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
       
        if ($strMatriculaUsuario == '') {
            $objExcecao->adicionar_validacao('A matrícula do usuário não foi informada', null,'alert-danger');
        }else{
            /*if (strlen($strMatriculaUsuario) > 8) {
                $objExcecao->adicionar_validacao('A matrícula do usuário possui mais que 8 caracteres.','idMatricula');
            }*/
        }
        
        return $usuario->setMatricula($strMatriculaUsuario);

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
        
        return $usuario->setSenha($strSenhaUsuario);

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
        $numUsuario = count($objUsuarioRN->listar($usuario,1));
        if($numUsuario > 0){
            $objExcecao->adicionar_validacao('O usuário já existe',null,'alert-danger');
        }

    }
     

    public function cadastrar(Usuario $usuario) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            
            $this->validarMatricula($usuario,$objExcecao); 
            $this->validarSenha($usuario,$objExcecao);
            $this->validarJaExisteUsuario($usuario,$objExcecao);
            
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
            
            $this->validarMatricula($usuario,$objExcecao);   
            $this->validarSenha($usuario,$objExcecao);
            $this->validarIdUsuario($usuario,$objExcecao);
            $this->validarJaExisteUsuario($usuario,$objExcecao);
                        
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

