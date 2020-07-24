<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do usuário do paciente
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/UsuarioBD.php';

class UsuarioRN{
    

   private function validarMatricula(Usuario $usuario,Excecao $objExcecao){
        $strMatriculaUsuario = trim($usuario->getMatricula());
       
        if ($strMatriculaUsuario == '' && $usuario->getCPF() == '') {
            $objExcecao->adicionar_validacao('A matrícula e CPF do usuário não foram informados', null,'alert-danger');
        }else{
            $objUsuarioAuxRN = new UsuarioRN();
            $objUsuario = new Usuario;
            $objUsuario->setMatricula($usuario->getMatricula());
            $arr = $objUsuarioAuxRN->listar($objUsuario,1);
            if(count($arr) > 0){
                if(!is_null($usuario->getIdUsuario())) {
                    foreach ($arr as $u) {
                        if ($u->getIdUsuario() != $usuario->getIdUsuario()) {
                            $objExcecao->adicionar_validacao('Já existe um usuário com esse número de matrícula', null, 'alert-danger');
                        }
                    }
                }else{
                    $objExcecao->adicionar_validacao('Já existe um usuário com esse número de matrícula', null, 'alert-danger');
                }

            }
        }
        
        $usuario->setMatricula($strMatriculaUsuario);
    }

