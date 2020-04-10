<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Usuario/Usuario.php';
require_once 'classes/Usuario/UsuarioRN.php';

require_once 'classes/PerfilUsuario/PerfilUsuario.php';
require_once 'classes/PerfilUsuario/PerfilUsuarioRN.php';

require_once 'classes/Recurso/Recurso.php';
require_once 'classes/Recurso/RecursoRN.php';

/* Relacionamentos */
require_once 'classes/Rel_usuario_perfilUsuario/Rel_usuario_perfilUsuario.php';
require_once 'classes/Rel_usuario_perfilUsuario/Rel_usuario_perfilUsuario_RN.php';

require_once 'classes/Rel_perfilUsuario_recurso/Rel_perfilUsuario_recurso.php';
require_once 'classes/Rel_perfilUsuario_recurso/Rel_perfilUsuario_recurso_RN.php';

/* UTILIDADES */
require_once 'utils/Utils.php';
require_once 'utils/Alert.php';
$utils = new Utils();
$objPagina = new Pagina();
$alert = "";
$select_usuario = '';
$select_perfilUsu = '';
$select_recurso = '';
$select_usuario_perfilUsu = '';
$select_perfilUsu_recurso = '';
$perfis_selecionados ='';
$aparecer_recursos = false;

try {
    
    /* USUÁRIO */
    $objUsuario = new Usuario();
    $objUsuarioRN = new UsuarioRN();
    
    /* PERFIL DO USUÁRIO */
    $objPerfilUsuario = new PerfilUsuario();
    $objPerfilUsuarioRN = new PerfilUsuarioRN();
    
    /* RECURSO */
    $objRecurso = new Recurso();
    $objRecursoRN = new RecursoRN();
    
    /* USUÁRIO + PERFIL DO USUÁRIO */
    $objRel_usuario_perfilUsuario = new Rel_usuario_perfilUsuario();
    $objRel_usuario_perfilUsuario_RN = new Rel_usuario_perfilUsuario_RN();
    
    /* PERFIL USUÁRIO + RECURSO */
    $objRel_perfilUsuario_recurso = new Rel_perfilUsuario_recurso();
    $objRel_perfilUsuario_recurso_RN = new Rel_perfilUsuario_recurso_RN();
        
    montar_select_usuario($select_usuario, $objUsuarioRN,$objUsuario,$aparecer_recursos);
    montar_select_perfil($select_perfilUsu, $objPerfilUsuarioRN,$objPerfilUsuario,$perfis_selecionados,$aparecer_recursos);
    
    
    switch ($_GET['action']) {
        case 'cadastrar_rel_usuario_perfil_recurso':
            if(isset($_POST['sel_usuario'])){
                $objUsuario->setIdUsuario($_POST['sel_usuario']);
                $objUsuario = $objUsuarioRN->consultar($objUsuario);
                montar_select_usuario($select_usuario, $objUsuarioRN,$objUsuario,$aparecer_recursos);
            }
            
            if (isset($_POST['salvar_upr'])) {
                   if(isset($_POST['sel_perfis'])){
                       //echo count($_POST['sel_perfis']);
                       $i=0;
                       for($i=0; $i<count($_POST['sel_perfis']); $i++){
                           //echo $_POST['sel_perfis'][$i];
                           $perfis_selecionados.= $_POST['sel_perfis'][$i].";";
                           $objRel_usuario_perfilUsuario->setIdUsuario_fk($objUsuario->getIdUsuario());
                           $objRel_usuario_perfilUsuario->setIdPerfilUsuario_fk($_POST['sel_perfis'][$i]);
                           $arrUP = $objRel_usuario_perfilUsuario_RN->validar_cadastro($objRel_usuario_perfilUsuario);
                           if(empty($arrUP)){
                               $objRel_usuario_perfilUsuario_RN->cadastrar($objRel_usuario_perfilUsuario);
                               $alert = Alert::alert_success_cadastrar();
                           }else{$alert = Alert::alert_error_cadastrar_editar(); }
                       }
                   }
                   $aparecer_recursos = true;
                   montar_select_usuario($select_usuario, $objUsuarioRN,$objUsuario,$aparecer_recursos);
                   montar_select_perfil($select_perfilUsu, $objPerfilUsuarioRN,$objPerfilUsuario,$perfis_selecionados,$aparecer_recursos);
            } else {
                /*$objSexo->setIdSexo('');
                $objSexo->setSexo('');
                $objSexo->setIndex_sexo('');*/
            }
            break;

        case 'editar_rel_usuario_perfil_recurso':
            if (!isset($_POST['salvar_sexoPaciente'])) { //enquanto não enviou o formulário com as alterações
                $objSexo->setIdSexo($_GET['idSexoPaciente']);
                $objSexo = $objSexoRN->consultar($objSexo);
            }

            if (isset($_POST['salvar_sexoPaciente'])) { //se enviou o formulário com as alterações
                $objSexo->setIdSexo($_GET['idSexoPaciente']);
                $objSexo->setSexo($_POST['txtSexo']);
                $objSexo->setIndex_sexo(strtoupper($utils->tirarAcentos($_POST['txtSexo'])));
                if (empty($objSexoRN->pesquisar_index($objSexo))) {
                    $objSexoRN->alterar($objSexo);
                    $alert = Alert::alert_success_editar();
                } else {
                    $alert = Alert::alert_error_cadastrar_editar();
                }
            }


            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_sexoPaciente.php');
    }
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

function montar_select_recurso(&$select_perfilUsu,$objPerfilUsuarioRN ,&$objPerfilUsuario,&$perfis_selecionados,$aparecer_recursos){
    
    /* PERFIS DO USUÁRIO */
    $selected = '';$disabled='';
    $arr_perfis = $objPerfilUsuarioRN->listar($objPerfilUsuario);
    if($aparecer_recursos){
        $disabled = ' disabled ';
    }
    $select_perfilUsu = '<select '.$disabled.' class="selectpicker" multiple data-live-search="true"   name="sel_perfis[]">'
            . '<option value="0" ></option>';

    foreach ($arr_perfis as $pu) {
        $selected = ' ';
        if($perfis_selecionados != ''){
            $per = explode(";", $perfis_selecionados);
            foreach ($per as $ps){
                if($pu->getIdPerfilUsuario() == $ps){
                   $selected = ' selected ';
                }
            }
            $select_perfilUsu .= '<option ' . $selected . '  value="' . $pu->getIdPerfilUsuario().'">' . $pu->getPerfil() . '</option>';
 
        }
        
    }
    $select_perfilUsu .= '</select>';
}



function montar_select_usuario(&$select_usuario,$objUsuarioRN ,&$objUsuario,$aparecer_recursos){
    
    /* USUÁRIOS */
    $selected = '';$disabled='';
    $arr_usuarios = $objUsuarioRN->listar($objUsuario);
    if($aparecer_recursos){
        $disabled = ' disabled ';
    }
    $select_usuario = '<select '.$disabled.' class="form-control selectpicker"   onchange="this.form.submit()"  '
            . 'id="select-country idSel_usuarios" data-live-search="true" name="sel_usuario">'
            . '<option data-tokens="" ></option>';

    foreach ($arr_usuarios as $u) {
        $selected = '';
        if ($u->getIdUsuario() == $objUsuario->getIdUsuario()) {
            $selected = 'selected';
        }

        $select_usuario .= '<option ' . $selected . '  value="' . $u->getIdUsuario() .
                '" data-tokens="' . $u->getMatricula() . '">' . $u->getMatricula() . '</option>';
    }
    $select_usuario .= '</select>';
}


function montar_select_perfil(&$select_perfilUsu,$objPerfilUsuarioRN ,&$objPerfilUsuario,&$perfis_selecionados,$aparecer_recursos){
    
    /* PERFIS DO USUÁRIO */
    $selected = '';$disabled='';
    $arr_perfis = $objPerfilUsuarioRN->listar($objPerfilUsuario);
    if($aparecer_recursos){
        $disabled = ' disabled ';
    }
    $select_perfilUsu = '<select '.$disabled.' class="selectpicker" multiple data-live-search="true"   name="sel_perfis[]">'
            . '<option value="0" ></option>';

    foreach ($arr_perfis as $pu) {
        $selected = ' ';
        if($perfis_selecionados != ''){
            $per = explode(";", $perfis_selecionados);
            foreach ($per as $ps){
                if($pu->getIdPerfilUsuario() == $ps){
                   $selected = ' selected ';
                }
            }
            $select_perfilUsu .= '<option ' . $selected . '  value="' . $pu->getIdPerfilUsuario().'">' . $pu->getPerfil() . '</option>';
 
        }
        
    }
    $select_perfilUsu .= '</select>';
}




?>

<?php Pagina::abrir_head("Cadastrar relacionamento usuário com seus perfis e seus recursos"); ?>
<link rel="stylesheet" type="text/css" href="css/precadastros.css">
<style>
    body,html{
        font-size: 14px !important;
    }
    .dropdown-toggle{

        height: 35px;
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
<?= $alert ?>

<div class="conteudo">
    <div class="formulario">
        <form method="POST">
            
            <div class="form-row">
                <div class="col-md-5 mb-3">
                    <label for="label_usuarios">Selecione o usuário:</label>
                    <?=$select_usuario?>
                </div>
                               
                <div class="col-md-7">
                  <label for="label_usuarios">Selecione os perfis deste usuário:</label>
                  <?=$select_perfilUsu?>
                  
                </div>
              </div>
              <?php if(!$aparecer_recursos){ ?> <button class="btn btn-primary" type="submit" name="salvar_upr">Salvar</button>   <?php } ?>
            
            
        </form>
        </div>  
    
        <div class="formulario">
        <form method="POST">
            
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <h2> </h2>
                </div>
                <div class="col-md-8 mb-3">
                    <label for="label_usuarios">Selecione o usuário:</label>
                    <?=$select_usuario?>
                </div>
              </div>
              <?php if(!$aparecer_recursos){ ?> <button class="btn btn-primary" type="submit" name="salvar_upr">Salvar</button>   <?php } ?>
            
            
        </form>
        </div>  
    </div>  
</div>

<script src="js/sexoPaciente.js"></script>
<script src="js/fadeOut.js"></script>
<?php
$objPagina->mostrar_excecoes();
$objPagina->fechar_corpo();
?>

