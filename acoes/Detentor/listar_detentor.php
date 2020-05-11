<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Detentor/Detentor.php';
require_once '../classes/Detentor/DetentorRN.php';
Sessao::getInstance()->validar();
$objDetentor = new Detentor();
$objDetentorRN = new DetentorRN();
$html = '';

try{
    
    $arrDetentors = $objDetentorRN->listar($objDetentor);
    foreach ($arrDetentors as $r){   
         $html.='<tr>
                <th scope="row">'.Pagina::formatar_html($r->getIdDetentor()).'</th>
                    <td>'.Pagina::formatar_html($r->getDetentor()).'</td><td>';
        if(Sessao::getInstance()->verificar_permissao('editar_detentor')){      
            $html.= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_detentor&idDetentor='.Pagina::formatar_html($r->getIdDetentor())).'">Editar</a>';
        }
        $html .= '</td><td>';
            if(Sessao::getInstance()->verificar_permissao('remover_detentor')){
               $html.= ' <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_detentor&idDetentor='.Pagina::formatar_html($r->getIdDetentor())).'">Remover</a>';
            }
        $html .='</td></tr>';
    }
    
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Detentores");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("detentor");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();

    
   echo' <div class="conteudo_listar">'.
            Pagina::montar_topo_listar('LISTAR DETENTORES', 'cadastrar_detentor', 'NOVO DETENTOR').
            '<div class="conteudo_tabela">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">#ID</th>
                      <th scope="col">detentor</th>
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


