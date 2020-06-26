<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';

    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTexto.php';
    require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTextoRN.php';

    require_once __DIR__ . '/../../classes/TipoLocalArmazenamento/TipoLocalArmazenamento.php';
    require_once __DIR__ . '/../../classes/TipoLocalArmazenamento/TipoLocalArmazenamentoRN.php';

    require_once __DIR__ . '/../../utils/Utils.php';
    require_once __DIR__ . '/../../utils/Alert.php';

    Sessao::getInstance()->validar();

    $utils = new Utils();
    $select_tipoLocal = '';
    /*
     *  LOCAL DE ARMAZENAMENTO
     */
    $objLocalArmazenamentoTxt = new LocalArmazenamentoTexto();
    $objLocalArmazenamentoTxtRN = new LocalArmazenamentoTextoRN();

    /*
     *  TIPO LOCAL DE ARMAZENAMENTO
     */
    $objTipoLocalArmazenamento = new TipoLocalArmazenamento();
    $objTipoLocalArmazenamentoRN = new TipoLocalArmazenamentoRN();

    $cadastrado_sucesso = '';
    $alert ='';

    switch($_GET['action']){
        case 'editar_localArmazenamentoTxt':
            if(isset($_GET['idLocal'])){
                $objLocalArmazenamentoTxt->setIdLocal($_GET['idLocal']);
                $objLocalArmazenamentoTxt  = $objLocalArmazenamentoTxtRN->consultar($objLocalArmazenamentoTxt);
                //print_r($objLocalArmazenamentoTxt);

                $objTipoLocalArmazenamento->setIdTipoLocalArmazenamento($objLocalArmazenamentoTxt->getIdTipoLocal());
                //$objTipoLocalArmazenamento =  $objTipoLocalArmazenamentoRN->consultar($objTipoLocalArmazenamento);
                //print_r($objTipoLocalArmazenamento);
                InterfacePagina::montar_select_tipoLocalArmazenamentoTXT($select_tipoLocal,$objTipoLocalArmazenamentoRN,$objTipoLocalArmazenamento, '', '');
            }

            if(isset($_POST['salvar_local'])){
                $objLocalArmazenamentoTxt->setIdLocal($_GET['idLocal']);
                $objLocalArmazenamentoTxt->setNome(strtoupper($utils->tirarAcentos($_POST['txtNomeLocal'])));
                $objLocalArmazenamentoTxt->setCaixa(strtoupper($utils->tirarAcentos($_POST['txtCaixa'])));
                $objLocalArmazenamentoTxt->setPorta(strtoupper($utils->tirarAcentos($_POST['txtPorta'])));
                $objLocalArmazenamentoTxt->setPrateleira(strtoupper($utils->tirarAcentos($_POST['txtPrateleira'])));
                $objLocalArmazenamentoTxt->setColuna(strtoupper($utils->tirarAcentos($_POST['txtColuna'])));
                $objLocalArmazenamentoTxt->setPosicao(strtoupper($utils->tirarAcentos($_POST['txtPosicaoCaixa'])));
                $objLocalArmazenamentoTxt->setIdTipoLocal($_POST['sel_tipoLocalArmazenamentoTXT']);

                $objTipoLocalArmazenamento->setIdTipoLocalArmazenamento($objLocalArmazenamentoTxt->getIdTipoLocal());
                InterfacePagina::montar_select_tipoLocalArmazenamentoTXT($select_tipoLocal,$objTipoLocalArmazenamentoRN,$objTipoLocalArmazenamento, '', '');

                $objLocalArmazenamentoTxt = $objLocalArmazenamentoTxtRN->alterar($objLocalArmazenamentoTxt);
                $alert .= Alert::alert_success("O local de armazenamento foi ALTERADO com sucesso");

            }
            break;

        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_perfilPaciente.php');
    }

} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Editar local de armazenamento");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('EDITAR LOCAL DE ARMAZENAMENTO',null,null, 'listar_localArmazenamentoTxt', 'LISTAR LOCAIS DE ARMAZENAMENTO');
Pagina::getInstance()->mostrar_excecoes();

echo $alert.
    '<div class="conteudo_grande" style="margin-top: 0px;">         
                <form method="POST">
                    <div class="form-row">
                        <div class="col-md-6 ">
                            <label for="label_perfilPaciente">Informe o nome do local:</label>
                            <input type="text" class="form-control" id="idNomeLocal" placeholder="Nome Local" 
                                   onblur="" name="txtNomeLocal" 
                                    value="'. Pagina::formatar_html($objLocalArmazenamentoTxt->getNome()).'">           
                        </div>
                        <div class="col-md-6 ">
                             <label for="label_tipoLocal">Selecone o tipo do local:</label>
                            '.$select_tipoLocal.'         
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 ">
                            <label for="label_perfilPaciente">Informe o nome da porta:</label>
                            <input type="text" class="form-control" id="idPorta" placeholder="porta" 
                                   onblur="" name="txtPorta" 
                                    value="'. Pagina::formatar_html($objLocalArmazenamentoTxt->getPorta()).'">           
                        </div>
                        <div class="col-md-4 ">
                            <label for="label_perfilPaciente">Informe o nome da prateleira:</label>
                            <input type="text" class="form-control" id="idPrateleira" placeholder="prateleira" 
                                   onblur="" name="txtPrateleira" 
                                    value="'. Pagina::formatar_html($objLocalArmazenamentoTxt->getPrateleira()).'">           
                        </div>
                        <div class="col-md-4 ">
                            <label for="label_coluna">Informe o nome da coluna:</label>
                            <input type="text" class="form-control" id="idColuna" placeholder="coluna" 
                                   onblur="" name="txtColuna" 
                                    value="'. Pagina::formatar_html($objLocalArmazenamentoTxt->getColuna()).'">           
                        </div>
                    </div>  
                    
                    <div class="form-row">
                        <div class="col-md-6 ">
                            <label for="label_perfilPaciente">Informe o nome da caixa:</label>
                            <input type="text" class="form-control" id="idCaixa" placeholder="caixa" 
                                   onblur="" name="txtCaixa" 
                                    value="'. Pagina::formatar_html($objLocalArmazenamentoTxt->getCaixa()).'">           
                        </div>
                        <div class="col-md-6 ">
                            <label for="label_posicaoCaixa">Informe a posição na caixa (letra+número):</label>
                            <input type="text" class="form-control" id="idPosicaoCaixa" placeholder="posicao" 
                                   onblur="" name="txtPosicaoCaixa" 
                                    value="'. Pagina::formatar_html($objLocalArmazenamentoTxt->getPosicao()).'">           
                        </div>
                       
                    </div>  
                    <button class="btn btn-primary" type="submit" name="salvar_local">SALVAR</button>
                </form>
        </DIV>';


Pagina::getInstance()->fechar_corpo();



