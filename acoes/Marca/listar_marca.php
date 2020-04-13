<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Marca/Marca.php';
require_once '../classes/Marca/MarcaRN.php';

$objMarca = new Marca();
$objMarcaRN = new MarcaRN();
$html = '';

try{
    
    $arrMarcas = $objMarcaRN->listar($objMarca);
    foreach ($arrMarcas as $m){   
        $html.='<tr>
                    <th scope="row">'.Pagina::formatar_html($m->getIdMarca()).'</th>
                        <td>'.Pagina::formatar_html($m->getMarca()).'</td>
                        <td>';
        
            if(Sessao::getInstance()->verificar_permissao('editar_marca')){      
                $html.= '<a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=editar_marca&idMarca='.Pagina::formatar_html($m->getIdMarca())).'">Editar</a>';
            }
            $html .= '</td><td>';
                if(Sessao::getInstance()->verificar_permissao('remover_marca')){
                   $html.= '<a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=remover_marca&idMarca='.Pagina::formatar_html($m->getIdMarca())).'">Remover</a>';
                }
            $html .='</td></tr>';
    }
    
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Marcas");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("marca");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();

echo '
    
    <div class="conteudo_listar">'.
       Pagina::montar_topo_listar('LISTAR MARCAS', 'cadastrar_marca', 'NOVA MARCA').
        
        '<div class="conteudo_tabela">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">#ID</th>
                  <th scope="col">marca</th>
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


