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


    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTexto.php';
    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTextoRN.php';

    require_once __DIR__ . '/../../classes/TipoLocalArmazenamento/TipoLocalArmazenamento.php';
    require_once __DIR__ . '/../../classes/TipoLocalArmazenamento/TipoLocalArmazenamentoRN.php';

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


    /*
    *  LOCAL DE ARMAZENAMENTO
    */
    $objLocalArmazenamentoTxt = new LocalArmazenamentoTexto();
    $objLocalArmazenamentoTxtRN = new LocalArmazenamentoTextoRN();

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
            $arr_tubos = $objAmostraRN->obter_locais($objAmostra);


            foreach ($arr_tubos as $tubo) {

                $html .= '
                        <th scope="row">' . Pagina::formatar_html(TuboRN::mostrarDescricaoTipoTubo($tubo->getTipo())) . '</th>';
                if($tubo->getObjLocal()->getObjTipoLocal() != null) {
                    $html .= '       <td>' . Pagina::formatar_html(TipoLocalArmazenamentoRN::mostrarDescricaoTipo($tubo->getObjLocal()->getObjTipoLocal()->getCaractereTipo())) . '</td>';
                }else{
                    $html .= '       <td></td>';
                }
                $html .= '       <td>' . Pagina::formatar_html($tubo->getObjLocal()->getNome()) . '</td>
                        <td>' . Pagina::formatar_html($tubo->getObjLocal()->getPorta()) . '</td>
                        <td>' . Pagina::formatar_html($tubo->getObjLocal()->getPrateleira()) . '</td>
                         <td>' . Pagina::formatar_html($tubo->getObjLocal()->getColuna()) . '</td>
                        <td>' . Pagina::formatar_html($tubo->getObjLocal()->getCaixa()) . '</td>
                         <td>' . Pagina::formatar_html($tubo->getObjLocal()->getPosicao()) . '</td>';

                if($tubo->getObjLocal()->getIdLocal() != null) {
                    if (Sessao::getInstance()->verificar_permissao('editar_localArmazenamentoTxt')) {
                        $html .= '<td ><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_localArmazenamentoTxt&idLocal=' . Pagina::formatar_html($tubo->getObjLocal()->getIdLocal())) . '"><i class="fas fa-edit "></i></a></td>';
                    }
                }else{
                    $html .= '<td > </td>';
                }

                /*if($tubo->getObjLocal()->getIdLocal() != null) {
                    if (Sessao::getInstance()->verificar_permissao('editar_localArmazenamentoTxt')) {
                        $html .= '<td ><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_localArmazenamentoTxt&idLocal=' . Pagina::formatar_html($tubo->getObjLocal()->getIdLocal())) . '"><i class="fas fa-trash-alt"></i></a></td>';
                    }
                }else{
                    $html .= '<td > </td>';
                }*/
                                            
                  $html .= '  </tr>';


            }
        }

    }




} catch (Throwable $ex) {
    //die($ex);
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Listar Locais");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('LOCAIS DE ARMAZENAMENTO', null, null, null, null);


echo $alert;


echo '  <div class="conteudo_grande">
        <form method="POST"  >
        <div class="form-row" >
            <div class="col-md-10" style="width: 100%;margin-top: -25px;">
                <label>Informe o código da amostra</label>
                <input type="text" class="form-control" id="idCodAmostra" style="text-align: center;"
                       name="txtCodAmostra"  value="'.$objAmostra->getNickname().'">
            </div>
            <div class="col-md-2">
              <button class="btn btn-primary" type="submit"  style="margin-top: 7px;width: 100%;margin-left: 0px;" name="selecionar_amostra">SELECIONAR</button>
            </div>
            </div>
        </form>
        </div>';



echo '<div id="tabela_preparos">
        <div class="conteudo_tabela">
            <table class="table table-responsive table-hover " style="margin-top: -50px; width: 90%;margin-left: 5%;">
                <thead>
                    <tr>
                        ';

echo '                        <th scope="col">TIPO AMOSTRA</th>
                         <th scope="col">TIPO LOCAL</th>
                        <th scope="col">LOCAL</th>
                        <th scope="col">PORTA</th>
                        <th scope="col">PRATELEIRA</th>
                        <th scope="col">COLUNA</th>
                        <th scope="col">CAIXA</th>
                        <th scope="col">POSIÇÃO NA CAIXA</th>
                        <th scope="col"></th>
                        <!--<th scope="col"></th>-->
                                               
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
