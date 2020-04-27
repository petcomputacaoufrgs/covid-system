<?php

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/PortaBD.php';

class PortaRN{

    private function validarNome(Porta $porta,Excecao $objExcecao){
        $strNome = trim($porta->getNome());
        
        if ($strNome == '') {
            $objExcecao->adicionar_validacao('O nome da porta não foi informado','idNomePorta', 'alert-danger');
        }else{
            if (strlen($strNome) > 50) {
                $objExcecao->adicionar_validacao('O nome da porta possui mais que 50 caracteres.','idNomePorta', 'alert-danger');
            }
        }
        
        return $porta->setNome($strNome);
    }

    public function cadastrar(Porta $porta) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            /*REALIZAR VALIDACOES*/ 

            $objExcecao->lancar_validacoes();
            $objPortaBD = new PortaBD();
            $objPortaBD->cadastrar($porta,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando a porta.', $e);
        }
    }

    public function alterar(Porta $porta) {
        try {
            
           $objExcecao = new Excecao();
           $objBanco = new Banco();
           $objBanco->abrirConexao(); 
           
           /*REALZIAR VALIDACOES*/
                       
           $objExcecao->lancar_validacoes();
           $objPortaBD = new PortaBD();
           $objPortaBD->alterar($porta,$objBanco);
           
           $objBanco->fecharConexao();
       } catch (Exception $e) {
           throw new Excecao('Erro alterando a porta.', $e);
       }
   }

   public function consultar(Porta $porta) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objPortaBD = new PortaBD();
            $arr =  $objPortaBD->consultar($Porta,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {

            throw new Excecao('Erro consultando a porta.',$e);
        }
    }

    public function remover(Porta $porta) {
        try {
           $objExcecao = new Excecao();
           $objBanco = new Banco();
           $objBanco->abrirConexao(); 
           $objExcecao->lancar_validacoes();
           $objPortaBD = new PortaBD();
           $arr =  $objPortaBD->remover($porta,$objBanco);
           $objBanco->fecharConexao();
           return $arr;

       } catch (Exception $e) {
           throw new Excecao('Erro removendo a porta.', $e);
       }
   }

   public function listar(Porta $porta) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objPortaBD = new PortaBD();
            
            $arr = $objPortaBD->listar($porta,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando a porta.',$e);
        }
    }
}