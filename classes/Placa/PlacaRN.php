<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/PlacaBD.php';

require_once __DIR__ . '/../Situacao/Situacao.php';
class PlacaRN
{
    public static $STA_SOLICITACAO_MONTAGEM = 'S';
    public static $STA_AGUARDANDO_MIX = 'X';

    public static function listarValoresStaPlaca(){
        try {

            $arrObjTEtapa = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$STA_SOLICITACAO_MONTAGEM);
            $objSituacao->setStrDescricao('Solicitação montagem placa');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$STA_AGUARDANDO_MIX);
            $objSituacao->setStrDescricao('Aguardando Mix');
            $arrObjTEtapa[] = $objSituacao;


            return $arrObjTEtapa;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Situação da placa',$e);
        }
    }

    public static function mostrar_descricao_staPlaca($situacaoPlaca){
        $arr = self::listarValoresStaPlaca();
        foreach ($arr as $a){
            if($a->getStrTipo() == $situacaoPlaca ){
                return $a->getStrDescricao();
            }
        }
    }


    private function validarPlaca(Placa $objPlaca,Excecao $objExcecao){
        $strPlaca = trim($objPlaca->getPlaca());

        if ($strPlaca == '') {
            $objExcecao->adicionar_validacao('A placa não foi informada',null,'alert-danger');
        }else{
            if (strlen($strPlaca) > 150) {
                $objExcecao->adicionar_validacao('O placa deve possuir no máximo 150 caracteres',null,'alert-danger');
            }
        }

        return $objPlaca->setPlaca($strPlaca);

    }

    private function validarIdProtocolo(Placa $objPlaca,Excecao $objExcecao){

        if ($objPlaca->getIdProtocoloFk() == '' || $objPlaca->getIdProtocoloFk() == null || $objPlaca->getIdProtocoloFk() == -1 ) {
            $objExcecao->adicionar_validacao('Informe o protocolo da placa',null,'alert-danger');
        }
    }


    private function validar_existe_placa(Placa $objPlaca,Excecao $objExcecao){
        $objPlacaRN= new PlacaRN();
        if($objPlacaRN->ja_existe_placa($objPlaca)){
            $objExcecao->adicionar_validacao('A placa informada já existe',null,'alert-danger');
        }
    }

    private function validar_existe_RTqPCR_com_a_placa(Placa $objPlaca,Excecao $objExcecao){
        $objPlacaRN= new PlacaRN();
        if($objPlacaRN->existe_placa_com_placa($objPlaca)){
            $objExcecao->adicionar_validacao('Existe ao menos um RTqPCR associada a este placa. Logo, ela não pode ser excluído',null,'alert-danger');
        }
    }

    public function cadastrar(Placa $objPlaca) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

           // $this->validarPlaca($objPlaca,$objExcecao);
            $this->validarIdProtocolo($objPlaca,$objExcecao);
            $this->validar_existe_placa($objPlaca,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objPlacaBD = new PlacaBD();
            $placa  = $objPlacaBD->cadastrar($objPlaca,$objBanco);

            if($objPlaca->getObjsTubos() != null){
                $objRelTuboPlaca = new RelTuboPlaca();
                $objRelTuboPlacaRN = new RelTuboPlacaRN();
                $objRelTuboPlaca->setIdPlacaFk($placa->getIdPlaca());
                foreach ($objPlaca->getObjsTubos() as $tubo){
                    $objInfosTuboRN = new InfosTuboRN();
                    if($tubo->getObjInfosTubo() != null){
                        foreach ($tubo->getObjInfosTubo() as $info){
                            $objInfosTuboRN->cadastrar($info);
                        }
                    }

                    $objRelTuboPlaca->setIdTuboFk($tubo->getIdTubo());
                    $objRelTuboPlacaRN->cadastrar($objRelTuboPlaca);

                }
            }


            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objPlaca;
        } catch (Throwable $e) {

            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o placa.', $e);
        }
    }

    public function alterar(Placa $objPlaca) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();


            //$this->validarPlaca($objPlaca,$objExcecao);
            //$this->validar_existe_placa($objPlaca,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objPlacaBD = new PlacaBD();
            $placa = $objPlacaBD->alterar($objPlaca,$objBanco);

            if($objPlaca->getObjsTubos() != null) {
                //procurar pelo rel_tubo_lote
                $objRelTuboPlaca = new RelTuboPlaca();
                $objRelTuboPlacaRN = new RelTuboPlacaRN();
                $objRelTuboPlaca->setIdPlacaFk($placa->getIdPlaca());
                $arr_tubos_placa = $objRelTuboPlacaRN->listar($objRelTuboPlaca);

                $remover_relac = array();
                foreach ($arr_tubos_placa as $tubo) {
                    $encontrou = false;
                    foreach ($placa->getObjsTubos() as $t) {
                        if ($t->getIdTubo() == $tubo->getIdTuboFk()) {
                            $encontrou = true;
                            if ($t->getObjInfosTubo() != null) {
                                foreach ($t->getObjInfosTubo() as $info) {
                                    $objInfosTuboRN = new InfosTuboRN();
                                    $objInfosTuboRN->cadastrar($info);
                                }
                            }

                        }
                    }

                    if (!$encontrou) {
                        $remover_relac[] = $tubo;
                        $objInfosTubo = new InfosTubo();
                        $objInfosTuboRN = new InfosTuboRN();
                        $objInfosTubo->setIdTubo_fk($tubo->getIdTuboFk());
                        $objInfosTubo = $objInfosTuboRN->pegar_ultimo($objInfosTubo);
                        if ($objInfosTubo->getSituacaoTubo() == InfosTuboRN::$TST_EM_UTILIZACAO) {
                            $objInfosTuboRN->remover($objInfosTubo);
                        }

                    }
                }


                foreach ($remover_relac as $relTuboPlaca) {

                    $objRelTuboPlacaRN->remover($relTuboPlaca);
                }
            }

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objPlaca;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o placa.', $e);
        }
    }

    public function consultar(Placa $objPlaca) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPlacaBD = new PlacaBD();
            $arr =  $objPlacaBD->consultar($objPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o placa.',$e);
        }
    }
    public function consultar_completo(Placa $objPlaca) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPlacaBD = new PlacaBD();
            $arr =  $objPlacaBD->consultar_completo($objPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o placa.',$e);
        }
    }

    public function remover(Placa $objPlaca) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPlacaBD = new PlacaBD();

            $this->validar_existe_placa_com_o_placa($objPlaca, $objExcecao);
            $objExcecao->lancar_validacoes();

            $arr =  $objPlacaBD->remover($objPlaca,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o placa.', $e);
        }
    }

    public function listar(Placa $objPlaca) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPlacaBD = new PlacaBD();

            $arr = $objPlacaBD->listar($objPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o placa.',$e);
        }
    }

    public function ja_existe_placa(Placa $objPlaca) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPlacaBD = new PlacaBD();

            $arr = $objPlacaBD->ja_existe_placa($objPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro verificando se já existe o placa.',$e);
        }
    }




    public function existe_placa_com_placa(Placa $objPlaca) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPlacaBD = new PlacaBD();

            $bool = $objPlacaBD->existe_placa_com_o_placa($objPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $bool;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro verificando se existe placa com o placa.',$e);
        }
    }
}