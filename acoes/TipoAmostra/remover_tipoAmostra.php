<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
    require_once 'classes/Pagina/Pagina.php';
    require_once 'classes/Excecao/Excecao.php';
    require_once 'classes/TipoAmostra/TipoAmostra.php';
    require_once 'classes/TipoAmostra/TipoAmostraRN.php';
    
    $objPagina = new Pagina();
    $objTipoAmostra = new TipoAmostra();
    $objTipoAmostraRN = new TipoAmostraRN();
    try{
        
        
        $objTipoAmostra->setIdTipoAmostra($_GET['idTipoAmostra']);
        $objTipoAmostraRN->remover($objTipoAmostra);

        header('Location: controlador.php?action=listar_tipoAmostra');
    } catch (Exception $ex) {
        $objPagina->processar_excecao($ex);
    }


?>
