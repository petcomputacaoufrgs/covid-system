<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{
    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';
    require_once __DIR__.'/../../classes/Sexo/Sexo.php';
    require_once __DIR__.'/../../classes/Sexo/SexoRN.php';

    Sessao::getInstance()->validar();

    $objSexo = new Sexo();
    $objSexoRN = new SexoRN();
    $html = '';


    switch ($_GET['action']){
        case 'remover_sexoPaciente':
            try{
                $objSexo->setIdSexo($_GET['idSexoPaciente']);
                $objSexoRN->remover($objSexo);
                $alert .= Alert::alert_success("Sexo do paciente removido com sucesso");
                break;
            } catch (Throwable $ex) {
                Pagina::getInstance()->processar_excecao($ex);
            }
    }

    $arrSexos = $objSexoRN->listar(new Sexo());
    foreach ($arrSexos as $s){   
        $html.='<tr>
                    <th scope="row">'.Pagina::formatar_html($s->getIdSexo()).'</th>
                    <td>'.Pagina::formatar_html($s->getSexo()).'</td>';

        if(Sessao::getInstance()->verificar_permissao('editar_sexoPaciente')) {
            $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_sexoPaciente&idSexoPaciente='.Pagina::formatar_html($s->getIdSexo())).'"><i class="fas fa-edit "></i></a></td>';
        }

        if(Sessao::getInstance()->verificar_permissao('remover_sexoPaciente')) {
            $html .= ' <td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_sexoPaciente&idSexoPaciente='.Pagina::formatar_html($s->getIdSexo())).'"><i class="fas fa-trash-alt"></a></td>';
        }
        $html .= '</tr>';

    }

} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Sexo do Pacientes");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('LISTAR SEXO DOS PACIENTES', NULL,NULL,'cadastrar_sexoPaciente', 'NOVO SEXO DE PACIENTE');
Pagina::getInstance()->mostrar_excecoes();

echo $alert.'
    <div class="conteudo_listar">
        <div class="conteudo_tabela"><table class="table table-hover">
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



Pagina::getInstance()->fechar_corpo(); 


