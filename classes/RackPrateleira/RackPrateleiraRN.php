<?php

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/RackPrateleiraBD.php';

class RackPrateleiraRN{

    public function cadastrar(RackPrateleira $rackPrateleira) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            /*REALIZAR VALIDACOES*/ 

            $objExcecao->lancar_validacoes();
            $objRackPrateleiraBD = new RackPrateleiraBD();
            $objRackPrateleiraBD->cadastrar($rackPrateleira,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando o rack da prateleira.', $e);
        }
    }

    public function alterar(RackPrateleira $rackPrateleira) {
        try {
            
           $objExcecao = new Excecao();
           $objBanco = new Banco();
           $objBanco->abrirConexao(); 
           
           /*REALZIAR VALIDACOES*/
                       
           $objExcecao->lancar_validacoes();
           $objRackPrateleiraBD = new RackPrateleiraBD();
           $objRackPrateleiraBD->alterar($rackPrateleira,$objBanco);
           
           $objBanco->fecharConexao();
       } catch (Exception $e) {
           throw new Excecao('Erro alterando o rack da prateleira.', $e);
       }
   }

   public function consultar(RackPrateleira $rackPrateleira) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRackPrateleiraBD = new RackPrateleiraBD();
            $arr =  $objRackPrateleiraBD->consultar($rackPrateleira,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {

            throw new Excecao('Erro consultando o rack da prateleira.',$e);
        }
    }

    public function remover(RackPrateleira $rackPrateleira) {
        try {
           $objExcecao = new Excecao();
           $objBanco = new Banco();
           $objBanco->abrirConexao(); 
           $objExcecao->lancar_validacoes();
           $objRackPrateleiraBD = new RackPrateleiraBD();
           $arr =  $objRackPrateleiraBD->remover($rackPrateleira,$objBanco);
           $objBanco->fecharConexao();
           return $arr;

       } catch (Exception $e) {
           throw new Excecao('Erro removendo o rack da prateleira.', $e);
       }
   }

   public function listar(RackPrateleira $rackPrateleira) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRackPrateleiraBD = new RackPrateleiraBD();
            
            $arr = $objRackPrateleiraBD->listar($rackPrateleira,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o rack da prateleira.',$e);
        }
    }
}