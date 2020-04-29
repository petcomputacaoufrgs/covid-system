<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
try{
    require_once  __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once  __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once  __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once  __DIR__ . '/../../classes/Pagina/InterfacePagina.php';
    require_once  __DIR__ . '/../../classes/Capela/Capela.php';
    require_once  __DIR__ . '/../../classes/Capela/CapelaRN.php';

    require_once __DIR__ . '/../../classes/PreparoLote/PreparoLote.php';
    require_once __DIR__ . '/../../classes/PreparoLote/PreparoLoteRN.php';

    require_once __DIR__ . '/../../classes/Lote/Lote.php';
    require_once __DIR__ . '/../../classes/Lote/LoteRN.php';

    require_once  __DIR__ . '/../../utils/Utils.php';
    require_once  __DIR__ . '/../../utils/Alert.php';

    Sessao::getInstance()->validar();
    $utils = new Utils();

    $objCapela = new Capela();
    $objCapelaRN = new CapelaRN();

    /*
    * Objeto PreparoLote
    */
    $objPreparoLote = new PreparoLote();
    $objPreparoLoteRN = new PreparoLoteRN();


    /*
     * Objeto  lote
     */
    $objLote = new Lote();
    $objLoteRN = new LoteRN();

    $alert = '';
    $readonly = ' ';
    $select_situacao = '';
    $select_nivelSeguranca = '';

    InterfacePagina::montar_select_situacao_capela($select_situacao,$objCapela,'');
    InterfacePagina::montar_select_nivelSeguranca_capela($select_nivelSeguranca,$objCapela,'');
    switch($_GET['action']){

        case 'cadastrar_capela':


            $readonly = ' readonly ';
            $objCapela->setSituacaoCapela(CapelaRN::$TE_LIBERADA);
            
            if(isset($_POST['salvar_capela'])){
                
                $objCapela->setNumero($_POST['numCapela']);
                $objCapela->setSituacaoCapela(CapelaRN::$TE_LIBERADA);
                if($_POST['sel_nivelSegurancaCapela'] != -1)$objCapela->setNivelSeguranca($_POST['sel_nivelSegurancaCapela']);
                InterfacePagina::montar_select_situacao_capela($select_situacao,$objCapela,'');

                if(empty($objCapelaRN->validar_Cadastro($objCapela))){
                    $objCapelaRN->cadastrar($objCapela);
                    $alert= Alert::alert_success("Capela CADASTRADA com sucesso");
                }else{$alert= Alert::alert_danger("Capela NÃO cadastrada");}
                InterfacePagina::montar_select_situacao_capela($select_situacao,$objCapela,'');
                InterfacePagina::montar_select_nivelSeguranca_capela($select_nivelSeguranca,$objCapela,'');
                
            }else{
                $objCapela->setIdCapela('');
                $objCapela->setNumero('');
                $objCapela->setNivelSeguranca('');
                
            }
        break;
        
        case 'editar_capela':
            if(!isset($_POST['salvar_capela'])){ //enquanto não enviou o formulário com as alterações
                $objCapela->setIdCapela($_GET['idCapela']);
                $objCapela = $objCapelaRN->consultar($objCapela);
                InterfacePagina::montar_select_situacao_capela($select_situacao,$objCapela,'');

                $objPreparoLote = new PreparoLote();
                $objPreparoLoteRN = new PreparoLoteRN();
                $objPreparoLote->setIdCapelaFk($_GET['idCapela']);
                $arr_preparos = $objPreparoLoteRN->listar($objPreparoLote);

                if(count($arr_preparos) > 0) {
                    foreach ($arr_preparos as $preparo) {
                        $objLote = new Lote();
                        $objLoteRN = new LoteRN();

                        $objLote->setIdLote($preparo->getIdLoteFk());
                        $objLote = $objLoteRN->consultar($objLote);

                        if ($objLote->getSituacaoLote() == LoteRN::$TE_AGUARDANDO_PREPARACAO || $objLote->getSituacaoLote() == LoteRN::$TE_AGUARDANDO_EXTRACAO) {
                            $alert .= Alert::alert_warning("A capela está ocupada em algum nível do processo, não é possível editar sua situação");
                            InterfacePagina::montar_select_situacao_capela($select_situacao,$objCapela, ' disabled ');
                        }
                    }
                }



            }


             if(isset($_POST['salvar_capela'])){ //se enviou o formulário com as alterações

                 if(isset($_POST['sel_situacaoCapela'])) {
                     $objCapela->setSituacaoCapela($_POST['sel_situacaoCapela']);
                     InterfacePagina::montar_select_situacao_capela($select_situacao,$objCapela);
                 }

                $objCapela->setIdCapela($_GET['idCapela']);
                $objCapela->setNumero($_POST['numCapela']);
                $objCapela->setNivelSeguranca($_POST['sel_nivelSegurancaCapela']);

                $objCapelaRN->alterar($objCapela);
                $alert= Alert::alert_success("A capela foi ALTERADA");

            }

            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_capela.php');  
    }
   
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Cadastrar Capela");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("capela");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('CADASTRAR CAPELA', null,null,'listar_capela', 'LISTAR CAPELAS');
Pagina::getInstance()->mostrar_excecoes();

echo $alert.
     '<div class="conteudo_grande">
        <form method="POST">
            
            <div class="form-row">
                <div class="col-md-2 mb-3">
                    <label for="label_capela">Número da capela:</label>
                    <input type="number" class="form-control" id="idNumeroCapela" placeholder="Nº capela" 
                           onblur="" name="numCapela" required value="'. Pagina::formatar_html($objCapela->getNumero()).'">
                    <div id ="feedback_capela"></div>

                </div>
                <div class="col-md-6 mb-3">
                    <label for="label_capela"> Situação da capela: </label>'.
                    $select_situacao.'
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="label_capela">Nível de Segurança </label>'.
                     $select_nivelSeguranca.'
                </div>
            </div>  
            <button class="btn btn-primary" type="submit" name="salvar_capela">Salvar</button>
        </form>
    </div>';
               


Pagina::getInstance()->fechar_corpo(); 



