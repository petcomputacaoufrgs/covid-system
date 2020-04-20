<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
require_once '../classes/Sessao/Sessao.php';

require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Sessao/Sessao.php';

require_once '../classes/PerfilUsuario/PerfilUsuario.php';
require_once '../classes/PerfilUsuario/PerfilUsuarioRN.php';

require_once '../classes/Usuario/Usuario.php';
require_once '../classes/Usuario/UsuarioRN.php';

/* Relacionamentos */
require_once '../classes/Rel_usuario_perfilUsuario/Rel_usuario_perfilUsuario.php';
require_once '../classes/Rel_usuario_perfilUsuario/Rel_usuario_perfilUsuario_RN.php';



$html = '';

try{
    
    
     /* USUÁRIO + PERFIL DO USUÁRIO */
    $objRel_usuario_perfilUsuario = new Rel_usuario_perfilUsuario();
    $objRel_usuario_perfilUsuario_RN = new Rel_usuario_perfilUsuario_RN();


    /* PERFIL DO USUÁRIO */
    $objPerfilUsuario = new PerfilUsuario();
    $objPerfilUsuarioRN = new PerfilUsuarioRN();
    
    /* USUÁRIO */
    $objUsuario = new Usuario();
    $objUsuarioRN = new UsuarioRN();
    
    $arr_usuarios = $objUsuarioRN->listar($objUsuario);
    
    foreach ($arr_usuarios as $usuario){
        $objRel_usuario_perfilUsuario->setIdUsuario_fk($usuario->getIdUsuario());
        $arrRel = $objRel_usuario_perfilUsuario_RN->listar($objRel_usuario_perfilUsuario);
        
        $html.='<tr>
        <th scope="row">'.Pagina::formatar_html($usuario->getMatricula()).'</th><td> ';
        foreach ($arrRel as $relacionamento){
            $objPerfilUsuario->setIdPerfilUsuario($relacionamento->getIdPerfilUsuario_fk());
            $objPerfilUsuario = $objPerfilUsuarioRN->consultar($objPerfilUsuario);
            $html .= Pagina::formatar_html($objPerfilUsuario->getPerfil()).'    ';
        }
        $html .= '</td>
            <td><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=editar_usuario_perfilUsuario&idUsuario='.$usuario->getIdUsuario()).'">Editar</a></td>
            <td><a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=remover_usuario_perfilUsuario&idUsuario='.$usuario->getIdUsuario()).'">Remover</a></td>
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
    <div class="conteudo_listar">'.
       Pagina::montar_topo_listar('LISTAR RELACIONAMENTO DO USUÁRIO COM SEU PERFIL',null,null, 'cadastrar_usuario_perfilUsuario', 'NOVO USUÁRIO + PERFIL').
        '<div class="conteudo_tabela">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">USUÁRIO</th>
                        <th scope="col">PERFIL</th>
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
