<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
/*
session_start();
require_once __DIR__.'/../../classes/Sessao/Sessao.php';
require_once __DIR__.'/../../classes/Pagina/Pagina.php';
require_once __DIR__.'/../../classes/Excecao/Excecao.php';

require_once __DIR__ . '/../../classes/PreparoLote/PreparoLote.php';
require_once __DIR__ . '/../../classes/PreparoLote/PreparoLoteRN.php';

try{
    Sessao::getInstance()->validar();
    $objPreparoLote = new PreparoLote();
    $objPreparoLoteRN = new PreparoLoteRN();

    $objPreparoLote->setIdPreparoLote($_GET['idPreparoLote']);
    $objPreparoLoteRN->remover($objPreparoLote);
    header('Location: '. Sessao::getInstance()->assinar_link('controlador.php?action=listar_preparo_lote'));
    die();
} catch (Throwable $ex) {
    die($ex);
    Pagina::getInstance()->processar_excecao($ex);
}

