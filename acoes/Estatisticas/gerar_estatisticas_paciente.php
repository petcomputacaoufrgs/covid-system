<?php

try{
    //die( 'Versão Atual do PHP: ' . phpversion());

    session_start();

    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';
    require_once __DIR__.'/../../utils/Alert.php';
    //require_once __DIR__.'/../../classes/Estatisticas/PDF_Estatisticas.php';

    require_once __DIR__.'/../../classes/Amostra/Amostra.php';
    require_once __DIR__.'/../../classes/Amostra/AmostraRN.php';

    require_once __DIR__.'/../../classes/Paciente/PacienteRN.php';
    require_once __DIR__.'/../../classes/Paciente/PacienteRN.php';

    require_once __DIR__.'/../../classes/CadastroAmostra/CadastroAmostra.php';
    require_once __DIR__.'/../../classes/CadastroAmostra/CadastroAmostraRN.php';

    require_once __DIR__.'/../../classes/EstadoOrigem/EstadoOrigem.php';
    require_once __DIR__.'/../../classes/EstadoOrigem/EstadoOrigemRN.php';

    require_once __DIR__.'/../../classes/LugarOrigem/LugarOrigem.php';
    require_once __DIR__.'/../../classes/LugarOrigem/LugarOrigemRN.php';

    require_once __DIR__.'/../../classes/PerfilPaciente/PerfilPaciente.php';
    require_once __DIR__.'/../../classes/PerfilPaciente/PerfilPacienteRN.php';

    require_once __DIR__.'/../../classes/Diagnostico/Diagnostico.php';
    require_once __DIR__.'/../../classes/Diagnostico/DiagnosticoRN.php';

    require_once __DIR__.'/../../utils/Utils.php';


    Sessao::getInstance()->validar();

    $objCadastroAmostra = new CadastroAmostra();
    $objCadastroAmostraRN = new CadastroAmostraRN();

    $objDiagnostico = new Diagnostico();
    $objDiagnosticoRN = new DiagnosticoRN();

    $objPaciente = new Paciente();
    $objPacienteRN = new PacienteRN();

    $objAmostra = new Amostra();
    $objAmostraRN = new AmostraRN();

    $objUtils = new Utils();

    $checkedN = '';
    $alert = '';
    $teste = '';
    $dadosXls = '';

    if(!isset($_POST['btn_gerar_xls']) && !isset($_POST['btn_gerar_pdf'])){
        $checkedS = ' checked ';
    }

    if(isset($_POST['btn_adicionar_data']) || isset($_POST['btn_gerar_xls'])){
        $teste =  '<input type="text" class="form-control "  placeholder="" hidden id="inputDatas"
                       onblur="" name="TESTE"  value="'.$_POST['TESTE'].','.$_POST['dtEstatistica'].','.'">';

        $datas = explode(",",$_POST['TESTE'].','.$_POST['dtEstatistica'].',');

        $datas = array_filter($datas);
        if(count($datas) > 0 ) {
            $contador = 0;
            $contadorAux = 0;
            $teste .= '<div class="form-row" style="width: 100%;padding: 0px;margin: 0px;margin-top: 5px;">';

            foreach ($datas as $data) {
                if ($contador == 6) {
                    $contador = 0;
                    $teste .=  '    </div>
                                    <div class="form-row" style="width: 100%;padding: 0px;margin: 0px;">';
                }

                $teste .= ' <div class="col-md-2">
                                 <button type="button" onclick="remover_data(btnData' . $contadorAux.','.$contadorAux.')" id="btnData' . $contadorAux . '" 
                                            style="background-color: #3a5261;
                                            border-radius: 50px;
                                            padding-left: 15px;
                                            padding-top: 2px;
                                            padding-bottom: 4px;
                                            text-align: left;
                                            color:white;
                                            width: 90%;
                                            border: 1px solid white;
                                            margin-left: 0px;
                                            font-size: 12px;"
                                            name="btn_remover"
                                            value="'.$data.'"
                                            >'.Utils::converterData($data).'<i class="fas fa-times  fa-xs" style="float: right;color: white;padding-right: 12px;padding-top: 5.5px;text-align: right;"></i> </button>
                               <!-- <div style="background-color: #3a5261;
                                            border-radius: 50px;
                                            padding-left: 15px;
                                            padding-top: 2px;
                                            padding-bottom: 4px;
                                            color:white;
                                            width: 90%;
                                            border: 1px solid white;
                                            margin-left: 0px;
                                            font-size: 12px;"> ' . Utils::converterData($data) . '<i class="fas fa-times  fa-xs" style="float: right;color: white;padding-right: 12px;padding-top: 6.5px;"></i></div>-->
                            </div>
                            ';
                $contador++;
                $contadorAux++;
            }
            $teste .=  '    </div>';
        }

    }


    if(isset($_POST['btn_gerar_xls'])){
        if(count($datas) >  0) {
            $strDatas ='';
            foreach ($datas as $d) {
                $arrData = explode("-", $d);
                $ano = $arrData[0];
                $mes = $arrData[1];
                $dia = $arrData[2];

                $datasArr[] = $d;
                $dt[] = $dia . '/' . $mes . '/' . $ano;
                $strDatas .= $dia . '/' . $mes . '/' . $ano." e ";
            }
            $data = $dt;
            $strDatas = substr($strDatas,0,-2);

            $arr_cadastros = $objCadastroAmostraRN->listar_completo($objCadastroAmostra,array_filter($datasArr) , null);


            /*echo "<pre>";
            print_r($arr_cadastros);
            echo  "<pre>";
            die();*/

            //$objDiagnostico->setIdAmostraFk($amostra->getIdAmostra());
            //$objDiagnostico = $objDiagnosticoRN->consultar($objDiagnostico);
            if (isset($_POST['boolResultadoLaudo']) && $_POST['boolResultadoLaudo'] == 'on') {
                $arr_diagnosticos = $objDiagnosticoRN->listar($objDiagnostico);
            }


            if (count($arr_cadastros) == 0) {
                $alert .= Alert::alert_warning("Nenhuma amostra foi encontrada");
                $checkedS = ' checked ';
            }
            else {
                /*ECHO "<pre>";
                print_r($arr_cadastros);
                ECHO "</pre>";*/

                //pegar todas as amostras de perfil prefeitura de porto alegre

                $dadosXls = "";
                $dadosXls .= "  <table class=\"table table-hover\" border='1' >";
                $dadosXls .= "    <tr><td>Amostras cadastradas em " . $strDatas . "</td></tr>";
                $dadosXls .= "    <tr>";

                if (isset($_POST['boolNomePaciente']) && $_POST['boolNomePaciente'] == 'on') {
                    $dadosXls .= "  <td> Nome Paciente </td>";
                }
                if (isset($_POST['boolPerfilPaciente']) && $_POST['boolPerfilPaciente'] == 'on') {
                    $dadosXls .= "  <td> Perfil Paciente </td>";
                }

                //-------------------AMOSTRA
                if (isset($_POST['boolNicknameAmostra']) && $_POST['boolNicknameAmostra'] == 'on') {
                    $dadosXls .= "  <td> Codigo da amostra</td>";
                }
                if (isset($_POST['boolDataColetaAmostra']) && $_POST['boolDataColetaAmostra'] == 'on') {
                    $dadosXls .= "  <td> Data de coleta</td>";
                }
                if (isset($_POST['boolEstadoAmostra']) && $_POST['boolEstadoAmostra'] == 'on') {
                    $dadosXls .= "  <td> Estado (amostra)</td>";
                }
                if (isset($_POST['boolMunicipioAmostra']) && $_POST['boolMunicipioAmostra'] == 'on') {
                    $dadosXls .= "  <td> Municipio (amostra)</td>";
                }


                if (isset($_POST['boolNomeMae']) && $_POST['boolNomeMae'] == 'on') {
                    $dadosXls .= "  <td>Nome da mae</td>";
                }
                if (isset($_POST['boolDtNascimento']) && $_POST['boolDtNascimento'] == 'on') {
                    $dadosXls .= "  <td>Data de Nascimento</td>";
                }
                if (isset($_POST['boolRG']) && $_POST['boolRG'] == 'on') {
                    $dadosXls .= "  <td>RG</td>";
                }
                if (isset($_POST['boolCPF']) && $_POST['boolCPF'] == 'on') {
                    $dadosXls .= "  <td>CPF</td>";
                }
                if (isset($_POST['boolMunicipio']) && $_POST['boolMunicipio'] == 'on') {
                    $dadosXls .= "  <td>Municipio (paciente)</td>";
                }
                if (isset($_POST['boolEstado']) && $_POST['boolEstado'] == 'on') {
                    $dadosXls .= "  <td>Estado (paciente)</td>";
                }
                if (isset($_POST['boolGAL']) && $_POST['boolGAL'] == 'on') {
                    $dadosXls .= "  <td>Codigo GAL</td>";
                }


                //------------------- CADASTRO AMOSTRA
                if (isset($_POST['boolUsuarioCadastro']) && $_POST['boolUsuarioCadastro'] == 'on') {
                    $dadosXls .= "  <td> Usuario que cadastrou</td>";
                }
                if (isset($_POST['boolDataHrCadastro']) && $_POST['boolDataHrCadastro'] == 'on') {
                    $dadosXls .= "  <td> Hora Inicio - Hora Fim </td>";
                }

                if (isset($_POST['boolResultadoLaudo']) && $_POST['boolResultadoLaudo'] == 'on') {
                    $dadosXls .= "  <td> RESULTADO </td>";
                }

                $dadosXls .= " </tr>";
                foreach ($arr_cadastros as $cadastro) {
                    if(!is_null($cadastro->getObjAmostra())) {

                        $dadosXls .= "  <tr>";
                        $amostra = $cadastro->getObjAmostra();
                        // print_r($amostra->getObjPerfil());
                        // die();
                        $usuario = $cadastro->getObjUsuario();
                        $paciente = $cadastro->getObjAmostra()->getObjPaciente();

                        $estadoPaciente = null;
                        if(!is_null($cadastro->getObjAmostra()->getObjPaciente()->getObjEstado())){
                            $estadoPaciente = $cadastro->getObjAmostra()->getObjPaciente()->getObjEstado();
                        }

                        $municipioPaciente = null;
                        if(!is_null($cadastro->getObjAmostra()->getObjPaciente()->getObjMunicipio())){
                            $municipioPaciente = $cadastro->getObjAmostra()->getObjPaciente()->getObjMunicipio();
                        }


                        $estadoAmostra = $cadastro->getObjAmostra()->getObjEstado();

                        $municipioAmostra = null;
                        if(!is_null($cadastro->getObjAmostra()->getObjMunicipio())){
                            $municipioAmostra = $cadastro->getObjAmostra()->getObjMunicipio();
                        }


                        $codGAL = $cadastro->getObjAmostra()->getObjPaciente()->getObjCodGAL();

                        if (isset($_POST['boolNomePaciente']) && $_POST['boolNomePaciente'] == 'on') {
                            $dadosXls .= "  <td>" . strtoupper($objUtils->tirarAcentos($paciente->getNome())) . "</td>";
                        }
                        if (isset($_POST['boolPerfilPaciente']) && $_POST['boolPerfilPaciente'] == 'on') {
                            $dadosXls .= "  <td>" . PerfilPacienteRN::mostrarDescricaoTipo($amostra->getObjPerfil()->getCaractere()) . "</td>";
                        }

                        //-------------------AMOSTRA
                        if (isset($_POST['boolNicknameAmostra']) && $_POST['boolNicknameAmostra'] == 'on') {
                            $dadosXls .= "  <td>" . $amostra->getNickname() . "</td>";
                        }

                        if (isset($_POST['boolDataColetaAmostra']) && $_POST['boolDataColetaAmostra'] == 'on') {
                            $dadosXls .= "  <td>" . $amostra->getDataColeta() . "</td>";
                        }

                        if (isset($_POST['boolEstadoAmostra']) && $_POST['boolEstadoAmostra'] == 'on') {
                            if (is_null($estadoAmostra->getSigla()) && is_null($estadoAmostra->getNome())) {
                                $dadosXls .= "  <td></td>";
                            } else {
                                $dadosXls .= "  <td>" . $estadoAmostra->getSigla() . " - " . $objUtils->tirarAcentos($estadoAmostra->getNome()) . "</td>";
                            }

                        }
                        if (isset($_POST['boolMunicipioAmostra']) && $_POST['boolMunicipioAmostra'] == 'on') {
                            if(!is_null($municipioAmostra)) {
                                $dadosXls .= "  <td>" . $objUtils->tirarAcentos($municipioAmostra->getNome()) . "</td>";
                            }else{
                                $dadosXls .= "  <td></td>";
                            }
                        }

                        if (isset($_POST['boolNomeMae']) && $_POST['boolNomeMae'] == 'on') {
                            $dadosXls .= "  <td>" . strtoupper($objUtils->tirarAcentos($paciente->getNomeMae())) . "</td>";
                        }
                        if (isset($_POST['boolDtNascimento']) && $_POST['boolDtNascimento'] == 'on') {
                            $dadosXls .= "  <td>" . $paciente->getDataNascimento() . "</td>";
                        }
                        if (isset($_POST['boolRG']) && $_POST['boolRG'] == 'on') {
                            $dadosXls .= "  <td>" . $paciente->getRG() . "</td>";
                        }
                        if (isset($_POST['boolCPF']) && $_POST['boolCPF'] == 'on') {
                            $dadosXls .= "  <td>" . $paciente->getCPF() . "</td>";
                        }
                        if (isset($_POST['boolMunicipio']) && $_POST['boolMunicipio'] == 'on') {
                            if(!is_null($municipioPaciente)) {
                                $dadosXls .= "  <td>" . $objUtils->tirarAcentos($municipioPaciente->getNome()) . "</td>";
                            }else{
                                $dadosXls .= "  <td></td>";
                            }

                        }
                        if (isset($_POST['boolEstado']) && $_POST['boolEstado'] == 'on') {
                            if(!is_null($estadoPaciente)) {
                                //print_r($estadoPaciente);
                                if (is_null($estadoPaciente->getSigla()) && is_null($estadoPaciente->getNome())
                                    || strlen($estadoPaciente->getSigla()) == 0 || strlen($estadoPaciente->getNome()) ==0 ) {
                                    $dadosXls .= "  <td></td>";
                                } else {
                                    $dadosXls .= "  <td>" . $estadoPaciente->getSigla() . " - " . $objUtils->tirarAcentos($estadoPaciente->getNome()) . "</td>";
                                }
                            }else{
                                $dadosXls .= "  <td></td>";
                            }

                        }
                        if (isset($_POST['boolCartaoSUS']) && $_POST['boolCartaoSUS'] == 'on') {
                            $dadosXls .= "  <td>" . $paciente->getCartaoSUS() . "</td>";
                        }
                        if ($codGAL != null) {
                            if (isset($_POST['boolGAL']) && $_POST['boolGAL'] == 'on') {
                                $dadosXls .= "  <td>" . $codGAL->getCodigo() . "</td>";
                            }
                        }

                        //------------------- CADASTRO AMOSTRA
                        if (isset($_POST['boolUsuarioCadastro']) && $_POST['boolUsuarioCadastro'] == 'on') {
                            $dadosXls .= "  <td>" . $usuario->getMatricula() . "</td>";
                        }
                        if (isset($_POST['boolDataHrCadastro']) && $_POST['boolDataHrCadastro'] == 'on') {
                            $dadosXls .= "  <td>" . Utils::converterDataHora($cadastro->getDataHoraInicio()) . " - " . Utils::converterDataHora($cadastro->getDataHoraFim()) . "</td>";
                        }

                        if (isset($_POST['boolResultadoLaudo']) && $_POST['boolResultadoLaudo'] == 'on') {
                            $encontrou = false;
                            $objDiagnostico = new Diagnostico();
                            $i = 0;
                            while (!$encontrou && $i < count($arr_diagnosticos)) {
                                if ($arr_diagnosticos[$i]->getIdAmostraFk() == $amostra->getIdAmostra()) {
                                    $encontrou = true;
                                    $objDiagnostico = $arr_diagnosticos[$i];
                                }
                                $i++;
                            }
                            if (is_null($objDiagnostico)) {
                                $dadosXls .= "  <td> ainda não há resultado </td>";
                            } else {
                                $dadosXls .= "  <td> " . DiagnosticoRN::mostrarDescricaoSituacao($objDiagnostico->getDiagnostico()) . "</td>";
                            }
                        }

                        $dadosXls .= " </tr>";
                    }

                }



                $dadosXls .= '</table>';


                $arquivo = $strDatas .".xls";
                // Configurações header para forçar o download
                //header('Content-Type: application/vnd.ms-excel');
                // header('Content-Disposition: attachment;filename="'.$arquivo.'"');
                // header('Cache-Control: max-age=0');
                // Se for o IE9, isso talvez seja necessário
                //header('Cache-Control: max-age=1');

                header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                header("Content-type: application/x-msexcel");
                header('Content-Disposition: attachment; filename="' . $arquivo . '"');
                header("Content-Description: PHP Generated Data");

                // Envia o conteúdo do arquivo
                echo $dadosXls;
                exit;



            }
        }else {
            $alert .= Alert::alert_primary("Informe a data");
        }
    }




}catch (Throwable $e){
    die($e);
    Pagina::getInstance()->processar_excecao($e);
}

