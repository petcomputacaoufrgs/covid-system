<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/NivelPrioridade/NivelPrioridade.php';
require_once '../classes/NivelPrioridade/NivelPrioridadeRN.php';
require_once '../utils/Utils.php';
require_once '../utils/Alert.php';

$utils = new Utils();
$objNivelPrioridade  = new NivelPrioridade ();
$objNivelPrioridadeRN = new NivelPrioridadeRN();
$alert = '';

try{
    switch($_GET['action']){
        case 'cadastrar_nivelPrioridade':
            if(isset($_POST['salvar_nivelPrioridade'])){
                $alert='';
                $objNivelPrioridade->setNivel($_POST['numNivelPrioridade']);
                                
                $arr = $objNivelPrioridadeRN->validar_cadastro($objNivelPrioridade);
                if(empty($arr)){
                     $objNivelPrioridadeRN->cadastrar($objNivelPrioridade );
                     $alert = Alert::alert_success_cadastrar();
                }else{ $alert = Alert::alert_error_cadastrar_editar(); }
                
            }else{
                $objNivelPrioridade->setIdNivelPrioridade ('');
                $objNivelPrioridade->setNivel ('');
            }
        break;
        
        case 'editar_nivelPrioridade':
            if(!isset($_POST['salvar_nivelPrioridade'])){ //enquanto não enviou o formulário com as alterações
                $objNivelPrioridade->setIdNivelPrioridade($_GET['idNivelPrioridade']);
                $objNivelPrioridade  = $objNivelPrioridadeRN->consultar($objNivelPrioridade );
            }
            
             if(isset($_POST['salvar_nivelPrioridade'])){ //se enviou o formulário com as alterações
                $objNivelPrioridade->setIdNivelPrioridade($_GET['idNivelPrioridade']);
                $objNivelPrioridade->setNivel($_POST['numNivelPrioridade']);
                
                                
                $arr = $objNivelPrioridadeRN->validar_cadastro($objNivelPrioridade);
                if(empty($arr)){
                     $objNivelPrioridadeRN->alterar($objNivelPrioridade );
                     $alert = Alert::alert_success_editar();
                }else{ $alert = Alert::alert_error_cadastrar_editar(); }
                
            }
            
            
            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_nivelPrioridade.php');  
    }
   
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::getInstance()->abrir_head("Cadastrar Nível de Prioridade");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("nivelPrioridade");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();


echo $alert.
     Pagina::montar_topo_listar('CADASTRAR NÍVEL DE PRIORIDADE', 'listar_nivelPrioridade', 'LISTAR NIVEL PRIORIDADE').   
    '<div class="conteudo">
        <form method="POST">
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="label_nivelPrioridade">Digite o nível de prioridade:</label>
                    <input type="number" class="form-control" id="idNivelPrioridade " placeholder="Nível de prioridade (1 maior e 10 menor)" 
                           onblur="validaNivelPrioridade ()" name="numNivelPrioridade" 
                           required value="'. Pagina::formatar_html($objNivelPrioridade->getNivel()).'">
                    <div id ="feedback_nivelPrioridade"></div>

                </div>
            </div>  
            <button class="btn btn-primary" type="submit" name="salvar_nivelPrioridade">Salvar</button>
        </form>
    </div>';

Pagina::getInstance()->mostrar_excecoes(); 
Pagina::getInstance()->fechar_corpo(); 



