<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';

    require_once  __DIR__ . '/../../classes/Calculo/Calculo.php';
    require_once  __DIR__ . '/../../classes/Calculo/CalculoRN.php';
    require_once  __DIR__ . '/../../classes/Calculo/CalculoINT.php';

    require_once  __DIR__ . '/../../classes/Protocolo/Protocolo.php';
    require_once  __DIR__ . '/../../classes/Protocolo/ProtocoloRN.php';
    require_once  __DIR__ . '/../../classes/Protocolo/ProtocoloINT.php';

    require_once __DIR__ . '/../../classes/Operador/Operador.php';
    require_once __DIR__ . '/../../classes/Operador/OperadorRN.php';

    require_once  __DIR__ . '/../../utils/Utils.php';
    require_once  __DIR__ . '/../../utils/Alert.php';

    Sessao::getInstance()->validar();
    $utils = new Utils();

    $objOperador = new Operador();
    $objOperadorRN = new OperadorRN();

    $objCalculo = new Calculo();
    $objCalculoRN = new CalculoRN();

    $objProtocolo = new Protocolo();
    $objProtocoloRN = new ProtocoloRN();


    $html = '';


    $arrOperadores = $objOperadorRN->listar_completo($objOperador);
    foreach ($arrOperadores as $operador){
        $html.='<tr>
                <th scope="row">'.Pagina::formatar_html($operador->getIdOperador()).'</th>
                <td>'.Pagina::formatar_html($operador->getNome()).'</td>
                <td>'.Pagina::formatar_html($operador->getValor()).'</td>
                <td>'.Pagina::formatar_html($operador->getObjCalculo()->getNome()).'</td>
                <td>';

        if(Sessao::getInstance()->verificar_permissao('editar_operador')){
            $html.= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_operador&idOperador='.Pagina::formatar_html($operador->getIdOperador())).'"><i class="fas fa-edit" style="color: black;"></i></a>';
        }
        $html .= '</td><td>';
        if(Sessao::getInstance()->verificar_permissao('remover_operador')){
            $html.= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_operador&idOperador='.Pagina::formatar_html($operador->getIdOperador())).'"><i class="fas fa-trash-alt"></i></a>';
        }
        $html .='</td></tr>';
    }

} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Operador");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::getInstance()->mostrar_excecoes();
Pagina::montar_topo_listar('LISTAR OPERADOR', null,null,'cadastrar_operador', 'NOVO OPERADOR');
echo '
    <div class="conteudo_listar">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">NOME</th>
                  <th scope="col">VALOR</th>
                  <th scope="col">CÁLCULO</th>
                  <th scope="col"></th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>'
                .$html.
            '</tbody>
            </table>
    </div>';

Pagina::getInstance()->fechar_corpo();


