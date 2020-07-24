<?php
try {
    session_start();
    //require_once __DIR__.'/../../vendor/autoload.php';
    require_once __DIR__.'/../../vendor/mpdf60/mpdf.php';
    //require_once __DIR__.'/../../vendor/fpdf/fpdf.php';
    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../utils/Utils.php';

    require_once __DIR__.'/../../classes/Laudo/Laudo.php';
    require_once __DIR__.'/../../classes/Laudo/LaudoRN.php';

    require_once __DIR__.'/../../classes/PerfilPaciente/PerfilPaciente.php';
    require_once __DIR__.'/../../classes/PerfilPaciente/PerfilPacienteRN.php';

    require_once __DIR__.'/../../classes/LaudoProtocolo/LaudoProtocolo.php';
    require_once __DIR__.'/../../classes/LaudoProtocolo/LaudoProtocoloRN.php';

    require_once __DIR__.'/../../classes/LaudoKitExtracao/LaudoKitExtracao.php';
    require_once __DIR__.'/../../classes/LaudoKitExtracao/LaudoKitExtracaoRN.php';

    require_once __DIR__.'/../../classes/Protocolo/Protocolo.php';
    require_once __DIR__.'/../../classes/Protocolo/ProtocoloRN.php';

    require_once __DIR__.'/../../classes/KitExtracao/KitExtracao.php';
    require_once __DIR__.'/../../classes/KitExtracao/KitExtracaoRN.php';

    $utils = new Utils();
    Sessao::getInstance()->validar();
    date_default_timezone_set('America/Sao_Paulo');


    $mpdf = new mPDF(['mode' => 'utf-8', 'format' => [190, 236]]);
    //$pdf= new FPDF("P","pt","A4");
    //$pdf->AddPage();
    //$pdf->SetFont('Arial','',12);

    $objLaudo = new Laudo();
    $objLaudoRN = new LaudoRN();

    $objLaudo->setIdLaudo($_GET['idLaudo']);
    $arr_laudo = $objLaudoRN->listar($objLaudo);
    $objLaudo = $arr_laudo[0];

    //print_r($objLaudo);
    $objAmostra = $objLaudo->getObjAmostra();
    $objPerfilPaciente = $objAmostra->getObjPerfil();
    $objPaciente = $objAmostra->getObjPaciente();
    if(!is_null($objPaciente->getObjCodGAL())) {
        $objCodGal = $objPaciente->getObjCodGAL();
    }
    $objUsuario = $objLaudo->getObjUsuario();

    ///print_r($objUsuario);
    //die();


    $html = "   
            <table>
                           
                    <tr>
                        <td><img src=\"../public_html/img/logoICBS.png\"  style=\"width:100px;  \" /> </td>
                        <td><h1> LAUDO " . $_GET['idLaudo'] . " </h1></td>
                    </tr>
            </table>";



    if($objLaudo->getSituacao() == LaudoRN::$SL_PENDENTE){
        $background = 'style="margin-bottom: 10px;background-color: rgba(255,255,0,0.2);"';
    }
    if($objLaudo->getSituacao() == LaudoRN::$SL_CONCLUIDO){
        $background = 'style="margin-bottom: 10px;background-color: rgba(0,255,0,0.2);"';
    }


    $html .= " <table class=\"tabela\"> 
             
             <tr ".$background."><td colspan='2' style=\"text-align: center;\"> LAUDO ".LaudoRN::mostrarDescricaoStaLaudo($objLaudo->getSituacao()) ." </td></tr>
            <tr> <td> Nome paciente: </td><td>".$objPaciente->getNome()  ."</td></tr>";
    $html .= " <tr> <td> Código GAL: </td>";

    if(!is_null($objCodGal) && !is_null($objCodGal->getCodigo())) {
        $html .= "<td>" . $objCodGal->getCodigo() . "</td>";
    }else{
        $html .= "<td> - </td>";
    }
    $html .= "</tr>";
    $html .= "<tr> <td> Código Amostra: </td><td>".$objAmostra->getNickname()  ."</td></tr>
            <tr><td> Data Coleta: </td><td>" . Utils::getStrData($objAmostra->getDataColeta()) . "</td></tr>
            <tr><td> Perfil da amostra: </td><td>" . $objPerfilPaciente->getPerfil(). "</td></tr>";
    if(!is_null($objUsuario->getCPF())) {
        $html .= "        <tr><td> Profissional da Saúde: </td><td>" . $objUsuario->getCPF() . "</td></tr>";
    }else {
        $html .= "        <tr><td> Profissional da Saúde: </td><td>" . $objUsuario->getMatricula() . "</td></tr>";
    }

    /*if(!is_null($objLaudo->getArrProtocolos()) && count($objLaudo->getArrProtocolos()) > 0){
        $html.=" <tr><td colspan='2' style='background-color: #dee2e6'> Protocolos Utilizados: </td></tr>";
        //print_r($objLaudo->getArrProtocolos());
        //die();
        foreach ($objLaudo->getArrProtocolos() as $laudoProtocolo){
            $html.=" <tr><td colspan='2' > - ".$laudoProtocolo->getObjProtocolo()->getProtocolo()."</td></tr>";

        }

    }*/

    if(!is_null($objLaudo->getArrKitsExtracao()) && count($objLaudo->getArrProtocolos()) > 0){
        $html.=" <tr><td colspan='2' style='background-color: #dee2e6'> Kits de extração Utilizados: </td></tr>";
        foreach ($objLaudo->getArrKitsExtracao() as $kitExtracao){
            $html.=" <tr><td colspan='2' > - ".$kitExtracao->getObjKitExtracao()->getNome()."</td></tr>";

        }

    }
    if($objLaudo->getDataHoraGeracao() != null) {
        $html.=" <tr><td> Data/Hora de geração do laudo: </td><td>" . Utils::converterDataHora($objLaudo->getDataHoraGeracao()). "</td></tr>";
    }

    if($objLaudo->getDataHoraLiberacao() != null) {
        $html.=" <tr><td> Data/Hora de liberação do laudo: </td><td>" . Utils::converterDataHora( $objLaudo->getDataHoraLiberacao()) . "</td></tr>";
    }

    $html.=" <tr  style=\"background-color: rgba(255,0,0,0.3);\"><td colspan='2' > Resultado: " . LaudoRN::mostrarDescricaoResultado($objLaudo->getResultado()) . "</td></tr>";
    $html.=" <tr><td colspan='2' > Motivo: " . $objAmostra->getMotivoExame() . "</td></tr>";
    $html.=" <tr><td colspan='2' > Observações: " . $objLaudo->getObservacoes() . "</td></tr>";



    $html .= " </table>";


    $css = "
	body,html{
		color:black;
		font-size:12px;
	}
	table{
            width:100%;
            /*border: 1px solid red;*/
	}
	
	.tabela tr{
	    border: 1px solid #DDD;
	}
	.tabela td{
	    border: 1px solid #DDD;
	}
        
        tr,td{
            /*border: 1px solid #DDD;*/
        }
";


    $output = 'laudo_'.$objPaciente->getNome()."_emitido_" . Utils::converterDataHora(date("Y-m-d h:i:s"));

    $mpdf->WriteHTML($css, 1);
    $mpdf->WriteHTML($html);
    $mpdf->Output($output . '.pdf', 'D');
}catch(Throwable $e){
    die($e);
}
?>


