<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
 require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
 require_once __DIR__ . '/../../classes/Etnia/Etnia.php';
require_once __DIR__ . '/../../classes/Etnia/EtniaRN.php';

$objEtnia = new Etnia();
$objEtniaRN = new EtniaRN();
$html = '';

try{
    Sessao::getInstance()->validar();
    $arrEtnias = $objEtniaRN->listar($objEtnia);
    foreach ($arrEtnias as $r){   
         $html.='<tr>
                <th scope="row">'.Pagina::formatar_html($r->getIdEtnia()).'</th>
                    <td>'.Pagina::formatar_html($r->getEtnia()).'</td><td>';
        if(Sessao::getInstance()->verificar_permissao('editar_etnia')){      
            $html.= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_etnia&idEtnia='.Pagina::formatar_html($r->getIdEtnia())).'">Editar</a>';
        }
        $html .= '</td><td>';
            if(Sessao::getInstance()->verificar_permissao('remover_etnia')){
               $html.= ' <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_etnia&idEtnia='.Pagina::formatar_html($r->getIdEtnia())).'">Remover</a>';
            }
        $html .='</td></tr>';
    }
    
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Etnias");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("etnia");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();

    
   echo' <div class="conteudo_listar">'.
            Pagina::montar_topo_listar('LISTAR ETINIAS', null,null,'cadastrar_etnia', 'NOVA ETNIA').
            '<div class="conteudo_tabela">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">#ID</th>
                      <th scope="col">etnia</th>
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



Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo(); 


