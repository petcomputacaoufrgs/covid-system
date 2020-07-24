<?php

try{
    //die( 'Versão Atual do PHP: ' . phpversion());

    session_start();
    //header('Cache-Control: no-cache, must-revalidate');
    //header('Content-Type: application/json; charset=utf-8');
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once __DIR__ . '/../../utils/Alert.php';
    //require_once __DIR__.'/../../classes/Estatisticas/PDF_Estatisticas.php';

    require_once __DIR__ . '/../../classes/Amostra/Amostra.php';
    require_once __DIR__ . '/../../classes/Amostra/AmostraRN.php';

    require_once __DIR__ . '/../../classes/Paciente/PacienteRN.php';
    require_once __DIR__ . '/../../classes/Paciente/PacienteRN.php';

    require_once __DIR__ . '/../../classes/CadastroAmostra/CadastroAmostra.php';
    require_once __DIR__ . '/../../classes/CadastroAmostra/CadastroAmostraRN.php';

    require_once __DIR__ . '/../../classes/EstadoOrigem/EstadoOrigem.php';
    require_once __DIR__ . '/../../classes/EstadoOrigem/EstadoOrigemRN.php';

    require_once __DIR__ . '/../../classes/LugarOrigem/LugarOrigem.php';
    require_once __DIR__ . '/../../classes/LugarOrigem/LugarOrigemRN.php';

    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPaciente.php';
    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPacienteRN.php';
    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPacienteINT.php';

    require_once __DIR__ . '/../../classes/Laudo/Laudo.php';
    require_once __DIR__ . '/../../classes/Laudo/LaudoRN.php';

    require_once __DIR__ . '/../../classes/RTqPCR/RTqPCR.php';
    require_once __DIR__ . '/../../classes/RTqPCR/RTqPCR_RN.php';

    require_once __DIR__ . '/../../classes/Diagnostico/Diagnostico.php';
    require_once __DIR__ . '/../../classes/Diagnostico/DiagnosticoRN.php';

    require_once __DIR__ . '/../../utils/Utils.php';
    Sessao::getInstance()->validar();
    $alert = '';
    $str_cartao_sus = '';
    $str_cep_paciente = '';
    $str_codigo_gal = '';

    $str_logradouro_paciente = '';
    $str_numero_paciente ='';
    $str_complemento_paciente = '';
    $str_bairro_paciente = '';
    $str_municipio_paciente = '';
    $str_uf_paciente = '';

    if(is_null(Sessao::getInstance()->getCPF())){
        //redirecionar para página de perfil do usuário logado, onde ele insere o CPF

    }else {

        $objCadastroAmostra = new CadastroAmostra();
        $objCadastroAmostraRN = new CadastroAmostraRN();

        $objDiagnostico = new Diagnostico();
        $objDiagnosticoRN = new DiagnosticoRN();

        $objLaudo = new Laudo();
        $objLaudoRN = new LaudoRN();

        $objPaciente = new Paciente();
        $objPacienteRN = new PacienteRN();

        $objPerfilPaciente = new PerfilPaciente();
        $objPerfilPacienteRN = new PerfilPacienteRN();

        $objRTqPCR = new RTqPCR();
        $objRTqPCR_RN = new RTqPCR_RN();

        $objAmostra = new Amostra();
        $objAmostraRN = new AmostraRN();


        //$arr_rtqpcrs_amostra = $objAmostraRN->listar_rtqpcrs_amostra($objAmostra,RTqPCR_RN::$STA_FINALIZADO);

        /*
        echo "<pre>";
        print_r($arr_rtqpcrs_amostra);
        echo  "<pre>";
        */
        //die();

        $objUtils = new Utils();

        $checkedN = '';
        $alert = '';
        $liberarXLS = false;
        $str_data_exame = '';
        $select_perfis = '';

        if (!isset($_POST['btn_gerar_xls']) && !isset($_POST['btn_gerar_pdf'])) {
            $checkedS = ' checked ';
        }

        PerfilPacienteINT::montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, null, null);
        if (isset($_POST['btn_adicionar_data']) || isset($_POST['btn_gerar_xls'])) {
            $teste = '<input type="text" class="form-control "  placeholder="" hidden id="inputDatas"
                       onblur="" name="TESTE"  value="' . $_POST['TESTE'] . ',' . $_POST['dtEstatistica'] . ',' . '">';

            $datas = explode(",", $_POST['TESTE'] . ',' . $_POST['dtEstatistica'] . ',');

            $datas = array_filter($datas);
            if (count($datas) > 0) {
                $contador = 0;
                $contadorAux = 0;
                $teste .= '<div class="form-row" style="width: 100%;padding: 0px;margin: 0px;margin-top: 5px;">';

                foreach ($datas as $data) {
                    if ($contador == 6) {
                        $contador = 0;
                        $teste .= '    </div>
                                    <div class="form-row" style="width: 100%;padding: 0px;margin: 0px;">';
                    }

                    $teste .= ' <div class="col-md-2">
                                 <button type="button" onclick="remover_data(btnData' . $contadorAux . ',' . $contadorAux . ')" id="btnData' . $contadorAux . '" 
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
                                            value="' . $data . '"
                                            >' . Utils::converterData($data) . '<i class="fas fa-times  fa-xs" style="float: right;color: white;padding-right: 12px;padding-top: 5.5px;text-align: right;"></i> </button>
                                </div>';
                    $contador++;
                    $contadorAux++;
                }
                $teste .= '    </div>';
            }

            PerfilPacienteINT::montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, null, null);

            if(isset($_POST['sel_perfil'])) {
                $objPerfilPacientePOST = new PerfilPaciente();
                $objPerfilPacientePOST->setIdPerfilPaciente($_POST['sel_perfil']);
                $objPerfilPacientePOST = $objPerfilPacienteRN->consultar($objPerfilPacientePOST);
                $liberarXLS = true;
            }else{
                $alert .= Alert::alert_warning("Informe o perfil do paciente");
                $liberarXLS = false;
            }


        }


        if (isset($_POST['btn_gerar_xls']) && $liberarXLS) {
            if (count($datas) > 0) {
                $strDatas = '';
                foreach ($datas as $d) {
                    $arrData = explode("-", $d);
                    $ano = $arrData[0];
                    $mes = $arrData[1];
                    $dia = $arrData[2];

                    $datasArr[] = $d;
                    $dt[] = $dia . '/' . $mes . '/' . $ano;
                    $strDatas .= $dia . '/' . $mes . '/' . $ano . " e ";
                }
                $data = $dt;
                $strDatas = substr($strDatas, 0, -2);

                $arr_amostras_prefeitura = array();
                $arr_cadastros = $objCadastroAmostraRN->listar_completo($objCadastroAmostra, array_filter($datasArr), null);

                foreach ($arr_cadastros as $cadastro) {
                    $objAmostra = $cadastro->getObjAmostra();
                    $objPerfilPaciente = $objAmostra->getObjPerfil();
                    if ($objPerfilPaciente->getCaractere() == $objPerfilPacientePOST->getCaractere()){ //PerfilPacienteRN::$TP_PREFEITURA_PORTO_ALEGRE) {
                        $arr_amostras_prefeitura[] = $cadastro;
                    }
                }


                //echo "<pre>";
                //print_r($arr_amostras_prefeitura);
                //echo  "<pre>";
                //die();

                //$arr_diagnosticos = $objDiagnosticoRN->listar($objDiagnostico);
                if (count($arr_amostras_prefeitura) == 0) {
                    $alert .= Alert::alert_warning("Nenhuma amostra foi encontrada");
                    $checkedS = ' checked ';
                }
                else {
                    $arr_laudos = $objLaudoRN->listar($objLaudo);
                    //ECHO "<pre>";
                    //print_r($arr_laudos);
                    //ECHO "</pre>";

                    //die();

                    //pegar todas as amostras de perfil prefeitura de porto alegre
                    $dadosXls = "";
                    $dadosXls .= "  <table class=\"table table-hover\" border='1' >";
                    //$dadosXls .= "    <tr><td>Amostras cadastradas em " . $strDatas . "</td></tr>";
                    $dadosXls .= "    <tr>";
                    $dadosXls .= "  <td>CPF_PACIENTE</td>";
                    $dadosXls .= "  <td>CNS_PACIENTE</td>";
                    $dadosXls .= "  <td>PROTOCOLO_GERCON</td>";
                    $dadosXls .= "  <td>CEP_PACIENTE</td>";
                    $dadosXls .= "  <td>LOGRADOURO</td>";
                    $dadosXls .= "  <td>NUMERO</td>";
                    $dadosXls .= "  <td>COMPLEMENTO</td>";
                    $dadosXls .= "  <td>BAIRRO</td>";
                    $dadosXls .= "  <td>MUNICIPIO</td>";
                    $dadosXls .= "  <td>UF</td>";
                    $dadosXls .= "  <td>TELEFONE_PACIENTE</td>";
                    $dadosXls .= "  <td>CNES_LABORATORIO</td>";
                    $dadosXls .= "  <td>DATA_DO_EXAME</td>";
                    $dadosXls .= "  <td>CPF_PROFISSIONAL</td>";
                    $dadosXls .= "  <td>CODIGO_EXAME</td>";
                    $dadosXls .= "  <td>RESULTADO</td>";
                    $dadosXls .= "  <td>DATA_INICIO_SINTOMAS</td>";
                    $dadosXls .= " </tr>";

                    foreach ($arr_amostras_prefeitura as $cadastro) {
                        if (!is_null($cadastro->getObjAmostra())) {

                            $dadosXls .= "  <tr>";
                            $amostra = $cadastro->getObjAmostra();
                            $usuario = $cadastro->getObjUsuario();
                            $paciente = $cadastro->getObjAmostra()->getObjPaciente();

                            if(!is_null($paciente->getCartaoSUS())){
                                $str_cartao_sus = $paciente->getCartaoSUS();
                            }else{
                                $str_cartao_sus  = '';
                            }

                            if(!is_null($paciente->getCEP())){
                                $str_cep_paciente = $paciente->getCEP();
                                $str_logradouro_paciente = $objPaciente->getEndereco();
                                $str_numero_paciente = $objPaciente->getNumero();
                                $str_complemento_paciente = $objPaciente->getComplemento();
                                $str_bairro_paciente = $objPaciente->getBairro();

                                if(!is_null($objPaciente->getObjMunicipio())){
                                    $str_municipio_paciente = $objPaciente->getObjMunicipio()->getNome();
                                }

                                if(!is_null($objPaciente->getObjEstado())){
                                    $str_uf_paciente = $objPaciente->getObjEstado()->getSigla();
                                }


                            }else{
                                $str_cep_paciente  = '';
                            }

                            if(!is_null($cadastro->getObjAmostra()->getObjPaciente()) &&  !is_null($cadastro->getObjAmostra()->getObjPaciente()->getObjCodGAL())){
                                $str_codigo_gal = $cadastro->getObjAmostra()->getObjPaciente()->getObjCodGAL()->getCodigo();
                            }else{
                                $str_codigo_gal  = '';
                            }

                            $dadosXls .= "  <td>" . $paciente->getCPF() . "</td>";
                            $dadosXls .= "  <td>" . $str_cartao_sus." </td>";
                            $dadosXls .= "  <td>" . $str_codigo_gal . "</td>";
                            $dadosXls .= "  <td>" . $str_cep_paciente . "</td>";
                            $dadosXls .= "  <td>" . $str_logradouro_paciente . "</td>";
                            $dadosXls .= "  <td>" . $str_numero_paciente . "</td>";
                            $dadosXls .= "  <td>" . $str_complemento_paciente . "</td>";
                            $dadosXls .= "  <td>" . $str_bairro_paciente . "</td>";
                            $dadosXls .= "  <td>" . $str_municipio_paciente . "</td>";
                            $dadosXls .= "  <td>" . $str_uf_paciente . "</td>";
                            $dadosXls .= "  <td>" .$paciente->getDDD(). $paciente->getTelefone() . "</td>";
                            $dadosXls .= "  <td>    0213349 </td>";


                            $arr_rtqpcrs_amostra = $objAmostraRN->listar_rtqpcrs_amostra($amostra,RTqPCR_RN::$STA_FINALIZADO);
                            //print_r($arr_rtqpcrs_amostra);
                            //die();
                            if(count($arr_rtqpcrs_amostra)> 0){
                                $str_data_exame = Utils::converterDataHora($arr_rtqpcrs_amostra[0]->getObjRTqPCR()->getDataHoraFim());
                            }
                            $dadosXls .= "  <td>    ". $str_data_exame ." </td>";
                            $dadosXls .= "  <td>" . Sessao::getInstance()->getCPF() . "</td>";
                            $dadosXls .= "  <td>0213019999</td>";


                            $encontrou = false;
                            $objDiagnostico = new Diagnostico();
                            $i = 0;
                            while (!$encontrou && $i < count($arr_laudos)) {
                                if ($arr_laudos[$i]->getIdAmostraFk() == $amostra->getIdAmostra()) {
                                    $encontrou = true;
                                    $objLaudoAux = $arr_laudos[$i];

                                }
                                $i++;
                            }
                            if (is_null($objLaudoAux)) {
                                $dadosXls .= "  <td>  </td>";
                            } else {
                                $dadosXls .= "  <td> " .strtoupper(Utils::getInstance()->tirarAcentos(LaudoRN::mostrarDescricaoResultado($objLaudoAux->getResultado()))) . "</td>";
                            }


                            $dadosXls .= "  <td>  </td>";
                            $dadosXls .= " </tr>";
                        }

                    }


                    $dadosXls .= '</table>';


                    $arquivo = $strDatas ."_".$objPerfilPacientePOST->getIndex_perfil().".xls";
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
            } else {
                $alert .= Alert::alert_primary("Informe a data");
            }
        }
    }




}catch (Throwable $e){
    die($e);
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
Pagina::montar_topo_listar("ESTATÍSTICAS PREFEITURA");

echo $alert;


echo '<div class="conteudo_grande" style="margin-top: 0px;">
    <form method="POST" >
        <div class="form-row" style="width: 100%;padding: 0px;margin: 0px;">
            <div class="col-md-12" style="width: 100%;">
                <label for="label_dataEstatistica">Informe uma data:</label>
                <input type="date" class="form-control "  placeholder=""  
                       onblur="" name="dtEstatistica"  value="">
            </div>
            <!-- <div class="col-md-1">
                <button class="btn btn-primary" style="margin-top:33px;margin-left: -5px;width: 100%;height: 35px;" type="submit" name="btn_adicionar_data"> <i class="fas fa-plus" style="color: white;"></i></button>
             </div> -->
             <!--<div class="col-md-6" style="width: 100%;">
                <button class="btn btn-primary" style="margin-top:33px;margin-left: -5px;width: 100%;" type="submit" name="btn_gerar_pdf"><i class="fas fa-file-pdf" style="color: white;"></i> .PDF </button>
             </div>-->
       
        </div>
        <div class="form-row" style="margin-top: 5px;">
            <div class="col-md-12">
            <label for="label_dataEstatistica">Selecione um perfil:</label>
            '.$select_perfis.'
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


Pagina::getInstance()->fechar_corpo();
