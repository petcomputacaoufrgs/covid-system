<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Marca/Marca.php';
require_once '../classes/Marca/MarcaRN.php';

$objMarca = new Marca();
$objMarcaRN = new MarcaRN();
try{

    $objMarca->setIdMarca($_GET['idMarca']);
    $objMarcaRN->remover($objMarca);

    header('Location:'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_marca'));
    die();
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

?>
