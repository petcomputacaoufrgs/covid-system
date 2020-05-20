<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/ProtocoloBD.php';

require_once __DIR__ . '/../Situacao/Situacao.php';

class ProtocoloRN
{
    //tipo protocolo
    public static $TP_LACEN_IBMP = 'L';
    public static $TP_NEWGENE = 'N';
    public static $SL_AGPATH = 'A';
    public static $SL_AGPATH_CHARITE = 'E';


    public static function listarTiposProtocolos(){
        try {

            $arrObjTEtapa = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TP_LACEN_IBMP);
            $objSituacao->setStrDescricao('Protocolo LACEN/IBMP');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TP_NEWGENE);
            $objSituacao->setStrDescricao('Protocolo newgene Preamp');
            $arrObjTEtapa[] = $objSituacao;


            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$SL_AGPATH);
            $objSituacao->setStrDescricao('Protocolo Agpath');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$SL_AGPATH_CHARITE);
            $objSituacao->setStrDescricao('Protocolo Agpath/Charité');
            $arrObjTEtapa[] = $objSituacao;

            return $arrObjTEtapa;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de TIPO de protocolos',$e);
        }
    }

    public static function mosrtrar_descricao_tipo_protocolo($caractere){
        $arr = self::listarTiposProtocolos();
        foreach ($arr as $a){
            if($a->getStrTipo() == $caractere ){
                return $a->getStrDescricao();
            }
        }
    }

    private function validarProtocolo(Protocolo $objProtocolo,Excecao $objExcecao){
        $strProtocolo = trim($objProtocolo->getProtocolo());

        if ($strProtocolo == '') {
            $objExcecao->adicionar_validacao('O protocolo não foi informado',null,'alert-danger');
        }else{
            if (strlen($strProtocolo) > 150) {
                $objExcecao->adicionar_validacao('O protocolo deve possuir no máximo 150 caracteres',null,'alert-danger');
            }
        }

        return $objProtocolo->setProtocolo($strProtocolo);

    }


    private function validar_existe_protocolo(Protocolo $objProtocolo,Excecao $objExcecao){
        $objProtocoloRN= new ProtocoloRN();
        if($objProtocoloRN->ja_existe_protocolo($objProtocolo)){
            $objExcecao->adicionar_validacao('O protocolo informado já existe',null,'alert-danger');
        }
    }

    private function validar_existe_placa_com_o_protocolo(Protocolo $objProtocolo,Excecao $objExcecao){
        $objProtocoloRN= new ProtocoloRN();
        if($objProtocoloRN->existe_placa_com_protocolo($objProtocolo)){
            $objExcecao->adicionar_validacao('Existe ao menos uma placa associada a este protocolo. Logo, ele não pode ser excluído',null,'alert-danger');
        }
    }

    public function cadastrar(Protocolo $objProtocolo) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();


            $this->validarProtocolo($objProtocolo,$objExcecao);
            $this->validar_existe_protocolo($objProtocolo,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objProtocoloBD = new ProtocoloBD();
            $objProtocolo  = $objProtocoloBD->cadastrar($objProtocolo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objProtocolo;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o protocolo.', $e);
        }
    }

    public function alterar(Protocolo $objProtocolo) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();


            $this->validarProtocolo($objProtocolo,$objExcecao);
            $this->validar_existe_protocolo($objProtocolo,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objProtocoloBD = new ProtocoloBD();
            $protocolo = $objProtocoloBD->alterar($objProtocolo,$objBanco);


            if($objProtocolo->getObjDivisao() != null){

                /* DIVISÃO PROTOCOLO */
                $objDivisaoProtocoloRN = new DivisaoProtocoloRN();

                if(is_array($objProtocolo->getObjDivisao())){
                    foreach ($objProtocolo->getObjDivisao() as $divisao){
                        if($divisao->getIdDivisaoProtocolo() == null){ //cadastrar
                            $objDivisaoProtocoloRN->cadastrar($divisao);
                        }else{ //alterar
                            $objDivisaoProtocoloRN->alterar($divisao);
                        }
                    }

                }else if($objProtocolo->getObjDivisao()->getIdDivisaoProtocolo() == null){ //cadastrar

                }else{ //alterar

                }
            }

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $protocolo;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o protocolo.', $e);
        }
    }

    public function consultar(Protocolo $objProtocolo) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objProtocoloBD = new ProtocoloBD();
            $arr =  $objProtocoloBD->consultar($objProtocolo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o protocolo.',$e);
        }
    }

    public function remover(Protocolo $objProtocolo) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objProtocoloBD = new ProtocoloBD();

            $this->validar_existe_placa_com_o_protocolo($objProtocolo, $objExcecao);
            $objExcecao->lancar_validacoes();

            $objDivisaoProtocolo = new DivisaoProtocolo();
            $objDivisaoProtocoloRN = new DivisaoProtocoloRN();
            $objDivisaoProtocolo->setIdProtocoloFk($objProtocolo->getIdProtocolo());
            $arr_divs = $objDivisaoProtocoloRN->listar($objDivisaoProtocolo);
            if(count($arr_divs) > 0){
                foreach ($arr_divs as $divisao){
                    $objDivisaoProtocoloRN->remover($divisao);
                }
            }

            $arr =  $objProtocoloBD->remover($objProtocolo,$objBanco);



            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o protocolo.', $e);
        }
    }

    public function listar(Protocolo $objProtocolo) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objProtocoloBD = new ProtocoloBD();

            $arr = $objProtocoloBD->listar($objProtocolo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o protocolo.',$e);
        }
    }

    public function ja_existe_protocolo(Protocolo $objProtocolo) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objProtocoloBD = new ProtocoloBD();

            $arr = $objProtocoloBD->ja_existe_protocolo($objProtocolo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro verificando se já existe o protocolo.',$e);
        }
    }




    public function existe_placa_com_protocolo(Protocolo $objProtocolo) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objProtocoloBD = new ProtocoloBD();

            $bool = $objProtocoloBD->existe_placa_com_o_protocolo($objProtocolo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $bool;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro verificando se existe placa com o protocolo.',$e);
        }
    }
}