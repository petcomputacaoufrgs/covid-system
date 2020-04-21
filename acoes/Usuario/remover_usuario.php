<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Usuario/Usuario.php';
require_once '../classes/Usuario/UsuarioRN.php';


try{
    Sessao::getInstance()->validar();
    $objUsuario = new Usuario();
    $objUsuarioRN = new UsuarioRN();

    $objUsuario->setIdUsuario($_GET['idUsuario']);
    $objUsuarioRN->remover($objUsuario);

    header('Location:'. Sessao::getInstance()->assinar_link('controlador.php?action=listar_usuario'));
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}
