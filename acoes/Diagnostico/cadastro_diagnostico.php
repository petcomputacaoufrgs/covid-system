<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
try {
    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';

    require_once __DIR__.'/../../classes/Diagnostico/Diagnostico.php';
    require_once __DIR__.'/../../classes/Diagnostico/DiagnosticoRN.php';
    require_once __DIR__.'/../../classes/Diagnostico/DiagnosticoINT.php';

    require_once __DIR__.'/../../classes/Amostra/Amostra.php';
    require_once __DIR__.'/../../classes/Amostra/AmostraRN.php';

    require_once __DIR__.'/../../classes/InfosTubo/InfosTubo.php';
    require_once __DIR__.'/../../classes/InfosTubo/InfosTuboRN.php';

    require_once __DIR__.'/../../classes/Tubo/Tubo.php';
    require_once __DIR__.'/../../classes/Tubo/TuboRN.php';

    require_once __DIR__.'/../../classes/Laudo/Laudo.php';
    require_once __DIR__.'/../../classes/Laudo/LaudoRN.php';

    require_once __DIR__.'/../../classes/RTqPCR/RTqPCR.php';
    require_once __DIR__.'/../../classes/RTqPCR/RTqPCR_RN.php';
    require_once __DIR__.'/../../classes/RTqPCR/RTqPCR_INT.php';

    require_once __DIR__.'/../../classes/PerfilPaciente/PerfilPaciente.php';
    require_once __DIR__.'/../../classes/PerfilPaciente/PerfilPacienteRN.php';
    require_once __DIR__.'/../../classes/PerfilPaciente/PerfilPacienteINT.php';

    require_once __DIR__.'/../../utils/Utils.php';
    require_once __DIR__.'/../../utils/Alert.php';

    require_once __DIR__.'/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTexto.php';
    require_once __DIR__.'/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTextoRN.php';


    Sessao::getInstance()->validar();
    $utils = new Utils();
    date_default_timezone_set('America/Sao_Paulo');
    $_SESSION['DATA_LOGIN']  = date('Y-m-d  H:i:s');

    $objDiagnostico = new Diagnostico();
    $objDiagnosticoRN = new DiagnosticoRN();

    $objAmostra = new Amostra();
    $objAmostraRN = new AmostraRN();

    $objInfosTubo = new InfosTubo();
    $objInfosTuboRN = new InfosTuboRN();

    $objTubo = new Tubo();
    $objTuboRN = new TuboRN();

    $objPerfilPaciente = new PerfilPaciente();
    $objPerfilPacienteRN = new PerfilPacienteRN();

    $objRTqPCR = new RTqPCR();
    $objRTqPCR_RN = new RTqPCR_RN();

    $select_situacao = '';
    $select_perfis = '';
    $perfisSelecionados = '';
    $disabled = '';
    $alert = '';
    $form = '';

    PerfilPacienteINT::montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, '', '', null);

    if(isset($_GET['idLaudo'])){
        $alert .= Alert::alert_warning('O laudo foi cadastrado, registre no sistema GAL. Para acessá-lo, clique <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastro_laudo&idLaudo='.$_GET['idLaudo']) . '">aqui</a>');
    }

    switch ($_GET['action']) {
        case 'cadastrar_diagnostico':


             if (isset($_POST['btn_selecionar_perfil']) ) {
                 $perfil = array();
                 for ($i = 0; $i < count($_POST['sel_perfis']); $i++) {
                     $perfisSelecionados .= $_POST['sel_perfis'][$i] . ';';
                 }
                 $_SESSION['COVID19']['PERFIS_SELECIONADOS'] = $perfisSelecionados;
                 PerfilPacienteINT::montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, '', '', null);
             }else if(isset($_SESSION['COVID19']['PERFIS_SELECIONADOS'])) {
                 $perfisSelecionados = $_SESSION['COVID19']['PERFIS_SELECIONADOS'];
                 PerfilPacienteINT::montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, '', '', null);
             }

             if(strlen($perfisSelecionados) > 0) {

                 $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                 $objInfosTubo->setEtapa(InfosTuboRN::$TP_DIAGNOSTICO);
                 // $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_EM_UTILIZACAO);
                 $arrAmostras = $objInfosTuboRN->consultar_aguardando_diagnostico($objInfosTubo, $perfisSelecionados);

                 if (count($arrAmostras) == 0) {
                     $alert .= Alert::alert_warning("Não foram encontradas amostras");
                 } else {
                     $alert .= Alert::alert_success("Foram encontradas " . count($arrAmostras) . " amostras");

                     $form = '';
                     foreach ($arrAmostras as $amostra) {
                         $disabledCheck = '';
                         $tubo = $amostra->getObjTubo()[0];
                         $tam = count($tubo->getObjInfosTubo());
                         $infosTubo = $tubo->getObjInfosTubo()[$tam - 1];
                         if ($infosTubo->getSituacaoTubo() == InfosTuboRN::$TST_DESCARTADO) {
                             $objDiagnostico->setDiagnostico(DiagnosticoRN::$STA_INCONCLUSIVO);
                             $disabledCheck = ' disabled ';
                         }
                         DiagnosticoINT::montar_select_situacao_diagnostico($select_situacao, $objDiagnostico, $amostra->getIdAmostra(), null, null);
                         $form .= '<div class="form-row">  
                                    <div class="col-md-12 mb-4">
                                        <h4>' . $amostra->getNickname() . '</h4>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label>Perfil da Amostra</label>
                                        ' . $amostra->getObjPerfil()->getIndex_perfil() . '
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label >Selecione o diagnóstico</label>
                                        ' . $select_situacao . '
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label  >Observações</label>
                                        <textarea class="form-control form-control-sm" ' . $disabled . '
                                           name="txtObs_' . $amostra->getIdAmostra() . '" rows="2"></textarea>
                           
                                    </div>';
                         $form .= ' <div class="col-md-12 mb-4">
                                         <input type="checkbox" ' . $checked . ' class="custom-control-input" id="checkReteste_' . $amostra->getIdAmostra() . '" ' . $disabledCheck . '
                                            name="checkReteste' . $amostra->getIdAmostra() . '">
                                            <label class="custom-control-label" for="checkReteste_' . $amostra->getIdAmostra() . '">Reteste</label>
                                     </div>';
                         $form .= ' </div>';
                     }

                 }

                 $contador = 0;
                 $form = '<div class="form-row"> ';
                 foreach ($arrAmostras as $amostra) {
                     if ($contador == 3) {
                         $form .= '</div>';
                         $form .= '<div class="form-row"> ';
                         $contador = 0;
                     }
                     $arr_tubos_volume = $objInfosTuboRN->procurar_sobra_volume($amostra);
                     /*
                     echo "<pre>";
                     print_r($arr_tubos_volume);
                     echo "</pre>";
                     */
                     $tuboTipoAliquota=0;
                     $volumeAliquota = 0;
                     $tuboTipoRNA=0;
                     $volumeRNA = 0;
                     $tuboReteste = array();
                     if(count($arr_tubos_volume) > 0) {
                         foreach ($arr_tubos_volume as $tuboVolume) {
                             if ($tuboVolume->getTipo() == TuboRN::$TT_ALIQUOTA) {

                                 $tuboTipoAliquota++;
                                 $volumeAliquota += $tuboVolume->getObjInfosTubo()->getVolume();
                                 $tuboReteste[] = $tuboVolume;
                             }
                             if ($tuboVolume->getTipo() == TuboRN::$TT_RNA) {
                                 //if($tuboTipoRNA == 0 && $tuboTipoAliquota == 0) $tuboReteste = $tuboVolume;
                                 $tuboTipoRNA++;
                                 $volumeRNA += $tuboVolume->getObjInfosTubo()->getVolume();
                                 $tuboReteste[] = $tuboVolume;
                             }

                         }
                     }

                     $disabledCheck = '';
                     $tubo = $amostra->getObjTubo()[0];
                     $tam = count($tubo->getObjInfosTubo());
                     $infosTubo = $tubo->getObjInfosTubo()[$tam - 1];
                     $objDiagnostico = new Diagnostico();
                     if ($infosTubo->getSituacaoTubo() == InfosTuboRN::$TST_DESCARTADO) {
                         $objDiagnostico->setDiagnostico(DiagnosticoRN::$STA_INCONCLUSIVO );
                         $disabledCheck = ' disabled ';
                     }
                     DiagnosticoINT::montar_select_situacao_diagnostico($select_situacao, $objDiagnostico, $amostra->getIdAmostra(), null, null);

                     $form .= '
                                <div class="col-md-4"> 
                                   <form method="POST">
                                  
                                    <div class="card" style="width: 100%">
                                    <div style="border: 1px dashed #3a5261;width: 100%;padding:30px 0px 30px 0px;margin-left: 0%;text-align: center;" >
                                      <h2 >' . $amostra->getNickname() . '</h2>
                                      <h5>' . $amostra->getObjPerfil()->getIndex_perfil() . '</h5>
                                      </div>
                                      <div class="card-body">
                                        <h5 class="card-title">Informações </h5>
                                        <p class="card-text"> Volume Restante: </p>
                                        <ul>
                                            <li>Tubos ALÍQUOTA (quantidade '.$tuboTipoAliquota.'): '.$volumeAliquota.'ml</li>
                                            <li>Tubos RNA (quantidade '.$tuboTipoRNA.'): '.$volumeRNA.'ml</li>
                                          
                                        </ul>
                                         
                                        <hr>
                                        <p class="card-text"> Selecione o diagnóstico:</p>
                                        ' . $select_situacao . '
                                        <hr>';
                        if($volumeAliquota == 0 && $volumeRNA == 0){
                            $disabledCheck = ' disabled ';
                        }
                     $form .= '      <div class="form-check"  style="width:30%;margin-left: 35%;margin-top: 10px;">
                                            <input type="checkbox"  ' . $checked . ' class="form-check-input"   id="checkReteste_' . $amostra->getIdAmostra() . '" ' . $disabledCheck . '
                                            name="checkReteste' . $amostra->getIdAmostra() . '">
                                            <label class="form-check-label" for="checkReteste_' . $amostra->getIdAmostra() . '">Reteste</label>
                                          </div>';
                     $form .= '  <hr>                                 
                                         <p class="card-text"> Observações: </p>
                                        <textarea class="form-control form-control-sm" ' . $disabled . '
                                           name="txtObs_' . $amostra->getIdAmostra() . '" rows="2"></textarea>
                                        <!--<a target="_blank" style="margin-top: 20px;margin-left:0px;width: 100%;"  href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_diagnostico&idAmostra=' . $amostra->getIdAmostra()) . '" class="btn btn-primary" style="margin-left:1%;width: 98%;">Realizar Diagnóstico</a> -->
                                        <button class="btn btn-primary" type="submit" style="width: 100%;margin-left: 0%;margin-top:20px;" name="btn_diagnostico_' . $amostra->getIdAmostra() . '">Realizar Diagnóstico</button>
                                      </div>
                                      <div class="card-footer text-muted" style="font-size: 12px;">
                                        Aguardando diagnóstico desde: <br> ' . Utils::converterDataHora($infosTubo->getDataHora()) . '
                                      </div>
                                    </div>
                                    </form>
                               </div>';
                     //style="margin-bottom: -6.5%;width: 112.9%;margin-top:20px;margin-left: -6.5%;border-radius: 0px;background-color: #3a5261;"

                     $contador++;

                     if (isset($_POST['btn_diagnostico_' . $amostra->getIdAmostra()])) {
                         $objDiagnostico->setIdAmostraFk($amostra->getIdAmostra());
                         $objDiagnostico->setDiagnostico($_POST['sel_situacao_diagnostico'.$amostra->getIdAmostra()]);
                         //$objDiagnostico->setVolumeRestante($volumeAliquota+$volumeRNA);
                         $objDiagnostico->setVolumeRestante(strval($volumeAliquota));
                         if(isset($_POST['checkReteste' . $amostra->getIdAmostra()]) && $_POST['checkReteste' . $amostra->getIdAmostra()] == 'on'){
                             $objDiagnostico->setReteste(true);
                         }else{
                             $objDiagnostico->setReteste(false);
                         }

                         $objDiagnostico->setObservacoes($_POST['txtObs_' . $amostra->getIdAmostra()]);
                         $objDiagnostico->setDataHoraFim(date('Y-m-d  H:i:s'));
                         $objDiagnostico->setDataHoraInicio($_SESSION['DATA_LOGIN']);
                         $objDiagnostico->setIdUsuarioFk(Sessao::getInstance()->getIdUsuario());
                         $objDiagnostico->setSituacao(DiagnosticoRN::$STA_FINALIZADO);

                         $primeiraVez = true;
                         $arr_infos = array();
                         foreach ($amostra->getObjTubo() as $tuboAux){
                             $tamAux = count($tuboAux->getObjInfosTubo());
                             $infosTuboAux = $tuboAux->getObjInfosTubo()[$tam - 1];

                             $infosTuboAux->setIdInfosTubo(null);
                             $infosTuboAux->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                             $infosTuboAux->setIdTubo_fk($tuboAux->getIdTubo());
                             $infosTuboAux->setEtapa(InfosTuboRN::$TP_DIAGNOSTICO);
                             $infosTuboAux->setEtapaAnterior(InfosTuboRN::$TP_RTqPCR);
                             $infosTuboAux->setDataHora(date('Y-m-d  H:i:s'));
                             $infosTuboAux->setReteste($objDiagnostico->getReteste());
                             $infosTuboAux->setObservacoes($objDiagnostico->getObservacoes());
                             $infosTuboAux->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                             $infosTuboAux->setSituacaoTubo(InfosTuboRN::$TST_SEM_UTILIZACAO);
                             $arr_infos[] = $infosTuboAux;


                             $infosTuboAuxUm = new InfosTubo();
                             $infosTuboAuxUm->setIdInfosTubo(null);
                             $infosTuboAuxUm->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                             $infosTuboAuxUm->setIdTubo_fk($tuboAux->getIdTubo());
                             $infosTuboAuxUm->setEtapa(InfosTuboRN::$TP_LAUDO);
                             $infosTuboAuxUm->setEtapaAnterior(InfosTuboRN::$TP_DIAGNOSTICO);
                             $infosTuboAuxUm->setDataHora(date('Y-m-d  H:i:s'));
                             $infosTuboAuxUm->setReteste($objDiagnostico->getReteste());
                             $infosTuboAuxUm->setObservacoes($objDiagnostico->getObservacoes());
                             $infosTuboAuxUm->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                             $infosTuboAuxUm->setSituacaoTubo(InfosTuboRN::$TST_EM_UTILIZACAO);
                             $arr_infos[] = $infosTuboAux;


                             if($objDiagnostico->getReteste() && $objDiagnostico->getVolumeRestante() > 0){
                                 //if($volumeAliquota > 0){
                                 if($primeiraVez) {
                                     foreach ($tuboReteste as $t) {
                                         $infosTuboAuxDois = $t->getObjInfosTubo();
                                         $infosTuboAuxDois->setIdInfosTubo(null);
                                         $infosTuboAuxDois->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                                         $infosTuboAuxDois->setIdTubo_fk($t->getIdTubo());
                                         $infosTuboAuxDois->setEtapaAnterior(InfosTuboRN::$TP_DIAGNOSTICO);
                                         $infosTuboAuxDois->setEtapa(InfosTuboRN::$TP_RETESTE);
                                         $infosTuboAuxDois->setDataHora(date('Y-m-d  H:i:s'));
                                         $infosTuboAuxDois->setReteste('n');
                                         if ($objDiagnostico->getReteste()) {
                                             $infosTuboAuxDois->setReteste('s');
                                         }

                                         $infosTuboAuxDois->setObservacoes(null);
                                         $infosTuboAuxDois->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                                         $infosTuboAuxDois->setSituacaoTubo(InfosTuboRN::$TST_SEM_UTILIZACAO);
                                         $arr_infos[] = $infosTuboAuxDois;
                                         $primeiraVez = false;
                                     }
                                 }
                                 //}
                             }


                         }

                         if(!$objDiagnostico->getReteste()){
                             $objLaudo = new Laudo();
                             $objLaudo->setSituacao(LaudoRN::$SL_PENDENTE);
                             $objLaudo->setObservacoes($objDiagnostico->getObservacoes());
                             $objLaudo->setIdUsuarioFk(Sessao::getInstance()->getIdUsuario());
                             $objLaudo->setDataHoraGeracao(date('Y-m-d  H:i:s'));
                             $objLaudo->setDataHoraLiberacao(null);
                             $objLaudo->setIdAmostraFk($objDiagnostico->getIdAmostraFk());
                             $objLaudo->setResultado($objDiagnostico->getDiagnostico());
                             $objDiagnostico->setObjLaudo($objLaudo);
                         }
                         $objDiagnostico->setObjInfosTubo($arr_infos);
                         /*
                         echo "<pre>";
                         print_r($objDiagnostico);
                         echo "</pre>";
                         */

                         $objDiagnostico = $objDiagnosticoRN->cadastrar($objDiagnostico);
                         //print_r($objDiagnostico->getObjLaudo());
                         $alert .= Alert::alert_success("Diagnóstico <strong>cadastrado</strong> com sucesso");

                         if($amostra->getObjPerfil() != null && $amostra->getObjPerfil()->getCaractere() == PerfilPacienteRN::$TP_PACIENTES_SUS && $objDiagnostico->getObjLaudo() != null ){
                             header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_diagnostico&idLaudo=' .$objDiagnostico->getObjLaudo()->getIdLaudo()));
                             die();
                         }
                         //colocar o header na pg do diagnostico


                     }


                 }
             }

            break;

        case 'editar_diagnostico':

            if (isset($_POST['btn_salvar_diagnostico'])) { //se enviou o formulário com as alterações

                $alert= Alert::alert_success("Diagnóstico alterado com sucesso");
            }

            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_diagnostico.php');
    }
} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Realizar Diagnóstico");
Pagina::getInstance()->adicionar_css("precadastros");
/*if($novaAba){
    echo "<script>window.open('". Sessao::getInstance()->assinar_link('controlador.php?action=cadastro_laudo&idLaudo='.$objDiagnostico->getObjLaudo()->getIdLaudo().'&idAmostra=' . $amostra->getIdAmostra()) ."', '_blank');</script>";
}*/
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('REALIZAR DIAGNÓSTICO', null,null,'listar_diagnostico', 'LISTAR DIAGNÓSTICO');
Pagina::getInstance()->mostrar_excecoes();

echo
    $alert.

    '<div class="conteudo_grande" style="margin-top: -40px;">    
            <form method="POST">
                 <div class="form-row" style="margin-bottom: 30px;">  
                    <div class="col-md-3">
                        <input type="text" class="form-control" hidden id="idDtHrInicio" readonly  style="text-align: center;"
                           name="dtHrInicio"  value="'. Pagina::formatar_html($_SESSION['DATA_LOGIN']).'" >
                    </div>

                </div>

                <div class="form-row">  
                    <div class="col-md-12 mb-4">
                        <label for="nomeEquipamento" >Selecione um ou mais perfis</label>
                        '.$select_perfis.'
                         
                    </div>
                </div>
                
                <div class="form-row">  
                    <div class="col-md-12 mb-4">
                        <button class="btn btn-primary" style="width: 30%;margin-left: 35%;" type="submit" name="btn_selecionar_perfil">SELECIONAR</button>
                    </div> 
                </div>
                </form>   
                
                '.$form.'
               
    </div>';




Pagina::getInstance()->fechar_corpo();
