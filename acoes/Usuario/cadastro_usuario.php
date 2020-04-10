<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Usuario/Usuario.php';
require_once 'classes/Usuario/UsuarioRN.php';

$objPagina = new Pagina();
$objUsuario = new Usuario();
$objUsuarioRN = new UsuarioRN();
$sucesso = '';

try{
    switch($_GET['action']){
        case 'cadastrar_usuario':
            if(isset($_POST['salvar_usuario'])){
                $objUsuario->setMatricula( $_POST['numMatricula']);
                $objUsuarioRN->cadastrar($objUsuario);
                $sucesso= '<div id="sucesso_bd" class="sucesso">Cadastrado com sucesso</div>';
            }else{
                $objUsuario->setIdUsuario('');
                $objUsuario->setMatricula('');
            }
        break;
        
        case 'editar_usuario':
            if(!isset($_POST['salvar_usuario'])){ //enquanto não enviou o formulário com as alterações
                $objUsuario->setIdUsuario($_GET['idUsuario']);
                $objUsuario = $objUsuarioRN->consultar($objUsuario);
            }
            
             if(isset($_POST['salvar_usuario'])){ //se enviou o formulário com as alterações
                $objUsuario->setIdUsuario($_GET['idUsuario']);
                $objUsuario->setMatricula($_POST['numMatricula']);
                $objUsuarioRN->alterar($objUsuario);
                $sucesso= '<div id="sucesso_bd" class="sucesso">Alterado com sucesso</div>';
            }
            
            
            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_usuario.php');  
    }
   
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Cadastrar Usuário"); ?>
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
            <label for="label_doenca">Digite a matrícula:</label>
            <input type="number" class="form-control" id="idMatricula" placeholder="Matrícula" 
                   onblur="validaMatricula()" name="numMatricula" required value="<?=$objUsuario->getMatricula()?>">
            <div id ="feedback_matricula"></div>

        </div>
    </div>  
    <button class="btn btn-primary" type="submit" name="salvar_usuario">Salvar</button>
</form>

<script src="js/usuario.js"></script>
<script src="js/fadeOut.js"></script>

<?php 
$objPagina->mostrar_excecoes(); 
$objPagina->fechar_corpo(); 
?>


