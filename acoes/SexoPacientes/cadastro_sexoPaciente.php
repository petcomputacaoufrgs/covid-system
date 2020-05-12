<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
try{
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once __DIR__ . '/../../classes/Sexo/Sexo.php';
    require_once __DIR__ . '/../../classes/Sexo/SexoRN.php';
    require_once __DIR__ . '/../../utils/Utils.php';
    require_once __DIR__ . '/../../utils/Alert.php';

    Sessao::getInstance()->validar();

    $utils = new Utils();
    $objSexo = new Sexo();
    $objSexoRN = new SexoRN();
    $alert = "";

    switch ($_GET['action']) {
        case 'cadastrar_sexoPaciente':
            if (isset($_POST['salvar_sexoPaciente'])) {

                $objSexo->setSexo($_POST['txtSexo']);
                $objSexo->setIndex_sexo(strtoupper($utils->tirarAcentos($_POST['txtSexo'])));
                $objSexoRN->cadastrar($objSexo);
                $alert .= Alert::alert_success("Sexo do paciente CADASTRADO com sucesso");

            } else {
                $objSexo->setIdSexo('');
                $objSexo->setSexo('');
                $objSexo->setIndex_sexo('');
            }
            break;

        case 'editar_sexoPaciente':
            if (!isset($_POST['salvar_sexoPaciente'])) { //enquanto não enviou o formulário com as alterações
                $objSexo->setIdSexo($_GET['idSexoPaciente']);
                $objSexo = $objSexoRN->consultar($objSexo);
            }

            if (isset($_POST['salvar_sexoPaciente'])) { //se enviou o formulário com as alterações
                $objSexo->setIdSexo($_GET['idSexoPaciente']);
                $objSexo->setSexo($_POST['txtSexo']);
                $objSexo->setIndex_sexo(strtoupper($utils->tirarAcentos($_POST['txtSexo'])));
                $objSexoRN->alterar($objSexo);
                $alert .= Alert::alert_success("Sexo do paciente ALTERADO com sucesso");

            }


            break;
        default : die('Ação [' . $_GET['action'] . '] não reconhecida pelo controlador em cadastro_sexoPaciente.php');
    }
} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Cadastrar Sexo do paciente");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("sexoPaciente");
Pagina::fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar("CADASTRO SEXO PACIENTE", "cadastrar_sexoPaciente", "NOVO SEXO", "listar_sexoPaciente", "LISTAR SEXO PACIENTES");
Pagina::getInstance()->mostrar_excecoes();
echo $alert.'

<div class="conteudo" style="margin-top: -50px;">
    <div class="formulario">
        <form method="POST">
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="label_sexoPaciente">Digite o sexo do paciente:</label>
                    <input type="text" class="form-control" id="idSexoPaciente" placeholder="Sexo do paciente" 
                           onblur="validaSexoPaciente()" name="txtSexo" required value="'.Pagina::formatar_html($objSexo->getSexo()).'">
                    <div id ="feedback_sexoPaciente"></div>

                </div>
            </div>  
            <button class="btn btn-primary" type="submit" name="salvar_sexoPaciente">Salvar</button>
        </form>
    </div>  
</div>';

Pagina::fechar_corpo();

