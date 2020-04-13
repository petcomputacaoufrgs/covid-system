<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Usuario/Usuario.php';
require_once '../classes/Usuario/UsuarioRN.php';

require_once '../classes/PerfilUsuario/PerfilUsuario.php';
require_once '../classes/PerfilUsuario/PerfilUsuarioRN.php';

require_once '../classes/Recurso/Recurso.php';
require_once '../classes/Recurso/RecursoRN.php';

/* Relacionamentos */
require_once '../classes/Rel_usuario_perfilUsuario/Rel_usuario_perfilUsuario.php';
require_once '../classes/Rel_usuario_perfilUsuario/Rel_usuario_perfilUsuario_RN.php';

require_once '../classes/Rel_perfilUsuario_recurso/Rel_perfilUsuario_recurso.php';
require_once '../classes/Rel_perfilUsuario_recurso/Rel_perfilUsuario_recurso_RN.php';

/* UTILIDADES */
require_once '../utils/Utils.php';
require_once '../utils/Alert.php';
$utils = new Utils();
$objPagina = new Pagina();
$alert = "";
$select_usuario = '';
$select_perfilUsu = '';
$select_recurso = '';
$select_usuario_perfilUsu = '';
$select_perfilUsu_recurso = '';
$recursos_selecionados = '';
$disabled = '';

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

    montar_select_usuario($select_usuario, $objUsuarioRN, $objUsuario,$disabled);
    montar_select_perfil($select_perfilUsu, $objPerfilUsuarioRN, $objPerfilUsuario);
    montar_select_recurso($select_recurso, $objRecursoRN, $objRecurso,$recursos_selecionados);
    
    switch ($_GET['action']) {
        case 'cadastrar_rel_usuario_perfil_recurso':
            if (isset($_POST['sel_usuario'])) {
                $objUsuario->setIdUsuario($_POST['sel_usuario']);
                $objUsuario = $objUsuarioRN->consultar($objUsuario);
                montar_select_usuario($select_usuario, $objUsuarioRN, $objUsuario,$disabled);
            }

            if (isset($_POST['salvar_upr'])) {
            
                if (isset($_POST['sel_perfil'])) {
                    $objPerfilUsuario->setIdPerfilUsuario($_POST['sel_perfil']);
                    $objPerfilUsuario = $objPerfilUsuarioRN->consultar($objPerfilUsuario);
                    $objRel_usuario_perfilUsuario->setIdUsuario_fk($objUsuario->getIdUsuario());
                    $objRel_usuario_perfilUsuario->setIdPerfilUsuario_fk($_POST['sel_perfil']);
                    $arrUP = $objRel_usuario_perfilUsuario_RN->validar_cadastro($objRel_usuario_perfilUsuario);
                    if (empty($arrUP)) {
                        $objRel_usuario_perfilUsuario_RN->cadastrar($objRel_usuario_perfilUsuario);
                        $alert = Alert::alert_success_cadastrar();
                    } else {
                        $alert = Alert::alert_error_cadastrar_editar();
                    }
                    
                }
                
                 if(isset($_POST['sel_recursos'])){
                    $i = 0;
                    for ($i = 0; $i < count($_POST['sel_recursos']); $i++) {
                        //echo $_POST['sel_perfis'][$i];
                        $recursos_selecionados .= $_POST['sel_recursos'][$i] . ";";
                        $objRel_perfilUsuario_recurso->setIdPerfilUsuario_fk($objPerfilUsuario->getIdPerfilUsuario());
                        $objRel_perfilUsuario_recurso->setIdRecurso_fk($_POST['sel_recursos'][$i]);
                        $arrUP = $objRel_perfilUsuario_recurso_RN->validar_cadastro($objRel_perfilUsuario_recurso);
                        if (empty($arrUP)) {
                            $objRel_perfilUsuario_recurso_RN->cadastrar($objRel_perfilUsuario_recurso);
                            $alert = Alert::alert_success_cadastrar();
                        } else {
                            $alert = Alert::alert_error_cadastrar_editar();
                        }
                    }
                }
                montar_select_usuario($select_usuario, $objUsuarioRN, $objUsuario,$disabled);
                montar_select_perfil($select_perfilUsu, $objPerfilUsuarioRN, $objPerfilUsuario);
                montar_select_recurso($select_recurso, $objRecursoRN, $objRecurso,$recursos_selecionados);
                
            } 
            break;

        case 'editar_rel_usuario_perfil_recurso':
            if (!isset($_POST['salvar_upr'])) { //enquanto não enviou o formulário com as alterações
                $disabled = " disabled ";
                $objUsuario->setIdUsuario($_GET['idUsuario']);
                $objUsuario = $objUsuarioRN->consultar($objUsuario);
                montar_select_usuario($select_usuario, $objUsuarioRN, $objUsuario,$disabled);
                
                $objPerfilUsuario->setIdPerfilUsuario($_GET['idPerfilUsuario']);
                $objPerfilUsuario = $objPerfilUsuarioRN->consultar($objPerfilUsuario);
                montar_select_perfil($select_perfilUsu, $objPerfilUsuarioRN, $objPerfilUsuario);
                
                $recursos_selecionados = explode(",",$_GET['idRecurso']);
                montar_select_recurso($select_recurso, $objRecursoRN, $objRecurso,$recursos_selecionados);
                
            }

            if (isset($_POST['salvar_upr'])) { //se enviou o formulário com as alterações
                if (isset($_POST['sel_perfil'])) {
                    
                    $objUsuario->setIdUsuario($_GET['idUsuario']);
                    $objUsuario = $objUsuarioRN->consultar($objUsuario);
                    
                    $objPerfilUsuario->setIdPerfilUsuario($_POST['sel_perfil']);
                    $objPerfilUsuario = $objPerfilUsuarioRN->consultar($objPerfilUsuario);
                    
                    
                    
                    $arr_UP = $objRel_usuario_perfilUsuario_RN->listar($objRel_usuario_perfilUsuario);
                    $nao_cadastra = false;
                    foreach ($arr_UP as $pu){
                        if($pu->getIdPerfilUsuario_fk() == $_POST['sel_perfil'] && $pu->getIdUsuario_fk() == $_GET['idUsuario']){
                            $nao_cadastra = true; //uusário já possuí o perfil informado
                        }
                    }
                    if(!$nao_cadastra){
                        $objRel_usuario_perfilUsuario->setIdUsuario_fk($_GET['idUsuario']);
                        $objRel_usuario_perfilUsuario->setIdPerfilUsuario_fk($_POST['sel_perfil']);
                        $arrUP = $objRel_usuario_perfilUsuario_RN->validar_cadastro($objRel_usuario_perfilUsuario);
                        if (empty($arrUP)) {
                            $objRel_usuario_perfilUsuario_RN->cadastrar($objRel_usuario_perfilUsuario);
                            $alert = Alert::alert_success_cadastrar();
                        } else {
                            $alert = Alert::alert_error_cadastrar_editar();
                        }
                    }
                    }
                    
                    $arr_pr= $objRel_perfilUsuario_recurso_RN->listar($objRel_perfilUsuario_recurso);
                    if(isset($_POST['sel_recursos'])){
                        $i = 0;
                        for ($i = 0; $i < count($_POST['sel_recursos']); $i++) {
                            //echo $_POST['sel_perfis'][$i];
                            $recursos_selecionados .= $_POST['sel_recursos'][$i] . ";";
                            $objRel_perfilUsuario_recurso->setIdPerfilUsuario_fk($objPerfilUsuario->getIdPerfilUsuario());
                            $objRel_perfilUsuario_recurso->setIdRecurso_fk($_POST['sel_recursos'][$i]);
                            foreach ($arr_pr as $pr){
                                if($pr->getIdUsuario_fk() == $objUsuario->getIdUsuario()){
                                    if($pr->getIdRecurso_fk() == $_POST['sel_recursos'][$i]){
                                        
                                    }
                                }
                            }
                            
                            
                            
                            $arrUP = $objRel_perfilUsuario_recurso_RN->validar_cadastro($objRel_perfilUsuario_recurso);
                            if (empty($arrUP)) {
                                $objRel_perfilUsuario_recurso_RN->cadastrar($objRel_perfilUsuario_recurso);
                                $alert = Alert::alert_success_cadastrar();
                            } else {
                                $alert = Alert::alert_error_cadastrar_editar();
                            }
                        }
                    }
                                       
                //}
                montar_select_usuario($select_usuario, $objUsuarioRN, $objUsuario,$disabled);
                montar_select_perfil($select_perfilUsu, $objPerfilUsuarioRN, $objPerfilUsuario);
                montar_select_recurso($select_recurso, $objRecursoRN, $objRecurso,$recursos_selecionados);
                
                
                
                
            }


            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_sexoPaciente.php');
    }
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}





