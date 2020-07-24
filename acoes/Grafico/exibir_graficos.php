<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
try {
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../utils/Utils.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';

    require_once __DIR__ . '/../../classes/CadastroAmostra/CadastroAmostra.php';
    require_once __DIR__ . '/../../classes/CadastroAmostra/CadastroAmostraRN.php';

    require_once __DIR__ . '/../../classes/Amostra/Amostra.php';
    require_once __DIR__ . '/../../classes/Amostra/AmostraRN.php';

    require_once __DIR__ . '/../../classes/Sexo/Sexo.php';
    require_once __DIR__ . '/../../classes/Sexo/SexoRN.php';

    require_once __DIR__ . '/../../classes/Etnia/Etnia.php';
    require_once __DIR__ . '/../../classes/Etnia/EtniaRN.php';

    require_once __DIR__ . '/../../utils/Utils.php';

    Sessao::getInstance()->validar();
    date_default_timezone_set('America/Sao_Paulo');

    /*
    $objAmostra = new Amostra();
    $objAmostraRN = new AmostraRN();
    $arr_amostras = $objAmostraRN->listar_completo_unica_consulta($objAmostra);

    $dataAtual = explode("/", date('d/m/Y'));
    //echo "<pre>";
    //print_r($arr_amostras);
    //echo "</pre>";
    //die();

    foreach ($arr_amostras as $cadastroAmostra){
        $amostra = $cadastroAmostra->getObjAmostra();
        $objPaciente = $amostra->getObjPaciente();
        $objPerfilPaciente = $amostra->getObjPerfil();

        $arr_perfis[] = $objPerfilPaciente->getPerfil();
        if(!is_null($objPaciente->getObjEtnia())){
            $arr_etnia[] = $objPaciente->getObjEtnia()->getEtnia();
        }else{
            $arr_etnia[] = 'Não informada';
        }
        $arr_sexo[] = $objPaciente->getObjSexo()->getSexo();

        if(!is_null($amostra->getObjMunicipio())) {
            $arr_municipios[] = $amostra->getObjMunicipio()->getNome();
        }else{
            $arr_municipios[] = 'Não informado';
        }

        if(!is_null($amostra->getObjMunicipio()) && $amostra->getObjMunicipio()->getNome() == 'Porto Alegre') {
            $arr_POA[] = $objPerfilPaciente->getPerfil();
        }
        else{
            $arr_POA[] = 'Não informado';
        }

        if(!is_null($objPaciente->getDataNascimento())) {
            $dataNascimento  = explode("/", Utils::getStrData($objPaciente->getDataNascimento()));
            if(strlen($dataNascimento[2] . $dataNascimento[1] . $dataNascimento[0]) == 8) {
                $idade = intval(intval($dataAtual[2]) - intval($dataNascimento[2]));
                $arr_idades[] = array('idade'=>$idade, 'num' => $dataNascimento[2] . $dataNascimento[1] . $dataNascimento[0]);
            }else{
                $arr_idades_ordenada[] = 'Não informada';
            }

        }else{
            $arr_idades_ordenada[] = 'Não informada';
        }

        if(!is_null($amostra->getObjLaudo()) && !is_null($amostra->getObjLaudo()->getResultado()) && !is_null($objPaciente->getObjEtnia())) {
            //$arr_etnia_laudo[] = array( "etnia" => $objPaciente->getObjEtnia()->getIndex_etnia(),"resultado_laudo" =>LaudoRN::mostrarDescricaoResultado($amostra->getObjLaudo()->getResultado()));
            $arr_etnia_laudo[] = $objPaciente->getObjEtnia()->getIndex_etnia().' ('.LaudoRN::mostrarDescricaoResultado($amostra->getObjLaudo()->getResultado()).')';

        }

        if(!is_null($amostra->getObjLaudo()) && !is_null($objPaciente->getDataNascimento())){
            $dataNascimento  = explode("/", Utils::getStrData($objPaciente->getDataNascimento()));
            $idadeLaudo = intval(intval($dataAtual[2]) - intval($dataNascimento[2]));
            if(strlen($dataNascimento[2] . $dataNascimento[1] . $dataNascimento[0]) == 8) {
                $arr_idade_laudo[] = array("idadeResultado" => $idadeLaudo." anos (".LaudoRN::mostrarDescricaoResultado($amostra->getObjLaudo()->getResultado()).")","num" => $dataNascimento[0].$dataNascimento[1].$dataNascimento[2]);
            }else{
                $arr_idade_laudo_ordenado[] = 'Não informada';
            }

        }else{
            $arr_idade_laudo_ordenado[] = 'Não informada';
        }

        $dataCadastro = explode(" ",$cadastroAmostra->getDataHoraInicio());
        $dataCadastroAux = explode("-", $dataCadastro[0]);
        $arr_data_cadastro[] = array("dataCadastro" => Utils::getStrData($dataCadastro[0]),"num" => $dataCadastroAux[0].$dataCadastroAux[1].$dataCadastroAux[2]);
        $arr_data_coleta[] = Utils::getStrData($amostra->getDataColeta());
    }


    //idade
    usort($arr_idades, 'sortByOrder');
    foreach (array_reverse($arr_idades) as $item) {
        $arr_idades_ordenada[] = $item['idade'];
    }



    //idade x laudo
    usort($arr_idade_laudo, 'sortByOrder');
    foreach ($arr_idade_laudo as $item) {
        $arr_idade_laudo_ordenado[] = $item['idadeResultado'];
    }



    //data cadastro
    usort($arr_data_cadastro, 'sortByOrder');
    foreach ($arr_data_cadastro as $item) {
        $arr_data_cadastro_ordenada[] = $item['dataCadastro'];
    }


    $arr_idade_laudo_count = array_count_values($arr_idade_laudo_ordenado);
    $arr_cores_idade_laudo = array();
    for($i=0; $i<count($arr_idade_laudo_count); $i++){
        $arr_cores_idade_laudo[] = Utils::random_color(0.5);
    }

    $arr_etnia_laudo_count = array_count_values($arr_etnia_laudo);
    $arr_cores_etnia_laudo = array();
    for($i=0; $i<count($arr_etnia_laudo_count); $i++){
        $arr_cores_etnia_laudo[] = Utils::random_color(0.5);
    }

    $arr_POA_count = array_count_values($arr_POA);
    $arr_cores_POA_count = array();
    for($i=0; $i<count($arr_POA_count); $i++){
        $arr_cores_POA_count[] = Utils::random_color(0.5);
    }
    //---
    $arr_data_coleta_count = array_count_values($arr_data_coleta);
    $arr_cores_data_coleta = array();
    for($i=0; $i<count($arr_data_coleta_count); $i++){
        $arr_cores_data_coleta[] = Utils::random_color(0.5);
    }

    $arr_data_cadastro_count = array_count_values($arr_data_cadastro_ordenada);
    $arr_cores_data_cadastro = array();
    for($i=0; $i<count($arr_data_cadastro_count); $i++){
        $arr_cores_data_cadastro[] = Utils::random_color(0.5);
    }

    //---
    $arr_perfis_count = array_count_values($arr_perfis);
    //print_r($arr_perfis_count);
    for($i=0; $i<count($arr_perfis_count); $i++){
        $arr_cores_perfis[] = Utils::random_color(0.5);
    }

    //---
    $arr_sexo_count = array_count_values($arr_sexo);
    //print_r($arr_sexo_count);
    for($i=0; $i<count($arr_sexo_count); $i++){
        $arr_cores_sexo[] = Utils::random_color(0.5);
    }

    $arr_etnia_count = array_count_values($arr_etnia);
    //print_r($arr_etnia_count);
    for($i=0; $i<count($arr_etnia_count); $i++){
        $arr_cores_etnia[] = Utils::random_color(0.5);
    }


    $arr_municipios_count = array_count_values($arr_municipios);
    //print_r($arr_municipios_count);

    foreach ($arr_municipios_count as $municipio => $valor){
        $arr_municipios_sort[] = array("nome" => $municipio, "num" => $valor);
    }
    print_r($arr_municipios_sort);
    usort($arr_municipios_sort, 'sortByOrder');
    foreach ($arr_municipios_sort as $item) {
        $arr_municipios_ordenada[$item['nome']] = $item['num'];
    }


    for($i=0; $i<count($arr_municipios_ordenada); $i++){
        $arr_cores_municipios[] = Utils::random_color(0.5);
    }


    $arr_idades_count = array_count_values($arr_idades_ordenada);
    //print_r($arr_municipios_count);
    for($i=0; $i<count($arr_idades_count); $i++){
        $arr_cores_idade[] = Utils::random_color(0.5);
    }



    $arr_JSON['Perfil'] = $arr_perfis_count;
    $arr_JSON['cores_Perfil'] = $arr_cores_perfis;

    $arr_JSON['Sexo'] = $arr_sexo_count;
    $arr_JSON['cores_Sexo'] = $arr_cores_sexo;

    $arr_JSON['Etnia'] = $arr_etnia_count;
    $arr_JSON['cores_Etnia'] = $arr_cores_etnia;

    $arr_JSON['Municipio'] = $arr_municipios_count;
    $arr_JSON['cores_Municipio'] = $arr_cores_municipios;

    $arr_JSON['Data_coleta'] = $arr_data_coleta_count;
    $arr_JSON['cores_Data_coleta'] = $arr_cores_data_coleta;

    $arr_JSON['data_cadastro'] = $arr_data_cadastro_count;
    $arr_JSON['cores_data_cadastro'] = $arr_cores_data_cadastro;

    $arr_JSON['cadastros_POA'] = $arr_POA_count;
    $arr_JSON['cores_cadastros_POA'] = $arr_cores_POA_count;

    $arr_JSON['idade'] = $arr_idades_count;
    $arr_JSON['cores_idade'] = $arr_cores_idade;

    $arr_JSON['etnia_laudo'] = $arr_etnia_laudo_count;
    $arr_JSON['cores_etnia_laudo'] = $arr_cores_etnia_laudo;

    $arr_JSON['idade_laudo'] = $arr_idade_laudo_count;
    $arr_JSON['cores_idade_laudo'] = $arr_cores_idade_laudo;

    echo "<pre>";
    print_r($arr_JSON);
    echo "</pre>";
    DIE();
    */

}catch(Throwable $e){

    Pagina::getInstance()->processar_excecao($e);
}

