<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
try{

    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';

    require_once __DIR__.'/../../classes/Equipamento/Equipamento.php';
    require_once __DIR__.'/../../classes/Equipamento/EquipamentoRN.php';
    require_once __DIR__.'/../../classes/Equipamento/EquipamentoINT.php';

    require_once __DIR__.'/../../classes/Marca/Marca.php';
    require_once __DIR__.'/../../classes/Marca/MarcaRN.php';

    require_once __DIR__.'/../../classes/Modelo/Modelo.php';
    require_once __DIR__.'/../../classes/Modelo/ModeloRN.php';

    require_once __DIR__.'/../../classes/Detentor/Detentor.php';
    require_once __DIR__.'/../../classes/Detentor/DetentorRN.php';

    require_once __DIR__.'/../../classes/Pesquisa/PesquisaINT.php';

    require_once __DIR__.'/../../utils/Utils.php';
    require_once __DIR__.'/../../utils/Alert.php';

    $objEquipamento = new Equipamento();
    $objEquipamentoRN = new EquipamentoRN();
    $html = '';

    $objMarca = new Marca();
    $objMarcaRN = new MarcaRN();

    $objModelo = new Modelo();
    $objModeloRN = new ModeloRN();

    $objDetentor = new Detentor();
    $objDetentorRN = new DetentorRN();

    $objUtils = new Utils();
    $alert= '';

    switch ($_GET['action']){
        case 'remover_equipamento':
            try{
                $objEquipamento->setIdEquipamento($_GET['idEquipamento']);
                $objEquipamentoRN->remover($objEquipamento);
                $alert .= Alert::alert_success("Equipamento removido com sucesso");
                break;
            } catch (Throwable $ex) {
                Pagina::getInstance()->processar_excecao($ex);
            }
    }


    $array_colunas = array('ID EQUIPAMENTO','NOME EQUIPAMENTO','SITUAÇÃO EQUIPAMENTO','MODELO','DETENTOR','MARCA','DATA ÚLTIMA CALIBRAGEM','DATA CHEGADA');
    $array_tipos_colunas = array('text','text','select_situacoes_equipamento', 'text','text','text','date','date');
    $valorPesquisa = '';
    $select_pesquisa = '';
    PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, null,null,' onchange="this.form.submit()" ');

    $select_situacoes_equipamento = '';

    if(isset($_POST['sel_pesquisa_coluna']) ){

        PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, $_POST['sel_pesquisa_coluna'],null,' onchange="this.form.submit()" ');
        if($array_tipos_colunas[$_POST['sel_pesquisa_coluna']] == 'select_situacoes_equipamento'){
            EquipamentoINT::montar_select_situacao_equipamento($select_situacoes_equipamento,$objEquipamento,null,null);
            $input = $select_situacoes_equipamento;
        } else {
            //echo $array_tipos_colunas[$_POST['sel_pesquisa_coluna']];
            $input = '<input type="' . $array_tipos_colunas[$_POST['sel_pesquisa_coluna']] . '" value="' . $_POST['valorPesquisa'] .
                '" placeholder="' . $array_colunas[$_POST['sel_pesquisa_coluna']] . '" name="valorPesquisa" aria-label="Search" class="form-control">';
        }
    }ELSE{
        $input = '<input type="text" disabled value="" id="pesquisaDisabled" placeholder="" name="valorPesquisa" aria-label="Search" class="form-control">';
    }

    if(!isset($_POST['hdnPagina'])){
        $objEquipamento->setNumPagina(1);
    } else {
        $objEquipamento->setNumPagina($_POST['hdnPagina']);
    }


    if(isset($_POST['valorPesquisa']) || isset($_POST['sel_situacao_equipamento'])){

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'ID EQUIPAMENTO'){
            $objEquipamento->setIdEquipamento($_POST['valorPesquisa']);
        }
        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'NOME EQUIPAMENTO'){
            $objEquipamento->setNomeEquipamento($_POST['valorPesquisa']);
        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'SITUAÇÃO EQUIPAMENTO'){
            $objEquipamento->setSituacaoEquipamento($_POST['sel_situacao_equipamento']);
            EquipamentoINT::montar_select_situacao_equipamento($select_situacoes_equipamento,$objEquipamento,null,null);
            $input = $select_situacoes_equipamento;
        }


        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'DETENTOR'){
            $objDetentor->setIndex_detentor(strtoupper($objUtils->tirarAcentos($_POST['valorPesquisa'])));
            $objEquipamento->setObjDetentor($objDetentor);
        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'MODELO'){
            $objModelo->setIndex_modelo(strtoupper($objUtils->tirarAcentos($_POST['valorPesquisa'])));
            $objEquipamento->setObjModelo($objModelo);
        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'MARCA'){
            $objMarca->setIndex_marca(strtoupper($objUtils->tirarAcentos($_POST['valorPesquisa'])));
            $objEquipamento->setObjMarca($objMarca);
        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'DATA ÚLTIMA CALIBRAGEM'){
            $objEquipamento->setDataUltimaCalibragem($_POST['valorPesquisa']);
        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'DATA CHEGADA'){
            $objEquipamento->setDataChegada($_POST['valorPesquisa']);
        }

    }


    $arrEquipamentos = $objEquipamentoRN->paginacao($objEquipamento);

    /*
        echo "<pre>";
        print_r($arrEquipamentos);
        echo "</pre>";
    */
    $alert .= Alert::alert_info("Foram encontrados ".$objEquipamento->getTotalRegistros()." equipamentos");


    /************************* PAGINAÇÃO *************************/
    $paginacao = '
                    <nav aria-label="Page navigation example">
                      <ul class="pagination">';
    $paginacao .= '<li class="page-item"><input type="button" onclick="paginar(1)" class="page-link" name="btn_paginacao" value="Primeiro"/></li>';
    for($i=0; $i<($objEquipamento->getTotalRegistros()/20); $i++){
        $color = '';
        if($objEquipamento->getNumPagina() == $i ){
            $color = ' style="background-color: #d2d2d2;" ';
        }
        $paginacao .= '<li '.$color.' class="page-item"><input type="button" onclick="paginar('.($i+1).')" class="page-link" name="btn_paginacao" value="'.($i+1).'"/></li>';
    }
    //$paginacao .= '<li class="page-item"><input type="button" onclick="paginar('.($objAmostra->getTotalRegistros()-1).')" class="page-link" name="btn_paginacao" value="Último"/></li>';
    $paginacao .= '  </ul>
                    </nav>';



    foreach ($arrEquipamentos as $e){

        $html.='<tr>
                    <th scope="row">'.Pagina::formatar_html($e->getIdEquipamento()).'</th>';
        $html .= '               <td>' . Pagina::formatar_html($e->getNomeEquipamento()).'</td>';


        $descricao = EquipamentoRN::mostrarDescricaoSituacao($e->getSituacaoEquipamento());
        if($e->getSituacaoEquipamento() == EquipamentoRN::$TE_OCUPADO){ $background = ' style="background-color: rgba(255,0,0,0.2);" ';}
        if($e->getSituacaoEquipamento() == EquipamentoRN::$TE_LIBERADO) {$background = ' style="background-color: rgba(0,255,0,0.2);" ';}
        $html .= '               <td '.$background.'>' . Pagina::formatar_html($descricao).'</td>';


        $html.='                <td>'.Pagina::formatar_html($e->getHoras().'hrs e '.$e->getMinutos()).'min</td>';
        //detentor
        if($e->getObjDetentor() != null) {
            $html .= '               <td>' . Pagina::formatar_html($e->getObjDetentor()->getIndex_detentor()).'</td>';
        }else{
            $html .= '<td> - </td>';
        }

        //marca
        if($e->getObjMarca() != null) {
            $html .= '               <td>' . Pagina::formatar_html($e->getObjMarca()->getIndex_marca()).'</td>';
        }else{
            $html .= '<td> - </td>';
        }

        //modelo
        if($e->getObjModelo() != null) {
            $html .= '               <td>' . Pagina::formatar_html($e->getObjModelo()->getIndex_modelo()).'</td>';
        }else{
            $html .= '<td> - </td>';
        }


        $html.='                <td>'.Pagina::formatar_html(Utils::converterData($e->getDataUltimaCalibragem())).'</td>';
        $html.='                <td>'.Pagina::formatar_html(Utils::converterData($e->getDataChegada())).'</td>';

        
            if(Sessao::getInstance()->verificar_permissao('editar_equipamento')){      
                $html.= '<td><a href="'. Sessao::getInstance()->assinar_link('controlador.php?action=editar_equipamento&idEquipamento='.Pagina::formatar_html($e->getIdEquipamento())).'"><i class="fas fa-edit "></i></a></td>';
            }else {
                $html .= '<td> - </td>';
            }

            if(Sessao::getInstance()->verificar_permissao('remover_equipamento')){
               $html.= ' <td><a href="'. Sessao::getInstance()->assinar_link('controlador.php?action=remover_equipamento&idEquipamento='.Pagina::formatar_html($e->getIdEquipamento())).'"><i class="fas fa-trash-alt"></i></a></td>';
            }else {
                $html .= '<td> - </td>';
            }
            $html .= '</tr>';
    }
    
} catch (Throwable $ex) {
  Pagina::getInstance()->processar_excecao($ex);
}


Pagina::getInstance()->abrir_head("Listar Equipamentos");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("pesquisa_pg");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('LISTAR EQUIPAMENTOS', null,null,'cadastrar_equipamento', 'NOVO EQUIPAMENTO');
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
    <div class="conteudo_grande" style="margin-top: -5px;">  
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">NOME</th>
                        <th scope="col">SITUAÇÃO</th>
                        <th scope="col">DURAÇÃO RTqPCR</th>
                        <th scope="col">DETENTOR</th>
                        <th scope="col">MARCA</th>
                        <th scope="col">MODELO</th>
                        <th scope="col">DATA ÚLTIMA CALIBRAGEM</th>
                        <th scope="col">DATA CHEGADA</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>'
                .$html.    
              '</tbody>
            </table>
    </div>';


Pagina::getInstance()->fechar_corpo();