Pagina::abrir_head("Gerar Estatísticas");
?>
<script type="text/javascript">
    function remover_data(data,id) {
        //alert(id);

        var x = document.getElementsByName("btn_remover");
        var strConcat = '';
        var i;
        for (i = 0; i < x.length; i++) {
            if(data.value !== x[i].value){
                strConcat = x[i].value +"," + strConcat;
                //document.getElementById("inputDatas").value = x[i].value.",";
            }
        }
        //alert(strConcat);
        document.getElementById("inputDatas").value = strConcat;
        var btn = document.getElementById("btnData"+id);
        btn.parentNode.removeChild(btn);
        //document.getElementById("inputDatas").value = "My value";
    }
</script>

<?php
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar("ESTATÍSTICAS");

echo $alert;
/*
$arrayBind[] = array('i', $objPaciente->getIdSexo_fk());
$arrayBind[] = array('i', $objPaciente->getIdEtnia_fk());


$arrayBind[] = array('s', $objPaciente->getCEP());
$arrayBind[] = array('s', $objPaciente->getEndereco());
$arrayBind[] = array('s', $objPaciente->getObsEndereco());
$arrayBind[] = array('s', $objPaciente->getObsCEP());
$arrayBind[] = array('s', $objPaciente->getObsCPF());
$arrayBind[] = array('s', $objPaciente->getPassaporte());
$arrayBind[] = array('s', $objPaciente->getObsPassaporte());
$arrayBind[] = array('s', $objPaciente->getCadastroPendente());
$arrayBind[] = array('s', $objPaciente->getCartaoSUS());
$arrayBind[] = array('s', $objPaciente->getObsCartaoSUS());
$arrayBind[] = array('s', $objPaciente->getObsDataNascimento());
$arrayBind[] = array('i', $objPaciente->getIdMunicipioFk());
$arrayBind[] = array('i', $objPaciente->getIdEstadoFk());
$arrayBind[] = array('s', $objPaciente->getObsMunicipio());
*/

