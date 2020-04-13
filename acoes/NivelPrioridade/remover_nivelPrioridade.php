<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
require_once '../classes/Sessao/Sessao.php';
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/NivelPrioridade/NivelPrioridade.php';
require_once 'classes/NivelPrioridade/NivelPrioridadeRN.php';

$objNivelPrioridade = new NivelPrioridade();
$objNivelPrioridadeRN = new NivelPrioridadeRN();
try{
    $objNivelPrioridade->setIdNivelPrioridade($_GET['idNivelPrioridade']);
    $objNivelPrioridadeRN->remover($objNivelPrioridade);

    header('Location:'. Sessao::getInstance()->assinar_link('controlador.php?action=listar_nivelPrioridade'));
    die();
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


?>
