<?php 
/***********************************************
 *  Classe das regras de negocio das relacoes  *
 *  dos tubos com seus respectivos lotes       *                   *
 ***********************************************/

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/Rel_tubo_lote_BD.php';

class Rel_tubo_lote_RN{

    private  function validarIdLote(Rel_tubo_lote $relTuboLote,Excecao $objExcecao){
        if($relTuboLote->getIdLote_fk() == null){
            $objExcecao->adicionar_validacao('Identificador do lote não informado',null,'alert-danger');
        }
    }

    private  function validarIdTubo(Rel_tubo_lote $relTuboLote, Excecao $objExcecao){
        if($relTuboLote->getIdTubo_fk() == null){
            $objExcecao->adicionar_validacao('Identificador do tubo não informado',null,'alert-danger');
        }
    }

    private function validarIdRelTuboLote(Rel_tubo_lote $relTuboLote, Excecao $objExcecao){
        if($relTuboLote->getIdRelTuboLote() == null){
            $objExcecao->adicionar_validacao('Identificador do relacionamento tubo com o lote não informado',null,'alert-danger');
        }
    }


    public function cadastrar(Rel_tubo_lote $relTuboLote){
        $objBanco = new Banco();
        try{
            
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdLote($relTuboLote,$objExcecao);
            $this->validarIdTubo($relTuboLote,$objExcecao);

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

            $this->validarIdLote($relTuboLote,$objExcecao);
            $this->validarIdTubo($relTuboLote,$objExcecao);
            $this->validarIdRelTuboLote($relTuboLote,$objExcecao);
            
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


   /**** EXTRAS ****/
    public function listar_completo($relTuboLote) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objRel_tubo_lote_BD = new Rel_tubo_lote_BD();

            $arr =  $objRel_tubo_lote_BD->listar_completo($relTuboLote,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na listagem completa do relacionamento do tubo com seu respectivo lote.',$e);
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


    public function remover_peloIdLote(Rel_tubo_lote $relTuboLote) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objRel_tubo_lote_BD = new Rel_tubo_lote_BD();

            $arr =  $objRel_tubo_lote_BD->remover_peloIdLote($relTuboLote,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;

        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na remoção do relacionamento do tubo com seu respectivo lote.', $e);
        }
    }

   }