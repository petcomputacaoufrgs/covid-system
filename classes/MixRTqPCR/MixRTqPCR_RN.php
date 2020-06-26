<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/MixRTqPCR_BD.php';
require_once __DIR__ . '/../Situacao/Situacao.php';

class MixRTqPCR_RN
{

    public static $STA_INVALIDA = 'I';
    public static $STA_TRANSPORTE_MONTAGEM = 'T';
    public static $STA_NA_MONTAGEM = 'M';
    public static $STA_MONTAGEM_FINALIZADA = 'F';
    public static $STA_AGUARDANDO_TABELAS_PROTOCOLOS = 'S';

    public static $STA_EM_ANDAMENTO = 'E';



    public static function listarValoresStaMix(){
        try {

            $arrObjTEtapa = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$STA_EM_ANDAMENTO);
            $objSituacao->setStrDescricao('EM ANDAMENTO');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$STA_INVALIDA);
            $objSituacao->setStrDescricao('INVÁLIDA');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$STA_NA_MONTAGEM);
            $objSituacao->setStrDescricao('NA MONTAGEM DA PLACA RTqPCR');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$STA_TRANSPORTE_MONTAGEM);
            $objSituacao->setStrDescricao('EM TRANSPORTE PARA A MONTAGEM DA PLACA RTqPCR');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$STA_MONTAGEM_FINALIZADA);
            $objSituacao->setStrDescricao('MONTAGEM DA PLACA RTqPCR FINALIZADA');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$STA_AGUARDANDO_TABELAS_PROTOCOLOS);
            $objSituacao->setStrDescricao('AGUARDANDO O SALVAMENTO DAS TABELAS DOS PROTOCOLOS');
            $arrObjTEtapa[] = $objSituacao;

            return $arrObjTEtapa;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Situação da placa',$e);
        }
    }

    public static function mostrar_descricao_staMix($situacaoMix){
        $arr = self::listarValoresStaMix();
        foreach ($arr as $a){
            if($a->getStrTipo() == $situacaoMix ){
                return $a->getStrDescricao();
            }
        }
        return null;
    }


    private function validarIdSolicitacao(MixRTqPCR $objMix,Excecao $objExcecao){

        if ($objMix->getIdSolicitacaoFk() == '' || $objMix->getIdSolicitacaoFk() == null || $objMix->getIdSolicitacaoFk() == -1 ) {
            $objExcecao->adicionar_validacao('Informe o identificador da solicitação do mix',null,'alert-danger');
        }
    }


    private function validarIdUsuario(MixRTqPCR $objMix,Excecao $objExcecao){

        if ($objMix->getIdUsuarioFk() == '' || $objMix->getIdUsuarioFk() == null || $objMix->getIdUsuarioFk() == -1 ) {
            $objExcecao->adicionar_validacao('Informe o identificador do usuário que realizou o mix',null,'alert-danger');
        }
    }


    private function validarIdPlaca(MixRTqPCR $objMix,Excecao $objExcecao){

        if ($objMix->getIdPlacaFk() == '' || $objMix->getIdPlacaFk() == null || $objMix->getIdPlacaFk() == -1 ) {
            $objExcecao->adicionar_validacao('Informe o identificador da placa do mix',null,'alert-danger');
        }
    }



    private function validarSituacao(MixRTqPCR $objMix,Excecao $objExcecao){

        if ($objMix->getSituacaoMix() == '' || $objMix->getSituacaoMix() == null ){
            $objExcecao->adicionar_validacao('Informe a situação do mix',null,'alert-danger');
        }else{
            if(self::mostrar_descricao_staMix($objMix->getSituacaoMix()) == null){
                $objExcecao->adicionar_validacao('A situação informada para o mix é inválida',null,'alert-danger');
            }
        }
    }



    private function validarDataHoraFim(MixRTqPCR $objMix,Excecao $objExcecao){

        if ($objMix->getDataHoraFim() == '' || $objMix->getSituacaoMix() == null ){
            $objExcecao->adicionar_validacao('Informe a data/hora fim do mix',null,'alert-danger');
        }
    }

    private function validarDataHoraInicio(MixRTqPCR $objMix,Excecao $objExcecao){

        if ($objMix->getDataHoraFim() == '' || $objMix->getSituacaoMix() == null ){
            $objExcecao->adicionar_validacao('Informe a data/hora início do mix',null,'alert-danger');
        }
    }


    public function cadastrar(MixRTqPCR $objMix) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            //$this->validarSituacao($objMix,$objExcecao);
            $this->validarIdUsuario($objMix,$objExcecao);
            $this->validarIdPlaca($objMix,$objExcecao);
            $this->validarIdSolicitacao($objMix,$objExcecao);
            $this->validarDataHoraFim($objMix,$objExcecao);
            $this->validarDataHoraInicio($objMix,$objExcecao);

            $objExcecao->lancar_validacoes();

            if($objMix->getObjPlaca() != null){
                $objPlacaRN = new PlacaRN();
                $objPlacaRN->alterar($objMix->getObjPlaca());
            }

            if($objMix->getArrObjInfosTubo() != null){
                $objInfosTuboRN = new InfosTuboRN();

                foreach ($objMix->getArrObjInfosTubo() as $infoTubo){
                    $objInfosTuboRN->cadastrar($infoTubo);
                }
            }

            $objMixBD = new MixRTqPCR_BD();
            $mix  = $objMixBD->cadastrar($objMix,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $mix;
        } catch (Throwable $e) {

            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o placa.', $e);
        }
    }

    public function alterar(MixRTqPCR $objMix) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            //$this->validarSituacao($objMix,$objExcecao);
            $this->validarIdUsuario($objMix,$objExcecao);
            $this->validarIdPlaca($objMix,$objExcecao);
            $this->validarIdSolicitacao($objMix,$objExcecao);
            $this->validarDataHoraFim($objMix,$objExcecao);
            $this->validarDataHoraInicio($objMix,$objExcecao);

            $objExcecao->lancar_validacoes();

            if($objMix->getObjPlaca() != null){
                $objPlacaRN = new PlacaRN();
                $objPlacaRN->alterar($objMix->getObjPlaca());
            }

            if($objMix->getArrObjInfosTubo() != null){
                $objInfosTuboRN = new InfosTuboRN();

                foreach ($objMix->getArrObjInfosTubo() as $infoTubo){
                    $objInfosTuboRN->cadastrar($infoTubo);
                }
            }

             $objMixBD = new MixRTqPCR_BD();
            $mix = $objMixBD->alterar($objMix,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $mix;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o placa.', $e);
        }
    }

    public function consultar(MixRTqPCR $objMix) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
             $objMixBD = new MixRTqPCR_BD();
            $arr =  $objMixBD->consultar($objMix,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o placa.',$e);
        }
    }

    public function remover(MixRTqPCR $objMix) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
             $objMixBD = new MixRTqPCR_BD();

            //$this->validar_existe_RTqPCR_com_a_placa($objMix, $objExcecao);
            $objExcecao->lancar_validacoes();

            $arr =  $objMixBD->remover($objMix,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o placa.', $e);
        }
    }


    public function listar(MixRTqPCR $objMix,$numLimite=null,$completo) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
             $objMixBD = new MixRTqPCR_BD();

             if($completo){
                 $arr = $objMixBD->listar_completo($objMix, $numLimite, $objBanco);
             }else {
                 $arr = $objMixBD->listar($objMix, $numLimite, $objBanco);
             }

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o placa.',$e);
        }
    }

    public function paginacao(MixRTqPCR $objMix) {
        $objBanco = new Banco();
        try {

            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objMixBD = new MixRTqPCR_BD();

            $arr = $objMixBD->paginacao($objMix, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o placa.',$e);
        }
    }

}