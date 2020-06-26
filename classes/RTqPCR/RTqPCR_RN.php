<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/RTqPCR_BD.php';


class RTqPCR_RN
{
    public static $STA_EM_ANDAMENTO = 'A';
    public static $STA_FINALIZADO = 'F';
    public static $STA_ATRASADO = 'S';


    public static function listarValoresStaRTqPCR(){
        try {

            $arrObjTEtapa = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$STA_EM_ANDAMENTO);
            $objSituacao->setStrDescricao('RTqPCR em andamento');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$STA_ATRASADO);
            $objSituacao->setStrDescricao('RTqPCR ultrapassou o tempo');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$STA_FINALIZADO);
            $objSituacao->setStrDescricao('RTqPCR finalizado');
            $arrObjTEtapa[] = $objSituacao;


            return $arrObjTEtapa;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Situação da placa',$e);
        }
    }

    public static function mostrarDescricaoRTqPCR($descricao){
        $arr = self::listarValoresStaRTqPCR();
        foreach ($arr as $a){
            if($a->getStrTipo() == $descricao ){
                return $a->getStrDescricao();
            }
        }
    }


    private function validarIdPlaca(RTqPCR $objRTqPCR,Excecao $objExcecao){
        if(is_null($objRTqPCR->getIdPlacaFk())){
            $objExcecao->adicionar_validacao('O identificador da placa não foi informado',null,'alert-danger');
        }
    }

    private function validarIdEquipamento(RTqPCR $objRTqPCR,Excecao $objExcecao){
        if(is_null($objRTqPCR->getIdPlacaFk())){
            $objExcecao->adicionar_validacao('O identificador do equipamento não foi informado',null,'alert-danger');
        }
    }

    private function validarIdRTqPCR(RTqPCR $objRTqPCR,Excecao $objExcecao){
        if(is_null($objRTqPCR->getIdRTqPCR())){
            $objExcecao->adicionar_validacao('O identificador do RTqCPCR não foi informado',null,'alert-danger');
        }
    }

    private function validarIdUsuario(RTqPCR $objRTqPCR,Excecao $objExcecao){
        if(is_null($objRTqPCR->getIdUsuarioFk())){
            $objExcecao->adicionar_validacao('O identificador do usuário não foi informado',null,'alert-danger');
        }
    }

    private function validarDataHoraInicio(RTqPCR $objRTqPCR,Excecao $objExcecao){
        $strPlaca = trim($objRTqPCR->getDataHoraInicio());
        if(is_null($strPlaca)){
            $objExcecao->adicionar_validacao('A data hora início do RTqPCR não foi informada',null,'alert-danger');
        }
    }

    private function validarDataHoraFim(RTqPCR $objRTqPCR,Excecao $objExcecao){
        $strPlaca = trim($objRTqPCR->getDataHoraFim());
        if(is_null($strPlaca)){
            $objExcecao->adicionar_validacao('A data hora fim do RTqPCR não foi informada',null,'alert-danger');
        }
    }

    private function validarSituacaoRTqPCR(RTqPCR $objRTqPCR,Excecao $objExcecao){
        if(is_null(self::mostrarDescricaoRTqPCR($objRTqPCR->getSituacaoRTqPCR()))){
            $objExcecao->adicionar_validacao('A situação do RTqCPCR é inválida',null,'alert-danger');
        }
    }


    public function cadastrar(RTqPCR $objRTqPCR) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdPlaca($objRTqPCR,$objExcecao);
            $this->validarIdEquipamento($objRTqPCR,$objExcecao);
            $this->validarIdUsuario($objRTqPCR,$objExcecao);
            $this->validarDataHoraInicio($objRTqPCR,$objExcecao);
            $this->validarDataHoraFim($objRTqPCR,$objExcecao);
            $this->validarSituacaoRTqPCR($objRTqPCR,$objExcecao);

            if($objRTqPCR->getObjPlaca() != null){
                $objPlacaRN = new PlacaRN();

                //alterar infos
                if(is_array($objRTqPCR->getObjPlaca()->getObjsTubos())){
                    $objInfosTuboRN = new InfosTuboRN();
                    foreach ($objRTqPCR->getObjPlaca()->getObjsTubos() as $info){
                        $objInfosTuboRN->cadastrar($info);
                    }
                    $objRTqPCR->getObjPlaca()->setObjsTubos(null);
                }

                $objPlacaRN->alterar($objRTqPCR->getObjPlaca());
            }

            if($objRTqPCR->getObjEquipamento() != null){
                $objEquipamentoRN = new EquipamentoRN();
                $objEquipamentoRN->bloquear_registro($objRTqPCR->getObjEquipamento());
            }


            $objExcecao->lancar_validacoes();
            $objRTqPCR_BD = new RTqPCR_BD();
            $RTqPCR = $objRTqPCR_BD->cadastrar($objRTqPCR,$objBanco);


            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $RTqPCR;
        } catch (Throwable $e) {

            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o RTqPCR.', $e);
        }
    }

    public function alterar(RTqPCR $objRTqPCR) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdRTqPCR($objRTqPCR,$objExcecao);
            $this->validarIdPlaca($objRTqPCR,$objExcecao);
            $this->validarIdEquipamento($objRTqPCR,$objExcecao);
            $this->validarIdUsuario($objRTqPCR,$objExcecao);
            $this->validarDataHoraInicio($objRTqPCR,$objExcecao);
            $this->validarDataHoraFim($objRTqPCR,$objExcecao);
            $this->validarSituacaoRTqPCR($objRTqPCR,$objExcecao);

            $objExcecao->lancar_validacoes();

            if($objRTqPCR->getObjPlaca() != null){
                $objPlacaRN = new PlacaRN();
                $objInfosTuboRN = new InfosTuboRN();
                if($objRTqPCR->getSituacaoRTqPCR() == RTqPCR_RN::$STA_FINALIZADO){
                    //$objPlacaRN->alterar($objRTqPCR->getObjPlaca());
                    if (is_array($objRTqPCR->getObjPlaca()->getObjsTubos())) {
                        foreach ($objRTqPCR->getObjPlaca()->getObjsTubos() as $tubo){
                            if(is_array($tubo->getObjInfosTubo())) {
                                foreach ($tubo->getObjInfosTubo() as $info) {
                                    $objInfosTuboRN->cadastrar($info);
                                }
                            }else{
                                $objInfosTuboRN->cadastrar($tubo->getObjInfosTubo());
                            }
                        }
                    }

                }else {
                    //alterar infos
                    if (is_array($objRTqPCR->getObjPlaca()->getObjsTubos())) {
                        $objInfosTuboRN = new InfosTuboRN();
                        foreach ($objRTqPCR->getObjPlaca()->getObjsTubos() as $info) {
                            $objInfosTuboRN->cadastrar($info);
                        }
                        $objRTqPCR->getObjPlaca()->setObjsTubos(null);
                    }


                    $objPlacaRN->alterar($objRTqPCR->getObjPlaca());
                }
            }

            $objRTqPCR_BD = new RTqPCR_BD();
            $RTqPCR = $objRTqPCR_BD->alterar($objRTqPCR,$objBanco);


            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $RTqPCR;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o RTqPCR.', $e);
        }
    }

    public function consultar(RTqPCR $objRTqPCR) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objRTqPCR_BD = new RTqPCR_BD();
            $arr =  $objRTqPCR_BD->consultar($objRTqPCR,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o RTqPCR.',$e);
        }
    }

    public function listar(RTqPCR $objRTqPCR,$numLimite =null) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objRTqPCR_BD = new RTqPCR_BD();
            $arr =  $objRTqPCR_BD->listar($objRTqPCR,$numLimite,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o RTqPCR.',$e);
        }
    }

    public function remover(RTqPCR $objRTqPCR) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objRTqPCR_BD = new RTqPCR_BD();

            //$this->validar_existe_RTqPCR_com_a_placa($objRTqPCR, $objExcecao);
            $objExcecao->lancar_validacoes();

            $arr =  $objRTqPCR_BD->remover($objRTqPCR,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o RTqPCR.', $e);
        }
    }

    public function paginacao(RTqPCR $objRTqPCR) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objRTqPCR_BD = new RTqPCR_BD();


            $objExcecao->lancar_validacoes();

            $arr =  $objRTqPCR_BD->paginacao($objRTqPCR,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro paginação o RTqPCR.', $e);
        }
    }
}