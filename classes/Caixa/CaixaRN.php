<?php

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/CaixaBD.php';

class CaixaRN{

    
    private function validarPosicao(Caixa $caixa,Excecao $objExcecao){
        $strPosicao = trim($caixa->getPosicao());
        
        if ($strPosicao == '') {
            $objExcecao->adicionar_validacao('A posicao da caixa não foi informado','idPosicaoCaixa', 'alert-danger');
        }else{
            if (strlen($strPosicao) > 4) {
                $objExcecao->adicionar_validacao('A posicao da caixa possui mais que 4 caracteres.','idStatusCapela', 'alert-danger');
            }
        }
        
        return $caixa->setPosicao($strPosicao);

    }

    public function cadastrar(Caixa $caixa) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            /*REALIZAR VALIDACOES*/ 

            $objExcecao->lancar_validacoes();
            $objCaixaBD = new CaixaBD();
            $objCaixaBD->cadastrar($caixa,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando a caixa.', $e);
        }
    }

    public function alterar(Caixa $caixa) {
        try {
            
           $objExcecao = new Excecao();
           $objBanco = new Banco();
           $objBanco->abrirConexao(); 
           
           /*REALZIAR VALIDACOES*/
                       
           $objExcecao->lancar_validacoes();
           $objCaixaBD = new CaixaBD();
           $objCaixaBD->alterar($caixa,$objBanco);
           
           $objBanco->fecharConexao();
       } catch (Exception $e) {
           throw new Excecao('Erro alterando a caixa.', $e);
       }
   }

   public function consultar(Caixa $caixa) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objCaixaBD = new CaixaBD();
            $arr =  $objCaixaBD->consultar($caixa,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {

            throw new Excecao('Erro consultando a caixa.',$e);
        }
    }

    public function remover(Caixa $caixa) {
        try {
           $objExcecao = new Excecao();
           $objBanco = new Banco();
           $objBanco->abrirConexao(); 
           $objExcecao->lancar_validacoes();
           $objCaixaBD = new CaixaBD();
           $arr =  $objCaixaBD->remover($caixa,$objBanco);
           $objBanco->fecharConexao();
           return $arr;

       } catch (Exception $e) {
           throw new Excecao('Erro removendo a caixa.', $e);
       }
   }

   public function listar(Caixa $caixa) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objCaixaBD = new CaixaBD();
            
            $arr = $objCaixaBD->listar($caixa,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando a caixa.',$e);
        }
    }
}