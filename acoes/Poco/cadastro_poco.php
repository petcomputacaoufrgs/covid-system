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

    require_once  __DIR__.'/../../utils/Utils.php';


    Sessao::getInstance()->validar();

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

    $select_placas = '';
    $arr_pocos = array();
    $disabled = '';

    InterfacePagina::montar_select_placas($select_placas, $objPlaca, $objPlacaRN, '', '');


    if (isset($_GET['idPlaca'])) {

        if(!Sessao::getInstance()->verificar_permissao('mix_placa_RTqPCR')){
            $disabled = ' disabled ';
        }

        $objPlaca->setIdPlaca($_GET['idPlaca']);
        $objPlaca = $objPlacaRN->consultar_completo($objPlaca); // busca tudo em 1 consulta

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

            $tubos_inexistentes = $objPlacaRN->consultar_tubos_inexistentes($objPlaca,1,4);
            foreach ($tubos_inexistentes as $tubo){
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

            $tubos_inexistentes = $objPlacaRN->consultar_tubos_inexistentes($objPlaca,5,8);
            foreach ($tubos_inexistentes as $tubo){
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

            $tubos_inexistentes = $objPlacaRN->consultar_tubos_inexistentes($objPlaca,9,12);
            foreach ($tubos_inexistentes as $tubo){
                $alert .= Alert::alert_warning('Informe o local da amostra <strong>'.$tubo['nickname'].'</strong>,na divisão <strong>'.$objDivisaoProtocolo[2]->getNomeDivisao() .'</strong>, visto não foi informada na placa mas faz parte da solicitação');
            }


        } else if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 4) {
            $incremento_na_placa_original = 3;
        }

        if($error_qnt) {
            $objPlacaAux = new Placa();
            $objPlacaAux->setIdPlaca($_GET['idPlaca']);
            $objPlacaAux = $objPlacaRN->consultar($objPlacaAux);
            $objPlacaAux->setSituacaoPlaca(PlacaRN::$STA_INVALIDA);
            $objPlacaRN->alterar($objPlacaAux);

        }

        if(!$error_qnt){
            $objPlacaAux = new Placa();
            $objPlacaAux->setIdPlaca($_GET['idPlaca']);
            $objPlacaAux = $objPlacaRN->consultar($objPlacaAux);
            $objPlacaAux->setSituacaoPlaca(PlacaRN::$STA_AGUARDANDO_MIX);
            $objPlacaRN->alterar($objPlacaAux);
        }


        $error = false;
        $arr_errors = array();

        $table .= '<table class="table table-responsive table-hover">';
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
                                } else if (trim(strtoupper($_POST[$strPosicao])) == 'C+') {
                                    $pocoPlaca->getObjPoco()->setConteudo('C+');
                                } else if (trim(strtoupper($_POST[$strPosicao])) == 'C-') {
                                    $pocoPlaca->getObjPoco()->setConteudo('C-');
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
    }

    if (isset($_POST['btn_editar_poco']) && count($arr_errors) == 0) {
        header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_poco&idSolicitacao=' . $_GET['idSolicitacao'] . '&idPlaca=' . $objPlaca->getIdPlaca()));
        die();
    }

} catch (Throwable $ex) {
    Pagina::getInstance()->mostrar_excecoes($ex);
}

Pagina::abrir_head("Cadastrar poço");
Pagina::getInstance()->adicionar_css("precadastros");
if($liberar_popUp == 's') {
    Pagina::getInstance()->adicionar_javascript("popUp");
}
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('VISUALIZAR E EDITAR POÇO','remover_amostras_da_placa','REMOVER AMOSTRA(S) DA PLACA', 'mix_placa_RTqPCR', 'REALIZAR MIX DA PLACA');
echo $alert;
Pagina::getInstance()->mostrar_excecoes();

echo '<div class="conteudo_grande"   style="margin-top: 0px;">
            <form method="POST">'.
                $table.'
                <div class="form-row">
                    <div class="col-md-12">
                        <button class="btn btn-primary" type="submit" name="btn_editar_poco">EDITAR</button>
                    </div>
                </div>
            </form>
     </div>';

Pagina::getInstance()->fechar_corpo();