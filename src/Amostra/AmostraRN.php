<?php

/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\Amostra;

use InfUfrgs\Excecao\Excecao;
use InfUfrgs\Amostra\AmostraDB;

class AmostraRN{
   
    
    private function validarQuantidadeTubos(Amostra $objAmostra, Excecao $objExcecao) {
        $strQntTubos = trim($objAmostra->getQuantidadeTubos());
       
        
        if ($strQntTubos == '') {
            $objExcecao->adicionar_validacao('Quantidade de tubos não foi informada','idQntTubos');
        }
        
        
        $objAmostra->setQuantidadeTubos($strQntTubos);

    }
    
    private function validarObservacoes(Amostra $objAmostra, Excecao $objExcecao) {
        $strObservacoes = trim($objAmostra->getObservacoes());
       
        
        if (strlen($strObservacoes) > 150) {
            $objExcecao->adicionar_validacao('A observação possui mais de 150 caracteres.','idObsAmostra');
        }
       
        $objAmostra->setObservacoes($strObservacoes);

    }
    
    private function validarDataHoraColeta(Amostra $objAmostra, Excecao $objExcecao) {
        $strDataHoraColeta = trim($objAmostra->getDataHoraColeta());
       
        if ($strDataHoraColeta == '') {
            $objExcecao->adicionar_validacao('Informar a data e hora da coleta.','idDtHrColeta');
        }
        $objAmostra->setDataHoraColeta($strDataHoraColeta);
    }
    
    private function validarAceitaRecusa(Amostra $objAmostra, Excecao $objExcecao) {
        $strAceitaRecusa = trim($objAmostra->getAceita_recusa());
       
        
        if ($strAceitaRecusa == '') {
            $objExcecao->adicionar_validacao('Informar se a amostra é aceita ou recusada.','idAceitaRecusada');
        }
       
        $objAmostra->setAceita_recusa($strAceitaRecusa);

    }
     

    public function cadastrar(Amostra $amostra) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarQuantidadeTubos($amostra,$objExcecao);
            $this->validarObservacoes($amostra,$objExcecao);
            $this->validarAceitaRecusa($amostra,$objExcecao);
            $this->validarDataHoraColeta($amostra,$objExcecao);
            
            $objExcecao->lancar_validacoes();
            $objAmostraBD = new AmostraBD();
            $objAmostraBD->cadastrar($amostra,$objBanco);
            
            $objBanco->fecharConexao();
            
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando amostra.', $e);
        }
    }

    public function alterar(Amostra $amostra) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 

            $this->validarQuantidadeTubos($amostra,$objExcecao);
            $this->validarObservacoes($amostra,$objExcecao);
            $this->validarAceitaRecusa($amostra,$objExcecao);
            $this->validarDataHoraColeta($amostra,$objExcecao);
            $objExcecao->lancar_validacoes();
            
            $objAmostraBD = new AmostraBD();
            $objAmostraBD->alterar($amostra,$objBanco);
            $objBanco->fecharConexao();

        } catch (Exception $e) {
            throw new Exception('Erro alterando amostra.', NULL, $e);
        }
    }

    public function consultar(Amostra $amostra) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objAmostraBD = new AmostraBD();
            $arr = $objAmostraBD->consultar($amostra,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Exception('Erro consultando amostra.', NULL, $e);
        }
    }

    public function remover(Amostra $amostra) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objAmostraBD = new AmostraBD();
            $arr =  $objAmostraBD->remover($amostra,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Exception('Erro removendo amostra.', NULL, $e);
        }
    }

    public function listar(Amostra $amostra) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objAmostraBD = new AmostraBD();
            $arr =  $objAmostraBD->listar($amostra,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Exception('Erro listando amostra.', NULL, $e);
        }
    }


}

?>
