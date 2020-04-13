<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Sexo/Sexo.php';
require_once '../classes/Sexo/SexoRN.php';

$objSexo = new Sexo();
$objSexoRN = new SexoRN();
$html = '';

try{
    
    $arrSexos = $objSexoRN->listar($objSexo);
    foreach ($arrSexos as $s){   
        $html.='<tr>
                    <th scope="row">'.Pagina::formatar_html($s->getIdSexo()).'</th>
                    <td>'.Pagina::formatar_html($s->getSexo()).'</td>
                    <td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_sexoPaciente&idSexoPaciente='.Pagina::formatar_html($s->getIdSexo())).'">Editar</a></td>
                    <td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_sexoPaciente&idSexoPaciente='.Pagina::formatar_html($s->getIdSexo())).'">Remover</a></td>
                </tr>';
    }
    
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Sexo do Pacientes");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();

echo '
    <div class="conteudo_listar">'.
       Pagina::montar_topo_listar('LISTAR SEXO DOS PACIENTES', 'cadastrar_sexoPaciente', 'NOVO SEXO DE PACIENTE').
        '<div class="conteudo_tabela"><table class="table table-hover">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">#ID</th>
                  <th scope="col">sexo</th>
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


