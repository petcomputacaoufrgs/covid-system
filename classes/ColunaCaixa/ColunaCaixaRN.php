<?php


require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/ColunaCaixaBD.php';

class ColunaCaixaRN{

    public function cadastrar(ColunaCaixa $colunaCaixa) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            /*REALIZAR VALIDACOES*/ 

            $objExcecao->lancar_validacoes();
            $objColunaCaixaBD = new ColunaCaixaBD();
            $objColunaCaixaBD->cadastrar($colunaCaixa,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando a coluna da caixa.', $e);
        }
    }

    public function alterar(ColunaCaixa $colunaCaixa) {
        try {
            
           $objExcecao = new Excecao();
           $objBanco = new Banco();
           $objBanco->abrirConexao(); 
           
           /*REALZIAR VALIDACOES*/
                       
           $objExcecao->lancar_validacoes();
           $objColunaCaixaBD = new ColunaCaixaBD();
           $objColunaCaixaBD->alterar($colunaCaixa,$objBanco);
           
           $objBanco->fecharConexao();
       } catch (Exception $e) {
           throw new Excecao('Erro alterando a coluna da caixa.', $e);
       }
   }

   public function consultar(ColunaCaixa $colunaCaixa) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objColunaCaixaBD = new ColunaCaixaBD();
            $arr =  $objColunaCaixaBD->consultar($colunaCaixa,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {

            throw new Excecao('Erro consultando a coluna da caixa.',$e);
        }
    }

    public function remover(ColunaCaixa $colunaCaixa) {
        try {
           $objExcecao = new Excecao();
           $objBanco = new Banco();
           $objBanco->abrirConexao(); 
           $objExcecao->lancar_validacoes();
           $objColunaCaixaBD = new ColunaCaixaBD();
           $arr =  $objColunaCaixaBD->remover($colunaCaixa,$objBanco);
           $objBanco->fecharConexao();
           return $arr;

       } catch (Exception $e) {
           throw new Excecao('Erro removendo a coluna da caixa.', $e);
       }
   }

   public function listar(ColunaCaixa $colunaCaixa) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objColunaCaixaBD = new ColunaCaixaBD();
            
            $arr = $objColunaCaixaBD->listar($colunaCaixa,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando a coluna da caixa.',$e);
        }
    }
}