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

    require_once __DIR__ . '/../../classes/MontagemGrupo/MontagemGrupo.php';
    require_once __DIR__ . '/../../classes/MontagemGrupo/MontagemGrupoRN.php';

    require_once __DIR__ . '/../../classes/Log/Log.php';
    require_once __DIR__ . '/../../classes/Log/LogRN.php';



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
    $btn_imprimir = 'n';

    $qntSelecionada = 0;
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $objPerfilPaciente = new PerfilPaciente();
    $arrPerfis = $objPerfilPacienteRN->listar($objPerfilPaciente);


    $objMontagemGrupo = new MontagemGrupo();
    $objMontagemGrupoRN = new MontagemGrupoRN();

    $cancelar_md12 = 'n';
    $alert .= Alert::alert_info("As amostras serão ordenadas pela data da coleta");


    $btn = '';
    $sumir_btn_cancelar = 'n';

        InterfacePagina::montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, '', '');
        $msgPopUp ='';
        $sumir_btn_confirmar = 'n';
        $sumir_btn_confirmar_novamente = 's';

        if(isset($_GET['idPreparoLote'])){
            $alert = Alert::alert_success("Os dados foram cadastrado com sucesso");
            $objPreparoLote->setIdPreparoLote($_GET['idPreparoLote']);
            $objPreparoLote = $objPreparoLoteRN->consultar_tubos($objPreparoLote);
            $collapse  = '';
            $contador = 0;
            foreach ($objPreparoLote[0]->getObjsTubos() as $g) {
                //print_r($g);
                //print_r($g->getIdAmostra());
                $perfilPaciente = substr($g->getCodigoAmostra(), 0, -1);

                $data = explode("-", $g->getDataColeta());
                $ano = $data[0];
                $mes = $data[1];
                $dia = $data[2];
                $collapse .= '
                    
                       <div class="accordion" id="accordionExample" style="margin-top: 10px;">
                          <div class="card">
                            <div class="card-header" id="heading_' . $contador . '" 
                            style="background-color: rgba(58,82,97,0.8);">
                              <h5 class="mb-0">
                                <button class="btn btn-link " style="text-decoration: none;color: #fff;font-size: 15px; 
                                font-weight: bold;" type="button" data-toggle="collapse" data-target="#collapse_' . $contador . '" 
                                aria-expanded="true" aria-controls="collapse_' . $contador . '" >
                                  Amostra ' . $g->getNickname() .
                     '</button>
                              </h5>
                            </div>
                        
                            <div id="collapse_' . $contador . '" class="collapse show" aria-labelledby="heading_' . $g->getIdAmostra() . '" data-parent="#accordionExample">
                              <div class="card-body">
                                 <strong>Data coleta:</strong> ' . $dia . '/' . $mes . '/' . $ano . '<br>
                                 <strong>Perfil paciente:</strong> ' . PerfilPacienteRN::retornarTipoPaciente($g->getObjPaciente()->getCaractere()) . '<br>
                              </div>
                            </div>
                          
                          </div>
                          </div>';
                $contador++;
            }


        }

        if(isset($_POST['btn_imprimir'])){
            header('Location: '. Sessao::getInstance()->assinar_link('controlador.php?action=imprimir_preparo_lote&idPreparoLote='.$_GET['idPreparoLote']));
            die();
        }


        if (isset($_POST['enviar_perfil']) || isset($_POST['btn_confirmar'])|| isset($_POST['btn_confirmar_novamente'])) { //se enviou o perfil e a prioridade
            $_SESSION['DATA_SAIDA'] = date("Y-m-d H:i:s");

            if(isset($_POST['enviar_perfil'])){
                $btn = 'selecionar';
                $sumir_btn_confirmar = 'n';
            }
            if(isset($_POST['btn_confirmar'])){
                $btn = 'confirmar';
                //$sumir_btn_confirmar = 's';
            }
            if(isset($_POST['btn_confirmar_novamente'])){
                $btn = 'confirmar_novamente';
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
                    } else if ($erro_qntAmostras == 'n') { //chegou até aqui então está tudo certo

                        $objMontagemGrupo->setArrIdsPerfis($arr_idsPerfis);
                        $objMontagemGrupo->setQntAmostras($qntSelecionada);
                        $arr_grupo = $objMontagemGrupoRN->listar_completo($objMontagemGrupo); //listou todas as amostras


                        //die();
                        if (count($arr_grupo) == 0) {
                            $alert .= Alert::alert_warning("Não foi encontrada nenhuma amostra");
                        } else {
                            $button_selecionar = 'n';

                            if (count($arr_grupo) >= $qntSelecionada) {
                                $alert = Alert::alert_success("Foi encontrada uma quantidade de amostras maior/igual ao desejado");
                                $quantidade = $qntSelecionada;
                            } else {
                                $quantidade = count($arr_grupo);
                                $alert = Alert::alert_warning("Foi encontrada uma quantidade de amostras menor que o desejado");
                            }

                            $html = '<div class="form-row" >
                                            <div class="input-group col-md-12 " >
                                                <h5>Quantidade de amostras encontradas: ' . $quantidade . '</h5>
                                            </div>
                                         </div>';
                            $hidden = '';
                            $VALORES = '';
                            $show = false;
                            foreach ($arr_grupo as $grupo) { //todos os tubos originais
                                //print_r($grupo);
                                $checked = '';
                                $disabled = '';
                                $hidden = '';

                                if(isset($_POST['btn_confirmar'])) {
                                    $sumir_btn_confirmar = 's';
                                    $sumir_btn_confirmar_novamente = 'n';
                                    if ($_POST['checkbox_' . $grupo->getAmostra()->getIdAmostra()] == 'on') {
                                        $arr_amostras[] = $grupo->getAmostra();
                                        $idAMOSTRAS .= $grupo->getAmostra()->getIdAmostra().',';
                                        $idTUBOS .= $grupo->getAmostra()->getObjTubo()->getIdTubo().',';
                                        $checked = ' checked ';
                                        $show = true;

                                    }else{
                                        $show = false;
                                        
                                    }
                                }


                                if(isset($_POST['btn_confirmar_novamente'])){
                                    //echo $_POST['checkboxes'];
                                    $arr_checks = array();
                                    $arr_checks = explode(',',$_POST['checkboxes']);
                                    //print_r($arr_checks);

                                    $arr_tubos = array();
                                    $arr_tubos = explode(',',$_POST['checkboxes_tubos']);

                                    for($i=0; $i<count($arr_checks); $i++){
                                        if($grupo->getAmostra()->getIdAmostra() == $arr_checks[$i]){
                                            //echo "####".$grupo->getAmostra()->getIdAmostra();
                                            $checked = ' checked ';
                                            $show = true;
                                        }
                                       
                                    }
                                    if($checked == ' checked '){
                                        $show = true;
                                    }else{
                                        $show = false;
                                    }
                                }


                                if (isset($_POST['enviar_perfil'])) {
                                    $checked = ' checked ';
                                    $show = true;
                                }
                                //print_r($grupo);
                                if($show) {
                                    $html .= '
                                    <div class="form-row"  >
                                                                        
                                    <div class="input-group col-md-12 " >
                                          <div class="input-group-prepend">
                                          <input type="text"  class="form-control" hidden value="' . $idAMOSTRAS . '" name="checkboxes">
                                          <input type="text"  class="form-control" hidden value="' . $idTUBOS . '" name="checkboxes_tubos">
                                            <div class="input-group-text" >
                                              <input type="checkbox" ' . $checked . '  name="checkbox_' . $grupo->getAmostra()->getIdAmostra() . '" 
                                              style="width: 50px;" aria-label="Checkbox for following text input">
                                            </div>
                                          </div>
                                          <input type="text" disabled  class="form-control" value="Amostra '.TuboRN::mostrarDescricaoTipoTubo($grupo->getAmostra()->getObjTubo()->getTipo()).' '. $grupo->getAmostra()->getNickname() . ' ---  Data coleta: ' . $grupo->getAmostra()->getDataColeta() .'">
                                    </div>
                                    </div>';
                                }

                            }


                            if (isset($_POST['btn_confirmar_novamente'])) {

                                //print_r($arr_checks);
                                for($i=0; $i<(count($arr_tubos)-1); $i++){

                                    $objTubo = new Tubo();
                                    $objTubo->setIdTubo($arr_tubos[$i]);
                                    $tubos[] = $objTubo;
                                }

                                /*$VALORES = substr($VALORES,0,-1);

                                $idsTubos = explode(",",$VALORES);

                                for($i=0; $i<count($idsTubos);$i++){
                                    $objTubo = new Tubo();
                                    $objTubo->setIdTubo($idsTubos[$i]);
                                    $tubos[] = $objTubo;
                                }
                                */
                                if(count($tubos) > 0) {
                                    $btn_imprimir = 's';
                                    $sumir_btn_confirmar = 's';
                                    $sumir_btn_cancelar = 'n';

                                    // print_r($tubos_selecionados);
                                    $objLote->setTipo(LoteRN::$TL_PREPARO);
                                    $objLote->setObjsTubo($tubos);
                                    $objLote->setSituacaoLote(LoteRN::$TE_TRANSPORTE_PREPARACAO);
                                    $objLote->setQntAmostrasDesejadas($qntSelecionada);
                                    $objLote->setQntAmostrasAdquiridas(count($tubos));

                                    $objPreparoLote->setObjLote($objLote);

                                    $objPreparoLote->setIdUsuarioFk(Sessao::getInstance()->getIdUsuario());
                                    $objPreparoLote->setDataHoraFim($_SESSION['DATA_SAIDA']);
                                    $objPreparoLote->setDataHoraInicio($_POST['dtHoraLoginInicio']);
                                    $objPreparoLote->setObjPerfil($perfil);


                                    $objRel_Perfil_preparoLote->setObjPreparoLote($objPreparoLote);
                                    $objRel_Perfil_preparoLote->setObjPerfilPaciente($perfil);
                                    //print_r($objRel_Perfil_preparoLote);

                                    $objRel_Perfil_preparoLoteRN->cadastrar($objRel_Perfil_preparoLote);
                                    $cadastrar_novo = 's';
                                    $button_selecionar == 'n';
                                    $sumir_btn_confirmar_novamente = 's';
                                    $sumir_btn_cancelar = 's';
                                    $btn_imprimir = 's';
                                    $alert = Alert::alert_success("Os dados foram cadastrado com sucesso");

                                    //header('Location: '. Sessao::getInstance()->assinar_link('controlador.php?action=montar_preparo_extracao&idPreparoLote='.$objPreparoLote->getIdPreparoLote()));
                                    //die();
                            }
                        }
                    }

                }
            }
        }
    }


} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Montar grupo");
Pagina::getInstance()->adicionar_css("precadastros");
if($cadastrar_novo  == 's') {
    Pagina::getInstance()->adicionar_javascript("popUp");
}
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::getInstance()->mostrar_excecoes();

