<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();

try{
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';

    require_once __DIR__ . '/../../classes/Capela/Capela.php';
    require_once __DIR__ . '/../../classes/Capela/CapelaRN.php';


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
                        <td>'.Pagina::formatar_html(CapelaRN::mostrarDescricaoTipo($m->getSituacaoCapela())).'</td>
                        <td>'.Pagina::formatar_html(CapelaRN::mostrarDescricaoTipoSeguranca($m->getNivelSeguranca())).'</td>
                <td>';
               if(Sessao::getInstance()->verificar_permissao('editar_capela')){
                   $html .= '<a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=editar_capela&idCapela='.Pagina::formatar_html($m->getIdCapela())).'"><i class="fas fa-edit "></i></a>';
               }
               $html .= '</td>';

               /*if(Sessao::getInstance()->verificar_permissao('remover_capela')){
                     $html .= '<td><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=remover_capela&idCapela='.Pagina::formatar_html($m->getIdCapela())).'"><i class="fas fa-trash-alt"></a></td>';
               }*/
               $html .= '</tr>';
    }
    
} catch (Throwable $ex) {
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


