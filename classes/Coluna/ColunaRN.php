<?php

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/ColunaBD.php';

class ColunaRN{

    private function validarNome(Coluna $coluna,Excecao $objExcecao){
        $strNome = trim($coluna->getNome());
        
        if ($strNome == '') {
            $objExcecao->adicionar_validacao('O nome da coluna não foi informado','idNomeColuna', 'alert-danger');
        }else{
            if (strlen($strNome) > 50) {
                $objExcecao->adicionar_validacao('O nome da coluna possui mais que 50 caracteres.','idNomeColuna', 'alert-danger');
            }
        }
        
        return $coluna->setNome($strNome);

    }

    public function cadastrar(Coluna $coluna) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            /*REALIZAR VALIDACOES*/ 

            $objExcecao->lancar_validacoes();
            $objColunaBD = new ColunaBD();
            $objColunaBD->cadastrar($coluna,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando a coluna.', $e);
        }
    }

    public function alterar(Coluna $coluna) {
        try {
            
           $objExcecao = new Excecao();
           $objBanco = new Banco();
           $objBanco->abrirConexao(); 
           
           /*REALZIAR VALIDACOES*/
                       
           $objExcecao->lancar_validacoes();
           $objColunaBD = new ColunaBD();
           $objColunaBD->alterar($coluna,$objBanco);
           
           $objBanco->fecharConexao();
       } catch (Exception $e) {
           throw new Excecao('Erro alterando a coluna.', $e);
       }
   }

   public function consultar(Coluna $coluna) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objColunaBD = new ColunaBD();
            $arr =  $objColunaBD->consultar($coluna,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {

            throw new Excecao('Erro consultando a coluna.',$e);
        }
    }

    public function remover(Coluna $coluna) {
        try {
           $objExcecao = new Excecao();
           $objBanco = new Banco();
           $objBanco->abrirConexao(); 
           $objExcecao->lancar_validacoes();
           $objColunaBD = new ColunaBD();
           $arr =  $objColunaBD->remover($coluna,$objBanco);
           $objBanco->fecharConexao();
           return $arr;

       } catch (Exception $e) {
           throw new Excecao('Erro removendo a coluna.', $e);
       }
   }

   public function listar(Coluna $coluna) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objColunaBD = new ColunaBD();
            
            $arr = $objColunaBD->listar($coluna,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando a coluna.',$e);
        }
    }
}
    
    