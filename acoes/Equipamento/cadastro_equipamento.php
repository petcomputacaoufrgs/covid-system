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
                salvar_detentor($objDetentor, $objDetentorRN, $objEquipamento);
                salvar_marca($objMarca, $objMarcaRN, $objEquipamento);
                salvar_modelo($objModelo, $objModeloRN, $objEquipamento);
                $objEquipamento->setDataUltimaCalibragem($_POST['dtUltimaCalibragem']);
                $objEquipamento->setDataChegada($_POST['dtChegada']);

                //print_r($objEquipamento);
                $objEquipamentoRN->cadastrar($objEquipamento);



                $sucesso = '<div id="sucesso_bd" class="sucesso">Cadastrado com sucesso</div>';
            }
            $objEquipamento->setIdEquipamento('');
            $objEquipamento->setIdDetentor_fk('');
            $objEquipamento->setIdMarca_fk('');
            $objEquipamento->setIdModelo_fk('');
            $objEquipamento->setDataChegada('');
            $objEquipamento->setDataUltimaCalibragem('');
            montar_select_detentores($select_detentores, $objDetentor, $objDetentorRN, $objEquipamento);
            montar_select_marcas($select_marcas, $objMarca, $objMarcaRN, $objEquipamento);
            montar_select_modelos($select_modelos, $objModelo, $objModeloRN, $objEquipamento);

            break;

        case 'editar_equipamento':
            if (!isset($_POST['salvar_equipamento'])) { //enquanto não enviou o formulário com as alterações
                $objEquipamento->setIdEquipamento($_GET['idEquipamento']);
                $objEquipamento = $objEquipamentoRN->consultar($objEquipamento);
            }

            if (isset($_POST['salvar_equipamento'])) { //se enviou o formulário com as alterações
                $objEquipamento->setIdEquipamento($_GET['idEquipamento']);

                salvar_detentor($objDetentor, $objDetentorRN, $objEquipamento);
                salvar_marca($objMarca, $objMarcaRN, $objEquipamento);
                salvar_modelo($objModelo, $objModeloRN, $objEquipamento);

                $objEquipamento->setDataUltimaCalibragem($_POST['dtUltimaCalibragem']);
                $objEquipamento->setDataChegada($_POST['dtChegada']);


                $objEquipamentoRN->alterar($objEquipamento);

                $sucesso = '<div id="sucesso_bd" class="sucesso">Alterado com sucesso</div>';
            }

            montar_select_detentores($select_detentores, $objDetentor, $objDetentorRN, $objEquipamento);
            montar_select_marcas($select_marcas, $objMarca, $objMarcaRN, $objEquipamento);
            montar_select_modelos($select_modelos, $objModelo, $objModeloRN, $objEquipamento);

            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_equipamento.php');
    }
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

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
    /* DETENTORES */
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
    /* MARCAS */
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
    /* MODELOS */
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
?>

<?php Pagina::abrir_head("Cadastrar Equipamento"); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />



<style>
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

    .box{
        border: 1px solid red;
    }
</style>
<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo(); ?>
<?= $sucesso ?>


<h1>Cadastro de Equipamentos</h1>

<div class="formulario">
    <form method="POST">
        <div class="form-row">  
            
            <div class="col-md-4 mb-4">
                <label for="detentorEquipamento" >*Detentor:</label>
                <select class="form-control selectpicker is-invalid" id="select-country" data-live-search="true" name="sel_detentores">
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


