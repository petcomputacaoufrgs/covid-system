<?php

session_start();
try {
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';

    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';

    require_once __DIR__ . '/../../classes/Capela/Capela.php';
    require_once __DIR__ . '/../../classes/Capela/CapelaRN.php';
    require_once __DIR__ . '/../../classes/Capela/CapelaINT.php';

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
    require_once __DIR__ . '/../../classes/PreparoLote/PreparoLoteINT.php';

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

    require_once __DIR__. '/../../classes/KitExtracao/KitExtracao.php';
    require_once __DIR__. '/../../classes/KitExtracao/KitExtracaoRN.php';
    require_once __DIR__. '/../../classes/KitExtracao/KitExtracaoINT.php';



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


     /*
      *  USUÁRIO
      */
    $objUsuario = new Usuario();
    $objUsuarioRN = new UsuarioRN();

    /*
     *  KITS DE EXTRAÇÃO
     */
    $objKitExtracao = new KitExtracao();
    $objKitExtracaoRN = new KitExtracaoRN();

    $ja_confirmou = 'n';
    $show_amostras = '';
    $select_capelas = '';
    $select_grupos = '';
    $sumir_btn_alocar = 'n';
    $salvou_dados = 'n';
    $show_collap = '';

    $select_kitExtracao = '';
    $sumir_btns = 'n';
    $objPreparoLoteORIGINAL = new PreparoLote();
    $disabled_inputs = '';
    $nome_botao_alocar ='';
    $disabled_responsavel = '';



    switch ($_GET['action']) {
        case 'realizar_extracao':
            $nome_botao_alocar = 'SALVAR';
            if ($_GET['idLiberar'] || isset($_POST['btn_cancelar'])) {
                $objCapela->setIdCapela($_GET['idCapela']);
                $objCapela = $objCapelaRN->consultar($objCapela);
                $objCapela->setSituacaoCapela(CapelaRN::$TE_LIBERADA);
                $objCapelaRN->alterar($objCapela);
                $objPreparoLoteAuxiliar = new PreparoLote();
                $objPreparoLoteAuxiliar->setIdPreparoLote($_GET['idPreparoLote']);
                $objPreparoLoteAuxiliar = $objPreparoLoteRN->consultar_lote($objPreparoLoteAuxiliar);
                //print_r($objPreparoLoteAuxiliar);

                if ($objPreparoLoteAuxiliar->getObjLote()->getSituacaoLote() != LoteRN::$TE_EXTRACAO_FINALIZADA) {
                    //$objPreparoLote->setIdPreparoLote($_GET['idPreparoLote']);
                    //$objPreparoLote = $objPreparoLoteRN->consultar($objPreparoLote);
                    //$objPreparoLote->setIdCapelaFk(null);
                    $objPreparoLoteAuxiliar->setIdCapelaFk(null);
                    $objPreparoLoteRN->mudar_status_lote($objPreparoLoteAuxiliar, LoteRN::$TE_AGUARDANDO_EXTRACAO);
                }


                header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=realizar_extracao'));
                die();
            }

            if (isset($_GET['idSituacao'])) {
                if ($_GET['idSituacao'] == 2) {
                    $alert = Alert::alert_danger("O lote de extração já foi finalizado");
                }
            }

            if (isset($_GET['idPreparoLote'])) {
                $objPreparoLote->setIdPreparoLote($_GET['idPreparoLote']);
            }

            $selecionado = '';

            $objCapela->setNivelSeguranca(CapelaRN::$TNS_MEDIA_SEGURANCA);
            CapelaINT::montar_capelas_liberadas($select_capelas,$objCapela, $objCapelaRN,null,null);

            $objLote->setTipo(LoteRN::$TL_EXTRACAO);
            $objLote->setSituacaoLote(LoteRN::$TE_AGUARDANDO_EXTRACAO);
            $objPreparoLoteORIGINAL->setObjLote($objLote);
            PreparoLoteINT::montar_select_lotes($select_grupos,$objPreparoLoteORIGINAL, $objPreparoLoteRN, null,null);
            KitExtracaoINT::montar_select_kitsExtracao($select_kitExtracao,$objKitExtracao, $objKitExtracaoRN, null,null);

        if (strlen($select_grupos) > 0) {

            if (isset($_POST['btn_alocarCapela']) && !isset($_GET['idCapela'])) {

                $objCapela->setIdCapela($_POST['sel_nivelSegsCapela']);
                $objCapela->setNivelSeguranca(CapelaRN::$TNS_MEDIA_SEGURANCA);

                $objPreparoLoteORIGINAL->setIdPreparoLote($_POST['sel_preparo_lote']);
                $objPreparoLoteORIGINAL = $objPreparoLoteRN->consultar($objPreparoLoteORIGINAL);

                $objPreparoLoteORIGINAL->setObsKitExtracao($_POST['txtObsKit']);
                $objPreparoLoteORIGINAL->setLoteFabricacaokitExtracao($_POST['txtLoteFabricacaoKit']);

                if(isset($_POST['txtNomeResponsavel']) && strlen($_POST['txtNomeResponsavel']) > 0) {
                    $objPreparoLoteORIGINAL->setNomeResponsavel($_POST['txtNomeResponsavel']);
                }

                if(isset($_POST['txtMatricula']) && strlen($_POST['txtMatricula']) > 0 ) {
                    $objPreparoLoteORIGINAL->setIdResponsavel(strtoupper($_POST['txtMatricula']));

                }
                //print_r($objPreparoLoteORIGINAL);
                //die();

                $objPreparoLoteORIGINAL = $objPreparoLoteRN->alterar($objPreparoLoteORIGINAL);
                if($objPreparoLoteORIGINAL->getIdResponsavel() != null) {
                    $objUsuario->setIdUsuario($objPreparoLoteORIGINAL->getIdResponsavel());
                    $objUsuario = $objUsuarioRN->consultar($objUsuario);
                    $objPreparoLoteORIGINAL->setIdResponsavel($objUsuario->getMatricula());

                }

                $objCapelaRN->bloquear_registro($objCapela);
                header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=realizar_extracao&idCapela=' . $_POST['sel_nivelSegsCapela'] . '&idPreparoLote=' . $_POST['sel_preparo_lote'] . '&idKitExtracao=' . $_POST['sel_kit_extracao']));
                die();

            }


            if (isset($_POST['sel_capelasOcupadas'])) {
                header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=realizar_preparo_inativacao&idCapela=' . $_POST['sel_capelasOcupadas']));
                die();
            }


            if ((isset($_GET['idCapela']) && isset($_GET['idPreparoLote'])) || isset($_POST['btn_confirmar_extracao']) || isset($_POST['btn_terminar_extracao'])) {
                //garantir que não vá cadastrar outros ao mesmo tempo
                $disabled_responsavel = ' disabled ';
                $objPreparoLoteAuxiliar = new PreparoLote();
                $objPreparoLoteAuxiliar->setIdPreparoLote($_GET['idPreparoLote']);
                $objPreparoLoteAuxiliar = $objPreparoLoteRN->consultar_lote($objPreparoLoteAuxiliar);
                //print_r($objPreparoLoteAuxiliar);
                if ($objPreparoLoteAuxiliar->getObjLote()->getSituacaoLote() == LoteRN::$TE_EXTRACAO_FINALIZADA) {

                    $objCapela->setIdCapela($_GET['idCapela']);
                    $objCapela = $objCapelaRN->consultar($objCapela);
                    $objCapela->setSituacaoCapela(CapelaRN::$TE_LIBERADA);
                    $objCapelaRN->alterar($objCapela);
                    header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=realizar_preparo_inativacao&idSituacao=2'));
                    die();

                } else {


                    $sumir_btn_alocar = 's';
                    if (isset($_POST['btn_confirmar_extracao']) || isset($_POST['btn_terminar_extracao'])) {
                        $ja_confirmou = 's';
                    }
                    $objCapela->setIdCapela($_GET['idCapela']);
                    $objCapela = $objCapelaRN->consultar($objCapela);
                    $alert = Alert::alert_primary("Capela de número " . $objCapela->getNumero() . " alocada com SUCESSO");
                    $selecionado = $_GET['idCapela'];

                    InterfacePagina::montar_capelas_liberadas($objCapela, $objCapelaRN, $select_capelas, CapelaRN::$TNS_MEDIA_SEGURANCA, ' disabled ');
                    $objPreparoLote->setIdPreparoLote($_GET['idPreparoLote']);
                    InterfacePagina::montar_grupos_amostras($objPreparoLote, $objPreparoLoteRN, $select_grupos, ' disabled ', LoteRN::$TL_EXTRACAO);
                    $objKitExtracao->setIdKitExtracao($_GET['idKitExtracao']);
                    InterfacePagina::montar_select_kitsExtracao($objKitExtracao, $objKitExtracaoRN, $select_kitExtracao, ' disabled ');

                    $arr_tubos = $objPreparoLoteRN->consultar_tubos($objPreparoLote);
                    //print_r($arr_tubos);

                    $objPreparoLote->setIdPreparoLote($_GET['idPreparoLote']);
                    $objPreparoLote = $objPreparoLoteRN->consultar($objPreparoLote);
                    $objPreparoLoteORIGINAL = $objPreparoLoteRN->consultar($objPreparoLote);
                    $disabled_inputs = ' disabled ';
                    $objPreparoLote->setIdCapelaFk($_GET['idCapela']);
                    $objPreparoLote->setIdKitExtracaoFk($_GET['idKitExtracao']);

                    //print_r($objPreparoLote);
                    //die();
                    if($objPreparoLote->getIdResponsavel() != null) {
                        $objUsuario->setIdUsuario($objPreparoLote->getIdResponsavel());
                        $objUsuario = $objUsuarioRN->consultar($objUsuario);
                        $objPreparoLote->setIdResponsavel($objUsuario->getMatricula());
                        $objPreparoLoteORIGINAL->setIdResponsavel($objUsuario->getMatricula());
                    }


                    $objPreparoLote = $objPreparoLoteRN->alterar($objPreparoLote);
                    $objPreparoLoteRN->mudar_status_lote($objPreparoLote, LoteRN::$TE_EM_EXTRACAO);


                    $cont = 0;
                    $objPreparoLote->setIdPreparoLote($_GET['idPreparoLote']);
                    $objPreparoLote = $objPreparoLoteRN->consultar($objPreparoLote);

                    $objLoteExtracao = new Lote();
                    //$objPreparoLote = new PreparoLote();
                    $quantidadeTubos = 0;

                    $objTipoLocalArmazenamento->setCaractereTipo(TipoLocalArmazenamentoRN::$TL_APOS_EXTRACAO);
                    $arr_tipo = $objTipoLocalArmazenamentoRN->listar($objTipoLocalArmazenamento);

                    $contador = 0;
                    $contadorDel = 0;
                    $style_top = 0;
                    $arr_tubos_alterados = array();

                    $arr_JSCopiarLocal = array();
                    $arr_JSCopiarCaixa = array();
                    $arr_JSCopiarPorta = array();
                    $arr_JSCopiarColuna = array();
                    $arr_JSCopiarPrateleira = array();
                    $primeiro = true;


                    foreach ($arr_tubos[0]->getObjsTubos() as $tubosLote) {

                        $objInfosTubo->setIdTubo_fk($tubosLote->getObjTubo()->getIdTubo());
                        $objInfosTubo = $objInfosTuboRN->pegar_ultimo($objInfosTubo);
                        //print_r($objInfosTubo);

                        //$objLocalArmazenamentoTxt->setIdLocal($objInfosTubo->getIdLocalFk());
                        //$objLocalArmazenamentoTxt = $objLocalArmazenamentoTxtRN->consultar($objLocalArmazenamentoTxt);

                        if ($objInfosTubo->getReteste() == 'n' || $objInfosTubo->getReteste() == '') {
                            $reteste = "NÃO";
                        } else {
                            $reteste = "SIM";
                        }

                        $show = 'show ';
                        $style = 'style="margin-top: 10px;';

                        if ($style_top == 0) {
                            //$style = 'style="margin-top: -45px;';

                        }
                        $style_top++;


                        $disabled = '  ';
                        if (isset($_GET['idCapela']) && !isset($_POST['btn_confirmar_extracao']) && !isset($_POST['btn_terminar_extracao'])) {
                            $disabled = ' disabled ';
                        }

                        if (isset($_POST['btn_confirmar_extracao'])) {
                            $disabled = '';
                        }


                        $show_amostras .= '
                   
                    <div class="accordion" id="accordionExample" ' . $style . '">
                          <div class="card">
                          
                            <div class="card-header" id="heading_' . $tubosLote->getObjTubo()->getIdTubo() . '">
                              <h5 class="mb-0">
                                <button  style="text-decoration: none;color: #3a5261;"  class="btn btn-link" type="button" 
                                data-toggle="collapse" data-target="#collapse_' . $tubosLote->getObjTubo()->getIdTubo() . '" aria-expanded="true" aria-controls="collapseOne">
                                  <h5>AMOSTRA ' . $tubosLote->getNickname() . '</h5>
                                </button>
                              </h5>
                            </div>
                        
                            <div id="collapse_' . $tubosLote->getObjTubo()->getIdTubo() . '" class="collapse ' . $show . ' " 
                            aria-labelledby="heading_' . $tubosLote->getObjTubo()->getIdTubo() . '" data-parent="#accordionExample">
                              <div class="card-body">
                                    <div class="form-row" >
                                         <div class="col-md-12" style="background-color: #3a5261;padding: 5px;font-size: 13px;font-weight: bold; color: whitesmoke;">
                                            AMOSTRA INATIVADA
                                         </div>
                                    </div>
                                    <div class="form-row" >
                                        
                                        <div class="col-md-6">
                                            <label> Volume</label>
                                                <input type="number" class="form-control form-control-sm" id="idVolume"  ' . $disabled . ' style="text-align: center;" placeholder="" ' . $disabled . '
                                                    name="txtVolume_' . $tubosLote->getObjTubo()->getIdTubo() . '"  value="' . $objInfosTubo->getVolume() . '">
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label> Reteste</label>
                                                <input type="text" class="form-control form-control-sm" id="idReteste"  disabled style="text-align: center;" placeholder=""' . $disabled . '
                                                    name="txtReteste_' . $tubosLote->getObjTubo()->getIdTubo() . '"  value="' . $reteste . '">
                                        </div>
                                    </div>
                                    
                                    <div class="form-row" >';
                        $strIdLocalArmazenamento = 'nomeLocalArmazenamento_' . $tubosLote->getObjTubo()->getIdTubo();
                        $show_amostras .= '  <div class="col-md-4">
                                           <label> Local de armazenamento </label>
                                                <input type="text" class="form-control form-control-sm"  ' . $disabled . ' style="text-align: center;" placeholder=""
                                                        name="' . $strIdLocalArmazenamento . '" 
                                                         value="' . $_POST[$strIdLocalArmazenamento] . '"
                                                         id="' . $strIdLocalArmazenamento . '">
                                        </div>';
                        $arr_JSCopiarLocal[] = $strIdLocalArmazenamento;

                        $strIdPorta = 'txtPorta_' . $tubosLote->getObjTubo()->getIdTubo();
                        $show_amostras .= '        <div class="col-md-4">
                                           <label> Porta </label>
                                                <input type="text" class="form-control form-control-sm" ' . $disabled . ' style="text-align: center;" placeholder=""
                                                        name="' . $strIdPorta . '" 
                                                         value="' . $_POST[$strIdPorta] . '"
                                                         id="' . $strIdPorta . '">
                                        </div>';
                        $arr_JSCopiarPorta[] = $strIdPorta;

                        $strIdPrateleira = 'txtPrateleira_' . $tubosLote->getObjTubo()->getIdTubo();
                        $show_amostras .= ' <div class="col-md-4">
                                           <label> Prateleira </label>
                                                <input type="text" class="form-control form-control-sm" ' . $disabled . ' style="text-align: center;" placeholder=""
                                                        name="' . $strIdPrateleira . '" 
                                                         value="' . $_POST[$strIdPrateleira] . '"
                                                         id="' . $strIdPrateleira . '">
                                        </div>
                                        </div>';
                        $arr_JSCopiarPrateleira[] = $strIdPrateleira;

                        $strIdColuna = 'txtColuna_' . $tubosLote->getObjTubo()->getIdTubo();
                        $show_amostras .= '  <div class="form-row" >
                                        <div class="col-md-4">
                                                <label> Coluna </label>
                                                <input type="text" class="form-control form-control-sm"  ' . $disabled . ' style="text-align: center;" placeholder=""
                                                    name="' . $strIdColuna . '" 
                                                     value="' . $_POST[$strIdColuna] . '"
                                                     id="' . $strIdColuna . '">
                                             </div>';
                        $arr_JSCopiarColuna[] = $strIdColuna;

                        $strIdCaixa = 'txtCaixa_' . $tubosLote->getObjTubo()->getIdTubo();
                        $show_amostras .= '<div class="col-md-4">
                                                <label> Caixa </label>
                                                <input type="text" class="form-control form-control-sm"   ' . $disabled . ' style="text-align: center;" placeholder=""
                                                    name="' . $strIdCaixa . '" 
                                                     value="' . $_POST[$strIdCaixa] . '"
                                                     id="' . $strIdCaixa . '">
                                             </div>';
                        $arr_JSCopiarCaixa[] = $strIdCaixa;


                        $show_amostras .= '      <div class="col-md-4">
                                                
                                                <label> Posição (letra+número) </label>
                                                 <input type="text" class="form-control form-control-sm"  ' . $disabled . '  style="text-align: center;" placeholder=""
                                                        name="txtPosicao_' . $tubosLote->getObjTubo()->getIdTubo() . '"  
                                                        value="' . $_POST['txtPosicao_' . $tubosLote->getObjTubo()->getIdTubo()] . '">
                                             </div>
                                        </div>';
                        if ($primeiro && isset($_POST['btn_confirmar_extracao'])) {
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
                   
                                            <input type="checkbox" ' . $checked . ' class="custom-control-input" id="customDercartada_' . $tubosLote->getObjTubo()->getIdTubo() . '" ' . $disabled . '
                                            name="checkDercartada_' . $tubosLote->getObjTubo()->getIdTubo() . '">
                                            <label class="custom-control-label" for="customDercartada_' . $tubosLote->getObjTubo()->getIdTubo() . '">Precisou ser descartado no meio da extração</label>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label> Informe se teve algum problema</label>
                                                <textarea class="form-control form-control-sm" id="exampleFormControlTextarea1" ' . $disabled . '
                                                name="textAreaProblema_' . $tubosLote->getObjTubo()->getIdTubo() . '" rows="1">' . $_POST['textAreaProblema_' . $tubosLote->getObjTubo()->getIdTubo()] . '</textarea>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label> Observações adicionais</label>
                                               <textarea class="form-control form-control-sm" id="exampleFormControlTextarea1" ' . $disabled . '
                                               name="textAreaObs_' . $tubosLote->getObjTubo()->getIdTubo() . '" rows="1">' . $_POST['textAreaObs_' . $tubosLote->getObjTubo()->getIdTubo()] . '</textarea>
                                        </div>
                                    </div>
                                    
                                     
                                        
                                                                          
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                   
                                    
                                    ';

                        //tubo
                        if (isset($_POST['btn_terminar_extracao'])) {


                            //não remover o idLote desse
                            $arr_infos = array();
                            $objTubo = new Tubo();
                            $objInfosTubo = new InfosTubo();
                            //altera apenas o infos tubo adicionando uma coluna, como é o tubo  ele é descartado depois
                            $objTubo->setIdTubo($tubosLote->getObjTubo()->getIdTubo());
                            $objTubo = $objTuboRN->consultar($objTubo);
                            $objTubo->setTipo(TuboRN::$TT_RNA);

                            $objInfosTubo->setIdTubo_fk($tubosLote->getObjTubo()->getIdTubo());
                            $objInfosTubo = $objInfosTuboRN->pegar_ultimo($objInfosTubo);


                            //pretende cadastrar um novo infotubo
                            $objInfosTubo->setIdInfosTubo(null);
                            $objInfosTubo->setCodAmostra($tubosLote->getNickname());
                            $objInfosTubo->setEtapaAnterior(InfosTuboRN::$TP_PREPARACAO_INATIVACAO);
                            $objInfosTubo->setEtapa(InfosTuboRN::$TP_EXTRACAO);
                            $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                            $objInfosTubo->setIdTubo_fk($tubosLote->getObjTubo()->getIdTubo());

                            if (isset($_POST['txtVolume_' . $tubosLote->getObjTubo()->getIdTubo()]) && $_POST['txtVolume_' . $tubosLote->getObjTubo()->getIdTubo()] != '') {
                                //ECHO "$".$_POST['txtVolume_' . $tubosLote->getObjTubo()->getIdTubo()]."$";
                                $objInfosTubo->setVolume($_POST['txtVolume_' . $tubosLote->getObjTubo()->getIdTubo()]);
                            }

                            if (isset($_POST['textAreaProblema_' . $tubosLote->getObjTubo()->getIdTubo()]) && $_POST['textAreaProblema_' . $tubosLote->getObjTubo()->getIdTubo()] != '') {
                                $objInfosTubo->setObsProblema($_POST['textAreaProblema_' . $tubosLote->getObjTubo()->getIdTubo()]);
                            }

                            if (isset($_POST['textAreaObs_' . $tubosLote->getObjTubo()->getIdTubo()]) && $_POST['textAreaObs_' . $tubosLote->getObjTubo()->getIdTubo()] != '') {
                                $objInfosTubo->setObservacoes($_POST['textAreaObs_' . $tubosLote->getObjTubo()->getIdTubo()]);
                            }

                            $objLocalArmazenamentoTxt = new LocalArmazenamentoTexto();

                            if (isset($_POST['txtPosicao_' . $tubosLote->getObjTubo()->getIdTubo()]) && $_POST['txtPosicao_' . $tubosLote->getObjTubo()->getIdTubo()] != '') {
                                $objLocalArmazenamentoTxt->setPosicao(strtoupper(Utils::getInstance()->tirarAcentos($_POST['txtPosicao_' . $tubosLote->getObjTubo()->getIdTubo()])));
                            }
                            if (isset($_POST['txtCaixa_' . $tubosLote->getObjTubo()->getIdTubo()]) && $_POST['txtCaixa_' . $tubosLote->getObjTubo()->getIdTubo()] != '') {
                                $objLocalArmazenamentoTxt->setCaixa(strtoupper(Utils::getInstance()->tirarAcentos($_POST['txtCaixa_' . $tubosLote->getObjTubo()->getIdTubo()])));
                            }
                            if (isset($_POST['nomeLocalArmazenamento_' . $tubosLote->getObjTubo()->getIdTubo()]) && $_POST['nomeLocalArmazenamento_' . $tubosLote->getObjTubo()->getIdTubo()] != '') {
                                $objLocalArmazenamentoTxt->setNome(strtoupper(Utils::getInstance()->tirarAcentos($_POST['nomeLocalArmazenamento_' . $tubosLote->getObjTubo()->getIdTubo()])));
                            }

                            if (isset($_POST['txtPorta_' . $tubosLote->getObjTubo()->getIdTubo()]) && $_POST['txtPorta_' . $tubosLote->getObjTubo()->getIdTubo()] != '') {
                                $objLocalArmazenamentoTxt->setPorta(strtoupper(Utils::getInstance()->tirarAcentos($_POST['txtPorta_' . $tubosLote->getObjTubo()->getIdTubo()])));
                            }

                            if (isset($_POST['txtColuna_' . $tubosLote->getObjTubo()->getIdTubo()]) && $_POST['txtColuna_' . $tubosLote->getObjTubo()->getIdTubo()] != '') {
                                $objLocalArmazenamentoTxt->setColuna(strtoupper(Utils::getInstance()->tirarAcentos($_POST['txtColuna_' . $tubosLote->getObjTubo()->getIdTubo()])));
                            }
                            if (isset($_POST['txtPrateleira_' . $tubosLote->getObjTubo()->getIdTubo()]) && $_POST['txtColuna_' . $tubosLote->getObjTubo()->getIdTubo()] != '') {
                                $objLocalArmazenamentoTxt->setPrateleira(strtoupper(Utils::getInstance()->tirarAcentos($_POST['txtPrateleira_' . $tubosLote->getObjTubo()->getIdTubo()])));
                            }


                            $objLocalArmazenamentoTxt->setIdTipoLocal($arr_tipo[0]->getIdTipoLocalArmazenamento());
                            //$arr_local[] = $objLocalArmazenamentoTxt;
                            //$objInfosTubo->setObjLocal($arr_local);
                            $objInfosTubo->setObjLocal($objLocalArmazenamentoTxt);


                            $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                            $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                            if ($_POST['checkDercartada_' . $tubosLote->getObjTubo()->getIdTubo()] == 'on') {
                                $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_DESCARTADO_NO_MEIO_ETAPA);
                            } else {
                                $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_AGUARDANDO_SOLICITACAO_MONTAGEM_PLACA);
                            }
                            $objInfosTubo->setObjTubo($objTubo);
                            $objInfosTubo->setIdLote_fk($objPreparoLote->getIdLoteFk());
                            $arr_infos = array();
                            $arr_infos[0] = $objInfosTubo;


                            if($objInfosTubo->getSituacaoTubo() != InfosTuboRN::$TST_DESCARTADO_NO_MEIO_ETAPA) {
                                $objInfosTubo2 = new InfosTubo();
                                $objInfosTubo2->setObjLocal($objInfosTubo->getObjLocal());
                                $objInfosTubo2->setIdTubo_fk($objInfosTubo->getIdTubo_fk());
                                $objInfosTubo2->setIdLote_fk($objInfosTubo->getIdLote_fk());
                                $objInfosTubo2->setDataHora($objInfosTubo->getDataHora());
                                $objInfosTubo2->setReteste($objInfosTubo->getReteste());
                                $objInfosTubo2->setCodAmostra($objInfosTubo->getCodAmostra());
                                $objInfosTubo2->setObservacoes($objInfosTubo->getObservacoes());
                                $objInfosTubo2->setObsProblema($objInfosTubo->getObsProblema());
                                $objInfosTubo2->setEtapaAnterior(InfosTuboRN::$TP_EXTRACAO);
                                $objInfosTubo2->setEtapa(InfosTuboRN::$TP_RTqPCR_SOLICITACAO__MONTAGEM_PLACA);
                                $objInfosTubo2->setVolume($objInfosTubo->getVolume());
                                $objInfosTubo2->setIdUsuario_fk($objInfosTubo->getIdUsuario_fk());
                                $objInfosTubo2->setSituacaoTubo(InfosTuboRN::$TST_AGUARDANDO_SOLICITACAO_MONTAGEM_PLACA);
                                $objInfosTubo2->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                                $arr_infos[1] = $objInfosTubo2;
                                $objTubo->setObjInfosTubo($arr_infos);

                            }else{
                                $objInfosTubo3 = new InfosTubo();
                                $objInfosTubo3->setObjLocal($objInfosTubo->getObjLocal());
                                $objInfosTubo3->setIdTubo_fk($objInfosTubo->getIdTubo_fk());
                                $objInfosTubo3->setIdLote_fk(null);
                                $objInfosTubo3->setCodAmostra($tubosLote->getNickname());
                                $objInfosTubo3->setDataHora($objInfosTubo->getDataHora());
                                $objInfosTubo3->setReteste($objInfosTubo->getReteste());
                                $objInfosTubo3->setObservacoes($objInfosTubo->getObservacoes());
                                $objInfosTubo3->setObsProblema($objInfosTubo->getObsProblema());
                                $objInfosTubo3->setEtapaAnterior(InfosTuboRN::$TP_PREPARACAO_INATIVACAO);
                                $objInfosTubo3->setEtapa(InfosTuboRN::$TP_EXTRACAO);
                                $objInfosTubo3->setVolume($objInfosTubo->getVolume());
                                $objInfosTubo3->setIdUsuario_fk($objInfosTubo->getIdUsuario_fk());
                                $objInfosTubo3->setSituacaoTubo(InfosTuboRN::$TST_DESCARTADO_NO_MEIO_ETAPA);
                                $objInfosTubo3->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                                $objInfosTubo3->setObjTubo($objTubo);
                                $objTubo->setObjInfosTubo($objInfosTubo3);
                            }


                            if($objInfosTubo->getSituacaoTubo() == InfosTuboRN::$TST_DESCARTADO_NO_MEIO_ETAPA) {
                                $arr_tubos_deletados_lote[$contadorDel] = $objTubo;
                                $contadorDel++;
                            }
                            else{
                                $arr_tubos_alterados[$contador] = $objTubo;
                                $contador++;
                            }


                        }
                    }

                    if (isset($_POST['btn_terminar_extracao'])) {

                        //print_r($arr_tubos_alterados);


                        $objCapela->setIdCapela($_GET['idCapela']);
                        $objCapela = $objCapelaRN->consultar($objCapela);
                        $objCapela->setSituacaoCapela(CapelaRN::$TE_LIBERADA);
                        $objCapelaRN->alterar($objCapela);

                        //garantir que não vá cadastrar outros ao mesmo tempo
                        $objPreparoLoteAuxiliar = new PreparoLote();
                        $objPreparoLoteAuxiliar->setIdPreparoLote($_GET['idPreparoLote']);
                        $objPreparoLoteAuxiliar = $objPreparoLoteRN->consultar_lote($objPreparoLoteAuxiliar);

                        $objLote = $objPreparoLoteAuxiliar->getObjLote();
                        $objLote->setObjsTubo($arr_tubos_alterados);
                        //$objTuboRN->alterar_array_tubos($arr_tubos_alterados);
                        //print_r($objPreparoLoteAuxiliar);
                        if($objPreparoLoteAuxiliar->getIdResponsavel() != null) {
                            $objUsuario->setIdUsuario($objPreparoLoteAuxiliar->getIdResponsavel());
                            $objUsuario = $objUsuarioRN->consultar($objUsuario);
                            $objPreparoLoteAuxiliar->setIdResponsavel($objUsuario->getMatricula());
                        }

                        if ($objPreparoLoteAuxiliar->getObjLote()->getSituacaoLote() == LoteRN::$TE_EXTRACAO_FINALIZADA) {

                            header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=realizar_extracao&idSituacao=2'));
                            die();

                        } else {

                            $objPreparoLoteAuxiliar->setObjLote($objLote);
                            $objPreparoLoteAuxiliar->setDataHoraFim(date("Y-m-d H:i:s"));
                            $objPreparoLoteRN->alterar($objPreparoLoteAuxiliar);

                            foreach ($arr_tubos_deletados_lote as $tubosDeletados){
                                $objInfosTuboRN->cadastrar($tubosDeletados->getObjInfosTubo());
                            }

                            //MUDOU A SITUAÇÃO DO LOTE
                            $objPreparoLote->setIdPreparoLote($_GET['idPreparoLote']);
                            $objPreparoLoteRN->mudar_status_lote($objPreparoLote, LoteRN::$TE_EXTRACAO_FINALIZADA);
                            $sumir_btns = 's';
                            $cadastrar_novo = 's';

                            $alert = Alert::alert_success("Dados cadastrados com sucesso");
                        }
                    }


                }


            }
        }
        break;
        case 'editar_extracao':

            $nome_botao_alocar = 'EDITAR';
            $sumir_btns = 's';

            $objPreparoLote->setIdPreparoLote($_GET['idPreparoLote']);
            //$objPreparoLote = $objPreparoLoteRN->obter_todas_infos($objPreparoLote);
            $objCapela->setIdCapela($_GET['idCapela']);
            $objCapela->setNivelSeguranca(CapelaRN::$TNS_MEDIA_SEGURANCA);
            $objKitExtracao->setIdKitExtracao($_GET['idKitExtracao']);
            InterfacePagina::montar_capelas_liberadas($objCapela, $objCapelaRN, $select_capelas, CapelaRN::$TNS_MEDIA_SEGURANCA, '  ');
            InterfacePagina::montar_grupos_amostras($objPreparoLote, $objPreparoLoteRN, $select_grupos, ' disabled ', LoteRN::$TL_EXTRACAO);
            InterfacePagina::montar_select_kitsExtracao($objKitExtracao, $objKitExtracaoRN, $select_kitExtracao, ' ');


            $objPreparoLote->setIdPreparoLote($_GET['idPreparoLote']);
            $objPreparoLote = $objPreparoLoteRN->obter_todas_infos($objPreparoLote,'E');

            if($objPreparoLote->getIdResponsavel() != null) {
                $objUsuario->setIdUsuario($objPreparoLote->getIdResponsavel());
                $objUsuario = $objUsuarioRN->consultar($objUsuario);
                $objPreparoLote->setIdResponsavel($objUsuario->getMatricula());
            }


            InterfacePagina::montar_grupos_amostras($objPreparoLote, $objPreparoLoteRN, $select_grupos, ' disabled ', LoteRN::$TL_EXTRACAO);

            /*
                echo "<pre>";
                print_r($objPreparoLote);
                echo "</pre>";
            */

            $arr_JSCopiarLocal = array();
            $arr_JSCopiarCaixa = array();
            $arr_JSCopiarPorta = array();
            $arr_JSCopiarColuna = array();
            $arr_JSCopiarPrateleira = array();
            $primeiro = true;
            $contador = 0;
            $show_amostras = '';

            foreach ($objPreparoLote->getObjLote()->getObjsAmostras() as $amostras) {

                $show = 'show ';
                $style = 'style="margin-top: 10px;';

                $disabled = '  ';

                if (isset($_POST['btn_confirmar_extracao']) || $_GET['action'] == 'editar_extracao') {
                    $disabled = '';
                }

                $strIdTubo = $amostras->getObjTubo()->getIdTubo();

                if($amostras->getObjTubo()->getExtracaoInvalida()){
                    $disabled =  ' disabled ';
                }

                $local = $amostras->getObjTubo()->getObjInfosTubo()->getObjLocal();
                $infotubo = $amostras->getObjTubo()->getObjInfosTubo();

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
                                            AMOSTRA INATIVADA
                                         </div>
                                    </div>
                                    <div class="form-row" >
                                        
                                        <div class="col-md-6">
                                            <label> Volume</label>
                                                <input type="number" class="form-control form-control-sm" id="idVolume"  ' . $disabled . ' style="text-align: center;" placeholder="" ' . $disabled . '
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
                if ( ($primeiro && isset($_POST['btn_confirmar_extracao'])) || $_GET['action'] == 'editar_extracao') {
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
                                            <label class="custom-control-label" for="customDercartada_' . $strIdTubo . '">Precisou ser descartado no meio da extração</label>
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

                if (isset($_POST['btn_editar'])) {

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

                    if(!$amostras->getObjTubo()->getExtracaoInvalida()) {
                        if (is_null($local)) {
                            $local = new LocalArmazenamentoTexto();
                        }

                        $local->setNome($_POST[$strIdLocalArmazenamento]);

                        $local->setColuna($_POST[$strIdColuna]);
                        $local->setPorta($_POST[$strIdPorta]);
                        $local->setPrateleira($_POST[$strIdPrateleira]);
                        $local->setCaixa($_POST[$strIdCaixa]);
                        $local->setPosicao($_POST['txtPosicao_' . $strIdTubo]);

                        $infotubo->setReteste($_POST['txtReteste_' . $strIdTubo]);
                        $infotubo->setVolume($_POST['txtVolume_' . $strIdTubo]);
                        $infotubo->setObjTubo($amostras->getObjTubo());
                        if (isset($_POST['checkDercartada_' . $strIdTubo]) && $_POST['checkDercartada_' . $strIdTubo] == 'on') {
                            $infotubo->setSituacaoTubo(InfosTuboRN::$TST_DESCARTADO_NO_MEIO_ETAPA);
                        }
                        $infotubo->setObjLocal($local);

                        $arr_alteracoes[] = $infotubo;

                        $arr_amostras[] = $amostras;

                        /*echo "<pre>";
                        print_r($arr_alteracoes);
                        echo "</pre>";*/
                    }

                }
            }

            if (isset($_POST['btn_editar'])) {

                if ($_GET['idCapela'] != $_POST['sel_nivelSegsCapela']) {
                    $objCapela->setIdCapela($_GET['idCapela']);
                    $objCapela = $objCapelaRN->consultar($objCapela);
                    $objCapela->setSituacaoCapela(CapelaRN::$TE_LIBERADA);
                    $objCapela = $objCapelaRN->alterar($objCapela);
                }
                $objCapela->setIdCapela($_POST['sel_nivelSegsCapela']);
                $objCapela->setNivelSeguranca(CapelaRN::$TNS_MEDIA_SEGURANCA);
                $objPreparoLote->setObjCapela($objCapela);
                InterfacePagina::montar_capelas_liberadas($objCapela, $objCapelaRN, $select_capelas, CapelaRN::$TNS_MEDIA_SEGURANCA, '  ');

                $objPreparoLote->setIdKitExtracaoFk($_POST['sel_kit_extracao']);
                $objPreparoLote->setObsKitExtracao($_POST['txtObsKit']);
                $objPreparoLote->setLoteFabricacaokitExtracao($_POST['txtLoteFabricacaoKit']);
                $objPreparoLote->setObjsTubos($arr_alteracoes);
                $objLoteAux = $objPreparoLote->getObjLote();
                $objLote->setObjsAmostras($arr_amostras);
                $objPreparoLote->setObjLote($objLote);

                /*if($objPreparoLote->getIdResponsavel() != null) {
                    $objUsuario->setIdUsuario($objPreparoLote->getIdResponsavel());
                    $objUsuario = $objUsuarioRN->consultar($objUsuario);
                    $objPreparoLote->setIdResponsavel($objUsuario->getMatricula());

                }*/



                /*echo "<pre>";
                print_r($objPreparoLote);
                echo "</pre>";*/

                //$objPreparoLoteNovo = $objPreparoLoteRN->alterar($objPreparoLote);*/
                $objPreparoLote = $objPreparoLoteRN->alterar_extracao($objPreparoLote);

                header('Location: '. Sessao::getInstance()->assinar_link('controlador.php?action=editar_extracao&idPreparoLote=' . Pagina::formatar_html($objPreparoLote->getIdPreparoLote()).'&idCapela='.Pagina::formatar_html($objPreparoLote->getIdCapelaFk()).'&idKitExtracao='.Pagina::formatar_html($objPreparoLote->getIdKitExtracaoFk())));
                die();

            }


            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em solicitacaoMontagemPlacaRTqPCR.php');

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
//Pagina::getInstance()->adicionar_javascript("copia_localArmazenamento");
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
Pagina::montar_topo_listar("EXTRAÇÃO",null,null, "listar_preparo_inativacao", 'LISTAR LOTES DE EXTRAÇÃO');
echo $alert;
Pagina::getInstance()->mostrar_excecoes();

echo '<!-- Modal -->
    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="text-align: center">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                    Deseja realizar outra extração? </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"  >Close</button>
                    <button type="button"  class="btn btn-primary">
                    <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=realizar_extracao').'">Tenho certeza</a></button>
                </div>
            </div>
        </div>
    </div>';


if($_GET['action'] == 'realizar_extracao') {


    echo '<div class="conteudo_grande " STYLE="margin-top: 0px;" >
         <form method="POST">
                <div class="form-row" >
                    <div class="col-md-12">
                        <input type="text" class="form-control" id="idDataHoraLogin" hidden style="text-align: center;"
                               name="dtHoraLoginInicio" required value="' . $_SESSION['DATA_LOGIN'] . '">
                     </div>
                     </div>
                      <div class="form-row" >
                    <div class="col-md-8">
                        <label>Informe o nome do responsável: (opcional)</label>
                        <input type="text" class="form-control" '.$disabled_responsavel .' style="text-align: center;"
                               name="txtNomeResponsavel" value="'.$objPreparoLoteORIGINAL->getNomeResponsavel().'">
                     </div>
                      <div class="col-md-4">
                        <label>Informe o código do responsável: (opcional)</label>
                        <input type="text" class="form-control" '.$disabled_responsavel .' style="text-align: center;"
                               name="txtMatricula" value="'.$objPreparoLoteORIGINAL->getIdResponsavel().'">
                     </div>
                </div>
                <div class="form-row" >
                <div class="col-md-12"> 
                    <label>Escolha um dos kits</label>'
        . $select_kitExtracao .
        '</div>
                    </div>
                 <div class="form-row" >
                    <div class="col-md-6">
                        <label for="">Informe o lote de fabricação do kit de extração (opcional)</label>
                        <input type="text" class="form-control"  ' . $disabled_inputs . '
                               name="txtLoteFabricacaoKit"  value="' . Pagina::formatar_html($objPreparoLoteORIGINAL->getLoteFabricacaokitExtracao()) . '">
                     </div>
                     <div class="col-md-6">
                        <label for="">Observações do kit de extração (opcional)</label>
                        <textarea id="idTxtAreaObs" ' . $disabled_inputs . '
                                  name="txtObsKit" rows="1" cols="100" class="form-control"
                                  >' . Pagina::formatar_html($objPreparoLoteORIGINAL->getObsKitExtracao()) . '</textarea>
                     </div>
                </div>
                <div class="form-row" >
                    <div class="col-md-6">
                        <label>Escolha uma capela de média segurança</label>'
        . $select_capelas .
        '</div>
              
                   <div class="col-md-6"> 
                    <label>Escolha um grupo de amostras de extração</label>'
        . $select_grupos .
        '</div>
                    
                </div>';
    if ($sumir_btn_alocar == 'n') {
        echo '<div class="form-row" >
                    <div class="col-md-12" >
                        <button class="btn btn-primary"  type = "submit"style = "width: 25%; margin-left: 35%;" name = "btn_alocarCapela" > ' . $nome_botao_alocar . ' </button >
                    </div >
                 </div >';
    }
    echo '
         </form>
      </div>';

    if (isset($_GET['idCapela']) && isset($_GET['idPreparoLote'])) {
        echo '<div class="conteudo_grande preparo_inativacao">
         <form method="POST">
               
                ';

        if ($sumir_btns == 'n') {
            echo '  <div class="form-row" style="height: 50px;margin-top: -40px;" >';
            if ($ja_confirmou == 'n') {
                echo '<div class="col-md-6">
               <button class="btn btn-primary" STYLE="width: 50%;margin-left: 50%;margin-bottom: 5px;" type="submit" name="btn_confirmar_extracao">INICIAR EXTRAÇÃO</button>
             </div>';
            } else {
                //if($sumir_btns == 'n') {
                echo '<div class="col-md-6">
               <button class="btn btn-primary" STYLE="width: 50%;margin-left: 50%;margin-bottom: 5px;" type="submit" name="btn_terminar_extracao">SALVAR DADOS</button>
             </div>';
                //}
            }

            echo '<div class="col-md-6">
                       <button class="btn btn-primary" STYLE="width: 50%;margin-left: 0%;margin-bottom: 5px;"  type="submit" name="btn_cancelar">CANCELAR</button>
                     </div>
                     </div>';
        }

        echo '
             <div class="form-row" style="margin-top: 0px;">
                   <div class="col-md-12">'
            . $show_amostras .
            '</div>
                </div>
                </form>
      </div>';
    }
}

if($_GET['action'] == 'editar_extracao'){
    echo '<div class="conteudo_grande " STYLE="margin-top: 0px;" >
         <form method="POST">
                <div class="form-row" >
                    <div class="col-md-12">
                        <input type="text" class="form-control" id="idDataHoraLogin" hidden style="text-align: center;"
                               name="dtHoraLoginInicio" required value="' . $_SESSION['DATA_LOGIN'] . '">
                     </div>
                     </div>
                     <div class="form-row" >
                    <div class="col-md-8">
                        <label>Informe o nome do responsável: (opcional)</label>
                        <input type="text" class="form-control" '.$disabled_responsavel .' style="text-align: center;"
                               name="txtNomeResponsavel" value="'.$objPreparoLote->getNomeResponsavel().'">
                     </div>
                      <div class="col-md-4">
                        <label>Informe o código do responsável: (opcional)</label>
                        <input type="text" class="form-control" '.$disabled_responsavel .' style="text-align: center;"
                               name="txtMatricula" value="'.$objPreparoLote->getIdResponsavel().'">
                     </div>
                </div>
                <div class="form-row" >
                    <div class="col-md-12"> 
                        <label>Escolha um dos kits</label>'
        . $select_kitExtracao .
        '
                    </div>
                </div>
                <div class="form-row" >
                    <div class="col-md-6">
                        <label for="">Informe o lote de fabricação do kit de extração (opcional)</label>
                        <input type="text" class="form-control"  ' . $disabled_inputs . '
                               name="txtLoteFabricacaoKit"  value="' . Pagina::formatar_html($objPreparoLote->getLoteFabricacaokitExtracao()) . '">
                     </div>
                     <div class="col-md-6">
                        <label for="">Observações do kit de extração (opcional)</label>
                        <textarea id="idTxtAreaObs" ' . $disabled_inputs . '
                                  name="txtObsKit" rows="1" cols="100" class="form-control"
                                  >' . Pagina::formatar_html($objPreparoLote->getObsKitExtracao()) . '</textarea>
                     </div>
                </div>
                <div class="form-row" >
                    <div class="col-md-6">
                        <label>Escolha uma capela de média segurança</label>'
        . $select_capelas .
        '</div>
           
                   <div class="col-md-6"> 
                        <label>Escolha um grupo de amostras de extração</label>'
        . $select_grupos .
        '</div>    
                </div>';

    echo '
             <div class="form-row" style="margin-top: 0px;">
                 <div class="col-md-12">
                    <small style="color: red;"> Amostras desativadas são amostras que já seguiram a diante no processo. Logo, seus locais não são editáveis nessa etapa.</small>
                </div>
                <div class="col-md-12">'
        . $show_amostras .
        '</div>
            </div>';

    echo '<div class="form-row" >
                    <div class="col-md-12" >
                        <button class="btn btn-primary"  type = "submit" style = "width: 25%; margin-left: 35%;" name="btn_editar" > EDITAR LOTE EXTRAÇÃO </button >
                    </div >
                 </div >';
    echo '
         </form>
      </div>';
}

Pagina::getInstance()->fechar_corpo();