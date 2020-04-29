<?php

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/CaixaBD.php';

require_once __DIR__ . '/../../classes/Posicao/Posicao.php';
require_once __DIR__ . '/../../classes/Posicao/PosicaoRN.php';

class CaixaRN{


    private function validarNome(Caixa $caixa,Excecao $objExcecao){
        $strNome = trim($caixa->getNome());

        if ($strNome == '') {
            $objExcecao->adicionar_validacao('O nome da caixa não foi informado','idPosicaoCaixa', 'alert-danger');
        }else{
            if (strlen($strNome) > 100) {
                $objExcecao->adicionar_validacao('O nome da caixa possui mais que 100 caracteres.','idStatusCapela', 'alert-danger');
            }
        }

        return $caixa->setNome($strNome);

    }

    private function validarSlots(Caixa $caixa,Excecao $objExcecao){

        if ($caixa->getQntSlotsOcupados() > $caixa->getQntSlotsVazios())  {
            $objExcecao->adicionar_validacao('Não cabe mais amostras na caixa','idPosicaoCaixa', 'alert-danger');
        }

    }

    public function cadastrar(Caixa $caixa) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            
            /*REALIZAR VALIDACOES*/ 
            $this->validarNome($caixa,$objExcecao);
            $this->validarSlots($caixa,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objCaixaBD = new CaixaBD();
            $caixa  = $objCaixaBD->cadastrar($caixa,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $caixa;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando a caixa.', $e);
        }
    }

    public function alterar(Caixa $caixa) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            /*REALIZAR VALIDACOES*/
            $this->validarNome($caixa,$objExcecao);
            $this->validarSlots($caixa,$objExcecao);
                       
           $objExcecao->lancar_validacoes();
           $objCaixaBD = new CaixaBD();
           $objCaixaBD->alterar($caixa,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $caixa;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
           throw new Excecao('Erro alterando a caixa.', $e);
       }
   }

   public function consultar(Caixa $caixa) {
       $objBanco = new Banco();
       try {

           $objExcecao = new Excecao();
           $objBanco->abrirConexao();
           $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objCaixaBD = new CaixaBD();
            $arr =  $objCaixaBD->consultar($caixa,$objBanco);

           $objBanco->confirmarTransacao();
           $objBanco->fecharConexao();
           return $arr;
       } catch (Throwable $e) {
           $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando a caixa.',$e);
        }
    }

    public function remover(Caixa $caixa) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objCaixaBD = new CaixaBD();
            $arr =  $objCaixaBD->remover($caixa,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
           throw new Excecao('Erro removendo a caixa.', $e);
       }
   }

   public function listar(Caixa $caixa) {
       $objBanco = new Banco();
       try {

           $objExcecao = new Excecao();
           $objBanco->abrirConexao();
           $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objCaixaBD = new CaixaBD();
            
            $arr = $objCaixaBD->listar($caixa,$objBanco);

           $objBanco->confirmarTransacao();
           $objBanco->fecharConexao();
           return $arr;
       } catch (Throwable $e) {
           $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando a caixa.',$e);
        }
    }


}