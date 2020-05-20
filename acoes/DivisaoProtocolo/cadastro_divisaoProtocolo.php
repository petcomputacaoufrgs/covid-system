<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try {
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';

    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';

    require_once __DIR__ . '/../../classes/DivisaoProtocolo/DivisaoProtocolo.php';
    require_once __DIR__ . '/../../classes/DivisaoProtocolo/DivisaoProtocoloRN.php';
    require_once __DIR__ . '/../../classes/Protocolo/Protocolo.php';
    require_once __DIR__ . '/../../classes/Protocolo/ProtocoloRN.php';


    /* UTILIDADES */
    require_once __DIR__ . '/../../utils/Utils.php';
    require_once __DIR__ . '/../../utils/Alert.php';

    Sessao::getInstance()->validar();

    $alert = "";
    $select_protocolo = '';

    /* PROTOCOLO */
    $objProtocolo = new Protocolo();
    $objProtocoloRN = new ProtocoloRN();

    /* DIVISÃO PROTOCOLO */
    $objDivisaoProtocolo = new DivisaoProtocolo();
    $objDivisaoProtocoloRN = new DivisaoProtocoloRN();



    InterfacePagina::montar_select_protocolos($select_protocolos, $objProtocolo, $objProtocoloRN, '', '');


    switch ($_GET['action']) {

        case 'cadastrar_divisao_protocolo':

            if (isset($_POST['btn_salvar_divisao_protocolo'])) {
                if (isset($_POST['sel_protocolos'])) {
                    $objDivisaoProtocolo->setIdProtocoloFk($_POST['sel_protocolos']);
                    $objDivisaoProtocolo->setNomeDivisao($_POST['txtDivisao']);
                    $objProtocolo->setIdProtocolo($_POST['sel_protocolos']);
                    $objDivisaoProtocoloRN->cadastrar($objDivisaoProtocolo);
                    $alert .=  Alert::alert_success("Divisão do protocolo -".$_POST['txtDivisao']."- <strong>cadastrada</strong> com sucesso");

                }

                InterfacePagina::montar_select_protocolos($select_protocolos, $objProtocolo, $objProtocoloRN, '', '');
            }
            break;

        case 'editar_divisao_protocolo':

            $objDivisaoProtocolo->setIdDivisaoProtocolo($_GET['idDivisaoProtocolo']);

            if (!isset($_POST['btn_salvar_divisao_protocolo'])) { //enquanto não enviou o formulário com as alterações
                $objDivisaoProtocolo = $objDivisaoProtocoloRN->consultar($objDivisaoProtocolo);
                $objProtocolo->setIdProtocolo($objDivisaoProtocolo->getIdProtocoloFk());
                InterfacePagina::montar_select_protocolos($select_protocolos, $objProtocolo, $objProtocoloRN, '', '');

            }

            //se enviou o formulário com as alterações
                if (isset($_POST['btn_salvar_divisao_protocolo'])) {
                    if (isset($_POST['sel_protocolos'])) {
                        $objDivisaoProtocolo->setIdProtocoloFk($_POST['sel_protocolos']);
                        $objDivisaoProtocolo->setNomeDivisao($_POST['txtDivisao']);
                        $objProtocolo->setIdProtocolo($_POST['sel_protocolos']);
                        $objDivisaoProtocoloRN->alterar($objDivisaoProtocolo);
                        $alert .=  Alert::alert_success("Divisão do protocolo -".$_POST['txtDivisao']."- <strong>alterada</strong> com sucesso");

                    }

                    InterfacePagina::montar_select_protocolos($select_protocolos, $objProtocolo, $objProtocoloRN, '', '');
                }


            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastrar_divisao_protocolo.php');
    }
} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}



Pagina::abrir_head("Cadastrar a divisão do protocolo");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('CADASTRAR DIVISÃO DO PROTOCOLO',null,null, 'listar_divisao_protocolo', 'LISTAR DIVISÕES DOS PROTOCOLOS');
Pagina::getInstance()->mostrar_excecoes();
echo $alert.
    '<div class="conteudo_grande"   style="margin-top: -50px;">
        <div class="formulario">
            <form method="POST">
                <div class="form-row">
                    <div class="col-md-4">
                        <label for="label_usuarios">Selecione o protocolo:</label>'.
    $select_protocolos
    .'</div>

                    <div class="col-md-8">
                        <label for="label_perfis">Informe a divisão do protocolo:</label><br>
                        <input type="text" class="form-control"  placeholder="divisão" 
                   onblur="" name="txtDivisao"  value="'.Pagina::formatar_html($objDivisaoProtocolo->getNomeDivisao()).'">
            </div>
                </div>
                <button class="btn btn-primary" type="submit" name="btn_salvar_divisao_protocolo">SALVAR</button> 
                 
            </form>
        </div>  
    </div>';

ECHO


Pagina::getInstance()->fechar_corpo();
