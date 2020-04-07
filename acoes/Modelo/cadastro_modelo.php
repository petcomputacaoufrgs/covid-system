<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Modelo/Modelo.php';
require_once 'classes/Modelo/ModeloRN.php';

$objPagina = new Pagina();
$objModelo = new Modelo();
$objModeloRN = new ModeloRN();
$sucesso = '';

try{
    switch($_GET['action']){
        case 'cadastrar_modelo':
            if(isset($_POST['salvar_modelo'])){
                $objModelo->setModelo(mb_strtolower($_POST['txtModelo'],'utf-8'));
                $objModeloRN->cadastrar($objModelo);
                $sucesso= '<div id="sucesso_bd" class="sucesso">Cadastrado com sucesso</div>';
            }else{
                $objModelo->setIdModelo('');
                $objModelo->setModelo('');
            }
        break;
        
        case 'editar_modelo':
            
            if(!isset($_POST['salvar_modelo'])){ //enquanto não enviou o formulário com as alterações
                $objModelo->setIdModelo($_GET['idModelo']);
                $objModelo = $objModeloRN->consultar($objModelo);
            }
            
             if(isset($_POST['salvar_modelo'])){ //se enviou o formulário com as alterações
                $objModelo->setIdModelo($_GET['idModelo']);
                $objModelo->setModelo( mb_strtolower($_POST['txtModelo'],'utf-8'));
                $objModeloRN->alterar($objModelo);
                $sucesso= '<div id="sucesso_bd" class="sucesso">Alterado com sucesso</div>';
            }
            
            
            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_modelo.php');  
    }
   
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Cadastrar Modelo"); ?>
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
            <label for="label_modelo">Digite o modelo:</label>
            <input type="text" class="form-control" id="idModelo" placeholder="Modelo" 
                   onblur="validaModelo()" name="txtModelo" required value="<?=$objModelo->getModelo()?>">
            <div id ="feedback_modelo"></div>

        </div>
        
    </div>  
    <button class="btn btn-primary" type="submit" name="salvar_modelo">Salvar</button>
</form>
</div>
<script src="js/modelo.js"></script>
<script src="js/fadeOut.js"></script>

<?php 
$objPagina->mostrar_excecoes(); 
$objPagina->fechar_corpo(); 
?>


