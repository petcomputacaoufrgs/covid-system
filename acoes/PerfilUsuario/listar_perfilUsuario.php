<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once __DIR__ . '/../../classes/PerfilUsuario/PerfilUsuario.php';
    require_once __DIR__ . '/../../classes/PerfilUsuario/PerfilUsuarioRN.php';

    Sessao::getInstance()->validar();

    $objPerfilUsuario = new PerfilUsuario();
    $objPerfilUsuarioRN = new PerfilUsuarioRN();
    $html = '';
    $alert = '';

    switch ($_GET['action']){
        case 'remover_perfilUsuario':
            try{
                $objPerfilUsuario->setIdPerfilUsuario($_GET['idPerfilUsuario']);
                $objPerfilUsuarioRN->remover($objPerfilUsuario);
                $alert .= Alert::alert_success("Perfil removido com sucesso");
                break;
            } catch (Throwable $ex) {
                Pagina::getInstance()->processar_excecao($ex);
            }
    }

    $objPerfilUsuario = new PerfilUsuario();
    $arrPerfisUsuarios = $objPerfilUsuarioRN->listar($objPerfilUsuario);
    foreach ($arrPerfisUsuarios as $pu){
        $html.='<tr>
                    <th scope="row">'.Pagina::formatar_html($pu->getIdPerfilUsuario()).'</th>
                    <td>'.Pagina::formatar_html($pu->getPerfil()).'</td>';

        if(Sessao::getInstance()->verificar_permissao('editar_perfilUsuario')) {
            $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_perfilUsuario&idPerfilUsuario='.Pagina::formatar_html($pu->getIdPerfilUsuario())).'"><i class="fas fa-edit "></i></a></td>';
        }

        if(Sessao::getInstance()->verificar_permissao('remover_perfilUsuario')) {
            $html .= ' <td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_perfilUsuario&idPerfilUsuario=' . Pagina::formatar_html($pu->getIdPerfilUsuario())) . '"><i class="fas fa-trash-alt"></i></a></td>';
        }
        $html .= '</tr>';
    }

} catch (Throwable $ex) {
      Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Perfis de Usuários");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('LISTAR PERFIS DOS USUÁRIOS', null,null,'cadastrar_perfilUsuario', 'NOVO PERFIL DE USUÁRIO');
Pagina::getInstance()->mostrar_excecoes();
echo $alert.'
    <div class="conteudo_listar" style="width:50%;margin-left: 25%;">
        <div class="conteudo_tabela">
            <table class="table table-hover" >
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


Pagina::getInstance()->fechar_corpo(); 


