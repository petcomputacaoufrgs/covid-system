<?php
session_start();
try{
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';

    require_once __DIR__ . '/../../classes/Equipamento/EquipamentoINT.php';
    require_once __DIR__ . '/../../classes/Equipamento/EquipamentoRN.php';
    require_once __DIR__ . '/../../classes/Equipamento/Equipamento.php';

    require_once  __DIR__.'/../../utils/Utils.php';

    require_once __DIR__ . '/../../classes/Placa/Placa.php';
    require_once __DIR__ . '/../../classes/Placa/PlacaRN.php';
    require_once __DIR__ . '/../../classes/Placa/PlacaINT.php';

    require_once __DIR__ . '/../../classes/Poco/Poco.php';
    require_once __DIR__ . '/../../classes/Poco/PocoRN.php';

    require_once __DIR__ . '/../../classes/RelPocoPlaca/PocoPlaca.php';
    require_once __DIR__ . '/../../classes/RelPocoPlaca/PocoPlacaRN.php';

    require_once __DIR__ . '/../../classes/DivisaoProtocolo/DivisaoProtocolo.php';
    require_once __DIR__ . '/../../classes/DivisaoProtocolo/DivisaoProtocoloRN.php';

    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTexto.php';
    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTextoRN.php';

    require_once __DIR__ . '/../../classes/RelPerfilPlaca/RelPerfilPlaca.php';
    require_once __DIR__ . '/../../classes/RelPerfilPlaca/RelPerfilPlacaRN.php';

    require_once __DIR__ . '/../../classes/InfosTubo/InfosTubo.php';
    require_once __DIR__ . '/../../classes/InfosTubo/InfosTuboRN.php';

    require_once __DIR__ . '/../../classes/RTqPCR/RTqPCR.php';
    require_once __DIR__ . '/../../classes/RTqPCR/RTqPCR_RN.php';
    require_once __DIR__ . '/../../classes/RTqPCR/RTqPCR_INT.php';

    require_once __DIR__ . '/../../classes/ResultadoPCR/ResultadoPCR.php';
    require_once __DIR__ . '/../../classes/ResultadoPCR/ResultadoPCR_RN.php';

    require_once __DIR__ . '/../../classes/Planilha/Planilha.php';

    require_once __DIR__ . '/../../vendor/fpdf/fpdf.php';


    Sessao::getInstance()->validar();
    date_default_timezone_set('America/Sao_Paulo');
    $_SESSION['DATA_LOGIN'] = date("Y-m-d H:i:s");
    $objUtils = new Utils();



    /*
     * RTqPCR
     */
    $objRTqPcr= new RTqPCR();
    $objRTqPcrRN = new RTqPCR_RN();

    /*
     * INFOS TUBO
     */
    $objInfosTubo = new InfosTubo();
    $objInfosTuboRN = new InfosTuboRN();

    /*
     * EQUIPAMENTO
     */
    $objEquipamento = new Equipamento();
    $objEquipamentoRN = new EquipamentoRN();

    /* PROTOCOLO */
    $objProtocolo = new Protocolo();
    $objProtocoloRN = new ProtocoloRN();

    /* DIVISÃO PROTOCOLO */
    $objDivisaoProtocolo = new DivisaoProtocolo();
    $objDivisaoProtocoloRN = new DivisaoProtocoloRN();

    /*
    *  POÇO
    */
    $objPoco = new Poco();
    $objPocoRN = new PocoRN();


    /*
    *  POÇO + PLACA
    */
    $objPocoPlaca = new PocoPlaca();
    $objPocoPlacaRN = new PocoPlacaRN();

    /*
     * PLACA
     */
    $objPlaca = new Placa();
    $objPlacaRN = new PlacaRN();

    /*
     * RESULTADO RTqPCR
     */
    $objResultado = new ResultadoPCR();
    $objResultadoRN = new ResultadoPCR_RN();

    $bool_amostras_discrepantes = false;

    $objRTqPcr->setIdRTqPCR($_GET['idRTqPCR']);
    $objRTqPcr = $objRTqPcrRN->consultar($objRTqPcr);
    $dataFinal = explode(" ",$objRTqPcr->getDataHoraInicio());
    $final =  $dataFinal[0]." ".$objRTqPcr->getHoraFinal();
    $segundosAtraso =  Utils::compararDataHora($final,date("Y-m-d H:i:s"));
    $hrs = floor($segundosAtraso / 3600);
    $dias  = floor($hrs / 24);
    $horas =  fmod($hrs , 24);
    $minutos = floor(($segundosAtraso - ($hrs * 3600)) / 60);
    $segundos = floor($segundosAtraso % 60);
    $strAtraso =  "<h4> Atraso de ".$dias." dias ".$horas . " horas " . $minutos . " minutos " . $segundos." segundos </h4>";



    try {
        function uploadFile()
        {
            $objExcecao = new Excecao();
            $currentDirectory = getcwd();
            $uploadDirectory = "\planilhas\\";

            date_default_timezone_set("America/Sao_Paulo");

            $errors = []; // Store errors here

            $fileExtensionsAllowed = ['xls', 'xlsx']; // These will be the only file extensions allowed

            $fileName = $_FILES['the_file']['name'];
            $fileSize = $_FILES['the_file']['size'];
            $fileTmpName = $_FILES['the_file']['tmp_name'];
            $fileType = $_FILES['the_file']['type'];
            $fileError = $_FILES['the_file']['error'];
            $array = explode('.', $fileName);
            $fileExtension = strtolower(end($array));
            $newFileName = date("Ymd_Hi", time());

            $uploadPath = $currentDirectory . $uploadDirectory . basename($newFileName) . '.' . $fileExtension;
            // echo $uploadPath;

            if (isset($_POST['btn_upload'])) {

                if (!in_array($fileExtension, $fileExtensionsAllowed)) {
                    $objExcecao->adicionar_validacao("Arquivo não suportado, favor fazer upload de um arquivo *.xls",null,'alert-danger');
                }

                if ($fileSize > 8000000) {
                    $objExcecao->adicionar_validacao("Arquivo muito grande, fazer upload de um arquivo de até 8MB.",null,'alert-danger');
                }

                if ($fileError == 1) {
                    $objExcecao->adicionar_validacao( "O arquivo enviado excede o limite definido na diretiva upload_max_filesize do php.ini.",null,'alert-danger');
                }

                if ($fileError == 2) {
                    $objExcecao->adicionar_validacao("O arquivo excede o limite definido em MAX_FILE_SIZE no formulário HTML.",null,'alert-danger');
                }
                if ($fileError == 3) {
                    $objExcecao->adicionar_validacao("O upload do arquivo foi feito parcialmente.",null,'alert-danger');
                }
                if ($fileError == 4) {
                    $objExcecao->adicionar_validacao("Nenhum arquivo foi enviado.",null,'alert-danger');
                }
                if ($fileError == 5) {
                    $objExcecao->adicionar_validacao("Pasta temporária ausênte. Introduzido no PHP 5.0.3.",null,'alert-danger');
                }
                if ($fileError == 6) {
                    //$errors[] = "O upload do arquivo foi feito parcialmente.";
                    $objExcecao->adicionar_validacao("Falha em escrever o arquivo em disco. Introduzido no PHP 5.1.0.",null,'alert-danger');
                }
                if ($fileError == 7) {
                    //$errors[] = "O arquivo excede o limite definido em MAX_FILE_SIZE no formulário HTML.";
                    $objExcecao->adicionar_validacao("Nenhum arquivo foi enviado.",null,'alert-danger');
                }
                if ($fileError == 8) {
                    //$errors[] = "O arquivo excede o limite definido em MAX_FILE_SIZE no formulário HTML.";
                    $objExcecao->adicionar_validacao("Uma extensão do PHP interrompeu o upload do arquivo.",null,'alert-danger');
                }


                $objExcecao->lancar_validacoes();

                //echo "fileTmpName: ". $fileTmpName."#\n";
                //echo "uploadPath: ".$uploadPath."#%\n";
                $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

                if ($didUpload) {
                    //echo "<h3>O arquivo " . basename($fileName) . " foi enviado com sucesso </h3>";
                    return $newFileName . '.' . $fileExtension;
                } else {
                    echo "Houve um erro, por favor tente novamente ou contate o administrador.";
                    return -1;
                }

            }
        }

    }catch (Throwable $e){
        Pagina::getInstance()->processar_excecao($e);
    }


    if(isset($_POST['btn_upload'])) {
        $sumir_btn_upload = false;
        $result = uploadFile();

        if(!is_int($result)) {
            //Le o arquivo .xls usando a função leituraXLS();
            $leitor = new Planilha();
            $leitor->leituraXLS($result);
            $alert .= Alert::alert_success("Arquivo lido e cadastrado com sucesso");
            $sumir_btn_upload = true;
            //echo $result;

            $objResultado->setNomePlanilha($result);
            $arr_resultados = $objResultadoRN->listar($objResultado);

            $objPocoPlaca->setIdPlacaFk($_GET['idPlaca']);
            $arrPocosPlaca = $objPocoPlacaRN->listar_completo($objPocoPlaca);
            /*
                echo "<pre>";
                print_r($arrPocosPlaca);
                echo "</pre>";
            */

            //print_r($arr_resultados);
            foreach ($arr_resultados as $resultado){
                $linha = $resultado->getWell()[0];
                $coluna = $resultado->getWell()[1];
                foreach ($arrPocosPlaca as $pocoPlaca) {
                    $poco = $pocoPlaca->getObjPoco();
                    //echo $coluna." == ".$poco->getColuna()."\n";
                    //echo $linha." == ".$poco->getLinha()."\n";
                    if($poco->getLinha() == $linha && $poco->getColuna() == $coluna){
                        if($poco->getConteudo() != $resultado->getSampleName()){
                            $poco->setSituacao(PocoRN::$STA_OCUPADO_INVALIDO);
                            $objPocoRN->alterar($poco);
                            $bool_amostras_discrepantes = true;
                            $arr_amostras_discrepantes[] = $poco;
                        }
                    }
                }
            }

            $objPlaca->setIdPlaca($_GET['idPlaca']);
            $objPlaca = $objPlacaRN->consultar_completo($objPlaca);

            //mostrar o poço
            if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 1) {
                $incremento_na_placa_original = 0;
            } else if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 2) {
                $incremento_na_placa_original = 6;
            } else if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 3) {
                $incremento_na_placa_original = 4;
            } else if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 4) {
                $incremento_na_placa_original = 3;
            }


            $error = false;
            $arr_errors = array();

            //$table .= '<table class="table table-responsive table-hover" style="margin-top: 20px;">';
            $quantidade = 8;
            $letras = range('A', chr(ord('A') + $quantidade));

            $cols = (12 / count($objPlaca->getObjProtocolo()->getObjDivisao()));

            $tubo_placa = 0;
            $posicoes_array = 0;
            $cont = 1;
            $disabled = ' disabled ';

            $table = '<table class="table table-hover tabela_poco">';
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
                                    } else if($pocoPlaca->getObjPoco()->getSituacao() == PocoRN::$STA_OCUPADO) {
                                        $style = ' style="background-color: rgba(255,0,0,0.2);"';
                                    }else if($pocoPlaca->getObjPoco()->getSituacao() == PocoRN::$STA_OCUPADO_INVALIDO) {
                                        $style = ' style="background-color: rgba(113,111,111,0.2);"';
                                    }


                                    if (trim($pocoPlaca->getObjPoco()->getConteudo()) == 'BR' ||
                                        trim($pocoPlaca->getObjPoco()->getConteudo()) == 'C+' ||
                                        trim($pocoPlaca->getObjPoco()->getConteudo() == 'C-')) {
                                        $style = ' style="background-color: rgba(255,255,0,0.2);"';
                                    }


                                    $table .= '<td><input ' . $style . $disabled.' type="text" class="form-control"
                                        id="idDataHoraLogin" style="text-align: center;"
                                        name="' . $strPosicao . '"
                                        value="' . $pocoPlaca->getObjPoco()->getConteudo() . '"></td>';
                                } else {
                                    $table .= '<td ><input style="background-color: rgba(0,255,0,0.2);" '. $disabled.' type="text" class="form-control"
                                        id="idDataHoraLogin" style="text-align: center;"
                                        name="' . $strPosicao . '"
                                        value=""></td>';
                                }

                                if (isset($_POST['btn_editar_poco'])) {
                                    if (trim(strtoupper($_POST[$strPosicao])) == 'BR') {
                                        $pocoPlaca->getObjPoco()->setConteudo('BR');
                                        $pocoPlaca->getObjPoco()->setSituacao(PocoRN::$STA_OCUPADO);
                                        $objPocoRN->alterar($pocoPlaca->getObjPoco());
                                    } else if (trim(strtoupper($_POST[$strPosicao])) == 'C+') {
                                        $pocoPlaca->getObjPoco()->setConteudo('C+');
                                        $objPocoRN->alterar($pocoPlaca->getObjPoco());
                                        $pocoPlaca->getObjPoco()->setSituacao(PocoRN::$STA_OCUPADO);
                                    } else if (trim(strtoupper($_POST[$strPosicao])) == 'C-') {
                                        $pocoPlaca->getObjPoco()->setConteudo('C-');
                                        $pocoPlaca->getObjPoco()->setSituacao(PocoRN::$STA_OCUPADO);
                                        $objPocoRN->alterar($pocoPlaca->getObjPoco());
                                    } else {

                                        if (strlen(strtoupper($_POST[$strPosicao])) != 0) {
                                            //procurar entre as amostras permitidas
                                            $encontrou = false;
                                            foreach ($objPlaca->getObjsAmostras() as $amostra) {
                                                if ($amostra->getNickname() == trim(strtoupper($_POST[$strPosicao]))) {
                                                    $encontrou = true;
                                                    //$idTubo = $amostra->getObjTubo()->getIdTubo();
                                                }
                                            }
                                            if (!$encontrou) {
                                                $arr_errors[] = $_POST[$strPosicao];
                                                $alert .= Alert::alert_danger("O código informado -" . trim(strtoupper($_POST[$strPosicao])) . "- não é o de uma amostra válida para essa placa");
                                            } else {
                                                //$pocoPlaca->getObjPoco()->setIdTuboFk($idTubo);
                                                $pocoPlaca->getObjPoco()->setConteudo(trim(strtoupper($_POST[$strPosicao])));
                                            }
                                        }
                                    }


                                    $pocoPlaca->getObjPoco()->setSituacao(PocoRN::$STA_OCUPADO);
                                    if (strlen(trim(strtoupper($_POST[$strPosicao]))) == 0) {
                                        $pocoPlaca->getObjPoco()->setConteudo(null);
                                        $pocoPlaca->getObjPoco()->setSituacao(PocoRN::$STA_LIBERADO);
                                        $objPocoRN->alterar($pocoPlaca->getObjPoco());
                                    }

                                    if ($encontrou) {
                                        $objPocoRN->alterar($pocoPlaca->getObjPoco());
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $table.= '<tr><td>  </td>';
            foreach($objPlaca->getObjProtocolo()->getObjDivisao() as $divisao){
                $table.= '<td colspan="'.$cols.'" style=" background: rgba(242,242,242,0.4);border-left:1px solid #d2d2d2;border-right:1px solid #d2d2d2; ">'.$divisao->getNomeDivisao().'</td>';
            }
            $table.= '</tr>';
            $table .= '</table>';

            /*$objRTqPcr->setIdRTqPCR($_GET['idRTqPCR']);
            $arrRTqPCR = $objRTqPcrRN->listar($objRTqPcr);
            print_r($arrRTqPCR[0]);

            $objPlaca->setIdPlaca($_GET['idPlaca']);
            $arrPlaca = $objPlacaRN->listar_completo($objPlaca);

                echo "<pre>";
                print_r($arrPlaca[0]);
                echo "</pre>";
            */
        }
    }






} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Análise RTqPCR");
Pagina::getInstance()->adicionar_css("precadastros");
if($liberar_popUp == 's') {
    Pagina::getInstance()->adicionar_javascript("popUp");
}
Pagina::getInstance()->adicionar_javascript("showtime");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('ANÁLISE RTqPCR',null,null, 'listar_analise_RTqPCR', 'LISTAR RTqPCR');
echo $alert;
Pagina::getInstance()->mostrar_excecoes();


