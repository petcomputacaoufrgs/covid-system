<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/CadastroAmostraBD.php';

class CadastroAmostraRN{
   
    
      
     

    public function cadastrar(CadastroAmostra $cadastroAmostra) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
           
            $objExcecao->lancar_validacoes();
            $objCadastroAmostraBD = new CadastroAmostraBD();
            $objCadastroAmostraBD->cadastrar($cadastroAmostra,$objBanco);
            
            $objBanco->fecharConexao();
            
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando amostra.', $e);
        }
    }

    public function alterar(CadastroAmostra $cadastroAmostra) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 

            
            $objExcecao->lancar_validacoes();
            
            $objCadastroAmostraBD = new CadastroAmostraBD();
            $objCadastroAmostraBD->alterar($cadastroAmostra,$objBanco);
            $objBanco->fecharConexao();

        } catch (Exception $e) {
            throw new Exception('Erro alterando amostra.', NULL, $e);
        }
    }

    public function consultar(CadastroAmostra $cadastroAmostra) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objCadastroAmostraBD = new CadastroAmostraBD();
            $arr = $objCadastroAmostraBD->consultar($cadastroAmostra,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Exception('Erro consultando amostra.', NULL, $e);
        }
    }

    public function remover(CadastroAmostra $cadastroAmostra) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objCadastroAmostraBD = new CadastroAmostraBD();
            $arr =  $objCadastroAmostraBD->remover($cadastroAmostra,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Exception('Erro removendo amostra.', NULL, $e);
        }
    }

    public function listar(CadastroAmostra $cadastroAmostra) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objCadastroAmostraBD = new CadastroAmostraBD();
            $arr =  $objCadastroAmostraBD->listar($cadastroAmostra,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Exception('Erro listando amostra.', NULL, $e);
        }
    }
    
    
    
    
  
  

}

