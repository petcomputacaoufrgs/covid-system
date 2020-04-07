<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
    require_once 'classes/Pagina/Pagina.php';
    require_once 'classes/Excecao/Excecao.php';
    require_once 'classes/Paciente/Paciente.php';
    require_once 'classes/Paciente/PacienteRN.php';
    
    $objPagina = new Pagina();
    $objPaciente = new Paciente();
    $objPacienteRN = new PacienteRN();
    try{
        
        $objPaciente->setIdPaciente($_GET['idPaciente']);
        $objPacienteRN->remover($objPaciente);

        header('Location: controlador.php?action=listar_paciente');
    } catch (Exception $ex) {
        $objPagina->processar_excecao($ex);
    }

?>
