<?php
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Capela/Capela.php';
require_once 'classes/Capela/CapelaRN.php';
require_once 'utils/Utils.php';
require_once 'utils/Alert.php';
$utils = new Utils();
$objPagina = new Pagina();
$objCapela = new Capela();
$objCapelaRN = new CapelaRN();
$alert = '';


if(isset($_POST['lock_capela'])){
    $arr = $objCapelaRN->listar($objCapela);
    print_r($arr);
    $arr_capelas_livres= $objCapelaRN->bloquear_registro($objCapela);
    if(empty($arr_capelas_livres)){
        
        $alert = Alert::alert_error_semCapelaDisponivel();
    }else{
        
        $alert = Alert::alert_success_capelaDisponivel();
    }
}



?>


<?php Pagina::abrir_head("LOCK_Capela"); ?>
<link rel="stylesheet" type="text/css" href="css/precadastros.css">
<?php Pagina::fechar_head();?>
<?php $objPagina->montar_menu_topo();?>
<?=$alert?>
<div class="conteudo">
    <form method="POST">
        
        <button class="btn btn-primary" type="submit" name="lock_capela">LOCK</button>
    </form>
</div>

<script src="js/perfilUsuario.js"></script>
<script src="js/fadeOut.js"></script>

<?php 
$objPagina->mostrar_excecoes(); 
$objPagina->fechar_corpo(); 
?>