<?php
try {
    session_start();

    require_once '../vendor/autoload.php';

    require_once __DIR__ . '/../../classes/Placa/Placa.php';
    require_once __DIR__ . '/../../classes/Placa/PlacaRN.php';

    require_once __DIR__ . '/../../classes/Amostra/Amostra.php';
    require_once __DIR__ . '/../../classes/Amostra/AmostraRN.php';

    require_once __DIR__ . '/../../classes/Tubo/Tubo.php';
    require_once __DIR__ . '/../../classes/Tubo/TuboRN.php';

    require_once __DIR__ . '/../../classes/InfosTubo/InfosTubo.php';
    require_once __DIR__ . '/../../classes/InfosTubo/InfosTuboRN.php';

    require_once __DIR__ . '/../../classes/Protocolo/Protocolo.php';
    require_once __DIR__ . '/../../classes/Protocolo/ProtocoloRN.php';

    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPaciente.php';
    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPacienteRN.php';

    require_once __DIR__ . '/../../classes/RelTuboPlaca/RelTuboPlaca.php';
    require_once __DIR__ . '/../../classes/RelTuboPlaca/RelTuboPlacaRN.php';

    require_once __DIR__ . '/../../classes/RelPerfilPlaca/RelPerfilPlaca.php';
    require_once __DIR__ . '/../../classes/RelPerfilPlaca/RelPerfilPlacaRN.php';

    require_once __DIR__ . '/../../classes/RelPocoPlaca/PocoPlaca.php';
    require_once __DIR__ . '/../../classes/RelPocoPlaca/PocoPlacaRN.php';

    require_once __DIR__ . '/../../classes/SolicitacaoMontarPlaca/SolicitacaoMontarPlaca.php';
    require_once __DIR__ . '/../../classes/SolicitacaoMontarPlaca/SolicitacaoMontarPlacaRN.php';

    /*
     * SOLICITAÇÃO DE MONTAGEM DA PLACA RTqPCR
     */
    $objSolMontarPlaca = new SolicitacaoMontarPlaca();
    $objSolMontarPlacaRN = new SolicitacaoMontarPlacaRN();

    /*
     * PLACA
     */
    $objPlaca = new Placa();
    $objPlacaRN = new PlacaRN();

    /*
     * POÇO + PLACA
     */
    $objPocoPlaca = new PocoPlaca();
    $objPocoPlacaRN = new PocoPlacaRN();

    if (isset($_GET['idSolicitacao'])){
        $objSolMontarPlaca->setIdSolicitacaoMontarPlaca($_GET['idSolicitacao']);
        $arr_solicitacoes = $objSolMontarPlacaRN->listar($objSolMontarPlaca);
    }

    $objSolMontarPlaca = $arr_solicitacoes[0];
    //echo "<pre>";
    //print_r($objSolMontarPlaca);
    //echo "</pre>";

    //ob_clean();//Limpa o buffer de saída
    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [190, 236]]);

    $html = "   
            <table>
                           
                    <tr>
                        <td><img src=\"../public_html/img/logoICBS.png\"  style=\"width:100px;  \" /> </td>
                        <td><h1> SOLICITAÇÃO DE MONTAGEM DE PLACA DE Nº " . $objSolMontarPlaca->getIdSolicitacaoMontarPlaca() . " </h1></td>
                    </tr>
            </table>";

    if($objSolMontarPlaca->getSituacaoSolicitacao() == SolicitacaoMontarPlacaRN::$TS_FINALIZADA ){
        $style = ' style="background: rgba(0,255,0,0.2);text-align: center;"' ;
    }
    if($objSolMontarPlaca->getSituacaoSolicitacao() == SolicitacaoMontarPlacaRN::$TS_EM_ANDAMENTO ){
        $style = ' style="background: rgba(243,108,41,0.2);text-align: center;"' ;
    }

    $html .= " <table> 
              <tr><td '.$style.'>SITUAÇÃO SOLICITAÇÃO: ".SolicitacaoMontarPlacaRN::mostrarDescricaoSituacaoSolicitacao($objSolMontarPlaca->getSituacaoSolicitacao())."</td></tr>
              <tr>
                   <td>Quantidade de amostras na placa: " . count($objSolMontarPlaca->getObjsAmostras()) . "</td>
              </tr>
               <tr><td><hr width=\"1\"  height=\"100\"></td></tr>";

    foreach ($objSolMontarPlaca->getObjsAmostras() as $amostra) {

        $data = explode("-",$amostra->getDataColeta());
        $dia = $data[2];
        $mes = $data[1];
        $ano = $data[0];

        $html .= "<tr> <td style=\"background-color: #ddd;\"> Amostra ".$amostra->getCodigoAmostra()."  </td></tr>"
            . "<tr> <td>Data Coleta: " .$dia.'/'.$mes.'/'.$ano . "</td></tr>" .
            "<tr><td> Perfil da amostra: " . $amostra->getObjPerfil()->getIndex_perfil() . "</td></tr>" .
            "<tr><td><hr width=\"1\"  height=\"100\"></td></tr>";

    }

    $html .= " </table>";


    if ($objSolMontarPlaca->getIdPlacaFk() != null) {
        //echo $objSolMontarPlaca->getIdPlacaFk() ;

        $objPlaca->setIdPlaca($objSolMontarPlaca->getIdPlacaFk());
        $objPlaca = $objPlacaRN->consultar_completo($objPlaca); // busca tudo em 1 consulta
        /*echo '<pre>';
        print_r($objPlaca);
        echo '</pre>';*/

        //caso aumentem, tem que aumentar aqui
        if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 1) {
            $incremento_na_placa_original = 0;
        } else if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 2) {
            $incremento_na_placa_original = 6;
        } else if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 3) {
            $incremento_na_placa_original = 4;
        } else if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 4) {
            $incremento_na_placa_original = 3;
        }


        $table .= '<table class="table table-responsive table-hover tabela_poco" >';
        $quantidade = 8;
        $letras = range('A', chr(ord('A') + $quantidade));

        $cols = (12 / count($objPlaca->getObjProtocolo()->getObjDivisao()));
        $qnt = count($objPlaca->getObjProtocolo()->getObjDivisao());
        $colocarTubos = count($objPlaca->getObjProtocolo()->getObjDivisao());
        $quantidadeTubos = count($objPlaca->getObjsTubos());
        //echo "tubos: " . $quantidadeTubos;

        $divs = 0;

        $testeTubos = 0;
        $tubo_placa = 0;
        /*for ($j = -1; $j <= 8; $j++) {
            $table .= '<tr>';
            for ($i = 0; $i <= 12; $i++) {

                if($j == -1 && $i ==0){
                    $table .= '<td> </td>';
                }
                if($j == -1 && $i > 0){
                    $table .= '<td>'.($i).'</td>';
                }
                if($i == 0 && $j > -1 && $j <= 7){
                    $table .= '<td>'.$letras[$j].'</td>';
                }

                if($j > -1 && $i > 0 && $j<= 7 && $i <= 12) {

                    foreach ($objPlaca->getObjsPocosPlacas() as $pocosPlaca) {
                        $poco = $pocosPlaca->getObjPoco();
                        if($poco->getLinha() == $letras[$j] && $poco->getColuna() == $i){
                            if ($poco->getSituacao() == PocoRN::$STA_LIBERADO) {
                                $background = ' style="background: rgba(0,255,0,0.2);"';
                            } else {
                                $background = ' style="background: rgba(255,0,0,0.2);"';
                            }


                            if($i == $incremento_na_placa){
                                $table .= '<td><input type="text" ' . $background . ' class="form-control"  disabled style="text-align: center;"
                               name="poco' . $j . $i . '" value="INCREMENTO"></td>';
                                $incremento_na_placa = ($incremento_na_placa-1)+($incremento_na_placa-1);
                            }


                            if($objPlaca->getObjsTubos()[$testeTubos]!= null){
                                if($objPlaca->getObjsTubos()[$testeTubos]->getIdTuboFk() != null){
                                    $table .= '<td><input type="text" ' . $background . ' class="form-control"  disabled style="text-align: center;"
                               name="poco' . $j . $i . '" value="' . $objPlaca->getObjsTubos()[$testeTubos]->getIdTuboFk() . '"></td>';

                                }
                            }else{

                                $table .= '<td><input type="text" ' . $background . ' class="form-control"  disabled style="text-align: center;"
                               name="poco' . $j . $i . '" value="' . $letras[$j] . $i . '"></td>';
                            }





                        }
                    }

                    //if($objPlaca->getObjProtocolo()->getNumDivisoes() == 3){}
                }


                if($i== 0 && $j>7){
                    $table .= '<td ></td>';
                }
                if($qnt > 0) {
                    if ($j > 7  && $i>0 && $i <= 12) {
                        $table .= '<td colspan="' . $cols . '" style="border:1px solid black;" >' . $objPlaca->getObjProtocolo()->getObjDivisao()[$divs]->getNomeDivisao() . '</td>';
                        $qnt--;
                        $divs++;
                    }
                }

            }
            $table .= '</tr>';
        }
        $table .= '</table>';*/
        $contador_extras = 0;
        $posicoes_array = 0;
        $cont = 1;
        for ($j = 1; $j <= 12; $j++) {
            for ($i = 1; $i <= 8; $i++) {
                if ($objPlaca->getObjsAmostras()[$tubo_placa] != null) {
                    //$posicao_tubo[$posicoes_array] = array('valor'=>$objPlaca->getObjsTubos()[$tubo_placa]->getIdTuboFk(),'x' => $i, 'y' => $j);
                    $posicao_tubo[$i][$j] = $objPlaca->getObjsAmostras()[$tubo_placa]->getNickname();

                    if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 3) {
                        $posicao_tubo[$i][$j + $incremento_na_placa_original] = $objPlaca->getObjsAmostras()[$tubo_placa]->getNickname();
                        $posicao_tubo[$i][$j + (2 * $incremento_na_placa_original)] = $objPlaca->getObjsAmostras()[$tubo_placa]->getNickname();
                    }
                } else {

                    if ($cont == 1) {
                        //$posicao_tubo[$posicoes_array] = array('valor'=>'C+','x' => $i, 'y' => $j);
                        $posicao_tubo[$i][$j] = 'C+';
                        if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 3) {
                            $posicao_tubo[$i][$j + $incremento_na_placa_original] = 'C+';
                            $posicao_tubo[$i][$j + (2 * $incremento_na_placa_original)] = 'C+';
                        }
                    }
                    if ($cont == 2) {
                        //$posicao_tubo[$posicoes_array] = array('valor'=>'C-','x' => $i, 'y' => $j);
                        $posicao_tubo[$i][$j] = 'C-';
                        if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 3) {
                            $posicao_tubo[$i][$j + $incremento_na_placa_original] = 'C-';
                            $posicao_tubo[$i][$j + (2 * $incremento_na_placa_original)] = 'C-';
                        }
                    }
                    if ($cont == 3 || $cont == 4) {
                        //$posicao_tubo[$posicoes_array] = array('valor'=>'BR','x' => $i, 'y' => $j);
                        $posicao_tubo[$i][$j] = 'BR';
                        if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 3) {
                            $posicao_tubo[$i][$j + $incremento_na_placa_original] = 'BR';
                            $posicao_tubo[$i][$j + (2 * $incremento_na_placa_original)] = 'BR';
                        }
                    }

                    if ($cont > 4) {
                        break;
                    }
                    $cont++;
                }
                $tubo_placa++;
                $posicoes_array++;
            }
        }


        for ($i = 0; $i <= 8; $i++) {
            $table .= '<tr>';

            for ($j = 0; $j <= 12; $j++) {

                if ($i == 0 && $j == 0) { //canto superior esquerdo - quadrado vazio
                    $table .= '<td> - </td>';
                } else if ($i == 0 && $j > 0) { //linha 0 - local para se colocar os números
                    $table .= '<td  style="padding: 5px; "><strong>' . $j . '</strong></td>';
                } else if ($j == 0 && $i > 0) { //linha 0 - local para se colocar os números
                    $table .= '<td style="padding: 5px; "><strong>' . $letras[$i - 1] . '</strong></td>';
                } else {

                    if ($posicao_tubo[$i][$j] != '') {
                        if ($posicao_tubo[$i][$j] == 'BR' || $posicao_tubo[$i][$j] == 'C+' || $posicao_tubo[$i][$j] == 'C-') {
                            $style = ' style="background-color: rgba(255,255,0,0.2);"';
                        } else {
                            $style = ' style="background-color: rgba(255,0,0,0.2);" ';
                        }

                        $table .= '<td  ><input ' . $style . ' type="text" class="form-control" id="idDataHoraLogin" disabled style="text-align: center;"
                                    name="input_' . $i . '_' . $j . '" value=" ' . $posicao_tubo[$i][$j] . '"></td>';
                    } else {
                        $table .= '<td><input style="background-color: rgba(0,255,0,0.2);" type="text" class="form-control" id="idDataHoraLogin" disabled style="text-align: center;"
                                    name="input_' . $i . '_' . $j . '" value="  "></td>';

                    }
                }

            }

            $table .= '</tr>';
        }
        $table .= '</table>';

    }


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

    $output = 'solicitacaoMontagemPlaca' . $dia . '_' . $mes . '_' . $ano;
//echo $output;

    $mpdf->WriteHTML($css, 1);
    $mpdf->WriteHTML($html.$table);
    //$mpdf->Output($output);
    $mpdf->Output($output . '.pdf', I);
}catch(Throwable $e){
    die($e);
}



