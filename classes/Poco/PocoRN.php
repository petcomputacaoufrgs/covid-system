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
        return false;
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

        /*if(!self::mostrar_descricao_situacao_poco($objPoco->getSituacao())){
            $objExcecao->adicionar_validacao('A situação informada para o poço é inválida',null,'alert-danger');
        }*/


    }



    public function cadastrar(Poco $objPoco, $totalmente = null) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objPocoBD = new PocoBD();
            if($totalmente == 's'){
                if ($objPoco->getObjPlaca()->getObjProtocolo()->getNumDivisoes() == 1) {
                $incremento_na_placa_original = 0;
                } else if ($objPoco->getObjPlaca()->getObjProtocolo()->getNumDivisoes() == 2) {
                    $incremento_na_placa_original = 6;
                } else if ($objPoco->getObjPlaca()->getObjProtocolo()->getNumDivisoes() == 3) {
                    $incremento_na_placa_original = 4;
                } else if ($objPoco->getObjPlaca()->getObjProtocolo()->getNumDivisoes() == 4) {
                    $incremento_na_placa_original = 3;
                }

            //$error = false;
            //$arr_errors = array();

            $quantidade = 8;
            $letras = range('A', chr(ord('A') + $quantidade));

            $cols = (12 / count($objPoco->getObjPlaca()->getObjProtocolo()->getObjDivisao()));

            $tubo_placa = 0;
            $posicoes_array = 0;
            $cont = 1;
            $objPlaca = $objPoco->getObjPlaca();

            for ($j = 1; $j <= 12; $j++) {
                for ($i = 1; $i <= 8; $i++) {

                    if ($objPlaca->getObjsAmostras()[$tubo_placa] != null) {
                        //$posicao_tubo[$posicoes_array] = array('valor'=>$objPlaca->getObjsTubos()[$tubo_placa]->getIdTuboFk(),'x' => $i, 'y' => $j);
                        $posicao_tubo[$i][$j] = $objPlaca->getObjsAmostras()[$tubo_placa]->getNickname();

                        if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 3) {
                            $posicao_tubo[$i][$j + $incremento_na_placa_original] = $objPlaca->getObjsAmostras()[$tubo_placa]->getNickname();
                            $posicao_tubo[$i][$j + (2 * $incremento_na_placa_original)] = $objPlaca->getObjsAmostras()[$tubo_placa]->getNickname();
                        }
                    } else {

                        if ($cont == 1) {
                            //$posicao_tubo[$posicoes_array] = array('valor'=>'C+','x' => $i, 'y' => $j);
                            $posicao_tubo[$i][$j] = 'C+';

                            if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 3) {
                                $posicao_tubo[$i][$j + $incremento_na_placa_original] = 'C+';
                                $posicao_tubo[$i][$j + (2 * $incremento_na_placa_original)] = 'C+';
                            }
                        }
                        if ($cont == 2) {
                            //$posicao_tubo[$posicoes_array] = array('valor'=>'C-','x' => $i, 'y' => $j);
                            $posicao_tubo[$i][$j] = 'C-';
                            if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 3) {
                                $posicao_tubo[$i][$j + $incremento_na_placa_original] = 'C-';
                                $posicao_tubo[$i][$j + (2 * $incremento_na_placa_original)] = 'C-';
                            }
                        }
                        if ($cont == 3 || $cont == 4) {
                            //$posicao_tubo[$posicoes_array] = array('valor'=>'BR','x' => $i, 'y' => $j);
                            $posicao_tubo[$i][$j] = 'BR';
                            if ($objPlaca->getObjProtocolo()->getNumDivisoes() == 3) {
                                $posicao_tubo[$i][$j + $incremento_na_placa_original] = 'BR';
                                $posicao_tubo[$i][$j + (2 * $incremento_na_placa_original)] = 'BR';
                            }
                        }

                        if ($cont > 4) {
                            break;
                        }
                        $cont++;
                    }
                    $tubo_placa++;
                    $posicoes_array++;


                }
            }


            for ($j = 1; $j <= 12; $j++){
                for ($i = 1; $i <= 8; $i++){
                    $objPoco->setColuna($j);
                    $objPoco->setLinha($letras[$i-1]);
                    $objPoco->setConteudo($posicao_tubo[$i][$j]);
                    if($posicao_tubo[$i][$j] != '' && $posicao_tubo[$i][$j] != null){
                        $objPoco->setSituacao(PocoRN::$STA_OCUPADO);
                    }else{
                        $objPoco->setSituacao(PocoRN::$STA_LIBERADO);
                    }
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


            /*if($totalmente == 's') {
                $quantidade = 8;
                $letras = range('A', chr(ord('A') + $quantidade));
                $arr_pocos = array();
                for ($i = 1; $i <= 12; $i++) {
                    $objPoco->setColuna($i);
                    for ($j = 1; $j <= 8; $j++) {
                        $objPoco->setLinha($letras[$j-1]);

                        $poco = $objPocoBD->cadastrar($objPoco, $objBanco);



                    }
                }
            }*/}else {

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

    public function alterar_conteudo(Poco $objPoco) {
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
            $objPoco = $objPocoBD->alterar_conteudo($objPoco,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objPoco;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o poço.', $e);
        }
    }
}