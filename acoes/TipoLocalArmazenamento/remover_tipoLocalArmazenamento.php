<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
    require_once 'classes/Pagina/Pagina.php';
    require_once 'classes/Excecao/Excecao.php';
    require_once 'classes/TipoLocalArmazenamento/TipoLocalArmazenamento.php';
    require_once 'classes/TipoLocalArmazenamento/TipoLocalArmazenamentoRN.php';
    
    $objPagina = new Pagina();
    $objTipoLocalArmazenamento = new TipoLocalArmazenamento();
    $objTipoLocalArmazenamentoRN = new TipoLocalArmazenamentoRN();
    try{
        
        
        $objTipoLocalArmazenamento->setIdTipoLocalArmazenamento($_GET['idTipoLocalArmazenamento']);
        $objTipoLocalArmazenamentoRN->remover($objTipoLocalArmazenamento);

        header('Location: controlador.php?action=listar_tipoLocalArmazenamento');
    } catch (Exception $ex) {
        $objPagina->processar_excecao($ex);
    }


?>
