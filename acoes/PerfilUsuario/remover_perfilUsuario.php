<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
    require_once 'classes/Pagina/Pagina.php';
    require_once 'classes/Excecao/Excecao.php';
    require_once 'classes/PerfilUsuario/PerfilUsuario.php';
    require_once 'classes/PerfilUsuario/PerfilUsuarioRN.php';

    $objPagina = new Pagina();
    $objPerfilUsuario = new PerfilUsuario();
    $objPerfilUsuarioRN = new PerfilUsuarioRN();
    try{
        
        
        $objPerfilUsuario->setIdPerfilUsuario($_GET['idPerfilUsuario']);
        $objPerfilUsuarioRN->remover($objPerfilUsuario);

        header('Location: controlador.php?action=listar_perfilUsuario');
    } catch (Exception $ex) {
        $objPagina->processar_excecao($ex);
    }


?>
