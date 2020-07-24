<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do estado de origem do paciente
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/EstadoOrigemBD.php';

class EstadoOrigemRN{
    
 

    public function consultar(EstadoOrigem $detentor) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objEstadoOrigemBD = new EstadoOrigemBD();
            $arr =  $objEstadoOrigemBD->consultar($detentor,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
 
            throw new Excecao('Erro consultando o estado de origem.',$e);
        }
    }


    public function listar(EstadoOrigem $detentor) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objEstadoOrigemBD = new EstadoOrigemBD();
            
            $arr = $objEstadoOrigemBD->listar($detentor,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o estado de origem.',$e);
        }
    }


    public function pesquisar($campoBD, $valor_usuario) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objEstadoOrigemBD = new EstadoOrigemBD();
            $arr = $objEstadoOrigemBD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro pesquisando o estado de origem.', $e);
        }
    }

}

