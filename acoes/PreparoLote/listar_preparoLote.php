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


    switch ($_GET['action']){
        case 'remover_montagemGrupo':
            try{
                $objPreparoLote->setIdPreparoLote($_GET['idPreparoLote']);
                $objPreparoLoteRN->remover($objPreparoLote);
            }catch (Throwable $ex){
                Pagina::getInstance()->processar_excecao($ex);
            }
    }



    $arr_preparos = $objPreparoLoteRN->listar_preparos_lote($objPreparoLote,LoteRN::$TL_PREPARO);
    //print_r($arr_preparos);
    //die();




    $a = 0;

    foreach ($arr_preparos as $preparo) {
        //print_r($preparo);
        $strTubos = '';
        $strAmostras = '';
        foreach ($preparo->getObjLote()->getObjsTubo() as $tubo) {
            $strTubos .= $tubo->getIdTubo() . ",";
        }

        $cont = 0;
        foreach ($preparo->getObjLote()->getObjsAmostras() as $amostra) {
            if ($cont == 5) {
                $cont = 0;
                $strAmostras .= "\n";
            }
            $strAmostras .= $amostra->getNickname() . ",";
            $cont++;
        }


        $strTubos = substr($strTubos, 0, -1);
        $strAmostras = substr($strAmostras, 0, -1);

        $style_linha = '';
        if ($preparo->getObjLote()->getSituacaoLote() == LoteRN::$TE_EM_PREPARACAO) {
            $style_linha = ' style="background: rgba(243,108,41,0.2);"';
        }
        if ($preparo->getObjLote()->getSituacaoLote() == LoteRN::$TE_NA_MONTAGEM) {
            $style_linha = ' style="background: rgba(243,108,41,0.2);"';
        }


        $html .= '<tr' . $style_linha . '>           
            <th scope="row" >' . LoteRN::$TNL_ALIQUOTAMENTO . Pagina::formatar_html($preparo->getObjLote()->getIdLote()) . '</th>';


        if ($preparo->getObjLote()->getSituacaoLote() == LoteRN::$TE_PREPARACAO_FINALIZADA) {
            $style = ' style="background: rgba(0,255,0,0.2);"';
        }
        if ($preparo->getObjLote()->getSituacaoLote() == LoteRN::$TE_TRANSPORTE_PREPARACAO) {
            $style = ' style="background:rgba(255,0,0,0.2);"';
        }
        if ($preparo->getObjLote()->getSituacaoLote() == LoteRN::$TE_EM_PREPARACAO || $preparo->getObjLote()->getSituacaoLote() == LoteRN::$TE_NA_MONTAGEM) {
            $style = ' style="background: rgba(243,108,41,0.2);"';
        }
        $html .= '<td' . $style . '>' . Pagina::formatar_html(LoteRN::mostrarDescricaoSituacao($preparo->getObjLote()->getSituacaoLote())) . '</td>';

        $html .= '<td>' . Pagina::formatar_html(LoteRN::mostrarDescricaoTipoLote($preparo->getObjLote()->getTipo())) . '</td>';
        if (Sessao::getInstance()->verificar_permissao('listar_tubos')) {
            $html .= '    <td>' . Pagina::formatar_html($strTubos) . '</td>';
        }
        $html .= '    <td>' . Pagina::formatar_html($strAmostras) . '</td>';
        $html .= '    <td>' . Pagina::formatar_html($preparo->getIdUsuarioFk()) . '</td>';

        $dataHoraInicio = explode(" ", $preparo->getDataHoraInicio());
        $data = explode("-", $dataHoraInicio[0]);

        $diaI = $data[2];
        $mesI = $data[1];
        $anoI = $data[0];

        $html .= '   <td>' . $diaI . '/' . $mesI . '/' . $anoI . ' - ' . $dataHoraInicio[1] . '</td>';

        if ($preparo->getObjLote()->getSituacaoLote() == LoteRN::$TE_PREPARACAO_FINALIZADA) {
            $dataHoraFim = explode(" ", $preparo->getDataHoraFim());
            $data = explode("-", $dataHoraFim[0]);

            $diaF = $data[2];
            $mesF = $data[1];
            $anoF = $data[0];

            $html .= '   <td>' . $diaF . '/' . $mesF . '/' . $anoF . ' - ' . $dataHoraFim[1] . '</td>';
        } else {
            $html .= '<td> </td>';
        }

        //echo 'controlador.php?action=realizar_preparo_inativacao&idPreparoLote=' . Pagina::formatar_html($preparo->getIdPreparoLote()).'&idCapela='. Pagina::formatar_html($preparo->getIdCapelaFk()).'&idSituacao=1'."\n";
        if ($preparo->getObjLote()->getSituacaoLote() == LoteRN::$TE_EM_PREPARACAO) {
            $html .= '<td ><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=realizar_preparo_inativacao&idPreparoLote=' . Pagina::formatar_html($preparo->getIdPreparoLote()) . '&idCapela=' . Pagina::formatar_html($preparo->getIdCapelaFk())) . '&idSituacao=1"><i class="fas fa-exclamation-triangle" style="color: #f36c29;"></i></td>';
        } else if ($preparo->getObjLote()->getSituacaoLote() == LoteRN::$TE_NA_MONTAGEM) {
            $html .= '<td ><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=montar_preparo_extracao&idPreparoLote=' . Pagina::formatar_html($preparo->getIdPreparoLote())) .'"><i class="fas fa-exclamation-triangle" style="color: #f36c29;"></i></td>';
        } else{
            $html .= '<td ></td>';
        }
            /*if($preparo->getObjLote()->getSituacaoLote() == LoteRN::$TE_AGUARDANDO_PREPARACAO || $preparo->getObjLote()->getSituacaoLote() == LoteRN::$TE_TRANSPORTE_PREPARACAO){
                $html .= '<td ><i class="fas fa-times-circle" style="color: #ff0000;"></i></td>';
            }
            if($preparo->getObjLote()->getSituacaoLote() == LoteRN::$TE_PREPARACAO_FINALIZADA){
                $html .= '<td ><i class="fas fa-check-circle" style="color: green;"></i></i></td>';
            }*/

            if (Sessao::getInstance()->verificar_permissao('imprimir_preparo_lote')) {
                $html .= '<td><a target="_blank" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=imprimir_preparo_lote&idPreparoLote=' . Pagina::formatar_html($preparo->getIdPreparoLote())) . '"><i style="color:black;margin: 0px; padding: 0px;" class="fas fa-print"></i></a></td>';
            }

            if (Sessao::getInstance()->verificar_permissao('remover_montagemGrupo')) {
                $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_montagemGrupo&idPreparoLote=' . Pagina::formatar_html($preparo->getIdPreparoLote())) . '"><i class="fas fa-trash-alt"></i></a></td>';
            }


            $html .= '</tr>';
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
Pagina::getInstance()->mostrar_excecoes();
echo $alert;

echo '<div id="tabela_preparos" style="margin-top: -50px;">
        <div class="conteudo_tabela " >
            <table class="table table-hover table-responsive table-sm"  >
                <thead>
                    <tr>
                        <th  scope="col">LOTE</th>
                        <th  scope="col">SITUAÇÃO LOTE</th>
                        <th  scope="col">TIPO LOTE</th>';
                if (Sessao::getInstance()->verificar_permissao('listar_tubos')) {
                    echo '<th  scope="col">TUBOS</th>';
                }
                  echo '<th  scope="col">AMOSTRAS</th>
                        <th scope="col">ID USUÁRIO</th>
                        <th  scope="col">DATA HORA INÍCIO</th>
                        <th  scope="col">DATA HORA TÉRMINO</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
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


Pagina::getInstance()->fechar_corpo();
