<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: application/json; charset=utf-8');
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

    //sort($arr_municipios);



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

    $arr_JSON['Municipio'] = $arr_municipios_ordenada;
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

    /*$arr_JSON['TESTE'] = " datasets: [{
                                            label: 'Bar Dataset',
                                            data: [10, 20, 30, 40]
                                        }, {
                                            label: 'Line Dataset',
                                            data: [50, 50, 50, 50],
                
                                            // Changes this dataset to become a line
                                            type: 'line'
                                        }],
                                        labels: ['January', 'February', 'March', 'April']";
*/

    /*echo "<pre>";
    print_r($arr_JSON);
    echo "</pre>";*/

    echo json_encode( $arr_JSON);

}catch(Throwable $e){
    die($e);
}
function sortByOrder($a, $b) {
    return $a['num'] - $b['num'];
}