    private function validarCPF(Usuario $usuario,Excecao $objExcecao){
        $strCPF = trim($usuario->getCPF());

        if (strlen($strCPF) > 11) {
            $objExcecao->adicionar_validacao('O CPF do usuário possui mais que 11 caracteres', null,'alert-danger');
        }else{
            $objUsuarioAuxRN = new UsuarioRN();

            $objUsuario = new Usuario;
            $objUsuario->setCPF($usuario->getCPF());
            $arr = $objUsuarioAuxRN->listar($objUsuario,1);

            if(count($arr) > 0) {
                if (!is_null($usuario->getIdUsuario())) {
                    foreach ($arr as $usu) {
                        if ($usu->getIdUsuario() != $usuario->getIdUsuario()) {
                            $objExcecao->adicionar_validacao('Já existe um usuário com esse CPF', null, 'alert-danger');
                        }
                    }
                }
            }


            $strCPF = preg_replace('/[^0-9]/is', '', $strCPF);

            // Verifica se foi informado todos os digitos corretamente
            // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
            if (preg_match('/(\d)\1{10}/', $strCPF)) {
                $objExcecao->adicionar_validacao('O CPF do usuário não é válido.',  null, 'alert-danger');
            }
            $cpf = intval($strCPF);
            // Faz o calculo para validar o CPF
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) {
                    $objExcecao->adicionar_validacao('O CPF do usuário não é válido.',  null, 'alert-danger');
                }
            }

        }

        $usuario->setCPF($strCPF);

    }
    
     private function validarSenha(Usuario $usuario,Excecao $objExcecao){
        $strSenhaUsuario = trim($usuario->getSenha());
       
        if ($strSenhaUsuario == '') {
            $objExcecao->adicionar_validacao('A senha do usuário não foi informada', null,'alert-danger');
        }else{
            if (strlen($strSenhaUsuario) > 50) {
                $objExcecao->adicionar_validacao('A senha do usuário possui mais que 12 caracteres', null,'alert-danger');
            }
            
            //validacoes de senha
        }
        
        $usuario->setSenha($strSenhaUsuario);

    }

    private function validarIdUsuario(Usuario $usuario,Excecao $objExcecao){

       if($usuario->getIdUsuario() != null) {
           if ($usuario->getIdUsuario() == '') {
               $objExcecao->adicionar_validacao('O identificador do usuário não foi informado', null,'alert-danger');
           }
       }else{
           $objExcecao->adicionar_validacao('O identificador do usuário não foi informado', null,'alert-danger');
       }

    }


    private function validarJaExisteUsuario(Usuario $usuario,Excecao $objExcecao){

        $objUsuarioRN = new UsuarioRN();

        if($usuario->getCPF() != null){
            $objUsuarioAux = new Usuario();
            $objUsuarioAux->setCPF($usuario->getCPF());
            $arr_usuario_cpf = $objUsuarioRN->listar($objUsuarioAux,1);
            if(count($arr_usuario_cpf) > 0) {
                if (!is_null($usuario->getIdUsuario())) {
                    foreach ($arr_usuario_cpf as $usu) {
                        if ($usu->getIdUsuario() != $usuario->getIdUsuario()) {
                            $objExcecao->adicionar_validacao('O usuário já existe', null, 'alert-danger');
                        }
                    }
                }
            }
        }

        if($usuario->getMatricula() != null){
            $objUsuarioAux = new Usuario();
            $objUsuarioAux->setMatricula($usuario->getMatricula());
            $arr_usuario_matricula = $objUsuarioRN->listar($objUsuarioAux,1);
            if(count($arr_usuario_matricula) > 0) {
                if (!is_null($usuario->getIdUsuario())) {
                    foreach ($arr_usuario_matricula as $usu) {
                        if ($usu->getIdUsuario() != $usuario->getIdUsuario()) {
                            $objExcecao->adicionar_validacao('O usuário já existe', null, 'alert-danger');
                        }
                    }
                }
            }
        }

    }
     

    public function cadastrar(Usuario $usuario) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarCPF($usuario,$objExcecao);
            $this->validarMatricula($usuario,$objExcecao); 
            $this->validarSenha($usuario,$objExcecao);
            //$this->validarJaExisteUsuario($usuario,$objExcecao);
            
            $objExcecao->lancar_validacoes();
            $objUsuarioBD = new UsuarioBD();
            $usuario = $objUsuarioBD->cadastrar($usuario,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $usuario;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o usuário.', $e);
        }
    }

    public function alterar(Usuario $usuario) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarCPF($usuario,$objExcecao);
            $this->validarMatricula($usuario,$objExcecao);   
            $this->validarSenha($usuario,$objExcecao);
            $this->validarIdUsuario($usuario,$objExcecao);
            //$this->validarJaExisteUsuario($usuario,$objExcecao);
                        
            $objExcecao->lancar_validacoes();
            $objUsuarioBD = new UsuarioBD();
            $usuario = $objUsuarioBD->alterar($usuario,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $usuario;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o usuário.', $e);
        }
    }

    public function consultar(Usuario $usuario) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objUsuarioBD = new UsuarioBD();
            $arr =  $objUsuarioBD->consultar($usuario,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o usuário.',$e);
        }
    }

    public function remover(Usuario $usuario) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objUsuarioBD = new UsuarioBD();
            $arr =  $objUsuarioBD->remover($usuario,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o usuário.', $e);
        }
    }

    public function listar(Usuario $usuario,$numLimite = null) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objUsuarioBD = new UsuarioBD();
            
            $arr = $objUsuarioBD->listar($usuario,$numLimite,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o usuário.',$e);
        }
    }
    
    
     public function validar_cadastro(Usuario $usuario) {
         $objBanco = new Banco();
         try {
             $objExcecao = new Excecao();
             $objBanco->abrirConexao();
             $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objUsuarioBD = new UsuarioBD();
            $arr = $objUsuarioBD->validar_cadastro($usuario,$objBanco);

             $objBanco->confirmarTransacao();
             $objBanco->fecharConexao();
             return $arr;
         } catch (Throwable $e) {
             $objBanco->cancelarTransacao();
            throw new Excecao('Erro validando cadastro do usuário.', $e);
        }
    }


    public function pesquisar($campoBD, $valor_usuario) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objUsuarioBD = new UsuarioBD();
            $arr = $objUsuarioBD->pesquisar($campoBD,$valor_usuario,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro pesquisando o usuário.', $e);
        }
    }

    public function paginacao(Usuario $usuario) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objUsuarioBD = new UsuarioBD();
            $arr = $objUsuarioBD->paginacao($usuario,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na paginação do usuário.', $e);
        }
    }


}

