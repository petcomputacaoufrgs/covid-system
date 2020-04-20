<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Equipamento/Equipamento.php';
require_once '../classes/Equipamento/EquipamentoRN.php';
require_once '../classes/Detentor/Detentor.php';
require_once '../classes/Detentor/DetentorRN.php';
require_once '../classes/Marca/Marca.php';
require_once '../classes/Marca/MarcaRN.php';
require_once '../classes/Modelo/Modelo.php';
require_once '../classes/Modelo/ModeloRN.php';
require_once '../utils/Utils.php';
require_once '../utils/Alert.php';


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
try {

    /* DETENTORES */
    $objDetentor = new Detentor();
    $objDetentorRN = new DetentorRN();


    /* MARCAS */
    $objMarca = new Marca();
    $objMarcaRN = new MarcaRN();


    /* MODELOS */
    $objModelo = new Modelo();
    $objModeloRN = new ModeloRN();


    switch ($_GET['action']) {
        case 'cadastrar_equipamento':

            if (isset($_POST['salvar_equipamento'])) {
                              
                $objDetentor->setDetentor($_POST['txtDetentor']);
                $objDetentor->setIndex_detentor(strtoupper($utils->tirarAcentos($_POST['txtDetentor'])));
                $arr_detentores = $objDetentorRN->pesquisar_index($objDetentor);
                if(empty($arr_detentores)){
                    $objDetentorRN->cadastrar($objDetentor);
                    //$alert= Alert::getInstance()->alert_success_cadastrar();
                }else {$objDetentor->setIdDetentor($arr_detentores[0]->getIdDetentor());}
                
                
                $objMarca->setMarca($_POST['txtMarca']);
                $objMarca->setIndex_marca(strtoupper($utils->tirarAcentos($_POST['txtMarca'])));
                $arr_marcas = $objMarcaRN->pesquisar_index($objMarca);
                if(empty($arr_marcas)){
                     $objMarcaRN->cadastrar($objMarca);
                    //$alert= Alert::getInstance()->alert_success_cadastrar();
                }else $objMarca->setIdMarca($arr_marcas[0]->getIdMarca());
                        
                                
                $objModelo->setModelo($_POST['txtModelo']);
                $objModelo->setIndex_modelo(strtoupper($utils->tirarAcentos($_POST['txtModelo'])));
                $arr_modelos = $objModeloRN->pesquisar_index($objModelo);
                if(empty($arr_modelos)){
                    $objModeloRN->cadastrar($objModelo);
                    //$alert= Alert::getInstance()->alert_success_cadastrar();
                }else $objModelo->setIdModelo($arr_modelos[0]->getIdModelo());
                
                $objEquipamento->setIdDetentor_fk($objDetentor->getIdDetentor());
                $objEquipamento->setIdMarca_fk($objMarca->getIdMarca());
                $objEquipamento->setIdModelo_fk($objModelo->getIdModelo());
                $objEquipamento->setDataUltimaCalibragem($_POST['dtUltimaCalibragem']);
                $objEquipamento->setDataChegada($_POST['dtChegada']);

                $objEquipamentoRN->cadastrar($objEquipamento);
                $alert= Alert::getInstance()->alert_success_cadastrar();
                
            }else{
                $objEquipamento->setIdEquipamento('');
                $objEquipamento->setIdDetentor_fk('');
                $objEquipamento->setIdMarca_fk('');
                $objEquipamento->setIdModelo_fk('');
                $objEquipamento->setDataChegada('');
                $objEquipamento->setDataUltimaCalibragem('');
                
                $objModelo->setIdModelo('');
                $objModelo->setIndex_modelo('');
                $objModelo->setModelo('');
                
                $objDetentor->setDetentor('');
                $objDetentor->setIdDetentor('');
                $objDetentor->setIndex_detentor('');
                
                $objMarca->setIdMarca('');
                $objMarca->setIndex_marca('');
                $objMarca->setMarca('');
            }
         
            break;

        case 'editar_equipamento':
             $objEquipamento->setIdEquipamento($_GET['idEquipamento']);
             $objEquipamento = $objEquipamentoRN->consultar($objEquipamento);
            if (!isset($_POST['salvar_equipamento'])) { //enquanto não enviou o formulário com as alterações
               
                
                $objDetentor->setIdDetentor($objEquipamento->getIdDetentor_fk());
                $objDetentor = $objDetentorRN->consultar($objDetentor);
                
                $objModelo->setIdModelo($objEquipamento->getIdModelo_fk());
                $objModelo = $objModeloRN->consultar($objModelo);
                
                $objMarca->setIdMarca($objEquipamento->getIdMarca_fk());
                $objMarca = $objMarcaRN->consultar($objMarca);
                
                
            }

            if (isset($_POST['salvar_equipamento'])) { //se enviou o formulário com as alterações
                
                $objDetentorAux = new Detentor();
                $objDetentorAux->setIdDetentor($objEquipamento->getIdDetentor_fk());
                $objDetentorAux = $objDetentorRN->consultar($objDetentorAux);
                
                
                $objDetentor->setDetentor($_POST['txtDetentor']);
                $objDetentor->setIndex_detentor(strtoupper($utils->tirarAcentos($_POST['txtDetentor'])));
                if($objDetentorAux->getDetentor() != $_POST['txtDetentor'] &&
                   $objDetentorAux->getIndex_detentor() != strtoupper($utils->tirarAcentos($_POST['txtDetentor']))){
                    $arr_detentores = $objEquipamentoRN->listar($objEquipamento);
                    if(count($arr_detentores) > 1){ //não é só ele quem tem essa empresa

                        $objDetentorRN->cadastrar($objDetentor);
                    }else{
                        $arr_detentores = $objDetentorRN->pesquisar_index($objDetentor);
                        if(empty($arr_detentores)){
                            $objDetentorRN->alterar($objDetentor);
                            //$alert= Alert::getInstance()->alert_success_cadastrar();
                        }else {$objDetentor = $arr_detentores;}
                    }
                }
                
                //echo "igual";
                //die("asda");
                $objMarca->setIdMarca($objEquipamento->getIdMarca_fk());
                $objMarca->setMarca($_POST['txtMarca']);
                $objMarca->setIndex_marca(strtoupper($utils->tirarAcentos($_POST['txtMarca'])));
                $arr_marcas = $objMarcaRN->pesquisar_index($objMarca);
                if(empty($arr_marcas)){
                    $objMarcaRN->alterar($objMarca);
                    //$alert= Alert::getInstance()->alert_success_cadastrar();
                }else $objMarca->setIdMarca($arr_marcas[0]->getIdMarca());
                        
                $objModelo->setIdModelo($objEquipamento->getIdModelo_fk());                
                $objModelo->setModelo($_POST['txtModelo']);
                $objModelo->setIndex_modelo(strtoupper($utils->tirarAcentos($_POST['txtModelo'])));
                $arr_modelos = $objModeloRN->pesquisar_index($objModelo);
                if(empty($arr_modelos)){
                    $objModeloRN->alterar($objModelo);
                    //$alert= Alert::getInstance()->alert_success_cadastrar();
                }else $objModelo->setIdModelo($arr_modelos[0]->getIdModelo());
                               
                
                $objEquipamento->setDataUltimaCalibragem($_POST['dtUltimaCalibragem']);
                $objEquipamento->setDataChegada($_POST['dtChegada']);

                $objEquipamentoRN->alterar($objEquipamento);

                $alert= Alert::getInstance()->alert_success_editar();
            }

            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_equipamento.php');
    }
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Cadastrar Equipamento");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("equipamento");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();


   echo 
     $alert.
     Pagina::montar_topo_listar('CADASTRAR EQUIPAMENTO', 'listar_equipamento', 'LISTAR EQUIPAMENTOS').
    '<div class="conteudo_grande">    
        <div class="formulario">
            <form method="POST">


                <div class="form-row" style="margin-bottom: 30px;">  
                    <div class="col-md-9">
                        <h2> Cadastro de Equipamentos </h2>
                    </div>   

                    <div class="col-md-3">
                        <input type="text" class="form-control" id="idDtHrInicio" readonly  style="text-align: center;"
                           name="dtHrInicio" required value="'. Pagina::formatar_html($_SESSION['DATA_LOGIN']).'" >
                    </div>

                </div>

                <div class="form-row">  

                    <div class="col-md-4 mb-4">
                        <label for="detentorEquipamento" >Detentor:</label>
                        <input type="text" class="form-control" id="idDetentor" placeholder="Digite o nome do detentor " 
                               name="txtDetentor" required value="'.Pagina::formatar_html($objDetentor->getDetentor()).'" >
                    </div>

                    <div class="col-md-4 mb-4">
                        <label for="marcaEquipamento" >Marca:</label>
                        <input type="text" class="form-control" id="idMarca" placeholder="Digite o nome da marca " 
                               name="txtMarca" required value="'.Pagina::formatar_html($objMarca->getMarca()).'" >
                    </div>

                    <div class="col-md-4 mb-4">
                        <label for="modeloEquipamento">Modelo:</label>
                        <input type="text" class="form-control" id="idModelo" placeholder="Digite o nome do modelo " 
                               name="txtModelo" required value="'.Pagina::formatar_html($objModelo->getModelo()).'" >
                    </div>

                </div>


                <div class="form-row">  
                    <div class="col-md-4 mb-3">
                        <label for="label_dataUltimaCalibragem">*Digite a data da última calibragem:</label>
                        <input type="date" class="form-control" id="idDataUltimaCalibragem" placeholder="Última calibragem" 
                               onblur="validaDataUltimaCalibragem()" max="'.date('Y-m-d').'" 
                                   name="dtUltimaCalibragem" required 
                                   value="'.Pagina::formatar_html($objEquipamento->getDataUltimaCalibragem()).'">
                        <div id ="feedback_dataUltimaCalibragem"></div>

                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="label_dataChegada">*Digite a data da chegada:</label>
                        <input type="date" class="form-control" id="idDataChegada" placeholder="Data da chegada" 
                               onblur="validaDataChegada()" max="'.date('Y-m-d').'" name="dtChegada" 
                               required value="'.Pagina::formatar_html($objEquipamento->getDataChegada()).'">
                        <div id ="feedback_dataChegada"></div>

                    </div>

                </div> 
                <button class="btn btn-primary" type="submit" name="salvar_equipamento">Salvar</button>
            </form>
        </div>
    </div>';



Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();
