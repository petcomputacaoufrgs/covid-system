<?php
session_start();
try{
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';

    require_once  __DIR__ . '/../../classes/Calculo/Calculo.php';
    require_once  __DIR__ . '/../../classes/Calculo/CalculoRN.php';
    require_once  __DIR__ . '/../../classes/Calculo/CalculoINT.php';

    require_once  __DIR__ . '/../../classes/Protocolo/Protocolo.php';
    require_once  __DIR__ . '/../../classes/Protocolo/ProtocoloRN.php';
    require_once  __DIR__ . '/../../classes/Protocolo/ProtocoloINT.php';

    require_once __DIR__ . '/../../classes/Operador/Operador.php';
    require_once __DIR__ . '/../../classes/Operador/OperadorRN.php';

    require_once __DIR__ . '/../../classes/RelMixOperador/RelMixOperador.php';
    require_once __DIR__ . '/../../classes/RelMixOperador/RelMixOperadorRN.php';

    require_once __DIR__ . '/../../classes/MixRTqPCR/MixRTqPCR.php';
    require_once __DIR__ . '/../../classes/MixRTqPCR/MixRTqPCR_RN.php';

    require_once __DIR__ . '/../../classes/Poco/Poco.php';
    require_once __DIR__ . '/../../classes/Poco/PocoRN.php';

    require_once __DIR__ . '/../../classes/Placa/Placa.php';
    require_once __DIR__ . '/../../classes/Placa/PlacaRN.php';

    require_once __DIR__ . '/../../classes/RelPocoPlaca/PocoPlaca.php';
    require_once __DIR__ . '/../../classes/RelPocoPlaca/PocoPlacaRN.php';

    require_once __DIR__ . '/../../classes/RelTuboPlaca/RelTuboPlaca.php';
    require_once __DIR__ . '/../../classes/RelTuboPlaca/RelTuboPlacaRN.php';

    Sessao::getInstance()->validar();

    $objOperador = new Operador();
    $objOperadorRN = new OperadorRN();

    $objCalculo = new Calculo();
    $objCalculoRN = new CalculoRN();

    $objRelMixOperador = new RelMixOperador();
    $objRelMixOperadorRN = new RelMixOperadorRN();

    $objMix = new MixRTqPCR();
    $objMixRN = new MixRTqPCR_RN();

    $objPoco = new Poco();
    $objPocoRN = new PocoRN();

    $objPlaca = new Placa();
    $objPlacaRN = new PlacaRN();

    $objPocoPlaca = new PocoPlaca();
    $objPocoPlacaRN = new PocoPlacaRN();

    $objRelTuboPlaca = new RelTuboPlaca();
    $objRelTuboPlacaRN = new RelTuboPlacaRN();

    $objMix->setIdMixPlaca($_GET['idMix']);
    $objMix = $objMixRN->consultar($objMix);

    //ver se tem algum relMixOperador
    $objRelMixOperador->setIdMixFk($_GET['idMix']);
    $arr_relacionamentos = $objRelMixOperadorRN->listar_completo($objRelMixOperador);

    $objPlaca->setIdPlaca($_GET['idPlaca']);
    $objPlaca = $objPlacaRN->consultar_completo($objPlaca);
    $objProtocolo = $objPlaca->getObjProtocolo();

    $objCalculo->setIdProtocoloFk($objProtocolo->getIdProtocolo());
    $arr_calculos = $objCalculoRN->listar_completo($objCalculo);

    /*
    echo "<pre>";
    print_r($arr_calculos);
    echo "</pre>";
    */



    foreach ($arr_calculos as $calculo){
        foreach ($calculo->getObjOperador() as $operador) {
            foreach ($arr_relacionamentos as $relacionamento) {
                if($relacionamento->getIdOperadorFk() == $operador->getIdOperador()){
                    $operador->setValor($relacionamento->getValor());
                }
            }
        }
    }
    /*
    echo "####";
    echo "<pre>";
    print_r($arr_calculos);
    echo "</pre>";
    */



    $objRelTuboPlaca->setIdPlacaFk($_GET['idPlaca']);
    $arr = $objRelTuboPlacaRN->listar($objRelTuboPlaca);
    $numAmostras = count($arr);


    if ($objProtocolo->getCaractere() == ProtocoloRN::$TP_NEWGENE) {
        $tabelaE = '';
        $tabelaRdRp = '';
        $tabelaControle = '';

        ProtocoloINT::tabela_E_protocolo_newgene($tabelaE, $numAmostras, $arr_calculos[0]->getObjOperador());
        ProtocoloINT::tabela_RdRp_protocolo_newgene($tabelaRdRp, $numAmostras, $arr_calculos[1]->getObjOperador());
        ProtocoloINT::tabela_Controle_protocolo_newgene($tabelaControle, $numAmostras, $arr_calculos[2]->getObjOperador());

        $form = '<form method="post">
                        <div class="form-row">
                             <div class="col-md-4">';
        $form .= $tabelaE;
        $form .= '</div>
                              <div class="col-md-4">';
        $form .= $tabelaRdRp;
        $form .= '</div>
                              <div class="col-md-4">';
        $form .= $tabelaControle;
        $form .= '        </div>
                          </div>
                          <div class="form-row">
                              <div class="col-md-12">
                                    <button class="btn btn-primary" type="submit" '.$disabled.' style="width: 40%;margin-left: 30%;" name="btn_salvar_tabelas_operadores">EDITAR</button>
                              </div>
                          </div>  
                    </form>';

    }
    else if ($objProtocolo->getCaractere() == ProtocoloRN::$TP_LACEN_IBMP) {
        $tabelaLacen = '';

        ProtocoloINT::tabela1_protocolo_LACEN($tabelaLacen, $numAmostras, $arr_calculos[0]->getObjOperador());

        $form = '<form method="post">
                        <div class="form-row">
                             <div class="col-md-12">';
        $form .= $tabelaLacen;
        $form .= '</div>
                          </div>
                          <div class="form-row">
                              <div class="col-md-12">
                                    <button class="btn btn-primary" type="submit" '.$disabled.'  style="width: 40%;margin-left: 30%;" name="btn_salvar_tabelas_operadores">EDITAR</button>
                              </div>
                          </div>  
                    </form>';
    }
    else if ($objProtocolo->getCaractere() == ProtocoloRN::$TP_AGPATH) {
        $tabelaN1 = '';
        $tabelaN2 = '';
        $tabelaControle = '';
        ProtocoloINT::tabela_N1_protocolo_agpath_CDC($tabelaN1, $numAmostras, $arr_calculos[0]->getObjOperador());
        ProtocoloINT::tabela_N2_protocolo_agpath_CDC($tabelaN2, $numAmostras, $arr_calculos[1]->getObjOperador());
        ProtocoloINT::tabela_Controle_protocolo_agpath_CDC($tabelaControle, $numAmostras, $arr_calculos[2]->getObjOperador());
        $form = '<form method="post">
                        <div class="form-row">
                             <div class="col-md-4">';
        $form .= $tabelaN1;
        $form .= '</div>
                              <div class="col-md-4">';
        $form .= $tabelaN2;
        $form .= '</div>
                              <div class="col-md-4">';
        $form .= $tabelaControle;
        $form .= '        </div>
                          </div>
                          <div class="form-row">
                              <div class="col-md-12">
                                    <button class="btn btn-primary" type="submit" '.$disabled.'  style="width: 40%;margin-left: 30%;" name="btn_salvar_tabelas_operadores">EDITAR</button>
                              </div>
                          </div>  
                    </form>';

    }
    else if ($objProtocolo->getCaractere() == ProtocoloRN::$TP_AGPATH_CHARITE) {
        $tabelaE = '';
        $tabelaRdRp = '';
        $tabelaControle = '';

        ProtocoloINT::tabela_E_protocolo_agpath_charite($tabelaE, $numAmostras, $arr_calculos[0]->getObjOperador());
        ProtocoloINT::tabela_RdRp_protocolo_agpath_charite($tabelaRdRp, $numAmostras, $arr_calculos[1]->getObjOperador());
        ProtocoloINT::tabela_Controle_protocolo_agpath_charite($tabelaControle, $numAmostras, $arr_calculos[2]->getObjOperador());
        $form = '<form method="post">
                        <div class="form-row">
                             <div class="col-md-4">';
        $form .= $tabelaE;
        $form .= '</div>
                              <div class="col-md-4">';
        $form .= $tabelaRdRp;
        $form .= '</div>
                              <div class="col-md-4">';
        $form .= $tabelaControle;
        $form .= '        </div>
                          </div>
                          <div class="form-row">
                              <div class="col-md-12">
                                    <button class="btn btn-primary" type="submit" '.$disabled.'  style="width: 40%;margin-left: 30%;" name="btn_salvar_tabelas_operadores">EDITAR</button>
                              </div>
                          </div>  
                    </form>';
    }

    if(isset($_POST['btn_salvar_tabelas_operadores'])){
        $tam = count($arr_calculos[0]->getObjOperador());
        $arr_rel_mix_operador = array();
        $divisoesPlaca = count($arr_calculos);

        for($j=0; $j <$divisoesPlaca; $j++) {
            for ($i = 0; $i < $tam; $i++) {
                $objRelMixOperador = new RelMixOperador();
                $objRelMixOperador->setIdOperadorFk($arr_calculos[$j]->getObjOperador()[$i]->getIdOperador());
                $objRelMixOperador->setIdMixFk($objMix->getIdMixPlaca());
                $arrRel = $objRelMixOperadorRN->listar($objRelMixOperador);
                if(count($arrRel) > 0) {
                    $objRelMixOperador = $arrRel[0];
                    $str = strval($_POST['txtOp' . $i . '_' . $arr_calculos[$j]->getObjOperador()[$i]->getIdOperador()]);
                    $objRelMixOperador->setValor(strval($_POST['txtOp' . $i . '_' . $arr_calculos[$j]->getObjOperador()[$i]->getIdOperador()]));
                    //$arr_rel_mix_operador[] = $objRelMixOperador;
                    $objRelMixOperador = $objRelMixOperadorRN->alterar($objRelMixOperador);
                }else{
                    $objRelMixOperador->setValor(strval($_POST['txtOp' . $i . '_' . $arr_calculos[$j]->getObjOperador()[$i]->getIdOperador()]));
                    //$arr_rel_mix_operador[] = $objRelMixOperador;
                    $objRelMixOperador = $objRelMixOperadorRN->cadastrar($objRelMixOperador);
                }
                $arr_calculos[$j]->getObjOperador()[$i]->setValor($_POST['txtOp' . $i . '_' . $arr_calculos[$j]->getObjOperador()[$i]->getIdOperador()]);
            }

        }

        if ($objProtocolo->getCaractere() == ProtocoloRN::$TP_NEWGENE) {
            $tabelaE = '';
            $tabelaRdRp = '';
            $tabelaControle = '';

            ProtocoloINT::tabela_E_protocolo_newgene($tabelaE, $numAmostras, $arr_calculos[0]->getObjOperador());
            ProtocoloINT::tabela_RdRp_protocolo_newgene($tabelaRdRp, $numAmostras, $arr_calculos[1]->getObjOperador());
            ProtocoloINT::tabela_Controle_protocolo_newgene($tabelaControle, $numAmostras, $arr_calculos[2]->getObjOperador());

            $form = '<form method="post">
                        <div class="form-row">
                             <div class="col-md-4">';
            $form .= $tabelaE;
            $form .= '</div>
                              <div class="col-md-4">';
            $form .= $tabelaRdRp;
            $form .= '</div>
                              <div class="col-md-4">';
            $form .= $tabelaControle;
            $form .= '        </div>
                          </div>
                          <div class="form-row">
                              <div class="col-md-12">
                                    <button class="btn btn-primary" type="submit"  style="width: 40%;margin-left: 30%;" name="btn_salvar_tabelas_operadores">EDITAR</button>
                              </div>
                          </div>  
                    </form>';

        }
        else if ($objProtocolo->getCaractere() == ProtocoloRN::$TP_LACEN_IBMP) {
            $tabelaLacen = '';

            ProtocoloINT::tabela1_protocolo_LACEN($tabelaLacen, $numAmostras, $arr_calculos[0]->getObjOperador());

            $form = '<form method="post">
                        <div class="form-row">
                             <div class="col-md-12">';
            $form .= $tabelaLacen;
            $form .= '</div>
                          </div>
                          <div class="form-row">
                              <div class="col-md-12">
                                    <button class="btn btn-primary" type="submit"  style="width: 40%;margin-left: 30%;" name="btn_salvar_tabelas_operadores">EDITAR</button>
                              </div>
                          </div>  
                    </form>';
        }
        else if ($objProtocolo->getCaractere() == ProtocoloRN::$TP_AGPATH) {
            $tabelaN1 = '';
            $tabelaN2 = '';
            $tabelaControle = '';
            ProtocoloINT::tabela_N1_protocolo_agpath_CDC($tabelaN1, $numAmostras, $arr_calculos[0]->getObjOperador());
            ProtocoloINT::tabela_N2_protocolo_agpath_CDC($tabelaN2, $numAmostras, $arr_calculos[1]->getObjOperador());
            ProtocoloINT::tabela_Controle_protocolo_agpath_CDC($tabelaControle, $numAmostras, $arr_calculos[2]->getObjOperador());
            $form = '<form method="post">
                        <div class="form-row">
                             <div class="col-md-4">';
            $form .= $tabelaN1;
            $form .= '</div>
                              <div class="col-md-4">';
            $form .= $tabelaN2;
            $form .= '</div>
                              <div class="col-md-4">';
            $form .= $tabelaControle;
            $form .= '        </div>
                          </div>
                          <div class="form-row">
                              <div class="col-md-12">
                                    <button class="btn btn-primary" type="submit"  style="width: 40%;margin-left: 30%;" name="btn_salvar_tabelas_operadores">EDITAR</button>
                              </div>
                          </div>  
                    </form>';

        }
        else if ($objProtocolo->getCaractere() == ProtocoloRN::$TP_AGPATH_CHARITE) {
            $tabelaE = '';
            $tabelaRdRp = '';
            $tabelaControle = '';

            ProtocoloINT::tabela_E_protocolo_agpath_charite($tabelaE, $numAmostras, $arr_calculos[0]->getObjOperador());
            ProtocoloINT::tabela_RdRp_protocolo_agpath_charite($tabelaRdRp, $numAmostras, $arr_calculos[1]->getObjOperador());
            ProtocoloINT::tabela_Controle_protocolo_agpath_charite($tabelaControle, $numAmostras, $arr_calculos[2]->getObjOperador());
            $form = '<form method="post">
                        <div class="form-row">
                             <div class="col-md-4">';
            $form .= $tabelaE;
            $form .= '</div>
                              <div class="col-md-4">';
            $form .= $tabelaRdRp;
            $form .= '</div>
                              <div class="col-md-4">';
            $form .= $tabelaControle;
            $form .= '        </div>
                          </div>
                          <div class="form-row">
                              <div class="col-md-12">
                                    <button class="btn btn-primary" type="submit"  style="width: 40%;margin-left: 30%;" name="btn_salvar_tabelas_operadores">EDITAR</button>
                              </div>
                          </div>  
                    </form>';
        }

        //print_r($arr_rel_mix_operador);
    }


} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Editar Tabelas");
Pagina::getInstance()->adicionar_css("precadastros");
if($liberar_popUp == 's') {
    Pagina::getInstance()->adicionar_javascript("popUp");
}
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('EDITAR TABELAS PROTOCOLOS',null,null, 'listar_mix_placa_RTqPCR', 'LISTAR MIX PLACA');
echo $alert;
Pagina::getInstance()->mostrar_excecoes();

echo    '<div class="conteudo_grande"   style="margin-top: 0px;">';
echo        $form;
echo    '</div>';

Pagina::getInstance()->fechar_corpo();