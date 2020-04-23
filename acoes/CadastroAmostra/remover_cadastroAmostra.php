<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
    session_start();
    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';
    require_once __DIR__.'/../../classes/Amostra/Amostra.php';
    require_once __DIR__.'/../../classes/Amostra/AmostraRN.php';

    require_once __DIR__.'/../../classes/Tubo/Tubo.php';
    require_once __DIR__.'/../../classes/Tubo/TuboRN.php';

    require_once __DIR__.'/../../classes/InfosTubo/InfosTubo.php';
    require_once __DIR__.'/../../classes/InfosTubo/InfosTuboRN.php';
   
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

