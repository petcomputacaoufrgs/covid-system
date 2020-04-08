<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Paciente/Paciente.php';
require_once 'classes/Paciente/PacienteRN.php';
require_once 'classes/CodigoGAL/CodigoGAL.php';
require_once 'classes/CodigoGAL/CodigoGAL_RN.php';
require_once 'classes/Relacionamento_codGAL_paciente/Rel_codGAL_paciente.php';
require_once 'classes/Relacionamento_codGAL_paciente/Rel_codGAL_paciente_RN.php';
require_once 'classes/PerfilPaciente/PerfilPaciente.php';
require_once 'classes/PerfilPaciente/PerfilPacienteRN.php';
require_once 'classes/Sexo/Sexo.php';
require_once 'classes/Sexo/SexoRN.php';

$liberar = false;
$objPagina = new Pagina();
$objPaciente = new Paciente();
$objPacienteRN = new PacienteRN();
$sucesso = '';
$select_sexos ='';
$select_perfis ='';
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//echo $actual_link;
$read_only = '';
$cpf_obrigatorio = '';
 
try {
    /* PERFIL PACIENTE */
    $objPerfilPaciente = new PerfilPaciente();
    $objPerfilPacienteRN = new PerfilPacienteRN();

    /* SEXO PACIENTE */
    $objSexoPaciente = new Sexo();
    $objSexoPacienteRN = new SexoRN();
    
    /* CÓDIGO GAL */
    $objCodigoGAL = new CodigoGAL();
    $objCodigoGAL_RN = new CodigoGAL_RN();

    /* RELACIONAMENTO CÓDIGO GAL E PACIENTE */
    $obj_rel_codigoGAL_paciente = new Rel_codGAL_paciente();
    $obj_rel_codigoGAL_paciente_RN = new Rel_codGAL_paciente_RN();
    
    
    
    
    
    montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente);
    montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objPaciente);
    
    
        
    switch ($_GET['action']) {
        case 'cadastrar_paciente':
            
            $liberar = false;
            if(isset($_POST['sel_perfil'])){
                $objPerfilPaciente->setIdPerfilPaciente($_POST['sel_perfil']);
                $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
                $liberar = true; // libera os próximos campos
                $objPaciente->setIdPerfilPaciente_fk($objPerfilPaciente->getIdPerfilPaciente());              
                montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objPaciente);
            }
            
            if(isset($_POST['sel_sexo'])){
                $objSexoPaciente->setIdSexo($_POST['sel_sexo']);
                $objSexoPaciente =  $objSexoPacienteRN->consultar($objSexoPaciente);
                $objPaciente->setIdSexo_fk($objSexoPaciente->getIdSexo());
                montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente);
            }
            
            if (isset($_POST['salvar_paciente'])) {
                
                // primeiro cadastra os dados do paciente
                $objPaciente->setNome($_POST['txtNome']);
                $objPaciente->setDataNascimento($_POST['dtDataNascimento']);
                $objPaciente->setCPF($_POST['txtCPF']);
                $objPaciente->setNomeMae($_POST['txtNomeMae']);
                $objPaciente->setObsNomeMae($_POST['txtObsNomeMae']);
                if($_POST['txtNomeMae'] == '' && $_POST['txtObsNomeMae'] == '') $objPaciente->setObsNomeMae('Desconhecido');
                $objPaciente->setRG($_POST['txtRG']);
                $objPaciente->setObsRG($_POST['txtObsRG']);
                if($_POST['txtRG'] == '' && $_POST['txtObsRG']='') $objPaciente->setObsRG('Desconhecido');
                
                
                if($objSexoPaciente != null) $objPaciente->setIdSexo_fk($objSexoPaciente->getIdSexo());
                else {
                    $objPaciente->setObsSexo($_POST['txtObsSexo']);
                    if($_POST['txtObsSexo']='') $objPaciente->setObsSexo('Desconhecido');
                }
                             
                $objPacienteRN->cadastrar($objPaciente);
                
                // depois cadastra os dados do código GAL
                $objCodigoGAL->setCodigo($_POST['txtCodGAL']);
                $objCodigoGAL_RN->cadastrar($objCodigoGAL);
                
                // depois cadastra os dados que relacionam código GAL com o paciente
                $obj_rel_codigoGAL_paciente->setIdCodigoGAL_fk($objCodigoGAL->getIdCodigoGAL());
                $obj_rel_codigoGAL_paciente->setIdPaciente_fk($objPaciente->getIdPaciente());
                $obj_rel_codigoGAL_paciente_RN->cadastrar($obj_rel_codigoGAL_paciente);
                
               
                $sucesso = '<div id="sucesso_bd" class="sucesso">Cadastrado com sucesso</div>';
            } else {
                $objPaciente->setIdPaciente('');
                $objPaciente->setCPF('');
                $objPaciente->setDataNascimento('');
                $objPaciente->setIdPerfilPaciente_fk('');
                $objPaciente->setIdSexo_fk('');
                $objPaciente->setNome('');
                $objPaciente->setNomeMae('');
                $objPaciente->setObsRG('');
                $objPaciente->setObsSexo('');
                $objPaciente->setRG('');
                
                $objCodigoGAL->setIdCodigoGAL('');
                $objCodigoGAL->setCodigo('');
                
                //$obj_rel_codigoGAL_paciente->
            }
            break;

        case 'editar_paciente':
            if (!isset($_POST['salvar_paciente'])) { //enquanto não enviou o formulário com as alterações
                $objPaciente->setIdPaciente($_GET['idPaciente']);
                $objPaciente = $objPacienteRN->consultar($objPaciente);
                montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objPaciente);
                if($objPaciente->getIdPerfilPaciente_fk() != 0){
                    montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente) ;
                }
                $objPerfilPaciente->setIdPerfilPaciente($objPaciente->getIdPerfilPaciente_fk());
                $objPerfilPaciente= $objPerfilPacienteRN->consultar($objPerfilPaciente);
                if ($objPerfilPaciente->getPerfil() != 'paciente sus') { //apenas pacientes sus tem acesso ao cod Gal
                    $read_only = ' readonly ';
                }
                
            }

            if (isset($_POST['salvar_paciente'])) { //se enviou o formulário com as alterações
                $objPaciente->setIdPaciente($_GET['idPaciente']);
                                
                if(isset($_GET['valuePerfilSelected'])) $objPaciente->setIdPerfilPaciente_fk($_GET['valuePerfilSelected']);
                else{
                    $objPaciente = $objPacienteRN->consultar($objPaciente);
                    $objPaciente->setIdPerfilPaciente_fk($objPaciente->getIdPerfilPaciente_fk());
                }
                
                if ($objPerfilPaciente->getPerfil() != 'paciente sus') {
                    if(!isset($_POST['txtCPF'])){
                        $objExcecao->adicionar_validacao('Insira o CPF do paciente.','idCPF');
                    }
                }
                $objPaciente->setCPF($_POST['txtCPF']);
                if ($objPerfilPaciente->getPerfil() == 'paciente sus') {
                    if(!isset($_POST['txtCodGAL'])){
                        $objExcecao->adicionar_validacao('Insira o código GAL do paciente.','idCodGAL');
                    }
                    $objPaciente->setCodGAL($_POST['idCodGAL']);
                }
                
                if(isset($_POST['txtRG'])){
                    $objPaciente->setRG($_POST['txtRG']);
                }
                                
                $objPaciente->setIdSexo_fk($_POST['sel_sexo']);
                if($_POST['txtObsSexo'] == null && $_POST['sel_sexo'] == null){
                    $objPaciente->setObsSexo('Não informado');
                }
                
                $objPaciente->setNomeMae($_POST['txtNomeMae']);
                if($_POST['txtObsNomeMae'] == null && $_POST['txtNomeMae'] == null){
                    $objPaciente->setObsNomeMae('Não informado');
                }
                
                $objPaciente->setDataNascimento($_POST['dtDataNascimento']);
                $objPaciente->setNome($_POST['txtNome']);
                
               
                $objPacienteRN->alterar($objPaciente);
                header('Location: controlador.php?action=listar_paciente');
                
                //$sucesso = '<div id="sucesso_bd" class="sucesso">Alterado com sucesso</div>';
            }


            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_paciente.php');
    }
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}


