<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\Usuario\Amostra;

use InfUfrgs\Excecao\Excecao;

class Amostra
{
    private function validarQuantidade(Amostra $objAmostra, Excecao $objExcecao)
    {
        $strEmail = trim($objAmostra->getEmail());
       
        
        if ($strEmail == '') {
            $objExcecao->adicionar_validacao('Email não informado.');
        //throw new \Exeception('Email não informado.');
        } else {
            if (strlen($strEmail) > 60) {
                $objExcecao->adicionar_validacao('O email possui mais de 50 caracteres.');
            }

            if (!filter_var($strEmail, FILTER_VALIDATE_EMAIL)) {
                $objExcecao->adicionar_validacao('Email é inválido.');
            }
        }
        
        $objAmostra->setEmail($strEmail);
    }
     

    public function cadastrar(Amostra $amostra)
    {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();
            
            $this->validarQuantidade($amostra, $objExcecao);
            $this->validarObservacoes($amostra, $objExcecao);
            $this->dataHoraInicio($amostra, $objExcecao);
            $this->dataHoraFim($amostra, $objExcecao);
            
            
            $objExcecao->lancar_validacoes();
            
            $objAmostraBD = new AmostraBD();
            $objAmostraBD->cadastrar($amostra);
            
            $objBanco->fecharConexao();
        } catch (\Exeception $e) {
            throw new Excecao('Erro cadastrando amostra.', $e);
        }
    }

    public function alterar(Amostra $amostra)
    {
        try {
            $objExcecao = new Excecao();
            $this->validarEmail($amostra, $objExcecao);
            $this->validarMatricula($amostra, $objExcecao);

            $objExcecao->lancar_validacoes();
            $objAmostraBD = new AmostraBD();
            $objAmostraBD->alterar($amostra);
        } catch (\Exeception $e) {
            throw new \Exeception('Erro alterando amostra.', null, $e);
        }
    }

    public function consultar(Amostra $amostra)
    {
        try {
            $objAmostraBD = new AmostraBD();
            return $objAmostraBD->consultar($amostra);
        } catch (\Exeception $e) {
            throw new \Exeception('Erro consultando amostra.', null, $e);
        }
    }

    public function remover(Amostra $amostra)
    {
        try {
            $objAmostraBD = new AmostraBD();
            return $objAmostraBD->remover($amostra);
        } catch (\Exeception $e) {
            throw new \Exeception('Erro removendo amostra.', null, $e);
        }
    }

    public function listar(Amostra $amostra)
    {
        try {
            $objAmostraBD = new AmostraBD();
            return $objAmostraBD->listar($amostra);
        } catch (\Exeception $e) {
            throw new \Exeception('Erro listando amostra.', null, $e);
        }
    }


    public function logar(Amostra $amostra)
    {
        try {
            $objAmostraBD = new AmostraBD();
            return $objAmostraBD->logar($amostra);
        } catch (\Exeception $e) {
            throw new \Exeception('Erro logando amostra.', null, $e);
        }
    }

    public function pesquisar($campoBD, $valor_usuario)
    {
        try {
            $objAmostraBD = new AmostraBD();
            return $objAmostraBD->pesquisar($campoBD, $valor_usuario);
        } catch (\Exeception $e) {
            throw new \Exeception('Erro pesquisando amostra.', null, $e);
        }
    }
}