function montar_select_recurso(&$select_recurso, $objRecursoRN, &$objRecurso, &$recursos_selecionados) {

    /* RECURSOS DO USUÁRIO */
    $selected = '';
    $arr_recursos = $objRecursoRN->listar($objRecurso);

    $select_recurso = '<select  class="form-control selectpicker" multiple data-live-search="true"   name="sel_recursos[]">'
            . '<option value="0" ></option>';

    foreach ($arr_recursos as $recurso) {
        $selected = ' ';
        if ($recursos_selecionados != '') {
            if(!isset($_GET['idRecurso'])){$rec = explode(";", $recursos_selecionados);}
            else {$rec = explode(",",$_GET['idRecurso']);}
            foreach ($rec as $r) {
                if ($recurso->getIdRecurso() == $r) {
                    $selected = ' selected ';
                }
            }
            $select_recurso .= '<option ' . $selected . '  value="' . $recurso->getIdRecurso() . '">' . $recurso->getEtapa() . '</option>';
        } else {
            $select_recurso .= '<option  value="' . $recurso->getIdRecurso() . '">' . $recurso->getEtapa() . ' - Menu: ' . $recurso->getS_n_menu() . '</option>';
        }
    }
    $select_recurso .= '</select>';
}

function montar_select_usuario(&$select_usuario, $objUsuarioRN, &$objUsuario,$disabled) {

    /* USUÁRIO */
    
    $selected = '';
    
    $arr_usuarios = $objUsuarioRN->listar($objUsuario);
    
    $select_usuario = '<select '.$disabled.' class="form-control selectpicker"   onchange="this.form.submit()"  '
            . 'id="idSel_usuarios" data-live-search="true" name="sel_usuario">'
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

function montar_select_perfil(&$select_perfilUsu, $objPerfilUsuarioRN, &$objPerfilUsuario) {

    /* PERFIS DO USUÁRIO */
    $selected = '';
    $arr_perfis = $objPerfilUsuarioRN->listar($objPerfilUsuario);
   
    $select_perfilUsu = '<select class="form-control selectpicker"  data-live-search="true"   name="sel_perfil">'
            . '<option value="0" ></option>';

    foreach ($arr_perfis as $pu) {
        $selected = ' ';
        if ($pu->getIdPerfilUsuario() == $objPerfilUsuario->getIdPerfilUsuario()) {
            $selected = 'selected';
        }
              
        $select_perfilUsu .= '<option ' . $selected . '  value="' . $pu->getIdPerfilUsuario() . '">' . $pu->getPerfil() . '</option>';

    }
    $select_perfilUsu .= '</select>';
}
?>

<?php Pagina::abrir_head("Cadastrar relacionamento usuário com seus perfis e seus recursos"); ?>
<link rel="stylesheet" type="text/css" href="css/precadastros.css">
<style>
    .conteudo{
         /*background-color: gray;*/
         width: 90%;
         margin-top: 40px;
         margin-right: 5%;
         margin-left: 5%;
         
         padding:10px;
         
     }
      form{
         width: 90%;
         margin-right: 5%;
         margin-left: 5%;
         
     }
     
     .form-row{
         margin-bottom: 10px;
     }
     
    </style>
<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo(); ?>
<?= $alert ?>

<div class="conteudo">
    <div class="formulario">
        <form method="POST">
             

            <div class="form-row">
                <div class="col-md-2">
                    <label for="label_usuarios">Selecione o usuário:</label>
                    <?= $select_usuario ?>
                </div>

                <div class="col-md-4">
                    <label for="label_perfis">Selecione o perfil deste usuário:</label><br>
                        <?= $select_perfilUsu ?>

                </div>
                
                <div class="col-md-6">
                    <label for="label_recursos">Selecione os recursos deste usuário:</label><br>
                        <?= $select_recurso ?>

                </div>
            </div>
           <button class="btn btn-primary" type="submit" name="salvar_upr">Salvar</button> 


        </form>
    </div>  
      
</div>  
</div>

<script src="js/sexoPaciente.js"></script>
<script src="js/fadeOut.js"></script>
<?php
$objPagina->mostrar_excecoes();
$objPagina->fechar_corpo();