function montar_select_perfilPaciente(&$select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, &$objPaciente) {
    
    /* PERFIL DO PACIENTE */
    $selected = '';
    $arr_perfis= $objPerfilPacienteRN->listar($objPerfilPaciente);
       
    $select_perfis = '<select class="form-control selectpicker" onchange="this.form.submit()" '
            . 'id="select-country idSel_perfil" data-live-search="true" name="sel_perfil">'
            . '<option data-tokens="" ></option>';

    foreach ($arr_perfis as $perfil) {
        $selected = '';
        if ($perfil->getIdPerfilPaciente() == $objPaciente->getIdPerfilPaciente_fk()) {
            $selected = 'selected';
        }
        
        $select_perfis .= '<option ' . $selected . '  value="' . $perfil->getIdPerfilPaciente() . '" data-tokens="' . $perfil->getPerfil() . '">' . $perfil->getPerfil() . '</option>';
    }
    $select_perfis .= '</select>';
}

function montar_select_sexo(&$select_sexos, $objSexoPaciente, $objSexoPacienteRN, &$objPaciente) {
    /* SEXO DO PACIENTE */
    $selected = '';
    $arr_sexos= $objSexoPacienteRN->listar($objSexoPaciente);
       
    $select_sexos = '<select  onfocus="this.selectedIndex=0;" onchange="this.form.submit()" '
            . 'class="form-control selectpicker" id="select-country idSexo" '
            . 'data-live-search="true" name="sel_sexo">'
            . '<option data-tokens=""></option>';

    foreach ($arr_sexos as $sexo) {
         $selected = '';
        if ($sexo->getIdSexo() == $objPaciente->getIdSexo_fk()) {
            $selected = 'selected';
        }
        $select_sexos .= '<option ' . $selected . '  value="' . $sexo->getIdSexo() . '" data-tokens="' . $sexo->getSexo() . '">' . $sexo->getSexo() . '</option>';
    }
    $select_sexos .= '</select>';
}



