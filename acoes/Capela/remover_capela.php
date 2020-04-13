<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
    session_start();
    require_once '../classes/Sessao/Sessao.php';
    require_once '../classes/Pagina/Pagina.php';
    require_once '../classes/Excecao/Excecao.php';
    require_once '../classes/Capela/Capela.php';
    require_once '../classes/Capela/CapelaRN.php';
    
  
    $objCapela = new Capela();
    $objCapelaRN = new CapelaRN();
    try{
        
        $objCapela->setIdCapela($_GET['idCapela']);
        $objCapelaRN->remover($objCapela);

        header('Location: '. Sessao::getInstance()->assinar_link('controlador.php?action=listar_capela'));
        die();
    } catch (Exception $ex) {
        Pagina::getInstance()->processar_excecao($ex);
    }

