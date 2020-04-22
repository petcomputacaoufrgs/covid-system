<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Etnia/Etnia.php';
require_once '../classes/Etnia/EtniaRN.php';
require_once '../utils/Utils.php';
require_once '../utils/Alert.php';
require_once '../classes/Etnia/EtniaRN.php';

try {
    Sessao::getInstance()->validar();
    $utils = new Utils();

$objEtnia = new Etnia();
$objEtniaRN = new EtniaRN();
$alert = '';


    switch ($_GET['action']) {
        case 'cadastrar_etnia':
            if (isset($_POST['salvar_etnia'])) {
                $objEtnia->setEtnia($_POST['txtEtnia']);
                $objEtnia->setIndex_etnia(strtoupper($utils->tirarAcentos($_POST['txtEtnia'])));
                if (empty($objEtniaRN->pesquisar_index($objEtnia))) {
                    $objEtniaRN->cadastrar($objEtnia);
                    $alert = Alert::alert_success_cadastrar();
                }else{$alert = Alert::alert_error_cadastrar_editar(); }
            } else {
                $objEtnia->setIdEtnia('');
                $objEtnia->setEtnia('');
            }
            break;

        case 'editar_etnia':
            if (!isset($_POST['salvar_etnia'])) { //enquanto não enviou o formulário com as alterações
                $objEtnia->setIdEtnia($_GET['idEtnia']);
                $objEtnia = $objEtniaRN->consultar($objEtnia);
            }

            if (isset($_POST['salvar_etnia'])) { //se enviou o formulário com as alterações
                $objEtnia->setIdEtnia($_GET['idEtnia']);
                $objEtnia->setEtnia($_POST['txtEtnia']);
                $objEtnia->setIndex_etnia(strtoupper($utils->tirarAcentos($_POST['txtEtnia'])));
                if (empty($objEtniaRN->pesquisar_index($objEtnia))) {
                    $objEtniaRN->alterar($objEtnia);
                    $alert = Alert::alert_success_editar();
                }else{$alert = Alert::alert_error_cadastrar_editar();}   
            }

            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_etnia.php');
    }
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Cadastrar Etnia");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("etnia");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();

echo $alert.  
    Pagina::montar_topo_listar('CADASTRAR ETNIA', 'listar_etnia', 'LISTAR ETNIAS').
    '<div class="conteudo">
        <div class="formulario">
            <form method="POST">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="label_etnia">Digite a etnia:</label>
                        <input type="text" class="form-control" id="idEtnia" placeholder="Etnia" 
                               onblur="validaEtnia()" name="txtEtnia" 
                               required value="'. Pagina::formatar_html($objEtnia->getEtnia()).'">
                        <div id ="feedback_etnia"></div>

                    </div>

                </div>  
                <button class="btn btn-primary" type="submit" name="salvar_etnia">Salvar</button>
            </form>
        </div>
    </div>';


Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();



