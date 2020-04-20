<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Usuario/Usuario.php';
require_once '../classes/Usuario/UsuarioRN.php';

try {
    Sessao::getInstance()->validar();

    $objPagina = new Pagina();
    $objUsuario = new Usuario();
    $objUsuarioRN = new UsuarioRN();
    $html = '';
    $arrUsuarios = $objUsuarioRN->listar($objUsuario);
    foreach ($arrUsuarios as $u) {
        $html .= '<tr>
                    <th scope="row">' . Pagina::formatar_html($u->getIdUsuario()) . '</th>
                    <td>' . Pagina::formatar_html($u->getMatricula()) . '</td>
                    <td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_usuario&idUsuario=' . Pagina::formatar_html($u->getIdUsuario())) . '">Editar</a></td>
                    <td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_usuario&idUsuario=' . Pagina::formatar_html($u->getIdUsuario())) . '">Remover</a></td>
                </tr>';
    }
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Usuários");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();

echo '
    <div class="conteudo_listar">' .
 Pagina::montar_topo_listar('LISTAR USUÁRIOS', null, null, 'cadastrar_usuario', 'NOVO USUÁRIO') .
 '<div class="conteudo_tabela"><table class="table table-hover">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">#ID</th>
                  <th scope="col">matrícula</th>
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


