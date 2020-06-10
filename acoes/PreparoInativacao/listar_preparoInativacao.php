<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();

try {
    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';
    require_once __DIR__.'/../../utils/Alert.php';

    require_once __DIR__ . '/../../classes/Capela/Capela.php';
    require_once __DIR__ . '/../../classes/Capela/CapelaRN.php';
    require_once __DIR__ . '/../../classes/Capela/CapelaINT.php';

    require_once _DIR__ . '/../../classes/Pagina/InterfacePagina.php';
    require_once _DIR__ . '/../../classes/Tipo/Tipo.php';

    require_once __DIR__ . '/../../classes/Amostra/Amostra.php';
    require_once __DIR__ . '/../../classes/Amostra/AmostraRN.php';

    require_once __DIR__ . '/../../classes/Tubo/Tubo.php';
    require_once __DIR__ . '/../../classes/Tubo/TuboRN.php';

    require_once __DIR__ . '/../../classes/InfosTubo/InfosTubo.php';
    require_once __DIR__ . '/../../classes/InfosTubo/InfosTuboRN.php';

    require_once __DIR__ . '/../../utils/Utils.php';
    require_once __DIR__ . '/../../utils/Alert.php';

    require_once __DIR__ . '/../../classes/Lote/Lote.php';
    require_once __DIR__ . '/../../classes/Lote/LoteRN.php';

    require_once __DIR__ . '/../../classes/PreparoLote/PreparoLote.php';
    require_once __DIR__ . '/../../classes/PreparoLote/PreparoLoteRN.php';
    require_once __DIR__ . '/../../classes/PreparoLote/PreparoLoteINT.php';

    require_once __DIR__ . '/../../classes/Rel_perfil_preparoLote/Rel_perfil_preparoLote.php';
    require_once __DIR__ . '/../../classes/Rel_perfil_preparoLote/Rel_perfil_preparoLote_RN.php';

    require_once __DIR__ . '/../../classes/Rel_tubo_lote/Rel_tubo_lote.php';
    require_once __DIR__ . '/../../classes/Rel_tubo_lote/Rel_tubo_lote_RN.php';

    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPaciente.php';
    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPacienteRN.php';


    require_once __DIR__ . '/../../classes/LocalArmazenamento/LocalArmazenamento.php';
    require_once __DIR__ . '/../../classes/LocalArmazenamento/LocalArmazenamentoRN.php';

    require_once __DIR__ . '/../../classes/TipoLocalArmazenamento/TipoLocalArmazenamento.php';
    require_once __DIR__ . '/../../classes/TipoLocalArmazenamento/TipoLocalArmazenamentoRN.php';

    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTexto.php';
    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTextoRN.php';

    require_once __DIR__. '/../../classes/KitExtracao/KitExtracao.php';
    require_once __DIR__. '/../../classes/KitExtracao/KitExtracaoRN.php';
    require_once __DIR__. '/../../classes/KitExtracao/KitExtracaoINT.php';

    require_once __DIR__. '/../../classes/Pesquisa/PesquisaINT.php';

    Sessao::getInstance()->validar();


    /* AMOSTRA
    $objAmostra = new Amostra();
    $objAmostraRN = new AmostraRN();


    /* TUBO
    $objTubo = new Tubo();
    $objTuboRN = new TuboRN();


    /* INFOS TUBO
    $objInfosTubo = new InfosTubo();
    $objInfosTuboRN = new InfosTuboRN();
        */

    /*
     * PREPARO LOTE
     */
    $objPreparoLote = new PreparoLote();
    $objPreparoLoteRN = new PreparoLoteRN();

    /*
     *  LOTE
     */
    $objLote = new Lote();
    $objLoteRN = new LoteRN();

    /*
     *  CAPELA
     */
    $objCapela = new Capela();
    $objCapelaRN = new CapelaRN();

    /*
     *  KIT EXTRAÇÃO
     */
    $objKitExtracao = new KitExtracao();
    $objKitExtracaoRN = new KitExtracaoRN();


    $alert = '';
    $html = '';
    $inputs = '';

    switch ($_GET['action']){
        case 'remover_montagemGrupo_extracao':
            try{
                $objPreparoLote->setIdPreparoLote($_GET['idPreparoLote']);
                $objPreparoLoteRN->remover($objPreparoLote);
            }catch (Throwable $ex){
                Pagina::getInstance()->processar_excecao($ex);
            }
    }


    //$arr_preparos = $objPreparoLoteRN->listar_preparos_lote($objPreparoLote,LoteRN::$TL_EXTRACAO);

    /* PESQUISA */

    $array_colunas = array( 'Nº LOTE','SITUAÇÃO LOTE','CAPELA','KIT EXTRAÇÃO');
    $array_tipos_colunas = array( 'text', 'selectSituacaoLote','text','selectKitExtracao');
    $valorPesquisa = '';
    $select_situacao_lote = '';
    $select_kits_extracao = '';

    PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, null,null,' onchange="this.form.submit()" ');


    if(isset($_POST['sel_pesquisa_coluna']) ){

        PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, $_POST['sel_pesquisa_coluna'],null,' onchange="this.form.submit()" ');
        if($array_tipos_colunas[$_POST['sel_pesquisa_coluna']] == 'selectSituacaoLote'){
            LoteINT::montar_select_situacao_lote($select_situacao_lote, null, null,null);
            $input = $select_situacao_lote;
        }else if($array_tipos_colunas[$_POST['sel_pesquisa_coluna']] == 'selectKitExtracao'){
            KitExtracaoINT::montar_select_kitsExtracao($select_kits_extracao, $objKitExtracao, $objKitExtracaoRN,null, null);
            $input = $select_kits_extracao;
        }else {
            //echo $array_tipos_colunas[$_POST['sel_pesquisa_coluna']];
            $input = '<input type="' . $array_tipos_colunas[$_POST['sel_pesquisa_coluna']] . '" value="' . $_POST['valorPesquisa'] .
                '" placeholder="' . $array_colunas[$_POST['sel_pesquisa_coluna']] . '" name="valorPesquisa" aria-label="Search" class="form-control">';
        }
    }ELSE{
        $input = '<input type="text" disabled value="" id="pesquisaDisabled" placeholder="" name="valorPesquisa" aria-label="Search" class="form-control">';
    }

    if(!isset($_POST['hdnPagina'])){
        $objPreparoLote->setNumPagina(1);
    } else {
        $objPreparoLote->setNumPagina($_POST['hdnPagina']);
    }

    $objLote->setTipo(LoteRN::$TL_EXTRACAO);
    $objPreparoLote->setObjLote($objLote);

    if(isset($_POST['valorPesquisa']) || isset($_POST['sel_situacao_lote']) || isset($_POST['sel_kit_extracao'])){


        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'LOTE ORIGINAL' ){
            $objPreparoLote->setIdPreparoLote(strtoupper($_POST['valorPesquisa']));
        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'Nº LOTE'){
            $objLote->setIdLote($_POST['valorPesquisa']);
            $objPreparoLote->setObjLote($objLote);
        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'SITUAÇÃO LOTE'){
            $objLote->setSituacaoLote($_POST['sel_situacao_lote']);
            LoteINT::montar_select_situacao_lote($select_situacao_lote, $_POST['sel_situacao_lote'], null,null);
            $input = $select_situacao_lote;
            $objPreparoLote->setObjLote($objLote);

        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'CAPELA'){
            $objCapela->setNumero($_POST['valorPesquisa']);
            $objPreparoLote->setObjCapela($objCapela);

        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'KIT EXTRAÇÃO'){
            $objKitExtracao->setIdKitExtracao($_POST['sel_kit_extracao']);
            KitExtracaoINT::montar_select_kitsExtracao($select_kits_extracao, $objKitExtracao, $objKitExtracaoRN,null, null);
            $input = $select_kits_extracao;
            $objPreparoLote->setObjKitExtracao($objKitExtracao);

        }

    }


    $arrPreparos = $objPreparoLoteRN->paginacao($objPreparoLote);
    $alert .= Alert::alert_info("Foram encontradas ".$objPreparoLote->getTotalRegistros()." amostras");

    /*
    * PAGINAÇÃO
    */
    $paginacao = '
                    <nav aria-label="Page navigation example">
                      <ul class="pagination">';
    $paginacao .= '<li class="page-item"><input type="button" onclick="paginar(1)" class="page-link" name="btn_paginacao" value="Primeiro"/></li>';
    for($i=0; $i<($objPreparoLote->getTotalRegistros()/20); $i++){
        $color = '';
        if($objPreparoLote->getNumPagina() == $i ){
            $color = ' style="background-color: #d2d2d2;" ';
        }
        $paginacao .= '<li '.$color.' class="page-item"><input type="button" onclick="paginar('.($i+1).')" class="page-link" name="btn_paginacao" value="'.($i+1).'"/></li>';
    }
    //$paginacao .= '<li class="page-item"><input type="button" onclick="paginar('.($objAmostra->getTotalRegistros()-1).')" class="page-link" name="btn_paginacao" value="Último"/></li>';
    $paginacao .= '  </ul>
                    </nav>';


    /* FIM PESQUISA */

    /*
        echo "<pre>";
        print_r($arrPreparos);
        echo "</pre>";
    */


    foreach ($arrPreparos as $preparo) {

        $objLote = $preparo->getObjLote();
        $strTubos = '';
        $strAmostras = '';
        $contador = 0;
        $contadorAmostra = 0;
        foreach($objLote->getObjRelTuboLote() as $tubo){
            $strTubos .= $tubo->getIdTubo_fk().",";
            /*$contador++;
            if($contador == 3){
                $strTubos .= "\n";
                $contador = 0;
            }*/


            foreach ($tubo->getObjTubo() as $amostra) {
                $strAmostras .=  $amostra->getNickname().','; //."(".TuboRN::mostrarDescricaoTipoTubo($amostra->getObjTubo()->getTipo())."),\n";
                //$contadorAmostra++;
                /*if ($contadorAmostra == 3) {
                    $contadorAmostra = 0;
                    $strAmostras .= "\n";
                }*/

                // $arr_tipos[] = $amostra->getObjTubo()->getTipo();
            }
        }

        $strTubos = substr($strTubos, 0,-1);
        $strAmostras = substr($strAmostras, 0,-1);


        $style_linha = '';
        if($preparo->getObjLote()->getSituacaoLote() == LoteRN::$TE_EM_EXTRACAO){
            $style_linha = ' style="background: rgba(243,108,41,0.2);"' ;
        }



        $html .= '<tr'.$style_linha.'>';
        if($preparo->getObjLoteOriginal() != null) {
            $html .= '    <th scope="row" >' . LoteRN::$TL_PREPARO . Pagina::formatar_html($preparo->getObjLoteOriginal()->getIdLote()) . '</th>';
        }ELSE{
            $html .= '<td> - </td>';
        }

        $html .= '<td>' . LoteRN::$TL_EXTRACAO.Pagina::formatar_html($preparo->getObjLote()->getIdLote()) . '</td>';

        if($preparo->getObjLote()->getSituacaoLote() == LoteRN::$TE_EXTRACAO_FINALIZADA){
            $style = ' style="background: rgba(0,255,0,0.2);"' ;
        }
        if($preparo->getObjLote()->getSituacaoLote() == LoteRN::$TE_AGUARDANDO_EXTRACAO ){
            $style = ' style="background:rgba(255,0,0,0.2);"' ;
        }
        if($preparo->getObjLote()->getSituacaoLote() == LoteRN::$TE_EM_EXTRACAO){
            $style = ' style="background: rgba(243,108,41,0.2);"' ;
        }
        $html .= '<td'.$style.'>' . Pagina::formatar_html(LoteRN::mostrarDescricaoSituacao($preparo->getObjLote()->getSituacaoLote())) . '</td>';


        //$html .= '   <td>' . Pagina::formatar_html(LoteRN::mostrarDescricaoTipoLote($preparo->getObjLote()->getTipo())) . '</td>';

        $html .='    <td style="white-space: pre-wrap;">' . Pagina::formatar_html($strAmostras) . '</td>';

        if (Sessao::getInstance()->verificar_permissao('listar_tubos')) {
            $html .='    <td style="white-space: pre-wrap;">' . Pagina::formatar_html($strTubos) . '</td>';
        }

        $idResp = '';
        if($preparo->getIdResponsavel()){
            $idResp = '('.$preparo->getIdResponsavel().')';
        }
        $html .= '    <td>' . Pagina::formatar_html($preparo->getNomeResponsavel())." ".$idResp . '</td>';


        $html .='   <td>' . Pagina::formatar_html($preparo->getObjUsuario()->getMatricula()) . '</td>';

        if($preparo->getObjKitExtracao() != null) {
            $html .= '   <td>' . Pagina::formatar_html($preparo->getObjKitExtracao()->getNome()) . '</td>';
        }else{
            $html .= '   <td> - </td>';
        }

        if($preparo->getObjCapela() != null) {
            $html .= '   <td>' . Pagina::formatar_html($preparo->getObjCapela()->getNumero()) . '</td>';
        }else{
            $html .= '   <td>  - </td>';
        }

        $dataHoraInicio = explode(" ", $preparo->getDataHoraInicio());
        $data = explode("-", $dataHoraInicio[0]);

        $diaI = $data[2];
        $mesI = $data[1];
        $anoI = $data[0];

        $html .= '   <td>' . $diaI . '/' . $mesI . '/' . $anoI . ' - ' . $dataHoraInicio[1] . '</td>';

        if($preparo->getObjLote()->getSituacaoLote() == LoteRN::$TE_EXTRACAO_FINALIZADA) {
            $dataHoraFim = explode(" ", $preparo->getDataHoraFim());
            $data = explode("-", $dataHoraFim[0]);

            $diaF = $data[2];
            $mesF = $data[1];
            $anoF = $data[0];

            $html .= '   <td>' . $diaF . '/' . $mesF . '/' . $anoF . ' - ' . $dataHoraFim[1] . '</td>';
        }else{
            $html .= '  <td> - </td>';
        }


        if($preparo->getObjLote()->getSituacaoLote() == LoteRN::$TE_EM_EXTRACAO){
            if (Sessao::getInstance()->verificar_permissao('realizar_extracao')) {
                //ECHO ' controlador.php?action=realizar_extracao&idPreparoLote=' . Pagina::formatar_html($preparo->getIdPreparoLote()).'&idCapela='.Pagina::formatar_html($preparo->getIdCapelaFk()).'&idKitExtracao='.Pagina::formatar_html($preparo->getIdKitExtracaoFk());
                $html .= '<td ><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=realizar_extracao&idPreparoLote=' . Pagina::formatar_html($preparo->getIdPreparoLote()) . '&idCapela=' . Pagina::formatar_html($preparo->getIdCapelaFk()) . '&idKitExtracao=' . Pagina::formatar_html($preparo->getIdKitExtracaoFk()) . '&idSituacao=1') . '"><i class="fas fa-exclamation-triangle" style="color: #f36c29;"></i></td>';
            }else{
                $html .= '<td ></td>';
            }
        }else{
            $html .= '<td ></td>';
        }

        //if($preparo->getExtracaoInvalida() == null) {
            if (Sessao::getInstance()->verificar_permissao('editar_extracao') && $preparo->getObjLote()->getSituacaoLote() == LoteRN::$TE_EXTRACAO_FINALIZADA) {
                $html .= '<td ><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_extracao&idPreparoLote=' . Pagina::formatar_html($preparo->getIdPreparoLote()) . '&idCapela=' . Pagina::formatar_html($preparo->getIdCapelaFk()) . '&idKitExtracao=' . Pagina::formatar_html($preparo->getIdKitExtracaoFk()) . '&idSituacao=1') . '"><i class="fas fa-edit" style="color: black;"></i></td>';
            } else {
                $html .= '<td ></td>';
            }
        //}else{
        //    $html .= '<td ></td>';
        //}


        if (Sessao::getInstance()->verificar_permissao('imprimir_preparo_lote')) {
            $html .= '<td><a target="_blank" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=imprimir_preparo_lote&idPreparoLote=' . Pagina::formatar_html($preparo->getIdPreparoLote())) . '"><i style="color:black;margin: 0px; padding: 0px;" class="fas fa-print"></i></a></td>';
        }

        if (Sessao::getInstance()->verificar_permissao('remover_montagemGrupo_extracao')) {
            $html .= '<td ><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_montagemGrupo_extracao&idPreparoLote=' . Pagina::formatar_html($preparo->getIdPreparoLote())) . '"><i class="fas fa-trash-alt"></i></a></td>';
        }
        $html .= '</tr>';
    }




} catch (Throwable $ex) {
    //die($ex);
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Listar Grupos Extração");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("pesquisa_pg");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('LISTAR GRUPOS DE EXTRAÇÃO', null, null, null, null);
Pagina::getInstance()->mostrar_excecoes();
echo $alert;
Pagina::montar_topo_pesquisar($select_pesquisa, $input);

echo '
        
        <form method="post" style="height:40px;margin-left: 1%;width: 98%;">
             <div class="form-row">
                <div class="col-md-12" >
                    '.$paginacao.'
                 </div>
             </div>
         </form>
         
         <div id="tabela_preparos"  style="margin-top: -50px;">
        <div class="conteudo_tabela " >
            <table class="table table-hover " >
                <thead>
                    <tr>
                       <th scope="col">LOTE ORIGINAL</th>
                        <!--<th scope="col">Nº PREPARO</th>-->
                        <th  scope="col">Nº LOTE</th>
                        <th  scope="col">SITUAÇÃO LOTE</th>
                      
                        <th  scope="col">AMOSTRAS</th>';
                        if (Sessao::getInstance()->verificar_permissao('listar_tubos')) {
                            echo '<th scope="col">TUBOS</th>';
                        }
                        echo '
                        <th scope="col">RESPONSÁVEL</th>
                        <th scope="col">USUÁRIO</th>
                        <th scope="col">KIT EXTRAÇÃO</th>
                        <th scope="col">CAPELA</th>
                        <th  scope="col">DATA HORA INÍCIO</th>
                        <th  scope="col">DATA HORA TÉRMINO</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>'
    . $html .
    '</tbody>
            </table>
        </div>
        </div>
   ';


Pagina::getInstance()->fechar_corpo();
