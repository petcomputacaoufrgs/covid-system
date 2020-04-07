<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
    require_once 'classes/Pagina/Pagina.php';
    require_once 'classes/Excecao/Excecao.php';
    require_once 'classes/Usuario/Usuario.php';
    require_once 'classes/Usuario/UsuarioRN.php';
    
    $objPagina = new Pagina();
    $objUsuario = new Usuario();
    $objUsuarioRN = new UsuarioRN();
    try{
        
        
        $objUsuario->setIdUsuario($_GET['idUsuario']);
        $objUsuarioRN->remover($objUsuario);

        header('Location: controlador.php?action=listar_usuario');
    } catch (Exception $ex) {
        $objPagina->processar_excecao($ex);
    }


?>
