<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Doenca/Doenca.php';
require_once '../classes/Doenca/DoencaRN.php';

$objDoenca = new Doenca();
$objDoencaRN = new DoencaRN();
try{


    $objDoenca->setIdDoenca($_GET['idDoenca']);
    $objDoencaRN->remover($objDoenca);

    header('Location: '. Sessao::getInstance()->assinar_link('controlador.php?action=listar_doenca'));
    die();
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


