<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
    require_once 'classes/Pagina/Pagina.php';
    require_once 'classes/Excecao/Excecao.php';
    require_once 'classes/Detentor/Detentor.php';
    require_once 'classes/Detentor/DetentorRN.php';
    
    $objPagina = new Pagina();
    $objDetentor = new Detentor();
    $objDetentorRN = new DetentorRN();
    try{
        
        $objDetentor->setIdDetentor($_GET['idDetentor']);
        $objDetentorRN->remover($objDetentor);

        header('Location: controlador.php?action=listar_detentor');
    } catch (Exception $ex) {
        $objPagina->processar_excecao($ex);
    }

?>
