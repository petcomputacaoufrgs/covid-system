<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
try {
require_once __DIR__. '/../../classes/Sessao/Sessao.php';
require_once __DIR__. '/../../classes/Pagina/Pagina.php';
require_once __DIR__. '/../../classes/Excecao/Excecao.php';
require_once __DIR__. '/../../classes/Detentor/Detentor.php';
require_once __DIR__. '/../../classes/Detentor/DetentorRN.php';
require_once __DIR__. '/../../utils/Utils.php';
require_once __DIR__. '/../../utils/Alert.php';
require_once __DIR__. '/../../classes/Detentor/DetentorRN.php';
    Sessao::getInstance()->validar();
$utils = new Utils();
$objDetentor = new Detentor();
$objDetentorRN = new DetentorRN();
$alert = '';


    switch ($_GET['action']) {
        case 'cadastrar_detentor':
            if (isset($_POST['salvar_detentor'])) {
                $objDetentor->setDetentor($_POST['txtDetentor']);
                $objDetentor->setIndex_detentor(strtoupper($utils->tirarAcentos($_POST['txtDetentor'])));
                if (empty($objDetentorRN->pesquisar_index($objDetentor))) {
                    $objDetentorRN->cadastrar($objDetentor);
                    $alert = Alert::alert_success_cadastrar();
                }else{$alert = Alert::alert_error_cadastrar_editar(); }
                //$alert= '<div id="sucesso_bd" class="sucesso">Já existe um detentor com esse nome</div>';
            } else {
                $objDetentor->setIdDetentor('');
                $objDetentor->setDetentor('');
            }
            break;

        case 'editar_detentor':
            if (!isset($_POST['salvar_detentor'])) { //enquanto não enviou o formulário com as alterações
                $objDetentor->setIdDetentor($_GET['idDetentor']);
                $objDetentor = $objDetentorRN->consultar($objDetentor);
            }

            if (isset($_POST['salvar_detentor'])) { //se enviou o formulário com as alterações
                $objDetentor->setIdDetentor($_GET['idDetentor']);
                $objDetentor->setDetentor($_POST['txtDetentor']);
                $objDetentor->setIndex_detentor(strtoupper($utils->tirarAcentos($_POST['txtDetentor'])));
                if (empty($objDetentorRN->pesquisar_index($objDetentor))) {
                    $objDetentorRN->alterar($objDetentor);
                    $alert = Alert::alert_success_editar();
                }else{$alert = Alert::alert_error_cadastrar_editar();}   
            }

            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_detentor.php');
    }
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Cadastrar Detentor");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("detentor");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();

echo $alert.  
    Pagina::montar_topo_listar('CADASTRAR DETENTOR', 'listar_detentor', 'LISTAR DETENTORES').
    '<div class="conteudo">
        <div class="formulario">
            <form method="POST">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="label_detentor">Digite o detentor:</label>
                        <input type="text" class="form-control" id="idDetentor" placeholder="Detentor" 
                               onblur="validaDetentor()" name="txtDetentor" 
                               required value="'. Pagina::formatar_html($objDetentor->getDetentor()).'">
                        <div id ="feedback_detentor"></div>

                    </div>

                </div>  
                <button class="btn btn-primary" type="submit" name="salvar_detentor">Salvar</button>
            </form>
        </div>
    </div>';


Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();



