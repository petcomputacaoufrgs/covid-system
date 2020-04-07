<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do usuário do paciente
 */

require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Usuario/UsuarioBD.php';

class UsuarioRN{
    

    private function validarMatricula(Usuario $usuario,Excecao $objExcecao){
        $strMatricula = trim($usuario->getMatricula());
        
        if ($strMatricula == '') {
            $objExcecao->adicionar_validacao('A matrícula não foi informado','idMatricula');
        }else{
            if (strlen($strMatricula) > 0 && strlen($strMatricula) < 8) {
                $objExcecao->adicionar_validacao('A matrícula não possui 8 números.','idMatricula');
            }
            if (strlen($strMatricula) > 8) {
                $objExcecao->adicionar_validacao('A matrícula possui mais que 8 números.','idMatricula');
            }
            
            $usuario_aux_RN = new UsuarioRN();
            $array_matriculas = $usuario_aux_RN->listar($usuario);
            //print_r($array_sexos);
            foreach ($array_matriculas as $m){
                if($m->getMatricula() == $usuario->getMatricula()){
                    $objExcecao->adicionar_validacao('A matrícula já existe.','idMatricula');
                }
            }
        }
        
        return $usuario->setMatricula($strMatricula);

    }
     

    public function cadastrar(Usuario $usuario) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarMatricula($usuario,$objExcecao); 
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

?>
