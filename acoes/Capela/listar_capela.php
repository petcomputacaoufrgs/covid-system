<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();

try{
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';

require_once '../classes/Capela/Capela.php';
require_once '../classes/Capela/CapelaRN.php';


Sessao::getInstance()->validar();
$objCapela = new Capela();
$objCapelaRN = new CapelaRN();
$html = '';


    
    $arrCapelas = $objCapelaRN->listar($objCapela);
    foreach ($arrCapelas as $m){

         if ($m->getSituacaoCapela() == CapelaRN::$TE_OCUPADA) {
            $style = ' style="background-color:rgba(255, 0, 0, 0.2);" ';
        } else if ($m->getSituacaoCapela() == CapelaRN::$TE_LIBERADA) {
            $style = ' style="background-color:rgba(0, 255, 0, 0.2);" ';
        }

        $html.='<tr '.$style.'>
                    <th scope="row">'.Pagina::formatar_html($m->getIdCapela()).'</th>
                        <td>'.Pagina::formatar_html($m->getNumero()).'</td>
                        <td>'.Pagina::formatar_html($objCapelaRN->mostrarDescricaoTipo($m->getSituacaoCapela())).'</td>
                        <td>'.Pagina::formatar_html($m->getNivelSeguranca()).'</td>
                <td>';
               if(Sessao::getInstance()->verificar_permissao('editar_capela')){
                   $html .= '<a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=editar_capela&idCapela='.Pagina::formatar_html($m->getIdCapela())).'">Editar</a>';
               }
               $html .= '</td><td>';
               if(Sessao::getInstance()->verificar_permissao('remover_capela')){
                     $html .= '<a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=remover_capela&idCapela='.Pagina::formatar_html($m->getIdCapela())).'">Remover</a>';
               }
               $html .= '</td></tr>';
    }
    
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Capelas");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();

echo '
    
    <div class="conteudo_listar">'.
       Pagina::montar_topo_listar('LISTAR CAPELAS', null,null,'cadastrar_capela', 'NOVA CAPELA').
        
        '<div class="conteudo_tabela">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">#ID</th>
                  <th scope="col">NÚMERO</th>
                  <th scope="col">SITUAÇÃO</th>
                  <th scope="col">NÍVEL SEGURANÇA</th>
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


