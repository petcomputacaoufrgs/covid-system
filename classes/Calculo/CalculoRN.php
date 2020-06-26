<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/CalculoBD.php';
class CalculoRN
{

    private function validarIdCalculo(Calculo $objCalculo, Excecao $objExcecao)
    {
        if($objCalculo->getIdCalculo() == null){
            $objExcecao->adicionar_validacao('O identificador do cálculo deve ser informado', null, 'alert-danger');
        }
    }
    private function validarIdProtocolo(Calculo $objCalculo, Excecao $objExcecao)
    {
        if($objCalculo->getIdProtocoloFk() == null || $objCalculo->getIdProtocoloFk() <= 0){
            $objExcecao->adicionar_validacao('O identificador do protocolo deve ser informado', null, 'alert-danger');
        }else{
            $numIdProtocolo = intval($objCalculo->getIdProtocoloFk());
            return $objCalculo->setIdProtocoloFk($numIdProtocolo);

            /*if(!is_int($objCalculo->getIdProtocoloFk())){
                $objExcecao->adicionar_validacao('O identificador do protocolo deve ser um inteiro', null, 'alert-danger');
            }*/
        }
    }

    private function validarNome(Calculo $objCalculo, Excecao $objExcecao)
    {
        if($objCalculo->getNome() == null){
            $objExcecao->adicionar_validacao('O nome do cálculo deve ser informado', null, 'alert-danger');
        }else{
            $strOperador = trim($objCalculo->getNome());
            if(strlen($strOperador) > 50){
                $objExcecao->adicionar_validacao('O nome do cálculo deve ter, no máximo, 50 caracteres', null, 'alert-danger');
            }
        }
    }


    public function cadastrar(Calculo $objCalculo)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarNome($objCalculo, $objExcecao);
            $this->validarIdProtocolo($objCalculo, $objExcecao);

            $objExcecao->lancar_validacoes();
            $objCalculoBD = new CalculoBD();
            $objCalculoBD->cadastrar($objCalculo, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objCalculo;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o cálculo.', $e);
        }
    }

    public function alterar(Calculo $objCalculo)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdCalculo($objCalculo, $objExcecao);
            $this->validarIdProtocolo($objCalculo, $objExcecao);
            $this->validarNome($objCalculo, $objExcecao);


            $objExcecao->lancar_validacoes();
            $objCalculoBD = new CalculoBD();
            $objCalculo = $objCalculoBD->alterar($objCalculo, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objCalculo;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o cálculo.', $e);
        }
    }

    public function consultar(Calculo $objCalculo)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $this->validarIdCalculo($objCalculo, $objExcecao);
            $objExcecao->lancar_validacoes();
            $objCalculoBD = new CalculoBD();
            $arr = $objCalculoBD->consultar($objCalculo, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o cálculo.', $e);
        }
    }

    public function remover(Calculo $objCalculo)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $this->validarIdCalculo($objCalculo, $objExcecao);
            $objExcecao->lancar_validacoes();
            $objCalculoBD = new CalculoBD();
            $arr = $objCalculoBD->remover($objCalculo, $objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o cálculo.', $e);
        }
    }

    public function listar(Calculo $objCalculo,$numLimite = null)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objCalculoBD = new CalculoBD();

            $arr = $objCalculoBD->listar($objCalculo, $numLimite, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o cálculo.', $e);
        }
    }

    public function listar_completo(Calculo $objCalculo,$numLimite = null)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objCalculoBD = new CalculoBD();

            $arr = $objCalculoBD->listar_completo($objCalculo, $numLimite, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o cálculo.', $e);
        }
    }
}