<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do detentor do paciente
 */

require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Detentor/DetentorBD.php';

class DetentorRN{
    

    private function validarDetentor(Detentor $detentor,Excecao $objExcecao){
        $strDetentor = trim($detentor->getDetentor());
        
        if ($strDetentor == '') {
            $objExcecao->adicionar_validacao('O detentor não foi informado','idDetentor');
        }else{
            if (strlen($strDetentor) > 100) {
                $objExcecao->adicionar_validacao('O detentor possui mais que 100 caracteres.','idDetentor');
            }
            
            $detentor_aux_RN = new DetentorRN();
            $array_detentores = $detentor_aux_RN->listar($detentor);
            //print_r($array_sexos);
            foreach ($array_detentores as $d){
                if($d->getDetentor() == $detentor->getDetentor()){
                    $objExcecao->adicionar_validacao('O detentor já existe.','idDetentor');
                }
            }
        }
        
        return $detentor->setDetentor($strDetentor);

    }
     

    public function cadastrar(Detentor $detentor) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarDetentor($detentor,$objExcecao); 
            $objExcecao->lancar_validacoes();
            $objDetentorBD = new DetentorBD();
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


    public function pesquisar($campoBD, $valor_usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objDetentorBD = new DetentorBD();
            $arr = $objDetentorBD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando o detentor.', $e);
        }
    }

}

?>
