<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Modelo/Modelo.php';
require_once '../classes/Modelo/ModeloRN.php';
require_once '../utils/Utils.php';
require_once '../utils/Alert.php';

$utils = new Utils();

$objModelo = new Modelo();
$objModeloRN = new ModeloRN();
$alert = '';

try {
    switch ($_GET['action']) {
        case 'cadastrar_modelo':
            if (isset($_POST['salvar_modelo'])) {
                $objModelo->setModelo($_POST['txtModelo']);
                $objModelo->setIndex_modelo(strtoupper($utils->tirarAcentos($_POST['txtModelo'])));
                if (empty($objModeloRN->pesquisar_index($objModelo))) {
                    $objModeloRN->cadastrar($objModelo);
                    $alert = Alert::alert_success_cadastrar();
                }else{ $alert = Alert::alert_error_cadastrar_editar();}
                //$alert= '<div id="sucesso_bd" class="sucesso"> Já tinha existe um modelo com este nome cadastrado anterirormente com sucesso</div>';
            } else {
                $objModelo->setIdModelo('');
                $objModelo->setModelo('');
            }
            break;

        case 'editar_modelo':

            if (!isset($_POST['salvar_modelo'])) { //enquanto não enviou o formulário com as alterações
                $objModelo->setIdModelo($_GET['idModelo']);
                $objModelo = $objModeloRN->consultar($objModelo);
            }

            if (isset($_POST['salvar_modelo'])) { //se enviou o formulário com as alterações
                $objModelo->setIdModelo($_GET['idModelo']);
                $objModelo->setModelo($_POST['txtModelo']);
                $objModelo->setIndex_modelo(strtoupper($utils->tirarAcentos($_POST['txtModelo'])));
                if (empty($objModeloRN->pesquisar_index($objModelo))) {
                    $objModeloRN->alterar($objModelo);
                    $alert = Alert::alert_success_editar();
                }else{ $alert = Alert::alert_error_cadastrar_editar();}
                
            }


            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_modelo.php');
    }
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::getInstance()->abrir_head("Cadastrar Modelo");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("modelo");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();

    echo  $alert.
          Pagina::montar_topo_listar('CADASTRAR MODELO', 'listar_modelo', 'LISTAR MODELO').
        '<div class="conteudo">
            <div class="formulario">
                <form method="POST">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="label_modelo">Digite o modelo:</label>
                            <input type="text" class="form-control" id="idModelo" placeholder="Modelo" 
                                   onblur="validaModelo()" name="txtModelo" required value="'. Pagina::formatar_html($objModelo->getModelo()).'">
                            <div id ="feedback_modelo"></div>

                        </div>

                    </div>  
                    <button class="btn btn-primary" type="submit" name="salvar_modelo">Salvar</button>
                </form>
            </div>
        </div>';
      
Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();



