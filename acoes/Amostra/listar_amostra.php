<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Amostra/Amostra.php';
require_once '../classes/Amostra/AmostraRN.php';

$objAmostra = new Amostra();
$objAmostraRN = new AmostraRN();
$html = '';

try {

    $arrAmostras = $objAmostraRN->listar($objAmostra);
    foreach ($arrAmostras as $r) {
        if ($r->getAceita_recusa() == 'r') {
            $result = 'Recusada';
            $style = ' style="background-color:rgba(255, 0, 0, 0.2);" ';
        } else if ($r->getAceita_recusa() == 'a') {
            $result = 'Aceita';
            $style = ' style="background-color:rgba(0, 255, 0, 0.2);" ';
        }
        $html .= '<tr' . $style . '>
                    <th scope="row">' . Pagina::formatar_html($r->getIdAmostra()) . '</th>
                            <td>' . Pagina::formatar_html($result) . '</td>
                            <td>' . Pagina::formatar_html($r->getStatusAmostra()). '</td>
                            <td>' . Pagina::formatar_html($r->getDataHoraColeta()). '</td>
                        <td>';
                
               if(Sessao::getInstance()->verificar_permissao('editar_amostra')){
                   $html .= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_amostra&idAmostra=' . Pagina::formatar_html($r->getIdAmostra())) . '">Editar</a>';
               }
               $html .= '</td><td>';
               if(Sessao::getInstance()->verificar_permissao('remover_amostra')){
                     $html .= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_amostra&idAmostra=' . Pagina::formatar_html($r->getIdAmostra())) . '">Remover</a>';
               }
               $html .= '</td></tr>';
    }
} catch (Exception $ex) {
   Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Listar Amostras");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();



echo '
    <div class="conteudo_listar">'.
        Pagina::montar_topo_listar('LISTAR AMOSTRAS', 'cadastrar_amostra', 'NOVA AMOSTRA').
        '<div class="conteudo_tabela">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">CÓDIGO</th>
                        <th scope="col">ACEITA OU RECUSADA</th>
                        <th scope="col">STATUS DA AMOSTRA</th>
                        <th scope="col">DATA E HORA DA COLETA</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>'
             . $html .
             '</tbody>
            </table>
        </div>
    </div>';


Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();
