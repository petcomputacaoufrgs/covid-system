<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/EtniaBD.php';


class EtniaRN{
    

            
    public function cadastrar(Etnia $etnia) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
           
            
            $objExcecao->lancar_validacoes();
            $objEtnia_BD = new EtniaBD();
            $objEtnia_BD->cadastrar($etnia,$objBanco);
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando a etnia do paciente.', $e);
        }
    }

    public function alterar(Etnia $etnia) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
                       
            $objExcecao->lancar_validacoes();
            $objEtnia_BD = new EtniaBD();
            $objEtnia_BD->alterar($etnia,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando a etnia do paciente.', $e);
        }
    }

    public function consultar(Etnia $etnia) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objEtnia_BD = new EtniaBD();
            $arr =  $objEtnia_BD->consultar($etnia,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando a etnia do paciente.',$e);
        }
    }

    public function remover(Etnia $etnia) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objEtnia_BD = new EtniaBD();
            $arr =  $objEtnia_BD->remover($etnia,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo a etnia do paciente.', $e);
        }
    }

    public function listar(Etnia $etnia) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objEtnia_BD = new EtniaBD();
            
            $arr = $objEtnia_BD->listar($etnia,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando a etnia do paciente.',$e);
        }
    }


    public function pesquisar_index(Etnia $etnia) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objEtniaBD = new EtniaBD();
            $arr = $objEtniaBD->pesquisar_index($etnia,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando a etnia do paciente.', $e);
        }
    }
    
   
}

