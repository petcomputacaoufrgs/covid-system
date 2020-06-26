<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */


session_start();
try{

    require_once __DIR__. '/../../classes/Sessao/Sessao.php';
    require_once __DIR__. '/../../classes/Pagina/Pagina.php';
    require_once __DIR__. '/../../classes/Excecao/Excecao.php';
    require_once __DIR__. '/../../classes/KitExtracao/KitExtracao.php';
    require_once __DIR__. '/../../classes/KitExtracao/KitExtracaoRN.php';
    require_once __DIR__. '/../../utils/Utils.php';
    require_once __DIR__. '/../../utils/Alert.php';

    Sessao::getInstance()->validar();
    $utils = new Utils();
    $objKitExtracao = new KitExtracao();
    $objKitExtracaoRN = new KitExtracaoRN();
    $alert = '';


    switch ($_GET['action']) {
        case 'cadastrar_kitExtracao':
            if (isset($_POST['salvar_kitExtracao'])) {
                $objKitExtracao->setNome($_POST['txtNome']);
                $objKitExtracao->setIndexNome(strtoupper($utils->tirarAcentos($_POST['txtNome'])));
                $objKitExtracao = $objKitExtracaoRN->cadastrar($objKitExtracao);
                $alert .= Alert::alert_success("Kit - ".$objKitExtracao->getNome()." - cadastrado com sucesso ");
            } else {
                $objKitExtracao->setNome('');
                $objKitExtracao->setIndexNome('');
            }
            break;

        case 'editar_kitExtracao':
            if (!isset($_POST['salvar_kitExtracao'])) { //enquanto não enviou o formulário com as alterações
                $objKitExtracao->setIdKitExtracao($_GET['idKitExtracao']);
                $objKitExtracao = $objKitExtracaoRN->consultar($objKitExtracao);
            }

            if (isset($_POST['salvar_kitExtracao'])) { //se enviou o formulário com as alterações
                $objKitExtracao->setIdKitExtracao($_GET['idDetentor']);
                $objKitExtracao->setNome($_POST['txtNome']);
                $objKitExtracao->setIndexNome(strtoupper($utils->tirarAcentos($_POST['txtNome'])));
                $objKitExtracao =  $objKitExtracaoRN->alterar($objKitExtracao);
                $alert .= Alert::alert_success("Kit - ".$objKitExtracao->getNome()." - alterado com sucesso ");

            }

            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_kitExtracao.php');
    }
} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Cadastrar Kit de Extração");
Pagina::getInstance()->adicionar_css("precadastros");
//Pagina::getInstance()->adicionar_javascript("detentor");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('CADASTRAR KIT DE EXTRAÇÃO', null,null,'listar_kitExtracao', 'LISTAR KIT DE EXTRAÇÃO');
Pagina::getInstance()->mostrar_excecoes();
echo $alert;
echo '<div class="conteudo" style="margin-top: -50px;width: 100%;">
        <div class="formulario">
            <form method="POST">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="label_detentor">Digite o nome do kit de extração:</label>
                        <input type="text" class="form-control" id="idDetentor" placeholder="Kit de Extração" 
                               onblur="" name="txtNome" 
                               required value="'. Pagina::formatar_html($objKitExtracao->getNome()).'">
                        <div id ="feedback_detentor"></div>
                    </div>

                </div>  
                <button class="btn btn-primary" type="submit" name="salvar_kitExtracao">Salvar</button>
            </form>
        </div>
    </div>';


Pagina::getInstance()->fechar_corpo();



