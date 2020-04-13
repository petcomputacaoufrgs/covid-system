<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/PerfilPaciente/PerfilPaciente.php';
require_once '../classes/PerfilPaciente/PerfilPacienteRN.php';

$objPerfilPaciente = new PerfilPaciente();
$objPerfilPacienteRN = new PerfilPacienteRN();
$html = '';

try{
    
    $arrPerfisPacientes = $objPerfilPacienteRN->listar($objPerfilPaciente);
    foreach ($arrPerfisPacientes as $pp){   
        $html.='<tr>
                    <th scope="row">'.Pagina::formatar_html($pp->getIdPerfilPaciente()).'</th>
                    <td>'.Pagina::formatar_html($pp->getPerfil()).'</td>
                    <td>';
        
            if(Sessao::getInstance()->verificar_permissao('editar_perfilPaciente')){      
                $html.= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_perfilPaciente&idPerfilPaciente='.Pagina::formatar_html($pp->getIdPerfilPaciente())).'">Editar</a>';
            }
            $html .= '</td><td>';
                if(Sessao::getInstance()->verificar_permissao('remover_perfilPaciente')){
                   $html.= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_perfilPaciente&idPerfilPaciente='.Pagina::formatar_html($pp->getIdPerfilPaciente())).'">Remover</a>';
                }
            $html .='</td></tr>';
    }
    
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Perfis de Pacientes");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();


echo '
    <div class="conteudo_listar">'.
       Pagina::montar_topo_listar('LISTAR PERFIS DOS PACIENTES', 'cadastrar_perfilPaciente', 'NOVO PERFIL DE PACIENTE').
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