if(!isset($_GET['idPreparoLote'])) {
    Pagina::montar_topo_listar("CRIAR GRUPO DE AMOSTRAS",null,null, "listar_preparo_lote", 'LISTAR GRUPOS');
    echo $alert;
}else{
    Pagina::montar_topo_listar("INFORMAÇÕES SOBRE O GRUPO DE AMOSTRAS",null,null, "listar_preparo_lote", 'LISTAR GRUPOS');
    echo $alert;
    echo '
            <form method="post">
               <div class="form-row" >
                    <div class="col-md-12">
                        <button class="btn btn-primary" style="margin-left:0px;margin-top: 31px;width: 100%;" type="submit"  name="btn_imprimir">IMPRIMIR</button>
                    </div>
                </div>
            </form>';
}



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
                <div class="modal-body">
                    
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"  >Close</button>
                    <button type="button"  class="btn btn-primary">
                    <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=montar_preparo_extracao') . '">Tenho certeza</a></button>
                </div>
            </div>
        </div>
    </div>';


if(!isset($_GET['idPreparoLote'])) {
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
                    type="submit" name="btn_confirmar" >SELECIONAR AMOSTRAS</button>
                </div>';

        }

        if ($sumir_btn_confirmar_novamente == 'n' && $sumir_btn_confirmar = 's') {
            echo '  <div class="form-row" >';
            echo '<div class="col-md-6">
                        <button class="btn btn-primary" style="margin-left:0px;margin-top: 31px;width: 100%;" 
                    type="submit" name="btn_confirmar_novamente" > CONFIRMAR NOVAMENTE</button>
                </div>';
        }

        if ($sumir_btn_cancelar == 'n' && $sumir_btn_confirmar_novamente = 's') {
            echo '<div class="col-md-6">
                        <button type="button" class="btn btn-primary" style="margin-left:0px;margin-top: 31px;width: 100%;color:white;text-decoration: none;" 
                        data-toggle="modal"  data-target="#exampleModalCenter3" name="btn_cancelar" > Cancelar</button>
                </div>';
        }



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
                    <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=montar_preparo_extracao') . '">Tenho certeza</a></button>
                </div>
            </div>
        </div>
    </div>';

}else if(isset($_GET['idPreparoLote'])){
    echo '<div class="conteudo_grande">
                <div class="form-row" >
                   <div class="col-md-12">'
                    .$collapse.
                   '</div>
                </div>
            </div>';

}

   /* if($button_selecionar == 's' && $sumir_btn_cancelar = 'n') {
        echo
        '<div class="conteudo_grande">
            <form method="POST">
                <div class="form-row" >
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary" style="margin-left:25%;margin-top: -30px;width: 50%;" 
                            data-toggle="modal"  data-target="" name="btn_cancelar" > Cancelar</button>
                    </div>
                </div>
            </form>
        </div>';
    }*/

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


Pagina::getInstance()->fechar_corpo();