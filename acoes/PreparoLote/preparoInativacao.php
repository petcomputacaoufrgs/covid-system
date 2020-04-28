<?php

session_start();
require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
require_once __DIR__ . '/../../classes/Capela/Capela.php';
require_once __DIR__ . '/../../classes/Capela/CapelaRN.php';
require_once _DIR__ . '/../../classes/Pagina/InterfacePagina.php';

require_once __DIR__ . '/../../classes/Amostra/Amostra.php';
require_once __DIR__ . '/../../classes/Amostra/AmostraRN.php';

require_once __DIR__ . '/../../classes/Tubo/Tubo.php';
require_once __DIR__ . '/../../classes/Tubo/TuboRN.php';

require_once __DIR__ . '/../../classes/InfosTubo/InfosTubo.php';
require_once __DIR__ . '/../../classes/InfosTubo/InfosTuboRN.php';

require_once __DIR__ . '/../../utils/Utils.php';
require_once __DIR__ . '/../../utils/Alert.php';

require_once __DIR__ . '/../../classes/Lote/Lote.php';
require_once __DIR__ . '/../../classes/Lote/LoteRN.php';

require_once __DIR__ . '/../../classes/PreparoLote/PreparoLote.php';
require_once __DIR__ . '/../../classes/PreparoLote/PreparoLoteRN.php';

require_once __DIR__ . '/../../classes/Rel_perfil_preparoLote/Rel_perfil_preparoLote.php';
require_once __DIR__ . '/../../classes/Rel_perfil_preparoLote/Rel_perfil_preparoLote_RN.php';

require_once __DIR__ . '/../../classes/Rel_tubo_lote/Rel_tubo_lote.php';
require_once __DIR__ . '/../../classes/Rel_tubo_lote/Rel_tubo_lote_RN.php';

require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPaciente.php';
require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPacienteRN.php';

