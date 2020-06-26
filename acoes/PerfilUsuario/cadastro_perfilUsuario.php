<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once __DIR__ . '/../../classes/PerfilUsuario/PerfilUsuario.php';
    require_once __DIR__ . '/../../classes/PerfilUsuario/PerfilUsuarioRN.php';
    require_once __DIR__ . '/../../utils/Utils.php';
    require_once __DIR__ . '/../../utils/Alert.php';

    Sessao::getInstance()->validar();


    $utils = new Utils();
    $objPerfilUsuario = new PerfilUsuario();
    $objPerfilUsuarioRN = new PerfilUsuarioRN();
    $alert = '';


    switch($_GET['action']){
        case 'cadastrar_perfilUsuario':
            if(isset($_POST['salvar_perfilUsuario'])){
                
                $objPerfilUsuario->setPerfil($_POST['txtPerfilUsuario']);
                $objPerfilUsuario->setIndex_perfil(strtoupper($utils->tirarAcentos($_POST['txtPerfilUsuario'])));
                if(empty($objPerfilUsuarioRN->pesquisar_index($objPerfilUsuario))){
                    $objPerfilUsuarioRN->cadastrar($objPerfilUsuario);
                    $alert= Alert::alert_success("Perfil usuário CADASTRADO com sucesso");
                }
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
                    $alert= Alert::alert_success("Perfil usuário ALTERADO com sucesso");
                }
            }

            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_perfilUsuario.php');  
    }
   
} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Cadastrar Perfil do usuário");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("perfilUsuario");
Pagina::fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('CADASTRAR PERFIL USUÁRIO',null,null, "listar_perfilUsuario", "LISTAR PERFIL USUÁRIO");
Pagina::getInstance()->mostrar_excecoes();

echo $alert.'
<div class="conteudo">
<form method="POST">
    <div class="form-row">
        <div class="col-md-12 mb-3">
            <label for="label_perfilUsuario">Digite o perfil do usuário:</label>
            <input type="text" class="form-control" id="idPerfilUsuario" placeholder="Perfil do usuário" 
                   onblur="validaPerfilUsuario()" name="txtPerfilUsuario" required value="'.Pagina::formatar_html($objPerfilUsuario->getPerfil()).'">
            <div id ="feedback_perfilUsuario"></div>

        </div>
    </div>  
    <button class="btn btn-primary" type="submit" name="salvar_perfilUsuario">Salvar</button>
</form>
</div>';

Pagina::getInstance()->fechar_corpo();


