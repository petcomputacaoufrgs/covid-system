<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

try {
    session_start();
    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';
    require_once __DIR__.'/../../utils/Alert.php';

    require_once __DIR__.'/../../classes/Amostra/Amostra.php';
    require_once __DIR__.'/../../classes/Amostra/AmostraRN.php';

    require_once __DIR__.'/../../classes/PerfilPaciente/PerfilPaciente.php';
    require_once __DIR__.'/../../classes/PerfilPaciente/PerfilPacienteRN.php';

    require_once __DIR__.'/../../classes/Tubo/Tubo.php';
    require_once __DIR__.'/../../classes/Tubo/TuboRN.php';

    require_once __DIR__.'/../../classes/Paciente/Paciente.php';
    require_once __DIR__.'/../../classes/Paciente/PacienteRN.php';

    require_once __DIR__.'/../../classes/InfosTubo/InfosTubo.php';
    require_once __DIR__.'/../../classes/InfosTubo/InfosTuboRN.php';

    require_once __DIR__.'/../../classes/Situacao/Situacao.php';


    Sessao::getInstance()->validar();


    $array_colunas = array('CÓDIGO', 'SITUAÇÃO AMOSTRA', 'DATA COLETA','PERFIL AMOSTRA','CADASTRO PENDENTE');
    $array_tipos_colunas = array('text', 'text', 'date', 'text','select');

    $value = '';
    $retornou_certo = false;
    $options = '';
    $position = null;
    $inputs = '';
    $error = '';
    $arrAmostras_pesquisa = array();
    $valor_selecionado = '';
    $select_a_r_g='';
    $select_perfis = '';
    $disabled = '';$onchange ='';

    /* AMOSTRA */
    $objAmostra = new Amostra();
    $objAmostraRN = new AmostraRN();


    //$objAmostraRN->arrumar_banco($objAmostra);



    /* PERFIL PACIENTE */
    $objPerfilPaciente = new PerfilPaciente();
    $objPerfilPacienteRN = new PerfilPacienteRN();

    /* PACIENTE */
    $objPaciente = new Paciente();
    $objPacienteRN = new PacienteRN();

    /* TUBO */
    $objTubo = new Tubo();
    $objTuboRN = new TuboRN();


    /* INFOS TUBO */
    $objInfosTubo = new InfosTubo();
    $objInfosTuboRN = new InfosTuboRN();


    $alert = '';
    $html = '';

    $options = InterfacePagina::montar_select_pesquisa($array_colunas,$position);

    if(isset($_POST['selecionar_amostra'])) {
        if (isset($_POST['txtCodAmostra'])) {

            //$id = substr($_POST['txtCodAmostra'], 1);
            $objAmostra->setNickname(strtoupper($_POST['txtCodAmostra']));
            $arr_tubos = $objAmostraRN->obter_infos($objAmostra);


            foreach ($arr_tubos as $tubo) {
                foreach ($tubo->getObjInfosTubo() as $info) {

                    $dataHora = explode(" ", $info->getDataHora());
                    $data = explode("-", $dataHora[0]);

                    $ano = $data[0];
                    $mes = $data[1];
                    $dia = $data[2];

                    $data = $dia . '/' . $mes . '/' . $ano . ' ' . $dataHora[1];

                    $corTd = '';
                    if($tubo->getTipo()  == TuboRN::$TT_ALIQUOTA){
                        //$corDescarte = ' style="color: black; font-weight:bold;" ';
                        $corTd = 'style="background-color: rgba(255,255,0,0.1);" ';
                    }
                    $corDescarte = '';$corTr ='';
                    if($info->getSituacaoTubo() == InfosTuboRN::$TST_DESCARTADO_NO_MEIO_ETAPA ||  $info->getSituacaoTubo() == InfosTuboRN::$TST_DESCARTADO || $info->getSituacaoTubo() == InfosTuboRN::$TST_LOCAL_ERRADO_POCO){
                        $corDescarte = ' style="color:red;" ';
                        $corTr = 'style="background-color: rgba(255,0,0,0.1);" ';
                    }


                    $html .= '<tr '.$corTr.'><th scope="row">' . Pagina::formatar_html($objAmostra->getNickname()) . '</th>';
                    if (Sessao::getInstance()->verificar_permissao('listar_tubos')) {
                        $html .= '<td>' . Pagina::formatar_html($info->getIdInfosTubo()) . '</td>';
                        $html .= '<td>' . Pagina::formatar_html($tubo->getIdTubo()) . '</td>';
                        $html .= '<td>' . Pagina::formatar_html($tubo->getIdTubo_fk()) . '</td>';
                    }
                    $original = '';
                    if($tubo->getTuboOriginal() == 's'){
                        $original = 'Sim';
                    }else{
                        $original = 'Não';
                    }

                    $reteste = '';
                    if($info->getReteste() == 's'){
                        $reteste = 'Sim';
                    }else{
                        $reteste = 'Não';
                    }



                    $html .= '<td>' . Pagina::formatar_html($original) . '</td>';
                    $html .= '<td '.$corTd.'>' . Pagina::formatar_html(TuboRN::mostrarDescricaoTipoTubo($tubo->getTipo())) . '</td>
                        <td>' . Pagina::formatar_html($reteste) . '</td>
                        <td>' . Pagina::formatar_html($info->getVolume()) . '</td>
                        <td '.$corDescarte.'>' . Pagina::formatar_html(InfosTuboRN::retornarStaTubo($info->getSituacaoTubo())) . '</td>
                        <td>' . Pagina::formatar_html(InfosTuboRN::retornarStaEtapa($info->getSituacaoEtapa())) . '</td>
                            <td>' . Pagina::formatar_html(InfosTuboRN::retornarEtapa($info->getEtapa())) . '</td>
                        <td>' . Pagina::formatar_html(InfosTuboRN::retornarEtapa($info->getEtapaAnterior())) . '</td>
              <td>' . Pagina::formatar_html($info->getObservacoes()) . '</td>
                    <td>' . Pagina::formatar_html($data) . '</td>
                        
                    </tr>';
                }

            }
        }
    }




} catch (Throwable $ex) {
    //die($ex);
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Listar Amostras");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('RASTREAMENTO DE AMOSTRAS', null, null, 'cadastrar_amostra', 'NOVA AMOSTRA');


echo $alert;


echo '  <div class="conteudo_grande">
        <form method="POST"  >
        <div class="form-row" >
            <div class="col-md-10" style="width: 100%;">
                <label>Informe o código da amostra</label>
                <input type="text" class="form-control" id="idCodAmostra" style="text-align: center;"
                       name="txtCodAmostra"  value="'.$objAmostra->getNickname().'">
            </div>
            <div class="col-md-2">
              <button class="btn btn-primary" type="submit"  style="margin-top: 33px;width: 100%;margin-left: 0px;" name="selecionar_amostra">SELECIONAR</button>
            </div>
            </div>
        </form>
        </div>';



echo '<div id="tabela_preparos">
        <div class="conteudo_tabela">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th scope="col">COD AMOSTRA</th>';
                if (Sessao::getInstance()->verificar_permissao('listar_tubos')) {
                    echo '<th scope="col">COD INFOS</th>
                        <th scope="col">COD TUBO</th>
                        <th scope="col">ORIGINADO PELO TUBO</th>';
                }
                        echo '<th scope="col">AMOSTRA ORIGINAL</th>
                        <th scope="col">TIPO</th>
                        <th scope="col">RETESTE</th>
                        <th scope="col">VOLUME</th>
                        <th scope="col">SITUAÇÃO AMOSTRA</th>
                        <th scope="col">SITUAÇÃO ETAPA</th>
                        <th scope="col">ETAPA</th>
                        <th scope="col">ETAPA ANTERIOR</th>
                        <th scope="col">OBS</th>
                        <th scope="col">DATA HORA</th>
                    </tr>
                </thead>
                <tbody>'
    . $html .
    '</tbody>
            </table>
        </div>
    </div>
    ';


Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();
