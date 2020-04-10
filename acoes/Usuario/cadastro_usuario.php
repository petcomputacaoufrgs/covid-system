<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Usuario/Usuario.php';
require_once 'classes/Usuario/UsuarioRN.php';
require_once 'utils/Utils.php';
require_once 'utils/Alert.php';

$utils = new Utils();
$objPagina = new Pagina();
$objUsuario = new Usuario();
$objUsuarioRN = new UsuarioRN();
$alert = '';

try {
    switch ($_GET['action']) {
        case 'cadastrar_usuario':
            if (isset($_POST['salvar_usuario'])) {
                $objUsuario->setMatricula($_POST['numMatricula']);
                $objUsuario->setSenha($_POST['password']);

                $arr_usuarios = $objUsuarioRN->validar_cadastro($objUsuario);
                if (empty($arr_usuarios)) {
                    $objUsuarioRN->cadastrar($objUsuario);
                    $alert = Alert::alert_success_cadastrar();
                } else {
                    $alert = Alert::alert_error_cadastrar_editar();
                }
            } else {
                $objUsuario->setIdUsuario('');
                $objUsuario->setMatricula('');
                $objUsuario->setSenha('');
            }
            break;

        case 'editar_usuario':
            if (!isset($_POST['salvar_usuario'])) { //enquanto não enviou o formulário com as alterações
                $objUsuario->setIdUsuario($_GET['idUsuario']);
                $objUsuario = $objUsuarioRN->consultar($objUsuario);
            }

            if (isset($_POST['salvar_usuario'])) { //se enviou o formulário com as alterações
                $objUsuario->setIdUsuario($_GET['idUsuario']);
                $objUsuario->setMatricula($_POST['numMatricula']);
                $objUsuario->setSenha($_POST['password']);
                $arr_usuarios = $objUsuarioRN->validar_cadastro($objUsuario); // não permitir que ao editar o usuário acabe mudando para um que já existe
                if (empty($arr_usuarios)) {
                     $objUsuarioRN->alterar($objUsuario);
                    $alert = Alert::alert_success_editar();
                } else {
                    $alert = Alert::alert_error_cadastrar_editar();
                }
              
            }


            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_usuario.php');
    }
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}
?>

<?php Pagina::abrir_head("Cadastrar Usuário"); ?>
<link rel="stylesheet" type="text/css" href="css/precadastros.css">
<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo(); ?>
<?= $alert ?>

<div class="conteudo">
    <form method="POST">
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="label_matricula">Digite a matrícula:</label>
                <input type="number" class="form-control" id="idMatricula" placeholder="Matrícula" 
                       onblur="validaMatricula()" name="numMatricula" required value="<?= $objUsuario->getMatricula() ?>">
                <div id ="feedback_matricula"></div>

            </div>
            <div class="col-md-6 mb-3">
                <label for="label_senha">Digite a senha:</label>
                <input type="password" class="form-control" id="idPassword" placeholder="Senha" 
                       onblur="validaSenha()" name="password" required value="<?= $objUsuario->getSenha() ?>">
                <div id ="feedback_senha"></div>

            </div>
        </div>  
        <button class="btn btn-primary" type="submit" name="salvar_usuario">Salvar</button>
    </form>
</div>

<script src="js/usuario.js"></script>
<script src="js/fadeOut.js"></script>

<?php
$objPagina->mostrar_excecoes();
$objPagina->fechar_corpo();
?>