function sortByOrder($a, $b) {
    return $a['num'] - $b['num'];
}



Pagina::abrir_head("Gráficos");

?>

    <script type="text/javascript">
        $.ajax({
            url: "<?=Sessao::getInstance()->assinar_link('controlador.php?action=exibir_dados_amostra_paciente') ?>",
            success: function (arr_result) {

                var arr_sexo = arr_result['Sexo'];
                var arr_cores_sexo = arr_result['cores_Sexo'];

                var arr_perfil = arr_result['Perfil'];
                var arr_cores_perfil = arr_result['cores_Perfil'];

                var arr_etnia = arr_result['Etnia'];
                var arr_cores_etnia = arr_result['cores_Etnia'];

                var arr_municipio = arr_result['Municipio'];
                var arr_cores_municipio = arr_result['cores_Municipio'];

                var arr_data_coleta = arr_result['Data_coleta'];
                var arr_cores_data_coleta = arr_result['cores_Data_coleta'];

                var arr_idades = arr_result['idade'];
                var arr_cores_idade = arr_result['cores_idade'];

                var arr_data_cadastro = arr_result['data_cadastro'];
                var arr_cores_data_cadastro = arr_result['cores_data_cadastro'];

                var arr_cadastros_POA = arr_result['cadastros_POA'];
                var arr_cores_cadastros_POA = arr_result['cores_cadastros_POA'];


                var arr_etnia_laudo = arr_result['etnia_laudo'];
                var arr_cores_etnia_laudo = arr_result['cores_etnia_laudo'];

                var arr_idade_laudo = arr_result['idade_laudo'];
                var arr_cores_idade_laudo = arr_result['cores_idade_laudo'];



                var i = 0;
                var nomesSexo = new Array();
                var valoresSexo = new Array();
                for (var sexo in arr_sexo) {
                    console.log(sexo);
                    nomesSexo[i] = sexo + " (" + arr_sexo[sexo] + ")";
                    ;
                    console.log(arr_sexo[sexo]);
                    valoresSexo[i] = arr_sexo[sexo];
                    i++;
                }

                Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                Chart.defaults.global.defaultFontColor = '#858796';

                // Pie Chart Example
                var ctx = document.getElementById("myPieChart");
                var myPieChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: nomesSexo,
                        datasets: [{
                            data: valoresSexo,
                            backgroundColor: arr_cores_sexo,
                            hoverBackgroundColor: arr_cores_sexo,
                            hoverBorderColor: "rgba(234, 236, 244, 1)",
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            caretPadding: 10,
                        },
                        legend: {
                            display: true,
                            position: 'right',
                            fontSize: 12
                        },
                        cutoutPercentage: 50,
                    },
                });

                //--------------------- ETNIA
                var i = 0;
                var nomesEtnia = new Array();
                var valoresEtnia = new Array();
                for (var etnia in arr_etnia) {
                    console.log(etnia);
                    nomesEtnia[i] = etnia + " (" + arr_etnia[etnia] + ")";
                    console.log(arr_etnia[etnia]);
                    valoresEtnia[i] = arr_etnia[etnia];
                    i++;
                }

                Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                Chart.defaults.global.defaultFontColor = '#858796';

                // Pie Chart Example
                var ctxEtnia = document.getElementById("pieChartEtnia");
                var myPieChartEtnia = new Chart(ctxEtnia, {
                    type: 'pie',
                    data: {
                        labels: nomesEtnia,
                        datasets: [{
                            data: valoresEtnia,
                            backgroundColor: arr_cores_etnia,
                            hoverBackgroundColor: arr_cores_etnia,
                            hoverBorderColor: "rgba(234, 236, 244, 1)",
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            caretPadding: 10,
                        },
                        legend: {
                            display: true,
                            position: 'right',
                            fontSize: 12
                        },
                        cutoutPercentage: 50,
                    },
                });


                //--- PERFIL PACIENTE
                var i = 0;
                var nomesPerfil = new Array();
                var valoresPerfil = new Array();
                for (var perfil in arr_perfil) {
                    console.log(perfil);
                    nomesPerfil[i] = perfil + " (" + arr_perfil[perfil] + ")";
                    console.log(arr_perfil[perfil]);
                    valoresPerfil[i] = arr_perfil[perfil];
                    i++;
                }


                Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                Chart.defaults.global.defaultFontColor = '#858796';

                // Pie Chart Example
                var ctxPerfil = document.getElementById("pieChartPerfil");
                var myPieChartPerfil = new Chart(ctxPerfil, {
                    type: 'pie',
                    data: {
                        labels: nomesPerfil,
                        datasets: [{
                            data: valoresPerfil,
                            backgroundColor: arr_cores_perfil,
                            hoverBackgroundColor: arr_cores_perfil,
                            hoverBorderColor: "rgba(234, 236, 244, 1)",
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            caretPadding: 10,
                        },
                        legend: {
                            display: true,
                            position: 'right',
                            fontSize: 12
                        },
                        cutoutPercentage: 1,
                    },
                });


                //--------------------- DATA COLETA
                var i = 0;
                var nomesDataColeta = new Array();
                var valoresDataColeta = new Array();
                var maiorDataColeta = -1;
                for (var dataColeta in arr_data_coleta) {
                    //console.log(dataColeta);
                    nomesDataColeta[i] = dataColeta;
                    //console.log(arr_data_coleta[dataColeta]);
                    valoresDataColeta[i] = arr_data_coleta[dataColeta];
                    if (maiorDataColeta < arr_data_coleta[dataColeta]) {
                        maiorDataColeta = arr_data_coleta[dataColeta];
                    }
                    i++;
                }
                var ctxBar = document.getElementById("barChartDataColeta");
                ctxBar.height = 200;
                var myLineChart = new Chart(ctxBar, {

                    type: 'line',
                    data: {
                        labels: nomesDataColeta,
                        datasets: [{
                            backgroundColor: ['rgba(255,255,255,1)', 'rgba(64,224,208,1)', 'rgba(218,165,32,1)', 'rgba(218,130,238,1)'],
                            borderColor: arr_cores_data_coleta,
                            data: valoresDataColeta
                        }]

                    },
                    options: {
                        scales: {
                            xAxes: [{
                                time: {
                                    unit: 'month'
                                },
                                gridLines: {
                                    display: false
                                },
                                ticks: {
                                    maxTicksLimit: 20
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                    max: maiorDataColeta + 5,
                                    maxTicksLimit: 5
                                },
                                gridLines: {
                                    display: true
                                }
                            }],
                        },
                        legend: {
                            display: false
                        }
                    }
                });


                //--------------------- DATA COLETA
                var i = 0;
                var nomesDataCadastro = new Array();
                var valoresDataCadastro = new Array();
                var maiorDataCadastro = -1;
                for (var dataCadastro in arr_data_cadastro) {
                    //console.log(dataColeta);
                    nomesDataCadastro[i] = dataCadastro;
                    //console.log(arr_data_coleta[dataColeta]);
                    valoresDataCadastro[i] = arr_data_cadastro[dataCadastro];
                    if (maiorDataCadastro < arr_data_cadastro[dataCadastro]) {
                        maiorDataCadastro = arr_data_cadastro[dataCadastro];
                    }
                    i++;
                }
                var ctxBarDataCadastro = document.getElementById("barChartDataCadastro");
                ctxBarDataCadastro.height = 200;
                var lineDataCadastro = new Chart(ctxBarDataCadastro, {

                    type: 'line',
                    data: {
                        labels: nomesDataCadastro,
                        datasets: [{
                            backgroundColor: ['#fff'],
                            borderColor: arr_data_cadastro,
                            data: valoresDataCadastro
                        },
                            {
                                backgroundColor: arr_cores_data_cadastro,
                                borderColor: arr_data_cadastro,
                                data: valoresDataCadastro
                            }]

                    },
                    options: {
                        scales: {
                            xAxes: [{
                                time: {
                                    unit: 'month'
                                },
                                gridLines: {
                                    display: false
                                },
                                ticks: {
                                    maxTicksLimit: 20
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                    max: maiorDataCadastro + 5,
                                    maxTicksLimit: 5
                                },
                                gridLines: {
                                    display: true
                                }
                            }],
                        },
                        legend: {
                            display: false
                        }
                    }
                });


                //--------------------- Municípios
                var i = 0;
                var nomesMunicipios = new Array();
                var valoresMunicipios = new Array();
                var maiorMunicipios = -1;
                for (var municipio in arr_municipio) {
                    //console.log(municipio);
                    nomesMunicipios[i] = municipio;//+" ("+arr_municipio[municipio]+")";
                    //console.log(arr_municipio[municipio]);
                    valoresMunicipios[i] = arr_municipio[municipio];
                    if (maiorMunicipios < arr_municipio[municipio]) {
                        maiorMunicipios = arr_municipio[municipio];
                    }
                    i++;
                }
                var ctxBarMunicipios = document.getElementById("barChartMunicipios");
                ctxBarMunicipios.height = 100;
                var myLineChart = new Chart(ctxBarMunicipios, {
                    type: 'bar',
                    data: {
                        labels: nomesMunicipios,
                        datasets: [{
                            backgroundColor: arr_cores_municipio[0],
                            borderColor: arr_cores_municipio[0],
                            data: valoresMunicipios
                        }]

                    },
                    options: {
                        scales: {
                            xAxes: [{
                                time: {
                                    unit: 'month'
                                },
                                gridLines: {
                                    display: false
                                },
                                ticks: {
                                    maxTicksLimit: 50
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                    max: maiorMunicipios + 5

                                },
                                gridLines: {
                                    display: true
                                }
                            }],
                        },
                        legend: {
                            display: false
                        }
                    }
                });


                //--------------------- Idade
                var i = 0;
                var idades = new Array();
                var valoresIdades = new Array();
                var maiorIdade = -1;
                for (var idade in arr_idades) {
                    //console.log(idade);
                    idades[i] = idade;//+" ("+arr_municipio[municipio]+")";
                    //console.log(arr_idades[idade]);
                    valoresIdades[i] = arr_idades[idade];
                    if (maiorIdade < arr_idades[idade]) {
                        maiorIdade = arr_idades[idade];
                    }
                    i++;
                }
                var ctxBarIdades = document.getElementById("barChartIdade");
                ctxBarIdades.height = 100;
                var myLineChart = new Chart(ctxBarIdades, {
                    type: 'bar',
                    data: {
                        labels: idades,
                        datasets: [{
                            backgroundColor: arr_cores_idade[0],
                            borderColor: arr_cores_idade[0],
                            data: valoresIdades
                        }]

                    },
                    options: {
                        scales: {
                            xAxes: [{
                                time: {
                                    unit: 'month'
                                },
                                gridLines: {
                                    display: false
                                },
                                ticks: {
                                     maxTicksLimit: valoresIdades.length - 10
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                    max: maiorIdade + 2,
                                    //maxTicksLimit: 50
                                },
                                gridLines: {
                                    display: true
                                }
                            }],
                        },
                        legend: {
                            display: false
                        }
                    }
                });


                //--------------------- ETNIA X LAUDO
                var i = 0;
                var nomesetniaLaudo = new Array();
                var valoresetniaLaudo = new Array();
                var maiorEtniaLaudo = -1;
                for (var etniaLaudo in arr_etnia_laudo) {
                    console.log(etniaLaudo);
                    nomesetniaLaudo[i] = etniaLaudo;//+" ("+arr_municipio[municipio]+")";
                    console.log(arr_etnia_laudo[etniaLaudo]);
                    valoresetniaLaudo[i] = arr_etnia_laudo[etniaLaudo];
                    if (maiorEtniaLaudo < arr_etnia_laudo[etniaLaudo]) {
                        maiorEtniaLaudo = arr_etnia_laudo[etniaLaudo];
                    }
                    i++;
                }
                var ctxBarEtniaLaudo = document.getElementById("barChartEtniaLaudo");
                ctxBarEtniaLaudo.height = 100;
                var barEtniaLaudo = new Chart(ctxBarEtniaLaudo, {
                    type: 'horizontalBar',
                    data: {
                        labels: nomesetniaLaudo,
                        datasets: [{
                            backgroundColor: arr_cores_etnia_laudo,
                            borderColor: arr_cores_etnia_laudo,
                            data: valoresetniaLaudo
                        }]

                    },
                    options: {
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: false
                                },
                                ticks: {
                                    min: 0,
                                    max: maiorEtniaLaudo + 1,
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                    max: maiorEtniaLaudo + 1,
                                    //maxTicksLimit: 50
                                },
                                gridLines: {
                                    display: true
                                }
                            }],
                        },
                        legend: {
                            display: false
                        }
                    }
                });

                //--------------------- idade x laudo
                var i = 0;
                var nomesIdadeLaudo = new Array();
                var valoresIdadeLaudo = new Array();
                var maiorIdadeLaudo = -1;
                for (var idadeLaudo in arr_idade_laudo) {
                    console.log(idadeLaudo);
                    nomesIdadeLaudo[i] = idadeLaudo;//+" ("+arr_municipio[municipio]+")";
                    console.log(arr_idade_laudo[idadeLaudo]);
                    valoresIdadeLaudo[i] = arr_idade_laudo[idadeLaudo];
                    if (maiorIdadeLaudo < arr_idade_laudo[idadeLaudo]) {
                        maiorIdadeLaudo = arr_idade_laudo[idadeLaudo];
                    }
                    i++;
                }

                var ctxBarIdadeLaudo = document.getElementById("barChartIdadeLaudo");
                ctxBarIdadeLaudo.height = 100;
                var lineChartIdadeLaudo = new Chart(ctxBarIdadeLaudo, {
                    type: 'line',
                    data: {
                        labels: nomesIdadeLaudo,
                        datasets: [{
                            backgroundColor: ['#fff'],
                            borderColor: arr_cores_idade_laudo,
                            data: valoresIdadeLaudo
                        }]

                    },
                    options: {
                        scales: {
                            xAxes: [{
                                time: {
                                    unit: 'month'
                                },
                                gridLines: {
                                    display: true
                                },
                                ticks: {
                                    maxTicksLimit: maiorIdadeLaudo + 5
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                    max: maiorIdadeLaudo,
                                    maxTicksLimit: 5
                                },
                                gridLines: {
                                    display: true
                                }
                            }],
                        },
                        legend: {
                            display: false
                        }
                    }
                });




                //--------------------- Municípios



                var i = 0;
                var nomesCadastrosPOA = new Array();
                var valoresCadastrosPOA= new Array();
                var maiorCadastroPoa = -1;
                for (var cadastroPOA in arr_cadastros_POA) {
                    //console.log(municipio);
                    nomesCadastrosPOA[i] = cadastroPOA;//+" ("+arr_municipio[municipio]+")";
                    //console.log(arr_municipio[municipio]);
                    valoresCadastrosPOA[i] = arr_cadastros_POA[cadastroPOA];
                    if (maiorCadastroPoa < arr_cadastros_POA[cadastroPOA]) {
                        maiorCadastroPoa = arr_cadastros_POA[cadastroPOA];
                    }
                    i++;
                }
                var ctxBarCadastrosPOA = document.getElementById("barChartCadastroPOA");
                ctxBarCadastrosPOA.height = 100;
                var lineChartCadastroPOA = new Chart(ctxBarCadastrosPOA, {
                    type: 'bar',
                    data: {
                        labels: nomesCadastrosPOA,
                        datasets: [{
                            backgroundColor: arr_cores_cadastros_POA,
                            borderColor: arr_cores_cadastros_POA,
                            data: valoresCadastrosPOA
                        }]

                    },
                    options: {
                        scales: {
                            xAxes: [{
                                time: {
                                    unit: 'month'
                                },
                                gridLines: {
                                    display: false
                                },
                                ticks: {
                                    maxTicksLimit: 50
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                    max: maiorCadastroPoa + 2

                                },
                                gridLines: {
                                    display: true
                                }
                            }],
                        },
                        legend: {
                            display: false
                        }
                    }
                });



            }
    });

    </script>
