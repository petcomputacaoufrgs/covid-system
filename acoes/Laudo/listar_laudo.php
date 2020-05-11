<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

try{

    session_start();
    date_default_timezone_set('America/Sao_Paulo');
    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';
    require_once __DIR__.'/../../classes/Laudo/Laudo.php';
    require_once __DIR__.'/../../classes/Laudo/LaudoRN.php';


    Sessao::getInstance()->validar();
    $objLaudo = new Laudo();
    $objLaudoRN = new LaudoRN();
    $html = '';



    $arr_laudo = $objLaudoRN->listar($objLaudo);
    foreach ($arr_laudo as $l){
        if($l->getSituacao() == LaudoRN::$SL_PENDENTE){
            $style = ' style="background-color:rgba(255, 255, 0, 0.2);" ';
        }
        if($l->getSituacao() == LaudoRN::$SL_CONCLUIDO){
            $style = ' style="background-color:rgba(0, 255, 0, 0.2);" ';
        }

        $html.='<tr' . $style . '>
                <th scope="row">'.Pagina::formatar_html($l->getIdLaudo()).'</th>
                <td>'.Pagina::formatar_html($l->getIdAmostraFk()).'</td>
                <td>'.Pagina::formatar_html(LaudoRN::mostrarDescricaoStaLaudo($l->getSituacao())).'</td>
                <td>'.Pagina::formatar_html(LaudoRN::mostrarDescricaoResultado($l->getResultado())).'</td>
                <td>'.Pagina::formatar_html($l->getDataHoraGeracao()).'</td>
                <td>'.Pagina::formatar_html($l->getDataHoraLiberacao()).'</td><td>
                
                ';

        if(Sessao::getInstance()->verificar_permissao('editar_laudo')){
            $html.= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_laudo&idLaudo='.Pagina::formatar_html($l->getIdLaudo())).'"><i style="color:black;margin: 0px; padding: 0px;" class="fas fa-edit "></i></a>';
        }
        $html .= '</td><td>';
        if(Sessao::getInstance()->verificar_permissao('imprimir_laudo')){
            $html.= '<a  target="_blank"  href="' . Sessao::getInstance()->assinar_link('controlador.php?action=imprimir_laudo&idLaudo='.Pagina::formatar_html($l->getIdLaudo())).'"><i style="color:black;margin: 0px; padding: 0px;" class="fas fa-print"></i></a>';
        }
        $html .= '</td></tr>';

        /*if(Sessao::getInstance()->verificar_permissao('remover_detentor')){
            $html.= ' <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_detentor&idDetentor='.Pagina::formatar_html($r->getIdDetentor())).'">Remover</a>';
        }
        $html .='</td></tr>';*/
    }

} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Laudos");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::getInstance()->mostrar_excecoes();
Pagina::montar_topo_listar('LISTAR LAUDOS', null,null,NULL,NULL);

echo' <div class="conteudo_listar">
        <div class="conteudo_tabela">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Nº LAUDO</th>
                      <th scope="col">AMOSTRA</th>
                      <th scope="col">SITUAÇÃO</th>
                      <th scope="col">RESULTADO</th>
                      <th scope="col">DATA GERAÇÃO</th>
                      <th scope="col">DATA LIBERAÇÃO</th>
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


