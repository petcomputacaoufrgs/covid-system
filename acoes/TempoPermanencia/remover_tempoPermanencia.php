<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
    require_once 'classes/Pagina/Pagina.php';
    require_once 'classes/Excecao/Excecao.php';
    require_once 'classes/TempoPermanencia/TempoPermanencia.php';
    require_once 'classes/TempoPermanencia/TempoPermanenciaRN.php';
    
    $objPagina = new Pagina();
    $objTempoPermanencia = new TempoPermanencia();
    $objTempoPermanenciaRN = new TempoPermanenciaRN();
    try{
        
        $objTempoPermanencia->setIdTempoPermanencia($_GET['idTempoPermanencia']);
        $objTempoPermanenciaRN->remover($objTempoPermanencia);

        header('Location: controlador.php?action=listar_tempoPermanencia');
    } catch (Exception $ex) {
        $objPagina->processar_excecao($ex);
    }

?>
