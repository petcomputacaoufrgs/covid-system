<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
session_start();

date_default_timezone_set('America/Sao_Paulo');
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    
        
    if(isset($_POST['liberar_capela'])){
        $_SESSION['DATA_LIBERACAO_CAPELA']  = date('d/m/Y  H:i:s');
    }else{
        $_SESSION['DATA_LOGIN']  = date('d/m/Y  H:i:s');
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
            <div class="col-md-6"><h2> Preparação </h2></div>   
            
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
                <label for="tipoAmostra">Capela que foi selecionada: </label>
                <input type="text" class="form-control" id="idDataHoraLogin" readonly 
                   name="dtHoraLoginInicio" required value="A capela é a de número xxxxxxxxxx" >
            </div>
            <div class="col-md-3 ">
                <label for="tipoAmostra">Perfil do paciente</label>
                <select class="form-control selectpicker" 
                    id="select-country idSel_perfilPaciente" data-live-search="true" name="sel_perfilPaciente" onChange="val_selPerfil()">
                 <option data-tokens="" value="0" >Selecione um perfil de paciente</option>
                 <option data-tokens="" value="1" > Equipe de Voluntários </option>
                 <option data-tokens=""  value="2">Profissionais da Saúde</option>
                 <option data-tokens="" value="3">Paciente SUS</option>
                <!--<?= $select_perfis ?>-->
                </select>
            </div>   
            
            <?php if(isset($_GET['idPerfilPaciente'])){ ?>
                        
            <div class="col-md-2 ">
                <label for="tipoAmostra"> Amostra em processamento: </label>
                <input type="text" class="form-control" id="idDataHoraLogin"  readonly
                   name="dtHoraLoginInicio" required value="xxxxxxxxxx" >
            </div>
            <div class="col-md-3 ">
                <label for="tipoAmostra">Local onde a amostra está armazenada</label>
                <select class="form-control selectpicker" 
                    id="select-country idSel_tiposAmostra" data-live-search="true" name="sel_tipoAmostra" disabled>
                 <option data-tokens="" ></option>
                 <option selected data-tokens="" >gaveta x </option>
                 <option data-tokens="" >gaveta y</option>
                 <option data-tokens="" >freezer x</option>
                 <option data-tokens="" >freezer y</option>
                <!--<?= $select_perfis ?>-->
                </select>
            </div>
            <div class="col-md-1">
                 <?php if(isset($_POST['liberar_capela'])){ ?>
                        <input type="text" class="form-control" id="idDataHoraLiberacao" readonly  style="text-align: center;margin-top:37px;"
                           name="dtHoraLoginLiberacao" value="<?=$_SESSION['DATA_LIBERACAO_CAPELA']?>" >
                 <?php }else{ ?>
                    <button  class="btn btn-primary"  style="margin-top:35px; width: 100%;" type="submit" name="liberar_capela">Liberar capela</button>
                 <?php } ?>
            </div>     
            
        </div>
                
        <!-- por baixo dos panos: 
            o usuário descarta a amostra A0 //sistema marca como descartada
            usuário libera a capela // sistema marca capela como liberada
        -->
        
    </form>
    
    <?php if(isset($_POST['liberar_capela'])){ ?>
    
    <!--
        tudo que está abaixo 
        só aparece após apertar o liberar capela 
    -->
    
    <form method="POST" style="margin-top:50px;">    
        
        <h2 style=" color:black;"> Local de Armazenamento </h2> 
        <hr width = “2” size = “100”>
        <div class="form-row" style="margin-top:10px;">  
            
            <div class="col-md-1"><h3 style="color:gray;margin-top:30px;text-align: center;"> Tubo 1 </h3></div>
            
            <div class="col-md-2 ">
                <label for="tipoAmostra"> Código do Tubo </label>
                <input type="text" class="form-control" id="idDataHoraLogin"  readonly
                   name="dtHoraLoginInicio" required value=" xxxxxx" >
            </div>
            
            <!-- 
                pegar apenas locais temporários 
                etapa pulável
            -->
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
            
            <!-- garantir que a amostra ou vai para o local temporário ou vai ir direto para a extração -->
             <div class="col-md-3">
                <div class="custom-control custom-checkbox mr-sm-2" style="margin-top: 40px;font-size: 25px;font-weight: bold;">
                    <input type="checkbox" class="custom-control-input" id="customControlAutosizing" >
                    <label class="custom-control-label" for="customControlAutosizing" >Vai direto para extração</label>
                  </div>
            </div>
            <!-- quando selecionar o checkbox deve-se procurar no banco se há algum recurso disponível para a extração ou ao enviar o form-->
                  
            
            
        </div>
        
        
        <div class="form-row" style="margin-top:40px;">  
            
            <div class="col-md-1"><h3 style="color:gray;margin-top:30px;text-align: center;"> Tubo 2 </h3></div>
            
            <div class="col-md-2 ">
                <label for="tipoAmostra"> Código do Tubo </label>
                <input type="text" class="form-control" id="idDataHoraLogin"  readonly
                   name="dtHoraLoginInicio" required value=" xxxxxx" >
            </div>
            
            <!-- 
                pegar apenas locais permanentes 
            -->
            <div class="col-md-4 ">
                <label for="tipoAmostra">Local onde a amostra será armazenada </label>
                <select class="form-control selectpicker" 
                    id="select-country idSel_tiposAmostra" data-live-search="true" name="sel_tipoAmostra" >
                 <option data-tokens="" >Selecione um local permanente</option>
                 <option data-tokens="" >gaveta x </option>
                 <option data-tokens="" >gaveta y </option>
                 <option data-tokens="" >freezer x</option>
                 <option data-tokens="" >freezer y</option>
                <!--<?= $select_perfis ?>-->
                </select>
            </div> 
            
            
             
            <div class="col-md-5">
                <label for="observações amostra"> Observações (gaveta quebrada, freezer estragado...)</label>
                <textarea onblur="validaObs()" id="idTxtAreaObs" name="txtAreaObs" rows="1" cols="100" class="form-control" id="obsAmostra" rows="3"></textarea>
                <div id ="feedback_obsAmostra"></div>
            </div>
        </div>
                  
            
                      
    
        
        <div class="form-row" style="margin-top:40px;">  
            
            <div class="col-md-1"><h3 style="color:gray;margin-top:30px;text-align: center;"> Tubo 3 </h3></div>
            
            <div class="col-md-2 ">
                <label for="tipoAmostra"> Código do Tubo </label>
                <input type="text" class="form-control" id="idDataHoraLogin"  readonly
                   name="dtHoraLoginInicio" required value=" xxxxxx" >
            </div>
            
            <!-- 
                pegar apenas locais permanentes 
            -->
            <div class="col-md-4 ">
                <label for="tipoAmostra">Local onde a amostra será armazenada</label>
                <select class="form-control selectpicker" 
                    id="select-country idSel_tiposAmostra" data-live-search="true" name="sel_tipoAmostra" >
                 <option data-tokens="" >Selecione um local permanente</option>
                 <option data-tokens="" >gaveta x </option>
                 <option data-tokens="" >gaveta y </option>
                 <option data-tokens="" >freezer x</option>
                 <option data-tokens="" >freezer y</option>
                <!--<?= $select_perfis ?>-->
                </select>
            </div> 
            
            <div class="col-md-5">
                <label for="observações amostra"> Observações (gaveta quebrada, freezer estragado...)</label>
                <textarea onblur="validaObs()" id="idTxtAreaObs" name="txtAreaObs" rows="1" cols="100" class="form-control" id="obsAmostra" rows="3"></textarea>
                <div id ="feedback_obsAmostra"></div>
            </div>
                  
           
            
        </div>
        
        
               


         

            <button style="margin-top:20px;" class="btn btn-primary" type="submit" name="salvar_paciente">Salvar</button>
            <?php }
            } 
            ?>
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
        
       

    function val_selPerfil() {
        $('.selectpicker').change(function (e) {
            //alert(e.target.value);
            //document.getElementById("class1").innerHTML = e.target.value ;
            window.location.href = "controlador.php?action=cadastrar_amostra_localArmazenamento&idPerfilPaciente=" + e.target.value;
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
