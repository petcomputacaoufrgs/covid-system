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

    require_once __DIR__ . '/../../classes/Usuario/Usuario.php';
    require_once __DIR__ . '/../../classes/Usuario/UsuarioRN.php';

    require_once __DIR__ . '/../../classes/Paciente/Paciente.php';
    require_once __DIR__ . '/../../classes/Paciente/PacienteRN.php';

    require_once __DIR__ . '/../../classes/Sexo/Sexo.php';
    require_once __DIR__ . '/../../classes/Sexo/SexoRN.php';

    require_once __DIR__ . '/../../classes/Amostra/Amostra.php';
    require_once __DIR__ . '/../../classes/Amostra/AmostraRN.php';

    require_once __DIR__ . '/../../classes/EstadoOrigem/EstadoOrigem.php';
    require_once __DIR__ . '/../../classes/EstadoOrigem/EstadoOrigemRN.php';

    require_once __DIR__ . '/../../classes/LugarOrigem/LugarOrigem.php';
    require_once __DIR__ . '/../../classes/LugarOrigem/LugarOrigemRN.php';

    require_once __DIR__ . '/../../classes/CodigoGAL/CodigoGAL.php';
    require_once __DIR__ . '/../../classes/CodigoGAL/CodigoGAL_RN.php';

    require_once __DIR__ . '/../../utils/Utils.php';
    require_once __DIR__ . '/../../utils/Alert.php';

    require_once __DIR__ . '/../../classes/Tubo/Tubo.php';
    require_once __DIR__ . '/../../classes/Tubo/TuboRN.php';

    require_once __DIR__ . '/../../classes/InfosTubo/InfosTubo.php';
    require_once __DIR__ . '/../../classes/InfosTubo/InfosTuboRN.php';

    require_once __DIR__ . '/../../classes/Etnia/Etnia.php';
    require_once __DIR__ . '/../../classes/Etnia/EtniaRN.php';

    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPaciente.php';
    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPacienteRN.php';

    require_once __DIR__ . '/../../classes/Tubo/Tubo.php';
    require_once __DIR__ . '/../../classes/Tubo/TuboRN.php';

    require_once __DIR__ . '/../../classes/InfosTubo/InfosTubo.php';
    require_once __DIR__ . '/../../classes/InfosTubo/InfosTuboRN.php';

    require_once __DIR__ . '/../../classes/Amostra/Amostra.php';
    require_once __DIR__ . '/../../classes/Amostra/AmostraRN.php';

    require_once __DIR__.'/../../classes/Laudo/Laudo.php';
    require_once __DIR__.'/../../classes/Laudo/LaudoRN.php';
    require_once __DIR__.'/../../classes/Laudo/LaudoINT.php';

    require_once __DIR__.'/../../classes/KitExtracao/KitExtracaoINT.php';
    require_once __DIR__.'/../../classes/KitExtracao/KitExtracao.php';
    require_once __DIR__.'/../../classes/KitExtracao/KitExtracaoRN.php';

    require_once __DIR__.'/../../classes/Protocolo/ProtocoloINT.php';
    require_once __DIR__.'/../../classes/Protocolo/Protocolo.php';
    require_once __DIR__.'/../../classes/Protocolo/ProtocoloRN.php';

    require_once __DIR__ . '/../../classes/LaudoKitExtracao/LaudoKitExtracao.php';
    require_once __DIR__ . '/../../classes/LaudoKitExtracao/LaudoKitExtracaoRN.php';

    require_once __DIR__ . '/../../classes/LaudoProtocolo/LaudoProtocolo.php';
    require_once __DIR__ . '/../../classes/LaudoProtocolo/LaudoProtocoloRN.php';

    $utils = new Utils();
    Sessao::getInstance()->validar();
    date_default_timezone_set('America/Sao_Paulo');
    $_SESSION['DATA_LOGIN']  = date('Y-m-d  H:i:s');

    /* USUÁRIO */
    $objUsuario = new Usuario();
    $objUsuario->setMatricula(Sessao::getInstance()->getMatricula());
    $objUsuarioRN = new UsuarioRN();

    /* AMOSTRA */
    $objAmostra = new Amostra();
    $objAmostraRN = new AmostraRN();

    /* TUBO */
    $objTubo = new Tubo();
    $objTuboRN = new TuboRN();


    /* INFOS TUBO */
    $objInfosTubo = new InfosTubo();
    $objInfosTuboRN = new InfosTuboRN();

    /* PACIENTE */
    $objPaciente = new Paciente();
    $objPacienteRN = new PacienteRN();

    /* PERFIL PACIENTE */
    $objPerfilPaciente = new PerfilPaciente();
    $objPerfilPacienteRN = new PerfilPacienteRN();


    /* ESTADO ORIGEM */
    $objEstadoOrigem = new EstadoOrigem();
    $objEstadoOrigemRN = new EstadoOrigemRN();

    /* LUGAR ORIGEM */
    $objLugarOrigem = new LugarOrigem();
    $objLugarOrigemRN = new LugarOrigemRN();

    /* CÓDIGO GAL */
    $objCodigoGAL = new CodigoGAL();
    $objCodigoGAL_RN = new CodigoGAL_RN();

    /* ETNIA */
    $objEtnia = new Etnia();
    $objEtniaRN = new EtniaRN();


    /* SEXO PACIENTE */
    $objSexoPaciente = new Sexo();
    $objSexoPacienteRN = new SexoRN();


    $objLaudo = new Laudo();
    $objLaudoRN = new LaudoRN();

    $objProtocolo = new Protocolo();
    $objProtocoloRN = new ProtocoloRN();

    $objKitExtracao = new KitExtracao();
    $objKitExtracaoRN = new KitExtracaoRN();

    $objLaudoKitExtracao = new LaudoKitExtracao();
    $objLaudoKitExtracaoRN = new LaudoKitExtracaoRN();

    $objLaudoProtocolo = new LaudoProtocolo();
    $objLaudoProtocoloRN = new LaudoProtocoloRN();

    $checkedLaudoFinalizado = '';
    $boolPacienteSUS = false;
    $boolSRAG = false;

    $checkedDevolver = '';
    $checkedDescartar = '';
    $disabledCheckDevolver = ' ';
    $disabledLaudoFinalizado = ' ';
    $disabledCheckDescarte = ' ';
    $selectedPositivo = '';
    $selectedNegativo = '';
    $selectedInconclusivo = '';
    $finalizarLaudo = true;
    $infos_amostra = '';
    $liberar_infos_amostra = false;
    $str_codigoGAL = '';
    $str_estado_sigla_amostra = '';
    $str_municipio_amostra = '';
    $select_resultado_laudo = '';
    $checkboxes_kit_extracao ='';
    $checkboxes_protocolo ='';
    $arr_laudo_protocolo = array();
    $arr_laudo_kitExtracao = array();


    if(isset($_GET['idLaudo'])) {

        $objLaudo->setIdLaudo($_GET['idLaudo']);
        $arr_laudo = $objLaudoRN->listar($objLaudo);

        $objLaudo = $arr_laudo[0];
        if ($objLaudo->getSituacao() == LaudoRN::$SL_CONCLUIDO) {
            $checkedLaudoFinalizado = ' checked ';
        }

        $objLaudoKitExtracao->setIdLaudoFk($_GET['idLaudo']);
        $arr_kits = $objLaudoKitExtracaoRN->listar($objLaudoKitExtracao);
        //print_r($arr_kits);
        $objLaudoProtocolo->setIdLaudoFk($_GET['idLaudo']);
        $arr_protocolos = $objLaudoProtocoloRN->listar($objLaudoProtocolo);


        ProtocoloINT::montar_checkboxes_protocolo($checkboxes_protocolo, $objProtocolo, $objProtocoloRN, $arr_protocolos,null);
        KitExtracaoINT::montar_checkboxes_kitsExtracao($checkboxes_kit_extracao, $objKitExtracao, $objKitExtracaoRN, $arr_kits,null, null);

        LaudoINT::montar_select_resultado($select_resultado_laudo,$objLaudo, null , null);

        $col_md = 'col-md-12';
        $objCodigoGAL = $objLaudo->getObjAmostra()->getObjPaciente()->getObjCodGAL();
        if ($objCodigoGAL != null) {
            $col_md = 'col-md-8';
        }
        $objAmostra = $objLaudo->getObjAmostra();
        $objPerfilPaciente = $objLaudo->getObjAmostra()->getObjPerfil();
        $objPaciente = $objLaudo->getObjAmostra()->getObjPaciente();

        if ($objAmostra->getMotivoExame() == 'Investigação Sindrome Respitatória Aguda Grave Associada ao Coronavírus (SARS - CoV)') {
            $checkedDevolver = ' checked ';
            $disabledCheckDevolver = ' disabled ';
        }

        //$objPaciente->setNome($objLaudo->getObjAmostra()->getObjPaciente()->getNome());
        //$objAmostra->setNickname($objLaudo->getObjAmostra()->getNickname());
        //$objAmostra->setDataColeta($objLaudo->getObjAmostra()->getDataColeta());
        //$objPerfilPaciente->setPerfil($objLaudo->getObjAmostra()->getObjPerfil());


        if ($objAmostra->getIdPerfilPaciente_fk() == $objPerfilPaciente->getIdPerfilPaciente()
            && $objPerfilPaciente->getCaractere() == PerfilPacienteRN::$TP_PACIENTES_SUS) {
            $boolPacienteSUS = true;
        }

        $objTubo->setIdAmostra_fk($objAmostra->getIdAmostra());
        $arr_tubos = $objTuboRN->listar_completo($objTubo, null, true);


        if (isset($_POST['salvar_laudo'])) {

            $arr_protocolos = $objProtocoloRN->listar(new Protocolo());
            foreach ($arr_protocolos as $protocolo){
                if(isset( $_POST['protocolo_'.$protocolo->getIdProtocolo()])) {
                    $arr_laudo_protocolo[] = $protocolo->getIdProtocolo();
                }
            }

            $arr_kits_extracao = $objKitExtracaoRN->listar(new KitExtracao());
            foreach ($arr_kits_extracao as $kitExtracao){
                if(isset( $_POST['kitExtracao_'.$kitExtracao->getIdKitExtracao()])) {
                    $arr_laudo_kitExtracao[] = $kitExtracao->getIdKitExtracao();
                }
            }

            $objLaudo->setArrProtocolos($arr_laudo_protocolo);
            $objLaudo->setArrKitsExtracao($arr_laudo_kitExtracao);
            $objLaudo->setResultado($_POST['sel_resultado_laudo']);
            LaudoINT::montar_select_resultado($select_resultado_laudo,$objLaudo, null , null);
            $objLaudo->setObservacoes($_POST['txtAreaObsLaudo']);
            if(isset($_POST['radioLocal'])) {
                $radioButton = $_POST['radioLocal'];
                if ($radioButton == 'devolver') {
                    $objLaudo->setDescarteDevolver(LaudoRN::$DD_DEVOLVER);
                } else if ($radioButton == 'descartar') {
                    $objLaudo->setDescarteDevolver(LaudoRN::$DD_DESCARTE);
                }
            }

            //if (isset($_POST['laudoEntregue'])) {
                $objLaudo->setDataHoraLiberacao(date("Y-m-d H:i:s"));
                $objLaudo->setSituacao(LaudoRN::$SL_CONCLUIDO);

                foreach ($arr_tubos as $amostra) {
                    $tubo = $amostra->getObjTubo();
                    $tam = count($tubo->getObjInfosTubo());
                    $objInfosTubo = $tubo->getObjInfosTubo()[$tam - 1];
                    $objInfosTuboCadastro = $objInfosTubo;
                    $objInfosTuboCadastro->setIdInfosTubo(null);
                    $objInfosTuboCadastro->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                    $objInfosTuboCadastro->setDataHora(date("Y-m-d H:i:s"));
                    $objInfosTuboCadastro->setEtapa(InfosTuboRN::$TP_LAUDO);
                    $objInfosTuboCadastro->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);

                    if ($arr_tubos[0]->getObjTubo()->getTuboOriginal() == 's') {
                        if (strtoupper(Utils::getInstance()->tirarAcentos($arr_tubos[0]->getObservacoes())) == strtoupper(Utils::getInstance()->tirarAcentos('Investigação Sindrome Respitatória Aguda Grave Associada ao Coronavírus (SARS - CoV)'))) {
                            $boolSRAG = true;
                        }
                    }

                    if ($tubo->getTipo() == TuboRN::$TT_RNA
                        && $objInfosTubo->getSituacaoTubo() == InfosTuboRN::$TST_AGUARDANDO_BANCO_RNA) {
                        if ($objLaudo->getSituacao() == LaudoRN::$RL_POSITIVO) {
                            $objInfosTuboCadastro->setSituacaoTubo(LaudoRN::mostrarDescricaoResultado(LaudoRN::$RL_POSITIVO) . " - banco-RNA");
                        }
                        if ($objLaudo->getSituacao() == LaudoRN::$RL_NEGATIVO) {
                            $objInfosTuboCadastro->setSituacaoTubo(LaudoRN::mostrarDescricaoResultado(LaudoRN::$RL_NEGATIVO) . " - banco-RNA");
                        }
                        if ($objLaudo->getSituacao() == LaudoRN::$RL_INCONCLUSIVO) {
                            $objInfosTuboCadastro->setSituacaoTubo(LaudoRN::mostrarDescricaoResultado(LaudoRN::$RL_INCONCLUSIVO) . " - banco-RNA");
                        }
                        $arr_infos[] = $objInfosTuboCadastro;
                    } else if ($tubo->getTipo() != TuboRN::$TT_RNA
                        && $objInfosTubo->getSituacaoTubo() == InfosTuboRN::$TST_AGUARDANDO_BANCO_AMOSTRAS) {
                        if ($objLaudo->getSituacao() == LaudoRN::$RL_INCONCLUSIVO) {
                            $objInfosTuboCadastro->setSituacaoTubo(LaudoRN::mostrarDescricaoResultado(LaudoRN::$RL_INCONCLUSIVO) . " - banco");
                            $arr_infos[] = $objInfosTuboCadastro;
                        } else {

                            if ($boolPacienteSUS) {
                                if ($objLaudo->getSituacao() == LaudoRN::$RL_POSITIVO) {
                                    $objInfosTuboCadastro->setSituacaoTubo(LaudoRN::mostrarDescricaoResultado(LaudoRN::$RL_POSITIVO) . " - enviar LACEN");
                                }
                                if ($objLaudo->getSituacao() == LaudoRN::$RL_NEGATIVO && $boolSRAG) {
                                    $objInfosTuboCadastro->setSituacaoTubo(LaudoRN::mostrarDescricaoResultado(LaudoRN::$RL_NEGATIVO) . " - enviar LACEN");
                                } else if ($objLaudo->getSituacao() == LaudoRN::$RL_NEGATIVO && !$boolSRAG) {
                                    $radioButton = $_POST['radioLocal'];
                                    if ($radioButton == 'devolver') {
                                        $objInfosTuboCadastro->setSituacaoTubo(LaudoRN::mostrarDescricaoResultado(LaudoRN::$RL_NEGATIVO) . " - enviar LACEN");
                                        $objLaudo->setDescarteDevolver(LaudoRN::$DD_DEVOLVER);
                                    } else if ($radioButton == 'descartar') {
                                        $objInfosTuboCadastro->setSituacaoTubo(InfosTuboRN::$TST_DESCARTADO);
                                        $objLaudo->setDescarteDevolver(LaudoRN::$DD_DESCARTE);
                                    }
                                }
                                $arr_infos[] = $objInfosTuboCadastro;
                            } else { //não é paciente SUS
                                if ($objLaudo->getSituacao() == LaudoRN::$RL_POSITIVO) {
                                    $objInfosTuboCadastro->setSituacaoTubo(LaudoRN::mostrarDescricaoResultado(LaudoRN::$RL_POSITIVO) . "- banco");
                                }
                                if ($objLaudo->getSituacao() == LaudoRN::$RL_NEGATIVO) {
                                    $objInfosTuboCadastro->setSituacaoTubo(InfosTuboRN::$TST_DESCARTADO);
                                }

                                $arr_infos[] = $objInfosTuboCadastro;
                            }
                        }
                    }

                }

                $objLaudo->setObjInfosTubo($arr_infos);

                $objLaudo = $objLaudoRN->alterar($objLaudo);

                $checkedLaudoFinalizado = ' checked ';
                $alert .= Alert::alert_success("Laudo alterado com sucesso");



           /* if (!isset($_POST['laudoEntregue'])) {
                $objLaudo->setDataHoraLiberacao(null);
                $objLaudo->setSituacao(LaudoRN::$SL_PENDENTE);
                $objLaudo = $objLaudoRN->alterar($objLaudo);
                $checked = '  ';
                $alert .= Alert::alert_success("Laudo alterado com sucesso");

            }*/
        }

        $objLaudoKitExtracao->setIdLaudoFk($_GET['idLaudo']);
        $arr_kits = $objLaudoKitExtracaoRN->listar($objLaudoKitExtracao);
        //print_r($arr_kits);
        $objLaudoProtocolo->setIdLaudoFk($_GET['idLaudo']);
        $arr_protocolos = $objLaudoProtocoloRN->listar($objLaudoProtocolo);


        ProtocoloINT::montar_checkboxes_protocolo($checkboxes_protocolo, $objProtocolo, $objProtocoloRN, $arr_protocolos,null);
        KitExtracaoINT::montar_checkboxes_kitsExtracao($checkboxes_kit_extracao, $objKitExtracao, $objKitExtracaoRN, $arr_kits,null, null);
    }
    else{
        //caso de cadastrar um laudo sem a amostra ter passado por nenhuma etapa do sistema ou do nada resolver fazer o laudo


        if(isset($_POST['btn_obter_infos'])){
            $objAmostra->setNickname(strtoupper($_POST['txtNicknameAmostra']));
            $amostra = $objAmostraRN->listar_completo($objAmostra);
            //print_r($amostra[0]);
            if(count($amostra) > 0) {
                $objAmostra = $amostra[0];

                //ver se já nao tem amostra com laudo
                $objLaudoAux = new Laudo();
                $objLaudoAux->setIdAmostraFk($objAmostra->getIdAmostra());
                $arr_laudo = $objLaudoRN->listar($objLaudoAux);

                if (count($arr_laudo) == 0) {

                        $liberar_infos_amostra = true;
                        $objPaciente = $amostra[0]->getObjPaciente();
                        if (!is_null($objPaciente->getObjCodGAL())) {
                            $objCodigoGAL = $objPaciente->getObjCodGAL();
                            $str_codigoGAL = $objCodigoGAL->getCodigo();
                        } else {
                            $str_codigoGAL = '';
                        }

                        if (!is_null($objAmostra->getObjMunicipio())) {
                            $str_municipio_amostra = $objAmostra->getObjMunicipio()->getNome();
                        } else {
                            $str_municipio_amostra = '';
                        }

                        if (!is_null($objAmostra->getObjEstado())) {
                            $str_estado_sigla_amostra = $objAmostra->getObjEstado()->getSigla();
                        } else {
                            $str_estado_sigla_amostra = '';
                        }

                        ProtocoloINT::montar_checkboxes_protocolo($checkboxes_protocolo, $objProtocolo, $objProtocoloRN, null,null);
                        KitExtracaoINT::montar_checkboxes_kitsExtracao($checkboxes_kit_extracao, $objKitExtracao, $objKitExtracaoRN, null,null, null);

                        $infos_amostra .= '<div class="form-row">        
                                         <div class="col-md-10">
                                                <label>Nome do paciente: </label>
                                                 <input type="text" disabled class="form-control"  placeholder="" 
                                                 onblur=""   value="' . Pagina::formatar_html($objPaciente->getNome()) . '"> 
                                         </div>
                                          <div class="col-md-2">
                                                <label>Data nascimento: </label>
                                                 <input type="text" disabled class="form-control"  placeholder="" 
                                                 onblur=""   value="' . Pagina::formatar_html(Utils::getStrData($objPaciente->getDataNascimento())) . '"> 
                                         </div>
                                      </div>
                                       <div class="form-row">        
                                         <div class="col-md-4">
                                                <label>CPF do paciente: </label>
                                                 <input type="text" disabled class="form-control"  placeholder="" 
                                                 onblur=""   value="' . Pagina::formatar_html($objPaciente->getCPF()) . '"> 
                                         </div>
                                          <div class="col-md-4">
                                                <label>RG do paciente: </label>
                                                 <input type="text" disabled class="form-control"  placeholder="" 
                                                 onblur=""   value="' . Pagina::formatar_html($objPaciente->getRG()) . '"> 
                                         </div>

                                         <div class="col-md-4">
                                                <label>Código GAL: </label>
                                                 <input type="text" disabled class="form-control"  placeholder="" 
                                                 onblur=""   value="' . Pagina::formatar_html($str_codigoGAL) . '"> 
                                         </div>               
                                        </div>
                                       <div class="form-row">        
                                         <div class="col-md-4">
                                                <label>Data de coleta da amostra: </label>
                                                 <input type="text" disabled class="form-control"  placeholder="" 
                                                 onblur=""   value="' . Pagina::formatar_html($objAmostra->getDataColeta()) . '"> 
                                         </div>
                                         <div class="col-md-4">
                                                <label>Estado da coleta: </label>
                                                 <input type="text" disabled class="form-control"  placeholder="" 
                                                 onblur=""   value="' . Pagina::formatar_html($str_estado_sigla_amostra) . '"> 
                                         </div>
                                          <div class="col-md-4">
                                                <label>Município da coleta: </label>
                                                 <input type="text" disabled class="form-control"  placeholder="" 
                                                 onblur=""   value="' . Pagina::formatar_html($str_municipio_amostra) . '"> 
                                         </div>
                                        
                                      </div>
                                       <div class="form-row">        
                                         <div class="col-md-12">
                                                <label>Motivo: </label>
                                                 <input type="text" disabled class="form-control"  placeholder="" 
                                                 onblur=""   value="' . Pagina::formatar_html($objAmostra->getMotivoExame()) . '"> 
                                         </div>
                                        
                                      </div>
                                       <div class="form-row">        
                                         <div class="col-md-12">
                                                <label>Observações amostra: </label>
                                                <textarea name="txtAreaObsAmostra" disabled rows="2" cols="100" class="form-control" rows="3">' . Pagina::formatar_html($objAmostra->getObservacoes()) . '</textarea>
                                                
                                         </div>
                                         </div>
                                       <div class="form-row">     
                                                 <div class="col-md-12">
                                                    <label> Resultado do laudo </label>
                                                     <select class="form-control" name="select_resultadoLaudo">
                                                      <option  value="-1">Selecione o resultado do laudo</option>
                                                      <option ' . $selectedPositivo . ' value="P">DETECTADO</option>
                                                      <option ' . $selectedNegativo . ' value="N">NÃO-DETECTADO</option>
                                                      <option ' . $selectedInconclusivo . ' value="I">INCONCLUSIVO</option>
                                                    </select> 
                                                 </div>
                            
                                            </div>     
                                       <div class="form-row">     
                                        <div class="col-md-12">
                                            <label> Selecione os kits de extração utilizados </label><br>
                                            <div style="border: 1px solid #ddd; padding: 10px;">
                                            ' . $checkboxes_kit_extracao . '
                                            </div>
                                        </div>                   
                                    </div>
                                       <div class="form-row">     
                                        <div class="col-md-12">
                                            <label> Selecione os protocolos utilizados </label><br>
                                            <div style="border: 1px solid #ddd; padding: 10px;">
                                            ' . $checkboxes_protocolo . '
                                            </div>
                                        </div>                   
                                    </div>
                                       <div class="form-row">     
                                     <div class="col-md-12">
                                        <label>Observações laudo: </label>
                                         <textarea name="txtAreaObsLaudo" rows="2" cols="100" class="form-control" rows="3">' . Pagina::formatar_html($objLaudo->getObservacoes()) . '</textarea>
                                 </div>
                                 
                              </div>';

                } else {
                    $alert .= Alert::alert_info('Essa amostra já tem um laudo associado a ela. Clique <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastro_laudo&idLaudo=' . $arr_laudo[0]->getIdLaudo()) . '">aqui</a>');
                }
            }else{
                $alert .= Alert::alert_warning("Nenhuma amostra foi encontrada com esse código");
            }


        }

        if (isset($_POST['salvar_laudo'])) {



            $arr_protocolos = $objProtocoloRN->listar(new Protocolo());
            foreach ($arr_protocolos as $protocolo){
                if(isset( $_POST['protocolo_'.$protocolo->getIdProtocolo()])) {
                    $arr_laudo_protocolo[] = $protocolo->getIdProtocolo();
                }
            }

            $arr_kits_extracao = $objKitExtracaoRN->listar(new KitExtracao());
            foreach ($arr_kits_extracao as $kitExtracao){
                if(isset( $_POST['kitExtracao_'.$kitExtracao->getIdKitExtracao()])) {
                    $arr_laudo_kitExtracao[] = $kitExtracao->getIdKitExtracao();
                }
            }

           // print_r($arr_laudo_kitExtracao);
           // print_r($arr_laudo_protocolo);

            $objLaudo->setArrProtocolos($arr_laudo_protocolo);
            $objLaudo->setArrKitsExtracao($arr_laudo_kitExtracao);
            $objLaudo->setDataHoraLiberacao(null);

            $objLaudo->setDataHoraLiberacao(date("Y-m-d H:i:s"));
            $objLaudo->setSituacao(LaudoRN::$SL_CONCLUIDO);


            $objLaudo->setObservacoes($_POST['txtAreaObsLaudo']);
            $objLaudo->setDataHoraGeracao($_POST['dtHrInicio']);
            $objLaudo->setResultado($_POST['select_resultadoLaudo']);
            if($objLaudo->getResultado() == LaudoRN::$RL_POSITIVO)$selectedPositivo = ' selected ';
            if($objLaudo->getResultado() == LaudoRN::$RL_NEGATIVO)$selectedNegativo = ' selected ';
            if($objLaudo->getResultado() == LaudoRN::$RL_INCONCLUSIVO) $selectedInconclusivo = ' selected ';

            $objAmostra->setNickname(strtoupper($_POST['txtNicknameAmostra']));

            $arr_amostra = $objAmostraRN->listar_completo($objAmostra);


            if(count($arr_amostra) > 0 ) {
                //ver se já não tem nenhum laudo com essa amostra
                $objLaudoAux = new Laudo();
                $objLaudoAux->setIdAmostraFk($arr_amostra[0]->getIdAmostra());
                $arr_laudo = $objLaudoRN->listar($objLaudoAux);

                if(count($arr_laudo) == 0) {
                    $objLaudo->setIdAmostraFk($arr_amostra[0]->getIdAmostra());
                    $objLaudo->setIdUsuarioFk(Sessao::getInstance()->getIdUsuario());

                    $objInfosTubo = new InfosTubo();
                    $objInfosTubo->setEtapa(InfosTuboRN::$TP_LAUDO);

                    $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                    $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_DESCARTADO);


                    if ($arr_amostra[0]->getNickname()[0] == PerfilPacienteRN::$TP_PACIENTES_SUS) {
                        $radioButton = $_POST['radioLocalAux'];
                        if ($radioButton == 'devolver') {
                            $objInfosTubo->setSituacaoTubo(LaudoRN::mostrarDescricaoResultado($_POST['select_resultadoLaudo']) . " - enviar LACEN");
                            $objLaudo->setDescarteDevolver(LaudoRN::$DD_DEVOLVER);
                        } else if ($radioButton == 'descartar') {
                            $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_DESCARTADO);
                            $objLaudo->setDescarteDevolver(LaudoRN::$DD_DESCARTE);
                        }
                    } else {
                        $disabledCheckDescarte = ' disabled ';
                        $disabledCheckDevolver = ' disabled ';
                        $checkedDevolver = ' checked ';
                    }
                    $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                    $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));

                    if ($arr_amostra[0]->get_a_r_g() == AmostraRN::$STA_AGUARDANDO) {
                        $objTubo = new Tubo();
                        $objTubo->setIdAmostra_fk($arr_amostra[0]->getIdAmostra());
                        $objTubo->setTuboOriginal('s');
                        $objTubo->setTipo(TuboRN::$TT_COLETA);

                        $objInfosTubo->setEtapaAnterior(InfosTuboRN::$TP_RECEPCAO);
                        $objInfosTubo->setReteste('n');
                        $objInfosTubo->setVolume(null);

                        $objTubo->setObjInfosTubo($objInfosTubo);
                        $objTubo = $objTuboRN->cadastrar($objTubo);
                    }
                    else {
                        $objTubo->setIdAmostra_fk($arr_amostra[0]->getIdAmostra());
                        $arr_tubo = $objTuboRN->listar_completo($objTubo, null, true);
                        if (count($arr_tubo) == 1) {

                            foreach ($arr_tubo as $amostra) {
                                $objTuboAux = $amostra->getObjTubo();
                                $objInfosTuboNovo = new InfosTubo();
                                $objInfosTuboNovo->setIdTubo_fk($objTuboAux->getIdTubo());
                                $infoTubo = $objInfosTuboRN->pegar_ultimo($objInfosTuboNovo);


                                $objInfosTuboNovo->setIdInfosTubo(null);
                                $objInfosTuboNovo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                                $objInfosTuboNovo->setIdPosicao_fk($infoTubo->getIdPosicao_fk());
                                $objInfosTuboNovo->setIdLote_fk($infoTubo->getIdLote_fk());
                                $objInfosTuboNovo->setEtapa(InfosTuboRN::$TP_LAUDO);
                                $objInfosTuboNovo->setEtapaAnterior($infoTubo->getEtapa());
                                $objInfosTuboNovo->setDataHora($objInfosTubo->getDataHora());
                                $objInfosTuboNovo->setReteste($infoTubo->getReteste());
                                $objInfosTuboNovo->setVolume($infoTubo->getVolume());
                                $objInfosTuboNovo->setObsProblema($infoTubo->getObsProblema());
                                $objInfosTuboNovo->setObservacoes($infoTubo->getObservacoes());
                                $objInfosTuboNovo->setSituacaoEtapa($objInfosTubo->getSituacaoEtapa());
                                $objInfosTuboNovo->setSituacaoTubo($objInfosTubo->getSituacaoTubo());
                                $objInfosTuboNovo->setIdLocalFk($infoTubo->getIdLocalFk());

                                $arr_infos[] = $objInfosTuboNovo;
                                //$objTuboAux->setObjInfosTubo($objInfosTuboNovo);
                                //$arr_tubos[] = $objTuboAux;

                            }
                            $objLaudo->setObjInfosTubo($arr_infos);
                        }else{
                            $alert .= Alert::alert_danger('A amostra está no meio de uma etapa. Logo, seu laudo não pode ser realizado');
                            $finalizarLaudo = false;
                        }
                    }
                    if($finalizarLaudo) {
                        $objLaudo = $objLaudoRN->cadastrar($objLaudo);
                        header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastro_laudo&idLaudo=' . $objLaudo->getIdLaudo().'&idSituacao=1'));
                        die();
                    }
                }
                else{
                    $alert .= Alert::alert_info('Essa amostra já tem um laudo associado a ela. Clique <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastro_laudo&idLaudo='.$arr_laudo[0]->getIdLaudo()) . '">aqui</a>');
                }
            }else{
                $alert .= Alert::alert_warning('Nenhuma amostra foi encontrada com esse código');
            }



            //$objLaudo->setIdAmostraFk();
        }

    }


    if(isset($_GET['idSituacao']) && $_GET['idSituacao'] == 1){
        $alert .= Alert::alert_success("Laudo cadastrado com sucesso");
    }




}catch (Throwable $ex) {
        Pagina::getInstance()->processar_excecao($ex);
    }

