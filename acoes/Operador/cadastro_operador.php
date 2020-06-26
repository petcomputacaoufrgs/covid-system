<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
try{
    require_once  __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once  __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once  __DIR__ . '/../../classes/Excecao/Excecao.php';

    require_once  __DIR__ . '/../../classes/Calculo/Calculo.php';
    require_once  __DIR__ . '/../../classes/Calculo/CalculoRN.php';
    require_once  __DIR__ . '/../../classes/Calculo/CalculoINT.php';

    require_once  __DIR__ . '/../../classes/Protocolo/Protocolo.php';
    require_once  __DIR__ . '/../../classes/Protocolo/ProtocoloRN.php';
    require_once  __DIR__ . '/../../classes/Protocolo/ProtocoloINT.php';

    require_once __DIR__ . '/../../classes/Operador/Operador.php';
    require_once __DIR__ . '/../../classes/Operador/OperadorRN.php';

    require_once  __DIR__ . '/../../utils/Utils.php';
    require_once  __DIR__ . '/../../utils/Alert.php';

    Sessao::getInstance()->validar();
    $utils = new Utils();

    $objOperador = new Operador();
    $objOperadorRN = new OperadorRN();

    $objCalculo = new Calculo();
    $objCalculoRN = new CalculoRN();

    $objProtocolo = new Protocolo();
    $objProtocoloRN = new ProtocoloRN();


    $select_calculo = '';
    $alert = '';


    switch($_GET['action']){
        case 'cadastrar_operador':
            if(isset($_POST['btn_salvar_operador'])) {
                $objOperador->setNome($_POST['txtNomeOperador']);
                $objOperador->setValor($_POST['txtValorOperador']);
                $objOperador->setIdCalculoFk($_POST['sel_calculo']);
                $objOperador = $objOperadorRN->cadastrar($objOperador);
                $objCalculo->setIdCalculo($_POST['sel_calculo']);
                $alert = Alert::alert_success("O operador -" . $objOperador->getNome() . "- foi cadastrado com sucesso");
            }
            break;

        case 'editar_operador':

            $objOperador->setIdOperador($_GET['idOperador']);
            $objOperador = $objOperadorRN->consultar($objOperador);
            $objCalculo->setIdCalculo($objOperador->getIdCalculoFk());
            CalculoINT::montar_select_calculo($select_calculo, $objCalculo, $objCalculoRN,null,null);

            if(isset($_POST['btn_salvar_operador'])) {
                $objOperador->setNome($_POST['txtNomeOperador']);
                $objOperador->setValor($_POST['txtValorOperador']);
                $objOperador->setIdCalculoFk($_POST['sel_calculo']);
                $objOperador = $objOperadorRN->alterar($objOperador);
                $alert = Alert::alert_success("O operador -" . $objOperador->getNome() . "- foi alterado com sucesso");
            }

            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_operador.php');
    }

    CalculoINT::montar_select_calculo($select_calculo, $objCalculo, $objCalculoRN,null,null);
} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Cadastrar Operador");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('CADASTRAR OPERADOR', null,null,'listar_operador', 'LISTAR OPERADOR');
Pagina::getInstance()->mostrar_excecoes();

echo $alert.
    '<div class="conteudo_grande">
        <form method="POST">
            
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="label_capela"> Selecione o cálculo: </label>'.
                        $select_calculo.'
                </div>
             </div>
             <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="label_capela">Nome do operador :</label>
                    <input type="text" class="form-control" placeholder="nome" 
                           name="txtNomeOperador" required value="'. Pagina::formatar_html($objOperador->getNome()).'">
                </div>
                 <div class="col-md-6 mb-3">
                    <label for="label_capela">Valor do operador :</label>
                    <input type="text" class="form-control" placeholder="valor" 
                           name="txtValorOperador" required value="'. Pagina::formatar_html($objOperador->getValor()).'">
                </div>
            </div>  
            <button class="btn btn-primary" type="submit" name="btn_salvar_operador">SALVAR</button>
        </form>
    </div>';

Pagina::getInstance()->fechar_corpo();



