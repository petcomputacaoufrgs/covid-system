<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do usuário do paciente
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/Rel_perfilUsuario_recurso_BD.php';

class Rel_perfilUsuario_recurso_RN{
        

    public function cadastrar(Rel_perfilUsuario_recurso $relPerfilRecurso) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            
            $objExcecao->lancar_validacoes();
            $objRel_perfilUsuario_recurso_BD = new Rel_perfilUsuario_recurso_BD();
            $objRel_perfilUsuario_recurso_BD->cadastrar($relPerfilRecurso,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando o relacionamento do perfil do usuário com o seu recurso.', $e);
        }
    }

    public function alterar(Rel_perfilUsuario_recurso $relPerfilRecurso) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            
                        
            $objExcecao->lancar_validacoes();
            $objRel_perfilUsuario_recurso_BD = new Rel_perfilUsuario_recurso_BD();
            $objRel_perfilUsuario_recurso_BD->alterar($relPerfilRecurso,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando o relacionamento do perfil do usuário com o seu recurso.', $e);
        }
    }

    public function consultar(Rel_perfilUsuario_recurso $relPerfilRecurso) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRel_perfilUsuario_recurso_BD = new Rel_perfilUsuario_recurso_BD();
            $arr =  $objRel_perfilUsuario_recurso_BD->consultar($relPerfilRecurso,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando o relacionamento do perfil do usuário com o seu recurso.',$e);
        }
    }

    public function remover(Rel_perfilUsuario_recurso $relPerfilRecurso) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRel_perfilUsuario_recurso_BD = new Rel_perfilUsuario_recurso_BD();
            $arr =  $objRel_perfilUsuario_recurso_BD->remover($relPerfilRecurso,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo o relacionamento do perfil do usuário com o seu recurso.', $e);
        }
    }

    public function listar(Rel_perfilUsuario_recurso $relPerfilRecurso) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRel_perfilUsuario_recurso_BD = new Rel_perfilUsuario_recurso_BD();
            
            $arr = $objRel_perfilUsuario_recurso_BD->listar($relPerfilRecurso,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o relacionamento do perfil do usuário com o seu recurso.',$e);
        }
    }
    
    public function listar_recursos(Rel_perfilUsuario_recurso $relPerfilRecurso) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRel_perfilUsuario_recurso_BD = new Rel_perfilUsuario_recurso_BD();
            
            $arr = $objRel_perfilUsuario_recurso_BD->listar_recursos($relPerfilRecurso,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o relacionamento do perfil do usuário com o seu recurso.',$e);
        }
    }
    
    
    public function validar_cadastro(Rel_perfilUsuario_recurso $relPerfilRecurso) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRel_perfilUsuario_recurso_BD = new Rel_perfilUsuario_recurso_BD();
            
            $arr = $objRel_perfilUsuario_recurso_BD->validar_cadastro($relPerfilRecurso,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o relacionamento do usuário com o seu perfil.',$e);
        }
    }
    
    public function pesquisar($campoBD, $valor_usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRel_perfilUsuario_recurso_BD = new Rel_perfilUsuario_recurso_BD();
            $arr = $objRel_perfilUsuario_recurso_BD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando o relacionamento do perfil do usuário com o seu recurso.', $e);
        }
    }

}

