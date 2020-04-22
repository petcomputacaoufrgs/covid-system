<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();

require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';

require_once '../classes/Usuario/Usuario.php';
require_once '../classes/Usuario/UsuarioRN.php';

require_once '../classes/Paciente/Paciente.php';
require_once '../classes/Paciente/PacienteRN.php';
require_once '../classes/PerfilPaciente/PerfilPaciente.php';
require_once '../classes/PerfilPaciente/PerfilPacienteRN.php';
require_once '../classes/Sexo/Sexo.php';
require_once '../classes/Sexo/SexoRN.php';
require_once '../classes/Amostra/Amostra.php';
require_once '../classes/Amostra/AmostraRN.php';
require_once '../classes/EstadoOrigem/EstadoOrigem.php';
require_once '../classes/EstadoOrigem/EstadoOrigemRN.php';
require_once '../classes/LugarOrigem/LugarOrigem.php';
require_once '../classes/LugarOrigem/LugarOrigemRN.php';
require_once '../classes/CodigoGAL/CodigoGAL.php';
require_once '../classes/CodigoGAL/CodigoGAL_RN.php';
require_once '../classes/NivelPrioridade/NivelPrioridade.php';
require_once '../classes/NivelPrioridade/NivelPrioridadeRN.php';
require_once '../utils/Utils.php';
require_once '../utils/Alert.php';

$utils = new Utils();

date_default_timezone_set('America/Sao_Paulo');
$_SESSION['DATA_LOGIN'] = date('d/m/Y  H:i:s');



$objUsuario = new Usuario();
$objUsuario->setMatricula(Sessao::getInstance()->getMatricula());
$objUsuarioRN = new UsuarioRN();

/* AMOSTRA */
$objAmostra = new Amostra();
$objAmostraRN = new AmostraRN();

/* CÓDIGO GAL */
$objCodigoGAL = new CodigoGAL();
$objCodigoGAL_RN = new CodigoGAL_RN();


/* PACIENTE */
$objPaciente = new Paciente();
$objPacienteRN = new PacienteRN();

/* PERFIL PACIENTE */
$objPerfilPaciente = new PerfilPaciente();
$objPerfilPacienteRN = new PerfilPacienteRN();

/* SEXO PACIENTE */
$objSexoPaciente = new Sexo();
$objSexoPacienteRN = new SexoRN();

/* ESTADO ORIGEM */
$objEstadoOrigem = new EstadoOrigem();
$objEstadoOrigemRN = new EstadoOrigemRN();

/* LUGAR ORIGEM */
$objLugarOrigem = new LugarOrigem();
$objLugarOrigemRN = new LugarOrigemRN();

/* NÍVEL DE PRIORIDADE */
$objNivelPrioridade = new NivelPrioridade();
$objNivelPrioridadeRN = new NivelPrioridadeRN();

