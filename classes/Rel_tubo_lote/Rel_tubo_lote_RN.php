<?php 
/***********************************************
 *  Classe das regras de negocio das relacoes  *
 *  dos tubos com seus respectivos lotes       *                   *
 ***********************************************/

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/Rel_tubo_lote_BD.php';

class Rel_tubo_lote_RN{

    public function cadastrar(Rel_tubo_lote $relTuboLote){
        try{
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            
            $objExcecao->lancar_validacoes();
            $objRel_tubo_lote_BD = new Rel_tubo_lote_BD();
            $objRel_tubo_lote_BD->cadastrar($relTuboLote,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro no cadastramento do relacionamento do tubo com seu respectivo lote.', $e);
        }
    }

    public function alterar(Rel_tubo_lote $relTuboLote) {
        try{
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            
            $objExcecao->lancar_validacoes();
            $objRel_tubo_lote_BD = new Rel_tubo_lote_BD();
            $objRel_tubo_lote_BD->alterar($relTuboLote,$objBanco);
           
           $objBanco->fecharConexao();
       } catch (Exception $e) {
           throw new Excecao('Erro na alteração do relacionamento do tubo com seu respectivo lote.', $e);
       }
   }

   public function consultar(Rel_tubo_lote $relTuboLote) {
       try{
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
        
        
            $objExcecao->lancar_validacoes();
            $objRel_tubo_lote_BD = new Rel_tubo_lote_BD();
            $arr =  $objRel_tubo_lote_BD->consultar($relTuboLote,$objBanco);
           
            $objBanco->fecharConexao();
            return $arr;
       } catch (Exception $e) {

           throw new Excecao('Erro na consulta do relacionamento do tubo com seu respectivo lote.',$e);
       }
   }

   public function remover(Rel_tubo_lote $relTuboLote) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRel_tubo_lote_BD = new Rel_tubo_lote_BD();
            
            $arr =  $objRel_tubo_lote_BD->remover($relTuboLote,$objBanco);
           
            $objBanco->fecharConexao();
            return $arr;

       } catch (Exception $e) {
           throw new Excecao('Erro na remoção do relacionamento do tubo com seu respectivo lote.', $e);
       }
   }

   public function listar(Rel_tubo_lote $relTuboLote) {
       try {
        $objExcecao = new Excecao();
        $objBanco = new Banco();
        $objBanco->abrirConexao(); 
        $objExcecao->lancar_validacoes();
        $objRel_tubo_lote_BD = new Rel_tubo_lote_BD();

        $arr =  $objRel_tubo_lote_BD->listar($relTuboLote,$objBanco);
       
        $objBanco->fecharConexao();
        return $arr;
       } catch (Exception $e) {
           throw new Excecao('Erro na listagem do relacionamento do tubo com seu respectivo lote.',$e);
       }
   }

   public function listar_lotes(Rel_tubo_lote $relTuboLote) {
    try {
        $objExcecao = new Excecao();
        $objBanco = new Banco();
        $objBanco->abrirConexao(); 
        $objExcecao->lancar_validacoes();
        $objRel_tubo_lote_BD = new Rel_tubo_lote_BD();
        
        $arr = $objRel_tubo_lote_BD->listar_recursos($relPerfilRecurso,$objBanco);
        
        $objBanco->fecharConexao();
        return $arr;
    } catch (Exception $e) {
        throw new Excecao('Erro na listagem do relacionamento do tubo com seu respectivo lote.',$e);
    }
}

   public function pesquisar($campoBD, $valor_usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRel_tubo_lote_BD = new Rel_tubo_lote_BD();
            $arr = $objRel_tubo_lote_BD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro na pesquisa do relacionamento do tubo com seu respectivo lote.', $e);
        }
    }
}