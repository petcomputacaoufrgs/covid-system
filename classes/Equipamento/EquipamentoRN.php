<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do equipamento
 */

require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Equipamento/EquipamentoBD.php';

class EquipamentoRN{
    

    
    private function validarDataUltimaCalibragem(Equipamento $equipamento,Excecao $objExcecao){
        $strDataUltimaCalibragem= trim($equipamento->getDataUltimaCalibragem());
        
        if ($strDataUltimaCalibragem == '') {
            $objExcecao->adicionar_validacao('A data da última calibragem não foi informada','idDataUltimaCalibragem');
        }else{

           // echo date('d-m-Y');            
            
        }
        
        return $equipamento->setDataUltimaCalibragem($strDataUltimaCalibragem);

    }
    private function validarDataChegada(Equipamento $equipamento,Excecao $objExcecao){
        $strDataChegada = trim($equipamento->getDataChegada());
        
        if ($strDataChegada == '') {
            $objExcecao->adicionar_validacao('A data de chegada não foi informada','idDataChegada');
        }else{
           
            
            // echo date('d-m-Y');    
        }
        
        return $equipamento->setDataChegada($strDataChegada);

    }
    
    private function validarIdDetentor(Equipamento $equipamento,Excecao $objExcecao){
        $strIdDetentor = trim($equipamento->getIdDetentor_fk());
        
        if ($strIdDetentor == '' || $strIdDetentor == null) {
            $objExcecao->adicionar_validacao('O detentor precisa ser informado','idDetentor');
        }
        return $equipamento->setIdDetentor_fk($strIdDetentor);

    }
     

    public function cadastrar(Equipamento $equipamento) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarIdDetentor($equipamento, $objExcecao);
            $this->validarDataChegada($equipamento,$objExcecao); 
            $this->validarDataUltimaCalibragem($equipamento,$objExcecao); 
            
            $objExcecao->lancar_validacoes();
            $objEquipamentoBD = new EquipamentoBD();
            $objEquipamentoBD->cadastrar($equipamento,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando o equipamento.', $e);
        }
    }

    public function alterar(Equipamento $equipamento) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarDataChegada($equipamento,$objExcecao); 
            $this->validarDataUltimaCalibragem($equipamento,$objExcecao);  
                        
            $objExcecao->lancar_validacoes();
            $objEquipamentoBD = new EquipamentoBD();
            $objEquipamentoBD->alterar($equipamento,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando o equipamento.', $e);
        }
    }

    public function consultar(Equipamento $equipamento) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objEquipamentoBD = new EquipamentoBD();
            $arr =  $objEquipamentoBD->consultar($equipamento,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando o equipamento.',$e);
        }
    }

    public function remover(Equipamento $equipamento) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objEquipamentoBD = new EquipamentoBD();
            $arr =  $objEquipamentoBD->remover($equipamento,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo o equipamento.', $e);
        }
    }

    public function listar(Equipamento $equipamento) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objEquipamentoBD = new EquipamentoBD();
            
            $arr = $objEquipamentoBD->listar($equipamento,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o equipamento.',$e);
        }
    }


    public function pesquisar($campoBD, $valor_usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objEquipamentoBD = new EquipamentoBD();
            $arr = $objEquipamentoBD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando o equipamento.', $e);
        }
    }

}

?>
