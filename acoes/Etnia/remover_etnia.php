<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Etnia/Etnia.php';
require_once '../classes/Etnia/EtniaRN.php';


try{
    Sessao::getInstance()->validar();
    $objPagina = new Pagina();
    $objEtnia = new Etnia();
    $objEtniaRN = new EtniaRN();
    $objEtnia->setIdEtnia($_GET['idEtnia']);
    $objEtniaRN->remover($objEtnia);

    header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_etnia'));
    die();
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>
