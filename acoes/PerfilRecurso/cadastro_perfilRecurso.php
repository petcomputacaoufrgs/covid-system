<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
require_once '../classes/Sessao/Sessao.php';

require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';

require_once '../classes/PerfilUsuario/PerfilUsuario.php';
require_once '../classes/PerfilUsuario/PerfilUsuarioRN.php';

require_once '../classes/Recurso/Recurso.php';
require_once '../classes/Recurso/RecursoRN.php';

require_once '../classes/Rel_perfilUsuario_recurso/Rel_perfilUsuario_recurso.php';
require_once '../classes/Rel_perfilUsuario_recurso/Rel_perfilUsuario_recurso_RN.php';

/* UTILIDADES */
require_once '../utils/Utils.php';
require_once '../utils/Alert.php';


$alert = "";
$select_perfilUsu = '';
$select_recurso = '';
$select_perfilUsu_recurso = '';
$recursos_selecionados = '';
$disabled = '';

try {
    //Sessao::getInstance()->validar();
    /* PERFIL DO USUÁRIO */
    $objPerfilUsuario = new PerfilUsuario();
    $objPerfilUsuarioRN = new PerfilUsuarioRN();

    /* RECURSO */
    $objRecurso = new Recurso();
    $objRecursoRN = new RecursoRN();

    /* PERFIL USUÁRIO + RECURSO */
    $objRel_perfilUsuario_recurso = new Rel_perfilUsuario_recurso();
    $objRel_perfilUsuario_recurso_RN = new Rel_perfilUsuario_recurso_RN();

    montar_select_perfil($select_perfilUsu, $objPerfilUsuarioRN, $objPerfilUsuario);
    montar_select_recurso($select_recurso, $objRecursoRN, $objRecurso, $recursos_selecionados);

    switch ($_GET['action']) {
        case 'cadastrar_rel_perfilUsuario_recurso':

            if (isset($_POST['salvar_upr'])) {

                if (isset($_POST['sel_perfil'])) {
                    $objPerfilUsuario->setIdPerfilUsuario($_POST['sel_perfil']);
                    $objPerfilUsuario = $objPerfilUsuarioRN->consultar($objPerfilUsuario);

                    if (isset($_POST['sel_recursos'])) {
                        $i = 0;
                        for ($i = 0; $i < count($_POST['sel_recursos']); $i++) {
                            $recursos_selecionados .= $_POST['sel_recursos'][$i] . ";";
                            $objRel_perfilUsuario_recurso->setIdPerfilUsuario_fk($objPerfilUsuario->getIdPerfilUsuario());
                            $objRel_perfilUsuario_recurso->setIdRecurso_fk($_POST['sel_recursos'][$i]);
                            $arrUP = $objRel_perfilUsuario_recurso_RN->validar_cadastro($objRel_perfilUsuario_recurso);
                            if (empty($arrUP)) {
                                $objRel_perfilUsuario_recurso_RN->cadastrar($objRel_perfilUsuario_recurso);
                                $alert = Alert::alert_success("O relacionamento perfil usuário e seu recurso foi cadastrado");
                            } else {
                                $alert = Alert::alert_warning("O relacionamento perfil usuário e seu recurso já tinha sido cadastrado");
                            }
                        }
                    }
                    montar_select_perfil($select_perfilUsu, $objPerfilUsuarioRN, $objPerfilUsuario);
                    montar_select_recurso($select_recurso, $objRecursoRN, $objRecurso, $recursos_selecionados);
                }
            }
            break;

        case 'editar_rel_perfilUsuario_recurso':
            if (!isset($_POST['salvar_upr'])) { //enquanto não enviou o formulário com as alterações
                $objPerfilUsuario->setIdPerfilUsuario($_GET['idPerfilUsuario']);
                $objPerfilUsuario = $objPerfilUsuarioRN->consultar($objPerfilUsuario);
                montar_select_perfil($select_perfilUsu, $objPerfilUsuarioRN, $objPerfilUsuario);

                $recursos_selecionados = $_GET['idRecurso'];
                montar_select_recurso($select_recurso, $objRecursoRN, $objRecurso, $recursos_selecionados);
            }

            if (isset($_POST['salvar_upr'])) { //se enviou o formulário com as alterações
                $objPerfilUsuario->setIdPerfilUsuario($_GET['idPerfilUsuario']);
                $objPerfilUsuario = $objPerfilUsuarioRN->consultar($objPerfilUsuario);


                $arr_pr = $objRel_perfilUsuario_recurso_RN->listar($objRel_perfilUsuario_recurso);
                if (isset($_POST['sel_recursos'])) {
                    $i = 0;

                    $recursos_selecionados_anterirormente = explode(";", $_GET['idRecurso']);
                    $result = array_diff($recursos_selecionados_anterirormente, $_POST['sel_recursos']);
                    //print_r($result);
                    foreach ($result as $r) {
                        $objRel_perfilUsuario_recurso->setIdPerfilUsuario_fk($_GET['idPerfilUsuario']);
                        $objRel_perfilUsuario_recurso->setIdRecurso_fk($r);
                        $objRel_perfilUsuario_recurso_RN->remover($objRel_perfilUsuario_recurso);
                    }

                    $recursos_selecionados = '';
                    for ($i = 0; $i < count($_POST['sel_recursos']); $i++) {
                        //echo $_POST['sel_perfis'][$i];
                        //print_r($_POST['sel_recursos']);

                        $objRel_perfilUsuario_recurso->setIdPerfilUsuario_fk($objPerfilUsuario->getIdPerfilUsuario());
                        $objRel_perfilUsuario_recurso->setIdRecurso_fk($_POST['sel_recursos'][$i]);
                        $arrUP = $objRel_perfilUsuario_recurso_RN->validar_cadastro($objRel_perfilUsuario_recurso);
                        if (empty($arrUP)) {
                            $objRel_perfilUsuario_recurso_RN->cadastrar($objRel_perfilUsuario_recurso);
                            $alert = Alert::alert_success("O relacionamento perfil usuário e seu recurso foi cadastrado");
                        } else {
                            $alert = Alert::alert_warning("O relacionamento perfil usuário e seu recurso já tinha sido cadastrado");
                        }
                        $recursos_selecionados .= $_POST['sel_recursos'][$i] . ";";
                    }

                    montar_select_perfil($select_perfilUsu, $objPerfilUsuarioRN, $objPerfilUsuario);
                    montar_select_recurso($select_recurso, $objRecursoRN, $objRecurso, $recursos_selecionados);
                }
            }
            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_perfilUsuario_recurso.php');
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
            $rec = explode(";", $recursos_selecionados);
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

function montar_select_perfil(&$select_perfilUsu, $objPerfilUsuarioRN, &$objPerfilUsuario) {

    /* PERFIS DO USUÁRIO */
    $selected = '';
    $arr_perfis = $objPerfilUsuarioRN->listar($objPerfilUsuario);
    $disabled = '';
    if (isset($_GET['idPerfilUsuario'])) {
        $disabled = ' disabled ';
    }
    $select_perfilUsu = '<select ' . $disabled . '  class="form-control selectpicker"  data-live-search="true"   name="sel_perfil">'
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

    Pagina::getInstance()->abrir_head("Cadastrar relacionamento dos perfis de usuário com os seus recursos");
    Pagina::getInstance()->adicionar_css("precadastros");
    Pagina::getInstance()->fechar_head();
    Pagina::getInstance()->montar_menu_topo();
    
    echo $alert.
     Pagina::montar_topo_listar('CADASTRAR RELACIONAMENTO DO PERFIL DO USUÁRIO COM SEUS RECURSOS', null,null,'listar_rel_perfilUsuario_recurso',
             'LISTAR PERFIL + RECURSO').
        '<div class="conteudo">
            <div class="formulario">
                <form method="POST">
                    <div class="form-row">
                        <div class="col-md-4">
                            <label for="label_perfis">Selecione o perfil deste usuário:</label><br>'.
                            $select_perfilUsu
                        .'</div>

                        <div class="col-md-8">
                            <label for="label_recursos">Selecione os recursos deste usuário:</label><br>'.
                            $select_recurso
                        .'</div>
                    </div>
                    <button class="btn btn-primary" type="submit" name="salvar_upr">Salvar</button> 
                </form>
            </div>  
        </div> '; 
        

Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();