Pagina::abrir_head("Laudo");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar("LAUDO",'cadastro_laudo','NOVO LAUDO',"listar_laudo","LISTAR LAUDOS");
Pagina::getInstance()->mostrar_excecoes();
echo $alert;


if(isset($_GET['idLaudo'])) {
    echo '<div class="conteudo_grande" style="width: 80%;margin-left: 10%;margin-top: -10px;">
            <form method="post" style="width:100%;margin-left:0;">
                <div class="form-row">
                    
                     <div class="' . $col_md . '">
                        <label>Nome do paciente: </label>
                         <input type="text" disabled class="form-control" id="idNome" placeholder="" 
                         onblur=""   value="' . Pagina::formatar_html($objPaciente->getNome()) . '">   
                     </div>';

    if(!is_null($objCodigoGAL)) {
        if ($objCodigoGAL->getCodigo() != null) {
            echo '<div class="col-md-4">
                                <label>Código GAL: </label>
                                 <input type="text" disabled class="form-control" id="idNome" placeholder="" 
                                 onblur=""   value="' . Pagina::formatar_html($objCodigoGAL->getCodigo()) . '">   
                             </div>';
        }
    }
    echo '</div>
                
                <div class="form-row">
                     <div class="col-md-4">
                        <label>Código da Amostra: </label>
                         <input type="text"  disabled class="form-control" id="idCodigoAmostra" placeholder="" 
                         onblur=""   value="' . Pagina::formatar_html($objAmostra->getNickname()) . '">   
                     </div>
                     <div class="col-md-4">
                        <label>Perfil Amostra: </label>
                         <input type="text" disabled class="form-control" id="idNome" placeholder="" 
                         onblur=""  value="' . Pagina::formatar_html($objPerfilPaciente->getPerfil()) . '">   
                     </div>
                     
                     <div class="col-md-4">
                        <label>Data da coleta: </label>
                         <input type="date" disabled class="form-control" id="idNome" placeholder="" 
                         onblur=""  value="' . Pagina::formatar_html($objAmostra->getDataColeta()) . '">   
                     </div>
                     
                </div>
              
                 <div class="form-row">
                     <div class="col-md-12">
                        <label>MOTIVO: </label>
                             <input type="text" disabled class="form-control"  placeholder="" 
                             onblur=""  value="' . Pagina::formatar_html($objAmostra->getMotivoExame()) . '">  
                     </div> 
                </div>
                 <div class="form-row">
                     <div class="col-md-12">
                        <label>RESULTADO DO LAUDO: </label>
                        '.$select_resultado_laudo.'
                             <!--<input type="text" disabled class="form-control" id="idNome" placeholder="" 
                             onblur=""  value="' . Pagina::formatar_html(LaudoRN::mostrarDescricaoResultado($objLaudo->getResultado())) . '">-->  
                     </div> 
                </div>
                <div class="form-row">     
                    <div class="col-md-12">
                        <label> Selecione os kits de extração utilizados </label><br>
                        <div style="border: 1px solid #ddd; padding: 10px;">
                        ' . $checkboxes_kit_extracao . '
                        </div>
                    </div>                   
                </div>
                <div class="form-row">     
                    <div class="col-md-12">
                        <label> Selecione os protocolos utilizados </label><br>
                        <div style="border: 1px solid #ddd; padding: 10px;">
                        ' . $checkboxes_protocolo . '
                        </div>
                    </div>                   
                </div>
                 <div class="form-row">     
                     <div class="col-md-12">
                        <label>Observações laudo: </label>
                         <textarea name="txtAreaObsLaudo" rows="2" cols="100" class="form-control" rows="3">'.Pagina::formatar_html($objLaudo->getObservacoes()).'</textarea>
                 </div>
                 
              </div>';


    //echo '<form method="post" style="width:100%;margin-left:0;">';
    //if ($objLaudo->getResultado() == LaudoRN::$RL_NEGATIVO) {
        /*if ($objLaudo->getSituacao() == LaudoRN::$SL_CONCLUIDO) {
            $disabledCheckDevolver = ' disabled ';
            $disabledLaudoFinalizado = ' disabled ';
            $disabledCheckDescarte = ' disabled ';
        }*/

if($boolPacienteSUS){

        if($objLaudo->getDescarteDevolver() == LaudoRN::$DD_DESCARTE){
            $checkedDescartar = ' checked ';
        }

        if($objLaudo->getDescarteDevolver() == LaudoRN::$DD_DEVOLVER){
            $checkedDevolver = ' checked ';
        }




        echo '<div class="form-row">
        
                                    <div class="col-md-2" style=" margin-left: 0;width: 100%;"> 
                                        <div class="custom-control custom-radio custom-control-inline" style="width: 100%;">
                                          <input type="radio"  ' . $checkedDevolver . $disabledCheckDevolver . ' class="custom-control-input" id="idDevolverAmostra"  name="radioLocal"
                                           value="devolver">
                                          <label class="custom-control-label" for="idDevolverAmostra">Devolver</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">   
                                        <div class="custom-control custom-radio custom-control-inline">
                                          <input type="radio" class="custom-control-input" ' . $checkedDescartar . $disabledCheckDescarte . ' id="idDescartarAmostra" name="radioLocal"
                                          value="descartar">
                                          <label class="custom-control-label" for="idDescartarAmostra">Descartar</label>
                                        </div>
                                    </div>
                                </div>';
   }

    $checkedLaudoFinalizado = '';
    if($objLaudo->getSituacao() == LaudoRN::$SL_CONCLUIDO){
        $checkedLaudoFinalizado = ' checked ';
    }
    echo '<!-- <div class="form-row" >
                                   <div class="col-md-12">   
                                         <div class="custom-control custom-checkbox" style="float: right; ">
                                            <input type="checkbox" ' . $checkedLaudoFinalizado . $disabledLaudoFinalizado . '  class="custom-control-input"  id="idLaudoFinalizado"
                                                   name="laudoEntregue" VALUE="on">
                                            <label class="custom-control-label"  for="idLaudoFinalizado">Laudo finalizado</label>
                                        </div>
                                    </div> 
                               </div>-->
                               <div class="form-row" style="margin-top: 5px;margin-bottom: 0px;">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" style="width: 50%; margin-left: 25%;" type="submit" name="salvar_laudo">SALVAR</button>
                                    </div>
                               </div>
                         </form>
                        </div>';
}
else{
    echo '<div class="conteudo_grande" style="width: 80%;margin-left: 10%;margin-top: -10px;">
            <form method="post" style="width:100%;margin-left:0;">
                <input type="text" class="form-control" hidden id="idDtHrInicio" readonly  style="text-align: center;"
                           name="dtHrInicio"  value="'. Pagina::formatar_html($_SESSION['DATA_LOGIN']).'" >
            
                <div class="form-row">        
                     <div class="col-md-10">
                        <label>Informe o código da amostra: </label>
                         <input type="text"  class="form-control" id="idNome" placeholder="" name="txtNicknameAmostra"
                         onblur=""   value="' . Pagina::formatar_html($objAmostra->getNickname()) . '">   
                     </div>
                     <div class="col-md-2">
                        <button class="btn btn-primary" style="width: 100%; margin-left:0;margin-top: 10px;"type="submit" name="btn_obter_infos">OBTER INFORMAÇÕES</button>
                     </div>
                </div>';

    if($liberar_infos_amostra) {
        echo $infos_amostra;

        if ($objLaudo->getDescarteDevolver() == LaudoRN::$DD_DESCARTE) {
            $checkedDescartar = ' checked ';
        }

        if ($objLaudo->getDescarteDevolver() == LaudoRN::$DD_DEVOLVER) {
            $checkedDevolver = ' checked ';
        }
        echo '<small style="color: red;">Os campos ABAIXO (Devolver e Descartar) só teram importância para amostras cujo perfil é Paciente SUS</small>';
        echo '<div class="form-row">
                                    <div class="col-md-2" style=" margin-left: 0;width: 100%;"> 
                                       <!-- Default inline 1-->
                                        <div class="custom-control custom-radio custom-control-inline" style="width: 100%;">
                                          <input type="radio"  ' . $checkedDevolver . ' class="custom-control-input" id="idDevolverAmostraL"  name="radioLocalAux" value="devolver">
                                          <label class="custom-control-label" for="idDevolverAmostraL">Devolver</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">   
                                        <!-- Default inline 2-->
                                        <div class="custom-control custom-radio custom-control-inline">
                                          <input type="radio" class="custom-control-input" ' . $checkedDescartar . ' id="idDescartarAmostraL" name="radioLocalAux" value="descartar">
                                          <label class="custom-control-label" for="idDescartarAmostraL">Descartar</label>
                                        </div>
                                    </div>
                                </div>';

        echo '<!-- <div class="form-row" >
                                    <div class="col-md-12">   
                                         <div class="custom-control custom-checkbox" style="float: right; ">
                                            <input type="checkbox" ' . $checkedLaudoFinalizado . '  class="custom-control-input"  id="idLaudoFinalizadoAux"
                                                   name="laudoEntregue">
                                            <label class="custom-control-label"  for="idLaudoFinalizadoAux">Laudo finalizado</label>
                                        </div>
                                    </div>
                               </div> -->
                               <div class="form-row" >
                                    <div class="col-md-12">   
                                    <button class="btn btn-primary" style="width: 40%; margin-left:30%;"type="submit" name="salvar_laudo">SALVAR</button>
                            </div>
                            </div>
                      </div>
                            
                        
                        </div>';
    }
       echo '     </form>
         </div>';
}

Pagina::getInstance()->fechar_corpo();