<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Doenca/Doenca.php';
require_once 'classes/Doenca/DoencaRN.php';

$objPagina = new Pagina();
$objDoenca = new Doenca();
$objDoencaRN = new DoencaRN();
$sucesso = '';

try{
    switch($_GET['action']){
        case 'cadastrar_doenca':
            if(isset($_POST['salvar_doenca'])){
                $objDoenca->setDoenca( mb_strtolower($_POST['txtDoenca'],'utf-8'));
                $objDoencaRN->cadastrar($objDoenca);
                $sucesso= '<div id="sucesso_bd" class="sucesso">Cadastrado com sucesso</div>';
            }else{
                $objDoenca->setIdDoenca('');
                $objDoenca->setDoenca('');
            }
        break;
        
        case 'editar_doenca':
            if(!isset($_POST['salvar_doenca'])){ //enquanto não enviou o formulário com as alterações
                $objDoenca->setIdDoenca($_GET['idDoenca']);
                $objDoenca = $objDoencaRN->consultar($objDoenca);
            }
            
             if(isset($_POST['salvar_doenca'])){ //se enviou o formulário com as alterações
                $objDoenca->setIdDoenca($_GET['idDoenca']);
                $objDoenca->setDoenca(mb_strtolower($_POST['txtDoenca'],'utf-8'));
                $objDoencaRN->alterar($objDoenca);
                $sucesso= '<div id="sucesso_bd" class="sucesso">Alterado com sucesso</div>';
            }
            
            
            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_doenca.php');  
    }
   
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Cadastrar Doença"); ?>
 <style>
    .placeholder_colored::-webkit-input-placeholder  {
        color: red;
        text-align: left;
    } 
    .sucesso{
        width: 100%;
        background-color: green;
    }
</style>
<?php Pagina::fechar_head();?>
<?php $objPagina->montar_menu_topo();?>
<?=$sucesso?>
<form method="POST">
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="label_doenca">Digite a doença:</label>
            <input type="text" class="form-control" id="idDoenca" placeholder="Doença" 
                   onblur="validaDoenca()" name="txtDoenca" required value="<?=$objDoenca->getDoenca()?>">
            <div id ="feedback_doenca"></div>

        </div>
    </div>  
    <button class="btn btn-primary" type="submit" name="salvar_doenca">Salvar</button>
</form>

<script src="js/doenca.js"></script>
<script src="js/fadeOut.js"></script>

<?php 
$objPagina->mostrar_excecoes(); 
$objPagina->fechar_corpo(); 
?>


