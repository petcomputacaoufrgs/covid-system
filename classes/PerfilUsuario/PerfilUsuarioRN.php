<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do perfil do usuário
 */

require_once 'classes/Excecao/Excecao.php';
require_once 'classes/PerfilUsuario/PerfilUsuarioBD.php';

class PerfilUsuarioRN{
    

    private function validarPerfil(PerfilUsuario $perfilUsuario,Excecao $objExcecao){
        $strPerfilUsuario = trim($perfilUsuario->getPerfil());
        
        if ($strPerfilUsuario == '') {
            $objExcecao->adicionar_validacao('O perfil do usuário não foi informado','idPerfilUsuario');
        }else{
            if (strlen($strPerfilUsuario) > 100) {
                $objExcecao->adicionar_validacao('O perfil do usuário possui mais que 100 caracteres.','idPerfilUsuario');
            }
            
            $perfilUsuario_aux_RN = new PerfilUsuarioRN();
            $array_perfis = $perfilUsuario_aux_RN->listar($perfilUsuario);
            foreach ($array_perfis as $p){
                if($p->getPerfil() == $perfilUsuario->getPerfil()){
                    $objExcecao->adicionar_validacao('O perfil do usuário já existe.','idPerfilUsuario');
                }
            }
        }
        
        return $perfilUsuario->setPerfil($strPerfilUsuario);

    }
     

    public function cadastrar(PerfilUsuario $perfilUsuario) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarPerfil($perfilUsuario,$objExcecao); 
            $objExcecao->lancar_validacoes();
            $objPerfilUsuarioBD = new PerfilUsuarioBD();
            $objPerfilUsuarioBD->cadastrar($perfilUsuario,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando o perfil do usuário.', $e);
        }
    }

    public function alterar(PerfilUsuario $perfilUsuario) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarPerfil($perfilUsuario,$objExcecao);   
                        
            $objExcecao->lancar_validacoes();
            $objPerfilUsuarioBD = new PerfilUsuarioBD();
            $objPerfilUsuarioBD->alterar($perfilUsuario,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando o perfil do usuário.', $e);
        }
    }

    public function consultar(PerfilUsuario $perfilUsuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objPerfilUsuarioBD = new PerfilUsuarioBD();
            $arr =  $objPerfilUsuarioBD->consultar($perfilUsuario,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando o perfil do usuário.',$e);
        }
    }

    public function remover(PerfilUsuario $perfilUsuario) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objPerfilUsuarioBD = new PerfilUsuarioBD();
            $arr =  $objPerfilUsuarioBD->remover($perfilUsuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo o perfil do usuário.', $e);
        }
    }

    public function listar(PerfilUsuario $perfilUsuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objPerfilUsuarioBD = new PerfilUsuarioBD();
            
            $arr = $objPerfilUsuarioBD->listar($perfilUsuario,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o perfil do usuário.',$e);
        }
    }


    public function pesquisar($campoBD, $valor_usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objPerfilUsuarioBD = new PerfilUsuarioBD();
            $arr = $objPerfilUsuarioBD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando o perfil do usuário.', $e);
        }
    }

}

?>
