<?php

session_start();

try {
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';

    require_once __DIR__ . '/../../classes/LocalArmazenamento/LocalArmazenamento.php';
    require_once __DIR__ . '/../../classes/LocalArmazenamento/LocalArmazenamentoRN.php';

    require_once __DIR__ . '/../../classes/TipoLocalArmazenamento/TipoLocalArmazenamento.php';
    require_once __DIR__ . '/../../classes/TipoLocalArmazenamento/TipoLocalArmazenamentoRN.php';

    require_once __DIR__ . '/../../classes/Porta/Porta.php';
    require_once __DIR__ . '/../../classes/Porta/PortaRN.php';

    require_once __DIR__ . '/../../classes/Prateleira/Prateleira.php';
    require_once __DIR__ . '/../../classes/Prateleira/PrateleiraRN.php';

    require_once __DIR__ . '/../../classes/Coluna/Coluna.php';
    require_once __DIR__ . '/../../classes/Coluna/ColunaRN.php';

    require_once __DIR__ . '/../../classes/Caixa/Caixa.php';
    require_once __DIR__ . '/../../classes/Caixa/CaixaRN.php';

    require_once __DIR__ . '/../../classes/Posicao/Posicao.php';
    require_once __DIR__ . '/../../classes/Posicao/PosicaoRN.php';


    Sessao::getInstance()->validar();
    $numero_portas = 0;

    /*
     *  LOCAL DE ARMAZENAMENTO
     */
    $objLocalArmazenamento = new LocalArmazenamento();
    $objLocalArmazenamentoRN = new LocalArmazenamentoRN();

    /*
     *  TIPO LOCAL DE ARMAZENAMENTO
     */
    $objTipoLA = new TipoLocalArmazenamento();
    $objTipoLRN = new TipoLocalArmazenamentoRN();

    /*
     *  PORTA
     */
    $objPorta = new Porta();
    $objPortaRN = new PortaRN();



    /*
     *  PRATELEIRA
     */
    $objPrateleira = new Prateleira();
    $objPrateleiraRN = new PrateleiraRN();

    /*
     *  COLUNA
     */
    $objColuna = new Coluna();
    $objColunaRN = new ColunaRN();

    /*
     *  CAIXA
     */
    $objCaixa = new Caixa();
    $objCaixaRN = new CaixaRN();

    /*
      *  POSIÇÃO
      */
    $objPosicao = new Posicao();
    $objPosicaoRN = new PosicaoRN();

    $alert = '';

    $select_tipoLocal = '';

    InterfacePagina::montar_select_tipoLocalArmazenamento($select_tipoLocal,$objTipoLRN,$objTipoLA,$objLocalArmazenamento, $disabled, $onchange);

    switch($_GET['action']){
        case 'cadastrar_localArmazenamento':

            if(isset($_POST['salvar_localArmazenamento'])){

                if(isset($_POST['sel_tipoLocalArmazenamento'])){
                    $objLocalArmazenamento->setIdTipoLocalArmazenamento_fk($_POST['sel_tipoLocalArmazenamento']);
                }

                $objLocalArmazenamento->setNome($_POST['nomeLocal']);
                $objLocalArmazenamento->setQntPortas($_POST['numPortas']);
                $objLocalArmazenamento->setQntPrateleiras($_POST['numPrateleiras']);
                $objLocalArmazenamento->setQntColunas($_POST['numColunas']);
                $objLocalArmazenamento->setQntCaixas($_POST['numCaixas']);
                $objLocalArmazenamento->setQntLinhasCaixa($_POST['numLinhasCaixa']);
                $objLocalArmazenamento->setQntColunasCaixa($_POST['numColunasCaixa']);

                $objLocalArmazenamentoRN->cadastrar($objLocalArmazenamento);
                InterfacePagina::montar_select_tipoLocalArmazenamento($select_tipoLocal,$objTipoLRN,$objTipoLA,$objLocalArmazenamento, $disabled, $onchange);
                $alert .=Alert::alert_success("Os dados foram CADASTRADOS com sucesso");

            }

            break;

        case 'editar_localArmazenamento':
            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_localArmazenamento.php');
    }






} catch (Throwable $ex) {
    DIE($ex);
    Pagina::getInstance()->mostrar_excecoes($ex);
}


Pagina::abrir_head("Montar grupo");
Pagina::getInstance()->adicionar_css("precadastros");
if($cadastrar_novo  == 's') {
    Pagina::getInstance()->adicionar_javascript("popUp");
}

Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();


echo $alert.'<div class="conteudo_grande">
        <form method="POST">
            
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="label_numPortas">Informe tipo do local de armazenamento </label>
                    '.$select_tipoLocal.'                    
                </div>
                <div class="col-md-6 mb-3">
                    <label for="label_numPortas">Informe o nome do local</label>
                    <input type="text" class="form-control" id="idNomeLocal" placeholder="nome" 
                           onblur="" name="nomeLocal" value="'.$objLocalArmazenamento->getNome().'">
                </div> 
            </div>
            <div class="form-row">
            <div class="col-md-4 mb-3">
                     <label for="label_numPortas">Informe o número de <strong> portas </strong> </label>
                     <input type="number" class="form-control" id="idNumPortas" placeholder="quantidade de portas" 
                                   onblur="" name="numPortas" value="'.$objLocalArmazenamento->getQntPortas().'">
               </div>
               <div class="col-md-4 mb-3">
                    <label for="label_numPortas">Informe a quantidade de <strong> prateleiras  </strong> por porta</label>
                    <input type="number" class="form-control" id="idNumPrateleiras" placeholder="quantidade de prateleiras"
                           onblur="" name="numPrateleiras" value="'.$objLocalArmazenamento->getQntPrateleiras().'">
                </div>
                <div class="col-md-4 mb-3">
                     <label for="label_numPortas">Informe o número de <strong> colunas  </strong>por prateleira</label>
                     <input type="number" class="form-control" id="idNumPortas" placeholder="quantidade de colunas" 
                                   onblur="" name="numColunas" value="'.$objLocalArmazenamento->getQntColunas().'">
               </div>
            </div>
            <div class="form-row">
               <div class="col-md-4 mb-3">
                    <label for="label_numPortas">Informe a quantidade de <strong> caixas </strong> por coluna </label>
                    <input type="number" class="form-control" id="idNumPrateleiras" placeholder="quantidade de caixas"
                           onblur="" name="numCaixas" value="' . $objLocalArmazenamento->getQntCaixas() . '">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="label_numPortas">Informe o número de <strong> linhas </strong> por caixa </label>
                    <input type="number" class="form-control" id="idNumPrateleiras" placeholder="quantidade de posições por caixa"
                           onblur="" name="numLinhasCaixa" value="' . $objLocalArmazenamento->getQntLinhasCaixa() . '">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="label_numPortas">Informe o número de <strong> colunas </strong> por caixa </label>
                    <input type="number" class="form-control" id="idNumPrateleiras" placeholder="quantidade de posições por caixa"
                           onblur="" name="numColunasCaixa" value="' . $objLocalArmazenamento->getQntColunasCaixa() . '">
                </div>
            </div>
            
            
             <div class="form-row">             
                <div class="col-md-12 mb-3">
                    <button class="btn btn-primary" type="submit" name="salvar_localArmazenamento">SALVAR</button>        
                </div>
            </div>      
            
           
        </form>
   </div>';



Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();