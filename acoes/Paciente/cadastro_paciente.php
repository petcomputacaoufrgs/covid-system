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
    $selected_rg = '';
    $selected_passaporte = '';
    $selected_codGal = '';
    
    $utils = new Utils();
    $cadastrarNovo = false;

    $objPaciente = new Paciente();
    $objPacienteRN = new PacienteRN();
    $checked = ' ';
    $select_sexos = '';
    $select_etnias = '';

    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    
    $erro = '';

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

    Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente);
    Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente);


    $popUp = '';
    switch ($_GET['action']) {
        case 'cadastrar_paciente':
            
            if(isset($_GET['idPaciente'])){
                $alert .= Alert::alert_success("Um paciente foi encontrado");
            }
            
            $paciente = array();
            if (isset($_GET['idPaciente'])) {

                $objPaciente->setIdPaciente($_GET['idPaciente']);
                $objPaciente = $objPacienteRN->consultar($objPaciente);
                //print_r($objPaciente);
            } else if (!isset($_POST['salvar_paciente'])) {

                if (isset($_POST['sel_opcoesCadastro']) ) {
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
                    if(isset($_POST['txtProcuraCPF']) && $_POST['txtProcuraCPF'] != ''){
                        $objPaciente->setCPF($_POST['txtProcuraCPF']);
                        $paciente = $objPacienteRN->procurar($objPaciente);

                        if ($paciente == null) {
                            $alert .= Alert::alert_warning("Nenhum paciente foi encontrado com esse campo (CPF)");
                            $cadastrarNovo = true;
                        } else {
                            $alert .= Alert::alert_success("Foi encontrado paciente com esse campo (CPF)");
                        }
                    }else{
                        $alert .= Alert::alert_warning("Informe o CPF para a busca");
                         
                        
                    }
                }

                if (isset($_POST['procurar_paciente_passaporte'])) {
                    if(isset($_POST['txtProcuraPassaporte']) && $_POST['txtProcuraPassaporte'] != ''){
                        $objPaciente->setPassaporte($_POST['txtProcuraPassaporte']);
                        $paciente = $objPacienteRN->procurar($objPaciente);

                        if ($paciente == null) {
                            $alert .= Alert::alert_warning("Nenhum paciente foi encontrado com esse campo (passaporte)");
                            $cadastrarNovo = true;
                        } else {
                            $alert .= Alert::alert_success("Foi encontrado paciente com esse campo (passaporte)");
                            
                        }
                    }else{
                        $alert .= Alert::alert_warning("Informe o passaporte para a busca");
                        
                    }
                }

                if (isset($_POST['procurar_paciente_RG'])) {
                    if(isset($_POST['txtProcuraRG']) && $_POST['txtProcuraRG'] != ''){
                        $objPaciente->setRG($_POST['txtProcuraRG']);
                        $paciente = $objPacienteRN->procurar($objPaciente);

                        if ($paciente == null) {
                            $alert .= Alert::alert_warning("Nenhum paciente foi encontrado com esse campo (RG)");
                            $cadastrarNovo = true;
                        } else {
                            $alert .= Alert::alert_success("Foi encontrado paciente com esse campo (RG)");
                        }
                    }else{
                        $alert .= Alert::alert_warning("Informe o RG para a busca");
                       
                    }
                }

                if (!empty($paciente)) {
                    $objPaciente = $paciente[0];
                    header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_paciente&idPaciente='
                                    . $paciente[0]->getIdPaciente()));
                    //Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente);
                    //Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente);
                }

                if (isset($_POST['procurar_paciente_codGAL'])) {
                    if(isset($_POST['txtProcuraCodGAL']) && $_POST['txtProcuraCodGAL'] != ''){
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
                                            . $objPaciente->getIdPaciente()));
                            //$alert .= Alert::alert_success("código GAL");
                            //Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente);
                            //Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente);
                        }
                    }else{
                        $alert .= Alert::alert_warning("Informe o código GAL para a busca");
                    }
                }
            }


            if (isset($_POST['salvar_paciente'])) {
                //print_r($objPaciente);

                $objPaciente->setCPF($_POST['txtCPF']);
                $CPFs = $objPacienteRN->procurarCPF($objPaciente);
                
                if(!empty($CPFs) && $CPFs[0]->getCPF() != '') {$alert .= Alert::alert_primary("O CPF já está associado a outro paciente");}
                
                
                $objPaciente->setRG($_POST['txtRG']);
                $RGS = $objPacienteRN->procurarRG($objPaciente);
                if(!empty($RGS) && $RGS[0]->getRG() != '') {$alert .= Alert::alert_primary("O RG já está associado a outro paciente");}
                

                //$objPaciente->setObsPassaporte($_POST['idObsPassaporte']);
                $objPaciente->setNomeMae($_POST['txtNomeMae']);
                $objPaciente->setEndereco($_POST['txtEndereco']);
                $objPaciente->setNome($_POST['txtNome']);
                $objPaciente->setPassaporte($_POST['txtPassaporte']);
                $objPaciente->setObsPassaporte($_POST['txtObsPassaporte']);
                $objPaciente->setObsCPF($_POST['txtObsCPF']);
                $objPaciente->setObsEndereco($_POST['txtObsEndereco']);
                $objPaciente->setObsRG($_POST['txtObsRG']);

                if (isset($_POST['sel_etnias']) && $_POST['sel_etnias'] != '') {
                    $objPaciente->setIdEtnia_fk($_POST['sel_etnias']);
                }

                if (isset($_POST['sel_sexo']) && $_POST['sel_sexo'] != '') {
                    //echo $_POST['sel_sexo'];
                    $objPaciente->setIdSexo_fk($_POST['sel_sexo']);
                }

                if (isset($_POST['dtDataNascimento']) && $_POST['dtDataNascimento'] != '' && $_POST['dtDataNascimento'] != null) {
                    $objPaciente->setDataNascimento($_POST['dtDataNascimento']);
                }ELSE{
                    $objPaciente->setDataNascimento(NULL);
                }
               


                $objPaciente->setCEP($_POST['txtCEP']);

                if (isset($_POST['cadastroPendente'])) {
                    if ($_POST['cadastroPendente'] == 'on'){
                        $objPaciente->setCadastroPendente('s');
                        $checked = ' checked ';
                    }
                    
                }else {
                    $objPaciente->setCadastroPendente('n');
                }

                if(!empty($CPFs) && !empty($RGS)){
                    if(!empty($RGS)){
                        //print_r ($RGS);
                        $objPaciente->setIdPaciente($RGS[0]->getIdPaciente());
                    }
                    if(!empty($CPFs)){
                        //print_r ($CPFs);
                        $objPaciente->setIdPaciente($CPFs[0]->getIdPaciente());
                    }
                    //die("aqui");
                    $objPacienteRN->alterar($objPaciente);
                    $alert .= Alert::alert_warning("O paciente foi ALTERADO com sucesso");
                }else{
                    $objPacienteRN->cadastrar($objPaciente);
                     $alert .= Alert::alert_success("O paciente foi CADASTRADO com sucesso");
                }


                if ($objPaciente->getIdSexo_fk() != null) {
                    Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente);
                }
                if ($objPaciente->getIdEtnia_fk() != null) {
                    Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente);
                }
               

                if (isset($_POST['txtCodGAL']) && $_POST['txtCodGAL'] != null) {
                    $objCodigoGAL->setCodigo($_POST['txtCodGAL']);
                    $objCodigoGAL->setIdPaciente_fk($objPaciente->getIdPaciente());
                    $arr = $objCodigoGAL_RN->listar($objCodigoGAL);
                    if (empty($arr)) {
                        $objCodigoGAL_RN->cadastrar($objCodigoGAL);
                        $alert .= Alert::alert_success("O código GAL foi cadastrado");
                    } else {
                        $alert .= Alert::alert_primary("O código GAL informado já havia sido cadastrado");
                    }
                }
            
                
            }
            break;

        case 'editar_paciente':
            if (!isset($_POST['salvar_paciente'])) { //enquanto não enviou o formulário com as alterações
              $objPaciente->setIdPaciente($_GET['idPaciente']);
              $objPaciente = $objPacienteRN->consultar($objPaciente);
              }

              if (isset($_POST['salvar_paciente'])) { //se enviou o formulário com as alterações
              $objPaciente->setIdPaciente($_GET['idPaciente']);
              $objPaciente->setPaciente(mb_strtolower($_POST['txtPaciente'], 'utf-8'));
              $objPacienteRN->alterar($objPaciente);
              $sucesso = '<div id="sucesso_bd" class="sucesso">Alterado com sucesso</div>';
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
    '<div class="formulario">
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
        if ($_POST['sel_opcoesCadastro'] == 'CPF') {
            echo '<div class="formulario">
                    <form method="POST">
                        <div class="form-row"> 
                            <div class="col-md-10">
                                 <label for="label_cpf">Digite o CPF:</label>
                                 <input type="text" class="form-control cep-mask" id="idCPF" placeholder="Ex.: 000.000.000-00" 
                                           onblur="valida_cpf()" name="txtProcuraCPF"  value="' . Pagina::formatar_html($objPaciente->getCPF()) . '">
                                    <div id ="feedback_cpf"></div>
                            </div>
                            <div class="col-md-2"><button class="btn btn-primary" 
                            style="width: 100%; height: 55%;margin:0px;margin-top:30px;" type="submit" 
                            name="procurar_paciente_CPF">Procurar</button></div>
                        </div>

                    </form>   
                </div>';
        } else if ($_POST['sel_opcoesCadastro'] == 'codGal') {
            echo '<div class="formulario">
                    <form method="POST">
                        <div class="form-row"> 
                            <div class="col-md-10">
                                 <label for="label_codGAL">Digite o código GAL:</label>
                                 <input type="text" class="form-control" id="idCodGAL" placeholder="" 
                                           onblur="" name="txtProcuraCodGAL"  value="' . Pagina::formatar_html($objCodigoGAL->getCodigo()) . '">
                                    <div id ="feedback_codGal"></div>
                            </div>
                            <div class="col-md-2"><button class="btn btn-primary" 
                            style="width: 100%; height: 55%;margin:0px;margin-top:30px;" type="submit" 
                            name="procurar_paciente_codGAL">Procurar</button></div>
                        </div>

                    </form>   
                </div>';
        } else if ($_POST['sel_opcoesCadastro'] == 'RG') {
            echo '<div class="formulario">
                    <form method="POST">
                        <div class="form-row"> 
                            <div class="col-md-10">
                                 <label for="label_rg">Digite o RG:</label>
                                 <input type="text" class="form-control" id="idRG" placeholder="" 
                                           onblur="" name="txtProcuraRG"  value="' . Pagina::formatar_html($objPaciente->getRG()) . '">
                                    <div id ="feedback_RG"></div>
                            </div>
                            <div class="col-md-2"><button class="btn btn-primary" 
                            style="width: 100%; height: 55%;margin:0px;margin-top:30px;" type="submit" 
                            name="procurar_paciente_RG">Procurar</button></div>
                        </div>

                    </form>   
                </div>';
        } else if ($_POST['sel_opcoesCadastro'] == 'passaporte') {
            echo '<div class="formulario">
                    <form method="POST">
                        <div class="form-row"> 
                            <div class="col-md-10">
                                 <label for="label_passaporte">Digite o passaporte:</label>
                                 <input type="text" class="form-control" id="idPassaporte" placeholder="" 
                                           onblur="" name="txtProcuraPassaporte"  value="' . Pagina::formatar_html($objPaciente->getPassaporte()) . '">
                                    <div id ="feedback_passaporte"></div>
                            </div>
                            <div class="col-md-2"><button class="btn btn-primary" 
                            style="width: 100%; height: 55%;margin:0px;margin-top:30px;" type="submit" 
                            name="procurar_paciente_passaporte">Procurar</button></div>
                        </div>

                    </form>   
                </div>';
        }
    }
}

