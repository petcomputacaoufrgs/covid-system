<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{
    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';
    require_once __DIR__.'/../../classes/TipoLocalArmazenamento/TipoLocalArmazenamento.php';
    require_once __DIR__.'/../../classes/TipoLocalArmazenamento/TipoLocalArmazenamentoRN.php';


    $objTipoLocalArmazenamento = new TipoLocalArmazenamento();
    $objTipoLocalArmazenamentoRN = new TipoLocalArmazenamentoRN();

    $objTipoLocalArmazenamento->setIdTipoLocalArmazenamento($_GET['idTipoLocalArmazenamento']);
    $objTipoLocalArmazenamentoRN->remover($objTipoLocalArmazenamento);

    header('Location: '. Sessao::getInstance()->assinar_link('controlador.php?action=listar_tipoLocalArmazenamento'));
    die();
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


?>
