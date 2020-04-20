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
require_once '../classes/CadastroAmostra/CadastroAmostra.php';
require_once '../classes/CadastroAmostra/CadastroAmostraRN.php';

require_once '../classes/Usuario/Usuario.php';
require_once '../classes/Usuario/UsuarioRN.php';

require_once '../classes/Paciente/Paciente.php';
require_once '../classes/Paciente/PacienteRN.php';

require_once '../classes/PerfilPaciente/PerfilPaciente.php';
require_once '../classes/PerfilPaciente/PerfilPacienteRN.php';

require_once '../classes/Usuario/Usuario.php';
require_once '../classes/Usuario/UsuarioRN.php';



try {
    Sessao::getInstance()->validar();

$objPaciente = new Paciente();
$objPacienteRN = new PacienteRN();
$objPerfilPaciente = new PerfilPaciente();
$objPerfilPacienteRN = new PerfilPacienteRN();


$objAmostra = new Amostra();
$objAmostraRN = new AmostraRN();

$objCadastroAmostra = new CadastroAmostra();
$objCadastroAmostraRN = new CadastroAmostraRN();


$objUsuario = new Usuario();
$objUsuarioRN = new UsuarioRN();
$html = '';


    
    $arrCadastroAmostras = $objCadastroAmostraRN->listar($objCadastroAmostra);
    
    //print_r($arrCadastroAmostras);
    //die("caqui");
    foreach ($arrCadastroAmostras as $ca){
        $objUsuario->setIdUsuario($ca->getIdUsuario_fk());
        $objUsuario = $objUsuarioRN->consultar($objUsuario);
        
        $objAmostra->setIdAmostra($ca->getIdAmostra_fk());
        $objAmostra = $objAmostraRN->consultar($objAmostra);
        $objPaciente->setIdPaciente($objAmostra->getIdPaciente_fk());
        $objPaciente = $objPacienteRN->consultar($objPaciente);
        
        //$objPerfilPaciente->setIdPerfilPaciente($objPaciente->getIdPerfilPaciente_fk());
        //$objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
        if($ca->getIdUsuario_fk() == $_SESSION['COVID19']['ID_USUARIO']){
        if ($objAmostra->getAceita_recusa() == 'r') {
            $result = 'Recusada';
            $style = ' style="background-color:rgba(255, 0, 0, 0.2);" ';
        } else if ($objAmostra->getAceita_recusa() == 'a') {
            $result = 'Aceita';
            $style = ' style="background-color:rgba(0, 255, 0, 0.2);" ';
        }else if ($objAmostra->getAceita_recusa() == 'g') {
            $result = 'Aguardando';
            $style = ' style="background-color:rgba(255, 255, 0, 0.2);" ';
        }

        $html .= '<tr' . $style . '>
                    <th scope="row">' . Pagina::formatar_html($objAmostra->getIdAmostra()) . '</th>
                            <td>' . Pagina::formatar_html($result) . '</td>
                            <td>' . Pagina::formatar_html($objAmostra->getStatusAmostra()). '</td>
                            <td>' . Pagina::formatar_html($objAmostra->getDataHoraColeta()). '</td>
                            <td>' .Pagina::formatar_html($objUsuario->getMatricula()) . '</td>
                            <td>' .Pagina::formatar_html($objPaciente->getCPF()) . '</td>
                        <td>';
                
               if(Sessao::getInstance()->verificar_permissao('editar_amostra')){
                   $html .= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_amostra&idAmostra=' . Pagina::formatar_html($objAmostra->getIdAmostra())) . '">Editar</a>';
               }
               $html .= '</td><td>';
               if(Sessao::getInstance()->verificar_permissao('remover_amostra')){
                     $html .= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_amostra&idAmostra=' . Pagina::formatar_html($objAmostra->getIdAmostra())) . '">Remover</a>';
               }
               $html .= '</td></tr>';
        
        }
        
    }
    
    
} catch (Throwable $ex) {
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
                        <th scope="col">USUÁRIO QUE CADASTROU</th>
                        <th scope="col">PERFIL PACIENTE</th>
                        <th scope="col">CPF</th>
                        
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
