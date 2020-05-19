<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
try{
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once __DIR__ . '/../../classes/Protocolo/Protocolo.php';
    require_once __DIR__ . '/../../classes/Protocolo/ProtocoloRN.php';
    require_once __DIR__ . '/../../utils/Alert.php';
    require_once __DIR__ . '/../../utils/Utils.php';

    $objUtils = new Utils();
    $objProtocolo = new Protocolo();
    $objProtocoloRN = new ProtocoloRN();
    $alert = '';
    $select_caractere = '';
    $lista_caractere = '';
    Sessao::getInstance()->validar();
    $alert .= Alert::alert_warning("O caractere inserido aqui deve ser colocado em ProtocoloRN como variável estática");

    switch($_GET['action']){

        case 'cadastrar_protocolo':
            if(isset($_POST['salvar_protocolo'])){
                $objProtocolo->setProtocolo($_POST['txtProtocolo']);
                $objProtocolo->setCaractere($_POST['txtCaractereProtocolo']);
                $objProtocolo->setNumDivisoes($_POST['numDivisoes']);
                $objProtocolo->setIndexProtocolo(strtoupper($objUtils->tirarAcentos($_POST['txtProtocolo'])));
                $objProtocolo->setNumMaxAmostras($_POST['numAmostras']);

                $objProtocolo  = $objProtocoloRN->cadastrar($objProtocolo);
                $alert.= Alert::alert_success("O protocolo -".$objProtocolo->getProtocolo()."- foi cadastrado");

            }

            $html = '<div class="col-md-3 mb-3">
                        <label >Informe o caractere:</label>
                        <input type="text" class="form-control" id="idNomeProtocolo" placeholder="caractere" 
                            onblur="" name="txtCaractereProtocolo"  value="'.Pagina::formatar_html($objProtocolo->getCaractere()).'">
                    </div>';

            $objProtocoloAux = new Protocolo();
            InterfacePagina::montar_lista_caracteres($lista_caractere,$objProtocoloRN,$objProtocoloAux,'');

            $html .= '<div class="col-md-3 "><label >Caracteres que já existem:</label>'.$lista_caractere.'</div>';



            break;

        case 'editar_protocolo':

            if(!isset($_POST['salvar_protocolo'])){ //enquanto não enviou o formulário com as alterações
                $objProtocolo->setIdProtocolo($_GET['idProtocolo']);
                $objProtocolo = $objProtocoloRN->consultar($objProtocolo);
                InterfacePagina::montar_select_caractereProtocolo($select_caractere,$objProtocoloRN,$objProtocolo,'');
            }

            if(isset($_POST['salvar_protocolo'])){ //se enviou o formulário com as alterações
                $objProtocolo->setIdProtocolo($_GET['idProtocolo']);
                $objProtocolo->setProtocolo($_POST['txtProtocolo']);
                $objProtocolo->setNumDivisoes($_POST['numDivisoes']);
                $objProtocolo->setCaractere($_POST['sel_caractereProtococolo']);
                $objProtocolo->setIndexProtocolo(strtoupper($objUtils->tirarAcentos($_POST['txtProtocolo'])));
                $objProtocolo->setNumMaxAmostras($_POST['numAmostras']);
                $objProtocoloRN->alterar($objProtocolo);
                $alert .= Alert::alert_success("O protocolo foi alterado");

                InterfacePagina::montar_select_caractereProtocolo($select_caractere,$objProtocoloRN,$objProtocolo,'');

            }

            $html = '<div class="col-md-6 mb-3">
                        <label for="label_etapa">Selecione o caractere do protocolo:</label>
                        '.$select_caractere.'
                    </div>';



            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_protocolo.php');
    }




} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Cadastrar Protocolo");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar("CADASTRAR PROTOCOLO",null,null,"listar_protocolo","LISTAR PROTOCOLOS");
Pagina::getInstance()->mostrar_excecoes();

echo $alert.'

<div class="conteudo_grande" >
<form method="POST">
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="label_nome">Digite o nome do protocolo:</label>
            <input type="text" class="form-control" id="idNomeProtocolo" placeholder="protocolo" 
                   onblur="" name="txtProtocolo"  value="'.Pagina::formatar_html($objProtocolo->getProtocolo()).'">
   

        </div>
        <div class="col-md-6 mb-3">
            <label for="label_etapa">Digite a quantidade máxima de amostras:</label>
            <input type="number" class="form-control" id="idEtapa" placeholder="nº amostras" 
                   onblur="" name="numAmostras"  value="'.Pagina::formatar_html($objProtocolo->getNumMaxAmostras()).'">
        </div>
        </div>
        
        <div class="form-row">
         <div class="col-md-6 mb-3">
            <label for="label_etapa">Informe quantas divisões vão ter na placa: Ex.:newGene[E,RdRp,Controle]</label>
            <input type="number" class="form-control" id="idEtapa" placeholder="nº divisões" 
                   onblur="" name="numDivisoes"  value="'.Pagina::formatar_html($objProtocolo->getNumDivisoes()).'">
        </div>  
        
        ';
        echo $html;

echo '</div>  
    <button class="btn btn-primary" type="submit" name="salvar_protocolo">Salvar</button>
</form>
</div>';



Pagina::getInstance()->fechar_corpo();

