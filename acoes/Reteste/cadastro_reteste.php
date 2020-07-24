<?php
session_start();
try {

    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';

    require_once __DIR__ . '/../../classes/Usuario/Usuario.php';
    require_once __DIR__ . '/../../classes/Usuario/UsuarioRN.php';

    require_once __DIR__ . '/../../classes/Paciente/Paciente.php';
    require_once __DIR__ . '/../../classes/Paciente/PacienteRN.php';

    require_once __DIR__ . '/../../classes/Sexo/Sexo.php';
    require_once __DIR__ . '/../../classes/Sexo/SexoRN.php';

    require_once __DIR__ . '/../../classes/Amostra/Amostra.php';
    require_once __DIR__ . '/../../classes/Amostra/AmostraRN.php';

    require_once __DIR__ . '/../../classes/EstadoOrigem/EstadoOrigem.php';
    require_once __DIR__ . '/../../classes/EstadoOrigem/EstadoOrigemRN.php';

    require_once __DIR__ . '/../../classes/LugarOrigem/LugarOrigem.php';
    require_once __DIR__ . '/../../classes/LugarOrigem/LugarOrigemRN.php';

    require_once __DIR__ . '/../../classes/CodigoGAL/CodigoGAL.php';
    require_once __DIR__ . '/../../classes/CodigoGAL/CodigoGAL_RN.php';

    require_once __DIR__ . '/../../utils/Utils.php';
    require_once __DIR__ . '/../../utils/Alert.php';

    require_once __DIR__ . '/../../classes/Tubo/Tubo.php';
    require_once __DIR__ . '/../../classes/Tubo/TuboRN.php';

    require_once __DIR__ . '/../../classes/InfosTubo/InfosTubo.php';
    require_once __DIR__ . '/../../classes/InfosTubo/InfosTuboRN.php';

    require_once __DIR__ . '/../../classes/Etnia/Etnia.php';
    require_once __DIR__ . '/../../classes/Etnia/EtniaRN.php';

    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPaciente.php';
    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPacienteRN.php';
    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPacienteINT.php';

    require_once __DIR__ . '/../../classes/Tubo/Tubo.php';
    require_once __DIR__ . '/../../classes/Tubo/TuboRN.php';

    require_once __DIR__ . '/../../classes/InfosTubo/InfosTubo.php';
    require_once __DIR__ . '/../../classes/InfosTubo/InfosTuboRN.php';

    require_once __DIR__ . '/../../classes/Amostra/Amostra.php';
    require_once __DIR__ . '/../../classes/Amostra/AmostraRN.php';

    require_once __DIR__ . '/../../classes/Laudo/Laudo.php';
    require_once __DIR__ . '/../../classes/Laudo/LaudoRN.php';

    require_once __DIR__ . '/../../classes/Diagnostico/Diagnostico.php';
    require_once __DIR__ . '/../../classes/Diagnostico/DiagnosticoRN.php';

    $utils = new Utils();
    Sessao::getInstance()->validar();
    date_default_timezone_set('America/Sao_Paulo');

    /* USUÁRIO */
    $objUsuario = new Usuario();
    $objUsuario->setMatricula(Sessao::getInstance()->getMatricula());
    $objUsuarioRN = new UsuarioRN();

    /* AMOSTRA */
    $objAmostra = new Amostra();
    $objAmostraRN = new AmostraRN();

    /* TUBO */
    $objTubo = new Tubo();
    $objTuboRN = new TuboRN();


    /* INFOS TUBO */
    $objInfosTubo = new InfosTubo();
    $objInfosTuboRN = new InfosTuboRN();

    /* PACIENTE */
    $objPaciente = new Paciente();
    $objPacienteRN = new PacienteRN();

    /* PERFIL PACIENTE */
    $objPerfilPaciente = new PerfilPaciente();
    $objPerfilPacienteRN = new PerfilPacienteRN();


    /* ESTADO ORIGEM */
    $objEstadoOrigem = new EstadoOrigem();
    $objEstadoOrigemRN = new EstadoOrigemRN();

    /* LUGAR ORIGEM */
    $objLugarOrigem = new LugarOrigem();
    $objLugarOrigemRN = new LugarOrigemRN();

    /* CÓDIGO GAL */
    $objCodigoGAL = new CodigoGAL();
    $objCodigoGAL_RN = new CodigoGAL_RN();

    /* ETNIA */
    $objEtnia = new Etnia();
    $objEtniaRN = new EtniaRN();


    /* SEXO PACIENTE */
    $objSexoPaciente = new Sexo();
    $objSexoPacienteRN = new SexoRN();


    $objLaudo = new Laudo();
    $objLaudoRN = new LaudoRN();

    $objDiagnostico = new Diagnostico();
    $objDiagnosticoRN = new DiagnosticoRN();

    $html = '';
    $select_perfis = '';
    $alert = '';

    PerfilPacienteINT::montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, null, true);

    $objInfosTubo->setEtapa(InfosTuboRN::$TP_RETESTE);
    $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
    $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_SEM_UTILIZACAO);
    $arrInfos = $objInfosTuboRN->listar($objInfosTubo);

    foreach ($arrInfos as $info){
        $objTubo->setIdTubo($info->getIdTubo_fk());
        $arr = $objTuboRN->listar_completo($objTubo,null,true);

        $arrInfosTubo = $objAmostraRN->obter_infos($arr[0]);
        $arr[0]->setObjTubo($arrInfosTubo);

        $arrAmostras[] = $arr[0];

        /*
        echo "<pre>";
        print_r($arrInfosTubo);
        echo "</pre>";
        */

    }



    /*
    echo "<pre>";
    print_r($arrAmostras);
    echo "</pre>";
    */

    //print_r($arrInfosTubo);
    //print_r($arrAmostras);



    if(isset($_POST['sel_perfil'])){

        $objPerfilPaciente->setIdPerfilPaciente($_POST['sel_perfil']);
        PerfilPacienteINT::montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, null, true);

        $html = '<div class="list-group">';
        foreach ($arrAmostras as $amostra){

            $objDiagnostico->setIdAmostraFk($amostra->getIdAmostra());
            $arr = $objDiagnosticoRN->listar($objDiagnostico);

            print_r($arr);


            if($amostra->getObjPerfil()->getIdPerfilPaciente() == $_POST['sel_perfil']){
                $html .= '
                              <div class="list-group-item list-group-item-action flex-column align-items-start "> 
                                <div class="d-flex w-100 justify-content-between">
                                  <h4 class="mb-1">'.$amostra->getNickname().' - '.DiagnosticoRN::mostrarDescricaoSituacao($arr[0]->getDiagnostico()).'</h4>
                                  <small> Data coleta '.Utils::converterData($amostra->getDataColeta()).'</small>
                                </div>';

                $primeiraVez = true;
                foreach ($amostra->getObjTubo() as $tubo) {
              //$html .= '<p class="mb-1">TUBO TIPO ' . TuboRN::mostrarDescricaoTipoTubo($tubo->getTipo()) . '</p>';
                    foreach ($tubo->getObjInfosTubo() as $infos) {
                        //print_r($infos);
                        if(strlen($infos->getObservacoes()) > 0 || strlen($infos->getObsProblema())){

                            if($primeiraVez){
                                $html .= '<table class="table table-hover " style="margin-top: 10px;" >'; //style="width: 60%;">
                                $html .= '<tr>
                                   <th>TIPO TUBO</th> 
                                   <th>ETAPA</th> 
                                   <th>OBSERVAÇÕES</th> 
                                   <th>PROBLEMAS</th> 
                                   <th>DATA/HORA</th> 
                                </tr>';
                            }
                            $primeiraVez = false;

                            $html .=  '<tr>';
                            $html .=  '<td>'.TuboRN::mostrarDescricaoTipoTubo($tubo->getTipo()).'</td>';
                            $html .=  '<td>'.InfosTuboRN::retornarEtapa($infos->getEtapa()).'</td>';
                            $html .=  '<td>'.$infos->getObservacoes().'</td>';
                            $html .=  '<td>'.$infos->getObsProblema().'</td>';
                            $html .=  '<td>'.Utils::converterDataHora($infos->getDataHora()).'</td>';
                            $html .= '</tr>';
                        }

                    }

                }
                $html .= '</table>';
                if(strlen($amostra->getObservacoes()) > 0 ){
                    $html .= '    <p class="mb-1"><strong>Observações: </strong>'.$amostra->getObservacoes().'</p>';
                }
                $html .= '      <small class="text-muted">'.PerfilPacienteRN::mostrarDescricaoTipo($amostra->getObjPerfil()->getCaractere()).'</small>
                                <!--<a href="" class="btn btn-primary" style="width: 20%;margin-left: 80%;" type="submit" name="btn_selecionar_perfil">Realizar reteste</a>-->
                                <a  class="btn btn-primary"  href="' . Sessao::getInstance()->assinar_link('controlador.php?action=realizar_reteste&idAmostra=' . $amostra->getIdAmostra()) . '" style="width: 20%;margin-left: 80%;">SELECIONAR</a>
                              </div>';
                $html .= '';


                //$arr_tubos_volume = $objInfosTuboRN->procurar_sobra_volume($amostra);
                //print_r($arr_tubos_volume);
            }
        }
        $html .= '</div>';
    }

    //print_r($arrInfos);


}catch (Throwable $e){
    Pagina::getInstance()->processar_excecao($e);
}

Pagina::abrir_head("Reteste");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("showtime");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('RETESTE',null,null, 'listar_reteste', 'LISTAR RETESTE');
echo $alert;
Pagina::getInstance()->mostrar_excecoes();


echo '<div class="conteudo_grande"   style="margin-top: 0px;"> 
            <form method="post">
                <div class="form-row">  
                    <div class="col-md-12">
                        <label>Selecione um perfil de paciente</label>
                        ' . $select_perfis .' 
                    </div>
               </div>
               '.$html.'
           </form>
        </div>';

Pagina::getInstance()->fechar_corpo();