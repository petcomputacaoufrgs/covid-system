<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
session_start();

date_default_timezone_set('America/Sao_Paulo');
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$idAmostra  = null;
        
    if(isset($_POST['liberar_capela'])){
        $_SESSION['DATA_LIBERACAO_CAPELA']  = date('d/m/Y  H:i:s');
    }else{
        $_SESSION['DATA_LOGIN']  = date('d/m/Y  H:i:s');
    }
    
    if(isset($_POST['sel_recurso'])){
        //SETAR ID
    }
    if(isset($_POST['sel_codAmostra']) && $_POST['sel_codAmostra'] != null){
       $idAmostra = $_POST['sel_codAmostra'];
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
        margin-right: 5%;
        margin-left: 5%;
        margin-top: 10%;
    }
    
   
</style>


<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo(); ?>

<div class="formulario">
    <form method="POST">
        
        <div class="form-row" style="margin-bottom: 30px;">  
            <div class="col-md-6">
                <h2> Extração </h2>
            </div>   
            
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
            
             <div class="col-md-3 ">
                <label for="tipoAmostra">Recursos Disponíveis</label>
                <select class="form-control selectpicker" 
                    id="select-country idSel_perfilPaciente" data-live-search="true" name="sel_recurso" 
                    onChange="val_selRecurso()">
                 <option data-tokens="" value="0" >Selecione um recurso</option>
                 <option data-tokens="" value="1" > Recurso 1 </option>
                 <option data-tokens=""  value="2"> Recurso 2 </option>
                 <option data-tokens="" value="3"> Recurso 3 </option>
                <!--<?= $select_perfis ?>-->
                </select>
            </div> 
            <div class="col-md-3 ">
                <label for="tipoAmostra">Perfil do paciente</label>
                <select class="form-control selectpicker" 
                    id="select-country idSel_perfilPaciente" data-live-search="true" 
                    name="sel_perfilPaciente" onChange="val_selPerfil()">
                 <option data-tokens="" value="0" >Selecione um perfil de paciente</option>
                 <option data-tokens="" value="1" > Equipe de Voluntários </option>
                 <option data-tokens=""  value="2">Profissionais da Saúde</option>
                 <option data-tokens="" value="3">Paciente SUS</option>
                <!--<?= $select_perfis ?>-->
                </select>
            </div> 
            
            <?php if(isset($_GET['idPerfilPaciente'])){ ?>
            
            <div class="col-md-3 ">
                <!-- apenas códigos de amostra do perfil já selecionado -->
                <label for="tipoAmostra">Código da amostra</label>
                <select class="form-control selectpicker" 
                    id="select-country idSel_perfilPaciente" data-live-search="true" name="sel_codAmostra" 
                    onChange="this.form.submit()">
                 <option data-tokens="" value="0" >Selecione uma amostra</option>
                 <option data-tokens="" value="123456700" > 123456700 </option>
                 <option data-tokens=""  value="123456789"> 123456789</option>
                 <option data-tokens="" value="458293018">  458293018</option>
                <!--<?= $select_perfis ?>-->
                </select>
            </div> 
            
            <?php } ?>
            
             <?php if($idAmostra != null){ ?>
            <div class="col-md-3 ">
                <label for="tipoAmostra">Local da amostra: </label>
                <input type="text" class="form-control" id="idDataHoraLogin" readonly 
                   name="dtHoraLoginInicio" required value="gaveta x" >
            </div>
                                                   
        </div>
                
               
          
        <div class="form-row" style="margin-top:10px;">  
            
            <!--<div class="col-md-1"><h3 style="color:gray;margin-top:30px;text-align: center;"> Dados da  </h3></div>-->
            
            <div class="col-md-3 ">
                <label for="tipoAmostra"> Concentração </label>
                <input type="number" class="form-control" id="idDataHoraLogin"  
                   name="dtHoraLoginInicio" required value=" 00000" >
            </div>
            
            <div class="col-md-3 ">
                <label for="tipoAmostra"> Pureza </label>
                <input type="number" class="form-control" id="idDataHoraLogin"  
                   name="dtHoraLoginInicio" required value=" 00000" >
            </div>
            
            <div class="col-md-3 ">
                <label for="tipoAmostra"> 260/280 </label>
                <input type="number" class="form-control" id="idDataHoraLogin"  
                   name="dtHoraLoginInicio" required value=" 00000" >
            </div>
            
            <div class="col-md-3 ">
                <label for="tipoAmostra"> 200/230 </label>
                <input type="number" class="form-control" id="idDataHoraLogin"  
                   name="dtHoraLoginInicio" required value=" 00000" >
            </div>

        </div>
        
         <!-- 
            mostrar apenas os lugares liberados
         -->
         
         <div class="form-row" style="margin-top:10px;">  
            <div class="col-md-4 ">
                    <label for="tipoAmostra">Local onde a amostra será armazenada</label>
                    <select class="form-control selectpicker" 
                        id="select-country idSel_tiposAmostra" data-live-search="true" name="sel_tipoAmostra" >
                     <option data-tokens="" >Selecione um local temporário</option>
                     <option data-tokens="" >gaveta x </option>
                     <option data-tokens="" >gaveta y </option>
                     <option data-tokens="" >freezer x</option>
                     <option data-tokens="" >freezer y</option>
                    <!--<?= $select_perfis ?>-->
                    </select>
            </div> 
             
            <div class="col-md-3">
                <div class="custom-control custom-checkbox mr-sm-2" style="margin-top: 40px;font-size: 25px;font-weight: bold;">
                    <input type="checkbox" class="custom-control-input" id="customControlAutosizing" >
                    <label class="custom-control-label" for="customControlAutosizing" >Utilizar local anterior</label>
                  </div>
            </div>
             
             
             <div class="col-md-5">
                 <label for="tipoAmostra">Reteste</label>
                <div class="custom-control custom-checkbox mr-sm-2" style=";font-size: 25px;font-weight: bold;">
                    <input type="checkbox" class="custom-control-input" id="customControlAutosizing2" >
                    <label class="custom-control-label" for="customControlAutosizing2" >será necessário um reteste?</label>
                  </div>
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
                window.location.href = "controlador.php?action=extrair_amostra&idAmostra=" + e.target.value;
                /*$.post("cadastro_paciente.php", {perfilSelecionado:e.target.value},function(data){
                 alert("data sent and received: "+data);
                 });*/

            });
        }
        
       

    function val_selRecurso() {
        $('.selectpicker').change(function (e) {
            //alert(e.target.value);
            //document.getElementById("class1").innerHTML = e.target.value ;
            window.location.href = window.location.href+ "&idSelRecurso=" + e.target.value;
            /*$.post("cadastro_paciente.php", {perfilSelecionado:e.target.value},function(data){
             alert("data sent and received: "+data);
             });*/

        });
    }
    
    
    function val_selPerfil() {
        $('.selectpicker').change(function (e) {
            //alert(e.target.value);
            //document.getElementById("class1").innerHTML = e.target.value ;
            window.location.href = window.location.href+"&idPerfilPaciente=" + e.target.value;
            /*$.post("cadastro_paciente.php", {perfilSelecionado:e.target.value},function(data){
             alert("data sent and received: "+data);
             });*/

        });
    }
    
    function val_amostra() {
        $('.selectpicker').change(function (e) {
            //alert(e.target.value);
            //document.getElementById("class1").innerHTML = e.target.value ;
            window.location.href = window.location.href+"&idAmostra=" + e.target.value;
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
