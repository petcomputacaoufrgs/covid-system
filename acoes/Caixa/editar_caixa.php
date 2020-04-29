<?php
session_start();
try{

    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';

    require_once __DIR__ . '/../../classes/Caixa/Caixa.php';
    require_once __DIR__ . '/../../classes/Caixa/CaixaRN.php';

    require_once __DIR__ . '/../../classes/Posicao/Posicao.php';
    require_once __DIR__ . '/../../classes/Posicao/PosicaoRN.php';

    require_once __DIR__ . '/../../classes/LocalArmazenamento/LocalArmazenamento.php';
    require_once __DIR__ . '/../../classes/LocalArmazenamento/LocalArmazenamentoRN.php';

    require_once __DIR__ . '/../../classes/Porta/Porta.php';
    require_once __DIR__ . '/../../classes/Porta/PortaRN.php';

    require_once __DIR__ . '/../../classes/Prateleira/Prateleira.php';
    require_once __DIR__ . '/../../classes/Prateleira/PrateleiraRN.php';

    require_once __DIR__ . '/../../classes/Coluna/Coluna.php';
    require_once __DIR__ . '/../../classes/Coluna/ColunaRN.php';

    require_once __DIR__.'/../../classes/Tubo/Tubo.php';
    require_once __DIR__.'/../../classes/Tubo/TuboRN.php';

    require_once __DIR__.'/../../classes/InfosTubo/InfosTubo.php';
    require_once __DIR__.'/../../classes/InfosTubo/InfosTuboRN.php';

    require_once __DIR__.'/../../classes/Amostra/Amostra.php';
    require_once __DIR__.'/../../classes/Amostra/AmostraRN.php';

    Sessao::getInstance()->validar();

    /*
    *  LOCAL DE ARMAZENAMENTO
    */
    $objLocalArmazenamento = new LocalArmazenamento();
    $objLocalArmazenamentoRN = new LocalArmazenamentoRN();

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

    /* AMOSTRA */
    $objAmostra = new Amostra();
    $objAmostraRN = new AmostraRN();

    /* TUBO */
    $objTubo = new Tubo();
    $objTuboRN = new TuboRN();


    /* INFOS TUBO */
    $objInfosTubo = new InfosTubo();
    $objInfosTuboRN = new InfosTuboRN();

    $objCaixa->setIdCaixa($_GET['idCaixa']);
    $objCaixa = $objCaixaRN->consultar($objCaixa);

    $objPosicao->setIdCaixa_fk($_GET['idCaixa']);
    $objPosicaoRN->listar($objPosicao);


    if(!isset($_GET['idCaixa'])){

        $input_table .= '
            <form METHOD="post">
            <div class="form-row">
                <div class="col-md-10 mb-3">
                    <label for="label_numPortas">Informe o número da caixa para procura</label>
                    <input type="number" class="form-control" id="idCodigo" placeholder="código" 
                           onblur="" name="numCaixa" value="">
                </div>
                 <div class="col-md-2 mb-3">
                    <button class="btn btn-primary" type="submit" style="margin-top: 33px; margin-left: 0px; width: 100%;" name="procurar_caixa"> CAIXA</button>        
                </div>
            </div>';

        if(isset($_POST['procurar_caixa'])){

            $objCaixa->setIdCaixa($_POST['numCaixa']);
            $objCaixa = $objCaixaRN->consultar($objCaixa);

            $objColuna->setIdColuna($objCaixa->getIdColuna_fk());
            $objColuna = $objColunaRN->consultar($objColuna);

            $objPrateleira->setIdPrateleira($objColuna->getIdPrateleira_fk());
            $objPrateleira = $objPrateleiraRN->consultar($objPrateleira);

            $objPorta->setIdPorta($objPrateleira->getIdPorta_fk());
            $objPorta = $objPortaRN->consultar($objPorta);

            $objLocalArmazenamento->setIdLocalArmazenamento($objPorta->getIdLocalArmazenamentoFk());
            $objLocalArmazenamento = $objLocalArmazenamentoRN->consultar($objLocalArmazenamento);

            header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_caixa&idCaixa='.$objCaixa->getIdCaixa().'&idLocalArmazenamento='.$objLocalArmazenamento->getIdLocalArmazenamento()));
            die();
        }

    }else {
        ECHO 'AQUI';

        $quantidade = 10;
        $letras = range('A', chr(ord('A') + $quantidade));

        $table .= '<div class="conteudo_grande"  style="margin-top: -20px;width: 100%;">
            <form METHOD="post">
            <div class="form-row">
                <div class="col-md-10 mb-3">
                    <label for="label_numPortas">Informe o código da amostra que deseja retirar</label>
                    <input type="text" class="form-control" id="idCodigo" placeholder="código" 
                           onblur="" name="codigoAmostra" value="">
                </div>
                 <div class="col-md-2 mb-3">
                    <button class="btn btn-primary" type="submit" style="margin-top: 33px; margin-left: 0px; width: 100%;" name="procurar_amostra">PROCURAR</button>        
                </div>
            </div>
            </form>
            <form METHOD="post">
            
            <table class="table table-hover">
             <table>
             <tr>   ';
        for ($i = 0; $i <= $objCaixa->getQntLinhas(); $i++) {
            if ($i == 0) {
                $table .= '<td><input type="text" class="form-control" id="idDataHoraLogin" disabled style="text-align: center;"
                                   name="input_' . $i . '" value=""></td>';
            } else {
                $table .= '<td><input type="text" class="form-control" id="idDataHoraLogin" disabled style="text-align: center;"
                                   name="input_' . $i . '" value="COLUNA ' . $i . '"></td>';
            }
        }
        $table .= '<tr>';
        for ($i = 1; $i <= $objCaixa->getQntColunas(); $i++) {
            $table .= '<td><input type="text" class="form-control" id="idDataHoraLogin" disabled style="text-align: center;"
                       name="input_' . $i . '_' . $j . '" value="LINHA ' . $letras[($i - 1)] . '"></td>';
            for ($j = 1; $j <= $objCaixa->getQntLinhas(); $j++) {
                $objPosicao = new Posicao();
                $objPosicao->setLinha(strval($j));
                $objPosicao->setColuna(strval($i));
                $objPosicao->setIdCaixa_fk($_GET['idCaixa']);

                $posicao = $objPosicaoRN->listar($objPosicao);

                if($posicao[0]->getSituacaoPosicao() == PosicaoRN::$TSP_OCUPADA) {
                    $objTubo->setIdTubo($posicao[0]->getIdTuboFk());
                    $objTubo = $objTuboRN->consultar($objTubo);

                    $objAmostra->setIdAmostra($objTubo->getIdAmostra_fk());
                    $objAmostra = $objAmostraRN->consultar($objAmostra);
                }

                if ($posicao[0]->getSituacaoPosicao() == PosicaoRN::$TSP_LIBERADA) {
                    $table .= '<td><input style="background-color: rgba(0,255,0,0.2);text-align:center;" type="text" class="form-control" id="idDataHoraLogin"  style="text-align: center;"
                             placeholder="liberado"  name="input_' . $i . '_' . $j . '" value=""></td>';
                } else {
                    $table .= '<td><input style="background-color: rgba(255,0,0,0.2);text-align: center;" type="text" class="form-control" id="idDataHoraLogin"  style="text-align: center;"
                              placeholder="ocupado"  disabled     name="input_' . $i . '_' . $j . '" value="'.$objAmostra->getCodigoAmostra().'"></td>';
                }


            }
            $table .= '</tr>';
        }
        $table .= '</table>
                <div class="form-row">
                
                 <div class="col-md-12 mb-3">
                    <button class="btn btn-primary" type="submit" style="margin-top: 33px; margin-left: 0px; width: 100%;" name="inserir_amostra">INSERIR</button>        
                </div>
            </div>
                
            </form>';

        if(isset($_POST['inserir_amostra'])){
            for($i=1; $i<=$objCaixa->getQntLinhas(); $i++) {
                for ($j = 1; $j <= $objCaixa->getQntColunas(); $j++) {
                    if(isset($_POST['input_' . $i . '_' . $j])){
                        $objPosicao = new Posicao();
                        $objPosicao->setLinha(strval($j));
                        $objPosicao->setColuna(strval($i));
                        $objPosicao->setIdCaixa_fk($_GET['idCaixa']);

                        $objPosicao->setIdTuboFk();
                        ECHO $_POST['input_' . $i . '_' . $j];
                    }
                }
            }

        }


        if($_POST['procurar_amostra']){
            for($i=1; $i<=$objCaixa->getQntLinhas(); $i++){
                for($j=1; $j<=$objCaixa->getQntColunas(); $j++){
                    $objPosicao = new Posicao();
                    $objPosicao->setLinha(strval($j));
                    $objPosicao->setColuna(strval($i));
                    $objPosicao->setIdCaixa_fk($_GET['idCaixa']);
                    $posicao = $objPosicaoRN->listar($objPosicao);

                    $id = $id = substr($_POST['codigoAmostra'], 1);
                    $objAmostra->setIdAmostra($id);
                    $objAmostra = $objAmostraRN->consultar($objAmostra);

                    $objTubo->setIdAmostra_fk($objAmostra->getIdAmostra());
                    $arr_tubos = $objTuboRN->listar($objTubo);

                    foreach ($arr_tubos as $tubo){
                        $objInfosTubo->setIdTubo_fk($tubo->getIdTubo());
                        $arr_infos_tubo = $objInfosTuboRN->listar($objInfosTubo);
                        foreach ($arr_infos_tubo as $info_tubo){
                            if($info_tubo->getIdPosicao_fk() == $posicao[0]->getIdPosicao()){

                            }
                        }

                    }
                   // if ($posicao[0]->getSituacaoPosicao == PosicaoRN::$TSP_OCUPADA && $posicao->getId
                }
            }
        }
    }


} catch (Throwable $ex) {
    die($ex);
    Pagina::getInstance()->mostrar_excecoes($ex);
}


Pagina::abrir_head("Caixinha");
Pagina::getInstance()->adicionar_css("precadastros");
if($liberar_popUp == 's') {
    Pagina::getInstance()->adicionar_javascript("popUp");
}
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
echo $alert;
Pagina::montar_topo_listar('Caixa '.$_GET['idCaixa'].' - Local '.$_GET['idLocalArmazenamento'],null,null, 'listar_caixas', 'LISTAR CAIXAS');

ECHO $input_table;
echo $table;





Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();