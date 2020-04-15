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
            $objExcecao->adicionar_validacao('A matrícula do usuário não foi informada','idMatricula');
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
            $objExcecao->adicionar_validacao('A senha do usuário não foi informada','idPassword');
        }else{
            if (strlen($strSenhaUsuario) > 50) {
                $objExcecao->adicionar_validacao('A senha do usuário possui mais que 12 caracteres.','idPassword');
            }
            
            //validacoes de senha
        }
        
        return $usuario->setSenha($strSenhaUsuario);

    }
     

    public function cadastrar(Usuario $usuario) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarMatricula($usuario,$objExcecao); 
            $this->validarSenha($usuario,$objExcecao); 
            
            $objExcecao->lancar_validacoes();
            $objUsuarioBD = new UsuarioBD();
            $objUsuarioBD->cadastrar($usuario,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando o usuário.', $e);
        }
    }

    public function alterar(Usuario $usuario) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarMatricula($usuario,$objExcecao);   
            $this->validarSenha($usuario,$objExcecao); 
                        
            $objExcecao->lancar_validacoes();
            $objUsuarioBD = new UsuarioBD();
            $objUsuarioBD->alterar($usuario,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando o usuário.', $e);
        }
    }

    public function consultar(Usuario $usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objUsuarioBD = new UsuarioBD();
            $arr =  $objUsuarioBD->consultar($usuario,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando o usuário.',$e);
        }
    }

    public function remover(Usuario $usuario) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objUsuarioBD = new UsuarioBD();
            $arr =  $objUsuarioBD->remover($usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo o usuário.', $e);
        }
    }

    public function listar(Usuario $usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objUsuarioBD = new UsuarioBD();
            
            $arr = $objUsuarioBD->listar($usuario,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o usuário.',$e);
        }
    }
    
    
     public function validar_cadastro(Usuario $usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objUsuarioBD = new UsuarioBD();
            $arr = $objUsuarioBD->validar_cadastro($usuario,$objBanco);

            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro validando cadastro do usuário.', $e);
        }
    }


    public function pesquisar($campoBD, $valor_usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objUsuarioBD = new UsuarioBD();
            $arr = $objUsuarioBD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando o usuário.', $e);
        }
    }

}

