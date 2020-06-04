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
    require_once __DIR__.'/../../classes/Amostra/AmostraINT.php';

    require_once __DIR__.'/../../classes/PerfilPaciente/PerfilPaciente.php';
    require_once __DIR__.'/../../classes/PerfilPaciente/PerfilPacienteRN.php';
    require_once __DIR__.'/../../classes/PerfilPaciente/PerfilPacienteINT.php';

    require_once __DIR__.'/../../classes/Tubo/Tubo.php';
    require_once __DIR__.'/../../classes/Tubo/TuboRN.php';

    require_once __DIR__.'/../../classes/Paciente/Paciente.php';
    require_once __DIR__.'/../../classes/Paciente/PacienteRN.php';

    require_once __DIR__.'/../../classes/InfosTubo/InfosTubo.php';
    require_once __DIR__.'/../../classes/InfosTubo/InfosTuboRN.php';

    require_once __DIR__.'/../../classes/Pesquisa/PesquisaINT.php';
    require_once __DIR__.'/../../classes/Paciente/PacienteINT.php';

    Sessao::getInstance()->validar();

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


    $valorInput1 = '';
    $inputs = '';
    $alert = '';
    $html = '';

    $objAmostra = new Amostra();


    /* PESQUISA */


    $array_colunas = array('CÓDIGO', 'SITUAÇÃO AMOSTRA', 'DATA COLETA','PERFIL AMOSTRA','CADASTRO PENDENTE','NOME PACIENTE');
    $array_tipos_colunas = array('text', 'selectSituacao', 'date', 'selectPerfil','selectCadastroPendente','text');
    $valorPesquisa = '';
    $select_pesquisa = '';
    $select_situacao_lote = '';
    $select_a_r_g='';
    PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, null,null,' onchange="this.form.submit()" ');


    $select_cadastro_pendente = '';
    $select_perfis = '';



    if(isset($_POST['sel_pesquisa_coluna']) ){

        PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, $_POST['sel_pesquisa_coluna'],null,' onchange="this.form.submit()" ');
        if($array_tipos_colunas[$_POST['sel_pesquisa_coluna']] == 'selectSituacao'){
            AmostraINT::montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, null, null);
            $input = $select_a_r_g;
        }else if($array_tipos_colunas[$_POST['sel_pesquisa_coluna']] == 'selectPerfil'){
            PerfilPacienteINT::montar_select_perfilPaciente_caractere($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, null,null);
            $input = $select_perfis;
        } else if($array_tipos_colunas[$_POST['sel_pesquisa_coluna']] == 'selectCadastroPendente'){
            PacienteINT::montar_select_cadastro_pendente($select_cadastro_pendente,$objPaciente,null,null);
            $input = $select_cadastro_pendente;
        } else {
            //echo $array_tipos_colunas[$_POST['sel_pesquisa_coluna']];
            $input = '<input type="' . $array_tipos_colunas[$_POST['sel_pesquisa_coluna']] . '" value="' . $_POST['valorPesquisa'] .
                '" placeholder="' . $array_colunas[$_POST['sel_pesquisa_coluna']] . '" name="valorPesquisa" aria-label="Search" class="form-control">';
        }
    }ELSE{
        $input = '<input type="text" disabled value="" id="pesquisaDisabled" placeholder="" name="valorPesquisa" aria-label="Search" class="form-control">';
    }

       if(!isset($_POST['hdnPagina'])){
           $objAmostra->setNumPagina(1);
       } else {
           $objAmostra->setNumPagina($_POST['hdnPagina']);
       }



        if(isset($_POST['valorPesquisa']) || isset($_POST['sel_cadastro_pendente'])
            || isset($_POST['sel_perfil_caractere']) || isset($_POST['sel_a_r_g']) ){


            if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'CÓDIGO' ){
                $objAmostra->setNickname(strtoupper($_POST['valorPesquisa']));
            }

            if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'SITUAÇÃO AMOSTRA'){
                $objAmostra->set_a_r_g($_POST['sel_a_r_g']);
                AmostraINT::montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, null, null);
                $input = $select_a_r_g;
            }

            if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'PERFIL AMOSTRA'){
                $objPerfilPaciente->setCaractere($_POST['sel_perfil_caractere']);
                PerfilPacienteINT::montar_select_perfilPaciente_caractere($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, null,null);
                $input = $select_perfis;
                $objAmostra->setObjPerfil($objPerfilPaciente);

            }

            if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'CADASTRO PENDENTE'){
                $objPaciente->setCadastroPendente($_POST['sel_cadastro_pendente']);
                PacienteINT::montar_select_cadastro_pendente($select_cadastro_pendente,$objPaciente,null,null);
                $input = $select_cadastro_pendente;
                $objAmostra->setObjPaciente($objPaciente);
            }

            if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'NOME PACIENTE'){
                $objPaciente->setNome($_POST['valorPesquisa']);
                $objAmostra->setObjPaciente($objPaciente);
            }

            if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'DATA COLETA'){
                $objAmostra->setDataColeta($_POST['valorPesquisa']);
            }





            /*if(isset($_POST['valorPesquisa'])){
                $valor =" e valor <strong>".$_POST['valorPesquisa'].'</strong>';
            }
            if(isset($_POST['sel_cadastro_pendente'])){
                if($_POST['sel_cadastro_pendente'] == 's'){ $s_n = 'sim';}
                if($_POST['sel_cadastro_pendente'] == 'n'){ $s_n = 'não';}
                $valor =" e valor <strong>".$s_n.'</strong>';
            }
            if(isset($_POST['sel_perfil_caractere'])){
                $valor =" e valor <strong>".PerfilPacienteRN::mostrarDescricaoTipo($_POST['sel_perfil_caractere']).'</strong>';
            }
            if(count($arrAmostras) == 0){
                $alert = Alert::alert_warning("Nenhuma amostra foi encontrado com o campo <strong>".$array_colunas[$_POST['sel_pesquisa_coluna']].'</strong>'.$valor);
            }else{
                $alert = Alert::alert_success("Foram encontradas ".count($arrAmostras)." amostras com o campo <strong>".$array_colunas[$_POST['sel_pesquisa_coluna']].'</strong>'.$valor);
            }*/
        }


    $arrAmostras = $objAmostraRN->paginacao($objAmostra);
        $alert .= Alert::alert_info("Foram encontradas ".$objAmostra->getTotalRegistros()." amostras");

        /*
        * PAGINAÇÃO
        */
        $paginacao = '
                    <nav aria-label="Page navigation example">
                      <ul class="pagination">';
        $paginacao .= '<li class="page-item"><input type="button" onclick="paginar(1)" class="page-link" name="btn_paginacao" value="Primeiro"/></li>';
        for($i=0; $i<($objAmostra->getTotalRegistros()/100); $i++){
            $color = '';
            if($objAmostra->getNumPagina() == $i ){
                $color = ' style="background-color: #d2d2d2;" ';
            }
            $paginacao .= '<li '.$color.' class="page-item"><input type="button" onclick="paginar('.($i+1).')" class="page-link" name="btn_paginacao" value="'.($i+1).'"/></li>';
        }
        //$paginacao .= '<li class="page-item"><input type="button" onclick="paginar('.($objAmostra->getTotalRegistros()-1).')" class="page-link" name="btn_paginacao" value="Último"/></li>';
        $paginacao .= '  </ul>
                    </nav>';


      /* FIM PESQUISA */


    foreach ($arrAmostras as $amostra){

        if($amostra->get_a_r_g() == 'a'){
            $texto = "ACEITA";
            $color = ' style="background-color: rgba(0,255,0,0.2);" ';
        }else if($amostra->get_a_r_g() == 'r'){
            $texto = "RECUSADA";
            $color = ' style="background-color: rgba(255,0,0,0.2);" ';
        }else{
            $texto = "AGUARDANDO";
            $color = ' style="background-color: rgba(255,255,0,0.2);" ';
        }

        $html .= '<tr>
                    <th scope="row">' . Pagina::formatar_html($amostra->getNickname()) . '</th>
                    <td>' . Pagina::formatar_html($amostra->getObjPaciente()->getNome()) . '</td>
                    <td '.$color.'>' . Pagina::formatar_html($texto) . '</td>';



            $data = explode("-", $amostra->getDataColeta());

            $diaF = $data[2];
            $mesF = $data[1];
            $anoF = $data[0];

            $html .= '   <td>' . $diaF . '/' . $mesF . '/' . $anoF . '</td>';



        $html .= '          <td>' . Pagina::formatar_html($amostra->getObjPerfil()->getPerfil()) . '</td>';

        if($amostra->getObjPaciente()->getCadastroPendente() == 's'){
            $valor = ' sim ';
        }
        if($amostra->getObjPaciente()->getCadastroPendente() == 'n'){
            $valor = ' não ';
        }
        $html .= '<td>' . Pagina::formatar_html($valor) . '</td>';
        /*
        $html .= '<td><button type="button" class="btn btn-secondary tooltip_obs"  data-toggle="tooltip" data-html="true" title="'.$amostra->getObservacoes().'">
            <i class="fas fa-comment-dots fa-2x"></i>
        </button></td>';
        */
        $html .= '<td style="width: 30px;">'.$amostra->getObservacoes().'</button></td>';

        //echo 'controlador.php?action=editar_amostra&idAmostra=' . Pagina::formatar_html($amostra->getIdAmostra().'&idPaciente=' . Pagina::formatar_html($amostra->getObjPaciente()->getIdPaciente()));
        //editar amostra
        if (Sessao::getInstance()->verificar_permissao('editar_amostra')) {
            $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_amostra&idAmostra=' . Pagina::formatar_html($amostra->getIdAmostra()).'&idPaciente=' . Pagina::formatar_html($amostra->getObjPaciente()->getIdPaciente())) . '"><i class="fas fa-edit" style="color: black;"></i></a></td>';
        }else{
            $html .= '<td ></td>';
        }

        if (Sessao::getInstance()->verificar_permissao('remover_amostra')) {
            $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_amostra&idAmostra=' . Pagina::formatar_html($amostra->getIdAmostra())) . '"><i class="fas fa-trash-alt"></i></a></td>';
        }else{
            $html .= '<td ></td>';
        }

        $html .= '</tr>';

    }


} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Listar Amostras");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("pesquisa_pg");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('LISTAR AMOSTRAS', null, null, 'cadastrar_amostra', 'NOVA AMOSTRA');
Pagina::getInstance()->mostrar_excecoes();
echo $alert;
Pagina::montar_topo_pesquisar($select_pesquisa, $input);

echo '
        
        <form method="post" style="height:40px;margin-left: 1%;width: 98%;">
             <div class="form-row">
                <div class="col-md-12" >
                    '.$paginacao.'
                 </div>
             </div>
         </form>

        <div class="conteudo_tabela">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">CÓDIGO DA AMOSTRA</th>
                        <th scope="col">PACIENTE</th>
                        <th scope="col">SITUAÇÃO AMOSTRA</th>
                        <th scope="col">DATA DA COLETA</th>
                        <th scope="col">PERFIL DA AMOSTRA</th>
                        <th scope="col">CADASTRO PENDENTE</th>
                        <th scope="col">OBSERVAÇÕES</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>'
    . $html .
    '</tbody>
            </table>
        </div>
    </div>';



Pagina::getInstance()->fechar_corpo();
