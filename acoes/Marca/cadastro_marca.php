<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Marca/Marca.php';
require_once '../classes/Marca/MarcaRN.php';
require_once '../utils/Utils.php';

$utils = new Utils();
$objMarca = new Marca();
$objMarcaRN = new MarcaRN();
$alert = '';

try{
    switch($_GET['action']){
        case 'cadastrar_marca':
            if(isset($_POST['salvar_marca'])){
                $objMarca->setMarca($_POST['txtMarca']);
                $objMarca->setIndex_marca(strtoupper($utils->tirarAcentos($_POST['txtMarca'])));
                if(empty($objMarcaRN->pesquisar_index($objMarca))){
                    $objMarcaRN->cadastrar($objMarca);
                    $alert= Alert::alert_success_cadastrar();
                }else{$alert= Alert::alert_error_cadastrar_editar();}
                                
            }else{
                $objMarca->setIdMarca('');
                $objMarca->setMarca('');
                $objMarca->setIndex_marca('');
            }
        break;
        
        case 'editar_marca':
            if(!isset($_POST['salvar_marca'])){ //enquanto não enviou o formulário com as alterações
                $objMarca->setIdMarca($_GET['idMarca']);
                $objMarca = $objMarcaRN->consultar($objMarca);
            }
            
             if(isset($_POST['salvar_marca'])){ //se enviou o formulário com as alterações
                $objMarca->setMarca($_POST['txtMarca']);
                $objMarca->setIndex_marca(strtoupper($utils->tirarAcentos($_POST['txtMarca'])));
                if(empty($objMarcaRN->pesquisar_index($objMarca))){
                    $objMarcaRN->alterar($objMarca);
                    $alert= Alert::alert_success_cadastrar();
                }else{$alert= Alert::alert_error_cadastrar_editar();}
                
            }
            
            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_marca.php');  
    }
   
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::getInstance()->abrir_head("Cadastrar Marca");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("marca");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();


echo $alert.
     Pagina::montar_topo_listar('CADASTRAR MARCA', 'listar_marca', 'LISTAR MARCA').
        '<div class="conteudo">
            <form method="POST">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="label_marca">Digite a marca:</label>
                        <input type="text" class="form-control" id="idMarca" placeholder="Marca" 
                                   onblur="validaMarca()" name="txtMarca" required value="'. Pagina::formatar_html($objMarca->getMarca()).'">
                            <div id ="feedback_marca"></div>

                    </div>
                </div>  
                <button class="btn btn-primary" type="submit" name="salvar_doenca">Salvar</button>
            </form>
        </div>';



Pagina::getInstance()->mostrar_excecoes(); 
Pagina::getInstance()->fechar_corpo(); 


