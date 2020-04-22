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

/* Relacionamentos */
require_once '../classes/Rel_usuario_perfilUsuario/Rel_usuario_perfilUsuario.php';
require_once '../classes/Rel_usuario_perfilUsuario/Rel_usuario_perfilUsuario_RN.php';

/* UTILIDADES */
require_once '../utils/Utils.php';
require_once '../utils/Alert.php';


$alert = "";
$select_usuario = '';
$select_perfilUsu = '';
$select_usuario_perfilUsu = '';
$perfis_selecionados ='';
try {

    /* USUÁRIO */
    $objUsuario = new Usuario();
    $objUsuarioRN = new UsuarioRN();

    /* PERFIL DO USUÁRIO */
    $objPerfilUsuario = new PerfilUsuario();
    $objPerfilUsuarioRN = new PerfilUsuarioRN();

    /* USUÁRIO + PERFIL DO USUÁRIO */
    $objRel_usuario_perfilUsuario = new Rel_usuario_perfilUsuario();
    $objRel_usuario_perfilUsuario_RN = new Rel_usuario_perfilUsuario_RN();

    montar_select_usuario($select_usuario, $objUsuarioRN, $objUsuario);
    montar_select_perfil($select_perfilUsu, $objPerfilUsuarioRN, $objPerfilUsuario,$perfis_selecionados);
    
    if(isset($_POST['sel_usuario'])) {
        $objUsuario->setIdUsuario($_POST['sel_usuario']);
        $objUsuario = $objUsuarioRN->consultar($objUsuario);
        montar_select_usuario($select_usuario, $objUsuarioRN, $objUsuario);
    }
    switch ($_GET['action']) {
       
        case 'cadastrar_usuario_perfilUsuario':
            if (isset($_POST['salvar_upr'])) {
                if (isset($_POST['sel_perfil'])) {
                    $objPerfilUsuario->setIdPerfilUsuario($_POST['sel_perfil']);
                    $objPerfilUsuario = $objPerfilUsuarioRN->consultar($objPerfilUsuario);

                    if (isset($_POST['sel_perfil'])) {
                        $i = 0;
                        for ($i = 0; $i < count($_POST['sel_perfil']); $i++) {
                            $perfis_selecionados .= $_POST['sel_perfil'][$i] . ";";
                            $objRel_usuario_perfilUsuario->setIdUsuario_fk($objUsuario->getIdUsuario());
                            $objRel_usuario_perfilUsuario->setIdPerfilUsuario_fk($_POST['sel_perfil'][$i]);
                            
                            $arrUP = $objRel_usuario_perfilUsuario_RN->validar_cadastro($objRel_usuario_perfilUsuario);
                            if (empty($arrUP)) {
                                $objRel_usuario_perfilUsuario_RN->cadastrar($objRel_usuario_perfilUsuario);
                                $alert = Alert::alert_success("Foi CADASTRADA a relação do usuário com o perfil");
                            } else {
                                $alert = Alert::alert_danger("Não foi CADASTRADA a relação do usuário com o perfil");
                            }
                        }
                    }
                    
                }
                               
                montar_select_usuario($select_usuario, $objUsuarioRN, $objUsuario);
                montar_select_perfil($select_perfilUsu, $objPerfilUsuarioRN, $objPerfilUsuario,$perfis_selecionados);
            }
            break;

        case 'editar_usuario_perfilUsuario':
            if (!isset($_POST['salvar_upr'])) { //enquanto não enviou o formulário com as alterações
               
                $objUsuario->setIdUsuario($_GET['idUsuario']);
                $objUsuario = $objUsuarioRN->consultar($objUsuario);
                montar_select_usuario($select_usuario, $objUsuarioRN, $objUsuario);
                
                $objRel_usuario_perfilUsuario->setIdUsuario_fk($_GET['idUsuario']);
                $arr_rel = $objRel_usuario_perfilUsuario_RN->listar($objRel_usuario_perfilUsuario);
                
                foreach ($arr_rel as $relacionamento){
                    $perfis_selecionados .= $relacionamento->getIdPerfilUsuario_fk()."; ";
                }
                
                montar_select_perfil($select_perfilUsu, $objPerfilUsuarioRN, $objPerfilUsuario,$perfis_selecionados);

            }

            if (isset($_POST['salvar_upr'])) { //se enviou o formulário com as alterações
                if (isset($_POST['sel_perfil'])) {
                    
                    $perfis_selecionados_anteriormente = array();
                    $objUsuario->setIdUsuario($_GET['idUsuario']);
                    $objUsuario = $objUsuarioRN->consultar($objUsuario);
                    
                    $objRel_usuario_perfilUsuario->setIdUsuario_fk($_GET['idUsuario']);
                    $arr_rel = $objRel_usuario_perfilUsuario_RN->listar($objRel_usuario_perfilUsuario);
                
                    foreach ($arr_rel as $relacionamento){
                         $perfis_selecionados_anteriormente[]= $relacionamento->getIdPerfilUsuario_fk();
                    }
                    
                    $result = array_diff($perfis_selecionados_anteriormente, $_POST['sel_perfil']);
                                    
                    foreach ($result as $r) {
                        $objRel_usuario_perfilUsuario->setIdPerfilUsuario_fk($r);
                        $objRel_usuario_perfilUsuario->setIdUsuario_fk($_GET['idUsuario']);
                        $objRel_usuario_perfilUsuario_RN->remover($objRel_usuario_perfilUsuario);
                    }
                    
                    $perfis_selecionados = '';
                    for ($i = 0; $i < count($_POST['sel_perfil']); $i++) {
                        $objRel_usuario_perfilUsuario->setIdPerfilUsuario_fk($_POST['sel_perfil'][$i]);
                        $objRel_usuario_perfilUsuario->setIdUsuario_fk($_GET['idUsuario']);
                        
                        $arrUP = $objRel_usuario_perfilUsuario_RN->validar_cadastro($objRel_usuario_perfilUsuario);
                        if (empty($arrUP)) {
                            $objRel_usuario_perfilUsuario_RN->cadastrar($objRel_usuario_perfilUsuario);
                            $alert .= Alert::alert_success("Foi ALTERADA a relação do usuário com o perfil");
                        } else {
                            $alert .= Alert::alert_danger("Não foi ALTERADA a relação do usuário com o perfil");  
                        }
                        $perfis_selecionados .= $_POST['sel_perfil'][$i] . ";";
                    }
                
                }
                
                montar_select_usuario($select_usuario, $objUsuarioRN, $objUsuario);
                montar_select_perfil($select_perfilUsu, $objPerfilUsuarioRN, $objPerfilUsuario,$perfis_selecionados);
            }


            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_usuario_perfilUsuario.php');
    }
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}


