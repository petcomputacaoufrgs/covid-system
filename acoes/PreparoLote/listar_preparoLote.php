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

    require_once __DIR__ . '/../../classes/Usuario/Usuario.php';
    require_once __DIR__ . '/../../classes/Usuario/UsuarioRN.php';

    require_once __DIR__ . '/../../classes/Pesquisa/PesquisaINT.php';

    require_once __DIR__ . '/../../classes/Lote/Lote.php';
    require_once __DIR__ . '/../../classes/Lote/LoteRN.php';
    require_once __DIR__ . '/../../classes/Lote/LoteINT.php';

    require_once __DIR__ . '/../../classes/Capela/Capela.php';
    require_once __DIR__ . '/../../classes/Capela/CapelaRN.php';

    require_once __DIR__ . '/../../classes/KitExtracao/KitExtracao.php';
    require_once __DIR__ . '/../../classes/KitExtracao/KitExtracaoRN.php';

    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTexto.php';
    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTextoRN.php';

    require_once __DIR__. '/../../classes/KitExtracao/KitExtracaoINT.php';



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

    /*
    * Objeto Usuário
    */
    $objUsuario = new Usuario();
    $objUsuarioRN = new UsuarioRN();


    /*
     * Objeto Capela
     */
    $objCapela = new Capela();
    $objCapelaRN = new CapelaRN();

    $objLote = new Lote();


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
                header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_preparo_lote'));
                die();
            }catch (Throwable $ex){
                Pagina::getInstance()->processar_excecao($ex);
            }
    }




    /* PESQUISA */
    $array_colunas = array('Nº LOTE', 'SITUAÇÃO LOTE','CAPELA');//,'DATA HORA INÍCIO','DATA HORA TÉRMINO');
    $array_tipos_colunas = array('text', 'selectSituacaoLote','text');//,'text');
    $valorPesquisa = '';
    $select_situacao_lote = '';
    $select_kits_extracao = '';

    PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, null,null,' onchange="this.form.submit()" ');


    if(isset($_POST['sel_pesquisa_coluna']) ){

        PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, $_POST['sel_pesquisa_coluna'],null,' onchange="this.form.submit()" ');
        if($array_tipos_colunas[$_POST['sel_pesquisa_coluna']] == 'selectSituacaoLote'){
            LoteINT::montar_select_situacao_lote($select_situacao_lote, null, null,null);
            $input = $select_situacao_lote;
        }else {
            //echo $array_tipos_colunas[$_POST['sel_pesquisa_coluna']];
            $input = '<input type="' . $array_tipos_colunas[$_POST['sel_pesquisa_coluna']] . '" value="' . $_POST['valorPesquisa'] .
                '" placeholder="' . $array_colunas[$_POST['sel_pesquisa_coluna']] . '" name="valorPesquisa" aria-label="Search" class="form-control">';
        }
    }ELSE{
        $input = '<input type="text" disabled value="" id="pesquisaDisabled" placeholder="" name="valorPesquisa" aria-label="Search" class="form-control">';
    }

    if(!isset($_POST['hdnPagina'])){
        $objPreparoLote->setNumPagina(1);
    } else {
        $objPreparoLote->setNumPagina($_POST['hdnPagina']);
    }

    $objLote->setTipo(LoteRN::$TL_PREPARO);
    $objPreparoLote->setObjLote($objLote);

    if(isset($_POST['valorPesquisa']) || isset($_POST['sel_situacao_lote']) || isset($_POST['sel_kit_extracao'])){


        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'Nº LOTE'){
            $objLote->setIdLote($_POST['valorPesquisa']);
            $objPreparoLote->setObjLote($objLote);
        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'SITUAÇÃO LOTE'){
            $objLote->setSituacaoLote($_POST['sel_situacao_lote']);
            LoteINT::montar_select_situacao_lote($select_situacao_lote, $_POST['sel_situacao_lote'], null,null);
            $input = $select_situacao_lote;
            $objPreparoLote->setObjLote($objLote);

        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'CAPELA'){
            $objCapela->setNumero($_POST['valorPesquisa']);
            $objPreparoLote->setObjCapela($objCapela);

        }


    }

    /* FIM PESQUISA */



    $arrPreparos = $objPreparoLoteRN->paginacao($objPreparoLote);
    $alert .= Alert::alert_info("Foram encontrados ".$objPreparoLote->getTotalRegistros()." lotes");


    /*
     * PAGINAÇÃO
     */

    $paginacao = '
                    <nav aria-label="Page navigation example">
                      <ul class="pagination">';
    $paginacao .= '<li class="page-item"><input type="button" onclick="paginar(1)" class="page-link" name="btn_paginacao" value="Primeiro"/></li>';
    for($i=0; $i<($objPreparoLote->getTotalRegistros()/20); $i++){
        $color = '';
        if($objPreparoLote->getNumPagina() == $i ){
            $color = ' style="background-color: #d2d2d2;" ';
        }
        $paginacao .= '<li '.$color.' class="page-item"><input type="button" onclick="paginar('.($i+1).')" class="page-link" name="btn_paginacao" value="'.($i+1).'"/></li>';
    }
    //$paginacao .= '<li class="page-item"><input type="button" onclick="paginar('.($objAmostra->getTotalRegistros()-1).')" class="page-link" name="btn_paginacao" value="Último"/></li>';
    $paginacao .= '  </ul>
                    </nav>';

    $a = 0;

    foreach ($arrPreparos as $preparo) {
        $objLote = $preparo->getObjLote();
        $strTubos = '';
        $strAmostras = '';
        $contador = 0;
        $contadorAmostra = 0;
        foreach($objLote->getObjRelTuboLote() as $tubo){
            $strTubos .= $tubo->getIdTubo_fk().",";
            /*$contador++;
            if($contador == 3){
                $strTubos .= "\n";
                $contador = 0;
            }*/


            foreach ($tubo->getObjTubo() as $amostra) {
                $strAmostras .=  $amostra->getNickname() ."(".TuboRN::mostrarDescricaoTipoTubo($amostra->getObjTubo()->getTipo())."),\n";
                //$contadorAmostra++;
                /*if ($contadorAmostra == 3) {
                    $contadorAmostra = 0;
                    $strAmostras .= "\n";
                }*/

               // $arr_tipos[] = $amostra->getObjTubo()->getTipo();
            }
        }

        //print_r($arr_tipos);

        $strTubos = substr($strTubos, 0,-1);
        $strAmostras = substr($strAmostras, 0,-2);


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

        if (Sessao::getInstance()->verificar_permissao('listar_tubos')) {
            $html .= '    <td style="white-space: pre-wrap;">' . Pagina::formatar_html($strTubos) . '</td>';
        }
        $html .= '    <td style="white-space: pre-wrap;">' . Pagina::formatar_html($strAmostras) . '</td>';

        if($preparo->getObjCapela() != null) { $html .= '    <td style="white-space: pre-wrap;">' . Pagina::formatar_html($preparo->getObjCapela()->getNumero()) . '</td>';
        }else { $html .= '    <td style="white-space: pre-wrap;"> - </td>'; }


        if($preparo->getNomeResponsavel() != null || $preparo->getIdResponsavel() != null) {
            $idResp = '';
            if ($preparo->getIdResponsavel()) {
                $idResp = '(' . $preparo->getIdResponsavel() . ')';
            }
            $html .= '    <td>' . Pagina::formatar_html($preparo->getNomeResponsavel()) . " " . $idResp . '</td>';
        }else { $html .= '    <td> - </td>'; }

        $html .= '    <td>' . Pagina::formatar_html($preparo->getObjUsuario()->getMatricula()) . '</td>';

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
            $html .= '<td> - </td>';
        }

        //echo 'controlador.php?action=realizar_preparo_inativacao&idPreparoLote=' . Pagina::formatar_html($preparo->getIdPreparoLote()) . '&idCapela=' . Pagina::formatar_html($preparo->getIdCapelaFk()) . '&idSituacao=1'."\n";

        if ($preparo->getObjLote()->getSituacaoLote() == LoteRN::$TE_EM_PREPARACAO) {
            if (Sessao::getInstance()->verificar_permissao('realizar_preparo_inativacao')) {
                $html .= '<td ><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=realizar_preparo_inativacao&idPreparoLote=' . Pagina::formatar_html($preparo->getIdPreparoLote()) . '&idCapela=' . Pagina::formatar_html($preparo->getIdCapelaFk())) . '&idSituacao=1"><i class="fas fa-exclamation-triangle" style="color: #f36c29;"></i></td>';
            }else{
                $html .= '<td> - </td>';
            }
        } else if ($preparo->getObjLote()->getSituacaoLote() == LoteRN::$TE_NA_MONTAGEM) {
            //echo 'controlador.php?action=montar_preparo_extracao&idPreparoLote=' . Pagina::formatar_html($preparo->getIdPreparoLote())."\n";
            if (Sessao::getInstance()->verificar_permissao('montar_preparo_extracao')) {
                $html .= '<td ><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=montar_preparo_extracao&idPreparoLote=' . Pagina::formatar_html($preparo->getIdPreparoLote())) . '"><i class="fas fa-exclamation-triangle" style="color: #f36c29;"></i></td>';
            }else{
                $html .= '<td > - </td>';
            }
        } else{
            $html .= '<td> - </td>';
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
Pagina::getInstance()->adicionar_javascript("pesquisa_pg");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('LISTAR PREPARO DOS GRUPOS', null, null, 'montar_preparo_extracao', 'NOVO GRUPO DE AMOSTRAS');
Pagina::getInstance()->mostrar_excecoes();
echo $alert;
Pagina::montar_topo_pesquisar($select_pesquisa, $input, null,null);

echo '

    <form method="post" style="height:40px;margin-left: 1%;width: 98%;">
             <div class="form-row">
                <div class="col-md-12" >
                    '.$paginacao.'
                 </div>
             </div>
         </form>
    
    <div id="tabela_preparos" style="margin-top: -30px;">
        <div class="conteudo_tabela " >
            <table class="table table-hover"  >
                <thead>
                    <tr>
                        <th  scope="col">Nº LOTE</th>
                        <th  scope="col">SITUAÇÃO LOTE</th>';
                if (Sessao::getInstance()->verificar_permissao('listar_tubos')) {
                    echo '<th  scope="col">TUBOS</th>';
                }
                  echo '<th  scope="col">AMOSTRAS</th>
                        <th  scope="col">Nº CAPELA</th>
                        <th scope="col">RESPONSÁVEL</th>
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
