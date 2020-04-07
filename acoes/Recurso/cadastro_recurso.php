<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Recurso/Recurso.php';
require_once 'classes/Recurso/RecursoRN.php';

$objPagina = new Pagina();
$objRecurso = new Recurso();
$objRecursoRN = new RecursoRN();
$sucesso = '';

try{
    switch($_GET['action']){
        case 'cadastrar_recurso':
            if(isset($_POST['salvar_recurso'])){
                $objRecurso->setNome(mb_strtolower($_POST['txtNome'],'utf-8'));
                $objRecurso->set_s_n_menu( mb_strtolower($_POST['txtSN'],'utf-8'));

                $objRecursoRN->cadastrar($objRecurso);
                $sucesso= '<div id="sucesso_bd" class="sucesso">Cadastrado com sucesso</div>';
            }else{
                $objRecurso->setIdRecurso('');
                $objRecurso->setNome('');
                $objRecurso->set_s_n_menu('');
            }
        break;
        
        case 'editar_recurso':
            if(!isset($_POST['salvar_recurso'])){ //enquanto não enviou o formulário com as alterações
                $objRecurso->setIdRecurso($_GET['idRecurso']);
                $objRecurso = $objRecursoRN->consultar($objRecurso);
            }
            
             if(isset($_POST['salvar_recurso'])){ //se enviou o formulário com as alterações
                $objRecurso->setIdRecurso($_GET['idRecurso']);
                $objRecurso->setNome( mb_strtolower($_POST['txtNome'],'utf-8'));
                $objRecurso->set_s_n_menu( mb_strtolower($_POST['txtSN'],'utf-8'));
                $objRecursoRN->alterar($objRecurso);
                $sucesso= '<div id="sucesso_bd" class="sucesso">Alterado com sucesso</div>';
            }
            
            
            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_recurso.php');  
    }
   
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Cadastrar Recurso"); ?>
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
            <label for="label_nome">Digite o nome:</label>
            <input type="text" class="form-control" id="idNomeRecurso" placeholder="Nome" 
                   onblur="validaNome()" name="txtNome" required value="<?=$objRecurso->getNome()?>">
            <div id ="feedback_nome"></div>

        </div>
        <div class="col-md-4 mb-3">
            <label for="label_s_n_menu">Digite S/N para o menu:</label>
            <input type="text" class="form-control" id="idSNRecurso" placeholder="S/N" 
                   onblur="validaSNmenu()" name="txtSN" required value="<?=$objRecurso->get_s_n_menu()?>">
            <div id ="feedback_s_n_menu"></div>

        </div>
    </div>  
    <button class="btn btn-primary" type="submit" name="salvar_recurso">Salvar</button>
</form>

<script src="js/recurso.js"></script>
<script src="js/fadeOut.js"></script>

<?php 
$objPagina->mostrar_excecoes(); 
$objPagina->fechar_corpo(); 
?>


