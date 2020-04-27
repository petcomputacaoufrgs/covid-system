<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */


session_start();

require_once __DIR__.'/../../classes/Sessao/Sessao.php';
require_once __DIR__.'/../../classes/Pagina/Pagina.php';
require_once __DIR__.'/../../classes/Pagina/Interf.php';
require_once __DIR__.'/../../classes/Excecao/Excecao.php';

require_once __DIR__.'/../../classes/Usuario/Usuario.php';
require_once __DIR__.'/../../classes/Usuario/UsuarioRN.php';

require_once __DIR__.'/../../classes/Paciente/Paciente.php';
require_once __DIR__.'/../../classes/Paciente/PacienteRN.php';

require_once __DIR__.'/../../classes/Sexo/Sexo.php';
require_once __DIR__.'/../../classes/Sexo/SexoRN.php';

require_once __DIR__.'/../../classes/Amostra/Amostra.php';
require_once __DIR__.'/../../classes/Amostra/AmostraRN.php';

require_once __DIR__.'/../../classes/EstadoOrigem/EstadoOrigem.php';
require_once __DIR__.'/../../classes/EstadoOrigem/EstadoOrigemRN.php';

require_once __DIR__.'/../../classes/LugarOrigem/LugarOrigem.php';
require_once __DIR__.'/../../classes/LugarOrigem/LugarOrigemRN.php';

require_once __DIR__.'/../../classes/CodigoGAL/CodigoGAL.php';
require_once __DIR__.'/../../classes/CodigoGAL/CodigoGAL_RN.php';

require_once __DIR__.'/../../classes/NivelPrioridade/NivelPrioridade.php';
require_once __DIR__.'/../../classes/NivelPrioridade/NivelPrioridadeRN.php';

require_once __DIR__.'/../../classes/CadastroAmostra/CadastroAmostra.php';
require_once __DIR__.'/../../classes/CadastroAmostra/CadastroAmostraRN.php';

require_once __DIR__.'/../../utils/Utils.php';
require_once __DIR__.'/../../utils/Alert.php';

require_once __DIR__.'/../../classes/Tubo/Tubo.php';
require_once __DIR__.'/../../classes/Tubo/TuboRN.php';

require_once __DIR__.'/../../classes/InfosTubo/InfosTubo.php';
require_once __DIR__.'/../../classes/InfosTubo/InfosTuboRN.php';

require_once __DIR__.'/../../classes/Etnia/Etnia.php';
require_once __DIR__.'/../../classes/Etnia/EtniaRN.php';

require_once __DIR__.'/../../classes/PerfilPaciente/PerfilPaciente.php';
require_once __DIR__.'/../../classes/PerfilPaciente/PerfilPacienteRN.php';

