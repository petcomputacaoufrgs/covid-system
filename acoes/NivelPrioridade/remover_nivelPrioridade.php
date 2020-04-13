<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
    require_once 'classes/Pagina/Pagina.php';
    require_once 'classes/Excecao/Excecao.php';
    require_once 'classes/NivelPrioridade/NivelPrioridade.php';
    require_once 'classes/NivelPrioridade/NivelPrioridadeRN.php';
    
    $objPagina = new Pagina();
    $objNivelPrioridade = new NivelPrioridade();
    $objNivelPrioridadeRN = new NivelPrioridadeRN();
    try{
        
        
        $objNivelPrioridade->setIdNivelPrioridade($_GET['idNivelPrioridade']);
        $objNivelPrioridadeRN->remover($objNivelPrioridade);

        header('Location: controlador.php?action=listar_nivelPrioridade');
    } catch (Exception $ex) {
        $objPagina->processar_excecao($ex);
    }


?>
