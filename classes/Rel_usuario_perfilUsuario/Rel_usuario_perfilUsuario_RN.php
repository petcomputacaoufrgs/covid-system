<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do usuário do paciente
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/Rel_usuario_perfilUsuario_BD.php';

class Rel_usuario_perfilUsuario_RN{
        

    public function cadastrar(Rel_usuario_perfilUsuario $relUsuarioPerfil) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            
            $objExcecao->lancar_validacoes();
            $objRel_usuario_perfilUsuario_BD = new Rel_usuario_perfilUsuario_BD();
            $objRel_usuario_perfilUsuario_BD->cadastrar($relUsuarioPerfil,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando o relacionamento do usuário com o seu perfil.', $e);
        }
    }

    public function alterar(Rel_usuario_perfilUsuario $relUsuarioPerfil) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            
                        
            $objExcecao->lancar_validacoes();
            $objRel_usuario_perfilUsuario_BD = new Rel_usuario_perfilUsuario_BD();
            $objRel_usuario_perfilUsuario_BD->alterar($relUsuarioPerfil,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando o relacionamento do usuário com o seu perfil.', $e);
        }
    }

    public function consultar(Rel_usuario_perfilUsuario $relUsuarioPerfil) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRel_usuario_perfilUsuario_BD = new Rel_usuario_perfilUsuario_BD();
            $arr =  $objRel_usuario_perfilUsuario_BD->consultar($relUsuarioPerfil,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando o relacionamento do usuário com o seu perfil.',$e);
        }
    }

    public function remover(Rel_usuario_perfilUsuario $relUsuarioPerfil) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRel_usuario_perfilUsuario_BD = new Rel_usuario_perfilUsuario_BD();
            $arr =  $objRel_usuario_perfilUsuario_BD->remover($relUsuarioPerfil,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo o relacionamento do usuário com o seu perfil.', $e);
        }
    }

    public function listar(Rel_usuario_perfilUsuario $relUsuarioPerfil) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRel_usuario_perfilUsuario_BD = new Rel_usuario_perfilUsuario_BD();
            
            $arr = $objRel_usuario_perfilUsuario_BD->listar($relUsuarioPerfil,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o relacionamento do usuário com o seu perfil.',$e);
        }
    }
    
    public function validar_cadastro(Rel_usuario_perfilUsuario $relUsuarioPerfil) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRel_usuario_perfilUsuario_BD = new Rel_usuario_perfilUsuario_BD();
            
            $arr = $objRel_usuario_perfilUsuario_BD->validar_cadastro($relUsuarioPerfil,$objBanco);
            
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
            $objRel_usuario_perfilUsuario_BD = new Rel_usuario_perfilUsuario_BD();
            $arr = $objRel_usuario_perfilUsuario_BD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando o relacionamento do usuário com o seu perfil.', $e);
        }
    }

}

?>
