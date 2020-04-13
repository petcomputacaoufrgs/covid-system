<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Modelo/Modelo.php';
require_once '../classes/Modelo/ModeloRN.php';


$objModelo = new Modelo();
$objModeloRN = new ModeloRN();
try{

    $objModelo->setIdModelo($_GET['idModelo']);
    $objModeloRN->remover($objModelo);

    header('Location:'. Sessao::getInstance()->assinar_link('controlador.php?action=listar_modelo'));
    die();
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

