<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../utils/Utils.php';
require_once '../utils/Alert.php';
require_once '../classes/Pagina/Interf.php';
require_once '../classes/Excecao/Excecao.php';

require_once '../classes/Paciente/Paciente.php';
require_once '../classes/Paciente/PacienteRN.php';

require_once '../classes/Etnia/Etnia.php';
require_once '../classes/Etnia/EtniaRN.php';

require_once '../classes/CodigoGAL/CodigoGAL.php';
require_once '../classes/CodigoGAL/CodigoGAL_RN.php';

require_once '../classes/Sexo/Sexo.php';
require_once '../classes/Sexo/SexoRN.php';

try {
    Sessao::getInstance()->validar();
    $alert = '';

    $selected_cpf = '';
    $invalid  ='';
        
    $selected_rg = '';
    $onchange = '';
    $selected_passaporte = '';
    $selected_codGal = '';
    $salvou = '';
    $utils = new Utils();
    $cadastrarNovo = false;

    $objPaciente = new Paciente();
    $objPacienteRN = new PacienteRN();

    $disabled = '';
    $checked = ' ';
    $select_sexos = '';
    $select_etnias = '';

    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $cadastro = false;
    $erro = '';
    $editar = false;
    $SUS = false;
    

    /* ETNIA */
    $objEtnia = new Etnia();
    $objEtniaRN = new EtniaRN();

    /* CÓDIGO GAL */
    $objCodigoGAL = new CodigoGAL();
    $objCodigoGAL_RN = new CodigoGAL_RN();


    /* SEXO PACIENTE */
    $objSexoPaciente = new Sexo();
    $objSexoPacienteRN = new SexoRN();

    Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente,$disabled,$onchange );
    Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente,$disabled,$onchange);


    $popUp = '';
    switch ($_GET['action']) {
        case 'cadastrar_paciente':

                      
            
            $paciente = array();
            if (isset($_GET['idPaciente'])) {
                $alert .= Alert::alert_success("Um paciente foi encontrado");
                $objPaciente->setIdPaciente($_GET['idPaciente']);
                $objPaciente = $objPacienteRN->consultar($objPaciente);
                
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


                Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente,$disabled,$onchange);
                Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente,$disabled,$onchange);
            } else if (!isset($_POST['salvar_paciente'])) {

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
                    header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_paciente&idPaciente='
                                    . $paciente[0]->getIdPaciente()));
                    //Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente);
                    //Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente);
                }

                if (isset($_POST['procurar_paciente_codGAL'])) {
                    if (isset($_POST['txtProcuraCodGAL']) && $_POST['txtProcuraCodGAL'] != '') {
                        $objCodigoGAL->setCodigo($_POST['txtProcuraCodGAL']);
                        $paciente = $objCodigoGAL_RN->listar($objCodigoGAL);

                        if ($paciente == null) {
                            $alert .= Alert::alert_warning("Nenhum paciente foi encontrado com esse campo (código GAL)");
                            $cadastrarNovo = true;
                            $SUS = true;
                        } else {
                            $SUS = true;
                            $objCodigoGAL = $paciente[0];
                            $objPaciente->setIdPaciente($objCodigoGAL->getIdPaciente_fk());
                            $objPaciente = $objPacienteRN->consultar($objPaciente);

                            Header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_paciente&idPaciente='
                                            . $objPaciente->getIdPaciente() . '&idCodigo=' . $objCodigoGAL->getCodigo()));
                            //$alert .= Alert::alert_success("código GAL");
                            //Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente);
                            //Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente);
                        }
                    } else {
                        $alert .= Alert::alert_warning("Informe o código GAL para a busca");
                    }
                }
            }


            if (isset($_POST['salvar_paciente'])) {
                $disabled = '';
                $erro = false;$GAL= false;
                if (isset($_GET['idPaciente'])){ //caso de o paciente já existir, então só vai ocorrer a alteração desse usuário
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
                    $disabled = ' disabled ';
                    $editar = true;
                    if($GAL){
                        $objCodigoGAL->setIdPaciente_fk($_GET['idPaciente']);
                        $objCodigoGAL_RN->alterar($objCodigoGAL);
                        $alert .= Alert::alert_success("O código GAL do paciente foi ALTERADO com sucesso");
                    }else{
                        //$alert .= Alert::alert_danger("O código GAL do paciente não foi ALTERADO");
                    }
                    
                    
                } else if (isset($_GET['idPaciente']) && $erro) {
                    $alert .= Alert::alert_danger("O paciente não foi ALTERADO com sucesso");
                }

                if ($cadastro && !$erro) {
                    if ($objPaciente->getNome() == '') {
                        $alert .= Alert::alert_danger("Informe o nome do paciente");
                        $invalid = ' is-invalid ';
                        $cadastrarNovo = true;
                        if($GAL) $GAL = true;
                        $editar = TRUE;
                    } else {
                        
                        $objPacienteRN->cadastrar($objPaciente);
                        if(!$GAL) {
                            $salvou = ' hidden ';
                            $disabled = ' disabled ';
                            $alert .= Alert::alert_success("O paciente foi CADASTRADO com sucesso");
                            $cadastrarNovo = true;
                            if($objPaciente->getCadastroPendente()== 's') $checked = ' checked ';
                            $editar = true;
                        }
                        
                        if($GAL){
                            
                            $objCodigoGAL->setIdPaciente_fk($objPaciente->getIdPaciente());
                            $objCodigoGAL->setCodigo($_POST['txtCodGAL']);
                            
                            if($objCodigoGAL_RN->cadastrar($objCodigoGAL)){
                                $alert .= Alert::alert_success("O paciente foi CADASTRADO com sucesso");
                                $alert .= Alert::alert_success("O código GAL do paciente foi CADASTRADO com sucesso");
                                $salvou = ' hidden ';
                                $disabled = ' disabled ';
                                $cadastrarNovo = true;
                                $editar = true;
                            }else{
                        
                                $alert .= Alert::alert_danger("O código GAL do paciente não foi CADASTRADO");
                                $objPacienteRN->remover($objPaciente);
                                $alert .= Alert::alert_danger("O paciente foi apagado");
                            }
                        }
                
                        
                    }
                    
                } else if ($cadastro && $erro) {
                    $cadastrarNovo = true;
                    $alert .= Alert::alert_danger("O paciente não foi CADASTRADO com sucesso");
                }

                Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente,$disabled,$onchange);
                Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente,$disabled,$onchange);

                

             
                 
            }
            break;

        case 'editar_paciente':
            
            $paciente = array();
            if (isset($_GET['idPaciente'])) {
                                                
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
            
            
            if (!isset($_POST['salvar_paciente'])) { //enquanto não enviou o formulário com as alterações
                $objPaciente->setIdPaciente($_GET['idPaciente']);
                $objPaciente = $objPacienteRN->consultar($objPaciente);
            }

            if (isset($_POST['salvar_paciente'])) { //se enviou o formulário com as alterações
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
                    
                    if($GAL){
                        $objCodigoGAL->setIdPaciente_fk($_GET['idPaciente']);
                        $objCodigoGAL_RN->alterar($objCodigoGAL);
                        $alert .= Alert::alert_success("O código GAL do paciente foi ALTERADO com sucesso");
                    }else{
                       // $alert .= Alert::alert_danger("O código GAL do paciente não foi ALTERADO");
                    }
                    
                    
                } else if (isset($_GET['idPaciente']) && $erro) {
                    $alert .= Alert::alert_danger("O paciente não foi ALTERADO com sucesso");
                }
                    
                    
                    
            }


            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_paciente.php');
    }
} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Cadastrar Paciente");
Pagina::getInstance()->adicionar_css("precadastros");
//Pagina::getInstance()->adicionar_javascript("fadeOut");
Pagina::getInstance()->adicionar_javascript("endereco");
Pagina::getInstance()->adicionar_javascript("paciente");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();



