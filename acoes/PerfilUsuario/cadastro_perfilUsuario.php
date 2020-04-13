<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/PerfilUsuario/PerfilUsuario.php';
require_once '../classes/PerfilUsuario/PerfilUsuarioRN.php';
require_once '../utils/Utils.php';
require_once '../utils/Alert.php';


$utils = new Utils();
$objPagina = new Pagina();
$objPerfilUsuario = new PerfilUsuario();
$objPerfilUsuarioRN = new PerfilUsuarioRN();
$alert = '';


try{
    switch($_GET['action']){
        case 'cadastrar_perfilUsuario':
            if(isset($_POST['salvar_perfilUsuario'])){
                
                $objPerfilUsuario->setPerfil($_POST['txtPerfilUsuario']);
                $objPerfilUsuario->setIndex_perfil(strtoupper($utils->tirarAcentos($_POST['txtPerfilUsuario'])));
                if(empty($objPerfilUsuarioRN->pesquisar_index($objPerfilUsuario))){
                    $objPerfilUsuarioRN->cadastrar($objPerfilUsuario);
                    $alert= Alert::alert_success_cadastrar();
                }else{$alert= Alert::alert_error_cadastrar_editar();}
                
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
                $objPerfilUsuario->setPerfil($_POST['txtPerfilUsuario']);
                $objPerfilUsuario->setIndex_perfil(strtoupper($utils->tirarAcentos($_POST['txtPerfilUsuario'])));
                if(empty($objPerfilUsuarioRN->pesquisar_index($objPerfilUsuario))){
                    $objPerfilUsuarioRN->alterar($objPerfilUsuario);
                    $alert= Alert::alert_success_editar();
                }else{$alert= Alert::alert_error_cadastrar_editar();}
            }

            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_perfilUsuario.php');  
    }
   
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Cadastrar Perfil do usuário"); ?>
<link rel="stylesheet" type="text/css" href="css/precadastros.css">
<?php Pagina::fechar_head();?>
<?php $objPagina->montar_menu_topo();?>
<?=$alert?>
<div class="conteudo">
<form method="POST">
    <div class="form-row">
        <div class="col-md-12 mb-3">
            <label for="label_perfilUsuario">Digite o perfil do usuário:</label>
            <input type="text" class="form-control" id="idPerfilUsuario" placeholder="Perfil do usuário" 
                   onblur="validaPerfilUsuario()" name="txtPerfilUsuario" required value="<?=$objPerfilUsuario->getPerfil()?>">
            <div id ="feedback_perfilUsuario"></div>

        </div>
    </div>  
    <button class="btn btn-primary" type="submit" name="salvar_perfilUsuario">Salvar</button>
</form>
</div>

<script src="js/perfilUsuario.js"></script>
<script src="js/fadeOut.js"></script>

<?php 
$objPagina->mostrar_excecoes(); 
$objPagina->fechar_corpo(); 
?>


