<?php
session_start();
try{

    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';

    require_once __DIR__ . '/../../classes/Poco/Poco.php';
    require_once __DIR__ . '/../../classes/Poco/PocoRN.php';

    require_once __DIR__ . '/../../classes/Placa/Placa.php';
    require_once __DIR__ . '/../../classes/Placa/PlacaRN.php';

    require_once __DIR__ . '/../../classes/RelPocoPlaca/PocoPlaca.php';
    require_once __DIR__ . '/../../classes/RelPocoPlaca/PocoPlacaRN.php';

    require_once __DIR__ . '/../../classes/DivisaoProtocolo/DivisaoProtocolo.php';
    require_once __DIR__ . '/../../classes/DivisaoProtocolo/DivisaoProtocoloRN.php';

    require_once __DIR__ . '/../../classes/RelTuboPlaca/RelTuboPlaca.php';
    require_once __DIR__ . '/../../classes/RelTuboPlaca/RelTuboPlacaRN.php';

    require_once __DIR__ . '/../../classes/SolicitacaoMontarPlaca/SolicitacaoMontarPlaca.php';
    require_once __DIR__ . '/../../classes/SolicitacaoMontarPlaca/SolicitacaoMontarPlacaRN.php';
    require_once __DIR__ . '/../../classes/SolicitacaoMontarPlaca/SolicitacaoMontarPlacaINT.php';

    require_once  __DIR__.'/../../utils/Utils.php';

    require_once __DIR__.'/../../classes/MixRTqPCR/MixRTqPCR.php';
    require_once __DIR__.'/../../classes/MixRTqPCR/MixRTqPCR_RN.php';
    require_once __DIR__.'/../../classes/MixRTqPCR/MixRTqPCR_INT.php';

    require_once __DIR__ . '/../../classes/RelPerfilPlaca/RelPerfilPlaca.php';
    require_once __DIR__ . '/../../classes/RelPerfilPlaca/RelPerfilPlacaRN.php';

    require_once __DIR__ . '/../../classes/MontagemPlaca/MontagemPlaca.php';
    require_once __DIR__ . '/../../classes/MontagemPlaca/MontagemPlacaRN.php';

    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTexto.php';
    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTextoRN.php';


    Sessao::getInstance()->validar();
    date_default_timezone_set('America/Sao_Paulo');
    $_SESSION['DATA_LOGIN'] = date("Y-m-d H:i:s");
    $objUtils = new Utils();

    /*
     * SOLICITAÇÃO DE MONTAGEM DA PLACA RTqPCR
     */
    $objSolMontarPlaca = new SolicitacaoMontarPlaca();
    $objSolMontarPlacaRN = new SolicitacaoMontarPlacaRN();

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
    *  PLACA
    */
    $objPlaca = new Placa();
    $objPlacaRN = new PlacaRN();

    /*
    *  POÇO + PLACA
    */
    $objPocoPlaca = new PocoPlaca();
    $objPocoPlacaRN = new PocoPlacaRN();

    /*
    *  RELACIONAMENTO TUBO + PLACA
    */
    $objRelTuboPlaca = new RelTuboPlaca();
    $objRelTuboPlacaRN = new RelTuboPlacaRN();


    /*
     *  MIX
     */
    $objMix = new MixRTqPCR();
    $objMixRN = new MixRTqPCR_RN();

    /*
    *  MONTAGEM PLACA
    */
    $objMontagemPlaca = new MontagemPlaca();
    $objMontagemPlacaRN = new MontagemPlacaRN();

    $arr_pocos = array();
    $select_mix = '';
    //$disabled = ' disabled ';

    if(!isset($_GET['idMontagem']) && !isset($_GET['idMix'])) {
        $objMix = new MixRTqPCR();
        $objMix->setSituacaoMix(MixRTqPCR_RN::$STA_TRANSPORTE_MONTAGEM);
        MixRTqPCR_INT::montar_select_mix_dadaSituacao($select_mix, $objMix, $objMixRN, null, true);
    }

    if(isset($_POST['sel_mix'])){
        $objMix->setIdMixPlaca($_POST['sel_mix']);
        $arr = $objMixRN->listar($objMix,null, true);
        $objMix = $arr[0];


         //   echo "<pre>";
         //   print_r($objMix);
         //   echo "</pre>";


        $objMix->setSituacaoMix(MixRTqPCR_RN::$STA_TRANSPORTE_MONTAGEM);
        MixRTqPCR_INT::montar_select_mix_dadaSituacao($select_mix,$objMix,$objMixRN,true,true);
        $objSolMontarPlaca = $objMix->getObjSolicitacao();
        $objPlaca = $objMix->getObjSolicitacao()->getObjPlaca();

        $objPlaca->setSituacaoPlaca(PlacaRN::$STA_NA_MONTAGEM);

        foreach ($objPlaca->getObjRelTuboPlaca() as $relTuboPlaca){
            foreach ($relTuboPlaca->getObjTubo() as $amostra){
                $tam =  count($amostra->getObjTubo()->getObjInfosTubo());
                $tam -= 1;
                $objInfosTubo = new InfosTubo();
                $objInfosTubo = $amostra->getObjTubo()->getObjInfosTubo()[$tam];
              //  echo "<pre>";
              //  print_r($objInfosTubo);
              //  echo "</pre>";

                $objInfosTubo->setIdInfosTubo(null);
                $objInfosTubo->setEtapaAnterior(InfosTuboRN::$TP_RTqPCR_MIX_PLACA);
                $objInfosTubo->setEtapa(InfosTuboRN::$TP_RTqPCR_MONTAGEM_PLACA);
                $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_EM_ANDAMENTO);
                $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_EM_UTILIZACAO);
                $arr_infos[] = $objInfosTubo;
            }
        }
       // die();
        $objMontagemPlaca->setIdUsuarioFk(Sessao::getInstance()->getIdUsuario());
        $objMontagemPlaca->setIdMixFk($objMix->getIdMixPlaca());
        $objMontagemPlaca->setDataHoraFim(date("Y-m-d H:i:s"));
        $objMontagemPlaca->setDataHoraInicio($_SESSION['DATA_LOGIN']);
        $objMontagemPlaca->setSituacaoMontagem(MontagemPlacaRN::$STA_MONTAGEM_ANDAMENTO);
        $objMontagemPlaca->setObjInfosTubo($arr_infos);
        $objPlaca->setObjProtocolo(null);
        $objPlaca->setObjsTubos(null);
        $objPlaca->setObjsAmostras(null);
        $objPlaca->setObjRelPerfilPlaca(null);
        $objPlaca->setObjRelTuboPlaca(null);
        $objPlaca->setObjsPocosPlacas(null);
        $objMix->setObjPlaca($objPlaca);
        $objMix->setSituacaoMix(MixRTqPCR_RN::$STA_NA_MONTAGEM);
        $objMontagemPlaca->setObjMix($objMix);
        $objMontagemPlaca = $objMontagemPlacaRN->cadastrar($objMontagemPlaca);
        header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=montar_placa_RTqPCR&idMontagem='.$objMontagemPlaca->getIdMontagem().'&idMix='.$_POST['sel_mix']));
        die();
    }


    if (isset($_GET['idMontagem']) && isset($_GET['idMix'])) {
        $objMix->setIdMixPlaca($_GET['idMix']);
        $arr = $objMixRN->listar($objMix,null, true);
        $objMix = $arr[0];

        /*
            echo "<pre>";
            print_r($objMix);
            echo "</pre>";
        */

        MixRTqPCR_INT::montar_select_mix_dadaSituacao($select_mix,$objMix,$objMixRN,true,true);
        $objSolMontarPlaca = $objMix->getObjSolicitacao();
        $objPlacaAux = $objMix->getObjSolicitacao()->getObjPlaca();
        $objPlaca = $objPlacaRN->consultar_completo($objPlacaAux);


        if (count($objPlaca->getObjsPocosPlacas()) == 0) {
            $objPoco->setObjPlaca($objPlaca);
            $objPocoRN->cadastrar($objPoco, 's');
            $objPlaca = $objPlacaRN->consultar_completo($objPlaca);
        }

        $error_qnt = false;
        $arr_amostras_repetidas = array();
        $arr_divisao_repeticao = array();

        //caso aumentem, tem que aumentar aqui
        if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 1) {
            $incremento_na_placa_original = 0;
            $arr_qnts = $objPlacaRN->solicitar_quantidade($objPlaca,1,12,true);

            foreach ($arr_qnts[0] as $arr_qnt) {
                if ($arr_qnt['count(*)'] > 1) {
                    $alert .= Alert::alert_danger('A amostra ' . $arr_qnt['conteudo'] . ' foi repetida ' . $arr_qnt['count(*)'] . ' vezes');
                    $arr_amostras_repetidas[] =  $arr_qnt['conteudo'];
                    $error_qnt = true;
                }
            }

            $tubos_inexistentes = $objPlacaRN->consultar_tubos_inexistentes($objPlaca,1,12);
            foreach ($tubos_inexistentes as $tubo){
                $alert .= Alert::alert_warning('Informe o local da amostra <strong>'.$tubo['nickname'].'</strong>, visto não foi informada na placa mas faz parte da solicitação');
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
            $arr_qnts0 = $objPlacaRN->solicitar_quantidade($objPlaca,1,4,true);
            foreach ($arr_qnts0[0] as $arr_qnt) {
                if ($arr_qnt['count(*)'] > 1) {
                    $alert .= Alert::alert_danger('A amostra ' . $arr_qnt['conteudo'] . ' foi repetida ' . $arr_qnt['count(*)'] . ' vezes na divisão '.$objDivisaoProtocolo[0]->getNomeDivisao());
                    //$arr_amostras_repetidas[] = array('conteudo' => $qnt['conteudo'], 'divisao' => 0);
                    $error_qnt = true;
                    $arr_divisao_repeticao[0] = true;
                }

            }
            if(!$error_qnt){$arr_divisao_repeticao[0] = false; }

            $tubos_inexistentes1 = $objPlacaRN->consultar_tubos_inexistentes($objPlaca,1,4);
            foreach ($tubos_inexistentes1 as $tubo){
                $alert .= Alert::alert_warning('Informe o local da amostra <strong>'.$tubo['nickname'].'</strong>,na divisão <strong>'.$objDivisaoProtocolo[0]->getNomeDivisao() .'</strong>, visto não foi informada na placa mas faz parte da solicitação');
            }

            /*
             * SEGUNDA DIVISÃO DA PLACA
             */
            $arr_qnts1 = $objPlacaRN->solicitar_quantidade($objPlaca,5,8,true);
            foreach ($arr_qnts1[0] as $arr_qnt) {
                if ($arr_qnt['count(*)'] > 1) {

                    $alert .= Alert::alert_danger('A amostra ' . $arr_qnt['conteudo'] . ' foi repetida ' . $arr_qnt['count(*)'] . ' vezes na divisão '.$objDivisaoProtocolo[1]->getNomeDivisao());
                    //$arr_amostras_repetidas[] = array('conteudo' => $qnt['conteudo'], 'divisao' => 1);
                    $error_qnt = true;
                    $arr_divisao_repeticao[1] = true;
                }
            }
            if(!$error_qnt){$arr_divisao_repeticao[1] = false; }

            $tubos_inexistentes2 = $objPlacaRN->consultar_tubos_inexistentes($objPlaca,5,8);
            foreach ($tubos_inexistentes2 as $tubo){
                $alert .= Alert::alert_warning('Informe o local da amostra <strong>'.$tubo['nickname'].'</strong>,na divisão <strong>'.$objDivisaoProtocolo[1]->getNomeDivisao() .'</strong>, visto não foi informada na placa mas faz parte da solicitação');
            }

            /*
            * TERCEIRA DIVISÃO DA PLACA
            */
            $arr_qnts2 = $objPlacaRN->solicitar_quantidade($objPlaca,9,12,true);
            foreach ($arr_qnts2[0] as $arr_qnt) {
                if ($arr_qnt['count(*)'] > 1) {
                    $alert .= Alert::alert_danger('A amostra ' . $arr_qnt['conteudo'] . ' foi repetida ' .$arr_qnt['count(*)'] . ' vezes na divisão '.$objDivisaoProtocolo[2]->getNomeDivisao());
                    //$arr_amostras_repetidas[] = array('conteudo' => $qnt['conteudo'], 'divisao' => 2);
                    $error_qnt = true;
                    $arr_divisao_repeticao[2] = true;
                }
            }
            if(!$error_qnt){$arr_divisao_repeticao[2] = false; }

            $tubos_inexistentes3 = $objPlacaRN->consultar_tubos_inexistentes($objPlaca,9,12);
            foreach ($tubos_inexistentes3 as $tubo){
                $alert .= Alert::alert_warning('Informe o local da amostra <strong>'.$tubo['nickname'].'</strong>,na divisão <strong>'.$objDivisaoProtocolo[2]->getNomeDivisao() .'</strong>, visto não foi informada na placa mas faz parte da solicitação');
            }


        } else if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 4) {
            $incremento_na_placa_original = 3;
        }

        $objMix->setIdMixPlaca($_GET['idMix']);
        $arr = $objMixRN->listar($objMix,null, true);
        $objMix = $arr[0];
        $objPlacaAux = $objMix->getObjSolicitacao()->getObjPlaca();
        $objPlacaAux = $objPlacaRN->consultar($objPlacaAux);
        if($error_qnt || count($tubos_inexistentes1) > 0 || count($tubos_inexistentes2) > 0 || count($tubos_inexistentes3) > 0) {
            $objPlacaAux->setSituacaoPlaca(PlacaRN::$STA_INVALIDA);
        }else{
            $objPlacaAux->setSituacaoPlaca(PlacaRN::$STA_NA_MONTAGEM);
        }

        if($objPlacaAux->getSituacaoPlaca() == PlacaRN::$STA_INVALIDA){
            $alert .= Alert::alert_danger("A placa tem situação <strong>INVÁLIDA</strong>");
        }
        $objPlacaRN->alterar($objPlacaAux);


        $error = false;
        $arr_errors = array();

        $table .= '<table class="table table-responsive table-hover" style="margin-top: 20px;">';
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

                                if ($pocoPlaca->getObjPoco()->getSituacao() == PocoRN::$STA_LIBERADO) {
                                    $style = ' style="background-color: rgba(0,255,0,0.2);"';
                                } else {
                                    $style = ' style="background-color: rgba(255,0,0,0.2);"';
                                }

                                if($objPlaca->getObjProtocolo()->getNumDivisoes() == 3) {

                                    if($arr_divisao_repeticao[0]){
                                        //$cor = Utils::random_color(80);
                                        foreach ($arr_qnts0[1] as $arr_qnt) {
                                            if($arr_qnt['conteudo'] == $pocoPlaca->getObjPoco()->getConteudo() &&
                                                $letras[$i-1] == $arr_qnt['linha'] && $j == $arr_qnt['coluna']){
                                                $style = ' style="background-color: rgba(255,0,0,0.2);border:2px solid red;"';
                                            }

                                        }
                                    }

                                    if($arr_divisao_repeticao[1]){
                                        foreach ($arr_qnts1[1] as $arr_qnt) {
                                            if($arr_qnt['conteudo'] == $pocoPlaca->getObjPoco()->getConteudo() &&
                                                $letras[$i-1] == $arr_qnt['linha'] && $j == $arr_qnt['coluna']){
                                                $style = ' style="background-color: rgba(255,0,0,0.2);border:2px solid red;"';
                                            }

                                        }
                                    }

                                    if($arr_divisao_repeticao[2]){
                                        foreach ($arr_qnts2[1] as $arr_qnt) {
                                            if($arr_qnt['conteudo'] == $pocoPlaca->getObjPoco()->getConteudo() &&
                                                $letras[$i-1] == $arr_qnt['linha'] && $j == $arr_qnt['coluna']){
                                                $style = ' style="background-color: rgba(255,0,0,0.2);border:2px solid red;"';
                                            }

                                        }
                                    }

                                }


                                if (trim($pocoPlaca->getObjPoco()->getConteudo()) == 'BR' ||
                                    trim($pocoPlaca->getObjPoco()->getConteudo()) == 'C+' ||
                                    trim($pocoPlaca->getObjPoco()->getConteudo() == 'C-')) {
                                    $style = ' style="background-color: rgba(255,255,0,0.2);"';
                                }

                                if($objPlaca->getObjProtocolo()->getNumDivisoes() == 1) {
                                    foreach ($arr_qnts[1] as $arr_qnt) {
                                        if($arr_qnt['conteudo'] == $pocoPlaca->getObjPoco()->getConteudo() &&
                                            $letras[$i-1] == $arr_qnt['linha'] && $j == $arr_qnt['coluna']){
                                            $style = ' style="background-color: rgba(255,0,0,0.2);border:2px solid red;"';
                                        }

                                    }
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



        // locais de armazenamento e volume
        $arr_JSCopiarLocal = array();
        $arr_JSCopiarCaixa = array();
        $arr_JSCopiarPorta = array();
        $arr_JSCopiarColuna = array();
        $arr_JSCopiarPrateleira = array();
        $primeiro = true;
        $contador = 0;
        $show_amostras = '';
        foreach ($objMix->getObjSolicitacao()->getObjPlaca()->getObjRelTuboPlaca() as $relacionamento){
            foreach ($relacionamento->getObjTubo() as $amostra)
            $arr_amostras[] = $amostra;
        }
        /*echo "<pre>";
        print_r($arr_amostras);
        echo "</pre>";*/

        foreach ($arr_amostras as $amostras) {
            $tam = count($amostras->getObjTubo()->getObjInfosTubo());
            $tam -= 1;
            $infotubo = $amostras->getObjTubo()->getObjInfosTubo()[$tam];
           // echo "<pre>";
           // print_r($infotubo);
           // echo "</pre>";
            $local = $amostras->getObjTubo()->getObjInfosTubo()[$tam]->getObjLocal();


            $show = 'show ';
            $style = 'style="margin-top: 10px;';

            $disabled = '  ';

            $strIdTubo = $amostras->getObjTubo()->getIdTubo();

            if($amostras->getObjTubo()->getExtracaoInvalida()){
                $disabled =  ' disabled ';
            }

            if ($infotubo->getReteste() == 's') {
                $reteste = 'SIM';
            } else {
                $reteste = 'NÃO';
            }

            if ($infotubo->getSituacaoTubo() == InfosTuboRN::$TST_DESCARTADO_NO_MEIO_ETAPA) {
                $checked = ' checked ';
            }

            if($local == null){
                $strNomeLocal = '';
                $strNomePorta = '';
                $strNomePrateleira = '';
                $strNomeColuna = '';
                $strNomeCaixa = '';
                $strNomePosicao = '';
            }else {

                if ($local->getNome() == null) {
                    $strNomeLocal = '';
                } else {
                    $strNomeLocal = $local->getNome();
                }

                if ($local->getPorta() == null) {
                    $strNomePorta = '';
                } else {
                    $strNomePorta = $local->getPorta();
                }

                if ($local->getPrateleira() == null) {
                    $strNomePrateleira = '';
                } else {
                    $strNomePrateleira = $local->getPrateleira();
                }

                if ($local->getCaixa() == null) {
                    $strNomeCaixa = '';
                } else {
                    $strNomeCaixa = $local->getCaixa();
                }

                if ($local->getColuna() == null) {
                    $strNomeColuna = '';
                } else {
                    $strNomeColuna = $local->getColuna();
                }

                if ($local->getPosicao() == null) {
                    $strNomePosicao = '';
                } else {
                    $strNomePosicao = $local->getPosicao();
                }
            }



            $show_amostras .= '
                   
                    <div class="accordion" id="accordionExample" ' . $style . '">
                          <div class="card">
                          
                            <div class="card-header" id="heading_' . $strIdTubo . '">
                              <h5 class="mb-0">
                                <button  style="text-decoration: none;color: #3a5261;"  class="btn btn-link" type="button" 
                                data-toggle="collapse" data-target="#collapse_' . $strIdTubo . '" aria-expanded="true" aria-controls="collapseOne">
                                  <h5>AMOSTRA ' . $amostras->getNickname() . '</h5>
                                </button>
                              </h5>
                            </div>
                        
                            <div id="collapse_' . $strIdTubo . '" class="collapse ' . $show . ' " 
                            aria-labelledby="heading_' . $strIdTubo . '" data-parent="#accordionExample">
                              <div class="card-body">
                                    <div class="form-row" >
                                         <div class="col-md-12" style="background-color: #3a5261;padding: 5px;font-size: 13px;font-weight: bold; color: whitesmoke;">
                                            AMOSTRA RNA
                                         </div>
                                    </div>
                                    <div class="form-row" >
                                        
                                        <div class="col-md-6">
                                            <label> Volume</label>
                                                <input type="number" class="form-control form-control-sm" id="idVolume"  
                                                ' . $disabled . ' step="0.01" style="text-align: center;" placeholder="" ' . $disabled . '
                                                    name="txtVolume_' . $strIdTubo . '"  value="' . $infotubo->getVolume() . '">
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label> Reteste</label>
                                                <input type="text" class="form-control form-control-sm" id="idReteste"  disabled style="text-align: center;" placeholder=""' . $disabled . '
                                                    name="txtReteste_' . $strIdTubo . '"  value="' . $reteste . '">
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-row" >';
            $strIdLocalArmazenamento = 'nomeLocalArmazenamento_' . $strIdTubo;
            $show_amostras .= '  <div class="col-md-4">
                                           <label> Local de armazenamento </label>
                                                <input type="text" class="form-control form-control-sm"  ' . $disabled . ' style="text-align: center;" placeholder=""
                                                        name="' . $strIdLocalArmazenamento . '" 
                                                         value="' . $strNomeLocal . '"
                                                         id="' . $strIdLocalArmazenamento . '">
                                        </div>';
            $arr_JSCopiarLocal[] = $strIdLocalArmazenamento;

            $strIdPorta = 'txtPorta_' . $strIdTubo;
            $show_amostras .= '        <div class="col-md-4">
                                           <label> Porta </label>
                                                <input type="text" class="form-control form-control-sm" ' . $disabled . ' style="text-align: center;" placeholder=""
                                                        name="' . $strIdPorta . '" 
                                                         value="' . $strNomePorta . '"
                                                         id="' . $strIdPorta . '">
                                        </div>';
            $arr_JSCopiarPorta[] = $strIdPorta;

            $strIdPrateleira = 'txtPrateleira_' . $strIdTubo;
            $show_amostras .= ' <div class="col-md-4">
                                           <label> Prateleira </label>
                                                <input type="text" class="form-control form-control-sm" ' . $disabled . ' style="text-align: center;" placeholder=""
                                                        name="' . $strIdPrateleira . '" 
                                                         value="' . $strNomePrateleira . '"
                                                         id="' . $strIdPrateleira . '">
                                        </div>
                                        </div>';
            $arr_JSCopiarPrateleira[] = $strIdPrateleira;

            $strIdColuna = 'txtColuna_' . $strIdTubo;
            $show_amostras .= '  <div class="form-row" >
                                        <div class="col-md-4">
                                                <label> Coluna </label>
                                                <input type="text" class="form-control form-control-sm"  ' . $disabled . ' style="text-align: center;" placeholder=""
                                                    name="' . $strIdColuna . '" 
                                                     value="' . $strNomeColuna . '"
                                                     id="' . $strIdColuna . '">
                                             </div>';
            $arr_JSCopiarColuna[] = $strIdColuna;

            $strIdCaixa = 'txtCaixa_' . $strIdTubo;
            $show_amostras .= '<div class="col-md-4">
                                                <label> Caixa </label>
                                                <input type="text" class="form-control form-control-sm"   ' . $disabled . ' style="text-align: center;" placeholder=""
                                                    name="' . $strIdCaixa . '" 
                                                     value="' . $strNomeCaixa . '"
                                                     id="' . $strIdCaixa . '">
                                             </div>';
            $arr_JSCopiarCaixa[] = $strIdCaixa;


            $show_amostras .= '      <div class="col-md-4">
                                                
                                                <label> Posição (letra+número) </label>
                                                 <input type="text" class="form-control form-control-sm"  ' . $disabled . '  style="text-align: center;" placeholder=""
                                                        name="txtPosicao_' . $strIdTubo . '"  
                                                        value="' . $strNomePosicao . '">
                                             </div>
                                        </div>';
            if ($primeiro) {
                $show_amostras .= '<div class="form-row">
                                            <div class="col-md-12">
                                                <button style="padding:5px;background-color: #3a5261; color: white;font-size:12px;border: 2px solid white;border-radius: 5px;"  
                                                    type="button" onclick="copiar()">COPIAR LOCAL DE ARMAZENAMENTO PARA TODAS AS AMOSTRAS</button>
                                            </div>
                                        </div>';
                $primeiro = false;
            }

            $show_amostras .= '<div class="form-row" style="margin-bottom: 30px;">
                                        <div class="col-md-2">
                                            <div class="custom-control custom-checkbox mr-sm-2" style="margin-top: 10px;margin-left: 5px;">
                   
                                            <input type="checkbox" ' . $checked . ' class="custom-control-input" id="customDercartada_' . $strIdTubo . '" ' . $disabled . '
                                            name="checkDercartada_' . $strIdTubo . '">
                                            <label class="custom-control-label" for="customDercartada_' . $strIdTubo . '">Precisou ser descartado no meio da montagem da placa</label>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label> Informe se teve algum problema</label>
                                                <textarea class="form-control form-control-sm" id="exampleFormControlTextarea1" ' . $disabled . '
                                                name="textAreaProblema_' . $strIdTubo . '" rows="1">' . $infotubo->getObsProblema() . '</textarea>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label> Observações adicionais</label>
                                               <textarea class="form-control form-control-sm" id="exampleFormControlTextarea1" ' . $disabled . '
                                               name="textAreaObs_' . $strIdTubo . '" rows="1">' . $infotubo->getObservacoes() . '</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';

            if (isset($_POST['btn_salvar_montagem'])) {

                /*echo "<pre>";
                  echo "obs =" . $_POST['textAreaObs_' . $strIdTubo];
                  echo "  problema =" . $_POST['textAreaProblema_' . $strIdTubo];
                  echo "  check =" . $_POST['checkDercartada_' . $strIdTubo];
                  echo "  local =" . $_POST[$strIdLocalArmazenamento];
                  echo "  porta =" . $_POST[$strIdPorta];
                  echo "  prateleira =" . $_POST[$strIdPrateleira];
                  echo "  coluna =" . $_POST[$strIdColuna];
                  echo "  caixa =" . $_POST[$strIdCaixa];
                  echo "  posição =" . $_POST['txtPosicao_' . $strIdTubo];
                  echo "</pre>";*/

                    if (is_null($local)) {
                        $local = new LocalArmazenamentoTexto();
                    }else{
                        $infotubo->setIdLocalFk($local->getIdLocal());
                    }

                    $local->setNome($_POST[$strIdLocalArmazenamento]);
                    $local->setColuna($_POST[$strIdColuna]);
                    $local->setPorta($_POST[$strIdPorta]);
                    $local->setPrateleira($_POST[$strIdPrateleira]);
                    $local->setCaixa($_POST[$strIdCaixa]);
                    $local->setPosicao($_POST['txtPosicao_' . $strIdTubo]);

                    $infotubo->setIdInfosTubo(null);
                    $infotubo->setReteste($_POST['txtReteste_' . $strIdTubo]);
                    $infotubo->setVolume($_POST['txtVolume_' . $strIdTubo]);
                    $infotubo->setObjTubo($amostras->getObjTubo());
                    if (isset($_POST['checkDercartada_' . $strIdTubo]) && $_POST['checkDercartada_' . $strIdTubo] == 'on') {
                        $infotubo->setSituacaoTubo(InfosTuboRN::$TST_DESCARTADO_NO_MEIO_ETAPA);
                    }
                    $infotubo->setObjLocal($local);

                    $arr_alteracoes[] = $infotubo;

                    //$arr_amostras_[] = $amostras;

                    /*echo "<pre>";
                    print_r($arr_alteracoes);
                    echo "</pre>";*/


            }
        }

    }


    if(isset($_POST['btn_cancelar_montagem'])){
        $objMontagemPlaca->setIdMontagem($_GET['idMontagem']);
        $objMontagemPlaca = $objMontagemPlacaRN->consultar($objMontagemPlaca);

        $objMix->setIdMixPlaca($_GET['idMix']);
        $arr = $objMixRN->listar($objMix,null, true);
        $objMix = $arr[0];
        $objMix->setSituacaoMix(MixRTqPCR_RN::$STA_TRANSPORTE_MONTAGEM);

        $objPlaca = $objMix->getObjSolicitacao()->getObjPlaca();
        $objPlaca->setSituacaoPlaca(PlacaRN::$STA_MIX_FINALIZADO);

        $objMontagemPlaca->setObjMix($objMix);


        foreach ($objPlaca->getObjRelTuboPlaca() as $relTuboPlaca){
            foreach ($relTuboPlaca->getObjTubo() as $amostra){
                $tam =  count($amostra->getObjTubo()->getObjInfosTubo());
                $tam -= 1;
                $objInfosTubo = new InfosTubo();
                $objInfosTubo = $amostra->getObjTubo()->getObjInfosTubo()[$tam];
                //print_r($objInfosTubo);
                $objInfosTubo->setIdInfosTubo(null);
                $objInfosTubo->setEtapaAnterior(InfosTuboRN::$TP_RTqPCR_SOLICITACAO__MONTAGEM_PLACA);
                $objInfosTubo->setEtapa(InfosTuboRN::$TP_RTqPCR_MONTAGEM_PLACA);
                $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_AGUARDANDO_MONTAGEM_PLACA);
                $arr_infos[] = $objInfosTubo;
            }
        }
        $objMontagemPlaca->setObjInfosTubo($arr_infos);
        $objMontagemPlaca->setIdUsuarioFk(Sessao::getInstance()->getIdUsuario());
        $objPlaca->setObjProtocolo(null);
        $objPlaca->setObjsTubos(null);
        $objPlaca->setObjsAmostras(null);
        $objPlaca->setObjRelPerfilPlaca(null);
        $objPlaca->setObjRelTuboPlaca(null);
        $objPlaca->setObjsPocosPlacas(null);
        $objMix->setObjPlaca($objPlaca);
        $objMontagemPlaca->setObjMix($objMix);
        $objMontagemPlaca = $objMontagemPlacaRN->remover($objMontagemPlaca);
        header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_montagem_placa_RTqPCR'));
        die();

    }

    if (isset($_POST['btn_editar_poco'])) {
        header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=montar_placa_RTqPCR&idMontagem='.$_GET['idMontagem'].'&idMix='.$_GET['idMix']));
        die();
    }

    if(isset($_POST['btn_salvar_montagem'])){

        if($objPlaca->getSituacaoPlaca() != PlacaRN::$STA_INVALIDA) {

           // echo "<pre>";
           // print_r($objPlaca);
           // echo "</pre>";

            foreach ($objPlaca->getObjsAmostras() as $amostra){

                foreach ($objPlaca->getObjsPocosPlacas() as $pocoPlaca){
                    $poco = $pocoPlaca->getObjPoco();

                    if($amostra->getNickname() == $poco->getConteudo()){


                        $objTubo = new Tubo();
                        $objTubo->setIdTubo_fk($amostra->getObjTubo()->getIdTubo());
                        $objTubo->setTipo($amostra->getObjTubo()->getTipo());
                        $objTubo->setTuboOriginal('n');
                        $objTubo->setIdAmostra_fk($amostra->getIdAmostra());


                        $objInfosTubo = new InfosTubo();
                        $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                        //$objInfosTubo->setIdTubo_fk($reg['idTubo_fk']);
                        $objInfosTubo->setEtapa(InfosTuboRN::$TP_RTqPCR_MONTAGEM_PLACA);
                        $objInfosTubo->setEtapaAnterior(InfosTuboRN::$TP_RTqPCR_MIX_PLACA);
                        $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                        $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                        $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_NO_POCO);
                        $objTubo->setObjInfosTubo($objInfosTubo);

                        $poco->setObjTubo($objTubo);
                        $arr_pocos_alterados[] = $poco;
                        $arr_tubos_novos[] = $objTubo;
                    }
                }
            }

            /*
            echo "<pre>";
            print_r($arr_pocos_alterados);
            echo "</pre>";
            */

           // die();

            /*echo "<pre>";
            print_r($arr_alteracoes);
            echo "</pre>";*/



            $objMontagemPlaca->setIdMontagem($_GET['idMontagem']);
            $objMontagemPlaca = $objMontagemPlacaRN->consultar($objMontagemPlaca);
            $objMontagemPlaca->setObjPocos($arr_pocos_alterados);

            if ($objMontagemPlaca->getSituacaoMontagem() != MontagemPlacaRN::$STA_MONTAGEM_FINALIZADA) {
                $objMontagemPlaca->setDataHoraFim(date("Y-m-d H:i:s"));
                $arr_infos = array();
                for ($i = 0; $i < count($arr_alteracoes); $i++) {

                    $objInfosTubo = new InfosTubo();
                    $objInfosTubo->setIdInfosTubo(null);

                    $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                    $objInfosTubo->setEtapaAnterior(InfosTuboRN::$TP_RTqPCR_MIX_PLACA);
                    $objInfosTubo->setEtapa(InfosTuboRN::$TP_RTqPCR_MONTAGEM_PLACA);
                    $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                    $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_AGUARDANDO_RTqCPR);
                    $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                    $objInfosTubo->setIdLote_fk($arr_alteracoes[$i]->getIdLote_fk());
                    $objInfosTubo->setIdLocalFk($arr_alteracoes[$i]->getIdLocalFk());
                    $objInfosTubo->setVolume($arr_alteracoes[$i]->getVolume());
                    $objInfosTubo->setReteste($arr_alteracoes[$i]->getReteste());
                    $objInfosTubo->setObsProblema($arr_alteracoes[$i]->getObsProblema());
                    $objInfosTubo->setObservacoes($arr_alteracoes[$i]->getObservacoes());
                    $objInfosTubo->setIdTubo_fk($arr_alteracoes[$i]->getIdTubo_fk());
                    $objInfosTubo->setObjLocal($arr_alteracoes[$i]->getObjLocal());
                    $arr_infos[0] = $objInfosTubo;

                    $objInfosTuboAux = new InfosTubo();
                    $objInfosTuboAux->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                    $objInfosTuboAux->setIdTubo_fk($arr_alteracoes[$i]->getIdTubo_fk());
                    $objInfosTuboAux->setEtapaAnterior(InfosTuboRN::$TP_RTqPCR_MONTAGEM_PLACA);
                    $objInfosTuboAux->setEtapa(InfosTuboRN::$TP_RTqPCR);
                    $objInfosTuboAux->setIdLote_fk($objInfosTubo->getIdLote_fk());
                    $objInfosTuboAux->setIdLocalFk($objInfosTubo->getIdLocalFk());
                    $objInfosTuboAux->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                    $objInfosTuboAux->setSituacaoTubo(InfosTuboRN::$TST_AGUARDANDO_RTqCPR);
                    $objInfosTuboAux->setDataHora(date("Y-m-d H:i:s"));
                    $objInfosTuboAux->setVolume($arr_alteracoes[$i]->getVolume());
                    $objInfosTuboAux->setReteste($arr_alteracoes[$i]->getReteste());
                    $objInfosTuboAux->setObsProblema($arr_alteracoes[$i]->getObsProblema());
                    $objInfosTuboAux->setObservacoes($arr_alteracoes[$i]->getObservacoes());
                    $objInfosTuboAux->setObjLocal($arr_alteracoes[$i]->getObjLocal());
                    $arr_infos[1] = $objInfosTuboAux;

                    //para cada um criar quantos tubos forem equivalentes as ocorrencias na placa

                }

                $arr_alteracoes[] = $arr_infos[0];
                $arr_alteracoes[] = $arr_infos[1];

                /*
                echo "<pre>";
                print_r($arr_alteracoes);
                echo "</pre>";
                */

                $objPlaca->setSituacaoPlaca(PlacaRN::$STA_MONTAGEM_FINALIZADA);
                $objPlaca->setObjProtocolo(null);
                $objPlaca->setObjsTubos(null);
                $objPlaca->setObjsAmostras(null);
                $objPlaca->setObjRelPerfilPlaca(null);
                $objPlaca->setObjRelTuboPlaca(null);
                $objPlaca->setObjsPocosPlacas(null);
                $objMix->setObjPlaca($objPlaca);
                $objMix->setSituacaoMix(MixRTqPCR_RN::$STA_MONTAGEM_FINALIZADA);
                $objMontagemPlaca->setObjMix($objMix);
                $objMontagemPlaca->setObjInfosTubo($arr_alteracoes);
                $objMontagemPlaca->setSituacaoMontagem(MontagemPlacaRN::$STA_MONTAGEM_FINALIZADA);

                /*
                echo "<pre>";
                print_r($objMontagemPlaca);
                echo "</pre>";
                */

                $objMontagemPlaca = $objMontagemPlacaRN->alterar($objMontagemPlaca);
                $alert .= Alert::alert_success("A montagem foi salva");
                $liberar_popUp = 's';

                header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_montagem_placa_RTqPCR'));
                die();
            }else{
                $alert .= Alert::alert_warning("A montagem da placa já foi finalizada");
            }
        }else{
            $alert .= Alert::alert_warning("A placa está inválida. Logo, não é possível finalizar a montagem");
        }


    }


} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Montagem Placa");
Pagina::getInstance()->adicionar_css("precadastros");
if($liberar_popUp == 's') {
    Pagina::getInstance()->adicionar_javascript("popUp");
}
echo "\n".'<script type="text/javascript">

    function copiar(){
      //alert(\'COPIANDO\');
    ';


for($i=1;$i<count($arr_JSCopiarLocal); $i++){
    echo "\n".'document.getElementById(\''.$arr_JSCopiarLocal[$i].'\').value = document.getElementById(\''.$arr_JSCopiarLocal[0].'\').value;';

}

for($i=1;$i<count($arr_JSCopiarPorta); $i++){
    echo "\n".'document.getElementById(\''.$arr_JSCopiarPorta[$i].'\').value = document.getElementById(\''.$arr_JSCopiarPorta[0].'\').value;';

}

for($i=1;$i<count($arr_JSCopiarCaixa); $i++){
    echo "\n".'document.getElementById(\''.$arr_JSCopiarCaixa[$i].'\').value = document.getElementById(\''.$arr_JSCopiarCaixa[0].'\').value;';

}

for($i=1;$i<count($arr_JSCopiarPrateleira); $i++){
    echo "\n".'document.getElementById(\''.$arr_JSCopiarPrateleira[$i].'\').value = document.getElementById(\''.$arr_JSCopiarPrateleira[0].'\').value;';

}

for($i=1;$i<count($arr_JSCopiarColuna); $i++){
    echo "\n".'document.getElementById(\''.$arr_JSCopiarColuna[$i].'\').value = document.getElementById(\''.$arr_JSCopiarColuna[0].'\').value;';

}



echo '
   }

