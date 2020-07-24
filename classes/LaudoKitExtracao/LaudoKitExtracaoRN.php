<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/LaudoKitExtracaoBD.php';


class LaudoKitExtracaoRN
{

    private function validarIdLaudoKitExtracao(LaudoKitExtracao $objLaudoKitExtracao,Excecao $objExcecao){

        if($objLaudoKitExtracao->getIdRelLaudoKitExtracao() == null) {
            $objExcecao->adicionar_validacao('O identificar do relacionamento Laudo+KitExtração não foi informado', null, 'alert-danger');
        }

    }

    public function cadastrar(LaudoKitExtracao $objLaudoKitExtracao) {
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objLaudoKitExtracaoBD = new LaudoKitExtracaoBD();

            $objLaudoKitExtracao = $objLaudoKitExtracaoBD->cadastrar($objLaudoKitExtracao,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objLaudoKitExtracao;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o relacionamento laudo+kitExtração.', $e);
        }
    }

    public function alterar(LaudoKitExtracao $objLaudoKitExtracao) {
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdLaudoKitExtracao($objLaudoKitExtracao,$objExcecao);
            $objExcecao->lancar_validacoes();

            $objLaudoKitExtracaoBD = new LaudoKitExtracaoBD();
            $objLaudoKitExtracao = $objLaudoKitExtracaoBD->alterar($objLaudoKitExtracao,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objLaudoKitExtracao;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o relacionamento laudo+kitExtração.', $e);
        }
    }

    public function consultar(LaudoKitExtracao $objLaudoKitExtracao) {
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdLaudoKitExtracao($objLaudoKitExtracao,$objExcecao);
            $objExcecao->lancar_validacoes();
            $objLaudoKitExtracaoBD = new LaudoKitExtracaoBD();

            $arr =  $objLaudoKitExtracaoBD->consultar($objLaudoKitExtracao,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();

            throw new Excecao('Erro consultando o relacionamento laudo+kitExtração.',$e);
        }
    }

    public function remover(LaudoKitExtracao $objLaudoKitExtracao) {
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdLaudoKitExtracao($objLaudoKitExtracao,$objExcecao);
            $objExcecao->lancar_validacoes();

            $objLaudoKitExtracaoBD = new LaudoKitExtracaoBD();
            $arr =  $objLaudoKitExtracaoBD->remover($objLaudoKitExtracao,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o relacionamento laudo+kitExtração.', $e);
        }
    }

    public function listar(LaudoKitExtracao $objLaudoKitExtracao) {
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objLaudoKitExtracaoBD = new LaudoKitExtracaoBD();

            $arr = $objLaudoKitExtracaoBD->listar($objLaudoKitExtracao,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o relacionamento laudo+kitExtração.',$e);
        }
    }



}