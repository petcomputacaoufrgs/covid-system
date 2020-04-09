<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
    require_once 'classes/Pagina/Pagina.php';
    require_once 'classes/Excecao/Excecao.php';
    require_once 'classes/PerfilPaciente/PerfilPaciente.php';
    require_once 'classes/PerfilPaciente/PerfilPacienteRN.php';
    
    $objPagina = new Pagina();
    $objPerfilPaciente = new PerfilPaciente();
    $objPerfilPacienteRN = new PerfilPacienteRN();
    try{
        
        
        $objPerfilPaciente->setIdPerfilPaciente($_GET['idPerfilPaciente']);
        $objPerfilPacienteRN->remover($objPerfilPaciente);

        header('Location: controlador.php?action=listar_perfilPaciente');
    } catch (Exception $ex) {
        $objPagina->processar_excecao($ex);
    }


?>