$alert = '';
$select_sexos = '';
$select_estados = '';
$select_municipios = '';
$select_nivelPrioridade = '';
$select_perfis = '';
$select_a_r = '';
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$disabled = '';
$read_only = '';
$cpf_obrigatorio = '';
try {

    montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente);
    montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objPaciente, $disabled);
    montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra); //por default RS
    montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra);
    montar_select_aceitaRecusada($select_a_r, $objAmostra);
    montar_select_niveis_prioridade($select_nivelPrioridade, $objNivelPrioridade, $objNivelPrioridadeRN, $objAmostra);




    /* if (isset($_POST['sel_sexo']) && $_POST['sel_sexo'] != null) {
      $objSexoPaciente->setIdSexo($_POST['sel_sexo']);
      $objSexoPaciente = $objSexoPacienteRN->consultar($objSexoPaciente);
      $objPaciente->setIdSexo_fk($objSexoPaciente->getIdSexo());
      montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente);
      } */


    switch ($_GET['action']) {
        case 'cadastrar_amostra':
            $disabled = '';
            if (isset($_POST['sel_perfil'])) {
                $objPerfilPaciente->setIdPerfilPaciente($_POST['sel_perfil']);
                $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
                $objPaciente->setIdPerfilPaciente_fk($objPerfilPaciente->getIdPerfilPaciente());
                montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objPaciente, $disabled);
            }
            if (isset($_POST['salvar_amostra'])) {

                $objPaciente->setCPF($_POST['txtCPF']);
                $objPaciente->setIdPerfilPaciente_fk($objPerfilPaciente->getIdPerfilPaciente());
                $objPaciente->setNome($_POST['txtNome']);
                $objPaciente->setDataNascimento($_POST['dtDataNascimento']);


                //RG
                if (isset($_POST['txtRG'])) {
                    $objPaciente->setRG($_POST['txtRG']);
                }
                if (isset($_POST['txtObsRG'])) {
                    $objPaciente->setObsRG($_POST['txtObsRG']);
                }
                if (!isset($_POST['txtRG']) && $_POST['txtRG'] = null && !isset($_POST['txtObsRG']) && $_POST['txtObsRG'] == null) {
                    $objPaciente->setObsRG('Desconhecido');
                }

                //SEXO
                if (isset($_POST['sel_sexo'])) {
                    $objPaciente->setIdSexo_fk($_POST['sel_sexo']);
                }
                if ($_POST['sel_sexo'] == 0) {
                    $objPaciente->setObsSexo('Desconhecido');
                }

                //NOME MÃE
                if (isset($_POST['txtNomeMae'])) {
                    $objPaciente->setNomeMae($_POST['txtNomeMae']);
                }
                if (isset($_POST['txtNomeMae'])) {
                    $objPaciente->setObsNomeMae($_POST['txtObsNomeMae']);
                }
                if (!isset($_POST['txtNomeMae']) && !isset($_POST['txtObsNomeMae'])) {
                    $objPaciente->setObsNomeMae('Desconhecido');
                }

                $arr = $objPacienteRN->validarCadastro($objPaciente);
                if (empty($arr)) {
                    $objPacienteRN->cadastrar($objPaciente);
                } else
                    $objPaciente->setIdPaciente($arr[0]->getIdPaciente());


                if (isset($_POST['txtCodGAL'])) {
                    $objCodigoGAL->setCodigo($_POST['txtCodGAL']);
                    $objCodigoGAL->getIdPaciente_fk($objPaciente->getIdPaciente());
                    $objCodigoGAL_RN->cadastrar($objCodigoGAL);
                    $objAmostra->setIdCodGAL_fk($objCodigoGAL->getIdCodigoGAL());
                }



                //Parte da coleta
                $objAmostra->setIdPaciente_fk($objPaciente->getIdPaciente());
                $objAmostra->setDataHoraColeta($_POST['dtColeta']);
                $objAmostra->setAceita_recusa($_POST['sel_aceita_recusada']);
                if ($_POST['sel_aceita_recusada'] == 'a') {
                    $objAmostra->setStatusAmostra('Aguardando Preparação');
                } else if ($_POST['sel_aceita_recusada'] == 'r') {
                    $objAmostra->setStatusAmostra('Descartada');
                }
                $objAmostra->setObservacoes($_POST['txtAreaObs']);
                $objAmostra->setIdEstado_fk(43); //ESTADO DO RS
                $objAmostra->setIdLugarOrigem_fk($_POST['sel_cidades']);
                $objAmostra->setIdNivelPrioridade_fk(1);

                $arr_amostra = $objAmostraRN->validarCadastro($objAmostra);
                if (empty($arr_amostra)) {
                    $objAmostraRN->cadastrar($objAmostra);
                } else {
                    $objAmostra = $arr_amostra;
                }

                montar_select_aceitaRecusada($select_a_r, $objAmostra);
                montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra); //por default RS
                montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra);
                $alert = Alert::alert_success_cadastrar();
                
            } else {
                $objPaciente->setIdPaciente('');
                $objPaciente->setCPF('');
                $objPaciente->setDataNascimento('');
                $objPaciente->setIdPerfilPaciente_fk('');
                $objPaciente->setIdSexo_fk('');
                $objPaciente->setNome('');
                $objPaciente->setNomeMae('');
                $objPaciente->setObsRG('');
                $objPaciente->setObsSexo('');
                $objPaciente->setRG('');
                $objAmostra->setIdAmostra('');
                $objAmostra->setIdPaciente_fk('');
                $objAmostra->setDataHoraColeta('');
                $objAmostra->setAceita_recusa('');
                $objAmostra->setObservacoes('');
                $objAmostra->setIdEstado_fk('');
                $objAmostra->setIdLugarOrigem_fk('');
                $objAmostra->setIdCodGAL_fk('');
                $objAmostra->setIdNivelPrioridade_fk('');
                $objCodigoGAL->setCodigo('');
                $objCodigoGAL->setIdCodigoGAL('');
                $objCodigoGAL->setIdPaciente_fk('');
            }
            break;

        case 'editar_amostra':
            $disabled = ' disabled ';
            if (!isset($_POST['salvar_amostra'])) { //enquanto não enviou o formulário com as alterações
                $objAmostra->setIdAmostra($_GET['idAmostra']);
                $objAmostra = $objAmostraRN->consultar($objAmostra);
                montar_select_aceitaRecusada($select_a_r, $objAmostra);

                $objPaciente->setIdPaciente($objAmostra->getIdPaciente_fk());
                $objPaciente = $objPacienteRN->consultar($objPaciente);

                if ($objPaciente->getRG() == null) {
                    $objPaciente->setRG('');
                }

                if ($objPaciente->getIdSexo_fk() != 0) {
                    $objSexoPaciente->setIdSexo($objPaciente->getIdSexo_fk());
                    $objSexoPaciente = $objSexoPacienteRN->consultar($objSexoPaciente);
                    montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente);
                }

                $objPerfilPaciente->setIdPerfilPaciente($objPaciente->getIdPerfilPaciente_fk());
                $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
                montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objPaciente, $disabled);

                if ($objAmostra->getIdCodGAL_fk() != null) {
                    $objCodigoGAL->setIdCodigoGAL($objAmostra->getIdCodGAL_fk());
                    $objCodigoGAL->setIdPaciente_fk($objPaciente->setIdPaciente());
                    $objCodigoGAL = $objCodigoGAL_RN->consultar($objCodigoGAL);
                }

                $objEstadoOrigem->setCod_estado($objAmostra->getIdEstado_fk());
                $objEstadoOrigem = $objEstadoOrigemRN->consultar($objEstadoOrigem);
                montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra); //por default RS

                $objLugarOrigem->setIdLugarOrigem($objAmostra->getIdLugarOrigem_fk());
                $objLugarOrigemRN->consultar($objLugarOrigem);
                montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra);
            }

            if (isset($_POST['salvar_amostra'])) {
                echo "aqui";
                //Parte da coleta
                $objAmostra->setIdAmostra($_GET['idAmostra']);

                $objAmostra = $objAmostraRN->consultar($objAmostra);
                $objAmostra->setDataHoraColeta($_POST['dtColeta']);
                $objAmostra->setAceita_recusa($_POST['sel_aceita_recusada']);
                if ($_POST['sel_aceita_recusada'] == 'a') {
                    $objAmostra->setStatusAmostra('Aguardando Preparação');
                } else if ($_POST['sel_aceita_recusada'] == 'r') {
                    $objAmostra->setStatusAmostra('Descartada');
                }
                $objAmostra->setObservacoes($_POST['txtAreaObs']);
                $objAmostra->setIdEstado_fk(43); //ESTADO DO RS
                $objAmostra->setIdLugarOrigem_fk($_POST['sel_cidades']);
                $objAmostra->setIdNivelPrioridade_fk(1); //NIVEL DE PRIORIDADE

                if (isset($_POST['txtCodGAL'])) {
                    $objCodigoGAL->setCodigo($_POST['txtCodGAL']);
                    $objCodigoGAL->getIdPaciente_fk($objAmostra->getIdPaciente_fk());
                    $objCodigoGAL_RN->alterar($objCodigoGAL);
                    $objAmostra->setIdCodGAL_fk($objCodigoGAL->getIdCodigoGAL());
                }


                $objAmostraRN->alterar($objAmostra);
                //print_r($objAmostra);


                $objPaciente->setIdPaciente($objAmostra->getIdPaciente_fk());
                $objPaciente = $objPacienteRN->consultar($objPaciente);
                $objPaciente->setCPF($_POST['txtCPF']);
                $objPaciente->setNome($_POST['txtNome']);
                $objPaciente->setDataNascimento($_POST['dtDataNascimento']);


                //RG
                if (isset($_POST['txtRG'])) {
                    echo $_POST['txtRG'];
                    $objPaciente->setRG($_POST['txtRG']);
                    $objPaciente->setObsRG('');
                } else if (isset($_POST['txtObsRG'])) {
                    $objPaciente->setObsRG($_POST['txtObsRG']);
                } else if (!isset($_POST['txtRG']) && $_POST['txtRG'] = null && !isset($_POST['txtObsRG']) && $_POST['txtObsRG'] == null) {
                    echo "aqui";
                    $objPaciente->setObsRG('Desconhecido');
                }

                //SEXO
                if (isset($_POST['sel_sexo'])) {
                    $objPaciente->setIdSexo_fk($_POST['sel_sexo']);
                } else if ($_POST['sel_sexo'] == 0) {
                    $objPaciente->setObsSexo('Desconhecido');
                }

                //NOME MÃE
                if (isset($_POST['txtNomeMae'])) {
                    $objPaciente->setNomeMae($_POST['txtNomeMae']);
                } else if (isset($_POST['txtNomeMae'])) {
                    $objPaciente->setObsNomeMae($_POST['txtObsNomeMae']);
                } else if (!isset($_POST['txtNomeMae']) && !isset($_POST['txtObsNomeMae'])) {
                    $objPaciente->setObsNomeMae('Desconhecido');
                }
                //print_r($objPaciente);
                //die("aqui");
                $objPacienteRN->alterar($objPaciente);

                montar_select_aceitaRecusada($select_a_r, $objAmostra);
                montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra); //por default RS
                montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra);
                $alert = Alert::alert_success_editar();


               // header('Location: controlador.php?action=listar_amostra');
            }


            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_amostra.php');
    }
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

