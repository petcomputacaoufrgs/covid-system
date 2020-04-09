<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
    require_once 'classes/Pagina/Pagina.php';
    require_once 'classes/Excecao/Excecao.php';
    require_once 'classes/Modelo/Modelo.php';
    require_once 'classes/Modelo/ModeloRN.php';
    
    $objPagina = new Pagina();
    $objModelo = new Modelo();
    $objModeloRN = new ModeloRN();
    try{
        
        $objModelo->setIdModelo($_GET['idModelo']);
        $objModeloRN->remover($objModelo);

        header('Location: controlador.php?action=listar_modelo');
    } catch (Exception $ex) {
        $objPagina->processar_excecao($ex);
    }

?>
