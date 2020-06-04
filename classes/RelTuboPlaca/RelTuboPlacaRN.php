<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/RelTuboPlacaBD.php';
class RelTuboPlacaRN
{
    public function cadastrar(RelTuboPlaca $objRelTuboPlaca){
        $objBanco = new Banco();
        try{

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            //print_r($objRelTuboPlaca);

            $objExcecao->lancar_validacoes();
            $objRelTuboPlacaBD = new RelTuboPlacaBD();
            $objRelTuboPlaca = $objRelTuboPlacaBD->cadastrar($objRelTuboPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objRelTuboPlaca;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro no cadastramento do relacionamento dos tubos com uma placa.', $e);
        }
    }

    public function alterar(RelTuboPlaca $objRelTuboPlaca) {
        $objBanco = new Banco();
        try{

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();


            $objExcecao->lancar_validacoes();
            $objRelTuboPlacaBD = new RelTuboPlacaBD();
            $objRelTuboPlaca  = $objRelTuboPlacaBD->alterar($objRelTuboPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objRelTuboPlaca;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na alteração do relacionamento dos tubos com uma placa.', $e);
        }
    }

    public function consultar(RelTuboPlaca $objRelTuboPlaca) {
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objRelTuboPlacaBD = new RelTuboPlacaBD();
            $arr =  $objRelTuboPlacaBD->consultar($objRelTuboPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na consulta do relacionamento dos tubos com uma placa.',$e);
        }
    }

    public function remover(RelTuboPlaca $objRelTuboPlaca) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objRelTuboPlacaBD = new RelTuboPlacaBD();

            $arr =  $objRelTuboPlacaBD->remover($objRelTuboPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;

        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na remoção do relacionamento dos tubos com uma placa.', $e);
        }
    }

    public function remover_arr($arr_relacionamento) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objRelTuboPlacaBD = new RelTuboPlacaBD();

            $arr =  $objRelTuboPlacaBD->remover_arr($arr_relacionamento,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;

        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na remoção do relacionamento dos tubos com uma placa.', $e);
        }
    }

    public function listar(RelTuboPlaca $objRelTuboPlaca) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objRelTuboPlacaBD = new RelTuboPlacaBD();

            $arr =  $objRelTuboPlacaBD->listar($objRelTuboPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na listagem do relacionamento dos tubos com uma placa.',$e);
        }
    }

    public function listar_completo($relTuboPlaca) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objRelTuboPlacaBD = new RelTuboPlacaBD();

            $arr =  $objRelTuboPlacaBD->listar_completo($relTuboPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na listagem completa do relacionamento dos tubos com uma placa.',$e);
        }
    }
}