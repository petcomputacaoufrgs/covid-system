<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
session_start();

date_default_timezone_set('America/Sao_Paulo');
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$idPerfilPaciente = null;  
        
        
    if(isset($_POST['sel_perfilPaciente']) && $_POST['sel_perfilPaciente']!= null){
        $idPerfilPaciente = $_POST['sel_perfilPaciente'];
    }

    if(isset($_POST['imprimir'])){
       header('Location: controlador.php?action=imprimir_laudo');
    }
 //echo $actual_link;
$objPagina = new Pagina();
?>


<?php Pagina::abrir_head("ETAPA 2"); ?>
<style>
    body,html{
        font-size: 20px !important;
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


<style>
    .custom-control-input{
        
    }
    
    
</style>
<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo(); ?>

<div class="formulario">
    <form method="POST">
        
        <div class="form-row">  
            <div class="col-md-6"><h2> Laudo </h2></div>   
            
            <div class="col-md-4">
                <input type="text" class="form-control" id="idDataHoraLogin" readonly style="text-align: center;margin-bottom: 10px;"
                   name="dtHoraLoginInicio" required value="Identificador do usuário logado: xxxxxxxx" >
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" id="idDataHoraLogin" readonly  style="text-align: center;"
                   name="dtHoraLoginInicio" required value="<?=$_SESSION['DATA_LOGIN'] ?>" >
            </div>
                    
        </div>           
        
              
        
        <div class="form-row">  
            <div class="col-md-4 ">
                <label for="tipoAmostra">Perfil do paciente</label>
                <select class="form-control selectpicker" 
                    id="select-country idSel_perfilPaciente" data-live-search="true" name="sel_perfilPaciente" onChange="this.form.submit()">
                 <option data-tokens="" value="0" >Selecione um perfil de paciente</option>
                 <option data-tokens="" value="1" > Equipe de Voluntários </option>
                 <option data-tokens=""  value="2">Profissionais da Saúde</option>
                 <option data-tokens="" value="3">Paciente SUS</option>
                <!--<?= $select_perfis ?>-->
                </select>
            </div>
            <?php if(isset($_POST['sel_perfilPaciente'])){ ?>
            <div class="col-md-4 ">
            <label for="tipoAmostra"> Nº da amostra: </label>
            <input type="number" class="form-control" id="idDataHoraLogin" readonly  
                   name="dtHoraLoginInicio" required value="12345" >
            </div>
                       
            
            <div class="col-md-4 ">
            <label for="tipoAmostra"> Resultado do Laudo: </label>
            <input type="text" class="form-control" id="idDataHoraLogin" readonly  
                   name="dtHoraLoginInicio" required value="positivo" >
            </div>
        </div>
        <div class="form-row">  
            <div class="col-md-3 ">
            <label for="tipoAmostra"> Nome do paciente: </label>
            <input type="text" class="form-control" id="idDataHoraLogin" readonly  
                   name="dtHoraLoginInicio" required value="nome aqui" >
            </div>
            
            <div class="col-md-3 ">
             <label for="tipoAmostra"> CPF: </label>
            <input type="text" class="form-control" id="idDataHoraLogin" readonly  
                   name="dtHoraLoginInicio" required value="nome aqui" >
            </div>
        
            <div class="col-md-3 ">
             <label for="tipoAmostra"> RG: </label>
            <input type="text" class="form-control" id="idDataHoraLogin" readonly  
                   name="dtHoraLoginInicio" required value="nome aqui" >
            </div>
            
            <?php if($_POST['sel_perfilPaciente'] == 3){ ?>
            <div class="col-md-3 ">
            <label for="tipoAmostra"> Código GAL: </label>
            <input type="text" class="form-control" id="idDataHoraLogin" readonly  
                   name="dtHoraLoginInicio" required value="nome aqui" >
            </div>
            <?php } ?>
            
        </div>
            <div class="form-row">  
            <div class="col-md-8">
                <label for="observações amostra"> Observações </label>
                <textarea onblur="validaObs()" id="idTxtAreaObs" name="txtAreaObs" rows="3" cols="100" class="form-control" id="obsAmostra" rows="3"></textarea>
                <div id ="feedback_obsAmostra"></div>
            </div>

                
                <div class="col-md-4">
                <div class="custom-control custom-checkbox mr-sm-2" style="margin-top: 40px;font-size: 25px;font-weight: bold;">
                    <input type="checkbox" class="custom-control-input" id="customControlAutosizing" >
                    <label class="custom-control-label" for="customControlAutosizing" >Laudo entregue</label>
                  </div>
            </div>
            
           
        </div>
        <button style="margin-top:20px;" class="btn btn-primary" value="imprimir" name="imprimir">Imprimir Laudo</button>
            <button style="margin-top:20px;" class="btn btn-primary" type="submit" name="salvar_paciente">Salvar</button>
       <?php } ?>
               
    </form>


</div>


<?php
$objPagina->mostrar_excecoes();
$objPagina->fechar_corpo();
?>
