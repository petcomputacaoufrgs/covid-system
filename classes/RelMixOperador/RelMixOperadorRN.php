<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/RelMixOperadorBD.php';

class RelMixOperadorRN
{
    private function validarIdRelMixOperador(RelMixOperador $objRelMixOperador, Excecao $objExcecao)
    {
        if($objRelMixOperador->getIdRelMixOperador() == null || $objRelMixOperador->getIdRelMixOperador() <= 0){
            $objExcecao->adicionar_validacao('O identificador do relacionamento mix com o operador deve ser informado', null, 'alert-danger');
        }else{
            $numIdRelMixOperador = intval($objRelMixOperador->getIdRelMixOperador());
            return $objRelMixOperador->setIdRelMixOperador($numIdRelMixOperador);
        }
    }

    private function validarIdOperador(RelMixOperador $objRelMixOperador, Excecao $objExcecao)
    {
        if($objRelMixOperador->getIdOperadorFk() == null){
            $objExcecao->adicionar_validacao('O identificador do operador deve ser informado', null, 'alert-danger');
        }
    }
    private function validarIdMix(RelMixOperador $objRelMixOperador, Excecao $objExcecao)
    {
        if($objRelMixOperador->getIdMixFk() == null || $objRelMixOperador->getIdMixFk() <= 0){
            $objExcecao->adicionar_validacao('O identificador do mix deve ser informado', null, 'alert-danger');
        }else{
            $numIdMix = intval($objRelMixOperador->getIdMixFk());
            return $objRelMixOperador->setIdMixFk($numIdMix);
        }
    }

    private function validarValor(RelMixOperador $objRelMixOperador, Excecao $objExcecao)
    {
        if($objRelMixOperador->getValor() == null){
            $objExcecao->adicionar_validacao('O valor do relacionamento do mix com seus operadores deve ser informado', null, 'alert-danger');
        }else{
            $strValor = trim($objRelMixOperador->getValor());
            if(strlen($strValor) > 50){
                $objExcecao->adicionar_validacao('O valor do relacionamento do mix com seus operadores deve ter, no máximo, 50 caracteres', null, 'alert-danger');
            }
        }
    }


    public function cadastrar(RelMixOperador $objRelMixOperador)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarValor($objRelMixOperador, $objExcecao);
            $this->validarIdOperador($objRelMixOperador, $objExcecao);
            $this->validarIdMix($objRelMixOperador, $objExcecao);

            $objExcecao->lancar_validacoes();
            $objRelMixOperadorBD = new RelMixOperadorBD();
            $objRelMixOperadorBD->cadastrar($objRelMixOperador, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objRelMixOperador;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o relacionamento do mix com seus operadores.', $e);
        }
    }

    public function alterar(RelMixOperador $objRelMixOperador)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdRelMixOperador($objRelMixOperador, $objExcecao);
            $this->validarValor($objRelMixOperador, $objExcecao);
            $this->validarIdOperador($objRelMixOperador, $objExcecao);
            $this->validarIdMix($objRelMixOperador, $objExcecao);

            $objExcecao->lancar_validacoes();
            $objRelMixOperadorBD = new RelMixOperadorBD();
            $objRelMixOperador = $objRelMixOperadorBD->alterar($objRelMixOperador, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objRelMixOperador;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o relacionamento do mix com seus operadores.', $e);
        }
    }

    public function consultar(RelMixOperador $objRelMixOperador)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $this->validarIdRelMixOperador($objRelMixOperador, $objExcecao);
            $objExcecao->lancar_validacoes();
            $objRelMixOperadorBD = new RelMixOperadorBD();
            $arr = $objRelMixOperadorBD->consultar($objRelMixOperador, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o relacionamento do mix com seus operadores.', $e);
        }
    }

    public function remover(RelMixOperador $objRelMixOperador)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $this->validarIdRelMixOperador($objRelMixOperador, $objExcecao);
            $objExcecao->lancar_validacoes();
            $objRelMixOperadorBD = new RelMixOperadorBD();
            $arr = $objRelMixOperadorBD->remover($objRelMixOperador, $objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o relacionamento do mix com seus operadores.', $e);
        }
    }

    public function listar(RelMixOperador $objRelMixOperador,$numLimite = null)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objRelMixOperadorBD = new RelMixOperadorBD();

            $arr = $objRelMixOperadorBD->listar($objRelMixOperador, $numLimite, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o relacionamento do mix com seus operadores.', $e);
        }
    }

    public function listar_completo(RelMixOperador $objRelMixOperador,$numLimite = null)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objRelMixOperadorBD = new RelMixOperadorBD();

            $arr = $objRelMixOperadorBD->listar_completo($objRelMixOperador, $numLimite, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o relacionamento do mix com seus operadores.', $e);
        }
    }
}