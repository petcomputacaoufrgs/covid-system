<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/OperadorBD.php';
class OperadorRN
{
    private function validarIdOperador(Operador $objOperador, Excecao $objExcecao)
    {
       if($objOperador->getIdOperador() == null){
           $objExcecao->adicionar_validacao('O identificador do operador deve ser informado', null, 'alert-danger');
       }
    }
    private function validarIdCalculo(Operador $objOperador, Excecao $objExcecao)
    {
        if($objOperador->getIdCalculoFk() == null){
            $objExcecao->adicionar_validacao('O identificador do cálculo deve ser informado', null, 'alert-danger');
        }else{
                $numIdCalculo = intval($objOperador->getIdCalculoFk());
                return $objOperador->setIdCalculoFk($numIdCalculo);
        }
    }
    private function validarNome(Operador $objOperador, Excecao $objExcecao)
    {
        if($objOperador->getNome() == null){
            $objExcecao->adicionar_validacao('O nome do operador deve ser informado', null, 'alert-danger');
        }else{
            $strOperador = trim($objOperador->getNome());
            if(strlen($strOperador) > 50){
                $objExcecao->adicionar_validacao('O nome do operador deve ter, no máximo, 50 caracteres', null, 'alert-danger');
            }
        }
    }

    private function validarValor(Operador $objOperador, Excecao $objExcecao)
    {
        if($objOperador->getValor() == null){
            $objExcecao->adicionar_validacao('O valor do operador deve ser informado', null, 'alert-danger');
        }
    }


    public function cadastrar(Operador $objOperador)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdCalculo($objOperador, $objExcecao);
            $this->validarNome($objOperador, $objExcecao);
            $this->validarValor($objOperador, $objExcecao);

            $objExcecao->lancar_validacoes();
            $objOperadorBD = new OperadorBD();
            $objOperador = $objOperadorBD->cadastrar($objOperador, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objOperador;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o operador.', $e);
        }
    }

    public function alterar(Operador $objOperador)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdCalculo($objOperador, $objExcecao);
            $this->validarIdOperador($objOperador, $objExcecao);
            $this->validarNome($objOperador, $objExcecao);
            $this->validarValor($objOperador, $objExcecao);


            $objExcecao->lancar_validacoes();
            $objOperadorBD = new OperadorBD();
            $objOperador = $objOperadorBD->alterar($objOperador, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objOperador;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o operador.', $e);
        }
    }

    public function consultar(Operador $objOperador)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $this->validarIdOperador($objOperador, $objExcecao);
            $objExcecao->lancar_validacoes();
            $objOperadorBD = new OperadorBD();
            $arr = $objOperadorBD->consultar($objOperador, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o operador.', $e);
        }
    }

    public function remover(Operador $objOperador)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $this->validarIdOperador($objOperador, $objExcecao);
            $objExcecao->lancar_validacoes();
            $objOperadorBD = new OperadorBD();
            $arr = $objOperadorBD->remover($objOperador, $objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o operador.', $e);
        }
    }

    public function listar(Operador $objOperador,$numLimite = null)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objOperadorBD = new OperadorBD();

            $arr = $objOperadorBD->listar($objOperador, $numLimite, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o operador.', $e);
        }
    }

    public function listar_completo(Operador $objOperador,$numLimite = null)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objOperadorBD = new OperadorBD();

            $arr = $objOperadorBD->listar_completo($objOperador, $numLimite, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o operador completo.', $e);
        }
    }

}