<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Modelo/Modelo.php';
require_once '../classes/Modelo/ModeloRN.php';

$objModelo = new Modelo();
$objModeloRN = new ModeloRN();
$html = '';

try{
    
    $arrModelos = $objModeloRN->listar($objModelo);
    foreach ($arrModelos as $m){   
    $html.='<tr>
                <th scope="row">'.Pagina::formatar_html($m->getIdModelo()).'</th>
                <td>'.Pagina::formatar_html($m->getModelo()).'</td>
                <td>';
            
            if(Sessao::getInstance()->verificar_permissao('editar_modelo')){      
                $html.= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_modelo&idModelo='.Pagina::formatar_html($m->getIdModelo())).'">Editar</a>';
            }
            $html .= '</td><td>';
                if(Sessao::getInstance()->verificar_permissao('remover_modelo')){
                   $html.= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_modelo&idModelo='.Pagina::formatar_html($m->getIdModelo())).'">Remover</a>';
                }
            $html .='</td></tr>';
    }
    
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Modelo");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("modelo");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();

echo '
    <div class="conteudo_listar">'.
    
       Pagina::montar_topo_listar('LISTAR MODELOS', 'cadastrar_modelo', 'NOVO MODELO').
        
        '<div class="conteudo_tabela">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">#ID</th>
                  <th scope="col">modelo</th>
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


Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo(); 


