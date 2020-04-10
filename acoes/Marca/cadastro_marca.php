<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Marca/Marca.php';
require_once 'classes/Marca/MarcaRN.php';
require_once 'utils/Utils.php';
$utils = new Utils();
$objPagina = new Pagina();
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
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Cadastrar Marca"); ?>
 
<link rel="stylesheet" type="text/css" href="css/precadastros.css">
<?php Pagina::fechar_head();?>
<?php $objPagina->montar_menu_topo();?>
<?=$alert?>


<DIV class="conteudo">
    <form method="POST">
        <div class="form-row">
            <div class="col-md-12 mb-3">
                <label for="label_marca">Digite a marca:</label>
                <input type="text" class="form-control" id="idMarca" placeholder="Marca" 
                           onblur="validaMarca()" name="txtMarca" required value="<?=$objMarca->getMarca()?>">
                    <div id ="feedback_marca"></div>

            </div>
        </div>  
        <button class="btn btn-primary" type="submit" name="salvar_doenca">Salvar</button>
    </form>
</DIV>

<script src="js/marca.js"></script>


<?php 
$objPagina->mostrar_excecoes(); 
$objPagina->fechar_corpo(); 
?>


