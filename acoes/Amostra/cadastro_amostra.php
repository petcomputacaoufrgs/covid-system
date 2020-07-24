<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();

require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Pagina/InterfacePagina.php';
require_once '../classes/Excecao/Excecao.php';

require_once '../classes/Usuario/Usuario.php';
require_once '../classes/Usuario/UsuarioRN.php';

require_once '../classes/Paciente/Paciente.php';
require_once '../classes/Paciente/PacienteRN.php';

require_once '../classes/PerfilPaciente/PerfilPaciente.php';
require_once '../classes/PerfilPaciente/PerfilPacienteRN.php';

require_once '../classes/Sexo/Sexo.php';
require_once '../classes/Sexo/SexoRN.php';

require_once '../classes/Amostra/Amostra.php';
require_once '../classes/Amostra/AmostraRN.php';

require_once '../classes/EstadoOrigem/EstadoOrigem.php';
require_once '../classes/EstadoOrigem/EstadoOrigemRN.php';

require_once '../classes/LugarOrigem/LugarOrigem.php';
require_once '../classes/LugarOrigem/LugarOrigemRN.php';

require_once '../classes/CodigoGAL/CodigoGAL.php';
require_once '../classes/CodigoGAL/CodigoGAL_RN.php';

require_once '../classes/NivelPrioridade/NivelPrioridade.php';
require_once '../classes/NivelPrioridade/NivelPrioridadeRN.php';

require_once '../classes/Etnia/Etnia.php';
require_once '../classes/Etnia/EtniaRN.php';

require_once '../classes/Tubo/Tubo.php';
require_once '../classes/Tubo/TuboRN.php';

require_once '../classes/InfosTubo/InfosTubo.php';
require_once '../classes/InfosTubo/InfosTuboRN.php';

require_once '../utils/Utils.php';
require_once '../utils/Alert.php';

