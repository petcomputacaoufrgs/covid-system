<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Detentor/Detentor.php';
require_once 'classes/Detentor/DetentorRN.php';

$objPagina = new Pagina();
$objDetentor = new Detentor();
$objDetentorRN = new DetentorRN();
$sucesso = '';

try{
    switch($_GET['action']){
        case 'cadastrar_detentor':
            if(isset($_POST['salvar_detentor'])){
                $objDetentor->setDetentor(mb_strtolower($_POST['txtDetentor'],'utf-8'));
                $objDetentorRN->cadastrar($objDetentor);
                $sucesso= '<div id="sucesso_bd" class="sucesso">Cadastrado com sucesso</div>';
            }else{
                $objDetentor->setIdDetentor('');
                $objDetentor->setDetentor('');
            }
        break;
        
        case 'editar_detentor':
            if(!isset($_POST['salvar_detentor'])){ //enquanto não enviou o formulário com as alterações
                $objDetentor->setIdDetentor($_GET['idDetentor']);
                $objDetentor = $objDetentorRN->consultar($objDetentor);
            }
            
             if(isset($_POST['salvar_detentor'])){ //se enviou o formulário com as alterações
                $objDetentor->setIdDetentor($_GET['idDetentor']);
                $objDetentor->setDetentor( mb_strtolower($_POST['txtDetentor'],'utf-8'));
                $objDetentorRN->alterar($objDetentor);
                $sucesso= '<div id="sucesso_bd" class="sucesso">Alterado com sucesso</div>';
            }
            
            
            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_detentor.php');  
    }
   
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Cadastrar Detentor"); ?>
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
        margin: 50px;
    }
</style>
<?php Pagina::fechar_head();?>
<?php $objPagina->montar_menu_topo();?>
<?=$sucesso?>
<div class="formulario">
<form method="POST">
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="label_detentor">Digite o detentor:</label>
            <input type="text" class="form-control" id="idDetentor" placeholder="Detentor" 
                   onblur="validaDetentor()" name="txtDetentor" required value="<?=$objDetentor->getDetentor()?>">
            <div id ="feedback_detentor"></div>

        </div>
        
    </div>  
    <button class="btn btn-primary" type="submit" name="salvar_detentor">Salvar</button>
</form>
</div>

<script src="js/detentor.js"></script>
<script src="js/fadeOut.js"></script>

<?php 
$objPagina->mostrar_excecoes(); 
$objPagina->fechar_corpo(); 
?>


