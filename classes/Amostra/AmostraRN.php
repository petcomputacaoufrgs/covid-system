<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/AmostraBD.php';

class AmostraRN{
   
    
      
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
    
    public function validarCadastro(Amostra $amostra) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $arr_resultado = array();
            $cadastrar = true;
            $objAmostraRN = new AmostraRN();
            $arr_amostras = $objAmostraRN->listar($amostra);
                        
            foreach ($arr_amostras as $a){
                if($a->getAceita_recusa() == $amostra->getAceita_recusa() &&
                   $a->getObservacoes() == $amostra->getObservacoes() &&
                   strtotime ($a->getDataHoraColeta()) == strtotime($amostra->getDataHoraColeta()) &&
                   $a->getIdEstado_fk() == $amostra->getIdEstado_fk() && 
                   $a->getIdLugarOrigem_fk() == $amostra->getIdLugarOrigem_fk() &&
                   $a->getIdPaciente_fk() == $amostra->getIdPaciente_fk() && 
                   $a->getIdNivelPrioridade_fk() == $amostra->getIdNivelPrioridade_fk() && 
                   $a->getStatusAmostra() == $amostra->getStatusAmostra()){
                     $amostra->setIdAmostra($a->getIdAmostra());
                     $cadastrar = false;
                     //return $arr_resultado;
                }
            }
            
            if($cadastrar){
                return $arr_resultado;
            }else{
                $objAmostraBD = new AmostraBD();
                $arr_resultado =  $objAmostraBD->consultar($amostra,$objBanco);
                $objBanco->fecharConexao();
            
            }
            return $arr_resultado;
        } catch (Exception $e) {
            throw new Exception('Erro listando amostra.', NULL, $e);
        }
    }
    
    
  
  

}

?>
