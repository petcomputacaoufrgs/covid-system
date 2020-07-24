<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/LaudoProtocoloBD.php';


class LaudoProtocoloRN
{

    private function validarIdLaudoProtocolo(LaudoProtocolo $objLaudoProtocolo,Excecao $objExcecao){

        if($objLaudoProtocolo->getIdRelLaudoProtocolo() == null) {
            $objExcecao->adicionar_validacao('O identificar do relacionamento laudo+protocolo não foi informado', null, 'alert-danger');
        }

    }

    public function cadastrar(LaudoProtocolo $objLaudoProtocolo) {
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objLaudoProtocoloBD = new LaudoProtocoloBD();

            $objLaudoProtocolo = $objLaudoProtocoloBD->cadastrar($objLaudoProtocolo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objLaudoProtocolo;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o relacionamento laudo+protocolo.', $e);
        }
    }

    public function alterar(LaudoProtocolo $objLaudoProtocolo) {
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdLaudoProtocolo($objLaudoProtocolo,$objExcecao);
            $objExcecao->lancar_validacoes();

            $objLaudoProtocoloBD = new LaudoProtocoloBD();
            $objLaudoProtocolo = $objLaudoProtocoloBD->alterar($objLaudoProtocolo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objLaudoProtocolo;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o relacionamento laudo+protocolo.', $e);
        }
    }

    public function consultar(LaudoProtocolo $objLaudoProtocolo) {
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdLaudoProtocolo($objLaudoProtocolo,$objExcecao);
            $objExcecao->lancar_validacoes();
            $objLaudoProtocoloBD = new LaudoProtocoloBD();

            $arr =  $objLaudoProtocoloBD->consultar($objLaudoProtocolo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();

            throw new Excecao('Erro consultando o relacionamento laudo+protocolo.',$e);
        }
    }

    public function remover(LaudoProtocolo $objLaudoProtocolo) {
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdLaudoProtocolo($objLaudoProtocolo,$objExcecao);
            $objExcecao->lancar_validacoes();

            $objLaudoProtocoloBD = new LaudoProtocoloBD();
            $arr =  $objLaudoProtocoloBD->remover($objLaudoProtocolo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o relacionamento laudo+protocolo.', $e);
        }
    }

    public function listar(LaudoProtocolo $objLaudoProtocolo) {
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objLaudoProtocoloBD = new LaudoProtocoloBD();

            $arr = $objLaudoProtocoloBD->listar($objLaudoProtocolo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o relacionamento laudo+protocolo.',$e);
        }
    }

}