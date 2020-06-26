<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/DiagnosticoBD.php';
class DiagnosticoRN
{
    public static $STA_POSITIVO = 'P';
    public static $STA_NEGATIVO = 'N';
    public static $STA_INCONCLUSIVO = 'I';

    public static $STA_ANDAMENTO = 'A';
    public static $STA_FINALIZADO = 'F';


    public static function listarValoresSituacaoDiagnostico(){
        try {

            $arrObj = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$STA_POSITIVO);
            $objSituacao->setStrDescricao('POSITIVO');
            $arrObj[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$STA_NEGATIVO);
            $objSituacao->setStrDescricao('NEGATIVO');
            $arrObj[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$STA_INCONCLUSIVO);
            $objSituacao->setStrDescricao('INCONCLUSIVO');
            $arrObj[] = $objSituacao;

            return $arrObj;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de SITUAÇÃO do diagnóstico',$e);
        }
    }


    public static function mostrarDescricaoSituacao($strSituacao){
        foreach (self::listarValoresSituacaoDiagnostico() as $tipo){
            if($tipo->getStrTipo() == $strSituacao){
                return $tipo->getStrDescricao();
            }
        }
        return null;
    }

    public static function listarValoresStatus(){
        try {

            $arrObj = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$STA_FINALIZADO);
            $objSituacao->setStrDescricao('FINALIZADO');
            $arrObj[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$STA_ANDAMENTO);
            $objSituacao->setStrDescricao('EM ANDAMENTO');
            $arrObj[] = $objSituacao;

            return $arrObj;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de STATUS do diagnóstico',$e);
        }
    }


    public static function mostrarDescricaoStatus($strSituacao){
        foreach (self::listarValoresStatus() as $tipo){
            if($tipo->getStrTipo() == $strSituacao){
                return $tipo->getStrDescricao();
            }
        }
        return null;
    }

    private function validarObservacoes(Diagnostico $objDiagnostico,Excecao $objExcecao){
        $strObs = trim($objDiagnostico->getObservacoes());
        if(strlen($strObs) > 300){
            $objExcecao->adicionar_validacao('As observações devem possuir no máximo 300 caracteres',null,'alert-danger');
        }
    }
    private function validarDiagnostico(Diagnostico $objDiagnostico,Excecao $objExcecao){

        if(is_null(self::mostrarDescricaoSituacao($objDiagnostico->getDiagnostico()))){
            $objExcecao->adicionar_validacao('O diagnóstico informado é inválido',null,'alert-danger');
        }else if(is_null($objDiagnostico->getDiagnostico())){
            $objExcecao->adicionar_validacao('O diagnóstico não foi informado',null,'alert-danger');
        }
    }
    private function validarIdDiagnostico(Diagnostico $objDiagnostico,Excecao $objExcecao){
        if(is_null($objDiagnostico->getIdDiagnostico())){
            $objExcecao->adicionar_validacao('O id do diagnóstico não foi informado',null,'alert-danger');
        }
    }
    private function validarIdAmostra(Diagnostico $objDiagnostico,Excecao $objExcecao){
        if(is_null($objDiagnostico->getIdAmostraFk())){
            $objExcecao->adicionar_validacao('O id da amostra não foi informado',null,'alert-danger');
        }
    }
    private function validarIdUsuario(Diagnostico $objDiagnostico,Excecao $objExcecao){

        if(is_null($objDiagnostico->getIdUsuarioFk())){
            $objExcecao->adicionar_validacao('O id do usuário que realizou o diagnóstico não foi informado',null,'alert-danger');
        }
    }
    private function validarDataHoraInicio(Diagnostico $objDiagnostico,Excecao $objExcecao){

        if(is_null($objDiagnostico->getDataHoraInicio())){
            $objExcecao->adicionar_validacao('A data/hora do início do diagnóstico não foi informado',null,'alert-danger');
        }
    }
    private function validarDataHoraFim(Diagnostico $objDiagnostico,Excecao $objExcecao){

        if(is_null($objDiagnostico->getDataHoraFim())){
            $objExcecao->adicionar_validacao('A data/hora do fim do diagnóstico não foi informado',null,'alert-danger');
        }
    }


    public function cadastrar(Diagnostico $objDiagnostico) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdUsuario($objDiagnostico,$objExcecao);
            $this->validarIdAmostra($objDiagnostico,$objExcecao);
            $this->validarObservacoes($objDiagnostico,$objExcecao);
            $this->validarDiagnostico($objDiagnostico,$objExcecao);
            $this->validarDataHoraInicio($objDiagnostico,$objExcecao);
            $this->validarDataHoraFim($objDiagnostico,$objExcecao);


            $objExcecao->lancar_validacoes();
            $objDiagnosticoBD = new DiagnosticoBD();
            $diagnostico = $objDiagnosticoBD->cadastrar($objDiagnostico,$objBanco);

            if($objDiagnostico->getObjInfosTubo() != null){
                if(is_array($objDiagnostico->getObjInfosTubo())){
                    $objInfosTuboRN = new InfosTuboRN();
                    foreach ($objDiagnostico->getObjInfosTubo() as $info){
                        $objInfosTuboRN->cadastrar($info);
                    }
                }
            }

            if($objDiagnostico->getObjLaudo() != null){
                $objLaudoRN = new LaudoRN();
                if(!is_array($objDiagnostico->getObjLaudo())){
                    $laudo = $objLaudoRN->cadastrar($objDiagnostico->getObjLaudo());
                    $diagnostico->setObjLaudo($laudo);
                }
            }

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $diagnostico;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o diagnóstico.', $e);
        }
    }

    public function alterar(Diagnostico $objDiagnostico) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdUsuario($objDiagnostico,$objExcecao);
            $this->validarIdAmostra($objDiagnostico,$objExcecao);
            $this->validarObservacoes($objDiagnostico,$objExcecao);
            $this->validarDiagnostico($objDiagnostico,$objExcecao);
            $this->validarIdDiagnostico($objDiagnostico,$objExcecao);
            $this->validarDataHoraInicio($objDiagnostico,$objExcecao);
            $this->validarDataHoraFim($objDiagnostico,$objExcecao);

            $objExcecao->lancar_validacoes();

            $objDiagnosticoBD = new DiagnosticoBD();
            $objEquipamento = $objDiagnosticoBD->alterar($objDiagnostico,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objEquipamento;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o diagnóstico.', $e);
        }
    }

    public function consultar(Diagnostico $objDiagnostico) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdDiagnostico($objDiagnostico,$objExcecao);
            $objExcecao->lancar_validacoes();
            $objDiagnosticoBD = new DiagnosticoBD();
            $arr =  $objDiagnosticoBD->consultar($objDiagnostico,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o diagnóstico.',$e);
        }
    }

    public function remover(Diagnostico $objDiagnostico) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdDiagnostico($objDiagnostico,$objExcecao);
            $objExcecao->lancar_validacoes();
            $objDiagnosticoBD = new DiagnosticoBD();
            $arr =  $objDiagnosticoBD->remover($objDiagnostico,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o diagnóstico.', $e);
        }
    }

    public function listar(Diagnostico $objDiagnostico,$numLimite = null) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objDiagnosticoBD = new DiagnosticoBD();

            $arr = $objDiagnosticoBD->listar($objDiagnostico,$numLimite,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o diagnóstico.',$e);
        }
    }

    /**** EXTRAS ****/
    public function listar_completo(Diagnostico $objDiagnostico,$numLimite = null) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objDiagnosticoBD = new DiagnosticoBD();

            $arr = $objDiagnosticoBD->listar_completo($objDiagnostico,$numLimite,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o diagnóstico completo.',$e);
        }
    }

    public function paginacao(Diagnostico $objDiagnostico) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objDiagnosticoBD = new DiagnosticoBD();
            $arr =  $objDiagnosticoBD->paginacao($objDiagnostico,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o diagnóstico.',$e);
        }
    }
}