<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/PocoBD.php';

require_once  __DIR__.'/../Situacao/Situacao.php';
class PocoRN
{
    //situcação do poço
    public static $STA_OCUPADO = 'O';
    public static $STA_LIBERADO = 'L';


    public static function listarTipoSituacaoPoco(){
        try {

            $arrObjTStaPoco = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$STA_OCUPADO);
            $objSituacao->setStrDescricao('Poço ocupado');
            $arrObjTStaPoco[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$STA_LIBERADO);
            $objSituacao->setStrDescricao('Poço liberado');
            $arrObjTEtapa[] = $objSituacao;

            return $arrObjTStaPoco;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de TIPO de protocolos',$e);
        }
    }

    public static function mostrar_descricao_situacao_poco($caractere){
        $arr = self::listarTipoSituacaoPoco();
        foreach ($arr as $a){
            if($a->getStrTipo() == $caractere ){
                return $a->getStrDescricao();
            }
        }
    }



    private function validarLinha(Poco $objPoco,Excecao $objExcecao){
        $strLinha = trim($objPoco->getLinha());

        if ($strLinha == '') {
            $objExcecao->adicionar_validacao('Informe a linha do poço',null,'alert-danger');
        }else{
            if (strlen($strLinha) > 6) {
                $objExcecao->adicionar_validacao('A linha do poço deve possuir no máximo 6 caracteres',null,'alert-danger');
            }
        }

        return $objPoco->setLinha($strLinha);

    }

    private function validarColuna(Poco $objPoco,Excecao $objExcecao){
        $strColuna = trim($objPoco->getColuna());

        if ($strColuna == '') {
            $objExcecao->adicionar_validacao('Informe a coluna do poço',null,'alert-danger');
        }else{
            if (strlen($strColuna) > 6) {
                $objExcecao->adicionar_validacao('A coluna do poço deve possuir no máximo 6 caracteres',null,'alert-danger');
            }
        }

        return $objPoco->setColuna($strColuna);

    }

    private function validarSituacao(Poco $objPoco,Excecao $objExcecao){
        $arr = self::listarTipoSituacaoPoco();
        $encontrou = false;
        foreach ($arr as $a){
            if($a->getStrTipo() == $objPoco->getSituacao() ){
                $encontrou = true;
            }
        }

        if(!$encontrou){
            $objExcecao->adicionar_validacao('A situação informada para o pocço é inválida',null,'alert-danger');
        }


    }



    public function cadastrar(Poco $objPoco, $totalmente = null) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objPocoBD = new PocoBD();
            if($totalmente == 's') {
                $quantidade = 8;
                $letras = range('A', chr(ord('A') + $quantidade));
                $arr_pocos = array();
                for ($i = 1; $i <= 12; $i++) {
                    $objPoco->setColuna($i);
                    for ($j = 1; $j <= 8; $j++) {
                        $objPoco->setLinha($letras[$j]);
                        $objPoco->setSituacao(PocoRN::$STA_LIBERADO);
                        $poco = $objPocoBD->cadastrar($objPoco, $objBanco);
                        if($objPoco->getObjPlaca() != null){
                            $objPocoPlaca = new PocoPlaca();
                            $objPocoPlacaRN = new PocoPlacaRN();
                            $objPocoPlaca->setIdPlacaFk($objPoco->getObjPlaca()->getIdPlaca());
                            $objPocoPlaca->setIdPocoFk($poco->getIdPoco());
                            $objPocoPlacaRN->cadastrar($objPocoPlaca);
                        }

                    }
                }
            }else {

                $this->validarColuna($objPoco,$objExcecao);
                $this->validarLinha($objPoco,$objExcecao);
                $this->validarSituacao($objPoco,$objExcecao);
                $objExcecao->lancar_validacoes();
                $objPocoBD->cadastrar($objPoco, $objBanco);

            }
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $poco;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o poço.', $e);
        }
    }

    public function alterar(Poco $objPoco) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarColuna($objPoco,$objExcecao);
            $this->validarLinha($objPoco,$objExcecao);
            $this->validarSituacao($objPoco,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objPocoBD = new PocoBD();
            $objPoco = $objPocoBD->alterar($objPoco,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objPoco;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o poço.', $e);
        }
    }

    public function consultar(Poco $objPoco) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPocoBD = new PocoBD();
            $arr =  $objPocoBD->consultar($objPoco,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o poço.',$e);
        }
    }

    public function remover(Poco $objPoco) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPocoBD = new PocoBD();

            $objExcecao->lancar_validacoes();

            $arr =  $objPocoBD->remover($objPoco,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o poço.', $e);
        }
    }

    public function listar(Poco $objPoco) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPocoBD = new PocoBD();

            $arr = $objPocoBD->listar($objPoco,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o poço.',$e);
        }
    }
}