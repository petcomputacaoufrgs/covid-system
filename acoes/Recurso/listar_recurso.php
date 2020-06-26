<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{
    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';
    require_once __DIR__.'/../../classes/Recurso/Recurso.php';
    require_once __DIR__.'/../../classes/Recurso/RecursoRN.php';

    Sessao::getInstance()->validar();

    $objRecurso = new Recurso();
    $objRecursoRN = new RecursoRN();
    $html = '';
    $alert = '';

    switch ($_GET['action']){
        case 'remover_recurso':
            try{
                $objRecurso->setIdRecurso($_GET['idRecurso']);
                $objRecursoRN->remover($objRecurso);
                $alert .= Alert::alert_success("Recurso removido com sucesso");
                break;
            } catch (Throwable $ex) {
                Pagina::getInstance()->processar_excecao($ex);
            }
    }


    $arrRecursos = $objRecursoRN->listar(new Recurso());
    foreach ($arrRecursos as $r){   
        $html.='<tr>
                    <th scope="row">'.Pagina::formatar_html($r->getIdRecurso()).'</th>
                        <td>'.Pagina::formatar_html($r->getNome()).'</td>
                        <td>'.Pagina::formatar_html($r->getS_n_menu()).'</td>';

        if(Sessao::getInstance()->verificar_permissao('editar_recurso')) {
            $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_recurso&idRecurso='.Pagina::formatar_html($r->getIdRecurso())).'"><i class="fas fa-edit "></i></a></td>';
        }

        if(Sessao::getInstance()->verificar_permissao('remover_recurso')) {
            $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_recurso&idRecurso='.Pagina::formatar_html($r->getIdRecurso())).'"><i class="fas fa-trash-alt"></a></td>';
        }

        $html .= ' </tr>';
    }
    
} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Recursos");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('LISTAR RECURSOS',null,null, 'cadastrar_recurso', 'NOVO RECURSO');
Pagina::getInstance()->mostrar_excecoes();

echo $alert.'
    <div class="conteudo_listar">'.
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


Pagina::getInstance()->fechar_corpo(); 

