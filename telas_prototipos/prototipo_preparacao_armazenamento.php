<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

use InfUfrgs\Pagina\Pagina;
use InfUfrgs\Excecao\Excecao;
session_start();

date_default_timezone_set('America/Sao_Paulo');
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$dateLogin = date('d/m/Y  H:i:s');
$_SESSION['DATA_LOGIN']  = $dateLogin;

 //echo $actual_link;
$objPagina = new Pagina();
?>


<?php Pagina::abrir_head("Cadastrar Paciente"); ?>
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
    .formulario{
        margin: 50px;
    }

</style>

<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo(); ?>

<div class="formulario">
    <form method="POST">
        
        <div class="form-row">  
            <div class="col-md-10"><h3> Local de Armazenamento </h3></div>
            <div class="col-md-2">
                <input type="text" class="form-control" id="idDataHoraLogin" readonly 
                   name="dtHoraLoginInicio" required value="<?=$_SESSION['DATA_LOGIN'] ?>" >
            </div>
                    
        </div>           
        <hr width = “2” size = “100”>
        
        <div class="form-row">  
            <div class="col-md-12">
                <label for="numAmostra">Nº da amostra:</label>
                <select class="form-control selectpicker" onchange="val_num_amostra()"
                    id="select-country idSel_tiposAmostra" data-live-search="true" name="sel_tipoAmostra">
                 <option data-tokens="" ></option>
                 <option data-tokens="" >1234</option>
                 <option data-tokens="" >23748</option>
                 <option data-tokens="" >2918</option>
                 <option data-tokens="" >2123</option>
                <!--<?= $select_perfis ?>-->
                </select>
            </div>
        </div>
                    
       <?php
            if (!isset($_GET['idAmostra']) && !isset($_GET['idAmostra'])) {
                echo '<small style="color:red;"> Nenhuma amostra foi selecionado</small>';
            } else {
                ?> 
        
        <h5 style="margin-top:40px; color:gray;"> Tubo 1 da amostra </h5>
        <hr width = “2” size = “100”>
        <div class="form-row" style="margin-top:10px;">  
           
            <div class="col-md-6">
                <label for="tipoAmostra">Tipo da amostra</label>
                <select class="form-control selectpicker" 
                    id="select-country idSel_tiposAmostra" data-live-search="true" name="sel_tipoAmostra">
                 <option data-tokens="" ></option>
                 <option data-tokens="" >congelada</option>
                 <option data-tokens="" >normal</option>
                <!--<?= $select_perfis ?>-->
                </select>
            </div>
            
            
            <div class="col-md-6">
                <label for="numAmostra">Locais de armazenamento já pré cadastrados</label>
                <select class="form-control selectpicker" 
                        id="select-country idSel_tiposAmostra" onchange="this.form.submit()" data-live-search="true" name="sel_tipoAmostra">
                 <option data-tokens="" ></option>
                 <option data-tokens="" >gaveta x - temporária - com 4 espaços vazios</option>
                 <option data-tokens="" >gaveta y - temporária - com 2 espaços vazios</option>
                 <option data-tokens="" >frezzer a - temporária - com 1 espaços vazios</option>
                 <option data-tokens="" >gaveta z - temporária - com 4 espaços vazios</option>
                <!--<?= $select_perfis ?>-->
                </select>
            </div>
            
            
            
        </div>
        
        <h5 style="margin-top:40px; color:gray;"> Tubo 2 da amostra </h5>
        <hr width = “2” size = “100”>
        <div class="form-row" style="margin-top:10px;">  
           
            <div class="col-md-6">
                <label for="numAmostra">Locais de armazenamento já pré cadastrados</label>
                <select class="form-control selectpicker" 
                    id="select-country idSel_tiposAmostra" data-live-search="true" name="sel_tipoAmostra">
                 <option data-tokens="" ></option>
                 <option data-tokens="" >gaveta x - temporária - com 4 espaços vazios</option>
                 <option data-tokens="" >gaveta y - temporária - com 2 espaços vazios</option>
                 <option data-tokens="" >frezzer a - temporária - com 1 espaços vazios</option>
                 <option data-tokens="" >gaveta z - temporária - com 4 espaços vazios</option>
                <!--<?= $select_perfis ?>-->
                </select>
            </div>
            
            <div class="col-md-6">
                <label for="tipoAmostra">Tipo da amostra</label>
                <select class="form-control selectpicker" 
                    id="select-country idSel_tiposAmostra" data-live-search="true" name="sel_tipoAmostra">
                 <option data-tokens="" ></option>
                 <option data-tokens="" >congelada</option>
                 <option data-tokens="" >normal</option>
                <!--<?= $select_perfis ?>-->
                </select>
            </div>
            
        </div>
        
        
        <h5 style="margin-top:40px; color:gray;"> Tubo 3 da amostra </h5>
        <hr width = “2” size = “100”>
        <div class="form-row" style="margin-top:10px;">  
           
            <div class="col-md-6">
                <label for="numAmostra">Locais de armazenamento já pré cadastrados</label>
                <select class="form-control selectpicker" 
                    id="select-country idSel_tiposAmostra" data-live-search="true" name="sel_tipoAmostra">
                 <option data-tokens="" ></option>
                 <option data-tokens="" >gaveta x - temporária - com 4 espaços vazios</option>
                 <option data-tokens="" >gaveta y - temporária - com 2 espaços vazios</option>
                 <option data-tokens="" >frezzer a - temporária - com 1 espaços vazios</option>
                 <option data-tokens="" >gaveta z - temporária - com 4 espaços vazios</option>
                <!--<?= $select_perfis ?>-->
                </select>
            </div>
            
            <div class="col-md-6">
                <label for="tipoAmostra">Tipo da amostra</label>
                <select class="form-control selectpicker" 
                    id="select-country idSel_tiposAmostra" data-live-search="true" name="sel_tipoAmostra">
                 <option data-tokens="" ></option>
                 <option data-tokens="" >congelada</option>
                 <option data-tokens="" >normal</option>
                <!--<?= $select_perfis ?>-->
                </select>
            </div>
            
        </div>
               


         

            <button style="margin-top:20px;" class="btn btn-primary" type="submit" name="salvar_paciente">Salvar</button>
<?php } ?>
    </form>


</div>

<script>
    function val_num_amostra() {
            $('.selectpicker').change(function (e) {
                //alert(e.target.value);
                //document.getElementById("class1").innerHTML = e.target.value ;
                window.location.href = "controlador.php?action=cadastrar_amostra_localArmazenamento&idAmostra=" + e.target.value;
                /*$.post("cadastro_paciente.php", {perfilSelecionado:e.target.value},function(data){
                 alert("data sent and received: "+data);
                 });*/

            });
        }


</script>
<?php
$objPagina->mostrar_excecoes();
$objPagina->fechar_corpo();
?>
