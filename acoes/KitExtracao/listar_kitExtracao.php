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

    $objKitExtracao = new KitExtracao();
    $objKitExtracaoRN = new KitExtracaoRN();

    $html = '';



    $arr_kits_extracao = $objKitExtracaoRN->listar($objKitExtracao);
    foreach ($arr_kits_extracao as $ke){
        $html.='<tr>
                <th scope="row">'.Pagina::formatar_html($ke->getIdKitExtracao()).'</th>
                    <td>'.Pagina::formatar_html($ke->getNome()).'</td><td>';
        if(Sessao::getInstance()->verificar_permissao('editar_kitExtracao')){
            $html.= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_kitExtracao&idKitExtracao='.Pagina::formatar_html($ke->getIdKitExtracao())).'">Editar</a>';
        }
        $html .= '</td><td>';
        if(Sessao::getInstance()->verificar_permissao('remover_kitExtracao')){
            $html.= ' <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_kitExtracao&idKitExtracao='.Pagina::formatar_html($ke->getIdKitExtracao())).'">Remover</a>';
        }
        $html .='</td></tr>';
    }

} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Kits de Extração");
Pagina::getInstance()->adicionar_css("precadastros");
//Pagina::getInstance()->adicionar_javascript("detentor");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::getInstance()->mostrar_excecoes();
Pagina::montar_topo_listar('LISTAR KITS DE EXTRAÇÃO', null,null,'cadastrar_kitExtracao', 'NOVO KIT DE EXTRAÇÃO');

echo' <div class="conteudo_listar">'.

    '<div class="conteudo_tabela">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">#ID</th>
                      <th scope="col">KIT DE EXTRAÇÃO</th>
                      <th scope="col"></th>
                      <th scope="col"></th>
                    </tr>
                  </thead>
                  <tbody>'
    .$html.
    '</tbody>
                </table>
            </div>
           </div> ';



Pagina::getInstance()->fechar_corpo();


