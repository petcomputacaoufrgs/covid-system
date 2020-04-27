<?php

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/PrateleiraColunaBD.php';

class PrateleiraColunaRN{

    public function cadastrar(PrateleiraColuna $prateleiraColuna) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            /*REALIZAR VALIDACOES*/ 

            $objExcecao->lancar_validacoes();
            $objPrateleiraColunaBD = new PrateleiraColunaBD();
            $objPrateleiraColunaBD->cadastrar($prateleiraColuna,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando a coluna da prateleira.', $e);
        }
    }

    public function alterar(PrateleiraColuna $prateleiraColuna) {
        try {
            
           $objExcecao = new Excecao();
           $objBanco = new Banco();
           $objBanco->abrirConexao(); 
           
           /*REALZIAR VALIDACOES*/
                       
           $objExcecao->lancar_validacoes();
           $objPrateleiraColunaBD = new PrateleiraColunaBD();
           $objPrateleiraColunaBD->alterar($prateleiraColuna,$objBanco);
           
           $objBanco->fecharConexao();
       } catch (Exception $e) {
           throw new Excecao('Erro alterando a coluna da prateleira.', $e);
       }
   }

   public function consultar(PrateleiraColuna $prateleiraColuna) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objPrateleiraColunaBD = new PrateleiraColunaBD();
            $arr =  $objPrateleiraColunaBD->consultar($prateleiraColuna,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {

            throw new Excecao('Erro consultando a coluna da prateleira.',$e);
        }
    }

    public function remover(PrateleiraColuna $prateleiraColuna) {
        try {
           $objExcecao = new Excecao();
           $objBanco = new Banco();
           $objBanco->abrirConexao(); 
           $objExcecao->lancar_validacoes();
           $objPrateleiraColunaBD = new PrateleiraColunaBD();
           $arr =  $objPrateleiraColunaBD->remover($prateleiraColuna,$objBanco);
           $objBanco->fecharConexao();
           return $arr;

       } catch (Exception $e) {
           throw new Excecao('Erro removendo a coluna da prateleira.', $e);
       }
   }

   public function listar(PrateleiraColuna $prateleiraColuna) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objPrateleiraColunaBD = new PrateleiraColunaBD();
            
            $arr = $objPrateleiraColunaBD->listar($prateleiraColuna,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando a coluna da prateleira.',$e);
        }
    }
} 