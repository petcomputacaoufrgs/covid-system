<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
try {
    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';

    require_once __DIR__.'/../../classes/Equipamento/Equipamento.php';
    require_once __DIR__.'/../../classes/Equipamento/EquipamentoRN.php';
    require_once __DIR__.'/../../classes/Equipamento/EquipamentoINT.php';

    require_once __DIR__.'/../../classes/Detentor/Detentor.php';
    require_once __DIR__.'/../../classes/Detentor/DetentorRN.php';

    require_once __DIR__.'/../../classes/Marca/Marca.php';
    require_once __DIR__.'/../../classes/Marca/MarcaRN.php';

    require_once __DIR__.'/../../classes/Modelo/Modelo.php';
    require_once __DIR__.'/../../classes/Modelo/ModeloRN.php';

    require_once __DIR__.'/../../utils/Utils.php';
    require_once __DIR__.'/../../utils/Alert.php';


    $utils = new Utils();
    date_default_timezone_set('America/Sao_Paulo');
    $_SESSION['DATA_LOGIN']  = date('d/m/Y  H:i:s');


    $objEquipamento = new Equipamento();
    $objEquipamentoRN = new EquipamentoRN();
    $alert = '';
    $select_detentores = '';
    $select_marcas = '';
    $select_modelos = '';

    $selected = '';
    $alert = '';


    /* DETENTORES */
    $objDetentor = new Detentor();
    $objDetentorRN = new DetentorRN();


    /* MARCAS */
    $objMarca = new Marca();
    $objMarcaRN = new MarcaRN();


    /* MODELOS */
    $objModelo = new Modelo();
    $objModeloRN = new ModeloRN();

    $select_situacao_equipamento = '';
    $disabled = '';

    EquipamentoINT::montar_select_situacao_equipamento($select_situacao_equipamento,$objEquipamento, null ,  null);

    switch ($_GET['action']) {
        case 'cadastrar_equipamento':

            if (isset($_POST['salvar_equipamento'])) {

                $objEquipamento->setNomeEquipamento($_POST['txtNomeEquipamento']);
                $objEquipamento->setSituacaoEquipamento($_POST['sel_situacao_equipamento']);
                $objEquipamento->setIdUsuarioFk(Sessao::getInstance()->getIdUsuario());
                $objEquipamento->setDataCadastro(date('Y-m-d  H:i:s'));
                $objEquipamento->setHoras($_POST['numberHoras']);
                $objEquipamento->setMinutos($_POST['numberMinutos']);

                if(isset($_POST['txtMarca']) && strlen($_POST['txtMarca']) > 0) {
                    $objMarca->setMarca($_POST['txtMarca']);
                    $objMarca->setIndex_marca(strtoupper($utils->tirarAcentos($_POST['txtMarca'])));
                    $objEquipamento->setObjMarca($objMarca);
                }

                if(isset($_POST['txtModelo']) && strlen($_POST['txtModelo']) > 0) {
                    $objModelo->setModelo($_POST['txtModelo']);
                    $objModelo->setIndex_modelo(strtoupper($utils->tirarAcentos($_POST['txtModelo'])));
                    $objEquipamento->setObjModelo($objModelo);
                }

                if(isset($_POST['txtDetentor']) && strlen($_POST['txtDetentor']) > 0) {
                    $objDetentor->setDetentor($_POST['txtDetentor']);
                    $objDetentor->setIndex_detentor(strtoupper($utils->tirarAcentos($_POST['txtDetentor'])));
                    $objEquipamento->setObjDetentor($objDetentor);
                }

                $objEquipamento->setDataUltimaCalibragem($_POST['dtUltimaCalibragem']);
                $objEquipamento->setDataChegada($_POST['dtChegada']);

                $objEquipamento = $objEquipamentoRN->cadastrar($objEquipamento);

                /*
                    echo "<pre>";
                    print_r($objEquipamento);
                    echo "</pre>";
                */

                EquipamentoINT::montar_select_situacao_equipamento($select_situacao_equipamento,$objEquipamento, ' disabled ' ,  null);
                $disabled  = ' disabled ';
                $alert= Alert::alert_success("Equipamento cadastrado com sucesso");
                
            }
         
            break;

        case 'editar_equipamento':
             $objEquipamento->setIdEquipamento($_GET['idEquipamento']);
             $arr_equipamentos = $objEquipamentoRN->listar_completo($objEquipamento,1);
             $objEquipamento  = $arr_equipamentos[0];
             $objDetentor = $objEquipamento->getObjDetentor();
             $objModelo = $objEquipamento->getObjModelo();
             $objMarca= $objEquipamento->getObjMarca();

             EquipamentoINT::montar_select_situacao_equipamento($select_situacao_equipamento,$objEquipamento, null ,  null);

             if (isset($_POST['salvar_equipamento'])) { //se enviou o formulário com as alterações

                $objEquipamento->setNomeEquipamento($_POST['txtNomeEquipamento']);
                $objEquipamento->setSituacaoEquipamento($_POST['sel_situacao_equipamento']);

                $objMarca->setMarca($_POST['txtMarca']);
                $objMarca->setIndex_marca(strtoupper($utils->tirarAcentos($_POST['txtMarca'])));
                $objEquipamento->setObjMarca($objMarca);

                $objModelo->setModelo($_POST['txtModelo']);
                $objModelo->setIndex_modelo(strtoupper($utils->tirarAcentos($_POST['txtModelo'])));
                $objEquipamento->setObjModelo($objModelo);

                $objDetentor->setDetentor($_POST['txtDetentor']);
                $objDetentor->setIndex_detentor(strtoupper($utils->tirarAcentos($_POST['txtDetentor'])));
                $objEquipamento->setObjDetentor($objDetentor);

                $objEquipamento->setDataUltimaCalibragem($_POST['dtUltimaCalibragem']);
                $objEquipamento->setDataChegada($_POST['dtChegada']);

                $objEquipamento = $objEquipamentoRN->alterar($objEquipamento);

                /*
                    echo "<pre>";
                    print_r($objEquipamento);
                    echo "</pre>";
                */

                EquipamentoINT::montar_select_situacao_equipamento($select_situacao_equipamento,$objEquipamento, ' disabled ' ,  null);
                $disabled  = ' disabled ';
                $alert= Alert::alert_success("Equipamento alterado com sucesso");
            }

            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_equipamento.php');
    }
} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Cadastrar Equipamento");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("equipamento");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('CADASTRAR EQUIPAMENTO', null,null,'listar_equipamento', 'LISTAR EQUIPAMENTOS');
Pagina::getInstance()->mostrar_excecoes();

   echo 
     $alert.

    '<div class="conteudo_grande" style="margin-top: -40px;">    
            <form method="POST">
                 <div class="form-row" style="margin-bottom: 30px;">  
                    <div class="col-md-3">
                        <input type="text" class="form-control" hidden id="idDtHrInicio" readonly  style="text-align: center;"
                           name="dtHrInicio"  value="'. Pagina::formatar_html($_SESSION['DATA_LOGIN']).'" >
                    </div>

                </div>

                  <div class="form-row">  

                    <div class="col-md-6 mb-4">
                        <label for="nomeEquipamento" >Nome equipamento: (opcional)</label>
                        <input type="text" class="form-control" id="idNomeEquipamento" placeholder="Digite o nome do equipamento " 
                               name="txtNomeEquipamento" '.$disabled.' value="'.Pagina::formatar_html($objEquipamento->getNomeEquipamento()).'" >
                    </div>
                    <div class="col-md-6 mb-4">
                        <label  >Situação do equipamento </label>'.
                                $select_situacao_equipamento
                    .'</div>
                </div>
                <div class="form-row">  

                    <div class="col-md-3 mb-4">
                        <label for="nomeEquipamento" >Horas estimadas para o RTqPCR:</label>
                        <input type="number" class="form-control" placeholder="Hr" 
                               name="numberHoras" '.$disabled.' value="'.Pagina::formatar_html($objEquipamento->getHoras()).'" >
                    </div>
                    <div class="col-md-3 mb-4">
                       <label for="nomeEquipamento" >Minutos estimados para o RTqPCR:</label>
                        <input type="number" class="form-control" placeholder="Hr" 
                               name="numberMinutos" '.$disabled.' value="'.Pagina::formatar_html($objEquipamento->getMinutos()).'" >
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="label_dataUltimaCalibragem">Data da última calibragem: (opcional)</label>
                        <input type="date" class="form-control" id="idDataUltimaCalibragem" placeholder="Última calibragem"                              
                               name="dtUltimaCalibragem"  '.$disabled.'
                               value="'.Pagina::formatar_html($objEquipamento->getDataUltimaCalibragem()).'">
                    <div id ="feedback_dataUltimaCalibragem"></div>

                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="label_dataChegada">Data da chegada: (opcional)</label>
                        <input type="date" class="form-control" id="idDataChegada" placeholder="Data da chegada" 
                             name="dtChegada" '.$disabled.'
                                value="'.Pagina::formatar_html($objEquipamento->getDataChegada()).'">
                        <div id ="feedback_dataChegada"></div>

                    </div>
                </div>
                <div class="form-row">  

                    <div class="col-md-4 mb-4">
                        <label for="detentorEquipamento" >Detentor: (opcional)</label>
                        <input type="text" class="form-control" id="idDetentor" placeholder="Digite o nome do detentor " 
                               name="txtDetentor" '.$disabled.'  value="'.Pagina::formatar_html($objDetentor->getIndex_detentor()).'" >
                    </div>

                    <div class="col-md-4 mb-4">
                        <label for="marcaEquipamento" >Marca: (opcional)</label>
                        <input type="text" class="form-control" id="idMarca" placeholder="Digite o nome da marca " 
                               name="txtMarca"  '.$disabled.' value="'.Pagina::formatar_html($objMarca->getIndex_marca()).'" >
                    </div>

                    <div class="col-md-4 mb-4">
                        <label for="modeloEquipamento">Modelo: (opcional)</label>
                        <input type="text" class="form-control" id="idModelo" placeholder="Digite o nome do modelo " 
                               name="txtModelo" '.$disabled.' value="'.Pagina::formatar_html($objModelo->getIndex_modelo()).'" >
                    </div>

                </div>


                <div class="form-row">  
                

                </div> 
                <button class="btn btn-primary" type="submit" name="salvar_equipamento">Salvar</button>
            </form>      
    </div>';




Pagina::getInstance()->fechar_corpo();
