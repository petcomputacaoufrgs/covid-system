<?php

session_start();
try {
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once __DIR__ . '/../../classes/Capela/Capela.php';
    require_once __DIR__ . '/../../classes/Capela/CapelaRN.php';
    require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';

    require_once __DIR__ . '/../../classes/Amostra/Amostra.php';
    require_once __DIR__ . '/../../classes/Amostra/AmostraRN.php';

    require_once __DIR__ . '/../../classes/Tubo/Tubo.php';
    require_once __DIR__ . '/../../classes/Tubo/TuboRN.php';

    require_once __DIR__ . '/../../utils/Utils.php';
    require_once __DIR__ . '/../../utils/Alert.php';

    require_once __DIR__ . '/../../classes/Poco/Poco.php';
    require_once __DIR__ . '/../../classes/Poco/PocoRN.php';

    require_once __DIR__ . '/../../classes/Placa/Placa.php';
    require_once __DIR__ . '/../../classes/Placa/PlacaRN.php';

    require_once __DIR__ . '/../../classes/RelPocoPlaca/PocoPlaca.php';
    require_once __DIR__ . '/../../classes/RelPocoPlaca/PocoPlacaRN.php';

    require_once __DIR__ . '/../../classes/RelTuboPlaca/RelTuboPlaca.php';
    require_once __DIR__ . '/../../classes/RelTuboPlaca/RelTuboPlacaRN.php';

    require_once __DIR__ . '/../../classes/MixRTqPCR/MixRTqPCR.php';
    require_once __DIR__ . '/../../classes/MixRTqPCR/MixRTqPCR_RN.php';

    require_once __DIR__ . '/../../classes/SolicitacaoMontarPlaca/SolicitacaoMontarPlaca.php';
    require_once __DIR__ . '/../../classes/SolicitacaoMontarPlaca/SolicitacaoMontarPlacaRN.php';


    Sessao::getInstance()->validar();
    $utils = new Utils();

    date_default_timezone_set('America/Sao_Paulo');
    $_SESSION['DATA_LOGIN'] = date("Y-m-d H:i:s");

    /*
     * Objeto Amostra
     */
    $objAmostra = new Amostra();
    $objAmostraRN = new AmostraRN();

    /*
     * Objeto Tubo
     */
    $objTubo = new Tubo();
    $objTuboRN = new TuboRN();


    /*
    *  POÇO
    */
    $objPoco = new Poco();
    $objPocoRN = new PocoRN();

    /*
    *  PLACA
    */
    $objPlaca = new Placa();
    $objPlacaRN = new PlacaRN();

    /*
    *  RELACIONAMENTO POÇO + PLACA
    */
    $objPocoPlaca = new PocoPlaca();
    $objPocoPlacaRN = new PocoPlacaRN();

    /*
    *  RELACIONAMENTO TUBO + PLACA
    */
    $objRelTuboPlaca = new RelTuboPlaca();
    $objRelTuboPlacaRN = new RelTuboPlacaRN();

    /*
     * SOLICITAÇÃO DE MONTAGEM DA PLACA RTqPCR
     */
    $objSolMontarPlaca = new SolicitacaoMontarPlaca();
    $objSolMontarPlacaRN = new SolicitacaoMontarPlacaRN();

    $objMix = new MixRTqPCR();
    $objMixRN = new MixRTqPCR_RN();



    $objPlaca->setIdPlaca($_GET['idPlaca']);
    $objPlaca = $objPlacaRN->consultar_completo($objPlaca);

    $alert = '';
    $boolRemocaoTotal = false;
    $checked = '';
    //echo "<pre>";
    //print_r($objPlaca);
    //echo "</pre>";


    for($i=0; $i<count($objPlaca->getObjsTubos()); $i++) { //todos os tubos originais
        $tubo = $objPlaca->getObjsTubos()[$i];
        $amostra = $objPlaca->getObjsAmostras()[$i];
        $txtNomeCheck = 'checkbox_' . $amostra->getIdAmostra();
        $html .= '
             <div class="form-row"  >                                       
                <div class="input-group col-md-12 " >
                      <div class="input-group-prepend">                          
                         <div class="input-group-text" >
                              <input type="checkbox" ' . $checked . '  name="'.$txtNomeCheck.'" 
                              style="width: 50px;" aria-label="Checkbox for following text input">
                         </div>
                      </div>
                      <input type="text" disabled  class="form-control" value="Amostra ' .$amostra->getNickname() .' do tipo '. TuboRN::mostrarDescricaoTipoTubo($amostra->getObjTubo()->getTipo())  .'">
                </div>
             </div>';

        if(isset($_POST['btn_remover']) ){
//            echo $_POST[$txtNomeCheck];

            if($_POST[$txtNomeCheck] == 'on'){
                //vai remover essa amostra
                $arr_amostras_removidas[] = $amostra;
                $arr_tubos_removidos[] = $tubo;


            }
        }

    }

    if(isset($_POST['btn_remover']) ){
        //else{
        //foreach ($arr_amostras_removidas as $amostraRemovida){
        $objPlacaAux = $objPlaca;

        $objPlacaAux->setObjsAmostras($arr_amostras_removidas);
        $objPlacaAux->setObjsTubos($arr_tubos_removidos);
        /*echo "<pre>";
        print_r($objPlacaAux->getObjsTubos());
        echo "</pre>";*/
        $objPlacaRN->remover_amostras($objPlaca,$boolRemocaoTotal);

        if(count($arr_amostras_removidas) == count($objPlaca->getObjsAmostras())){ //caso em que todas serão removidas
            $boolRemocaoTotal = true;
            $objMix->setIdMixPlaca(intval($_GET['idMix']));
            $objMixRN->remover($objMix);
            $objPlacaRN->remover($objPlaca);
            $objSolMontarPlaca->setIdSolicitacaoMontarPlaca(intval($_GET['idSolicitacao']));
            $objSolMontarPlacaRN->remover($objSolMontarPlaca);
        }


        header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=mix_placa_RTqPCR&idSolicitacao=' . $_GET['idSolicitacao'].'&idPlaca='.$_GET['idPlaca']));
        die();
       // }
    }

} catch (Throwable $ex) {
    //die($ex);
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Montar grupo");
Pagina::getInstance()->adicionar_css("precadastros");
if($boolRemocaoTotal) {
    Pagina::getInstance()->adicionar_javascript("popUp");
}
Pagina::getInstance()->adicionar_javascript("tabelaDinamica");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar("REMOVER AMOSTRAS DA PLACA",'listar_montagem_placa_RTqPCR','LISTAR MONTAGEM DA PLACA', "listar_mix_placa_RTqPCR", 'LISTAR MIX DA PLACA');
Pagina::getInstance()->mostrar_excecoes();
echo $alert;


echo '<!-- Modal -->
    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="text-align: center">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                    Tem certeza? </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Serão removidas todas as amostras da placa. Sendo assim, a solicitação será removida assim como a placa de poços.
                    <br> Após confirmar <strong>não será possível voltar atrás</strong>.
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"  >Close</button>
                    <button type="button"  class="btn btn-primary">
                    <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_solicitacao_montagem_placa_RTqPCR&idSolicitacao=' . $_GET['idSolicitacao'].'&idSituacao=1') . '">Tenho certeza</a></button>
                </div>
            </div>
        </div>
    </div>';

echo '
        <div class="conteudo_grande" style="margin-top: -10px;">
            <form method="POST" name="inicio">
            <div class="form-row" >

                <div class="col-md-12">
                    <input type="text" class="form-control" id="idDataHoraLogin" hidden style="text-align: center;"
                           name="dtHoraLoginInicio" required value="' . $_SESSION['DATA_LOGIN'] . '">
                </div>
            </div>';

    echo '<div class="form-row" >
            <div class="col-md-12">
                <label for="label_perfisAmostras">Selecione as amostras que vão sair da placa: </label>'
                . $html .
            '</div>
         </div>';

        echo '<div class="form-row" >
                <div class="col-md-12" >
                    <button class="btn btn-primary" style="margin-left:0px;margin-top: 31px;width: 40%;margin-left: 30%;" type="submit"  name="btn_remover">REMOVER</button>
                </div>
             </div>';

echo '    </form>
            </div>';

echo '<!-- Modal -->
    <div class="modal fade" id="exampleModalCenter3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="text-align: center">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                    Tem certeza que dejesa deseja cancelar? </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                Ao cancelar, nenhum dado será salvo
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"  >Close</button>
                    <button type="button"  class="btn btn-primary">
                    <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_solicitacao_montagem_placa_RTqPCR') . '">Tenho certeza</a></button>
                </div>
            </div>
        </div>
    </div>';

Pagina::getInstance()->fechar_corpo();