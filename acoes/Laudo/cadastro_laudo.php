<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */


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

    require_once __DIR__ . '/../../classes/Tubo/Tubo.php';
    require_once __DIR__ . '/../../classes/Tubo/TuboRN.php';

    require_once __DIR__ . '/../../classes/InfosTubo/InfosTubo.php';
    require_once __DIR__ . '/../../classes/InfosTubo/InfosTuboRN.php';

    require_once __DIR__ . '/../../classes/Amostra/Amostra.php';
    require_once __DIR__ . '/../../classes/Amostra/AmostraRN.php';

    require_once __DIR__.'/../../classes/Laudo/Laudo.php';
    require_once __DIR__.'/../../classes/Laudo/LaudoRN.php';

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

    $checked = '';

    //if(isset($_GET['idLaudo'])){

        $objLaudo->setIdLaudo($_GET['idLaudo']);
        $objLaudo = $objLaudoRN->laudo_completo($objLaudo);
        // print_r($objLaudo);
        $col_md = 'col-md-12';
        if($objLaudo->getObjAmostra()->getObjPaciente()->getObjCodGAL() != null) {
            $col_md = 'col-md-8';
            $objCodigoGAL->setCodigo($objLaudo->getObjAmostra()->getObjPaciente()->getObjCodGAL());
        }
        $objPaciente->setNome($objLaudo->getObjAmostra()->getObjPaciente()->getNome());
        $objAmostra->setNickname($objLaudo->getObjAmostra()->getNickname());
        $objAmostra->setDataColeta($objLaudo->getObjAmostra()->getDataColeta());
        $objPerfilPaciente->setPerfil($objLaudo->getObjAmostra()->getObjPerfil());

        if($objLaudo->getSituacao() == LaudoRN::$SL_CONCLUIDO){
            $checked = ' checked ';
        }

    //}

    if(isset($_POST['salvar_laudo'])){
        $objLaudo = new Laudo();
        $objLaudoRN = new LaudoRN();

        $objLaudo->setIdLaudo($_GET['idLaudo']);
        $objLaudo = $objLaudoRN->consultar($objLaudo);

        if($_POST['laudoEntregue'] == 'on'){
            $objLaudo->setDataHoraLiberacao(date("Y-m-d H:i:s"));
            $objLaudo->setSituacao(LaudoRN::$SL_CONCLUIDO);
            $objLaudo = $objLaudoRN->alterar($objLaudo);
            $checked = ' checked ';
            $alert .=  Alert::alert_success("Laudo alterado com sucesso");

        }
        if($_POST['laudoEntregue'] != 'on'){
            $objLaudo->setDataHoraLiberacao(null);
            $objLaudo->setSituacao(LaudoRN::$SL_PENDENTE);
            $objLaudo = $objLaudoRN->alterar($objLaudo);
            $checked = '  ';
            $alert .=  Alert::alert_success("Laudo alterado com sucesso");

        }
    }




}catch (Throwable $ex) {
        Pagina::getInstance()->processar_excecao($ex);
    }

Pagina::abrir_head("Laudo");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar("LAUDO",null,null,"listar_laudo","LISTAR LAUDOS");
echo $alert;

    echo '<div class="conteudo_grande" style="width: 80%;margin-left: 10%;margin-top: -10px;">
                <div class="form-row">
                    
                     <div class="'.$col_md.'">
                        <label>Nome do paciente: </label>
                         <input type="text" disabled class="form-control" id="idNome" placeholder="" 
                         onblur=""   value="' . Pagina::formatar_html($objPaciente->getNome()) . '">   
                     </div>';

                if($objCodigoGAL->getCodigo() != null) {
                     echo '<div class="col-md-4">
                                <label>Código GAL: </label>
                                 <input type="text" disabled class="form-control" id="idNome" placeholder="" 
                                 onblur=""   value="' . Pagina::formatar_html($objCodigoGAL->getCodigo()) . '">   
                             </div>';
                }
                echo '</div>
                
                <div class="form-row">
                     <div class="col-md-4">
                        <label>Código da Amostra: </label>
                         <input type="text"  disabled class="form-control" id="idCodigoAmostra" placeholder="" 
                         onblur=""   value="' . Pagina::formatar_html($objAmostra->getNickname()) . '">   
                     </div>
                     <div class="col-md-4">
                        <label>Perfil Amostra: </label>
                         <input type="text" disabled class="form-control" id="idNome" placeholder="" 
                         onblur=""  value="' . Pagina::formatar_html($objPerfilPaciente->getPerfil()) . '">   
                     </div>
                     
                     <div class="col-md-4">
                        <label>Data da coleta: </label>
                         <input type="date" disabled class="form-control" id="idNome" placeholder="" 
                         onblur=""  value="' . Pagina::formatar_html($objAmostra->getDataColeta()) . '">   
                     </div>
                     
                </div>
                <div class="form-row">
                    <label>RESULTADO DO LAUDO: </label>
                         <input type="text" disabled class="form-control" id="idNome" placeholder="" 
                         onblur=""  value="' . Pagina::formatar_html(LaudoRN::mostrarDescricaoResultado($objLaudo->getResultado())) . '">   
                </div>
                <form method="post">
                <div class="form-row">
                    
                    <div class="col-md-12">
                        <div class="custom-control custom-checkbox" style="float: right;">
                            <input type="checkbox" '.$checked.'  class="custom-control-input"  id="idCadastroPendente"
                                   name="laudoEntregue">
                            <label class="custom-control-label"  for="idCadastroPendente">Laudo finalizado</label>
                        </div>
                    </div>
                </div>
                <div class="form-row" style="margin-top: 5px;margin-bottom: 0px;">
                    <div class="col-md-12">
                        <button class="btn btn-primary" style="width: 50%; margin-left: 25%;" type="submit" name="salvar_laudo">SALVAR</button>
                    </div>
                </div>
                </form>
           </div>';

Pagina::getInstance()->fechar_corpo();