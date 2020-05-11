<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
try{

    require_once __DIR__. '/../../classes/Sessao/Sessao.php';
    require_once __DIR__. '/../../classes/Pagina/Pagina.php';
    require_once __DIR__. '/../../classes/Excecao/Excecao.php';
    require_once __DIR__. '/../../classes/KitExtracao/KitExtracao.php';
    require_once __DIR__. '/../../classes/KitExtracao/KitExtracaoRN.php';
    require_once __DIR__. '/../../utils/Utils.php';
    require_once __DIR__. '/../../utils/Alert.php';

    Sessao::getInstance()->validar();

    $objKitExtracao = new KitExtracao();
    $objKitExtracaoRN = new KitExtracaoRN();


    $objKitExtracao->setIdKitExtracao($_GET['idKitExtracao']);
    $objKitExtracaoRN->remover($objKitExtracao);

    header('Location: '. Sessao::getInstance()->assinar_link('controlador.php?action=listar_kitExtracao'));
    die();
} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}
