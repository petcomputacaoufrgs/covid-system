<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Equipamento/Equipamento.php';
require_once '../classes/Equipamento/EquipamentoRN.php';

$objEquipamento = new Equipamento();
$objEquipamentoRN = new EquipamentoRN();
$html = '';

try{
    
    $arrEquipamentos = $objEquipamentoRN->listar($objEquipamento);
    foreach ($arrEquipamentos as $e){   
        $html.='<tr>
                    <th scope="row">'.Pagina::formatar_html($e->getIdEquipamento()).'</th>
                        <td>'.Pagina::formatar_html($e->getIdDetentor_fk()).'</td>
                        <td>'.Pagina::formatar_html($e->getIdMarca_fk()).'</td>
                        <td>'.Pagina::formatar_html($e->getIdModelo_fk()).'</td>
                        <td>'.Pagina::formatar_html($e->getDataUltimaCalibragem()).'</td>
                        <td>'.Pagina::formatar_html($e->getDataChegada()).'</td>
                        <td>';
        
            if(Sessao::getInstance()->verificar_permissao('editar_equipamento')){      
                $html.= '<a href="'. Sessao::getInstance()->assinar_link('controlador.php?action=editar_equipamento&idEquipamento='.Pagina::formatar_html($e->getIdEquipamento())).'">Editar</a>';
            }
            $html .= '</td><td>';
                if(Sessao::getInstance()->verificar_permissao('remover_equipamento')){
                   $html.= ' <a href="'. Sessao::getInstance()->assinar_link('controlador.php?action=remover_equipamento&idEquipamento='.Pagina::formatar_html($e->getIdEquipamento())).'">Remover</a>';
                }
            $html .='</td></tr>';
    }
    
} catch (Exception $ex) {
  Pagina::getInstance()->processar_excecao($ex);
}


Pagina::getInstance()->abrir_head("Listar Equipamentos");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();

echo    '
    <div class="conteudo_listar">'.
    
       Pagina::montar_topo_listar('LISTAR EQUIPAMENTOS', 'cadastrar_equipamento', 'NOVO EQUIPAMENTO').
        
        '<div class="conteudo_tabela">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">detentor</th>
                        <th scope="col">marca</th>
                        <th scope="col">modelo</th>
                        <th scope="col">data da última calibragem</th>
                        <th scope="col">data chegada</th>
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