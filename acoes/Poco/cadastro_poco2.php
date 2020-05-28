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


    Sessao::getInstance()->validar();

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

    InterfacePagina::montar_select_placas($select_placas, $objPlaca, $objPlacaRN, '', '');


    if (isset($_GET['idPlaca'])) {

        $objPlaca->setIdPlaca($_GET['idPlaca']);
        $objPlaca = $objPlacaRN->consultar_completo($objPlaca); // busca tudo em 1 consulta

        /*echo "<pre>";
        print_r($objPlaca);
        echo "</pre>";*/


        if (count($objPlaca->getObjsPocosPlacas()) == 0) {
            $objPoco->setObjPlaca($objPlaca);
            $objPocoRN->cadastrar($objPoco, 's');
            $objPlaca = $objPlacaRN->consultar_completo($objPlaca);
        }


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
                                //echo $poco->getConteudo()

                                $table .= '<td><input ' . $style . ' type="text" class="form-control"
                                        id="idDataHoraLogin" style="text-align: center;"
                                        name="' . $strPosicao . '"
                                        value="' . $pocoPlaca->getObjPoco()->getConteudo() . '"></td>';
                            } else {
                                $table .= '<td ><input style="background-color: rgba(0,255,0,0.2);" type="text" class="form-control"
                                        id="idDataHoraLogin" style="text-align: center;"
                                        name="' . $strPosicao . '"
                                        value=""></td>';
                            }

                            if (isset($_POST['btn_editar_poco'])) {

                                //$objPoco = new Poco();
                                //$pocoPlaca->getObjPoco()->setLinha($letras[$i-1]);
                                //Poco->setColuna($j);

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
                                }

                                if ($encontrou) {
                                    $objPocoRN->alterar($pocoPlaca->getObjPoco());
                                }
                                //$arr_pocos[] = $objPoco;

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
        header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_poco&idSolicitacao='.$_GET['idSolicitacao'].'&idPlaca='.$objPlaca->getIdPlaca()));
        die();
    }



    /*if (isset($_POST['btn_editar_poco'])) {
        if (count($objPlaca->getObjsPocosPlacas()) > 0 && count($arr_errors) == 0) {
            $objPlaca->setIdPlaca($_GET['idPlaca']);
            $objPlaca = $objPlacaRN->consultar_completo($objPlaca);

            /*
                echo "<pre>";
                print_r($objPlaca->getObjsPocosPlacas());
                echo "</pre>";
                die();


            $table = '<table class="table table-responsive table-hover">';

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
                                    //echo $poco->getConteudo()

                                    $table .= '<td><input ' . $style . ' type="text" class="form-control"
                                    id="idDataHoraLogin" style="text-align: center;"
                                    name="' . $strPosicao . '"
                                    value="' . $pocoPlaca->getObjPoco()->getConteudo() . '"></td>';
                                } else {
                                    $table .= '<td><input style="background-color: rgba(0,255,0,0.2);" type="text" class="form-control"
                                    id="idDataHoraLogin" style="text-align: center;"
                                    name="' . $strPosicao . '"
                                    value=""></td>';
                                }
                            }

                        }

                    }
                }

            }
            $table .= '</table>';


        } else if (count($arr_errors) > 0) {
            foreach ($arr_errors as $error) {
                $alert .= Alert::alert_danger("O código informado " . $error . " não é o de uma amostra válida para essa placa");
            }
        }
    }
}*/


    /*for ($i = 0; $i <= 8; $i++) {
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

                if ($posicao_tubo[$i][$j] != '') {
                    if ($posicao_tubo[$i][$j] == 'BR' || $posicao_tubo[$i][$j] == 'C+' || $posicao_tubo[$i][$j] == 'C-') {
                        $style = ' style="background-color: rgba(255,255,0,0.2);"';
                    } else {
                        $style = ' style="background-color: rgba(255,0,0,0.2);" ';
                    }

                    $table .= '<td><input ' . $style . ' type="text" class="form-control"
                                        id="idDataHoraLogin" style="text-align: center;"
                                        name="' . $strPosicao . '"
                                        value="' . [$i][$j] . '"></td>';
                } else {
                    $table .= '<td><input style="background-color: rgba(0,255,0,0.2);"
                                    type="text" class="form-control" id="idDataHoraLogin"
                                    style="text-align: center;"
                                    name="' . $strPosicao . '" value=""></td>';

                }
            }
        }
    }*/


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
Pagina::montar_topo_listar('VISUALIZAR E EDITAR POÇO',null,null, 'listar_poco', 'LISTAR POÇOS');
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