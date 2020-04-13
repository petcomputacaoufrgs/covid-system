<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Capela/Capela.php';
require_once '../classes/Capela/CapelaRN.php';
require_once '../utils/Utils.php';
require_once '../utils/Alert.php';


$utils = new Utils();
$objCapela = new Capela();
$objCapelaRN = new CapelaRN();
$alert = '';
$readonly = ' ';

try{
    switch($_GET['action']){
        case 'cadastrar_capela':
            $readonly = ' readonly ';
            $objCapela->setStatusCapela('LIBERADA');
            
            if(isset($_POST['salvar_capela'])){
                
                $objCapela->setNumero($_POST['numCapela']);
                $objCapela->setStatusCapela('LIBERADA');
                
                if(empty($objCapelaRN->validar_Cadastro($objCapela))){
                    $objCapelaRN->cadastrar($objCapela);
                    $alert= Alert::alert_success_cadastrar();
                }else{$alert= Alert::alert_error_cadastrar_editar();}
                
            }else{
                $objCapela->setIdCapela('');
                $objCapela->setNumero('');
                
            }
        break;
        
        case 'editar_capela':
            if(!isset($_POST['salvar_capela'])){ //enquanto não enviou o formulário com as alterações
                $objCapela->setIdCapela($_GET['idCapela']);
                $objCapela = $objCapelaRN->consultar($objCapela);
            }
            
             if(isset($_POST['salvar_capela'])){ //se enviou o formulário com as alterações
                $objCapela->setIdCapela($_GET['idCapela']);
                $objCapela->setNumero($_POST['numCapela']);
                $objCapela->setStatusCapela(strtoupper($utils->tirarAcentos($_POST['txtStatusCapela'])));
                if(empty($objCapelaRN->validar_cadastro($objCapela))){
                    $objCapelaRN->alterar($objCapela);
                    $alert= Alert::alert_success_editar();
                }else{$alert= Alert::alert_error_cadastrar_editar();}
            }

            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_capela.php');  
    }
   
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Cadastrar Capela");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("capela");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();


echo $alert.
     Pagina::montar_topo_listar('CADASTRAR CAPELA', 'listar_capela', 'LISTAR CAPELAS').
     '<div class="conteudo">
        <form method="POST">
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="label_capela">Número da capela:</label>
                    <input type="number" class="form-control" id="idNumeroCapela" placeholder="Nº capela" 
                           onblur="" name="numCapela" required value="'. Pagina::formatar_html($objCapela->getNumero()).'">
                    <div id ="feedback_capela"></div>

                </div>
                <div class="col-md-8 mb-3">
                    <label for="label_capela">Status da capela: (LIBERADA | OCUPADA)</label>
                    <input type="text" class="form-control" id="idStatusCapela" placeholder="Status capela" '.$readonly.'
                           onblur="" name="txtStatusCapela" required value="'. Pagina::formatar_html($objCapela->getStatusCapela()).'">
                    <div id ="feedback_capela"></div>

                </div>
            </div>  
            <button class="btn btn-primary" type="submit" name="salvar_capela">Salvar</button>
        </form>
    </div>';
               

Pagina::getInstance()->mostrar_excecoes(); 
Pagina::getInstance()->fechar_corpo(); 



