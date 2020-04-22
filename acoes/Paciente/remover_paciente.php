<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Paciente/Paciente.php';
require_once '../classes/Paciente/PacienteRN.php';


try{
    Sessao::getInstance()->validar();
    
    $objPaciente = new Paciente();
    $objPacienteRN = new PacienteRN();
    
    $objPaciente->setIdPaciente($_GET['idPaciente']);
    $objPacienteRN->remover($objPaciente);

    header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_paciente'));
    die();
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


