<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/PerfilUsuario/PerfilUsuario.php';
require_once '../classes/PerfilUsuario/PerfilUsuarioRN.php';

$objPerfilUsuario = new PerfilUsuario();
$objPerfilUsuarioRN = new PerfilUsuarioRN();
$html = '';

try{
    
    $arrPerfisUsuarios = $objPerfilUsuarioRN->listar($objPerfilUsuario);
    foreach ($arrPerfisUsuarios as $pu){   
        $html.='<tr>
                    <th scope="row">'.Pagina::formatar_html($pu->getIdPerfilUsuario()).'</th>
                    <td>'.Pagina::formatar_html($pu->getPerfil()).'</td>
                    <td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_perfilUsuario&idPerfilUsuario='.Pagina::formatar_html($pu->getIdPerfilUsuario())).'">Editar</a></td>
                    <td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_perfilUsuario&idPerfilUsuario='.Pagina::formatar_html($pu->getIdPerfilUsuario())).'">Remover</a></td>
                </tr>';
    }
    
} catch (Exception $ex) {
      Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Perfis de Usuários");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
echo '
    <div class="conteudo_listar">'.
       Pagina::montar_topo_listar('LISTAR PERFIS DOS USUÁRIOS', 'cadastrar_perfilUsuario', 'NOVO PERFIL DE USUÁRIO').
        '<div class="conteudo_tabela">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">perfil</th>
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


