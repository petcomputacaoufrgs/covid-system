<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Marca/Marca.php';
require_once 'classes/Marca/MarcaRN.php';

$objPagina = new Pagina();
$objMarca = new Marca();
$objMarcaRN = new MarcaRN();
$sucesso = '';

try{
    switch($_GET['action']){
        case 'cadastrar_marca':
            if(isset($_POST['salvar_marca'])){
                $objMarca->setMarca(mb_strtolower($_POST['txtMarca'],'utf-8'));
                $objMarcaRN->cadastrar($objMarca);
                $sucesso= '<div id="sucesso_bd" class="sucesso">Cadastrado com sucesso</div>';
            }else{
                $objMarca->setIdMarca('');
                $objMarca->setMarca('');
            }
        break;
        
        case 'editar_marca':
            if(!isset($_POST['salvar_marca'])){ //enquanto não enviou o formulário com as alterações
                $objMarca->setIdMarca($_GET['idMarca']);
                $objMarca = $objMarcaRN->consultar($objMarca);
            }
            
             if(isset($_POST['salvar_marca'])){ //se enviou o formulário com as alterações
                $objMarca->setIdMarca($_GET['idMarca']);
                $objMarca->setMarca( mb_strtolower($_POST['txtMarca'],'utf-8'));
                $objMarcaRN->alterar($objMarca);
                $sucesso= '<div id="sucesso_bd" class="sucesso">Alterado com sucesso</div>';
            }
            
            
            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_marca.php');  
    }
   
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Cadastrar Marca"); ?>
 <style>
    .placeholder_colored::-webkit-input-placeholder  {
        color: red;
        text-align: left;
    } 
    .sucesso{
        width: 100%;
        background-color: green;
    }
    .formulario{
        margin: 10px;
    }
</style>
<?php Pagina::fechar_head();?>
<?php $objPagina->montar_menu_topo();?>
<?=$sucesso?>
<div class="formulario">
<form method="POST">
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="label_marca">Digite a marca:</label>
            <input type="text" class="form-control" id="idMarca" placeholder="Marca" 
                   onblur="validaMarca()" name="txtMarca" required value="<?=$objMarca->getMarca()?>">
            <div id ="feedback_marca"></div>

        </div>
        
    </div>  
    <button class="btn btn-primary" type="submit" name="salvar_marca">Salvar</button>
</form>
</div>

<script src="js/marca.js"></script>
<script src="js/fadeOut.js"></script>

<?php 
$objPagina->mostrar_excecoes(); 
$objPagina->fechar_corpo(); 
?>


