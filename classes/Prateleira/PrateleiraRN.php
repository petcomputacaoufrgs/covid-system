<?php

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/PrateleiraBD.php';

class PrateleiraRN{

    public static $TSR_COM_ESPACO_LIVRE = 'C';
    public static $TSR_SEM_ESPACO_LIVRE = 'S';

    public static function listarValoresTipoEstado(){
        try {

            $arrObjStaColuna = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TSR_COM_ESPACO_LIVRE);
            $objSituacao->setStrDescricao('Prateleira com espaço livre');
            $arrObjStaColuna[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TSR_SEM_ESPACO_LIVRE);
            $objSituacao->setStrDescricao('Prateleira sem espaço livre');
            $arrObjStaColuna[] = $objSituacao;

            return $arrObjStaColuna;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Tipo situação da porta',$e);
        }
    }

    public static function mostrarDescricaoTipo($strTipo){
        //$objExcecao = new Excecao();

        foreach (self::listarValoresTipoEstado() as $tipo){
            if($tipo->getStrTipo() == $strTipo){
                return $tipo->getStrDescricao();
            }
        }

        //$objExcecao->adicionar_validacao('Não encontrou o tipo informadoo.','alert-danger');
    }

    private function validarStrTipoPrateleira(Prateleira $prateleira,Excecao $objExcecao){

        if ($prateleira->getSituacaoPrateleira() == null){
            $objExcecao->adicionar_validacao('Tipo não informado',null,'alert-danger');
        }else{
            $flag = false;
            foreach (self::listarValoresTipoEstado() as $tipo){
                if($tipo->getStrTipo() == $prateleira->getSituacaoPrateleira()){
                    $flag = true;
                }
            }

            if(!$flag){
                $objExcecao->adicionar_validacao('Situação da prateleira não foi encontrada',null,'alert-danger');
            }
        }

    }

    private function validarNome(Prateleira $prateleira,Excecao $objExcecao){
        $strNome = trim($prateleira->getNome());
        
        if ($strNome == '') {
            $objExcecao->adicionar_validacao('O nome da prateleira não foi informado','idNomePrateleira', 'alert-danger');
        }else{
            if (strlen($strNome) > 100) {
                $objExcecao->adicionar_validacao('O nome da prateleira possui mais que 100 caracteres.','idNomePrateleira', 'alert-danger');
            }
        }
        
        return $prateleira->setNome($strNome);
    }

    public function cadastrar(Prateleira $prateleira) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            
            /*REALIZAR VALIDACOES*/ 
            $this->validarNome($prateleira, $objExcecao);

            $objExcecao->lancar_validacoes();
            $objPrateleiraBD = new PrateleiraBD();
            $objPrateleiraBD->cadastrar($prateleira,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $prateleira;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando a prateleira.', $e);
        }
    }

    public function alterar(Prateleira $prateleira) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
           
           /*REALZIAR VALIDACOES*/
            $this->validarNome($prateleira, $objExcecao);
                       
           $objExcecao->lancar_validacoes();
           $objPrateleiraBD = new PrateleiraBD();
           $objPrateleiraBD->alterar($prateleira,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $prateleira;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
           throw new Excecao('Erro alterando a prateleira.', $e);
       }
   }

   public function consultar(Prateleira $prateleira) {
       $objBanco = new Banco();
       try {

           $objExcecao = new Excecao();
           $objBanco->abrirConexao();
           $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPrateleiraBD = new PrateleiraBD();
            $arr =  $objPrateleiraBD->consultar($prateleira,$objBanco);

           $objBanco->confirmarTransacao();
           $objBanco->fecharConexao();
           return $arr;
       } catch (Throwable $e) {
           $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando a prateleira.',$e);
        }
    }

    public function remover(Prateleira $prateleira) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
           $objExcecao->lancar_validacoes();
           $objPrateleiraBD = new PrateleiraBD();
           $arr =  $objPrateleiraBD->remover($prateleira,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
           throw new Excecao('Erro removendo a prateleira.', $e);
       }
   }

   public function listar(Prateleira $prateleira) {
       $objBanco = new Banco();
       try {

           $objExcecao = new Excecao();
           $objBanco->abrirConexao();
           $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPrateleiraBD = new PrateleiraBD();
            
            $arr = $objPrateleiraBD->listar($prateleira,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando a prateleira.',$e);
        }
    }
}