if (isset($_GET['idPaciente']) || $cadastrarNovo) {
    ?>
    <div class="formulario">
        <form method="POST">
            <h2> Sobre o paciente </h2>
            <hr width = 2 size = 2>
            <div class="form-row" style="margin-top:10px;">
                <div class="col-md-3 mb-3">
                    <label for="label_nome">Digite o nome:</label>
                    <input type="text" class="form-control" id="idNome" placeholder="Nome" 
                           onblur="validaNome()" name="txtNome"  value="<?= $objPaciente->getNome() ?>">
                    <div id ="feedback_nome"></div>

                </div>
                <div class="col-md-3 mb-9">
                    <label for="label_nomeMae">Digite o nome da mãe:</label>
                    <input type="text" class="form-control" id="idNomeMae" placeholder="Nome da mãe" 
                           onblur="validaNomeMae()" name="txtNomeMae" value="<?= $objPaciente->getNomeMae() ?>">
                    <div id ="feedback_nomeMae"></div>
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerObsNomeMae" style="display:none" >

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsNomeMae()"  name="obs"  type="radio"  class="custom-control-input" id="customControlValidation2" name="radio-stacked" >
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
                    <input type="date" class="form-control" id="idDtNascimento" placeholder="Data de nascimento"  
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
                    <input type="text" class="form-control cep-mask" id="idCPF" placeholder="Ex.: 000.000.000-00" 
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
                    <input type="txt" class="form-control" id="idRG" placeholder="RG" 
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
                    <input type="txt" class="form-control" id="idPassaporte" placeholder="Passaporte" 
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

                <div class="col-md-4 mb-4">
                    <label for="CEP" >CEP:</label>
                    <input type="text" class="form-control " id="idCPF" placeholder="00000-000" 
                           onblur="getDadosEnderecoPorCEP(this.value)" name="txtCEP" value="<?= $objPaciente->getCEP() ?>">
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
                    <input type="text" class="form-control " id="idEndereco" placeholder="Endereço" 
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

                <?php if($SUS){ ?>
                <div class="col-md-4 mb-3">
                    <label for="label_codGal">Digite o código Gal:</label>
                    <input type="text" class="form-control" id="idCodGAL" placeholder="000 0000 0000 0000" data-mask="000 0000 0000 0000" 
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
                        <input type="checkbox" class="custom-control-input" <?= $checked ?> id="idCadastroPendente" name="cadastroPendente">
                        <label class="custom-control-label"  for="idCadastroPendente">Cadastro Pendente</label>
                    </div>
                </div>
            </div>
            
            <div class="form-row">

                <div class="col-md-6" >
                <button class="btn btn-primary" style="width: 50%;margin-left:45%;" type="submit" name="salvar_paciente">Salvar</button>
                </div>
                <div class="col-md-6" >
                   
                <!--<button class="btn btn-primary" style="width: 50%;margin-left:0%;" data-toggle="modal" type="button" name="cancelar_cadastro">Cancelar</button>-->
                <button type="button" class="btn btn-primary" data-toggle="modal" style="width: 50%;margin-left:0%;" data-target="#exampleModalCenter"> Cancelar</button>
                </div>
            </div>

        </form>



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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button"  class="btn btn-primary"><a href="<?=Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_paciente')?>">Tenho certeza</a></button>
      </div>
    </div>
  </div>
</div>





<?php
Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();



