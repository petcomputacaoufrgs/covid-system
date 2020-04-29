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
    $table ='';
            if(isset($_POST['procurar_localArmazenamento'])){
                $objLocalArmazenamento->setNome($_POST['nomeLocal']);
                $arr_locais = $objLocalArmazenamentoRN->listar($objLocalArmazenamento);

                foreach ($arr_locais as $local){
                    $objPorta->setIdLocalArmazenamentoFk($local->getIdLocalArmazenamento());
                    $arr_portas = $objPortaRN->listar($objPorta);
                    foreach ($arr_portas as $porta) {
                        $objPrateleira->setIdPrateleira($objPorta->getIdPorta());
                        $arr_prateleiras = $objPrateleiraRN->listar($objPrateleira);
                        if ($porta->getIdLocalArmazenamentoFk() == $local->getIdLocalArmazenamento()) {
                            $table .= '
                                    <div class="conteudo_grande">
                                      <table style="border: 1px solid black;width: 90%;margin-left: 5%;margin-top: -50px;">
                                        <tr><td>' . $objLocalArmazenamento->getNome().' - '.$porta->getNome() . '</td></tr>
                                      </table>';

                            $contador_prateleiras = 1;
                            foreach ($arr_prateleiras as $prateleira) {
                                $objColuna->setIdPrateleira_fk($objPrateleira->getIdPrateleira());
                                $arr_colunas = $objColunaRN->listar($objColuna);

                                $prateleiraAux = new Prateleira();
                                $prateleiraAux->setIdPorta_fk($porta->getIdPorta());
                                $arr_prateleiras_porta = $objPrateleiraRN->listar($prateleiraAux);

                                if ($prateleira->getIdPorta_fk() == $porta->getIdPorta()) {
                                    $style_border_prateleira ='';
                                    if($contador_prateleiras < count($arr_prateleiras_porta)){
                                        $style_border_prateleira = 'border-bottom: 8px solid red;';
                                    }
                                    $table .= '<table style="'.$style_border_prateleira.'width: 90%;margin-left: 5%;margin-top:1px;padding:20px;align-content: center;"><tr>
                                                Espaço da prateleira '.$prateleira->getIdPrateleira().'
                                                ';
                                    $contador_prateleiras++;

                                    $colunaAux = new Coluna();
                                    $colunaAux->setIdPrateleira_fk($prateleira->getIdPrateleira());
                                    $arr_colunas_prateleira = $objColunaRN->listar($colunaAux);

                                    foreach ($arr_colunas as $coluna) {
                                        if ($coluna->getIdPrateleira_fk() == $prateleira->getIdPrateleira()) {

                                            $table .= ' <td style="border-left:4px solid black;border-right:4px solid black;padding:10px;">Coluna '.$coluna->getIdColuna().'
  
                                                            <table style="border: 2px solid blue;width: 98%;margin-left: 1%;margin-right: 1%;margin-top: 2px;margin-bottom:2px;align-content: center;">
                                                              <tr>';

                                            $objCaixa->setIdColuna_fk($objColuna->getIdColuna());
                                            $arr_caixas = $objCaixaRN->listar($objCaixa);
                                            foreach ($arr_caixas as $caixa) {
                                                if ($caixa->getIdColuna_fk() == $coluna->getIdColuna()) {
                                                    $table .= '<td style="border: 3px solid deeppink;padding: 5px;">
                                                                    <a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=editar_caixa&idCaixa='.$caixa->getIdCaixa().'&idLocalArmazenamento='.$local->getIdLocalArmazenamento()).'">Caixa' . $caixa->getIdCaixa() . '</a></td>';

                                                }
                                            }
                                            $table .= ' </tr></table></td>';
                                        }
                                    }
                                    $table .= '</tr>';
                                }
                            }
                            $table .= ' </table></div>';
                        }

                    }

                }
            }


} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
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
                <div class="col-md-10 mb-3">
                    <label for="label_numPortas">Informe o nome do local de armazenamento para a procura</label>
                    <input type="text" class="form-control" id="idNomeLocal" placeholder="nome" 
                           onblur="" name="nomeLocal" value="'.$objLocalArmazenamento->getNome().'">
                </div> 
                       
                <div class="col-md-2 mb-3">
                    <button class="btn btn-primary" type="submit" style="margin-top: 33px; margin-left: 0px; width: 100%;" name="procurar_localArmazenamento">PROCURAR</button>        
                </div>
            </div>      
            
           
        </form>
   </div>';
echo $table;
echo '<div class="conteudo_grande" style="margin-top:30px;"></div>';

Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();