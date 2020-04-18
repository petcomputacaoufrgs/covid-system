<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Pagina/Interf.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../utils/Alert.php';

require_once '../classes/Amostra/Amostra.php';
require_once '../classes/Amostra/AmostraRN.php';

require_once '../classes/PerfilPaciente/PerfilPaciente.php';
require_once '../classes/PerfilPaciente/PerfilPacienteRN.php';

require_once '../classes/Tubo/Tubo.php';
require_once '../classes/Tubo/TuboRN.php';

require_once '../classes/InfosTubo/InfosTubo.php';
require_once '../classes/InfosTubo/InfosTuboRN.php';

try {
    Sessao::getInstance()->validar();


    $array_colunas = array('CÓDIGO', 'SITUAÇÃO AMOSTRA', 'DATA COLETA', 'PERFIL AMOSTRA');
    $array_tipos_colunas = array('text', 'text', 'date', 'text');

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
    
    /* PERFIL PACIENTE */
    $objPerfilPaciente = new PerfilPaciente();
    $objPerfilPacienteRN = new PerfilPacienteRN();

    /* TUBO */
    $objTubo = new Tubo();
    $objTuboRN = new TuboRN();


    /* INFOS TUBO */
    $objInfosTubo = new InfosTubo();
    $objInfosTuboRN = new InfosTuboRN();
    $alert = '';
    $html = '';

    $options = Interf::montar_select_pesquisa($array_colunas,$position);

    $botoes_aparecer = false;
    //resetar
    if (isset($_POST['bt_resetar'])) {
        $position ='';
        header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_amostra'));
    }

    if (isset($_POST['coluna_selecionada'])) {
        header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_amostra'
                        . '&idColunaSelecionada=' . $_POST['coluna_selecionada']));
    }

    //botao do select das colunas
    if (isset($_GET['idColunaSelecionada'])) { //primeiro verifica se está na url
        $botoes_aparecer = true;
        $valor_selecionado = $array_colunas[$_GET['idColunaSelecionada']]; // a coluna pesquisa me da o numero da coluna que foi escolhida pra a pesquisa
        $position = $_GET['idColunaSelecionada'];
        
        $options = Interf::montar_select_pesquisa($array_colunas,$position);
        

        //$options = '';
        $options .= '<option disabled selected value="' . $position . '">' . $valor_selecionado . '</option>' . "\n";
        
        
        if($valor_selecionado ==  'SITUAÇÃO AMOSTRA'){
            Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, $disabled, $onchange);
            $inputs = $select_a_r_g;
        }else if($valor_selecionado ==  'PERFIL AMOSTRA'){
            Interf::getInstance()->montar_select_pp($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, $disabled, $onchange);
            $inputs = $select_perfis;
        }
        else{
            
            // monta o input conforme o tipo indicado no $array_tipos_colunas
            $inputs = '<input type="' . $array_tipos_colunas[$position] . '" value="' . $value .
                    '" placeholder="Search" name="txtSearch" aria-label="Search" class="form-control">';
            //$options = Interf::montar_select_pesquisa($array_colunas);]
        }
    }

    if (isset($_GET['idColunaSelecionada']) && isset($_POST['bt_pesquisar_palavra'])) {

        if ($array_colunas[$_GET['idColunaSelecionada']] == 'CÓDIGO') {
            $objAmostra->setCodigoAmostra($_POST['txtSearch']);
            $arrAmostras_pesquisa = $objAmostraRN->listar($objAmostra);
            if (empty($arrAmostras_pesquisa)) {
                //$arrAmostras_pesquisa = array('ERROR' => "Nenhuma lixeira encontrada com este ID");
                $alert .= Alert::alert_primary("Nenhuma amostra encontrada com este código situação");
            } else {
                $retornou_certo = true;
            }
           
        }
        
        if ($array_colunas[$_GET['idColunaSelecionada']] == 'SITUAÇÃO AMOSTRA') {
            
            $objAmostra->set_a_r_g($_POST['sel_a_r_g']);
            $arrAmostras_pesquisa = $objAmostraRN->listar($objAmostra);
            if (empty($arrAmostras_pesquisa)) {
                //$arrAmostras_pesquisa = array('ERROR' => "Nenhuma lixeira encontrada com este ID");
                $alert .= Alert::alert_primary("Nenhuma amostra encontrada com esta situação");
            } else {
                $retornou_certo = true;
            }
            Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra, $disabled, $onchange);
            $inputs = $select_a_r_g;
        }
        
        if ($array_colunas[$_GET['idColunaSelecionada']] == 'DATA COLETA') {
            
            $objAmostra->setDataColeta($_POST['txtSearch']);
            $arrAmostras_pesquisa = $objAmostraRN->listar($objAmostra);
            if (empty($arrAmostras_pesquisa)) {
                //$arrAmostras_pesquisa = array('ERROR' => "Nenhuma lixeira encontrada com este ID");
                $alert .= Alert::alert_primary("Nenhuma amostra encontrada nesta data");
            } else {
                $retornou_certo = true;
            }
        }
        
        if ($array_colunas[$_GET['idColunaSelecionada']] == 'PERFIL AMOSTRA') {
            
            $objAmostra->setIdPerfilPaciente_fk($_POST['sel_PP']);
            $arrAmostras_pesquisa = $objAmostraRN->listar($objAmostra);
            if (empty($arrAmostras_pesquisa)) {
                //$arrAmostras_pesquisa = array('ERROR' => "Nenhuma lixeira encontrada com este ID");
                $alert .= Alert::alert_primary("Nenhuma amostra encontrada com este perfil");
            } else {
                $retornou_certo = true;
            }
            Interf::getInstance()->montar_select_pp($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objAmostra, $disabled, $onchange);
            $inputs = $select_perfis;
        }
        
        
    }


    if (empty($arrAmostras_pesquisa) || $retornou_certo) {

        $objAmostraAux = new Amostra();
        $objAmostraAuxRN = new AmostraRN();
        if (!$retornou_certo) {
            $arrAmostras = $objAmostraAuxRN->listar($objAmostraAux);
        } else {
            $arrAmostras = $arrAmostras_pesquisa;
        }
        $itens = '';


        foreach ($arrAmostras as $r) {
            if ($r->get_a_r_g() == 'r') {
                $result = 'Recusada';
                $style = ' style="background-color:rgba(255, 0, 0, 0.2);" ';
            } else if ($r->get_a_r_g() == 'a') {
                $result = 'Aceita';
                $style = ' style="background-color:rgba(0, 255, 0, 0.2);" ';
            } else if ($r->get_a_r_g() == 'g') {
                $result = 'Aguardando chegada';
                $style = ' style="background-color:rgba(255, 255, 0, 0.2);" ';
            }
            
           
            $objPerfilPaciente->setIdPerfilPaciente($r->getIdPerfilPaciente_fk());
            $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
            
            
            if($r->getDataColeta() != null){
                $strData = explode("-", $r->getDataColeta());
            
                $ano = $strData[0];
                $mes = $strData[1];
                $dia = $strData[2];
                
                $data = $dia."/".$mes."/".$ano;
                
            }
            
            $html .= '<tr' . $style . '>
                    <th scope="row">' . Pagina::formatar_html($r->getCodigoAmostra()) . '</th>
                            <td>' . Pagina::formatar_html($result) . '</td>
                            <td>' . Pagina::formatar_html($data) . '</td>
                            <td>' . Pagina::formatar_html($objPerfilPaciente->getPerfil()) . '</td>
                        <td>';

            if (Sessao::getInstance()->verificar_permissao('editar_amostra')) {
                $html .= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_amostra&idAmostra=' . Pagina::formatar_html($r->getIdAmostra())) . '">Editar</a>';
            }
            $html .= '</td><td>';
            if (Sessao::getInstance()->verificar_permissao('remover_amostra')) {
                $html .= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_amostra&idAmostra=' . Pagina::formatar_html($r->getIdAmostra())) . '">Remover</a>';
            }
            $html .= '</td></tr>';

        }
    }
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Listar Amostras");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();



