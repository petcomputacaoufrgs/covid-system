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
    require_once __DIR__ . '/../../classes/Placa/PlacaINT.php';

    require_once __DIR__ . '/../../classes/Amostra/Amostra.php';
    require_once __DIR__ . '/../../classes/Amostra/AmostraRN.php';

    require_once __DIR__ . '/../../classes/Tubo/Tubo.php';
    require_once __DIR__ . '/../../classes/Tubo/TuboRN.php';

    require_once __DIR__ . '/../../classes/InfosTubo/InfosTubo.php';
    require_once __DIR__ . '/../../classes/InfosTubo/InfosTuboRN.php';


    require_once __DIR__ . '/../../classes/Protocolo/Protocolo.php';
    require_once __DIR__ . '/../../classes/Protocolo/ProtocoloRN.php';
    require_once __DIR__ . '/../../classes/Protocolo/ProtocoloINT.php';

    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPaciente.php';
    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPacienteRN.php';

    require_once __DIR__ . '/../../classes/RelTuboPlaca/RelTuboPlaca.php';
    require_once __DIR__ . '/../../classes/RelTuboPlaca/RelTuboPlacaRN.php';

    require_once __DIR__ . '/../../classes/RelPerfilPlaca/RelPerfilPlaca.php';
    require_once __DIR__ . '/../../classes/RelPerfilPlaca/RelPerfilPlacaRN.php';

    require_once __DIR__ . '/../../classes/SolicitacaoMontarPlaca/SolicitacaoMontarPlaca.php';
    require_once __DIR__ . '/../../classes/SolicitacaoMontarPlaca/SolicitacaoMontarPlacaRN.php';
    require_once __DIR__ . '/../../classes/SolicitacaoMontarPlaca/SolicitacaoMontarPlacaINT.php';

    require_once __DIR__ . '/../../classes/Pesquisa/PesquisaINT.php';

    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTexto.php';
    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTextoRN.php';

    Sessao::getInstance()->validar();
    $utils = new Utils();

    date_default_timezone_set('America/Sao_Paulo');


    /*
     * AMOSTRA
     */
    $objAmostra = new Amostra();
    $objAmostraRN = new AmostraRN();

    /*
     * PLACA
     */
    $objPlaca = new Placa();
    $objPlacaRN = new PlacaRN();

    /*
    * TUBO
    */
    $objTubo = new Tubo();
    $objTuboRN = new TuboRN();

    $objInfosTubo = new InfosTubo();
    $objInfosTuboRN = new InfosTuboRN();

    /*
     * PROTOCOLO
     */
    $objProtocolo = new Protocolo();
    $objProtocoloRN = new ProtocoloRN();

    /*
     * PERFIL PACIENTE
     */
    $objPerfilPaciente = new PerfilPaciente();
    $objPerfilPacienteRN = new PerfilPacienteRN();

    /*
     * RELACIONAMENTO DOS TUBOS COM A PLACA
     */
    $objRelTuboPlaca = new RelTuboPlaca();
    $objRelTuboPlacaRN = new RelTuboPlacaRN();

    /*
    * RELACIONAMENTO DOS PERFIS COM A PLACA
    */
    $objRelPerfilPlaca = new RelPerfilPlaca();
    $objRelPerfilPlacaRN = new RelPerfilPlacaRN();

    /*
     * SOLICITAÇÃO DE MONTAGEM DA PLACA RTqPCR
     */
    $objSolMontarPlaca = new SolicitacaoMontarPlaca();
    $objSolMontarPlacaRN = new SolicitacaoMontarPlacaRN();



    $alert = '';
    /************************* REMOÇÃO *************************/
    switch ($_GET['action']){
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
    }
    /************************* FIM DA REMOÇÃO *************************/



    //$objProtocolo->setIndexProtocolo("AGPATH/CDC");
    //$objPlaca->setObjProtocolo($objProtocolo);
    //$objSolMontarPlaca->setObjPlaca($objPlaca);



    $array_colunas = array('CÓDIGO', 'SITUAÇÃO DA SOLICITAÇÃO','CÓDIGO PLACA','SITUAÇÃO PLACA','PROTOCOLO');
    $array_tipos_colunas = array('text','selectSituacaoSolicitacao', 'text','selectSituacaoPlaca', 'selectProtocolo');//,'text');
    $valorPesquisa = '';
    $select_pesquisa = '';
    PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, null,null,' onchange="this.form.submit()" ');

    if (isset($_POST['bt_resetar'])) {
        $select_pesquisa = '';
        PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, null,null,' onchange="this.form.submit()" ');
    }

    $select_situacoes_placa = '';
    $select_protocolo = '';
    $select_situacao_solicitacao = '';

    if(isset($_POST['sel_pesquisa_coluna']) ){

        PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, $_POST['sel_pesquisa_coluna'],null,' onchange="this.form.submit()" ');
        if($array_tipos_colunas[$_POST['sel_pesquisa_coluna']] == 'selectSituacaoPlaca'){
            PlacaINT::montar_select_situacao_placa($select_situacoes_placa,$objPlaca,null,null);
            $input = $select_situacoes_placa;
        }else if($array_tipos_colunas[$_POST['sel_pesquisa_coluna']] == 'selectSituacaoSolicitacao'){
            $objSolMontarPlaca->setSituacaoSolicitacao(null);
            SolicitacaoMontarPlacaINT::montar_select_situacoes_solicitacao($select_situacao_solicitacao, $objSolMontarPlaca, null,  null);
            $input = $select_situacao_solicitacao;
        } else if($array_tipos_colunas[$_POST['sel_pesquisa_coluna']] == 'selectProtocolo'){
            ProtocoloINT::montar_select_protocolo($select_protocolo,$objProtocolo,null,null);
            $input = $select_protocolo;

        } else {
            //echo $array_tipos_colunas[$_POST['sel_pesquisa_coluna']];
            $input = '<input type="' . $array_tipos_colunas[$_POST['sel_pesquisa_coluna']] . '" value="' . $_POST['valorPesquisa'] .
                '" placeholder="' . $array_colunas[$_POST['sel_pesquisa_coluna']] . '" name="valorPesquisa" aria-label="Search" class="form-control">';
        }
    }ELSE{
        $input = '<input type="text" disabled value="" id="pesquisaDisabled" placeholder="" name="valorPesquisa" aria-label="Search" class="form-control">';
    }

    if(!isset($_POST['hdnPagina'])){
        $objSolMontarPlaca->setNumPagina(1);
    } else {
        $objSolMontarPlaca->setNumPagina($_POST['hdnPagina']);
    }


    if(isset($_POST['valorPesquisa']) || isset($_POST['sel_situacao_placa'])
        || isset($_POST['sel_tipos_protocolos']) || isset($_POST['sel_situacao_solicitacao'])){
        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'CÓDIGO'){
            $objSolMontarPlaca->setIdSolicitacaoMontarPlaca($_POST['valorPesquisa']);
        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'CÓDIGO PLACA'){
            $objPlaca->setIdPlaca($_POST['valorPesquisa']);
            $objSolMontarPlaca->setObjPlaca($objPlaca);
        }


        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'SITUAÇÃO DA SOLICITAÇÃO'){
            $objSolMontarPlaca->setSituacaoSolicitacao($_POST['sel_situacao_solicitacao']);
            SolicitacaoMontarPlacaINT::montar_select_situacoes_solicitacao($select_situacao_solicitacao, $objSolMontarPlaca, null,  null);
            $input = $select_situacao_solicitacao;
        }


        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'SITUAÇÃO PLACA'){
            $objPlaca->setSituacaoPlaca($_POST['sel_situacao_placa']);
            PlacaINT::montar_select_situacao_placa($select_situacoes_placa,$objPlaca,null,null);
            $input = $select_situacoes_placa;
            $objSolMontarPlaca->setObjPlaca($objPlaca);
        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'PROTOCOLO'){
            $objProtocolo->setCaractere($_POST['sel_tipos_protocolos']);
            ProtocoloINT::montar_select_protocolo($select_protocolo,$objProtocolo,null,null);
            $input = $select_protocolo;
            $objPlaca->setObjProtocolo($objProtocolo);
            $objSolMontarPlaca->setObjPlaca($objPlaca);
        }

    }

    $arr_solicitacoes = $objSolMontarPlacaRN->paginacao($objSolMontarPlaca);
    $alert .= Alert::alert_info("Foram encontradas ".$objSolMontarPlaca->getTotalRegistros()." solicitações");


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
    print_r($arr_solicitacoes);
    echo "</pre>";
    */

    foreach ($arr_solicitacoes as $solicitacao) {

        $strTubos = '';
        $strAmostras = '';
        $contador = 0;
        $contadorAmostra = 0;
        foreach ($solicitacao->getObjPlaca()->getObjRelTuboPlaca() as $relacionamento) {
            $strTubos .= $relacionamento->getIdTuboFk() . ",";
            $contador++;
            if ($contador == 8) {
                $contador = 0;
                $strTubos .= "\n";
            }

            foreach ($relacionamento->getObjTubo() as $amostra) {
                $strAmostras .= $amostra->getNickname() . ",";
                $contadorAmostra++;
                if ($contadorAmostra == 8) {
                    $contadorAmostra = 0;
                    $strAmostras .= "\n";
                }
            }
        }


        $strTubos = substr($strTubos, 0, -1);
        $strAmostras = substr($strAmostras, 0, -1);

        $style_linha = '';
        if ($solicitacao->getSituacaoSolicitacao() == SolicitacaoMontarPlacaRN::$TS_EM_ANDAMENTO) {
            $style_linha = ' style="background: rgba(243,108,41,0.2);"';
        }



        $html .= '<tr' . $style_linha . '>           
            <th scope="row" >' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca()) . '</th>';


        if ($solicitacao->getSituacaoSolicitacao() == SolicitacaoMontarPlacaRN::$TS_FINALIZADA) {
            $style = ' style="background: rgba(0,255,0,0.2);"';
        }

        if ($solicitacao->getSituacaoSolicitacao() == SolicitacaoMontarPlacaRN::$TS_EM_ANDAMENTO) {
            $style = ' style="background: rgba(243,108,41,0.2);"';
        }
        $html .= '<td' . $style . '>' . Pagina::formatar_html(SolicitacaoMontarPlacaRN::mostrarDescricaoSituacaoSolicitacao($solicitacao->getSituacaoSolicitacao())) . '</td>';

        $html .= '<td>' . Pagina::formatar_html($solicitacao->getObjPlaca()->getIdPlaca()) . '</td>';
        $html .= '<td>' . Pagina::formatar_html($solicitacao->getObjPlaca()->getPlaca()) . '</td>';

        $background_placa = '';
        if($solicitacao->getObjPlaca()->getSituacaoPlaca() == PlacaRN::$STA_INVALIDA){
            $background_placa = ' style="background: rgba(255,0,0,0.2);"';
        }

        $html .= '<td'.$background_placa.'>' . Pagina::formatar_html(PlacaRN::mostrar_descricao_staPlaca($solicitacao->getObjPlaca()->getSituacaoPlaca())) . '</td>';

        $html .= '<td>' . Pagina::formatar_html($solicitacao->getObjPlaca()->getObjProtocolo()->getProtocolo()) . '</td>';
        if (Sessao::getInstance()->verificar_permissao('listar_tubos')) {
            $html .= '    <td style="white-space: pre-wrap;"> ' . Pagina::formatar_html($strTubos) . '</td>';
        }
        $html .= '    <td style="white-space: pre-wrap;">' . Pagina::formatar_html($strAmostras) . '</td>';
        $html .= '    <td >' . Pagina::formatar_html($solicitacao->getObjUsuario()->getMatricula()) . '</td>';

        $dataHoraInicio = explode(" ", $solicitacao->getDataHoraInicio());
        $data = explode("-", $dataHoraInicio[0]);

        $diaI = $data[2];
        $mesI = $data[1];
        $anoI = $data[0];

        $html .= '   <td>' . $diaI . '/' . $mesI . '/' . $anoI . ' - ' . $dataHoraInicio[1] . '</td>';

        if ($solicitacao->getSituacaoSolicitacao() == SolicitacaoMontarPlacaRN::$TS_FINALIZADA) {
            $dataHoraFim = explode(" ", $solicitacao->getDataHoraFim());
            $data = explode("-", $dataHoraFim[0]);

            $diaF = $data[2];
            $mesF = $data[1];
            $anoF = $data[0];

            $html .= '   <td>' . $diaF . '/' . $mesF . '/' . $anoF . ' - ' . $dataHoraFim[1] . '</td>';
        } else {
            $html .= '<td> </td>';
        }

        //echo 'controlador.php?action=solicitar_montagem_placa_RTqPCR&idSolicitacao=' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca()) . '&idProtocolo=' . Pagina::formatar_html($solicitacao->getObjPlaca()->getIdProtocoloFk()) . '&idPlaca=' . Pagina::formatar_html($solicitacao->getObjPlaca()->getIdPlaca()) . '&idSituacao=1';
        if ($solicitacao->getSituacaoSolicitacao() == SolicitacaoMontarPlacaRN::$TS_EM_ANDAMENTO) {
            $html .= '<td ><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=solicitar_montagem_placa_RTqPCR&idSolicitacao=' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca()) . '&idProtocolo=' . Pagina::formatar_html($solicitacao->getObjPlaca()->getIdProtocoloFk()) . '&idPlaca=' . Pagina::formatar_html($solicitacao->getObjPlaca()->getIdPlaca())) . '&idSituacao=1"><i class="fas fa-exclamation-triangle" style="color: #f36c29;"></i></td>';
        }else{
            $html.='<td></td>';
        }


        if (Sessao::getInstance()->verificar_permissao('mostrar_poco')) {
            if($solicitacao->getSituacaoSolicitacao() == SolicitacaoMontarPlacaRN::$TS_FINALIZADA ) {
                $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=mostrar_poco&idSolicitacao=' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca()) . '&idPlaca=' . Pagina::formatar_html($solicitacao->getObjPlaca()->getIdPlaca())) . '"><i class="fas fa-eye" style="color: black;"></i></a></td>';
            }else{
                $html.='<td></td>';
            }
        }else{
            $html.='<td></td>';
        }

        if (Sessao::getInstance()->verificar_permissao('imprimir_solicitacao_montagem_placa_RTqPCR')) {
            $html .= '<td><a target="_blank" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=imprimir_solicitacao_montagem_placa_RTqPCR&idSolicitacao=' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca()) ) . '"><i style="color:black;margin: 0px; padding: 0px;" class="fas fa-print"></i></a></td>';
        }else{
            $html.='<td></td>';
        }

        if (Sessao::getInstance()->verificar_permissao('remover_solicitacao_montagem_placa_RTqPCR')) {
            if($solicitacao->getSituacaoSolicitacao() != SolicitacaoMontarPlacaRN::$TS_FINALIZADA ) {
                $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_solicitacao_montagem_placa_RTqPCR&idSolicitacao=' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca())) . '"><i class="fas fa-trash-alt"></i></a></td>';
            }else{
                $html.='<td></td>';
            }
        }else{
            $html.='<td></td>';
        }


        $html .= '</tr>';
        $a++;
    }


} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Listar Solicitações de Montagem das Placas RTqPCR");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("pesquisa_pg");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('LISTAR SOLICITAÇÕES DE MONTAGEM DAS PLACAS RTqPCR', null, null, null, null);
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
         
         <div id="tabela_preparos" style="margin-top: -50px;" >
        <div class="conteudo_tabela " >
            <table class="table table-hover  table-sm"  >
                <thead>
                    <tr>
                        <th  scope="col">SOLICITAÇÃO</th>
                        <th  scope="col">SITUAÇÃO DA SOLICITAÇÃO</th>
                        <th  scope="col">Nº PLACA</th>
                        <th  scope="col">NOME PLACA</th>
                        <th  scope="col">SITUAÇÃO PLACA</th>
                        <th  scope="col">PROTOCOLO</th>';

                        if (Sessao::getInstance()->verificar_permissao('listar_tubos')) {
                            echo '<th  scope="col">TUBOS</th>';
                        }
                        echo '<th  scope="col">AMOSTRAS</th>
                        <th scope="col">ID USUÁRIO</th>
                        <th  scope="col">DATA HORA INÍCIO</th>
                        <th  scope="col">DATA HORA TÉRMINO</th>';
if ($solicitacao->getSituacaoSolicitacao() == SolicitacaoMontarPlacaRN::$TS_EM_ANDAMENTO) { echo '<th scope="col"></th>';}
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
