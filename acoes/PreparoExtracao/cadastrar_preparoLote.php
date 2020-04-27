<?php

session_start();
require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
require_once __DIR__ . '/../../classes/Capela/Capela.php';
require_once __DIR__ . '/../../classes/Capela/CapelaRN.php';
require_once _DIR__ . '/../../classes/Pagina/Interf.php';

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

try {
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
    $capela_liberada = 'n';
    $liberar_prioridade = 'n';
    $liberar_popUp = 'n';
    $erro_qntAmostras = 'n';
    $select_perfis = '';
    $button_selecionar = 's';
    $cadastrar_novo = 'n';

    $qntSelecionada = 0;
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $objPerfilPaciente = new PerfilPaciente();
    $arrPerfis = $objPerfilPacienteRN->listar($objPerfilPaciente);


    if (isset($_POST['unlock_capela']) || isset($_GET['idLiberar'])) {
        if(isset($_GET['idLiberar'])){ $objCapela->setIdCapela($_GET['idLiberar']);
        }else{  $objCapela->setIdCapela($_GET['idCapela']); }

        $objCapela = $objCapelaRN->consultar($objCapela);
        $objCapela->setStatusCapela('LIBERADA');
        $objCapelaRN->alterar($objCapela);
        $alert = Alert::alert_success("A capela foi liberada");
    }


    if (isset($_POST['lock_capela'])) {

        //$arr = $objCapelaRN->listar($objCapela);
        $objCapela->setNivelSeguranca("NB1");
        $arr_capelas_livres = $objCapelaRN->bloquear_registro($objCapela);

        if (empty($arr_capelas_livres)) {
            $capela_liberada = 'n';
            $alert = Alert::alert_error_semCapelaDisponivel();
        } else {
            header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=montar_preparo_extracao&idCapela=' . $arr_capelas_livres[0]->getIdCapela()));
            die();
        }
    }

    /*
     * SÓ CHEGA AQUI QUANDO UMA CAPELA ESTÁ LIVRE
     */
    $btn = '';
    if (isset($_GET['idCapela']) && $_GET['idCapela'] != null) {
        $capela_liberada = 's';
        $alert .= Alert::alert_success("Há capelas disponíveis");
        $alert .= Alert::alert_primary("Você alocou uma capela");

        Interf::getInstance()->montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, '', '');
        $msgPopUp ='';
        $sumir_btn_confirmar = 'n';
        if (isset($_POST['enviar_perfil']) || isset($_POST['btn_confirmar'])|| isset($_POST['btn_confirmar_localizacao']) ) { //se enviou o perfil e a prioridade
            $_SESSION['DATA_SAIDA'] = date("Y-m-d H:i:s");

            if(isset($_POST['enviar_perfil'])){
                $btn = 'selecionar';
                $sumir_btn_confirmar = 'n';
            }
            if(isset($_POST['btn_confirmar'])){
                $btn = 'confirmar';
                //$sumir_btn_confirmar = 's';
            }
            if(isset($_POST['btn_confirmar_localizacao'])){
                $btn = 'confirmar_localizacao';
            }


            if(!isset($_POST['sel_perfis']) && $_POST['sel_perfis'] == null && !isset($_POST['numQntAmostras']) && $_POST['numQntAmostras'] == 0) { //não enviou nenhum dos dois
                $alert.= Alert::alert_danger("Informe o perfil e a quantidade de amostras");
            }else {
                if(isset($_POST['numQntAmostras'])){
                    $qntSelecionada = $_POST['numQntAmostras'];

                    if($_POST['numQntAmostras'] == 0){
                        $alert .= Alert::alert_danger("Informe a quantidade de amostras");
                        $erro_qntAmostras = 's';
                    }else if($_POST['numQntAmostras'] != 0) {
                        if (fmod($_POST['numQntAmostras'], 8) != 0) {
                            $erro_qntAmostras = 's';
                            $alert .= Alert::alert_danger("Informe a quantidade de amostras sendo um múltiplo de 8 ");
                        } else {
                            $erro_qntAmostras = 'n';
                        }
                        $qntSelecionada = $_POST['numQntAmostras'];
                        $objLote->setQntAmostrasDesejadas($_POST['numQntAmostras']);
                    }
                }

                if(!isset($_POST['sel_perfis']) && $_POST['sel_perfis'] == null){
                    $alert .= Alert::alert_danger("Informe o perfil da amostra");
                }
                else if(isset($_POST['sel_perfis']) && $_POST['sel_perfis'] != null) {
                    $paciente_sus = 'n';
                    for ($i = 0; $i < count($_POST['sel_perfis']); $i++) {
                        $perfisSelecionados .= $_POST['sel_perfis'][$i] . ';';
                        $objPerfilPacienteAux = new PerfilPaciente();
                        $objPerfilPacienteAux->setIdPerfilPaciente($_POST['sel_perfis'][$i]);
                        $perfil[$i] = $objPerfilPacienteRN->consultar($objPerfilPacienteAux);
                        if ($perfil[$i]->getIndex_perfil() == 'PACIENTES SUS') {
                            $paciente_sus = 's';
                        }
                    }

                    Interf::getInstance()->montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, '', '');

                    if (count($perfil) > 1 && $paciente_sus == 's') {
                        $alert .= Alert::alert_danger("Você selecionou o perfil PACIENTES SUS e este perfil deve ser tratado sozinho");
                    } else if ($erro_qntAmostras == 'n') {
                        $button_selecionar = 'n';

                        $arr_amostras = $objAmostraRN->filtro_menor_data($objAmostra, $perfil);
                        //print_r($arr_amostras);

                        foreach ($arr_amostras as $amostras) { //todos os tubos originais
                            $objTubo->setIdAmostra_fk($amostras->getIdAmostra());
                            $arr_tubos[] = $objTuboRN->listar($objTubo);
                        }
                        //print_r($arr_tubos);

                        foreach ($arr_tubos as $tubos) {
                            foreach ($tubos as $t) {
                                if ($t->getTuboOriginal = 's') {
                                    $arr_tubos_result[] = $t;
                                }

                            }
                        }

                        //print_r($arr_tubos_result);

                        $objInfosTubo->setEtapa('final preparação parte 1');
                        $objInfosTubo->setStatusTubo('banco de amostras');
                        $objInfosTubo->setIdInfosTubo("10");
                        $objInfosTubo->setIdTubo_fk("29");
                        $arr_infosTubo_status[] = $objInfosTuboRN->listar($objInfosTubo);
                        //print_r($arr_infosTubo_status);

                        //die("!1");
                        $arr_infosTubo_result = array();
                        /*if(count($arr_infosTubo_status) > 0) {
                            foreach ($arr_infosTubo_status as $infostubos) {
                                $objTubo->setIdTubo($infostubos->getIdTubo_fk());
                                //print_r($objTuboRN->consultar($objTubo));
                                $arr_infosTubo_result[] = $objTuboRN->consultar($objTubo);
                            }
                        }*/
                        //echo "infos result";
                        //print_r($arr_infosTubo_result);
                        $arr_result = array_merge($arr_tubos_result, $arr_infosTubo_result);
                        //print_r($arr_result);
                        /** #ARRUMAR PARA ACRESCENTAR OS INFOS TUBO **/
                        if (count($arr_tubos_result) == 0) {
                            $html = '<div class="form-row" >
                                            <div class="input-group col-md-12 " >
                                                <h5>Quantidade de amostras encontradas: 0 </h5>
                                            </div>
                                         </div>';
                        } else {
                            $button_selecionar == 'n';
                            if (count($arr_tubos_result) >= $qntSelecionada) {
                                $alert = Alert::alert_success("Foi encontrada uma quantidade de amostras maior/igual ao desejado");
                                $quantidade = $qntSelecionada;
                            } else {
                                $quantidade = count($arr_tubos_result);
                                $alert = Alert::alert_danger("Foi encontrada uma quantidade de amostras menor que o desejado");
                            }
                            $qnt = 0;
                            $html = '<div class="form-row" >
                                            <div class="input-group col-md-12 " >
                                                <h5>Quantidade de amostras encontradas: ' . $quantidade . '</h5>
                                            </div>
                                         </div>';
                            foreach ($arr_tubos_result as $tubo_resultado) { //todos os tubos originais
                                if ($qnt >= $qntSelecionada) break;

                                $objAmostra->setIdAmostra($tubo_resultado->getIdAmostra_fk());
                                $objAmostra = $objAmostraRN->consultar($objAmostra);

                                $checked = '';
                                if (isset($_POST['btn_confirmar']) || isset($_POST['btn_confirmar_localizacao'])) {
                                    if (isset($_POST['checkbox_' . $objAmostra->getIdAmostra()])) {
                                        if ($_POST['checkbox_' . $objAmostra->getIdAmostra()] == 'on') {
                                            $amostras_escolhidas[] = $objAmostra;
                                            $checked = 'checked';
                                            $tubos_escolhidos[] = $tubo_resultado;
                                        }
                                    }
                                }


                                if (isset($_POST['enviar_perfil'])) {
                                    $checked = ' checked ';
                                }
                                $html .= '
                                    <div class="form-row" >
                                    <div class="input-group col-md-12 " >
                                          <div class="input-group-prepend">
                                            <div class="input-group-text" >
                                            <!--<label>' . $tubo_resultado->getIdTubo() . '</label>-->
                                              <input type="checkbox" ' . $checked . '  name="checkbox_' . $objAmostra->getIdAmostra() . '" style="width: 50px;" aria-label="Checkbox for following text input">
                                            </div>
                                          </div>
                                          <input type="text" disabled class="form-control" value="Amostra ' . $objAmostra->getCodigoAmostra() . '">
                                    </div>
                                    </div>';

                                $qnt++;
                            }
                        }

                        if (isset($_POST['btn_confirmar']) || isset($_POST['btn_confirmar_localizacao'])) {

                            $objLote->setObjsTubo($tubos_escolhidos);
                            $objLote->setQntAmostrasAdquiridas(count($amostras_escolhidas));


                            $sumir_btn_confirmar = 's';
                            if (count($amostras_escolhidas) < $qntSelecionada) {
                                $alert = Alert::alert_warning('Você selecionou ' . count($amostras_escolhidas) . ' de ' . $quantidade . ' amostras');
                            }

                            $html = '<div class="form-row" >
                                            <div class="input-group col-md-12 " >
                                                <h5>Quantidade de amostras selecionadas: ' . count($amostras_escolhidas) . '  </h5>
                                            </div>
                                      </div><div class="accordion" id="accordionExample">
                                         ';

                            $contador = 1;
                            foreach ($amostras_escolhidas as $objAmostra) {
                                $data = explode("-", $objAmostra->getDataColeta());
                                $ano = $data[0];
                                $mes = $data[1];
                                $dia = $data[2];
                                $html .= '
                                   
                                      <div class="card">
                                        <div class="card-header" id="heading_' . $contador . '" 
                                        style="background-color: rgba(58,82,97,0.8);">
                                          <h5 class="mb-0">
                                            <button class="btn btn-link " style="text-decoration: none;color: #fff;font-size: 15px; 
                                            font-weight: bold;" type="button" data-toggle="collapse" data-target="#collapse_' . $contador . '" 
                                            aria-expanded="true" aria-controls="collapse_' . $contador . '" >
                                              Amostra ' . $objAmostra->getCodigoAmostra() .
                                    '</button>
                                          </h5>
                                        </div>
                                    
                                        <div id="collapse_' . $contador . '" class="collapse show" aria-labelledby="heading_' . $objAmostra->getIdAmostra() . '" data-parent="#accordionExample">
                                          <div class="card-body">
                                             Data coleta: ' . $dia . '/' . $mes . '/' . $ano . '<br>
                                             Local de armazenamento: ##   <br>
                                          </div>
                                        </div>
                                      
                                      </div>';
                                $contador++;


                            }
                        }

                        if (isset($_POST['btn_confirmar_localizacao'])) {
                            print_r($tubos_escolhidos);
                            $objLote->setStatusLote("em análise - aguardando preparação");
                            $objLote->setQntAmostrasDesejadas($qntSelecionada);


                            $objPreparoLote->setObjLote($objLote);
                            $objPreparoLote->setIdCapela($_GET['idCapela']);
                            $objPreparoLote->setIdUsuarioFk(Sessao::getInstance()->getIdUsuario());
                            $objPreparoLote->setDataHoraFim($_SESSION['DATA_SAIDA']);
                            $objPreparoLote->setDataHoraInicio($_POST['dtHoraLoginInicio']);
                            $objPreparoLote->setObjPerfil($perfil);


                            $objRel_Perfil_preparoLote->setObjPreparoLote($objPreparoLote);
                            $objRel_Perfil_preparoLote->setObjPerfilPaciente($perfil);
                            print_r($objRel_Perfil_preparoLote);

                            $objRel_Perfil_preparoLoteRN->cadastrar($objRel_Perfil_preparoLote);
                            $cadastrar_novo = 's';
                            $button_selecionar == 'n';
                            $alert = Alert::alert_success("Os dados foram cadastrado com sucesso");
                            //header('Location: '. Sessao::getInstance()->assinar_link('controlador.php?action=montar_preparo_extracao'));
                            //die();
                        }

                        }
                    }
                }
            }
        }
                /*print_r($arr_perfis_selecionados);

        if(isset($_POST['sel_prioridade'])){
            $selected_data = '';$selected_perfil =''; $selected_reteste = '';
            if($_POST['sel_prioridade'] == 'dcol') $selected_data = ' selected ';
            if($_POST['sel_prioridade'] == 'p') $selected_perfil = ' selected ';
            if($_POST['sel_prioridade'] == 'r') $selected_reteste = ' selected ';

            if($_POST['sel_prioridade'] == 'p') {

                $prioridade = '<small style="color: red;">Quanto menor o número maior a sua prioridade </small>';
                foreach ($arr_perfis_selecionados as $perfil){
                    $prioridade .= '
                <div class="form-row" >
                    <div class="col-md-3">
                       <label for="label">Prioridade do perfil ' . $perfil->getPerfil() . '</label>
                    </div>
                    <div class="col-md-1">
                       <input type="number" class="form-control" max='. count($arr_perfis_selecionados).' min=1 id="idCPF" placeholder="" 
                              name="prioridade_'.$perfil->getIdPerfilPaciente().'"  value="">
                    </div>
                </div>';
                }
            }else{
                $prioridade = '';
            }
            

        }


        if (isset($_POST['enviar_prioridade'])) { //se enviou o perfil e a prioridade
            if($_POST['sel_prioridade'] != '') {
                $selected_data = '';$selected_perfil =''; $selected_reteste = '';
                if($_POST['sel_prioridade'] == 'dcol') $selected_data = ' selected ';
                if($_POST['sel_prioridade'] == 'r') $selected_reteste = ' selected ';

                if($_POST['sel_prioridade'] == 'p'){
                    foreach ($arrPerfis as $perfil){
                        echo $perfil->getIdPerfilPaciente().': '.$_POST['prioridade_'.$perfil->getIdPerfilPaciente().''];
                    }

                } //$selected_perfil = ' selected ';


                if ($_POST['sel_prioridade'] == 'dcol') { // filtra pela menor data dentre todas as amostras dos perfis selecionados
                    $arr_amostras = $objAmostraRN->filtro_menor_data($objAmostra, $_POST['sel_perfis']);
                }
                //print_r($arr_amostras);

                if (isset($_POST['sel_perfis']) && $_POST['sel_perfis'] != null) {
                    $perfisSelecionados = '';
                    for ($i = 0; $i < count($_POST['sel_perfis']); $i++) {
                        $perfisSelecionados .= $_POST['sel_perfis'][$i] . ';';

                        if ($_POST['sel_prioridade'] == 'dcol') { // procura na ordem já
                            foreach ($arr_amostras as $amostra) {
                                if ($amostra->get_a_r_g() == 'a') {
                                    $amostras[$amostra->getIdAmostra()] = $amostra;
                                }
                            }
                        } else {
                            $objAmostra->setIdPerfilPaciente_fk($_POST['sel_perfis'][$i]);
                            $objAmostra->set_a_r_g('a');
                            $arr_amostras_selecionadas[$_POST['sel_perfis'][$i]] = $objAmostraRN->listar($objAmostra); //todas as amostras de um perfil X
                        }
                    }
                    echo $perfisSelecionados;

                    if ($_POST['sel_prioridade'] != 'dcol') {
                        foreach ($arr_amostras_selecionadas as $amostra) {
                            foreach ($amostra as $a) {
                                $amostras[$a->getIdAmostra()] = $a;
                            }
                        }
                    }
                    print_r($amostras);
                    if (count($amostras) > 0) {
                        foreach ($amostras as $a) {
                            $objTubo->setIdAmostra_fk($a->getIdAmostra());
                            if (count($objTuboRN->listar($objTubo)) > 0) {
                                $arr_tubos[$a->getIdAmostra()] = $objTuboRN->listar($objTubo);
                            }
                        }

                        foreach ($arr_tubos as $tubo) {
                            foreach ($tubo as $t) {
                                if ($_POST['sel_prioridade'] == 'r') {
                                    $objInfosTubo->setReteste('s');
                                }
                                $objInfosTubo->setIdTubo_fk($t->getIdTubo());
                                $objInfosTubo->setStatusTubo("Aguardando preparação");
                                if (count($objInfosTuboRN->listar($objInfosTubo)) > 0) {
                                    $arr_infosTubo[$t->getIdTubo()] = $objInfosTuboRN->listar($objInfosTubo); //todos os infos tubo em que o status é "Aguardando preparação"
                                    //$idtubos[] = $t->getIdTubo();
                                }

                            }
                        }

                        $qnt = 0;
                        foreach ($arr_infosTubo as $info) {
                            foreach ($info as $i) {

                                $objInfosTubo = $i;
                                //echo $objInfosTubo->getIdTubo_fk();
                                $objTubo->setIdTubo($objInfosTubo->getIdTubo_fk());
                                $objTubo = $objTuboRN->consultar($objTubo);

                                $objAmostra->setIdAmostra($objTubo->getIdAmostra_fk());
                                $objAmostra = $objAmostraRN->consultar($objAmostra);


                                $html .= '
                           
                                    <div class="input-group mb-3 " >
                                          <div class="input-group-prepend">
                                            <div class="input-group-text" >
                                              <input type="checkbox" checked name="checkbox_' . $objAmostra->getIdAmostra() . '" aria-label="Checkbox for following text input">
                                            </div>
                                          </div>
                                          <input type="text" disabled class="form-control" value="Amostra ' . $objAmostra->getCodigoAmostra() . '">
                                    </div>';
                                $qnt++;
                            }
                        }

                        if($qnt > 0) {
                            $titulo = '<div class="conteudo_grande preparo" style="margin-top: -10px;margin-bottom: 0px;">
                                <h4 style="margin-left: 40px;">Quantidade de amostras: ' . $qnt . '</h4>
                                <form method="post">';
                            $html = $titulo . $html . '</form></div>';
                        }


                    }

                    //if(count($arr_infosTubo) == 0  && $_POST['sel_prioridade'] == 'r'){ $alert .= Alert::alert_warning("Nenhuma amostra encontrada com o filtro: RETESTE"); }
                    if ($qnt == 0 &&  $_POST['sel_prioridade'] == 'dcol') {
                        $alert .= Alert::alert_warning("Nenhuma amostra encontrada com o filtro: DATA DE COLETA");
                    }


                }

                Interf::getInstance()->montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, '', 'this.form.submit()');

            }
        }*/


} catch (Throwable $ex) {
    //DIE($ex);
    Pagina::getInstance()->mostrar_excecoes($ex);
}


