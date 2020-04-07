<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do lugar de origem do paciente
 */

require_once 'classes/Excecao/Excecao.php';
require_once 'classes/LugarOrigem/LugarOrigemBD.php';

class LugarOrigemRN{
    
   

    public function cadastrar(LugarOrigem $detentor) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $objExcecao->lancar_validacoes();
            $objLugarOrigemBD = new LugarOrigemBD();
            $objLugarOrigemBD->cadastrar($detentor,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando o lugar de origem.', $e);
        }
    }

    public function alterar(LugarOrigem $detentor) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
                        
            $objExcecao->lancar_validacoes();
            $objLugarOrigemBD = new LugarOrigemBD();
            $objLugarOrigemBD->alterar($detentor,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando o lugar de origem.', $e);
        }
    }

    public function consultar(LugarOrigem $detentor) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objLugarOrigemBD = new LugarOrigemBD();
            $arr =  $objLugarOrigemBD->consultar($detentor,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando o lugar de origem.',$e);
        }
    }

    public function remover(LugarOrigem $detentor) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objLugarOrigemBD = new LugarOrigemBD();
            $arr =  $objLugarOrigemBD->remover($detentor,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo o lugar de origem.', $e);
        }
    }

    public function listar(LugarOrigem $detentor) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objLugarOrigemBD = new LugarOrigemBD();
            
            $arr = $objLugarOrigemBD->listar($detentor,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o lugar de origem.',$e);
        }
    }


    public function pesquisar($campoBD, $valor_usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objLugarOrigemBD = new LugarOrigemBD();
            $arr = $objLugarOrigemBD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando o lugar de origem.', $e);
        }
    }

}

?>
