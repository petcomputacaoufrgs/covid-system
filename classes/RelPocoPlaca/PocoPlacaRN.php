<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/PocoPlacaBD.php';

class PocoPlacaRN
{
    public function cadastrar(PocoPlaca $objPocosPlaca) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objPocosPlacaBD = new PocoPlacaBD();
            $objPoco  = $objPocosPlacaBD->cadastrar($objPocosPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objPoco;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando os poços da placa na RN.', $e);
        }
    }

    public function alterar(PocoPlaca $objPocosPlaca) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objPocosPlacaBD = new PocoPlacaBD();
            $objPoco = $objPocosPlacaBD->alterar($objPocosPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objPoco;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando os poços da placa na RN.', $e);
        }
    }

    public function consultar(PocoPlaca $objPocosPlaca) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPocosPlacaBD = new PocoPlacaBD();
            $arr =  $objPocosPlacaBD->consultar($objPocosPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando os poços da placa na RN.',$e);
        }
    }

    public function remover(PocoPlaca $objPocosPlaca) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPocosPlacaBD = new PocoPlacaBD();

            $objExcecao->lancar_validacoes();

            $arr =  $objPocosPlacaBD->remover($objPocosPlaca,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo os poços da placa na RN.', $e);
        }
    }

    public function listar(PocoPlaca $objPocosPlaca) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPocosPlacaBD = new PocoPlacaBD();

            $arr = $objPocosPlacaBD->listar($objPocosPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando os poços da placa na RN.',$e);
        }
    }
}