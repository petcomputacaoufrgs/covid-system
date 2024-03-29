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
        $objAmostra = $objAmostraRN->consultar($objAmostra);

        if($objAmostra->getIdCodGAL_fk() != null){
            $objCodigoGAL = new CodigoGAL();
            $objCodigoGALRN = new CodigoGALRN();
            $objCodigoGAL->setIdCodigoGAL($objAmostra->getIdCodGAL_fk());

            $objCodigoGALRN->remover($objCodigoGAL);
        }



        $objTubo = new Tubo();
        $objTuboRN = new TuboRN();
        $objTubo->setIdAmostra_fk($_GET['idAmostra']);
        $arr_tubos = $objTuboRN->listar($objTubo);


        if(count($arr_tubos) > 0) {

            $objInfosTubo = new InfosTubo();
            $objInfosTuboRN = new InfosTuboRN();

            foreach ($arr_tubos as $tubo) {
                $objInfosTubo->setIdTubo_fk($tubo->getIdTubo());
                $arr_infosTubo = $objInfosTuboRN->listar($objInfosTubo);
                $objTuboRN->remover($tubo);
            }

            foreach ($arr_infosTubo as $infoTubo) {
                $objInfosTuboRN->remover($infoTubo);
            }
        }

        $objAmostraRN->remover($objAmostra);

        header('Location: '. Sessao::getInstance()->assinar_link('controlador.php?action=listar_amostra'));
        die();
    } catch (Exception $ex) {
        Pagina::getInstance()->processar_excecao($ex);
    }

