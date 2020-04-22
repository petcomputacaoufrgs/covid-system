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

    $alert = '';
    $salvou_tudo = 'n';
    $selected_cpf = '';
    $invalid = '';
    $aparecer = true;
    $popUp = '';
    $selected_rg = '';
    $onchange = '';
    $selected_passaporte = '';
    $selected_codGal = '';
    $salvou = '';
    $cadastrarNovo = false;

    $disabled = '';
    $checked = ' ';
    $select_sexos = '';
    $select_etnias = '';
    $sumir = false;
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


    $cadastro = false;
    $erro = '';
    $editar = false;
    $SUS = false;
    $pacienteCadastrado = false;
    $select_estados = '';
    $select_municipios = '';
    $select_amostras = '';
    $select_nivelPrioridade = '';
    $select_nivelPrioridade = '';
    $select_codsGAL = '';
    $select_perfis = '';
    $select_a_r_g = '';
    $read_only = '';
    $cpf_obrigatorio = '';

    $perfil_erro = false;
    $situacao_erro = false;
    $data_erro = false;
    $amostraCadastrada = false;

    $checkedRGdesconhecido = '';
    $checkedRGmotivo = '';
    $checkedNomeMaeDesconhecido ='';
    $checkedNomeMaeMotivo ='';
    $checkedCEPDesconhecido = '';
    $checkedCEPMotivo ='';
    $checkedPassDesconhecido = '';
    $checkedPassMotivo = '';
    $checkedCPFMotivo = '';
    $checkedCPFDesconhecido = '';
    $checkedEndMotivo = '';
    $checkedEndDesconhecido = '';
    $checkedGALDesconhecido='';
    $checkedGALMotivo ='';
    $checkedCartaoSUSDesconhecido='';
    $checkedCartaoSUSMotivo ='';
    $checkedDtNascimentoDesconhecido = '';
    $checkedDtNascimentoMotivo = '';

    $checkedCEPAmostraDesconhecido = '';
    $checkedCEPAmostraMotivo = '';
    $checkedMotivoDesconhecido = '';
    $checkedMotivoMotivo = '';
    $checkedHoraColetaAmostraMotivo = '';
    $checkedHoraColetaDesconhecido = '';
    $checkedCadastroPendente = '';

    Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, $disabled, $onchange);
    Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente, $disabled, $onchange);
    Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, $disabled, $onchange);
    Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, $disabled, $onchange);
    Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra, $disabled, $onchange); //por default RS
    Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra, $disabled, $onchange);
    Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, $disabled, $onchange);

    if(isset($_GET['idPaciente'])){
        $aparecer = true;

        $objPaciente->setIdPaciente($_GET['idPaciente']);
        $objPaciente = $objPacienteRN->consultar($objPaciente);

        if($objPaciente->getDataNascimento() == null || $objPaciente->getDataNascimento() == '') {
            if ($objPaciente->getObsDataNascimento() == 'Desconhecido' || $objPaciente->getObsDataNascimento() == '') {
                $checkedDtNascimentoDesconhecido = ' checked ';
            } else if ($objPaciente->getObsDataNascimento() != 'Desconhecido') {
                $checkedDtNascimentoMotivo = ' checked ';
            }
        }

        if($objPaciente->getRG() == null || $objPaciente->getRG() == '') {
            if ($objPaciente->getObsRG() == 'Desconhecido' || $objPaciente->getObsRG() == '') {
                $checkedRGdesconhecido = ' checked ';
            } else if ($objPaciente->getObsRG() != 'Desconhecido') {
                $checkedRGMotivo = ' checked ';
            }
        }

        if($objPaciente->getNomeMae() == null || $objPaciente->getNomeMae() == '') {
            if ($objPaciente->getObsNomeMae() == 'Desconhecido' || $objPaciente->getObsNomeMae() == '') {
                $checkedNomeMaeDesconhecido = ' checked ';
            } else if ($objPaciente->getObsNomeMae() != 'Desconhecido') {
                $checkedNomeMaeMotivo = ' checked ';
            }
        }

        if($objPaciente->getCartaoSUS() == null || $objPaciente->getCartaoSUS() == '') {
            if ($objPaciente->getObsCartaoSUS() == 'Desconhecido' || $objPaciente->getObsCartaoSUS() == '') {
                $checkedCartaoSUSDesconhecido = ' checked ';
            } else if ($objPaciente->getObsCartaoSUS() != 'Desconhecido') {
                $checkedCartaoSUSMotivo = ' checked ';
            }
        }

        //if(!isset($_GET['idAmostra'])) {
            if ($objPaciente->getObsCodGAL() == 'Desconhecido' || $objPaciente->getObsCodGAL() == '') {
                $checkedGALDesconhecido = ' checked ';
            } else if ($objPaciente->getObsCodGAL() != 'Desconhecido') {
                $checkedGALMotivo = ' checked ';
            }
        //}


        if($objPaciente->getCEP() == null || $objPaciente->getCEP() == '') {
            if ($objPaciente->getObsCEP() == 'Desconhecido' || $objPaciente->getObsCEP() == '') {
                $checkedCEPDesconhecido = ' checked ';
            } else if ($objPaciente->getObsCEP() != 'Desconhecido') {
                $checkedCEPMotivo = ' checked ';
            }
        }

        if($objPaciente->getPassaporte() == null || $objPaciente->getPassaporte() == '') {
            if ($objPaciente->getObsPassaporte() == 'Desconhecido' || $objPaciente->getObsPassaporte() == '') {
                $checkedPassDesconhecido = ' checked ';
            } else if ($objPaciente->getObsPassaporte() != 'Desconhecido') {
                $checkedPssMotivo = ' checked ';
            }
        }

        if($objPaciente->getEndereco() == null || $objPaciente->getEndereco() == '') {
            if ($objPaciente->getObsEndereco() == 'Desconhecido' || $objPaciente->getObsEndereco() == '') {
                $checkedEndDesconhecido = ' checked ';
            } else if ($objPaciente->getObsEndereco() != 'Desconhecido') {
                $checkedEndMotivo = ' checked ';
            }
        }

        if($objPaciente->getCPF() == null || $objPaciente->getCPF() == '') {
            if ($objPaciente->getObsCPF() == 'Desconhecido' || $objPaciente->getObsCPF() == '') {
                $checkedCPFDesconhecido = ' checked ';

            } else if ($objPaciente->getObsCPF() != 'Desconhecido') {
                $checkedCPFMotivo = ' checked ';
            }
        }

        if($objPaciente->getCadastroPendente() == 's'){
            $checkedCadastroPendente = ' checked ';
        }

    }

    if(isset($_GET['idAmostra'])){
        $objAmostra->setIdAmostra($_GET['idAmostra']);
        $objAmostra = $objAmostraRN->consultar($objAmostra);


        if($objAmostra->getIdCodGAL_fk() != null){
            $objCodigoGAL->setIdCodigoGAL($objAmostra->getIdCodGAL_fk());
            $objCodigoGAL = $objCodigoGAL_RN->consultar($objCodigoGAL);

            if($objPaciente->getObsCodGAL() == 'Desconhecido' || $objPaciente->getObsCodGAL() == ''){
                $checkedGALDesconhecido = ' checked ';
            }else if($objPaciente->getObsCodGAL() != 'Desconhecido'){
                $checkedGALMotivo = ' checked ';
            }
        }

        if($objAmostra->getCEP() == null || $objAmostra->getCEP() == '') {
            if ($objAmostra->getObsCEP() == 'Desconhecido' || $objAmostra->getObsCEP() == '') {
                $checkedCEPAmostraDesconhecido = ' checked ';
            } else if ($objAmostra->getObsCEP() != 'Desconhecido') {
                $checkedCEPAmostraMotivo = ' checked ';
            }
        }

        if($objAmostra->getHoraColeta() == null || $objAmostra->getHoraColeta() == '') {
            if ($objAmostra->getObsHoraColeta() == 'Desconhecido' || $objAmostra->getObsHoraColeta() == '') {
                $checkedHoraColetaDesconhecido = ' checked ';
            } else if ($objAmostra->getObsHoraColeta() != 'Desconhecido') {
                $checkedHoraColetaAmostraMotivo = ' checked ';
            }
        }

        if($objAmostra->getObsLugarOrigem() =='') {
            $objAmostra->setObsLugarOrigem('Desconhecido');
        }

        if($objAmostra->getMotivoExame() == null || $objAmostra->getMotivoExame() == '') {
            if ($objAmostra->getObsMotivo() == 'Desconhecido' || $objAmostra->getObsMotivo() == '') {
                $checkedMotivoDesconhecido = ' checked ';
            } else if ($objAmostra->getObsMotivo() != 'Desconhecido') {
                $checkedMotivoMotivo = ' checked ';
            }
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
                }

                if (isset($_POST['procurar_paciente_CPF'])) {
                    if (isset($_POST['txtProcuraCPF']) && $_POST['txtProcuraCPF'] != '') {
                        $objPaciente->setCPF($_POST['txtProcuraCPF']);
                        $paciente = $objPacienteRN->procurar($objPaciente);

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


                if (isset($_GET['idPaciente'])) {
                    $alert .= Alert::alert_success("Um paciente foi encontrado com esses dados");
                    $aparecer = true;
                    //$objPaciente->setIdPaciente($_GET['idPaciente']);
                    //$objPaciente = $objPacienteRN->consultar($objPaciente);


                    /*$arr = $objCodigoGAL_RN->listar($objCodigoGAL);
                    if (count($arr) > 1) {
                        $alert .= Alert::alert_primary("O paciente possui mais de um código GAL");
                        Interf::getInstance()->montar_select_codsGAL($select_codsGAL, $objCodigoGAL, $objCodigoGAL_RN, $objPaciente, $disabled, $onchange);
                    }*/

                    $objAmostraAux = new Amostra();
                    $objAmostraAux->setIdPaciente_fk($_GET['idPaciente']);
                    $arr_amostras = $objAmostraRN->listar($objAmostraAux);

                    /*
                    if (count($arr_amostras) > 1) {
                        $alert .= Alert::alert_primary("O paciente possui mais de uma amostra");
                        Interf::getInstance()->montar_select_amostras($select_amostras, $objAmostra, $objAmostraRN, $objPaciente, $disabled, 'onchange="this.form.submit()"');
                    }*/



                    Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, $disabled, $onchange);
                    Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente, $disabled, $onchange);
                    Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, $disabled, $onchange);
                    Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra, $disabled, $onchange); //por default RS
                    Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra, $disabled, $onchange);
                    Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, $disabled, $onchange);
                }

                if (isset($_POST['sel_amostras']) && $_POST['sel_amostras'] != null) {
                    $objAmostra->setIdAmostra($_POST['sel_amostras']);
                    Interf::getInstance()->montar_select_amostras($select_amostras, $objAmostra, $objAmostraRN, $objPaciente, $disabled, $onchange);
                    $objAmostra = $objAmostraRN->consultar($objAmostra);
                }
            }

            if (isset($_POST['salvar_cadastro'])) {
                $errogal = false;
                $_SESSION['DATA_SAIDA'] = date("Y-m-d H:i:s");


                $objPaciente->setCEP($_POST['txtCEP']);
                if($objPaciente->getCEP()){
                    $objPaciente->setObsCEP($_POST['txtObsDataNascimento']);
                }

                $objPaciente->setPassaporte($_POST['txtPassaporte']);
                $objPaciente->setCPF($_POST['txtCPF']);
                $objPaciente->setRG($_POST['txtRG']);

                $objPaciente->setNomeMae($_POST['txtNomeMae']);
                if($objPaciente->getNomeMae() == null ){
                    $objPaciente->setObsNomeMae($_POST['txtObsNomeMae']);
                }

                $objPaciente->setEndereco($_POST['txtEndereco']);
                if($objPaciente->getEndereco() == null){
                    $objPaciente->setObsEndereco($_POST['txtObsEndereco']);
                }

                $objPaciente->setNome($_POST['txtNome']);

                if($objPaciente->getPassaporte() == null){
                    $objPaciente->setObsPassaporte($_POST['txtObsPassaporte']);
                }

                if($objPaciente->getCPF() == null){
                    $objPaciente->setObsCPF($_POST['txtObsCPF']);
                }

                $objPaciente->setCartaoSUS($_POST['txtCartaoSUS']);
                if($objPaciente->getCartaoSUS() == null){
                    $objPaciente->setObsCartaoSUS($_POST['txtObsCartaoSUS']);
                }

                if($objPaciente->getRG() == null) {
                    $objPaciente->setObsRG($_POST['txtObsRG']);
                }

                if (isset($_POST['sel_perfil'])) {
                    $objPerfilPaciente->setIdPerfilPaciente($_POST['sel_perfil']);
                    $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
                    $objAmostra->setIdPerfilPaciente_fk($_POST['sel_perfil']);
                    Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, $disabled, $onchange);
                }

                if(!isset($_GET['idPaciente'])) {
                    if (isset($_POST['txtCodGAL']) && $_POST['txtCodGAL'] != null) {
                        $objCodigoGAL->setCodigo($_POST['txtCodGAL']);
                        $objPaciente->setObjCodGAL($objCodigoGAL);
                    } else {
                        $objPaciente->setObsCodGAL($_POST['txtObsCodGAL']);
                    }
                }else{

                    if (isset($_POST['txtCodGAL']) && $_POST['txtCodGAL'] != null) {

                        if($objPerfilPaciente->getIndex_perfil() == 'PACIENTES SUS') {
                            $objCodigoGAL->setCodigo($_POST['txtCodGAL']);
                            $objCodigoGAL->setIdPaciente_fk($_GET['idPaciente']);
                            $objCodigoGAL_RN->alterar($objCodigoGAL);
                        }else{
                            $objCodigoGAL->setCodigo($_POST['txtCodGAL']);
                            $objCodigoGAL->setIdPaciente_fk($_GET['idPaciente']);
                            $errogal = true;
                            $alert.= Alert::alert_danger("O perfil da amostra não permite que este paciente tenha um código GAL");
                        }
                        //$objPaciente->setObjCodGAL();
                    }
                }



                if (isset($_POST['sel_etnias']) && $_POST['sel_etnias'] != '') {
                    $objPaciente->setIdEtnia_fk($_POST['sel_etnias']);
                    Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente, $disabled, $onchange);
                }

                if (isset($_POST['sel_sexo']) && $_POST['sel_sexo'] != '') {
                    $objPaciente->setIdSexo_fk($_POST['sel_sexo']);
                    Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, $disabled, $onchange);

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

                $objAmostra->setDataColeta($_POST['dtColeta']);

                if (isset($_POST['timeColeta']) && $_POST['timeColeta'] != null) {
                    $objAmostra->setHoraColeta($_POST['timeColeta']);
                } else {
                    $objAmostra->setHoraColeta(null);
                    $objAmostra->setObsHoraColeta($_POST['txtObsHoraColeta']);
                }

                if (isset($_POST['sel_a_r_g'])) {
                    $objAmostra->set_a_r_g($_POST['sel_a_r_g']);
                    Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, $disabled, $onchange);
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

                /*
                 * setar os objs 
                 */
                if (isset($_GET['idPaciente'])) {
                    $objPaciente->setIdPaciente($_GET['idPaciente']);
                    $objPacienteRN->alterar($objPaciente);
                    $objAmostra->setIdPaciente_fk($objPaciente->getIdPaciente());
                } ELSE {
                    $objAmostra->setObjPaciente($objPaciente);
                }

                $objAmostra->setObjTubo($objTubo);
                $objTubo->setObjInfosTubo($objInfosTubo);
                $objCadastroAmostra->setObjAmostra($objAmostra);

                Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra, $disabled, $onchange);
                Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, $disabled, $onchange);
                Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente, $disabled, $onchange);
                Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, $disabled, $onchange);
                Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, $disabled, $onchange);
                Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra, $disabled, $onchange); //por default RS
                Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, $disabled, $onchange);

                //print_r($objAmostra);

                /*
                 * CADASTRO AMOSTRA
                 */
                echo $errogal;

                //DIE();
                if(!$errogal) {
                    $objCadastroAmostra->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                    $objCadastroAmostra->setDataHoraInicio($_POST['dtHoraLoginInicio']);
                    $objCadastroAmostra->setDataHoraFim($_SESSION['DATA_SAIDA']);
                    if ($objCadastroAmostraRN->cadastrar($objCadastroAmostra) != null) {
                        //$disabled = ' disabled ';
                        $aparecer = false;
                        if ($objPaciente->getCadastroPendente() == 's') {
                            $checkedCadastroPendente = ' checked ';
                        }
                        $salvou_tudo = 's';
                        //$BOTAO_CANCELAR = 'off';
                        //$BOTAO_SALVAR = 'off';
                        if ($objAmostra->get_a_r_g() == 'r') {
                            $alert .= Alert::alert_primary('Amostra descartada! Emitir laudo');
                        }
                        $alert .= Alert::alert_success("Paciente <strong>" . $objPaciente->getNome() . "</strong> CADASTRADO com sucesso");
                        $alert .= Alert::alert_success("Amostra <strong>" . $objAmostra->getCodigoAmostra() . "</strong> CADASTRADA com sucesso");
                    }else {
                        $alert .= Alert::alert_danger("Paciente não foi CADASTRADO");
                        $alert .= Alert::alert_danger("Amostra não foi CADASTRADA");
                    }

                }else {
                    $alert .= Alert::alert_danger("Paciente não foi CADASTRADO");
                    $alert .= Alert::alert_danger("Amostra não foi CADASTRADA");
                }

                Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra, $disabled, $onchange);
                Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, $disabled, $onchange);
                Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente, $disabled, $onchange);
                Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, $disabled, $onchange);
                Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, $disabled, $onchange);
                Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra, $disabled, $onchange); //por default RS
                Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, $disabled, $onchange);

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



                Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, $disabled, $onchange);
                Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente, $disabled, $onchange);
                Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, $disabled, $onchange);
                Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra, $disabled, $onchange); //por default RS
                Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra, $disabled, $onchange);
                Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, $disabled, $onchange);
            }


            if (isset($_POST['salvar_cadastro'])) {
                $_SESSION['DATA_LOGIN'] = date("Y-m-d H:i:s");


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
                    Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, $disabled, $onchange);
                }

                if (isset($_POST['sel_perfil'])) {
                    $objPerfilPaciente->setIdPerfilPaciente($_POST['sel_perfil']);
                    $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
                    $objAmostra->setIdPerfilPaciente_fk($_POST['sel_perfil']);
                    Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, $disabled, $onchange);
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
                Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra, $disabled, $onchange);

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



                /*
                print_r($objPerfilPaciente);
                 if (isset($_POST['txtCartaoSUS']) && $_POST['txtCartaoSUS'] != null) {

                     if($objPerfilPaciente->getIndex_perfil() == 'PACIENTES SUS') {
                         $objPaciente->setCartaoSUS($_POST['txtCartaoSUS']);
                     }else{
                         $erroSUS = true;
                         $alert.= Alert::alert_danger("O perfil da amostra não permite que este paciente tenha um cartão SUS");
                     }

                 }*/

                if (isset($_POST['txtCodGAL']) && $_POST['txtCodGAL'] != null) {
                    if($objPerfilPaciente->getIndex_perfil() == 'PACIENTES SUS') {
                        $objCodigoGAL->setCodigo($_POST['txtCodGAL']);
                        $objCodigoGAL->setIdPaciente_fk($_GET['idPaciente']);
                        $objCodigoGAL_RN->alterar($objCodigoGAL);
                    }else{
                        $objCodigoGAL->setCodigo($_POST['txtCodGAL']);
                        $objCodigoGAL->setIdPaciente_fk($_GET['idPaciente']);
                        $errogal = true;
                        $alert.= Alert::alert_danger("O perfil da amostra não permite que este paciente tenha um código GAL");
                    }
                    //$objPaciente->setObjCodGAL();
                }


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


                $objPacienteRN->alterar($objPaciente);
                //echo $errogal;
                if(!$errogal) {
                    $objAmostraRN->alterar($objAmostra);
                    $alert .= Alert::alert_success('Dados da amostra <strong>'.$objAmostra->getCodigoAmostra().'</strong> ALTERADOS com sucesso');
                }

                if($objPaciente->getCadastroPendente() == 's'){
                    $checkedCadastroPendente = ' checked ';
                }

                /*
                 * TUBO 
                 */
                $objTubo->setIdAmostra_fk($objAmostra->getIdAmostra());
                $objTubo->setTuboOriginal('s');
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
                        }
                        $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                        $objInfosTubo->setReteste('n');
                        $objInfosTubo->setVolume(null);
                        $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getMatricula());

                        $objTubo->setObjInfosTubo($objInfosTubo);
                        $objTuboRN->cadastrar($objTubo);
                    }
                } else {
                    $objTubo = $arr_tbs[0];
                    $objInfosTubo->setIdTubo_fk($objTubo->getIdTubo());
                    if ($objAmostra->get_a_r_g() == 'r') {
                        $objInfosTubo->setStatusTubo(" Descartado ");
                    }
                    $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                    $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getMatricula());
                }



            

                Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra, $disabled, $onchange);
                Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, $disabled, $onchange);
                Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente, $disabled, $onchange);
                Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, $disabled, $onchange);
                Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, $disabled, $onchange);
                Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra, $disabled, $onchange); //por default RS
                Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, $disabled, $onchange);
            }

            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em CadastroAmostra.php');
    }
} catch (Throwable $ex) {
    $aparecer = true;
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Cadastrar Amostra");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("amostra");
Pagina::getInstance()->adicionar_javascript("paciente");
?>
<!--<script type="text/javascript">
    function validar() {
        Alert("validar");
        if (document.getElementById('idNome').value == '') {
            Alert("Informe o nome");
            return false;
        }
        return true;
    }

</script> -->
<?php
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
//			DIE("INT80");
Pagina::montar_topo_listar('CADASTRAR AMOSTRA', 'cadastrar_amostra', 'NOVA AMOSTRA', 'listar_amostra', 'LISTAR AMOSTRAS');
Pagina::getInstance()->mostrar_excecoes();


echo $popUp;
echo $alert;

$botaoNovo = false;
if ($salvou_tudo == 's' && !$aparecer) {
    $botaoNovo = true;
    echo '<button style="margin-left: 25%;width: 50%;" type="button" class="btn btn-primary" data-toggle="modal" style="width: 50%;margin-left:0%;" data-target="#exampleModalCenter2" > CADASTRAR NOVA AMOSTRA</button>';
}

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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary"><a
                                href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_amostra') . '">Tenho
                            certeza</a></button>
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
                    </select>
                </div>
            </div>

        </form>   
    </div>';
        if (isset($_POST['sel_opcoesCadastro']) && $_POST['sel_opcoesCadastro'] != '' && $_POST['sel_opcoesCadastro'] != null) {
            echo '<div class="conteudo_grande" style="margin-top:-20px;">
                    <form method="POST">
                        <div class="form-row"> 
                            <div class="col-md-10">';

            if ($_POST['sel_opcoesCadastro'] == 'CPF') {
                echo '
                                 <label for="label_cpf">Digite o CPF:</label>
                                 <input type="number" class="form-control" id="idCPF" placeholder="" 
                                           onblur="valida_cpf()" name="txtProcuraCPF"  value="' . Pagina::formatar_html($objPaciente->getCPF()) . '">
                                    <div id ="feedback_cpf"></div>
                            </div>
                            <div class="col-md-2"><button class="btn btn-primary" 
                            style="width: 100%; height: 55%;margin:0px;margin-top:30px;" type="submit" 
                            name="procurar_paciente_CPF">Procurar</button></div>';
            } else if ($_POST['sel_opcoesCadastro'] == 'codGal') {
                echo '               <label for="label_codGAL">Digite o código GAL:</label>
                                 <input type="text" class="form-control" id="idCodGAL" placeholder="" 
                                           onblur="" name="txtProcuraCodGAL"  value="' . Pagina::formatar_html($objCodigoGAL->getCodigo()) . '">
                                    <div id ="feedback_codGal"></div>
                            </div>
                            <div class="col-md-2"><button class="btn btn-primary" 
                            style="width: 100%; height: 55%;margin:0px;margin-top:30px;" type="submit" 
                            name="procurar_paciente_codGAL">Procurar</button></div>';
            } else if ($_POST['sel_opcoesCadastro'] == 'RG') {
                echo '
                                 <label for="label_rg">Digite o RG:</label>
                                 <input type="number" class="form-control" id="idRG" placeholder="" 
                                           onblur="" name="txtProcuraRG"  value="' . Pagina::formatar_html($objPaciente->getRG()) . '">
                                    <div id ="feedback_RG"></div>
                            </div>
                            <div class="col-md-2"><button class="btn btn-primary" 
                            style="width: 100%; height: 55%;margin:0px;margin-top:30px;" type="submit" 
                            name="procurar_paciente_RG">Procurar</button></div>';
            } else if ($_POST['sel_opcoesCadastro'] == 'passaporte') {
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
                    <input type="text" class="form-control <?= $invalid ?>" id="idNome" placeholder="Nome"  <?= $disabled ?>
                           onblur="validaNome()" name="txtNome"  value="<?= $objPaciente->getNome() ?>">
                    <div id ="feedback_nome" ></div>

                </div>
                <div class="col-md-3 mb-9">
                    <label for="label_nomeMae">Digite o nome da mãe:</label>
                    <input type="text" class="form-control" id="idNomeMae" placeholder="Nome da mãe" <?= $disabled ?>
                           onblur="validaNomeMae()" name="txtNomeMae" value="<?= $objPaciente->getNomeMae() ?>">
                    <div id ="feedback_nomeMae"></div>

                    <?php if($checkedNomeMaeMotivo == '' && $checkedNomeMaeDesconhecido == ''){
                        $styleNomeMae =  'style="display:none;"';
                    } else{
                        $styleNomeMae = '';
                    }?>

                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerObsNomeMae" <?=$styleNomeMae?> >

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsNomeMae()"  <?=$checkedNomeMaeDesconhecido?> name="obs"  type="radio"
                                           class="custom-control-input" id="customControlValidation2" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidation2">Desconhecido</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onchange="val_radio_obsNomeMae()" <?=$checkedNomeMaeMotivo?> name="obs" type="radio" class="custom-control-input" id="customControlValidation3" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidation3">Outro</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control  mb-3">
                                    <?php
                                    $readOnlyNomeMae = '';
                                    if($checkedNomeMaeMotivo == ''){
                                        $readOnlyNomeMae = ' readonly ';
                                    }
                                    ?>
                                    <input style="height: 35px; margin-left: -25px;margin-top: -5px;" <?=$readOnlyNomeMae?>  type="text" class="form-control" id="idObsNomeMae" placeholder="motivo"
                                           onblur="validaObsNomeMae()" name="txtObsNomeMae" value="<?= $objPaciente->getObsNomeMae() ?>">
                                    <div id ="feedback_obsNomeMae"></div>

                                </div>
                            </div>
                        </div>
                    </div>



                </div>
                <div class="col-md-3 mb-3">
                    <label for="label_dtNascimento">Digite a data de nascimento:</label>
                    <input type="date" class="form-control" id="idDtNascimento" placeholder="Data de nascimento"  <?= $disabled ?>
                           onblur="validaDataNascimento()" name="dtDataNascimento"  max="<?php echo date('Y-m-d'); ?>"  value="<?= $objPaciente->getDataNascimento() ?>">
                    <div id ="feedback_dtNascimento"></div>

                    <?php if($checkedDtNascimentoDesconhecido == '' && $checkedDtNascimentoMotivo == ''){
                        $styleDtNascimento =  'style="display:none; "';
                    } else{
                        $styleDtNascimento = '';
                    }?>
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerDataNascimento" <?=$styleDtNascimento?> >

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_dtNascimento()" <?=$checkedDtNascimentoDesconhecido?>
                                           name="obsDataNascimento"  type="radio"  class="custom-control-input"
                                           id="Validationnascim2" name="radio_nomeMaeDesconhecido" >
                                    <label class="custom-control-label" for="Validationnascim2">Desconhecido</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onchange="val_radio_dtNascimento()" <?=$checkedDtNascimentoMotivo?>
                                           name="obsDataNascimento" type="radio"
                                           class="custom-control-input"
                                           id="Validationnascim3" name="radio-stacked" >
                                    <label class="custom-control-label" for="Validationnascim3">Outro</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control  mb-3">
                                    <?php
                                    $readOnlyDataNas = '';
                                    if($checkedDtNascimentoMotivo == ''){
                                        $readOnlyDataNas = ' readonly ';
                                    }
                                    ?>
                                    <input style="height: 35px; maCodGALin-left: -25px;maCodGALin-top: -5px;" <?=$readOnlyDataNas?>
                                           type="text" class="form-control" id="idObsDtNascimento" placeholder="motivo"
                                           onblur="validaObsDtNascimento()" name="txtObsDataNascimento" value="<?= $objPaciente->getObsDataNascimento() ?>">
                                    <div id ="feedback_obsCodGAL"></div>

                                </div>
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
                    <input type="text" class="form-control cep-mask" id="idCPF" placeholder=""  <?= $disabled ?>
                           onblur="validaCPF()" name="txtCPF" value="<?= $objPaciente->getCPF() ?>">
                    <div id ="feedback_cpf"></div>
                    <?php if($checkedCPFDesconhecido == '' && $checkedCPFMotivo == ''){
                        $styleCPF =  'style="display:none;"';
                    } else{
                        $styleCPF = '';
                    }?>
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerCPF" <?=$styleCPF?> >

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsCPF()" <?= $checkedCPFDesconhecido?> name="obsCPF"  type="radio"  class="custom-control-input"
                                           id="customControlValidationCPF2" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidationCPF2">Desconhecido</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onchange="val_radio_obsCPF()" <?=$checkedCPFMotivo?>  name="obsCPF" type="radio" class="custom-control-input"
                                           id="customControlValidationCPF3" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidationCPF3">Outro</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control  mb-3">

                                    <?php
                                    $readOnlyCPF = '';
                                    if($checkedCPFMotivo == ''){
                                        $readOnlyCPF = ' readonly ';
                                    }
                                    ?>
                                    <input style="height: 35px; margin-left: -25px;margin-top: -5px;" <?=$readOnlyCPF?>
                                           type="text" class="form-control" id="idObsCPF" placeholder="motivo"  
                                           onblur="validaObsCPF()" name="txtObsCPF" value="<?= $objPaciente->getObsCPF() ?>">
                                    <div id ="feedback_obsCPF"></div>

                                </div>
                            </div> 
                        </div>
                    </div>

                </div>
                <div class="col-md-3 mb-3">
                    <label for="label_rg">Digite o RG:</label>
                    <input type="txt" class="form-control" id="idRG" placeholder="RG" <?= $disabled ?>
                           onblur="validaRG()" name="txtRG"  value="<?= $objPaciente->getRG() ?>">
                    <div id ="feedback_rg"></div>
                    <?php if($checkedRGdesconhecido == '' && $checkedRGMotivo == ''){
                        $styleRG =  'style="display:none;"';
                    } else{
                        $styleRG = '';
                    }?>

                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerRG" <?=$styleRG?> >

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsRG()" <?=$checkedRGdesconhecido?> name="obsRG"  type="radio"  class="custom-control-input"
                                           id="customControlValidationRG2" name="radio-stacked"
                                           value="rgDesconhecido">
                                    <label class="custom-control-label" for="customControlValidationRG2">Desconhecido</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onchange="val_radio_obsRG()" <?=$checkedRGMotivo?>
                                           name="obsRG" type="radio" class="custom-control-input"
                                           value="rgMotivo"
                                           id="customControlValidationRG3" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidationRG3">Outro</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control  mb-3">
                                    <?php
                                    if($checkedRGMotivo != ''){
                                        $readOnlyRG = '';
                                    }else{
                                        $readOnlyRG = ' readonly ';
                                    }
                                    ?>
                                    <input style="height: 35px; margin-left: -25px;margin-top: -5px;" <?=$readOnlyRG ?>
                                           type="text" class="form-control" id="idObsRG" placeholder="motivo"  
                                           onblur="validaObsRG()" name="txtObsRG" value="<?= $objPaciente->getObsRG() ?>">
                                    <div id ="feedback_obsRG"></div>

                                </div>
                            </div> 
                        </div>
                    </div>

                </div>

                <div class="col-md-3 mb-3">
                    <label for="label_passaporte">Digite o passaporte:</label>
                    <input type="txt" class="form-control" id="idPassaporte" placeholder="Passaporte" <?= $disabled ?>
                           onblur="validaPassaporte()" name="txtPassaporte"  value="<?= $objPaciente->getPassaporte() ?>">
                    <div id ="feedback_passaporte"></div>

                    <?php if($checkedPassDesconhecido == '' && $checkedPassMotivo == ''){
                        $stylePassaporte =  'style="display:none;"';
                    } else{
                        $stylePassaporte = '';
                    }?>
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerPassaporte" <?=$stylePassaporte?> >

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsPassaporte()" <?=$checkedPassDesconhecido?> name="obsPassaporte"  type="radio"  class="custom-control-input"
                                           id="passaporte" name="radio-stacked" >
                                    <label class="custom-control-label" for="passaporte">Desconhecido</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onchange="val_radio_obsPassaporte()" <?=$checkedPassMotivo?> name="obsPassaporte" type="radio" class="custom-control-input"
                                           id="passaporte2" name="radio-stacked" >
                                    <label class="custom-control-label" for="passaporte2">Outro</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control  mb-3">
                                    <?php
                                        $readOnlyPass = '';
                                        if($checkedPassMotivo == ''){
                                            $readOnlyPass = ' readonly ';
                                        }
                                    ?>
                                    <input style="height: 35px; maPassaportein-left: -25px;maPassaportein-top: -5px;" <?=$readOnlyPass?>
                                           type="text" class="form-control" id="idObsPassaporte" placeholder="motivo"  
                                           onblur="validaObsPassaporte()" name="txtObsPassaporte" value="<?= $objPaciente->getObsPassaporte() ?>">
                                    <div id ="feedback_obsPassaporte"></div>

                                </div>
                            </div> 
                        </div>
                    </div>

                </div>

            </div>  

            <div class="form-row">

                <!-- getDadosEnderecoPorCEP(this.value) -->
                <div class="col-md-3 mb-4">
                    <label for="CEP" >CEP:</label> 
                    <input type="text" class="form-control " id="idCEP" placeholder=""  <?= $disabled ?>
                           onblur="validaCEP()" name="txtCEP" value="<?= $objPaciente->getCEP() ?>">
                    <div id ="feedback_cep"></div>
                    <?php if($checkedCEPDesconhecido == '' && $checkedCEPMotivo == ''){
                        $styleCEPPaciente =  'style="display:none;"';
                    } else{
                        $styleCEPPaciente = '';
                    }?>
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerCEPPaciente" <?=$styleCEPPaciente?> >

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsCEPPaciente()"  name="obsCEPPaciente" <?=$checkedCEPDesconhecido?> type="radio"  class="custom-control-input"
                                           id="customControlValidationCEPPaciente2" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidationCEPPaciente2">Desconhecido</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onchange="val_radio_obsCEPPaciente()"  <?=$checkedCEPMotivo?>   name="obsCEPPaciente" type="radio" class="custom-control-input"
                                           id="customControlValidationCEPPaciente3" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidationCEPPaciente3">Outro</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control  mb-3">

                                    <?php
                                    $readOnlyCEPPaciente = '';
                                    if($checkedCEPMotivo == ''){
                                        $readOnlyCEPPaciente = ' readonly ';
                                    }
                                    ?>
                                    <input style="height: 35px; maCEPin-left: -25px;maCEPin-top: -5px;" <?=$readOnlyCEPPaciente?>
                                           type="text" class="form-control" id="idObsCEP" placeholder="motivo"  
                                           onblur="validaObsCEP()" name="txtObsCEP" value="<?= $objPaciente->getObsCEP() ?>">
                                    <div id ="feedback_obsCEP"></div>

                                </div>
                            </div> 
                        </div>
                    </div>

                </div>
                <div class="col-md-3 mb-3">
                    <label for="label_endereco">Digite o Endereço:</label>
                    <input type="text" class="form-control " id="idEndereco" placeholder="Endereço" <?= $disabled ?>
                           onblur="validaEndereco()" name="txtEndereco" value="<?= $objPaciente->getEndereco() ?>">
                    <div id ="feedback_endereco"></div>
                    <?php if($checkedEndDesconhecido == '' && $checkedEndMotivo == ''){
                        $styleEndPaciente =  'style="display:none;"';
                    } else{
                        $styleEndPaciente = '';
                    }?>

                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerEndereco" <?=$styleEndPaciente?> >

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsEndereco()" <?=$checkedEndDesconhecido?> name="obsEndereco"  type="radio"  class="custom-control-input"
                                           id="ValidationEndereco2" name="radio-stacked" >
                                    <label class="custom-control-label" for="ValidationEndereco2">Desconhecido</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onchange="val_radio_obsEndereco()" <?=$checkedEndMotivo?> name="obsEndereco" type="radio" class="custom-control-input"
                                           id="ValidationEndereco3" name="radio-stacked" >
                                    <label class="custom-control-label" for="ValidationEndereco3">Outro</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control  mb-3">
                                    <?php
                                    $readOnlyEndereco = '';
                                    if($checkedEndMotivo == ''){
                                        $readOnlyEndereco = ' readonly ';
                                    }
                                    ?>
                                    <input style="height: 35px; maEnderecoin-left: -25px;maEnderecoin-top: -5px;" <?=$readOnlyEndereco?>
                                           type="text" class="form-control" id="idObsEndereco" placeholder="motivo"  
                                           onblur="validaObsEndereco()" name="txtObsEndereco" value="<?= $objPaciente->getObsEndereco() ?>">
                                    <div id ="feedback_obsEndereco"></div>

                                </div>
                            </div> 
                        </div>
                    </div>

                </div>

                <!--<?php // if ($SUS && $objCodigoGAL->getCodigo() != null) {              ?>-->


                    <div class="col-md-3 mb-3">
                        <label for="label_codGal">Digite o código Gal:</label>
                        <input type="text" class="form-control" id="idCodGAL" <?= $disabled ?>
                               placeholder="" data-mask=""
                               onblur="validaCODGAL()" name="txtCodGAL" value="<?= $objCodigoGAL->getCodigo() ?>">
                        <div id ="feedback_codGal"></div>
                        <?php if($checkedGALMotivo == '' && $checkedGALDesconhecido == ''){
                            $styleGAL =  'style="display:none;"';
                        } else{
                            $styleGAL = '';
                        }?>
                        <div class="desaparecer_aparecer" id="id_desaparecer_aparecerCodGAL" <?=$styleGAL?> >

                            <div class="form-row align-items-center" >
                                <div class="col-auto my-1">
                                    <div class="custom-control custom-radio mb-3">
                                        <input onclick="val_radio_obsCodGAL()" <?=$checkedGALDesconhecido?>  name="obsCodGAL"  type="radio"  class="custom-control-input"
                                               id="ValidationCodGAL2" name="radio-stacked" >
                                        <label class="custom-control-label" for="ValidationCodGAL2">Desconhecido</label>
                                    </div>
                                </div>

                                <div class="col-auto my-1">
                                    <div class="custom-control custom-radio mb-3">
                                        <input onchange="val_radio_obsCodGAL()" <?=$checkedGALMotivo?> name="obsCodGAL" type="radio" class="custom-control-input"
                                               id="ValidationCodGAL3" name="radio-stacked" >
                                        <label class="custom-control-label" for="ValidationCodGAL3">Outro</label>
                                    </div>
                                </div>

                                <div class="col-auto my-1">
                                    <div class="custom-control  mb-3">
                                        <?php
                                        $readOnlyGAL = '';
                                        if($checkedGALMotivo == ''){
                                            $readOnlyGAL = ' readonly ';
                                        }
                                        ?>
                                        <input style="height: 35px; maCodGALin-left: -25px;maCodGALin-top: -5px;" <?=$readOnlyGAL?>
                                               type="text" class="form-control" id="idObsCodGAL" placeholder="motivo"  
                                               onblur="validaObsCodGAL()" name="txtObsCodGAL" value="<?= $objPaciente->getObsCodGAL() ?>">
                                        <div id ="feedback_obsCodGAL"></div>

                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>

                        <div class="col-md-3 mb-3">
                            <label for="label_codGal">Digite o cartão SUS:</label>
                            <input type="text" class="form-control" id="idCartaoSUS" <?= $disabled ?>
                                   placeholder="" data-mask=""
                                   onblur="validaCartaoSUS()" name="txtCartaoSUS" value="<?= $objPaciente->getCartaoSUS() ?>">
                            <div id ="feedback_cartaoSUS"></div>
                            <?php if($checkedCartaoSUSMotivo == '' && $checkedCartaoSUSDesconhecido == ''){
                                $styleSUS =  'style="display:none;"';
                            } else{
                                $styleSUS = '';
                            }?>
                            <div class="desaparecer_aparecer" id="id_desaparecer_aparecerCartaoSUS" <?=$styleSUS?> >

                                <div class="form-row align-items-center" >
                                    <div class="col-auto my-1">
                                        <div class="custom-control custom-radio mb-3">
                                            <input onclick="val_radio_obsCartaoSUS()"  name="obsCartaoSUS"
                                                   type="radio"  class="custom-control-input" <?=$checkedCartaoSUSDesconhecido?>
                                                   id="ValidationSUS2" name="radio-stacked" >
                                            <label class="custom-control-label" for="ValidationSUS2">Desconhecido</label>
                                        </div>
                                    </div>

                                    <div class="col-auto my-1">
                                        <div class="custom-control custom-radio mb-3">
                                            <input onchange="val_radio_obsCartaoSUS()"  name="obsCartaoSUS"
                                                   type="radio" class="custom-control-input" <?=$checkedCartaoSUSMotivo?>
                                                   id="ValidationSUS3" name="radio-stacked" >
                                            <label class="custom-control-label" for="ValidationSUS3">Outro</label>
                                        </div>
                                    </div>

                                    <div class="col-auto my-1">
                                        <div class="custom-control  mb-3">
                                            <?php
                                            $readOnlySUS = '';
                                            if($checkedCartaoSUSMotivo == ''){
                                                $readOnlySUS = ' readonly ';
                                            }
                                            ?>
                                            <input style="height: 35px; maCodGALin-left: -25px;maCodGALin-top: -5px;" <?=$readOnlySUS?>
                                                   type="text" class="form-control" id="idObsCartaoSUS" placeholder="motivo"
                                                   onblur="validaObsCartaoSUS()" name="txtObsCartaoSUS" value="<?= $objPaciente->getObsCartaoSUS() ?>">
                                            <div id ="feedback_obsCodGAL"></div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



            </div>



            <div class="form-row">

                <div class="col-md-12">
                    <div class="custom-control custom-checkbox" style="float: right;">
                        <input type="checkbox" class="custom-control-input" <?= $checkedCadastroPendente ?> id="idCadastroPendente" <?= $disabled ?>
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
                    <input type="date" class="form-control" id="idDtColeta" placeholder="00/00/0000" <?= $disabled ?>
                           onblur="validaDataColeta()" name="dtColeta"  
                           value="<?= $objAmostra->getDataColeta() ?>"> 
                    <div id ="feedback_dataColeta"></div>
                </div>

                <div class="col-md-2">
                    <label for="labelHora">Hora Coleta:</label>
                    <input type="time" class="form-control" id="idHoraColeta" placeholder="00:00:00" <?= $disabled ?>
                           onblur="validaHoraColeta()" name="timeColeta"  
                           value="<?= $objAmostra->getHoraColeta() ?>"> 
                    <div id ="feedback_horaColeta"></div>
                    <?php if($checkedHoraColetaDesconhecido == '' && $checkedHoraColetaAmostraMotivo == ''){
                        $styleHoraColeta =  'style="display:none;"';
                    } else{
                        $styleHoraColeta = '';
                    }?>
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerHoraColeta" <?=$styleHoraColeta?> >

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsHoraColeta()" <?=$checkedHoraColetaDesconhecido?> name="obsHoraColeta"  type="radio"
                                           class="custom-control-input" 
                                           id="customControlValidationHoraColeta2" name="radio_rg" >
                                    <label class="custom-control-label" for="customControlValidationHoraColeta2">Desconhecido</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onchange="val_radio_obsHoraColeta()" <?=$checkedHoraColetaAmostraMotivo?> name="obsHoraColeta" type="radio" class="custom-control-input"
                                           id="customControlValidationHoraColeta3" name="radio_rg" >
                                    <label class="custom-control-label" for="customControlValidationHoraColeta3">Outro</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control  mb-3">
                                    <?php
                                    $readOnlyHoraColeta = '';
                                    if($checkedHoraColetaAmostraMotivo == ''){
                                        $readOnlyHoraColeta = ' readonly ';
                                    }
                                    ?>
                                    <input style="height: 35px; margin-left: -25px;margin-top: -5px;"  <?=$readOnlyHoraColeta?>
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
                    <input type="text" class="form-control" id="idMotivo" placeholder="Motivo " <?= $disabled ?>
                           onblur="validaMotivo()" name="txtMotivo"  
                           value="<?= $objAmostra->getMotivoExame() ?>"> 
                    <div id ="feedback_motivo"></div>
                    <?php if($checkedMotivoDesconhecido == '' && $checkedMotivoMotivo == ''){
                        $styleMotivo =  'style="display:none;"';
                    } else{
                        $styleMotivo = '';
                    }?>
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerMotivo" <?=$styleMotivo?>>

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsMotivo()"  name="obsMotivo" <?=$checkedMotivoDesconhecido?> type="radio"  class="custom-control-input"
                                           id="customControlValidationMotivo2" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidationMotivo2">Desconhecido</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onchange="val_radio_obsMotivo()" <?=$checkedMotivoMotivo?>  name="obsMotivo" type="radio" class="custom-control-input"
                                           id="customControlValidationMotivo3" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidationMotivo3">Outro</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control  mb-3">
                                    <?php
                                    $readOnlyMotivo = '';
                                    if($checkedMotivoMotivo == ''){
                                        $readOnlyMotivo = ' readonly ';
                                    }
                                    ?>
                                    <input style="height: 35px; margin-left: -25px;margin-top: -5px;" <?=$readOnlyMotivo?>
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
                    <input type="text" class="form-control" id="idCEPAmostra" placeholder="" <?= $disabled ?>
                           onblur="validaCEPAmostra()" name="txtCEPAmostra"
                           value="<?= $objAmostra->getCEP() ?>"> 
                    <div id ="feedback_cepAmostra"></div>
                    <?php if($checkedCEPAmostraDesconhecido == '' && $checkedCEPAmostraMotivo == ''){
                        $styleCEPAmostra =  'style="display:none;"';
                    } else{
                        $styleCEPAmostra = '';
                    }?>
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerCEPAmostra" <?=$styleCEPAmostra?>>

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsCEPamostra()"  name="obsCEPamostra"  type="radio"  class="custom-control-input" 
                                           id="customControlValidationCPF2" name="radio-stacked" <?=$checkedCEPAmostraDesconhecido?> >
                                    <label class="custom-control-label" for="customControlValidationCPF2">Desconhecido</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onchange="val_radio_obsCEPamostra()"  <?=$checkedCEPAmostraMotivo?> name="obsCEPamostra" type="radio" class="custom-control-input"
                                           id="customControlValidationCPF3" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidationCPF3">Outro</label>
                                </div>
                            </div>


                            <div class="col-auto my-1">
                                <div class="custom-control  mb-3">
                                    <?php
                                    $readOnlyCEPamostra = '';
                                    if($checkedCEPAmostraMotivo == ''){
                                        $readOnlyCEPamostra = ' readonly ';
                                    }
                                    ?>
                                    <input style="height: 35px; margin-left: -25px;margin-top: -5px;" <?=$readOnlyCEPamostra?>  type="text"
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
                    <?php
                        if($objAmostra->getObsLugarOrigem() == '' || $objAmostra->getObsLugarOrigem() == null){
                            $lugar = ' Desconhecido ';
                        }else{
                            $lugar = $objAmostra->getObsLugarOrigem();
                        }

                    ?>
                    <label for="labelObsLugarOrigem">Não tem município?</label>
                    <input type="text" class="form-control" id="idObsLugarOrigem" placeholder="Desconhecido" <?= $disabled ?>
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
                    <textarea onblur="validaObs()" id="idTxtAreaObs" name="txtAreaObs" rows="2" cols="100" class="form-control" id="obsAmostra" rows="3"></textarea>
                    <div id ="feedback_obsAmostra"></div>
                </div>
            </div>


            <?php if ($BOTAO_SALVAR == 'on') {
                    if($BOTAO_CANCELAR == 'off'){ $style=  'style="width:50%;margin-left:80%;"';}
                    else { $style=  'style="width: 50%;margin-left:45%;"';}
               echo '<div class="form-row">
                    <div class="col-md-6" >
                        <button class="btn btn-primary" '.$style.' type="submit" name="salvar_cadastro">Salvar</button>
                    </div>';
            }
                    if($BOTAO_CANCELAR == 'on'){
                    echo '<div class="col-md-6" >
                        <button type="button" class="btn btn-primary" data-toggle="modal" style="width: 50%;margin-left:0%;" data-target="#exampleModalCenter" > Cancelar</button>
                    </div>
                </div>';
                } ?>


        </form>
        <!--<?php
            if ($editar) {
                echo '<button style="margin-left:45%;" type="button"  class="btn btn-primary">' .
                '<a style="color:white;text-decoration:none;" '
                . 'href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_paciente&idPaciente=' . $objPaciente->getIdPaciente()) . '">editar paciente</a></button>';
            }
            ?>-->



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


<?php } ?>

<?php
Pagina::getInstance()->fechar_corpo();

