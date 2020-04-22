<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/LogBD.php';


class LogRN{
    

            
    public function cadastrar(Log $log) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
           
            
            $objExcecao->lancar_validacoes();
            $objLog_BD = new LogBD();
            $objLog_BD->cadastrar($log,$objBanco);
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando o Log de erro.', $e);
        }
    }

    public function alterar(Log $log) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
                       
            $objExcecao->lancar_validacoes();
            $objLog_BD = new LogBD();
            $objLog_BD->alterar($log,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando o Log de erro.', $e);
        }
    }

    public function consultar(Log $log) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objLog_BD = new LogBD();
            $arr =  $objLog_BD->consultar($log,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando o Log de erro.',$e);
        }
    }

    public function remover(Log $log) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objLog_BD = new LogBD();
            $arr =  $objLog_BD->remover($log,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo o Log de erro.', $e);
        }
    }

    public function listar(Log $log) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objLog_BD = new LogBD();
            
            $arr = $objLog_BD->listar($log,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o Log de erro.',$e);
        }
    }


    public function pesquisar($campoBD, $valor_usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objLog_BD = new LogBD();
            $arr = $objLog_BD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando o Log de erro.', $e);
        }
    }
    
   
}

