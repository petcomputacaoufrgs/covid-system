<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio da permanência do paciente
 */

require_once 'classes/Excecao/Excecao.php';
require_once 'classes/TempoPermanencia/TempoPermanenciaBD.php';

class TempoPermanenciaRN{
    

    private function validarTempoTempoPermanencia(TempoPermanencia $tempoPermanencia,Excecao $objExcecao){
        $strTempoPermanencia = trim($tempoPermanencia->getTempoPermanencia());
        
        if ($strTempoPermanencia == '') {
            $objExcecao->adicionar_validacao('O tempo de permanência não foi informado','idTempoTempoPermanencia');
        }else{
            if (strlen($strTempoPermanencia) > 50) {
                $objExcecao->adicionar_validacao('O tempo de permanência possui mais que 50 caracteres.','idTempoTempoPermanencia');
            }
            
            $tempoPermanencia_aux_RN = new TempoPermanenciaRN();
            $array_tempos_permanencias = $tempoPermanencia_aux_RN->listar($tempoPermanencia);
            //print_r($array_sexos);
            foreach ($array_tempos_permanencias as $tp){
                if($tp->getTempoPermanencia() == $tempoPermanencia->getTempoPermanencia()){
                    $objExcecao->adicionar_validacao('O tempo de permanência já existe.','idTempoTempoPermanencia');
                }
            }
        }
        
        return $tempoPermanencia->setTempoPermanencia($strTempoPermanencia);

    }
     

    public function cadastrar(TempoPermanencia $tempoPermanencia) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarTempoTempoPermanencia($tempoPermanencia,$objExcecao); 
            $objExcecao->lancar_validacoes();
            $objTempoPermanenciaBD = new TempoPermanenciaBD();
            $objTempoPermanenciaBD->cadastrar($tempoPermanencia,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando a permanência.', $e);
        }
    }

    public function alterar(TempoPermanencia $tempoPermanencia) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarTempoTempoPermanencia($tempoPermanencia,$objExcecao);   
                        
            $objExcecao->lancar_validacoes();
            $objTempoPermanenciaBD = new TempoPermanenciaBD();
            $objTempoPermanenciaBD->alterar($tempoPermanencia,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando a permanência.', $e);
        }
    }

    public function consultar(TempoPermanencia $tempoPermanencia) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objTempoPermanenciaBD = new TempoPermanenciaBD();
            $arr =  $objTempoPermanenciaBD->consultar($tempoPermanencia,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando a permanência.',$e);
        }
    }

    public function remover(TempoPermanencia $tempoPermanencia) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objTempoPermanenciaBD = new TempoPermanenciaBD();
            $arr =  $objTempoPermanenciaBD->remover($tempoPermanencia,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo a permanência.', $e);
        }
    }

    public function listar(TempoPermanencia $tempoPermanencia) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objTempoPermanenciaBD = new TempoPermanenciaBD();
            
            $arr = $objTempoPermanenciaBD->listar($tempoPermanencia,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando a permanência.',$e);
        }
    }


    public function pesquisar($campoBD, $valor_usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objTempoPermanenciaBD = new TempoPermanenciaBD();
            $arr = $objTempoPermanenciaBD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando a permanência.', $e);
        }
    }

}

?>
