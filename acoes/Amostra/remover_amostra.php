<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
    require_once 'classes/Pagina/Pagina.php';
    require_once 'classes/Excecao/Excecao.php';
    require_once 'classes/Amostra/Amostra.php';
    require_once 'classes/Amostra/AmostraRN.php';
    
    $objPagina = new Pagina();
    $objAmostra = new Amostra();
    $objAmostraRN = new AmostraRN();
    try{
        
        $objAmostra->setIdAmostra($_GET['idAmostra']);
        $objAmostraRN->remover($objAmostra);

        header('Location: controlador.php?action=listar_amostra');
    } catch (Exception $ex) {
        $objPagina->processar_excecao($ex);
    }

?>
