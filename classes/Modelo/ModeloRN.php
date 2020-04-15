<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do modelo do paciente
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/ModeloBD.php';

class ModeloRN{
    

    private function validarModelo(Modelo $modelo,Excecao $objExcecao){
        $strModelo = trim($modelo->getModelo());
        
        if ($strModelo == '') {
            $objExcecao->adicionar_validacao('O modelo não foi informado','idModelo');
        }else{
            if (strlen($strModelo) > 100) {
                $objExcecao->adicionar_validacao('O modelo possui mais que 100 caracteres.','idModelo');
            }
            
        }
        
        return $modelo->setModelo($strModelo);

    }
    
    
    public function cadastrar(Modelo $modelo) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objModeloBD = new ModeloBD();
            
            $this->validarModelo($modelo,$objExcecao); 
            
            $objExcecao->lancar_validacoes();
            $objModeloBD->cadastrar($modelo,$objBanco);
            
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando o modelo.', $e);
        }
    }

    public function alterar(Modelo $modelo) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarModelo($modelo,$objExcecao);   
                        
            $objExcecao->lancar_validacoes();
            $objModeloBD = new ModeloBD();
            $objModeloBD->alterar($modelo,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando o modelo.', $e);
        }
    }

    public function consultar(Modelo $modelo) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objModeloBD = new ModeloBD();
           
            $arr =  $objModeloBD->consultar($modelo,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando o modelo.',$e);
        }
    }

    public function remover(Modelo $modelo) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objModeloBD = new ModeloBD();
            $arr =  $objModeloBD->remover($modelo,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo o modelo.', $e);
        }
    }

    public function listar(Modelo $modelo) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objModeloBD = new ModeloBD();
            
            $arr = $objModeloBD->listar($modelo,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o modelo.',$e);
        }
    }


    public function pesquisar_index(Modelo $modelo) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objModeloBD = new ModeloBD();
            $arr = $objModeloBD->pesquisar_index($modelo,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando o modelo.', $e);
        }
    }

}

