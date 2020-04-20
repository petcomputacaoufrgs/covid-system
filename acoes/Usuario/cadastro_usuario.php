<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Usuario/Usuario.php';
require_once '../classes/Usuario/UsuarioRN.php';
require_once '../utils/Utils.php';
require_once '../utils/Alert.php';


try {
    Sessao::getInstance()->validar();
    $utils = new Utils();
    $objUsuario = new Usuario();
    $objUsuarioRN = new UsuarioRN();
    $alert = '';
    
    switch ($_GET['action']) {
        case 'cadastrar_usuario':
            if (isset($_POST['salvar_usuario'])) {
                $objUsuario->setMatricula($_POST['numMatricula']);
                $objUsuario->setSenha($_POST['password']);

                $arr_usuarios = $objUsuarioRN->validar_cadastro($objUsuario);
                if (empty($arr_usuarios)) {
                    $objUsuarioRN->cadastrar($objUsuario);
                    $alert = Alert::alert_success("O usuário foi CADASTRADO com sucesso");
                } else {
                    $alert = Alert::alert_danger("O usuário não foi CADASTRADO");
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
                    $alert = Alert::alert_success_editar("O Usuário foi ALTERADO com sucesso");
                } else {
                    $alert = Alert::alert_danger("O Usuário não foi ALTERADO");
                }
              
            }


            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_usuario.php');
    }
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Cadastrar Usuário");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("usuario");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();

echo  $alert;

?>

<div class="conteudo">
    <form method="POST">
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="label_matricula">Digite a matrícula:</label>
                <input type="text" class="form-control" id="idMatricula" placeholder="Matrícula" 
                       onblur="" name="numMatricula" required value="<?= $objUsuario->getMatricula() ?>">
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


<?php
Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();



