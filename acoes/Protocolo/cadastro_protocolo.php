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

    require_once __DIR__ . '/../../classes/DivisaoProtocolo/DivisaoProtocolo.php';
    require_once __DIR__ . '/../../classes/DivisaoProtocolo/DivisaoProtocoloRN.php';

    require_once __DIR__ . '/../../utils/Alert.php';
    require_once __DIR__ . '/../../utils/Utils.php';

    $objUtils = new Utils();
    /* PROTOCOLO */
    $objProtocolo = new Protocolo();
    $objProtocoloRN = new ProtocoloRN();

    /* DIVISÃO PROTOCOLO */
    $objDivisaoProtocolo = new DivisaoProtocolo();
    $objDivisaoProtocoloRN = new DivisaoProtocoloRN();

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

                header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_protocolo&idProtocolo='.$objProtocolo->getIdProtocolo()));
                die();
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

            $objProtocolo->setIdProtocolo($_GET['idProtocolo']);
            if(!isset($_POST['salvar_protocolo'])){ //enquanto não enviou o formulário com as alterações
                $objProtocolo = $objProtocoloRN->consultar($objProtocolo);
                InterfacePagina::montar_select_caractereProtocolo($select_caractere,$objProtocoloRN,$objProtocolo,'');
            }
            $objDivisaoProtocolo->setIdProtocoloFk($_GET['idProtocolo']);
            $arr_divisoes =$objDivisaoProtocoloRN->listar_completo($objDivisaoProtocolo);

            if(count($arr_divisoes) > 0) {
                $inputsDivisoes = '';
                $contador = 1;
                $arr_nomes_divs = array();
                foreach ($arr_divisoes as $divisao) {

                    $inputsDivisoes .= '<div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for="label_nome">Digite o nome da divisão ' . $contador . ':</label>
                                        <input type="text" class="form-control" id="idNomeProtocolo" placeholder="divisão '.$contador.'" 
                                               onblur="" name="txtNomeDivisao' . $contador . '"  value="' . Pagina::formatar_html($divisao->getNomeDivisao()) . '">';
                    $inputsDivisoes .= '     </div>
                                </div> ';
                    if (isset($_POST['txtNomeDivisao' . $contador])) {
                        $objDivisaoProtocoloAux = new DivisaoProtocolo();
                        $objDivisaoProtocoloAux->setIdDivisaoProtocolo($divisao->getIdDivisaoProtocolo());
                        if (isset($_GET['idProtocolo'])) {
                            $objDivisaoProtocoloAux->setIdProtocoloFk($_GET['idProtocolo']);
                        }
                        $objDivisaoProtocoloAux->setNomeDivisao($_POST['txtNomeDivisao' . $contador]);
                        $arr_nomes_divs[] = $objDivisaoProtocoloAux;
                    }
                    $contador++;
                }
            }else{
                $objProtocolo->setIdProtocolo($_GET['idProtocolo']);
                $objProtocolo = $objProtocoloRN->consultar($objProtocolo);
                $inputsDivisoes = '';
                $contador = 1;
                $arr_nomes_divs = array();
                for ($i=0; $i<$objProtocolo->getNumDivisoes(); $i++) {

                    $inputsDivisoes .= '<div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for="label_nome">Digite o nome da divisão ' . $contador . ':</label>
                                        <input type="text" class="form-control" id="idNomeProtocolo" placeholder="divisão '.$contador.'" 
                                               onblur="" name="txtNomeDivisao' . $contador . '"  value="' . $_POST['txtNomeDivisao' . $contador] . '">
                                    </div>
                                </div> ';

                    if (isset($_POST['txtNomeDivisao' . $contador])) {
                        $objDivisaoProtocoloAux = new DivisaoProtocolo();

                        if (isset($_GET['idProtocolo'])) {
                            $objDivisaoProtocoloAux->setIdProtocoloFk($_GET['idProtocolo']);
                        }
                        $objDivisaoProtocoloAux->setNomeDivisao($_POST['txtNomeDivisao' . $contador]);
                        $arr_nomes_divs[] = $objDivisaoProtocoloAux;
                    }
                    $contador++;
                }
            }




            if(isset($_POST['salvar_protocolo'])){ //se enviou o formulário com as alterações

                $objProtocolo->setObjDivisao($arr_nomes_divs);
                $objProtocolo->setIdProtocolo($_GET['idProtocolo']);
                $objProtocolo->setProtocolo($_POST['txtProtocolo']);
                $objProtocolo->setNumDivisoes($_POST['numDivisoes']);
                $objProtocolo->setCaractere($_POST['sel_caractereProtococolo']);
                $objProtocolo->setIndexProtocolo(strtoupper($objUtils->tirarAcentos($_POST['txtProtocolo'])));
                $objProtocolo->setNumMaxAmostras($_POST['numAmostras']);
                $objProtocolo = $objProtocoloRN->alterar($objProtocolo);

                $alert .= Alert::alert_success("O protocolo foi alterado");

                InterfacePagina::montar_select_caractereProtocolo($select_caractere,$objProtocoloRN,$objProtocolo,'');

                $objProtocolo->setIdProtocolo($_GET['idProtocolo']);
                $objDivisaoProtocolo->setIdProtocoloFk($_GET['idProtocolo']);
                $arr_divisoes =$objDivisaoProtocoloRN->listar_completo($objDivisaoProtocolo);

                $inputsDivisoes = '';
                $contador = 1;
                $arr_nomes_divs = array();
                foreach ($arr_divisoes as $divisao) {

                    $inputsDivisoes .= '<div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for="label_nome">Digite o nome da divisão '.$contador.':</label>
                                        <input type="text" class="form-control" id="idNomeProtocolo" placeholder="protocolo" 
                                               onblur="" name="txtNomeDivisao'.$contador.'"  value="' . Pagina::formatar_html($divisao->getNomeDivisao()) . '">
                                    </div>
                                </div> ';
                    $contador++;
                }

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
        echo $html.'</div>'.$inputsDivisoes;

echo '
    <button class="btn btn-primary" type="submit" name="salvar_protocolo">Salvar</button>
</form>
</div>';





Pagina::getInstance()->fechar_corpo();

