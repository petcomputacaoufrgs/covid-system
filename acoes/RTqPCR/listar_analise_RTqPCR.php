<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();

try {
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';

    require_once __DIR__ . '/../../classes/Equipamento/EquipamentoINT.php';
    require_once __DIR__ . '/../../classes/Equipamento/EquipamentoRN.php';
    require_once __DIR__ . '/../../classes/Equipamento/Equipamento.php';

    require_once  __DIR__.'/../../utils/Utils.php';

    require_once __DIR__ . '/../../classes/Placa/Placa.php';
    require_once __DIR__ . '/../../classes/Placa/PlacaRN.php';
    require_once __DIR__ . '/../../classes/Placa/PlacaINT.php';

    require_once __DIR__ . '/../../classes/Poco/Poco.php';
    require_once __DIR__ . '/../../classes/Poco/PocoRN.php';

    require_once __DIR__ . '/../../classes/RelPocoPlaca/PocoPlaca.php';
    require_once __DIR__ . '/../../classes/RelPocoPlaca/PocoPlacaRN.php';

    require_once __DIR__ . '/../../classes/DivisaoProtocolo/DivisaoProtocolo.php';
    require_once __DIR__ . '/../../classes/DivisaoProtocolo/DivisaoProtocoloRN.php';

    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTexto.php';
    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTextoRN.php';

    require_once __DIR__ . '/../../classes/RelPerfilPlaca/RelPerfilPlaca.php';
    require_once __DIR__ . '/../../classes/RelPerfilPlaca/RelPerfilPlacaRN.php';

    require_once __DIR__ . '/../../classes/InfosTubo/InfosTubo.php';
    require_once __DIR__ . '/../../classes/InfosTubo/InfosTuboRN.php';

    require_once __DIR__ . '/../../classes/RTqPCR/RTqPCR.php';
    require_once __DIR__ . '/../../classes/RTqPCR/RTqPCR_RN.php';
    require_once __DIR__ . '/../../classes/RTqPCR/RTqPCR_INT.php';

    require_once __DIR__.'/../../classes/Pesquisa/PesquisaINT.php';

    Sessao::getInstance()->validar();
    $utils = new Utils();

    date_default_timezone_set('America/Sao_Paulo');


    /*
    * RTqPCR
    */
    $objRTqPCR= new RTqPCR();
    $objRTqPCR_RN = new RTqPCR_RN();

    /*
    * PLACA
    */
    $objPlaca= new Placa();
    $objPlacaRN = new PlacaRN();

    /*
     * INFOS TUBO
     */
    $objInfosTubo = new InfosTubo();
    $objInfosTuboRN = new InfosTuboRN();

    /*
     * EQUIPAMENTO
     */
    $objEquipamento = new Equipamento();
    $objEquipamentoRN = new EquipamentoRN();


    $alert = '';
    switch ($_GET['action']){
        case 'remover_analise_RTqPCR':
            try{
               /* $objMontagemPlaca->setIdMontagem($_GET['idMontagem']);
                $objMontagemPlaca = $objMontagemPlacaRN->consultar($objMontagemPlaca);
                if($objMontagemPlaca->getSituacaoMontagem() != MontagemPlacaRN::$STA_MONTAGEM_FINALIZADA) {
                    $objMontagemPlacaRN->remover($objMontagemPlaca);
                }else{
                    $alert .= Alert::alert_warning("A montagem já foi finalizada, logo não pode ser excluída");
                }*/
            }catch (Throwable $ex){
                Pagina::getInstance()->processar_excecao($ex);
            }
    }

    /************************* FIM REMOÇÃO *************************/

    $array_colunas = array('ID RTqPCR','SITUAÇÃO RTqPCR','ID PLACA','NOME PLACA','ID EQUIPAMENTO','NOME EQUIPAMENTO');
    $array_tipos_colunas = array('text','select_situacoes_rtqpcr', 'text','text','text','text');
    $valorPesquisa = '';
    $select_pesquisa = '';
    PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, null,null,' onchange="this.form.submit()" ');

    $select_situacoes_RTqPCR = '';

    if(isset($_POST['sel_pesquisa_coluna']) ){

        PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, $_POST['sel_pesquisa_coluna'],null,' onchange="this.form.submit()" ');
        if($array_tipos_colunas[$_POST['sel_pesquisa_coluna']] == 'select_situacoes_rtqpcr'){
            RTqPCR_INT::montar_select_situacao_RTqPCR($select_situacoes_RTqPCR,$objRTqPCR,null,null);
            $input = $select_situacoes_RTqPCR;
        } else {
            //echo $array_tipos_colunas[$_POST['sel_pesquisa_coluna']];
            $input = '<input type="' . $array_tipos_colunas[$_POST['sel_pesquisa_coluna']] . '" value="' . $_POST['valorPesquisa'] .
                '" placeholder="' . $array_colunas[$_POST['sel_pesquisa_coluna']] . '" name="valorPesquisa" aria-label="Search" class="form-control">';
        }
    }ELSE{
        $input = '<input type="text" disabled value="" id="pesquisaDisabled" placeholder="" name="valorPesquisa" aria-label="Search" class="form-control">';
    }

    if(!isset($_POST['hdnPagina'])){
        $objRTqPCR->setNumPagina(1);
    } else {
        $objRTqPCR->setNumPagina($_POST['hdnPagina']);
    }


    if(isset($_POST['valorPesquisa']) || isset($_POST['sel_situacao_rtqpcr'])){

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'ID RTqPCR'){
            $objRTqPCR->setIdRTqPCR($_POST['valorPesquisa']);
        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'SITUAÇÃO RTqPCR'){
            $objRTqPCR->setSituacaoRTqPCR($_POST['sel_situacao_rtqpcr']);
            RTqPCR_INT::montar_select_situacao_RTqPCR($select_situacoes_RTqPCR,$objRTqPCR,null,null);
            $input = $select_situacoes_RTqPCR;
        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'ID PLACA'){
            $objPlaca->setIdPlaca($_POST['valorPesquisa']);
            $objRTqPCR->setObjPlaca($objPlaca);
        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'NOME PLACA'){
            $objPlaca->setIndexPlaca(strtoupper($utils->tirarAcentos($_POST['valorPesquisa'])));
            $objRTqPCR->setObjPlaca($objPlaca);
        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'ID EQUIPAMENTO'){
            $objEquipamento->setIdEquipamento($_POST['valorPesquisa']);
            $objRTqPCR->setObjEquipamento($objEquipamento);
        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'NOME EQUIPAMENTO'){
            $objEquipamento->setNomeEquipamento($_POST['valorPesquisa']);
            $objRTqPCR->setObjEquipamento($objEquipamento);
        }

    }

    $arrRTqPCR = $objRTqPCR_RN->paginacao($objRTqPCR);

    /*
        echo "<pre>";
        print_r($arrRTqPCR);
        echo "</pre>";
    */
    $alert .= Alert::alert_info("Foram encontradas ".$objRTqPCR->getTotalRegistros()." RTqPCRs");


    /************************* PAGINAÇÃO *************************/
    $paginacao = '
                    <nav aria-label="Page navigation example">
                      <ul class="pagination">';
    $paginacao .= '<li class="page-item"><input type="button" onclick="paginar(1)" class="page-link" name="btn_paginacao" value="Primeiro"/></li>';
    for($i=0; $i<($objRTqPCR->getTotalRegistros()/20); $i++){
        $color = '';
        if($objRTqPCR->getNumPagina() == $i ){
            $color = ' style="background-color: #d2d2d2;" ';
        }
        $paginacao .= '<li '.$color.' class="page-item"><input type="button" onclick="paginar('.($i+1).')" class="page-link" name="btn_paginacao" value="'.($i+1).'"/></li>';
    }
    $paginacao .= '  </ul>
                    </nav>';
    /************************* FIM PAGINAÇÃO *************************/

    /*
        echo "<pre>";
        print_r($arrMontagem);
        echo "</pre>";
     */


    foreach ($arrRTqPCR as $RTqPCR) {
        $objUsuario = $RTqPCR->getObjUsuario();
        $objEquipamento = $RTqPCR->getObjEquipamento();
        $objPlaca = $RTqPCR->getObjPlaca();


        $strTubos = '';
        $strAmostras = '';
        $contador = 0;
        foreach($objPlaca->getObjsTubos() as $tubo){
            //print_r($tubo);
            $strTubos .= $tubo->getIdTuboFk().",";
            $contador++;
            if($contador == 5){
                $strTubos .= "\n";
                $contador = 0;
            }

            foreach ($tubo->getObjTubo() as $amostra) {
                $strAmostras .= $amostra->getNickname() . ",";
                $contadorAmostra++;
                if ($contadorAmostra == 5) {
                    $contadorAmostra = 0;
                    $strAmostras .= "\n";
                }
            }
        }

        $strTubos = substr($strTubos, 0, -1);
        $strAmostras = substr($strAmostras, 0, -1);

        $data = Utils::getData($RTqPCR->getDataHoraInicio()).' '.$RTqPCR->getHoraFinal();
        $segundos = Utils::compararDataHora(date("Y-m-d H:i:s"),$data);
        $segundosEq = $objEquipamento->getHoras()*60*60;
        $segundosEq += $objEquipamento->getMinutos()*60;
        //echo "segundos que faltam: ".$segundos."s de ".$segundosEq."s\n";

        if($segundos <= ($segundosEq/2)){
            $icon = '<button type="button" class="btn btn-secondary" style="border: none;" data-toggle="tooltip" data-placement="top" title="Já passou da metade">
                     <i class="fas fa-hourglass-end" style="color: #f36c29;"></i>
                    </button>
                    ';
        }else if($segundos > ($segundosEq/2)){
            $icon = '<i class="far fa-hourglass" style="color: green;"></i>';
        }else if($segundos < 0){
            $icon = '<i class="fas fa-hourglass" style="color: red;"></i>';
        }

        $style_linha = '';
        if ($RTqPCR->getSituacaoRTqPCR() == RTqPCR_RN::$STA_EM_ANDAMENTO) {
            $style_linha = ' style="background: rgba(243,108,41,0.2);"';
            $style_td  = $style_linha;
        }

        if ($RTqPCR->getSituacaoRTqPCR() == RTqPCR_RN::$STA_FINALIZADO) {
            $style_td = ' style="background: rgba(0,255,0,0.2);"';
        }

        if ($RTqPCR->getSituacaoRTqPCR() == RTqPCR_RN::$STA_ATRASADO) {
            $style_linha =  ' style="background: rgba(255,0,0,0.2);"';
            $style_td = $style_linha;
        }


        $html .= '<tr ' . $style_linha . '>           
            <th scope="row" >' . Pagina::formatar_html($RTqPCR->getIdRTqPCR()) . '</th>';
        $html .= '    <th scope="row" '.$style_td.'>' . Pagina::formatar_html(RTqPCR_RN::mostrarDescricaoRTqPCR($RTqPCR->getSituacaoRTqPCR())) . '</th>';

        $html .= '<td>' . Pagina::formatar_html($objPlaca->getIdPlaca()) . '</td>';
        $html .= '<td>' . Pagina::formatar_html($objPlaca->getPlaca()) . '</td>';
        $html .= '<td>' . Pagina::formatar_html(PlacaRN::mostrar_descricao_staPlaca($objPlaca->getSituacaoPlaca())) . '</td>';

        $html .= '<td>' . Pagina::formatar_html($objEquipamento->getIdEquipamento()) . '</td>';
        $html .= '<td>' . Pagina::formatar_html($objEquipamento->getNomeEquipamento()) . '</td>';

        if (Sessao::getInstance()->verificar_permissao('listar_tubos')) {
            $html .= '    <td style="white-space: pre-wrap;">' . Pagina::formatar_html($strTubos) . '</td>';
        }
        $html .= '    <td style="white-space: pre-wrap;">' . Pagina::formatar_html($strAmostras) . '</td>';

        $html .= '    <td>' . Pagina::formatar_html($objUsuario->getMatricula()) . '</td>';


        $html .= '   <td>'.$RTqPCR->getHoraFinal().' - '.Utils::getStrData($RTqPCR->getDataHoraInicio()).'</td>';

        $html .= '   <td>'.Utils::converterDataHora($RTqPCR->getDataHoraInicio()).'</td>';

        if ($RTqPCR->getSituacaoRTqPCR() == RTqPCR_RN::$STA_FINALIZADO) {
            $html .= '   <td>'.Utils::converterDataHora($RTqPCR->getDataHoraFim()).'</td>';
        }else{
            $html .= '   <td> - </td>';
        }



        //echo 'controlador.php?action=mix_placa_RTqPCR&idSolicitacao=' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca()) . '&idPlaca=' . Pagina::formatar_html($solicitacao->getObjPlaca()->getIdPlaca()) . '&idMix=' . Pagina::formatar_html($mix->getIdMixPlaca())."\n";
        if ($RTqPCR->getSituacaoRTqPCR() == RTqPCR_RN::$STA_EM_ANDAMENTO) {
            $html .= '<td ><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=analisar_RTqPCR&idRTqPCR=' . Pagina::formatar_html($RTqPCR->getIdRTqPCR()) . '&idPlaca=' . Pagina::formatar_html($objPlaca->getIdPlaca()). '&idEquipamento=' . Pagina::formatar_html($objEquipamento->getIdEquipamento())) .'">'.$icon.'</td>';
        }else if ($RTqPCR->getSituacaoRTqPCR() == RTqPCR_RN::$STA_ATRASADO) {
            $html .= '<td ><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=analisar_RTqPCR&idRTqPCR=' . Pagina::formatar_html($RTqPCR->getIdRTqPCR()) . '&idPlaca=' . Pagina::formatar_html($objPlaca->getIdPlaca()). '&idEquipamento=' . Pagina::formatar_html($objEquipamento->getIdEquipamento())) .'"><i class="fas fa-hourglass" style="color: red;"></i></td>';
        }else{
            $html .= '<td ></td>';
        }



        /*if (Sessao::getInstance()->verificar_permissao('remover_montagem_placa_RTqPCR')) {
            if($solicitacao->getSituacaoSolicitacao() != SolicitacaoMontarPlacaRN::$TS_FINALIZADA ) {
                $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_montagem_placa_RTqPCR&idMontagem=' . Pagina::formatar_html($montagem->getIdMontagem())) . '"><i class="fas fa-trash-alt"></i></a></td>';
            }else{
                $html .= '<td ></td>';
            }
        }else{
            $html .= '<td ></td>';
        }*/


        $html .= '</tr>';
        $a++;
    }


} catch (Throwable $ex) {
    //die($ex);
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Listar Montagens das Placas RTqPCR");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("pesquisa_pg");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('LISTAR RTqPCR', null, null, 'analisar_RTqPCR', 'RTqPCR');
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
         
         <div id="tabela_preparos" style="margin-top: -50px;">
        <div class="conteudo_tabela " >
        <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-bottom: 5px;">
                    Legenda dos ícones
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" style="color: grey;"><i class="far fa-hourglass" style="color: green;"></i>  Falta mais da metade do tempo para o equipamento RTqPCR ser liberado</a>
                    <a class="dropdown-item" href="#" style="color: grey;"><i class="fas fa-hourglass-end" style="color: #f36c29;"></i>    Falta menos da metade do tempo para o equipamento RTqPCR ser liberado</a>
                    <a class="dropdown-item" href="#" style="color: grey;"><i class="fas fa-hourglass" style="color: red;"></i>  O equipamneto de RTqPCR já deveria ter sido liberado</a>
                    <a class="dropdown-item" href="#" style="color: grey;"><i style="color:black;margin: 0px; padding: 0px;" class="fas fa-print"></i>  Impressão da placa de poços</a>
                    
                  </div>
            </div>
            <table class="table table-hover"  >
                <thead>
                    <tr>
                        <th  scope="col">ID RTqPCR</th>
                        <th  scope="col">SITUAÇÃO RTqPCR </th>
                        <th  scope="col">ID PLACA</th>
                        <th  scope="col">NOME PLACA</th>
                        <th  scope="col">SITUAÇÃO PLACA</th>
                        <th  scope="col">ID EQUIPAMENTO</th>
                        <th  scope="col">NOME EQUIPAMENTO</th>';


if (Sessao::getInstance()->verificar_permissao('listar_tubos')) {
    echo '<th  scope="col">TUBOS</th>';
}
echo '<th  scope="col">AMOSTRAS</th>
                        <th scope="col">ID USUÁRIO</th>
                        <th scope="col">PREVISÃO DE TÉRMINO</th>
                        <th  scope="col">DATA HORA INÍCIO</th>
                        <th  scope="col">DATA HORA TÉRMINO</th>';
if ($objRTqPCR->getSituacaoRTqPCR() == RTqPCR_RN::$STA_EM_ANDAMENTO) { echo '<th scope="col"></th>';}
//if (Sessao::getInstance()->verificar_permissao('imprimir_montagem_placa_RTqPCR')) {echo '<th scope="col"></th>';}
//if (Sessao::getInstance()->verificar_permissao('remover_montagem_placa_RTqPCR')) {echo '<th scope="col"></th>';}
echo ' <!--<th scope="col"></th>-->
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