function montar_select_niveis_prioridade(&$select_nivelPrioridade, $objNivelPrioridade, $objNivelPrioridadeRN, &$objAmostra) {
    /* TIPOS AMOSTRA */


    $selected = '';
    $arr_niveisPrioridade = $objNivelPrioridadeRN->listar($objNivelPrioridade);

    $select_nivelPrioridade = '<select class="form-control selectpicker" '
            . 'id="select-country idSel_niveisPrioridade" data-live-search="true" name="sel_niveisPrioridade">'
            . '<option data-tokens="" ></option>';

    foreach ($arr_niveisPrioridade as $nivel) {
        $selected = '';
        if ($nivel->getIdNivelPrioridade() == $objAmostra->getIdNivelPrioridade_fk()) {
            $selected = 'selected';
        }

        $select_nivelPrioridade .= '<option ' . $selected . '  '
                . 'value="' . Pagina::formatar_html($nivel->getIdNivelPrioridade()) .
                '" data-tokens="' . Pagina::formatar_html($nivel->getNivel()) . '">' 
                . Pagina::formatar_html($nivel->getNivel()) . '</option>';
    }
    $select_nivelPrioridade .= '</select>';
}

function montar_select_aceitaRecusada(&$select_a_r, &$objAmostra) {
    $selectedr = '';
    $selecteda = '';
    if ($objAmostra != null) {
        if ($objAmostra->getAceita_recusa() == 'r') {
            $selectedr = ' selected ';
        }
        if ($objAmostra->getAceita_recusa() == 'a') {
            $selecteda = ' selected ';
        }
    }
    $select_a_r = ' <select id="idSelAceitaRecusada" class="form-control" name="sel_aceita_recusada" onblur="">
                        <option value="">Selecione</option>
                        <option' . Pagina::formatar_html($selecteda) . ' value="a">Aceita</option>
                        <option' . Pagina::formatar_html($selectedr) . ' value="r">Recusada</option>
                    </select>';
}