try {
    Sessao::getInstance()->validar();
    $utils = new Utils();

    date_default_timezone_set('America/Sao_Paulo');
    $_SESSION['DATA_LOGIN'] = date("Y-m-d H:i:s");

    /*
     * Objeto Capela
     */
    $objCapela = new Capela();
    $objCapelaRN = new CapelaRN();

    /*
     * Objeto Capela
     */
    $objPerfilPaciente = new PerfilPaciente();
    $objPerfilPacienteRN = new PerfilPacienteRN();

    /*
     * Objeto Amostra
     */
    $objAmostra = new Amostra();
    $objAmostraRN = new AmostraRN();

    /*
     * Objeto Tubo
     */
    $objTubo = new Tubo();
    $objTuboRN = new TuboRN();


    /*
     * Objeto Infos Tubo
     */
    $objInfosTubo = new InfosTubo();
    $objInfosTuboRN = new InfosTuboRN();


    /*
     * Objeto PreparoLote
     */
    $objPreparoLote = new PreparoLote();
    $objPreparoLoteRN = new PreparoLoteRN();

    /*
     * Objeto rel tubo com o lote
     */
    $objRelTuboLote = new Rel_tubo_lote();
    $objRelTuboLoteRN = new Rel_tubo_lote_RN();

    /*
     * Objeto  lote
     */
    $objLote = new Lote();
    $objLoteRN = new LoteRN();


    /*
     * Objeto  do relacionamento do perfil com o lote
     */
    $objRel_Perfil_preparoLote = new Rel_perfil_preparoLote();
    $objRel_Perfil_preparoLoteRN = new Rel_perfil_preparoLote_RN();

    $ja_confirmou = 'n';
    $show_amostras = '';
    $select_capelas_ocupadas = '';
    $objCapela->setStatusCapela('OCUPADA');
    $arr_capelas_ocupadas = $objCapelaRN->listar($objCapela);
    //print_r($arr_capelas_ocupadas);

    if($_POST['btn_cancelar']){
        header('Location: '. Sessao::getInstance()->assinar_link('controlador.php?action=realizar_preparo_inativacao'));
        die();
    }


    if(count($arr_capelas_ocupadas) > 0) { //tem capelas pré alocadas
        $selecionado = '';
        Interf::montar_capelas_ocupadas($arr_capelas_ocupadas,$objPreparoLote,$objPreparoLoteRN,$objLote,$objLoteRN,$select_capelas_ocupadas,$selecionado);

        if(isset($_POST['sel_capelasOcupadas'])){
            header('Location: '. Sessao::getInstance()->assinar_link('controlador.php?action=realizar_preparo_inativacao&idCapela='.$_POST['sel_capelasOcupadas']));
            die();
        }

        if(isset($_GET['idCapela']) ||  $_POST['btn_confirmarPreparacao']){

            $selecionado = $_GET['idCapela'];
            Interf::montar_capelas_ocupadas($arr_capelas_ocupadas,$objPreparoLote,$objPreparoLoteRN,$objLote,$objLoteRN,$select_capelas_ocupadas,$selecionado);
            $objPreparoLote->setIdCapelaFk($_GET['idCapela']);
            $preparos_lote = $objPreparoLoteRN->listar($objPreparoLote);

            $contador = 0;
            foreach ($preparos_lote as $pl){
                if($pl->getIdCapelaFk() ==$_GET['idCapela']){
                    $objLote->setIdLote($pl->getIdLoteFk());
                    $objLote = $objLoteRN->consultar($objLote);

                    $objRelTuboLote->setIdLote_fk($objLote->getIdLote());
                    $arr_tubos_do_lote = $objRelTuboLoteRN->listar($objRelTuboLote);

                    //print_r($arr_tubos_do_lote);
                    $head.=
                             '<th style="width: 15%;" scope="col">Código amostra</th>
                              <th style="width: 10%;" scope="col">Reteste</th>
                              <th style="width: 10%;" scope="col">Volume</th>
                              <th style="width: 20%;" scope="col" >Problemas</th>
                              <th style="width: 20%;" scope="col" >Informe o problema</th>
                              <th style="width: 20%;" scope="col" >Observações Adicionaisc</th>';

                    foreach ($arr_tubos_do_lote as $tubosLote) {
                        $objTubo->setIdTubo($tubosLote->getIdTubo_fk());
                        $objTubo = $objTuboRN->consultar($objTubo);

                        $objInfosTubo->setIdTubo_fk($objTubo->getIdTubo());
                        $objInfosTubo = $objInfosTuboRN->pegar_ultimo($objInfosTubo);

                        //if($objInfosTubo->getStatusTubo

                        $objAmostra->setIdAmostra($objTubo->getIdAmostra_fk());
                        $objAmostra = $objAmostraRN->consultar($objAmostra);


                        if ($objInfosTubo->getReteste() == 'n') {
                            $reteste = "NÃO";
                        } else {
                            $reteste = "SIM";
                        }

                        $show = ' ';
                        $style = 'style="margin-top: 10px;';

                        if($contador == 0){
                            $style = 'style="margin-top: -20px;';
                            $show = ' show ';
                        }

                        if(isset($_POST['btn_confirmarPreparacao'])){
                            $amostra_original = 'DESCARTADO';
                        }

                        $show_amostras .= '
                           
                            <div class="accordion" id="accordionExample" '.$style.'">
                                  <div class="card">
                                  
                                    <div class="card-header" id="heading_'.$objTubo->getIdTubo().'">
                                      <h5 class="mb-0">
                                        <button  style="text-decoration: none;color: #3a5261;"  class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse_'.$objTubo->getIdTubo().'" aria-expanded="true" aria-controls="collapseOne">
                                          <h5>AMOSTRA '.$objAmostra->getCodigoAmostra().'</h5>
                                        </button>
                                      </h5>
                                    </div>
                                
                                    <div id="collapse_'.$objTubo->getIdTubo().'" class="collapse '.$show.' " aria-labelledby="heading_'.$objTubo->getIdTubo().'" data-parent="#accordionExample">
                                      <div class="card-body">
                                            <div class="form-row" >
                                                 <div class="col-md-12" style="background-color: #3a5261;padding: 5px;font-size: 13px;font-weight: bold; color: whitesmoke;">
                                                    AMOSTRA ORIGINAL
                                                 </div>
                                            </div>
                                            <div class="form-row" >
                                                 <div class="col-md-4">
                                                    <label> Local onde está armazenado </label>
                                                        <input type="text" class="form-control form-control-sm" id="idLocalArmazenamento"  disabled style="text-align: center;" placeholder=""
                                                            name="txtLocalArmazenamento'.$objTubo->getIdTubo().'"  value="'.$amostra_original.'">
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <label> Volume</label>
                                                        <input type="number" class="form-control form-control-sm" id="idVolume"  disabled style="text-align: center;" placeholder=""
                                                            name="txtVolume_'.$objTubo->getIdTubo().'"  value="' .  $objInfosTubo->getVolume() . '">
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <label> Reteste</label>
                                                        <input type="text" class="form-control form-control-sm" id="idReteste"  disabled style="text-align: center;" placeholder=""
                                                            name="txtReteste_'.$objTubo->getIdTubo().'"  value="' .  $reteste . '">
                                                </div>
                                            </div>
                                            
                                            <div class="form-row" style="margin-bottom: 30px;">
                                                <div class="col-md-2">
                                                    <div class="custom-control custom-checkbox mr-sm-2" style="margin-top: 10px;margin-left: 5px;">
                                                   
                                                    <input type="checkbox" class="custom-control-input" id="customDercartada_'.$objTubo->getIdTubo().'" 
                                                    name="checkDercartada_'.$objTubo->getIdTubo().'">
                                                    <label class="custom-control-label" for="customDercartada_'.$objTubo->getIdTubo().'">Precisou ser descartado no meio da preparação</label>
                                                  </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label> Informe se teve algum problema</label>
                                                        <textarea class="form-control form-control-sm" id="exampleFormControlTextarea1" 
                                                        name="textAreaProblema_'.$objTubo->getIdTubo().'" rows="1"></textarea>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <label> Observações adicionais</label>
                                                       <textarea class="form-control form-control-sm" id="exampleFormControlTextarea1" 
                                                       name="textAreaObs_'.$objTubo->getIdTubo().'" rows="1"></textarea>
                                                </div>
                                            </div>
                                            ';

                        if(isset($_POST['btn_terminarPreparacao'])){

                            $objInfosTuboNovo = new InfosTubo();
                            if(isset($_POST['checkDercartada_'.$objTubo->getIdTubo()]) && $_POST['checkDercartada_'.$objTubo->getIdTubo()] == 'on'){
                                $objInfosTuboNovo->setDescarteNaEtapa('s');
                            }

                            if(isset($_POST['textAreaProblema_'.$objTubo->getIdTubo()])){
                                $objInfosTuboNovo->setProblema($_POST['textAreaProblema_'.$objTubo->getIdTubo()]);
                            }

                            if(isset($_POST['textAreaObs_'.$objTubo->getIdTubo()])){
                                $objInfosTuboNovo->setObservacoes($_POST['textAreaObs_'.$objTubo->getIdTubo()]);
                            }

                            $objInfosTuboNovo->setEtapa("preparação/inativação - finalizada ");
                            $objInfosTuboNovo->setStatusTubo("Descartado");
                            $objInfosTuboNovo->setIdTubo_fk($objTubo->getIdTubo());

                        }

                        $contador++;
                        if (!isset($_POST['btn_confirmarPreparacao'])) {
                            $show_amostras .= '</div></div></div></div>';
                        }

                        if (isset($_POST['btn_confirmarPreparacao'])) {
                            $ja_confirmou ='s';

                            $objLote->setStatusLote("em preparação");

                            //print_r($objLote);

                            $objTuboNovo = new Tubo();
                            //$objTuboNovo->setIdAmostra_fk($objAmostra->getIdAmostra());
                            //$objTuboNovo->setIdTubo_fk($objTubo->getIdTubo());
                            //$objTuboNovo->setTuboOriginal('n');

                            /*$objInfosTuboNovo = NEW InfosTubo();
                            $objInfosTuboNovo->setEtapa("na preparação");
                            $objInfosTuboNovo->setStatusTubo("em preparação");*/

                            for ($i = 1; $i <= 3; $i++) {

                                if($i == 1 || $i == 2){
                                    $status = 'banco de amostras - final extração';
                                    $nometubo = 'ALIQUOTA '.$i;
                                    //$objInfosTuboNovo->setVolume('1.0');
                                    $armazenamento = " banco de amostras ";
                                }
                                if($i == 3){
                                    $nometubo = 'EXTRAÇÃO';
                                    //S$objInfosTuboNovo->setVolume('0.2');
                                    $armazenamento = ' extração ';
                                }


                                $show_amostras .= '

                                             <div class="form-row " style="background-color: whitesmoke; margin-bottom: 0px; "> 
                                                <div class="col-md-1" style="background-color: #3a5261;margin-top: 0px;font-size: 13px;font-weight: bold; color: whitesmoke;text-align: center;">'.$nometubo.'</div>       
                                                     <div class="col-md-3" style="padding: 10px;">
                                                         <label> Local de armazenamento </label>';
                                                        if($i == 1 || $i == 2) {
                                                            $show_amostras .= '<select class="form-control form-control-sm">
                                                          <option>Banco de Amostras</option>
                                                          <option>Small select</option>
                                                          <option>Small select</option>
                                                        </select>';
                                                        }else{
                                                            $show_amostras .=  '<input type="text" class="form-control form-control-sm" id="idVolume"  disabled style="text-align: center;" placeholder=""
                                                                name="txtExtracao_'.$objTubo->getIdTubo().'"  value="Extração">';
                                                        }

                                          $show_amostras .= '</div>
                                                     <div class="col-md-2" style="padding: 10px;">
                                                         <label> Caixa </label>
                                                          <input type="text" class="form-control form-control-sm" id="idVolume"   style="text-align: center;" placeholder=""
                                                                name="txtVolume_'.$nometubo.$i.'"  value="">
                                                         </div>
                                                         
                                                        
                                                     <div class="col-md-2" style="padding: 10px;">
                                                         <label> Posição </label>
                                                         <input type="text" class="form-control form-control-sm" id="idVolume"   style="text-align: center;" placeholder=""
                                                                name="txtVolume_'.$nometubo.$i.'"  value="">
                                                         </div>
                                                    
                                                    
                                                    <div class="col-md-1" style="padding: 10px;">
                                                     <label> Volume</label>
                                                        <input type="number" class="form-control form-control-sm" id="idVolume"  disabled style="text-align: center;" placeholder=""
                                                            name="txtVolume_'.$nometubo.$i.'"  value="VOLUME"> <!--$objInfosTuboNovo->getVolume().-->
                                                     </div>
                                            </div> 
                                            
                                            
                                            <div class="form-row " style="background-color: whitesmoke;margin-top: -10px;"> 
                                                <div class="col-md-1" style="background-color: #3a5261"></div>       
                                                <div class="col-md-2">
                                                
                                                <div class="custom-control  '.$checked.' custom-checkbox mr-sm-2" style="margin-top: 20px; margin-left: 20px;">
                                                    <input type="checkbox" class="custom-control-input" id="check_'.$nometubo.$i.'" name="checkDescartada_'.$nometubo.$i.'">
                                                    <label class="custom-control-label" for="check_'.$nometubo.$i.'">Precisou ser descartada</label>
                                                  </div>
                                                </div>
                                                <div class="col-md-4" style="padding: 10px;">
                                                    <label> Informe se teve algum problema</label>
                                                        <textarea class="form-control" id="exampleFormControlTextarea1" name="textAreaProblema_'.$nometubo.$i.'" rows="1"></textarea>
                                                </div>
                                                
                                                <div class="col-md-5" style="padding: 10px;">
                                                    <label> Observações adicionais</label>
                                                       <textarea class="form-control" id="exampleFormControlTextarea1" name="textAreaObs_'.$nometubo.$i.'" rows="1"></textarea>
                                                </div>
                                            </div>
                                            
                                            ';

                                if(isset($_POST['btn_terminarPreparacao'])){

                                    $objTuboNovo = new Tubo();
                                    $objTuboNovo->setTuboOriginal('n');
                                    $objTuboNovo->setIdAmostra_fk($objAmostra->getIdAmostra());
                                    $objTuboNovo->setIdTubo_fk($objTubo->getIdTubo());
                                    if($i == 3)$objTuboNovo->setTipo('RNA');
                                    else  $objTuboNovo->setTipo('ALIQUOTA');


                                    $objInfosTuboNovo = new InfosTubo();
                                    if(isset($_POST['textAreaObs_'.$nometubo.$i])){
                                        $objInfosTuboNovo->setObservacoes($_POST['textAreaObs_'.$nometubo.$i]);
                                    }

                                    if(isset($_POST['textAreaProblema_'.$nometubo.$i])){
                                        $objInfosTuboNovo->setProblema($_POST['textAreaProblema_'.$nometubo.$i]);
                                    }

                                    if(isset($_POST['check_'.$nometubo.$i]) && $_POST['check_'.$nometubo.$i] == 'on'){
                                        $objInfosTuboNovo->setDescarteNaEtapa('s');
                                        $objInfosTuboNovo->setStatusTubo("Descartado");
                                    }else{
                                        if($i == 1 || $i == 2){
                                            $objInfosTuboNovo->setStatusTubo("banco de amostras");
                                        }else{
                                            $objInfosTuboNovo->setStatusTubo("aguardando extração");
                                        }
                                    }
                                    //$objInfosTuboNovo->setIdLocalArmazenamento_fk();
                                    $objInfosTuboNovo->setDataHora(date("Y-m-d H:i:s"));
                                    $objInfosTuboNovo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                                    $objInfosTuboNovo->setEtapa("finalizada - preparação ");
                                    $objTuboNovo->setObjInfosTubo($objInfosTuboNovo);


                                    //$objTuboNovo = $objTuboRN->cadastrar($objTuboNovo);
                                }

                            }

                            $show_amostras .= '</div></div></div></div>';

                        }
                    }





                }
            }

        }

    }else{
        $alert.= Alert::alert_primary('Não existe grupo de amostra em espera');
    }



} catch (Throwable $ex) {
    Pagina::getInstance()->mostrar_excecoes($ex);
}


