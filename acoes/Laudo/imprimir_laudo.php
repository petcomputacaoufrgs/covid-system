<?php
try {
    session_start();
    require_once __DIR__.'/../../vendor/autoload.php';
    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../utils/Utils.php';

    require_once __DIR__.'/../../classes/Laudo/Laudo.php';
    require_once __DIR__.'/../../classes/Laudo/LaudoRN.php';

    $utils = new Utils();
    Sessao::getInstance()->validar();
    date_default_timezone_set('America/Sao_Paulo');


    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [190, 236]]);

    $objLaudo = new Laudo();
    $objLaudoRN = new LaudoRN();

    $objLaudo->setIdLaudo($_GET['idLaudo']);
    $objLaudo = $objLaudoRN->laudo_completo($objLaudo);


    $html = "   
            <table>
                           
                    <tr>
                        <td><img src=\"../public_html/img/logoICBS.png\"  style=\"width:100px;  \" /> </td>
                        <td><h1> LAUDO " . $_GET['idLaudo'] . " </h1></td>
                    </tr>
            </table>";



    $dataColeta = explode("-",$objLaudo->getObjAmostra()->getDataColeta());

    $dia = $dataColeta[2];
    $mes = $dataColeta[1];
    $ano = $dataColeta[0];

    $dataGeracao = explode("-",$objLaudo->getObjAmostra()->getDataColeta());

    $dia = $dataColeta[2];
    $mes = $dataColeta[1];
    $ano = $dataColeta[0];

    if($objLaudo->getSituacao() == LaudoRN::$SL_PENDENTE){
        $background = 'style="margin-bottom: 10px;background-color: rgba(255,255,0,0.2);"';
    }
    if($objLaudo->getSituacao() == LaudoRN::$SL_CONCLUIDO){
        $background = 'style="margin-bottom: 10px;background-color: rgba(0,255,0,0.2);"';
    }



    $html .= " <table class=\"tabela\"> 
             
             <tr ".$background."><td colspan='2' style=\"text-align: center;\"> LAUDO ".LaudoRN::mostrarDescricaoStaLaudo($objLaudo->getSituacao()) ." </td></tr>
            <tr> <td> Nome paciente: </td><td>".$objLaudo->getObjAmostra()->getObjPaciente()->getNome()  ."</td></tr>
            <tr> <td> Código GAL: </td><td>".$objLaudo->getObjAmostra()->getObjPaciente()->getObjCodGAL()  ."</td></tr>
            <tr> <td> Código Amostra: </td><td>".$objLaudo->getObjAmostra()->getNickname()  ."</td></tr>
            <tr><td> Data Coleta: </td><td>" . $dia.'/'.$mes.'/'.$ano . "</td></tr>
            <tr><td> Perfil da amostra: </td><td>" . $objLaudo->getObjAmostra()->getObjPerfil() . "</td></tr>
            <tr><td> Usuário: </td><td>" . $objLaudo->getIdUsuarioFk() . "</td></tr>";

    if($objLaudo->getDataHoraGeracao() != null) {
        $liberacaoG = explode(" ",  $objLaudo->getDataHoraGeracao());
        $dataLiberacao = explode("-", $liberacaoG[0]);
        $diaG = $dataLiberacao[2];
        $mesG = $dataLiberacao[1];
        $anoG = $dataLiberacao[0];

        $html.=" <tr><td> Data/Hora de geração do laudo: </td><td>" . $diaG."/".$mesG."/".$anoG." - ".$liberacaoG[1] . "</td></tr>";
    }

    if($objLaudo->getDataHoraLiberacao() != null) {
        $liberacao = explode(" ", $objLaudo->getDataHoraLiberacao());
        $dataLiberacao = explode("-", $liberacao[0]);
        $diaL = $dataLiberacao[2];
        $mesL = $dataLiberacao[1];
        $anoL = $dataLiberacao[0];

        $html.=" <tr><td> Data/Hora de liberação do laudo: </td><td>" . $diaL."/".$mesL."/".$anoL." - ".$liberacao[1] . "</td></tr>";
    }

    $html.=" <tr  style=\"background-color: rgba(255,0,0,0.3);\"><td colspan='2' > Resultado: " . LaudoRN::mostrarDescricaoResultado($objLaudo->getResultado()) . "</td></tr>";



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

    $DATAAUX = explode("-", date("Y-m-d "));

    $dia = $DATAAUX[2];
    $mes = $DATAAUX[1];
    $ano = $DATAAUX[0];

    $output = 'laudo_paciente_'.$objLaudo->getObjAmostra()->getObjPaciente()->getNome()."_emitido_" . $dia . '_' . $mes . '_' . $ano;
//echo $output;

    $mpdf->WriteHTML($css, 1);
    $mpdf->WriteHTML($html);
    $mpdf->Output($output . '.pdf', I);
}catch(Throwable $e){
    die($e);
}
?>


