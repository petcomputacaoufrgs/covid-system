<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/TipoAmostra/TipoAmostra.php';
require_once 'classes/TipoAmostra/TipoAmostraRN.php';

$objPagina = new Pagina();
$objTipoAmostra = new TipoAmostra();
$objTipoAmostraRN = new TipoAmostraRN();
$sucesso  = "";
try{
    switch($_GET['action']){
        case 'cadastrar_tipoAmostra':
            if(isset($_POST['salvar_tipoAmostra'])){
                $objTipoAmostra->setTipo(mb_strtolower($_POST['txtTipoAmostra'],'utf-8'));
                $objTipoAmostraRN->cadastrar($objTipoAmostra);
                $sucesso= '<div id="sucesso_bd" class="sucesso">Cadastrado com sucesso</div>';
            }else{
                $objTipoAmostra->setIdTipoAmostra('');
                $objTipoAmostra->setTipo('');
            }
        break;
        
        case 'editar_tipoAmostra':
            if(!isset($_POST['salvar_tipoAmostra'])){ //enquanto não enviou o formulário com as alterações
                $objTipoAmostra->setIdTipoAmostra($_GET['idTipoAmostra']);
                $objTipoAmostra = $objTipoAmostraRN->consultar($objTipoAmostra);
            }
            
             if(isset($_POST['salvar_tipoAmostra'])){ //se enviou o formulário com as alterações
                $objTipoAmostra->setIdTipoAmostra($_GET['idTipoAmostra']);
                $objTipoAmostra->setTipo(mb_strtolower($_POST['txtTipoAmostra'],'utf-8'));
                $objTipoAmostraRN->alterar($objTipoAmostra);
                $sucesso= '<div id="sucesso_bd" class="sucesso">Alterado com sucesso</div>';
            }
            
            
            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_tiposAmostras.php');  
    }
   
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}




?>

<?php
Pagina::abrir_head("Cadastrar Tipos de Amostras");
?>
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
            <label for="label_tipoAmostra">Digite o tipo da amostra</label>
            <input type="text" class="form-control" id="idTipoAmostra" placeholder="Tipo da amostra" 
                   onblur="validaTipoAmostra()" name="txtTipoAmostra" required value="<?=$objTipoAmostra->getTipo()?>">
            <div id ="feedback_tipoAmostra"></div>

        </div>
    </div>  
    <button class="btn btn-primary" type="submit" name="salvar_tipoAmostra">Salvar</button>
</form>
</div> 

<script src="js/tipoAmostra.js"></script>
<script src="js/fadeOut.js"></script>


<?php 
$objPagina->mostrar_excecoes();
$objPagina->fechar_corpo(); 
?>

