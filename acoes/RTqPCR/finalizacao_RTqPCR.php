<?php
/*
 *  idSituacao = 0 --> não encontrou amostras discrepantes
 *  idSituacao = 1 --> encontrou amostras discrepantes
 */
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

    require_once __DIR__ . '/../../classes/Amostra/Amostra.php';
    require_once __DIR__ . '/../../classes/Amostra/AmostraRN.php';


    Sessao::getInstance()->validar();
    date_default_timezone_set('America/Sao_Paulo');
    $_SESSION['DATA_LOGIN'] = date("Y-m-d H:i:s");
    $objUtils = new Utils();

    /*
     * Amostra
     */
    $objAmostra= new Amostra();
    $objAmostraRN = new AmostraRN();


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

    $sumir_btn_upload = false;
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


    die("asda");
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

        $result = uploadFile();

        if (!is_int($result)) {
            //Le o arquivo .xls usando a função leituraXLS();
            $leitor = new Planilha();
            $leitor->leituraXLS($result, $_GET['idRTqPCR']);
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
            foreach ($arr_resultados as $resultado) {
                $linha = $resultado->getWell()[0];
                if(strlen($resultado->getWell()) == 2){
                    $coluna = substr($resultado->getWell(),-1);
                }else{
                    $coluna = substr($resultado->getWell(),-2);
                }

                foreach ($arrPocosPlaca as $pocoPlaca) {
                    $poco = $pocoPlaca->getObjPoco();
                    //echo $coluna." == ".$poco->getColuna()."\n";
                    //echo $linha." == ".$poco->getLinha()."\n";
                    if ($poco->getLinha() == $linha && $poco->getColuna() == $coluna) {
                        if ( ($poco->getConteudo() != $resultado->getSampleName()) ||  ((is_null($poco->getConteudo())) &&  (!is_null($resultado->getSampleName())))){
                            //|| (is_null($poco->getConteudo()) &&  (strlen($resultado->getSampleName()) >0))) {
                            $poco->setSituacao(PocoRN::$STA_OCUPADO_INVALIDO);
                            //$strConteudo = $poco->getConteudo().' ('.$resultado->getSampleName().')';
                            //$poco->setConteudo($strConteudo);
                            $objPocoRN->alterar($poco);
                            $bool_amostras_discrepantes = true;
                            //$arr_amostras_discrepantes[] = $poco;
                        }
                    }
                }
            }


            if ($bool_amostras_discrepantes) {
                header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=finalizar_RTqPCR&idRTqPCR=' . $_GET['idRTqPCR'] . '&idPlaca=' . $_GET['idPlaca'] . '&idEquipamento=' . $_GET['idEquipamento'] . '&idSituacao=1&idDiscrepancia=1'));

            } else {
                header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=finalizar_RTqPCR&idRTqPCR=' . $_GET['idRTqPCR'] . '&idPlaca=' . $_GET['idPlaca'] . '&idEquipamento=' . $_GET['idEquipamento'] . '&idSituacao=0&idDiscrepancia=0'));
            }
            die();

        }
    }
    if(isset($_GET['idComResultado']) && $_GET['idComResultado']==1) {
        $objResultado->setIdRTqPCRFk($_GET['idRTqPCR']);
        $arr_resultados = $objResultadoRN->listar($objResultado);

        $objPocoPlaca->setIdPlacaFk($_GET['idPlaca']);
        $arrPocosPlaca = $objPocoPlacaRN->listar_completo($objPocoPlaca);


       $encontrou = false;
       $i=0;
        while(!$encontrou && $i<count($arrPocosPlaca)){
            $poco = $arrPocosPlaca[$i]->getObjPoco();
            if($poco->getSituacao() == PocoRN::$STA_OCUPADO_INVALIDO){
                $encontrou = true;
            }
            $i++;
        }
        if ($encontrou) {
            header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=finalizar_RTqPCR&idRTqPCR=' . $_GET['idRTqPCR'] . '&idPlaca=' . $_GET['idPlaca'] . '&idEquipamento=' . $_GET['idEquipamento'] . '&idSituacao=1&idDiscrepancia=1'));

        } else {
            header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=finalizar_RTqPCR&idRTqPCR=' . $_GET['idRTqPCR'] . '&idPlaca=' . $_GET['idPlaca'] . '&idEquipamento=' . $_GET['idEquipamento'] . '&idSituacao=0&idDiscrepancia=0'));
        }
        die();

    }


    if(isset($_GET['idSituacao'])) {
        /*$objResultado->setIdRTqPCRFk($_GET['idRTqPCR']);
        $arr_resultados = $objResultadoRN->listar($objResultado);
        $objPocoPlaca->setIdPlacaFk($_GET['idPlaca']);
        $arrPocosPlaca = $objPocoPlacaRN->listar_completo($objPocoPlaca);

        foreach ($arr_resultados as $resultado) {
            $linha = $resultado->getWell()[0];
            $coluna = $resultado->getWell()[1];
            foreach ($arrPocosPlaca as $pocoPlaca) {
                $poco = $pocoPlaca->getObjPoco();
                //echo $coluna." == ".$poco->getColuna()."\n";
                //echo $linha." == ".$poco->getLinha()."\n";
                if ($poco->getLinha() == $linha && $poco->getColuna() == $coluna) {
                    if (($poco->getConteudo() != $resultado->getSampleName()) || ((is_null($poco->getConteudo())) && (!is_null($resultado->getSampleName())))) {
                        $poco->setSituacao(PocoRN::$STA_OCUPADO_INVALIDO);
                        $objPocoRN->alterar($poco);
                        $arr_pocos_invalidos[] = $linha . $coluna;
                    }
                }

            }

        }

        if (count($arr_pocos_invalidos)) {
            $arr = array_unique($arr_pocos_invalidos);
            foreach ($arr as $pocoInvalido) {
                $str .= $pocoInvalido . ", ";
            }
            $str = substr($str, 0, -2);
            $alert .= Alert::alert_warning("Poços " . $str . ' inválidos');
        }
        */


        $objPlaca->setIdPlaca($_GET['idPlaca']);
        $objPlaca = $objPlacaRN->consultar_completo($objPlaca);


        //mostrar o poço
        $error_qnt = false;
        $arr_amostras_repetidas = array();
        $arr_divisao_repeticao = array();

        //caso aumentem, tem que aumentar aqui
        if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 1) {
            $incremento_na_placa_original = 0;
            $arr_qnts = $objPlacaRN->solicitar_quantidade($objPlaca, 1, 12, true);

            foreach ($arr_qnts[0] as $arr_qnt) {
                if ($arr_qnt['count(*)'] > 1) {
                    $alert .= Alert::alert_danger('A amostra ' . $arr_qnt['conteudo'] . ' foi repetida ' . $arr_qnt['count(*)'] . ' vezes');
                    $arr_amostras_repetidas[] = $arr_qnt['conteudo'];
                    $error_qnt = true;
                }
            }

            $tubos_inexistentes = $objPlacaRN->consultar_tubos_inexistentes($objPlaca, 1, 12);
            foreach ($tubos_inexistentes as $tubo) {
                $alert .= Alert::alert_warning('Informe o local da amostra <strong>' . $tubo['nickname'] . '</strong>, visto não foi informada na placa mas faz parte da solicitação');
            }


        } else if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 2) {
            $incremento_na_placa_original = 6;
        }
        else if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 3) {
            $incremento_na_placa_original = 4;

            $objDivisaoProtocolo = new DivisaoProtocolo();
            $objDivisaoProtocolo = $objPlaca->getObjProtocolo()->getObjDivisao();

            /*
             * PRIMEIRA DIVISÃO DA PLACA
             */
            $arr_qnts0 = $objPlacaRN->solicitar_quantidade($objPlaca, 1, 4, true);
            foreach ($arr_qnts0[0] as $arr_qnt) {
                if ($arr_qnt['count(*)'] > 1) {
                    $alert .= Alert::alert_danger('A amostra ' . $arr_qnt['conteudo'] . ' foi repetida ' . $arr_qnt['count(*)'] . ' vezes na divisão ' . $objDivisaoProtocolo[0]->getNomeDivisao());
                    //$arr_amostras_repetidas[] = array('conteudo' => $qnt['conteudo'], 'divisao' => 0);
                    $error_qnt = true;
                    $arr_divisao_repeticao[0] = true;
                }

            }
            if (!$error_qnt) {
                $arr_divisao_repeticao[0] = false;
            }

            $tubos_inexistentes1 = $objPlacaRN->consultar_tubos_inexistentes($objPlaca, 1, 4);
            foreach ($tubos_inexistentes1 as $tubo) {
                $alert .= Alert::alert_warning('Informe o local da amostra <strong>' . $tubo['nickname'] . '</strong>,na divisão <strong>' . $objDivisaoProtocolo[0]->getNomeDivisao() . '</strong>, visto não foi informada na placa mas faz parte da solicitação');
            }

            /*
             * SEGUNDA DIVISÃO DA PLACA
             */
            $arr_qnts1 = $objPlacaRN->solicitar_quantidade($objPlaca, 5, 8, true);
            foreach ($arr_qnts1[0] as $arr_qnt) {
                if ($arr_qnt['count(*)'] > 1) {

                    $alert .= Alert::alert_danger('A amostra ' . $arr_qnt['conteudo'] . ' foi repetida ' . $arr_qnt['count(*)'] . ' vezes na divisão ' . $objDivisaoProtocolo[1]->getNomeDivisao());
                    //$arr_amostras_repetidas[] = array('conteudo' => $qnt['conteudo'], 'divisao' => 1);
                    $error_qnt = true;
                    $arr_divisao_repeticao[1] = true;
                }
            }
            if (!$error_qnt) {
                $arr_divisao_repeticao[1] = false;
            }

            $tubos_inexistentes2 = $objPlacaRN->consultar_tubos_inexistentes($objPlaca, 5, 8);
            foreach ($tubos_inexistentes2 as $tubo) {
                $alert .= Alert::alert_warning('Informe o local da amostra <strong>' . $tubo['nickname'] . '</strong>,na divisão <strong>' . $objDivisaoProtocolo[1]->getNomeDivisao() . '</strong>, visto não foi informada na placa mas faz parte da solicitação');
            }

            /*
            * TERCEIRA DIVISÃO DA PLACA
            */
            $arr_qnts2 = $objPlacaRN->solicitar_quantidade($objPlaca, 9, 12, true);
            foreach ($arr_qnts2[0] as $arr_qnt) {
                if ($arr_qnt['count(*)'] > 1) {
                    $alert .= Alert::alert_danger('A amostra ' . $arr_qnt['conteudo'] . ' foi repetida ' . $arr_qnt['count(*)'] . ' vezes na divisão ' . $objDivisaoProtocolo[2]->getNomeDivisao());
                    //$arr_amostras_repetidas[] = array('conteudo' => $qnt['conteudo'], 'divisao' => 2);
                    $error_qnt = true;
                    $arr_divisao_repeticao[2] = true;
                }
            }
            if (!$error_qnt) {
                $arr_divisao_repeticao[2] = false;
            }

            $tubos_inexistentes3 = $objPlacaRN->consultar_tubos_inexistentes($objPlaca, 9, 12);
            foreach ($tubos_inexistentes3 as $tubo) {
                $alert .= Alert::alert_warning('Informe o local da amostra <strong>' . $tubo['nickname'] . '</strong>,na divisão <strong>' . $objDivisaoProtocolo[2]->getNomeDivisao() . '</strong>, visto não foi informada na placa mas faz parte da solicitação');
            }


        } else if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 4) {
            $incremento_na_placa_original = 3;
        }


        $objPlacaAux = new Placa();
        $objPlacaAux->setIdPlaca($_GET['idPlaca']);
        $objPlacaAux = $objPlacaRN->consultar($objPlacaAux);
        if($_GET['idSituacao'] == 3){
            $alert .= Alert::alert_danger("A placa tem situação <strong>INVÁLIDA</strong>");
        }else if($error_qnt || count($tubos_inexistentes1) > 0 || count($tubos_inexistentes2) > 0 || count($tubos_inexistentes3) > 0) {

            $objPlacaAux->setSituacaoPlaca(PlacaRN::$STA_INVALIDA);
            $alert .= Alert::alert_danger("A placa tem situação <strong>INVÁLIDA</strong>");

        }else{
            $objPlacaAux->setSituacaoPlaca(PlacaRN::$STA_ATRASO_RTqPCR);

        }
        $objPlacaRN->alterar($objPlacaAux);


        $error = false;
        $arr_errors = array();

        $disabled = '';

        /*if ($_GET['idSituacao'] == 1 || $_GET['idSituacao'] == 3) {
            $disabled = '';
        } else {
            $disabled = ' disabled ';
        }*/

        $quantidade = 8;
        $letras = range('A', chr(ord('A') + $quantidade));

        $cols = (12 / count($objPlaca->getObjProtocolo()->getObjDivisao()));

        $tubo_placa = 0;
        $posicoes_array = 0;
        $cont = 1;


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


                                if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 3) {

                                    if ($arr_divisao_repeticao[0]) {
                                        //$cor = Utils::random_color(80);
                                        foreach ($arr_qnts0[1] as $arr_qnt) {
                                            if ($arr_qnt['conteudo'] == $pocoPlaca->getObjPoco()->getConteudo() &&
                                                $letras[$i - 1] == $arr_qnt['linha'] && $j == $arr_qnt['coluna']) {
                                                $style = ' style="background-color: rgba(255,0,0,0.2);border:2px solid red;"';
                                            }

                                        }
                                    }

                                    if ($arr_divisao_repeticao[1]) {
                                        foreach ($arr_qnts1[1] as $arr_qnt) {
                                            if ($arr_qnt['conteudo'] == $pocoPlaca->getObjPoco()->getConteudo() &&
                                                $letras[$i - 1] == $arr_qnt['linha'] && $j == $arr_qnt['coluna']) {
                                                $style = ' style="background-color: rgba(255,0,0,0.2);border:2px solid red;"';
                                            }

                                        }
                                    }

                                    if ($arr_divisao_repeticao[2]) {
                                        foreach ($arr_qnts2[1] as $arr_qnt) {
                                            if ($arr_qnt['conteudo'] == $pocoPlaca->getObjPoco()->getConteudo() &&
                                                $letras[$i - 1] == $arr_qnt['linha'] && $j == $arr_qnt['coluna']) {
                                                $style = ' style="background-color: rgba(255,0,0,0.2);border:2px solid red;"';
                                            }

                                        }
                                    }

                                }

                                if ($pocoPlaca->getObjPoco()->getSituacao() == PocoRN::$STA_LIBERADO) {
                                    $style = ' style="background-color: rgba(0,255,0,0.2);"';
                                }
                                else if($pocoPlaca->getObjPoco()->getSituacao() == PocoRN::$STA_OCUPADO) {
                                    $style = ' style="background-color: rgba(255,0,0,0.2);"';
                                    if (trim($pocoPlaca->getObjPoco()->getConteudo()) == 'BR' ||
                                        trim($pocoPlaca->getObjPoco()->getConteudo()) == 'C+' ||
                                        trim($pocoPlaca->getObjPoco()->getConteudo() == 'C-')) {
                                        $style = ' style="background-color: rgba(255,255,0,0.2);"';
                                    }
                                }
                                else if($pocoPlaca->getObjPoco()->getSituacao() == PocoRN::$STA_OCUPADO_INVALIDO){
                                    $style = ' style="background-color: rgba(0,0,0,0.2);"';
                                }

                                if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 1) {
                                    foreach ($arr_qnts[1] as $arr_qnt) {
                                        if ($arr_qnt['conteudo'] == $pocoPlaca->getObjPoco()->getConteudo() &&
                                            $letras[$i - 1] == $arr_qnt['linha'] && $j == $arr_qnt['coluna']) {
                                            $style = ' style="background-color: rgba(255,0,0,0.2);border:2px solid red;"';
                                        }

                                    }
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

                            if (isset($_POST['btn_arrumar_discrepancia'])) {
                                if (trim(strtoupper($_POST[$strPosicao])) == 'BR') {
                                    $pocoPlaca->getObjPoco()->setConteudo('BR');
                                    $pocoPlaca->getObjPoco()->setSituacao(PocoRN::$STA_OCUPADO);
                                    $pocoPlaca->getObjPoco()->setIdTuboFk(null);
                                    $objPocoRN->alterar($pocoPlaca->getObjPoco());
                                }
                                else if (trim(strtoupper($_POST[$strPosicao])) == 'C+') {
                                    $pocoPlaca->getObjPoco()->setConteudo('C+');
                                    $pocoPlaca->getObjPoco()->setIdTuboFk(null);
                                    $pocoPlaca->getObjPoco()->setSituacao(PocoRN::$STA_OCUPADO);
                                    $objPocoRN->alterar($pocoPlaca->getObjPoco());
                                }
                                else if (trim(strtoupper($_POST[$strPosicao])) == 'C-') {
                                    $pocoPlaca->getObjPoco()->setConteudo('C-');
                                    $pocoPlaca->getObjPoco()->setSituacao(PocoRN::$STA_OCUPADO);
                                    $pocoPlaca->getObjPoco()->setIdTuboFk(null);
                                    $objPocoRN->alterar($pocoPlaca->getObjPoco());
                                }
                                else {

                                    if (strlen(strtoupper($_POST[$strPosicao])) != 0) {
                                        $encontrou = false;
                                        $amostrasValidas = array();
                                        foreach ($objPlaca->getObjsAmostras() as $amostra) {
                                            if ($amostra->getNickname() == trim(strtoupper($_POST[$strPosicao]))) {
                                                $amostrasValidas[] = $amostra;
                                                $encontrou = true;
                                                $idTubo = $amostra->getObjTubo()->getIdTubo();
                                            }
                                        }

                                        if($objPlaca->getObjProtocolo()->getNumDivisoes() == 3){
                                            if($j>0 && $j<5 ){
                                                $idTubo = $amostrasValidas[0]->getObjTubo()->getIdTubo();
                                            }else if($j>=5 && $j<9){
                                                $idTubo = $amostrasValidas[1]->getObjTubo()->getIdTubo();
                                            }else if($j>9 && $j<=12){
                                                $idTubo = $amostrasValidas[2]->getObjTubo()->getIdTubo();
                                            }
                                        }/*else if($objPlaca->getObjProtocolo()->getNumDivisoes() == 1){

                                        }*/


                                        if (!$encontrou) {
                                            $arr_errors[] = $_POST[$strPosicao];
                                            $alert .= Alert::alert_danger("O código informado -" . trim(strtoupper($_POST[$strPosicao])) . "- não é o de uma amostra válida para essa placa");
                                        } else {
                                            //$pocoPlaca->getObjPoco()->setIdTuboFk($idTubo);
                                            $pocoPlaca->getObjPoco()->setConteudo(trim(strtoupper($_POST[$strPosicao])));
                                            $pocoPlaca->getObjPoco()->setIdTuboFk($idTubo);
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
        $table .= '<tr><td>  </td>';
        foreach ($objPlaca->getObjProtocolo()->getObjDivisao() as $divisao) {
            $table .= '<td colspan="' . $cols . '" style=" background: rgba(242,242,242,0.4);border-left:1px solid #d2d2d2;border-right:1px solid #d2d2d2; ">' . $divisao->getNomeDivisao() . '</td>';
        }
        $table .= '</tr>';
        $table .= '</table>';

        if (isset($_POST['btn_arrumar_discrepancia']) && count($arr_errors) == 0) {

            //ver se coincide com o resultado
            $objResultado->setIdRTqPCRFk($_GET['idRTqPCR']);
            $arr_resultados = $objResultadoRN->listar($objResultado);

            $objPocoPlaca->setIdPlacaFk($_GET['idPlaca']);
            $arrPocosPlaca = $objPocoPlacaRN->listar_completo($objPocoPlaca);
            /*
                echo "<pre>";
                print_r($arrPocosPlaca);
                echo "</pre>";
            */

            //print_r($arr_resultados);
            $arr_pocos_invalidos = array();
            foreach ($arr_resultados as $resultado) {
                $linha = $resultado->getWell()[0];
                if(strlen($resultado->getWell()) == 2){
                    $coluna = substr($resultado->getWell(),-1);
                }else{
                    $coluna = substr($resultado->getWell(),-2);
                }

                foreach ($arrPocosPlaca as $pocoPlaca) {
                    $poco = $pocoPlaca->getObjPoco();
                    //echo $coluna." == ".$poco->getColuna()."\n";
                    //echo $linha." == ".$poco->getLinha()."\n";

                    if ($poco->getLinha() == $linha && $poco->getColuna() == $coluna) {
                        if (($poco->getConteudo() != $resultado->getSampleName())){ //|| ((is_null($poco->getConteudo())) && (!is_null($resultado->getSampleName())))) {
                            $poco->setSituacao(PocoRN::$STA_OCUPADO_INVALIDO);
                            $objPocoRN->alterar($poco);
                            $arr_pocos_invalidos[] = $linha . $coluna;
                        }else if($poco->getConteudo() == $resultado->getSampleName()){
                            $poco->setSituacao(PocoRN::$STA_OCUPADO);
                            $objPocoRN->alterar($poco);
                        }else if((is_null($poco->getConteudo())) && (is_null($resultado->getSampleName()))){
                            $poco->setSituacao(PocoRN::$STA_LIBERADO);
                            $objPocoRN->alterar($poco);
                        }
                    }

                }

            }

            if (count($arr_pocos_invalidos) > 0) {
                //$arr = array_unique($arr_pocos_invalidos);
                //foreach ($arr as $pocoInvalido){
                //    $str .= $pocoInvalido.", ";
                //}
                //$str = substr($str, 0, -2);
                //$alert .= Alert::alert_warning("Poços " . $str . ' inválidos');
                $bool_amostras_discrepantes = true;
                if ($bool_amostras_discrepantes) {
                    header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=finalizar_RTqPCR&idRTqPCR=' . $_GET['idRTqPCR'] . '&idPlaca=' . $_GET['idPlaca'] . '&idEquipamento=' . $_GET['idEquipamento'] . '&idSituacao=1&idDiscrepancia=1'));

                } else {
                    header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=finalizar_RTqPCR&idRTqPCR=' . $_GET['idRTqPCR'] . '&idPlaca=' . $_GET['idPlaca'] . '&idEquipamento=' . $_GET['idEquipamento'] . '&idSituacao=0&idDiscrepancia=0'));
                }
                die();
            } else {


                $error_qnt = false;
                $arr_amostras_repetidas = array();
                $arr_divisao_repeticao = array();

                //caso aumentem, tem que aumentar aqui
                if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 1) {
                    $incremento_na_placa_original = 0;
                    $arr_qnts = $objPlacaRN->solicitar_quantidade($objPlaca, 1, 12, true);

                    foreach ($arr_qnts[0] as $arr_qnt) {
                        if ($arr_qnt['count(*)'] > 1) {
                            $alert .= Alert::alert_danger('A amostra ' . $arr_qnt['conteudo'] . ' foi repetida ' . $arr_qnt['count(*)'] . ' vezes');
                            $arr_amostras_repetidas[] = $arr_qnt['conteudo'];
                            $error_qnt = true;
                        }
                    }

                    $tubos_inexistentes = $objPlacaRN->consultar_tubos_inexistentes($objPlaca, 1, 12);
                    foreach ($tubos_inexistentes as $tubo) {
                        $alert .= Alert::alert_warning('Informe o local da amostra <strong>' . $tubo['nickname'] . '</strong>, visto não foi informada na placa mas faz parte da solicitação');
                    }


                } else if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 2) {
                    $incremento_na_placa_original = 6;
                } else if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 3) {
                    $incremento_na_placa_original = 4;

                    $objDivisaoProtocolo = new DivisaoProtocolo();
                    $objDivisaoProtocolo = $objPlaca->getObjProtocolo()->getObjDivisao();

                    /*
                     * PRIMEIRA DIVISÃO DA PLACA
                     */
                    $arr_qnts0 = $objPlacaRN->solicitar_quantidade($objPlaca, 1, 4, true);
                    foreach ($arr_qnts0[0] as $arr_qnt) {
                        if ($arr_qnt['count(*)'] > 1) {
                            $alert .= Alert::alert_danger('A amostra ' . $arr_qnt['conteudo'] . ' foi repetida ' . $arr_qnt['count(*)'] . ' vezes na divisão ' . $objDivisaoProtocolo[0]->getNomeDivisao());
                            //$arr_amostras_repetidas[] = array('conteudo' => $qnt['conteudo'], 'divisao' => 0);
                            $error_qnt = true;
                            $arr_divisao_repeticao[0] = true;
                        }

                    }
                    if (!$error_qnt) {
                        $arr_divisao_repeticao[0] = false;
                    }

                    $tubos_inexistentes1 = $objPlacaRN->consultar_tubos_inexistentes($objPlaca, 1, 4);
                    foreach ($tubos_inexistentes1 as $tubo) {
                        $alert .= Alert::alert_warning('Informe o local da amostra <strong>' . $tubo['nickname'] . '</strong>,na divisão <strong>' . $objDivisaoProtocolo[0]->getNomeDivisao() . '</strong>, visto não foi informada na placa mas faz parte da solicitação');
                    }

                    /*
                     * SEGUNDA DIVISÃO DA PLACA
                     */
                    $arr_qnts1 = $objPlacaRN->solicitar_quantidade($objPlaca, 5, 8, true);
                    foreach ($arr_qnts1[0] as $arr_qnt) {
                        if ($arr_qnt['count(*)'] > 1) {

                            $alert .= Alert::alert_danger('A amostra ' . $arr_qnt['conteudo'] . ' foi repetida ' . $arr_qnt['count(*)'] . ' vezes na divisão ' . $objDivisaoProtocolo[1]->getNomeDivisao());
                            //$arr_amostras_repetidas[] = array('conteudo' => $qnt['conteudo'], 'divisao' => 1);
                            $error_qnt = true;
                            $arr_divisao_repeticao[1] = true;
                        }
                    }
                    if (!$error_qnt) {
                        $arr_divisao_repeticao[1] = false;
                    }

                    $tubos_inexistentes2 = $objPlacaRN->consultar_tubos_inexistentes($objPlaca, 5, 8);
                    foreach ($tubos_inexistentes2 as $tubo) {
                        $alert .= Alert::alert_warning('Informe o local da amostra <strong>' . $tubo['nickname'] . '</strong>,na divisão <strong>' . $objDivisaoProtocolo[1]->getNomeDivisao() . '</strong>, visto não foi informada na placa mas faz parte da solicitação');
                    }

                    /*
                    * TERCEIRA DIVISÃO DA PLACA
                    */
                    $arr_qnts2 = $objPlacaRN->solicitar_quantidade($objPlaca, 9, 12, true);
                    foreach ($arr_qnts2[0] as $arr_qnt) {
                        if ($arr_qnt['count(*)'] > 1) {
                            $alert .= Alert::alert_danger('A amostra ' . $arr_qnt['conteudo'] . ' foi repetida ' . $arr_qnt['count(*)'] . ' vezes na divisão ' . $objDivisaoProtocolo[2]->getNomeDivisao());
                            //$arr_amostras_repetidas[] = array('conteudo' => $qnt['conteudo'], 'divisao' => 2);
                            $error_qnt = true;
                            $arr_divisao_repeticao[2] = true;
                        }
                    }
                    if (!$error_qnt) {
                        $arr_divisao_repeticao[2] = false;
                    }

                    $tubos_inexistentes3 = $objPlacaRN->consultar_tubos_inexistentes($objPlaca, 9, 12);
                    foreach ($tubos_inexistentes3 as $tubo) {
                        $alert .= Alert::alert_warning('Informe o local da amostra <strong>' . $tubo['nickname'] . '</strong>,na divisão <strong>' . $objDivisaoProtocolo[2]->getNomeDivisao() . '</strong>, visto não foi informada na placa mas faz parte da solicitação');
                    }


                } else if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 4) {
                    $incremento_na_placa_original = 3;
                }

                $objPlacaAux = new Placa();
                $objPlacaAux->setIdPlaca($_GET['idPlaca']);
                $objPlacaAux = $objPlacaRN->consultar($objPlacaAux);
                if ($error_qnt || count($tubos_inexistentes1) > 0 || count($tubos_inexistentes2) > 0 || count($tubos_inexistentes3) > 0) {
                    //echo "aqui";
                    $objPlacaAux->setSituacaoPlaca(PlacaRN::$STA_INVALIDA);
                    $objPlacaRN->alterar($objPlacaAux);
                    header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=finalizar_RTqPCR&idRTqPCR=' . $_GET['idRTqPCR'] . '&idPlaca=' . $_GET['idPlaca'] . '&idEquipamento=' . $_GET['idEquipamento'] . '&idSituacao=3'));
                    die();
                    //$alert = Alert::alert_danger("A placa tem situação <strong>INVÁLIDA</strong>");
                }

                header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=finalizar_RTqPCR&idRTqPCR=' . $_GET['idRTqPCR'] . '&idPlaca=' . $_GET['idPlaca'] . '&idEquipamento=' . $_GET['idEquipamento'] . '&idSituacao=4&idDiscrepancia=' . $_GET['idDiscrepancia']));
                die();

            }
        }

    }

    if(isset($_POST['btn_prosseguir'])){

        $objPlaca->setIdPlaca($_GET['idPlaca']);
        $objPlaca = $objPlacaRN->consultar($objPlaca);

        if($objPlaca->getSituacaoPlaca() == PlacaRN::$STA_INVALIDA){
            $alert .= Alert::alert_danger("A placa está <strong>inválida</strong> então não é possível prosseguir");
        }else {

            $objRTqPcr->setIdRTqPCR($_GET['idRTqPCR']);
            $objRTqPcr = $objRTqPcrRN->consultar($objRTqPcr);


            $objPocoPlaca->setIdPlacaFk($_GET['idPlaca']);
            $arr_rel_poco_placa = $objPocoPlacaRN->listar_completo($objPocoPlaca);


            $arr_amostras_invalidas = array();
            foreach ($arr_rel_poco_placa as $relacionamento) {
                $poco = $relacionamento->getObjPoco();
                if($poco->getConteudo()[0] == PerfilPacienteRN::$TE_OUTROS || $poco->getConteudo()[0] == PerfilPacienteRN::$TP_PREFEITURA_PORTO_ALEGRE ||
                    $poco->getConteudo()[0] == PerfilPacienteRN::$TP_FUNCIONARIOS_ENGIE || $poco->getConteudo()[0] == PerfilPacienteRN::$TP_PROFISSIONAIS_SAUDE ||
                    $poco->getConteudo()[0] == PerfilPacienteRN::$TP_PACIENTES_SUS ||  $poco->getConteudo()[0] == PerfilPacienteRN::$TP_VOLUNTARIOS
                    && is_int($poco->getConteudo()[1])) {
                    //$objAmostra = $poco->getObjTubo();
                    if ($poco->getSituacao() == PocoRN::$STA_OCUPADO_INVALIDO) {
                        if(!in_array($poco->getConteudo(),$arr_amostras_invalidas)) {
                            $arr_amostras_invalidas[] = $poco->getConteudo();
                        }
                    }
                }
            }

            //print_r($arr_amostras_invalidas);


            $arr_ids = array();
            foreach ($arr_rel_poco_placa as $relacionamento) {
                $poco = $relacionamento->getObjPoco();
                /*echo "<pre>";
                print_r($poco);
                echo "</pre>";*/

                if($poco->getConteudo()[0] == PerfilPacienteRN::$TE_OUTROS || $poco->getConteudo()[0] == PerfilPacienteRN::$TP_PREFEITURA_PORTO_ALEGRE ||
                    $poco->getConteudo()[0] == PerfilPacienteRN::$TP_FUNCIONARIOS_ENGIE || $poco->getConteudo()[0] == PerfilPacienteRN::$TP_PROFISSIONAIS_SAUDE ||
                    $poco->getConteudo()[0] == PerfilPacienteRN::$TP_PACIENTES_SUS ||  $poco->getConteudo()[0] == PerfilPacienteRN::$TP_VOLUNTARIOS
                    && is_int($poco->getConteudo()[1])) {
                    //print_r($poco);
                    $arr_infos = array();
                    $objAmostra = $poco->getObjTubo();
                    $tubo = $poco->getObjTubo()->getObjTubo();
                    $tam = count($poco->getObjTubo()->getObjTubo()->getObjInfosTubo());
                    $objInfosTubo = $poco->getObjTubo()->getObjTubo()->getObjInfosTubo()[$tam - 1];
                    //foreach ($arr_amostras_invalidas as $amostrasInvalidas){
                        if(in_array($objAmostra->getNickname(),$arr_amostras_invalidas)){
                            $objTuboAux = $objAmostraRN->consultar_volume($objAmostra);

                            if (!is_null($objTuboAux)) {

                                if($poco->getSituacao() == PocoRN::$STA_OCUPADO_INVALIDO) {
                                    $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_LOCAL_ERRADO_POCO);
                                }else if($poco->getSituacao() == PocoRN::$STA_OCUPADO){
                                    $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_NO_POCO);
                                }
                                $objInfosTubo->setIdInfosTubo(null);
                                $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                                $objInfosTubo->setEtapa(InfosTuboRN::$TP_RTqPCR);
                                $objInfosTubo->setEtapaAnterior(InfosTuboRN::$TP_RTqPCR_MONTAGEM_PLACA);
                                $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                                $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                                $arr_infos[0] = $objInfosTubo;

                                if(!in_array($objAmostra->getNickname(),$arr_ids)) {
                                    $arr_ids[] = $objAmostra->getNickname();

                                    $objInfosTuboAliquota = $objTuboAux->getObjInfosTubo();
                                    $objInfosTuboAliquota->setIdInfosTubo(null);
                                    $objInfosTuboAliquota->setIdTubo_fk($objTuboAux->getIdTubo());
                                    $objInfosTuboAliquota->setSituacaoTubo(InfosTuboRN::$TST_SEM_UTILIZACAO);
                                    $objInfosTuboAliquota->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                                    $objInfosTuboAliquota->setEtapa(InfosTuboRN::$TP_MONTAGEM_GRUPOS_AMOSTRAS);
                                    $objInfosTuboAliquota->setEtapaAnterior(InfosTuboRN::$TP_PREPARACAO_INATIVACAO);
                                    $objInfosTuboAliquota->setDataHora(date("Y-m-d H:i:s"));
                                    $objInfosTuboAliquota->setReteste('s');
                                    $objInfosTuboAliquota->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                                    $objInfosTuboAliquota->setObservacoes("Problemas no RTqPCR --> nova montagem");

                                    $objTuboAux->setObjInfosTubo($objInfosTuboAliquota);
                                    $objAmostra->setObjTubo($objTuboAux);
                                    $arr_tubos[] = $objTuboAux;
                                }

                            } else {//laudo
                                $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_LOCAL_ERRADO_POCO);
                                $objInfosTubo->setIdInfosTubo(null);
                                $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                                $objInfosTubo->setEtapa(InfosTuboRN::$TP_RTqPCR);
                                $objInfosTubo->setEtapaAnterior(InfosTuboRN::$TP_RTqPCR_MONTAGEM_PLACA);
                                $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                                $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                                $arr_infos[0] = $objInfosTubo;


                                $objInfosTuboAux = new InfosTubo();
                                $objInfosTuboAux->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                                $objInfosTuboAux->setIdPosicao_fk($objInfosTubo->getIdPosicao_fk());
                                $objInfosTuboAux->setIdTubo_fk($poco->getIdTuboFk());
                                $objInfosTuboAux->setIdLote_fk($objInfosTubo->getIdLote_fk());
                                $objInfosTuboAux->setEtapa(InfosTuboRN::$TP_DIAGNOSTICO);
                                $objInfosTuboAux->setEtapaAnterior(InfosTuboRN::$TP_RTqPCR);
                                $objInfosTuboAux->setDataHora(date("Y-m-d H:i:s"));
                                $objInfosTuboAux->setReteste($objInfosTubo->getReteste());
                                $objInfosTuboAux->setVolume($objInfosTubo->getVolume());
                                $objInfosTuboAux->setObsProblema($objInfosTubo->getObsProblema());
                                $objInfosTuboAux->setObservacoes($objInfosTubo->getObservacoes());
                                $objInfosTuboAux->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                                $objInfosTuboAux->setSituacaoTubo(InfosTuboRN::$TST_DESCARTADO);
                                $objInfosTuboAux->setIdLocalFk($objInfosTubo->getIdLocalFk());
                                $arr_infos[1] = $objInfosTuboAux;


                            }
                        }else if ($poco->getSituacao() == PocoRN::$STA_OCUPADO) {
                            $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_SEM_UTILIZACAO);
                            $objInfosTubo->setIdInfosTubo(null);
                            $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                            $objInfosTubo->setEtapa(InfosTuboRN::$TP_RTqPCR);
                            $objInfosTubo->setEtapaAnterior(InfosTuboRN::$TP_RTqPCR_MONTAGEM_PLACA);
                            $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                            $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                            $arr_infos[0] = $objInfosTubo;


                            $objInfosTuboAux = new InfosTubo();
                            $objInfosTuboAux->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                            $objInfosTuboAux->setIdPosicao_fk($objInfosTubo->getIdPosicao_fk());
                            $objInfosTuboAux->setIdTubo_fk($poco->getIdTuboFk());
                            $objInfosTuboAux->setIdLote_fk($objInfosTubo->getIdLote_fk());
                            $objInfosTuboAux->setEtapa(InfosTuboRN::$TP_DIAGNOSTICO);
                            $objInfosTuboAux->setEtapaAnterior(InfosTuboRN::$TP_RTqPCR);
                            $objInfosTuboAux->setDataHora(date("Y-m-d H:i:s"));
                            $objInfosTuboAux->setReteste($objInfosTubo->getReteste());
                            $objInfosTuboAux->setVolume($objInfosTubo->getVolume());
                            $objInfosTuboAux->setObsProblema($objInfosTubo->getObsProblema());
                            $objInfosTuboAux->setObservacoes($objInfosTubo->getObservacoes());
                            $objInfosTuboAux->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                            $objInfosTuboAux->setSituacaoTubo(InfosTuboRN::$TST_EM_UTILIZACAO);
                            $objInfosTuboAux->setIdLocalFk($objInfosTubo->getIdLocalFk());
                            $arr_infos[1] = $objInfosTuboAux;
                        }

                        $objTubo = $tubo;
                        $objTubo->setObjInfosTubo($arr_infos);
                        $arr_tubos[] = $objTubo;
                    //}

                }

                /*if (!is_null($poco->getObjTubo())) {
                    $objAmostra = $poco->getObjTubo();

                    $tubo = $poco->getObjTubo()->getObjTubo();
                    $tam = count($poco->getObjTubo()->getObjTubo()->getObjInfosTubo());
                    $objInfosTubo = $poco->getObjTubo()->getObjTubo()->getObjInfosTubo()[$tam - 1];

                    if ($_GET['idDiscrepancia'] == 1) {

                        //verificar se tem amostra com mais volume
                        $objTuboAux = $objAmostraRN->consultar_volume($objAmostra);
                        if(!is_null($objTuboAux)){
                            $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_LOCAL_ERRADO_POCO);
                            $objInfosTubo->setIdInfosTubo(null);
                            $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                            $objInfosTubo->setEtapa(InfosTuboRN::$TP_RTqPCR);
                            $objInfosTubo->setEtapaAnterior(InfosTuboRN::$TP_RTqPCR_MONTAGEM_PLACA);
                            $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                            $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                            $arr_infos[0] = $objInfosTubo;

                            $objInfosTuboAliquota = $objTuboAux->getObjInfosTubo();
                            $objInfosTuboAliquota->setIdInfosTubo(null);
                            $objInfosTuboAliquota->setSituacaoTubo(InfosTuboRN::$TST_SEM_UTILIZACAO);
                            $objInfosTuboAliquota->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                            $objInfosTuboAliquota->setEtapa(InfosTuboRN::$TP_MONTAGEM_GRUPOS_AMOSTRAS);
                            $objInfosTuboAliquota->setEtapaAnterior(InfosTuboRN::$TP_PREPARACAO_INATIVACAO);
                            $objInfosTuboAliquota->setDataHora(date("Y-m-d H:i:s"));
                            $objInfosTuboAliquota->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);

                            $objTuboAux->setObjInfosTubo($objInfosTuboAliquota);
                            $arr_tubos[] = $objTuboAux;

                        }else{//laudo
                            $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_LOCAL_ERRADO_POCO);
                            $objInfosTubo->setIdInfosTubo(null);
                            $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                            $objInfosTubo->setEtapa(InfosTuboRN::$TP_RTqPCR);
                            $objInfosTubo->setEtapaAnterior(InfosTuboRN::$TP_RTqPCR_MONTAGEM_PLACA);
                            $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                            $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                            $arr_infos[0] = $objInfosTubo;


                            $objInfosTuboAux = new InfosTubo();
                            $objInfosTuboAux->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                            $objInfosTuboAux->setIdPosicao_fk($objInfosTubo->getIdPosicao_fk());
                            $objInfosTuboAux->setIdTubo_fk($poco->getIdTuboFk());
                            $objInfosTuboAux->setIdLote_fk($objInfosTubo->getIdLote_fk());
                            $objInfosTuboAux->setEtapa(InfosTuboRN::$TP_LAUDO);
                            $objInfosTuboAux->setEtapaAnterior(InfosTuboRN::$TP_RTqPCR);
                            $objInfosTuboAux->setDataHora(date("Y-m-d H:i:s"));
                            $objInfosTuboAux->setReteste($objInfosTubo->getReteste());
                            $objInfosTuboAux->setVolume($objInfosTubo->getVolume());
                            $objInfosTuboAux->setObsProblema($objInfosTubo->getObsProblema());
                            $objInfosTuboAux->setObservacoes($objInfosTubo->getObservacoes());
                            $objInfosTuboAux->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                            $objInfosTuboAux->setSituacaoTubo(InfosTuboRN::$TST_DESCARTADO);
                            $objInfosTuboAux->setIdLocalFk($objInfosTubo->getIdLocalFk());
                            $arr_infos[1] = $objInfosTuboAux;
                        }
                    } else {


                        $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_SEM_UTILIZACAO);
                        $objInfosTubo->setIdInfosTubo(null);
                        $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                        $objInfosTubo->setEtapa(InfosTuboRN::$TP_RTqPCR);
                        $objInfosTubo->setEtapaAnterior(InfosTuboRN::$TP_RTqPCR_MONTAGEM_PLACA);
                        $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                        $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                        $arr_infos[0] = $objInfosTubo;


                        $objInfosTuboAux = new InfosTubo();
                        $objInfosTuboAux->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                        $objInfosTuboAux->setIdPosicao_fk($objInfosTubo->getIdPosicao_fk());
                        $objInfosTuboAux->setIdTubo_fk($poco->getIdTuboFk());
                        $objInfosTuboAux->setIdLote_fk($objInfosTubo->getIdLote_fk());
                        $objInfosTuboAux->setEtapa(InfosTuboRN::$TP_DIAGNOSTICO);
                        $objInfosTuboAux->setEtapaAnterior(InfosTuboRN::$TP_RTqPCR);
                        $objInfosTuboAux->setDataHora(date("Y-m-d H:i:s"));
                        $objInfosTuboAux->setReteste($objInfosTubo->getReteste());
                        $objInfosTuboAux->setVolume($objInfosTubo->getVolume());
                        $objInfosTuboAux->setObsProblema($objInfosTubo->getObsProblema());
                        $objInfosTuboAux->setObservacoes($objInfosTubo->getObservacoes());
                        $objInfosTuboAux->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                        $objInfosTuboAux->setSituacaoTubo(InfosTuboRN::$TST_EM_UTILIZACAO);
                        $objInfosTuboAux->setIdLocalFk($objInfosTubo->getIdLocalFk());
                        $arr_infos[1] = $objInfosTuboAux;
                    }
                    $objTubo = $tubo;
                    $objTubo->setObjInfosTubo($arr_infos);
                    $arr_tubos[] = $objTubo;


                }*/

            }



            /*
                echo "<pre>";
                print_r($arr_tubos);
                echo "</pre>";
            */

            $objPlaca->setObjsTubos($arr_tubos);

            $objRTqPcr->setSituacaoRTqPCR(RTqPCR_RN::$STA_FINALIZADO);
            $objPlaca->setSituacaoPlaca(PlacaRN::$STA_RTqPCR_FINALIZADO);
            $objRTqPcr->setObjPlaca($objPlaca);
            $objRTqPcr = $objRTqPcrRN->alterar($objRTqPcr);

            $objEquipamento->setIdEquipamento($_GET['idEquipamento']);
            $objEquipamento = $objEquipamentoRN->consultar($objEquipamento);
            $objEquipamento->setSituacaoEquipamento(EquipamentoRN::$TE_LIBERADO);
            $objEquipamento = $objEquipamentoRN->alterar($objEquipamento);
            header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_analise_RTqPCR'));
            die();
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
if(!isset($_GET['idSituacao']) && !isset($_GET['idComResultado'])) {
    echo '<div class="conteudo_grande"   style="margin-top: 0px;"> 
                <form enctype="multipart/form-data" method="POST">
                    <!-- MAX_FILE_SIZE deve preceder o campo input -->
                    <input type="hidden" name="MAX_FILE_SIZE" value="8000000" />
                    <!-- O Nome do elemento input determina o nome da array $_FILES -->
                    Enviar esse arquivo: <input name="the_file" type="file" />
                    <input type="submit"  name="btn_upload" value="Enviar arquivo" />
                </form>
           </div>';
}else{
    echo  '<div class="conteudo_grande"   style="margin-top: 0px;"> 
                <form method="POST">  
                    <div class="form-row">
                        <div class="col-md-12" style="text-align: center;">
                            '.$table.'
                        </div>
                    </div>';
    //tem amostras discrepantes
    if($_GET['idSituacao'] == 1 || $_GET['idSituacao'] == 3 ) {
        if ($_GET['idSituacao'] == 1){
            $colmd = 'col-md-6';
        }else{
            $colmd = 'col-md-12';
        }
        echo '<div class="form-row">  
                <div class="'.$colmd.'">
                   <button class="btn btn-primary" type="submit" style="width: 80%;margin-left: 10%;" name="btn_arrumar_discrepancia">ARRUMAR DISCREPÂNCIA NO POÇO</button>
                </div>';
        if ($_GET['idSituacao'] == 1){
            echo '<div class="col-md-6" >
                    <button class="btn btn-primary" type="submit" style="width: 80%; margin-left: 100px;" name="btn_prosseguir">APENAS PROSSEGUIR</button>
                </div>';
        }
        echo ' </div>';
    }else  if($_GET['idSituacao'] == 4 || $_GET['idDiscrepancia'] == 0 ){
        echo '<div class="form-row">  
                <div class="col-md-6" >
                    <button class="btn btn-primary" type="submit" style="width: 80%; margin-left: 20%;" name="btn_arrumar_discrepancia">EDITAR POÇO</button>
                </div>
                <div class="col-md-6" >
                    <button class="btn btn-primary" type="submit" style="width: 80%; margin-left: 0%;" name="btn_prosseguir">PROSSEGUIR</button>
                </div>
              </div>';

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