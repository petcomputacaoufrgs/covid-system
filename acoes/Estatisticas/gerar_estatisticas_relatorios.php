<?php

try{
    //die( 'Versão Atual do PHP: ' . phpversion());

    session_start();

    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';
    require_once __DIR__.'/../../utils/Alert.php';
    //require_once __DIR__.'/../../classes/Estatisticas/PDF_Estatisticas.php';
    Sessao::getInstance()->validar();




    if(isset($_POST['btn_estatisticas_pacientes'])){
        header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=gerar_estatisticas_paciente'));
        die();
    }

    if(isset($_POST['btn_estatisticas_prefeitura'])){
        header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=gerar_estatisticas_prefeitura'));
        die();
    }

}catch (Throwable $e){
    die($e);
}

Pagina::abrir_head("Gerar Estatísticas");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar("ESTATÍSTICAS");


echo '<div class="conteudo_grande" style="margin-top: 0px;">
    <form method="POST" >         
        <div class="form-row" >
             <div class="col-md-12" style="margin: 10px;" >
                <button class="btn btn-primary"    style="width: 100%;margin-left: 0px;cursor: default;" type="submit" name="btn_estatisticas_prefeitura"> Relatórios Prefeitura de Porto Alegre </button>
             </div>
             <div class="col-md-12" style="margin: 10px;">
                <button class="btn btn-primary" style="width: 100%;margin-left: 0px;" type="submit" name="btn_estatisticas_pacientes"> Estatísticas Gerais</button>
             </div>
        </div>
    </form>
</div>';


Pagina::getInstance()->fechar_corpo();
