<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();

try {
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

    require_once __DIR__ . '/../../classes/PreparoLote/PreparoLote.php';
    require_once __DIR__ . '/../../classes/PreparoLote/PreparoLoteRN.php';

    Sessao::getInstance()->validar();


    $value = '';
    $retornou_certo = false;
    $options = '';
    $position = null;
    $inputs = '';
    $error = '';
    $arrAmostras_pesquisa = array();
    $disabled = '';$onchange ='';

    /* AMOSTRA */
    $objAmostra = new Amostra();
    $objAmostraRN = new AmostraRN();

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

    $botoes_aparecer = false;

    $objPreparoLote = new PreparoLote();
    $objPreparoLoteRN = new PreparoLoteRN();

    $arr_preparos = $objPreparoLoteRN->listar_preparos_lote($objPreparoLote,LoteRN::$TL_PREPARO);
    //print_r($arr_preparos);
    //die();

    $a = 0;

    foreach ($arr_preparos as $preparo) {
        $strTubos = '';
        foreach($preparo->getObjLote()->getObjsTubo() as $tubo){
            $strTubos .= $tubo->getIdTubo().",";
        }
        //print_r($preparo);

        $strTubos = substr($strTubos, 0,-1);

        $html .= '<tr>
            <th scope="row" >' . Pagina::formatar_html($preparo->getIdPreparoLote()) . '</th>
            <td>' . Pagina::formatar_html($preparo->getObjLote()->getIdLote()) . '</td>
            <td>' . Pagina::formatar_html(LoteRN::mostrarDescricaoSituacao($preparo->getObjLote()->getSituacaoLote())) . '</td>
            <td>' . Pagina::formatar_html(LoteRN::mostrarDescricaoTipoLote($preparo->getObjLote()->getTipo())) . '</td>
            <td>' . Pagina::formatar_html($strTubos) . '</td>
            <td>' . Pagina::formatar_html($preparo->getIdUsuarioFk()) . '</td>';

        $dataHoraInicio = explode(" ", $preparo->getDataHoraInicio());
        $data = explode("-", $dataHoraInicio[0]);

        $diaI = $data[2];
        $mesI = $data[1];
        $anoI = $data[0];

        $html .= '   <td>' . $diaI. '/'.$mesI.'/'.$anoI.' - '.$dataHoraInicio[1] . '</td>';

        $dataHoraFim = explode(" ", $preparo->getDataHoraFim());
        $data = explode("-", $dataHoraFim[0]);

        $diaF = $data[2];
        $mesF = $data[1];
        $anoF = $data[0];

        $html .= '   <td>' . $diaF. '/'.$mesF.'/'.$anoF.' - '.$dataHoraFim[1] . '</td>';
            
                                                                  
                /*<td class="td_a">';

            if (Sessao::getInstance()->verificar_permissao('editar_preparoLote')) {
                $html .= '<a href="' .
                    Sessao::getInstance()->assinar_link('controlador.php?action=editar_preparoLote&idPreparoLote=' . Pagina::formatar_html($preparo->getIdPreparoLote())) . '"><i class="fas fa-edit"></i></a>';
            }*/
            $html .= '<td >';
            if (Sessao::getInstance()->verificar_permissao('remover_montagemGrupo')) {
                $html .= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_montagemGrupo&idPreparoLote=' . Pagina::formatar_html($preparo->getIdPreparoLote())) . '"><i class="fas fa-trash-alt"></i></a>';
            }
            $html .= '</td></tr>';
            $a++;
    }


} catch (Throwable $ex) {
    //die($ex);
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Listar Grupos");
Pagina::getInstance()->adicionar_css("precadastros");

Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('LISTAR PREPARO DOS GRUPOS', null, null, 'montar_preparo_extracao', 'NOVO GRUPO DE AMOSTRAS');
echo $alert;

echo '<div id="tabela_preparos" style="margin-top: -50px;">
        <div class="conteudo_tabela " >
            <table class="table table-hover table-sm" >
                <thead>
                    <tr>
                        <th scope="col">Nº PREPARO</th>
                        <th  scope="col">Nº LOTE</th>
                        <th  scope="col">SITUAÇÃO LOTE</th>
                        <th  scope="col">TIPO LOTE</th>
                        <th  scope="col">TUBOS</th>
                        <th scope="col">ID USUÁRIO</th>
                        <th  scope="col">DATA HORA INÍCIO</th>
                        <th  scope="col">DATA HORA TÉRMINO</th>
                        <th scope="col"></th>
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
