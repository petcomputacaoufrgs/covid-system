<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/PerfilPaciente/PerfilPaciente.php';
require_once 'classes/PerfilPaciente/PerfilPacienteRN.php';

$objPagina = new Pagina();
$objPerfilPaciente = new PerfilPaciente();
$objPerfilPacienteRN = new PerfilPacienteRN();
$cadastrado_sucesso = '';
$sucesso ='';
try{
    switch($_GET['action']){
        case 'cadastrar_perfilPaciente':
            if(isset($_POST['salvar_perfilPaciente'])){
                $objPerfilPaciente->setPerfil( mb_strtolower($_POST['txtPerfilPaciente'],'utf-8'));
                $objPerfilPacienteRN->cadastrar($objPerfilPaciente);
                $sucesso= '<div id="sucesso_bd" class="sucesso">Cadastrado com sucesso</div>';
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
                $objPerfilPaciente->setPerfil(mb_strtolower($_POST['txtPerfilPaciente'],'utf-8'));
                $objPerfilPacienteRN->alterar($objPerfilPaciente);
                $sucesso= '<div id="sucesso_bd" class="sucesso">Alterado com sucesso</div>';
            }
            
            
            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_perfilPaciente.php');  
    }
   
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Cadastrar Perfil do paciente"); ?>
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
            <label for="label_perfilPaciente">Digite o perfil do paciente:</label>
            <input type="text" class="form-control" id="idPerfilPaciente" placeholder="Perfil do paciente" 
                   onblur="validaPerfilPaciente()" name="txtPerfilPaciente" required value="<?=$objPerfilPaciente->getPerfil()?>">
            <div id ="feedback_perfilPaciente"></div>

        </div>
    </div>  
    <button class="btn btn-primary" type="submit" name="salvar_perfilPaciente">Salvar</button>
</form>

<script src="js/perfilPaciente.js"></script>
<script src="js/fadeOut.js"></script>

<?php 
$objPagina->mostrar_excecoes(); 
$objPagina->fechar_corpo(); 
?>


