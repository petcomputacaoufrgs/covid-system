<?php 
/**************************************************** 
 *  Classe das regras de negócio do lote dos tubos  *
 ****************************************************/

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/LoteBD.php';

class LoteRN{


    private function validarQntAmostrasDesejadas(Lote $lote,Excecao $objExcecao){
        $strQntAmostrasDesejadas = trim($lote->getQntAmostrasDesejadas());
        
        if ($strQntAmostrasDesejadas == '') {
            $objExcecao->adicionar_validacao('A quantidade de amostras desejadas não foi informado',null,'alert-danger');
        }

        if($lote->getQntAmostrasDesejadas() != 8 && $lote->getQntAmostrasDesejadas() != 16){
            if($lote->getQntAmostrasDesejadas() != 8) {$objExcecao->adicionar_validacao('A quantidade de amostras não é 8 ',null,'alert-danger'); }
            if($lote->getQntAmostrasDesejadas() != 16){ $objExcecao->adicionar_validacao('A quantidade de amostras não é 16 ',null,'alert-danger'); }
        }



        return $lote->setQntAmostrasDesejadas($strQntAmostrasDesejadas);
    }

    private function validarQntAmostrasAdquiridas(Lote $lote,Excecao $objExcecao){
        $strQntAmostrasAdquiridas = trim($lote->getQntAmostrasAdquiridas());
        
        if ($strQntAmostrasAdquiridas == '') {
            $objExcecao->adicionar_validacao('O número da quantidade de amostras adquiridas não foi informado',null,'alert-danger');
        }
        return $lote->setQntAmostrasAdquiridas($strQntAmostrasAdquiridas);
    }

    private function validarStatusLote(Lote $lote,Excecao $objExcecao){
        $strStatusLote = trim($lote->getStatusLote());

        if ($strStatusLote == '') {
            $objExcecao->adicionar_validacao('O status do lote não foi informado',null,'alert-danger');
        }

        return $lote->setStatusLote($strStatusLote);
    }

    public function cadastrar(Lote $lote){
        try{

            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 

            $this->validarQntAmostrasDesejadas($lote,$objExcecao);
            $this->validarQntAmostrasAdquiridas($lote,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objLoteBD = new LoteBD();
            $objLoteBD->cadastrar($lote,$objBanco);

            if($lote->getObjsTubo() != null){
                $objRelTuboLote = new Rel_tubo_lote();
                $objRelTuboLoteRN = new Rel_tubo_lote_RN();
                $objRelTuboLote->setIdLote_fk($lote->getIdLote());
                $objRelTuboLote->setObjLote($lote);
                foreach($lote->getObjsTubo() as $t){
                    //foreach ($objTubo as $t){
                        //print_r($t);
                        $objRelTuboLote->setIdTubo_fk($t->getIdTubo());
                        $objRelTuboLoteRN->cadastrar($objRelTuboLote);

                    //}
                    //$objRelTuboLote->setIdTubo_fk($obj->getIdTubo_fk());

                }
            }


            $objBanco->fecharConexao();
        }catch(Exception $e){
            throw new Excecao('Erro no cadastramento do lote.', $e);
        }
    }

    public function alterar(Lote $lote) {
        try{
            
           $objExcecao = new Excecao();
           $objBanco = new Banco();
           $objBanco->abrirConexao(); 
           
           $this->validarQntAmostrasDesejadas($lote,$objExcecao);
           $this->validarQntAmostrasAdquiridas($lote,$objExcecao);
                       
           $objExcecao->lancar_validacoes();
           $objLoteBD = new LoteBD();
           $objLoteBD->alterar($lote,$objBanco);
           
           $objBanco->fecharConexao();
       } catch (Exception $e){
           throw new Excecao('Erro na alteração do lote.', $e);
       }
   }

   public function consultar(Lote $lote) {
       try{
           $objExcecao = new Excecao();
           $objBanco = new Banco();
           $objBanco->abrirConexao(); 
           $objExcecao->lancar_validacoes();
           $objLoteBD = new LoteBD();
           $arr =  $objLoteBD->consultar($lote,$objBanco);
           
           $objBanco->fecharConexao();
           return $arr;
       }catch (Exception $e){
           throw new Excecao('Erro na consulta do lote.',$e);
       }
   }

   public function remover(Lote $lote){
        try{
           $objExcecao = new Excecao();
           $objBanco = new Banco();
           $objBanco->abrirConexao(); 
           $objExcecao->lancar_validacoes();
           $objLoteBD = new LoteBD();
           $arr =  $objLoteBD->remover($lote,$objBanco);
           $objBanco->fecharConexao();
           return $arr;

       }catch (Exception $e){
           throw new Excecao('Erro na remoção do lote.', $e);
       }
   }

   public function listar(Lote $lote) {
       try{
           $objExcecao = new Excecao();
           $objBanco = new Banco();
           $objBanco->abrirConexao(); 
           $objExcecao->lancar_validacoes();
           $objLoteBD = new LoteBD();
           
           $arr = $objLoteBD->listar($lote,$objBanco);
           
           $objBanco->fecharConexao();
           return $arr;
       }catch (Exception $e){
           throw new Excecao('Erro na listagem do lote.',$e);
       }
   }

   public function pesquisar($campoBD, $valor_usuario) {
    try {
        $objExcecao = new Excecao();
        $objBanco = new Banco();
        $objBanco->abrirConexao(); 
        $objExcecao->lancar_validacoes();
        $objLoteBD = new LoteBD();
        $arr = $objLoteBD->pesquisar($campoBD,$valor_usuario,$objBanco);
        $objBanco->fecharConexao();
        return $arr;
    } catch (Exception $e) {
        throw new Excecao('Erro na pesquisa do lote.', $e);
    }
}

}