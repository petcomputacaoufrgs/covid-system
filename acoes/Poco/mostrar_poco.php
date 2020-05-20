<?php
session_start();
try{

    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';

    require_once __DIR__ . '/../../classes/Poco/Poco.php';
    require_once __DIR__ . '/../../classes/Poco/PocoRN.php';

    require_once __DIR__ . '/../../classes/Placa/Placa.php';
    require_once __DIR__ . '/../../classes/Placa/PlacaRN.php';

    require_once __DIR__ . '/../../classes/RelPocoPlaca/PocoPlaca.php';
    require_once __DIR__ . '/../../classes/RelPocoPlaca/PocoPlacaRN.php';

    require_once __DIR__ . '/../../classes/DivisaoProtocolo/DivisaoProtocolo.php';
    require_once __DIR__ . '/../../classes/DivisaoProtocolo/DivisaoProtocoloRN.php';

    require_once __DIR__ . '/../../classes/RelTuboPlaca/RelTuboPlaca.php';
    require_once __DIR__ . '/../../classes/RelTuboPlaca/RelTuboPlacaRN.php';



    Sessao::getInstance()->validar();

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
    *  PLACA
    */
    $objPlaca = new Placa();
    $objPlacaRN = new PlacaRN();

    /*
    *  POÇO + PLACA
    */
    $objPocoPlaca = new PocoPlaca();
    $objPocoPlacaRN = new PocoPlacaRN();

    /*
    *  RELACIONAMENTO TUBO + PLACA
    */
    $objRelTuboPlaca = new RelTuboPlaca();
    $objRelTuboPlacaRN = new RelTuboPlacaRN();

    $select_placas = '';

    InterfacePagina::montar_select_placas($select_placas, $objPlaca, $objPlacaRN, '', '');

    /*if(isset($_POST['btn_associar'])) {

        $objPlaca->setIdPlaca($_POST['sel_placas']);
        $objPlaca = $objPlacaRN->consultar($objPlaca);
        $objPoco->setObjPlaca($objPlaca);
        //$poco = $objPocoRN->cadastrar($objPoco,'s');
        $alert .= Alert::alert_success("Poço cadastrado com sucesso");

        $objPocoPlaca->setIdPlacaFk(35);

        $objPlaca->setIdPlaca(35);
        $objPlaca = $objPlacaRN->consultar($objPlaca);*/


    if (isset($_GET['idPlaca'])) {
        $objPlaca->setIdPlaca($_GET['idPlaca']);
        $objPlaca = $objPlacaRN->consultar_completo($objPlaca); // busca tudo em 1 consulta
        /*echo '<pre>';
        print_r($objPlaca);
        echo '</pre>';*/

        //caso aumentem, tem que aumentar aqui
        if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 1) {
            $incremento_na_placa_original = 0;
        } else if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 2) {
            $incremento_na_placa_original = 6;
        } else if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 3) {
            $incremento_na_placa_original = 4;
        } else if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 4) {
            $incremento_na_placa_original = 3;
        }


        $table .= '<table class="table table-responsive table-hover">';
        $quantidade = 8;
        $letras = range('A', chr(ord('A') + $quantidade));

        $cols = (12 / count($objPlaca->getObjProtocolo()->getObjDivisao()));
        $qnt = count($objPlaca->getObjProtocolo()->getObjDivisao());
        $colocarTubos = count($objPlaca->getObjProtocolo()->getObjDivisao());
        $quantidadeTubos = count($objPlaca->getObjsTubos());
        //echo "tubos: " . $quantidadeTubos;

        $divs = 0;

        $testeTubos = 0;
        $tubo_placa = 0;
        /*for ($j = -1; $j <= 8; $j++) {
            $table .= '<tr>';
            for ($i = 0; $i <= 12; $i++) {

                if($j == -1 && $i ==0){
                    $table .= '<td> </td>';
                }
                if($j == -1 && $i > 0){
                    $table .= '<td>'.($i).'</td>';
                }
                if($i == 0 && $j > -1 && $j <= 7){
                    $table .= '<td>'.$letras[$j].'</td>';
                }

                if($j > -1 && $i > 0 && $j<= 7 && $i <= 12) {

                    foreach ($objPlaca->getObjsPocosPlacas() as $pocosPlaca) {
                        $poco = $pocosPlaca->getObjPoco();
                        if($poco->getLinha() == $letras[$j] && $poco->getColuna() == $i){
                            if ($poco->getSituacao() == PocoRN::$STA_LIBERADO) {
                                $background = ' style="background: rgba(0,255,0,0.2);"';
                            } else {
                                $background = ' style="background: rgba(255,0,0,0.2);"';
                            }


                            if($i == $incremento_na_placa){
                                $table .= '<td><input type="text" ' . $background . ' class="form-control"  disabled style="text-align: center;"
                               name="poco' . $j . $i . '" value="INCREMENTO"></td>';
                                $incremento_na_placa = ($incremento_na_placa-1)+($incremento_na_placa-1);
                            }


                            if($objPlaca->getObjsTubos()[$testeTubos]!= null){
                                if($objPlaca->getObjsTubos()[$testeTubos]->getIdTuboFk() != null){
                                    $table .= '<td><input type="text" ' . $background . ' class="form-control"  disabled style="text-align: center;"
                               name="poco' . $j . $i . '" value="' . $objPlaca->getObjsTubos()[$testeTubos]->getIdTuboFk() . '"></td>';

                                }
                            }else{

                                $table .= '<td><input type="text" ' . $background . ' class="form-control"  disabled style="text-align: center;"
                               name="poco' . $j . $i . '" value="' . $letras[$j] . $i . '"></td>';
                            }





                        }
                    }

                    //if($objPlaca->getObjProtocolo()->getNumDivisoes() == 3){}
                }


                if($i== 0 && $j>7){
                    $table .= '<td ></td>';
                }
                if($qnt > 0) {
                    if ($j > 7  && $i>0 && $i <= 12) {
                        $table .= '<td colspan="' . $cols . '" style="border:1px solid black;" >' . $objPlaca->getObjProtocolo()->getObjDivisao()[$divs]->getNomeDivisao() . '</td>';
                        $qnt--;
                        $divs++;
                    }
                }

            }
            $table .= '</tr>';
        }
        $table .= '</table>';*/
        $contador_extras = 0;
        $posicoes_array = 0;
        $cont = 1;
        for ($j = 1; $j <= 12; $j++) {
            for ($i = 1; $i <= 8; $i++) {
                if ($objPlaca->getObjsAmostras()[$tubo_placa] != null) {
                    //$posicao_tubo[$posicoes_array] = array('valor'=>$objPlaca->getObjsTubos()[$tubo_placa]->getIdTuboFk(),'x' => $i, 'y' => $j);
                    $posicao_tubo[$i][$j] = $objPlaca->getObjsAmostras()[$tubo_placa]->getNickname();

                    if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 3) {
                        $posicao_tubo[$i][$j + $incremento_na_placa_original] = $objPlaca->getObjsAmostras()[$tubo_placa]->getNickname();
                        $posicao_tubo[$i][$j + (2 * $incremento_na_placa_original)] = $objPlaca->getObjsAmostras()[$tubo_placa]->getNickname();
                    }
                } else {

                    if ($cont == 1) {
                        //$posicao_tubo[$posicoes_array] = array('valor'=>'C+','x' => $i, 'y' => $j);
                        $posicao_tubo[$i][$j] = 'C+';
                        if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 3) {
                            $posicao_tubo[$i][$j + $incremento_na_placa_original] = 'C+';
                            $posicao_tubo[$i][$j + (2 * $incremento_na_placa_original)] = 'C+';
                        }
                    }
                    if ($cont == 2) {
                        //$posicao_tubo[$posicoes_array] = array('valor'=>'C-','x' => $i, 'y' => $j);
                        $posicao_tubo[$i][$j] = 'C-';
                        if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 3) {
                            $posicao_tubo[$i][$j + $incremento_na_placa_original] = 'C-';
                            $posicao_tubo[$i][$j + (2 * $incremento_na_placa_original)] = 'C-';
                        }
                    }
                    if ($cont == 3 || $cont == 4) {
                        //$posicao_tubo[$posicoes_array] = array('valor'=>'BR','x' => $i, 'y' => $j);
                        $posicao_tubo[$i][$j] = 'BR';
                        if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 3) {
                            $posicao_tubo[$i][$j + $incremento_na_placa_original] = 'BR';
                            $posicao_tubo[$i][$j + (2 * $incremento_na_placa_original)] = 'BR';
                        }
                    }

                    if ($cont > 4) {
                        break;
                    }
                    $cont++;
                }
                $tubo_placa++;
                $posicoes_array++;
            }
        }


        for ($i = 0; $i <= 8; $i++) {
            $table .= '<tr>';

            for ($j = 0; $j <= 12; $j++) {

                if ($i == 0 && $j == 0) { //canto superior esquerdo - quadrado vazio
                    $table .= '<td> - </td>';
                } else if ($i == 0 && $j > 0) { //linha 0 - local para se colocar os números
                    $table .= '<td><strong>' . $j . '</strong></td>';
                } else if ($j == 0 && $i > 0) { //linha 0 - local para se colocar os números
                    $table .= '<td><strong>' . $letras[$i - 1] . '</strong></td>';
                } else {

                    if ($posicao_tubo[$i][$j] != '') {
                        if ($posicao_tubo[$i][$j] == 'BR' || $posicao_tubo[$i][$j] == 'C+' || $posicao_tubo[$i][$j] == 'C-') {
                            $style = ' style="background-color: rgba(255,255,0,0.2);"';
                        } else {
                            $style = ' style="background-color: rgba(255,0,0,0.2);" ';
                        }

                        $table .= '<td><input ' . $style . ' type="text" class="form-control" id="idDataHoraLogin" disabled style="text-align: center;"
                                    name="input_' . $i . '_' . $j . '" value=" ' . $posicao_tubo[$i][$j] . '"></td>';
                    } else {
                        $table .= '<td><input style="background-color: rgba(0,255,0,0.2);" type="text" class="form-control" id="idDataHoraLogin" disabled style="text-align: center;"
                                    name="input_' . $i . '_' . $j . '" value="  "></td>';

                    }
                }

            }

            $table .= '</tr>';
        }
        $table .= '</table>';

    }




    /*
    if(!isset($_GET['idCaixa'])){

        $input_table .= '
            <form METHOD="post">
            <div class="form-row">
                <div class="col-md-10 mb-3">
                    <label for="label_numPortas">Informe o número da caixa para procura</label>
                    <input type="number" class="form-control" id="idCodigo" placeholder="código"
                           onblur="" name="numCaixa" value="">
                </div>
                 <div class="col-md-2 mb-3">
                    <button class="btn btn-primary" type="submit" style="margin-top: 33px; margin-left: 0px; width: 100%;" name="procurar_caixa"> CAIXA</button>
                </div>
            </div>';

        if(isset($_POST['procurar_caixa'])){

            $objCaixa->setIdCaixa($_POST['numCaixa']);
            $objCaixa = $objCaixaRN->consultar($objCaixa);

            $objColuna->setIdColuna($objCaixa->getIdColuna_fk());
            $objColuna = $objColunaRN->consultar($objColuna);

            $objPrateleira->setIdPrateleira($objColuna->getIdPrateleira_fk());
            $objPrateleira = $objPrateleiraRN->consultar($objPrateleira);

            $objPorta->setIdPorta($objPrateleira->getIdPorta_fk());
            $objPorta = $objPortaRN->consultar($objPorta);

            $objLocalArmazenamento->setIdLocalArmazenamento($objPorta->getIdLocalArmazenamentoFk());
            $objLocalArmazenamento = $objLocalArmazenamentoRN->consultar($objLocalArmazenamento);

            header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_caixa&idCaixa='.$objCaixa->getIdCaixa().'&idLocalArmazenamento='.$objLocalArmazenamento->getIdLocalArmazenamento()));
            die();
        }

    }else {
        //ECHO 'AQUI';

        $quantidade = 10;
        $letras = range('A', chr(ord('A') + $quantidade));

        $table .= '<div class="conteudo_grande"  style="margin-top: -20px;width: 100%;">
            <form METHOD="post">
            <div class="form-row">
                <div class="col-md-10 mb-3">
                    <label for="label_numPortas">Informe o código da amostra que deseja retirar</label>
                    <input type="text" class="form-control" id="idCodigo" placeholder="código"
                           onblur="" name="codigoAmostra" value="">
                </div>
                 <div class="col-md-2 mb-3">
                    <button class="btn btn-primary" type="submit" style="margin-top: 33px; margin-left: 0px; width: 100%;" name="procurar_amostra">PROCURAR</button>
                </div>
            </div>
            </form>
            <form METHOD="post">

            <table class="table table-hover">
             <table>
             <tr>   ';
        for ($i = 0; $i <= $objCaixa->getQntLinhas(); $i++) {
            if ($i == 0) {
                $table .= '<td><input type="text" class="form-control" id="idDataHoraLogin" disabled style="text-align: center;"
                                   name="input_' . $i . '" value=""></td>';
            } else {
                $table .= '<td><input type="text" class="form-control" id="idDataHoraLogin" disabled style="text-align: center;"
                                   name="input_' . $i . '" value=" ' . $i . '"></td>';
            }
        }
        $table .= '<tr>';
        for ($i = 1; $i <= $objCaixa->getQntLinhas(); $i++) {
            $table .= '<td><input type="text" class="form-control" id="idDataHoraLogin" disabled style="text-align: center;"
                       name="input_' . $i . '_' . $j . '" value=" ' . $letras[($i - 1)] . '"></td>';
            for ($j = 1; $j <= $objCaixa->getQntColunas(); $j++) {
                $objPosicao = new Posicao();
                $objPosicao->setLinha(strval($i));
                $objPosicao->setColuna(strval($j));
                $objPosicao->setIdCaixa_fk($_GET['idCaixa']);

                $posicao = $objPosicaoRN->listar($objPosicao);

                if($posicao[0]->getSituacaoPosicao() == PosicaoRN::$TSP_OCUPADA) {
                    $objTubo->setIdTubo($posicao[0]->getIdTuboFk());
                    $objTubo = $objTuboRN->consultar($objTubo);

                    $objAmostra->setIdAmostra($objTubo->getIdAmostra_fk());
                    $objAmostra = $objAmostraRN->consultar($objAmostra);
                }

                if ($posicao[0]->getSituacaoPosicao() == PosicaoRN::$TSP_LIBERADA) {
                    $table .= '<td><input style="background-color: rgba(0,255,0,0.2);text-align:center;" type="text" class="form-control" id="idDataHoraLogin"  style="text-align: center;"
                             placeholder="liberado"  name="input_' . $i . '_' . $j . '" value=""></td>';
                } else {
                    $table .= '<td><input style="background-color: rgba(255,0,0,0.2);text-align: center;" type="text" class="form-control" id="idDataHoraLogin"  style="text-align: center;"
                              placeholder="ocupado"  disabled     name="input_' . $i . '_' . $j . '" value="'.$objAmostra->getCodigoAmostra().'"></td>';
                }


            }
            $table .= '</tr>';
        }
        $table .= '</table>
                <div class="form-row">

                 <div class="col-md-12 mb-3">
                    <button class="btn btn-primary" type="submit" style="margin-top: 33px; margin-left: 0px; width: 100%;" name="inserir_amostra">INSERIR</button>
                </div>
            </div>

            </form>
            </div>';

        if(isset($_POST['inserir_amostra'])){
            for($i=1; $i<=$objCaixa->getQntLinhas(); $i++) {
                for ($j = 1; $j <= $objCaixa->getQntColunas(); $j++) {
                    if(isset($_POST['input_' . $i . '_' . $j])){
                        $objPosicao = new Posicao();
                        $objPosicao->setLinha(strval($j));
                        $objPosicao->setColuna(strval($i));
                        $objPosicao->setIdCaixa_fk($_GET['idCaixa']);

                        $objPosicao->setIdTuboFk();
                        ECHO $_POST['input_' . $i . '_' . $j];
                    }
                }
            }

        }


        if($_POST['procurar_amostra']){
            for($i=1; $i<=$objCaixa->getQntLinhas(); $i++){
                for($j=1; $j<=$objCaixa->getQntColunas(); $j++){
                    $objPosicao = new Posicao();
                    $objPosicao->setLinha(strval($j));
                    $objPosicao->setColuna(strval($i));
                    $objPosicao->setIdCaixa_fk($_GET['idCaixa']);
                    $posicao = $objPosicaoRN->listar($objPosicao);

                    $id = $id = substr($_POST['codigoAmostra'], 1);
                    $objAmostra->setIdAmostra($id);
                    $objAmostra = $objAmostraRN->consultar($objAmostra);

                    $objTubo->setIdAmostra_fk($objAmostra->getIdAmostra());
                    $arr_tubos = $objTuboRN->listar($objTubo);

                    foreach ($arr_tubos as $tubo){
                        $objInfosTubo->setIdTubo_fk($tubo->getIdTubo());
                        $arr_infos_tubo = $objInfosTuboRN->listar($objInfosTubo);
                        foreach ($arr_infos_tubo as $info_tubo){
                            if($info_tubo->getIdPosicao_fk() == $posicao[0]->getIdPosicao()){

                            }
                        }

                    }
                    // if ($posicao[0]->getSituacaoPosicao == PosicaoRN::$TSP_OCUPADA && $posicao->getId
                }
            }
        }*/

} catch (Throwable $ex) {
    Pagina::getInstance()->mostrar_excecoes($ex);
}


Pagina::abrir_head("Mostrar poço");
Pagina::getInstance()->adicionar_css("precadastros");
if($liberar_popUp == 's') {
    Pagina::getInstance()->adicionar_javascript("popUp");
}
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('Placa '.$_GET['idPlaca'].' e seus poços',null,null, null, null);
echo $alert;
Pagina::getInstance()->mostrar_excecoes();

echo '<div class="conteudo_grande"   style="margin-top: 0px;">
            <form method="POST">'.
    $table.'
                <!--<div class="form-row">
                    <div class="col-md-12">
                        <button class="btn btn-primary" type="submit" name="btn_salvar">SALVAR</button>
                    </div>
                </div>-->
            </form>
     </div>';





Pagina::getInstance()->fechar_corpo();