<?php
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar("GRÁFICOS",null,null,null,null);
Pagina::getInstance()->mostrar_excecoes();

echo '
<!-- Begin Page Content -->
        <div class="container-fluid" style="">

        
          <!-- Content Row -->
          <div class="row">
           
            <!-- Donut Chart -->
            <div class="col-md-6">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header">
                  <h6 class="m-0 font-weight-bold text-primary">Sexo dos pacientes</h6>
                </div>
                <!-- Card Body -->
                 <div class="card-body" style="height: 350px;">
                  <div class="chart-pie" style="height: 310px;width: 100%;">
                    <canvas id="myPieChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
            
             <!-- Donut Chart -->
            <div class="col-md-6">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header">
                  <h6 class="m-0 font-weight-bold text-primary">Etnia dos pacientes</h6>
                </div>
                <!-- Card Body -->
                 <div class="card-body" style="height: 350px;">
                  <div class="chart-pie" style="height: 310px;width: 100%;">
                    <canvas id="pieChartEtnia"></canvas>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="row">
            <!-- Pie Chart -->
            <div class="col-md-6">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header">
                  <h6 class="m-0 font-weight-bold text-primary">Perfis dos pacientes</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body" style="height: 350px;">
                  <div class="chart-pie" style="height: 310px;width: 100%;">
                    <canvas id="pieChartPerfil" ></canvas>
                  </div>
                </div>
              </div>
            </div>
              <!-- Area Chart -->
              <div class="col-md-6">
             <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Cadastros POA</h6>
                    </div>
                    <div class="card-body" style="height: 350px;">
                        <div class="chart-pie" style="height: 250px;width: 100%;">
                            <canvas id="barChartCadastroPOA" ></canvas>
                        </div>
                      
                    </div>
                  </div>
              </div>
        </div>
          <div class="row">
            <div class="col-md-12">

             <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Idade</h6>
                    </div>
                    <div class="card-body" >
                  <div class="chart-bar" style="width: 100%;">
                        <canvas id="barChartIdade"></canvas>
                      </div>
                      
                    </div>
                  </div>
              </div>
                 
         </div>
         <div class="row">
            <div class="col-md-6">
                  <!-- Bar Chart -->
                  <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Idade x Laudo</h6>
                    </div>
                    <div class="card-body" style="height: auto;">
                  <div class="chart-bar" style="height: auto;width: 100%;">
                        <canvas id="barChartIdadeLaudo"></canvas>
                      </div>
                      
                    </div>
                  </div>
             </div>
             <div class="col-md-6">
                  <!-- Bar Chart -->
                  <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Etnia x Laudo</h6>
                    </div>
                    <div class="card-body" style="height: auto;">
                  <div class="chart-bar" style="height: auto;width: 100%;">
                        <canvas id="barChartEtniaLaudo"></canvas>
                      </div>
                      
                    </div>
                  </div>
             </div>
         </div>
          <div class="row">
            <div class="col-md-6">
                  <!-- Bar Chart -->
                  <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Amostras por data de coleta</h6>
                    </div>
                    <div class="card-body" style="height: auto;">
                  <div class="chart-bar" style="height: auto;width: 100%;">
                        <canvas id="barChartDataColeta"></canvas>
                      </div>
                      
                    </div>
                  </div>
             </div>
        <!-- </div>
          <div class="row"> -->
            <div class="col-md-6">
                  <!-- Bar Chart -->
                  <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Amostras por data de cadastro</h6>
                    </div>
                     <div class="card-body" style="height: auto;">
                  <div class="chart-bar" style="height: auto;width: 100%;">
                        <canvas id="barChartDataCadastro"></canvas>
                      </div>
                      
                    </div>
                  </div>
             </div>
             </div>
         <!--</div> -->
             <div class="row">
            <div class="col-md-12">
                
                  <div class="card shadow mb-4">
                    <div class="card-header">
                      <h6 class="m-0 font-weight-bold text-primary">Distribuição por municípios (onde as amostras foram coletas)</h6>
                    </div>
                    <div class="card-body" style="height: auto;">
                      <div class="chart-bar" style="height: auto;width: 100%;">
                        <canvas id="barChartMunicipios"></canvas>
                      </div>

                    </div>
                  </div>
                  </div>  
              </div>      
      <!--  <div class="row">
            <div class="col-md-12">
                 
                  <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Quantidade de amostras por data de coleta</h6>
                    </div>
                    <div class="card-body" style="height: auto;">
                  <div class="chart-bar" style="height: auto;width: 100%;">
                        <canvas id="myBarChart"></canvas>
                      </div>
                      
                    </div>
                  </div>
             </div>
         </div> -->
         <!--
         <div class="row">
            <div class="col-md-12">
                  <div class="card shadow mb-4">
                <div class="card-header">
                  <h6 class="m-0 font-weight-bold text-primary">Distribuição por municípios</h6>
                </div>
                <div class="card-body">
                  <div class="chart-area">
                    <canvas id="barChartMunicipios"></canvas>
                  </div>
                 
                </div>
              </div>
             </div>
         </div>
         -->

          </div>

        </div>
        <!-- /.container-fluid -->';

//echo '<canvas id="myPieChart" width="200px"  height="200px"></canvas>';
//echo "oi";
Pagina::getInstance()->fechar_corpo();