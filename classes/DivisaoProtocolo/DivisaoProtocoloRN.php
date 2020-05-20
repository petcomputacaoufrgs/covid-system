<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/DivisaoProtocoloBD.php';


class DivisaoProtocoloRN
{

    private function validarNomeDivisao(DivisaoProtocolo $objDivisaoProtocolo,Excecao $objExcecao){
        $strNomeDivisao = trim($objDivisaoProtocolo->getNomeDivisao());

        if ($strNomeDivisao == '') {
            $objExcecao->adicionar_validacao('O nome da divisão não foi informado',null,'alert-danger');
        }else{
            if (strlen($strNomeDivisao) > 150) {
                $objExcecao->adicionar_validacao('O nome da divisão deve possuir no máximo 50 caracteres',null,'alert-danger');
            }
        }

        return $objDivisaoProtocolo->setNomeDivisao($strNomeDivisao);

    }

    private function validarIdProtocolo(DivisaoProtocolo $objDivisaoProtocolo,Excecao $objExcecao){
        if($objDivisaoProtocolo->getIdProtocoloFk() == null){
            $objExcecao->adicionar_validacao('O nome da divisão tem que estar associado a algum protocolo',null,'alert-danger');
        }
    }

    private function validarIdProtocoloNomeDivisao(DivisaoProtocolo $objDivisaoProtocolo,Excecao $objExcecao){
       //validar se já não tem o nome da divisão para o mesmo protocolo
    }


    public function cadastrar(DivisaoProtocolo $objDivisaoProtocolo) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();


            $this->validarIdProtocolo($objDivisaoProtocolo,$objExcecao);
            $this->validarNomeDivisao($objDivisaoProtocolo,$objExcecao);
            $this->validarIdProtocoloNomeDivisao($objDivisaoProtocolo,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objDivisaoProtocoloBD = new DivisaoProtocoloBD();
            $objDivisaoProtocolo  = $objDivisaoProtocoloBD->cadastrar($objDivisaoProtocolo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objDivisaoProtocolo;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando a divisão do protocolo.', $e);
        }
    }

    public function alterar(DivisaoProtocolo $objDivisaoProtocolo) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdProtocolo($objDivisaoProtocolo,$objExcecao);
            $this->validarNomeDivisao($objDivisaoProtocolo,$objExcecao);
            $this->validarIdProtocoloNomeDivisao($objDivisaoProtocolo,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objDivisaoProtocoloBD = new DivisaoProtocoloBD();
            $objDivisaoProtocolo = $objDivisaoProtocoloBD->alterar($objDivisaoProtocolo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objDivisaoProtocolo;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando a divisão do protocolo.', $e);
        }
    }

    public function consultar(DivisaoProtocolo $objDivisaoProtocolo) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objDivisaoProtocoloBD = new DivisaoProtocoloBD();
            $arr =  $objDivisaoProtocoloBD->consultar($objDivisaoProtocolo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando a divisão do protocolo.',$e);
        }
    }

    public function remover(DivisaoProtocolo $objDivisaoProtocolo) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objDivisaoProtocoloBD = new DivisaoProtocoloBD();

            $objExcecao->lancar_validacoes();

            $arr =  $objDivisaoProtocoloBD->remover($objDivisaoProtocolo,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo a divisão do protocolo.', $e);
        }
    }

    public function listar(DivisaoProtocolo $objDivisaoProtocolo) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objDivisaoProtocoloBD = new DivisaoProtocoloBD();

            $arr = $objDivisaoProtocoloBD->listar($objDivisaoProtocolo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando a divisão do protocolo.',$e);
        }
    }

    public function listar_completo(DivisaoProtocolo $objDivisaoProtocolo) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objDivisaoProtocoloBD = new DivisaoProtocoloBD();

            $arr = $objDivisaoProtocoloBD->listar_completo($objDivisaoProtocolo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando a divisão do protocolo.',$e);
        }
    }

}