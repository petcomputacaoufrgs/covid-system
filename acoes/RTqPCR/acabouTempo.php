<?php

session_start();
header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: application/json; charset=utf-8');
try {
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once  __DIR__.'/../../utils/Utils.php';

    require_once __DIR__ . '/../../classes/Placa/Placa.php';
    require_once __DIR__ . '/../../classes/Placa/PlacaRN.php';

    require_once __DIR__ . '/../../classes/RTqPCR/RTqPCR.php';
    require_once __DIR__ . '/../../classes/RTqPCR/RTqPCR_RN.php';

    require_once __DIR__ . '/../../classes/InfosTubo/InfosTubo.php';
    require_once __DIR__ . '/../../classes/InfosTubo/InfosTuboRN.php';

    require_once __DIR__ . '/../../classes/RelTuboPlaca/RelTuboPlaca.php';
    require_once __DIR__ . '/../../classes/RelTuboPlaca/RelTuboPlacaRN.php';

    require_once __DIR__ . '/../../classes/Tubo/Tubo.php';
    require_once __DIR__ . '/../../classes/Tubo/TuboRN.php';

    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPaciente.php';
    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPacienteRN.php';

    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTexto.php';
    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTextoRN.php';

    require_once __DIR__ . '/../../classes/RelPerfilPlaca/RelPerfilPlaca.php';
    require_once __DIR__ . '/../../classes/RelPerfilPlaca/RelPerfilPlacaRN.php';

    require_once __DIR__ . '/../../classes/Equipamento/EquipamentoRN.php';
    require_once __DIR__ . '/../../classes/Equipamento/Equipamento.php';



    Sessao::getInstance()->validar();

    /*
     * RTqPCR
     */
    $objRTqPcr = new RTqPCR();
    $objRTqPcrRN = new RTqPCR_RN();

    /*
     * INFOS TUBO
     */
    $objInfosTubo = new InfosTubo();
    $objInfosTuboRN = new InfosTuboRN();

    /*
     * PLACA
     */
    $objPlaca = new Placa();
    $objPlacaRN = new PlacaRN();
    date_default_timezone_set('America/Sao_Paulo');

    $arr = $objRTqPcrRN->paginacao($objRTqPcr);
    foreach ($arr as $rtqpcr) {
        if ($rtqpcr->getSituacaoRTqPCR() == RTqPCR_RN::$STA_ATRASADO) {
            $arrBool = array(1);
        } else {
            $data = Utils::getData($rtqpcr->getDataHoraInicio()).' '.$rtqpcr->getHoraFinal();
            //$arrFrase[] = date("Y-m-d H:i:s");
            //$arrFrase[] = $data;
            //$arrFrase[] = Utils::compararDataHora(date("Y-m-d H:i:s"),$data);
            if (Utils::compararDataHora(date("Y-m-d H:i:s"),$data) < 0) {
                $arrFrase[] = Utils::compararDataHora(date("Y-m-d H:i:s"),$data);
                $arrResult[] = $rtqpcr->getIdRTqPCR();
                $rtqpcr->setSituacaoRTqPCR(RTqPCR_RN::$STA_ATRASADO);

                $objPlaca = $rtqpcr->getObjPlaca();
                $objPlaca->setSituacaoPlaca(PlacaRN::$STA_ATRASO_RTqPCR);

                foreach ($objPlaca->getObjsTubos() as $objRelTuboPlaca) {
                    foreach ($objRelTuboPlaca->getObjTubo() as $amostra) {
                        $tam = count($amostra->getObjTubo()->getObjInfosTubo());
                        $objInfosTubo = $amostra->getObjTubo()->getObjInfosTubo()[$tam - 1];

                        $objInfosTubo->setIdInfosTubo(null);
                        $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                        $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                        $objInfosTubo->setObsProblema(null);
                        $objInfosTubo->setObservacoes(null);
                        $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_ATRASADO_RTqCPR);
                        $arr_infos[] = $objInfosTubo;

                    }
                }

                $objPlaca->setObjsTubos($arr_infos);
                $rtqpcr->setObjPlaca($objPlaca);
                $objRTqPcrRN->alterar($rtqpcr);
                $arrBool = array(2);
            }
        }
    }

    /*if(count($arrBool) > 0 ){
        $arrBool = array(1);
    }*/
    //$arrBool = array(1,2,3);
    echo json_encode($arrFrase);

}catch (Throwable $e){
    die($e);
}

