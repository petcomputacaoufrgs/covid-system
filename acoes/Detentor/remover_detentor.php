<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
try{
    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';
    require_once __DIR__.'/../../classes/Detentor/Detentor.php';
    require_once __DIR__.'/../../classes/Detentor/DetentorRN.php';

    Sessao::getInstance()->validar();

    $objDetentor = new Detentor();
    $objDetentorRN = new DetentorRN();


    $objDetentor->setIdDetentor($_GET['idDetentor']);
    $objDetentorRN->remover($objDetentor);

    header('Location: '. Sessao::getInstance()->assinar_link('controlador.php?action=listar_detentor'));
    die();
} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}
