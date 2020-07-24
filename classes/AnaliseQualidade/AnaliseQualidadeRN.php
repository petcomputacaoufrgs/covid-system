<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/AnaliseQualidadeBD.php';
require_once __DIR__ . '/../Situacao/Situacao.php';

class AnaliseQualidadeRN
{
    public static $TA_COM_QUALIDADE = 'C';
    public static $TA_SEM_QUALIDADE = 'S';

    public static function listarValoresTipoResultadoAnalise()
    {
        try {

            $arrObj= array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TA_COM_QUALIDADE);
            $objSituacao->setStrDescricao('COM QUALIDADE');
            $arrObj[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TA_SEM_QUALIDADE);
            $objSituacao->setStrDescricao('SEM QUALIDADE');
            $arrObj[] = $objSituacao;

            return $arrObj;

        } catch (Throwable $e) {
            throw new Excecao('Erro listando valores de Tipo estado da capela', $e);
        }
    }

    public static function mostrarDescricaoResultadoAnalise($strTipo){
        foreach (self::listarValoresTipoResultadoAnalise() as $tipo){
            if($tipo->getStrTipo() == $strTipo){
                return $tipo->getStrDescricao();
            }
        }
        return null;
    }

    private function validarIdAmostra(AnaliseQualidade $objAnaliseQualidade,Excecao $objExcecao){

        if ($objAnaliseQualidade->getIdAmostraFk() == null || $objAnaliseQualidade->getIdAmostraFk() <= 0) {
            $objExcecao->adicionar_validacao('O identificador da amostra não foi informado',null, 'alert-danger');
        }else{
            $numIdAmostra = trim($objAnaliseQualidade->getIdAmostraFk());
            $objAnaliseQualidade->setIdAmostraFk(intval($numIdAmostra));
        }
    }

    private function validarIdTuboFk(AnaliseQualidade $objAnaliseQualidade,Excecao $objExcecao){

        if ($objAnaliseQualidade->getIdTuboFk() == null || $objAnaliseQualidade->getIdTuboFk() <= 0) {
            $objExcecao->adicionar_validacao('O identificador do tubo da amostra não foi informado',null, 'alert-danger');
        }else{
            $numIdTubo = trim($objAnaliseQualidade->getIdTuboFk());
            $objAnaliseQualidade->setIdTuboFk(intval($numIdTubo));
        }
    }

    private function validarIdUsuario(AnaliseQualidade $objAnaliseQualidade,Excecao $objExcecao){

        if ($objAnaliseQualidade->getIdUsuarioFk() == null || $objAnaliseQualidade->getIdUsuarioFk() <= 0) {
            $objExcecao->adicionar_validacao('O identificador do usuário não foi informado',null, 'alert-danger');
        }else{
            $numIdUsuario = trim($objAnaliseQualidade->getIdUsuarioFk());
            $objAnaliseQualidade->setIdUsuarioFk(intval($numIdUsuario));
        }
    }

    private function validarObservacoes(AnaliseQualidade $objAnaliseQualidade,Excecao $objExcecao){
        if(!is_null($objAnaliseQualidade->getObservacoes())) {
            $strObervacoes = trim($objAnaliseQualidade->getObservacoes());
            if (strlen($strObervacoes) > 300) {
                $objExcecao->adicionar_validacao('As observações devem possuir, no máximo, 300 caracteres', null, 'alert-danger');
            }
        }
    }

    private function validarIdAnalise(AnaliseQualidade $objAnaliseQualidade,Excecao $objExcecao){

        if ($objAnaliseQualidade->getIdAnaliseQualidade() == null || $objAnaliseQualidade->getIdAnaliseQualidade() <= 0) {
            $objExcecao->adicionar_validacao('O identificador da análise de qualidade não foi informado',null, 'alert-danger');
        }else{
            $numIdAnalise = trim($objAnaliseQualidade->getIdAnaliseQualidade());
            $objAnaliseQualidade->setIdAnaliseQualidade(intval($numIdAnalise));
        }
    }

    private function validarDataHoraInicio(AnaliseQualidade $objAnaliseQualidade,Excecao $objExcecao){

        if ($objAnaliseQualidade->getDataHoraInicio() == null || $objAnaliseQualidade->getDataHoraInicio() <= 0) {
            $objExcecao->adicionar_validacao('A data/hora início da análise de qualidade não foi informada',null, 'alert-danger');
        }
    }

    private function validarDataHoraFim(AnaliseQualidade $objAnaliseQualidade,Excecao $objExcecao){

        if ($objAnaliseQualidade->getDataHoraFim() == null || $objAnaliseQualidade->getDataHoraFim() <= 0) {
            $objExcecao->adicionar_validacao('A data/hora fim da análise de qualidade não foi informada',null, 'alert-danger');
        }
    }

    private function validarResultado(AnaliseQualidade $objAnaliseQualidade,Excecao $objExcecao){

        if ($objAnaliseQualidade->getResultado() == null ) {
            $objExcecao->adicionar_validacao('O resultado da análise de qualidade não foi informado',null, 'alert-danger');
        }else{
            if(is_null(self::mostrarDescricaoResultadoAnalise($objAnaliseQualidade->getResultado()))){
                $objExcecao->adicionar_validacao('O resultado da análise de qualidade é inválido',null, 'alert-danger');
            }
        }
    }

    public function cadastrar(AnaliseQualidade $objAnaliseQualidade) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdUsuario($objAnaliseQualidade,$objExcecao);
            $this->validarObservacoes($objAnaliseQualidade,$objExcecao);
            $this->validarResultado($objAnaliseQualidade,$objExcecao);
            $this->validarIdAmostra($objAnaliseQualidade,$objExcecao);
            $this->validarIdTuboFk($objAnaliseQualidade,$objExcecao);
            $this->validarDataHoraInicio($objAnaliseQualidade,$objExcecao);
            $this->validarDataHoraFim($objAnaliseQualidade,$objExcecao);
            $objExcecao->lancar_validacoes();

            if($objAnaliseQualidade->getObjInfosTubo() != null){
                $objInfosTuboRN = new InfosTuboRN();
                if(is_array($objAnaliseQualidade->getObjInfosTubo())){
                    foreach ($objAnaliseQualidade->getObjInfosTubo() as $info){
                        $objInfosTubo = $objInfosTuboRN->cadastrar($info);
                    }
                }else{
                    $objInfosTubo = $objInfosTuboRN->cadastrar($objAnaliseQualidade->getObjInfosTubo());
                }
            }

            $objAnaliseQualidadeBD = new AnaliseQualidadeBD();
            $obj =$objAnaliseQualidadeBD->cadastrar($objAnaliseQualidade,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $obj;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando a análise de qualidade (AnaliseQualidadeRN).', $e);
        }
    }

    public function alterar(AnaliseQualidade $objAnaliseQualidade) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdAnalise($objAnaliseQualidade,$objExcecao);
            $this->validarIdUsuario($objAnaliseQualidade,$objExcecao);
            $this->validarObservacoes($objAnaliseQualidade,$objExcecao);
            $this->validarIdAmostra($objAnaliseQualidade,$objExcecao);
            $this->validarIdTuboFk($objAnaliseQualidade,$objExcecao);
            $this->validarDataHoraInicio($objAnaliseQualidade,$objExcecao);
            $this->validarDataHoraFim($objAnaliseQualidade,$objExcecao);
            $this->validarResultado($objAnaliseQualidade,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objAnaliseQualidadeBD = new AnaliseQualidadeBD();
            $objAnaliseQualidade = $objAnaliseQualidadeBD->alterar($objAnaliseQualidade,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objAnaliseQualidade;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando a análise de qualidade (AnaliseQualidadeRN).', $e);
        }
    }

    public function consultar(AnaliseQualidade $objAnaliseQualidade) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdAnalise($objAnaliseQualidade,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objAnaliseQualidadeBD = new AnaliseQualidadeBD();
            $arr =  $objAnaliseQualidadeBD->consultar($objAnaliseQualidade,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando a análise de qualidade (AnaliseQualidadeRN).',$e);
        }
    }

    public function remover(AnaliseQualidade $objAnaliseQualidade) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $this->validarIdAnalise($objAnaliseQualidade,$objExcecao);
            $objExcecao->lancar_validacoes();
            $objAnaliseQualidadeBD = new AnaliseQualidadeBD();
            $objAnaliseQualidadeBD->remover($objAnaliseQualidade,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();

        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo a análise de qualidade (AnaliseQualidadeRN).', $e);
        }
    }

    public function listar(AnaliseQualidade $objAnaliseQualidade) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objAnaliseQualidadeBD = new AnaliseQualidadeBD();

            $arr = $objAnaliseQualidadeBD->listar($objAnaliseQualidade,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando a análise de qualidade (AnaliseQualidadeRN).',$e);
        }
    }


}