try {

    Sessao::getInstance()->validar();
    $utils = new Utils();

    date_default_timezone_set('America/Sao_Paulo');
    $_SESSION['DATA_LOGIN'] = date('d/m/Y  H:i:s');

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

    /* NÍVEL DE PRIORIDADE */
    $objNivelPrioridade = new NivelPrioridade();
    $objNivelPrioridadeRN = new NivelPrioridadeRN();

    $onchange = '';
    //$onchange = ' onchange="this.form.submit()" ';
    $alert = '';
    $select_sexos = '';
    $select_estados = '';
    $select_etnias = '';
    $select_municipios = '';
    $select_perfis = '';
    $select_a_r_g = '';
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $disabled = '';
    $read_only = '';
    $cpf_obrigatorio = '';

    $perfil_erro = false;
    $situacao_erro = false;
    $data_erro = false;


    Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, $disabled, $onchange);
    Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, $disabled, $onchange);
    Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra, $disabled, $onchange); //por default RS
    Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra, $disabled, $onchange);
    Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, $disabled, $onchange);
    //Interf::getInstance()->montar_select_niveis_prioridade($select_nivelPrioridade, $objNivelPrioridade, $objNivelPrioridadeRN, $objAmostra);*/




    /* if (isset($_POST['sel_sexo']) && $_POST['sel_sexo'] != null) {
      $objSexoPaciente->setIdSexo($_POST['sel_sexo']);
      $objSexoPaciente = $objSexoPacienteRN->consultar($objSexoPaciente);
      $objPaciente->setIdSexo_fk($objSexoPaciente->getIdSexo());
      montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente);
      } */


    switch ($_GET['action']) {
        case 'cadastrar_amostra':
            $disabled = '';


            if (isset($_POST['salvar_amostra'])) {

                if ($_POST['sel_a_r_g'] == null) {
                    $alert .= Alert::alert_danger("Informe a situação da amostra (aceita/recusada/a caminho)");
                    $situacao_erro = true;
                }
                if (isset($_POST['sel_a_r_g'])) {
                    $objAmostra->set_a_r_g($_POST['sel_a_r_g']);
                    Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, $disabled, $onchange);
                }


                if ($_POST['sel_perfil'] == null) {
                    $alert .= Alert::alert_danger("Informe o perfil da amostra");
                    $perfil_erro = true;
                }

                if (isset($_POST['sel_perfil'])) {
                    $objPerfilPaciente->setIdPerfilPaciente($_POST['sel_perfil']);
                    $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
                    $objAmostra->setIdPerfilPaciente_fk($_POST['sel_perfil']);
                    Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, $disabled, $onchange);
                }

                //Parte da coleta
                $objAmostra->setIdPaciente_fk($objPaciente->getIdPaciente());
                $objAmostra->setDataColeta($_POST['dtColeta']);
                if ($_POST['dtColeta'] == null) {
                    $alert .= Alert::alert_danger("Informe a data de coleta da amostra");
                    $data_erro = true;
                }

                if (isset($_POST['timeColeta']) && $_POST['timeColeta'] != null) {
                    $objAmostra->setHoraColeta($_POST['timeColeta']);
                } else {
                    $objAmostra->setHoraColeta(null);
                }
                $objAmostra->set_a_r_g($_POST['sel_a_r_g']);
               
                $objAmostra->setObservacoes($_POST['txtAreaObs']);

                $objAmostra->setIdEstado_fk(43); //ESTADO DO RS
                $objAmostra->setIdLugarOrigem_fk($_POST['sel_cidades']);
                $objAmostra->setIdNivelPrioridade_fk(null);

                $objAmostra->setMotivoExame($_POST['txtMotivo']);
                $objAmostra->setObsCEP($_POST['txtObsCEPAmostra']);
                $objAmostra->setObsHoraColeta($_POST['txtObsHoraColeta']);
                $objAmostra->setObsLugarOrigem($_POST['txtObsLugarOrigem']);
                $objAmostra->setObsMotivo($_POST['txtObsMotivo']);

                //print_r($objAmostra);
                if (!$data_erro && !$perfil_erro && !$situacao_erro) {
                    $objAmostraRN->cadastrar($objAmostra);
                    $alert .= Alert::alert_success("Amostra CADASTRADA com sucesso");
                    
                    /*
                     * consegue o perfil do paciente, para pegar o caractere específico
                     */
                    $objPerfilPaciente->setIdPerfilPaciente($objAmostra->getIdPerfilPaciente_fk());
                    $arr_perfil = $objPerfilPacienteRN->listar($objPerfilPaciente);
                    
                    $objAmostra->setCodigoAmostra($arr_perfil[0]->getCaractere() . $objAmostra->getIdAmostra());
                    $objAmostraRN->alterar($objAmostra);
                    
                    if($objAmostra->get_a_r_g() == AmostraRN::$STA_ACEITA || $objAmostra->get_a_r_g() ==  AmostraRN::$STA_RECUSADA){
                        /*
                         * Recém está criando a amostra então o tubo não veio de nenhum outro
                         */
                        $objTubo->setIdAmostra_fk($objAmostra->getIdAmostra());
                        $objTubo->setIdTubo_fk(null);
                        $objTubo->setTuboOriginal('s');
                        $objTuboRN->cadastrar($objTubo);
                        $alert .= Alert::alert_success("Tubo CADASTRADO com sucesso");
                        
                        $objInfosTubo->setIdTubo_fk($objTubo->getIdTubo());
                        $objInfosTubo->setEtapa("recepção - finalizada");
                        if($objAmostra->get_a_r_g() == AmostraRN::$STA_ACEITA){
                            $objInfosTubo->setStatusTubo(" Aguardando preparação ");
                        }else if ($objAmostra->get_a_r_g() == AmostraRN::$STA_RECUSADA){
                            $objInfosTubo->setStatusTubo(" Descartado ");
                        }
                        $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                        $objInfosTubo->setReteste('n');
                        $objInfosTubo->setVolume(null);
                        $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getMatricula());
                        $objInfosTuboRN->cadastrar($objInfosTubo);
                        $alert .= Alert::alert_success("Informações do tubo foram CADASTRADO com sucesso");
                        
                    }
                    
                    
                }else if($data_erro || $perfil_erro || $situacao_erro){
                    $alert .= Alert::alert_danger("Amostra não pode ser CADASTRADA");
                }
                

                Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, $disabled, $onchange);
                Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, $disabled, $onchange);
                Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra, $disabled, $onchange); //por default RS
                Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra, $disabled, $onchange);
            } else {
                $objPaciente->setIdPaciente('');
                $objPaciente->setCPF('');
                $objPaciente->setDataNascimento('');
                $objPaciente->setIdSexo_fk('');
                $objPaciente->setNome('');
                $objPaciente->setNomeMae('');
                $objPaciente->setObsRG('');
                $objPaciente->setRG('');
                $objAmostra->setIdAmostra('');
                $objAmostra->setIdPaciente_fk('');
                $objAmostra->setDataColeta('');
                $objAmostra->setHoraColeta('');
                $objAmostra->set_a_r_g('');
                $objAmostra->setObservacoes('');
                $objAmostra->setIdEstado_fk('');
                $objAmostra->setIdLugarOrigem_fk('');
                $objAmostra->setIdCodGAL_fk('');
                $objAmostra->setIdNivelPrioridade_fk('');
                $objCodigoGAL->setCodigo('');
                $objCodigoGAL->setIdCodigoGAL('');
                $objCodigoGAL->setIdPaciente_fk('');
                $objAmostra->setCEP('');
            }
            break;

        case 'editar_amostra':
            $perfil_erro = false; $data_erro = false; $situacao_erro = false;
            if (!isset($_POST['salvar_amostra'])) { //enquanto não enviou o formulário com as alterações
                $objAmostra->setIdAmostra($_GET['idAmostra']);
                $objAmostra = $objAmostraRN->consultar($objAmostra);
                Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, $disabled, $onchange);
                
                Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, $disabled, $onchange);
                
                if($objAmostra->getIdEstado_fk() != null){
                    $objEstadoOrigem->setCod_estado($objAmostra->getIdEstado_fk());
                    $objEstadoOrigem = $objEstadoOrigemRN->consultar($objEstadoOrigem);
                    Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra, $disabled, $onchange); //por default RS
                }

                if($objAmostra->getIdLugarOrigem_fk() != null){
                    $objLugarOrigem->setIdLugarOrigem($objAmostra->getIdLugarOrigem_fk());
                    $objLugarOrigemRN->consultar($objLugarOrigem);
                    Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra,$disabled, $onchange);
                }
            }

            if (isset($_POST['salvar_amostra'])) {
                
                //Parte da coleta
                $objAmostra->setIdAmostra($_GET['idAmostra']);

                
                if ($_POST['dtColeta'] == null) {
                    $alert .= Alert::alert_danger("Informe a data de coleta da amostra");
                    $data_erro = true;
                }else{
                    $objAmostra->setDataColeta($_POST['dtColeta']);
                }
                
                if ($_POST['sel_a_r_g'] == null) {
                    $alert .= Alert::alert_danger("Informe a situação da amostra (aceita/recusada/a caminho)");
                    $situacao_erro = true;
                }
                if (isset($_POST['sel_a_r_g'])) {
                    $objAmostra->set_a_r_g($_POST['sel_a_r_g']);
                    Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, $disabled, $onchange);
                }


                if ($_POST['sel_perfil'] == null) {
                    $alert .= Alert::alert_danger("Informe o perfil da amostra");
                    $perfil_erro = true;
                }

                if (isset($_POST['sel_perfil'])) {
                    $objPerfilPaciente->setIdPerfilPaciente($_POST['sel_perfil']);
                    $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
                    $objAmostra->setIdPerfilPaciente_fk($_POST['sel_perfil']);
                    Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, $disabled, $onchange);
                }
                
                if (isset($_POST['timeColeta']) && $_POST['timeColeta'] != null) {
                    $objAmostra->setHoraColeta($_POST['timeColeta']);
                } else {
                    $objAmostra->setHoraColeta(null);
                }

                $objAmostra->setObservacoes($_POST['txtAreaObs']);
                $objAmostra->setIdEstado_fk(43); //ESTADO DO RS
                $objAmostra->setIdLugarOrigem_fk($_POST['sel_cidades']);
                $objAmostra->setIdNivelPrioridade_fk(null); //NIVEL DE PRIORIDADE
                
                $objAmostra->setMotivoExame($_POST['txtMotivo']);
                $objAmostra->setObsCEP($_POST['txtObsCEPAmostra']);
                $objAmostra->setObsHoraColeta($_POST['txtObsHoraColeta']);
                $objAmostra->setObsLugarOrigem($_POST['txtObsLugarOrigem']);
                $objAmostra->setObsMotivo($_POST['txtObsMotivo']);
                
                /*
                 * consegue o perfil do paciente, para pegar o caractere específico
                 */
                $objPerfilPaciente->setIdPerfilPaciente($objAmostra->getIdPerfilPaciente_fk());
                $arr_perfil = $objPerfilPacienteRN->listar($objPerfilPaciente);
                $objAmostra->setCodigoAmostra($arr_perfil[0]->getCaractere() . $objAmostra->getIdAmostra());
                
                if (!$data_erro && !$perfil_erro && !$situacao_erro) {
                    $objAmostraRN->alterar($objAmostra);
                    $alert .= Alert::alert_success("Amostra ALTERADA com sucesso");
                    
                    /*
                     * consegue o perfil do paciente, para pegar o caractere específico
                     */
                    
                    if($objAmostra->get_a_r_g() ==  AmostraRN::$STA_ACEITA || $objAmostra->get_a_r_g() ==  AmostraRN::$STA_RECUSADA){
                        /*
                         * Recém está criando a amostra então o tubo não veio de nenhum outro
                         */
                        $objTubo->setIdAmostra_fk($_GET['idAmostra']); //pega o tubo original da amostra
                        $array_tubos = $objTuboRN->listar($objTubo);
                        
                        if(empty($array_tubos)){
                            $objTubo->setIdAmostra_fk($_GET['idAmostra']);
                            $objTubo->setIdTubo_fk(null);
                            $objTubo->setTuboOriginal('s');
                            $objTuboRN->cadastrar($objTubo);
                            $objInfosTubo->setIdTubo_fk($objTubo->getIdTubo());
                        }else{
                        
                            foreach ($array_tubos as $t){
                                if($t->getTuboOriginal() == 's'){
                                    $indiceTubo = $t->getIdTubo();
                                }
                            }

                            $objInfosTubo->setIdTubo_fk($indiceTubo);
                        }
                        $objInfosTubo->setEtapa("recepção - finalizada");
                        if($objAmostra->get_a_r_g() ==  AmostraRN::$STA_ACEITA){
                            $objInfosTubo->setStatusTubo(" Aguardando preparação ");
                        }else if ($objAmostra->get_a_r_g() ==  AmostraRN::$STA_RECUSADA){
                            $objInfosTubo->setStatusTubo(" Descartado ");
                        }
                        
                        $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                        $objInfosTubo->setReteste('n');
                        $objInfosTubo->setVolume(null);
                        $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getMatricula());
                        $objInfosTuboRN->cadastrar($objInfosTubo);
                        $alert .= Alert::alert_success("Informações do tubo foram ATUALIZADAS com sucesso");
                        
                    }
                    
                    
                }else if($data_erro || $perfil_erro || $situacao_erro){
                    $alert .= Alert::alert_danger("Amostra não pode ser ALTERADA");
                }
                
                
                
                

                               
                Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, $disabled, $onchange);
                Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra, $disabled, $onchange);
                $alert = Alert::alert_success_editar();


                // header('Location: controlador.php?action=listar_amostra');
            }


            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_amostra.php');
    }
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Cadastrar Amostra");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("amostra");
Pagina::getInstance()->adicionar_javascript("paciente");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();

