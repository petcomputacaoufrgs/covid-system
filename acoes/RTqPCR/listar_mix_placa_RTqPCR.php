<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();

try {
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once __DIR__ . '/../../utils/Alert.php';
    require_once __DIR__ . '/../../utils/Utils.php';

    require_once __DIR__ . '/../../classes/Placa/Placa.php';
    require_once __DIR__ . '/../../classes/Placa/PlacaRN.php';

    require_once __DIR__ . '/../../classes/Amostra/Amostra.php';
    require_once __DIR__ . '/../../classes/Amostra/AmostraRN.php';

    require_once __DIR__ . '/../../classes/Tubo/Tubo.php';
    require_once __DIR__ . '/../../classes/Tubo/TuboRN.php';

    require_once __DIR__ . '/../../classes/InfosTubo/InfosTubo.php';
    require_once __DIR__ . '/../../classes/InfosTubo/InfosTuboRN.php';

    require_once __DIR__ . '/../../classes/Protocolo/Protocolo.php';
    require_once __DIR__ . '/../../classes/Protocolo/ProtocoloRN.php';

    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPaciente.php';
    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPacienteRN.php';

    require_once __DIR__ . '/../../classes/RelTuboPlaca/RelTuboPlaca.php';
    require_once __DIR__ . '/../../classes/RelTuboPlaca/RelTuboPlacaRN.php';

    require_once __DIR__ . '/../../classes/RelPerfilPlaca/RelPerfilPlaca.php';
    require_once __DIR__ . '/../../classes/RelPerfilPlaca/RelPerfilPlacaRN.php';

    require_once __DIR__ . '/../../classes/SolicitacaoMontarPlaca/SolicitacaoMontarPlaca.php';
    require_once __DIR__ . '/../../classes/SolicitacaoMontarPlaca/SolicitacaoMontarPlacaRN.php';

    require_once __DIR__.'/../../classes/MixRTqPCR/MixRTqPCR.php';
    require_once __DIR__.'/../../classes/MixRTqPCR/MixRTqPCR_RN.php';
    require_once __DIR__.'/../../classes/MixRTqPCR/MixRTqPCR_INT.php';

    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTexto.php';
    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTextoRN.php';

    require_once __DIR__.'/../../classes/Pesquisa/PesquisaINT.php';

    Sessao::getInstance()->validar();
    $utils = new Utils();

    date_default_timezone_set('America/Sao_Paulo');

    $objAmostra = new Amostra();
    $objAmostraRN = new AmostraRN();

    $objPlaca = new Placa();
    $objPlacaRN = new PlacaRN();

    $objTubo = new Tubo();
    $objTuboRN = new TuboRN();

    $objInfosTubo = new InfosTubo();
    $objInfosTuboRN = new InfosTuboRN();

    $objProtocolo = new Protocolo();
    $objProtocoloRN = new ProtocoloRN();

    $objPerfilPaciente = new PerfilPaciente();
    $objPerfilPacienteRN = new PerfilPacienteRN();

    $objRelTuboPlaca = new RelTuboPlaca();
    $objRelTuboPlacaRN = new RelTuboPlacaRN();

    $objRelPerfilPlaca = new RelPerfilPlaca();
    $objRelPerfilPlacaRN = new RelPerfilPlacaRN();

    $objSolMontarPlaca = new SolicitacaoMontarPlaca();
    $objSolMontarPlacaRN = new SolicitacaoMontarPlacaRN();

    $solicitacao = new SolicitacaoMontarPlaca();

    $objSolMontarPlaca = new SolicitacaoMontarPlaca();
    $objSolMontarPlacaRN = new SolicitacaoMontarPlacaRN();

    $objMix = new MixRTqPCR();
    $objMixRN = new MixRTqPCR_RN();

    $html = '';
    $alert = '';


    /*switch ($_GET['action']){
        case 'remover_solicitacao_montagem_placa_RTqPCR':
            try{
                $objSolMontarPlaca->setIdSolicitacaoMontarPlaca($_GET['idSolicitacao']);
                $objSolMontarPlaca = $objSolMontarPlacaRN->consultar($objSolMontarPlaca);
                if($objSolMontarPlaca->getSituacaoSolicitacao() != SolicitacaoMontarPlacaRN::$TS_FINALIZADA ||
                    (isset($_GET['idSituacao']) && $_GET['idSituacao'] == 1)) {
                    $objSolMontarPlacaRN->remover_completamente($objSolMontarPlaca);
                }else{
                    $alert .= Alert::alert_warning("A solicitação já foi finalizada, logo não pode ser excluída");
                }
            }catch (Throwable $ex){
                Pagina::getInstance()->processar_excecao($ex);
            }
    }*/

    /************************* FIM REMOÇÃO *************************/

    $array_colunas = array('ID MIX', 'SITUAÇÃO DO MIX','ID PLACA');
    $array_tipos_colunas = array('text','selectSituacaoMix', 'text');//,'text');
    $valorPesquisa = '';
    $select_pesquisa = '';
    PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, null,null,' onchange="this.form.submit()" ');

    if (isset($_POST['bt_resetar'])) {
        $select_pesquisa = '';
        PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, null,null,' onchange="this.form.submit()" ');
    }

    $select_situacoes_mix = '';

    if(isset($_POST['sel_pesquisa_coluna']) ){

        PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, $_POST['sel_pesquisa_coluna'],null,' onchange="this.form.submit()" ');
        if($array_tipos_colunas[$_POST['sel_pesquisa_coluna']] == 'selectSituacaoMix'){
            MixRTqPCR_INT::montar_select_situacao_mix($select_situacoes_mix,$objMix,null,null);
            $input = $select_situacoes_mix;
        } else {
            //echo $array_tipos_colunas[$_POST['sel_pesquisa_coluna']];
            $input = '<input type="' . $array_tipos_colunas[$_POST['sel_pesquisa_coluna']] . '" value="' . $_POST['valorPesquisa'] .
                '" placeholder="' . $array_colunas[$_POST['sel_pesquisa_coluna']] . '" name="valorPesquisa" aria-label="Search" class="form-control">';
        }
    }ELSE{
        $input = '<input type="text" disabled value="" id="pesquisaDisabled" placeholder="" name="valorPesquisa" aria-label="Search" class="form-control">';
    }

    if(!isset($_POST['hdnPagina'])){
        $objMix->setNumPagina(1);
    } else {
        $objMix->setNumPagina($_POST['hdnPagina']);
    }


    if(isset($_POST['valorPesquisa']) || isset($_POST['sel_situacao_mix'])){

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'ID MIX'){
            $objMix->setIdMixPlaca($_POST['valorPesquisa']);
        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'ID PLACA'){
            $objPlaca->setIdPlaca($_POST['valorPesquisa']);
            $objSolMontarPlaca->setObjPlaca($objPlaca);
            $objMix->setObjSolicitacao($objSolMontarPlaca);
        }


        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'SITUAÇÃO DO MIX'){
            $objMix->setSituacaoMix($_POST['sel_situacao_mix']);
            MixRTqPCR_INT::montar_select_situacao_mix($select_situacoes_mix,$objMix,null,null);
            $input = $select_situacoes_mix;
        }


    }

    $arr_mix = $objMixRN->paginacao($objMix);
    $alert .= Alert::alert_info("Foram encontradas ".$objMix->getTotalRegistros()." mix de placa");


    /************************* PAGINAÇÃO *************************/
    $paginacao = '
                    <nav aria-label="Page navigation example">
                      <ul class="pagination">';
    $paginacao .= '<li class="page-item"><input type="button" onclick="paginar(1)" class="page-link" name="btn_paginacao" value="Primeiro"/></li>';
    for($i=0; $i<($objSolMontarPlaca->getTotalRegistros()/20); $i++){
        $color = '';
        if($objSolMontarPlaca->getNumPagina() == $i ){
            $color = ' style="background-color: #d2d2d2;" ';
        }
        $paginacao .= '<li '.$color.' class="page-item"><input type="button" onclick="paginar('.($i+1).')" class="page-link" name="btn_paginacao" value="'.($i+1).'"/></li>';
    }
    //$paginacao .= '<li class="page-item"><input type="button" onclick="paginar('.($objAmostra->getTotalRegistros()-1).')" class="page-link" name="btn_paginacao" value="Último"/></li>';
    $paginacao .= '  </ul>
                    </nav>';


    /************************* FIM PAGINAÇÃO *************************/

    /*
        echo "<pre>";
        print_r($arr_mix);
        echo "</pre>";
    */


    foreach ($arr_mix as $mix) {
        $solicitacao = $mix->getObjSolicitacao();
        $objPlaca = $mix->getObjSolicitacao()->getObjPlaca();
        /*
        echo "<pre>";
        print_r($objPlaca);
        echo "</pre>";
       */
        $strTubos = '';
        $strAmostras = '';
        $contador = 0;
        $arr_amostras = array();

        foreach($objPlaca->getObjRelTuboPlaca() as $tubo){
            //print_r($tubo);
            $strTubos .= $tubo->getIdTuboFk().",";
            $contador++;
            if($contador == 5){
                $strTubos .= "\n";
                $contador = 0;
            }


            foreach ($tubo->getObjTubo() as $amostra) {
                if (!in_array($amostra->getNickname(), $arr_amostras)) {
                    $arr_amostras[] = $amostra->getNickname();
                    $strAmostras .= $amostra->getNickname() .","; // ."(". TuboRN::mostrarDescricaoTipoTubo($tubo->getObjTubo()[0]->getObjTubo()->getTipo())."),";
                    $contadorAmostra++;
                    if ($contadorAmostra == 5) {
                        $contadorAmostra = 0;
                        $strAmostras .= "\n";
                    }
                }
            }
        }

        $strTubos = substr($strTubos, 0, -1);
        $strAmostras = substr($strAmostras, 0, -1);

        $style_linha = '';
        if ($mix->getSituacaoMix() == MixRTqPCR_RN::$STA_EM_ANDAMENTO || $mix->getSituacaoMix() == MixRTqPCR_RN::$STA_AGUARDANDO_TABELAS_PROTOCOLOS) {
            $style_linha = ' style="background: rgba(243,108,41,0.2);"';
        }


        $html .= '<tr' . $style_linha . '>           
            <th scope="row" >' . Pagina::formatar_html($mix->getIdMixPlaca()) . '</th>';

        $html .= '<td>' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca()) . '</td>';


        $html .= '<td '.$style_linha.'>' . Pagina::formatar_html(MixRTqPCR_RN::mostrar_descricao_staMix($mix->getSituacaoMix())) . '</td>';

        $html .= '<td>' . Pagina::formatar_html($objPlaca->getIdPlaca()) . '</td>';


        if (Sessao::getInstance()->verificar_permissao('listar_tubos')) {
            $html .= '    <td style="white-space: pre-wrap;">' . Pagina::formatar_html($strTubos) . '</td>';
        }
        $html .= '    <td style="white-space: pre-wrap;">' . Pagina::formatar_html($strAmostras) . '</td>';

        $html .= '    <td>' . Pagina::formatar_html($mix->getObjUsuario()->getMatricula()) . '</td>';

        $dataHoraInicio = explode(" ", $mix->getDataHoraInicio());
        $data = explode("-", $dataHoraInicio[0]);

        $diaI = $data[2];
        $mesI = $data[1];
        $anoI = $data[0];

        $html .= '   <td>' . $diaI . '/' . $mesI . '/' . $anoI . ' - ' . $dataHoraInicio[1] . '</td>';


        $dataHoraFim = explode(" ", $mix->getDataHoraFim());
        $data = explode("-", $dataHoraFim[0]);

        $diaF = $data[2];
        $mesF = $data[1];
        $anoF = $data[0];

        $html .= '   <td>' . $diaF . '/' . $mesF . '/' . $anoF . ' - ' . $dataHoraFim[1] . '</td>';

        //echo 'controlador.php?action=mix_placa_RTqPCR&idSolicitacao=' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca()) . '&idPlaca=' . Pagina::formatar_html($objPlaca->getIdPlaca()) . '&idMix=' . Pagina::formatar_html($mix->getIdMixPlaca().'&idTabela=1');

        //echo 'controlador.php?action=mix_placa_RTqPCR&idSolicitacao=' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca()) . '&idPlaca=' . Pagina::formatar_html($solicitacao->getObjPlaca()->getIdPlaca()) . '&idMix=' . Pagina::formatar_html($mix->getIdMixPlaca())."\n";
        if ($mix->getSituacaoMix() == MixRTqPCR_RN::$STA_EM_ANDAMENTO || $mix->getSituacaoMix() == MixRTqPCR_RN::$STA_AGUARDANDO_TABELAS_PROTOCOLOS) {
            if($mix->getSituacaoMix() == MixRTqPCR_RN::$STA_AGUARDANDO_TABELAS_PROTOCOLOS){
                $html .= '<td ><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=mix_placa_RTqPCR&idSolicitacao=' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca()) . '&idPlaca=' . Pagina::formatar_html($objPlaca->getIdPlaca()) . '&idMix=' . Pagina::formatar_html($mix->getIdMixPlaca()).'&idTabela=1') .'"><i class="fas fa-exclamation-triangle" style="color: #f36c29;"></i></td>';
            }else if($mix->getSituacaoMix() == MixRTqPCR_RN::$STA_EM_ANDAMENTO ) {
                $html .= '<td ><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=mix_placa_RTqPCR&idSolicitacao=' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca()) . '&idPlaca=' . Pagina::formatar_html($objPlaca->getIdPlaca()) . '&idMix=' . Pagina::formatar_html($mix->getIdMixPlaca())) . '"><i class="fas fa-exclamation-triangle" style="color: #f36c29;"></i></td>';
            }
        }else{
            $html .= '<td ></td>';
        }


        if (Sessao::getInstance()->verificar_permissao('mostrar_poco')) {
            if ($mix->getSituacaoMix() == MixRTqPCR_RN::$STA_EM_ANDAMENTO || $mix->getSituacaoMix() == MixRTqPCR_RN::$STA_AGUARDANDO_TABELAS_PROTOCOLOS ){
                $color = ' style="color:red;" ';
            }else if($mix->getSituacaoMix() == MixRTqPCR_RN::$STA_TRANSPORTE_MONTAGEM){
                $color = ' style="color:green;" ';
            }else{
                $color = ' style="color:black;" ';
            }
            $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=mostrar_poco&idSolicitacao=' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca()) . '&idPlaca=' . Pagina::formatar_html($objPlaca->getIdPlaca())) . '"><i class="fas fa-eye" '.$color.'></i></a></td>';
        }else{
            $html .= '<td ></td>';
        }

        if (Sessao::getInstance()->verificar_permissao('editar_tabelas_protocolos') && $solicitacao->getSituacaoSolicitacao() == SolicitacaoMontarPlacaRN::$TS_FINALIZADA) {
            $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_tabelas_protocolos&idSolicitacao=' . Pagina::formatar_html($mix->getObjSolicitacao()->getIdSolicitacaoMontarPlaca()).'&idMix=' . Pagina::formatar_html($mix->getIdMixPlaca()) . '&idPlaca=' . Pagina::formatar_html($objPlaca->getIdPlaca())) . '"><i style="color: black;" class="fas fa-table"></i></a></td>';
        }else{
            $html .= '<td ></td>';
        }


        if (Sessao::getInstance()->verificar_permissao('imprimir_mix_placa_RTqPCR')) {
            $html .= '<td><a target="_blank" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=imprimir_mix_placa_RTqPCR&idMix=' . Pagina::formatar_html($mix->getIdMixPlaca()) ) . '"><i style="color:black;margin: 0px; padding: 0px;" class="fas fa-print"></i></a></td>';
        }else{
            $html .= '<td ></td>';
        }


        if (Sessao::getInstance()->verificar_permissao('remover_solicitacao_montagem_placa_RTqPCR')) {
            if($solicitacao->getSituacaoSolicitacao() != SolicitacaoMontarPlacaRN::$TS_FINALIZADA ) {
                $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_solicitacao_montagem_placa_RTqPCR&idSolicitacao=' . Pagina::formatar_html($mix->getObjSolicitacao()->getIdSolicitacaoMontarPlaca())) . '"><i class="fas fa-trash-alt"></i></a></td>';
                $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_tabelas_protocolos&idSolicitacao=' . Pagina::formatar_html($mix->getObjSolicitacao()->getIdSolicitacaoMontarPlaca()).'&idMix=' . Pagina::formatar_html($mix->getIdMixPlaca()) . '&idPlaca=' . Pagina::formatar_html($objPlaca->getIdPlaca())) . '"><i class="fas fa-trash-alt"></i></a></td>';
            }else{
                $html .= '<td ></td>';
            }
        }else{
            $html .= '<td ></td>';
        }


        $html .= '</tr>';
        $a++;
    }


} catch (Throwable $ex) {
    //die($ex);
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Listar Mix da Placa");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("pesquisa_pg");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('LISTAR MIX DA PLACA', null, null, null, null);
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
                    <a class="dropdown-item" href="#" style="color: grey;"><i class="fas fa-eye" style="color:red;"  ></i>  O mix está em andamento ou placa está inválida</a>
                    <a class="dropdown-item" href="#" style="color: grey;"><i class="fas fa-eye" style="color:black;"></i>  Placa está válida, mas não foi salva definitivamente</a>
                    <a class="dropdown-item" href="#" style="color: grey;"><i class="fas fa-eye" style="color:green;"></i>  Placa está válida e pronta para montagem</a>
                    <a class="dropdown-item" href="#" style="color: grey;"><i class="fas fa-exclamation-triangle" style="color: #f36c29;"></i>  O mix da placa está em andamento</a>
                    <a class="dropdown-item" href="#" style="color: grey;"><i style="color: black;" class="fas fa-table"></i>  Tabelas dos protocolos</a>
                    <a class="dropdown-item" href="#" style="color: grey;"><i style="color:black;margin: 0px; padding: 0px;" class="fas fa-print"></i>  Impressão da placa de poços</a>
                    
                  </div>
            </div>
            <table class="table table-hover"  >
                <thead>
                    <tr>
                        <th  scope="col">MIX</th>
                        <th  scope="col">ID DA SOLICITAÇÃO DE ORIGEM</th>
                        <th  scope="col">SITUAÇÃO MIX</th>
                        <th  scope="col">Nº PLACA</th>';


if (Sessao::getInstance()->verificar_permissao('listar_tubos')) {
    echo '<th  scope="col">TUBOS</th>';
}
echo '<th  scope="col">AMOSTRAS</th>
                        <th scope="col">ID USUÁRIO</th>
                        <th  scope="col">DATA HORA INÍCIO</th>
                        <th  scope="col">DATA HORA TÉRMINO</th>';
if (!is_null($solicitacao) && !is_null($solicitacao->getSituacaoSolicitacao()) && $solicitacao->getSituacaoSolicitacao() == SolicitacaoMontarPlacaRN::$TS_EM_ANDAMENTO) { echo '<th scope="col"></th>';}
if (Sessao::getInstance()->verificar_permissao('mostrar_poco')) { echo '<th scope="col"></th>';}
if (Sessao::getInstance()->verificar_permissao('imprimir_solicitacao_montagem_placa_RTqPCR')) {echo '<th scope="col"></th>';}
if (Sessao::getInstance()->verificar_permissao('remover_solicitacao_montagem_placa_RTqPCR')) {echo '<th scope="col"></th>';}
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
