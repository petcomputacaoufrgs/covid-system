<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try {

    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';
    require_once __DIR__.'/../../utils/Alert.php';
    require_once __DIR__.'/../../utils/Utils.php';

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

    require_once __DIR__.'/../../classes/CadastroAmostra/CadastroAmostra.php';
    require_once __DIR__.'/../../classes/CadastroAmostra/CadastroAmostraRN.php';

    Sessao::getInstance()->validar();

    $objAmostra = new Amostra();
    $objAmostraRN = new AmostraRN();

    $objPerfilPaciente = new PerfilPaciente();
    $objPerfilPacienteRN = new PerfilPacienteRN();

    $objPaciente = new Paciente();
    $objPacienteRN = new PacienteRN();

    $objTubo = new Tubo();
    $objTuboRN = new TuboRN();

    $objInfosTubo = new InfosTubo();
    $objInfosTuboRN = new InfosTuboRN();

    $objCadastroAmostra = new CadastroAmostra();
    $objCadastroAmostraRN = new CadastroAmostraRN();

    $valorInput1 = '';
    $inputs = '';
    $alert = '';
    $html = '';

    $objAmostra = new Amostra();


    /* PESQUISA */
    $array_colunas = array('CÓDIGO', 'CÓDIGO AMOSTRA', 'CPF USUÁRIO','MATRÍCULA USUÁRIO');
    $array_tipos_colunas = array('text', 'text', 'text');
    $valorPesquisa = '';
    $select_pesquisa = '';

    PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, null,null,' onchange="this.form.submit()" ');

    if(isset($_POST['sel_pesquisa_coluna']) ){
        PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, $_POST['sel_pesquisa_coluna'],null,' onchange="this.form.submit()" ');
        $input = '<input type="' . $array_tipos_colunas[$_POST['sel_pesquisa_coluna']] . '" value="' . $_POST['valorPesquisa'] .
            '" placeholder="' . $array_colunas[$_POST['sel_pesquisa_coluna']] . '" name="valorPesquisa" aria-label="Search" class="form-control">';

    }ELSE{
        $input = '<input type="text" disabled value="" id="pesquisaDisabled" placeholder="" name="valorPesquisa" aria-label="Search" class="form-control">';
    }

       if(!isset($_POST['hdnPagina'])){
           $objCadastroAmostra->setNumPagina(1);
       } else {
           $objCadastroAmostra->setNumPagina($_POST['hdnPagina']);
       }

        if(isset($_POST['valorPesquisa']) || isset($_POST['sel_cadastro_pendente'])
            || isset($_POST['sel_perfil_caractere']) || isset($_POST['sel_a_r_g']) ){


            if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'CÓDIGO' ){
                $objCadastroAmostra->setIdCadastroAmostra(strtoupper($_POST['valorPesquisa']));
            }

            if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'CÓDIGO AMOSTRA'){
                $objAmostra->setNickname(strtoupper($_POST['valorPesquisa']));
                $objCadastroAmostra->setObjAmostra($objAmostra);
            }

            if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'CPF USUÁRIO'){
                $objUsuario->setCPF(strtoupper($_POST['valorPesquisa']));
                $objCadastroAmostra->setObjUsuario($objUsuario);
            }

            if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'MATRÍCULA USUÁRIO'){
                $objUsuario->setMatricula(strtoupper($_POST['valorPesquisa']));
                $objCadastroAmostra->setObjUsuario($objUsuario);
            }
        }


    $arrCadastrosAmostras = $objCadastroAmostraRN->paginacao($objCadastroAmostra);
    $alert .= Alert::alert_info("Foram encontradas ".$objCadastroAmostra->getTotalRegistros()."  cadastros de amostras");

        /*
        * PAGINAÇÃO
        */
        $paginacao = '
                    <nav aria-label="Page navigation example">
                      <ul class="pagination">';
        $paginacao .= '<li class="page-item"><input type="button" onclick="paginar(1)" class="page-link" name="btn_paginacao" value="Primeiro"/></li>';
        for($i=0; $i<($objCadastroAmostra->getTotalRegistros()/500); $i++){
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


    foreach ($arrCadastrosAmostras as $cadastroAmostra){
        $objAmostra = $cadastroAmostra->getObjAmostra();
        $objUsuario = $cadastroAmostra->getObjUsuario();

        $html .= '<tr>
                    <th scope="row">' . Pagina::formatar_html($cadastroAmostra->getIdCadastroAmostra()) . '</th>';

        if(!is_null($objAmostra) && !is_null($objAmostra->getNickname())) {
            $html .= ' <td>' . Pagina::formatar_html($objAmostra->getNickname()) . '</td>';
        }else{
            $html .= ' <td>-</td>';
        }

        if(!is_null($objUsuario->getCPF())) {
            $html .= '           <td>  ' . Pagina::formatar_html($objUsuario->getCPF()) . ' (CPF)</td>';
        }else if(!is_null($objUsuario->getMatricula())){
            $html .= '           <td>  ' . Pagina::formatar_html($objUsuario->getMatricula()) . ' (nº matrícula)</td>';
        }else{
            $html .= '           <td>  ' . Pagina::formatar_html($objUsuario->getIdUsuario()) . '</td>';
        }
        $html .= '  <td> ' . Pagina::formatar_html(Utils::converterDataHora($cadastroAmostra->getDataHoraInicio())) .'</td>
                    <td> ' . Pagina::formatar_html(Utils::converterDataHora($cadastroAmostra->getDataHoraFim())) . '</td>';

        $html .= '</tr>';

    }


} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Listar Cadastro Amostras");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("pesquisa_pg");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('LISTAR CADASTRO AMOSTRAS', null, null, 'cadastrar_amostra', 'NOVA AMOSTRA');
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
                        <th scope="col">CÓDIGO DO CADASTRO</th>
                        <th scope="col">CÓDIGO AMOSTRA</th>
                        <th scope="col">USUÁRIO</th>
                        <th scope="col">DATA INÍCIO</th>
                        <th scope="col">DATA FIM</th>
                    </tr>
                </thead>
                <tbody>'
    . $html .
    '</tbody>
            </table>
        </div>
    </div>';



Pagina::getInstance()->fechar_corpo();
