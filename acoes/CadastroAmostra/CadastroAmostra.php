
<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */


session_start();

require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Pagina/Interf.php';
require_once '../classes/Excecao/Excecao.php';

require_once '../classes/Usuario/Usuario.php';
require_once '../classes/Usuario/UsuarioRN.php';

require_once '../classes/Paciente/Paciente.php';
require_once '../classes/Paciente/PacienteRN.php';


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

require_once '../classes/CadastroAmostra/CadastroAmostra.php';
require_once '../classes/CadastroAmostra/CadastroAmostraRN.php';

require_once '../utils/Utils.php';
require_once '../utils/Alert.php';

require_once '../classes/Etnia/Etnia.php';
require_once '../classes/Etnia/EtniaRN.php';
/*require_once '../classes/PerfilPaciente/PerfilPaciente.php';
require_once '../classes/PerfilPaciente/PerfilPacienteRN.php';*/
try {
    Sessao::getInstance()->validar();
    $utils = new Utils();

    date_default_timezone_set('America/Sao_Paulo');
    $_SESSION['DATA_LOGIN'] = date("Y-m-d H:i:s");



    $objUsuario = new Usuario();
    $objUsuario->setMatricula(Sessao::getInstance()->getMatricula());
    $objUsuarioRN = new UsuarioRN();

    /* AMOSTRA */
    $objAmostra = new Amostra();
    $objAmostraRN = new AmostraRN();

    /* CÓDIGO GAL */
    $objCodigoGAL = new CodigoGAL();
    $objCodigoGAL_RN = new CodigoGAL_RN();

    /* ETNIA */
    $objEtnia = new Etnia();
    $objEtniaRN = new EtniaRN();


    /* PACIENTE */
    $objPaciente = new Paciente();
    $objPacienteRN = new PacienteRN();

    /* PERFIL PACIENTE 
    $objPerfilPaciente = new PerfilPaciente();
    $objPerfilPacienteRN = new PerfilPacienteRN();
     * 
     */

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


    /* CADASTRO AMOSTRA */
    $objCadastroAmostra = new CadastroAmostra();
    $objCadastroAmostraRN = new CadastroAmostraRN();



    $alert = '';
    $select_sexos = '';
    $select_estados = '';
    $select_municipios = '';
    $select_etnias = '';
    $select_nivelPrioridade = '';
    $select_perfis = '';
    $select_a_r_g = '';
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $disabled = '';
    $read_only = '';
    $cpf_obrigatorio = '';

    Interf::getInstance()->montar_select_etnias($select_etnias, $objEtnia, $objEtniaRN, $objPaciente);
    Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente);
    Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objPaciente, $disabled);
    Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra); //por default RS
    Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra);
    Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra);
    Interf::getInstance()->montar_select_niveis_prioridade($select_nivelPrioridade, $objNivelPrioridade, $objNivelPrioridadeRN, $objAmostra);




    if (isset($_POST['txtCPF'])) {
        ECHO "cpf";
    } 


    switch ($_GET['action']) {
        case 'cadastrar_amostra':

            $_SESSION['DATA_SAIDA'] = date("Y-m-d H:i:s");
            $disabled = '';
            /*if (isset($_POST['sel_perfil'])) {
                $objPerfilPaciente->setIdPerfilPaciente($_POST['sel_perfil']);
                $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
                $objPaciente->setIdPerfilPaciente_fk($objPerfilPaciente->getIdPerfilPaciente());
                Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objPaciente, $disabled);
            }*/


            if (isset($_POST['salvar_amostra'])) {



                $objPaciente->setCPF($_POST['txtCPF']);
                //$objPaciente->setIdPerfilPaciente_fk($objPerfilPaciente->getIdPerfilPaciente());
                $objPaciente->setNome($_POST['txtNome']);
                $objPaciente->setDataNascimento($_POST['dtDataNascimento']);


                //RG
                if (isset($_POST['txtRG'])) {
                    $objPaciente->setRG($_POST['txtRG']);
                }
                /* if (isset($_POST['txtObsRG'])) {
                  $objPaciente->setObsRG($_POST['txtObsRG']);
                  }
                  if (!isset($_POST['txtRG']) && $_POST['txtRG'] = null && !isset($_POST['txtObsRG']) && $_POST['txtObsRG'] == null) {
                  $objPaciente->setObsRG('Desconhecido');
                  } */

                //SEXO
                if (isset($_POST['sel_sexo'])) {
                    $objPaciente->setIdSexo_fk($_POST['sel_sexo']);
                }
                if ($_POST['sel_sexo'] == 0) {
                    $objPaciente->setObsSexo('Desconhecido');
                }
                //NOME MÃƒE
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
                } else {
                    $objPaciente->setIdPaciente($arr[0]->getIdPaciente());
                }



                if (isset($_POST['txtCodGAL'])) {

                    $objCodigoGAL->setCodigo($_POST['txtCodGAL']);

                    $objCodigoGAL->setIdPaciente_fk($objPaciente->getIdPaciente());

                    $objCodigoGAL_RN->cadastrar($objCodigoGAL);
                    $objAmostra->setIdCodGAL_fk($objCodigoGAL->getIdCodigoGAL());
                }



                //Parte da coleta
                $objAmostra->setIdPaciente_fk($objPaciente->getIdPaciente());
                $objAmostra->setDataHoraColeta($_POST['dtColeta']);
                $objAmostra->setAceita_recusa($_POST['sel_aceita_recusada']);


                if ($_POST['sel_aceita_recusada'] == 'a') {
                    $objAmostra->setStatusAmostra('Aguardando PreparaÃ§Ã£o');
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
                    $objCadastroAmostra->setIdAmostra_fk($objAmostra->getIdAmostra());
                    $objCadastroAmostra->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                    $objCadastroAmostra->setDataHoraInicio($_POST['dtHoraLoginInicio']);
                    $objCadastroAmostra->setDataHoraFim($_SESSION['DATA_SAIDA']);
                    $objCadastroAmostraRN->cadastrar($objCadastroAmostra);
                } else {
                    $objAmostra = $arr_amostra;
                }

                Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra);
                Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra); //por default RS
                Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra);

                $alert = Alert::alert_success_cadastrar();
            } else {
                $objPaciente->setIdPaciente('');
                $objPaciente->setCPF('');
                $objPaciente->setDataNascimento('');
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
            if (!isset($_POST['salvar_amostra'])) { //enquanto nÃ£o enviou o formulÃ¡rio com as alteraÃ§Ãµes
                $objAmostra->setIdAmostra($_GET['idAmostra']);
                $objAmostra = $objAmostraRN->consultar($objAmostra);
                Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra);

                $objPaciente->setIdPaciente($objAmostra->getIdPaciente_fk());
                $objPaciente = $objPacienteRN->consultar($objPaciente);

                if ($objPaciente->getRG() == null) {
                    $objPaciente->setRG('');
                }

                if ($objPaciente->getIdSexo_fk() != 0) {
                    $objSexoPaciente->setIdSexo($objPaciente->getIdSexo_fk());
                    $objSexoPaciente = $objSexoPacienteRN->consultar($objSexoPaciente);
                    Interf::getInstance()->montar_select_sexo($select_sexos, $objSexoPaciente, $objSexoPacienteRN, $objPaciente);
                }

                //$objPerfilPaciente->setIdPerfilPaciente($objPaciente->getIdPerfilPaciente_fk());
                $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
                Interf::getInstance()->montar_select_perfilPaciente($select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $objPaciente, $disabled);

                if ($objAmostra->getIdCodGAL_fk() != null) {
                    $objCodigoGAL->setIdCodigoGAL($objAmostra->getIdCodGAL_fk());
                    $objCodigoGAL->setIdPaciente_fk($objPaciente->setIdPaciente());
                    $objCodigoGAL = $objCodigoGAL_RN->consultar($objCodigoGAL);
                }

                $objEstadoOrigem->setCod_estado($objAmostra->getIdEstado_fk());
                $objEstadoOrigem = $objEstadoOrigemRN->consultar($objEstadoOrigem);
                Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra); //por default RS

                $objLugarOrigem->setIdLugarOrigem($objAmostra->getIdLugarOrigem_fk());
                $objLugarOrigemRN->consultar($objLugarOrigem);
                Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra);
            }

            if (isset($_POST['salvar_amostra'])) {

                //Parte da coleta
                $objAmostra->setIdAmostra($_GET['idAmostra']);

                $objAmostra = $objAmostraRN->consultar($objAmostra);
                $objAmostra->setDataHoraColeta($_POST['dtColeta']);
                $objAmostra->setAceita_recusa($_POST['sel_aceita_recusada']);
                if ($_POST['sel_aceita_recusada'] == 'a') {
                    $objAmostra->setStatusAmostra('Aguardando PreparaÃ§Ã£o');
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

                $objPaciente->setIdPaciente($objAmostra->getIdPaciente_fk());
                $objPaciente = $objPacienteRN->consultar($objPaciente);
                $objPaciente->setCPF($_POST['txtCPF']);
                $objPaciente->setNome($_POST['txtNome']);
                $objPaciente->setDataNascimento($_POST['dtDataNascimento']);


                //RG
                if (isset($_POST['txtRG'])) {
                    //echo $_POST['txtRG'];
                    $objPaciente->setRG($_POST['txtRG']);
                    $objPaciente->setObsRG('');
                } else if (isset($_POST['txtObsRG'])) {
                    $objPaciente->setObsRG($_POST['txtObsRG']);
                } else if (!isset($_POST['txtRG']) && $_POST['txtRG'] = null && !isset($_POST['txtObsRG']) && $_POST['txtObsRG'] == null) {
                    //echo "aqui";
                    $objPaciente->setObsRG('Desconhecido');
                }

                //SEXO
                if (isset($_POST['sel_sexo'])) {
                    $objPaciente->setIdSexo_fk($_POST['sel_sexo']);
                } else if ($_POST['sel_sexo'] == 0) {
                    $objPaciente->setObsSexo('Desconhecido');
                }

                //NOME MÃƒE
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

                Interf::getInstance()->montar_select_aceitaRecusadaAguarda($select_a_r_g, $objAmostra);
                Interf::getInstance()->montar_select_estado($select_estados, $objEstadoOrigem, $objEstadoOrigemRN, $objAmostra); //por default RS
                Interf::getInstance()->montar_select_cidade($select_municipios, $objLugarOrigem, $objLugarOrigemRN, $objEstadoOrigem, $objAmostra);
                $alert = Alert::alert_success_editar();


                // header('Location: controlador.php?action=listar_amostra');
            }

            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em CadastroAmostra.php');
    }
} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Cadastrar Amostra");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("amostra");
Pagina::getInstance()->adicionar_javascript("paciente");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
//			DIE("INT80");
echo $alert .
 Pagina::montar_topo_listar('CADASTRAR AMOSTRA', 'listar_amostra', 'LISTAR AMOSTRAS');
?>

<div class="conteudo_grande">
    <div class="formulario">
        <form method="POST">
            <!-- CPF -->
                <div class="col-md-3 mb-4">
                    <label for="label_cpf">Digite o CPF:</label>
                    <input type="text" class="form-control cep-mask" id="idCPF" placeholder="Ex.: 000.000.000-00" 
                           onblur="validaCPF()" name="txtCPF" <?= $cpf_obrigatorio ?> 
                           value="<?= Pagina::formatar_html($objPaciente->getCPF()) ?>">
                    <div id ="feedback_cpf"></div>
                    

                </div> 
             <button style="margin-top:20px;" class="btn btn-primary" type="submit" 
                        name="salvar_amostra">Salvar</button> 
        </form>
    </div>
</div>





            <?php
            Pagina::getInstance()->mostrar_excecoes();
            Pagina::getInstance()->fechar_corpo();
            