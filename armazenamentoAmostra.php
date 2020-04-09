<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';


date_default_timezone_set('America/Sao_Paulo');
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$dateLogin = date('d/m/Y  H:i:s');
$dateLogin  = str_replace('/', '_', $dateLogin);
$dateLogin  = str_replace(':', '_', $dateLogin);
$dateLogin  = str_replace(' ', '__', $dateLogin);
if(!isset($_POST['dataEntrouForm'])){
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]".'&dataEntrouForm='.$dateLogin;
    header('Location: '.$actual_link);
}
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
                   name="dtHoraLoginInicio" required value="<?php echo date('d/m/Y  H:i:s'); ?>">
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

        <div class="form-row">  

            <div class="col-md-12">
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
            
        </div>
               


            <div class="form-row" style="margin-top:10px;">

                <div class="col-md-4 mb-3">
                    <label for="label_nome">Digite o nome:</label>
                    <input type="text" class="form-control" id="idNome" placeholder="Nome" 
                           onblur="validaNome()" name="txtNome" required value="<?= $objPaciente->getNome() ?>">
                    <div id ="feedback_nome"></div>

                </div>

                <!-- Nome da mãe -->
                <div class="col-md-4 mb-9">
                    <label for="label_nomeMae">Digite o nome da mãe:</label>
                    <input type="text" class="form-control" id="idNomeMae" placeholder="Nome da mãe" 
                           onblur="validaNomeMae()" name="txtNomeMae" required value="<?= $objPaciente->getNomeMae() ?>">
                    <div id ="feedback_nomeMae"></div>
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerObsNomeMae" style="display:none" >

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsNomeMae()"  name="obs"  type="radio"  class="custom-control-input" id="customControlValidation2" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidation2">Não informado</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onchange="val_radio_obsNomeMae()"  name="obs" type="radio" class="custom-control-input" id="customControlValidation3" name="radio-stacked" >
                                    <label class="custom-control-label" for="customControlValidation3">Outro</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control  mb-3">

                                    <input style="height: 35px; margin-left: -25px;margin-top: -5px;" readonly  type="text" class="form-control" id="idObsNomeMae" placeholder="motivo"  
                                           onblur="validaObsNomeMae()" name="txtObsNomeMae" required value="<?= $objPaciente->getObsNomeMae() ?>">
                                    <div id ="feedback_obsNomeMae"></div>

                                </div>
                            </div>
                        </div>
                    </div>



                </div>

                <!-- Data de nascimento -->
                <div class="col-md-4 mb-3">
                    <label for="label_dtNascimento">Digite a data de nascimento:</label>
                    <input type="date" class="form-control" id="idDataNascimento" placeholder="Data de nascimento"  
                           onblur="validaDataNascimento()" name="dtDataNascimento"  max="<?php echo date('Y-m-d'); ?>" required value="<?= $objPaciente->getDataNascimento() ?>">
                    <div id ="feedback_dtNascimento"></div>
                </div>



            </div>  


            <div class="form-row">
                <!-- Sexo -->
                <div class="col-md-3 mb-4">
                    <label for="sexoPaciente" >Sexo:</label>
    <?= $select_sexos ?>
                    <div id ="feedback_sexo"></div>

                    <!--  <div class="desaparecer_aparecer" id="id_desaparecer_aparecerObsSexo" style="margin-top:25px;" >

                          <div class="form-row align-items-center" >
                              <div class="col-auto mb-1">
                                  <div class="custom-control custom-radio mb-3">
                                      <input onclick="val_radio_obsSexo()"  name="obsSexo" value="naoInformado" type="radio"  class="custom-control-input" id="customControlValidationSexo" name="radio-stacked2" >
                                      <label class="custom-control-label" for="customControlValidationSexo">Não informado </label>
                                  </div>
                              </div>

                              <div class="col-auto mb-1">
                                  <div class="custom-control custom-radio mb-3">
                                      <input onchange="val_radio_obsSexo()"  name="obsSexo" value="outro" type="radio" class="custom-control-input" id="customControlValidationSexo2" name="radio-stacked2" >
                                      <label class="custom-control-label" for="customControlValidationSexo2">Outro</label>
                                  </div>
                              </div>

                              <div class="col-auto my-1">
                                  <div class="custom-control  mb-2">

                                      <input style="height: 35px;margin-left: -25px;margin-top: -15px;" readonly  type="text" class="form-control" id="idObsSexo" placeholder="motivo"  
                                             onblur="validaObsSexo()" name="txtObsSexo" required value="<?= $objPaciente->getObsSexo() ?>">
                                      <div id ="feedback_obsNomeMae"></div>

                                  </div>
                              </div>
                          </div>
                      </div> -->
                </div>
                <!-- CPF -->
                <div class="col-md-3 mb-4">
    <?php
    $validaCPF = '';
    if ($cpf_obrigatorio == '') {
        $validaCPF = 'validaCPFSUS()';
    } else {
        $validaCPF = 'validaCPF()';
    }
    ?>
                    <label for="label_cpf">Digite o CPF:</label>
                    <input type="text" class="form-control cep-mask" id="idCPF" placeholder="Ex.: 000.000.000-00" 
                           onblur="<?= $validaCPF ?>" name="txtCPF" <?= $cpf_obrigatorio ?> value="<?= $objPaciente->getCPF() ?>">
                    <div id ="feedback_cpf"></div>

    <?php if ($validaCPF == 'validaCPFSUS()') { ?>
                        <div class="desaparecer_aparecer" id="id_desaparecer_aparecerObsCPF" style="margin-top:25px; display:none;" >

                            <div class="form-row align-items-center" >
                                <div class="col-auto my-1">
                                    <div class="custom-control custom-radio mb-3">
                                        <input onclick="val_radio_obsCPF()"  name="obsCPF" value="naoInformado" type="radio"  
                                               class="custom-control-input" id="customControlValidationCPF" name="radio-stacked4" >
                                        <label class="custom-control-label" for="customControlValidationCPF">Não informado </label>
                                    </div>
                                </div>

                                <div class="col-auto my-1">
                                    <div class="custom-control custom-radio mb-3">
                                        <input onchange="val_radio_obsCPF()"  name="obsCPF" value="outro" type="radio" 
                                               class="custom-control-input" id="customControlValidationCPF2" name="radio-stacked4" >
                                        <label class="custom-control-label" for="customControlValidationCPF2">Outro</label>
                                    </div>
                                </div>

                                <div class="col-auto my-1">
                                    <div class="custom-control  mb-3">

                                        <input style="height: 35px;margin-left: -25px;margin-top: -20px;" readonly  
                                               type="text" class="form-control" id="idObsCPF" placeholder="motivo"  
                                               onblur="validaObsCPF()" name="txtObsCPF" required value="<?= $objPaciente->getObsCPF() ?>">
                                        <div id ="feedback_obsCPF"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
    <?php } ?>



                </div>

                <!-- RG -->
                <div class="col-md-3 mb-3">
                    <label for="label_rg">Digite o RG:</label>
                    <input type="txt" class="form-control" id="idRG" placeholder="RG" 
                           onblur="validaRG()" name="txtRG" value="<?= $objPaciente->getRG() ?>">
                    <div id ="feedback_rg"></div>
                    <div class="desaparecer_aparecer" id="id_desaparecer_aparecerObsRG" style="margin-top:25px; display: none;" >

                        <div class="form-row align-items-center" >
                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onclick="val_radio_obsRG()"  name="obsRG" value="naoInformado" type="radio"  
                                           class="custom-control-input" id="customControlValidationRG" name="radio-stacked3" >
                                    <label class="custom-control-label" for="customControlValidationRG">Não informado </label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control custom-radio mb-3">
                                    <input onchange="val_radio_obsRG()"  name="obsRG" value="outro" type="radio" 
                                           class="custom-control-input" id="customControlValidationRG2" name="radio-stacked3" >
                                    <label class="custom-control-label" for="customControlValidationRG2">Outro</label>
                                </div>
                            </div>

                            <div class="col-auto my-1">
                                <div class="custom-control  mb-3">

                                    <input style="height: 35px;margin-left: -25px;margin-top: -5px;" readonly  
                                           type="text" class="form-control" id="idObsRG" placeholder="motivo"  
                                           onblur="validaObsRG()" name="txtObsRG" required value="<?= $objPaciente->getObsRG() ?>">
                                    <div id ="feedback_obsRG"></div>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <!-- CÓDIGO GAL -->
                <div class="col-md-3 mb-3">
                    <label for="label_codGal">Digite o código Gal:</label>
                    <input type="text" class="form-control" id="idCodGAL" placeholder="000 0000 0000 0000" data-mask="000 0000 0000 0000"  <?= $read_only ?>
                           onblur="validaCodGAL()" name="txtCodGAL" required value="<?= $objPaciente->getCodGAL() ?>">
                    <div id ="feedback_codGal"></div>

                </div>

            </div>  
            <h3> Sobre a Coleta </h3>
            <hr width = “2” size = “100”>
            <div class="form-row">  
                <div class="col-md-2">

                    <label for="inputAceitaRecusada">Aceita ou recusada</label>
                    <select id="idSelAceitaRecusada" class="form-control" name="sel_aceita_recusada" onblur="validaAceitaRecusa()">
                        <option value="">Selecione</option>
                        <option value="a">Aceita</option>
                        <option value="r">Recusada</option>

                    </select>
                    <div id ="feedback_aceita_recusada"></div>
                </div>
                <div class="col-md-2">
                    <label for="labelQuantidadeTubos">Quantidade de tubos: </label>
                    <input type="number" class="form-control" id="idQntTubos" placeholder="nº tubos" default
                           onblur="validaQntTubos()" name="numQntTubos" required value="<?= $tubos ?>">
                    <div id ="feedback_qntTubos"></div>
                </div>
                
                <div class="col-md-4">
                    <label for="labelDataHora">Data e Hora:</label>
                    <input type="datetime-local" class="form-control" id="idDtHrColeta" placeholder="00/00/0000 00:00:00" 
                           onblur="validaDataHoraColeta()" name="dtColeta" required value="<?= $objAmostra->getDataHoraColeta() ?>">
                    <div id ="feedback_dataColeta"></div>

                </div>
                
                <div class="col-md-1">
                    <label for="labelEstadoColeta">Estado:</label>
                    <?= $select_estados ?>
                </div>
                <div id ="feedback_estado"></div>

                <div class="col-md-3">
                    <label for="labelMunicípioColeta">Município:</label>
                    <?= $select_municipios ?>
                </div>

                

                


            </div>
            <div class="form-row">
            <div class="col-md-12">
                    <label for="observações amostra">Observações</label>
                    <textarea onblur="validaObs()" id="idTxtAreaObs" name="txtAreaObs" rows="2" cols="100" class="form-control" id="obsAmostra" rows="3"></textarea>
                    <div id ="feedback_obsAmostra"></div>
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
                window.location.href = "controlador.php?action=cadastrar_localArmazenamento&idAmostra=" + e.target.value;
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
