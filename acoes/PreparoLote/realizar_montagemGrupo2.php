<?php

session_start();
try {
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once __DIR__ . '/../../classes/Capela/Capela.php';
    require_once __DIR__ . '/../../classes/Capela/CapelaRN.php';
    require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';

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
    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPacienteINT.php';

    require_once __DIR__ . '/../../classes/MontagemGrupo/MontagemGrupo.php';
    require_once __DIR__ . '/../../classes/MontagemGrupo/MontagemGrupoRN.php';

    require_once __DIR__ . '/../../classes/Log/Log.php';
    require_once __DIR__ . '/../../classes/Log/LogRN.php';

    require_once __DIR__ . '/../../classes/KitExtracao/KitExtracao.php';
    require_once __DIR__ . '/../../classes/KitExtracao/KitExtracaoRN.php';

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


    $arr_infosTubo = array();
    $arr_tubos = array();
    $arr_amostras_resultado = array();
    $arr_amostras_selecionadas = array();
    $perfis_nome = array();
    $alert = '';
    $perfisSelecionados = '';
    $amostrasSelecionadas = '';
    $select_amostras= '';
    $capela_liberada = 'n';
    $liberar_prioridade = 'n';
    $liberar_popUp = 'n';
    $erro_qntAmostras = 'n';
    $select_perfis = '';
    $button_selecionar = 's';
    $cadastrar_novo = 'n';
    $btn_imprimir = 'n';
    $sumir_btn_enviar_perfil_manual = 'n';

    $qntSelecionada = 0;
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $objPerfilPaciente = new PerfilPaciente();


    $sumir_btn_enviar_amostras_manual = 'n';
    $objMontagemGrupo = new MontagemGrupo();
    $objMontagemGrupoRN = new MontagemGrupoRN();


    $arr_posts = array();

    if(isset($_GET['idTipoMontagem']) && $_GET['idTipoMontagem'] == 2) {
        $alert .= Alert::alert_info("As amostras serão ordenadas pelo seu código");
    }


    $sumir_btn_cancelar = 'n';

    InterfacePagina::montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, '', '', null);

    $msgPopUp ='';
    $sumir_btn_confirmar = 'n';
    $sumir_btn_confirmar_novamente = 's';

    if(isset($_POST['btn_cancelar']) ){
        $objPreparoLote->setIdPreparoLote($_GET['idPreparoLote']);
        //$objPreparoLote = $objPreparoLoteRN->preparoLote_completo($objPreparoLote,null,true,true,true);
        $_SESSION['COVID19']['INFOSTUBO'] = true;
        $objPreparoLote = $objPreparoLoteRN->preparoLote_completo($objPreparoLote);
        $_SESSION['COVID19']['INFOSTUBO'] = false;


        echo "<pre>";
        print_r($objPreparoLote);
        echo "</pre>";

        die();
        $objPreparoLote = $objPreparoLoteRN->remover_completamente2($objPreparoLote);
        //header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=montar_preparo_extracao'));
        die();
    }

    if(!isset($_GET['idPreparoLote'])) {
        switch ($_GET['idTipoMontagem']) {
            case 1: //manual
                //PerfilPacienteINT::montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, null,null, null);
                try {
                    if ($_POST['btn_enviar_perfil_manual'] || isset($_POST['btn_enviar_amostras'])) {

                        $paciente_sus = 'n';
                        $perfil = array();
                        for ($i = 0; $i < count($_POST['sel_perfis']); $i++) {
                            $perfisSelecionados .= $_POST['sel_perfis'][$i] . ';';
                            $objPerfilPacienteAux = new PerfilPaciente();
                            $objPerfilPacienteAux->setIdPerfilPaciente($_POST['sel_perfis'][$i]);
                            $perfil[$i] = $objPerfilPacienteRN->consultar($objPerfilPacienteAux);
                            if ($perfil[$i]->getCaractere() == PerfilPacienteRN::$TP_PACIENTES_SUS) {
                                $paciente_sus = 's';
                            }
                        }

                        PerfilPacienteINT::montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, '', '');


                        $qntSelecionada = $_POST['numQntAmostras'];
                        $lista = '';
                        for ($i = 0; $i < $qntSelecionada; $i++) {
                            $lista .= ' <div class="form-row" >
                                    <div class="col-md-1" >
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">' . ($i + 1) . ' ª amostra </div>
                                    </div>
                                    </div>
                                    
                                    <div class="col-md-10" >
                                        <input type="text" class="form-control" id="idQntAmostras" placeholder="código amostra"
                                            name="txtCod_' . $i . '" style="margin-left:10px;width:102%;" value="' . Pagina::formatar_html(strtoupper($utils->tirarAcentos($_POST['txtCod_' . $i]))) . '">
                                    </div>
                                </div>';

                            if (isset($_POST['txtCod_' . $i])){
                                $arr_posts[] .= strtoupper($utils->tirarAcentos($_POST['txtCod_' . $i]));
                            }
                        }

                        if(count($arr_posts) > 0){
                            $arr_posts_unique = array_unique($arr_posts);

                            if(count($arr_posts_unique) < count($arr_posts) && count($arr_posts) > 0){
                                $alert.= Alert::alert_warning("Alguma amostra foi informada mais de uma vez");
                            }else{
                                if (isset($_POST['btn_enviar_amostras'])) {
                                    $amostras_selecionadas = $objAmostraRN->validar_amostras($arr_posts, $perfil);

                                    $tubos = array();
                                    foreach ($amostras_selecionadas as $amostra) {
                                        $tubo = $amostra->getObjTubo();
                                        $objInfosTubo = new InfosTubo();
                                        $objInfosTuboRN = new InfosTuboRN();

                                        $objTubo = $amostra->getObjTubo();
                                        $objInfosTuboUltimo = $amostra->getObjTubo()->getObjInfosTubo();

                                        $objInfosTuboUltimo->setIdTubo_fk($amostra->getObjTubo()->getIdTubo());
                                        $objInfosTuboUltimo->setIdInfosTubo(null);
                                        $objInfosTuboUltimo->setObservacoes(null);
                                        $objInfosTuboUltimo->setObsProblema(null);
                                        $objInfosTuboUltimo->setSituacaoTubo(InfosTuboRN::$TST_EM_UTILIZACAO);
                                        $objInfosTuboUltimo->setSituacaoEtapa(InfosTuboRN::$TSP_EM_ANDAMENTO);
                                        $objTubo->setObjInfosTubo($objInfosTuboUltimo);
                                        $tubos[] = $objTubo;
                                    }
                                }
                            }
                        }

                    }
                } catch (Throwable $e) {
                    Pagina::getInstance()->processar_excecao($e);
                }


                $codigo .= '<div class="conteudo_grande" style="margin-top: -10px;">
                          <form method="POST">
                                <div class="form-row" >
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="idDataHoraLogin" hidden style="text-align: center;"
                                               name="dtHoraLoginInicio" required value="' . $_SESSION['DATA_LOGIN'] . '">
                                    </div>
                                </div>
                                <div class="form-row" >';

                $codigo .= '         <div class="col-md-8">
                                         <label for="label_perfisAmostras">Selecione um perfil de amostra</label>
                                                ' . $select_perfis . '
                                     </div>';

                $codigo .= '        <div class="col-md-2">     
                                <label for="label_perfisAmostras">Amostras</label>
                                    <input type="number" ' . $readonly . ' class="form-control" id="idQntAmostras" placeholder="quantidade"
                                        name="numQntAmostras"  value="' . $_POST['numQntAmostras'] . '">
                                    </div>';


                $codigo .= '       <div class="col-md-2" >
                                        <input class="btn btn-primary" style="margin-left:10px;margin-top:31px;width: 100%;" type="submit"  name="btn_enviar_perfil_manual" value="ALTERAR" />
                                </div>';
                $codigo .= '        </div>';

                if ($_POST['btn_enviar_perfil_manual'] || isset($_POST['btn_enviar_amostras'])) {
                    $codigo .= $lista;

                    $codigo .= '<div class="form-row" >
                                <div class="col-md-12" >
                                        <input class="btn btn-primary" style="margin-left:30%;margin-top:31px;width: 40%;" type="submit"  name="btn_enviar_amostras" value="SELECIONAR AMOSTRAS" />
                                </div>
                              </div>';
                }


                $codigo .= '    </form>
                        </div>
                        ';

                break;
            case 2: //automático

                if (isset($_POST['enviar_perfil'])) { //se enviou o perfil e a prioridade

                    if (!isset($_POST['sel_perfis']) && $_POST['sel_perfis'] == null && !isset($_POST['numQntAmostras']) && $_POST['numQntAmostras'] == 0) { //não enviou nenhum dos dois
                        $alert .= Alert::alert_danger("Informe o perfil e a quantidade de amostras");
                    } else {
                        if (isset($_POST['numQntAmostras'])) {
                            $qntSelecionada = $_POST['numQntAmostras'];

                            if ($_POST['numQntAmostras'] == 0) {
                                $alert .= Alert::alert_danger("Informe a quantidade de amostras");
                                $erro_qntAmostras = 's';
                            } else {
                                $erro_qntAmostras = 'n';
                                $qntSelecionada = $_POST['numQntAmostras'];
                                $objLote->setQntAmostrasDesejadas($_POST['numQntAmostras']);
                            }
                        }

                        if (!isset($_POST['sel_perfis']) && $_POST['sel_perfis'] == null) {
                            $alert .= Alert::alert_danger("Informe o perfil da amostra");
                        } else if (isset($_POST['sel_perfis']) && $_POST['sel_perfis'] != null) {
                            $paciente_sus = 'n';
                            $perfil = array();
                            for ($i = 0; $i < count($_POST['sel_perfis']); $i++) {
                                $perfisSelecionados .= $_POST['sel_perfis'][$i] . ';';
                                $arr_idsPerfis[] = $_POST['sel_perfis'][$i];
                                $objPerfilPacienteAux = new PerfilPaciente();
                                $objPerfilPacienteAux->setIdPerfilPaciente($_POST['sel_perfis'][$i]);
                                $perfil[$i] = $objPerfilPacienteRN->consultar($objPerfilPacienteAux);
                                if ($perfil[$i]->getCaractere() == PerfilPacienteRN::$TP_PACIENTES_SUS) {
                                    $paciente_sus = 's';
                                }
                            }

                            InterfacePagina::montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, '', '');

                            if (count($perfil) > 1 && $paciente_sus == 's') {
                                $alert .= Alert::alert_danger("Você selecionou o perfil PACIENTES SUS e este perfil deve ser tratado sozinho");
                            } else if ($erro_qntAmostras == 'n') {
                                //chegou até aqui então está tudo certo

                                if (isset($_GET['idTipoMontagem']) && $_GET['idTipoMontagem'] == 2) {
                                    $objMontagemGrupo->setArrIdsPerfis($arr_idsPerfis);
                                    $objMontagemGrupo->setQntAmostras($qntSelecionada);
                                    $arr_grupo = $objMontagemGrupoRN->listar_completo($objMontagemGrupo);

                                    /*
                                    echo "<pre>";
                                    print_r($arr_grupo);
                                    echo "</pre>";
                                    die();
                                    */

                                    $tubos = array();
                                    foreach ($arr_grupo as $grupo) {
                                        $objInfosTubo = new InfosTubo();
                                        $objInfosTuboRN = new InfosTuboRN();
                                        $objTubo = new Tubo();
                                        $objInfosTubo->setIdTubo_fk($grupo->getAmostra()->getObjTubo()->getIdTubo());
                                        $objTubo->setIdTubo($grupo->getAmostra()->getObjTubo()->getIdTubo());
                                        $objInfosTuboUltimo = $objInfosTuboRN->pegar_ultimo($objInfosTubo);

                                        $objInfosTuboUltimo->setIdInfosTubo(null);
                                        $objInfosTuboUltimo->setObservacoes(null);
                                        $objInfosTuboUltimo->setObsProblema(null);
                                        $objInfosTuboUltimo->setSituacaoTubo(InfosTuboRN::$TST_EM_UTILIZACAO);
                                        $objInfosTuboUltimo->setSituacaoEtapa(InfosTuboRN::$TSP_EM_ANDAMENTO);
                                        $objTubo->setObjInfosTubo($objInfosTuboUltimo);
                                        $tubos[] = $objTubo;

                                    }

                                }
                            }
                        }
                    }
                }
                break;
            default:
                break;
        }
    }



    if (count($tubos) > 0 && !isset($_GET['idPreparoLote'])) {


        $objLote->setTipo(LoteRN::$TL_PREPARO);
        $objLote->setObjsTubo($tubos);
        $objLote->setSituacaoLote(LoteRN::$TE_NA_MONTAGEM);
        $objLote->setQntAmostrasDesejadas($qntSelecionada);
        $objLote->setQntAmostrasAdquiridas(count($tubos));

        $objPreparoLote->setObjLote($objLote);

        $objPreparoLote->setIdUsuarioFk(Sessao::getInstance()->getIdUsuario());
        $objPreparoLote->setDataHoraFim(date("Y-m-d H:i:s"));
        $objPreparoLote->setDataHoraInicio($_POST['dtHoraLoginInicio']);
        $objPreparoLote->setObjPerfil($perfil);

        $objRel_Perfil_preparoLote->setObjPreparoLote($objPreparoLote);
        $objRel_Perfil_preparoLote->setObjPerfilPaciente($perfil);


        $objRel_Perfil_preparoLote = $objRel_Perfil_preparoLoteRN->cadastrar($objRel_Perfil_preparoLote);

        header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=montar_preparo_extracao&idPreparoLote=' . $objRel_Perfil_preparoLote->getObjPreparoLote()->getIdPreparoLote()));
        die();
    } else {
        if(isset($_GET['idTipoMontagem']) && $_GET['idTipoMontagem'] == 2 && isset($_POST['enviar_perfil'])) {  $alert = Alert::alert_warning("Nenhuma amostra foi encontrada com esse(s) perfil(s)"); }
    }



    //depois que salvou o preparo do lote
    if(isset($_GET['idPreparoLote'])) {
        $alert .= Alert::alert_success("Cadastro parcial realizado");
        $objPreparoLote->setIdPreparoLote($_GET['idPreparoLote']);
        $objPreparoLote = $objPreparoLoteRN->consultar($objPreparoLote);

        $todas_infos = $objPreparoLoteRN->obter_todas_infos($objPreparoLote,null);




        /*    echo "<pre>";
            print_r($todas_infos);
            echo "</pre>";
        die();
        */

        $qntSelecionada = $todas_infos->getObjLote()->getQntAmostrasDesejadas();
        $quantidade = count($todas_infos->getObjLote()->getObjsAmostras());

        foreach ($todas_infos->getObjPerfil() as $perfil) {
            //echo $perfil->getIdPerfilPaciente();
            $perfisSelecionados .= $perfil->getIdPerfilPaciente() . ';';
        }
        $button_selecionar = 'n';
        InterfacePagina::montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, ' readonly ', '');


        if ($quantidade >= $todas_infos->getObjLote()->getQntAmostrasDesejadas()) {
            $alert = Alert::alert_success("Foi encontrada uma quantidade de amostras maior/igual ao desejado");
            $quantidade = $todas_infos->getObjLote()->getQntAmostrasDesejadas();
        } else {
            $quantidade = count($todas_infos->getObjLote()->getObjsAmostras());
            $alert = Alert::alert_warning("Foram encontradas ". $quantidade." amostras, uma quantidade menor que o desejado");
        }

        if(!isset($_POST['btn_confirmar'])) {
            $html = '<div class="form-row" >
                            <div class="input-group col-md-12 " >
                                <h5>Quantidade de amostras encontradas: ' . $quantidade . '</h5>
                            </div>
                         </div>';
        }

        $hidden = '';
        $VALORES = '';
        $show = false;

        foreach ($todas_infos->getObjLote()->getObjsAmostras() as $amostra) { //todos os tubos originais
            $objTubo = $amostra->getObjTubo();
            //print_r($grupo);
            $checked = '';
            $disabled = '';
            $hidden = '';

            if(isset($_POST['btn_confirmar'])) {
                echo ' ';

                $sumir_btn_confirmar = 's';
                $sumir_btn_confirmar_novamente = 'n';

                if ($_POST['checkbox_' . $amostra->getIdAmostra()] == 'on') {
                    echo ' ';
                    $arr_amostras[] = $amostra;
                    $arr_tubos[] = $amostra->getObjTubo();
                    $idAMOSTRAS .= $amostra->getIdAmostra().',';
                    $checked = ' checked ';
                    $show = true;

                }else{
                    $show = false;

                }
            }

            if (!isset($_POST['btn_confirmar'])) {
                $checked = ' checked ';
                $show = true;
            }

            //print_r($grupo);
            if ($show) {
                $data = explode("-", $amostra->getDataColeta());

                $dia = $data[2];
                $mes = $data[1];
                $ano = $data[0];

                $html .= '
                        <div class="form-row"  >
                                                            
                        <div class="input-group col-md-12 " >
                              <div class="input-group-prepend">                          
                                <div class="input-group-text" >
                                <input type="text" disabled  hidden class="form-control" value="'.$idAMOSTRAS.'">
                                  <input type="checkbox" ' . $checked . '  name="checkbox_' . $amostra->getIdAmostra() . '" 
                                  style="width: 50px;" aria-label="Checkbox for following text input">
                                </div>
                              </div>
                              <input type="text" disabled  class="form-control" value="Amostra ' . TuboRN::mostrarDescricaoTipoTubo($amostra->getObjTubo()->getTipo()) . ' ' . $amostra->getNickname() . ' - Data coleta: ' . $dia . '/' . $mes . '/' . $ano .'">
                        </div>
                        </div>';
            }



        }
        //die("10");

        if (isset($_POST['btn_confirmar'])) {

            $html = '<div class="form-row" >
                            <div class="input-group col-md-12 " >
                                <h5>Quantidade de amostras selecionadas: ' . count($arr_amostras) . '</h5>
                            </div>
                         </div>';
            //print_r($arr_checks);
            $arr_infos = array();

            /*
            echo "<pre>";
            print_r($arr_amostras);
            echo "</pre>";
            */

            for($i=0; $i<count($arr_amostras); $i++){

                //print_r($arr_amostras[$i]);
                $objTubo = new Tubo();
                $objTubo->setIdTubo($arr_amostras[$i]->getObjTubo()->getIdTubo());

                $objInfosTubo = new InfosTubo();
                $objInfosTubo->setIdTubo_fk($arr_amostras[$i]->getObjTubo()->getIdTubo());
                $objInfosTubo = $objInfosTuboRN->pegar_ultimo($objInfosTubo);
                $objInfosTubo->setIdInfosTubo(null);
                $objInfosTubo->setIdTubo_fk($arr_amostras[$i]->getObjTubo()->getIdTubo());
                $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                $objInfosTubo->setEtapa(InfosTuboRN::$TP_MONTAGEM_GRUPOS_AMOSTRAS);
                $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_TRANSPORTE_PREPARACAO);
                $objInfosTubo->setIdLote_fk($todas_infos->getObjLote()->getIdLote());
                $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                $arr_infos[0] = $objInfosTubo;

                $objInfosTuboAux = new InfosTubo();
                $objInfosTuboAux->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                $objInfosTuboAux->setIdLote_fk($todas_infos->getObjLote()->getIdLote());
                $objInfosTuboAux->setIdTubo_fk($arr_amostras[$i]->getObjTubo()->getIdTubo());
                $objInfosTuboAux->setEtapaAnterior(InfosTuboRN::$TP_MONTAGEM_GRUPOS_AMOSTRAS);
                $objInfosTuboAux->setEtapa(InfosTuboRN::$TP_PREPARACAO_INATIVACAO);
                $objInfosTuboAux->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                $objInfosTuboAux->setSituacaoTubo(InfosTuboRN::$TST_TRANSPORTE_PREPARACAO);
                $objInfosTuboAux->setDataHora(date("Y-m-d H:i:s"));
                $arr_infos[1] = $objInfosTuboAux;
                $objTubo->setObjInfosTubo($arr_infos);
                $tubos[$i] = $objTubo;
                $html .= '<input type="text" disabled style="margin-top:5px;"  class="form-control" value="'.TuboRN::mostrarDescricaoTipoTubo($arr_amostras[$i]->getObjTubo()->getTipo()).' '. $arr_amostras[$i]->getNickname() . ' ---  Data coleta: ' . $arr_amostras[$i]->getDataColeta() .'">';

            }


            if(count($tubos) > 0) {


                $objLote = $todas_infos->getObjLote();
                $objLote->setIdLote($objPreparoLote->getIdLoteFk());
                $objLote->setObjsTubo($tubos);
                $objLote->setObjsAmostras($arr_amostras);
                $objLote->setSituacaoLote(LoteRN::$TE_TRANSPORTE_PREPARACAO);
                $objLote->setQntAmostrasAdquiridas(count($tubos));

                $objPreparoLote->setObjLote($objLote);

                $objPreparoLote->setIdUsuarioFk(Sessao::getInstance()->getIdUsuario());
                $objPreparoLote->setDataHoraFim(date("Y-m-d H:i:s"));
                $objPreparoLote->setObjPerfil($todas_infos->getObjPerfil());

                /*
                    echo "<pre>";
                    print_r($objPreparoLote);
                    echo "</pre>";
                */



                $objPreparoLoteRN = new PreparoLoteRN();
                $objPreparoLote = $objPreparoLoteRN->alterar($objPreparoLote);

                //die();
                $btn_imprimir = 's';
                $sumir_btn_confirmar = 's';
                $sumir_btn_cancelar = 'n';

                $cadastrar_novo = 's';
                $button_selecionar == 'n';

                $alert = Alert::alert_success("Os dados foram cadastrado com sucesso");

                //header('Location: '. Sessao::getInstance()->assinar_link('controlador.php?action=montar_preparo_extracao&idPreparoLote='.$objPreparoLote->getIdPreparoLote()));
                //die();
            }
        }

    }


} catch (Throwable $ex) {
    //die($ex);
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Montar grupo");
Pagina::getInstance()->adicionar_css("precadastros");
if($cadastrar_novo  == 's') {
    Pagina::getInstance()->adicionar_javascript("popUp");
}
Pagina::getInstance()->adicionar_javascript("tabelaDinamica");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar("CRIAR GRUPO DE AMOSTRAS",null,null, "listar_preparo_lote", 'LISTAR GRUPOS');
Pagina::getInstance()->mostrar_excecoes();
echo $alert;

if(!isset($_GET['idTipoMontagem']) && !isset($_GET['idPreparoLote'])){
    echo '
        <div class="conteudo_grande" style="margin-top: -20px;">
            <form method="POST" name="inicio">
            <div class="form-row" >
            
                <div class="col-md-12">
                    <input type="text" class="form-control" id="idDataHoraLogin" hidden style="text-align: center;"
                           name="dtHoraLoginInicio" required value="' . $_SESSION['DATA_LOGIN'] . '">
                </div>
            </div>
             <div class="form-row" >
                  <div class="col-md-6" >
                        <a  class="btn btn-primary" STYLE="margin-left:0px;width:100%;margin-top: 17px;font-size: 20px;" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=montar_preparo_extracao&idTipoMontagem=1').'"><i style="color:white;" class="fas fa-cogs fa-3x"></i><br>ESCOLHA MANUAL</a>
                        <!--<button class="btn btn-primary" style="margin-left:0px;margin-top: 31px;width: 100%;" type="submit"  name="btn_manual">ESCOLHA MANUAL</button>-->
                  </div>
                   <div class="col-md-6" >
                        <a  class="btn btn-primary" STYLE="margin-left:0px;width:100%;margin-top: 17px;font-size: 20px;" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=montar_preparo_extracao&idTipoMontagem=2').'"><i  style="color:white;" class="fas fa-laptop-code fa-3x"></i><br>ESCOLHA AUTOMÁTICA</a>
                        <!--<button class="btn btn-primary" style="margin-left:0px;margin-top: 31px;width: 100%;" type="submit"  name="btn_automatico">ESCOLHA AUTOMÁTICA</button>-->
                  </div>
             </div>
             </form>
        </div>
                    ';
}

echo $codigo;


if( (isset($_GET['idTipoMontagem']) && $_GET['idTipoMontagem'] == 2) || isset($_GET['idPreparoLote'])) {

    echo '
        <div class="conteudo_grande" style="margin-top: -10px;">
            <form method="POST" name="inicio">
            <div class="form-row" >

                <div class="col-md-12">
                    <input type="text" class="form-control" id="idDataHoraLogin" hidden style="text-align: center;"
                           name="dtHoraLoginInicio" required value="' . $_SESSION['DATA_LOGIN'] . '">
                </div>
            </div>
             <div class="form-row" >';

    if ($button_selecionar == 'n') {
        $col_md = 'col-md-10';
        $readonly = ' readonly="true" ';

    } else if (isset($_GET['idTipoMontagem']) && $_GET['idTipoMontagem'] == 1) {
        $col_md = 'col-md-8';
        if($sumir_btn_enviar_perfil_manual == 's') $col_md = 'col-md-10';
    } else {
        $col_md = 'col-md-8';
        $readonly = '';
    }

    echo '<div class="' . $col_md . '">
             <label for="label_perfisAmostras">Selecione um perfil de amostra</label>'
        . $select_perfis .
        '</div>
          ';
    echo '<div class="col-md-2">
            <label for="label_perfisAmostras">Amostras</label>
            <input type="number" ' . $readonly . ' class="form-control" id="idQntAmostras" placeholder="quantidade"
                name="numQntAmostras"  value="' . $qntSelecionada . '">
            </div>
            ';

    if (isset($_GET['idTipoMontagem']) && $_GET['idTipoMontagem'] == 1) {
        if($sumir_btn_enviar_perfil_manual == 'n') {
            echo '
                 <div class="col-md-2" >
                     <button class="btn btn-primary" style="margin-left:10px;margin-top: 31px;width: 100%;" type="submit"  name="enviar_perfil_manual">SELECIONAR</button>
                 </div>
              </div>';
        }else{
            echo '</div>';
        }

        if($sumir_btn_enviar_perfil_manual == 's'){

            //echo $html_inputs;


            if($sumir_btn_enviar_amostras_manual == 'n') {
                echo '
             <div class="col-md-12" >
                 <button class="btn btn-primary" style="margin-left:0px;margin-top: 31px;width: 100%;"
                 type="submit"  name="enviar_amostras_manual">SELECIONAR</button>
             </div>';
            }
            // echo '</div>';
        }
    } else {

        if ($button_selecionar == 's') {
            echo '<div class="col-md-2" >
                        <button class="btn btn-primary" style="margin-left:0px;margin-top: 31px;width: 100%;" type="submit"  name="enviar_perfil">SELECIONAR</button>
                      </div>
                    ';
        }
    }
    echo ' </div> ';

    if ($button_selecionar == 'n') {
        if ($sumir_btn_confirmar == 'n') {
            echo '  <div class="form-row" >';
            echo '    <div class="col-md-6" style="margin-top: -10px;" >
                        <button class="btn btn-primary" style="margin-left:0px;margin-top: 20px;width: 100%;"
                        type="submit" name="btn_confirmar" >SELECIONAR AMOSTRAS</button>
                        </div>';
            echo '<div class="col-md-6"  style="margin-top: -10px;">
                    <button type="submit" style="width:100%; margin-top: 20px;margin-left:0%;color:white;text-decoration: none;" class="btn btn-primary"   name="btn_cancelar" > Cancelar</button>
                  </div>';
            echo '</div>';
        }

        echo '  <div class="form-row" >
                   <div class="col-md-12">
                    ' . $html . '
                    </div>
                  </div>';

    }

    echo '
            </form>';
}


echo '<!-- Modal -->
    <div class="modal fade" id="exampleModalCenter3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="text-align: center">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                    Tem certeza que dejesa deseja cancelar? </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                Ao cancelar, nenhum dado será salvo
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"  >Close</button>
                    <button type="button"  class="btn btn-primary">
                    <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_solicitacao_montagem_placa_RTqPCR') . '">Tenho certeza</a></button>
                </div>
            </div>
        </div>
    </div>';

Pagina::getInstance()->fechar_corpo();