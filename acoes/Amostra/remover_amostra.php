<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
    session_start();
    require_once '../classes/Sessao/Sessao.php';
    require_once '../classes/Pagina/Pagina.php';
    require_once '../classes/Excecao/Excecao.php';
    require_once '../classes/Amostra/Amostra.php';
    require_once '../classes/Amostra/AmostraRN.php';
    
       
   
    try{
        Sessao::getInstance()->validar();
        $objAmostra = new Amostra();
        $objAmostraRN = new AmostraRN();
        
        $objAmostra->setIdAmostra($_GET['idAmostra']);
        $objAmostraRN->remover($objAmostra);

        header('Location: '. Sessao::getInstance()->assinar_link('controlador.php?action=listar_amostra'));
        die();
    } catch (Exception $ex) {
        Pagina::getInstance()->processar_excecao($ex);
    }

