<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Equipamento/Equipamento.php';
require_once '../classes/Equipamento/EquipamentoRN.php';

$objEquipamento = new Equipamento();
$objEquipamentoRN = new EquipamentoRN();
try{

    $objEquipamento->setIdEquipamento($_GET['idEquipamento']);
    $objEquipamentoRN->remover($objEquipamento);

    header('Location: '. Sessao::getInstance()->assinar_link('controlador.php?action=listar_equipamento'));
    die();
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

?>
