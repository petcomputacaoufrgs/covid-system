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

    require_once __DIR__ . '/../../classes/MontagemPlaca/MontagemPlaca.php';
    require_once __DIR__ . '/../../classes/MontagemPlaca/MontagemPlacaRN.php';
    require_once __DIR__ . '/../../classes/MontagemPlaca/MontagemPlacaINT.php';

    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTexto.php';
    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTextoRN.php';

    require_once __DIR__.'/../../classes/Pesquisa/PesquisaINT.php';

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


    /*
     * SOLICITAÇÃO DE MONTAGEM DA PLACA RTqPCR
     */
    $objSolMontarPlaca = new SolicitacaoMontarPlaca();
    $objSolMontarPlacaRN = new SolicitacaoMontarPlacaRN();

    /*
     *  MIX
     */
    $objMix = new MixRTqPCR();
    $objMixRN = new MixRTqPCR_RN();

    /*
    *  MONTAGEM PLACA
    */
    $objMontagemPlaca = new MontagemPlaca();
    $objMontagemPlacaRN = new MontagemPlacaRN();

    $alert = '';
    switch ($_GET['action']){
        case 'remover_montagem_placa_RTqPCR':
            try{
                $objMontagemPlaca->setIdMontagem($_GET['idMontagem']);
                $objMontagemPlaca = $objMontagemPlacaRN->consultar($objMontagemPlaca);
                if($objMontagemPlaca->getSituacaoMontagem() != MontagemPlacaRN::$STA_MONTAGEM_FINALIZADA) {
                    $objMontagemPlacaRN->remover($objMontagemPlaca);
                }else{
                    $alert .= Alert::alert_warning("A montagem já foi finalizada, logo não pode ser excluída");
                }
            }catch (Throwable $ex){
                Pagina::getInstance()->processar_excecao($ex);
            }
    }

    /************************* FIM REMOÇÃO *************************/

    $array_colunas = array('ID MONTAGEM','SITUAÇÃO MONTAGEM','ID MIX','ID PLACA');
    $array_tipos_colunas = array('text','select_situacoes_montagem', 'text','text');//,'text');
    $valorPesquisa = '';
    $select_pesquisa = '';
    PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, null,null,' onchange="this.form.submit()" ');

    $select_situacoes_montagem = '';

    if(isset($_POST['sel_pesquisa_coluna']) ){

        PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, $_POST['sel_pesquisa_coluna'],null,' onchange="this.form.submit()" ');
        if($array_tipos_colunas[$_POST['sel_pesquisa_coluna']] == 'select_situacoes_montagem'){
            MontagemPlacaINT::montar_select_situacao_montagem($select_situacoes_montagem,$objMontagemPlaca,null,null);
            $input = $select_situacoes_montagem;
        } else {
            //echo $array_tipos_colunas[$_POST['sel_pesquisa_coluna']];
            $input = '<input type="' . $array_tipos_colunas[$_POST['sel_pesquisa_coluna']] . '" value="' . $_POST['valorPesquisa'] .
                '" placeholder="' . $array_colunas[$_POST['sel_pesquisa_coluna']] . '" name="valorPesquisa" aria-label="Search" class="form-control">';
        }
    }ELSE{
        $input = '<input type="text" disabled value="" id="pesquisaDisabled" placeholder="" name="valorPesquisa" aria-label="Search" class="form-control">';
    }

    if(!isset($_POST['hdnPagina'])){
        $objMontagemPlaca->setNumPagina(1);
    } else {
        $objMontagemPlaca->setNumPagina($_POST['hdnPagina']);
    }


    if(isset($_POST['valorPesquisa']) || isset($_POST['sel_situacao_montagem'])){

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'ID MONTAGEM'){
            $objMontagemPlaca->setIdMontagem($_POST['valorPesquisa']);
        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'SITUAÇÃO MONTAGEM'){
            $objMontagemPlaca->setSituacaoMontagem($_POST['sel_situacao_montagem']);
            MontagemPlacaINT::montar_select_situacao_montagem($select_situacoes_montagem,$objMontagemPlaca,null,null);
            $input = $select_situacoes_montagem;
        }


        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'ID MIX'){
            $objMix->setIdMixPlaca($_POST['valorPesquisa']);
            $objMontagemPlaca->setObjMix($objMix);
        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'ID PLACA'){
            $objPlaca->setIdPlaca($_POST['valorPesquisa']);
            $objMix->setObjPlaca($objPlaca);
            $objMontagemPlaca->setObjMix($objMix);
        }


    }

    $arrMontagem = $objMontagemPlacaRN->paginacao($objMontagemPlaca);

    /*
        echo "<pre>";
        print_r($arrMontagem);
        echo "</pre>";
    */
    $alert .= Alert::alert_info("Foram encontradas ".$objMontagemPlaca->getTotalRegistros()." montagens de placa");


    /************************* PAGINAÇÃO *************************/
    $paginacao = '
                    <nav aria-label="Page navigation example">
                      <ul class="pagination">';
    $paginacao .= '<li class="page-item"><input type="button" onclick="paginar(1)" class="page-link" name="btn_paginacao" value="Primeiro"/></li>';
    for($i=0; $i<($objMontagemPlaca->getTotalRegistros()/20); $i++){
        $color = '';
        if($objMontagemPlaca->getNumPagina() == $i ){
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
        print_r($arrMontagem);
        echo "</pre>";
     */


    foreach ($arrMontagem as $montagem) {
        $objUsuario = $montagem->getObjUsuario();
        $objMix = $montagem->getObjMix();
        $solicitacao = $montagem->getObjMix()->getObjSolicitacao();
        $objPlaca = $montagem->getObjMix()->getObjSolicitacao()->getObjPlaca();


        $strTubos = '';
        $strAmostras = '';
        $arr_amostras = array();
        $contador = 0;
        foreach($objPlaca->getObjRelTuboPlaca() as $tubo){
            //print_r($tubo);
            $strTubos .= $tubo->getIdTuboFk().",";
            $contador++;
            if($contador == 5){
                $strTubos .= "\n";
                $contador = 0;
            }


            foreach ($tubo->getObjTubo() as $amostra) {
                if(!in_array($amostra->getNickname(),$arr_amostras)) {
                    $arr_amostras[] = $amostra->getNickname();
                    $strAmostras .= $amostra->getNickname() . ",";
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
        if ($montagem->getSituacaoMontagem() == MontagemPlacaRN::$STA_MONTAGEM_ANDAMENTO) {
            $style_linha = ' style="background: rgba(243,108,41,0.2);"';
            $style_td  = $style_linha;
        }

        if ($montagem->getSituacaoMontagem() == MontagemPlacaRN::$STA_MONTAGEM_FINALIZADA) {
            $style_td = ' style="background: rgba(0,255,0,0.2);"';
        }


        $html .= '<tr' . $style_linha . '>           
            <th scope="row" >' . Pagina::formatar_html($montagem->getIdMontagem()) . '</th>';
        $html .= '    <th scope="row" '.$style_td.'>' . Pagina::formatar_html(MontagemPlacaRN::mostrar_descricao_staMontagemPlaca($montagem->getSituacaoMontagem())) . '</th>';

        $html .= '<td>' . Pagina::formatar_html($objMix->getIdMixPlaca()) . '</td>';

        $html .= '<td>' . Pagina::formatar_html($objPlaca->getIdPlaca()) . '</td>';



        if (Sessao::getInstance()->verificar_permissao('listar_tubos')) {
            $html .= '    <td style="white-space: pre-wrap;">' . Pagina::formatar_html($strTubos) . '</td>';
        }
        $html .= '    <td style="white-space: pre-wrap;">' . Pagina::formatar_html($strAmostras) . '</td>';

        $html .= '    <td>' . Pagina::formatar_html($objUsuario->getMatricula()) . '</td>';

        $html .= '   <td>'.Utils::converterDataHora($montagem->getDataHoraInicio()).'</td>';

        if ($montagem->getSituacaoMontagem() == MontagemPlacaRN::$STA_MONTAGEM_FINALIZADA) {
            $html .= '   <td>'.Utils::converterDataHora($montagem->getDataHoraFim()).'</td>';
        }else{
            $html .= '   <td> - </td>';
        }


        //echo 'controlador.php?action=mix_placa_RTqPCR&idSolicitacao=' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca()) . '&idPlaca=' . Pagina::formatar_html($solicitacao->getObjPlaca()->getIdPlaca()) . '&idMix=' . Pagina::formatar_html($mix->getIdMixPlaca())."\n";
        if ($montagem->getSituacaoMontagem() == MontagemPlacaRN::$STA_MONTAGEM_ANDAMENTO) {
            $html .= '<td ><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=montar_placa_RTqPCR&idMix=' . Pagina::formatar_html($objMix->getIdMixPlaca()) . '&idMontagem=' . Pagina::formatar_html($montagem->getIdMontagem())) .'"><i class="fas fa-exclamation-triangle" style="color: #f36c29;"></i></td>';
        }else{
            $html .= '<td ></td>';
        }



        if (Sessao::getInstance()->verificar_permissao('imprimir_montagem_placa_RTqPCR')) {
            $html .= '<td><a target="_blank" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=imprimir_montagem_placa_RTqPCR&idMontagem=' . Pagina::formatar_html($montagem->getIdMontagem())) . '"><i style="color:black;margin: 0px; padding: 0px;" class="fas fa-print"></i></a></td>';
        }else{
            $html .= '<td ></td>';
        }

        if (Sessao::getInstance()->verificar_permissao('remover_montagem_placa_RTqPCR')) {
            if($solicitacao->getSituacaoSolicitacao() != SolicitacaoMontarPlacaRN::$TS_FINALIZADA ) {
                $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_montagem_placa_RTqPCR&idMontagem=' . Pagina::formatar_html($montagem->getIdMontagem())) . '"><i class="fas fa-trash-alt"></i></a></td>';
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


Pagina::abrir_head("Listar Montagens das Placas RTqPCR");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("pesquisa_pg");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('LISTAR MONTAGEM DAS PLACAS RTqPCR', null, null, 'montar_placa_RTqPCR', 'NOVA MONTAGEM DE PLACA');
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
            <table class="table table-hover"  >
                <thead>
                    <tr>
                        <th  scope="col">ID MONTAGEM PLACA</th>
                        <th  scope="col">ID SITUAÇÃO MONTAGEM </th>
                        <th  scope="col">ID MIX</th>
                        <th  scope="col">ID PLACA</th>';


if (Sessao::getInstance()->verificar_permissao('listar_tubos')) {
    echo '<th  scope="col">TUBOS</th>';
}
echo '<th  scope="col">AMOSTRAS</th>
                        <th scope="col">ID USUÁRIO</th>
                        <th  scope="col">DATA HORA INÍCIO</th>
                        <th  scope="col">DATA HORA TÉRMINO</th>';
if ($solicitacao->getSituacaoSolicitacao() == MontagemPlacaRN::$STA_MONTAGEM_ANDAMENTO) { echo '<th scope="col"></th>';}
if (Sessao::getInstance()->verificar_permissao('imprimir_montagem_placa_RTqPCR')) {echo '<th scope="col"></th>';}
if (Sessao::getInstance()->verificar_permissao('remover_montagem_placa_RTqPCR')) {echo '<th scope="col"></th>';}
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