echo '<div class="conteudo_grande"   style="margin-top: 0px;"> 
            <div class="form-row">  
                <div class="col-md-12" style="text-align: center;">
                    ' . $strAtraso .' 
                </div>
           </div>
           </div>';
if(!$sumir_btn_upload) {
    echo '<form enctype="multipart/form-data" method="POST">
            <!-- MAX_FILE_SIZE deve preceder o campo input -->
            <input type="hidden" name="MAX_FILE_SIZE" value="8000000" />
            <!-- O Nome do elemento input determina o nome da array $_FILES -->
            Enviar esse arquivo: <input name="the_file" type="file" />
            <input type="submit"  name="btn_upload" value="Enviar arquivo" />
        </form>';
}else{
    echo  '<div class="conteudo_grande"   style="margin-top: 0px;"> 
                <form method="POST">  
                    <div class="form-row">
                        <div class="col-md-12" style="text-align: center;">
                            '.$table.'
                        </div>
                    </div>';
    //tem amostras discrepantes
    if($bool_amostras_discrepantes){
        echo '<div class="form-row">  
                <div class="col-md-6" style="text-align: center;">
                    <button class="btn btn-primary" type="submit" style="width: 100%;" name="btn_arrumar_discrepancia">ARRUMAR DISCREPÂNCIA</button>
                </div>
                <div class="col-md-6" style="text-align: center;">
                    <button class="btn btn-primary" type="submit" style="width: 100%;" name="btn_prosseguir">APENAS PROSSEGUIR</button>
                </div>
              </div>';
    }else{

    }
    echo '        </div>
                </form>
            </div>';
}
echo '<!-- Modal -->
    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="text-align: center">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                    Deseja realizar outra análise de RTqPCR? </h5>   
                </div>             
                <div class="modal-footer">
                    <!--<button type="button" class="btn btn-secondary" data-dismiss="modal"  >Close</button>-->
                    <button type="button"  class="btn btn-primary">
                    <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=finalizar_RTqPCR') . '">Sim</a></button>
                </div>
            </div>
        </div>
    </div>';


/*
echo '<div class="conteudo_grande"   style="margin-top: 0px;">        
             <form method="POST">
             
              <div class="col-md-12">
                    <input type="text" class="form-control" id="idDataHoraLogin" hidden style="text-align: center;"
                           name="dtHoraLoginInicio" required value="' . $_SESSION['DATA_LOGIN'] . '">
                </div>
             
             <div class="form-row">  
                <div class="col-md-12" >
                    <label>Selecione um RTqPCR</label>
                    '.$select_rtpcr.'
                </div>
                
             </div>          ';


    echo ' <div class="form-row">  
            <div class="col-md-12" >
                <button class="btn btn-primary" type="submit" name="btn_rtqpcr">SALVAR</button>
            </div>
       </div>';

echo '</form>
</div>';

*/
Pagina::getInstance()->fechar_corpo();