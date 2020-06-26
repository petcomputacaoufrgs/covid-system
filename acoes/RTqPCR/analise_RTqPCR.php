<?php
session_start();
try{
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
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


    Sessao::getInstance()->validar();
    date_default_timezone_set('America/Sao_Paulo');
    $_SESSION['DATA_LOGIN'] = date("Y-m-d H:i:s");
    $objUtils = new Utils();


    /*
     * RTqPCR
     */
    $objRTqPcr= new RTqPCR();
    $objRTqPcrRN = new RTqPCR_RN();

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

    /* PROTOCOLO */
    $objProtocolo = new Protocolo();
    $objProtocoloRN = new ProtocoloRN();

    /* DIVISÃO PROTOCOLO */
    $objDivisaoProtocolo = new DivisaoProtocolo();
    $objDivisaoProtocoloRN = new DivisaoProtocoloRN();

    /*
    *  POÇO
    */
    $objPoco = new Poco();
    $objPocoRN = new PocoRN();


    /*
    *  POÇO + PLACA
    */
    $objPocoPlaca = new PocoPlaca();
    $objPocoPlacaRN = new PocoPlacaRN();

    /*
     * PLACA
     */
    $objPlaca = new Placa();
    $objPlacaRN = new PlacaRN();


    $select_equipamentos = '';

    $objEquipamento->setSituacaoEquipamento(EquipamentoRN::$TE_LIBERADO);
    EquipamentoINT::montar_select_equipamentos($select_equipamentos,$objEquipamento,$objEquipamentoRN, null , null);

    $objPlaca->setSituacaoPlaca(PlacaRN::$STA_MONTAGEM_FINALIZADA);
    PlacaINT::montar_select_placa($select_placa,$objPlaca,$objPlacaRN,null,null);

    if(isset($_POST['btn_rtqpcr'])) {

        $objEquipamento->setIdEquipamento($_POST['sel_equipamento']);
        $objEquipamento = $objEquipamentoRN->consultar($objEquipamento);

        //MUDAR STATUS PLACA
        $objPlaca->setIdPlaca($_POST['sel_placa']);
        $arr_placas = $objPlacaRN->listar_completo($objPlaca);
        $objPlaca = $arr_placas[0];
        $objPlaca->setSituacaoPlaca(PlacaRN::$STA_SETUP_RTqPCR);

        foreach ($objPlaca->getObjsTubos() as $relTubos){
            foreach ($relTubos->getObjTubo() as $tubo ){
                $tamInfos = count($tubo->getObjTubo()->getObjInfosTubo());
                $objInfosTubo = new InfosTubo();
                $objInfosTubo = $tubo->getObjTubo()->getObjInfosTubo()[$tamInfos-1];
                $objInfosTubo->setIdInfosTubo(null);
                $objInfosTubo->setObservacoes(null);
                $objInfosTubo->setObsProblema(null);
                $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_EM_ANDAMENTO);
                $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_EM_UTILIZACAO);
                $objInfosTubo->setEtapa(InfosTuboRN::$TP_RTqPCR);
                $objInfosTubo->setEtapaAnterior(InfosTuboRN::$TP_RTqPCR_MONTAGEM_PLACA);
                $arr_infos[] = $objInfosTubo;
            }
        }

        $objPlaca->setObjsTubos($arr_infos);


        $minutos = 60 * intval( $objEquipamento->getHoras());
        $minutos +=  $objEquipamento->getMinutos();

        //echo date('H:i:s', strtotime('+'.$minutos. ' minute', strtotime($arrHora[1])));
        $objRTqPcr->setHoraFinal(date('H:i:s', strtotime('+'.$minutos. ' minute', strtotime(date('H:i:s')))));
        $objRTqPcr->setDataHoraFim(date("Y-m-d H:i:s"));
        $objRTqPcr->setIdUsuarioFk(Sessao::getInstance()->getIdUsuario());
        $objRTqPcr->setIdEquipamentoFk($objEquipamento->getIdEquipamento());
        $objRTqPcr->setIdPlacaFk($objPlaca->getIdPlaca());
        $objRTqPcr->setDataHoraInicio($_POST['dtHoraLoginInicio']);
        $objRTqPcr->setSituacaoRTqPCR(RTqPCR_RN::$STA_EM_ANDAMENTO);

        $objRTqPcr->setObjEquipamento($objEquipamento);
        $objRTqPcr->setObjPlaca($objPlaca);
        $objRTqPcr = $objRTqPcrRN->cadastrar($objRTqPcr);

        /*
        echo "<pre>";
        print_r($objPlaca);
        echo "</pre>";
        */

        EquipamentoINT::montar_select_equipamentos($select_equipamentos,$objEquipamento,$objEquipamentoRN, null , null);
        PlacaINT::montar_select_placa($select_placa,$objPlaca,$objPlacaRN,null,null);
        header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=analisar_RTqPCR&idPlaca=' . Pagina::formatar_html($objPlaca->getIdPlaca()) . '&idEquipamento=' . Pagina::formatar_html($objEquipamento->getIdEquipamento()) . '&idRTqPCR=' . Pagina::formatar_html($objRTqPcr->getIdRTqPCR())));
        die();
    }

    if(isset($_GET['idPlaca']) && isset($_GET['idEquipamento'])  && isset($_GET['idRTqPCR'])) {
        //mostrar tempo estimado

        $objEquipamento->setIdEquipamento($_GET['idEquipamento']);
        EquipamentoINT::montar_select_equipamentos($select_equipamentos,$objEquipamento,$objEquipamentoRN, true , null);

        $objRTqPcr->setIdRTqPCR($_GET['idRTqPCR']);
        $arr = $objRTqPcrRN->paginacao($objRTqPcr);
        $objRTqPcr = $arr[0];
        /*
            echo "<pre>";
            print_r($objRTqPcr);
            echo "</pre>";
        */
        $objEquipamento = $objRTqPcr->getObjEquipamento();

        $objPlaca->setIdPlaca($_GET['idPlaca']);
        $objPlaca = $objPlacaRN->consultar_completo($objPlaca);
        PlacaINT::montar_select_placa($select_placa,$objPlaca,$objPlacaRN,true,null);

        if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 1) {
            $incremento_na_placa_original = 0;
        } else if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 2) {
            $incremento_na_placa_original = 6;
        } else if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 3) {
            $incremento_na_placa_original = 4;
        }
        $quantidade = 8;
        $letras = range('A', chr(ord('A') + $quantidade));

        $cols = (12 / count($objPlaca->getObjProtocolo()->getObjDivisao()));

        $tubo_placa = 0;
        $posicoes_array = 0;
        $cont = 1;
        $disabled = ' disabled ';
        $table = '<table class="table table-responsive table-hover tabela_poco">';
        $arr_erro_qnt = array();
        for ($i = 0; $i <= 8; $i++) {
            $table .= '<tr>';

            for ($j = 0; $j <= 12; $j++) {
                $strPosicao = 'input_' . $i . '_' . $j;
                if ($i == 0 && $j == 0) { //canto superior esquerdo - quadrado vazio
                    $table .= '<td> - </td>';
                } else if ($i == 0 && $j > 0) { //linha 0 - local para se colocar os números
                    $table .= '<td><strong>' . $j . '</strong></td>';
                } else if ($j == 0 && $i > 0) { //linha 0 - local para se colocar os números
                    $table .= '<td><strong>' . $letras[$i - 1] . '</strong></td>';
                } else if ($i > 0 && $j > 0) {
                    foreach ($objPlaca->getObjsPocosPlacas() as $pocoPlaca) {
                        if ($pocoPlaca->getObjPoco()->getLinha() == $letras[$i - 1] && $pocoPlaca->getObjPoco()->getColuna() == $j) {
                            if ($pocoPlaca->getObjPoco()->getConteudo() != '') {
                                if ($pocoPlaca->getObjPoco()->getSituacao() == PocoRN::$STA_LIBERADO) {
                                    $style = ' style="background-color: rgba(0,255,0,0.2);"';
                                } else {
                                    $style = ' style="background-color: rgba(255,0,0,0.2);"';
                                }

                                if (trim($pocoPlaca->getObjPoco()->getConteudo()) == 'BR' ||
                                    trim($pocoPlaca->getObjPoco()->getConteudo()) == 'C+' ||
                                    trim($pocoPlaca->getObjPoco()->getConteudo() == 'C-')) {
                                    $style = ' style="background-color: rgba(255,255,0,0.2);"';
                                }
                                $table .= '<td><input ' . $style . $disabled.' type="text" class="form-control"
                                        id="idDataHoraLogin" style="text-align: center;"
                                        name="' . $strPosicao . '"
                                        value="' . $pocoPlaca->getObjPoco()->getConteudo() . '"></td>';
                            } else {
                                $table .= '<td ><input style="background-color: rgba(0,255,0,0.2);" '. $disabled.' type="text" class="form-control"
                                        id="idDataHoraLogin" style="text-align: center;"
                                        name="' . $strPosicao . '"
                                        value=""></td>';
                            }

                        }
                    }
                }
            }
        }
        $table.= '<tr><td>  </td>';
        foreach($objPlaca->getObjProtocolo()->getObjDivisao() as $divisao){
            $table.= '<td colspan="'.$cols.'" style=" background: rgba(242,242,242,0.4);border-left:1px solid #d2d2d2;border-right:1px solid #d2d2d2; ">'.$divisao->getNomeDivisao().'</td>';
        }
        $table.= '</tr>';
        $table .= '</table>';

    }


} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Análise RTqPCR");
Pagina::getInstance()->adicionar_css("precadastros");
if($liberar_popUp == 's') {
    Pagina::getInstance()->adicionar_javascript("popUp");
}

 /*  <!-- <script type="text/javascript">
        //$( document ).ready(function() {
        //  alert( "ready!" );
        setInterval(verificarAmostras, 3000);
        //});

        function verificarAmostras(){
            $.ajax({url: "<?=Sessao::getInstance()->assinar_link('controlador.php?action=verificar_amostras') ?>", success: function(result){
                    //alert(result);
                    document.getElementById("idResultadoRTQPCR").classList.add("verificarAmostras");
                    document.getElementById("idResultadoRTQPCR").innerHTML = 'Finalização do RTqPCR <a href="<?=Sessao::getInstance()->assinar_link('controlador.php?action=listar_analise_RTqPCR') ?>">aqui</a>';
                }});
        }
    </script> --> */