function montar_select_usuario(&$select_usuario, $objUsuarioRN, &$objUsuario) {
    
    /* USUÁRIO */
    $disabled ='';
    $selected = '';
    if(isset($_GET['idUsuario'])){
        $disabled = ' disabled ';
    }
    $arr_usuarios = $objUsuarioRN->listar($usuario = new Usuario());
    
    $select_usuario = '<select ' . $disabled . ' class="form-control selectpicker"   onchange="this.form.submit()"  '
            . 'id="idSel_usuarios" data-live-search="true" name="sel_usuario">'
            . '<option data-tokens="" ></option>';

    foreach ($arr_usuarios as $u) {
        $selected = '';
        if ($u->getIdUsuario() == $objUsuario->getIdUsuario()) {
            $selected = 'selected';
        }

        $select_usuario .= '<option ' . $selected . '  value="' . Pagina::formatar_html($u->getIdUsuario()) .
                '" data-tokens="' .  Pagina::formatar_html($u->getMatricula()) . '">' . Pagina::formatar_html($u->getMatricula()) . '</option>';
    }
    $select_usuario .= '</select>';
}

function montar_select_perfil(&$select_perfilUsu, $objPerfilUsuarioRN, &$objPerfilUsuario, &$perfis_selecionados) {

    /* PERFIS DO USUÁRIO */
    $selected = '';
    $arr_perfis = $objPerfilUsuarioRN->listar($objPerfilUsuario);

    $select_perfilUsu = '<select  class="form-control selectpicker" multiple data-live-search="true"   name="sel_perfil[]">'
            . '<option value="0" ></option>';

    foreach ($arr_perfis as $todos_perfis) {
        $selected = ' ';
        if ($perfis_selecionados != '') {
            $perfis = explode(";", $perfis_selecionados);
            foreach ($perfis as $p) {
                if ($todos_perfis->getIdPerfilUsuario() == $p) {
                    $selected = ' selected ';
                }
            }
            $select_perfilUsu .= '<option ' . $selected . '  '
                    . 'value="' .  Pagina::formatar_html($todos_perfis->getIdPerfilUsuario()) . '">'
                    .  Pagina::formatar_html($todos_perfis->getPerfil()) . '</option>';
        } else {
            $select_perfilUsu .= '<option  '
                    . 'value="' .  Pagina::formatar_html($todos_perfis->getIdPerfilUsuario()) . '">' 
                    .  Pagina::formatar_html($todos_perfis->getPerfil())  . '</option>';
        }
    }
    $select_perfilUsu .= '</select>';
}



Pagina::abrir_head("Cadastrar relacionamento usuário com seus perfis");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();

echo $alert.
     Pagina::montar_topo_listar('CADASTRAR RELACIONAMENTO DO USUÁRIO COM O SEU PERFIL',null,null, 'listar_usuario_perfilUsuario',
             'USUÁRIO + PERFIL').
    '<div class="conteudo">
        <div class="formulario">
            <form method="POST">
                <div class="form-row">
                    <div class="col-md-4">
                        <label for="label_usuarios">Selecione o usuário:</label>'.
                        $select_usuario
                    .'</div>

                    <div class="col-md-8">
                        <label for="label_perfis">Selecione o perfil deste usuário:</label><br>'.
                        $select_perfilUsu
                    .'</div>
                </div>
                <button class="btn btn-primary" type="submit" name="salvar_upr">Salvar</button> 
            </form>
        </div>  
    </div>'; 


Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();
