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

    if (isset($_GET['idPlaca'])) {
        $objPlaca->setIdPlaca($_GET['idPlaca']);
        $objPlaca = $objPlacaRN->consultar_completo($objPlaca); // busca tudo em 1 consulta
        //echo '<pre>';
        //print_r($objPlaca);
        //echo '</pre>';

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


        $table .= '<table class="table table-responsive table-hover tabela_poco" >';
        $quantidade = 8;
        $letras = range('A', chr(ord('A') + $quantidade));

        $cols = (12 / count($objPlaca->getObjProtocolo()->getObjDivisao()));

        $tubo_placa = 0;
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
                    $table .= '<td  style="padding: 5px; "><strong>' . $j . '</strong></td>';
                } else if ($j == 0 && $i > 0) { //linha 0 - local para se colocar os números
                    $table .= '<td style="padding: 5px; "><strong>' . $letras[$i - 1] . '</strong></td>';
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
        $table.= '<tr><td>  </td>';
        foreach($objPlaca->getObjProtocolo()->getObjDivisao() as $divisao){
            $table.= '<td colspan="'.$cols.'" style=" background: rgba(242,242,242,0.4);border-left:1px solid #d2d2d2;border-right:1px solid #d2d2d2; ">'.$divisao->getNomeDivisao().'</td>';
        }
        $table.= '</tr>';
        $table .= '</table>';

    }

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
Pagina::montar_topo_listar('Placa '.$_GET['idPlaca'].' e seus poços','remover_amostras_da_placa','REMOVER ALGUMA(S) AMOSTRAS DA PLACA', 'mix_placa_RTqPCR', 'REALIZAR MIX DA PLACA');
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