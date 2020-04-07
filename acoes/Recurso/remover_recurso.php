<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
    require_once 'classes/Pagina/Pagina.php';
    require_once 'classes/Excecao/Excecao.php';
    require_once 'classes/Recurso/Recurso.php';
    require_once 'classes/Recurso/RecursoRN.php';
    
    $objPagina = new Pagina();
    $objRecurso = new Recurso();
    $objRecursoRN = new RecursoRN();
    try{
        
        
        $objRecurso->setIdRecurso($_GET['idRecurso']);
        $objRecursoRN->remover($objRecurso);

        header('Location: controlador.php?action=listar_recurso');
    } catch (Exception $ex) {
        $objPagina->processar_excecao($ex);
    }

?>
