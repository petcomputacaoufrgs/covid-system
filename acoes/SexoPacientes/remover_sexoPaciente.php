<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
/*

    NÃO ESTÁ SENDO UTILIZADO MAIS


session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Sexo/Sexo.php';
require_once '../classes/Sexo/SexoRN.php';

$objPagina = new Pagina();
$objSexo = new Sexo();
$objSexoRN = new SexoRN();
try{


    $objSexo->setIdSexo($_GET['idSexoPaciente']);
    $objSexoRN->remover($objSexo);

    header('Location: controlador.php?action=listar_sexoPaciente');
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}


