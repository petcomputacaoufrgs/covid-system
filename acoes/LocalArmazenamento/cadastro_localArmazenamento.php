<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/LocalArmazenamento/LocalArmazenamento.php';
require_once 'classes/LocalArmazenamento/LocalArmazenamentoRN.php';
require_once 'classes/TipoLocalArmazenamento/TipoLocalArmazenamento.php';
require_once 'classes/TipoLocalArmazenamento/TipoLocalArmazenamentoRN.php';
require_once 'classes/TempoPermanencia/TempoPermanencia.php';
require_once 'classes/TempoPermanencia/TempoPermanenciaRN.php';

$objPagina = new Pagina();
$objLocalArmazenamento = new LocalArmazenamento();
$objLocalArmazenamentoRN = new LocalArmazenamentoRN();
$sucesso = '';

$select_temposPermanencias = '';
$select_tiposLocais = '';
try{
    
    /* TIPO LOCAL */
    $objTipoLocalArm = new TipoLocalArmazenamento();
    $objTipoLocalArmRN = new TipoLocalArmazenamentoRN();
    
    /* TEMPO PERMANÊNCIA */
    $objTempoPermanencia = new TempoPermanencia();
    $objTempoPermanenciaRN = new TempoPermanenciaRN();
    
    switch($_GET['action']){
        case 'cadastrar_localArmazenamento':
            montar_select_tipoLA($select_tiposLocais, $objTipoLocalArm, $objTipoLocalArmRN, $objLocalArmazenamento);
            montar_select_tempoPermanenciaLA($select_temposPermanencias, $objTempoPermanencia, $objTempoPermanenciaRN, $objLocalArmazenamento);
            
            if(isset($_POST['salvar_localArmazenamento'])){
                $objLocalArmazenamento->setMatricula( $_POST['numMatricula']);
                $objLocalArmazenamentoRN->cadastrar($objLocalArmazenamento);
                $sucesso= '<div id="sucesso_bd" class="sucesso">Cadastrado com sucesso</div>';
            }else{
                $objLocalArmazenamento->setIdLocalArmazenamento('');
                $objLocalArmazenamento->setDataHoraFim('');
                $objLocalArmazenamento->setDataHoraInicio('');
                $objLocalArmazenamento->setIdTempoPermanencia_fk('');
                $objLocalArmazenamento->setIdTipoLocal_fk('');
            }
        break;
        
        case 'editar_localArmazenamento':
            if(!isset($_POST['salvar_localArmazenamento'])){ //enquanto não enviou o formulário com as alterações
                $objLocalArmazenamento->setIdLocalArmazenamento($_GET['idLocalArmazenamento']);
                $objLocalArmazenamento = $objLocalArmazenamentoRN->consultar($objLocalArmazenamento);
            }
            
             if(isset($_POST['salvar_localArmazenamento'])){ //se enviou o formulário com as alterações
                $objLocalArmazenamento->setIdLocalArmazenamento($_GET['idLocalArmazenamento']);
                $objLocalArmazenamento->setMatricula($_POST['numMatricula']);
                $objLocalArmazenamentoRN->alterar($objLocalArmazenamento);
                $sucesso= '<div id="sucesso_id" class="sucesso">Alterado com sucesso</div>';
            }
            
            
            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_localArmazenamento.php');  
    }
   
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

function montar_select_tempoPermanenciaLA(&$select_temposPermanencias, $objTempoPermanencia, $objTempoPermanenciaRN, &$objLocalArmazenamento) {
    /* TEMPO DE PERMANÊNCIA  */
    $selected = '';
    $arr_temposPermanencias= $objTempoPermanenciaRN->listar($objTempoPermanencia);
    $select_temposPermanencias = '<select class="form-control selectpicker" id="select-country" data-live-search="true" name="sel_tempoPermanencia">'
            . '<option data-tokens=""></option>';

    foreach ($arr_temposPermanencias as $tempoPermanencia) {
        if ($tempoPermanencia->getIdTempoPermanencia() == $objLocalArmazenamento->getIdTempoPermanencia_fk()) {
            $selected = 'selected';
        }
        $select_temposPermanencias .= '<option ' . $selected . '  value="' . $tempoPermanencia->getIdTempoPermanencia() 
                . '" data-tokens="' . $tempoPermanencia->getTempoPermanencia() . '">' 
                . $tempoPermanencia->getTempoPermanencia(). '</option>';
    }
    $select_temposPermanencias .= '</select>';
}

function montar_select_tipoLA(&$select_tiposLocais, $objTipoLocalArm, $objTipoLocalArmRN, &$objLocalArmazenamento) {
    /* TIPO LOCAL ARMAZENAMENTO */
    $selected = '';
    $arr_tiposLocais = $objTipoLocalArmRN->listar($objTipoLocalArm);
    $select_tiposLocais = '<select class="form-control selectpicker" id="select-country" data-live-search="true" name="sel_tiposLocais">'
            . '<option data-tokens=""></option>';

    foreach ($arr_tiposLocais as $tipoLocal) {
        if ($tipoLocal->getIdTipoLocalArmazenamento() == $objLocalArmazenamento->getIdLocalArmazenamento()) {
            $selected = 'selected';
        }
        $select_tiposLocais .= '<option ' . $selected . '  value="' . $tipoLocal->getIdTipoLocalArmazenamento() 
                . '" data-tokens="' . $tipoLocal->getNomeLocal() . '">' 
                . $tipoLocal->getNomeLocal() .' - espaços vazios: '
                . ($tipoLocal->getQntEspacosTotal()  - $tipoLocal->getQntEspacosAmostra())  . '</option>';
    }
    $select_tiposLocais .= '</select>';
}
?>


<?php Pagina::abrir_head("Cadastrar Local Armazenamento"); ?>
 <style>
    .placeholder_colored::-webkit-input-placeholder  {
        color: red;
        text-align: left;
    } 
    .sucesso{
        width: 100%;
        background-color: green;
    }
</style>
<?php Pagina::fechar_head();?>
<?php $objPagina->montar_menu_topo();?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />


<?=$sucesso?>
<div class="formulario">
    <form method="POST">
        <div class="form-row">  
            
            <div class="col-md-4 mb-4">
                <label for="LA_tempoPermanencia" >Qual o tempo de permanência neste local:</label>
                <?= $select_temposPermanencias ?>
            </div>

            <div class="col-md-4 mb-4">
                <label for="tipoLocal">Tipo local de armazenamento:</label>
                <?= $select_tiposLocais ?>
            </div>

        </div>

        <!--<div class="form-row">  
            <div class="col-md-4 mb-3">
                <label for="label_dataUltimaCalibragem">Digite a data da última calibragem:</label>
                <input type="date" class="form-control" id="idDataUltimaCalibragem" placeholder="Última calibragem" 
                       onblur="validaDataUltimaCalibragem()" max="<?php date('Y-m-d'); ?>" name="dtUltimaCalibragem" required value="<?= $objEquipamento->getDataUltimaCalibragem() ?>">
                <div id ="feedback_dataUltimaCalibragem"></div>

            </div>

            <div class="col-md-4 mb-3">
                <label for="label_dataChegada">Digite a data da chegada:</label>
                <input type="date" class="form-control" id="idDataChegada" placeholder="Data da chegada" 
                       onblur="validaDataChegada()" max="<?php date('Y-m-d'); ?>" name="dtChegada" 
                       required value="<?= $objEquipamento->getDataChegada() ?>">
                <div id ="feedback_dataChegada"></div>

            </div> -->

        </div> 
        <button class="btn btn-primary" type="submit" name="salvar_localArmazenamento">Salvar</button>
    </form>
</div>

<script src="js/usuario.js"></script>
<script src="js/fadeOut.js"></script>

<?php 
$objPagina->mostrar_excecoes(); 
$objPagina->fechar_corpo(); 
?>