function montar_select_tiposAmostra(&$select_tiposAmostra, $objTipoAmostra, $objTipoAmostraRN, &$objAmostra) {
    /* TIPOS AMOSTRA */
    $selected = '';
    $arr_tiposAmostra = $objTipoAmostraRN->listar($objTipoAmostra);

    $select_tiposAmostra = '<select class="form-control selectpicker" '
            . 'id="select-country idSel_tiposAmostra" data-live-search="true" name="sel_tipoAmostra">'
            . '<option data-tokens="" ></option>';

    foreach ($arr_tiposAmostra as $tipoAmostra) {
        $selected = '';
        if ($tipoAmostra->getIdTipoAmostra() == $objAmostra->getIdTipoAmostra_fk()) {
            $selected = 'selected';
        }

        $select_tiposAmostra .= '<option ' . $selected . 
                '  value="' . Pagina::formatar_html($tipoAmostra->getIdTipoAmostra()) .
                '" data-tokens="' . Pagina::formatar_html($tipoAmostra->getTipo()) . '">' 
                . Pagina::formatar_html($tipoAmostra->getTipo()) . '</option>';
    }
    $select_tiposAmostra .= '</select>';
}

function montar_select_estado(&$select_estados, $objEstadoOrigem, $objEstadoOrigemRN, &$objAmostra) {
    /* ESTADO */
    $selected = '';
    $arr_estados = $objEstadoOrigemRN->listar($objEstadoOrigem);

    $select_estados = '<select class="form-control selectpicker" onchange="this.form.submit()" disabled '
            . 'id="select-country idSel_estados"'
            . ' data-live-search="true" name="sel_estados">'
            . '<option data-tokens="" ></option>';

    foreach ($arr_estados as $estado) {
        $selected = '';
        if ($estado->getCod_estado() == $objAmostra->getIdEstado_fk()) {
            $selected = 'selected';
        }
        if ($estado->getSigla() == 'RS' && $objAmostra->getIdEstado_fk() == null) {
            $selected = 'selected';
        }

        $select_estados .= '<option ' . $selected . 
                '  value="' . Pagina::formatar_html($estado->getCod_estado()) . '" '
                . 'data-tokens="' . Pagina::formatar_html($estado->getSigla()) . '">'
                . Pagina::formatar_html($estado->getSigla()) . '</option>';
    }
    $select_estados .= '</select>';
}

