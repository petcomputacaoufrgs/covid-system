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


    public static function listarValoresResultado(){
        try {

            $arrObjTEtapa = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$RL_POSITIVO);
            $objSituacao->setStrDescricao('POSITIVO');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$RL_NEGATIVO);
            $objSituacao->setStrDescricao('NEGATIVO');
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
            $objSituacao->setStrDescricao('RECUSADA - problemas na preparação');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$RL_PROBLEMAS_EXTRACAO);
            $objSituacao->setStrDescricao('RECUSADA - problemas na extração');
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


    private function validarObservacoes(Laudo $laudo,Excecao $objExcecao){

        if($laudo->getObservacoes() != null) {
            $strObservacoes = trim($laudo->getObservacoes());


            if (strlen($strObservacoes) > 300) {
                $objExcecao->adicionar_validacao('As observações do laudo possuem mais de 300 caracteres.', 'idLaudo', 'alert-danger');
            }

            return $strObservacoes->setObservacoes($strObservacoes);
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

            $objExcecao->lancar_validacoes();
            $laudo = $objLaudoBD->cadastrar($laudo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $laudo;
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

            $objExcecao->lancar_validacoes();
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

            $objExcecao->lancar_validacoes();
            $objLaudoBD = new LaudoBD();
            $arr =  $objLaudoBD->remover($laudo,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
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


    public function laudo_completo(Laudo $laudo) {
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objLaudoBD = new LaudoBD();

            $arr =  $objLaudoBD->laudo_completo($laudo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();

            throw new Excecao('Erro consultando o laudo completo.',$e);
        }
    }

}