<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do estado de origem do paciente
 */

require_once 'classes/Excecao/Excecao.php';
require_once 'classes/EstadoOrigem/EstadoOrigemBD.php';

class EstadoOrigemRN{
    
 

    public function consultar(EstadoOrigem $detentor) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objEstadoOrigemBD = new EstadoOrigemBD();
            $arr =  $objEstadoOrigemBD->consultar($detentor,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando o estado de origem.',$e);
        }
    }


    public function listar(EstadoOrigem $detentor) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objEstadoOrigemBD = new EstadoOrigemBD();
            
            $arr = $objEstadoOrigemBD->listar($detentor,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o estado de origem.',$e);
        }
    }


    public function pesquisar($campoBD, $valor_usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objEstadoOrigemBD = new EstadoOrigemBD();
            $arr = $objEstadoOrigemBD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando o estado de origem.', $e);
        }
    }

}

?>
