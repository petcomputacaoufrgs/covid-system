<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Recurso/Recurso.php';
require_once '../classes/Recurso/RecursoRN.php';

$objRecurso = new Recurso();
$objRecursoRN = new RecursoRN();
$html = '';

try{
    
    $arrRecursos = $objRecursoRN->listar($objRecurso);
    foreach ($arrRecursos as $r){   
        $html.='<tr>
                    <th scope="row">'.Pagina::formatar_html($r->getIdRecurso()).'</th>
                        <td>'.Pagina::formatar_html($r->getNome()).'</td>
                        <td>'.Pagina::formatar_html($r->getS_n_menu()).'</td>
                        <td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_recurso&idRecurso='.Pagina::formatar_html($r->getIdRecurso())).'">Editar</a></td>
                        <td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_recurso&idRecurso='.Pagina::formatar_html($r->getIdRecurso())).'">Remover</a></td>
                </tr>';
    }
    
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Recursos");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();


echo '
    <div class="conteudo_listar">'.
       Pagina::montar_topo_listar('LISTAR RECURSOS', 'cadastrar_recurso', 'NOVO RECURSO').
        '<div class="conteudo_tabela"><table class="table table-hover">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">NOME</th>
                        <th scope="col">S/N</th>
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

