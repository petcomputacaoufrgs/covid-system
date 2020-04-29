<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do detentor do paciente
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/DetentorBD.php';

class DetentorRN{
    

    private function validarDetentor(Detentor $detentor,Excecao $objExcecao){
        $strDetentor = trim($detentor->getDetentor());
        
        if ($strDetentor == '') {
            $objExcecao->adicionar_validacao('O detentor não foi informado','idDetentor','alert-danger');
        }else{
            if (strlen($strDetentor) > 100) {
                $objExcecao->adicionar_validacao('O detentor possui mais que 100 caracteres.','idDetentor','alert-danger');
            }
            
        }
        
        return $detentor->setDetentor($strDetentor);

    }
    
     private function validarIndexDetentor(Detentor $detentor,Excecao $objExcecao){
        $strIndexDetentor = trim($detentor->getIndex_detentor());
        
       
            $detentor_aux_RN = new DetentorRN();
            $array_detentores = $detentor_aux_RN->listar($detentor);
            //print_r($array_sexos);
            foreach ($array_detentores as $d){
                if($d->getIndex_detentor() == $strIndexDetentor){
                    //$objExcecao->adicionar_validacao('O detentor já existe.','idDetentor');
                    return false;
                }
            }
        
        return true;

    }

    private function validarRemocao(Detentor $detentor,Excecao $objExcecao){
        $objEquipamento = new Equipamento();
        $objEquipamentoRN = new EquipamentoRN();


        $objEquipamento->setIdDetentor_fk($detentor->getIdDetentor());
        $arr = $objEquipamentoRN->existe($objEquipamento);

        //print_r($arr);
        if(count($arr) > 0){
            $objExcecao->adicionar_validacao('O detentor não pode ser excluído porque tem um equipamento associado a ele','idLocalArmazenamento', 'alert-danger');
        }
    }



    public function cadastrar(Detentor $detentor) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objDetentorBD = new DetentorBD();
            $this->validarDetentor($detentor,$objExcecao); 
             
            
            
            $objExcecao->lancar_validacoes();
            $objDetentorBD->cadastrar($detentor,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando o detentor.', $e);
        }
    }

    public function alterar(Detentor $detentor) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarDetentor($detentor,$objExcecao);  
            
            $objExcecao->lancar_validacoes();
            $objDetentorBD = new DetentorBD();
            $objDetentorBD->alterar($detentor,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando o detentor.', $e);
        }
    }

    public function consultar(Detentor $detentor) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objDetentorBD = new DetentorBD();
            $arr =  $objDetentorBD->consultar($detentor,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando o detentor.',$e);
        }
    }

    public function remover(Detentor $detentor) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();

             $this->validarRemocao($detentor,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objDetentorBD = new DetentorBD();
            $arr =  $objDetentorBD->remover($detentor,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo o detentor.', $e);
        }
    }

    public function listar(Detentor $detentor) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objDetentorBD = new DetentorBD();
            
            $arr = $objDetentorBD->listar($detentor,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o detentor.',$e);
        }
    }


     public function pesquisar_index(Detentor $detentor) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objDetentorBD = new DetentorBD();
            $arr = $objDetentorBD->pesquisar_index($detentor,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando o detentor.', $e);
        }
    }

}

