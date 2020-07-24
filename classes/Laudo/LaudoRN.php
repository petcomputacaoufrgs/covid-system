<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/LaudoBD.php';

require_once __DIR__ . '/../Situacao/Situacao.php';

require_once __DIR__ . '/../Amostra/Amostra.php';
require_once __DIR__ . '/../Amostra/AmostraRN.php';

require_once __DIR__ . '/../Paciente/Paciente.php';
require_once __DIR__ . '/../Paciente/PacienteRN.php';



class LaudoRN
{
    //resultado do laudo
    public static $RL_POSITIVO = 'P';
    public static $RL_NEGATIVO = 'N';
    public static $RL_INCONCLUSIVO = 'I';
    public static $RL_RECUSADO_RECEPCAO = 'R';
    public static $RL_PROBLEMAS_PREPARACAO = 'A';
    public static $RL_PROBLEMAS_EXTRACAO = 'E';

    //situação do laudo
    public static $SL_PENDENTE = 'P';
    public static $SL_CONCLUIDO = 'C';

    //descartar ou devolver amostra
    public static $DD_DESCARTE = 'R';
    public static $DD_DEVOLVER = 'L';


    public static function listarValoresResultado(){
        try {

            $arrObjTEtapa = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$RL_POSITIVO);
            $objSituacao->setStrDescricao('DETECTADO');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$RL_NEGATIVO);
            $objSituacao->setStrDescricao('NÃO-DETECTADO');
            $arrObjTEtapa[] = $objSituacao;


            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$RL_INCONCLUSIVO);
            $objSituacao->setStrDescricao('INCONCLUSIVO');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$RL_RECUSADO_RECEPCAO);
            $objSituacao->setStrDescricao('RECUSADA - na recepção');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$RL_PROBLEMAS_PREPARACAO);
            $objSituacao->setStrDescricao('PROBLEMA - na preparação');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$RL_PROBLEMAS_EXTRACAO);
            $objSituacao->setStrDescricao('PROBLEMA - na extração');
            $arrObjTEtapa[] = $objSituacao;


            return $arrObjTEtapa;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Tipo estado da capela',$e);
        }
    }

    public static function listarValoresStaLaudo(){
        try {

            $arrObjTEtapa = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$SL_PENDENTE);
            $objSituacao->setStrDescricao('PENDENTE');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$SL_CONCLUIDO);
            $objSituacao->setStrDescricao('CONCLUÍDO');
            $arrObjTEtapa[] = $objSituacao;

            return $arrObjTEtapa;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Tipo estado da capela',$e);
        }
    }

    public static function listarValoresDDLaudo(){
        try {

            $arr = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$DD_DESCARTE);
            $objSituacao->setStrDescricao('DESCARTE');
            $arr[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$DD_DEVOLVER);
            $objSituacao->setStrDescricao('DEVOLVER');
            $arr[] = $objSituacao;

            return $arr;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de DD no Laudo RN',$e);
        }
    }


    public static function mostrarDescricaoStaLaudo($caractere){

        foreach (self::listarValoresStaLaudo() as $sta){
            if($sta->getStrTipo() == $caractere){
                return $sta->getStrDescricao();
            }
        }
        return null;
    }

    public static function mostrarDescricaoResultado($caractere){
        foreach (self::listarValoresResultado() as $sta){
            if($sta->getStrTipo() == $caractere){
                return $sta->getStrDescricao();
            }
        }
        return null;
    }

    public static function mostrarDescricaoDD($caractere){
        foreach (self::listarValoresDDLaudo() as $sta){
            if($sta->getStrTipo() == $caractere){
                return $sta->getStrDescricao();
            }
        }
        return null;
    }


    private function validarObservacoes(Laudo $laudo,Excecao $objExcecao){

        if($laudo->getObservacoes() != null) {
            $strObservacoes = trim($laudo->getObservacoes());


            if (strlen($strObservacoes) > 300) {
                $objExcecao->adicionar_validacao('As observações do laudo possuem mais de 300 caracteres.', null, 'alert-danger');
            }

            $laudo->setObservacoes($strObservacoes);
        }

    }

    private function validarDD(Laudo $laudo,Excecao $objExcecao){

        if($laudo->getDescarteDevolver() != null) {
            if(is_null(self::listarValoresDDLaudo())){
                $objExcecao->adicionar_validacao('O devolver ou descartar tem um valor inválido', null, 'alert-danger');
            }

        }

    }

    private function validarIdLaudo(Laudo $laudo,Excecao $objExcecao){

        if($laudo->getIdLaudo() == null) {
            $objExcecao->adicionar_validacao('O identificar do laudo não foi informado', null, 'alert-danger');
        }

    }

    private function validarResultado(Laudo $laudo,Excecao $objExcecao){

        if($laudo->getResultado() == null || strlen($laudo->getResultado()) == 0) {
            $objExcecao->adicionar_validacao('O resultado do laudo não foi informado', null, 'alert-danger');
        }else{
            if(is_null(self::mostrarDescricaoResultado($laudo->getResultado()))){
                $objExcecao->adicionar_validacao('O resultado do laudo que foi informado é inválido', null, 'alert-danger');
            }
        }

    }

    public function cadastrar(Laudo $laudo) {
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objLaudoBD = new LaudoBD();

            $this->validarObservacoes($laudo,$objExcecao);
            $this->validarDD($laudo,$objExcecao);
            $this->validarResultado($laudo,$objExcecao);
            $objExcecao->lancar_validacoes();
            if($laudo->getObjInfosTubo() != null){
                $objInfosTuboRN = new InfosTuboRN();
                if(is_array($laudo->getObjInfosTubo())){
                    foreach ($laudo->getObjInfosTubo() as $info){
                        $objInfosTuboRN->cadastrar($info);
                    }
                }else{
                    $objInfosTuboRN->cadastrar($laudo->getObjInfosTubo());
                }
            }


            $laudoCadastro = $objLaudoBD->cadastrar($laudo,$objBanco);

            if(!is_null($laudoCadastro->getArrKitsExtracao())){
                $objLaudoKitExtracaoRN = new LaudoKitExtracaoRN();
                foreach ($laudoCadastro->getArrKitsExtracao() as $laudoKit){
                    $objLaudoKitExtracao = new LaudoKitExtracao();
                    $objLaudoKitExtracao->setIdKitExtracao($laudoKit);
                    $objLaudoKitExtracao->setIdLaudoFk($laudoCadastro->getIdLaudo());
                    $objLaudoKitExtracaoRN->cadastrar($objLaudoKitExtracao);
                }
            }

            if(!is_null($laudoCadastro->getArrProtocolos())){
                $objLaudoProtocoloRN = new LaudoProtocoloRN();
                foreach ($laudoCadastro->getArrProtocolos() as $protocolo){
                    $objLaudoProtocolo = new LaudoProtocolo();
                    $objLaudoProtocolo->setIdProtocoloFk($protocolo);
                    $objLaudoProtocolo->setIdLaudoFk($laudoCadastro->getIdLaudo());
                    $objLaudoProtocoloRN->cadastrar($objLaudoProtocolo);
                }
            }

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $laudoCadastro;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o laudo.', $e);
        }
    }

    public function alterar(Laudo $laudo) {
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarObservacoes($laudo,$objExcecao);
            $this->validarDD($laudo,$objExcecao);
            $this->validarResultado($laudo,$objExcecao);
            $objExcecao->lancar_validacoes();


            if($laudo->getObjInfosTubo() != null){
                $objInfosTuboRN = new InfosTuboRN();
                if(is_array($laudo->getObjInfosTubo())){
                    foreach ($laudo->getObjInfosTubo() as $info){
                        $objInfosTuboRN->cadastrar($info);
                    }
                }else{
                    $objInfosTuboRN->cadastrar($laudo->getObjInfosTubo());
                }
            }

            if(!is_null($laudo->getArrKitsExtracao())){
                $objLaudoKitExtracaoRN = new LaudoKitExtracaoRN();
                $objLaudoKitExtracao = new LaudoKitExtracao();
                $objLaudoKitExtracao->setIdLaudoFk($laudo->getIdLaudo());
                $arr_banco = $objLaudoKitExtracaoRN->listar($objLaudoKitExtracao);
                foreach ($arr_banco as $laudokit){
                    $objLaudoKitExtracaoRN->remover($laudokit);
                }

                foreach ($laudo->getArrKitsExtracao() as $kit){
                    $objLaudoKitExtracao->setIdLaudoFk($laudo->getIdLaudo());
                    $objLaudoKitExtracao->setIdKitExtracao($kit);
                    $objLaudoKitExtracaoRN->cadastrar($objLaudoKitExtracao);

                }
            }



            if(!is_null($laudo->getArrProtocolos())){
                $objLaudoProtocoloRN = new LaudoProtocoloRN();
                $objLaudoProtocolo = new LaudoProtocolo();
                $objLaudoProtocolo->setIdLaudoFk($laudo->getIdLaudo());
                $arr_banco = $objLaudoProtocoloRN->listar($objLaudoProtocolo);
                foreach ($arr_banco as $laudokit){
                    $objLaudoProtocoloRN->remover($laudokit);
                }

                foreach ($laudo->getArrProtocolos() as $id){
                    $objLaudoProtocolo->setIdLaudoFk($laudo->getIdLaudo());
                    $objLaudoProtocolo->setIdProtocoloFk($id);
                    $objLaudoProtocoloRN->cadastrar($objLaudoProtocolo);
                }
            }

            $objLaudoBD = new LaudoBD();
            $laudo = $objLaudoBD->alterar($laudo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $laudo;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o laudo.', $e);
        }
    }

    public function consultar(Laudo $laudo) {
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdLaudo($laudo,$objExcecao);
            $objExcecao->lancar_validacoes();
            $objLaudoBD = new LaudoBD();

            $arr =  $objLaudoBD->consultar($laudo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();

            throw new Excecao('Erro consultando o laudo.',$e);
        }
    }

    public function remover(Laudo $laudo) {
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            //$this->validarRemocao($laudo,$objExcecao);
            $this->validarIdLaudo($laudo,$objExcecao);
            $objExcecao->lancar_validacoes();
            $objLaudoBD = new LaudoBD();
            $objLaudoBD->remover($laudo,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();

        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o laudo.', $e);
        }
    }

    public function listar(Laudo $laudo) {
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objLaudoBD = new LaudoBD();

            $arr = $objLaudoBD->listar($laudo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o laudo.',$e);
        }
    }


    public function pesquisar_index(Laudo $laudo) {
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objLaudoBD = new LaudoBD();
            $arr = $objLaudoBD->pesquisar_index($laudo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro pesquisando o laudo.', $e);
        }
    }

    public function paginacao(Laudo $laudo) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();

            $objLaudoBD = new LaudoBD();
            $arr =  $objLaudoBD->paginacao($laudo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na paginação do laudo.', $e);
        }
    }

}