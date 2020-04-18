<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/AmostraBD.php';

class AmostraRN{
   
    
      
    private function validarObservacoes(Amostra $objAmostra, Excecao $objExcecao) {
        $strObservacoes = trim($objAmostra->getObservacoes());
       
        
        if (strlen($strObservacoes) > 300) {
            $objExcecao->adicionar_validacao('A observação possui mais de 300 caracteres.','idObsAmostra');
        }
       
        $objAmostra->setObservacoes($strObservacoes);

    }
    
    private function validarDataColeta(Amostra $objAmostra, Excecao $objExcecao) {
        $strDataColeta = trim($objAmostra->getDataColeta());
       
        if ($strDataColeta == '') {
            $objExcecao->adicionar_validacao('Informar a data da coleta.','idDtColeta');
        }
        
        //validar para que não se coloque datas futuras a atual
        $objAmostra->setDataColeta($strDataColeta);
    }
    
    private function validar_a_r_g(Amostra $objAmostra, Excecao $objExcecao) {
        $strARG = trim($objAmostra->get_a_r_g());
       
        
        if ($strARG == '') {
            $objExcecao->adicionar_validacao('Informar se a amostra é aceita, recusada ou está a caminho.','idARG');
        }
       
        $objAmostra->set_a_r_g($strARG);

    }
    
    
    private function validarObsMotivo(Amostra $objAmostra, Excecao $objExcecao) {
        $strObsMotivo = trim($objAmostra->getObsMotivo());
       
        
        if (strlen($strObsMotivo) > 300) {
            $objExcecao->adicionar_validacao('As observações de motivo possui mais que 300 caracteres.','idObsMotivo');
        }
       
        $objAmostra->setObsMotivo($strObsMotivo);

    }
     
    private function validarObsCEP(Amostra $objAmostra, Excecao $objExcecao) {
        $strObsCep = trim($objAmostra->getObsCEP());
       
        
        if (strlen($strObsCep) > 300) {
            $objExcecao->adicionar_validacao('As observações de CEP possui mais que 300 caracteres.','idObsCEPAmostra');
        }
       
        $objAmostra->setObsCEP($strObsCep);

    }
    
    private function validarObsHoraColeta(Amostra $objAmostra, Excecao $objExcecao) {
        $strObsHrColeta = trim($objAmostra->getObsHoraColeta());
       
        
        if (strlen($strObsHrColeta) > 300) {
            $objExcecao->adicionar_validacao('As observações da hora da coleta possui mais que 300 caracteres.','idObsHoraColeta');
        }
       
        $objAmostra->setObsHoraColeta($strObsHrColeta);

    }
    
    private function validarObsLugarOrigem(Amostra $objAmostra, Excecao $objExcecao) {
        $strObsLugarOrigem = trim($objAmostra->getObsLugarOrigem());
       
        
        if (strlen($strObsLugarOrigem) > 300) {
            $objExcecao->adicionar_validacao('As observações do lugar de origem da coleta possui mais que 300 caracteres.','idObsLugarOrigem');
        }
       
        $objAmostra->setObsLugarOrigem($strObsLugarOrigem);

    }
    
    private function validarMotivo(Amostra $objAmostra, Excecao $objExcecao) {
        $strMotivo = trim($objAmostra->getMotivoExame());
       
        
        if (strlen($strMotivo) > 100) {
            $objExcecao->adicionar_validacao('O motivo do exame possui mais que 100 caracteres.','idMotivo');
        }
       
        $objAmostra->setMotivoExame($strMotivo);

    }
    
    private function validarCEP(Amostra $objAmostra, Excecao $objExcecao) {
        $strCEP = trim($objAmostra->getCEP());
       
        
        if (strlen($strCEP) > 8) {
            $objExcecao->adicionar_validacao('O CEP do exame possui mais que 8 caracteres.','idCEPAmostra');
        }
       
        $objAmostra->setCEP($strCEP);

    }
    

    public function cadastrar(Amostra $amostra) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarObservacoes($amostra,$objExcecao);
            $this->validar_a_r_g($amostra,$objExcecao);
            $this->validarDataColeta($amostra,$objExcecao);
            $this->validarObsCEP($amostra,$objExcecao);
            $this->validarObsHoraColeta($amostra,$objExcecao);
            $this->validarObsLugarOrigem($amostra, $objExcecao);
            $this->validarObsMotivo($amostra, $objExcecao);
            $this->validarMotivo($amostra, $objExcecao);
            $this->validarCEP($amostra, $objExcecao);
            
            $objExcecao->lancar_validacoes();
            $objAmostraBD = new AmostraBD();
            $objAmostraBD->cadastrar($amostra,$objBanco);
            
            $objBanco->fecharConexao();
            
        } catch (Throwable $e) {
            throw new Excecao('Erro cadastrando amostra.', $e);
        }
    }

    public function alterar(Amostra $amostra) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 

            $this->validarObservacoes($amostra,$objExcecao);
            $this->validar_a_r_g($amostra,$objExcecao);
            $this->validarDataColeta($amostra,$objExcecao);
            $this->validarObsCEP($amostra,$objExcecao);
            $this->validarObsHoraColeta($amostra,$objExcecao);
            $this->validarObsLugarOrigem($amostra, $objExcecao);
            $this->validarObsMotivo($amostra, $objExcecao);
            $this->validarMotivo($amostra, $objExcecao);
            $this->validarCEP($amostra, $objExcecao);
            
            $objExcecao->lancar_validacoes();
            
            $objAmostraBD = new AmostraBD();
            $objAmostraBD->alterar($amostra,$objBanco);
            $objBanco->fecharConexao();

        } catch (Throwable $e) {
            throw new Excecao('Erro alterando amostra.', NULL, $e);
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

        } catch (Throwable $e) {
            throw new Excecao('Erro consultando amostra.', NULL, $e);
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
            throw new Excecao('Erro removendo amostra.', NULL, $e);
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
        } catch (Throwable $e) {
            throw new Excecao('Erro listando amostra.', NULL, $e);
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
                if($a->get_a_r_g() == $amostra->get_a_r_g() &&
                   $a->getObservacoes() == $amostra->getObservacoes() &&
                   strtotime ($a->getDataColeta()) == strtotime($amostra->getDataColeta()) &&
                   strtotime ($a->getHoraColeta()) == strtotime($amostra->getHoraColeta()) &&
                   $a->getIdEstado_fk() == $amostra->getIdEstado_fk() && 
                   $a->getIdLugarOrigem_fk() == $amostra->getIdLugarOrigem_fk() &&
                   $a->getIdPaciente_fk() == $amostra->getIdPaciente_fk() && 
                   $a->getIdNivelPrioridade_fk() == $amostra->getIdNivelPrioridade_fk() && 
                   $a->getObsCEP() == $amostra->getObsCEP() && 
                   $a->getObsHoraColeta() == $amostra->getObsHoraColeta() && 
                   $a->getObsLugarOrigem() == $amostra->getObsLugarOrigem() && 
                   $a->getObsMotivo() == $amostra->getObsMotivo() && 
                   $a->getMotivoExame() == $amostra->getMotivoExame()){
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
        } catch (Throwable $e) {
            throw new Excecao('Erro listando amostra.', NULL, $e);
        }
    }
    
    
  
  

}

