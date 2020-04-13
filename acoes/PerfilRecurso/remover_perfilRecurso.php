<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Rel_perfilUsuario_recurso/Rel_perfilUsuario_recurso.php';
require_once '../classes/Rel_perfilUsuario_recurso/Rel_perfilUsuario_recurso_RN.php';

try{

    /* PERFIL USUÁRIO + RECURSO */
    $objRel_perfilUsuario_recurso = new Rel_perfilUsuario_recurso();
    $objRel_perfilUsuario_recurso_RN = new Rel_perfilUsuario_recurso_RN();


    $recursos_selecionados = explode(";",$_GET['idRecurso']);

    foreach ($recursos_selecionados as $r){
        $objRel_perfilUsuario_recurso->setIdRecurso_fk($r);
        $objRel_perfilUsuario_recurso->setIdPerfilUsuario_fk($_GET['idPerfilUsuario']);
        $objRel_perfilUsuario_recurso_RN->remover($objRel_perfilUsuario_recurso);
    }

    header('Location:'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_rel_perfilUsuario_recurso'));
    die();
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


