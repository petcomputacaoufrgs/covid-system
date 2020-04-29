<?php 
/***********************************************
 *  Classe das regras de negocio das relacoes  *
 *  dos tubos com seus respectivos lotes       *                   *
 ***********************************************/

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/Rel_tubo_lote_BD.php';

class Rel_tubo_lote_RN{

    public function cadastrar(Rel_tubo_lote $relTuboLote){
        $objBanco = new Banco();
        try{
            
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            //print_r($relTuboLote);

            $objExcecao->lancar_validacoes();
            $objRel_tubo_lote_BD = new Rel_tubo_lote_BD();
            $objRel_tubo_lote_BD->cadastrar($relTuboLote,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro no cadastramento do relacionamento do tubo com seu respectivo lote.', $e);
        }
    }

    public function alterar(Rel_tubo_lote $relTuboLote) {
        $objBanco = new Banco();
        try{
            
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            
            
            $objExcecao->lancar_validacoes();
            $objRel_tubo_lote_BD = new Rel_tubo_lote_BD();
            $objRel_tubo_lote_BD->alterar($relTuboLote,$objBanco);

            $objBanco->confirmarTransacao();
           $objBanco->fecharConexao();
       } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
           throw new Excecao('Erro na alteração do relacionamento do tubo com seu respectivo lote.', $e);
       }
   }

   public function consultar(Rel_tubo_lote $relTuboLote) {
       $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
        
            $objExcecao->lancar_validacoes();
            $objRel_tubo_lote_BD = new Rel_tubo_lote_BD();
            $arr =  $objRel_tubo_lote_BD->consultar($relTuboLote,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
       } catch (Throwable $e) {
           $objBanco->cancelarTransacao();
           throw new Excecao('Erro na consulta do relacionamento do tubo com seu respectivo lote.',$e);
       }
   }

   public function remover(Rel_tubo_lote $relTuboLote) {
       $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objRel_tubo_lote_BD = new Rel_tubo_lote_BD();
            
            $arr =  $objRel_tubo_lote_BD->remover($relTuboLote,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;

       } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
           throw new Excecao('Erro na remoção do relacionamento do tubo com seu respectivo lote.', $e);
       }
   }

   public function listar(Rel_tubo_lote $relTuboLote) {
       $objBanco = new Banco();
        try {
        $objExcecao = new Excecao();
        $objBanco->abrirConexao();
        $objBanco->abrirTransacao();

        $objExcecao->lancar_validacoes();
        $objRel_tubo_lote_BD = new Rel_tubo_lote_BD();

        $arr =  $objRel_tubo_lote_BD->listar($relTuboLote,$objBanco);

        $objBanco->confirmarTransacao();
        $objBanco->fecharConexao();
        return $arr;
       } catch (Throwable $e) {
           $objBanco->cancelarTransacao();
           throw new Excecao('Erro na listagem do relacionamento do tubo com seu respectivo lote.',$e);
       }
   }

   public function listar_lotes(Rel_tubo_lote $relTuboLote) {
       $objBanco = new Banco();
        try {
        $objExcecao = new Excecao();
        $objBanco->abrirConexao();
        $objBanco->abrirTransacao();

        $objExcecao->lancar_validacoes();
        $objRel_tubo_lote_BD = new Rel_tubo_lote_BD();
        
        $arr = $objRel_tubo_lote_BD->listar_lotes($relTuboLote,$objBanco);

        $objBanco->confirmarTransacao();
        $objBanco->fecharConexao();
        return $arr;
    } catch (Throwable $e) {
        $objBanco->cancelarTransacao();
        throw new Excecao('Erro na listagem do relacionamento do tubo com seu respectivo lote.',$e);
    }
}

   }