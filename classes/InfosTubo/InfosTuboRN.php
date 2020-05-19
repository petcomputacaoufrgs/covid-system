<?php

/*************************************
*   Classe das regras de negocio das * 
*   informacoes dos tubos            *
**************************************/ 

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/InfosTuboBD.php';

class InfosTuboRN{

    //tipo etapa
    public static $TP_RECEPCAO = 'R';
    public static $TP_MONTAGEM_GRUPOS_AMOSTRAS = 'G';
    public static $TP_PREPARACAO_INATIVACAO = 'I';
    public static $TP_EXTRACAO = 'E';
    public static $TP_RTqPCR_SOLICITACAO__MONTAGEM_PLACA = 'M';
    public static $TP_RTqPCR_MIX_PLACA = 'X';
    public static $TP_RTqPCR = 'Q';
    public static $TP_LAUDO = 'L';

    //tipo situacao etapa
    public static $TSP_INICIALIZADO = 'I';
    public static $TSP_AGUARDANDO = 'U';
    public static $TSP_EM_ANDAMENTO = 'N';
    public static $TSP_FINALIZADO = 'F';


    //tipo situação tubo
    public static $TST_TRANSPORTE_PREPARACAO = 'T';
    public static $TST_SEM_UTILIZACAO = 'S';
    public static $TST_EM_UTILIZACAO = 'E';
    public static $TST_DESCARTADO = 'D';
    public static $TST_DESCARTADO_NO_MEIO_ETAPA= 'M';
    public static $TST_TRANSPORTE_EXTRACAO= 'R';
    public static $TST_AGUARDANDO_BANCO_AMOSTRAS= 'B';
    public static $TST_DESCARTADO_SEM_VOLUME= 'V';
    public static $TST_AGUARDANDO_SOLICITACAO_MONTAGEM_PLACA =  'N';
    public static $TST_AGUARDANDO_MIX_PLACA =  'X';
    public static $TST_AGUARDANDO_RTqCPR =  'Q';
    /*public static $TST_NA_MONTAGEM = 'N';
    public static $TST_NA_PREPARACAO = 'R';
    public static $TST_NA_EXTRACAO = 'X';
    public static $TST_NA_SOLICITACAO_MONTAGEM_PLACA = 'L';*/

    //observações
    public static $O_PREPARO_LOTE_APAGADO= 'P';


    public static $VOLUME_ALIQUOTA = 1.0;
    public static $VOLUME_INDO_EXTRACAO = 0.2;




