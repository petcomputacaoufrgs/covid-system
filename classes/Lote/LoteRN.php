<?php 
/**************************************************** 
 *  Classe das regras de negócio do lote dos tubos  *
 ****************************************************/

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/../Situacao/Situacao.php';

require_once __DIR__ . '/LoteBD.php';

class LoteRN{

    //situação do lote
    public static $TE_AGUARDANDO_PREPARACAO = 'R';
    public static $TE_TRANSPORTE_PREPARACAO = 'T';
    public static $TE_AGUARDANDO_EXTRACAO = 'X';
    public static $TE_EM_PREPARACAO = 'P';
    public static $TE_EM_EXTRACAO = 'E';
    public static $TE_PREPARACAO_FINALIZADA = 'F';
    public static $TE_EXTRACAO_FINALIZADA = 'Z';

    //tipo lote
    public static $TL_PREPARO = 'P';
    public static $TL_EXTRACAO = 'E';

    public static function listarValoresSituacaoLote(){
        try {

            $arrObjTECapela = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TE_AGUARDANDO_PREPARACAO);
            $objSituacao->setStrDescricao('Aguardando preparação');
            $arrObjTECapela[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TE_AGUARDANDO_EXTRACAO);
            $objSituacao->setStrDescricao('Aguardando extração');
            $arrObjTECapela[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TE_TRANSPORTE_PREPARACAO);
            $objSituacao->setStrDescricao('Transporte preparação');
            $arrObjTECapela[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TE_EM_PREPARACAO);
            $objSituacao->setStrDescricao('Em preparação');
            $arrObjTECapela[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TE_EM_EXTRACAO);
            $objSituacao->setStrDescricao('Em extração');
            $arrObjTECapela[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TE_PREPARACAO_FINALIZADA);
            $objSituacao->setStrDescricao('Preparação finalizada');
            $arrObjTECapela[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TE_EXTRACAO_FINALIZADA);
            $objSituacao->setStrDescricao('Extração finalizada');
            $arrObjTECapela[] = $objSituacao;


            return $arrObjTECapela;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Tipo estado da capela',$e);
        }
    }


    public static function listarValoresTipoLote(){
        try {

            $arrObjTECapela = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TL_PREPARO);
            $objSituacao->setStrDescricao('Lote para preparação');
            $arrObjTECapela[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TL_EXTRACAO);
            $objSituacao->setStrDescricao('Lote para extração');
            $arrObjTECapela[] = $objSituacao;

            return $arrObjTECapela;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Tipo estado da capela',$e);
        }
    }

    public static function mostrarDescricaoSituacao($strTipo){
        //$objExcecao = new Excecao();

        foreach (self::listarValoresSituacaoLote() as $tipo){
            if($tipo->getStrTipo() == $strTipo){
                return $tipo->getStrDescricao();
            }
        }
        return null;
        //$objExcecao->adicionarValidacao('Não encontrou o tipo informadoo.','alert-danger');
    }



    public static function mostrarDescricaoTipoLote($strTipo){
        //$objExcecao = new Excecao();

        foreach (self::listarValoresTipoLote() as $tipo){
            if($tipo->getStrTipo() == $strTipo){
                return $tipo->getStrDescricao();
            }
        }
        return null;
        //$objExcecao->adicionarValidacao('Não encontrou o tipo informadoo.','alert-danger');
    }

    private function validarStrTipoLote(Lote $lote,Excecao $objExcecao){

        if ($lote->getSituacaoLote() == null){
            $objExcecao->adicionar_validacao('Tipo não informado',null,'alert-danger');
        }else{
            $flag = false;
            foreach (self::listarValoresTipoLote() as $tipo){
                if($tipo->getStrTipo() == $lote->getTipo()){
                    $flag = true;
                }
            }

            if(!$flag){
                $objExcecao->adicionar_validacao('O tipo do lote não foi encontrado',null,'alert-danger');
            }
        }

    }


    private function validarQntAmostrasDesejadas(Lote $lote,Excecao $objExcecao){
        //se o lote for de preparação
        if($lote->getTipo() == LoteRN::$TL_PREPARO) {
            $strQntAmostrasDesejadas = trim($lote->getQntAmostrasDesejadas());

            if ($strQntAmostrasDesejadas == '') {
                $objExcecao->adicionar_validacao('A quantidade de amostras desejadas não foi informado', null, 'alert-danger');
            }

            if ($lote->getQntAmostrasDesejadas() != 8 && $lote->getQntAmostrasDesejadas() != 16) {
                if ($lote->getQntAmostrasDesejadas() != 8) {
                    $objExcecao->adicionar_validacao('A quantidade de amostras não é 8 ', null, 'alert-danger');
                }
                if ($lote->getQntAmostrasDesejadas() != 16) {
                    $objExcecao->adicionar_validacao('A quantidade de amostras não é 16 ', null, 'alert-danger');
                }
            }

            return $lote->setQntAmostrasDesejadas($strQntAmostrasDesejadas);
        }
    }

    private function validarQntAmostrasAdquiridas(Lote $lote,Excecao $objExcecao){
        $strQntAmostrasAdquiridas = trim($lote->getQntAmostrasAdquiridas());
        
        if ($strQntAmostrasAdquiridas == '') {
            $objExcecao->adicionar_validacao('O número da quantidade de amostras adquiridas não foi informado',null,'alert-danger');
        }
        return $lote->setQntAmostrasAdquiridas($strQntAmostrasAdquiridas);
    }

    private function validarSituacaoLote(Lote $lote,Excecao $objExcecao){
        $strStatusLote = trim($lote->getSituacaoLote());

        if ($strStatusLote == '') {
            $objExcecao->adicionar_validacao('O status do lote não foi informado',null,'alert-danger');
        }

        return $lote->setSituacaoLote($strStatusLote);
    }

    public function cadastrar(Lote $lote){
        $objBanco = new Banco();
        try{

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();


            $this->validarStrTipoLote($lote,$objExcecao);
            $this->validarQntAmostrasDesejadas($lote,$objExcecao);
            $this->validarQntAmostrasAdquiridas($lote,$objExcecao);
            $this->validarSituacaoLote($lote,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objLoteBD = new LoteBD();
            $lote = $objLoteBD->cadastrar($lote,$objBanco);


            $objRelTuboLote = new Rel_tubo_lote();
            $objRelTuboLoteRN = new Rel_tubo_lote_RN();

            //o lote para extração tem que validar coisas como lugar onde o tubo tá
            if($lote->getSituacaoLote() == LoteRN::$TE_AGUARDANDO_EXTRACAO && $lote->getObjsTubo() != null){

                $objRelTuboLote->setIdLote_fk($lote->getIdLote());
                $objRelTuboLote->setObjLote($lote);
                foreach ($lote->getObjsTubo() as $t) {
                    $objTuboRN = new TuboRN();
                    $t = $objTuboRN->cadastrar($t); //tubos do novo lote de extração
                    $arr_tubos[] = $t;
                    $objRelTuboLote->setIdTubo_fk($t->getIdTubo());
                    $objRelTuboLoteRN->cadastrar($objRelTuboLote);
                }
                $lote->setObjsTubo($arr_tubos);
            }else {
                if ($lote->getObjsTubo() != null) {

                    $objRelTuboLote->setIdLote_fk($lote->getIdLote());
                    $objRelTuboLote->setObjLote($lote);
                    foreach ($lote->getObjsTubo() as $t) {

                        $objInfosTubo = new InfosTubo();
                        $objInfosTuboRN = new InfosTuboRN();

                        $objInfosTubo->setIdTubo_fk($t->getIdTubo());
                        $objInfosTubo = $objInfosTuboRN->pegar_ultimo($objInfosTubo);



                        $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_SEM_UTILIZACAO);
                        $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                        $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                        $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());

                        $objInfosTuboRN->cadastrar($objInfosTubo);

                        $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_TRANSPORTE_PREPARACAO);
                        $objInfosTubo->setEtapa(InfosTuboRN::$TP_PREPARACAO_INATIVACAO);
                        $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                        $objInfosTubo->setIdLote_fk($lote->getIdLote());
                        $objInfosTubo->setEtapaAnterior(InfosTuboRN::$TP_MONTAGEM_GRUPOS_AMOSTRAS);
                        $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                        $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());

                        $objInfosTuboRN->cadastrar($objInfosTubo);

                        $objRelTuboLote->setIdTubo_fk($t->getIdTubo());
                        $objRelTuboLoteRN->cadastrar($objRelTuboLote);


                    }
                }
            }

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $lote;
        }catch(Exception $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro no cadastramento do lote.', $e);
        }
    }

    public function alterar(Lote $lote) {
        $objBanco = new Banco();
        try{

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarStrTipoLote($lote,$objExcecao);
           $this->validarQntAmostrasDesejadas($lote,$objExcecao);
           $this->validarQntAmostrasAdquiridas($lote,$objExcecao);
           $this->validarSituacaoLote($lote,$objExcecao);

           $objExcecao->lancar_validacoes();
           $objLoteBD = new LoteBD();
           $objLoteBD->alterar($lote,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $lote;
        }catch(Exception $e){
            $objBanco->cancelarTransacao();
           throw new Excecao('Erro na alteração do lote.', $e);
       }
   }

   public function consultar(Lote $lote) {
       $objBanco = new Banco();
       try{

           $objExcecao = new Excecao();
           $objBanco->abrirConexao();
           $objBanco->abrirTransacao();

           $objExcecao->lancar_validacoes();
           $objLoteBD = new LoteBD();
           $arr =  $objLoteBD->consultar($lote,$objBanco);

           $objBanco->confirmarTransacao();
           $objBanco->fecharConexao();
           return $arr;
       }catch(Exception $e){
           $objBanco->cancelarTransacao();
           throw new Excecao('Erro na consulta do lote.',$e);
       }
   }

    public function consultar_perfis(Lote $lote) {
        $objBanco = new Banco();
        try{

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objLoteBD = new LoteBD();
            $arr =  $objLoteBD->consultar_perfis($lote,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch(Exception $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na consulta do lote.',$e);
        }
    }


   public function remover(Lote $lote){
       $objBanco = new Banco();
       try{

           $objExcecao = new Excecao();
           $objBanco->abrirConexao();
           $objBanco->abrirTransacao();

           $objExcecao->lancar_validacoes();
           $objLoteBD = new LoteBD();
           $arr =  $objLoteBD->remover($lote,$objBanco);

           $objBanco->confirmarTransacao();
           $objBanco->fecharConexao();
           return $arr;
       }catch(Exception $e){
           $objBanco->cancelarTransacao();
           throw new Excecao('Erro na remoção do lote.', $e);
       }
   }

   public function listar(Lote $lote) {
       $objBanco = new Banco();
       try{

           $objExcecao = new Excecao();
           $objBanco->abrirConexao();
           $objBanco->abrirTransacao();

           $objExcecao->lancar_validacoes();
           $objLoteBD = new LoteBD();
           
           $arr = $objLoteBD->listar($lote,$objBanco);

           $objBanco->confirmarTransacao();
           $objBanco->fecharConexao();
           return $arr;
       }catch(Exception $e){
           $objBanco->cancelarTransacao();
           throw new Excecao('Erro na listagem do lote.',$e);
       }
   }

   public function pesquisar($campoBD, $valor_usuario) {
       $objBanco = new Banco();
       try{

           $objExcecao = new Excecao();
           $objBanco->abrirConexao();
           $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objLoteBD = new LoteBD();
            $arr = $objLoteBD->pesquisar($campoBD,$valor_usuario,$objBanco);

           $objBanco->confirmarTransacao();
           $objBanco->fecharConexao();
           return $arr;
       }catch(Exception $e){
           $objBanco->cancelarTransacao();
        throw new Excecao('Erro na pesquisa do lote.', $e);
    }
}

}