function montar_select_cidade(&$select_municipios, $objLugarOrigem, $objLugarOrigemRN, &$objEstadoOrigem, &$objAmostra) {
    /* MUNICÍPIOS */
    $selected = '';
    $arr_municipios = $objLugarOrigemRN->listar($objLugarOrigem);

    $select_municipios = '<select class="form-control selectpicker"  '
            . 'id="select-country idSel_cidades" data-live-search="true" name="sel_cidades">'
            . '<option data-tokens="" ></option>';

    foreach ($arr_municipios as $lugarOrigem) {
        $selected = '';
        if ($lugarOrigem->getCod_estado() == 43) {
            if ($lugarOrigem->getIdLugarOrigem() == $objAmostra->getIdLugarOrigem_fk()) {
                $selected = 'selected';
            }
            $select_municipios .= '<option ' . $selected .
                    '  value="' . Pagina::formatar_html($lugarOrigem->getIdLugarOrigem()) .
                    '" data-tokens="' . Pagina::formatar_html($lugarOrigem->getNome()) . '">'
                    . Pagina::formatar_html($lugarOrigem->getNome()) . '</option>';
        }
    }
    $select_municipios .= '</select>';
}

function montar_select_perfilPaciente(&$select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, &$objPaciente, $disabled) {
    /* PERFIL DO PACIENTE */
    $selected = '';
    $arr_perfis = $objPerfilPacienteRN->listar($objPerfilPaciente);

    $select_perfis = '<select class="form-control selectpicker" onchange="this.form.submit()" id="select-country idSel_perfil"'
            . ' data-live-search="true" name="sel_perfil"' . $disabled . '>'
            . '<option data-tokens="" ></option>';

    foreach ($arr_perfis as $perfil) {
        $selected = '';
        if ($perfil->getIdPerfilPaciente() == $objPaciente->getIdPerfilPaciente_fk()) {
            $selected = 'selected';
        }

        $select_perfis .= '<option ' . $selected . 
                '  value="' . Pagina::formatar_html($perfil->getIdPerfilPaciente()) 
                . '" data-tokens="' . Pagina::formatar_html($perfil->getPerfil()) . '">'
                . Pagina::formatar_html($perfil->getPerfil()) . '</option>';
    }
    $select_perfis .= '</select>';
}

