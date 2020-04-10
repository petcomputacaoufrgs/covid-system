<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Sexo/Sexo.php';
require_once 'classes/Sexo/SexoRN.php';
require_once 'utils/Utils.php';
require_once 'utils/Alert.php';
$utils = new Utils();
$objPagina = new Pagina();
$objSexo = new Sexo();
$objSexoRN = new SexoRN();
$alert = "";
try {
    switch ($_GET['action']) {
        case 'cadastrar_sexoPaciente':
            if (isset($_POST['salvar_sexoPaciente'])) {

                $objSexo->setSexo($_POST['txtSexo']);
                $objSexo->setIndex_sexo(strtoupper($utils->tirarAcentos($_POST['txtSexo'])));
                if (empty($objSexoRN->pesquisar_index($objSexo))) {
                    $objSexoRN->cadastrar($objSexo);
                    $alert = Alert::alert_success_cadastrar();
                } else {
                    $alert = Alert::alert_error_cadastrar_editar();
                }
            } else {
                $objSexo->setIdSexo('');
                $objSexo->setSexo('');
                $objSexo->setIndex_sexo('');
            }
            break;

        case 'editar_sexoPaciente':
            if (!isset($_POST['salvar_sexoPaciente'])) { //enquanto não enviou o formulário com as alterações
                $objSexo->setIdSexo($_GET['idSexoPaciente']);
                $objSexo = $objSexoRN->consultar($objSexo);
            }

            if (isset($_POST['salvar_sexoPaciente'])) { //se enviou o formulário com as alterações
                $objSexo->setIdSexo($_GET['idSexoPaciente']);
                $objSexo->setSexo($_POST['txtSexo']);
                $objSexo->setIndex_sexo(strtoupper($utils->tirarAcentos($_POST['txtSexo'])));
                if (empty($objSexoRN->pesquisar_index($objSexo))) {
                    $objSexoRN->alterar($objSexo);
                    $alert = Alert::alert_success_editar();
                } else {
                    $alert = Alert::alert_error_cadastrar_editar();
                }
            }


            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_sexoPaciente.php');
    }
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}
?>

<?php Pagina::abrir_head("Cadastrar Sexo do paciente"); ?>
<link rel="stylesheet" type="text/css" href="css/precadastros.css">
<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo(); ?>
<?= $alert ?>

<div class="conteudo">
    <div class="formulario">
        <form method="POST">
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="label_sexoPaciente">Digite o sexo do paciente:</label>
                    <input type="text" class="form-control" id="idSexoPaciente" placeholder="Sexo do paciente" 
                           onblur="validaSexoPaciente()" name="txtSexo" required value="<?= $objSexo->getSexo() ?>">
                    <div id ="feedback_sexoPaciente"></div>

                </div>
            </div>  
            <button class="btn btn-primary" type="submit" name="salvar_sexoPaciente">Salvar</button>
        </form>
    </div>  
</div>
<script src="js/sexoPaciente.js"></script>
<script src="js/fadeOut.js"></script>
<?php
$objPagina->mostrar_excecoes();
$objPagina->fechar_corpo();
?>

