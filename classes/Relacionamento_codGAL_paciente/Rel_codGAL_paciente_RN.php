<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio da o relacionamento entre código GAL  e o paciente do paciente
 */

require_once 'classes/excecao/Excecao.php';
require_once 'classes/Relacionamento_codGAL_paciente/Rel_codGAL_paciente_BD.php';

class Rel_codGAL_paciente_RN{
    
    public function cadastrar(Rel_codGAL_paciente $rel_cogGAL_paciente) {
        try {
            
            //$objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
       
            //$objExcecao->lancar_validacoes();
            $objRel_codGAL_paciente_BD = new Rel_codGAL_paciente_BD();
            $objRel_codGAL_paciente_BD->cadastrar($rel_cogGAL_paciente,$objBanco);
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando a o relacionamento entre código GAL  e o paciente.', $e);
        }
    }

    public function alterar(Rel_codGAL_paciente $rel_cogGAL_paciente) {
         try {
             
            //$objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            //$objExcecao->lancar_validacoes();
            $objRel_codGAL_paciente_BD = new Rel_codGAL_paciente_BD();
            $objRel_codGAL_paciente_BD->alterar($rel_cogGAL_paciente,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando a o relacionamento entre código GAL  e o paciente.', $e);
        }
    }

    public function consultar(Rel_codGAL_paciente $rel_cogGAL_paciente) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRel_codGAL_paciente_BD = new Rel_codGAL_paciente_BD();
            $arr =  $objRel_codGAL_paciente_BD->consultar($rel_cogGAL_paciente,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando a o relacionamento entre código GAL  e o paciente.',$e);
        }
    }

    public function remover(Rel_codGAL_paciente $rel_cogGAL_paciente) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRel_codGAL_paciente_BD = new Rel_codGAL_paciente_BD();
            $arr =  $objRel_codGAL_paciente_BD->remover($rel_cogGAL_paciente,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo a o relacionamento entre código GAL  e o paciente.', $e);
        }
    }

    public function listar(Rel_codGAL_paciente $rel_cogGAL_paciente) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRel_codGAL_paciente_BD = new Rel_codGAL_paciente_BD();
            
            $arr = $objRel_codGAL_paciente_BD->listar($rel_cogGAL_paciente,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando a o relacionamento entre código GAL  e o paciente.',$e);
        }
    }


    public function pesquisar($campoBD, $valor_usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRel_codGAL_paciente_BD = new Rel_codGAL_paciente_BD();
            $arr = $objRel_codGAL_paciente_BD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando a o relacionamento entre código GAL  e o paciente.', $e);
        }
    }

}

?>
