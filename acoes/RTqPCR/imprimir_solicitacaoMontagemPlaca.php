<?php
try {
    session_start();

    require_once __DIR__.'/../../vendor/mpdf60/mpdf.php';
    require_once __DIR__ . '/../../utils/Utils.php';

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

    date_default_timezone_set('America/Sao_Paulo');

    $objSolMontarPlaca = new SolicitacaoMontarPlaca();
    $objSolMontarPlacaRN = new SolicitacaoMontarPlacaRN();

    $objPlaca = new Placa();
    $objPlacaRN = new PlacaRN();

    $objPocoPlaca = new PocoPlaca();
    $objPocoPlacaRN = new PocoPlacaRN();

    if (isset($_GET['idSolicitacao'])) {
        $objSolMontarPlaca->setIdSolicitacaoMontarPlaca($_GET['idSolicitacao']);
        $arr_solicitacoes = $objSolMontarPlacaRN->listar($objSolMontarPlaca);

        $objSolMontarPlaca = $arr_solicitacoes[0];
        $mpdf = new mPDF(['mode' => 'utf-8', 'format' => [190, 236]]);

        $html = "   
            <table>            
                    <tr>
                        <td><img src=\"../public_html/img/logoICBS.png\"  style=\"width:100px;  \" /> </td>
                        <td><h1> SOLICITAÇÃO DE MONTAGEM DE PLACA DE Nº " . $objSolMontarPlaca->getIdSolicitacaoMontarPlaca() . " </h1></td>
                    </tr>
            </table>";

        if ($objSolMontarPlaca->getSituacaoSolicitacao() == SolicitacaoMontarPlacaRN::$TS_FINALIZADA) {
            $style = ' style="background: rgba(0,255,0,0.2);text-align: center;"';
        }
        if ($objSolMontarPlaca->getSituacaoSolicitacao() == SolicitacaoMontarPlacaRN::$TS_EM_ANDAMENTO) {
            $style = ' style="background: rgba(243,108,41,0.2);text-align: center;"';
        }

        $html .= " <table> 
              <tr><td '.$style.'>SITUAÇÃO SOLICITAÇÃO: " . SolicitacaoMontarPlacaRN::mostrarDescricaoSituacaoSolicitacao($objSolMontarPlaca->getSituacaoSolicitacao()) . "</td></tr>
              <tr>
                   <td>Quantidade de amostras na placa: " . count($objSolMontarPlaca->getObjsAmostras()) . "</td>
              </tr>
               <tr><td><hr width=\"1\"  height=\"100\"></td></tr>";

        foreach ($objSolMontarPlaca->getObjsAmostras() as $amostra) {
            $html .= "<tr> <td style=\"background-color: #ddd;\"> Amostra " . $amostra->getCodigoAmostra() . "  </td></tr>"
                . "<tr> <td>Data Coleta: " . Utils::getStrData($amostra->getDataColeta()) . "</td></tr>" .
                "<tr><td> Perfil da amostra: " . $amostra->getObjPerfil()->getIndex_perfil() . "</td></tr>" .
                "<tr><td><hr width=\"1\"  height=\"100\"></td></tr>";
        }
        $html .= " </table>";
        if ($objSolMontarPlaca->getIdPlacaFk() != null) {
            $objPlaca->setIdPlaca($objSolMontarPlaca->getIdPlacaFk());
            $objPlaca = $objPlacaRN->consultar_completo($objPlaca); // busca tudo em 1 consulta

            if ($objPlaca->getSituacaoPlaca() == PlacaRN::$STA_INVALIDA) {
                $color = ' style ="background-color: rgba(255,0,0,0.2);" ';
            } else if ($objPlaca->getSituacaoPlaca() == PlacaRN::$STA_NO_MIX) {
                $color = ' style="background: rgba(243,108,41,0.2);" ';
            } else if ($objPlaca->getSituacaoPlaca() == PlacaRN::$STA_MIX_FINALIZADO) {
                $color = ' style ="background-color: rgba(0,255,0,0.2);" ';
            }

            $tableinfplaca = '<table class="table table-responsive table-hover tabela_poco" style="text-align:center;">
                                <tr><td ' . $color . '>Situação da placa: ' . PlacaRN::mostrar_descricao_staPlaca($objPlaca->getSituacaoPlaca()) . '</td></tr>
                          </table>';


            /*echo '<pre>';
            print_r($objPlaca);
            echo '</pre>';*/

            //caso aumentem, tem que aumentar aqui
            if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 1) {
                $incremento_na_placa_original = 0;
            } else if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 3) {
                $incremento_na_placa_original = 4;
            }


            $quantidade = 8;
            $letras = range('A', chr(ord('A') + $quantidade));

            $cols = (12 / count($objPlaca->getObjProtocolo()->getObjDivisao()));

            $tubo_placa = 0;
            $posicoes_array = 0;
            $cont = 1;

            $table = '<table class="table table-responsive table-hover tabela_poco" style="text-align:center;">';
            $arr_erro_qnt = array();
            for ($i = 0; $i <= 8; $i++) {
                $table .= '<tr>';

                for ($j = 0; $j <= 12; $j++) {
                    $strPosicao = 'input_' . $i . '_' . $j;
                    if ($i == 0 && $j == 0) { //canto superior esquerdo - quadrado vazio
                        $table .= '<td> - </td>';
                    } else if ($i == 0 && $j > 0) { //linha 0 - local para se colocar os números
                        $table .= '<td><strong>' . $j . '</strong></td>';
                    } else if ($j == 0 && $i > 0) { //linha 0 - local para se colocar os números
                        $table .= '<td><strong>' . $letras[$i - 1] . '</strong></td>';
                    } else if ($i > 0 && $j > 0) {
                        foreach ($objPlaca->getObjsPocosPlacas() as $pocoPlaca) {
                            if ($pocoPlaca->getObjPoco()->getLinha() == $letras[$i - 1] && $pocoPlaca->getObjPoco()->getColuna() == $j) {

                                if ($pocoPlaca->getObjPoco()->getConteudo() != '') {
                                    $encontrou_repeticao = false;

                                    if ($pocoPlaca->getObjPoco()->getSituacao() == PocoRN::$STA_LIBERADO) {
                                        $style = ' style="background-color: rgba(0,255,0,0.2);"';
                                    } else {
                                        $style = ' style="background-color: rgba(255,0,0,0.2);"';
                                    }

                                    if (trim($pocoPlaca->getObjPoco()->getConteudo()) == 'BR' ||
                                        trim($pocoPlaca->getObjPoco()->getConteudo()) == 'C+' ||
                                        trim($pocoPlaca->getObjPoco()->getConteudo() == 'C-')) {
                                        $style = ' style="background-color: rgba(255,255,0,0.2);"';
                                    }

                                    $table .= '<td><input ' . $style . $disabled . ' type="text" class="form-control"
                                        id="idDataHoraLogin" style="text-align: center;"
                                        name="' . $strPosicao . '"
                                        value="' . $pocoPlaca->getObjPoco()->getConteudo() . '"></td>';
                                } else {
                                    $table .= '<td ><input style="background-color: rgba(0,255,0,0.2);" ' . $disabled . ' type="text" class="form-control"
                                        id="idDataHoraLogin" style="text-align: center;"
                                        name="' . $strPosicao . '"
                                        value=""></td>';
                                }

                            }
                        }
                    }
                }
            }
            $table .= '<tr><td>  </td>';
            foreach ($objPlaca->getObjProtocolo()->getObjDivisao() as $divisao) {
                $table .= '<td colspan="' . $cols . '" style=" background: rgba(242,242,242,0.4);border-left:1px solid #d2d2d2;border-right:1px solid #d2d2d2;text-align:center; ">' . $divisao->getNomeDivisao() . '</td>';
            }
            $table .= '</tr>';
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


        $output = 'nº' . $objSolMontarPlaca->getIdSolicitacaoMontarPlaca() . '-solicitacaoMontagemPlaca_' . Utils::converterDataHora(date("Y-m-d h:i:s"));
        $mpdf->WriteHTML($css, 1);
        $mpdf->WriteHTML($html . $tableinfplaca . $table);
        $mpdf->Output($output . '.pdf', 'D');
    }
}catch(Throwable $e){
    die($e);
}



