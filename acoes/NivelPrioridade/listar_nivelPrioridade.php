<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/NivelPrioridade/NivelPrioridade.php';
require_once '../classes/NivelPrioridade/NivelPrioridadeRN.php';

$objNivelPrioridade = new NivelPrioridade();
$objNivelPrioridadeRN = new NivelPrioridadeRN();
$html = '';

try{
    
    $arrNivelPrioridades = $objNivelPrioridadeRN->listar($objNivelPrioridade);
    foreach ($arrNivelPrioridades as $d){   
    $html.='<tr>
                <th scope="row">'.Pagina::formatar_html($d->getIdNivelPrioridade()).'</th>
                <td>'.Pagina::formatar_html($d->getNivel()).'</td>
                <td>';
    
            if(Sessao::getInstance()->verificar_permissao('editar_nivelPrioridade')){      
                $html.= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_nivelPrioridade&idNivelPrioridade='.Pagina::formatar_html($d->getIdNivelPrioridade())).'">Editar</a>';
            }
            $html .= '</td><td>';
                if(Sessao::getInstance()->verificar_permissao('remover_nivelPrioridade')){
                   $html.= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_nivelPrioridade&idNivelPrioridade='.Pagina::formatar_html($d->getIdNivelPrioridade())).'">Remover</a>';
                }
            $html .='</td></tr>';
    }
    
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Níveis de Prioridade");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("modelo");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();

echo '
    <div class="conteudo_listar">'.
       Pagina::montar_topo_listar('LISTAR NÍVEIS DE PRIORIDADE', 'cadastrar_nivelPrioridade', 'NOVO NÍVEL DE PRIORIDADE').
        
        '
        <div class="conteudo_tabela">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">#ID</th>
                  <th scope="col">NÍVEL DE PRIORIDADE</th>
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