echo $alert .
 Pagina::montar_topo_listar('CADASTRAR AMOSTRA', 'NOVA AMOSTRA', 'cadastrar_amostra', 'listar_amostra', 'LISTAR AMOSTRAS');
?>


<div class="conteudo_grande">
    <div class="formulario">
        <form method="POST">

            <h3> Sobre a Coleta </h3>
            <hr width = “2” size = “100”>
            <div class="form-row">  
                <div class="col-md-3">
                    <label for="inputAceitaRecusada">Aceita / Recusada / A caminho</label>
                    <?= $select_a_r_g ?>
                    <div id ="feedback_aceita_recusada"></div>
                </div>

                <div class="col-md-2">
                    <label for="labelData">Data Coleta:</label>
                    <input type="date" class="form-control" id="idDtColeta" placeholder="00/00/0000" 
                           onblur="validaDataColeta()" name="dtColeta"  
                           value="<?= $objAmostra->getDataColeta() ?>"> 
                    <div id ="feedback_dataColeta"></div>
                </div>

                <div class="col-md-2">
                    <label for="labelHora">Hora Coleta:</label>
                    <input type="time" class="form-control" id="idHoraColeta" placeholder="00:00:00" 
                           onblur="validaHoraColeta()" name="timeColeta"  
                           value="<?= $objAmostra->getHoraColeta() ?>"> 
                    <div id ="feedback_horaColeta"></div>
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerHoraColeta" style="display:none" >

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsHoraColeta()"  name="obsHoraColeta"  type="radio"  
                                           class="custom-control-input" 
                                           id="customControlValidationHoraColeta2" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidationHoraColeta2">Desconhecido</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onchange="val_radio_obsHoraColeta()"  name="obsHoraColeta" type="radio" class="custom-control-input" 
                                           id="customControlValidationHoraColeta3" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidationHoraColeta3">Outro</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control  mb-3">

                                    <input style="height: 35px; margin-left: -25px;margin-top: -5px;" readonly  
                                           type="text" class="form-control" id="idObsHoraColeta" placeholder="desconhecido"  
                                           onblur="validaObsHoraColeta()" name="txtObsHoraColeta" value="<?= $objAmostra->getObsHoraColeta() ?>">
                                    <div id ="feedback_obsHoraColeta"></div>

                                </div>
                            </div> 
                        </div>
                    </div>
                </div>


                <div class="col-md-5">
                    <label for="labelMotivo">Motivo Coleta:</label>
                    <input type="text" class="form-control" id="idMotivo" placeholder="Motivo " 
                           onblur="validaMotivo()" name="txtMotivo"  
                           value="<?= $objAmostra->getMotivoExame() ?>"> 
                    <div id ="feedback_motivo"></div>
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerMotivo" style="display:none" >

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsMotivo()"  name="obsMotivo"  type="radio"  class="custom-control-input" 
                                           id="customControlValidationMotivo2" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidationMotivo2">Desconhecido</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onchange="val_radio_obsMotivo()"  name="obsMotivo" type="radio" class="custom-control-input" 
                                           id="customControlValidationMotivo3" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidationMotivo3">Outro</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control  mb-3">

                                    <input style="height: 35px; margin-left: -25px;margin-top: -5px;" readonly  
                                           type="text" class="form-control" id="idObsMotivo" placeholder="desconhecido"  
                                           onblur="validaObsMotivo()" name="txtObsMotivo" value="<?= $objAmostra->getObsMotivo() ?>">
                                    <div id ="feedback_obsMotivo"></div>

                                </div>
                            </div> 
                        </div>
                    </div>

                </div>
            </div>
            <div class="form-row">  

                <div class="col-md-2">
                    <label for="inputPerfis">Perfil da amostra</label>
                    <?= $select_perfis ?>
                    <div id ="feedback_perfil"></div>
                </div>


                <div class="col-md-2">
                    <label for="labelCEP">CEP:</label>
                    <input type="text" class="form-control" id="idCEPAmostra" placeholder="00000-000 " 
                           onblur="validaCEPAmostra()" name="txtCEP"  
                           value="<?= $objAmostra->getCEP() ?>"> 
                    <div id ="feedback_cepAmostra"></div>
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerCEPAmostra" style="display:none" >

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsCEPamostra()"  name="obsCEPamostra"  type="radio"  class="custom-control-input" 
                                           id="customControlValidationCPF2" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidationCPF2">Desconhecido</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onchange="val_radio_obsCEPamostra()"  name="obsCEPamostra" type="radio" class="custom-control-input" 
                                           id="customControlValidationCPF3" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidationCPF3">Outro</label>
                                </div>
                            </div>


                            <div class="col-auto my-1">
                                <div class="custom-control  mb-3">

                                    <input style="height: 35px; margin-left: -25px;margin-top: -5px;" readonly  type="text" 
                                           class="form-control" id="idObsCEPAmostra" placeholder="desconhecido"  
                                           onblur="validaCEPAmostra()" name="txtObsCEPAmostra" value="<?= $objAmostra->getObsCEP() ?>">
                                    <div id ="feedback_CEPAmostra"></div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-2">
                    <label for="labelEstadoColeta">Estado:</label>
                    <?= $select_estados ?>
                </div>
                <div id ="feedback_estado"></div>

                <div class="col-md-3">
                    <label for="labelMunicípioColeta">Município:</label>
                    <?= $select_municipios ?>
                </div>

                <div class="col-md-3">
                    <label for="labelObsLugarOrigem">Lugar de origem desconhecido:</label>
                    <input type="text" class="form-control" id="idObsLugarOrigem" placeholder="Desconhecido" 
                           onblur="validaObsLugarOrigem()" name="txtObsLugarOrigem"  
                           value="<?= $objAmostra->getObsLugarOrigem() ?>"> 
                    <div id ="feedback_lugarOrigem"></div>
                </div>



                <!-- <div class="col-md-2">
                     <label for="labelNivelPrioridade">Nivel de Prioridade:</label>
                <?= $select_nivelPrioridade ?>
                 </div> -->

            </div>

            <div class="form-row">
                <div class="col-md-12">
                    <label for="observações amostra">Observações</label>
                    <textarea onblur="validaObs()" id="idTxtAreaObs" name="txtAreaObs" rows="2" cols="100" class="form-control" id="obsAmostra" rows="3"></textarea>
                    <div id ="feedback_obsAmostra"></div>
                </div>
            </div>


            <button style="margin-top:20px;" class="btn btn-primary" type="submit" 
                    name="salvar_amostra">Salvar</button> 


        </form>
    </div> 
</div>


<?php
Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();
