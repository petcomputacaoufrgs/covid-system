
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

require_once '../classes/CadastroAmostra/CadastroAmostra.php';
require_once '../classes/CadastroAmostra/CadastroAmostraRN.php';

require_once '../utils/Utils.php';
require_once '../utils/Alert.php';

require_once '../classes/Tubo/Tubo.php';
require_once '../classes/Tubo/TuboRN.php';

require_once '../classes/InfosTubo/InfosTubo.php';
require_once '../classes/InfosTubo/InfosTuboRN.php';

require_once '../classes/Etnia/Etnia.php';
require_once '../classes/Etnia/EtniaRN.php';

require_once '../classes/PerfilPaciente/PerfilPaciente.php';
require_once '../classes/PerfilPaciente/PerfilPacienteRN.php';

try {
    date_default_timezone_set('America/Sao_Paulo');


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

    $selected_cpf = '';
    $invalid = '';

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
    $select_nivelPrioridade = '';
    $select_perfis = '';
    $select_a_r_g = '';
    $read_only = '';
    $cpf_obrigatorio = '';

    $perfil_erro = false;
    $situacao_erro = false;
    $data_erro = false;
    $amostraCadastrada = false;


    Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, $disabled, $onchange);
    Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente, $disabled, $onchange);
    Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, $disabled, $onchange);
    Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, $disabled, $onchange);
    Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra, $disabled, $onchange); //por default RS
    Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra, $disabled, $onchange);
    Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, $disabled, $onchange);

    switch ($_GET['action']) {
        case 'cadastrar_amostra':

            $paciente = array();
            if (isset($_GET['idPaciente'])) {
                $_SESSION['DATA_LOGIN'] = date("Y-m-d H:i:s");
                $alert .= Alert::alert_success("Um paciente foi encontrado");
                $objPaciente->setIdPaciente($_GET['idPaciente']);
                $objPaciente = $objPacienteRN->consultar($objPaciente);
                //print_r($objPaciente);
                Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente, $disabled, $onchange);
                Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, $disabled, $onchange);

                $objAmostra->setIdPaciente_fk($_GET['idPaciente']);
                $arr_amostra_paciente = $objAmostraRN->listar($objAmostra);
                
                if ($arr_amostra_paciente != null) {
                    foreach ($arr_amostra_paciente as $a) {
                        if ($a->get_a_r_g() == 'g') {
                            $objAmostra = $a;
                        }
                    }

                    //print_r($arr_amostra_paciente);
                    Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra, $disabled, $onchange);
                    Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, $disabled, $onchange);
                    Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, $disabled, $onchange);
                } else {
                    $alert .= Alert::alert_primary("Ainda não há nenhuma amostra associada a este paciente");
                }

                $objCodigoGAL->setIdPaciente_fk($_GET['idPaciente']);

                if (isset($_GET['idCodigo'])) { //caso seja um paciente com GAL -- PACIENTE SUS
                    $objCodigoGAL->setCodigo($_GET['idCodigo']);
                    $arrgal = $objCodigoGAL_RN->listar($objCodigoGAL);


                    if (!empty($arrgal)) {
                        $SUS = true;
                        $objCodigoGAL = $arrgal[0]; // é pra devolver sempre 1
                        //print_r($objCodigoGAL);
                    } else {
                        $SUS = false;
                    }
                }


                Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, $disabled, $onchange);
                Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente, $disabled, $onchange);
            } else if (!isset($_POST['salvar_cadastro'])) {

                if (isset($_POST['sel_opcoesCadastro'])) {

                    if ($_POST['sel_opcoesCadastro'] == 'CPF') {
                        $selected_cpf = ' selected ';
                    }

                    if ($_POST['sel_opcoesCadastro'] == 'codGal') {
                        $selected_codGal = ' selected ';
                        //$SUS = true;
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
                }

                if (isset($_POST['procurar_paciente_passaporte'])) {
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
                }

                if (isset($_POST['procurar_paciente_RG'])) {
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
                    //$objPaciente = $paciente[0];
                    header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_amostra&idPaciente='
                                    . $paciente[0]->getIdPaciente()));
                    die();
                    //Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente);
                    //Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente);
                }

                if (isset($_POST['procurar_paciente_codGAL'])) {
                    if (isset($_POST['txtProcuraCodGAL']) && $_POST['txtProcuraCodGAL'] != '') {
                        if(is_numeric($_POST['txtProcuraCodGAL'])){
                            $objCodigoGAL = new CodigoGAL();
                            $objCodigoGAL->setCodigo($_POST['txtProcuraCodGAL']);
                            $paciente = $objCodigoGAL_RN->listar($objCodigoGAL);
                        }else{
                            $paciente = null;
                        }
                        
                        if ($paciente == null) {
                            $alert .= Alert::alert_warning("Nenhum paciente foi encontrado com esse campo (código GAL)");
                            $cadastrarNovo = true;
                            $SUS = true;
                        } else {
                            $SUS = true;
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

            $_SESSION['DATA_LOGIN'] = date("Y-m-d H:i:s");
            if (isset($_POST['salvar_cadastro'])) {
                $_SESSION['DATA_SAIDA'] = date("Y-m-d H:i:s");
                $sumir = false;
                $disabled = '';
                $erro = false;
                $GAL = false;
                if (isset($_GET['idPaciente'])) { //caso de o paciente já existir, então só vai ocorrer a alteração desse usuário
                    $arr_CPFs = array();
                    $arr_RGS = array();
                    $arr_passaportes = array();


                    if ($_POST['txtCPF'] != null) {
                        $objPacienteAux = new Paciente();
                        $objPacienteAux->setIdPaciente($_GET['idPaciente']);
                        $objPacienteAux->setCPF($_POST['txtCPF']);
                        $arr_CPFs = $objPacienteRN->procurarCPF($objPacienteAux); //procurou entre os outros pacientes

                        if (!empty($arr_CPFs)) {
                            $alert .= Alert::alert_primary("O CPF já está associado a outro paciente");
                            $erro = true;
                        } else if ($arr_CPFs == null) {
                            $objPaciente->setCPF($_POST['txtCPF']); // setei o CPF! tudo certo 
                        }
                    }


                    if ($_POST['txtRG'] != null) {

                        $objPacienteAux = new Paciente();
                        $objPacienteAux->setIdPaciente($_GET['idPaciente']);
                        $objPacienteAux->setRG($_POST['txtRG']);
                        $arr_RGS = $objPacienteRN->procurarRG($objPacienteAux);

                        //print_r($arr_RGS);
                        if (!empty($arr_RGS)) {
                            $alert .= Alert::alert_primary("O RG já está associado a outro paciente");
                            $erro = true;
                        } else {
                            $objPaciente->setRG($_POST['txtRG']); //setei o RG! Tudo certo
                        }
                        //die("MORREI");
                    }

                    if ($_POST['txtPassaporte'] != null) {

                        $objPacienteAux = new Paciente();
                        $objPacienteAux->setIdPaciente($_GET['idPaciente']);
                        $objPacienteAux->setPassaporte($_POST['txtPassaporte']);
                        $arr_passaportes = $objPacienteRN->procurarPassaporte($objPacienteAux);

                        if (!empty($arr_passaportes)) {
                            $alert .= Alert::alert_primary("O passaporte já está associado a outro paciente");
                            $erro = true;
                        } else {
                            $objPaciente->setPassaporte($_POST['txtPassaporte']); //setei o RG! Tudo certo
                        }
                    }


                    if (isset($_POST['txtCodGAL']) && $_POST['txtCodGAL'] != null) {

                        $objCodigoGAL->setIdPaciente_fk($_GET['idPaciente']);
                        $objCodigoGAL->setCodigo($_POST['txtCodGAL']);
                        $gals = $objCodigoGAL_RN->procurarGAL($objCodigoGAL);
                        //print_r($gals);
                        if (!empty($gals)) {
                            $alert .= Alert::alert_primary("O código GAL já está associado a outro paciente");
                            $erro = true;
                        } else {
                            $objCodigoGAL->setCodigo($_POST['txtCodGAL']);
                            $GAL = true;
                        }
                    }
                } else {
                    $cadastro = true;

                    if ($_POST['txtCPF'] != null) {
                        $objPacienteAux = new Paciente();
                        $objPacienteAux->setCPF($_POST['txtCPF']);
                        $arr_CPFs = $objPacienteRN->procurar($objPacienteAux); //procurou entre os outros pacientes
                        //print_r($arr_CPFs);
                        if (!empty($arr_CPFs)) {
                            $alert .= Alert::alert_primary("O CPF já está associado a outro paciente");
                            $erro = true;
                        } else {
                            $objPaciente->setCPF($_POST['txtCPF']); // setei o CPF! tudo certo 
                        }
                    }

                    if ($_POST['txtRG'] != null) {

                        $objPacienteAux = new Paciente();
                        $objPacienteAux->setRG($_POST['txtRG']);
                        $arr_RGS = $objPacienteRN->procurar($objPacienteAux);

                        //print_r($RGS);
                        if (!empty($arr_RGS)) {
                            $alert .= Alert::alert_primary("O RG já está associado a outro paciente");
                            $erro = true;
                        } else {
                            $objPaciente->setRG($_POST['txtRG']); //setei o RG! Tudo certo
                        }
                    }

                    if ($_POST['txtPassaporte'] != null) {

                        $objPacienteAux = new Paciente();
                        $objPacienteAux->setPassaporte($_POST['txtPassaporte']);
                        $arr_passaportes = $objPacienteRN->procurar($objPacienteAux);

                        if (!empty($arr_passaportes)) {
                            $alert .= Alert::alert_primary("O passaporte já está associado a outro paciente");
                            $erro = true;
                        } else {
                            $objPaciente->setPassaporte($_POST['txtPassaporte']); //setei o RG! Tudo certo
                        }
                    }


                    if (isset($_POST['txtCodGAL']) && $_POST['txtCodGAL'] != null) {
                        //echo "sus";
                        $SUS = true;
                        $objCodigoGAL->setCodigo($_POST['txtCodGAL']);
                        $gals = $objCodigoGAL_RN->listar($objCodigoGAL);

                        if (!empty($gals)) {
                            $alert .= Alert::alert_primary("O código GAL já está associado a outro paciente");
                            $erro = true;
                        } else {
                            $objCodigoGAL->setCodigo($_POST['txtCodGAL']);
                            $GAL = true;
                        }
                    }
                }


                $objPaciente->setCEP($_POST['txtCEP']);
                $objPaciente->setNomeMae($_POST['txtNomeMae']);
                $objPaciente->setEndereco($_POST['txtEndereco']);
                $objPaciente->setNome($_POST['txtNome']);
                $objPaciente->setObsPassaporte($_POST['txtObsPassaporte']);
                $objPaciente->setObsCPF($_POST['txtObsCPF']);
                $objPaciente->setObsEndereco($_POST['txtObsEndereco']);
                $objPaciente->setObsRG($_POST['txtObsRG']);

                if (isset($_POST['txtCodGAL']) && $_POST['txtCodGAL'] != null) {
                    if ($_POST['txtObsCodGAL'] != null) {
                        $objPaciente->setObsCodGAL($_POST['txtObsCodGAL']);
                    }
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
                }


                if (isset($_POST['cadastroPendente'])) {
                    if ($_POST['cadastroPendente'] == 'on') {
                        $objPaciente->setCadastroPendente('s');
                        $checked = ' checked ';
                    }
                } else {
                    $objPaciente->setCadastroPendente('n');
                }


                if (isset($_GET['idPaciente']) && !$erro) {

                    $objPacienteRN->alterar($objPaciente);
                    $alert .= Alert::alert_success("O paciente foi ALTERADO com sucesso");

                    $pacienteCadastrado = true;
                    $disabled = ' disabled ';
                    $editar = true;
                    if ($GAL) {
                        $objCodigoGAL->setIdPaciente_fk($_GET['idPaciente']);
                        $objCodigoGAL_RN->alterar($objCodigoGAL);
                        $alert .= Alert::alert_success("O código GAL do paciente foi ALTERADO com sucesso");
                    } else {
                        //$alert .= Alert::alert_danger("O código GAL do paciente não foi ALTERADO");
                    }
                } else if (isset($_GET['idPaciente']) && $erro) {
                    $alert .= Alert::alert_danger("O paciente não foi ALTERADO com sucesso");
                    $pacienteCadastrado = true;
                }

                if ($cadastro && !$erro) {
                    if ($objPaciente->getNome() == '') {
                        $alert .= Alert::alert_danger("Informe o nome do paciente");
                        $invalid = ' is-invalid ';
                        $cadastrarNovo = true;
                        if ($GAL)
                            $GAL = true;
                        $editar = TRUE;
                    } else {

                        $objPacienteRN->cadastrar($objPaciente);
                        if (!$GAL) {
                            $salvou = ' hidden ';
                            $disabled = ' disabled ';
                            $alert .= Alert::alert_success("O paciente foi CADASTRADO com sucesso");
                            $pacienteCadastrado = true;
                            $cadastrarNovo = true;
                            if ($objPaciente->getCadastroPendente() == 's')
                                $checked = ' checked ';
                            $editar = true;
                        }

                        if ($GAL) {

                            $objCodigoGAL->setIdPaciente_fk($objPaciente->getIdPaciente());
                            $objCodigoGAL->setCodigo($_POST['txtCodGAL']);

                            if ($objCodigoGAL_RN->cadastrar($objCodigoGAL)) {
                                $alert .= Alert::alert_success("O paciente foi CADASTRADO com sucesso");
                                $pacienteCadastrado = true;
                                $alert .= Alert::alert_success("O código GAL do paciente foi CADASTRADO com sucesso");
                                $salvou = ' hidden ';
                                $disabled = ' disabled ';
                                $cadastrarNovo = true;
                                $editar = true;
                            } else {

                                $alert .= Alert::alert_danger("O código GAL do paciente não foi CADASTRADO");
                                $objPacienteRN->remover($objPaciente);
                                $alert .= Alert::alert_danger("O paciente foi apagado");
                                $pacienteCadastrado = false;
                            }
                        }
                    }
                } else if ($cadastro && $erro) {
                    $cadastrarNovo = true;
                    $alert .= Alert::alert_danger("O paciente não foi CADASTRADO com sucesso");
                }

                if ($pacienteCadastrado) {
                    //Parte da coleta

                    $disabled = '';
                    if (isset($_GET['idPaciente']) && $_GET['idPaciente'] != null) {

                        $objAmostra->setIdPaciente_fk($_GET['idPaciente']);
                    } else {
                        $objAmostra->setIdPaciente_fk($objPaciente->getIdPaciente());
                    }

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
                        $amostraCadastrada = true;

                        /*
                         * consegue o perfil do paciente, para pegar o caractere específico
                         */
                        $objPerfilPaciente->setIdPerfilPaciente($objAmostra->getIdPerfilPaciente_fk());
                        $arr_perfil = $objPerfilPacienteRN->listar($objPerfilPaciente);

                        $objAmostra->setCodigoAmostra($arr_perfil[0]->getCaractere() . $objAmostra->getIdAmostra());
                        $objAmostraRN->alterar($objAmostra);

                        if ($objAmostra->get_a_r_g() == 'a' || $objAmostra->get_a_r_g() == 'r') {
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
                            if ($objAmostra->get_a_r_g() == 'a') {
                                $objInfosTubo->setStatusTubo(" Aguardando preparação ");
                            } else if ($objAmostra->get_a_r_g() == 'r') {
                                $objInfosTubo->setStatusTubo(" Descartado ");
                            }
                            $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                            $objInfosTubo->setReteste('n');
                            $objInfosTubo->setVolume(null);
                            $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getMatricula());
                            $objInfosTuboRN->cadastrar($objInfosTubo);
                            $alert .= Alert::alert_success("Informações do tubo foram CADASTRADO com sucesso");
                        }
                    } else if ($data_erro || $perfil_erro || $situacao_erro) {
                        $alert .= Alert::alert_danger("Amostra não pode ser CADASTRADA");
                        $amostraCadastrada = false;
                         header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_amostra&idPaciente='
                                    . $objPaciente->getIdPaciente()));
                         die();
                    }


                    Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, $disabled, $onchange);
                    Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, $disabled, $onchange);
                    Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra, $disabled, $onchange); //por default RS
                    Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra, $disabled, $onchange);
                } else {
                    $amostraCadastrada = false;
                    $alert .= Alert::alert_danger("A amostra não foi cadastrada porque os dados do paciente não estão corretos");
                }


                if ($pacienteCadastrado && $amostraCadastrada) {
                    //die("entrou aqui");
                    $sumir = true;
                    $disabled = ' disabled ';
                    $objCadastroAmostra->setIdAmostra_fk($objAmostra->getIdAmostra());
                    $objCadastroAmostra->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                    $objCadastroAmostra->setDataHoraInicio($_SESSION['DATA_LOGIN']);
                    $objCadastroAmostra->setDataHoraFim($_SESSION['DATA_SAIDA']);
                    //print_r($objCadastroAmostra);
                    $objCadastroAmostraRN->cadastrar($objCadastroAmostra);
                    
                    
                    //print_r($objPaciente);
                    //print_r($objAmostra);
                    //Header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_amostra&idPaciente='. $objPaciente->getIdPaciente().'&idAmostra='. $objAmostra->getIdAmostra()));
                    //die();
                }
                
            }
            
            
            /*if (isset($_POST['editar_cadastro'])) {
                echo 'controlador.php?action=editar_amostra&idPaciente='. $objPaciente->getIdPaciente().'&idAmostra='. $objAmostra->getIdAmostra();
                die();
                Header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_amostra&idPaciente='. $objPaciente->getIdPaciente().'&idAmostra='. $objAmostra->getIdAmostra()));
            }*/


            Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra, $disabled, $onchange);
            Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, $disabled, $onchange);
            Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente, $disabled, $onchange);
            Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, $disabled, $onchange);
            Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, $disabled, $onchange);
            Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra, $disabled, $onchange); //por default RS
            Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, $disabled, $onchange);



            break;

        case 'editar_amostra':
            //*$disabled = ' disabled ';
            if (isset($_GET['idPaciente']) && $_GET['idPaciente'] != null) {
                $objPaciente->setIdPaciente($_GET['idPaciente']);
                $objPaciente = $objPacienteRN->consultar($objPaciente);

                $objCodigoGAL->setIdPaciente_fk($_GET['idPaciente']);
                $arrgal = $objCodigoGAL_RN->listar($objCodigoGAL);


                if (!empty($arrgal)) {
                    $SUS = true;
                    $objCodigoGAL = $arrgal[0]; // é pra devolver sempre 1
                    //print_r($objCodigoGAL);
                } else {
                    $SUS = false;
                }
            }

            if (isset($_GET['idAmostra']) && $_GET['idAmostra'] != null) {
                $objAmostra->setIdAmostra($_GET['idAmostra']);
                $objAmostra = $objAmostraRN->consultar($objAmostra);
                
                 Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, $disabled, $onchange);
                Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, $disabled, $onchange);
                Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra, $disabled, $onchange); //por default RS
                Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra, $disabled, $onchange);
            }


            if (isset($_POST['salvar_cadastro'])) {
                $pacienteCadastrado = false;
                $GAL = false;
                $arr_CPFs = array();
                $arr_RGS = array();
                $arr_passaportes = array();

                if ($_POST['txtCPF'] != null) {
                    $objPacienteAux = new Paciente();
                    $objPacienteAux->setIdPaciente($_GET['idPaciente']);
                    $objPacienteAux->setCPF($_POST['txtCPF']);
                    $arr_CPFs = $objPacienteRN->procurarCPF($objPacienteAux); //procurou entre os outros pacientes

                    if (!empty($arr_CPFs)) {
                        $alert .= Alert::alert_primary("O CPF já está associado a outro paciente");
                        $erro = true;
                    } else {
                        $objPaciente->setCPF($_POST['txtCPF']); // setei o CPF! tudo certo 
                    }
                }


                if ($_POST['txtRG'] != null) {

                    $objPacienteAux = new Paciente();
                    $objPacienteAux->setIdPaciente($_GET['idPaciente']);
                    $objPacienteAux->setRG($_POST['txtRG']);
                    $arr_RGS = $objPacienteRN->procurarRG($objPacienteAux);

                    //print_r($RGS);
                    if (!empty($arr_RGS)) {
                        $alert .= Alert::alert_primary("O RG já está associado a outro paciente");
                        $erro = true;
                    } else {
                        $objPaciente->setRG($_POST['txtRG']); //setei o RG! Tudo certo
                    }
                }

                if ($_POST['txtPassaporte'] != null) {

                    $objPacienteAux = new Paciente();
                    $objPacienteAux->setIdPaciente($_GET['idPaciente']);
                    $objPacienteAux->setPassaporte($_POST['txtPassaporte']);
                    $arr_passaportes = $objPacienteRN->procurarPassaporte($objPacienteAux);

                    if (!empty($arr_passaportes)) {
                        $alert .= Alert::alert_primary("O passaporte já está associado a outro paciente");
                        $erro = true;
                    } else {
                        $objPaciente->setPassaporte($_POST['txtPassaporte']); //setei o RG! Tudo certo
                    }
                }


                if (isset($_POST['txtCodGAL']) && $_POST['txtCodGAL'] != null) {

                    $objCodigoGAL->setIdPaciente_fk($_GET['idPaciente']);
                    $objCodigoGAL->setCodigo($_POST['txtCodGAL']);
                    $gals = $objCodigoGAL_RN->procurarGAL($objCodigoGAL);
                    //print_r($gals);
                    if (!empty($gals)) {
                        $alert .= Alert::alert_primary("O código GAL já está associado a outro paciente");
                        $erro = true;
                    } else {
                        $objCodigoGAL->setCodigo($_POST['txtCodGAL']);
                        $GAL = true;
                    }
                }


                $objPaciente->setCEP($_POST['txtCEP']);
                $objPaciente->setNomeMae($_POST['txtNomeMae']);
                $objPaciente->setEndereco($_POST['txtEndereco']);
                $objPaciente->setNome($_POST['txtNome']);
                $objPaciente->setObsPassaporte($_POST['txtObsPassaporte']);
                $objPaciente->setObsCPF($_POST['txtObsCPF']);
                $objPaciente->setObsEndereco($_POST['txtObsEndereco']);
                $objPaciente->setObsRG($_POST['txtObsRG']);

                if (isset($_POST['txtCodGAL']) && $_POST['txtCodGAL'] != null) {
                    if ($_POST['txtObsCodGAL'] != null) {
                        $objPaciente->setObsCodGAL($_POST['txtObsCodGAL']);
                    }
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
                }


                if (isset($_POST['cadastroPendente'])) {
                    if ($_POST['cadastroPendente'] == 'on') {
                        $objPaciente->setCadastroPendente('s');
                        $checked = ' checked ';
                    }
                } else {
                    $objPaciente->setCadastroPendente('n');
                }

                $objPaciente->setIdPaciente($_GET['idPaciente']);

                if (isset($_GET['idPaciente']) && !$erro) {

                    $objPacienteRN->alterar($objPaciente);
                    $alert .= Alert::alert_success("O paciente foi ALTERADO com sucesso");
                    $pacienteCadastrado = true;

                    if ($GAL) {
                        $objCodigoGAL->setIdPaciente_fk($_GET['idPaciente']);
                        $objCodigoGAL_RN->alterar($objCodigoGAL);
                        $alert .= Alert::alert_success("O código GAL do paciente foi ALTERADO com sucesso");
                    } else {
                        // $alert .= Alert::alert_danger("O código GAL do paciente não foi ALTERADO");
                    }
                } else if (isset($_GET['idPaciente']) && $erro) {
                    $alert .= Alert::alert_danger("O paciente não foi ALTERADO com sucesso");
                    $pacienteCadastrado = false;
                }

                /*
                 * COLETA AMOSTRA
                 */
                if ($pacienteCadastrado) {
                    $disabled = '';

                    if (isset($_GET['idPaciente']) && $_GET['idPaciente'] != null) {
                        $objAmostra->setIdPaciente_fk($_GET['idPaciente']);
                    }

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

                    if (isset($_GET['idAmostra']) && $_GET['idAmostra'] != null) {
                        $objAmostra->setIdAmostra($_GET['idAmostra']);
                    }

                    /*
                     * consegue o perfil do paciente, para pegar o caractere específico
                     */
                    $objPerfilPaciente->setIdPerfilPaciente($objAmostra->getIdPerfilPaciente_fk());
                    $arr_perfil = $objPerfilPacienteRN->listar($objPerfilPaciente);

                    $objAmostra->setCodigoAmostra($arr_perfil[0]->getCaractere() . $objAmostra->getIdAmostra());

                    if (!$data_erro && !$perfil_erro && !$situacao_erro) {
                        $objAmostraRN->alterar($objAmostra);
                        $alert .= Alert::alert_success("Amostra ALTERADA com sucesso");
                        $amostraCadastrada = true;

                        if ($objAmostra->get_a_r_g() == 'a' || $objAmostra->get_a_r_g() == 'r') {
                            /*
                             * Recém está criando a amostra então o tubo não veio de nenhum outro
                             */
                            
                            $objTubo->setIdAmostra_fk($_GET['idAmostra']);
                            $arr_tubosaux = $objTuboRN->listar($objTubo);
                            
                                                        
                            if(empty($arr_tubosaux)){
                                $objTubo->setIdTubo_fk(null);
                                $objTubo->setTuboOriginal('s');
                                $objTuboRN->cadastrar($objTubo);
                                $alert .= Alert::alert_success("Tubo CADASTRADO com sucesso");
                            }else{
                                $objTubo = $arr_tubosaux[0];
                                $alert .= Alert::alert_success("Tubo ALTERADO com sucesso");
                            }
                            
                           
                            $objInfosTubo->setIdTubo_fk($objTubo->getIdTubo());
                           
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
                            $objInfosTuboRN->cadastrar($objInfosTubo);
                            
                            $alert .= Alert::alert_success("Informações do tubo foram CADASTRADO com sucesso");
                        }
                        
                        
                    } else if ($data_erro || $perfil_erro || $situacao_erro) {
                        $alert .= Alert::alert_danger("Amostra não pode ser CADASTRADA");
                        $amostraCadastrada = false;
                    }
                }
            }
            if($pacienteCadastrado && $amostraCadastrada){
                Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra, $disabled, $onchange);
                Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, $disabled, $onchange);
                Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente, $disabled, $onchange);
                Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente, $disabled, $onchange);
                Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, $disabled, $onchange);
                Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra, $disabled, $onchange); //por default RS
                Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, $disabled, $onchange);
            }


            /* if (!isset($_POST['salvar_amostra'])) { //enquanto não enviou o formulário com as alterações
              $objAmostra->setIdAmostra($_GET['idAmostra']);
              $objAmostra = $objAmostraRN->consultar($objAmostra);
              Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra);

              $objPaciente->setIdPaciente($objAmostra->getIdPaciente_fk());
              $objPaciente = $objPacienteRN->consultar($objPaciente);

              if ($objPaciente->getRG() == null) {
              $objPaciente->setRG('');
              }

              if ($objPaciente->getIdSexo_fk() != 0) {
              $objSexoPaciente->setIdSexo($objPaciente->getIdSexo_fk());
              $objSexoPaciente = $objSexoPacienteRN->consultar($objSexoPaciente);
              Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente);
              }

              //$objPerfilPaciente->setIdPerfilPaciente($objPaciente->getIdPerfilPaciente_fk());
              $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
              Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objPaciente, $disabled);

              if ($objAmostra->getIdCodGAL_fk() != null) {
              $objCodigoGAL->setIdCodigoGAL($objAmostra->getIdCodGAL_fk());
              $objCodigoGAL->setIdPaciente_fk($objPaciente->setIdPaciente());
              $objCodigoGAL = $objCodigoGAL_RN->consultar($objCodigoGAL);
              }

              $objEstadoOrigem->setCod_estado($objAmostra->getIdEstado_fk());
              $objEstadoOrigem = $objEstadoOrigemRN->consultar($objEstadoOrigem);
              Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra); //por default RS

              $objLugarOrigem->setIdLugarOrigem($objAmostra->getIdLugarOrigem_fk());
              $objLugarOrigemRN->consultar($objLugarOrigem);
              Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra);
              }

              if (isset($_POST['salvar_amostra'])) {

              //Parte da coleta
              $objAmostra->setIdAmostra($_GET['idAmostra']);

              $objAmostra = $objAmostraRN->consultar($objAmostra);
              $objAmostra->setDataColeta($_POST['dtColeta']);
              $objAmostra->set_a_r_g($_POST['sel_aceita_recusada']);
              if ($_POST['sel_aceita_recusada'] == 'a') {
              $objAmostra->setStatusAmostra('Aguardando Preparação');
              } else if ($_POST['sel_aceita_recusada'] == 'r') {
              $objAmostra->setStatusAmostra('Descartada');
              }
              $objAmostra->setObservacoes($_POST['txtAreaObs']);
              $objAmostra->setIdEstado_fk(43); //ESTADO DO RS
              $objAmostra->setIdLugarOrigem_fk($_POST['sel_cidades']);
              $objAmostra->setIdNivelPrioridade_fk(1); //NIVEL DE PRIORIDADE

              if (isset($_POST['txtCodGAL'])) {
              $objCodigoGAL->setCodigo($_POST['txtCodGAL']);
              $objCodigoGAL->getIdPaciente_fk($objAmostra->getIdPaciente_fk());
              $objCodigoGAL_RN->alterar($objCodigoGAL);
              $objAmostra->setIdCodGAL_fk($objCodigoGAL->getIdCodigoGAL());
              }


              $objAmostraRN->alterar($objAmostra);

              $objPaciente->setIdPaciente($objAmostra->getIdPaciente_fk());
              $objPaciente = $objPacienteRN->consultar($objPaciente);
              $objPaciente->setCPF($_POST['txtCPF']);
              $objPaciente->setNome($_POST['txtNome']);
              $objPaciente->setDataNascimento($_POST['dtDataNascimento']);


              //RG
              if (isset($_POST['txtRG'])) {
              //echo $_POST['txtRG'];
              $objPaciente->setRG($_POST['txtRG']);
              $objPaciente->setObsRG('');
              } else if (isset($_POST['txtObsRG'])) {
              $objPaciente->setObsRG($_POST['txtObsRG']);
              } else if (!isset($_POST['txtRG']) && $_POST['txtRG'] = null && !isset($_POST['txtObsRG']) && $_POST['txtObsRG'] == null) {
              //echo "aqui";
              $objPaciente->setObsRG('Desconhecido');
              }

              //SEXO
              if (isset($_POST['sel_sexo'])) {
              $objPaciente->setIdSexo_fk($_POST['sel_sexo']);
              }

              //NOME MÃE
              if (isset($_POST['txtNomeMae'])) {
              $objPaciente->setNomeMae($_POST['txtNomeMae']);
              } else if (isset($_POST['txtNomeMae'])) {
              $objPaciente->setObsNomeMae($_POST['txtObsNomeMae']);
              } else if (!isset($_POST['txtNomeMae']) && !isset($_POST['txtObsNomeMae'])) {
              $objPaciente->setObsNomeMae('Desconhecido');
              }
              //print_r($objPaciente);
              //die("aqui");
              $objPacienteRN->alterar($objPaciente);

              Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra);
              Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra); //por default RS
              Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra);
              $alert = Alert::alert_success_editar();


              // header('Location: controlador.php?action=listar_amostra');
              } */

            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em CadastroAmostra.php');
    }
} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Cadastrar Amostra");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("amostra");
Pagina::getInstance()->adicionar_javascript("paciente");
?>
<script type="text/javascript">
    function validar(){
        Alert("validar");
        if(document.getElementById('idNome').value == ''){
            Alert("Informe o nome");
            return false;
        }
      return true; 
    }

