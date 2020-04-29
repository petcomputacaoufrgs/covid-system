<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do preparo do lote
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/PreparoLoteBD.php';

class PreparoLoteRN
{

    public function cadastrar(PreparoLote $preparoLote)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            if($preparoLote->getObjLote() != null){
                if($preparoLote->getObjLote()->getIdLote_fk() == null){ //cadastrar lote
                    $objLote =$preparoLote->getObjLote();
                    $objLoteRN = new LoteRN();
                    $objLoteRN->cadastrar($objLote);

                }else{ //alterar lote

                }
                $preparoLote->setObjLote($objLote);
                $preparoLote->setIdLote_fk($objLote->getIdLote_fk());
            }


            $objExcecao->lancar_validacoes();
            $objPreparoLoteBD = new PreparoLoteBD();
            $objPreparoLoteBD->cadastrar($preparoLote, $objBanco);




            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $preparoLote;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o perfil do preparo do lote.', $e);
        }
    }

    public function alterar(PreparoLote $preparoLote)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();


            $objExcecao->lancar_validacoes();
            $objPreparoLoteBD = new PreparoLoteBD();
            $objPreparoLoteBD->alterar($preparoLote, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $preparoLote;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o perfil do preparo do lote.', $e);
        }
    }

    public function consultar(PreparoLote $preparoLote)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objPreparoLoteBD = new PreparoLoteBD();
            $arr = $objPreparoLoteBD->consultar($preparoLote, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o perfil do preparo do lote.', $e);
        }
    }

    public function remover(PreparoLote $preparoLote)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objPreparoLoteBD = new PreparoLoteBD();
            $arr = $objPreparoLoteBD->remover($preparoLote, $objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o perfil do preparo do lote.', $e);
        }
    }

    public function listar(PreparoLote $preparoLote)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objPreparoLoteBD = new PreparoLoteBD();

            $arr = $objPreparoLoteBD->listar($preparoLote, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o perfil do preparo do lote.', $e);
        }
    }

}