Pagina::montar_topo_listar('CADASTRAR PACIENTE', 'cadastrar_paciente', 'NOVO PACIENTE', 'listar_paciente', 'LISTAR PACIENTES');
//Pagina::montar_topo_listar('CADASTRAR PACIENTE', 'cadastrar_paciente', 'NOVO PACIENTE');
echo $popUp;
echo $alert;

if ((!isset($_GET['idPaciente']) && $_GET['action'] != 'editar_paciente')) {
    echo
    '<div class="conteudo_grande" '.$salvou.'>
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
                                 <input type="text" class="form-control cep-mask" id="idCPF" placeholder="Ex.: 000.000.000-00" 
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
                                 <input type="text" class="form-control" id="idRG" placeholder="" 
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
    echo '<small '.$salvou.' style="width:50%; margin-left:7%; color:red;">Informe o paciente desde o início ou procure por outro documento</small>';
if (isset($_GET['idPaciente']) || $cadastrarNovo ) {
    
    ?>
    <div class="conteudo_grande">
        <form method="POST" >
            <h2> Sobre o paciente </h2>
            <hr width = 2 size = 2>
            <div class="form-row" style="margin-top:10px;">
                <div class="col-md-3 mb-3">
                    <label for="label_nome">Digite o nome:</label>
                    <input type="text" class="form-control <?=$invalid?>" id="idNome" placeholder="Nome"  <?=$disabled?>
                           onblur="validaNome()" name="txtNome"  value="<?= $objPaciente->getNome() ?>">
                    <div id ="feedback_nome" ></div>

                </div>
                <div class="col-md-3 mb-9">
                    <label for="label_nomeMae">Digite o nome da mãe:</label>
                    <input type="text" class="form-control" id="idNomeMae" placeholder="Nome da mãe" <?=$disabled?>
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
                    <input type="date" class="form-control" id="idDtNascimento" placeholder="Data de nascimento"  <?=$disabled?>
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
                    <input type="text" class="form-control cep-mask" id="idCPF" placeholder="Ex.: 000.000.000-00"  <?=$disabled?>
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
                    <input type="txt" class="form-control" id="idRG" placeholder="RG" <?=$disabled?>
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
                    <input type="txt" class="form-control" id="idPassaporte" placeholder="Passaporte" <?=$disabled?>
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
                    <input type="text" class="form-control " id="idCEP" placeholder="00000-000"  <?=$disabled?>
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
                    <input type="text" class="form-control " id="idEndereco" placeholder="Endereço" <?=$disabled?>
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

    <?php if ($SUS && $objCodigoGAL->getCodigo() != null) { ?>
                    <div class="col-md-4 mb-3">
                        <label for="label_codGal">Digite o código Gal:</label>
                        <input type="text" class="form-control" id="idCodGAL" <?=$disabled?>
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
    <?php } ?>

            </div>  



            <div class="form-row">
                
                <div class="col-md-12">
                    <div class="custom-control custom-checkbox" style="float: right;">
                        <input type="checkbox" class="custom-control-input" <?= $checked ?> id="idCadastroPendente" <?=$disabled?>
                               name="cadastroPendente">
                        <label class="custom-control-label"  for="idCadastroPendente">Cadastro Pendente</label>
                    </div>
                </div>
            </div>

            <?php if(!$editar) { ?>
            <div class="form-row">
                <div class="col-md-6" >
                    <button class="btn btn-primary" style="width: 50%;margin-left:45%;" type="submit" name="salvar_paciente"<?=$salvou?>>Salvar</button>
                </div>

                <div class="col-md-6" >
                    <button type="button" class="btn btn-primary" data-toggle="modal" style="width: 50%;margin-left:0%;" data-target="#exampleModalCenter"  <?=$salvou?>> Cancelar</button>
                </div>
                
            </div>
            <?php } ?>

        </form>
         <?php if($editar){
               echo '<button style="margin-left:45%;" type="button"  class="btn btn-primary">'.
                    '<a style="color:white;text-decoration:none;" '
                       . 'href="'. Sessao::getInstance()->assinar_link('controlador.php?action=editar_paciente&idPaciente='.$objPaciente->getIdPaciente()).'">editar paciente</a></button>';     
         }?>


    </div>
<?php } ?>


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
                <button type="button"  class="btn btn-primary"><a href="<?= Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_paciente') ?>">Tenho certeza</a></button>
            </div>
        </div>
    </div>
</div>





<?php
Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();



