<?php

session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Capela/Capela.php';
require_once '../classes/Capela/CapelaRN.php';
require_once '../utils/Utils.php';
require_once '../utils/Alert.php';
try {
    Sessao::getInstance()->validar();
$utils = new Utils();
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

}catch (Throwable $ex) {
    
}


Pagina::abrir_head("LOCK capela");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();

echo $alert.
        '<div class="conteudo">
            <form method="POST">

                <button class="btn btn-primary" type="submit" name="lock_capela">LOCK</button>
            </form>
        </div>';

Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();