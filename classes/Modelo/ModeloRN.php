<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do modelo do paciente
 */

require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Modelo/ModeloBD.php';

class ModeloRN{
    

    private function validarModelo(Modelo $detentor,Excecao $objExcecao){
        $strModelo = trim($detentor->getModelo());
        
        if ($strModelo == '') {
            $objExcecao->adicionar_validacao('O modelo não foi informado','idModelo');
        }else{
            if (strlen($strModelo) > 100) {
                $objExcecao->adicionar_validacao('O modelo possui mais que 100 caracteres.','idModelo');
            }
            
            $detentor_aux_RN = new ModeloRN();
            $array_modelos = $detentor_aux_RN->listar($detentor);
            //print_r($array_sexos);
            foreach ($array_modelos as $m){
                if($m->getModelo() == $detentor->getModelo()){
                    $objExcecao->adicionar_validacao('O modelo já existe.','idModelo');
                }
            }
        }
        
        return $detentor->setModelo($strModelo);

    }
     

    public function cadastrar(Modelo $detentor) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarModelo($detentor,$objExcecao); 
            $objExcecao->lancar_validacoes();
            $objModeloBD = new ModeloBD();
            $objModeloBD->cadastrar($detentor,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando o modelo.', $e);
        }
    }

    public function alterar(Modelo $detentor) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarModelo($detentor,$objExcecao);   
                        
            $objExcecao->lancar_validacoes();
            $objModeloBD = new ModeloBD();
            $objModeloBD->alterar($detentor,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando o modelo.', $e);
        }
    }

    public function consultar(Modelo $detentor) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objModeloBD = new ModeloBD();
            $arr =  $objModeloBD->consultar($detentor,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando o modelo.',$e);
        }
    }

    public function remover(Modelo $detentor) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objModeloBD = new ModeloBD();
            $arr =  $objModeloBD->remover($detentor,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo o modelo.', $e);
        }
    }

    public function listar(Modelo $detentor) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objModeloBD = new ModeloBD();
            
            $arr = $objModeloBD->listar($detentor,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o modelo.',$e);
        }
    }


    public function pesquisar($campoBD, $valor_usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objModeloBD = new ModeloBD();
            $arr = $objModeloBD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando o modelo.', $e);
        }
    }

}

?>
