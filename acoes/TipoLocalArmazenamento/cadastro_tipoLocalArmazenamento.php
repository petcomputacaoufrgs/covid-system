<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
try{

    session_start();
    require_once  __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once  __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once  __DIR__ . '/../../classes/Excecao/Excecao.php';

    require_once  __DIR__ . '/../../utils/Utils.php';
    require_once  __DIR__ . '/../../utils/Alert.php';


    require_once  __DIR__ . '/../../classes/TipoLocalArmazenamento/TipoLocalArmazenamento.php';
    require_once  __DIR__ . '/../../classes/TipoLocalArmazenamento/TipoLocalArmazenamentoRN.php';

    Sessao::getInstance()->validar();

    $objTipoLocalArm = new TipoLocalArmazenamento();
    $objTipoLocalArmRN = new TipoLocalArmazenamentoRN();
    $alert = '';
    $utils = new Utils();

    switch($_GET['action']){
        case 'cadastrar_tipoLocalArmazenamento':
            if(isset($_POST['salvar_tipoLocalArm'])){

                $objTipoLocalArm->setTipo($_POST['txtNomeTipoLocal']);
                $objTipoLocalArm->setCaractereTipo(strtoupper($utils->tirarAcentos($_POST['txtCaractere'])));
                $objTipoLocalArm->setIndexTipo(strtoupper($utils->tirarAcentos($_POST['txtNomeTipoLocal'])));
                $objTipoLocalArmRN->cadastrar($objTipoLocalArm);
                $alert .= Alert::alert_success("Tipo local de armazenamento CADASTRADO com sucesso");
            }else{
                $objTipoLocalArm->setIdTipoLocalArmazenamento('');
                $objTipoLocalArm->setTipo('');
            }
        break;
        
        case 'editar_tipoLocalArmazenamento':

            if(!isset($_POST['salvar_tipoLocalArm'])){ //enquanto não enviou o formulário com as alterações
                $objTipoLocalArm->setIdTipoLocalArmazenamento($_GET['idTipoLocalArmazenamento']);
                $objTipoLocalArm = $objTipoLocalArmRN->consultar($objTipoLocalArm);
            }
            
             if(isset($_POST['salvar_tipoLocalArm'])){ //se enviou o formulário com as alterações
                 $objTipoLocalArm->setTipo($_POST['txtNomeTipoLocal']);
                 $objTipoLocalArm->setCaractereTipo(strtoupper($utils->tirarAcentos($_POST['txtCaractere'])));
                 $objTipoLocalArm->setIndexTipo(strtoupper($utils->tirarAcentos($_POST['txtNomeTipoLocal'])));
                 $objTipoLocalArmRN->alterar($objTipoLocalArm);
                 $alert .= Alert::alert_success("Tipo local de armazenamento ALTERADO com sucesso");
            }
            
            
            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_tipoLocalArmazenamento.php');  
    }
   
} catch (Throwable $ex) {
    //DIE($ex);
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::abrir_head("Cadastrar Tipo de local de armazenamento");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("tipoLocalArmazenamento");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('CADASTRAR TIPO LOCAL ARMAZENAMENTO',null,null, 'listar_tipoLocalArmazenamento', 'LISTAR TIPO LOCAL ARMAZENAMENTO');
Pagina::getInstance()->mostrar_excecoes();
echo $alert;


echo '<div class="conteudo_grande">
<form method="POST">
    <div class="form-row">
        <div class="col-md-5 mb-3">
            <label for="label_tipoLocalArm">Digite nome do local de armazenamento</label>
            <input type="text" class="form-control" id="idNomeTipoLA" placeholder="nome" 
                   onblur="validaNomeTipoLocalArmazenamento()" name="txtNomeTipoLocal"  value="'.$objTipoLocalArm->getTipo().'">
            <div id ="feedback_nomeLocal"></div>

        </div>
        
        <div class="col-md-5 mb-3">
            <label for="label_tipoLocalArm">Digite o 1º caractere (Banco de amostras -> B)</label>
            <input type="text" class="form-control" id="idCaractereLA" placeholder="caractere" 
                   onblur="" name="txtCaractere"  value="'.$objTipoLocalArm->getCaractereTipo().'">
            

        </div>
        
      
        <div class="col-md-2 mb-3">
            <button class="btn btn-primary" style="margin-top: 33px;margin-left: 0px;" type="submit" name="salvar_tipoLocalArm">Salvar</button>
        </div>
    </div>  
</form>
</div>';


Pagina::getInstance()->fechar_corpo();