Pagina::getInstance()->adicionar_javascript("showtime");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('ANÁLISE RTqPCR',null,null, 'listar_analise_RTqPCR', 'LISTAR RTqPCR');
echo $alert;
Pagina::getInstance()->mostrar_excecoes();

/*
echo '<div class="conteudo_grande"   style="margin-top: 0px;">        
             <form method="POST">
             <a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=verificar_amostras').'">aqui</a>
             </form>
             </div>'; */

echo '<!-- Modal -->
    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="text-align: center">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                    Deseja realizar outra análise de RTqPCR? </h5>   
                </div>             
                <div class="modal-footer">
                    <!--<button type="button" class="btn btn-secondary" data-dismiss="modal"  >Close</button>-->
                    <button type="button"  class="btn btn-primary">
                    <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=analisar_RTqPCR') . '">Sim</a></button>
                </div>
            </div>
        </div>
    </div>';

echo '<div class="conteudo_grande"   style="margin-top: 0px;">        
             <form method="POST">
             
              <div class="col-md-12">
                    <input type="text" class="form-control" id="idDataHoraLogin" hidden style="text-align: center;"
                           name="dtHoraLoginInicio" required value="' . $_SESSION['DATA_LOGIN'] . '">
                </div>
             
             <div class="form-row">  
                <div class="col-md-6" >
                    <label>Selecione um equipamento de RTqPCR</label>
                    '.$select_equipamentos.'
                </div>
                 <div class="col-md-6" >
                    <label>Selecione uma placa</label>
                    '.$select_placa.'
                </div>
             </div>          ';

if(!isset($_GET['idRTqPCR']) && !isset($_GET['idPlaca']) && !isset($_GET['idEquipamento'])) {
    echo ' <div class="form-row">  
            <div class="col-md-12" >
                <button class="btn btn-primary" type="submit" name="btn_rtqpcr">SALVAR</button>
            </div>
       </div>';
}
echo '</form>
</div>';
if(isset($_GET['idRTqPCR']) && isset($_GET['idPlaca']) && isset($_GET['idEquipamento'])) {
    echo '
        <div class="conteudo_grande"   style="margin-top: 0px;"> 
            <div class="form-row">  
                <div class="col-md-12" style="text-align: center;">
           Previsão de término: <h4>' . $objRTqPcr->getHoraFinal() . '</h4>' .
        '. </div>
           </div>
           <div class="form-row">  
                <div class="col-md-12" >' .
        $table . '
                 </div>
             </div>
     </div>';
}

Pagina::getInstance()->fechar_corpo();