echo '<div class="conteudo_grande" style="margin-top: 0px;">
    <form method="POST" >
        <div class="form-row" style="width: 100%;padding: 0px;margin: 0px;">
            <div class="col-md-11" style="width: 100%;">
                <label for="label_dataEstatistica">Informe uma data:</label>
                <input type="date" class="form-control "  placeholder=""  
                       onblur="" name="dtEstatistica"  value="">
            </div>
             <div class="col-md-1">
                <button class="btn btn-primary" style="margin-top:33px;margin-left: -5px;width: 100%;height: 35px;" type="submit" name="btn_adicionar_data"> <i class="fas fa-plus" style="color: white;"></i></button>
             </div>
             <!--<div class="col-md-6" style="width: 100%;">
                <button class="btn btn-primary" style="margin-top:33px;margin-left: -5px;width: 100%;" type="submit" name="btn_gerar_pdf"><i class="fas fa-file-pdf" style="color: white;"></i> .PDF </button>
             </div>-->
       
        </div>';

echo $teste;


echo '
        <h4 style="margin-top: 10px;">Informações do paciente</h4>
        <hr>
         <div class="form-row" style="width: 100%;padding: 0px;margin: 0px;">';
echo '      <div class="col-md-2" style="width: 100%;">
                <div class="form-check">
                    <input type="checkbox"  '.$checkedS.' class="form-check-input" name="boolNomePaciente">
                    <label class="form-check-label" for="exampleCheck1">Nome paciente</label>
                </div>
            </div>';
