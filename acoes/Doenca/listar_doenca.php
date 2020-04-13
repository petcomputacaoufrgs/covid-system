<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Doenca/Doenca.php';
require_once '../classes/Doenca/DoencaRN.php';



Sessao::getInstance()->validar();

$objDoenca = new Doenca();
$objDoencaRN = new DoencaRN();
$html = '';

try {

    $arrDoencas = $objDoencaRN->listar($objDoenca);
    foreach ($arrDoencas as $d) {
        $html .= '<tr>
                    <th scope="row">' . Pagina::formatar_html($d->getIdDoenca()) . '</th>
                    <td>' . Pagina::formatar_html($d->getDoenca()) . '</td>
                    <td>';
                           
            if(Sessao::getInstance()->verificar_permissao('editar_doenca')){      
                $html.= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_doenca&idDoenca=' . Pagina::formatar_html($d->getIdDoenca())) . '">Editar</a>';
            }
            $html .= '</td><td>';
                if(Sessao::getInstance()->verificar_permissao('remover_doenca')){
                   $html.= ' <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_doenca&idDoenca=' . Pagina::formatar_html($d->getIdDoenca())) . '">Remover</a>';
                }
            $html .='</td></tr>';
    }
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::getInstance()->abrir_head("Listar Doenças");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();


echo    '
        <div class="conteudo_listar">'.
        Pagina::montar_topo_listar('LISTAR DOENÇAS', 'cadastrar_doenca', 'NOVA DOENÇA').
       
        '<div class="conteudo_tabela">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">doença</th>
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