?>

<?php Pagina::abrir_head("Cadastrar Paciente"); ?>
<style>
     body,html{
        font-size: 20px !important;
    }
    .dropdown-toggle{

        height: 45px;
    }
    .btn-default{
        border: 1px solid red;
    }
    .placeholder_colored::-webkit-input-placeholder  {
        color: red;
        text-align: left;
    } 
    .sucesso{
        width: 100%;
        background-color: green;
    }
    .formulario{
        margin: 50px;
    }
</style>

<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo(); ?>


<?= $sucesso ?>
<div class="formulario">
    <form method="POST">
        <div class="form-row">  

            <div class="col-md-12">
                <label for="perfil">Perfil:</label>
                    <?= $select_perfis ?>
            </div>
        </div>
                <?php
                if (!$liberar) {
                    echo '<small style="color:red;"> Nenhum perfil foi selecionado</small>';
                } else {
                    ?> 


            <div class="form-row" style="margin-top:10px;">
                
                <div class="col-md-4 mb-3">
                    <label for="label_nome">Digite o nome:</label>
                    <input type="text" class="form-control" id="idNome" placeholder="Nome" 
                           onblur="validaNome()" name="txtNome" required value="<?= $objPaciente->getNome() ?>">
                    <div id ="feedback_nome"></div>

                </div>
                
                <!-- Nome da mãe -->
                <div class="col-md-4 mb-9">
                    <label for="label_nomeMae">Digite o nome da mãe:</label>
                    <input type="text" class="form-control" id="idNomeMae" placeholder="Nome da mãe" 
                           onblur="validaNomeMae()" name="txtNomeMae" required value="<?= $objPaciente->getNomeMae() ?>">
                    <div id ="feedback_nomeMae"></div>
                    
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerObsNomeMae" style="display:none" >
                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsNomeMae()"  name="obs"  type="radio"  class="custom-control-input" id="customControlValidation2" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidation2">Não informado</label>
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
                                           onblur="validaObsNomeMae()" name="txtObsNomeMae" required value="<?= $objPaciente->getObsNomeMae() ?>">
                                    <div id ="feedback_obsNomeMae"></div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Data de nascimento -->
                <div class="col-md-4 mb-3">
                    <label for="label_dtNascimento">Digite a data de nascimento:</label>
                    <input type="date" class="form-control" id="idDataNascimento" placeholder="Data de nascimento"  
                           onblur="validaDataNascimento()" name="dtDataNascimento"  max="<?php echo date('Y-m-d'); ?>" required value="<?= $objPaciente->getDataNascimento() ?>">
                    <div id ="feedback_dtNascimento"></div>
                </div>
            </div>  

          
            <div class="form-row">
                 <!-- Sexo -->
                <div class="col-md-3 mb-4">
                    <label for="sexoPaciente" >Sexo:</label>
                    <?= $select_sexos ?>
                    <div id ="feedback_sexo"></div>
                
                <div class="desaparecer_aparecer" id="id_desaparecer_aparecerObsSexo" style="margin-top:25px;" >

                        <div class="form-row align-items-center" >
                            <div class="col-auto mb-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsSexo()"  name="obsSexo" value="naoInformado" type="radio"  class="custom-control-input" id="customControlValidationSexo" name="radio-stacked2" >
                                    <label class="custom-control-label" for="customControlValidationSexo">Não informado </label>
                                </div>
                            </div>

                            <div class="col-auto mb-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onchange="val_radio_obsSexo()"  name="obsSexo" value="outro" type="radio" class="custom-control-input" id="customControlValidationSexo2" name="radio-stacked2" >
                                    <label class="custom-control-label" for="customControlValidationSexo2">Outro</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control  mb-2">

                                    <input style="height: 35px;margin-left: -25px;margin-top: -15px;" readonly  type="text" class="form-control" id="idObsSexo" placeholder="motivo"  
                                           onblur="validaObsSexo()" name="txtObsSexo" required value="<?= $objPaciente->getObsSexo() ?>">
                                    <div id ="feedback_obsNomeMae"></div>

                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
                 
                <!-- CPF -->
                <div class="col-md-3 mb-4">
                    <label for="label_cpf">Digite o CPF:</label>
                    <input type="text" class="form-control cep-mask" id="idCPF" placeholder="Ex.: 000.000.000-00" 
                           onblur="validaCPF()" name="txtCPF" required value="<?= $objPaciente->getCPF() ?>">
                    <div id ="feedback_cpf"></div>

                </div>
                
                <!-- RG -->
                <div class="col-md-3 mb-3">
                    <label for="label_rg">Digite o RG:</label>
                    <input type="txt" class="form-control" id="idRG" placeholder="RG" 
                           onblur="validaRG()" name="txtRG" value="<?= $objPaciente->getRG() ?>">
                    <div id ="feedback_rg"></div>
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerObsRG" style="margin-top:25px; display: none;" >

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsRG()"  name="obsRG" value="naoInformado" type="radio"  
                                           class="custom-control-input" id="customControlValidationRG" name="radio-stacked3" >
                                    <label class="custom-control-label" for="customControlValidationRG">Não informado </label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onchange="val_radio_obsRG()"  name="obsRG" value="outro" type="radio" 
                                           class="custom-control-input" id="customControlValidationRG2" name="radio-stacked3" >
                                    <label class="custom-control-label" for="customControlValidationRG2">Outro</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control  mb-3">

                                    <input style="height: 35px;margin-left: -25px;margin-top: -5px;" readonly  
                                           type="text" class="form-control" id="idObsRG" placeholder="motivo"  
                                           onblur="validaObsRG()" name="txtObsRG" required value="<?= $objPaciente->getObsRG() ?>">
                                    <div id ="feedback_obsRG"></div>

                                </div>
                            </div>
                        </div>
                    </div>
                    

                </div>
                
                <?php if($objPerfilPaciente->getPerfil() == 'Pacientes SUS') { ?>
                    <!-- CÓDIGO GAL -->
                    <div class="col-md-3 mb-3">
                        <label for="label_codGal">Digite o código Gal:</label>
                        <input type="text" class="form-control" id="idCodGAL" placeholder="000 0000 0000 0000" data-mask="000 0000 0000 0000"  <?= $read_only ?>
                               onblur="validaCodGAL()" name="txtCodGAL" required value="<?= $objCodigoGAL->getCodigo() ?>">
                        <div id ="feedback_codGal"></div>

                    </div>
                <?php } ?>

            </div>  
            <button class="btn btn-primary" type="submit" name="salvar_paciente">Salvar</button>
        <?php } ?>
    </form>