Pagina::abrir_head("Montar grupo");
Pagina::getInstance()->adicionar_css("precadastros");
if($cadastrar_novo  == 's') {
    Pagina::getInstance()->adicionar_javascript("popUp");
}
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
echo $alert;
echo '<!-- Modal -->
    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="text-align: center">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                    Deseja montar outro grupo de amostras? </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"  >Close</button>
                    <button type="button"  class="btn btn-primary">
                    <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=montar_preparo_extracao&idLiberar=' . $_GET['idCapela']) . '">Tenho certeza</a></button>
                </div>
            </div>
        </div>
    </div>';

echo '<div class="conteudo_grande " >
         <form method="POST">
                <div class="form-row" >
                    <div class="col-md-12">'
                        .$select_capelas_ocupadas.
                    '</div>
                </div>
         </form>
      </div>';

echo '<div class="conteudo_grande preparo_inativacao">
         <form method="POST">
                <div class="form-row" >
                    <div class="col-md-12">'
                            .$show_amostras.
                    '</div>
                </div>
                <div class="form-row" >';
                    if($ja_confirmou = 'n') {
                        echo '<div class="col-md-6">
                       <button class="btn btn-primary" STYLE="width: 50%;margin-left: 50%;" type="submit" name="btn_confirmarPreparacao">CONFIRMAR PREPARAÇÃO</button>
                     </div>';
                    }else{
                        echo '<div class="col-md-6">
                           <button class="btn btn-primary" STYLE="width: 50%;margin-left: 50%;" type="submit" name="btn_terminarPreparacao">SALVAR DADOS</button>
                         </div>';
                    }
                     echo '<div class="col-md-6">
                       <button class="btn btn-primary" STYLE="width: 50%;margin-left: 0%;"  type="submit" name="btn_cancelar">CANCELAR</button>
                     </div>
                
                </div>
         </form>
      </div>';
?>




<?php
Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();