function montar_select_sexo(&$select_sexos, $objSexoPaciente, $objSexoPacienteRN, &$objPaciente) {
    /* SEXO DO PACIENTE */
    $selected = '';
    $arr_sexos = $objSexoPacienteRN->listar($objSexoPaciente);

    $select_sexos = '<select  onchange="" '
            . 'class="form-control selectpicker" '
            . 'id="select-country idSexo" data-live-search="true" '
            . 'name="sel_sexo">'
            . '<option data-tokens=""></option>';

    foreach ($arr_sexos as $sexo) {
        $selected = '';
        if ($sexo->getIdSexo() == $objPaciente->getIdSexo_fk()) {
            $selected = 'selected';
        }
        $select_sexos .= '<option ' . $selected . 
                '  value="' . Pagina::formatar_html($sexo->getIdSexo()) 
                . '" data-tokens="' . Pagina::formatar_html($sexo->getSexo()) . '">'
                . Pagina::formatar_html($sexo->getSexo()) . '</option>';
    }
    $select_sexos .= '</select>';
}
?>



<?php
Pagina::abrir_head("Cadastrar Amostra");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("amostra");
Pagina::getInstance()->adicionar_javascript("paciente");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();

echo $alert.
     Pagina::montar_topo_listar('CADASTRAR AMOSTRA', 'listar_amostra', 'LISTAR AMOSTRAS');
?>


