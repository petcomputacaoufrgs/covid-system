<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Sexo/Sexo.php';
require_once 'classes/Sexo/SexoRN.php';

$objPagina = new Pagina();
$objSexo = new Sexo();
$objSexoRN = new SexoRN();
$sucesso = "";
try{
    switch($_GET['action']){
        case 'cadastrar_sexoPaciente':
            if(isset($_POST['salvar_sexoPaciente'])){
                $objSexo->setSexo(mb_strtolower($_POST['txtSexo'],'utf-8'));
                $objSexoRN->cadastrar($objSexo);
                 $sucesso= '<div id="sucesso_bd" class="sucesso">Cadastrado com sucesso</div>';
            }else{
                $objSexo->setIdSexo('');
                $objSexo->setSexo('');
            }
        break;
        
        case 'editar_sexoPaciente':
            if(!isset($_POST['salvar_sexoPaciente'])){ //enquanto não enviou o formulário com as alterações
                $objSexo->setIdSexo($_GET['idSexoPaciente']);
                $objSexo = $objSexoRN->consultar($objSexo);
            }
            
             if(isset($_POST['salvar_sexoPaciente'])){ //se enviou o formulário com as alterações
                $objSexo->setIdSexo($_GET['idSexoPaciente']);
                $objSexo->setSexo(mb_strtolower($_POST['txtSexo'],'utf-8'));
                $objSexoRN->alterar($objSexo);
                $sucesso= '<div id="sucesso_bd" class="sucesso">Alterado com sucesso</div>';
            }
            
            
            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_sexoPaciente.php');  
    }
   
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}




?>

<?php Pagina::abrir_head("Cadastrar Sexo do paciente"); ?>
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
        margin:10px;
    }
</style>
<?php Pagina::fechar_head();?>
<?php $objPagina->montar_menu_topo();?>
<?=$sucesso?>
<div class="formulario">
<form method="POST">
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="label_sexoPaciente">Digite o sexo do paciente:</label>
            <input type="text" class="form-control" id="idSexoPaciente" placeholder="Sexo do paciente" 
                   onblur="validaSexoPaciente()" name="txtSexo" required value="<?=$objSexo->getSexo()?>">
            <div id ="feedback_sexoPaciente"></div>

        </div>
    </div>  
    <button class="btn btn-primary" type="submit" name="salvar_sexoPaciente">Salvar</button>
</form>
</div>  
<script src="js/sexoPaciente.js"></script>
<script src="js/fadeOut.js"></script>
<?php 
$objPagina->mostrar_excecoes(); 
$objPagina->fechar_corpo(); 
?>