</script>
<?php
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
//			DIE("INT80");
Pagina::montar_topo_listar('CADASTRAR AMOSTRA', 'cadastrar_amostra', 'NOVA AMOSTRA', 'listar_amostra', 'LISTAR AMOSTRAS');

echo $popUp;
echo $alert;



if (!isset($_GET['idPaciente']) && $_GET['action'] != 'editar_paciente' && $_GET['action'] != 'editar_amostra') {
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

if ($cadastrarNovo)
    echo '<small ' . $salvou . ' style="width:50%; margin-left:7%; color:red;">Informe o paciente desde o início ou procure por outro documento</small>';
if (isset($_GET['idPaciente']) || $cadastrarNovo) {
    ?>
    <div class="conteudo_grande">
        <form method="POST" onsubmit="validar()" >
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
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerObsNomeMae" style="display:none" >

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsNomeMae()"  name="obs"  type="radio" 
                                           class="custom-control-input" id="customControlValidation2" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidation2">Desconhecido</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onchange="val_radio_obsNomeMae()"  name="obs" type="radio" class="custom-control-input" id="customControlValidation3" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidation3">Outro</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control  mb-3">

                                    <input style="height: 35px; margin-left: -25px;margin-top: -5px;" readonly  type="text" class="form-control" id="idObsNomeMae" placeholder="motivo"  
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
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerCPF" style="display:none" >

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsCPF()"  name="obsCPF"  type="radio"  class="custom-control-input" 
                                           id="customControlValidationCPF2" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidationCPF2">Desconhecido</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onchange="val_radio_obsCPF()"  name="obsCPF" type="radio" class="custom-control-input" 
                                           id="customControlValidationCPF3" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidationCPF3">Outro</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control  mb-3">

                                    <input style="height: 35px; margin-left: -25px;margin-top: -5px;" readonly  
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
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerRG" style="display:none" >

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsRG()"  name="obsRG"  type="radio"  class="custom-control-input" 
                                           id="customControlValidationRG2" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidationRG2">Desconhecido</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onchange="val_radio_obsRG()"  name="obsRG" type="radio" class="custom-control-input" 
                                           id="customControlValidationRG3" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidationRG3">Outro</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control  mb-3">

                                    <input style="height: 35px; margin-left: -25px;margin-top: -5px;" readonly   
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
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerPassaporte" style="display:none" >

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsPassaporte()"  name="obsPassaporte"  type="radio"  class="custom-control-input" 
                                           id="passaporte" name="radio-stacked" >
                                    <label class="custom-control-label" for="passaporte">Desconhecido</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onchange="val_radio_obsPassaporte()"  name="obsPassaporte" type="radio" class="custom-control-input" 
                                           id="passaporte2" name="radio-stacked" >
                                    <label class="custom-control-label" for="passaporte2">Outro</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control  mb-3">

                                    <input style="height: 35px; maPassaportein-left: -25px;maPassaportein-top: -5px;" readonly  
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
                <div class="col-md-4 mb-4">
                    <label for="CEP" >CEP:</label> 
                    <input type="text" class="form-control " id="idCEP" placeholder=""  <?= $disabled ?>
                           onblur="validaCEP()" name="txtCEP" value="<?= $objPaciente->getCEP() ?>">
                    <div id ="feedback_cep"></div>
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerCEP" style="display:none" >

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsCEP()"  name="obsCEP"  type="radio"  class="custom-control-input" 
                                           id="customControlValidationCEP2" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidationCEP2">Desconhecido</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onchange="val_radio_obsCEP()"  name="obsCEP" type="radio" class="custom-control-input" 
                                           id="customControlValidationCEP3" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidationCEP3">Outro</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control  mb-3">

                                    <input style="height: 35px; maCEPin-left: -25px;maCEPin-top: -5px;" readonly  
                                           type="text" class="form-control" id="idObsCEP" placeholder="motivo"  
                                           onblur="validaObsCEP()" name="txtObsCEP" value="<?= $objPaciente->getObsCEP() ?>">
                                    <div id ="feedback_obsCEP"></div>

                                </div>
                            </div> 
                        </div>
                    </div>

                </div>
                <div class="col-md-4 mb-3">
                    <label for="label_endereco">Digite o Endereço:</label>
                    <input type="text" class="form-control " id="idEndereco" placeholder="Endereço" <?= $disabled ?>
                           onblur="validaEndereco()" name="txtEndereco" value="<?= $objPaciente->getEndereco() ?>">
                    <div id ="feedback_endereco"></div>
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerEndereco" style="display:none" >

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsEndereco()"  name="obsEndereco"  type="radio"  class="custom-control-input" 
                                           id="ValidationEndereco2" name="radio-stacked" >
                                    <label class="custom-control-label" for="ValidationEndereco2">Desconhecido</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onchange="val_radio_obsEndereco()"  name="obsEndereco" type="radio" class="custom-control-input" 
                                           id="ValidationEndereco3" name="radio-stacked" >
                                    <label class="custom-control-label" for="ValidationEndereco3">Outro</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control  mb-3">

                                    <input style="height: 35px; maEnderecoin-left: -25px;maEnderecoin-top: -5px;" readonly  
                                           type="text" class="form-control" id="idObsEndereco" placeholder="motivo"  
                                           onblur="validaObsEndereco()" name="txtObsEndereco" value="<?= $objPaciente->getObsEndereco() ?>">
                                    <div id ="feedback_obsEndereco"></div>

                                </div>
                            </div> 
                        </div>
                    </div>

                </div>

                <!--<?php // if ($SUS && $objCodigoGAL->getCodigo() != null) {     ?>-->
                <div class="col-md-4 mb-3">
                    <label for="label_codGal">Digite o código Gal:</label>
                    <input type="text" class="form-control" id="idCodGAL" <?= $disabled ?>
                           placeholder="000 0000 0000 0000" data-mask="000 0000 0000 0000" 
                           onblur="validaCodGAL()" name="txtCodGAL" value="<?= $objCodigoGAL->getCodigo() ?>">
                    <div id ="feedback_codGal"></div>
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerCodGAL" style="display:none" >

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsCodGAL()"  name="obsCodGAL"  type="radio"  class="custom-control-input" 
                                           id="ValidationCodGAL2" name="radio-stacked" >
                                    <label class="custom-control-label" for="ValidationCodGAL2">Desconhecido</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onchange="val_radio_obsCodGAL()"  name="obsCodGAL" type="radio" class="custom-control-input" 
                                           id="ValidationCodGAL3" name="radio-stacked" >
                                    <label class="custom-control-label" for="ValidationCodGAL3">Outro</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control  mb-3">

                                    <input style="height: 35px; maCodGALin-left: -25px;maCodGALin-top: -5px;" readonly  
                                           type="text" class="form-control" id="idObsCodGAL" placeholder="motivo"  
                                           onblur="validaObsCodGAL()" name="txtObsCodGAL" value="<?= $objPaciente->getObsCodGAL() ?>">
                                    <div id ="feedback_obsCodGAL"></div>

                                </div>
                            </div> 
                        </div>
                    </div>



                </div>
                <!-- <?php //}     ?>-->

            </div>  



            <div class="form-row">

                <div class="col-md-12">
                    <div class="custom-control custom-checkbox" style="float: right;">
                        <input type="checkbox" class="custom-control-input" <?= $checked ?> id="idCadastroPendente" <?= $disabled ?>
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
                    <input type="text" class="form-control" id="idMotivo" placeholder="Motivo " <?= $disabled ?>
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
                    <input type="text" class="form-control" id="idCEPAmostra" placeholder="00000-000 " <?= $disabled ?>
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
                    <input type="text" class="form-control" id="idObsLugarOrigem" placeholder="Desconhecido" <?= $disabled ?>
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


    <?php if (!$sumir) { ?> 
                <div class="form-row">
                    <div class="col-md-6" >
                        <button class="btn btn-primary" style="width: 50%;margin-left:45%;" type="submit" name="salvar_cadastro">Salvar</button>
                    </div>

                    <div class="col-md-6" >
                        <button type="button" class="btn btn-primary" data-toggle="modal" style="width: 50%;margin-left:0%;" data-target="#exampleModalCenter" > Cancelar</button>
                    </div>

                </div>
    <?php } else { ?>
            <!--    <div class="form-row">
                    <div class="col-md-6" >
                        <button class="btn btn-primary" style="width: 50%;margin-left:45%;" type="submit" name="editar_cadastro">Editar</button>
                    </div>
                </div> -->


    <?php } ?>

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
Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();

