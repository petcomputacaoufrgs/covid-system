<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
    require_once 'classes/Pagina/Pagina.php';
    require_once 'classes/Excecao/Excecao.php';
    require_once 'classes/Marca/Marca.php';
    require_once 'classes/Marca/MarcaRN.php';
    
    $objPagina = new Pagina();
    $objMarca = new Marca();
    $objMarcaRN = new MarcaRN();
    try{
        
        $objMarca->setIdMarca($_GET['idMarca']);
        $objMarcaRN->remover($objMarca);

        header('Location: controlador.php?action=listar_marca');
    } catch (Exception $ex) {
        $objPagina->processar_excecao($ex);
    }

?>
