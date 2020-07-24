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

    require_once __DIR__ . '/../../classes/AnaliseQualidade/AnaliseQualidade.php';
    require_once __DIR__ . '/../../classes/AnaliseQualidade/AnaliseQualidadeRN.php';
    require_once __DIR__ . '/../../classes/AnaliseQualidade/AnaliseQualidadeINT.php';


    $utils = new Utils();
    Sessao::getInstance()->validar();

    date_default_timezone_set('America/Sao_Paulo');
    $_SESSION['DATA_LOGIN'] = date("Y-m-d H:i:s");

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

    /* ANÁLISE DE QUALIDADE */
    $objAnaliseQualidade = new AnaliseQualidade();
    $objAnaliseQualidadeRN = new AnaliseQualidadeRN();

    $html = '';
    $alert = '';

    $tuboRNA = false;
    $tuboALIQUOTA = false;
    $aparecer_botoes = true;
    $rtqpcr_realizado =false;
    if(isset($_GET['idRTqPCRRealizado']) && $_GET['idRTqPCRRealizado'] == 1){
        $rtqpcr_realizado =true;
    }


    $objTubo->setIdAmostra_fk($_GET['idAmostra']);
    $arrAmostras = $objTuboRN->listar_completo($objTubo,null,true);

    foreach ($arrAmostras as $amostra){
        $tubo = $amostra->getObjTubo();
        $arrInfosTubo = $tubo->getObjInfosTubo();
        foreach ($arrInfosTubo as $info){
            if($info->getEtapa() == InfosTuboRN::$TP_RETESTE && $info->getSituacaoEtapa() == InfosTuboRN::$TSP_AGUARDANDO && $info->getSituacaoTubo() == InfosTuboRN::$TST_SEM_UTILIZACAO) {
                $amostras_validas[] = $amostra;
                if($tubo->getTipo() == TuboRN::$TT_RNA){
                    $tuboRNA = true;
                    $amostras_RNA[] = $amostra;
                }
                if($tubo->getTipo() == TuboRN::$TT_ALIQUOTA){
                    $tuboALIQUOTA = true;
                    $amostras_aliquotas[] = $amostra;
                }
            }
        }
    }

    //amostras disponíveis para reteste
    /*
    echo "<pre>";
    print_r($amostras_validas);
    echo "</pre>";
    */

    $html_amostras ='';
    $html_amostras .= '<div class="container">
                        <div class="row">';

    foreach ($amostras_validas as $amostra) {
        $objAnaliseQualidade = new AnaliseQualidade();
        if($contador == 1) {
            $html_amostras .= '   </div>';
            $html_amostras .= '   <hr>';
            $html_amostras .= '   <div class="row">';
            $contador =0;
        }

        $tubo = $amostra->getObjTubo();
        $tam = count($tubo->getObjInfosTubo());
        $info = $tubo->getObjInfosTubo()[$tam-1];
        $objLocal = $info->getObjLocal();
        $objDiagnostico->setIdAmostraFk($amostra->getIdAmostra());
        $arr = $objDiagnosticoRN->listar($objDiagnostico);
        $objDiagnostico = $arr[0];

        $objAnaliseQualidade->setIdTuboFk($tubo->getIdTubo());
        $objAnaliseQualidade->setIdAmostraFk($amostra->getIdAmostra());
        $arrAnalises = $objAnaliseQualidadeRN->listar($objAnaliseQualidade);
        if(count($arrAnalises) > 0) {
            $objAnaliseQualidade = $arrAnalises[0];
        }

        //print_r($tubo->getObjInfosTubo());

        //datas
        $data_preparo = '-';$data_solicitacaoMontagem='-';$data_extracao ='-';$data_montagem_grupo='-';
        $data_mix = '-';$data_rtqpcr ='-';$data_montagem='-';

        //obser
        $str_obs_montagem ='-';$str_obs_montagemPreparo='-';$str_obs_extracao = '-';
        $str_obs_mix = '-';$str_obs_preparo ='-';$str_obs_rtqpcr='-';$str_obs_solicitacao='-';

        //problemas
        $str_obsP_montagem ='-';$str_obsP_montagemPreparo='-';$str_obsP_extracao = '-';
        $str_obsP_mix = '-';$str_obsP_preparo ='-';$str_obsP_rtqpcr='-';$str_obsP_solicitacao='-';
        foreach ($tubo->getObjInfosTubo() as $i){

            if($i->getEtapa() == InfosTuboRN::$TP_MONTAGEM_GRUPOS_AMOSTRAS){
                if(strlen($i->getObservacoes()) > 0){
                    $str_obs_montagemPreparo .= $i->getObservacoes()."; ";
                }
                if(strlen($i->getObsProblema()) > 0){
                    $str_obsP_montagemPreparo .= $i->getObservacoes()."; ";
                }
                if($i->getSituacaoEtapa() == InfosTuboRN::$TSP_FINALIZADO) {
                    $data_montagem_grupo = Utils::converterDataHora($i->getDataHora());
                }
            }
            else if($i->getEtapa() == InfosTuboRN::$TP_PREPARACAO_INATIVACAO){
                if(strlen($i->getObservacoes()) > 0){
                    $str_obs_preparo .= $i->getObservacoes()."; ";
                }
                if(strlen($i->getObsProblema()) > 0){
                    $str_obsP_preparo .= $i->getObservacoes()."; ";
                }
                if($i->getSituacaoEtapa()  ==InfosTuboRN::$TSP_FINALIZADO) {
                    $data_preparo = Utils::converterDataHora($i->getDataHora());
                }
            }
            else if($i->getEtapa() ==InfosTuboRN::$TP_EXTRACAO){
                if(strlen($i->getObservacoes()) > 0){
                    $str_obs_extracao .= $i->getObservacoes()."; ";
                }
                if(strlen($i->getObsProblema()) > 0){
                    $str_obsP_extracao .= $i->getObservacoes()."; ";
                }
                if($i->getSituacaoEtapa() == InfosTuboRN::$TSP_FINALIZADO) {
                    $data_extracao = Utils::converterDataHora($i->getDataHora());
                }
            }
            else if($i->getEtapa() ==InfosTuboRN::$TP_RTqPCR_SOLICITACAO__MONTAGEM_PLACA){
                if(strlen($info->getObservacoes()) > 0){
                    $str_obs_solicitacao .= $i->getObservacoes()."; ";
                }
                if(strlen($i->getObsProblema()) > 0){
                    $str_obsP_solicitacao .= $i->getObservacoes()."; ";
                }
                if($i->getSituacaoEtapa() == InfosTuboRN::$TSP_FINALIZADO) {
                    $data_solicitacaoMontagem = Utils::converterDataHora($i->getDataHora());
                }
            }
            else if($i->getEtapa() ==InfosTuboRN::$TP_RTqPCR_MIX_PLACA){
                if(strlen($i->getObservacoes()) > 0){
                    $str_obs_mix .= $i->getObservacoes()."; ";
                }
                if(strlen($i->getObsProblema()) > 0){
                    $str_obsP_mix .= $i->getObservacoes()."; ";
                }
                if($i->getSituacaoEtapa() == InfosTuboRN::$TSP_FINALIZADO) {
                    $data_mix = Utils::converterDataHora($i->getDataHora());
                }
            }
            else if($i->getEtapa() ==InfosTuboRN::$TP_RTqPCR_MONTAGEM_PLACA){
                if(strlen($i->getObservacoes()) > 0 && 'Informando o local de armazenamento' != $i->getObservacoes()){
                    $str_obs_montagem .= $i->getObservacoes()."; ";
                }
                if(strlen($i->getObsProblema()) > 0){
                    $str_obsP_montagem .= $i->getObservacoes()."; ";
                }
                if($i->getSituacaoEtapa() == InfosTuboRN::$TSP_FINALIZADO) {
                    $data_montagem = Utils::converterDataHora($i->getDataHora());
                }
            }
            else if($i->getEtapa()  == InfosTuboRN::$TP_RTqPCR ){
                if(strlen($i->getObservacoes()) > 0){
                    $str_obs_rtqpcr .= $i->getObservacoes()."; ";
                }

                if(strlen($i->getObsProblema()) > 0){
                    $str_obsP_rtqpcr .= $i->getObservacoes()."; ";
                }

                if($i->getSituacaoEtapa() == InfosTuboRN::$TSP_FINALIZADO) {
                    $data_rtqpcr = Utils::converterDataHora($i->getDataHora());
                }
            }
        }

        $html_amostras .= '  
                                <div class="col-md-12">
                                    <table class="table table-responsive">
                                          
                                          <tbody>';



        $style = 'style="font-weight: bold;background-color: rgba(58,82,97,0.1);"';
        $html_amostras .= '<tr><td  rowspan="5" colspan="2" style="padding-top: 8%;background-color: #3a5261;color: white;">
                                    <h3> '.$amostra->getNickname().' do tipo <br> '.TuboRN::mostrarDescricaoTipoTubo($tubo->getTipo()).'</h3>
                                </td></tr>';
        $html_amostras .= '<tr ><td style="border-top: 1px solid #3a5261;background-color: #3a5261;color: white;width: 10%;"> Etapa </td>
                                <td style="border-top: 1px solid #3a5261;background-color: #3a5261;color: white;"> Observações </td>
                                <td style="border-top: 1px solid #3a5261;background-color: #3a5261;color: white;"> Problemas </td>
                                <td style="border-top: 1px solid #3a5261;background-color: #3a5261;color: white;width: 10%;"> Data </td>
                                <td style="border-top: 1px solid #3a5261;background-color: #3a5261;color: white;width: 10%;">  </td>
                                </tr>';
        $html_amostras .= '<tr ><td '.$style.'> Recepção: </td>
                                <td colspan="3"> '.$amostra->getObservacoes().' </td>';

        if($tubo->getTipo() == TuboRN::$TT_ALIQUOTA){
            //botao nova extracao
            $html_amostras .= ' <td rowspan="10" style="background-color: #3a5261;color: white;border: none;">
                                    <button class="btn btn-primary" type="submit"  style="margin-top:0;padding: 230px 0 230px 0;width: 100%;margin-left:0;border: 1px solid whitesmoke;" name="btn_preparo_'.$tubo->getIdTubo().'">REALIZAR NOVO PREPARO</button>
                               </td>';

        }



         if($tubo->getTipo() == TuboRN::$TT_RNA){
            //botao analise qualidade
            if ($tuboRNA && is_null($objAnaliseQualidade)) {
                $html_amostras .= ' <td rowspan="5" style="background-color: #3a5261;color: white;border: none;">
                                            <button class="btn btn-primary" type="submit"  
                                            style="margin-top:0;padding: 150px 5px 150px 5px;width: 100%;margin-left: 0;border: 1px solid whitesmoke;" name="btn_analise_qualidade_'.$tubo->getIdTubo().'">REALIZAR ANÁLISE DE QUALIDADE</button>
                                       </td>';
            } else if(!$tuboRNA) {
                $html_amostras .= '<td style="background-color: #dee2e6;color: white;border: none;margin-top:0;padding: 150px 2px 150px 2px;">
                                     Não tem amostra RNA disponível 
                                    </td>';
            }else if(!is_null($objAnaliseQualidade)){
                $html_amostras .= ' <td  rowspan="5" style="background-color: #3a5261;color: white;border: none;margin-top:0;padding: 150px 2px 150px 2px;">
                           <p style="align-content:center;">Já foi realizada a análise de qualidade</p>
                        </td>';
            }
        }


        $html_amostras .= '</tr>';
        $html_amostras .= '<tr><td '.$style.'> Montagem Grupos Preparação: </td>
                               <td>  '.$str_obs_montagemPreparo.' </td>
                               <td>  '.$str_obsP_montagemPreparo.'  </td>
                                <td> '.$data_montagem_grupo.' </td>
                           </tr>';
        $html_amostras .= '<tr><td '.$style.'> Preparação/Inativação: </td>
                               <td> '.$str_obs_preparo.' </td>
                               <td> '.$str_obsP_preparo.' </td>
                               <td> '.$data_preparo.' </td>
                           </tr>';


        //$html_amostras .= '<tr ><td  rowspan="1"  colspan="2" style="font-weight: bold;"> INFORMAÇÕES </td></tr>';
        $html_amostras .= '<tr>';
        $html_amostras .= '<td style="font-weight: bold;width: 5%;"> Volume </td><td style="background-color: rgba(210,210,210,0.2);width: 15%;"> '.$info->getVolume().'ml</td>';
        $html_amostras .= '<td '.$style.'> Extração: </td>
                            <td> '.$str_obs_extracao.' </td>
                            <td> '.$str_obsP_extracao.' </td>
                            <td> '.$data_extracao.' </td>';
        $html_amostras .= '</tr>';

        if(strlen($objLocal->getNome()) > 0) {
            $html_amostras .= '<td style="font-weight: bold;"> Nome local armazenamento: </td><td> ' . $objLocal->getNome() . '</td>';
        }else{
            $html_amostras .= '<td style="font-weight: bold;"> Nome local armazenamento: </td><td>  Não informado </td>';
        }
        $html_amostras .= '<td '.$style.'> Solicitação Montagem da placa de RTqPCR: </td><td> '.$str_obs_solicitacao.' </td><td>  '.$str_obsP_solicitacao.'  </td><td>'.$data_solicitacaoMontagem.'</td>';
        $html_amostras .= '</tr>';

        if(strlen($objLocal->getPorta()) > 0) {
            $html_amostras .= '<td style="font-weight: bold;"> Porta: </td><td> ' . $objLocal->getPorta() . '</td>';
        }else{
            $html_amostras .= '<td style="font-weight: bold;"> Porta: </td><td>  Não informada </td>';
        }
        $html_amostras .= '<td '.$style.'> Mix placa RTqPCR: </td><td> '.$str_obs_mix.' </td><td> '.$str_obsP_mix.' </td><td> '.$data_mix.' </td>';
        if($tubo->getTipo() == TuboRN::$TT_RNA) {
            if(!$rtqpcr_realizado) {
                if ($info->getVolume() >= 0.15) {
                    //botao rtqpcr
                    if ($tuboRNA) {
                        $html_amostras .= ' <td rowspan="5" style="color: white;border: none;background-color: #3a5261;" >
                                           <button class="btn btn-primary" type="submit"  style="margin-top:0;padding: 150px 0 150px 0;width: 100%;margin-left: 0px;border: 1px solid whitesmoke;" name="btn_rtqpcr_' . $tubo->getIdTubo() . '">REALIZAR NOVO RTqPCR</button>
                                       </td>';
                    }
                } else {
                    $html_amostras .= ' <td rowspan="5" style="color: white;border: none;margin-top:0;padding: 145px 0 145px 0;" >
                                           Não tem volume suficiente para realizar um novo RTqPCR
                                       </td>';
                }
            }else{
                $html_amostras .= ' <td  rowspan="5" style="background-color: #3a5261;color: white;border: none;margin-top:0;padding: 150px 2px 150px 2px;">
                           <p style="align-content:center;">Já foi realizado o RTqPCR</p>
                        </td>';
            }
        }
        $html_amostras .= '</tr>';

        if(strlen($objLocal->getPrateleira()) > 0) {
            $html_amostras .= '<td style="font-weight: bold;"> Prateleira: </td><td> ' . $objLocal->getPrateleira() . '</td>';
        }else{
            $html_amostras .= '<td style="font-weight: bold;"> Prateleira: </td><td>  Não informada </td>';
        }
        $html_amostras .= '<td '.$style.'> Montagem da placa de RTqPCR: </td><td> '.$str_obs_montagem.' </td><td> '.$str_obsP_montagem.' </td><td> '.$data_montagem.' </td>';
        $html_amostras .= '</tr>';

        $html_amostras .= '<tr>';
        if(strlen($objLocal->getColuna()) > 0) {
            $html_amostras .= '<td style="font-weight: bold;"> Coluna: </td><td> ' . $objLocal->getColuna() . '</td>';
        }else{
            $html_amostras .= '<td style="font-weight: bold;"> Coluna: </td><td>  Não informada </td>';
        }
        $html_amostras .= '<td '.$style.'> Análise do RTqPCR: </td><td> '.$str_obs_rtqpcr.' </td><td> '.$str_obsP_rtqpcr.'  </td><td> '.$data_rtqpcr.' </td>';
        $html_amostras .= '</tr>';

        $html_amostras .= '<tr>';
        if(strlen($objLocal->getCaixa()) > 0) {
            $html_amostras .= '<td style="font-weight: bold;"> Caixa: </td><td> ' . $objLocal->getCaixa() . '</td>';
        }else{
            $html_amostras .= '<td style="font-weight: bold;"> Caixa: </td><td>  Não informada </td>';
        }

        $styleDiagnostico = ' ';
        if($objDiagnostico->getDiagnostico() == DiagnosticoRN::$STA_INCONCLUSIVO){
            $styleDiagnostico = ' style="background-color: rgba(255,255,0,0.2);"';
        }else if($objDiagnostico->getDiagnostico() == DiagnosticoRN::$STA_POSITIVO){
            $styleDiagnostico = ' style="background-color: rgba(255,0,0,0.2);"';
        }else if($objDiagnostico->getDiagnostico() == DiagnosticoRN::$STA_NEGATIVO){
            $styleDiagnostico = ' style="background-color: rgba(0,255,0,0.2);"';
        }

        $html_amostras .= '<td '.$style.'> Diagnóstico: </td>
                           <td colspan="2" '.$styleDiagnostico.'> '.DiagnosticoRN::mostrarDescricaoSituacao($objDiagnostico->getDiagnostico()).' </td>
                           <td colspan="1" '.$styleDiagnostico.'> '.$objDiagnostico->getDataHoraFim().' </td>';
        $html_amostras .= '</tr>';

        $html_amostras .= '<tr>';
        if(strlen($objLocal->getPosicao()) > 0) {
            $html_amostras .= '<td style="font-weight: bold;"> Posição: </td><td> ' . $objLocal->getPosicao() . '</td>';
        }else{
            $html_amostras .= '<td style="font-weight: bold;"> Posição: </td><td>  Não informada </td>';
        }

        if($tubo->getTipo() == TuboRN::$TT_ALIQUOTA){
            $html_amostras .= '<td style="font-weight: bold;background-color: rgba(255,0,0,0.1);" colspan="4"><strike> Análise de qualidade </strike></td>';
        }else {
            if (count($arrAnalises) == 0) {
                $txtAnalise = 'Não foi realizada a análise de qualidade';
                $html_amostras .= '<td ' . $style . '> Análise de qualidade: </td><td colspan="3" style="background-color: rgba(255,255,0,0.2);"> Não foi realizada a análise de qualidade </td>';
            } else {
                if (strlen($arrAnalises[0]->getObservacoes()) > 0) {
                    $str_obs_analise = $arrAnalises[0]->getObservacoes();
                }
                if ($arrAnalises[0]->getResultado() == AnaliseQualidadeRN::$TA_COM_QUALIDADE) {
                    $colorText = ' style="color:green;"';
                }
                if ($arrAnalises[0]->getResultado() == AnaliseQualidadeRN::$TA_SEM_QUALIDADE) {
                    $colorText = ' style="color:red;"';
                }
                $html_amostras .= '<td ' . $style . '> Análise de qualidade: <br><h5 ' . $colorText . '>' . AnaliseQualidadeRN::mostrarDescricaoResultadoAnalise($arrAnalises[0]->getResultado()) . '</h5>
                            </td><td  colspan="2">' . $str_obs_analise . '</td>
                                <td>' . Utils::converterDataHora($arrAnalises[0]->getDataHoraFim()) . '</td>';
            }
            $html_amostras .= '</tr>';
        }


        $html_amostras .= '    </tbody>
                        </table>
                        </div>';
        $contador++;



        // ------------------------ ANÁLISE DE QUALIDADE
        if(isset($_POST['btn_analise_qualidade_'.$tubo->getIdTubo()]) || isset($_POST['btn_salvar_analise_'.$tubo->getIdTubo()])){


            //    $tubo = $amostras_RNA[0]->getObjTubo();
            //   $tam = count($tubo->getObjInfosTubo());
            //    $info = $tubo->getObjInfosTubo()[$tam - 1];
            //    $objLocal = $info->getObjLocal();

                $objDiagnostico->setIdAmostraFk($amostra->getIdAmostra());
                $arr = $objDiagnosticoRN->listar($objDiagnostico);
                $select_resultado_analise = '';

                AnaliseQualidadeINT::montar_select_resultados_analise($select_resultado_analise,$objAnaliseQualidade, null , null);
            $html_qualidade='';
                $html_qualidade = '<h5> Análise de Qualidade da amostra '.$amostra->getNickname().' do tipo '.TuboRN::mostrarDescricaoTipoTubo($tubo->getTipo()).'</h5>
                   <!-- <form method="post"> -->
                    <input type="text" class="form-control" id="idDataHoraLogin" hidden style="text-align: center;"
                               name="dtHoraLoginInicio" required value="' . $_SESSION['DATA_LOGIN'] . '">
                     <div class="form-row">  
                         <div class="col-md-12">
                            <label>Volume</label>
                            <input type="number" class="form-control" step="any" placeholder="ml" 
                            name="numVolume"  value="' . Pagina::formatar_html($info->getVolume()) . '"> 
                         </div>
                     </div>
                      <div class="form-row">  
                        <div class="col-md-4">
                            <label>Local de armazenamento</label>
                            <input type="text" class="form-control" step="any" placeholder=""  disabled
                            name="txtPorta"  value="' . Pagina::formatar_html($objLocal->getNome()) . '"> 
                         </div>
                         <div class="col-md-4">
                            <label>Porta</label>
                            <input type="text" class="form-control" step="any" placeholder=""  disabled
                            name="txtPorta"  value="' . Pagina::formatar_html($objLocal->getPorta()) . '"> 
                         </div>
                         <div class="col-md-4">
                            <label>Prateleira</label>
                            <input type="text" class="form-control" step="any" placeholder=""  disabled
                            name="txtPorta"  value="' . Pagina::formatar_html($objLocal->getPrateleira()) . '"> 
                         </div>
                         </div>
                         <div class="form-row"> 
                         <div class="col-md-4">
                            <label>Coluna</label>
                            <input type="text" class="form-control" step="any" placeholder=""  disabled
                            name="txtPorta"  value="' . Pagina::formatar_html($objLocal->getColuna()) . '"> 
                         </div>
                         <div class="col-md-4">
                            <label>Caixa</label>
                            <input type="text" class="form-control" step="any" placeholder=""  disabled
                            name="txtPorta"  value="' . Pagina::formatar_html($objLocal->getCaixa()) . '"> 
                         </div>
                          <div class="col-md-4">
                            <label>Posição na caixa</label>
                            <input type="text" class="form-control" step="any" placeholder=""  disabled
                            name="txtPorta"  value="' . Pagina::formatar_html($objLocal->getPosicao()) . '"> 
                         </div>
                     </div>
                     <div class="form-row">  
                         <div class="col-md-12">
                            <label>Resultado</label>
                            '.$select_resultado_analise.'
                         </div>
                     </div>
                     <div class="form-row">  
                         <div class="col-md-12">
                            <label>Observações</label>
                             <textarea  name="txtAreaObs" rows="2" cols="100" class="form-control"></textarea>
                         </div>
                     </div>
                     <div class="form-row">  
                         <div class="col-md-12">
                            <button class="btn btn-primary" type="submit"  style="width: 40%;margin-left: 30%;" name="btn_salvar_analise_'.$tubo->getIdTubo().'">SALVAR ANÁLISE DE QUALIDADE</button>
                         </div>
                     </div>
                     
                     ';

                if(isset($_POST['btn_salvar_analise_'.$tubo->getIdTubo()])){

                    $objInfosTubo = $info;
                    $objInfosTubo->setIdInfosTubo(null);
                    $objInfosTubo->setEtapa(InfosTuboRN::$TP_RETESTE);
                    $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_EM_ANDAMENTO);
                    $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_EM_UTILIZACAO);
                    $objInfosTubo->setVolume($_POST['numVolume']);

                    $objAnaliseQualidade->setIdAmostraFk($amostra->getIdAmostra());
                    $objAnaliseQualidade->setIdUsuarioFk(Sessao::getInstance()->getIdUsuario());
                    $objAnaliseQualidade->setDataHoraInicio($_SESSION['DATA_LOGIN']);
                    $objAnaliseQualidade->setDataHoraFim(date("Y-m-d H:i:s"));
                    $objAnaliseQualidade->setObservacoes($_POST['txtAreaObs']);
                    $objAnaliseQualidade->setResultado($_POST['sel_resultado_analise']);

                    $objAnaliseQualidade->setObjInfosTubo($objInfosTubo);
                    $objAnaliseQualidade = $objAnaliseQualidadeRN->cadastrar($objAnaliseQualidade);
                    header('Location: '. Sessao::getInstance()->assinar_link('controlador.php?action=realizar_reteste&idAmostra=' . Pagina::formatar_html($amostra->getIdAmostra()).'&idAnaliseQualidade='.Pagina::formatar_html($objAnaliseQualidade->getIdAnaliseQualidade())));
                    die();

                }



        }



        // ------------------------ EXTRAÇÃO
        if(isset($_POST['btn_preparo_'.$tubo->getIdTubo()]) || isset($_POST['btn_selecionar_amostra_aliquota'])){
            if (!is_null($objAnaliseQualidade)) { //fez a análise de qualidade

            } else {

            }
            //caso tenha mais de uma, selecionar qual que quer pra então seguir em frente
            //echo $tubo->getIdTubo();
            $objInfosTubo = $info;
            $objInfosTubo->setIdInfosTubo(null);
            $objInfosTubo->setEtapa(InfosTuboRN::$TP_MONTAGEM_GRUPOS_AMOSTRAS);
            $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
            $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_SEM_UTILIZACAO);

            foreach ($amostras_RNA as $amostraRNA){
                $tuboRNA = $amostraRNA->getObjTubo();
                $taminfoRNA = count($tuboRNA->getObjInfosTubo());
                $infoTuboRNA = $tuboRNA->getObjInfosTubo()[$taminfoRNA-1];

                $infoTuboRNA->setIdInfosTubo(null);
                $infoTuboRNA->setEtapa(InfosTuboRN::$TP_RETESTE);
                $infoTuboRNA->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                $infoTuboRNA->setSituacaoTubo(InfosTuboRN::$TST_DESCARTADO);
            }

        }


        // ------------------------ RTqPCR
        if(isset($_POST['btn_rtqpcr_'.$tubo->getIdTubo()]) || isset($_POST['btn_salvar_rtqpcr_'.$tubo->getIdTubo()])){

            $html_qualidade='';
            $html_qualidade = '
                   <!-- <form method="post"> --> 
                   <div class="form-row">  
                        <div class="col-md-4">
                            <label>Local de armazenamento</label>
                            <input type="text" class="form-control" step="any" placeholder=""  
                            name="txtNome"  value="' . Pagina::formatar_html($objLocal->getNome()) . '"> 
                         </div>
                         <div class="col-md-4">
                            <label>Porta</label>
                            <input type="text" class="form-control" step="any" placeholder=""  
                            name="txtPorta"  value="' . Pagina::formatar_html($objLocal->getPorta()) . '"> 
                         </div>
                         <div class="col-md-4">
                            <label>Prateleira</label>
                            <input type="text" class="form-control" step="any" placeholder=""  
                            name="txtPrateleira"  value="' . Pagina::formatar_html($objLocal->getPrateleira()) . '"> 
                         </div>
                         </div>
                         <div class="form-row"> 
                         <div class="col-md-4">
                            <label>Coluna</label>
                            <input type="text" class="form-control" step="any" placeholder=""  
                            name="txtColuna"  value="' . Pagina::formatar_html($objLocal->getColuna()) . '"> 
                         </div>
                         <div class="col-md-4">
                            <label>Caixa</label>
                            <input type="text" class="form-control" step="any" placeholder=""  
                            name="txtCaixa"  value="' . Pagina::formatar_html($objLocal->getCaixa()) . '"> 
                         </div>
                          <div class="col-md-4">
                            <label>Posição na caixa</label>
                            <input type="text" class="form-control" step="any" placeholder=""  
                            name="txtPosicao"  value="' . Pagina::formatar_html($objLocal->getPosicao()) . '"> 
                         </div>
                     </div>
                     
                     <div class="form-row">  
                         <div class="col-md-12">
                            <button class="btn btn-primary" type="submit"  style="width: 40%;margin-left: 30%;" name="btn_salvar_rtqpcr_'.$tubo->getIdTubo().'">SALVAR NOVO LOCAL</button>
                         </div>
                     </div>
                     
                     ';


            if(isset($_POST['btn_salvar_rtqpcr_'.$tubo->getIdTubo()])) {
                if (!is_null($objAnaliseQualidade)) { //fez a análise de qualidade
                    $objLocalNovo = new LocalArmazenamentoTexto();
                    $objLocalNovo->setNome($_POST['txtNome']);
                    $objLocalNovo->setPorta($_POST['txtPorta']);
                    $objLocalNovo->setPrateleira($_POST['txtPrateleira']);
                    $objLocalNovo->setColuna($_POST['txtColuna']);
                    $objLocalNovo->setCaixa($_POST['txtCaixa']);
                    $objLocalNovo->setPosicao($_POST['txtPosicao']);
                    $objLocalNovo->setIdTipoLocal($objLocal->getIdTipoLocal());

                    $objInfosTubo = $info;
                    $objInfosTubo->setIdInfosTubo(null);
                    $objInfosTubo->setObjLocal($objLocalNovo);
                    $objInfosTubo->setEtapa(InfosTuboRN::$TP_RTqPCR_SOLICITACAO__MONTAGEM_PLACA);
                    $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                    $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_AGUARDANDO_SOLICITACAO_MONTAGEM_PLACA);
                    $objInfosTuboRN->cadastrar($objInfosTubo);
                } else {
                    $objInfosTubo = $info;
                    $objInfosTubo->setIdInfosTubo(null);
                    $objInfosTubo->setEtapa(InfosTuboRN::$TP_RTqPCR_SOLICITACAO__MONTAGEM_PLACA);
                    $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                    $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_AGUARDANDO_SOLICITACAO_MONTAGEM_PLACA);
                    $objInfosTuboRN->cadastrar($objInfosTubo);
                }


                header('Location: '. Sessao::getInstance()->assinar_link('controlador.php?action=realizar_reteste&idAmostra=' . Pagina::formatar_html($amostra->getIdAmostra()).'&idRTqPCRRealizado=1'));
                die();
            }

        }

        // ------------------------ RTqPCR
        if(isset($_POST['btn_inconclusivo'])){

        }



    }
    $html_amostras .= '</div>';







}catch (Throwable $e){
    Pagina::getInstance()->processar_excecao($e);
}

Pagina::abrir_head("Reteste");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('RETESTE',null,null, 'listar_reteste', 'LISTAR RETESTE');
echo $alert;
Pagina::getInstance()->mostrar_excecoes();


echo '<div class="conteudo_grande"   style="margin-top: 0px;"> 
            <form method="post">';

if(strlen($html_qualidade) > 0){
    echo $html_qualidade;
}else{
    echo $html_amostras;
}

 echo '          </form>';




//echo $html_amostras;
echo'       </div>';

Pagina::getInstance()->fechar_corpo();