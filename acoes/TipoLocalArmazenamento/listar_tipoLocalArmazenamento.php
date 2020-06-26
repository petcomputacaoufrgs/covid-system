<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
try{
    session_start();
    require_once  __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once  __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once  __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once  __DIR__ . '/../../utils/Utils.php';
    require_once  __DIR__ . '/../../utils/Alert.php';

    require_once  __DIR__ . '/../../classes/TipoLocalArmazenamento/TipoLocalArmazenamento.php';
    require_once  __DIR__ . '/../../classes/TipoLocalArmazenamento/TipoLocalArmazenamentoRN.php';

    Sessao::getInstance()->validar();

    $objPagina = new Pagina();
    $objTipoLocalArm = new TipoLocalArmazenamento();
    $objTipoLocalArmRN = new TipoLocalArmazenamentoRN();
    $html = '';

    $arrTipoLocais = $objTipoLocalArmRN->listar($objTipoLocalArm);

    foreach ($arrTipoLocais as $tl){   
        $html.='<tr>
                    <th scope="row">'.Pagina::formatar_html($tl->getIdTipoLocalArmazenamento()).'</th>
                    <td>'.Pagina::formatar_html($tl->getTipo()).'</td>';

        if(Sessao::getInstance()->verificar_permissao('editar_tipoLocalArmazenamento')){
            $html.= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_tipoLocalArmazenamento&idTipoLocalArmazenamento='.Pagina::formatar_html($tl->getIdTipoLocalArmazenamento())).'">Editar</a>';
        }
        $html .= '</td><td>';
        if(Sessao::getInstance()->verificar_permissao('remover_tipoLocalArmazenamento')){
            $html.= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_tipoLocalArmazenamento&idTipoLocalArmazenamento='.Pagina::formatar_html($tl->getIdTipoLocalArmazenamento())).'">Remover</a>';
        }
        $html .='</td></tr>';

    }
    
} catch (Throwable $ex) {

   Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Listar tipos de locais de armazenamento");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("tipoLocalArmazenamento");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();

echo Pagina::montar_topo_listar('LISTAR TIPO LOCAL ARMAZENAMENTO',null,null, 'cadastrar_tipoLocalArmazenamento', 'CADASTRAR TIPO LOCAL ARMAZENAMENTO').'
<div class="conteudo_grande">
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#ID</th>
      <th scope="col">nome do local</th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    '.$html.'  
  </tbody>
</table>
</div>
';


Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();

