<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

try{

    session_start();
    date_default_timezone_set('America/Sao_Paulo');
    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';
    require_once __DIR__.'/../../classes/Laudo/Laudo.php';
    require_once __DIR__.'/../../classes/Laudo/LaudoRN.php';
    require_once __DIR__.'/../../classes/Laudo/LaudoINT.php';
    require_once __DIR__.'/../../classes/Amostra/Amostra.php';
    require_once __DIR__.'/../../classes/Amostra/AmostraRN.php';

    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPaciente.php';
    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPacienteRN.php';
    require_once __DIR__.'/../../utils/Utils.php';
    require_once __DIR__.'/../../classes/Pesquisa/PesquisaINT.php';

    Sessao::getInstance()->validar();
    $objLaudo = new Laudo();
    $objLaudoRN = new LaudoRN();
    $html = '';
    $alert =   '';

    $array_colunas = array('CÓDIGO', 'SITUAÇÃO LAUDO', 'RESULTADO','CÓDIGO AMOSTRA');
    $array_tipos_colunas = array('text', 'selectSituacao', 'selectResultado','text');
    $valorPesquisa = '';
    $select_pesquisa = '';
    $select_situacao = '';
    $select_resultado='';
    PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, null,null,' onchange="this.form.submit()" ');
    if(isset($_POST['sel_pesquisa_coluna']) ){

        PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, $_POST['sel_pesquisa_coluna'],null,' onchange="this.form.submit()" ');
        if($array_tipos_colunas[$_POST['sel_pesquisa_coluna']] == 'selectSituacao'){
            LaudoINT::montar_select_situacao($select_situacao, $objLaudo, null, null);
            $input = $select_situacao;
        }else if($array_tipos_colunas[$_POST['sel_pesquisa_coluna']] == 'selectResultado'){
            LaudoINT::montar_select_resultado($select_resultado, $objLaudo, null, null);
            $input = $select_resultado;
        } else {
            //echo $array_tipos_colunas[$_POST['sel_pesquisa_coluna']];
            $input = '<input type="' . $array_tipos_colunas[$_POST['sel_pesquisa_coluna']] . '" value="' . $_POST['valorPesquisa'] .
                '" placeholder="' . $array_colunas[$_POST['sel_pesquisa_coluna']] . '" name="valorPesquisa" aria-label="Search" class="form-control">';
        }
    }ELSE{
        $input = '<input type="text" disabled value="" id="pesquisaDisabled" placeholder="" name="valorPesquisa" aria-label="Search" class="form-control">';
    }

    if(!isset($_POST['hdnPagina'])){
        $objLaudo->setNumPagina(1);
    } else {
        $objLaudo->setNumPagina($_POST['hdnPagina']);
    }

    if(isset($_POST['valorPesquisa']) || isset($_POST['sel_resultado_laudo'])
        || isset($_POST['sel_situacao_laudo']) ){


        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'CÓDIGO' ){
            $objLaudo->setIdLaudo($_POST['valorPesquisa']);
        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'SITUAÇÃO LAUDO'){
            $objLaudo->setSituacao($_POST['sel_situacao_laudo']);
            LaudoINT::montar_select_situacao($select_situacao, $objLaudo, null, null);
            $input = $select_situacao;
        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'RESULTADO'){
            $objLaudo->setResultado($_POST['sel_resultado_laudo']);
            LaudoINT::montar_select_resultado($select_resultado, $objLaudo, null, null);
            $input = $select_resultado;
        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'CÓDIGO AMOSTRA'){
            $objAmostra = new Amostra();
            $objAmostra->setNickname($_POST['valorPesquisa']);
            $objLaudo->setObjAmostra($objAmostra);
        }

    }


    $arr_laudo = $objLaudoRN->paginacao($objLaudo);
    $alert .= Alert::alert_info("Foram encontradas ".$objLaudo->getTotalRegistros()." amostras");

   /* echo "<pre>";
    print_r($arr_laudo);
    echo "</pre>";
    die();
   */

    /*
    * PAGINAÇÃO
    */
    $paginacao = '
                    <nav aria-label="Page navigation example">
                      <ul class="pagination">';
    $paginacao .= '<li class="page-item"><input type="button" onclick="paginar(1)" class="page-link" name="btn_paginacao" value="Primeiro"/></li>';
    for($i=0; $i<($objLaudo->getTotalRegistros()/50); $i++){
        $color = '';
        if($objLaudo->getNumPagina() == $i ){
            $color = ' style="background-color: #d2d2d2;" ';
        }
        $paginacao .= '<li '.$color.' class="page-item"><input type="button" onclick="paginar('.($i+1).')" class="page-link" name="btn_paginacao" value="'.($i+1).'"/></li>';
    }
    //$paginacao .= '<li class="page-item"><input type="button" onclick="paginar('.($objAmostra->getTotalRegistros()-1).')" class="page-link" name="btn_paginacao" value="Último"/></li>';
    $paginacao .= '  </ul>
                    </nav>';


    /* FIM PESQUISA */


    foreach ($arr_laudo as $l){

        if($l->getSituacao() == LaudoRN::$SL_PENDENTE){
            $style = ' style="background-color:rgba(255, 255, 0, 0.2);" ';
        }
        if($l->getSituacao() == LaudoRN::$SL_CONCLUIDO){
            $style = ' style="background-color:rgba(0, 255, 0, 0.2);" ';
        }

        $html.='<tr' . $style . '>
                <th scope="row">'.Pagina::formatar_html($l->getIdLaudo()).'</th>';
        /*if(is_array($l->getObjAmostra())) {
            $html .= '<td>' . Pagina::formatar_html($l->getObjAmostra()[0]['nickname']) . '</td>';
        }else{*/
            $html .= '<td>' . Pagina::formatar_html($l->getObjAmostra()->getNickname()) . '</td>';


        $html.='<td>'.Pagina::formatar_html(LaudoRN::mostrarDescricaoStaLaudo($l->getSituacao())).'</td>
                <td>'.Pagina::formatar_html(LaudoRN::mostrarDescricaoResultado($l->getResultado())).'</td>';


        if($l->getDataHoraGeracao() != null) {
            $html.=" <td>". Utils::converterDataHora($l->getDataHoraGeracao()). "</td>";
        }
        ELSE{
            $html.=" <td> - </td>";
        }


        if($l->getDataHoraLiberacao() != null) {
            $html.=" <td>".Utils::converterDataHora($l->getDataHoraLiberacao()) . "</td>";
        }ELSE{
            $html.=" <td> - </td>";
        }



        if(Sessao::getInstance()->verificar_permissao('editar_laudo')){
            $html.= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_laudo&idLaudo='.Pagina::formatar_html($l->getIdLaudo())).'"><i style="color:black;margin: 0px; padding: 0px;" class="fas fa-edit "></i></a>';
        }
        $html .= '</td><td>';
        if(Sessao::getInstance()->verificar_permissao('imprimir_laudo')){
            $html.= '<a  target="_blank"  href="' . Sessao::getInstance()->assinar_link('controlador.php?action=imprimir_laudo&idLaudo='.Pagina::formatar_html($l->getIdLaudo())).'"><i style="color:black;margin: 0px; padding: 0px;" class="fas fa-print"></i></a>';
        }
        $html .= '</td></tr>';

        /*if(Sessao::getInstance()->verificar_permissao('remover_detentor')){
            $html.= ' <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_detentor&idDetentor='.Pagina::formatar_html($r->getIdDetentor())).'">Remover</a>';
        }
        $html .='</td></tr>';*/
    }

} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Laudos");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("pesquisa_pg");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::getInstance()->mostrar_excecoes();
Pagina::montar_topo_listar('LISTAR LAUDOS', null,null,'cadastro_laudo','NOVO LAUDO');
echo $alert;
Pagina::montar_topo_pesquisar($select_pesquisa, $input);
echo' <div class="conteudo_listar">
  <form method="post" style="height:40px;margin-left: 1%;width: 98%;">
             <div class="form-row">
                <div class="col-md-12" >
                    '.$paginacao.'
                 </div>
             </div>
         </form>
        <div class="conteudo_tabela">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Nº LAUDO</th>
                      <th scope="col">AMOSTRA</th>
                      <th scope="col">SITUAÇÃO</th>
                      <th scope="col">RESULTADO</th>
                      <th scope="col">DATA GERAÇÃO</th>
                      <th scope="col">DATA LIBERAÇÃO</th>
                      <th scope="col"></th>
                      <th scope="col"></th>
                    </tr>
                  </thead>
                  <tbody>'
    .$html.
    '</tbody>
                </table>
            </div>
           </div> ';



Pagina::getInstance()->fechar_corpo();