echo '     <div class="col-md-2" style="width: 100%;">
                <div class="form-check">
                    <input type="checkbox" '.$checkedN.' class="form-check-input" name="boolNomeMae">
                    <label class="form-check-label" for="exampleCheck1">Nome da mãe</label>
                </div>
            </div>';
echo '      <div class="col-md-2" style="width: 100%;">
                <div class="form-check">
                    <input type="checkbox" '.$checkedN.'  class="form-check-input" name="boolDtNascimento">
                    <label class="form-check-label" for="exampleCheck1">Data Nascimento</label>
                </div>
            </div>';
echo '      <div class="col-md-2" style="width: 100%;">
                <div class="form-check">
                    <input type="checkbox"  '.$checkedN.' class="form-check-input" name="boolRG">
                    <label class="form-check-label" for="exampleCheck1">RG</label>
                </div>
            </div>';
echo '      <div class="col-md-2" style="width: 100%;">
                <div class="form-check">
                    <input type="checkbox" '.$checkedN.' class="form-check-input" name="boolCPF">
                    <label class="form-check-label" for="exampleCheck1">CPF</label>
                </div>
            </div>';
echo '      <div class="col-md-2" style="width: 100%;">
                <div class="form-check">
                    <input type="checkbox"  '.$checkedS.' class="form-check-input" name="boolMunicipio">
                    <label class="form-check-label" for="exampleCheck1">Município</label>
                </div>
            </div>
            
         </div>';
