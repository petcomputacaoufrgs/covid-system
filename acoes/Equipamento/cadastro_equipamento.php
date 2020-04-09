<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Equipamento/Equipamento.php';
require_once 'classes/Equipamento/EquipamentoRN.php';
require_once 'classes/Detentor/Detentor.php';
require_once 'classes/Detentor/DetentorRN.php';
require_once 'classes/Marca/Marca.php';
require_once 'classes/Marca/MarcaRN.php';
require_once 'classes/Modelo/Modelo.php';
require_once 'classes/Modelo/ModeloRN.php';
require_once 'utils/Utils.php';

$utils = new Utils();
session_start();

date_default_timezone_set('America/Sao_Paulo');
$_SESSION['DATA_LOGIN']  = date('d/m/Y  H:i:s');

$objPagina = new Pagina();
$objEquipamento = new Equipamento();
$objEquipamentoRN = new EquipamentoRN();
$sucesso = '';
$select_detentores = '';
$select_marcas = '';
$select_modelos = '';

$selected = '';

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
                /*salvar_detentor($objDetentor, $objDetentorRN, $objEquipamento);
                salvar_marca($objMarca, $objMarcaRN, $objEquipamento);
                salvar_modelo($objModelo, $objModeloRN, $objEquipamento);*/
                
                $objDetentor->setDetentor($_POST['txtDetentor']);
                $objDetentor->setIndex_detentor(strtoupper($utils->tirarAcentos($_POST['txtDetentor'])));
                $arr_detentores = $objDetentorRN->pesquisar_index($objDetentor);
                if(empty($arr_detentores)){
                    $objDetentorRN->cadastrar($objDetentor);
                    $sucesso= '<div id="sucesso_bd" class="sucesso">Cadastrado com sucesso</div>';
                }else $objDetentor->setIdDetentor($arr_detentores[0]->getIdDetentor());
                
                
                $objMarca->setMarca($_POST['txtMarca']);
                $objMarca->setIndex_marca(strtoupper($utils->tirarAcentos($_POST['txtMarca'])));
                $arr_marcas = $objMarcaRN->pesquisar_index($objMarca);
                if(empty($arr_marcas)){
                     $objMarcaRN->cadastrar($objMarca);
                    $sucesso= '<div id="sucesso_bd" class="sucesso">Cadastrado com sucesso</div>';
                }else $objMarca->setIdMarca($arr_marcas[0]->getIdMarca());
                        
                                
                $objModelo->setModelo($_POST['txtModelo']);
                $objModelo->setIndex_modelo(strtoupper($utils->tirarAcentos($_POST['txtModelo'])));
                $arr_modelos = $objModeloRN->pesquisar_index($objModelo);
                if(empty($arr_modelos)){
                    $objModeloRN->cadastrar($objModelo);
                    $sucesso= '<div id="sucesso_bd" class="sucesso">Cadastrado com sucesso</div>';
                }else $objModelo->setIdModelo($arr_modelos[0]->getIdModelo());
                
                $objEquipamento->setIdDetentor_fk($objDetentor->getIdDetentor());
                $objEquipamento->setIdMarca_fk($objMarca->getIdMarca());
                $objEquipamento->setIdModelo_fk($objModelo->getIdModelo());
                $objEquipamento->setDataUltimaCalibragem($_POST['dtUltimaCalibragem']);
                $objEquipamento->setDataChegada($_POST['dtChegada']);

                print_r($objEquipamento);
                $objEquipamentoRN->cadastrar($objEquipamento);

                $sucesso = '<div id="sucesso_bd" class="sucesso">Cadastrado com sucesso</div>';
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
            if (!isset($_POST['salvar_equipamento'])) { //enquanto não enviou o formulário com as alterações
                $objEquipamento->setIdEquipamento($_GET['idEquipamento']);
                $objEquipamento = $objEquipamentoRN->consultar($objEquipamento);
            }

            if (isset($_POST['salvar_equipamento'])) { //se enviou o formulário com as alterações
                               
                $objDetentor->setDetentor($_POST['txtDetentor']);
                $objDetentor->setIndex_detentor(strtoupper($utils->tirarAcentos($_POST['txtDetentor'])));
                $arr_detentores = $objDetentorRN->pesquisar_index($objDetentor);
                if(empty($arr_detentores)){
                    $objDetentorRN->alterar($objDetentor);
                    $sucesso= '<div id="sucesso_bd" class="sucesso">Alterado com sucesso</div>';
                }else $objDetentor->setIdDetentor($arr_detentores[0]->getIdDetentor());
                
                
                $objMarca->setMarca($_POST['txtMarca']);
                $objMarca->setIndex_marca(strtoupper($utils->tirarAcentos($_POST['txtMarca'])));
                $arr_marcas = $objMarcaRN->pesquisar_index($objMarca);
                if(empty($arr_marcas)){
                     $objMarcaRN->alterar($objMarca);
                    $sucesso= '<div id="sucesso_bd" class="sucesso">Alterado com sucesso</div>';
                }else $objMarca->setIdMarca($arr_marcas[0]->getIdMarca());
                        
                                
                $objModelo->setModelo($_POST['txtModelo']);
                $objModelo->setIndex_modelo(strtoupper($utils->tirarAcentos($_POST['txtModelo'])));
                $arr_modelos = $objModeloRN->pesquisar_index($objModelo);
                if(empty($arr_modelos)){
                    $objModeloRN->alterar($objModelo);
                    $sucesso= '<div id="sucesso_bd" class="sucesso">Alterado com sucesso</div>';
                }else $objModelo->setIdModelo($arr_modelos[0]->getIdModelo());
                echo $objModelo->getModelo();
                
                
                $objEquipamento->setDataUltimaCalibragem($_POST['dtUltimaCalibragem']);
                $objEquipamento->setDataChegada($_POST['dtChegada']);

                $objEquipamentoRN->alterar($objEquipamento);

                $sucesso = '<div id="sucesso_bd" class="sucesso">Alterado com sucesso</div>';
            }

            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_equipamento.php');
    }
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}


