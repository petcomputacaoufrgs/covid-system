<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/PerfilPaciente/PerfilPaciente.php';
require_once 'classes/PerfilPaciente/PerfilPacienteRN.php';
require_once 'utils/Utils.php';
require_once 'utils/Alert.php';
$utils = new Utils();
$objPagina = new Pagina();
$objPerfilPaciente = new PerfilPaciente();
$objPerfilPacienteRN = new PerfilPacienteRN();

$cadastrado_sucesso = '';
$alert ='';
try{
    switch($_GET['action']){
        case 'cadastrar_perfilPaciente':
            if(isset($_POST['salvar_perfilPaciente'])){
                $objPerfilPaciente->setPerfil($_POST['txtPerfilPaciente']);
                $objPerfilPaciente->setIndex_perfil(strtoupper($utils->tirarAcentos($_POST['txtPerfilPaciente'])));  
                if(empty($objPerfilPacienteRN->pesquisar_index($objPerfilPaciente))){
                   $objPerfilPacienteRN->cadastrar($objPerfilPaciente);
                   $alert= Alert::alert_success_cadastrar();
                }else {$alert= Alert::alert_error_cadastrar_editar();}
                
            }else{
                $objPerfilPaciente->setIdPerfilPaciente('');
                $objPerfilPaciente->setPerfil('');
            }
        break;
        
        case 'editar_perfilPaciente':
            if(!isset($_POST['salvar_perfilPaciente'])){ //enquanto não enviou o formulário com as alterações
                $objPerfilPaciente->setIdPerfilPaciente($_GET['idPerfilPaciente']);
                $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
            }
            
             if(isset($_POST['salvar_perfilPaciente'])){ //se enviou o formulário com as alterações
                $objPerfilPaciente->setIdPerfilPaciente($_GET['idPerfilPaciente']);
                $objPerfilPaciente->setPerfil($_POST['txtPerfilPaciente']);
                $objPerfilPaciente->setIndex_perfil(strtoupper($utils->tirarAcentos($_POST['txtPerfilPaciente'])));
                if(empty($objPerfilPacienteRN->pesquisar_index($objPerfilPaciente))){
                    $objPerfilPacienteRN->alterar($objPerfilPaciente);
                    $alert= Alert::alert_success_editar();
                }else {$alert= Alert::alert_error_cadastrar_editar();}
                
            }
            
            
            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_perfilPaciente.php');  
    }
   
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Cadastrar Perfil do paciente"); ?>
<link rel="stylesheet" type="text/css" href="css/precadastros.css">
<?php Pagina::fechar_head();?>
<?php $objPagina->montar_menu_topo();?>

<?=$alert?>
<DIV class="conteudo">
<form method="POST">
    <div class="form-row">
        <div class="col-md-12 mb-3">
            <label for="label_perfilPaciente">Digite o perfil do paciente:</label>
            <input type="text" class="form-control" id="idPerfilPaciente" placeholder="Perfil do paciente" 
                   onblur="validaPerfilPaciente()" name="txtPerfilPaciente" required value="<?=$objPerfilPaciente->getPerfil()?>">
            <div id ="feedback_perfilPaciente"></div>

        </div>
    </div>  
    <button class="btn btn-primary" type="submit" name="salvar_perfilPaciente">Salvar</button>
</form>
</DIV>
<script src="js/perfilPaciente.js"></script>
<script src="js/fadeOut.js"></script>

<?php 
$objPagina->mostrar_excecoes(); 
$objPagina->fechar_corpo(); 
?>


