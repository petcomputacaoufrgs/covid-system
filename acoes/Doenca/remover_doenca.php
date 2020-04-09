<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
    require_once 'classes/Pagina/Pagina.php';
    require_once 'classes/Excecao/Excecao.php';
    require_once 'classes/Doenca/Doenca.php';
    require_once 'classes/Doenca/DoencaRN.php';
    
    $objPagina = new Pagina();
    $objDoenca = new Doenca();
    $objDoencaRN = new DoencaRN();
    try{
        
        
        $objDoenca->setIdDoenca($_GET['idDoenca']);
        $objDoencaRN->remover($objDoenca);

        header('Location: controlador.php?action=listar_doenca');
    } catch (Exception $ex) {
        $objPagina->processar_excecao($ex);
    }


?>
