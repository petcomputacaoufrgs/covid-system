<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/RelPerfilPlacaBD.php';

class RelPerfilPlacaRN
{
    public function cadastrar(RelPerfilPlaca $objRelPerfilPlaca){
        $objBanco = new Banco();
        try{

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            //print_r($objRelPerfilPlaca);

            $objExcecao->lancar_validacoes();
            $objRelPerfilPlacaBD = new RelPerfilPlacaBD();
            $objRelPerfilPlaca = $objRelPerfilPlacaBD->cadastrar($objRelPerfilPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objRelPerfilPlaca;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro no cadastramento do relacionamento dos perfis com uma placa.', $e);
        }
    }

    public function alterar(RelPerfilPlaca $objRelPerfilPlaca) {
        $objBanco = new Banco();
        try{

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();


            $objExcecao->lancar_validacoes();
            $objRelPerfilPlacaBD = new RelPerfilPlacaBD();
            $objRelPerfilPlaca  = $objRelPerfilPlacaBD->alterar($objRelPerfilPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objRelPerfilPlaca;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na alteração do relacionamento dos perfis com uma placa.', $e);
        }
    }

    public function consultar(RelPerfilPlaca $objRelPerfilPlaca) {
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objRelPerfilPlacaBD = new RelPerfilPlacaBD();
            $arr =  $objRelPerfilPlacaBD->consultar($objRelPerfilPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na consulta do relacionamento dos perfis com uma placa.',$e);
        }
    }

    public function remover(RelPerfilPlaca $objRelPerfilPlaca) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objRelPerfilPlacaBD = new RelPerfilPlacaBD();

            $arr =  $objRelPerfilPlacaBD->remover($objRelPerfilPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;

        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na remoção do relacionamento dos perfis com uma placa.', $e);
        }
    }

    public function listar(RelPerfilPlaca $objRelPerfilPlaca) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objRelPerfilPlacaBD = new RelPerfilPlacaBD();

            $arr =  $objRelPerfilPlacaBD->listar($objRelPerfilPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na listagem do relacionamento dos perfis com uma placa.',$e);
        }
    }


}