<div class="conteudo_grande">
    <div class="formulario">
        <form method="POST">

            <div class="form-row">  
                <div class="col-md-9"><h3> Sobre o Paciente </h3></div>
                <!--<div class="col-md-4">
                    <input type="text" class="form-control" id="idUsuarioLogado" readonly style="text-align: center;margin-bottom: 10px;"
                           name="txtUsuarioLogado" required value="Identificador do usuário logado: <?= $objUsuario->getMatricula() ?>" >
                </div> -->
                <div class="col-md-3">
                    <input type="text" class="form-control" id="idDataHoraLogin" readonly style="text-align: center;"
                           name="dtHoraLoginInicio" required value="<?= $_SESSION['DATA_LOGIN'] ?>">
                </div>

            </div>           


            <div class="form-row">  

                <div class="col-md-12">
                    <label for="perfil">Perfil:</label>
                    <?= $select_perfis ?>
                </div>

            </div>
            <?php
            if (!isset($_POST['sel_perfil']) && !isset($_GET['idAmostra'])) {
                echo '<small style="color:red;"> Nenhum perfil foi selecionado</small>';
            } else {
                ?> 


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
                               onblur="validaDataNascimento()" name="dtDataNascimento"  max="<?php echo date('Y-m-d'); ?>" 
                               required value="<?= Pagina::formatar_html($objPaciente->getDataNascimento()) ?>">
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
                        <label for="label_cpf">Digite o CPF:</label>
                        <input type="text" class="form-control cep-mask" id="idCPF" placeholder="Ex.: 000.000.000-00" 
                               onblur="validaCPF()" name="txtCPF" <?= $cpf_obrigatorio ?> 
                               value="<?= Pagina::formatar_html($objPaciente->getCPF()) ?>">
                        <div id ="feedback_cpf"></div>

                    </div> 

                    <!-- RG -->
                    <div class="col-md-3 mb-3">
                        <label for="label_rg">Digite o RG:</label>
                        <input type="txt" class="form-control" id="idRG" placeholder="RG" 
                               onblur="validaRG()" name="txtRG" 
                               value="<?= Pagina::formatar_html($objPaciente->getRG()) ?>">
                        <div id ="feedback_rg"></div>
                        <div class="desaparecer_aparecer" id="id_desaparecer_aparecerObsRG" style="margin-top:25px; display: none;" >

                            <div class="form-row align-items-center" >
                                <!--<div class="col-auto my-1">
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
                                </div>-->

                                <!--<div class="col-auto ">
                                    <div class="custom-control  mb-3">
                                        <input style="height: 35px;margin-left: -25px;margin-top: -20px;" 
                                               type="text" class="form-control" id="idObsRG" placeholder="motivo"  
                                               onblur="validaObsRG()" name="txtObsRG" required value="<?= $objPaciente->getObsRG() ?>">
                                        <div id ="feedback_obsRG"></div>
                                    </div>
                                </div>-->
                            </div>
                        </div>


                    </div>

                    <!-- CÓDIGO GAL -->
                         <?PHP if ($objPerfilPaciente->getPerfil() == 'Pacientes SUS') { ?>
                        <div class="col-md-3 mb-3">
                            <label for="label_codGal">Digite o código Gal:</label>
                            <input type="text" class="form-control" id="idCodGAL" placeholder="000 0000 0000 0000" data-mask="000 0000 0000 0000"  <?= $read_only ?>
                                   onblur="validaCodGAL()" name="txtCodGAL" required 
                                   value="<?= Pagina::formatar_html($objCodigoGAL->getCodigo()) ?>">
                            <div id ="feedback_codGal"></div>

                        </div>
    <?php } ?>


                </div>  


                <h3> Sobre a Coleta </h3>
                <hr width = “2” size = “100”>
                <div class="form-row">  
                    <div class="col-md-2">

                        <label for="inputAceitaRecusada">Aceita ou recusada</label>
                    <?= $select_a_r ?>
                        <div id ="feedback_aceita_recusada"></div>
                    </div>
                    <!--<div class="col-md-2">
                        <label for="labelQuantidadeTubos">Quantidade de tubos: </label>
                        <input type="number" class="form-control" id="idQntTubos" placeholder="nº tubos" default
                               onblur="validaQntTubos()" name="numQntTubos" required value="<?= $tubos ?>">
                        <div id ="feedback_qntTubos"></div>
                    </div> -->

                    <div class="col-md-4">
                        <label for="labelDataHora">Data e Hora:</label>
                        <input type="datetime-local" class="form-control" id="idDtHrColeta" placeholder="00/00/0000 00:00:00" 
                               onblur="validaDataHoraColeta()" name="dtColeta" required 
                               value="<?= str_replace(" ", "T", $objAmostra->getDataHoraColeta()) ?>"> <!--<?= str_replace(" ", "T", $objAmostra->getDataHoraColeta()) ?>-->
                        <div id ="feedback_dataColeta"></div>

                    </div>

                    <div class="col-md-2">
                        <label for="labelEstadoColeta">Estado:</label>
    <?= $select_estados ?>
                    </div>
                    <div id ="feedback_estado"></div>

                    <div class="col-md-4">
                        <label for="labelMunicípioColeta">Município:</label>
    <?= $select_municipios ?>
                    </div>

                   <!-- <div class="col-md-2">
                        <label for="labelNivelPrioridade">Nivel de Prioridade:</label>
    <?= $select_nivelPrioridade ?>
                    </div> -->

                </div>

                <div class="form-row">
                    <div class="col-md-12">
                        <label for="observações amostra">Observações</label>
                        <textarea onblur="validaObs()" id="idTxtAreaObs" name="txtAreaObs" rows="2" cols="100" class="form-control" id="obsAmostra" rows="3"></textarea>
                        <div id ="feedback_obsAmostra"></div>
                    </div>
                </div>


                <button style="margin-top:20px;" class="btn btn-primary" type="submit" 
                        name="salvar_amostra">Salvar</button> 

<?php } ?>
        </form>
    </div> 
</div>


<?php
Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();