echo '   <div class="form-row" style="width: 100%;padding: 0px;margin: 0px;">
             <div class="col-md-2" style="width: 100%;">
                <div class="form-check">
                    <input type="checkbox"  '.$checkedS.' class="form-check-input" name="boolEstado">
                    <label class="form-check-label" for="exampleCheck1">Estado</label>
                </div>
            </div>';
echo '      <div class="col-md-2" style="width: 100%;">
                <div class="form-check">
                    <input type="checkbox"  '.$checkedN.' class="form-check-input"  name="boolCartaoSUS">
                    <label class="form-check-label" for="exampleCheck1">Cartão SUS</label>
                </div>
            </div>
            <div class="col-md-2" style="width: 100%;">
                <div class="form-check">
                    <input type="checkbox"  '.$checkedS.' class="form-check-input"  name="boolGAL">
                    <label class="form-check-label" for="exampleCheck1">Código GAL</label>
                </div>
            </div>    
             <div class="col-md-2" style="width: 100%;">
                <div class="form-check">
                    <input type="checkbox"  '.$checkedS.' class="form-check-input"  name="boolPerfilPaciente">
                    <label class="form-check-label" for="exampleCheck1">Perfil Paciente</label>
                </div>
            </div>       
         </div>';

echo '<h4 style="margin-top: 20px;">Informações da amostra</h4>
         <hr>
         <div class="form-row" style="width: 100%;padding: 0px;margin: 0px;">
            <div class="col-md-2" style="width: 100%;">
                <div class="form-check">
                    <input type="checkbox" '.$checkedS.'  class="form-check-input" name="boolNicknameAmostra">
                    <label class="form-check-label" for="exampleCheck1">Nickname</label>
                </div>
            </div>
            <div class="col-md-2" style="width: 100%;">
                <div class="form-check">
                    <input type="checkbox"  '.$checkedN.' class="form-check-input" name="boolDataColetaAmostra">
                    <label class="form-check-label" for="exampleCheck1">Data Coleta</label>
                </div>
            </div>
            <div class="col-md-2" style="width: 100%;">
                <div class="form-check">
                    <input type="checkbox" '.$checkedS.'  class="form-check-input" name="boolMunicipioAmostra">
                    <label class="form-check-label" for="exampleCheck1">Município</label>
                </div>
            </div>
            <div class="col-md-2" style="width: 100%;">
                <div class="form-check">
                    <input type="checkbox"  '.$checkedS.' class="form-check-input" name="boolEstadoAmostra">
                    <label class="form-check-label" for="exampleCheck1">Estado</label>
                </div>
            </div>
         </div>
         
         <h4 style="margin-top: 20px;">Informações do cadastro</h4>
         <hr>
         <div class="form-row" style="width: 100%;padding: 0px;margin: 0px;">
            <div class="col-md-3" style="width: 100%;">
                <div class="form-check">
                    <input type="checkbox" '.$checkedS.' class="form-check-input" name="boolUsuarioCadastro">
                    <label class="form-check-label" for="exampleCheck1">Usuário que cadastrou</label>
                </div>
            </div>
            <div class="col-md-2" style="width: 100%;">
                <div class="form-check">
                    <input type="checkbox" '.$checkedS.' class="form-check-input" name="boolDataHrCadastro">
                    <label class="form-check-label" for="exampleCheck1">Horário do cadastro</label>
                </div>
            </div>
         </div>';
