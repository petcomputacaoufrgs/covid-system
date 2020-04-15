<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do código GAL do paciente
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/CodigoGAL_RN.php';


class CodigoGAL_RN{
    

    private function validarCodGAL(CodigoGAL $codGAL,Excecao $objExcecao){
        $strCodGAL = trim($codGAL->getCodigo());
        
        
        if (strlen($strCodGAL) > 20) {
            $objExcecao->adicionar_validacao('O código GAL possui mais de 20 caracteres.','idCodGAL');
        }
        
        
        return $codGAL->setCodigo($strCodGAL);
    }
         
    public function cadastrar(CodigoGAL $codGAL) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            /* VALIDAÇÕES */
            $this->validarCodGAL($codGAL,$objExcecao);  
            
            $objExcecao->lancar_validacoes();
            $objCodigoGAL_BD = new CodigoGAL_BD();
            $objCodigoGAL_BD->cadastrar($codGAL,$objBanco);
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando o código GAL.', $e);
        }
    }

    public function alterar(CodigoGAL $codGAL) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            /* VALIDAÇÕES */
            $this->validarCodGAL($codGAL,$objExcecao);  
            
            $objExcecao->lancar_validacoes();
            $objCodigoGAL_BD = new CodigoGAL_BD();
            $objCodigoGAL_BD->alterar($codGAL,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando o código GAL.', $e);
        }
    }

    public function consultar(CodigoGAL $codGAL) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objCodigoGAL_BD = new CodigoGAL_BD();
            $arr =  $objCodigoGAL_BD->consultar($codGAL,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando o código GAL.',$e);
        }
    }

    public function remover(CodigoGAL $codGAL) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objCodigoGAL_BD = new CodigoGAL_BD();
            $arr =  $objCodigoGAL_BD->remover($codGAL,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo o código GAL.', $e);
        }
    }

    public function listar(CodigoGAL $codGAL) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objCodigoGAL_BD = new CodigoGAL_BD();
            
            $arr = $objCodigoGAL_BD->listar($codGAL,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o código GAL.',$e);
        }
    }


    public function pesquisar($campoBD, $valor_usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objCodigoGAL_BD = new CodigoGAL_BD();
            $arr = $objCodigoGAL_BD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando o código GAL.', $e);
        }
    }
    
   
}

