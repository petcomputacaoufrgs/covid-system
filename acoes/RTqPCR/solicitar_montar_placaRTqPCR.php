<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
try {
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once __DIR__ . '/../../utils/Alert.php';
    require_once __DIR__ . '/../../utils/Utils.php';

    require_once __DIR__ . '/../../classes/Placa/Placa.php';
    require_once __DIR__ . '/../../classes/Placa/PlacaRN.php';

    require_once __DIR__ . '/../../classes/Amostra/Amostra.php';
    require_once __DIR__ . '/../../classes/Amostra/AmostraRN.php';

    require_once __DIR__ . '/../../classes/Tubo/Tubo.php';
    require_once __DIR__ . '/../../classes/Tubo/TuboRN.php';

    require_once __DIR__ . '/../../classes/InfosTubo/InfosTubo.php';
    require_once __DIR__ . '/../../classes/InfosTubo/InfosTuboRN.php';

    require_once __DIR__ . '/../../classes/Protocolo/Protocolo.php';
    require_once __DIR__ . '/../../classes/Protocolo/ProtocoloRN.php';

    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPaciente.php';
    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPacienteRN.php';

    require_once __DIR__ . '/../../classes/RelTuboPlaca/RelTuboPlaca.php';
    require_once __DIR__ . '/../../classes/RelTuboPlaca/RelTuboPlacaRN.php';

    require_once __DIR__ . '/../../classes/RelPerfilPlaca/RelPerfilPlaca.php';
    require_once __DIR__ . '/../../classes/RelPerfilPlaca/RelPerfilPlacaRN.php';

    require_once __DIR__ . '/../../classes/SolicitacaoMontarPlaca/SolicitacaoMontarPlaca.php';
    require_once __DIR__ . '/../../classes/SolicitacaoMontarPlaca/SolicitacaoMontarPlacaRN.php';

    require_once __DIR__ . '/../../classes/Poco/Poco.php';
    require_once __DIR__ . '/../../classes/Poco/PocoRN.php';

    require_once __DIR__ . '/../../classes/RelPocoPlaca/PocoPlaca.php';
    require_once __DIR__ . '/../../classes/RelPocoPlaca/PocoPlacaRN.php';

    require_once __DIR__ . '/../../classes/Tipo/Tipo.php';

    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTexto.php';
    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTextoRN.php';



    Sessao::getInstance()->validar();
    $utils = new Utils();

    date_default_timezone_set('America/Sao_Paulo');
    $_SESSION['DATA_LOGIN'] = date("Y-m-d H:i:s");


    /*
     * AMOSTRA
     */
    $objAmostra = new Amostra();
    $objAmostraRN = new AmostraRN();

    /*
     * PLACA
     */
    $objPlaca = new Placa();
    $objPlacaRN = new PlacaRN();

    /*
    * TUBO
    */
    $objTubo = new Tubo();
    $objTuboRN = new TuboRN();

    $objInfosTubo = new InfosTubo();
    $objInfosTuboRN = new InfosTuboRN();


    /*
     * POÇO
     */
    $objPoco = new Poco();
    $objPocoRN = new PocoRN();

    /*
     * PROTOCOLO
     */
    $objProtocolo = new Protocolo();
    $objProtocoloRN = new ProtocoloRN();

    /*
     * PERFIL PACIENTE
     */
    $objPerfilPaciente = new PerfilPaciente();
    $objPerfilPacienteRN = new PerfilPacienteRN();

    /*
     * RELACIONAMENTO DOS TUBOS COM A PLACA
     */
    $objRelTuboPlaca = new RelTuboPlaca();
    $objRelTuboPlacaRN = new RelTuboPlacaRN();

    /*
    * RELACIONAMENTO DOS PERFIS COM A PLACA
    */
    $objRelPerfilPlaca = new RelPerfilPlaca();
    $objRelPerfilPlacaRN = new RelPerfilPlacaRN();

    /*
     * SOLICITAÇÃO DE MONTAGEM DA PLACA RTqPCR
     */
    $objSolMontarPlaca = new SolicitacaoMontarPlaca();
    $objSolMontarPlacaRN = new SolicitacaoMontarPlacaRN();


    /*
     * SOLICITAÇÃO DE MONTAGEM DA PLACA RTqPCR
     */
    $objSolMontarPlaca = new SolicitacaoMontarPlaca();
    $objSolMontarPlacaRN = new SolicitacaoMontarPlacaRN();



    $alert = '';
    $disabled = '';
    $select_protocolos = '';
    $select_perfis = '';
    $perfisSelecionados = '';
    $adicionar_qntMaxAmostras = 'n';
    $btn_selecionar_sumir = 'n';
    $sumir_btn_salvar = 'n';
    $aparecer_btn_mapa = 'n';
    $txtTipoSolicitacao = '';
    $lista = '';

    $btn_qnt_sumir = 'n';

    InterfacePagina::montar_select_protocolos($select_protocolos, $objProtocolo, $objProtocoloRN, $disabled, 'onchange="this.form.submit()"');
    InterfacePagina::montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, '', '', null);

    if(isset($_GET['idSituacao'])){
        if($_GET['idSituacao'] == 1){
            //veio do listar
        }
        if($_GET['idSituacao'] == 2){
            //cadastro parcial
        }
        if($_GET['idSituacao'] == 3){
            //lote já finalizado
            $alert .= Alert::alert_danger("A solicitação de montagem já foi feita");
        }
        if($_GET['idSituacao'] == 4){
            //solicitação removida já que não tem nenhuma amostra na placa
            $alert = Alert::alert_warning("Nenhuma amostra foi selecionada para a placa");
            $alert .= Alert::alert_success("Solicitação <strong>removida</strong> com sucesso");
        }

    }


    if (isset($_POST['sel_protocolos'])) {
        header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=solicitar_montagem_placa_RTqPCR&idTipoSolicitacao='.$_GET['idTipoSolicitacao'].'&idProtocolo=' . $_POST['sel_protocolos']));
        die();
    }


    if(isset($_POST['btn_cancelar'])){

        if (isset($_GET['idSolicitacao'])) {
            $objSolMontarPlaca->setIdSolicitacaoMontarPlaca($_GET['idSolicitacao']);
            $objSolMontarPlaca = $objSolMontarPlacaRN->consultar($objSolMontarPlaca);
            $objSolMontarPlacaRN->remover_completamente($objSolMontarPlaca);
            header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=solicitar_montagem_placa_RTqPCR'));
            die();
        }

    }


    if (isset($_GET['idProtocolo']) && !isset($_POST['enviar_perfis'])) {
        $objProtocolo->setIdProtocolo($_GET['idProtocolo']);
        $objProtocolo = $objProtocoloRN->consultar($objProtocolo);
        InterfacePagina::montar_select_protocolos($select_protocolos, $objProtocolo, $objProtocoloRN, ' disabled ', '');
        $adicionar_qntMaxAmostras = 's';

        if ($objProtocolo->getCaractere() == ProtocoloRN::$TP_LACEN_IBMP) {
            $objPerfilPaciente->setCaractere(PerfilPacienteRN::$TP_PACIENTES_SUS);
            $arr = $objPerfilPacienteRN->listar($objPerfilPaciente);
            $objPerfilPaciente = $arr[0];
            $perfisSelecionados = $objPerfilPaciente->getIdPerfilPaciente() . ';';
            InterfacePagina::montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, 'readonly="readonly"', '', null);
        } else {
            InterfacePagina::montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, '', '', null);
        }
    }



    if (isset($_GET['idProtocolo']) && (isset($_POST['enviar_perfis']) || isset($_POST['btn_quantidade']))) {// isset($_POST['salvar_placa']) )){ //se salvou o perfil
        $objProtocolo->setIdProtocolo($_GET['idProtocolo']);
        $objProtocolo = $objProtocoloRN->consultar($objProtocolo);
        InterfacePagina::montar_select_protocolos($select_protocolos, $objProtocolo, $objProtocoloRN, ' disabled ', '');
        $adicionar_qntMaxAmostras = 's';
        $contador = 0;

        if(is_null($_POST['inputhidden']) && is_null($_POST['sel_perfis'])){
            $alert .= Alert::alert_danger("Informe o(s) perfil(s) da amostra");
        }else{
        $perfisSelecionados = $_POST['inputhidden'];

            if (isset($_POST['sel_perfis']) && $_POST['sel_perfis'] != null) {
                $paciente_sus = 'n';
                for ($i = 0; $i < count($_POST['sel_perfis']); $i++) {
                    $perfisSelecionados .= $_POST['sel_perfis'][$i] . ';';
                    $arr_idsPerfis[$contador++] = $_POST['sel_perfis'][$i];
                    $objPerfilPacienteAux = new PerfilPaciente();
                    $objPerfilPacienteAux->setIdPerfilPaciente($_POST['sel_perfis'][$i]);
                    $perfil[$i] = $objPerfilPacienteRN->consultar($objPerfilPacienteAux);
                    if ($perfil[$i]->getCaractere() == PerfilPacienteRN::$TP_PACIENTES_SUS) {
                        $paciente_sus = 's';
                    }
                }
            }

            $input_hidden = '<input type="text" name="inputhidden" hidden value="'.$perfisSelecionados.'">';
            InterfacePagina::montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, ' disabled ', '');
            if($_GET['idTipoSolicitacao'] == Tipo::$TIPO_AUTOMATICO ) {
                $btn_selecionar_sumir = 's';
            }
            $objAmostra->setObjProtocolo($objProtocolo);
            $objAmostra->setObjPerfil($arr_idsPerfis);

            if (isset($_POST['btn_quantidade']) || isset($_POST['enviar_perfis']) ) {
                //echo $_POST['numAmostrasManuais'];

                $arr_posts = array();
                for($i=0; $i<$_POST['numAmostrasManuais']; $i++){
                    $lista .= ' <div class="form-row" >
                                    <div class="col-md-1" >
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">' . ($i + 1) . ' ª amostra </div>
                                    </div>
                                    </div>
                                    
                                    <div class="col-md-11" >
                                        <input type="text" class="form-control" id="idQntAmostras" placeholder="código amostra"
                                            name="txtCod_' . $i . '" style="margin-left:20px;width:95%;" value="' . Pagina::formatar_html(strtoupper($utils->tirarAcentos($_POST['txtCod_' . $i]))) . '">
                                    </div>
                                </div>';

                    if($_POST['enviar_perfis']){
                        $arr_posts[] = Pagina::formatar_html(strtoupper($utils->tirarAcentos($_POST['txtCod_' . $i])));
                    }
                }

            }else{
                $alert .= Alert::alert_danger("Informar a quantidade de amostras");
            }
        }
         if(isset($_POST['enviar_perfis'])) {


            //if($_GET['idTipoSolicitacao'] == Tipo::$TIPO_MANUAL || $_GET['idTipoSolicitacao'] == Tipo::$TIPO_HIBRIDO ||){
                //procurar pelas amostras e ver se estão na etapa certa
                //print_r($arr_posts);
                $arr_perfis = explode(';',$perfisSelecionados);
                array_pop($arr_perfis);
                $arr_perfis = array_unique($arr_perfis);

                $perfil = array();
                foreach ($arr_perfis as $perfilItem){
                    $objPerfilPaciente->setIdPerfilPaciente($perfilItem);
                    $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
                    $perfil[] = $objPerfilPaciente;
                }

                $objAmostra->setObjPerfil($perfil);

             if($_GET['idTipoSolicitacao'] == Tipo::$TIPO_MANUAL || $_GET['idTipoSolicitacao'] == Tipo::$TIPO_HIBRIDO) {
                 $arr_amostrasAux = $objAmostraRN->validar_amostras_solicitacao($arr_posts, $perfil);
             }
                $btn_qnt_sumir = 's';
                $btn_selecionar_sumir = 's';

               // print_r($objAmostra);
               // die();


             if($_GET['idTipoSolicitacao'] == Tipo::$TIPO_AUTOMATICO){
                 $arr_amostras = $objAmostraRN->listar_aguardando_sol_montagem_placa_RTqCPR($objAmostra,$objProtocolo->getNumMaxAmostras(),null);
                 //print_r($arr_amostras);
             }
             if($_GET['idTipoSolicitacao'] == Tipo::$TIPO_HIBRIDO){
                 $arr_amostras = $objAmostraRN->listar_aguardando_sol_montagem_placa_RTqCPR($objAmostra,$objProtocolo->getNumMaxAmostras(), $arr_amostrasAux);
                 //echo "<pre>";
                 //print_r($arr_amostras);
                 //echo "</pre>";

             }
             if($_GET['idTipoSolicitacao'] == Tipo::$TIPO_MANUAL){
                 $arr_amostras = $arr_amostrasAux;
             }

             if(count($arr_amostras) > 0) {

                 //echo '<pre>';
                 //print_r($arr_amostras);
                 //echo '</pre>';
                 //die();

                 $objPlaca->setIdProtocoloFk($_GET['idProtocolo']);
                 if (isset($_POST['txtNomePlaca'])) {
                     $objPlaca->setPlaca($_POST['txtNomePlaca']);
                     $objPlaca->setIndexPlaca($utils->tirarAcentos(strtoupper($_POST['txtNomePlaca'])));
                 }
                 //$objPlaca->setObjsAmostras($arr_amostras);
                 $arr_infos_tubos = array();
                 foreach ($arr_amostras as $amostra) {
                     $objTubo = $amostra->getObjTubo();
                     if($amostra->getObjTubo()->getObjInfosTubo() == null) {
                         $objInfosTubo->setIdTubo_fk($amostra->getObjTubo()->getIdTubo());
                         $objInfosTuboUltimo = $objInfosTuboRN->pegar_ultimo($objInfosTubo);
                     }else{
                         $objInfosTuboUltimo = $amostra->getObjTubo()->getObjInfosTubo();
                     }


                     $objInfosTuboUltimo->setIdInfosTubo(null);
                     $objInfosTuboUltimo->setObservacoes(null);
                     $objInfosTuboUltimo->setObsProblema(null);
                     $objInfosTuboUltimo->setSituacaoTubo(InfosTuboRN::$TST_EM_UTILIZACAO);
                     $objInfosTuboUltimo->setSituacaoEtapa(InfosTuboRN::$TSP_EM_ANDAMENTO);
                     $arr_infos_tubos[0] = $objInfosTuboUltimo;
                     $objTubo->setObjInfosTubo($arr_infos_tubos);
                     $tubos[] = $objTubo;

                 }

                 //echo "<pre>";
                 //print_r($tubos);
                 //echo "</pre>";
                 //die();

                 //echo count($tubos);
                 $objPlaca->setObjsTubos($tubos);


                 $objRelPerfilPlaca->setObjPerfis($perfil);

                 $objSolMontarPlaca->setIdUsuarioFk(Sessao::getInstance()->getIdUsuario());
                 $objSolMontarPlaca->setDataHoraInicio($_SESSION['DATA_LOGIN']);
                 $objSolMontarPlaca->setDataHoraFim(date("Y-m-d H:i:s"));
                 $objPlaca->setSituacaoPlaca(PlacaRN::$STA_SOLICITACAO_MONTAGEM);
                 $objSolMontarPlaca->setSituacaoSolicitacao(SolicitacaoMontarPlacaRN::$TS_EM_ANDAMENTO);
                 $objSolMontarPlaca->setObjRelPerfilPlaca($objRelPerfilPlaca);
                 $objSolMontarPlaca->setObjPlaca($objPlaca);

                 //echo '<pre>';
                 //print_r( $objSolMontarPlaca);
                 //echo '</pre>';
                 //die();
                 $objSolMontarPlaca = $objSolMontarPlacaRN->cadastrar($objSolMontarPlaca);

                 header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=solicitar_montagem_placa_RTqPCR&idSolicitacao=' . Pagina::formatar_html($objSolMontarPlaca->getIdSolicitacaoMontarPlaca()) . '&idProtocolo=' . Pagina::formatar_html($objSolMontarPlaca->getObjPlaca()->getIdProtocoloFk()) . '&idPlaca=' . Pagina::formatar_html($objSolMontarPlaca->getObjPlaca()->getIdPlaca()) . '&idSituacao=2'));
                 die();
             }else{
                 $btn_selecionar_sumir = 'n';
                 $sumir_btn_salvar = 'n';
                 $perfisSelecionados= '';
                 $objPerfilPaciente = new PerfilPaciente();
                 InterfacePagina::montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, '  ', '');
                 $alert .= Alert::alert_warning("Nenhuma amostra foi encontrada");
             }
         }

    }

    if(isset($_GET['idProtocolo']) && isset($_GET['idPlaca']) && isset($_GET['idSolicitacao']) ){

        $disabled = ' disabled ';

        $objSolMontarPlaca->setIdSolicitacaoMontarPlaca($_GET['idSolicitacao']);
        $arr_solicitacoes = $objSolMontarPlacaRN->listar($objSolMontarPlaca);
        //echo "<pre>";
        //print_r($arr_solicitacoes);
        //echo "</pre>";
        //die();

        $objProtocolo = $arr_solicitacoes[0]->getObjPlaca()->getObjProtocolo();
        InterfacePagina::montar_select_protocolos($select_protocolos, $objProtocolo, $objProtocoloRN, ' disabled ', '');

        $objPlaca = $arr_solicitacoes[0]->getObjPlaca();
        $perfisSelecionados ='';
        foreach ($arr_solicitacoes[0]->getObjsPerfis() as $perfis){
            //print_r($perfis);
            $perfisSelecionados .=  $perfis->getIdPerfilFk() . ';';
        }
        $objPerfilPaciente = new PerfilPaciente();
        InterfacePagina::montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, ' disabled ', '');
        $btn_selecionar_sumir = 's';

        $alert .= Alert::alert_info("Foram encontradas " . count($arr_solicitacoes[0]->getObjsAmostras()) . " amostras");

        /*echo '<pre>';
        print_r($arr_solicitacoes);
        echo '</pre>';*/

        if ($sumir_btn_salvar == 's') {

        }
        //$tabela_poco =


        //lista das amostras com o perfil certo, só exibir tudo
        foreach ($arr_solicitacoes[0]->getObjsAmostras() as $amostra) {
            if (!isset($_POST['salvar_placa'])) {
               $hdnValue= 'S';
                $class = ' sucesso_rgba ';
                $texto = '<i class="fas fa-minus"></i> Remover da placa';
            }else{
                $hdnValue= $_POST['hdnAmostra' . $amostra->getIdAmostra()];
                $texto = '';
                if($hdnValue == 'S') {
                    $class = ' sucesso_rgba ';
                }else{
                    $class = ' error_rgba ';

                }
            }
            $collapse .= '<div id="accordion_' . $amostra->getObjTubo()->getIdTubo() . '" style="margin-top: 10px;">
                                  <div class="card" >
                                    <div class="card-header '.$class.'"  id="heading_' . $amostra->getObjTubo()->getIdTubo() . '" style="padding:2px; height: 50px;">
                                      <h5 class="mb-0" style="margin-top: 5px;">
                                       <input type="hidden" name="hdnAmostra' . $amostra->getIdAmostra() . '" id="hdnAmostra' . $amostra->getIdAmostra() . '"  value="'.$hdnValue.'">  ';


            $collapse .= ' <button type="button" onclick="remover(' . $amostra->getIdAmostra() . ',' . $amostra->getObjTubo()->getIdTubo() . ')" id="btnAmostra' . $amostra->getIdAmostra() . '" 
            style="float: right;font-size: 13px;color: #3a5261;text-decoration: none !important; background: none;border: none;" 
            name="btn_remover">  '.$texto.' </button>';


            $collapse .= ' <button class="btn btn-link" style="text-decoration: none !important;" data-toggle="collapse" type="button"
                                        data-target="#collapse_' . $amostra->getObjTubo()->getIdTubo() . '" aria-expanded="true" 
                                        aria-controls="collapse_' . $amostra->getObjTubo()->getIdTubo() . '">
                                     <h6 style="text-decoration: none !important; color: #3a5261;">' . $amostra->getNickname() . ' - '.$amostra->getObjPerfil()->getIndex_perfil() . '</h6>                           
                                </button>
                              </h5>
                            </div>
                                
                                    <div id="collapse_' . $amostra->getObjTubo()->getIdTubo() . '" class="collapse show " aria-labelledby="heading_' . $amostra->getObjTubo()->getIdTubo() . '" data-parent="#accordion_' . $amostra->getObjTubo()->getIdTubo() . '">
                                      <div class="card-body">
                                            <div class="form-row">
                                                <div class="col-md-4">
                                                    <label >Data Coleta:</label>
                                                        <input type="date" disabled  style="text-align: center;" class="form-control" id="idData" placeholder="" 
                                                       onblur="" name="dtDataColeta"  value="' . $amostra->getDataColeta() . '">  
                                                </div>
                                                <div class="col-md-4">
                                                    <label >Tipo amostra:</label>
                                                        <input type="text" style="text-align: center;" disabled class="form-control" id="idData" placeholder="" 
                                                       onblur="" name="txtTipoTubo"  value="' . TuboRN::mostrarDescricaoTipoTubo($amostra->getObjTubo()->getTipo()) . '">  
                                                </div>
                                                <div class="col-md-4">
                                                    <label >Observações:</label>
                                                        <input type="text" disabled style="text-align: center;" class="form-control" id="idData" placeholder="" 
                                                       onblur="" name="txtTipoTubo"  value="' . $amostra->getObservacoes() . '">  
                                                </div>
                                                
                                            </div>
                                      </div>
                                    </div>
                                  </div>
                             </div>';

            if (isset($_POST['salvar_placa'])) {
                if($_POST['hdnAmostra' . $amostra->getIdAmostra()] == 'S') {
                    $arr_amostras_escolhidas[] = $amostra;
                }
            }

        }

        if (isset($_POST['salvar_placa'])) {

            $objSolMontarPlacaAux = new SolicitacaoMontarPlaca();
            $objSolMontarPlacaAux->setIdSolicitacaoMontarPlaca($_GET['idSolicitacao']);
            $objSolMontarPlacaAux =  $objSolMontarPlacaRN->consultar($objSolMontarPlacaAux);

            if($objSolMontarPlacaAux->getSituacaoSolicitacao() == SolicitacaoMontarPlacaRN::$TS_FINALIZADA){
                header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=solicitar_montagem_placa_RTqPCR&idSituacao=2'));
                die();
            }else {

                if (count($arr_amostras_escolhidas) == 0) {

                    $objSolMontarPlaca->setIdSolicitacaoMontarPlaca($_GET['idSolicitacao']);
                    $objSolMontarPlaca = $objSolMontarPlacaRN->remover_completamente($objSolMontarPlaca);
                    header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=solicitar_montagem_placa_RTqPCR&idSituacao=4'));
                    die();

                } else {
                    $alert = Alert::alert_info("Foram selecionadas " . count($arr_amostras_escolhidas) . " amostras");
                }

                // $sumir_btn_salvar = 's';
                //print_r($arr_amostras_escolhidas);

                $arr_infos = array();
                for ($i = 0; $i < count($arr_amostras_escolhidas); $i++) {

                    $objTubo = new Tubo();
                    $objTubo->setIdTubo($arr_amostras_escolhidas[$i]->getObjTubo()->getIdTubo());


                    $objInfosTubo = new InfosTubo();
                    $objInfosTubo->setIdTubo_fk($arr_amostras_escolhidas[$i]->getObjTubo()->getIdTubo());
                    $objInfosTubo = $objInfosTuboRN->pegar_ultimo($objInfosTubo);
                    $objInfosTubo->setIdInfosTubo(null);
                    $objInfosTubo->setIdTubo_fk($arr_amostras_escolhidas[$i]->getObjTubo()->getIdTubo());
                    $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                    $objInfosTubo->setEtapa(InfosTuboRN::$TP_RTqPCR_SOLICITACAO__MONTAGEM_PLACA);
                    $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                    $objInfosTubo->setIdLote_fk(null);
                    $objInfosTubo->setIdLocalFk(null);
                    $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_AGUARDANDO_MIX_PLACA);
                    $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                    $arr_infos[0] = $objInfosTubo;

                    $objInfosTuboAux = new InfosTubo();
                    $objInfosTuboAux->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                    $objInfosTuboAux->setIdTubo_fk($arr_amostras_escolhidas[$i]->getObjTubo()->getIdTubo());
                    $objInfosTuboAux->setEtapaAnterior(InfosTuboRN::$TP_RTqPCR_SOLICITACAO__MONTAGEM_PLACA);
                    $objInfosTuboAux->setEtapa(InfosTuboRN::$TP_RTqPCR_MIX_PLACA);
                    $objInfosTuboAux->setIdLote_fk(null);
                    $objInfosTuboAux->setIdLocalFk(null);
                    $objInfosTuboAux->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                    $objInfosTuboAux->setSituacaoTubo(InfosTuboRN::$TST_AGUARDANDO_MIX_PLACA);
                    $objInfosTuboAux->setVolume($objInfosTubo->getVolume());
                    $objInfosTuboAux->setReteste($objInfosTubo->getReteste());
                    $objInfosTuboAux->setDataHora(date("Y-m-d H:i:s"));
                    $arr_infos[1] = $objInfosTuboAux;
                    $objTubo->setObjInfosTubo($arr_infos);
                    $tubos[$i] = $objTubo;


                }



                $objPlaca->setObjsTubos($tubos);
                $objSolMontarPlaca->setIdSolicitacaoMontarPlaca($_GET['idSolicitacao']);
                $objSolMontarPlaca = $objSolMontarPlacaRN->consultar($objSolMontarPlaca);
                $objSolMontarPlaca->setSituacaoSolicitacao(SolicitacaoMontarPlacaRN::$TS_FINALIZADA);
                $objPlaca->setSituacaoPlaca(PlacaRN::$STA_AGUARDANDO_MIX);
                $objSolMontarPlaca->setDataHoraFim(date("Y-m-d H:i:s"));
                $objProtocolo = new Protocolo();
                $objProtocoloRN = new ProtocoloRN();
                $objProtocolo->setIdProtocolo($objPlaca->getIdProtocoloFk());
                $objProtocolo = $objProtocoloRN->consultar($objProtocolo);
                $objPlaca->setObjProtocolo($objProtocolo);

                $objPlaca->setObjsAmostras($arr_amostras_escolhidas);
                $objSolMontarPlaca->setObjPlaca($objPlaca);
                $objSolMontarPlaca = $objSolMontarPlacaRN->alterar($objSolMontarPlaca);
                $alert = Alert::alert_success("Dados cadastrados com sucesso");
                $sumir_btn_salvar = 's';
                $aparecer_btn_mapa = 's';
            }

            //InterfacePagina::montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, ' disabled ', '');
        }

    }




} catch (Throwable $ex) {
    //die($ex);
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Solicitar Montagem Placa RTqPCR");
Pagina::getInstance()->adicionar_css("precadastros");
?>
<script type="text/javascript">
    function remover(idAmostra,idTubo){

        var sinalizador = document.getElementById('hdnAmostra'+idAmostra).value;
        if(sinalizador == 'S'){
            document.getElementById('hdnAmostra'+idAmostra).value = 'N';
            document.getElementById('btnAmostra'+idAmostra).innerHTML = '<i class="fas fa-plus"></i> Adicionar na placa';
            if (document.getElementById('heading_'+idTubo).classList.contains("sucesso_rgba")) {
                document.getElementById('heading_'+idTubo).classList.remove("sucesso_rgba");
                document.getElementById('heading_'+idTubo).classList.add("error_rgba");
            }

        }else {
            document.getElementById('hdnAmostra'+idAmostra).value = 'S';
            document.getElementById('btnAmostra'+idAmostra).innerHTML = ' <i class="fas fa-minus"></i> Remover da placa';

            if (document.getElementById('heading_'+idTubo).classList.contains("error_rgba")) {
                document.getElementById('heading_'+idTubo).classList.remove("error_rgba");
                document.getElementById('heading_'+idTubo).classList.add("sucesso_rgba");
            }
        }
    }

</script>

<?php
if($sumir_btn_salvar == 's') {
    Pagina::getInstance()->adicionar_javascript("popUp");
}
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();

if(isset($_GET['idTipoSolicitacao'])){
    if($_GET['idTipoSolicitacao'] == Tipo::$TIPO_MANUAL) { $txtTipoSolicitacao = " - " . Tipo::mostrar_descricao_tipo(Tipo::$TIPO_MANUAL);}
    if($_GET['idTipoSolicitacao'] == Tipo::$TIPO_HIBRIDO) { $txtTipoSolicitacao = " - " .Tipo::mostrar_descricao_tipo(Tipo::$TIPO_HIBRIDO);}
    if($_GET['idTipoSolicitacao'] == Tipo::$TIPO_AUTOMATICO) { $txtTipoSolicitacao = " - " .Tipo::mostrar_descricao_tipo(Tipo::$TIPO_AUTOMATICO);}
}

Pagina::montar_topo_listar("SOLICITAR MONTAGEM PLACA RTqPCR ".$txtTipoSolicitacao,null,null,"listar_solicitacao_montagem_placa_RTqPCR","LISTAR SOLICITAÇÕES");
Pagina::getInstance()->mostrar_excecoes();
echo $alert;
echo '<!-- Modal -->
    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="text-align: center">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                    Deseja fazer nova solicitação de montagem? </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-footer">
                    <!--<button type="button"  class="btn btn-primary">
                    <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=mostrar_poco&idSolicitacao'.$objSolMontarPlaca->getIdSolicitacaoMontarPlaca().'&idPlaca=' . $objPlaca->getIdPlaca()) . '">Mostrar poço</a></button> -->
                    <button type="button"  class="btn btn-primary">
                    <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=solicitar_montagem_placa_RTqPCR') . '">Sim</a></button>
                </div>
            </div>
        </div>
    </div>';


if(!isset($_GET['idTipoSolicitacao']) && !isset($_GET['idPlaca']) && !isset($_GET['idSolicitacao'])){
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
                  <div class="col-md-4" >
                        <a  class="btn btn-primary" STYLE="margin-left:0px;width:100%;margin-top: 17px;font-size: 20px;" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=solicitar_montagem_placa_RTqPCR&idTipoSolicitacao=1').'"><i style="color:white;" class="fas fa-cogs fa-3x"></i><br>ESCOLHA MANUAL</a>
                        <!--<button class="btn btn-primary" style="margin-left:0px;margin-top: 31px;width: 100%;" type="submit"  name="btn_manual">ESCOLHA MANUAL</button>-->
                  </div>
                   <div class="col-md-4" >
                        <a  class="btn btn-primary" STYLE="margin-left:0px;width:100%;margin-top: 17px;font-size: 20px;" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=solicitar_montagem_placa_RTqPCR&idTipoSolicitacao=2').'"><i style="color:white;" class="fas fa-cogs fa-3x"></i>      <i  style="color:white;" class="fas fa-laptop-code fa-3x"></i><br>ESCOLHA HÍBRIDA</a>
                        <!--<button class="btn btn-primary" style="margin-left:0px;margin-top: 31px;width: 100%;" type="submit"  name="btn_automatico">ESCOLHA AUTOMÁTICA</button>-->
                  </div>
                  <div class="col-md-4" >
                        <a  class="btn btn-primary" STYLE="margin-left:0px;width:100%;margin-top: 17px;font-size: 20px;" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=solicitar_montagem_placa_RTqPCR&idTipoSolicitacao=3').'"><i  style="color:white;" class="fas fa-laptop-code fa-3x"></i><br>ESCOLHA AUTOMÁTICA</a>
                        <!--<button class="btn btn-primary" style="margin-left:0px;margin-top: 31px;width: 100%;" type="submit"  name="btn_automatico">ESCOLHA AUTOMÁTICA</button>-->
                  </div>
             </div>
             </form>
        </div>
                    ';
}

if(isset($_GET['idTipoSolicitacao']) || isset($_GET['idSolicitacao'])){
     echo '
    <div class="conteudo_grande" style="margin-top: -15px;">
    <form method="POST">
        <div class="form-row">';
          if($adicionar_qntMaxAmostras == 'n'){
             echo '<div class="col-md-12">';
          }else{
              echo '<div class="col-md-8">';
          }
          echo '<label >Selecione o protocolo:</label>'
                    .$select_protocolos;
          echo'</div>';
            if($adicionar_qntMaxAmostras == 's'){
                echo '<div class="col-md-4">';
                echo '<label >Número máximo de amostras:</label>
                        <input type="number" disabled class="form-control" id="idNumMax" placeholder="nº" 
                       onblur="" name="numMaxAmostras"  value="'.Pagina::formatar_html($objProtocolo->getNumMaxAmostras()).'">';
                echo '</div>';
            }

          echo'</div>  
    </form>';

            /*if($aparecer_btn_mapa == 's'){
                if(Sessao::getInstance()->verificar_permissao('mostrar_poco')) {
                    echo '<div class="form-row" >
                        <div class="col-md-12">
                            <a target="_blank" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=mostrar_poco&idPlaca=' . $objPlaca->getIdPlaca()) . '" class="btn btn-primary"  style="width: 100%; text-align: center;">MOSTRAR POÇO</a>
                        </div>
                    </div>';
                }
            }*/


    if($adicionar_qntMaxAmostras == 's') {
        echo '<form method="POST"  >
                <div class="form-row" >
                
                    <div class="col-md-12">
                        <input type="text" class="form-control" hidden id="idDataHoraLogin"  style="text-align: center;"
                               name="dtHoraLoginInicio" required value="' . $_SESSION['DATA_LOGIN'] . '">
                    </div>
                </div>
                    <div class="form-row">';
        if ($objProtocolo->getCaractere() == ProtocoloRN::$TP_LACEN_IBMP || $btn_selecionar_sumir == 's') {
            echo '<div class="col-md-4">';
        } else {
            echo '<div class="col-md-4">';
        }

        echo '<label >Nome placa (opcional):</label>
                <input type="text" ' . $disabled . ' class="form-control" id="idTextPlaca" placeholder="nome" 
               onblur="" name="txtNomePlaca"  value="' . Pagina::formatar_html($objPlaca->getPlaca()) . '">
               </div>';

        if ($btn_selecionar_sumir == 's' || $_GET['idTipoSolicitacao'] == Tipo::$TIPO_MANUAL || $_GET['idTipoSolicitacao'] == Tipo::$TIPO_HIBRIDO ) {
            echo '<div class="col-md-8">';
        } else {
            echo '<div class="col-md-6">';
        }
        echo '<label for="label_nome">Selecione o(s) perfil(s):</label>' .
            $select_perfis . '
                                                 
                    </div>';
        echo $input_hidden;

        if($_GET['idTipoSolicitacao'] == Tipo::$TIPO_MANUAL || $_GET['idTipoSolicitacao'] == Tipo::$TIPO_HIBRIDO ){
            echo '</div>';
            $col_md = ' col-md-10';
            if($btn_qnt_sumir == 's') {
                $col_md = ' col-md-12';
            }
            echo '<div class="form-row">
                    <div class="'.$col_md.'">
                    <label >Nº de amostras que serão inseridas:</label>
                <input type="number" ' . $disabled . ' class="form-control"  placeholder="nº" 
               onblur="" name="numAmostrasManuais"  value="' . $_POST['numAmostrasManuais']. '">
               </div>';

            if($btn_qnt_sumir == 'n') {

                echo '<div class="col-md-2" >
                    <!--<button type="button" onclick="this.form.submit()" class="btn btn-primary" style="margin-left:0px;margin-top: 31px;width: 100%;"   name="enviar_perfis">SELECIONAR</button>-->
                    <input type="submit" class="btn btn-primary" style="margin-left:0px;margin-top: 31px;width: 100%;"   name="btn_quantidade" value="SELECIONAR"></input>
                </div>';

            }
            echo '</div>';
            echo $lista;

            if($btn_selecionar_sumir == 'n'){
                echo '<div class="form-row">
                        <div class="col-md-12" >
                            <!--<button type="button" onclick="this.form.submit()" class="btn btn-primary" style="margin-left:0px;margin-top: 31px;width: 100%;"   name="enviar_perfis">SELECIONAR</button>-->
                            <input type="submit" class="btn btn-primary" style="margin-left:35%;width: 30%;"   name="enviar_perfis" value="SELECIONAR"></input>
                        </div>
                        </div>';
            }
        }

        if($_GET['idTipoSolicitacao'] == Tipo::$TIPO_AUTOMATICO) {
            if ($btn_selecionar_sumir == 'n') {
                echo '<div class="col-md-2" >
                    <!--<button type="button" onclick="this.form.submit()" class="btn btn-primary" style="margin-left:0px;margin-top: 31px;width: 100%;"   name="enviar_perfis">SELECIONAR</button>-->
                    <button type="submit" class="btn btn-primary" style="margin-left:0px;margin-top: 31px;width: 100%;"   name="enviar_perfis">SELECIONAR</button>
                </div>';
            }
        }
        echo '</div>';

        if ($sumir_btn_salvar == 'n' && isset($_GET['idSolicitacao'])) {
            echo ' <div class="form-row">
                    <div class="col-md-6">
                        <button class="btn btn-primary" style="margin-left:0px;margin-top: 31px;width: 100%;" type="submit"  name="salvar_placa">SALVAR</button>
                    </div>
                <div class="col-md-6">
                     <button type="submit" class="btn btn-primary" style="margin-left:0px;margin-top: 31px;margin-left:0%;width: 100%;color:white;text-decoration: none;" 
                        name="btn_cancelar" > Cancelar</button>
                </div>
               
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
                                <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=solicitar_montagem_placa_RTqPCR') . '">Tenho certeza</a></button>
                            </div>
                        </div>
                    </div>
                </div>
    
                
            </div>';
        }


        if ($btn_selecionar_sumir == 's') {
            echo '<div class="form-row">
                    <div class="col-md-12" >
                    ' . $collapse . '
                    </div>
                   </div>';
        }

        echo '    </form>
           </div>';
    }
}

Pagina::getInstance()->fechar_corpo();

