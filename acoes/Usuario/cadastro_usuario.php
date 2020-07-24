<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();

try {
    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';
    require_once __DIR__.'/../../classes/Usuario/Usuario.php';
    require_once __DIR__.'/../../classes/Usuario/UsuarioRN.php';
    require_once __DIR__.'/../../utils/Utils.php';
    require_once __DIR__.'/../../utils/Alert.php';

    Sessao::getInstance()->validar();
    $utils = new Utils();
    $objUsuario = new Usuario();
    $objUsuarioRN = new UsuarioRN();
    $alert = '';
    $titulo = '';
    switch ($_GET['action']) {
        case 'cadastrar_usuario':
            $titulo  = 'CADASTRAR USUÁRIO';
            if (isset($_POST['salvar_usuario'])) {
                $objUsuario->setMatricula($_POST['numMatricula']);
                $objUsuario->setSenha($_POST['password']);
                $objUsuario->setCPF($_POST['numCPF']);
                $objUsuarioRN->cadastrar($objUsuario);
                $alert = Alert::alert_success("O usuário -".$objUsuario->getMatricula()."- foi <strong>cadastrado</strong> com sucesso");

            } else {
                $objUsuario->setIdUsuario('');
                $objUsuario->setMatricula('');
                $objUsuario->setSenha('');
            }
            break;

        case 'editar_usuario':
            $titulo  = 'EDITAR USUÁRIO';
            if (!isset($_POST['salvar_usuario'])) { //enquanto não enviou o formulário com as alterações
                $objUsuario->setIdUsuario($_GET['idUsuario']);
                $objUsuario = $objUsuarioRN->consultar($objUsuario);
            }

            if (isset($_POST['salvar_usuario'])) { //se enviou o formulário com as alterações
                $objUsuario->setIdUsuario($_GET['idUsuario']);
                $objUsuario->setMatricula($_POST['numMatricula']);
                $objUsuario->setSenha($_POST['password']);
                $objUsuario->setCPF($_POST['numCPF']);
                $objUsuarioRN->alterar($objUsuario);
                $alert = Alert::alert_success("O usuário -".$objUsuario->getMatricula()."- foi <strong>alterado</strong> com sucesso");
            }


            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_usuario.php');
    }
} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Cadastrar Usuário");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("usuario");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar($titulo,null,null,'listar_usuario','LISTAR USUÁRIOS');
Pagina::getInstance()->mostrar_excecoes();
echo  $alert;

echo '

<div class="conteudo_grande">
    <form method="POST">
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="label_matricula">Digite a matrícula:</label>
                <input type="text" class="form-control" id="idMatricula" placeholder="Matrícula" 
                      name="numMatricula" required value="'. Pagina::formatar_html($objUsuario->getMatricula()) .'">

            </div>
            <div class="col-md-4 mb-3">
                <label for="label_matricula">Digite o CPF:</label>
                <input type="text" class="form-control" id="idMatricula" placeholder="CPF" 
                      name="numCPF" required value="'. Pagina::formatar_html($objUsuario->getCPF()) .'">

            </div>
            <div class="col-md-4 mb-3">
                <label for="label_senha">Digite a senha:</label>
                <input type="password" class="form-control" id="idPassword" placeholder="Senha" 
                    name="password" required value="'. Pagina::formatar_html($objUsuario->getSenha()) .'">

            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12 mb-3">
                <input class="btn btn-primary" type="submit" name="salvar_usuario" style="width: 40%;margin-left: 30%;" value="SALVAR"></input>
            </div>
        </div>  
       
    </form>
</div>';


Pagina::getInstance()->fechar_corpo();



