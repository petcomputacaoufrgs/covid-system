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

    $html = '';
    $alert = '';

    switch ($_GET['action']){
        case 'remover_divisao_protocolo':
            try{
                $objDivisaoProtocolo->setIdDivisaoProtocolo($_GET['idDivisaoProtocolo']);
                $objDivisaoProtocoloRN->remover($objDivisaoProtocolo);
                $alert .= Alert::alert_success("Divisão do protocolo removida com sucesso");
                break;
            } catch (Throwable $ex) {
                Pagina::getInstance()->processar_excecao($ex);
            }
    }

    $objDivisaoProtocolo = new DivisaoProtocolo();
    $arr_divisoes =$objDivisaoProtocoloRN->listar_completo($objDivisaoProtocolo);
    foreach ($arr_divisoes as $divisao){
        $html.='<tr>
                    <th scope="row">'.Pagina::formatar_html($divisao->getIdDivisaoProtocolo()).'</th>
                    <td>'.Pagina::formatar_html($divisao->getObjProtocolo()->getIndexProtocolo()).'</td>
                    <td>'.Pagina::formatar_html($divisao->getNomeDivisao()).'</td>';

        if(Sessao::getInstance()->verificar_permissao('editar_divisao_protocolo')) {
            $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_divisao_protocolo&idDivisaoProtocolo='.Pagina::formatar_html($divisao->getIdDivisaoProtocolo())).'"><i class="fas fa-edit "></i></a></td>';
        }

        if(Sessao::getInstance()->verificar_permissao('remover_divisao_protocolo')) {
            $html .= ' <td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_divisao_protocolo&idDivisaoProtocolo='.Pagina::formatar_html($divisao->getIdDivisaoProtocolo())).'"><i class="fas fa-trash-alt"></a></td>';
        }
        $html .= '</tr>';
    }

} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Divisão dos Protocolos");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('LISTAR DIVISÃO DOS PROTOCOLOS', null,null,'cadastrar_divisao_protocolo', 'NOVA DIVISÃO DE PROTOCOLO');
Pagina::getInstance()->mostrar_excecoes();
echo $alert.'
    <div class="conteudo_listar" style="width:50%;margin-left: 25%;">
        <div class="conteudo_tabela">
            <table class="table table-hover" >
                <thead>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">PROTOCOLO</th>
                        <th scope="col">DIVISÃO</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>'
    .$html.
    '</tbody>
            </table>
        </div>
    </div>';


Pagina::getInstance()->fechar_corpo();


