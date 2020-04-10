<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Capela/Capela.php';
require_once 'classes/Capela/CapelaRN.php';
require_once 'utils/Utils.php';
require_once 'utils/Alert.php';
$utils = new Utils();
$objPagina = new Pagina();
$objCapela = new Capela();
$objCapelaRN = new CapelaRN();
$alert = '';


try{
    switch($_GET['action']){
        case 'cadastrar_capela':
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
                $objCapela->setStatusCapela('');
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
                $objCapela->setIndex_perfil(strtoupper($utils->tirarAcentos($_POST['txtStatusCapela'])));
                if(empty($objCapelaRN->pesquisar_index($objCapela))){
                    $objCapelaRN->alterar($objCapela);
                    $alert= Alert::alert_success_editar();
                }else{$alert= Alert::alert_error_cadastrar_editar();}
            }

            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_capela.php');  
    }
   
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Cadastrar Capela"); ?>
<link rel="stylesheet" type="text/css" href="css/precadastros.css">
<?php Pagina::fechar_head();?>
<?php $objPagina->montar_menu_topo();?>
<?=$alert?>
<div class="conteudo">
<form method="POST">
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="label_capela">Número da capela:</label>
            <input type="number" class="form-control" id="idNumeroCapela" placeholder="Nº capela" 
                   onblur="" name="numCapela" required value="<?=$objCapela->getNumero()?>">
            <div id ="feedback_capela"></div>

        </div>
        <div class="col-md-8 mb-3">
            <label for="label_capela">Status da capela: (LIBERADA | OCUPADA)</label>
            <input type="text" class="form-control" id="idStatusCapela" placeholder="Status capela" 
                   onblur="" name="txtStatusCapela" required value="<?=$objCapela->getStatusCapela()?>">
            <div id ="feedback_capela"></div>

        </div>
    </div>  
    <button class="btn btn-primary" type="submit" name="salvar_capela">Salvar</button>
</form>
</div>

<script src="js/perfilUsuario.js"></script>
<script src="js/fadeOut.js"></script>

<?php 
$objPagina->mostrar_excecoes(); 
$objPagina->fechar_corpo(); 
?>


