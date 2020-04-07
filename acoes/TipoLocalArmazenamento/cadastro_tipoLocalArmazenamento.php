<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/TipoLocalArmazenamento/TipoLocalArmazenamento.php';
require_once 'classes/TipoLocalArmazenamento/TipoLocalArmazenamentoRN.php';

$objPagina = new Pagina();
$objTipoLocalArm = new TipoLocalArmazenamento();
$objTipoLocalArmRN = new TipoLocalArmazenamentoRN();
$sucesso = '';
try{
    switch($_GET['action']){
        case 'cadastrar_tipoLocalArmazenamento':
            if(isset($_POST['salvar_tipoLocalArm'])){
                $objTipoLocalArm->setNomeLocal(mb_strtolower($_POST['txtNomeTipoLocal'],'utf-8'));
                $objTipoLocalArm->setQntEspacosTotal($_POST['numQntTotal']);
                $objTipoLocalArm->setQntEspacosAmostra($_POST['numQntAmostras']);
                
                $objTipoLocalArmRN->cadastrar($objTipoLocalArm);
                 $sucesso= '<div id="sucesso_bd" class="sucesso">Cadastrado com sucesso</div>';
            }else{
                $objTipoLocalArm->setIdTipoLocalArmazenamento('');
                $objTipoLocalArm->setNomeLocal('');
            }
        break;
        
        case 'editar_tipoLocalArmazenamento':
            if(!isset($_POST['salvar_tipoLocalArm'])){ //enquanto não enviou o formulário com as alterações
                $objTipoLocalArm->setIdTipoLocalArmazenamento($_GET['idTipoLocalArmazenamento']);
                $objTipoLocalArm = $objTipoLocalArmRN->consultar($objTipoLocalArm);
            }
            
             if(isset($_POST['salvar_tipoLocalArm'])){ //se enviou o formulário com as alterações
                $objTipoLocalArm->setIdTipoLocalArmazenamento($_GET['idTipoLocalArmazenamento']);
                $objTipoLocalArm->setNomeLocal(mb_strtolower($_POST['txtNomeTipoLocal'],'utf-8'));
                $objTipoLocalArmRN->alterar($objTipoLocalArm);
                 $sucesso= '<div id="sucesso_bd" class="sucesso">Alterado com sucesso</div>';
            }
            
            
            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_tipoLocalArmazenamento.php');  
    }
   
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}




?>

<?php
Pagina::abrir_head("Cadastrar Tipo de Local de Armazenamento");
?>
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
<?=$sucesso?>

<form method="POST">
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="label_tipoLocalArm">Digite nome do local de armazenamento</label>
            <input type="text" class="form-control" id="idNomeTipoLA" placeholder="Tipo local armazenamento" 
                   onblur="validaNomeTipoLocalArmazenamento()" name="txtNomeTipoLocal" required value="<?=$objTipoLocalArm->getNomeLocal()?>">
            <div id ="feedback_nomeLocal"></div>

        </div>
        <div class="col-md-4 mb-3">
            <label for="label_tipoQntTotal">Digite a quantidade total de espaços para amostras</label>
            <input type="number" min="0" class="form-control" id="idQntTotalEspacoLA" placeholder="nº total" 
                   onblur="validaEspacoTotal()" name="numQntTotal" required value="<?=$objTipoLocalArm->getQntEspacosTotal()?>">
            <div id ="feedback_qntTotal"></div>

        </div>
        <div class="col-md-4 mb-3">
            <label for="label_qntAmostra">Digite a quantidade de espaços com amostras</label>
            <input type="number" min="0" class="form-control" id="idQntEspacoAmostra" placeholder="nº amostras guardadas" 
                   onblur="validaEspacoAmostra()" name="numQntAmostras" required value="<?=$objTipoLocalArm->getQntEspacosAmostra()?>">
            <div id ="feedback_qntAmostra"></div>

        </div>
    </div>  
    <button class="btn btn-primary" type="submit" name="salvar_tipoLocalArm">Salvar</button>
</form>

<script src="js/tipoLocalArmazenamento.js"></script>
<script src="js/fadeOut.js"></script>


<?php 
$objPagina->mostrar_excecoes();
$objPagina->fechar_corpo(); 
?>

