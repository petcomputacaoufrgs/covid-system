<?php

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/PrateleiraBD.php';

class PrateleiraRN{

    private function validarNome(Prateleira $prateleira,Excecao $objExcecao){
        $strNome = trim($prateleira->getNome());
        
        if ($strNome == '') {
            $objExcecao->adicionar_validacao('O nome da prateleira não foi informado','idNomePrateleira', 'alert-danger');
        }else{
            if (strlen($strNome) > 10) {
                $objExcecao->adicionar_validacao('O nome da prateleira possui mais que 10 caracteres.','idNomePrateleira', 'alert-danger');
            }
        }
        
        return $prateleira->setNome($strNome);
    }

    public function cadastrar(Prateleira $prateleira) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            /*REALIZAR VALIDACOES*/ 

            $objExcecao->lancar_validacoes();
            $objPrateleiraBD = new PrateleiraBD();
            $objPrateleiraBD->cadastrar($rateleira,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando a prateleira.', $e);
        }
    }

    public function alterar(Prateleira $prateleira) {
        try {
            
           $objExcecao = new Excecao();
           $objBanco = new Banco();
           $objBanco->abrirConexao(); 
           
           /*REALZIAR VALIDACOES*/
                       
           $objExcecao->lancar_validacoes();
           $objPrateleiraBD = new PrateleiraBD();
           $objPrateleiraBD->alterar($prateleira,$objBanco);
           
           $objBanco->fecharConexao();
       } catch (Exception $e) {
           throw new Excecao('Erro alterando a prateleira.', $e);
       }
   }

   public function consultar(Prateleira $prateleira) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objPrateleiraBD = new PrateleiraBD();
            $arr =  $objPrateleiraBD->consultar($prateleira,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {

            throw new Excecao('Erro consultando a prateleira.',$e);
        }
    }

    public function remover(Prateleira $prateleira) {
        try {
           $objExcecao = new Excecao();
           $objBanco = new Banco();
           $objBanco->abrirConexao(); 
           $objExcecao->lancar_validacoes();
           $objPrateleiraBD = new PrateleiraBD();
           $arr =  $objPrateleiraBD->remover($prateleira,$objBanco);
           $objBanco->fecharConexao();
           return $arr;

       } catch (Exception $e) {
           throw new Excecao('Erro removendo a prateleira.', $e);
       }
   }

   public function listar(Prateleira $prateleira) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
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