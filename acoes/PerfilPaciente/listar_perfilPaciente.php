<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPaciente.php';
    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPacienteRN.php';

    Sessao::getInstance()->validar();

    $objPerfilPaciente = new PerfilPaciente();
    $objPerfilPacienteRN = new PerfilPacienteRN();
    $html = '';
    $alert = '';

    if(isset($_GET['action']) && $_GET['action'] =='remover_perfilPaciente') {

        $objPerfilPaciente->setIdPerfilPaciente($_GET['idPerfilPaciente']);
        $objPerfilPacienteRN->remover($objPerfilPaciente);
        $alert .= Alert::alert_success("Perfil removido com sucesso");

    }

    $objPerfilPaciente = new PerfilPaciente();
    $arrPerfisPacientes = $objPerfilPacienteRN->listar($objPerfilPaciente);
    foreach ($arrPerfisPacientes as $pp) {
        $html .= '<tr>
                    <th scope="row">' . Pagina::formatar_html($pp->getIdPerfilPaciente()) . '</th>
                    <td>' . Pagina::formatar_html($pp->getPerfil()) . '</td>
                    <td>';

        if (Sessao::getInstance()->verificar_permissao('editar_perfilPaciente')) {
            $html .= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_perfilPaciente&idPerfilPaciente=' . Pagina::formatar_html($pp->getIdPerfilPaciente())) . '"><i class="fas fa-edit "></i></a>';
        }
        $html .= '</td><td>';
        if (Sessao::getInstance()->verificar_permissao('remover_perfilPaciente')) {
            $html .= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_perfilPaciente&idPerfilPaciente=' . Pagina::formatar_html($pp->getIdPerfilPaciente())) . '"><i class="fas fa-trash-alt"></a></a>';
        }
        $html .= '</td></tr>';

    }
    
} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Perfis de Pacientes");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('LISTAR PERFIS DOS PACIENTES',null,null, 'cadastrar_perfilPaciente', 'NOVO PERFIL DE PACIENTE');
Pagina::getInstance()->mostrar_excecoes();


echo $alert.'
    <div class="conteudo_listar">
        <div class="conteudo_tabela">
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


Pagina::getInstance()->fechar_corpo(); 