echo $alert.
    '<div class="conteudo_listar">' .
 Pagina::montar_topo_listar('LISTAR AMOSTRAS', null, null, 'cadastrar_amostra', 'NOVA AMOSTRA');

echo '<div class="campo_pesquisa" >
            <div class="row">
                <form class="form-inline" method="post" style="margin-left: 30px;"  > <!--action="<?= $acao ?>">-->
                    <div class="form-row" >
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-search"></i></span></div>
                        
                        <select id="select_search"  onchange="this.form.submit()"
                            class="select_column custom-select" name="coluna_selecionada" required="true" >
                            <option> Selecione o campo de busca</option>' .
 $options
 . '</select>';

if ($valor_selecionado != '') {
    echo $inputs;
}

if ($botoes_aparecer) {
    echo '
    
                    <div class="btn-group" role="group" aria-label="Basic example">
                            <input type="submit" class="btn btn-outline-add
                                   accesskey=""  
                                   accept=""
                                   name="bt_pesquisar_palavra"
                                    value="Pesquisar">
                       <input type="submit" class="btn btn-outline-add" name="bt_resetar" value="Resetar">
                        </div>
                    </div>';
}
echo '  </form>
            </div> <!-- fim row -->
        </div> <!-- fim conteúdo -->';

echo '<div class="conteudo_tabela">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">CÓDIGO DA AMOSTRA</th>
                        <th scope="col">SITUAÇÃO AMOSTRA</th>
                        <th scope="col">DATA DA COLETA</th>
                        <th scope="col">PERFIL</th>
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


Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();