Pagina::abrir_head("Montar grupo");
Pagina::getInstance()->adicionar_css("precadastros");
if($cadastrar_novo  == 's') {
    Pagina::getInstance()->adicionar_javascript("popUp");
}

Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
echo $alert;
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
                    <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=montar_preparo_extracao&idLiberar=' . $_GET['idCapela']) . '">Tenho certeza</a></button>
                </div>
            </div>
        </div>
    </div>';

if($cadastrar_novo == 'n') {
    if ($capela_liberada == 'n') {
        echo
        '<div class="conteudo_grande">
            <form method="POST">
                <div class="form-row" >
                
                    <div class="col-md-12">
                        <button class="btn btn-primary" type="submit" name="lock_capela">VERIFICAR DISPONIBILIDADE DA CAPELA</button>
                    </div>
                </div>
            </form>
        </div>';
    }

    if ($capela_liberada == 's') {
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

        } else {
            $col_md = 'col-md-8';
            $readonly = '';
        }
        $qntSelecionada = $_POST['numQntAmostras'];
        echo '<div class="' . $col_md . '">
                        <label for="label_perfisAmostras">Selecione um perfil de amostra</label>'
            . $select_perfis .
            '</div>
          ';

        echo '<div class="col-md-2">
            <label for="label_perfisAmostras">Amostras</label>
            <input type="number" ' . $readonly . ' class="form-control" id="idQntAmostras" placeholder="quantidade" 
                name="numQntAmostras"  value="' . $qntSelecionada . '">
            </div>';


        if ($button_selecionar == 's') {
            echo '<div class="col-md-2" >
                        <button class="btn btn-primary" style="margin-left:0px;margin-top: 31px;width: 100%;" type="submit"  name="enviar_perfil">SELECIONAR</button>
                      </div>
              </div>        ';
        }
        if ($button_selecionar == 'n') {
            echo '</div>';

            echo $html;
            if ($sumir_btn_confirmar == 'n') {
                echo '  <div class="form-row" >';
                echo '    <div class="col-md-6" >
                    <button class="btn btn-primary" style="margin-left:0px;margin-top: 31px;width: 100%;" 
                    type="submit" name="btn_confirmar">CONFIRMAR</button>
                </div>';
            }

            if ($sumir_btn_confirmar == 's') {
                echo '  <div class="form-row" >';
                echo '    <div class="col-md-6" >
                    <button class="btn btn-primary" style="margin-left:0px;margin-top: 31px;width: 100%;" 
                    type="submit" name="btn_confirmar_localizacao">CONFIRMAR LOCALIZAÇÃO</button>
                </div>';
            }

            if ($btn == '') {
                $col_md = 'col-md-12';
            } else {
                $col_md = 'col-md-6';
            }

            echo '<div class="' . $col_md . '" >
        <button type="button" class="btn btn-primary" style="margin-left:0px;margin-top: 31px;width: 100%;" 
        data-toggle="modal"  data-target="#exampleModalCenter3" name="btn_cancelar" > Cancelar</button>
    </div>';
            echo '</div>';
        }

        echo '</div>
            </form>';

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
                    <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=montar_preparo_extracao&idLiberar=' . $_GET['idCapela']) . '">Tenho certeza</a></button>
                </div>
            </div>
        </div>
    </div>';

    if($button_selecionar == 's') {
        echo
        '<div class="conteudo_grande">
            <form method="POST">
                <div class="form-row" >
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary" style="margin-left:25%;margin-top: -30px;width: 50%;" 
                            data-toggle="modal"  data-target="#exampleModalCenter3" name="btn_cancelar" > Cancelar</button>
                    </div>
                </div>
            </form>
        </div>';
    }
    }
}

/*

//echo '<div class="conteudo_grande">'.$collapse.'</div>';


/*echo'
    <div class="modal fade" id="cancel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Tem certeza que dejesa cancelar o cadastro? </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                Ao cancelar, nenhum dado será cadastrado no banco.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"  >Close</button>
                    <button type="button"  class="btn btn-primary"><a href="'. Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_amostra').'">Tenho certeza</a></button>
                </div>
            </div>
        </div>
    </div>';*/



Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();