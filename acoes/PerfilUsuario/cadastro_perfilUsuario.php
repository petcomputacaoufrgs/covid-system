<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/PerfilUsuario/PerfilUsuario.php';
require_once 'classes/PerfilUsuario/PerfilUsuarioRN.php';

$objPagina = new Pagina();
$objPerfilUsuario = new PerfilUsuario();
$objPerfilUsuarioRN = new PerfilUsuarioRN();
$sucesso = '';


try{
    switch($_GET['action']){
        case 'cadastrar_perfilUsuario':
            if(isset($_POST['salvar_perfilUsuario'])){
                $objPerfilUsuario->setPerfil( mb_strtolower($_POST['txtPerfilUsuario'],'utf-8'));
                $objPerfilUsuarioRN->cadastrar($objPerfilUsuario);
                $sucesso = '<div id="sucesso_bd" class="sucesso">Cadastrado com sucesso</div>';
            }else{
                $objPerfilUsuario->setIdPerfilUsuario('');
                $objPerfilUsuario->setPerfil('');
            }
        break;
        
        case 'editar_perfilUsuario':
            if(!isset($_POST['salvar_perfilUsuario'])){ //enquanto não enviou o formulário com as alterações
                $objPerfilUsuario->setIdPerfilUsuario($_GET['idPerfilUsuario']);
                $objPerfilUsuario = $objPerfilUsuarioRN->consultar($objPerfilUsuario);
            }
            
             if(isset($_POST['salvar_perfilUsuario'])){ //se enviou o formulário com as alterações
                $objPerfilUsuario->setIdPerfilUsuario($_GET['idPerfilUsuario']);
                $objPerfilUsuario->setPerfil(mb_strtolower($_POST['txtPerfilUsuario'],'utf-8'));
                $objPerfilUsuarioRN->alterar($objPerfilUsuario);
                $sucesso = '<div id="sucesso_bd" class="sucesso">Alterado com sucesso</div>';
            }
            
            
            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_perfilUsuario.php');  
    }
   
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Cadastrar Perfil do usuário"); ?>
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
            <label for="label_perfilUsuario">Digite o perfil do usuário:</label>
            <input type="text" class="form-control" id="idPerfilUsuario" placeholder="Perfil do usuário" 
                   onblur="validaPerfilUsuario()" name="txtPerfilUsuario" required value="<?=$objPerfilUsuario->getPerfil()?>">
            <div id ="feedback_perfilUsuario"></div>

        </div>
    </div>  
    <button class="btn btn-primary" type="submit" name="salvar_perfilUsuario">Salvar</button>
</form>

<script src="js/perfilUsuario.js"></script>
<script src="js/fadeOut.js"></script>

<?php 
$objPagina->mostrar_excecoes(); 
$objPagina->fechar_corpo(); 
?>