/*
function salvar_detentor($objDetentor, $objDetentorRN, &$objEquipamento) {
    $d = array();
    if (isset($_POST['sel_detentores']) && $_POST['sel_detentores']) {
        $objDetentor->setIdDetentor($_POST['sel_detentores']);
        $d = $objDetentorRN->consultar($objDetentor);
        $objEquipamento->setIdDetentor_fk($d->getIdDetentor());
    }
}

function salvar_marca($objMarca, $objMarcaRN, &$objEquipamento) {
    $mr = array();
    if (isset($_POST['sel_marcas']) && $_POST['sel_marcas'] != null) {
        $objMarca->setIdMarca($_POST['sel_marcas']);
        $mr = $objMarcaRN->consultar($objMarca);
        $objEquipamento->setIdMarca_fk($mr->getIdMarca());
    }
}

function salvar_modelo($objModelo, $objModeloRN, &$objEquipamento) {
    $md = array();
    if (isset($_POST['sel_modelos']) && $_POST['sel_modelos'] != null) {
        $objModelo->setIdModelo($_POST['sel_modelos']);
        $md = $objModeloRN->consultar($objModelo);
        $objEquipamento->setIdModelo_fk($md->getIdModelo());
    }
}

function montar_select_detentores(&$select_detentores, $objDetentor, $objDetentorRN, &$objEquipamento) {
    // DETENTORES 
    $selected = '';
    $arr_detentores = $objDetentorRN->listar($objDetentor);
    $select_detentores =  '<option data-tokens=""></option>';

    foreach ($arr_detentores as $detentor) {

        if ($detentor->getIdDetentor() == $objEquipamento->getIdDetentor_fk()) {
            $selected = 'selected';
        }
        $select_detentores .= '<option ' . $selected . ' value="' . $detentor->getIdDetentor() . '" data-tokens="' . $detentor->getDetentor() . '">' . $detentor->getDetentor() . '</option>';
    }
    
}

function montar_select_marcas(&$select_marcas, $objMarca, $objMarcaRN, &$objEquipamento) {
    // MARCAS 
    $selected = '';

    $arr_marcas = $objMarcaRN->listar($objMarca);
    $select_marcas = '<select class="form-control selectpicker" id="select-country idDetentor" data-live-search="true" name="sel_marcas">'
            . '<option data-tokens=""></option>';

    foreach ($arr_marcas as $marca) {
        if ($marca->getIdMarca() == $objEquipamento->getIdMarca_fk()) {
            $selected = 'selected';
        }
        $select_marcas .= '<option ' . $selected . '  value="' . $marca->getIdMarca() . '" data-tokens="' . $marca->getMarca() . '">' . $marca->getMarca() . '</option>';
    }
    $select_marcas .= '</select>';
}

function montar_select_modelos(&$select_modelos, $objModelo, $objModeloRN, &$objEquipamento) {
    // MODELOS 
    $selected = '';
    $arr_modelos = $objModeloRN->listar($objModelo);
    $select_modelos = '<select class="form-control selectpicker" id="select-country modelo" data-live-search="true" name="sel_modelos">'
            . '<option data-tokens=""></option>';

    foreach ($arr_modelos as $modelo) {
        if ($modelo->getIdModelo() == $objEquipamento->getIdModelo_fk()) {
            $selected = 'selected';
        }
        $select_modelos .= '<option ' . $selected . '  value="' . $modelo->getIdModelo() . '" data-tokens="' . $modelo->getModelo() . '">' . $modelo->getModelo() . '</option>';
    }
    $select_modelos .= '</select>';
}
*/
?>

