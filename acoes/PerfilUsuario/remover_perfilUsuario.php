<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
/*

NÃO ESTÁ SENDO UTILIZADO

session_start();
try{
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once __DIR__ . '/../../classes/PerfilUsuario/PerfilUsuario.php';
    require_once __DIR__ . '/../../classes/PerfilUsuario/PerfilUsuarioRN.php';

    Sessao::getInstance()->validar();

    $objPerfilUsuario = new PerfilUsuario();
    $objPerfilUsuarioRN = new PerfilUsuarioRN();

    $objPerfilUsuario->setIdPerfilUsuario($_GET['idPerfilUsuario']);
    $objPerfilUsuarioRN->remover($objPerfilUsuario);

    header('Location: '.Sessao::getInstance()->assinar_link(' controlador.php?action=listar_perfilUsuario'));
} catch (Throwable $ex) {
        //$objExcecao = new Excecao();
    //$objExcecao->adicionar_validacao($ex);
    Pagina::getInstance()->processar_excecao($ex);
}