    public static function listarValoresTipoEtapa(){
        try {

            $arrObjTEtapa = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TP_RECEPCAO);
            $objSituacao->setStrDescricao('Recepção');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TP_MONTAGEM_GRUPOS_AMOSTRAS);
            $objSituacao->setStrDescricao('Montagem do grupo de preparo/extração');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TP_PREPARACAO_INATIVACAO);
            $objSituacao->setStrDescricao('Preparo e Inativação');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TP_EXTRACAO);
            $objSituacao->setStrDescricao('Extração');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TP_RTqPCR);
            $objSituacao->setStrDescricao('RT-qPCR');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TP_RTqPCR_SOLICITACAO__MONTAGEM_PLACA);
            $objSituacao->setStrDescricao('Solicitação de montagem da placa RT-qPCR');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TP_LAUDO);
            $objSituacao->setStrDescricao('Laudo');
            $arrObjTEtapa[] = $objSituacao;


            return $arrObjTEtapa;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Tipo etapa do infostubo',$e);
        }
    }

    public static function listarValoresTipoStaEtapa(){
        try {

            $arrObjTStaEtapa = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TSP_INICIALIZADO);
            $objSituacao->setStrDescricao('Inicializada');
            $arrObjTStaEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TSP_AGUARDANDO);
            $objSituacao->setStrDescricao('Aguardando');
            $arrObjTStaEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TSP_EM_ANDAMENTO);
            $objSituacao->setStrDescricao('Em andamento');
            $arrObjTStaEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TSP_FINALIZADO);
            $objSituacao->setStrDescricao('Finalizada');
            $arrObjTStaEtapa[] = $objSituacao;

            return $arrObjTStaEtapa;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Situação da infostubo',$e);
        }
    }

    public static function listarValoresTipoStaTubo(){
        try {

            $arrObjTStaTubo = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TST_SEM_UTILIZACAO);
            $objSituacao->setStrDescricao('Sem utilização no momento');
            $arrObjTStaTubo[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TST_EM_UTILIZACAO);
            $objSituacao->setStrDescricao('Em utilização');
            $arrObjTStaTubo[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TST_DESCARTADO);
            $objSituacao->setStrDescricao('Descartado');
            $arrObjTStaTubo[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TST_TRANSPORTE_PREPARACAO);
            $objSituacao->setStrDescricao('Em transporte para preparação');
            $arrObjTStaTubo[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TST_TRANSPORTE_EXTRACAO);
            $objSituacao->setStrDescricao('Em transporte para extração');
            $arrObjTStaTubo[] = $objSituacao;


            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TST_DESCARTADO_NO_MEIO_ETAPA);
            $objSituacao->setStrDescricao('Descartado no meio da etapa');
            $arrObjTStaTubo[] = $objSituacao;


            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TST_AGUARDANDO_BANCO_AMOSTRAS);
            $objSituacao->setStrDescricao('Aguardando no banco de amostras');
            $arrObjTStaTubo[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TST_DESCARTADO_SEM_VOLUME);
            $objSituacao->setStrDescricao('Descartado por falta de volume');
            $arrObjTStaTubo[] = $objSituacao;


            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TST_AGUARDANDO_RTqCPR);
            $objSituacao->setStrDescricao('Aguardando a etapa de RT-qCPR');
            $arrObjTStaTubo[] = $objSituacao;


            return $arrObjTStaTubo;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de SITUAÇÃO do tubo',$e);
        }
    }

    public static function listarValoresObs(){
        try {

            $arrObjTEtapa = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$O_PREPARO_LOTE_APAGADO);
            $objSituacao->setStrDescricao('Preparo lote foi apagado');
            $arrObjTEtapa[] = $objSituacao;


            return $arrObjTEtapa;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Tipo estado da capela',$e);
        }
    }

    public static function retornarStaTubo($situacaoTubo){
        $arr = self::listarValoresTipoStaTubo();
        foreach ($arr as $a){
            if($a->getStrTipo() == $situacaoTubo ){
                return $a->getStrDescricao();
            }
        }
    }

    public static function retornarStaEtapa($situacaoEtapa){
        $arr = self::listarValoresTipoStaEtapa();
        foreach ($arr as $a){
            if($a->getStrTipo() == $situacaoEtapa ){
                return $a->getStrDescricao();
            }
        }
    }

    public static function retornarEtapa($etapa){
        $arr = self::listarValoresTipoEtapa();

        foreach ($arr as $a){
            if($a->getStrTipo() == $etapa ){
                return $a->getStrDescricao();
            }
        }
    }




    private function validarIdLocalArmazenamento_fk(InfosTubo $infosTubo, Excecao $objExcecao){
        $strIdLocalArmazenamento_fk = trim($infosTubo->getIdLocalArmazenamento_fk());

        //if($strIdLocalArmazenamento_fk == '' || $strIdLocalArmazenamento_fk == null){
        //    $objExcecao->adicionar_validacao('O ID do local de armazenamento não foi informado.', 'idLocalArmazenamento_fk');
        //}

        return $infosTubo->setIdLocalArmazenamento_fk($strIdLocalArmazenamento_fk);
    }

    private function validarIdTubo_fk(InfosTubo $infosTubo, Excecao $objExcecao){
        $strIdTubo_fk = trim($infosTubo->getIdTubo_fk());

        //if($strIdTubo_fk == '' || $strIdTubo_fk == null){
        //    $objExcecao->adicionar_validacao('O ID do tubo não foi informado.', 'idTubo_fk');
        //}

        return $infosTubo->setIdTubo_fk($strIdTubo_fk);
    }

    private function validarStatusTubo(InfosTubo $infosTubo, Excecao $objExcecao){
        $strStatusTubo = trim($infosTubo->getStatusTubo());

        if($strStatusTubo == ''){
            $objExcecao->adicionar_validacao('O status do tubo nao foi informado.', 'idStatusTubo', 'alert-danger');
        }else{
            if(strlen($strStatusTubo) > 100){
                $objExcecao->adicionar_validacao('O status do tubo possui mais que 100 caracteres.','idStatusTubo', 'alert-danger');
            }
        }

        return $infosTubo->setStatusTubo($strStatusTubo);
    }

    private function validarEtapa(InfosTubo $infosTubo, Excecao $objExcecao){
        $strEtapa = trim($infosTubo->getEtapa());

        if($strEtapa == ''){
            $objExcecao->adicionar_validacao('O nome da etapa nao foi informada.', 'idEtapa', 'alert-danger');
        }else{
            if(strlen($strEtapa) > 100){
                $objExcecao->adicionar_validacao('O nome da etapa possui mais que 100 caracteres.','idEtapa', 'alert-danger');
            }


        }

        return $infosTubo->setEtapa($strEtapa);
    }

    private function validarDataHora(InfosTubo $infosTubo, Excecao $objExcecao){
        $dthr = trim($infosTubo->getDataHora());
        //echo $infosTubo->getDataHora();
        //echo strlen($infosTubo->getDataHora());
        if (strlen($infosTubo->getDataHora()) == 0.0) {
            $objExcecao->adicionar_validacao('Informar a data e hora.','idDataHora', 'alert-danger');
        }

        $infosTubo->setDataHora($dthr);
    }

    private function validarVolume(InfosTubo $infosTubo, Excecao $objExcecao)
    {



        if($infosTubo->getVolume() != null){
        $strVolume = trim($infosTubo->getVolume());

            if($infosTubo->getVolume() == 0.0){
                $infosTubo->setSituacaoTubo(InfosTuboRN::$TST_DESCARTADO_NO_MEIO_ETAPA);

            }

                /*if($infosTubo->getObjTubo()->getTipo() == TuboRN::$TT_ALIQUOTA && $infosTubo->getReteste() == 'S'){
                    if($infosTubo->getVolume() != InfosTuboRN::$VOLUME_INDO_EXTRACAO ){

                    }
                }*/

        if ($infosTubo->getObjTubo() != null) {
            if ($infosTubo->getEtapa() != InfosTuboRN::$TP_RECEPCAO) {
                //print_r($infosTubo->getObjTubo());

                if ($infosTubo->getObjTubo()->getTipo() == TuboRN::$TT_INDO_EXTRACAO) {
                    if ($infosTubo->getVolume() == 0.0 && ($infosTubo->getSituacaoTubo() != InfosTuboRN::$TST_DESCARTADO || $infosTubo->getSituacaoTubo() != InfosTuboRN::$TST_DESCARTADO_NO_MEIO_ETAPA)) {
                        $objExcecao->adicionar_validacao('O volume do tubo é 0.0 mas ele não foi descartado? <strong>' . $infosTubo->getCodAmostra() . '</strong> ', 'idVolume', 'alert-danger');
                    }
                }


                if ($infosTubo->getObjTubo()->getTipo() == TuboRN::$TT_INDO_EXTRACAO) {
                    if ($infosTubo->getVolume() != InfosTuboRN::$VOLUME_INDO_EXTRACAO && $infosTubo->getObsProblema() == null) {
                        $objExcecao->adicionar_validacao('Informe porque o volume foi diferente de ' . InfosTuboRN::$VOLUME_INDO_EXTRACAO . ' na amostra <strong>' . $infosTubo->getCodAmostra() . '</strong> ', 'idVolume', 'alert-danger');
                    }
                }

                if ($infosTubo->getSituacaoTubo() == InfosTuboRN::$TST_AGUARDANDO_RTqCPR && $infosTubo->getVolume() != InfosTuboRN::$VOLUME_INDO_EXTRACAO && $infosTubo->getObsProblema() == null) {

                    $objExcecao->adicionar_validacao('Informe porque o volume foi diferente de ' . InfosTuboRN::$VOLUME_INDO_EXTRACAO . ' na amostra <strong>' . $infosTubo->getCodAmostra() . '</strong> ', 'idVolume', 'alert-danger');
                }


                /*if ($infosTubo->getObjTubo()->getTipo() == TuboRN::$TT_ALIQUOTA) {
                    if ($infosTubo->getVolume() != InfosTuboRN::$VOLUME_ALIQUOTA && $infosTubo->getObsProblema() == null ) {
                        $objExcecao->adicionar_validacao('Informe porque o volume foi diferente de ' . InfosTuboRN::$VOLUME_ALIQUOTA . ' na amostra <strong>' . $infosTubo->getCodAmostra() . '</strong> ', 'idVolume', 'alert-danger');
                    }
                }*/

                if ($infosTubo->getSituacaoTubo() == InfosTuboRN::$TST_DESCARTADO_NO_MEIO_ETAPA) {
                    return $infosTubo->setVolume(0.0);
                }


            }
        }




    }


        /*if($strVolume == ''){
            $objExcecao->adicionar_validacao('Informe um volume.','idVolume');
        }*/
                           
        return $infosTubo->setVolume(doubleval($strVolume));
    }

    private function  validarSituacaoEtapa(InfosTubo $infosTubo, Excecao $objExcecao){
        if($infosTubo->getSituacaoEtapa() == InfosTuboRN::$TSP_FINALIZADO && $infosTubo->getIdLote_fk() != null){
          //  $objExcecao->adicionar_validacao('Não é possível finalizar a etapa visto que o tubo pertence a um lote de número '.$infosTubo->getIdLote_fk() ,'idVolume', 'alert-danger');
        }
        //validar para nao mudarem depois q o laudo estiver pronto
    }


    private function validarObservacoes(InfosTubo $infosTubo, Excecao $objExcecao){
        $strObs = trim($infosTubo->getObservacoes());

        if(strlen($strObs) > 150){
            $objExcecao->adicionar_validacao('As observações em infos tubo possuem mais de 150 caracteres' ,'idVolume', 'alert-danger');
        }

        return $infosTubo->setObservacoes($strObs);
    }

    private function validarObsProblemas(InfosTubo $infosTubo, Excecao $objExcecao){
        $strObsProblemas = trim($infosTubo->getObsProblema());

        if(strlen($strObsProblemas) > 150){
            $objExcecao->adicionar_validacao('As observações do problema em infos tubo possuem mais de 150 caracteres na amostra <strong>'.$infosTubo->getCodAmostra() .'</strong> ' ,'idVolume', 'alert-danger');
        }

        if($infosTubo->getSituacaoTubo() == InfosTuboRN::$TST_DESCARTADO_NO_MEIO_ETAPA && strlen($strObsProblemas) == 0){

            $objExcecao->adicionar_validacao('Informar o problema que fez a amostra <strong>'.$infosTubo->getCodAmostra() .'</strong> ser descartada -- '. TuboRN::mostrarDescricaoTipoTubo($infosTubo->getObjTubo()->getTipo()) ,null, 'alert-danger');
        }

        return $infosTubo->setObsProblema($strObsProblemas);
    }

    public function cadastrar(InfosTubo $infosTubo){
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();


            if($infosTubo->getObjLocal() != null && $infosTubo->getSituacaoTubo() != InfosTuboRN::$TST_DESCARTADO_NO_MEIO_ETAPA) {
                $objLocalTxt = new LocalArmazenamentoTexto();
                $objLocalTxtRN = new LocalArmazenamentoTextoRN();

                //for($i = 0; $i <count($infosTubo->getObjLocal()); $i++) {
                    $infosTubo->getObjLocal()->setObjInfos($infosTubo);
                    $local = $objLocalTxtRN->cadastrar($infosTubo->getObjLocal());
                    //$arr_locais[] = $local;
                //}
                $infosTubo->setObjLocal($local);
                $infosTubo->setIdLocalFk($local->getIdLocal());

            }



            $this->validarSituacaoEtapa($infosTubo, $objExcecao);
            $this->validarEtapa($infosTubo, $objExcecao);
            $this->validarDataHora($infosTubo, $objExcecao);
            $this->validarVolume($infosTubo, $objExcecao);
            $this->validarObservacoes($infosTubo, $objExcecao);
            $this->validarObsProblemas($infosTubo, $objExcecao);

            $objExcecao->lancar_validacoes();
            $objInfosTuboBD = new infosTuboBD();
            $objInfosTubo = $objInfosTuboBD->cadastrar($infosTubo,$objBanco);

            /*if($infosTubo->getObjLocal() != null && $objInfosTubo->getSituacaoTubo() == InfosTuboRN::$TST_DESCARTADO_NO_MEIO_ETAPA){
                $objExcecao->adicionar_validacao('A amostra <strong>'.$infosTubo->getCodAmostra() .'</strong> foi descartada no meio da etapa. Logo, ela não deve ter um local de armazenamento -- '. TuboRN::mostrarDescricaoStaTubo($infosTubo->getObjTubo()->getTipo()) ,null, 'alert-danger');
            }*/

            /*if($infosTubo->getObjLocal() != null && ($infosTubo->getObjLocal()->getNome() != null || $infosTubo->getObjLocal()->getPosicao() != null || $infosTubo->getObjLocal()->getCaixa() != null) &&
            $infosTubo->getVolume() == 0){
                $objExcecao->adicionar_validacao('A amostra <strong>'.$infosTubo->getCodAmostra() .'</strong> tem volume 0. Logo, ela não deve ter um local de armazenamento -- '. TuboRN::mostrarDescricaoStaTubo($infosTubo->getObjTubo()->getTipo()) ,null, 'alert-danger');
            }*/
            $objExcecao->lancar_validacoes();





            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $infosTubo;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro no cadastramento das informacoes do tubo.', $e);
        }
    }

    public function alterar(InfosTubo $infosTubo){
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();


            //$this->validarIdTubo_fk($infosTubo, $objExcecao);
            $this->validarSituacaoEtapa($infosTubo, $objExcecao);
            $this->validarEtapa($infosTubo, $objExcecao);
            $this->validarDataHora($infosTubo, $objExcecao);
            $this->validarVolume($infosTubo, $objExcecao);
            $this->validarObservacoes($infosTubo, $objExcecao);
            $this->validarObsProblemas($infosTubo, $objExcecao);

            $objExcecao->lancar_validacoes();
            $objInfosTuboBD = new infosTuboBD();
            $infosTubo = $objInfosTuboBD->alterar($infosTubo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $infosTubo;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na alteração das informacoes do tubo.', $e);
        }
    }

    public function consultar(InfosTubo $infosTubo){
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objInfosTuboBD = new infosTuboBD();
            $arr = $objInfosTuboBD->consultar($infosTubo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na consulta das informacoes do tubo.', $e);
        }
    }

    public function remover(InfosTubo $infosTubo){
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objInfosTuboBD = new infosTuboBD();
            $arr = $objInfosTuboBD->remover($infosTubo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na remoção das informacoes do tubo.', $e);
        }
    }

    public function listar(InfosTubo $infosTubo){
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objInfosTuboBD = new infosTuboBD();
            $arr = $objInfosTuboBD->listar($infosTubo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na listagem das informacoes do tubo.', $e);
        }
    }

    public function pegar_ultimo(InfosTubo $infosTubo){
        try{
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();
            $objExcecao->lancar_validacoes();
            $objInfosTuboBD = new infosTuboBD();

            $arr = $objInfosTuboBD->pegar_ultimo($infosTubo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro ao pegar o último dado das nformacoes do tubo.', $e);
        }
    }

    public function arrumarbanco(InfosTubo $infosTubo){
        try{
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();

            $objInfosTuboRN = new InfosTuboRN();
            $arr_infos = $objInfosTuboRN->listar($infosTubo);

            foreach ($arr_infos as $info) {
                $objInfosTuboBD = new infosTuboBD();
                $objInfosTuboBD->arrumarbanco($infosTubo, $info, $objBanco);
            }

            die();

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();

        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na listagem das informacoes do tubo.', $e);
        }
    }

    public function validar_volume(PreparoLote $preparoLote){
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objInfosTuboBD = new infosTuboBD();
            $infosTubo = $objInfosTuboBD->validar_volume($preparoLote,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $infosTubo;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro no cadastramento das informacoes do tubo.', $e);
        }
    }


    public function lockRegistro_utilizacaoTubo_MG( $montagemGrupo){
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            //$objExcecao->lancar_validacoes();
            foreach ($montagemGrupo as $grupo){



                $objInfosTubo = new InfosTubo();
                $objInfosTuboRN = new InfosTuboRN();
                $objInfosTubo->setIdTubo_fk($grupo->getAmostra()->getObjTubo()->getIdTubo());
                $objInfosTuboUltimo= $objInfosTuboRN->pegar_ultimo($objInfosTubo);

                $objInfosTuboUltimo->setSituacaoTubo(InfosTuboRN::$TST_EM_UTILIZACAO);
                $objInfosTuboUltimo->setSituacaoEtapa(InfosTuboRN::$TSP_EM_ANDAMENTO);

                //$objInfosTuboRN->cadastrar($objInfosTuboUltimo);

            }

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na consulta das informacoes do tubo.', $e);
        }
    }
}

