<?php

session_start();
try {
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once __DIR__ . '/../../classes/Capela/Capela.php';
    require_once __DIR__ . '/../../classes/Capela/CapelaRN.php';
    require_once _DIR__ . '/../../classes/Pagina/InterfacePagina.php';

    require_once __DIR__ . '/../../classes/Amostra/Amostra.php';
    require_once __DIR__ . '/../../classes/Amostra/AmostraRN.php';

    require_once __DIR__ . '/../../classes/Tubo/Tubo.php';
    require_once __DIR__ . '/../../classes/Tubo/TuboRN.php';

    require_once __DIR__ . '/../../classes/InfosTubo/InfosTubo.php';
    require_once __DIR__ . '/../../classes/InfosTubo/InfosTuboRN.php';

    require_once __DIR__ . '/../../utils/Utils.php';
    require_once __DIR__ . '/../../utils/Alert.php';

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


    require_once __DIR__ . '/../../classes/LocalArmazenamento/LocalArmazenamento.php';
    require_once __DIR__ . '/../../classes/LocalArmazenamento/LocalArmazenamentoRN.php';

    require_once __DIR__ . '/../../classes/TipoLocalArmazenamento/TipoLocalArmazenamento.php';
    require_once __DIR__ . '/../../classes/TipoLocalArmazenamento/TipoLocalArmazenamentoRN.php';

    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTexto.php';
    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTextoRN.php';




    Sessao::getInstance()->validar();
    $utils = new Utils();

    date_default_timezone_set('America/Sao_Paulo');
    $_SESSION['DATA_LOGIN'] = date("Y-m-d H:i:s");

    /*
     * Objeto Capela
     */
    $objCapela = new Capela();
    $objCapelaRN = new CapelaRN();

    /*
     * Objeto Capela
     */
    $objPerfilPaciente = new PerfilPaciente();
    $objPerfilPacienteRN = new PerfilPacienteRN();

    /*
     * Objeto Amostra
     */
    $objAmostra = new Amostra();
    $objAmostraRN = new AmostraRN();

    /*
     * Objeto Tubo
     */
    $objTubo = new Tubo();
    $objTuboRN = new TuboRN();


    /*
     * Objeto Infos Tubo
     */
    $objInfosTubo = new InfosTubo();
    $objInfosTuboRN = new InfosTuboRN();


    /*
     * Objeto PreparoLote
     */
    $objPreparoLote = new PreparoLote();
    $objPreparoLoteRN = new PreparoLoteRN();

    /*
     * Objeto rel tubo com o lote
     */
    $objRelTuboLote = new Rel_tubo_lote();
    $objRelTuboLoteRN = new Rel_tubo_lote_RN();

    /*
     * Objeto  lote
     */
    $objLote = new Lote();
    $objLoteRN = new LoteRN();


    /*
     * Objeto  do relacionamento do perfil com o lote
     */
    $objRel_Perfil_preparoLote = new Rel_perfil_preparoLote();
    $objRel_Perfil_preparoLoteRN = new Rel_perfil_preparoLote_RN();


    /*
   *  LOCAL DE ARMAZENAMENTO
   */
    $objLocalArmazenamento = new LocalArmazenamento();
    $objLocalArmazenamentoRN = new LocalArmazenamentoRN();

    /*
  *  LOCAL DE ARMAZENAMENTO
  */
    $objLocalArmazenamentoTxt = new LocalArmazenamentoTexto();
    $objLocalArmazenamentoTxtRN = new LocalArmazenamentoTextoRN();

    /*
   *  TIPO LOCAL DE ARMAZENAMENTO
   */
    $objTipoLocalArmazenamento = new TipoLocalArmazenamento();
    $objTipoLocalArmazenamentoRN = new TipoLocalArmazenamentoRN();

    $ja_confirmou = 'n';
    $show_amostras = '';
    $select_capelas = '';
    $select_grupos = '';
    $sumir_btn_alocar = 'n';
    $salvou_dados = 'n';
    $show_collap = '';
    $sumir_btns = 'n';


        if($_GET['idLiberar'] || isset($_POST['btn_cancelar'])){
            $objCapela->setIdCapela($_GET['idCapela']);
            $objCapela = $objCapelaRN->consultar($objCapela);
            $objCapela->setSituacaoCapela(CapelaRN::$TE_LIBERADA);
            $objCapelaRN->alterar($objCapela);

            $objPreparoLote->setIdPreparoLote($_GET['idPreparoLote']);
            $objPreparoLoteRN->mudar_status_lote($objPreparoLote, LoteRN::$TE_TRANSPORTE_PREPARACAO);


            header('Location: '. Sessao::getInstance()->assinar_link('controlador.php?action=realizar_preparo_inativacao'));
            die();
        }



        $selecionado = '';
        InterfacePagina::montar_capelas_liberadas($objCapela, $objCapelaRN, $select_capelas,CapelaRN::$TNS_ALTA_SEGURANCA,'');
        InterfacePagina::montar_grupos_amostras($objPreparoLote, $objPreparoLoteRN, $select_grupos,'', LoteRN::$TL_PREPARO);

        if(strlen($select_grupos) > 0) {

            if (isset($_POST['btn_alocarCapela']) && !isset($_GET['idCapela'])) {
                if ($_POST['sel_grupos'] != -1 && $_POST['sel_nivelSegsCapela'] != -1) {
                    $alert .= Alert::alert_warning("Selecione aqui");
                    $objCapela->setIdCapela($_POST['sel_nivelSegsCapela']);
                    $objCapela->setNivelSeguranca(CapelaRN::$TNS_ALTA_SEGURANCA);
                    $objCapelaRN->bloquear_registro($objCapela);
                    header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=realizar_preparo_inativacao&idCapela=' . $_POST['sel_nivelSegsCapela'] . '&idPreparoLote=' . $_POST['sel_grupos']));
                    die();
                } else if ($_POST['sel_grupos'] != -1 && $_POST['sel_nivelSegsCapela'] == -1) {
                    $alert .= Alert::alert_warning("Selecione uma capela de alta segurança");
                } else if ($_POST['sel_grupos'] == -1 && $_POST['sel_nivelSegsCapela'] != -1) {
                    $alert .= Alert::alert_warning("Selecione um grupo de amostras");
                } else {
                    $alert .= Alert::alert_warning("Selecione uma capela e um grupo de amostras");
                }

            }


            if (isset($_POST['sel_capelasOcupadas'])) {
                header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=realizar_preparo_inativacao&idCapela=' . $_POST['sel_capelasOcupadas']));
                die();
            }


            if ((isset($_GET['idCapela']) && isset($_GET['idPreparoLote'])) || isset($_POST['btn_confirmarPreparacao']) || isset($_POST['btn_terminarPreparacao'])) {
                $sumir_btn_alocar = 's';
                if(isset($_POST['btn_confirmarPreparacao'])){
                    $ja_confirmou = 's';
                }
                $alert = Alert::alert_success("Capela de número " . $_GET['idCapela'] . " alocada com SUCESSO");
                $selecionado = $_GET['idCapela'];
                $objCapela->setIdCapela($_GET['idCapela']);
                InterfacePagina::montar_capelas_liberadas($objCapela, $objCapelaRN, $select_capelas,CapelaRN::$TNS_ALTA_SEGURANCA,' disabled ');
                $objPreparoLote->setIdPreparoLote($_GET['idPreparoLote']);
                InterfacePagina::montar_grupos_amostras($objPreparoLote, $objPreparoLoteRN, $select_grupos, ' disabled ',LoteRN::$TL_PREPARO);

                $arr_tubos = $objPreparoLoteRN->consultar_tubos($objPreparoLote);



                $objPreparoLote->setIdPreparoLote($_GET['idPreparoLote']);
                $objPreparoLoteRN->mudar_status_lote($objPreparoLote, LoteRN::$TE_EM_PREPARACAO);


                //print_r($arr_tubos);
                $contador = 0;
                $qnt = 0;
                foreach ($arr_tubos[0]->getObjsTubos() as $tubo) {
                    if ($tubo->getObjTubo()->getTipo() == TuboRN::$TT_COLETA) {
                        $qnt += 2;
                    } else if ($tubo->getObjTubo()->getTipo() == TuboRN::$TT_ALIQUOTA) {
                        $qnt += 1;
                    }
                }

                //$arr_locais = $objLocalArmazenamentoRN->pegar_valores($objLocalArmazenamento,$qnt );
                //die();

                $objTipoLocalArmazenamento->setCaractereTipo(TipoLocalArmazenamentoRN::$TL_BANCO_AMOSTRAS);
                $arr_tipo = $objTipoLocalArmazenamentoRN->listar($objTipoLocalArmazenamento);

                 $cont = 0;
                $objPreparoLote->setIdPreparoLote($_GET['idPreparoLote']);
                $objPreparoLoteRN->consultar($objPreparoLote);

                $objLoteExtracao = new Lote();


                $objPreparoLote = new PreparoLote();

                $quantidadeTubos = 0;

                $contador = 0;
                $style_top = 0;
                $arr_tubos_alterados = array();
                foreach ($arr_tubos[0]->getObjsTubos() as $tubosLote) {

                    //$objInfosTubo->setIdTubo_fk($tubosLote->getObjTubo()->getIdTubo());
                    //$objInfosTubo = $objInfosTuboRN->pegar_ultimo($objInfosTubo);
                    //$objInfosTubo->setIdInfosTubo(null);

                    if ($objInfosTubo->getReteste() == 'n' || $objInfosTubo->getReteste() == '' ) {
                        $reteste = "NÃO";
                    } else {
                        $reteste = "SIM";
                    }

                    $show = 'show ';
                    $style = 'style="margin-top: 10px;';

                    if ($style_top == 0 ) {
                        $style = 'style="margin-top: -50px;';

                    }

                    if (isset($_POST['btn_confirmarPreparacao'])) {
                        $amostra_original = 'DESCARTADO';

                    }
                    $disabled = '  ';
                    if (isset($_GET['idCapela']) && !isset($_POST['btn_confirmarPreparacao']) && !isset($_POST['btn_terminarPreparacao'])) {
                        $disabled = ' disabled ';
                    }

                    if (isset($_POST['btn_confirmarPreparacao'])) {
                        $disabled = '';
                    }

                    if($tubosLote->getObjTubo()->getTipo() == TuboRN::$TT_ALIQUOTA){
                        $amostra_aliquota = 'TIPO ALIQUOTA';
                    }ELSE{
                        $amostra_aliquota = '';
                    }

                    $show_amostras .= '
               
                <div class="accordion" id="accordionExample" ' . $style . '">
                      <div class="card">
                      
                        <div class="card-header" id="heading_' . $tubosLote->getObjTubo()->getIdTubo() . '">
                          <h5 class="mb-0">
                            <button  style="text-decoration: none;color: #3a5261;"  class="btn btn-link" type="button" 
                            data-toggle="collapse" data-target="#collapse_' . $tubosLote->getObjTubo()->getIdTubo() . '" aria-expanded="true" aria-controls="collapseOne">
                              <h5>AMOSTRA ' . $tubosLote->getNickname() .'</h5>
                            </button>
                          </h5>
                        </div>
                    
                        <div id="collapse_' . $tubosLote->getObjTubo()->getIdTubo() . '" class="collapse ' . $show . ' " 
                        aria-labelledby="heading_' . $tubosLote->getObjTubo()->getIdTubo() . '" data-parent="#accordionExample">
                          <div class="card-body">
                                <div class="form-row" >
                                     <div class="col-md-12" style="background-color: #3a5261;padding: 5px;font-size: 13px;font-weight: bold; color: whitesmoke;">
                                        AMOSTRA ORIGINAL '.$amostra_aliquota.'
                                     </div>
                                </div>
                                <div class="form-row" >
                                    
                                    <div class="col-md-6">
                                        <label> Volume</label>
                                            <input type="number" class="form-control form-control-sm" id="idVolume"  ' . $disabled . ' style="text-align: center;" placeholder="" ' . $disabled . '
                                                name="txtVolumeORIGINAL_' . $tubosLote->getObjTubo()->getIdTubo() . '"  value="'.$_POST['txtVolumeORIGINAL_' . $tubosLote->getObjTubo()->getIdTubo()].'">
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label> Reteste</label>
                                            <input type="text" class="form-control form-control-sm" id="idReteste"  disabled style="text-align: center;" placeholder=""' . $disabled . '
                                                name="txtRetesteORIGINAL_' . $tubosLote->getObjTubo()->getIdTubo() . '"  value="' . $reteste . '">
                                    </div>
                                </div>
                                
                                <div class="form-row" style="margin-bottom: 30px;">
                                    <div class="col-md-2">
                                        <div class="custom-control custom-checkbox mr-sm-2" style="margin-top: 10px;margin-left: 5px;">';
                                    $checked = '';
                                    if($_POST['checkDercartadaORIGINAL_' . $tubosLote->getObjTubo()->getIdTubo()] == 'on'){
                                        $checked = ' checked ';
                                    }

                    $show_amostras .= '    
                                        <input type="checkbox" '.$checked.' class="custom-control-input" id="customDercartada_' . $tubosLote->getObjTubo()->getIdTubo() . '" ' . $disabled . '
                                        name="checkDercartadaORIGINAL_' . $tubosLote->getObjTubo()->getIdTubo() . '">
                                        <label class="custom-control-label" for="customDercartada_' . $tubosLote->getObjTubo()->getIdTubo() . '">Precisou ser descartado no meio da preparação</label>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label> Informe se teve algum problema</label>
                                            <textarea class="form-control form-control-sm" id="exampleFormControlTextarea1" ' . $disabled . '
                                            name="textAreaProblemaORIGINAL_' . $tubosLote->getObjTubo()->getIdTubo() . '" rows="1">'.$_POST['textAreaProblemaORIGINAL_' . $tubosLote->getObjTubo()->getIdTubo()].'</textarea>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label> Observações adicionais</label>
                                           <textarea class="form-control form-control-sm" id="exampleFormControlTextarea1" ' . $disabled . '
                                           name="textAreaObsORIGINAL_' . $tubosLote->getObjTubo()->getIdTubo() . '" rows="1">'.$_POST['textAreaObsORIGINAL_' . $tubosLote->getObjTubo()->getIdTubo()].'</textarea>
                                    </div>
                                </div>
                                ';

                    //tubo original
                    if (isset($_POST['btn_terminarPreparacao'])) {
                        //não remover o idLote desse
                        $arr_infos = array();
                        $objTubo = new Tubo();
                        $objInfosTubo = new InfosTubo();
                        //altera apenas o infos tubo adicionando uma coluna, como é o tubo original ele é descartado depois
                        $objTubo->setIdTubo($tubosLote->getObjTubo()->getIdTubo());
                        $objTubo = $objTuboRN->consultar($objTubo);
                        $objInfosTubo->setIdTubo_fk($tubosLote->getObjTubo()->getIdTubo());
                        $objInfosTubo = $objInfosTuboRN->pegar_ultimo($objInfosTubo);
                        $objInfosTubo->setIdInfosTubo(null);
                        $objInfosTubo->setCodAmostra($tubosLote->getNickname());
                        $objInfosTubo->setReteste('n');
                        $objInfosTubo->setEtapa(InfosTuboRN::$TP_PREPARACAO_INATIVACAO);
                        $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                        $objInfosTubo->setIdTubo_fk($tubosLote->getObjTubo()->getIdTubo());

                        if(isset($_POST['txtVolumeORIGINAL_' . $tubosLote->getObjTubo()->getIdTubo()]) && $_POST['txtVolumeORIGINAL_' . $tubosLote->getObjTubo()->getIdTubo()] != '') {
                            $objInfosTubo->setVolume($_POST['txtVolumeORIGINAL_' . $tubosLote->getObjTubo()->getIdTubo()]);
                        }

                        if(isset($_POST['textAreaProblemaORIGINAL_' . $tubosLote->getObjTubo()->getIdTubo()]) && $_POST['textAreaProblemaORIGINAL_' . $tubosLote->getObjTubo()->getIdTubo()] != ''){
                            $objInfosTubo->setObsProblema($_POST['textAreaProblemaORIGINAL_' . $tubosLote->getObjTubo()->getIdTubo()]);
                        }

                        if(isset($_POST['textAreaObsORIGINAL_' . $tubosLote->getObjTubo()->getIdTubo()]) && $_POST['textAreaObsORIGINAL_' . $tubosLote->getObjTubo()->getIdTubo()] != ''){
                            $objInfosTubo->setObservacoes($_POST['textAreaObsORIGINAL_' . $tubosLote->getObjTubo()->getIdTubo()]);
                        }

                        $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                        $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                        if ($_POST['checkDercartadaORIGINAL_' . $tubosLote->getObjTubo()->getIdTubo()] == 'on') {
                            $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_DESCARTADO_NO_MEIO_ETAPA);
                        } else {
                            $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_DESCARTADO);
                        }

                        $arr_infos[$contador] = $objInfosTubo;
                        $objTubo->setObjInfosTubo($arr_infos);
                        $arr_tubos_alterados[$contador] = $objTubo;
                        $contador++;
                    }


                    if ( !isset($_POST['btn_confirmarPreparacao']) && !isset($_POST['btn_terminarPreparacao'])) {
                        $show_amostras .= '</div></div></div></div>';

                    }

                    if (isset($_POST['btn_confirmarPreparacao']) || isset($_POST['btn_terminarPreparacao'])) {
                        $ja_confirmou = 's';


                        for ($i = 1; $i <= 3; $i++) {

                            if ($tubosLote->getObjTubo()->getTipo() == TuboRN::$TT_COLETA) {
                                if ($i == 1 || $i == 2) {
                                    $status = 'banco de amostras - final extração';
                                    $nometubo = 'ALIQUOTA' . $i;
                                    //$objInfosTuboNovo->setVolume('1.0');
                                    $armazenamento = " banco de amostras ";
                                    $volume = 1.0;
                                    $volumeTxt = 1.0;
                                    if (isset($_POST['txtVolume_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()])) {
                                        $volume = $_POST['txtVolume_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()];
                                    }
                                }
                                if ($i == 3) {
                                    $nometubo = 'EXTRACAO';
                                    //S$objInfosTuboNovo->setVolume('0.2');
                                    $armazenamento = ' extração ';
                                    $volume = 0.2;
                                    $volumeTxt = 0.2;
                                    if (isset($_POST['txtVolume_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()])) {
                                        $volume = $_POST['txtVolume_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()];
                                    }
                                }
                            }
                            if($tubosLote->getObjTubo()->getTipo() == TuboRN::$TT_ALIQUOTA){
                                if ($i == 1) {
                                    $status = 'banco de amostras - final extração';
                                    $nometubo = 'ALIQUOTA';
                                    //$objInfosTuboNovo->setVolume('1.0');
                                    $armazenamento = " banco de amostras ";
                                    $objInfosTubo->setIdTubo_fk($tubosLote->getObjTubo()->getIdTubo());
                                    $objInfosTubo = $objInfosTuboRN->pegar_ultimo($objInfosTubo);

                                    $volume = doubleval($objInfosTubo->getVolume()) - 0.2;
                                    $volumeTxt = 1.0;
                                    if (isset($_POST['txtVolumeALIQUOTA_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()])) {
                                        $volume = $_POST['txtVolumeALIQUOTA_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()];
                                    }
                                }
                                if ($i == 2) {
                                    $nometubo = 'EXTRACAO';
                                    //S$objInfosTuboNovo->setVolume('0.2');
                                    $armazenamento = ' extração ';

                                    $objInfosTubo->setIdTubo_fk($tubosLote->getObjTubo()->getIdTubo());
                                    $objInfosTubo = $objInfosTuboRN->pegar_ultimo($objInfosTubo);

                                    $volume =  0.2;
                                    $volumeTxt = 0.2;
                                    if (isset($_POST['txtVolumeALIQUOTA_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()])) {
                                        $volume = $_POST['txtVolumeALIQUOTA_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()];
                                    }
                                }
                            }

                            if ($tubosLote->getObjTubo()->getTipo() == TuboRN::$TT_COLETA) {
                                $show_amostras .= '
                                
                                 <div class="form-row " style="background-color: whitesmoke; margin-bottom: 0px; "> 
                                    <div class="col-md-1" style="background-color: #3a5261;margin-top: 0px;font-size: 13px;font-weight: bold; color: whitesmoke;text-align: center;">' . $nometubo . '</div>       
                                         <div class="col-md-3" style="padding: 10px;">';


                                if ($i == 1 || $i == 2) {
                                    $show_amostras .= '
                                             <label> Local de armazenamento </label>
                                            <input type="text" class="form-control form-control-sm" id="idNomeLocal"  style="text-align: center;" placeholder=""
                                                    name="nomeLocalArmazenamento_'. $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo() . '" 
                                                     value="'.$_POST['nomeLocalArmazenamento_'. $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()].'">';

                                } else {
                                    $show_amostras .= '<label> Próxima Etapa </label>
                                                <input type="text" class="form-control form-control-sm" id="idVolume"  disabled style="text-align: center;" placeholder=""
                                                    name="txtExtracao_' . $tubosLote->getObjTubo()->getIdTubo() . '"  value="EXTRAÇÃO">';
                                }

                                if ($i == 3) {
                                    $hidden = ' hidden ';

                                } else {
                                    $hidden = '';
                                }
                                $show_amostras .= '</div>

                                         <div class="col-md-2" style="padding: 10px;" ' . $hidden . '>
                                             <label> Caixa </label>
                                              <input type="text" class="form-control form-control-sm" id="idVolume"   style="text-align: center;" placeholder=""
                                                    name="txtCaixa_' . $nometubo. '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo() . '" 
                                                     value="'.$_POST['txtCaixa_' . $nometubo. '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()].'">
                                             </div>
                                             
                                            
                                         <div class="col-md-2" style="padding: 10px;"' . $hidden . '>
                                             <label> Posição </label>
                                             <input type="text" class="form-control form-control-sm" id="idVolume"   style="text-align: center;" placeholder=""
                                                    name="txtPosicao_' . $nometubo . '_' . $i . '_' .  $tubosLote->getObjTubo()->getIdTubo() . '"  
                                                    value="'.$_POST['txtPosicao_' . $nometubo . '_' . $i . '_' .  $tubosLote->getObjTubo()->getIdTubo()].'">
                                             </div>';

                                $show_amostras .= '<div class="col-md-1" style="padding: 10px;">
                                         <label> Volume </label>
                                            <input type="number" class="form-control form-control-sm" id="idVolume"   style="text-align: center;" placeholder=""
                                                name="txtVolume_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo() . '"  
                                                value="' . $volume . '"> <!--$objInfosTuboNovo->getVolume().-->
                                         </div>
                                         <div class="col-md-1" style="padding: 10px;">
                                         <small style="color:red;">Por padrão o valor do volume será ' . $volumeTxt . 'ml </small>
                                            </div>
                                </div> ';

                                $checked = '';
                                if($_POST['checkDescartada_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()] == 'on'){
                                    $checked = ' checked ';
                                }
                                $show_amostras .= '<div class="form-row " style="background-color: whitesmoke;margin-top: -10px;"> 
                                    <div class="col-md-1" style="background-color: #3a5261"></div>       
                                    <div class="col-md-2">
                                    
                                    <div class="custom-control  custom-checkbox mr-sm-2" style="margin-top: 20px; margin-left: 20px;">
                                        <input type="checkbox" ' . $checked . ' class="custom-control-input" id="check_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo() . '"
                                         name="checkDescartada_' . $nometubo . '_' . $i  . '_' . $tubosLote->getObjTubo()->getIdTubo() . '">
                                        <label class="custom-control-label" for="check_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo() . '">Precisou ser descartada</label>
                                      </div>
                                    </div>
                                    <div class="col-md-4" style="padding: 10px;">
                                        <label> Informe se teve algum problema</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" 
                                            name="textAreaProblema_' . $nometubo . '_' . $tubosLote->getObjTubo()->getIdTubo() . '" rows="1">'.trim($_POST['textAreaProblema_' . $nometubo . '_' . $tubosLote->getObjTubo()->getIdTubo()]).'</textarea>
                                    </div>
                                    
                                    <div class="col-md-5" style="padding: 10px;">
                                        <label> Observações adicionais</label>
                                           <textarea class="form-control" id="exampleFormControlTextarea1" 
                                           name="textAreaObs_' . $nometubo . '_' . $tubosLote->getObjTubo()->getIdTubo() . '" rows="1">'.trim($_POST['textAreaObs_' . $nometubo . '_' . $tubosLote->getObjTubo()->getIdTubo()]).'</textarea>
                                    </div>
                                </div>
                                
                                ';

                                if (isset($_POST['btn_terminarPreparacao'])) {
                                $arr_local = array();
                                $arr_infos = array();
                                $objInfosTubo = new InfosTubo();
                                $objTuboNovo = new Tubo();


                                //if ($tubosLote->getObjTubo()->getTipo() == TuboRN::$TT_COLETA) {

                                    $objInfosTubo->setIdTubo_fk($tubosLote->getObjTubo()->getIdTubo());
                                    $objInfosTubo = $objInfosTuboRN->pegar_ultimo($objInfosTubo);

                                    $objInfosTubo->setIdInfosTubo(null);
                                    $objInfosTubo->setCodAmostra($tubosLote->getNickname());
                                    //$etapa = $objInfosTubo->getEtapaAnterior();


                                    $objTuboNovo->setTuboOriginal('n');
                                    if ($i == 1 || $i == 2) {
                                        $objTuboNovo->setTipo(TuboRN::$TT_ALIQUOTA);
                                        $objInfosTubo->setVolume(1);
                                    } else {
                                        $objTuboNovo->setTipo(TuboRN::$TT_INDO_EXTRACAO);
                                        $objInfosTubo->setVolume(0.2);
                                    }
                                    if (isset($_POST['txtVolume_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()])) {
                                        $objInfosTubo->setVolume($_POST['txtVolume_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()]);
                                    }
                                    $objTuboNovo->setIdAmostra_fk($tubosLote->getIdAmostra());
                                    $objTuboNovo->setIdTubo_fk($tubosLote->getObjTubo()->getIdTubo());

                                    $objLocalArmazenamentoTxt = new LocalArmazenamentoTexto();
                                    if ($i == 1 || $i == 2) {
                                        if (isset($_POST['txtPosicao_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()]) && $_POST['txtPosicao_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()] != '') {
                                            $objLocalArmazenamentoTxt->setPosicao(strtoupper(Utils::getInstance()->tirarAcentos($_POST['txtPosicao_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()])));
                                        }
                                        if (isset($_POST['txtCaixa_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()]) && $_POST['txtCaixa_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()] != '') {
                                            $objLocalArmazenamentoTxt->setCaixa(strtoupper(Utils::getInstance()->tirarAcentos($_POST['txtCaixa_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()])));
                                        }
                                        if (isset($_POST['nomeLocalArmazenamento_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()]) && $_POST['nomeLocalArmazenamento_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()] != '') {
                                            $objLocalArmazenamentoTxt->setNome(strtoupper(Utils::getInstance()->tirarAcentos($_POST['nomeLocalArmazenamento_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()])));
                                        }
                                        $objLocalArmazenamentoTxt->setIdTipoLocal($arr_tipo[0]->getIdTipoLocalArmazenamento());
                                        //[] = $objLocalArmazenamentoTxt;
                                        $objInfosTubo->setObjLocal($objLocalArmazenamentoTxt);
                                    }

                                    if (isset($_POST['textAreaObs_' . $nometubo . '_' . $tubosLote->getObjTubo()->getIdTubo()]) && trim($_POST['textAreaObs_' . $nometubo . '_' . $tubosLote->getObjTubo()->getIdTubo()]) != '') {
                                        $objInfosTubo->setObservacoes($_POST['textAreaObs_' . $nometubo . '_' . $tubosLote->getObjTubo()->getIdTubo()]);
                                    }
                                    if (isset($_POST['textAreaProblema_' . $nometubo . '_' . $tubosLote->getObjTubo()->getIdTubo()]) && trim($_POST['textAreaProblema_' . $nometubo . '_' . $tubosLote->getObjTubo()->getIdTubo()]) != '') {
                                        $objInfosTubo->setObsProblema($_POST['textAreaProblema_' . $nometubo . '_' . $tubosLote->getObjTubo()->getIdTubo()]);
                                    }

                                    $objInfosTubo->setEtapa(InfosTuboRN::$TP_PREPARACAO_INATIVACAO);
                                    $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                                    $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                                    $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                                    $objInfosTubo->setReteste('n');

                                    if ($_POST['checkDescartada_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()] == 'on') {
                                        $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_DESCARTADO_NO_MEIO_ETAPA);
                                    } else {
                                        if ($i == 1 || $i == 2) {
                                            $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_AGUARDANDO_BANCO_AMOSTRAS);
                                        } else {
                                            $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_TRANSPORTE_EXTRACAO);
                                        }

                                    }

                                    if (($i == 1 || $i == 2) || ($i == 3 && $_POST['checkDescartada_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()] == 'on')) {
                                        $arr_infos[] = $objInfosTubo;
                                        $objTuboNovo->setObjInfosTubo($arr_infos);
                                        $arr_tubos_cadastro[] = $objTuboNovo;
                                    }


                                    if ($i == 3 && $_POST['checkDescartada_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()] != 'on') {
                                        $arr_infos = array();
                                        $objInfosTubo->setEtapa(InfosTuboRN::$TP_PREPARACAO_INATIVACAO);
                                        $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                                        $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_TRANSPORTE_EXTRACAO);
                                        $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                                        $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                                        $arr_infos[0] = $objInfosTubo;

                                        $objInfosTubo2 = new InfosTubo();
                                        $objInfosTubo2->setCodAmostra($tubosLote->getNickname());
                                        $objInfosTubo2->setEtapa(InfosTuboRN::$TP_EXTRACAO);
                                        $objInfosTubo2->setIdTubo_fk($objInfosTubo->getIdTubo_fk());
                                        $objInfosTubo2->setIdLote_fk($objInfosTubo->getIdLote_fk());
                                        $objInfosTubo2->setEtapaAnterior(InfosTuboRN::$TP_PREPARACAO_INATIVACAO);
                                        $objInfosTubo2->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                                        $objInfosTubo2->setSituacaoTubo(InfosTuboRN::$TST_TRANSPORTE_EXTRACAO);
                                        $objInfosTubo2->setDataHora(date("Y-m-d H:i:s"));
                                        $objInfosTubo2->setReteste('n');
                                        $objInfosTubo2->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                                        if (isset($_POST['txtVolume_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()]) && $_POST['txtVolume_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()] != '') {
                                            $objInfosTubo2->setVolume($_POST['txtVolume_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()]);
                                        }
                                        $arr_infos[1] = $objInfosTubo2;
                                        $quantidadeTubos++;
                                        $objTuboNovo->setObjInfosTubo($arr_infos);

                                        $objLoteExtracao->setQntAmostrasAdquiridas($quantidadeTubos);
                                        $objLoteExtracao->setQntAmostrasDesejadas($quantidadeTubos);
                                        $tubos_novo_lote[] = $objTuboNovo;
                                    }

                                }
                            }
                            if($tubosLote->getObjTubo()->getTipo() == TuboRN::$TT_ALIQUOTA){
                                if ($i == 1 || $i == 2) {
                                    $show_amostras .= '
                                    
                                     <div class="form-row " style="background-color: whitesmoke; margin-bottom: 0px; "> 
                                        <div class="col-md-1" style="background-color: #3a5261;margin-top: 0px;font-size: 13px;font-weight: bold; color: whitesmoke;text-align: center;">' . $nometubo . '</div>       
                                             <div class="col-md-3" style="padding: 10px;">';


                                if ($i == 1) {
                                    $show_amostras .= '
                                             <label> Local de armazenamento </label>
                                            <input type="text" class="form-control form-control-sm" id="idNomeLocal"  style="text-align: center;" placeholder=""
                                                    name="nomeLocalArmazenamentoALIQUOTA_'. $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo() . '" 
                                                     value="'.$_POST['nomeLocalArmazenamentoALIQUOTA_'. $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()].'">';
                                    $show_amostras .= '</div>
                                     <div class="col-md-2" style="padding: 10px;" ' . $hidden . '>
                                         <label> Caixa </label>
                                          <input type="text" class="form-control form-control-sm" id="idVolume"   style="text-align: center;" placeholder=""
                                                name="txtCaixaALIQUOTA_' . $nometubo. '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo() . '" 
                                                 value="'.$_POST['txtCaixaALIQUOTA_' . $nometubo. '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()].'">
                                         </div>
                                         
                                        
                                     <div class="col-md-2" style="padding: 10px;"' . $hidden . '>
                                         <label> Posição </label>
                                         <input type="text" class="form-control form-control-sm" id="idVolume"   style="text-align: center;" placeholder=""
                                                name="txtPosicaoALIQUOTA_' . $nometubo . '_' . $i . '_' .  $tubosLote->getObjTubo()->getIdTubo() . '"  
                                                value="'.$_POST['txtPosicaoALIQUOTA_' . $nometubo . '_' . $i . '_' .  $tubosLote->getObjTubo()->getIdTubo()].'">
                                         </div>';


                                } else {
                                    $show_amostras .= '<label> Próxima Etapa </label>
                                                <input type="text" class="form-control form-control-sm" id="idVolume"  disabled style="text-align: center;" placeholder=""
                                                    name="txtExtracaoALIQUOTA_' . $tubosLote->getObjTubo()->getIdTubo() . '"  value="EXTRAÇÃO">';
                                }

                                if ($i == 3) {
                                    $hidden = ' hidden ';

                                } else {
                                    $hidden = '';
                                }


                                $show_amostras .= '<div class="col-md-1" style="padding: 10px;">
                                         <label> Volume </label>
                                            <input type="number" class="form-control form-control-sm" id="idVolume"   style="text-align: center;" placeholder=""
                                                name="txtVolumeALIQUOTA_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo() . '"  
                                                value="' . $volume . '"> <!--$objInfosTuboNovo->getVolume().-->
                                         </div>
                                         <div class="col-md-1" style="padding: 10px;">';
                                    if($i== 2) {
                                        $show_amostras .= '<small style = "color:red;" > Por padrão o valor do volume será 0.2ml  </small >';
                                    }
                                    $show_amostras .= '</div>
                                </div> ';

                                $checked = '';
                                if($_POST['checkDescartadaALIQUOTA_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()] == 'on'){
                                    $checked = ' checked ';
                                }
                                $show_amostras .= '<div class="form-row " style="background-color: whitesmoke;margin-top: -10px;"> 
                                    <div class="col-md-1" style="background-color: #3a5261"></div>       
                                    <div class="col-md-2">
                                    
                                    <div class="custom-control  custom-checkbox mr-sm-2" style="margin-top: 20px; margin-left: 20px;">
                                        <input type="checkbox" ' . $checked . ' class="custom-control-input" id="check_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo() . '"
                                         name="checkDescartadaALIQUOTA_' . $nometubo . '_' . $i  . '_' . $tubosLote->getObjTubo()->getIdTubo() . '">
                                        <label class="custom-control-label" for="check_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo() . '">Precisou ser descartada</label>
                                      </div>
                                    </div>
                                    <div class="col-md-4" style="padding: 10px;">
                                        <label> Informe se teve algum problema</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" 
                                            name="textAreaProblemaALIQUOTA_' . $nometubo . '_' . $tubosLote->getObjTubo()->getIdTubo() . '" rows="1">'.trim($_POST['textAreaProblema_' . $nometubo . '_' . $tubosLote->getObjTubo()->getIdTubo()]).'</textarea>
                                    </div>
                                    
                                    <div class="col-md-5" style="padding: 10px;">
                                        <label> Observações adicionais</label>
                                           <textarea class="form-control" id="exampleFormControlTextarea1" 
                                           name="textAreaObsALIQUOTA_' . $nometubo . '_' . $tubosLote->getObjTubo()->getIdTubo() . '" rows="1">'.trim($_POST['textAreaObs_' . $nometubo . '_' . $tubosLote->getObjTubo()->getIdTubo()]).'</textarea>
                                    </div>
                                </div>
                                
                                ';

                                if (isset($_POST['btn_terminarPreparacao'])) {
                                    $arr_local = array();
                                    $arr_infos = array();
                                    $objInfosTubo = new InfosTubo();
                                    $objTuboNovo = new Tubo();


                                    //if ($tubosLote->getObjTubo()->getTipo() == TuboRN::$TT_COLETA) {

                                    $objInfosTubo->setIdTubo_fk($tubosLote->getObjTubo()->getIdTubo());
                                    $objInfosTubo = $objInfosTuboRN->pegar_ultimo($objInfosTubo);

                                    $objInfosTubo->setIdInfosTubo(null);
                                    $objInfosTubo->setCodAmostra($tubosLote->getNickname());
                                    //$etapa = $objInfosTubo->getEtapaAnterior();


                                    $objTuboNovo->setTuboOriginal('n');
                                    if ($i == 1) {
                                        $objTuboNovo->setTipo(TuboRN::$TT_ALIQUOTA);
                                        $objInfosTubo->setVolume($objInfosTubo->getVolume() - 0.2);
                                    } else {
                                        $objTuboNovo->setTipo(TuboRN::$TT_INDO_EXTRACAO);
                                        $objInfosTubo->setVolume(0.2);
                                    }
                                    if (isset($_POST['txtVolumeALIQUOTA_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()])) {
                                        $objInfosTubo->setVolume($_POST['txtVolumeALIQUOTA_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()]);
                                    }
                                    $objTuboNovo->setIdAmostra_fk($tubosLote->getIdAmostra());
                                    $objTuboNovo->setIdTubo_fk($tubosLote->getObjTubo()->getIdTubo());

                                    $objLocalArmazenamentoTxt = new LocalArmazenamentoTexto();
                                    if ($i == 1 ) {
                                        if (isset($_POST['txtPosicaoALIQUOTA_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()]) && $_POST['txtPosicaoALIQUOTA_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()] != '') {
                                            $objLocalArmazenamentoTxt->setPosicao(strtoupper(Utils::getInstance()->tirarAcentos($_POST['txtPosicaoALIQUOTA_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()])));
                                        }
                                        if (isset($_POST['txtCaixaALIQUOTA_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()]) && $_POST['txtCaixaALIQUOTA_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()] != '') {
                                            $objLocalArmazenamentoTxt->setCaixa(strtoupper(Utils::getInstance()->tirarAcentos($_POST['txtCaixaALIQUOTA_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()])));
                                        }
                                        if (isset($_POST['nomeLocalArmazenamentoALIQUOTA_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()]) && $_POST['nomeLocalArmazenamentoALIQUOTA_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()] != '') {
                                            $objLocalArmazenamentoTxt->setNome(strtoupper(Utils::getInstance()->tirarAcentos($_POST['nomeLocalArmazenamentoALIQUOTA_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()])));
                                        }
                                        $objLocalArmazenamentoTxt->setIdTipoLocal($arr_tipo[0]->getIdTipoLocalArmazenamento());
                                        //[] = $objLocalArmazenamentoTxt;
                                        $objInfosTubo->setObjLocal($objLocalArmazenamentoTxt);
                                    }

                                    if (isset($_POST['textAreaObsALIQUOTA_' . $nometubo . '_' . $tubosLote->getObjTubo()->getIdTubo()]) && trim($_POST['textAreaObsALIQUOTA_' . $nometubo . '_' . $tubosLote->getObjTubo()->getIdTubo()]) != '') {
                                        $objInfosTubo->setObservacoes($_POST['textAreaObsALIQUOTA_' . $nometubo . '_' . $tubosLote->getObjTubo()->getIdTubo()]);
                                    }
                                    if (isset($_POST['textAreaProblemaALIQUOTA_' . $nometubo . '_' . $tubosLote->getObjTubo()->getIdTubo()]) && trim($_POST['textAreaProblemaALIQUOTA_' . $nometubo . '_' . $tubosLote->getObjTubo()->getIdTubo()]) != '') {
                                        $objInfosTubo->setObsProblema($_POST['textAreaProblemaALIQUOTA_' . $nometubo . '_' . $tubosLote->getObjTubo()->getIdTubo()]);
                                    }

                                    $objInfosTubo->setEtapa(InfosTuboRN::$TP_PREPARACAO_INATIVACAO);
                                    $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                                    $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                                    $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                                    $objInfosTubo->setReteste('n');

                                    if ($_POST['checkDescartadaALIQUOTA_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()] == 'on') {
                                        $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_DESCARTADO_NO_MEIO_ETAPA);
                                    } else {
                                        if ($i == 1 ) {
                                            $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_AGUARDANDO_BANCO_AMOSTRAS);
                                        } else {
                                            $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_TRANSPORTE_EXTRACAO);
                                        }

                                    }

                                    if ($i == 1  || ($i == 2 && $_POST['checkDescartadaALIQUOTA_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()] == 'on')) {
                                        $arr_infos[] = $objInfosTubo;
                                        $objTuboNovo->setObjInfosTubo($arr_infos);
                                        $arr_tubos_cadastro[] = $objTuboNovo;
                                        print_r($arr_tubos_cadastro);
                                    }


                                    if ($i == 2 && $_POST['checkDescartadaALIQUOTA_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()] != 'on') {
                                        $arr_infos = array();
                                        $objInfosTubo->setEtapa(InfosTuboRN::$TP_PREPARACAO_INATIVACAO);
                                        $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                                        $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_TRANSPORTE_EXTRACAO);
                                        $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                                        $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                                        $arr_infos[0] = $objInfosTubo;

                                        $objInfosTubo2 = new InfosTubo();
                                        $objInfosTubo2->setCodAmostra($tubosLote->getNickname());
                                        $objInfosTubo2->setEtapa(InfosTuboRN::$TP_EXTRACAO);
                                        $objInfosTubo2->setIdTubo_fk($objInfosTubo->getIdTubo_fk());
                                        $objInfosTubo2->setIdLote_fk($objInfosTubo->getIdLote_fk());
                                        $objInfosTubo2->setEtapaAnterior(InfosTuboRN::$TP_PREPARACAO_INATIVACAO);
                                        $objInfosTubo2->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                                        $objInfosTubo2->setSituacaoTubo(InfosTuboRN::$TST_TRANSPORTE_EXTRACAO);
                                        $objInfosTubo2->setDataHora(date("Y-m-d H:i:s"));
                                        $objInfosTubo2->setReteste('n');
                                        $objInfosTubo2->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                                        if (isset($_POST['txtVolumeALIQUOTA_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()]) && $_POST['txtVolumeALIQUOTA_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()] != '') {
                                            $objInfosTubo2->setVolume($_POST['txtVolumeALIQUOTA_' . $nometubo . '_' . $i . '_' . $tubosLote->getObjTubo()->getIdTubo()]);
                                        }
                                        $arr_infos[1] = $objInfosTubo2;
                                        $quantidadeTubos++;
                                        $objTuboNovo->setObjInfosTubo($arr_infos);

                                        $objLoteExtracao->setQntAmostrasAdquiridas($quantidadeTubos);
                                        $objLoteExtracao->setQntAmostrasDesejadas($quantidadeTubos);
                                        $tubos_novo_lote[] = $objTuboNovo;
                                        print_r($tubos_novo_lote);
                                    }
                                }
                            }
                        }

                    }


                        $show_amostras .= '</div></div></div></div>';

                    }
                    $style_top++;

                }

                /*
                if (isset($_POST['btn_terminarPreparacao'])) {
                    $salvou_dados = 's';

                    //finalizar o lote pra preparação
                    $objPreparoLote->setIdPreparoLote($_GET['idPreparoLote']);
                    //$objPreparoLoteRN->mudar_status_lote($objPreparoLote, LoteRN::$TE_PREPARACAO_FINALIZADA);
                    $objPreparoLote = $objPreparoLoteRN->consultar($objPreparoLote);
                    $objLote->setIdLote($objPreparoLote->getIdLoteFk());
                    $arr_perfis = $objLoteRN->consultar_perfis($objLote);

                    $objPreparoLote = new PreparoLote();

                    //lote para extração
                    if(count($tubos_novo_lote) > 0) {
                        $objLoteExtracao->setTipo(LoteRN::$TL_EXTRACAO);
                        $objLoteExtracao->setSituacaoLote(LoteRN::$TE_AGUARDANDO_EXTRACAO);
                        $objLoteExtracao->setObjsTubo($tubos_novo_lote);
                        $objPreparoLote->setObjLote($objLoteExtracao);
                    }else{
                        $alert .= Alert::alert_warning("Nenhum lote de extração será feito");
                    }
                    //$objRel_Perfil_preparoLote = new Rel_perfil_preparoLote();
                    //$objRel_Perfil_preparoLoteRN = new Rel_perfil_preparoLote_RN();

                    $objPreparoLote->setIdUsuarioFk(Sessao::getInstance()->getIdUsuario());
                    $_SESSION['DATA_SAIDA'] = date("Y-m-d H:i:s");
                    $objPreparoLote->setDataHoraFim($_SESSION['DATA_SAIDA']);
                    $objPreparoLote->setDataHoraInicio($_SESSION['DATA_LOGIN']);
                    $objPreparoLote->setObjPerfil($arr_perfis);

                    $objPreparoLote->setObjsTubosCadastro($arr_tubos_cadastro);
                    $objPreparoLote->setObjsTubosAlterados($arr_tubos_alterados);


                    $objRel_Perfil_preparoLote->setObjPreparoLote($objPreparoLote);
                    $objRel_Perfil_preparoLote->setObjPerfilPaciente($arr_perfis);
                    //print_r($objRel_Perfil_preparoLote);

                    $objRel_Perfil_preparoLote = $objRel_Perfil_preparoLoteRN->cadastrar($objRel_Perfil_preparoLote);

                    $alert = Alert::alert_success('Cadastrado com sucesso');

                    //LIBEREI A CAPELA
                    $objCapela->setIdCapela($_GET['idCapela']);
                    $objCapela = $objCapelaRN->consultar($objCapela);
                    $objCapela->setSituacaoCapela(CapelaRN::$TE_LIBERADA);
                    $objCapelaRN->alterar($objCapela);

                    //MUDOU A SITUAÇÃO DO LOTE
                    $objPreparoLote->setIdPreparoLote($_GET['idPreparoLote']);
                    $objPreparoLoteRN->mudar_status_lote($objPreparoLote, LoteRN::$TE_PREPARACAO_FINALIZADA);

                    $sumir_btns = 's';

                    // $arr_tubos
                    //foreach ($arr_tubos[0]->getObjsTubos() as $tubo) {
                        $objInfosTuboRN = new InfosTuboRN();
                        //r($objRel_Perfil_preparoLote->getObjPreparoLote());
                        $objInfosTuboRN->validar_volume($objRel_Perfil_preparoLote->getObjPreparoLote());
                    //}

                }*/

            }
        }



} catch (Throwable $ex) {
    //die($ex);
    $show_collap = 's';
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Montar grupo");
Pagina::getInstance()->adicionar_css("precadastros");
if($cadastrar_novo  == 's') {
    Pagina::getInstance()->adicionar_javascript("popUp");
}
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
echo $alert;
Pagina::getInstance()->mostrar_excecoes();

echo '<!-- Modal -->
    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="text-align: center">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                    Deseja montar outro grupo de amostras? </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"  >Close</button>
                    <button type="button"  class="btn btn-primary">
                    <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=realizar_preparo_inativacao&idLiberar=' . $_GET['idCapela']) . '">Tenho certeza</a></button>
                </div>
            </div>
        </div>
    </div>';

echo '<div class="conteudo_grande " >
         <form method="POST">
                <div class="form-row" >
                    <div class="col-md-12">
                        <input type="text" class="form-control" id="idDataHoraLogin" hidden style="text-align: center;"
                               name="dtHoraLoginInicio" required value="' . $_SESSION['DATA_LOGIN'] . '">
                     </div>
                    <div class="col-md-6">
                        <label>Escolha uma capela de alta segurança</label>'
                        .$select_capelas.
                    '</div>
              
                   <div class="col-md-6"> 
                    <label>Escolha um grupo de amostras</label>'
                        .$select_grupos.
                    '</div>
                </div>';
                if($sumir_btn_alocar == 'n') {
                    echo '<div class="form-row" >
                    <div class="col-md-12" >
                        <button class="btn btn-primary"  type = "submit" style = "width: 25%; margin-left: 35%;" name = "btn_alocarCapela" > SELECIONAR </button >
                    </div >
                 </div >';
                    }
               echo '</div>
         </form>
      </div>';

if(isset($_GET['idCapela']) && isset($_GET['idPreparoLote'])) {
    echo '<div class="conteudo_grande preparo_inativacao">
         <form method="POST">
                <div class="form-row" >
                    <div class="col-md-12">'
        . $show_amostras .
        '</div>
                </div>';

                if($sumir_btns == 'n') {
                    echo '  <div class="form-row" >';
                    if ($ja_confirmou == 'n') {
                        echo '<div class="col-md-6">
               <button class="btn btn-primary" STYLE="width: 50%;margin-left: 50%;" type="submit" name="btn_confirmarPreparacao">INICIAR PREPARAÇÃO</button>
             </div>';
                    } else {
                        //if($sumir_btns == 'n') {
                        echo '<div class="col-md-6">
               <button class="btn btn-primary" STYLE="width: 50%;margin-left: 50%;" type="submit" name="btn_terminarPreparacao">SALVAR DADOS</button>
             </div>';
                        //}
                    }
                    echo '<div class="col-md-6">
                       <button class="btn btn-primary" STYLE="width: 50%;margin-left: 0%;"  type="submit" name="btn_cancelar">CANCELAR</button>
                     </div>
                     </div>';
                }
         echo '
                </form>
      </div>';
}

Pagina::getInstance()->fechar_corpo();