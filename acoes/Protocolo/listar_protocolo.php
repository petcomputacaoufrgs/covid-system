<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{
    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';
    require_once __DIR__.'/../../classes/Protocolo/Protocolo.php';
    require_once __DIR__.'/../../classes/Protocolo/ProtocoloRN.php';

    Sessao::getInstance()->validar();

    $objProtocolo = new Protocolo();
    $objProtocoloRN = new ProtocoloRN();
    $html = '';
    $alert = '';

    switch ($_GET['action']){
        case 'remover_protocolo':
            try{
                $objProtocolo->setIdProtocolo($_GET['idProtocolo']);
                $objProtocoloRN->remover($objProtocolo);
                $alert .= Alert::alert_success("Protocolo removido com sucesso");
                break;
            } catch (Throwable $ex) {
                Pagina::getInstance()->processar_excecao($ex);
            }
    }


    $arrProtocolo = $objProtocoloRN->listar(new Protocolo());
    foreach ($arrProtocolo as $p){


        $html.='<tr>
                    <th scope="row">'.Pagina::formatar_html($p->getIdProtocolo()).'</th>
                        <td>'.Pagina::formatar_html($p->getProtocolo()).'</td>
            
                        <td>'.Pagina::formatar_html($p->getNumMaxAmostras()).'</td>';

        if(Sessao::getInstance()->verificar_permissao('editar_protocolo')) {
            $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_protocolo&idProtocolo='.Pagina::formatar_html($p->getIdProtocolo())).'"><i class="fas fa-edit "></i></a></td>';
        }

        if(Sessao::getInstance()->verificar_permissao('remover_protocolo')) {
            $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_protocolo&idProtocolo='.Pagina::formatar_html($p->getIdProtocolo())).'"><i class="fas fa-trash-alt"></a></td>';
        }

        $html .= ' </tr>';
    }

} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Protocolos");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('LISTAR PROTOCOLOS',null,null, 'cadastrar_protocolo', 'NOVO PROTOCOLO');
Pagina::getInstance()->mostrar_excecoes();

echo $alert.'
    <div class="conteudo_listar">'.
    '<div class="conteudo_tabela"><table class="table table-hover">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">PROTOCOLO</th>
                        <th scope="col">Nº MÁX DE AMOSTRAS</th>
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

