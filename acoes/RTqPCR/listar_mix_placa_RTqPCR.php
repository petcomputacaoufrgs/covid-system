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


    $arr_mix = $objMixRN->listar(new MixRTqPCR(),null,true);
    //$arr_solicitacoes = $objSolMontarPlacaRN->listar(new SolicitacaoMontarPlaca());
    /*echo '<pre>';
           print_r($arr_solicitacoes);
           echo '</pre>';*/


    foreach ($arr_mix as $mix) {
        $solicitacao = $mix->getObjSolicitacao();

        $strTubos = '';
        $strAmostras = '';
        $contador = 0;
        foreach ($solicitacao->getObjsRelTuboPlaca() as $relacionamento) {
            $strTubos .= $relacionamento->getIdTuboFk() . ",";
            $contador++;
            if ($contador == 8) {
                $contador = 0;
                $strTubos .= "\n";
            }
        }

        $contador = 0;
        foreach ($solicitacao->getObjsAmostras() as $relacionamento) {
            $strAmostras .= $relacionamento->getNickname() . ",";
            $contador++;
            if ($contador == 8) {
                $contador = 0;
                $strAmostras .= "\n";
            }
        }

        $strTubos = substr($strTubos, 0, -1);
        $strAmostras = substr($strAmostras, 0, -1);

        $style_linha = '';
        if ($solicitacao->getSituacaoSolicitacao() == SolicitacaoMontarPlacaRN::$TS_EM_ANDAMENTO) {
            $style_linha = ' style="background: rgba(243,108,41,0.2);"';
        }



        $html .= '<tr' . $style_linha . '>           
            <th scope="row" >' . Pagina::formatar_html($mix->getIdMixPlaca()) . '</th>';

        $html .= '<td>' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca()) . '</td>';


        $html .= '<td>' . Pagina::formatar_html(MixRTqPCR_RN::mostrar_descricao_staMix($mix->getSituacaoMix())) . '</td>';
        
        $html .= '<td>' . Pagina::formatar_html($solicitacao->getObjPlaca()->getIdPlaca()) . '</td>';


        if (Sessao::getInstance()->verificar_permissao('listar_tubos')) {
            $html .= '    <td style="white-space: pre-wrap;">' . Pagina::formatar_html($strTubos) . '</td>';
        }
        $html .= '    <td style="white-space: pre-wrap;">' . Pagina::formatar_html($strAmostras) . '</td>';

        $html .= '    <td>' . Pagina::formatar_html($mix->getIdUsuarioFk()) . '</td>';

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


        //echo 'controlador.php?action=solicitar_montagem_placa_RTqPCR&idSolicitacao=' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca()) . '&idProtocolo=' . Pagina::formatar_html($solicitacao->getObjPlaca()->getIdProtocoloFk()) . '&idPlaca=' . Pagina::formatar_html($solicitacao->getObjPlaca()->getIdPlaca()) . '&idSituacao=1';
        if ($solicitacao->getSituacaoSolicitacao() == SolicitacaoMontarPlacaRN::$TS_EM_ANDAMENTO) {
            $html .= '<td ><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=solicitar_montagem_placa_RTqPCR&idSolicitacao=' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca()) . '&idProtocolo=' . Pagina::formatar_html($solicitacao->getObjPlaca()->getIdProtocoloFk()) . '&idPlaca=' . Pagina::formatar_html($solicitacao->getObjPlaca()->getIdPlaca())) . '&idSituacao=1"><i class="fas fa-exclamation-triangle" style="color: #f36c29;"></i></td>';
        }


        if (Sessao::getInstance()->verificar_permissao('mostrar_poco')) {
            if($solicitacao->getSituacaoSolicitacao() == SolicitacaoMontarPlacaRN::$TS_FINALIZADA ) {
                $color = ' style="color:black;" ';
                if($solicitacao->getObjPlaca()->getSituacaoPlaca() == PlacaRN::$STA_INVALIDA){
                    $color = ' style="color:red;" ';
                }
                $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=mostrar_poco&idSolicitacao=' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca()) . '&idPlaca=' . Pagina::formatar_html($solicitacao->getObjPlaca()->getIdPlaca())) . '"><i class="fas fa-th"'.$color.'"></i></a></td>';
            }
        }


        if (Sessao::getInstance()->verificar_permissao('imprimir_solicitacao_montagem_placa_RTqPCR')) {
            $html .= '<td><a target="_blank" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=imprimir_solicitacao_montagem_placa_RTqPCR&idSolicitacao=' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca()) ) . '"><i style="color:black;margin: 0px; padding: 0px;" class="fas fa-print"></i></a></td>';
        }

        if (Sessao::getInstance()->verificar_permissao('remover_solicitacao_montagem_placa_RTqPCR')) {
            if($solicitacao->getSituacaoSolicitacao() != SolicitacaoMontarPlacaRN::$TS_FINALIZADA ) {
                $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_solicitacao_montagem_placa_RTqPCR&idSolicitacao=' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca())) . '"><i class="fas fa-trash-alt"></i></a></td>';
            }
        }


        $html .= '</tr>';
        $a++;
    }


} catch (Throwable $ex) {
    //die($ex);
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Listar Solicitações de Montagem das Placas RTqPCR");
Pagina::getInstance()->adicionar_css("precadastros");

Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('LISTAR SOLICITAÇÕES DE MONTAGEM DAS PLACAS RTqPCR', null, null, null, null);
Pagina::getInstance()->mostrar_excecoes();
echo $alert;

echo '<div id="tabela_preparos" style="margin-top: -50px;">
        <div class="conteudo_tabela " >
            <table class="table table-hover table-responsive table-sm"  >
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
