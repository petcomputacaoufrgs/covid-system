<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/TempoPermanencia/TempoPermanencia.php';
require_once 'classes/TempoPermanencia/TempoPermanenciaRN.php';

$objPagina = new Pagina();
$objTempoPermanencia = new TempoPermanencia();
$objTempoPermanenciaRN = new TempoPermanenciaRN();
$sucesso = '';

try{
    switch($_GET['action']){
        case 'cadastrar_tempoPermanencia':
            if(isset($_POST['salvar_tempoPermanencia'])){
                $objTempoPermanencia->setTempoPermanencia(mb_strtolower($_POST['txtTempoPermanencia'],'utf-8'));
                $objTempoPermanenciaRN->cadastrar($objTempoPermanencia);
                $sucesso= '<div id="sucesso_bd" class="sucesso">Cadastrado com sucesso</div>';
            }else{
                $objTempoPermanencia->setIdTempoPermanencia('');
                $objTempoPermanencia->setTempoPermanencia('');
            }
        break;
        
        case 'editar_tempoPermanencia':
            if(!isset($_POST['salvar_tempoPermanencia'])){ //enquanto não enviou o formulário com as alterações
                $objTempoPermanencia->setIdTempoPermanencia($_GET['idTempoPermanencia']);
                $objTempoPermanencia = $objTempoPermanenciaRN->consultar($objTempoPermanencia);
            }
            
             if(isset($_POST['salvar_tempoPermanencia'])){ //se enviou o formulário com as alterações
                $objTempoPermanencia->setIdTempoPermanencia($_GET['idTempoPermanencia']);
                $objTempoPermanencia->setTempoPermanencia( mb_strtolower($_POST['txtTempoPermanencia'],'utf-8'));
                $objTempoPermanenciaRN->alterar($objTempoPermanencia);
                $sucesso= '<div id="sucesso_bd" class="sucesso">Alterado com sucesso</div>';
            }
            
            
            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_tempoPermanencia.php');  
    }
   
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Cadastrar Permanência"); ?>
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
            <label for="label_permanencia">Digite o tempo de permanência:</label>
            <input type="text" class="form-control" id="idTempoTempoPermanencia" placeholder="TempoPermanencia" 
                   onblur="validaTempoTempoPermanencia()" name="txtTempoPermanencia" required value="<?=$objTempoPermanencia->getTempoPermanencia()?>">
            <div id ="feedback_tempoTempoPermanencia"></div>

        </div>
        
    </div>  
    <button class="btn btn-primary" type="submit" name="salvar_tempoPermanencia">Salvar</button>
</form>

<script src="js/permanencia.js"></script>
<script src="js/fadeOut.js"></script>

<?php 
$objPagina->mostrar_excecoes(); 
$objPagina->fechar_corpo(); 
?>


