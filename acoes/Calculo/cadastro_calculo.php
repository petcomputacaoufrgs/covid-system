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

    require_once  __DIR__ . '/../../utils/Utils.php';
    require_once  __DIR__ . '/../../utils/Alert.php';

    Sessao::getInstance()->validar();
    $utils = new Utils();


    $objCalculo = new Calculo();
    $objCalculoRN = new CalculoRN();

    $objProtocolo = new Protocolo();
    $objProtocoloRN = new ProtocoloRN();

    $alert = '';

    $select_protocolo = '';
    switch($_GET['action']){
        case 'cadastrar_calculo':

            if(isset($_POST['btn_salvar_calculo'])){
                $objCalculo->setIdProtocoloFk($_POST['sel_protocolos']);
                $objCalculo->setNome($_POST['txtCalculo']);
                $objCalculoRN->cadastrar($objCalculo);
                $objProtocolo->setIdProtocolo($objCalculo->getIdProtocoloFk());
                $alert  = Alert::alert_success("O cálculo -".$objCalculo->getNome()."- foi cadastrado com sucesso");
           }
            break;

        case 'editar_calculo':

            $objCalculo->setIdCalculo($_GET['idCalculo']);
            $objCalculo = $objCalculoRN->consultar($objCalculo);

            $objProtocolo->setIdProtocolo($objCalculo->getIdProtocoloFk());
            ProtocoloINT::montar_select_protocolo($select_protocolo, $objProtocolo,null,null);

            if(isset($_POST['btn_salvar_calculo'])){
                $objCalculo->setIdProtocoloFk($_POST['sel_tipos_protocolos']);
                $objCalculo->setNome($_POST['txtCalculo']);
                $objCalculoRN->alterar($objCalculo);
                $alert  = Alert::alert_success("O cálculo -".$objCalculo->getNome()."- foi cadastrado com sucesso");
            }
            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_calculo.php');
    }

    ProtocoloINT::montar_select_id_protocolo($select_protocolo, $objProtocolo,$objProtocoloRN,null,null);

} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Cadastrar Cálculo");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('CADASTRAR CÁLCULO', null,null,'listar_calculo', 'LISTAR CÁLCULO');
Pagina::getInstance()->mostrar_excecoes();

echo $alert.
    '<div class="conteudo_grande">
        <form method="POST">
            
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="label_capela"> Selecione o protocolo: </label>'.
                        $select_protocolo.'
                </div>
                <div class="col-md-6 mb-3">
                    <label for="label_capela">Nome do cálculo:</label>
                    <input type="text" class="form-control" placeholder="cálculo" 
                           name="txtCalculo" required value="'. Pagina::formatar_html($objCalculo->getNome()).'">
                </div>
            </div>  
            <button class="btn btn-primary" type="submit" name="btn_salvar_calculo">SALVAR</button>
        </form>
    </div>';



Pagina::getInstance()->fechar_corpo();