</div>



<script src="js/paciente.js"></script>
<script src="js/fadeOut.js"></script>
<script>
 
function val() {
    $('.selectpicker').change(function (e) {
        //alert(e.target.value);
        //document.getElementById("class1").innerHTML = e.target.value ;
        window.location.href = "controlador.php?action=cadastrar_paciente&valuePerfilSelected=" + e.target.value; 
        /*$.post("cadastro_paciente.php", {perfilSelecionado:e.target.value},function(data){
            alert("data sent and received: "+data);
        });*/

    });    
 }
 
 function val_sexo() {
    $('.selectpicker').change(function (e) {
        alert(e.target.value);
        //document.getElementById("class1").innerHTML = e.target.value ;
        
        /*$.post("cadastro_paciente.php", {perfilSelecionado:e.target.value},function(data){
            alert("data sent and received: "+data);
        });*/

    });    
 }
                        function val_radio_obsNomeMae() {

                               var radios = document.getElementsByName('obs');
                               //var input_outro = document.getElementById('idObsNomeMae');
                               for (var i = 0, length = radios.length; i < length; i++) {
                                   if (radios[0].checked) {
                                       // do whatever you want with the checked radio
                                       //alert("desconhecido");
                                       document.getElementById('idObsNomeMae').readOnly = true;
                                       // only one radio can be logically checked, don't check the rest
                                       break;
                                   }
                                   if (radios[1].checked) {
                                       // do whatever you want with the checked radio
                                       //alert("outro");
                                       document.getElementById('idObsNomeMae').readOnly = false;
                                       // only one radio can be logically checked, don't check the rest
                                       break;
                                   }
                               }

                           }
                           
                           function val_radio_obsCPF() {

                               var radios = document.getElementsByName('obsCPF');
                               //var input_outro = document.getElementById('idObsNomeMae');
                               for (var i = 0, length = radios.length; i < length; i++) {
                                   if (radios[0].checked) {
                                       // do whatever you want with the checked radio
                                       //alert("desconhecido");
                                       document.getElementById('idObsCPF').readOnly = true;
                                       // only one radio can be logically checked, don't check the rest
                                       break;
                                   }
                                   if (radios[1].checked) {
                                       // do whatever you want with the checked radio
                                       //alert("outro");
                                       document.getElementById('idObsCPF').readOnly = false;
                                       // only one radio can be logically checked, don't check the rest
                                       break;
                                   }
                               }

                           }
                           
                           function val_radio_obsRG() {

                               var radios = document.getElementsByName('obsRG');
                               //var input_outro = document.getElementById('idObsNomeMae');
                               for (var i = 0, length = radios.length; i < length; i++) {
                                   if (radios[0].checked) {
                                       // do whatever you want with the checked radio
                                       //alert("desconhecido");
                                       document.getElementById('idObsRG').readOnly = true;
                                       // only one radio can be logically checked, don't check the rest
                                       break;
                                   }
                                   if (radios[1].checked) {
                                       // do whatever you want with the checked radio
                                       //alert("outro");
                                       document.getElementById('idObsRG').readOnly = false;
                                       // only one radio can be logically checked, don't check the rest
                                       break;
                                   }
                               }

                           }
                           
                           
                           function val_radio_obsSexo() {

                               var radios = document.getElementsByName('obsSexo');
                               //var input_outro = document.getElementById('idObsNomeMae');
                               for (var i = 0, length = radios.length; i < length; i++) {
                                   if (radios[0].checked) {
                                       document.getElementById('idObsSexo').readOnly = true;
                                       break;
                                   }
                                   if (radios[1].checked) {
                                       document.getElementById('idObsSexo').readOnly = false;
                                       break;
                                   }
                               }

                           }

</script>






<?php
$objPagina->mostrar_excecoes();
$objPagina->fechar_corpo();
?>


