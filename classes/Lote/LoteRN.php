<?php 
/**************************************************** 
 *  Classe das regras de negócio do lote dos tubos  *
 ****************************************************/

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/LoteBD.php';

class LoteRN{


    private function validarQntAmostrasTotal(Lote $lote,Excecao $objExcecao){
        $strQntAmostrasTotal = trim($lote->getQntAmostrasTotal());
        
        if ($strQntAmostrasTotal == '') {
            $objExcecao->adicionar_validacao('O número da quantidade de amostras totais não foi informado','idQntAmostrasTotal');
        }
        return $lote->setQntAmostrasTotal($strQntAmostrasTotal);
    }

    private function validarQntAmostrasLivres(Lote $lote,Excecao $objExcecao){
        $strQntAmostrasLivres = trim($lote->getQntAmostrasLivres());
        
        if ($strQntAmostrasLivres == '') {
            $objExcecao->adicionar_validacao('O número da quantidade de amostras livres não foi informado','idQntAmostrasLivres');
        }
        return $lote->setQntAmostrasLivres($strQntAmostrasLivres);
    }

    public function cadastrar(Lote $lote){
        try{

            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 

            $this->setQntAmostrasTotal($lote,$objExcecao);   
            $this->setQntAmostrasLivres($lote,$objExcecao);   

            $objExcecao->lancar_validacoes();
            $objLoteBD = new LoteBD();
            $objLoteBD->cadastrar($lote,$objBanco);

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
           
           $this->setQntAmostrasTotal($lote,$objExcecao);   
           $this->setQntAmostrasLivres($lote,$objExcecao);   
                       
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