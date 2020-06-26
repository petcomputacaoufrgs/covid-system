<?php
try {
    session_start();

    require_once '../vendor/autoload.php';
    require_once __DIR__ . '/../../classes/Lote/Lote.php';
    require_once __DIR__ . '/../../classes/Lote/LoteRN.php';

    require_once __DIR__ . '/../../classes/PreparoLote/PreparoLote.php';
    require_once __DIR__ . '/../../classes/PreparoLote/PreparoLoteRN.php';

    require_once __DIR__ . '/../../classes/Rel_perfil_preparoLote/Rel_perfil_preparoLote.php';
    require_once __DIR__ . '/../../classes/Rel_perfil_preparoLote/Rel_perfil_preparoLote_RN.php';

    require_once __DIR__ . '/../../classes/Rel_tubo_lote/Rel_tubo_lote.php';
    require_once __DIR__ . '/../../classes/Rel_tubo_lote/Rel_tubo_lote_RN.php';

    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPaciente.php';
    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPacienteRN.php';

    $objPreparoLote = new PreparoLote();
    $objPreparoLoteRN = new PreparoLoteRN();

    if (isset($_GET['idPreparoLote'])){
        $objPreparoLote->setIdPreparoLote($_GET['idPreparoLote']);
        $objPreparoLote = $objPreparoLoteRN->consultar($objPreparoLote);
        $objPreparoLote = $objPreparoLoteRN->consultar_tubos($objPreparoLote);
        //print_r($objPreparoLote);
    }

    //ob_clean();//Limpa o buffer de saída
    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [190, 236]]);

    $html = "   
            <table>
                           
                    <tr>
                        <td><img src=\"../public_html/img/logoICBS.png\"  style=\"width:100px;  \" /> </td>
                        <td><h1> GRUPO DE AMOSTRAS " . $objPreparoLote[0]->getIdPreparoLote() . " </h1></td>
                    </tr>
            </table>";

    if($objPreparoLote[0]->getObjsTubos()[0]->getObjLote() == LoteRN::$TE_PREPARACAO_FINALIZADA || $objPreparoLote[0]->getObjsTubos()[0]->getObjLote() == LoteRN::$TE_EXTRACAO_FINALIZADA){
        $style = ' style="background: rgba(0,255,0,0.2);text-align: center;"' ;
    }
    if($objPreparoLote[0]->getObjsTubos()[0]->getObjLote()== LoteRN::$TE_TRANSPORTE_PREPARACAO || $objPreparoLote[0]->getObjsTubos()[0]->getObjLote() == LoteRN::$TE_AGUARDANDO_EXTRACAO){
        $style = ' style="background:rgba(255,0,0,0.2);text-align: center;"' ;
    }
    if($objPreparoLote[0]->getObjsTubos()[0]->getObjLote()== LoteRN::$TE_EM_PREPARACAO || $objPreparoLote[0]->getObjsTubos()[0]->getObjLote() == LoteRN::$TE_EM_EXTRACAO){
        $style = ' style="background: rgba(243,108,41,0.2);text-align: center;"' ;
    }

    $html .= " <table> 
              <tr><td '.$style.'>SITUAÇÃO GRUPO: ".LoteRN::mostrarDescricaoSituacao($objPreparoLote[0]->getObjsTubos()[0]->getObjLote())."</td></tr>
              <tr>
                   <td>Quantidade de amostras no grupo: " . count($objPreparoLote[0]->getObjsTubos()) . "</td>
              </tr>
               <tr><td><hr width=\"1\"  height=\"100\"></td></tr>";

    foreach ($objPreparoLote[0]->getObjsTubos() as $amostra) {

        $data = explode("-",$amostra->getDataColeta());
        $dia = $data[2];
        $mes = $data[1];
        $ano = $data[0];

        $html .= "<tr> <td style=\"background-color: #ddd;\"> Amostra ".$amostra->getCodigoAmostra()."  </td></tr>"
            . "<tr> <td>Data Coleta: " .$dia.'/'.$mes.'/'.$ano . "</td></tr>" .
            "<tr><td> Perfil da amostra: " . PerfilPacienteRN::retornarTipoPaciente($amostra->getObjPaciente()->getCaractere()) . "</td></tr>" .
            "<tr><td><hr width=\"1\"  height=\"100\"></td></tr>";

    }
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
        
        tr,td{
            /*border: 1px solid blue;*/
        }
";

    $data = date("Y/m/d");
    $DATAAUX = explode("/", $data);

    $dia = $DATAAUX[0];
    $mes = $DATAAUX[1];
    $ano = $DATAAUX[2];

    $output = 'grupoAmostras_' . $dia . '_' . $mes . '_' . $ano;
//echo $output;

    $mpdf->WriteHTML($css, 1);
    $mpdf->WriteHTML($html);
    //$mpdf->Output($output);
    $mpdf->Output($output . '.pdf', I);
}catch(Throwable $e){
    die($e);
}