echo '<h4 style="margin-top: 20px;">Informações do resultado</h4>
         <hr>
         <div class="form-row" style="width: 100%;padding: 0px;margin: 0px;">
            <div class="col-md-12" style="width: 100%;">
                <div class="form-check">
                    <input type="checkbox" '.$checkedN.'  class="form-check-input" name="boolResultadoLaudo">
                    <label class="form-check-label" for="exampleCheck1">Resultado do laudo </label>
                </div>
            </div>
         </div>
          
        <div class="form-row" style="width: 100%;padding: 0px;margin: 0px;">
             <div class="col-md-12" style="width: 100%;">
                <button class="btn btn-primary" style="margin-top:33px;margin-left: -5px;width: 100%;" type="submit" name="btn_gerar_xls"><i class="fas fa-file-excel" style="color: white;"></i> .XLS</button>
             </div>
             <!--<div class="col-md-6" style="width: 100%;">
                <button class="btn btn-primary" style="margin-top:33px;margin-left: -5px;width: 100%;" type="submit" name="btn_gerar_pdf"><i class="fas fa-file-pdf" style="color: white;"></i> .PDF </button>
             </div>-->
        </div>
    </form>
</div>';


echo '<div class="conteudo_grande" style="margin-top: 0px;">';
echo $dadosXls;
echo '</div>';

Pagina::getInstance()->fechar_corpo();
