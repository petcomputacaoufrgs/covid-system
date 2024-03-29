<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Doenca/Doenca.php';
require_once '../classes/Doenca/DoencaRN.php';
require_once '../utils/Utils.php';
require_once '../utils/Alert.php';
session_start();
Sessao::getInstance()->validar();


$utils = new Utils();
$objPagina = new Pagina();
$objDoenca = new Doenca();
$objDoencaRN = new DoencaRN();
$alert = '';
try{
    switch($_GET['action']){
        case 'cadastrar_doenca':
            if(isset($_POST['salvar_doenca'])){
                $objDoenca->setDoenca($_POST['txtDoenca']);
                $objDoenca->setIndex_doenca(strtoupper($utils->tirarAcentos($_POST['txtDoenca'])));
                $arr_doencas = $objDoencaRN->pesquisar_index($objDoenca);
                if(empty($arr_doencas)){
                    $objDoencaRN->cadastrar($objDoenca);
                    $alert = Alert::alert_success_cadastrar();
                }else{ $alert = Alert::alert_error_cadastrar_editar(); }
                
            }else{
                $objDoenca->setIdDoenca('');
                $objDoenca->setDoenca('');
                $objDoenca->setIndex_doenca('');
            }
        break;
        
        case 'editar_doenca':
            if(!isset($_POST['salvar_doenca'])){ //enquanto não enviou o formulário com as alterações
                $objDoenca->setIdDoenca($_GET['idDoenca']);
                $objDoenca = $objDoencaRN->consultar($objDoenca);
            }
            
             if(isset($_POST['salvar_doenca'])){ //se enviou o formulário com as alterações
                $objDoenca->setIdDoenca($_GET['idDoenca']);
                $objDoenca->setDoenca($_POST['txtDoenca']);
                $objDoenca->setIndex_doenca(strtoupper($utils->tirarAcentos($_POST['txtDoenca'])));
                $arr_doencas = $objDoencaRN->pesquisar_index($objDoenca);
                if(empty($arr_doencas)){
                    $objDoencaRN->alterar($objDoenca);
                    $alert = Alert::alert_success_editar();
                }else {  $alert =Alert::alert_error_cadastrar_editar(); }
            
             }
            
            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_doenca.php');  
    }
   
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Cadastrar Doença");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("doenca");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
echo 
     $alert.
     Pagina::montar_topo_listar('CADASTRAR DOENÇA', 'listar_doenca', 'LISTAR DOENÇAS').
    '<DIV class="conteudo">
        <form method="POST">
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="label_doenca">Digite a doença:</label>
                    <input type="text" class="form-control" id="idDoenca" placeholder="Doença" 
                           onblur="validaDoenca()" name="txtDoenca" required 
                           value="'. Pagina::formatar_html($objDoenca->getDoenca()).'">
                    <div id ="feedback_doenca"></div>

                </div>
            </div>  
            <button class="btn btn-primary" type="submit" name="salvar_doenca">Salvar</button>
        </form>
    </DIV>';



Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();
