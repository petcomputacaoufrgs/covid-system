<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

try {
    session_start();
    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';
    require_once __DIR__.'/../../utils/Alert.php';

    require_once __DIR__.'/../../classes/Amostra/Amostra.php';
    require_once __DIR__.'/../../classes/Amostra/AmostraRN.php';


    Sessao::getInstance()->validar();



    if(isset($_POST['pesquisar_amostra'])){
        if(isset($_POST['txtCodAmostra'])){
            $id = substr($_POST['txtCodAmostra'], 1);
            if(is_numeric($id)) {
                $objAmostra = new Amostra();
                $objAmostra->setIdAmostra($id);
                $objAmostraRN = new AmostraRN();
                $objAmostra = $objAmostraRN->consultar($objAmostra);

                if($objAmostra != null) {

                    header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_amostra&idAmostra=' . $objAmostra->getIdAmostra() . '&idPaciente=' . $objAmostra->getIdPaciente_fk()));
                    die();
                }else{
                    $alert .= Alert::alert_warning("Nenhuma amostra foi encontrada");
                }
            }else{
                $alert .= Alert::alert_warning("Informe o código da amostra (letra + número)");
            }

        }

    }



} catch (Throwable $ex) {
    //die($ex);
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Editar Amostras");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();


echo $alert.
    Pagina::montar_topo_listar('EDITAR AMOSTRA', null,null,'cadastrar_amostra', 'CADASTRAR AMOSTRA').
    '
    <div class="conteudo_grande">
        <form method="POST">
            <div class="form-row">
                <div class="col-md-10 ">
                    <label for="label_codAmostra">Informe o código da amostra:</label>
                   <input type="text" class="form-control" id="idCodAmostra" placeholder="código" 
                           onblur="" name="txtCodAmostra" required value="">
                    <div id ="feedback_amostra"></div>

                </div>
            
                <div class="col-md-2 "> 
                    <button class="btn btn-primary"  style="width: 100%;margin-left: 0px;margin-top: 33px;" type="submit" name="pesquisar_amostra">Pesquisar</button>
                </div>
            </div> 
        </form>
    </div>';



Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();
