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
    public static $TP_ARMAZENAMENTO_EXTRACAO = 'M';
    // ...
    public static $TP_LAUDO = 'L';

    //tipo situacao etapa
    public static $TSP_INICIALIZADO = 'I';
    public static $TSP_AGUARDANDO = 'U';
    public static $TSP_EM_ANDAMENTO = 'N';
    public static $TSP_FINALIZADO = 'F';


    //tipo situação tubo
    public static $TST_SEM_UTILIZACAO = 'S';
    public static $TST_EM_UTILIZACAO = 'E';
    public static $TST_DESCARTADO = 'D';


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
            $objSituacao->setStrTipo(self::$TP_ARMAZENAMENTO_EXTRACAO);
            $objSituacao->setStrDescricao('Armazenamento da Preparação/Extração');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TP_LAUDO);
            $objSituacao->setStrDescricao('Laudo');
            $arrObjTEtapa[] = $objSituacao;


            return $arrObjTEtapa;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Tipo estado da capela',$e);
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
            throw new Excecao('Erro listando valores de Tipo estado da capela',$e);
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

            return $arrObjTStaTubo;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Tipo estado da capela',$e);
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
        if (strlen($infosTubo->getDataHora()) == 0) {
            $objExcecao->adicionar_validacao('Informar a data e hora.','idDataHora', 'alert-danger');
        }
        
        $infosTubo->setDataHora($dthr);
    }

    private function validarVolume(InfosTubo $infosTubo, Excecao $objExcecao){
        $strVolume = trim($infosTubo->getVolume());
        
        /*if($strVolume == ''){
            $objExcecao->adicionar_validacao('Informe um volume.','idVolume');
        }*/
                           
        return $infosTubo->setVolume($strVolume);
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
            $objExcecao->adicionar_validacao('As observações do problema em infos tubo possuem mais de 150 caracteres' ,'idVolume', 'alert-danger');
        }

        return $infosTubo->setObsProblema($strObsProblemas);
    }

    public function cadastrar(InfosTubo $infosTubo){
        try{

            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 


            //$this->validarIdLocalArmazenamento_fk($infosTubo, $objExcecao);
            //$this->validarIdTubo_fk($infosTubo, $objExcecao);
            //$this->validarStatusTubo($infosTubo, $objExcecao);
            $this->validarEtapa($infosTubo, $objExcecao);
            $this->validarDataHora($infosTubo, $objExcecao);
            $this->validarVolume($infosTubo, $objExcecao);
            //$this->validarDescarteNaEtapa($infosTubo, $objExcecao);
            $this->validarObservacoes($infosTubo, $objExcecao);
            $this->validarObsProblemas($infosTubo, $objExcecao);

            $objExcecao->lancar_validacoes();
            $objInfosTuboBD = new infosTuboBD();
            $objInfosTuboBD->cadastrar($infosTubo,$objBanco);

            $objBanco->fecharConexao();
            
        }catch (Throwable $e){
            throw new Excecao('Erro no cadastramento das informacoes do tubo.', $e);
        }
    }

    public function alterar(InfosTubo $infosTubo){
        try{

            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 

            //$this->validarIdLocalArmazenamento_fk($infosTubo, $objExcecao);
            $this->validarIdTubo_fk($infosTubo, $objExcecao);
            //$this->validarStatusTubo($infosTubo, $objExcecao);
            $this->validarEtapa($infosTubo, $objExcecao);
            $this->validarDataHora($infosTubo, $objExcecao);
            $this->validarVolume($infosTubo, $objExcecao);
            //$this->validarDescarteNaEtapa($infosTubo, $objExcecao);
            $this->validarObservacoes($infosTubo, $objExcecao);
            $this->validarObsProblemas($infosTubo, $objExcecao);

            $objExcecao->lancar_validacoes();
            $objInfosTuboBD = new infosTuboBD();
            $objInfosTuboBD->alterar($infosTubo,$objBanco);

            $objBanco->fecharConexao();
        }catch (Throwable $e){
            throw new Excecao('Erro na alteração das informacoes do tubo.', $e);
        }
    }

    public function consultar(InfosTubo $infosTubo){
        try{

            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objInfosTuboBD = new infosTuboBD();
            $arr = $objInfosTuboBD->consultar($infosTubo,$objBanco);

            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            throw new Excecao('Erro na consulta das informacoes do tubo.', $e);
        }
    }

    public function remover(InfosTubo $infosTubo){
        try{
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objInfosTuboBD = new infosTuboBD();
            $arr = $objInfosTuboBD->remover($infosTubo,$objBanco);

            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            throw new Excecao('Erro na remoção das informacoes do tubo.', $e);
        }
    }

    public function listar(InfosTubo $infosTubo){
        try{
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objInfosTuboBD = new infosTuboBD();
            $arr = $objInfosTuboBD->listar($infosTubo,$objBanco);

            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
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

            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
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
            print_r($arr_infos);

            foreach ($arr_infos as $info) {
                $objInfosTuboBD = new infosTuboBD();
                $objInfosTuboBD->arrumarbanco($infosTubo, $info, $objBanco);
            }

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();

        }catch (Throwable $e){
            die($e);
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na listagem das informacoes do tubo.', $e);
        }
    }
}