<?php Pagina::abrir_head("Cadastrar Equipamento"); ?>



<style>
    body,html{
        font-size: 14px !important;
    }
    .dropdown-toggle{
        
        height: 45px;
    }
    .placeholder_colored::-webkit-input-placeholder  {
        color: red;
        text-align: left;
    } 
    .sucesso{
        width: 100%;
        background-color: green;
    }
    /*.form-control-label{
        background-color: green;
    }*/
    .selectpicker{
        /*background-color: purple;*/
    }

    .formulario{
        margin:50px;
        padding: 10px;
    }
    .container{
        background-color: pink;
    }

    
</style>
<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo(); ?>
<?= $sucesso ?>


<div class="formulario">
    <form method="POST">
        
        <!--
        <div class="form-row">  
            
            <div class="col-md-4 mb-4">
                <label for="detentorEquipamento" >*Detentor:</label>
                <select class="form-control selectpicker " id="select-country" data-live-search="true" name="sel_detentores">
                    <?= $select_detentores ?>
                </select>
            </div>

            <div class="col-md-4 mb-4">
                <label for="marcaEquipamento" >Marca:</label>
                <?= $select_marcas ?>
            </div>

            <div class="col-md-4 mb-4">
                <label for="modeloEquipamento">Modelo:</label>
                <?= $select_modelos ?>
            </div>

        </div>
        -->
        <div class="form-row" style="margin-bottom: 30px;">  
            <div class="col-md-6">
                <h2> Cadastro de Equipamentos </h2>
            </div>   
            
            <div class="col-md-4">
                <input type="text" class="form-control" id="idUsuarioLogado" readonly style="text-align: center;margin-bottom: 10px;"
                   name="txtUsuarioLogado" required value="Identificador do usuário logado: xxxxxxxx" >
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" id="idDtHrInicio" readonly  style="text-align: center;"
                   name="dtHrInicio" required value="<?=$_SESSION['DATA_LOGIN'] ?>" >
            </div>
                    
        </div>
        
        <div class="form-row">  
            
            <div class="col-md-4 mb-4">
                <label for="detentorEquipamento" >Detentor:</label>
                <input type="text" class="form-control" id="idDetentor" placeholder="Digite o nome do detentor " 
                       name="txtDetentor" required value="<?=$objDetentor->getDetentor()?>" >
            </div>

            <div class="col-md-4 mb-4">
                <label for="marcaEquipamento" >Marca:</label>
                <input type="text" class="form-control" id="idMarca" placeholder="Digite o nome da marca " 
                       name="txtMarca" required value="<?=$objMarca->getMarca()?>" >
            </div>

            <div class="col-md-4 mb-4">
                <label for="modeloEquipamento">Modelo:</label>
                <input type="text" class="form-control" id="idModelo" placeholder="Digite o nome do modelo " 
                       name="txtModelo" required value="<?=$objModelo->getModelo()?>" >
            </div>

        </div>
        

        <div class="form-row">  
            <div class="col-md-4 mb-3">
                <label for="label_dataUltimaCalibragem">*Digite a data da última calibragem:</label>
                <input type="date" class="form-control" id="idDataUltimaCalibragem" placeholder="Última calibragem" 
                       onblur="validaDataUltimaCalibragem()" max="<?php echo date('Y-m-d'); ?>" name="dtUltimaCalibragem" required value="<?= $objEquipamento->getDataUltimaCalibragem() ?>">
                <div id ="feedback_dataUltimaCalibragem"></div>

            </div>

            <div class="col-md-4 mb-3">
                <label for="label_dataChegada">*Digite a data da chegada:</label>
                <input type="date" class="form-control" id="idDataChegada" placeholder="Data da chegada" 
                       onblur="validaDataChegada()" max="<?php echo date('Y-m-d'); ?>" name="dtChegada" 
                       required value="<?= $objEquipamento->getDataChegada() ?>">
                <div id ="feedback_dataChegada"></div>

            </div>

        </div> 
        <button class="btn btn-primary" type="submit" name="salvar_equipamento">Salvar</button>
    </form>
</div>

<script src="js/equipamento.js"></script>
<script src="js/fadeOut.js"></script>

<?php
$objPagina->mostrar_excecoes();
$objPagina->fechar_corpo();
?>


