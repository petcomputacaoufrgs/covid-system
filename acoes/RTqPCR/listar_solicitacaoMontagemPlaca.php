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

    $alert = '';
    switch ($_GET['action']){
        case 'remover_solicitacao_montagem_placa_RTqPCR':
            try{
                $objSolMontarPlaca->setIdSolicitacaoMontarPlaca($_GET['idSolicitacao']);
                $objSolMontarPlaca = $objSolMontarPlacaRN->consultar($objSolMontarPlaca);
                if($objSolMontarPlaca->getSituacaoSolicitacao() != SolicitacaoMontarPlacaRN::$TS_FINALIZADA) {
                    $objSolMontarPlacaRN->remover_completamente($objSolMontarPlaca);
                }else{
                    $alert .= Alert::alert_warning("A solicitação já foi finalizada, logo não pode ser excluída");
                }
            }catch (Throwable $ex){
                Pagina::getInstance()->processar_excecao($ex);
            }
    }



    $arr_solicitacoes = $objSolMontarPlacaRN->listar($objSolMontarPlaca);
    /*echo '<pre>';
           print_r($arr_solicitacoes);
           echo '</pre>';*/


    foreach ($arr_solicitacoes as $solicitacao) {

        $strTubos = '';
        $strAmostras = '';
        foreach ($solicitacao->getObjsRelTuboPlaca() as $relacionamento) {
            $strTubos .= $relacionamento->getIdTuboFk() . ",";
        }

        foreach ($solicitacao->getObjsAmostras() as $relacionamento) {
            $strAmostras .= $relacionamento->getNickname() . ",";
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
        $html .= '<td>' . Pagina::formatar_html($solicitacao->getObjPlaca()->getObjProtocolo()->getProtocolo()) . '</td>';
        if (Sessao::getInstance()->verificar_permissao('listar_tubos')) {
            $html .= '    <td>' . Pagina::formatar_html($strTubos) . '</td>';
        }
        $html .= '    <td>' . Pagina::formatar_html($strAmostras) . '</td>';
        $html .= '    <td>' . Pagina::formatar_html($solicitacao->getIdUsuarioFk()) . '</td>';

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

        //echo 'controlador.php?action=solicitar_montagem_placa_RTqPCR&idSolicitacao=' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca()) . '&idProtocolo=' . Pagina::formatar_html($solicitacao->getObjPlaca()->getIdProtocoloFk()) . '&idPlaca=' . Pagina::formatar_html($solicitacao->getObjPlaca()->getIdPlaca());
        if ($solicitacao->getSituacaoSolicitacao() == SolicitacaoMontarPlacaRN::$TS_EM_ANDAMENTO) {
            $html .= '<td ><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=solicitar_montagem_placa_RTqPCR&idSolicitacao=' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca()) . '&idProtocolo=' . Pagina::formatar_html($solicitacao->getObjPlaca()->getIdProtocoloFk()) . '&idPlaca=' . Pagina::formatar_html($solicitacao->getObjPlaca()->getIdPlaca())) . '&idSituacao=1"><i class="fas fa-exclamation-triangle" style="color: #f36c29;"></i></td>';
        } else{
            $html .= '<td ></td>';
        }


        if (Sessao::getInstance()->verificar_permissao('mostrar_poco')) {
            if($solicitacao->getSituacaoSolicitacao() == SolicitacaoMontarPlacaRN::$TS_FINALIZADA ) {
                $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=mostrar_poco&idSolicitacao=' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca()).'&idPlaca=' . Pagina::formatar_html($solicitacao->getObjPlaca()->getIdPlaca())) . '"><i class="fas fa-th" style="color:black;"></i></a></td>';
            }else{
                $html .= '<td></td>';
            }
        }else{
            $html .= '<td></td>';
        }


        if (Sessao::getInstance()->verificar_permissao('imprimir_solicitacao_montagem_placa_RTqPCR')) {
            $html .= '<td><a target="_blank" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=imprimir_solicitacao_montagem_placa_RTqPCR&idSolicitacao=' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca()) ) . '"><i style="color:black;margin: 0px; padding: 0px;" class="fas fa-print"></i></a></td>';
        }else{
            $html .= '<td></td>';
        }

        if (Sessao::getInstance()->verificar_permissao('remover_solicitacao_montagem_placa_RTqPCR')) {
            if($solicitacao->getSituacaoSolicitacao() != SolicitacaoMontarPlacaRN::$TS_FINALIZADA ) {
                $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_solicitacao_montagem_placa_RTqPCR&idSolicitacao=' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca())) . '"><i class="fas fa-trash-alt"></i></a></td>';
            }else{
                $html .= '<td></td>';
            }
        }else{
            $html .= '<td></td>';
        }


        $html .= '</tr>';
        $a++;
    }


} catch (Throwable $ex) {
    //die($ex);
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Listar Grupos");
Pagina::getInstance()->adicionar_css("precadastros");

Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('LISTAR PREPARO DOS GRUPOS', null, null, null, null);
Pagina::getInstance()->mostrar_excecoes();
echo $alert;

echo '<div id="tabela_preparos" style="margin-top: -50px;">
        <div class="conteudo_tabela " >
            <table class="table table-hover table-responsive table-sm"  >
                <thead>
                    <tr>
                        <th  scope="col">SOLICITAÇÃO</th>
                        <th  scope="col">SITUAÇÃO DA SOLICITAÇÃO</th>
                        <th  scope="col">Nº PLACA</th>
                        <th  scope="col">NOME PLACA</th>
                        <th  scope="col">PROTOCOLO</th>';

                        if (Sessao::getInstance()->verificar_permissao('listar_tubos')) {
                            echo '<th  scope="col">TUBOS</th>';
                        }
                        echo '<th  scope="col">AMOSTRAS</th>
                        <th scope="col">ID USUÁRIO</th>
                        <th  scope="col">DATA HORA INÍCIO</th>
                        <th  scope="col">DATA HORA TÉRMINO</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <!--<th scope="col"></th>-->
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
