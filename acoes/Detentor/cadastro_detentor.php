<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Detentor/Detentor.php';
require_once 'classes/Detentor/DetentorRN.php';
require_once 'utils/Utils.php';
require_once 'utils/Alert.php';
require_once 'classes/Detentor/DetentorRN.php';
$utils = new Utils();
$objPagina = new Pagina();
$objDetentor = new Detentor();
$objDetentorRN = new DetentorRN();
$alert = '';

try {
    switch ($_GET['action']) {
        case 'cadastrar_detentor':
            if (isset($_POST['salvar_detentor'])) {
                $objDetentor->setDetentor($_POST['txtDetentor']);
                $objDetentor->setIndex_detentor(strtoupper($utils->tirarAcentos($_POST['txtDetentor'])));
                if (empty($objDetentorRN->pesquisar_index($objDetentor))) {
                    $objDetentorRN->cadastrar($objDetentor);
                    $alert = Alert::alert_success_cadastrar();
                }else{$alert = Alert::alert_error_cadastrar_editar(); }
                //$alert= '<div id="sucesso_bd" class="sucesso">Já existe um detentor com esse nome</div>';
            } else {
                $objDetentor->setIdDetentor('');
                $objDetentor->setDetentor('');
            }
            break;

        case 'editar_detentor':
            if (!isset($_POST['salvar_detentor'])) { //enquanto não enviou o formulário com as alterações
                $objDetentor->setIdDetentor($_GET['idDetentor']);
                $objDetentor = $objDetentorRN->consultar($objDetentor);
            }

            if (isset($_POST['salvar_detentor'])) { //se enviou o formulário com as alterações
                $objDetentor->setIdDetentor($_GET['idDetentor']);
                $objDetentor->setDetentor($_POST['txtDetentor']);
                $objDetentor->setIndex_detentor(strtoupper($utils->tirarAcentos($_POST['txtDetentor'])));
                if (empty($objDetentorRN->pesquisar_index($objDetentor))) {
                    $objDetentorRN->alterar($objDetentor);
                    $alert = Alert::alert_success_editar();
                }else{$alert = Alert::alert_error_cadastrar_editar();}   
            }

            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_detentor.php');
    }
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}
?>

<?php Pagina::abrir_head("Cadastrar Detentor"); ?>
<link rel="stylesheet" type="text/css" href="css/precadastros.css">
<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo(); ?>
<?= $alert ?>
<div class="conteudo">
    <div class="formulario">
        <form method="POST">
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="label_detentor">Digite o detentor:</label>
                    <input type="text" class="form-control" id="idDetentor" placeholder="Detentor" 
                           onblur="validaDetentor()" name="txtDetentor" required value="<?= $objDetentor->getDetentor() ?>">
                    <div id ="feedback_detentor"></div>

                </div>

            </div>  
            <button class="btn btn-primary" type="submit" name="salvar_detentor">Salvar</button>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        setTimeout(function () {
            $('#sucesso_bd').fadeOut(500);
        }, 500);
    });
</script>
<script src="js/detentor.js"></script>
<script src="js/fadeOut.js"></script>

<?php
$objPagina->mostrar_excecoes();
$objPagina->fechar_corpo();
?>


