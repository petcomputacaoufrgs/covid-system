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

    require_once __DIR__ . '/../../classes/RelPerfilPlaca/RelPerfilPlaca.php';
    require_once __DIR__ . '/../../classes/RelPerfilPlaca/RelPerfilPlacaRN.php';

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

    $select_placas = '';
    $arr_pocos = array();
    $select_solicitacoes = '';
    //$disabled = ' disabled ';

    InterfacePagina::montar_select_placas($select_placas, $objPlaca, $objPlacaRN, '', '');


    $objSolMontarPlaca->setSituacaoSolicitacao(SolicitacaoMontarPlacaRN::$TS_FINALIZADA);
    $objPlaca->setSituacaoPlaca(PlacaRN::$STA_AGUARDANDO_MIX);
    $objSolMontarPlaca->setObjPlaca($objPlaca);
    SolicitacaoMontarPlacaINT::montar_select_solicitacoes($select_solicitacao, $objSolMontarPlaca, $objSolMontarPlacaRN,null, true);


    if(isset($_POST['sel_solicitacao']) && !isset($_GET['idSolicitacao'])){
        $objSolMontarPlaca->setIdSolicitacaoMontarPlaca($_POST['sel_solicitacao']);
        $arr_solicitacao = $objSolMontarPlacaRN->listar($objSolMontarPlaca);

        $objPlaca = $arr_solicitacao[0]->getObjPlaca();
        $objPlaca->setSituacaoPlaca(PlacaRN::$STA_NO_MIX);

        /*echo "<pre>";
        print_r($arr_solicitacao[0]);
        echo "</pre>";
        */

        $contador = 0;
        foreach ($arr_solicitacao[0]->getObjsAmostras() as $amostra){
            $objTubo = $amostra->getObjTubo();
            $objInfosTubo = $amostra->getObjTubo()->getObjInfosTubo();

            $objInfosNovo = new InfosTubo();
            $objInfosNovo = $objInfosTubo;

            $objInfosNovo->setIdInfosTubo(null);
            $objInfosNovo->setEtapa(InfosTuboRN::$TP_RTqPCR_MIX_PLACA);
            $objInfosNovo->setSituacaoEtapa(InfosTuboRN::$TSP_EM_ANDAMENTO);
            $objInfosNovo->setSituacaoTubo(InfosTuboRN::$TST_EM_UTILIZACAO);
            $objInfosNovo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
            $objInfosNovo->setDataHora(date("Y-m-d H:i:s"));
            $arr_infos[$contador++] = $objInfosNovo;

        }

        /*echo "<pre>";
        print_r($arr_infos);
        echo "</pre>";*/

        $objMix->setArrObjInfosTubo($arr_infos);
        $objMix->setObjPlaca($objPlaca);

        $objMix->setIdPlacaFk($objPlaca->getIdPlaca());
        $objMix->setIdSolicitacaoFk($arr_solicitacao[0]->getIdSolicitacaoMontarPlaca());
        $objMix->setDataHoraInicio($_SESSION['DATA_LOGIN']);
        $objMix->setDataHoraFim(date("Y-m-d H:i:s"));
        $objMix->setIdUsuarioFk(Sessao::getInstance()->getIdUsuario());
        $objMix->setSituacaoMix(MixRTqPCR_RN::$STA_EM_ANDAMENTO);
        $objMix = $objMixRN->cadastrar($objMix);

        header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=mix_placa_RTqPCR&idSolicitacao=' . $arr_solicitacao[0]->getIdSolicitacaoMontarPlaca(). '&idPlaca=' . $objPlaca->getIdPlaca().'&idMix='.$objMix->getIdMixPlaca()));
        die();

    }

    if (isset($_GET['idPlaca']) && isset($_GET['idSolicitacao']) && isset($_GET['idMix'])) {
        $objSolMontarPlaca->setIdSolicitacaoMontarPlaca(intval($_GET['idSolicitacao']));
        $objSolMontarPlaca->setObjPlaca(null);
        SolicitacaoMontarPlacaINT::montar_select_solicitacoes($select_solicitacao, $objSolMontarPlaca, $objSolMontarPlacaRN,true, null);

        $objPlaca->setIdPlaca($_GET['idPlaca']);
        $objPlaca = $objPlacaRN->consultar_completo($objPlaca); // busca tudo em 1 consulta

        if (count($objPlaca->getObjsPocosPlacas()) == 0) {
            $objPoco->setObjPlaca($objPlaca);
            $objPocoRN->cadastrar($objPoco, 's');
            $objPlaca = $objPlacaRN->consultar_completo($objPlaca);
        }

        if($objPlaca->getSituacaoPlaca() == PlacaRN::$STA_INVALIDA){
            $alert .= Alert::alert_danger("A placa tem situação <strong>INVÁLIDA</strong>");
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

        if($error_qnt || count($tubos_inexistentes1) > 0 || count($tubos_inexistentes2) > 0 || count($tubos_inexistentes3) > 0) {
            //echo "aqui";
            $objPlacaAux = new Placa();
            $objPlacaAux->setIdPlaca($_GET['idPlaca']);
            $objPlacaAux = $objPlacaRN->consultar($objPlacaAux);
            $objPlacaAux->setSituacaoPlaca(PlacaRN::$STA_INVALIDA);

            $objPlacaRN->alterar($objPlacaAux);


        }


        $error = false;
        $arr_errors = array();

        $table .= '<table class="table table-responsive table-hover" >';
        $quantidade = 8;
        $letras = range('A', chr(ord('A') + $quantidade));

        $cols = (12 / count($objPlaca->getObjProtocolo()->getObjDivisao()));

        $tubo_placa = 0;
        $posicoes_array = 0;
        $cont = 1;

        $table = '<table class="table table-responsive table-hover tabela_poco">';
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
                                            }
                                        }
                                        if (!$encontrou) {
                                            $arr_errors[] = $_POST[$strPosicao];
                                            $alert .= Alert::alert_danger("O código informado -" . trim(strtoupper($_POST[$strPosicao])) . "- não é o de uma amostra válida para essa placa");
                                        } else {
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
        // Sessao::getInstance()->getIdUsuario();
        if (isset($_POST['btn_editar_poco']) && count($arr_errors) == 0) {

            header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=mix_placa_RTqPCR&idSolicitacao=' . $_GET['idSolicitacao'] . '&idPlaca=' . $objPlaca->getIdPlaca().'&idMix='.$_GET['idMix']));
            die();
        }

    }

    if(isset($_POST['btn_remover'])){
        header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_amostras_da_placa&idSolicitacao=' . $_GET['idSolicitacao'] . '&idPlaca=' . $objPlaca->getIdPlaca()));
        die();
    }

    if(isset($_POST['btn_salvar_mix'])){
        $objSolMontarPlaca->setIdSolicitacaoMontarPlaca($_GET['idSolicitacao']);
        $objSolMontarPlaca = $objSolMontarPlacaRN->consultar($objSolMontarPlaca);

        if($objPlaca->getSituacaoPlaca() != PlacaRN::$STA_INVALIDA ) {
            $objMix->setIdMixPlaca($_GET['idMix']);
            $objMix = $objMixRN->consultar($objMix);

            if ($objMix->getSituacaoMix() != MixRTqPCR_RN::$STA_TRANSPORTE_MONTAGEM) {

                $objMix->setSituacaoMix(MixRTqPCR_RN::$STA_TRANSPORTE_MONTAGEM);

                $objSolMontarPlaca->setIdSolicitacaoMontarPlaca($_POST['sel_solicitacao']);
                $arr_solicitacao = $objSolMontarPlacaRN->listar($objSolMontarPlaca);

                $objPlaca = $arr_solicitacao[0]->getObjPlaca();
                $objPlaca->setSituacaoPlaca(PlacaRN::$STA_MIX_FINALIZADO);

                //echo "<pre>";
                //print_r($arr_solicitacao[0]);
                //echo "</pre>";


                $contador = 0;
                foreach ($arr_solicitacao[0]->getObjsAmostras() as $amostra) {
                    $objTubo = $amostra->getObjTubo();
                    $objInfosTubo = $amostra->getObjTubo()->getObjInfosTubo();

                    $objInfosNovo = new InfosTubo();
                    $objInfosNovo = $objInfosTubo;

                    $objInfosNovo->setIdInfosTubo(null);
                    $objInfosNovo->setEtapa(InfosTuboRN::$TP_RTqPCR_MIX_PLACA);
                    $objInfosNovo->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                    $objInfosNovo->setSituacaoTubo(InfosTuboRN::$TST_AGUARDANDO_MONTAGEM_PLACA);
                    $objInfosNovo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                    $objInfosNovo->setDataHora(date("Y-m-d H:i:s"));
                    $arr_infos[$contador++] = $objInfosNovo;

                    $objInfosNovo2 = new InfosTubo();
                    $objInfosTubo = new InfosTubo();

                    $objInfosNovo2->setIdTubo_fk($objInfosNovo->getIdTubo_fk());
                    $objInfosNovo2->setIdLote_fk($objInfosNovo->getIdLote_fk());
                    $objInfosNovo2->setReteste($objInfosNovo->getReteste());
                    $objInfosNovo2->setVolume($objInfosNovo->getVolume());
                    $objInfosNovo2->setObsProblema($objInfosNovo->getObsProblema());
                    $objInfosNovo2->setObservacoes($objInfosNovo->getObservacoes());
                    $objInfosNovo2->setIdLocalFk($objInfosNovo->getIdLocalFk());
                    $objInfosNovo2->setIdInfosTubo(null);
                    $objInfosNovo2->setEtapa(InfosTuboRN::$TP_RTqPCR_MONTAGEM_PLACA);
                    $objInfosNovo2->setEtapaAnterior(InfosTuboRN::$TP_RTqPCR_MIX_PLACA);
                    $objInfosNovo2->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                    $objInfosNovo2->setSituacaoTubo(InfosTuboRN::$TST_AGUARDANDO_MONTAGEM_PLACA);
                    $objInfosNovo2->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                    $objInfosNovo2->setDataHora(date("Y-m-d H:i:s"));
                    $arr_infos[$contador++] = $objInfosNovo2;

                }

                /*echo "<pre>";
                print_r($arr_infos);
                echo "</pre>";*/

                $objMix->setArrObjInfosTubo($arr_infos);
                $objMix->setObjPlaca($objPlaca);

                $objMix = $objMixRN->alterar($objMix);

                header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_mix_placa_RTqPCR'));
                die();
            }else{
                $alert .= Alert::alert_warning("O mix já está pronto e indo para a montagem. Logo, não é possível finalizá-lo novamente");
            }
        }else if($objPlaca->getSituacaoPlaca() != PlacaRN::$STA_INVALIDA){
            $alert .= Alert::alert_warning("A placa está inválida. Logo, não é possível finalizar o mix");
        }

    }


} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Editar Poço");
Pagina::getInstance()->adicionar_css("precadastros");
if($liberar_popUp == 's') {
    Pagina::getInstance()->adicionar_javascript("popUp");
}
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('EDITAR POÇO',null,null, 'listar_mix_placa_RTqPCR', 'LISTAR MIX PLACA');
echo $alert;
Pagina::getInstance()->mostrar_excecoes();

