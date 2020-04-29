<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
try{
    require_once  __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once  __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once  __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once  __DIR__ . '/../../classes/Marca/Marca.php';
    require_once  __DIR__ . '/../../classes/Marca/MarcaRN.php';
    require_once  __DIR__ . '/../../classes/Equipamento/Equipamento.php';
    require_once  __DIR__ . '/../../classes/Equipamento/EquipamentoRN.php';

    Sessao::getInstance()->validar();

    $objMarca = new Marca();
    $objMarcaRN = new MarcaRN();

    $objEquipamento = new Equipamento();
    $objEquipamentoRN = new EquipamentoRN();


    $objMarca->setIdMarca($_GET['idMarca']);

    $objEquipamento->setIdMarca_fk($_GET['idMarca']);
    $arr_equi = $objEquipamentoRN->listar($objEquipamento);


    if(count($arr_equi) == 0){ //nenhum equipamento associado aquela marca
        $objMarcaRN->remover($objMarca);
    }

    header('Location:'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_marca'));
    die();


} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}
