<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once 'classes/Excecao/Excecao.php';

class Amostra{


    private function validarQuantidade(Amostra $objAmostra, Excecao $objExcecao) {
        $strEmail = trim($objAmostra->getEmail());
       
        
        if ($strEmail == '') {
            $objExcecao->adicionar_validacao('Email não informado.');
            //throw new Exception('Email não informado.');
        }else{

            if (strlen($strEmail) > 60) {
                $objExcecao->adicionar_validacao('O email possui mais de 50 caracteres.');
            }

            if (!filter_var($strEmail, FILTER_VALIDATE_EMAIL)) {
                $objExcecao->adicionar_validacao('Email é inválido.');
            }
        }
        
        $objAmostra->setEmail($strEmail);

    }
     

    public function cadastrar(Amostra $amostra) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarQuantidade($amostra,$objExcecao);
            $this->validarObservacoes($amostra,$objExcecao);
            $this->dataHoraInicio($amostra,$objExcecao);
            $this->dataHoraFim($amostra,$objExcecao);
            
            
            $objExcecao->lancar_validacoes();
            
            $objAmostraBD = new AmostraBD();
            $objAmostraBD->cadastrar($amostra);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando amostra.', $e);
        }
    }

    public function alterar(Amostra $amostra) {
         try {
             $objExcecao = new Excecao();
            $this->validarEmail($amostra,$objExcecao);
            $this->validarMatricula($amostra,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objAmostraBD = new AmostraBD();
            $objAmostraBD->alterar($amostra);

        } catch (Exception $e) {
            throw new Exception('Erro alterando amostra.', NULL, $e);
        }
    }

    public function consultar(Amostra $amostra) {
        try {
            $objAmostraBD = new AmostraBD();
            return $objAmostraBD->consultar($amostra);

        } catch (Exception $e) {
            throw new Exception('Erro consultando amostra.', NULL, $e);
        }
    }

    public function remover(Amostra $amostra) {
         try {
            $objAmostraBD = new AmostraBD();
            return $objAmostraBD->remover($amostra);

        } catch (Exception $e) {
            throw new Exception('Erro removendo amostra.', NULL, $e);
        }
    }

    public function listar(Amostra $amostra) {
        try {
            $objAmostraBD = new AmostraBD();
            return $objAmostraBD->listar($amostra);
        } catch (Exception $e) {
            throw new Exception('Erro listando amostra.', NULL, $e);
        }
    }


    public function logar(Amostra $amostra) {
        try {
            $objAmostraBD = new AmostraBD();
            return $objAmostraBD->logar($amostra);
        } catch (Exception $e) {
            throw new Exception('Erro logando amostra.', NULL, $e);
        }
    }

    public function pesquisar($campoBD, $valor_usuario) {
        try {
            $objAmostraBD = new AmostraBD();
            return $objAmostraBD->pesquisar($campoBD,$valor_usuario);
        } catch (Exception $e) {
            throw new Exception('Erro pesquisando amostra.', NULL, $e);
        }
    }

}

?>