echo '<div class="conteudo_grande"   style="margin-top: 0px;">        
             <form method="POST">
             
             <div class="form-row">  
                <div class="col-md-12" >
                    <label>Selecione uma placa para fazer o mix</label>
                    '.$select_solicitacao.'
                </div>
             </div>';
             
      if (isset($_GET['idPlaca']) && isset($_GET['idSolicitacao']) && isset($_GET['idMix'])) {
          echo '             <input type="text" class="form-control" id="idDataHoraLogin" hidden style="text-align: center;"
                           name="dtHoraLoginInicio" required value="' . $_SESSION['DATA_LOGIN'] . '">
                           
            ' . $table;

          if (Sessao::getInstance()->verificar_permissao('remover_amostras_da_placa') ) {
              echo '    
               
                <div class="form-row">
                    <div class="col-md-5">
                        <button class="btn btn-primary" type="submit" name="btn_remover" style="width: 100%;">REMOVER AMOSTRA(S) DA PLACA</button>
                    </div>';
              //if($objPlaca->getSituacaoPlaca() != PlacaRN::$STA_INVALIDA && $objPlaca->getSituacaoPlaca() != PlacaRN::$STA_MIX_FINALIZADO) {
              echo '<div class="col-md-5">
                        <input class="btn btn-primary" type="submit" name="btn_editar_poco" style="width: 100%;" value="EDITAR" </input>
                    </div>';
              //}
              echo '</div>';

              echo '<div class="form-row">
                    <div class="col-md-12">
                        <input class="btn btn-primary" type="submit" name="btn_salvar_mix" style="margin-left:0%;width: 100%;" value="SALVAR O MIX DEFINITIVAMENTE"></input>
                    </div>';
              echo '</div>';
          }
      }
echo '</form>
</div>';

Pagina::getInstance()->fechar_corpo();