try {
    date_default_timezone_set('America/Sao_Paulo');
    $_SESSION['DATA_LOGIN'] = date("Y-m-d H:i:s");

    Sessao::getInstance()->validar();
    $utils = new Utils();


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

    /* CÓDIGO GAL */
    $objCodigoGAL = new CodigoGAL();
    $objCodigoGAL_RN = new CodigoGAL_RN();

    /* ETNIA */
    $objEtnia = new Etnia();
    $objEtniaRN = new EtniaRN();


    /* SEXO PACIENTE */
    $objSexoPaciente = new Sexo();
    $objSexoPacienteRN = new SexoRN();


    /* CADASTRO AMOSTRA */
    $objCadastroAmostra = new CadastroAmostra();
    $objCadastroAmostraRN = new CadastroAmostraRN();

    $botaoNovo = false;
    $alert = '';
    $salvou_tudo = 'n';

    $invalid = '';
    $aparecer = true;
    $popUp = '';
    $selected_rg = '';
    $selected_cpf = '';
    $selected_passaporte = '';
    $selected_codGal = '';
    $selected_nome = '';
    $listar_pacientes = 'n';

    $salvou = '';
    $cadastrarNovo = false;


    $checked = ' ';
    $erro = '';

    $select_sexos = '';
    $select_etnias = '';
    $select_estados = '';
    $select_municipios = '';
    $select_amostras = '';
    $select_nivelPrioridade = '';
    $select_nivelPrioridade = '';
    $select_codsGAL = '';
    $select_perfis = '';
    $select_a_r_g = '';

    $campoInformado ='';

    Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, '','');
    Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente, '','');
    Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, '','');
    Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, '','');
    Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra, ' disabled ',''); //por default RS
    Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra, '','');
    Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, '','');

    if(isset($_GET['idPaciente'])){
        $aparecer = true;

        $objPaciente->setIdPaciente($_GET['idPaciente']);
        $objPaciente = $objPacienteRN->consultar($objPaciente);

        if($objPaciente->getCadastroPendente() == 's'){
            $checkedCadastroPendente = ' checked ';
        }

    }

    if(isset($_GET['idAmostra'])){ //pro caso de editar
        $objAmostra->setIdAmostra($_GET['idAmostra']);
        $objAmostra = $objAmostraRN->consultar($objAmostra);


        if($objAmostra->getIdCodGAL_fk() != null){
            $objCodigoGAL->setIdCodigoGAL($objAmostra->getIdCodGAL_fk());
            $objCodigoGAL = $objCodigoGAL_RN->consultar($objCodigoGAL);

        }

    }

    switch ($_GET['action']) {
        case 'cadastrar_amostra':

            $BOTAO_CANCELAR = 'on';
            $BOTAO_SALVAR = 'on';

            if (!isset($_POST['salvar_cadastro'])) {
                $aparecer = false;
                if (isset($_POST['sel_opcoesCadastro'])) {
                    if ($_POST['sel_opcoesCadastro'] == 'CPF') {
                        $selected_cpf = ' selected ';
                    }
                    if ($_POST['sel_opcoesCadastro'] == 'codGal') {
                        $selected_codGal = ' selected ';
                    }
                    if ($_POST['sel_opcoesCadastro'] == 'RG') {
                        $selected_rg = ' selected ';
                    }
                    if ($_POST['sel_opcoesCadastro'] == 'passaporte') {
                        $selected_passaporte = ' selected ';
                    }
                    if ($_POST['sel_opcoesCadastro'] == 'nome') {
                        $selected_nome = ' selected ';
                    }
                }

                if (isset($_POST['procurar_paciente_nome'])) {
                    if (isset($_POST['txtProcuraNome']) && $_POST['txtProcuraNome'] != '') {
                        $objPacienteAux = new Paciente();
                        $objPacienteAux->setNome($_POST['txtProcuraNome']);
                        $paciente = $objPacienteRN->listar($objPacienteAux);
                        $selected_nome = ' selected ';
                        $campoInformado = $_POST['txtProcuraNome'];
                        if ($paciente == null || count($paciente) == 0) {
                            $alert .= Alert::alert_warning("Nenhum paciente foi encontrado com esse campo (nome)");
                            $cadastrarNovo = true;
                        } else {
                            $qntPacientesEncontrados = count($paciente);
                            $alert .= Alert::alert_success('Foram encontrados '.$qntPacientesEncontrados.' pacientes com esse campo (nome)');
                            //print_r($paciente);
                            $listar_pacientes = 's';

                            foreach ($paciente as $p) {
                                if($p->getCadastroPendente() == 's'){
                                    $pendente = 'sim';
                                }else{
                                    $pendente = 'não';
                                }

                                $lista_pacientes .= '<tr>
                                        <th scope="row">' . Pagina::formatar_html($p->getIdPaciente()) . '</th>
                                                <td>' . Pagina::formatar_html($p->getNome()) . '</td>
                                                <td>' . Pagina::formatar_html($p->getNomeMae()) . '</td>
                                                <td>' . Pagina::formatar_html($p->getCPF()) . '</td>'
                                             . '<td>' . Pagina::formatar_html($p->getRG()) . '</td>
                                                <td>' . Pagina::formatar_html($pendente) . '</td>
                                                
                                     <td style="background-color: #3a5261;width: 8%;"><a style="color: white; text-decoration: none;" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_amostra&idPaciente='.$p->getIdPaciente()).'" 
                                    class=""><i style="color:white;margin: 0px; padding: 0px;" class="fas fa-plus-square "></i> Cadastrar</a></td>';
                            }

                            //tratamento da página
                        }
                    } else {
                        $alert .= Alert::alert_warning("Informe o nome para a busca");
                    }
                }
                else {

                    if (isset($_POST['procurar_paciente_CPF'])) {
                        if (isset($_POST['txtProcuraCPF']) && $_POST['txtProcuraCPF'] != '') {
                            $objPaciente->setCPF($_POST['txtProcuraCPF']);
                            $paciente = $objPacienteRN->procurar($objPaciente);
                            $selected_cpf = ' selected ';
                            $campoInformado = $_POST['txtProcuraCPF'];

                            if ($paciente == null) {
                                $alert .= Alert::alert_warning("Nenhum paciente foi encontrado com esse campo (CPF)");
                                $cadastrarNovo = true;
                            } else {
                                $alert .= Alert::alert_success("Foi encontrado paciente com esse campo (CPF)");
                            }
                        } else {
                            $alert .= Alert::alert_warning("Informe o CPF para a busca");
                        }
                    } else if (isset($_POST['procurar_paciente_passaporte'])) {
                        if (isset($_POST['txtProcuraPassaporte']) && $_POST['txtProcuraPassaporte'] != '') {
                            $objPaciente->setPassaporte($_POST['txtProcuraPassaporte']);
                            $paciente = $objPacienteRN->procurar($objPaciente);
                            $selected_passaporte = ' selected ';
                            $campoInformado = $_POST['txtProcuraPassaporte'];
                            if ($paciente == null) {
                                $alert .= Alert::alert_warning("Nenhum paciente foi encontrado com esse campo (passaporte)");
                                $cadastrarNovo = true;
                            } else {
                                $alert .= Alert::alert_success("Foi encontrado paciente com esse campo (passaporte)");
                            }
                        } else {
                            $alert .= Alert::alert_warning("Informe o passaporte para a busca");
                        }
                    } else if (isset($_POST['procurar_paciente_RG'])) {
                        if (isset($_POST['txtProcuraRG']) && $_POST['txtProcuraRG'] != '') {
                            $objPaciente->setRG($_POST['txtProcuraRG']);
                            $paciente = $objPacienteRN->procurar($objPaciente);
                            $selected_rg = ' selected ';
                            $campoInformado = $_POST['txtProcuraRG'];
                            if ($paciente == null) {
                                $alert .= Alert::alert_warning("Nenhum paciente foi encontrado com esse campo (RG)");
                                $cadastrarNovo = true;
                            } else {
                                $alert .= Alert::alert_success("Foi encontrado paciente com esse campo (RG)");
                            }
                        } else {
                            $alert .= Alert::alert_warning("Informe o RG para a busca");
                        }
                    }

                    if (!empty($paciente) && $paciente != null) {
                        header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_amostra&idPaciente='
                                . $paciente[0]->getIdPaciente()));
                        die();
                    }

                    if (isset($_POST['procurar_paciente_codGAL'])) {
                        if (isset($_POST['txtProcuraCodGAL']) && $_POST['txtProcuraCodGAL'] != '') {
                            if (is_numeric($_POST['txtProcuraCodGAL'])) {
                                $objCodigoGAL = new CodigoGAL();
                                $objCodigoGAL->setCodigo($_POST['txtProcuraCodGAL']);
                                $paciente = $objCodigoGAL_RN->listar($objCodigoGAL);
                                $selected_codGal = ' selected ';
                                $campoInformado = $_POST['txtProcuraCodGAL'];
                            } else {
                                $paciente = null;
                            }
                            if ($paciente == null) {
                                $alert .= Alert::alert_warning("Nenhum paciente foi encontrado com esse campo (código GAL)");
                                $cadastrarNovo = true;
                            } else {
                                $objCodigoGAL = $paciente[0];
                                $objPaciente->setIdPaciente($objCodigoGAL->getIdPaciente_fk());
                                $objPaciente = $objPacienteRN->consultar($objPaciente);

                                Header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_amostra&idPaciente='
                                        . $objPaciente->getIdPaciente() . '&idCodigo=' . $objCodigoGAL->getCodigo()));
                                die();
                                //$alert .= Alert::alert_success("código GAL");
                                //Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente);
                                //Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente);
                            }
                        } else {
                            $alert .= Alert::alert_warning("Informe o código GAL para a busca");
                        }
                    }
                }

                if (isset($_GET['idPaciente'])) {
                    $alert .= Alert::alert_success("Um paciente foi encontrado com esses dados");
                    $aparecer = true;

                    $objAmostraAux = new Amostra();
                    $objAmostraAux->setIdPaciente_fk($_GET['idPaciente']);
                    $arr_amostras = $objAmostraRN->listar($objAmostraAux);

                    if (count($arr_amostras) > 1) {
                        $alert .= Alert::alert_primary("O paciente possui mais de uma amostra");
                        //Interf::getInstance()->montar_select_amostras($select_amostras, $objAmostra, $objAmostraRN, $objPaciente, '', 'onchange="this.form.submit()"');
                    }
                    Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, '','');
                    Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente, '','');
                    //Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, '','');
                    //Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra, 'disabled',''); //por default RS
                    //Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra, '','');
                    //Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, '','');
                }
            }

            //salvou o cadastro
            if (isset($_POST['salvar_cadastro'])) {
                $errogal = false;
                $_SESSION['DATA_SAIDA'] = date("Y-m-d H:i:s");


                $objPaciente->setCEP($_POST['txtCEP']);
                if($objPaciente->getCEP() == null){
                    $objPaciente->setObsCEP($_POST['txtObsDataNascimento']);
                }


                $objPaciente->setNome($_POST['txtNome']);

                $objPaciente->setNomeMae($_POST['txtNomeMae']);
                if($objPaciente->getNomeMae() == null ){
                    $objPaciente->setObsNomeMae($_POST['txtObsNomeMae']);
                }

                $objPaciente->setEndereco($_POST['txtEndereco']);
                if($objPaciente->getEndereco() == null){
                        $objPaciente->setObsEndereco($_POST['txtObsEndereco']);
                }

                $objPaciente->setPassaporte($_POST['txtPassaporte']);
                if($objPaciente->getPassaporte() == null){
                    $objPaciente->setObsPassaporte($_POST['txtObsPassaporte']);
                }

                $objPaciente->setCPF($_POST['txtCPF']);
                if($objPaciente->getCPF() == null){
                    $objPaciente->setObsCPF($_POST['txtObsCPF']);
                }

                $objPaciente->setCartaoSUS($_POST['txtCartaoSUS']);
                if($objPaciente->getCartaoSUS() == null){
                    $objPaciente->setObsCartaoSUS($_POST['txtObsCartaoSUS']);
                }

                $objPaciente->setRG($_POST['txtRG']);
                if($objPaciente->getRG() == null) {
                    $objPaciente->setObsRG($_POST['txtObsRG']);
                }

                if (isset($_POST['sel_perfil'])) {
                    $objPerfilPaciente->setIdPerfilPaciente($_POST['sel_perfil']);
                    $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
                    $objAmostra->setIdPerfilPaciente_fk($_POST['sel_perfil']);
                    Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, '','');
                }


                if (isset($_POST['txtCodGAL']) && $_POST['txtCodGAL'] != null) { //se escreveu algo no gal

                    if (!isset($_GET['idPaciente'])) { //paciente NÃO existe
                        $objCodigoGAL->setCodigo($_POST['txtCodGAL']);
                    } else {
                        $objCodigoGAL->setCodigo($_POST['txtCodGAL']);
                        $objCodigoGAL->setIdPaciente_fk($_GET['idPaciente']);
                    }
                    $objCodigoGAL->setObsCodGAL($_POST['txtObsCodGAL']);
                    $objPaciente->setObjCodGAL($objCodigoGAL);
                }


                if (isset($_POST['sel_etnias']) && $_POST['sel_etnias'] != '') {
                    $objPaciente->setIdEtnia_fk($_POST['sel_etnias']);
                    Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente, '','');
                }

                if (isset($_POST['sel_sexo']) && $_POST['sel_sexo'] != '') {
                    $objPaciente->setIdSexo_fk($_POST['sel_sexo']);
                    Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, '','');

                }


                if (isset($_POST['dtDataNascimento']) && $_POST['dtDataNascimento'] != '' && $_POST['dtDataNascimento'] != null) {
                    $objPaciente->setDataNascimento($_POST['dtDataNascimento']);
                } else {
                    $objPaciente->setDataNascimento(null);
                    $objPaciente->setObsDataNascimento($_POST['txtObsDataNascimento']);

                }


                if (isset($_POST['cadastroPendente'])) {
                    if ($_POST['cadastroPendente'] == 'on') {
                        $objPaciente->setCadastroPendente('s');
                        $checkedCadastroPendente = ' checked ';
                    }
                } else {
                    $objPaciente->setCadastroPendente('n');
                }

                /*
                 *  CADASTRO DA AMOSTRA - PARTE DA COLETA
                 */

                $objAmostra->setDataColeta($_POST['dtColeta']);

                if (isset($_POST['timeColeta']) && $_POST['timeColeta'] != null) {
                    $objAmostra->setHoraColeta($_POST['timeColeta']);
                } else {
                    $objAmostra->setHoraColeta(null);
                    $objAmostra->setObsHoraColeta($_POST['txtObsHoraColeta']);
                }

                if (isset($_POST['sel_a_r_g'])) {
                    $objAmostra->set_a_r_g($_POST['sel_a_r_g']);
                    Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, '','');
                }


                $objAmostra->setCEP($_POST['txtCEPAmostra']);
                if($objAmostra->getCEP() == null){
                    $objAmostra->setObsCEP($_POST['txtObsCEPAmostra']);
                }
                $objAmostra->setObservacoes($_POST['txtAreaObs']);
                $objAmostra->setIdEstado_fk(43); //ESTADO DO RS

                $objAmostra->setIdLugarOrigem_fk($_POST['sel_cidades']);
                if($objAmostra->getIdLugarOrigem_fk() == null){
                    $objAmostra->setObsLugarOrigem($_POST['txtObsLugarOrigem']);
                }

                $objAmostra->setIdNivelPrioridade_fk(null);

                $objAmostra->setMotivoExame($_POST['txtMotivo']);
                if($objAmostra->getMotivoExame() == null){
                    $objAmostra->setObsMotivo($_POST['txtObsMotivo']);
                }


                /*
                 * INFOS TUBO 
                 */

                if ($objAmostra->get_a_r_g() == 'a') {
                    $objInfosTubo->setEtapa("recepção - finalizada");
                    $objInfosTubo->setStatusTubo(" Aguardando preparação ");
                } else if ($objAmostra->get_a_r_g() == 'r') {
                    $objInfosTubo->setEtapa('emitir laudo - descarte na recepção');
                    $objInfosTubo->setStatusTubo(" Descartado ");
                    $objInfosTubo->setDescarteNaEtapa("s");

                }
                $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                $objInfosTubo->setReteste('n');
                $objInfosTubo->setVolume(null);
                $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getMatricula());


                /*
                 * TUBO 
                 */
                $objTubo->setIdTubo_fk(null);
                $objTubo->setTuboOriginal('s');
                $objTubo->setTipo('COLETA');

                /*
                 * setar os objs 
                 */
                if (isset($_GET['idPaciente'])) {
                    $objPaciente->setIdPaciente($_GET['idPaciente']);
                }
                $objAmostra->setObjPaciente($objPaciente);
                $objAmostra->setObjTubo($objTubo);
                $objTubo->setObjInfosTubo($objInfosTubo);
                $objCadastroAmostra->setObjAmostra($objAmostra);

                Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra, '','');
                Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, '','');
                Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente, '','');
                Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, '','');
                Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, '','');
                Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra, ' disabled ',''); //por default RS
                Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, '','');

                //print_r($objAmostra);

                /*
                 * CADASTRO AMOSTRA
                 */

                    $objCadastroAmostra->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                    $objCadastroAmostra->setDataHoraInicio($_POST['dtHoraLoginInicio']);
                    $objCadastroAmostra->setDataHoraFim($_SESSION['DATA_SAIDA']);
                    if ($objCadastroAmostraRN->cadastrar($objCadastroAmostra) != null) {

                        $aparecer = false;
                        if ($objPaciente->getCadastroPendente() == 's') {
                            $checkedCadastroPendente = ' checked ';
                        }
                        $salvou_tudo = 's';
                        $botaoNovo =  true;
                        if ($objAmostra->get_a_r_g() == 'r') {
                            $alert .= Alert::alert_primary('Amostra descartada! Emitir laudo');
                        }
                        $alert .= Alert::alert_success("Paciente <strong>" . $objPaciente->getNome() . "</strong> CADASTRADO com sucesso");
                        $alert .= Alert::alert_success("Amostra <strong>" . $objAmostra->getCodigoAmostra() . "</strong> CADASTRADA com sucesso");
                    }else {
                        $alert .= Alert::alert_danger("Paciente não foi CADASTRADO");
                        $alert .= Alert::alert_danger("Amostra não foi CADASTRADA");
                    }


                Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra, '','');
                Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, '','');
                Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente, '','');
                Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, '','');
                Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, '','');
                Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra, ' disabled ',''); //por default RS
                Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, '','');

            }



            break;

        case 'editar_amostra':

            $erroSUS = false;
            $errogal = false;
            $BOTAO_SALVAR = 'on';
            $BOTAO_CANCELAR = 'off';

            if (!isset($_POST['salvar_cadastro'])) {
                $objPaciente->setIdPaciente($_GET['idPaciente']);
                $objPaciente = $objPacienteRN->consultar($objPaciente);


                $objAmostra->setIdAmostra($_GET['idAmostra']);
                $objAmostra = $objAmostraRN->consultar($objAmostra);


                if($objAmostra->getIdCodGAL_fk() != null) {
                    $objCodigoGAL->setIdCodigoGAL($objAmostra->getIdCodGAL_fk());
                    $objCodigoGAL = $objCodigoGAL_RN->consultar($objCodigoGAL);
                }



                Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, '','');
                Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente, '','');
                Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, '','');
                Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra, ' disabled',''); //por default RS
                Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra, '','');
                Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, '','');
            }


            if (isset($_POST['salvar_cadastro'])) {
                $_SESSION['DATA_SAIDA'] = date("Y-m-d H:i:s");
                //$_SESSION['DATA_LOGIN'] = date("Y-m-d H:i:s");


                $objAmostra->setIdAmostra($_GET['idAmostra']);
                $objAmostra = $objAmostraRN->consultar($objAmostra);

                $objAmostra->setDataColeta($_POST['dtColeta']);

                if (isset($_POST['timeColeta']) && $_POST['timeColeta'] != null) {
                    $objAmostra->setHoraColeta($_POST['timeColeta']);
                } else {
                    $objAmostra->setHoraColeta(null);
                }

                if (isset($_POST['sel_a_r_g'])) {
                    $objAmostra->set_a_r_g($_POST['sel_a_r_g']);
                }

                if (isset($_POST['sel_perfil'])) {
                    $objPerfilPaciente->setIdPerfilPaciente($_POST['sel_perfil']);
                    $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
                    $objAmostra->setIdPerfilPaciente_fk($_POST['sel_perfil']);
                }else{
                    $objPerfilPaciente->setIdPerfilPaciente($objAmostra->getIdPerfilPaciente_fk());
                    $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
                }


                $objAmostra->setDataColeta($_POST['dtColeta']);

                if (isset($_POST['timeColeta']) && $_POST['timeColeta'] != null) {
                    $objAmostra->setHoraColeta($_POST['timeColeta']);
                } else {
                    $objAmostra->setHoraColeta(null);
                    $objAmostra->setObsHoraColeta($_POST['txtObsHoraColeta']);
                }

                if (isset($_POST['sel_a_r_g'])) {
                    $objAmostra->set_a_r_g($_POST['sel_a_r_g']);
                    Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, '','');
                }

                if (isset($_POST['sel_perfil'])) {
                    $objPerfilPaciente->setIdPerfilPaciente($_POST['sel_perfil']);
                    $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
                    $objAmostra->setIdPerfilPaciente_fk($_POST['sel_perfil']);
                    Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, '','');
                }


                $objAmostra->setCEP($_POST['txtCEPAmostra']);
                if($objAmostra->getCEP() == null){
                    $objAmostra->setObsCEP($_POST['txtObsCEPAmostra']);
                }
                $objAmostra->setObservacoes($_POST['txtAreaObs']);
                $objAmostra->setIdEstado_fk(43); //ESTADO DO RS

                $objAmostra->setIdLugarOrigem_fk($_POST['sel_cidades']);
                if($objAmostra->getIdLugarOrigem_fk() == null){
                    $objAmostra->setObsLugarOrigem($_POST['txtObsLugarOrigem']);
                }
                Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra, '','');

                $objAmostra->setIdNivelPrioridade_fk(null);

                $objAmostra->setMotivoExame($_POST['txtMotivo']);
                if($objAmostra->getMotivoExame() == null){
                    $objAmostra->setObsMotivo($_POST['txtObsMotivo']);
                }

                /*
                 * PACIENTE
                 */

                $objPaciente->setIdPaciente($_GET['idPaciente']);
                $objPaciente = $objPacienteRN->consultar($objPaciente); //tudo que não for setado, fica com o valor anterior

                $objPaciente->setNome($_POST['txtNome']);

                $objPaciente->setCEP($_POST['txtCEP']);
                if($objPaciente->getCEP()){
                    $objPaciente->setObsCEP($_POST['txtObsDataNascimento']);
                }

                $objPaciente->setNomeMae($_POST['txtNomeMae']);
                if($objPaciente->getNomeMae() == null ){

                    $objPaciente->setObsNomeMae($_POST['txtObsNomeMae']);
                }

                $objPaciente->setEndereco($_POST['txtEndereco']);
                if($objPaciente->getEndereco() == null){
                    if($_POST['obsEndereco'] == 'radio_endPDesconhecido'){
                        $objPaciente->setObsEndereco(null);
                    }else if($_POST['obsEndereco'] == 'radio_endPMotivo') {
                        $objPaciente->setObsEndereco($_POST['txtObsEndereco']);
                    }
                }
                //print_r($objPaciente);


                $objPaciente->setPassaporte($_POST['txtPassaporte']);
                if($objPaciente->getPassaporte() == null){
                    $objPaciente->setObsPassaporte($_POST['txtObsPassaporte']);
                }

                $objPaciente->setCPF($_POST['txtCPF']);
                if($objPaciente->getCPF() == null){
                    $objPaciente->setObsCPF($_POST['txtObsCPF']);
                }

                $objPaciente->setCartaoSUS($_POST['txtCartaoSUS']);
                if ($objPaciente->getCartaoSUS() == null) {
                    $objPaciente->setObsCartaoSUS($_POST['txtObsCartaoSUS']);
                }

                $objPaciente->setRG($_POST['txtRG']);
                if($objPaciente->getRG() == null) {
                    $objPaciente->setObsRG($_POST['txtObsRG']);
                }


                if (isset($_POST['txtCodGAL']) && $_POST['txtCodGAL'] != null) { //se escreveu algo no gal

                    if ($objAmostra->getIdCodGAL_fk() == null) { //não tinha nenhum código gal associado até agora
                        $objCodigoGAL->setCodigo($_POST['txtCodGAL']);
                        $objCodigoGAL->setIdPaciente_fk($_GET['idPaciente']);
                    } else { //o código gal já existia, precisa ser editado
                        $objCodigoGAL->setIdCodigoGAL($objAmostra->getIdCodGAL_fk());
                        $objCodigoGAL->setCodigo($_POST['txtCodGAL']);
                        $objCodigoGAL->setIdPaciente_fk($_GET['idPaciente']);
                    }
                    $objCodigoGAL->setObsCodGAL($_POST['txtObsCodGAL']);
                }

                $objPaciente->setObjCodGAL($objCodigoGAL);


                if (isset($_POST['sel_etnias']) && $_POST['sel_etnias'] != '') {
                    $objPaciente->setIdEtnia_fk($_POST['sel_etnias']);
                }

                if (isset($_POST['sel_sexo']) && $_POST['sel_sexo'] != '') {
                    $objPaciente->setIdSexo_fk($_POST['sel_sexo']);
                }

                if (isset($_POST['dtDataNascimento']) && $_POST['dtDataNascimento'] != '' && $_POST['dtDataNascimento'] != null) {
                    $objPaciente->setDataNascimento($_POST['dtDataNascimento']);
                } else {
                    $objPaciente->setDataNascimento(NULL);
                    $objPaciente->setObsDataNascimento($_POST['txtObsDataNascimento']);
                }


                if (isset($_POST['cadastroPendente'])) {
                    if ($_POST['cadastroPendente'] == 'on') {
                        $objPaciente->setCadastroPendente('s');
                        $checkedCadastroPendente = ' checked ';
                    }
                } else {
                    $objPaciente->setCadastroPendente('n');
                }


                //$objPacienteRN->alterar($objPaciente);
                //echo $errogal;
                $objAmostra->setObjPaciente($objPaciente);

                /*if(!$errogal) {
                    $objAmostraRN->alterar($objAmostra);
                    $alert .= Alert::alert_success('Dados da amostra <strong>'.$objAmostra->getCodigoAmostra().'</strong> ALTERADOS com sucesso');
                }*/

                if($objPaciente->getCadastroPendente() == 's'){
                    $checkedCadastroPendente = ' checked ';
                }

                /*
                 * TUBO 
                 */
                $objTubo->setIdAmostra_fk($objAmostra->getIdAmostra());
                $objTubo->setTuboOriginal('s');
                $objTubo->setTipo('COLETA');
                $arr_tbs = $objTuboRN->listar($objTubo);

                if (empty($arr_tbs)) {
                    if ($objAmostra->get_a_r_g() == 'a' || $objAmostra->get_a_r_g() == 'r') {
                        $objTubo->setIdTubo_fk(null);
                        $objTubo->setTuboOriginal('s');
                        $objTubo->setIdAmostra_fk($_GET['idAmostra']);
                        $objAmostra->setObjTubo($objTubo);

                        //recém criou o tubo
                        $objInfosTubo->setEtapa("recepção - finalizada");
                        if ($objAmostra->get_a_r_g() == 'a') {
                            $objInfosTubo->setStatusTubo(" Aguardando preparação ");
                        } else if ($objAmostra->get_a_r_g() == 'r') {
                            $objInfosTubo->setStatusTubo(" Descartado ");
                            $objInfosTubo->setDescarteNaEtapa("s");
                        }
                        $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                        $objInfosTubo->setReteste('n');
                        $objInfosTubo->setVolume(null);
                        $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getMatricula());


                        //$objTuboRN->cadastrar($objTubo);
                    }
                } else {
                    $objTubo = $arr_tbs[0];
                    $objInfosTubo->setIdTubo_fk($objTubo->getIdTubo());
                    $arr_infos = $objInfosTuboRN->listar($objInfosTubo);
                    $objInfosTubo = end($arr_infos);

                    if ($objAmostra->get_a_r_g() == 'r') {
                        $objInfosTubo->setStatusTubo(" Descartado ");
                        $objInfosTubo->etapa(" emitir laudo - descarte na recepção ");
                        $objInfosTubo->setDescarteNaEtapa("s");
                    }

                    if($objAmostra->get_a_r_g() == 'g'){
                        $objTubo->getIdAmostra_fk($objAmostra->getIdAmostra());
                        $arr_tubos = $objTuboRN->listar($objTubo);
                        foreach ($arr_tubos as $t) {
                            $objTuboRN->remover($t);
                        }
                    }

                    $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                    $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getMatricula());

                }

                print_r($objInfosTubo);
                $objTubo->setObjInfosTubo($objInfosTubo);
                $objAmostra->setIdAmostra($_GET['idAmostra']);
                $objAmostra->setObjTubo($objTubo);
                $objAmostra->setObjPaciente($objPaciente);
                $objCadastroAmostra->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                $objCadastroAmostra->setDataHoraInicio($_POST['dtHoraLoginInicio']);
                $objCadastroAmostra->setDataHoraFim($_SESSION['DATA_SAIDA']);
                $objCadastroAmostra->setObjAmostra($objAmostra);
                 if ($objCadastroAmostraRN->cadastrar($objCadastroAmostra) != null) {

                     if ($objPaciente->getCadastroPendente() == 's') {
                         $checkedCadastroPendente = ' checked ';
                     }
                     $salvou_tudo = 's';
                     $botaoNovo =  true;
                     if ($objAmostra->get_a_r_g() == 'r') {
                         $alert .= Alert::alert_primary('Amostra descartada! Emitir laudo');
                     }
                     $alert .= Alert::alert_success("Paciente <strong>" . $objPaciente->getNome() . "</strong> ALTERADO com sucesso");
                     $alert .= Alert::alert_success("Amostra <strong>" . $objAmostra->getCodigoAmostra() . "</strong> ALTERADO com sucesso");
                 }else {
                     $alert .= Alert::alert_danger("Paciente não foi ALTERADO");
                     $alert .= Alert::alert_danger("Amostra não foi ALTERADO");
                 }

            

                Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra, '', '');
                Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, '', '');
                Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente, '', '');
                Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, '', '');
                Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, '', '');
                Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra, '', ''); //por default RS
                Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, '', '');
            }

            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em CadastroAmostra.php');
    }
} catch (Throwable $ex) {
    $aparecer = true;
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Cadastrar Amostra");
if($botaoNovo) {
    Pagina::getInstance()->adicionar_javascript("popUp");
}
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("amostra");
Pagina::getInstance()->adicionar_javascript("paciente");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
//			DIE("INT80");
Pagina::montar_topo_listar('CADASTRAR AMOSTRA', 'cadastrar_amostra', 'NOVA AMOSTRA', 'listar_amostra', 'LISTAR AMOSTRAS');
Pagina::getInstance()->mostrar_excecoes();

if($salvou_tudo == 'n'){
    $alert2 = Alert::alert_primary("Na ausência de um motivo, o mesmo terá o valor 'Desconhecido'");
    echo $alert2;
}
echo $popUp;

echo $alert;


    echo ' <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Deseja cadastrar uma nova amostra? </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!--<div class="modal-body">
                    Ao cancelar, nenhum dado será cadastrado no banco.
                </div>-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary"><a
                                href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_amostra') . '">Sim, desejo cadastrar</a></button>
                </div>
            </div>
        </div>
    </div>';


if(!$aparecer && !$botaoNovo){

    if ($_GET['action'] != 'editar_paciente' && $_GET['action'] != 'editar_amostra') {
        echo
            '<div class="conteudo_grande" ' . $salvou . '>
        <form method="POST">
            <div class="row"> 
                <div class="col-md-12">
                    <label for="label_cpf">Informe como deseja procurar o paciente:</label>
                    <select class="form-control selectpicker" id="select-country idSel_opcoesCadastro" onchange="this.form.submit()"
                    data-live-search="true" name="sel_opcoesCadastro">
                    <option data-tokens="" ></option>
                    <option ' . $selected_codGal . 'value="codGal" data-tokens="Código gal">  SUS/LACEN</option>
                    <option ' . $selected_cpf . ' value="CPF" data-tokens="CPF"> CPF</option>
                    <option  ' . $selected_rg . 'value="RG" data-tokens="RG"> RG</option>
                    <option  ' . $selected_passaporte . 'value="passaporte" data-tokens="Passaporte"> Passaporte</option>
                    <option  ' . $selected_nome . 'value="nome" data-tokens="Nome"> Nome</option>
                    </select>
                </div>
            </div>

        </form>   
    </div>';
        //if (isset($_POST['sel_opcoesCadastro']) && $_POST['sel_opcoesCadastro'] != '' && $_POST['sel_opcoesCadastro'] != null ) {
        if($selected_nome != '' ||  $selected_cpf != '' || $selected_rg != '' || $selected_passaporte != ''){
            echo '<div class="conteudo_grande" style="margin-top:-20px;">
                    <form method="POST">
                        <div class="form-row"> 
                            <div class="col-md-10">';

            if ($_POST['sel_opcoesCadastro'] == 'nome' || $selected_nome != '') {

                echo '
                     <label for="label_cpf">Digite o nome:</label>
                     <input type="text" class="form-control" id="idNome" placeholder="" 
                               onblur="valida_nome()" name="txtProcuraNome"  
                               value="'.$campoInformado.'">
                        <div id ="feedback_nome"></div>
                </div>
                <div class="col-md-2"><button class="btn btn-primary" 
                style="width: 100%; height: 55%;margin:0px;margin-top:30px;" type="submit" 
                name="procurar_paciente_nome">Procurar</button></div>';

            } else if ($_POST['sel_opcoesCadastro'] == 'CPF' || $selected_cpf != '') {
                echo '
                                 <label for="label_cpf">Digite o CPF:</label>
                                 <input type="number" class="form-control" id="idCPF" placeholder="" 
                                           onblur="valida_cpf()" name="txtProcuraCPF"  value="' . Pagina::formatar_html($objPaciente->getCPF()) . '">
                                    <div id ="feedback_cpf"></div>
                            </div>
                            <div class="col-md-2"><button class="btn btn-primary" 
                            style="width: 100%; height: 55%;margin:0px;margin-top:30px;" type="submit" 
                            name="procurar_paciente_CPF">Procurar</button></div>';
            } else if ($_POST['sel_opcoesCadastro'] == 'codGal' || $selected_codGal != '') {
                echo '               <label for="label_codGAL">Digite o código GAL:</label>
                                 <input type="text" class="form-control" id="idCodGAL" placeholder="" 
                                           onblur="" name="txtProcuraCodGAL"  value="' . Pagina::formatar_html($objCodigoGAL->getCodigo()) . '">
                                    <div id ="feedback_codGal"></div>
                            </div>
                            <div class="col-md-2"><button class="btn btn-primary" 
                            style="width: 100%; height: 55%;margin:0px;margin-top:30px;" type="submit" 
                            name="procurar_paciente_codGAL">Procurar</button></div>';
            } else if ($_POST['sel_opcoesCadastro'] == 'RG' || $selected_rg != '') {
                echo '
                                 <label for="label_rg">Digite o RG:</label>
                                 <input type="number" class="form-control" id="idRG" placeholder="" 
                                           onblur="" name="txtProcuraRG"  value="' . Pagina::formatar_html($objPaciente->getRG()) . '">
                                    <div id ="feedback_RG"></div>
                            </div>
                            <div class="col-md-2"><button class="btn btn-primary" 
                            style="width: 100%; height: 55%;margin:0px;margin-top:30px;" type="submit" 
                            name="procurar_paciente_RG">Procurar</button></div>';
            } else if ($_POST['sel_opcoesCadastro'] == 'passaporte' || $selected_passaporte!= '') {
                echo '
                <label for="label_passaporte">Digite o passaporte:</label>
                <input type="text" class="form-control" id="idPassaporte" placeholder="" 
                                           onblur="" name="txtProcuraPassaporte"  value="' . Pagina::formatar_html($objPaciente->getPassaporte()) . '">
                                    <div id ="feedback_passaporte"></div>
                            </div>
                            <div class="col-md-2"><button class="btn btn-primary" 
                            style="width: 100%; height: 55%;margin:0px;margin-top:30px;" type="submit" 
                            name="procurar_paciente_passaporte">Procurar</button></div>';
            }

            echo '          </div>
                    </form>   
                </div>';
        }
    }
}


if($listar_pacientes == 's'){
    echo   '<div class="conteudo_tabela" style="width:98%;margin-left: 1%;margin-right: 1%;">
            <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col"># </th>
                <th scope="col">NOME</th>
                <th scope="col">NOME MAE</th>
                <th scope="col">CPF</th>
                <th scope="col">RG</th>
                <th scope="col">PENDENTE</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>';
    echo $lista_pacientes;
    echo '</tbody>
          </table>';

}else{
/*if ($cadastrarNovo)
    echo '<small ' . $salvou . ' style="width:50%; margin-left:7%; color:red;">Informe o paciente desde o início ou procure por outro documento</small>';*/
if ($aparecer || $cadastrarNovo){//(isset($_GET['idPaciente']) || $cadastrarNovo ) {
    ?>


    <div class="conteudo_grande">
        <form method="POST" onsubmit="validar()" >
            <div class="col-md-3">
                <input type="text" class="form-control" id="idDataHoraLogin" hidden style="text-align: center;"
                       name="dtHoraLoginInicio" required value="<?= $_SESSION['DATA_LOGIN'] ?>">
            </div>

            <?php
            if ($select_amostras != null) {

                echo '  
                  <div class="form-row">
                         <div class="col-md-12">
                            <label for="tdsAmostras" >Amostras:</label>' .
                $select_amostras .
                '</div>
                        </div>
                  
                     ';
            }
            ?>


            <h2> Sobre o paciente </h2>
            <hr width = 2 size = 2>
            <div class="form-row" style="margin-top:10px;">
                <div class="col-md-3 mb-3">
                    <label for="label_nome">Digite o nome:</label>
                    <input type="text" class="form-control <?= $invalid ?>" id="idNome" placeholder="Nome"
                           onblur="validaNome()" name="txtNome"  value="<?= $objPaciente->getNome() ?>">
                    <div id ="feedback_nome" ></div>

                </div>
                <div class="col-md-3 mb-9">
                    <label for="label_nomeMae">Digite o nome da mãe:</label>
                    <input type="text" class="form-control" id="idNomeMae" placeholder="Nome da mãe"
                           onblur="validaNomeMae()" name="txtNomeMae" value="<?= $objPaciente->getNomeMae() ?>">
                    <div id ="feedback_nomeMae"></div>
                    <?php if($objPaciente->getNomeMae() != null){
                        $displayNomeMae = ' display:none;';
                    } ?>
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerObsNomeMae" style="background-color: rgba(192,192,192,0.2);border-radius:5px;<?=$displayNomeMae?>" >

                            <div class="form-row align-items-center" >
                                <div class="col-auto my-1">
                                    <label style="margin-top: 10px;margin-left: 10px;" for="label_motivo">Motivo da ausência:</label>
                                </div>
                                <div class="col-auto my-1" >
                                    <input style="height: 35px; width: 100%; margin-left: 20px;margin-top: 2px;"
                                           type="text" class="form-control" id="idObsNomeMae" placeholder="Desconhecido"
                                           onblur="validaObsNomeMae()" name="txtObsNomeMae" value="<?= $objPaciente->getObsNomeMae() ?>">
                                    <div id ="feedback_obsNomeMae"></div>
                                </div>
                            </div>
                    </div>

                </div>
                <div class="col-md-3 mb-3">
                    <label for="label_dtNascimento">Digite a data de nascimento:</label>
                    <input type="date" class="form-control" id="idDtNascimento" placeholder="Data de nascimento"
                           onblur="validaDataNascimento()" name="dtDataNascimento"
                           value="<?= $objPaciente->getDataNascimento() ?>">
                    <div id ="feedback_dtNascimento"></div>
                    <?php if($objPaciente->getDataNascimento() != null){
                        $displayNascimento = ' display:none;';
                    } ?>
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerDataNascimento" style="background-color: rgba(192,192,192,0.2);border-radius:5px;<?=$displayNascimento?>" >
                            <div class="form-row align-items-center" >
                                <div class="col-auto my-1">
                                    <label style="margin-top: 10px;margin-left: 10px;" for="label_motivo">Motivo da ausência:</label>
                                </div>
                                <div class="col-auto my-1" >
                                    <input style="height: 35px; width: 100%; margin-left: 20px;margin-top: 2px;"
                                           type="text" class="form-control" id="idObsDtNascimento" placeholder="Desconhecido"
                                           onblur="validaObsDtNascimento()" name="txtObsDataNascimento" value="<?= $objPaciente->getObsDataNascimento() ?>">
                                    <div id ="feedback_dtNascimento"></div>
                                </div>
                            </div>
                        </div>
                </div>


                <div class="col-md-3 mb-4">
                    <label for="sexoPaciente" >Sexo:</label>
                    <?= $select_sexos ?>
                    <div id ="feedback_sexo"></div>
                </div>

            </div>  


            <div class="form-row">

                <div class="col-md-3 mb-4">
                    <label for="etniaPaciente" >Etnia:</label>
                    <?= $select_etnias ?>
                    <div id ="feedback_sexo"></div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="label_cpf">Digite o CPF:</label>
                    <input type="text" class="form-control cep-mask" id="idCPF" placeholder="CPF"
                           onblur="validaCPF()" name="txtCPF" value="<?= $objPaciente->getCPF() ?>">
                    <div id ="feedback_cpf"></div>
                    <?php if($objPaciente->getCPF() != null){
                        $displayCPF = ' display:none;';
                    } ?>
                        <div class="desaparecer_aparecer" id="id_desaparecer_aparecerCPF" style="background-color: rgba(192,192,192,0.2);border-radius:5px;<?=$displayCPF?>" >
                            <div class="form-row align-items-center" >
                                <div class="col-auto my-1">
                                    <label style="margin-top: 10px;margin-left: 10px;" for="label_motivo">Motivo da ausência:</label>
                                </div>
                                <div class="col-auto my-1" >
                                    <input style="height: 35px; width: 100%; margin-left: 20px;margin-top: 2px;"
                                           type="text" class="form-control" id="idObsCPF" placeholder="Desconhecido"
                                           onblur="validaObsCPF()" name="txtObsCPF" value="<?= $objPaciente->getObsCPF() ?>">
                                    <div id ="feedback_obsCPF"></div>
                                </div>
                            </div>
                        </div>

                </div>
                <div class="col-md-3 mb-3">
                    <label for="label_rg">Digite o RG:</label>
                    <input type="txt" class="form-control" id="idRG" placeholder="RG"
                           onblur="validaRG()" name="txtRG"  value="<?= $objPaciente->getRG() ?>">
                    <div id ="feedback_rg"></div>
                    <?php if($objPaciente->getRG() != null){
                        $displayRG = ' display:none;';
                    } ?>
                        <div class="desaparecer_aparecer" id="id_desaparecer_aparecerRG" style="background-color: rgba(192,192,192,0.2);border-radius:5px;<?=$displayRG?>" >
                            <div class="form-row align-items-center" >
                                <div class="col-auto my-1">
                                    <label style="margin-top: 10px;margin-left: 10px;" for="label_motivo">Motivo da ausência:</label>
                                </div>
                                <div class="col-auto my-1" >
                                    <input style="height: 35px; width: 100%; margin-left: 20px;margin-top: 2px;"
                                           type="text" class="form-control" id="idObsRG" placeholder="Desconhecido"
                                           onblur="validaObsRG()" name="txtObsRG" value="<?= $objPaciente->getObsRG() ?>">
                                    <div id ="feedback_obsRG"></div>
                                </div>
                            </div>
                        </div>

                </div>

                <div class="col-md-3 mb-3">
                    <label for="label_passaporte">Digite o passaporte:</label>
                    <input type="txt" class="form-control" id="idPassaporte" placeholder="Passaporte"
                           onblur="validaPassaporte()" name="txtPassaporte"  value="<?= $objPaciente->getPassaporte() ?>">
                    <div id ="feedback_passaporte"></div>
                    <?php if($objPaciente->getPassaporte() != null){
                        $displayPassaporte = ' display:none;';
                    } ?>
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerPassaporte" style="background-color: rgba(192,192,192,0.2);border-radius:5px;<?=$displayPassaporte?>" >

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <label style="margin-top: 10px;margin-left: 10px;" for="label_motivo">Motivo da ausência:</label>
                            </div>
                            <div class="col-auto my-1" >
                                <input style="height: 35px; width: 100%; margin-left: 20px;margin-top: 2px;"
                                       type="text" class="form-control" id="idObsPassaporte" placeholder="Desconhecido"
                                       onblur="validaObsPassaporte()" name="txtObsPassaporte" value="<?= $objPaciente->getObsPassaporte() ?>">
                                <div id ="feedback_obsPassaporte"></div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>  

            <div class="form-row">

                <!-- getDadosEnderecoPorCEP(this.value) -->
                <div class="col-md-3 mb-4">
                    <label for="CEP" >CEP:</label> 
                    <input type="text" class="form-control " id="idCEP" placeholder="CEP"
                           onblur="validaCEP()" name="txtCEP" value="<?= $objPaciente->getCEP() ?>">
                    <div id ="feedback_cep"></div>
                    <?php if($objPaciente->getCEP() != null){
                        $displayCEP = ' display:none;';
                    } ?>
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerCEPPaciente" style="background-color: rgba(192,192,192,0.2);border-radius:5px;<?=$displayCEP?>" >

                            <div class="form-row align-items-center" >
                                <div class="col-auto my-1">
                                    <label style="margin-top: 10px;margin-left: 10px;" for="label_motivo">Motivo da ausência:</label>
                                </div>
                                <div class="col-auto my-1" >
                                    <input style="height: 35px; width: 100%; margin-left: 20px;margin-top: 2px;"
                                           type="text" class="form-control" id="idObsCEP" placeholder="Desconhecido"
                                           onblur="validaObsCEP()" name="txtObsCEP" value="<?= $objPaciente->getObsCEP() ?>">
                                    <div id ="feedback_obsCEP"></div>

                                </div>
                            </div>
                        </div>

                </div>
                <div class="col-md-3 mb-3">
                    <label for="label_endereco">Digite o Endereço:</label>
                    <input type="text" class="form-control " id="idEndereco" placeholder="Endereço"
                           onblur="validaEndereco()" name="txtEndereco" value="<?= $objPaciente->getEndereco() ?>">
                    <div id ="feedback_endereco"></div>
                    <?php if($objPaciente->getEndereco() != null){
                        $displayEndereco = ' display:none;';
                    } ?>

                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerEndereco" style="background-color: rgba(192,192,192,0.2);border-radius:5px;<?=$displayEndereco?>" >
                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <label style="margin-top: 10px;margin-left: 10px;" for="label_motivo">Motivo da ausência:</label>
                            </div>
                            <div class="col-auto my-1" >
                                <input style="height: 35px; width: 100%; margin-left: 20px;margin-top: 2px;"
                                       type="text" class="form-control" id="idObsEndereco" placeholder="Desconhecido"
                                       onblur="validaObsEndereco()" name="txtObsEndereco" value="<?= $objPaciente->getObsEndereco() ?>">
                                <div id ="feedback_obsEndereco"></div>
                            </div>
                        </div>
                    </div>



                        </div>

                    <div class="col-md-3 mb-3">
                        <label for="label_codGal">Digite o código Gal:</label>
                        <input type="text" class="form-control" id="idCodGAL"
                               placeholder="GAL" data-mask=""
                               onblur="validaCODGAL()" name="txtCodGAL" value="<?= $objCodigoGAL->getCodigo() ?>">
                        <div id ="feedback_codGal"></div>
                        <?php if($objCodigoGAL->getCodigo() == null){
                            $displayCodGAL = ' display:none;';
                        } ?>
                        <div class="desaparecer_aparecer" id="id_desaparecer_aparecerCodGAL" style="background-color: rgba(192,192,192,0.2);border-radius:5px;<?=$displayCodGAL?>" >
                            <div class="form-row align-items-center" >
                                <div class="col-auto my-1">
                                    <label style="margin-top: 10px;margin-left: 10px;" for="label_motivo">Observações:</label>
                                </div>
                                <div class="col-auto my-1" >
                                    <input style="height: 35px; width: 100%; margin-left: 20px;margin-top: 2px;"
                                           type="text" class="form-control" id="idObsCodGAL" placeholder="Observações"
                                           onblur="validaObsCodGAL()" name="txtObsCodGAL" value="<?= $objCodigoGAL->getObsCodGAL() ?>">
                                    <div id ="feedback_obsCodGAL"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                        <div class="col-md-3 mb-3">
                            <label for="label_codGal">Digite o cartão SUS:</label>
                            <input type="text" class="form-control" id="idCartaoSUS"
                                   placeholder="SUS" data-mask=""
                                   onblur="validaCartaoSUS()" name="txtCartaoSUS" value="<?= $objPaciente->getCartaoSUS() ?>">
                            <div id ="feedback_cartaoSUS"></div>
                            <?php if($objPaciente->getCartaoSUS() != null){
                                $displayCartaoSUS = ' display:none;';
                            } ?>
                            <div class="desaparecer_aparecer" id="id_desaparecer_aparecerCartaoSUS" style="background-color: rgba(192,192,192,0.2);border-radius:5px;<?=$displayCartaoSUS?>" >
                                <div class="form-row align-items-center" >
                                    <div class="col-auto my-1">
                                        <label style="margin-top: 10px;margin-left: 10px;" for="label_motivo">Motivo da ausência:</label>
                                    </div>
                                    <div class="col-auto my-1" >
                                        <input style="height: 35px; width: 100%; margin-left: 20px;margin-top: 2px;"
                                               type="text" class="form-control" id="idObsCartaoSUS" placeholder="Desconhecido"
                                               onblur="validaObsCartaoSUS()" name="txtObsCartaoSUS" value="<?= $objPaciente->getObsCartaoSUS() ?>">
                                        <div id ="feedback_cartaoSUS"></div>

                                    </div>
                                </div>
                            </div>
                        </div>



            </div>



            <div class="form-row">

                <div class="col-md-12">
                    <div class="custom-control custom-checkbox" style="float: right;">
                        <input type="checkbox" class="custom-control-input" <?= $checkedCadastroPendente ?> id="idCadastroPendente"
                               name="cadastroPendente">
                        <label class="custom-control-label"  for="idCadastroPendente">Cadastro Pendente</label>
                    </div>
                </div>
            </div>





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

                <div class="col-md-3">
                    <label for="labelHora">Hora Coleta:</label>
                    <input type="time" class="form-control" id="idHoraColeta" placeholder="00:00:00"
                           onblur="validaHoraColeta()" name="timeColeta"  
                           value="<?= $objAmostra->getHoraColeta() ?>">
                    <div id ="feedback_horaColeta"></div>
                    <?php if($objAmostra->getHoraColeta() != null){
                        $displayHoraColeta = ' display:none;';
                    } ?>

                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerHoraColeta" style="background-color: rgba(192,192,192,0.2);border-radius:5px;<?=$displayHoraColeta?>" >
                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <label style="margin-top: 10px;margin-left: 10px;" for="label_motivo">Motivo da ausência:</label>
                            </div>
                            <div class="col-auto my-1" >
                                <input style="height: 35px; width: 100%; margin-left: 20px;margin-top: 2px;"
                                       type="text" class="form-control" id="idObsHoraColeta" placeholder="desconhecido"
                                       onblur="validaObsHoraColeta()" name="txtObsHoraColeta" value="<?= $objAmostra->getObsHoraColeta() ?>">
                                <div id ="feedback_obsHoraColeta"></div>

                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-md-4">
                    <label for="labelMotivo">Motivo Coleta:</label>
                    <input type="text" class="form-control" id="idMotivo" placeholder="Motivo "
                           onblur="validaMotivo()" name="txtMotivo"  
                           value="<?= $objAmostra->getMotivoExame() ?>"> 
                    <div id ="feedback_motivo"></div>
                    <?php if($objAmostra->getMotivoExame() != null){
                        $displayMotivoColeta = ' display:none;';
                    } ?>

                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerMotivo" style="background-color: rgba(192,192,192,0.2);border-radius:5px;<?=$displayMotivoColeta?>" >
                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <label style="margin-top: 10px;margin-left: 10px;" for="label_motivo">Motivo da ausência:</label>
                            </div>
                            <div class="col-auto my-1" >
                                <input style="height: 35px; width: 100%; margin-left: 20px;margin-top: 2px;"
                                       type="text" class="form-control" id="idObsCartaoSUS" placeholder="Desconhecido"
                                       onblur="validaObsCartaoSUS()" name="txtObsCartaoSUS"
                                       value="<?= $objAmostra->getObsMotivo() ?>">
                                <div id ="feedback_cartaoSUS"></div>

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


                <div class="col-md-3">
                    <label for="labelCEP">CEP:</label>
                    <input type="text" class="form-control" id="idCEPAmostra" placeholder="CEP"
                           onblur="validaCEPAmostra()" name="txtCEPAmostra"
                           value="<?= $objAmostra->getCEP() ?>"> 
                    <div id ="feedback_cepAmostra"></div>
                    <?php if($objAmostra->getCEP() != null){
                        $displayCEPamostra = ' display:none;';
                    } ?>
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerCEPAmostra" style="background-color: rgba(192,192,192,0.2);border-radius:5px;<?=$displayCEPamostra?>" >
                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <label style="margin-top: 10px;margin-left: 10px;" for="label_motivo">Motivo da ausência:</label>
                            </div>
                            <div class="col-auto my-1" >
                                <input style="height: 35px; width: 100%; margin-left: 20px;margin-top: 2px;"
                                       class="form-control" id="idObsCEPAmostra" placeholder="desconhecido"
                                       onblur="validaCEPAmostra()" name="txtObsCEPAmostra" value="<?= $objAmostra->getObsCEP() ?>">
                                <div id ="feedback_CEPAmostra"></div>

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


                <div class="col-md-2" style="background-color: rgba(192,192,192,0.2);border-radius:5px;height: 80px;">
                    <?php
                        if($objAmostra->getObsLugarOrigem() == '' || $objAmostra->getObsLugarOrigem() == null){
                            $lugar = ' Desconhecido ';
                        }else{
                            $lugar = $objAmostra->getObsLugarOrigem();
                        }

                    ?>
                    <label for="labelObsLugarOrigem">Não tem município?</label>
                    <input type="text" class="form-control" id="idObsLugarOrigem" placeholder="Desconhecido"
                           onblur="validaObsLugarOrigem()" name="txtObsLugarOrigem"  
                           value="<?= $lugar ?>">
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
                    <textarea onblur="validaObs()" id="idTxtAreaObs"
                              name="txtAreaObs" rows="2" cols="100" class="form-control"
                              id="obsAmostra" rows="3"><?=$objAmostra->getObservacoes()?></textarea>
                    <div id ="feedback_obsAmostra"></div>
                </div>
            </div>


            <?php if ($BOTAO_SALVAR == 'on') {
                    if($BOTAO_CANCELAR == 'off'){ $col= " col-md-12 ";$style= 'margin-left:0px;style="width:100%;"';}
                    else {$col="col-md-6"; $style=  'style="width: 100%;margin-left:0px;"';}
               echo '<div class="form-row">
                    <div class="'.$col.'" >
                        <button class="btn btn-primary" '.$style.' type="submit" name="salvar_cadastro">Salvar</button>
                    </div>';
            }
                    if($BOTAO_CANCELAR == 'on'){
                    echo '<div class="col-md-6" >
                        <button type="button" class="btn btn-primary" data-toggle="modal" style="width: 100%;margin-left:0%;" data-target="#exampleModalCenter" > Cancelar</button>
                    </div>
                </div>';
                } ?>


        </form>



    </div>





    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                    <button type="button"  class="btn btn-primary"><a href="<?= Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_amostra') ?>">Tenho certeza</a></button>
                </div>
            </div>
        </div>
    </div>


<?php }
}?>

<?php
Pagina::getInstance()->fechar_corpo();

