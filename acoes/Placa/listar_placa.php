<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{
    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';
    require_once __DIR__.'/../../classes/Placa/Placa.php';
    require_once __DIR__.'/../../classes/Placa/PlacaRN.php';

    Sessao::getInstance()->validar();

    $objPlaca = new Placa();
    $objPlacaRN = new PlacaRN();
    $html = '';
    $alert = '';

    switch ($_GET['action']){
        case 'remover_placa':
            try{
                $objPlaca->setIdPlaca($_GET['idPlaca']);
                $objPlacaRN->remover($objPlaca);
                $alert .= Alert::alert_success("Placa removido com sucesso");
                break;
            } catch (Throwable $ex) {
                Pagina::getInstance()->processar_excecao($ex);
            }
    }


    $arrPlaca = $objPlacaRN->listar(new Placa());
    foreach ($arrPlaca as $p){

        $html.='<tr>
                    <th scope="row">'.Pagina::formatar_html($p->getIdPlaca()).'</th>
                        <td>'.Pagina::formatar_html($p->getPlaca()).'</td>
                        <td>'.Pagina::formatar_html($p->getObjProtocolo()[0]['protocolo']).'</td>
                        <td>'.Pagina::formatar_html($p->getObjProtocolo()[0]['numMax_amostras']).'</td>
                        <td>'.Pagina::formatar_html(PlacaRN::mostrar_descricao_staPlaca($p->getSituacaoPlaca())).'</td>';

        if(Sessao::getInstance()->verificar_permissao('editar_placa')) {
            $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_placa&idPlaca='.Pagina::formatar_html($p->getIdPlaca())).'"><i class="fas fa-edit "></i></a></td>';
        }

        if(Sessao::getInstance()->verificar_permissao('remover_placa')) {
            $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_placa&idPlaca='.Pagina::formatar_html($p->getIdPlaca())).'"><i class="fas fa-trash-alt"></a></td>';
        }

        $html .= ' </tr>';
    }

} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Placas");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('LISTAR PLACAS',null,null, 'cadastrar_placa', 'NOVA PLACA');
Pagina::getInstance()->mostrar_excecoes();

echo $alert.'
    <div class="conteudo_listar">'.
    '<div class="conteudo_tabela"><table class="table table-hover">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">PLACA</th>
                        <th scope="col">PROTOCOLO</th>
                        <th scope="col">Nº MAX AMOSTRAS</th>
                        <th scope="col">SITUAÇÃO PLACA</th>
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