</script>';
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('MONTAGEM PLACA',null,null, 'listar_montagem_placa_RTqPCR', 'LISTAR MONTAGEM DA PLACA');
echo $alert;
Pagina::getInstance()->mostrar_excecoes();


echo '<!-- Modal -->
    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="text-align: center">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                    Deseja realizar outra montagem de placa? </h5>
                    <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>-->
                </div>
                
                <div class="modal-footer">
                    <!--<button type="button" class="btn btn-secondary" data-dismiss="modal"  >Close</button>-->
                    <button type="button"  class="btn btn-primary">
                    <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_montagem_placa_RTqPCR') . '">Sim</a></button>
                </div>
            </div>
        </div>
    </div>';

echo '<div class="conteudo_grande"   style="margin-top: 0px;">        
             <form method="POST">
             
             <div class="form-row">  
                <div class="col-md-12" >
                    <label>Selecione um mix para fazer a montagem da placa</label>
                    '.$select_mix.'
                </div>
             </div>';


if (isset($_GET['idMontagem'])  && isset($_GET['idMix'])) {
    echo '<div class="form-row">
                <div class="col-md-6">
                    <input class="btn btn-primary" type="submit" name="btn_salvar_montagem" style="margin-left:0%;width: 100%;" value="SALVAR A MONTAGEM DA PLACA"></input>
                </div>
                <div class="col-md-6">
                    <input class="btn btn-primary" type="submit" name="btn_cancelar_montagem" style="margin-left:0%;width: 100%;" value="CANCELAR A MONTAGEM DA PLACA"></input>
                </div>';
    echo '</div>';


    echo '  <input type="text" class="form-control" id="idDataHoraLogin" hidden style="text-align: center;"
                           name="dtHoraLoginInicio" required value="' . $_SESSION['DATA_LOGIN'] . '">';
    echo '<div class="col-md-12" style="margin-top: 40px; margin-bottom: 50px;">'
                    . $show_amostras .
                '</div>';
    echo $table;

    echo '
           
      <div class="form-row" >
        <div class="col-md-12">
            <input class="btn btn-primary" type="submit" name="btn_editar_poco" style="margin-left:0px;width: 100%;" value="EDITAR POSIÇÃO NA PLACA" </input>
        </div>
      </div>';


}

echo '</form>
</div>';

Pagina::getInstance()->fechar_corpo();