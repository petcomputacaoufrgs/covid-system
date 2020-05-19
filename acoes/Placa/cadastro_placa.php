<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
try{
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once __DIR__ . '/../../classes/Placa/Placa.php';
    require_once __DIR__ . '/../../classes/Placa/PlacaRN.php';
    require_once __DIR__ . '/../../classes/Protocolo/Protocolo.php';
    require_once __DIR__ . '/../../classes/Protocolo/ProtocoloRN.php';
    require_once __DIR__ . '/../../utils/Alert.php';
    require_once __DIR__ . '/../../utils/Utils.php';

    Sessao::getInstance()->validar();

    $objUtils = new Utils();
    $objPlaca = new Placa();
    $objPlacaRN = new PlacaRN();

    $objProtocolo = new Protocolo();
    $objProtocoloRN = new ProtocoloRN();

    $alert = '';

    $select_protocolos  = '';


    switch($_GET['action']){
        case 'cadastrar_placa':
            InterfacePagina::montar_select_protocolos($select_protocolos, $objProtocolo, $objProtocoloRN, $disabled, $onchange);

            if(isset($_POST['salvar_placa'])){
                $objPlaca->setPlaca($_POST['txtPlaca']);
                $objPlaca->setIndexPlaca(strtoupper($objUtils->tirarAcentos($_POST['txtPlaca'])));
                $objPlaca->setSituacaoPlaca(PlacaRN::$STA_SOLICITACAO_MONTAGEM);
                $objPlaca->setIdProtocoloFk($_POST['sel_protocolos']);

                $objPlaca  = $objPlacaRN->cadastrar($objPlaca);
                $alert.= Alert::alert_success("A placa -".$objPlaca->getPlaca()."- foi cadastrada");

            }
            break;

        case 'editar_placa':
            if(!isset($_POST['salvar_placa'])){ //enquanto não enviou o formulário com as alterações
                $objPlaca->setIdPlaca($_GET['idPlaca']);
                $objPlaca = $objPlacaRN->consultar($objPlaca);
                $objProtocolo->setIdProtocolo($objPlaca->getIdProtocoloFk());
                InterfacePagina::montar_select_protocolos($select_protocolos, $objProtocolo, $objProtocoloRN, $disabled, $onchange);
            }

            if(isset($_POST['salvar_placa'])){ //se enviou o formulário com as alterações
                $objPlaca->setIdPlaca($_GET['idPlaca']);
                $objPlaca->setPlaca($_POST['txtPlaca']);
                $objPlaca->setIndexPlaca(strtoupper($objUtils->tirarAcentos($_POST['txtPlaca'])));
                $objPlaca->setIdProtocoloFk($_POST['sel_protocolos']);
                $objPlaca->setSituacaoPlaca(PlacaRN::$STA_SOLICITACAO_MONTAGEM);

                $objPlacaRN->alterar($objPlaca);
                $alert .= Alert::alert_success("A placa foi alterada");
            }
            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_placa.php');
    }

    InterfacePagina::montar_select_protocolos($select_protocolos, $objProtocolo, $objProtocoloRN, $disabled, $onchange);

} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Cadastrar Placa");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar("CADASTRAR PLACA",null,null,"listar_placa","LISTAR PLACAS");
Pagina::getInstance()->mostrar_excecoes();
echo $alert.'
 
<div class="conteudo_grande" style="margin-top: -15px;">
<form method="POST">
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="label_nome">Digite o nome da placa:</label>
            <input type="text" class="form-control" id="idNomeProtocolo" placeholder="placa" 
                   onblur="" name="txtPlaca"  value="'.Pagina::formatar_html($objPlaca->getPlaca()).'">
   

        </div>
        <div class="col-md-6 mb-3">
            <label for="label_etapa">Selecione o protocolo:</label>'.
            $select_protocolos.'     

        </div>
       
    </div>  
    <button class="btn btn-primary" type="submit" name="salvar_placa">Salvar</button>
</form>
</div>';



Pagina::getInstance()->fechar_corpo();

