<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/SolicitacaoMontarPlacaBD.php';

class SolicitacaoMontarPlacaRN
{

    public static $TS_FINALIZADA = 'F';
    public static $TS_EM_ANDAMENTO = 'E';

    public static function listarValoresTipoSituacaoSolicitacao(){
        try {

            $arrObjTStaSolicitacao = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TS_FINALIZADA);
            $objSituacao->setStrDescricao('FINALIZADA');
            $arrObjTStaSolicitacao[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TS_EM_ANDAMENTO);
            $objSituacao->setStrDescricao('EM ANDAMENTO');
            $arrObjTStaSolicitacao[] = $objSituacao;

            return $arrObjTStaSolicitacao;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Tipo estado da capela',$e);
        }
    }

    public static function mostrarDescricaoSituacaoSolicitacao($caractere){
        foreach (self::listarValoresTipoSituacaoSolicitacao() as $sta){
            if($sta->getStrTipo() == $caractere){
                return $sta->getStrDescricao();
            }
        }
        return null;
    }

    private function validarIdPlaca(SolicitacaoMontarPlaca $objSolMontarPlaca, Excecao $objExcecao){
        if($objSolMontarPlaca->getIdPlacaFk() == null || $objSolMontarPlaca->getIdPlacaFk() == ''){
            $objExcecao->adicionar_validacao('Informar o id da placa', null, 'alert-danger');
        }
    }

    private function validarDataHoraFim(SolicitacaoMontarPlaca $objSolMontarPlaca, Excecao $objExcecao){
        if($objSolMontarPlaca->getDataHoraFim() == null ){
            $objExcecao->adicionar_validacao('Informar a data hora fim da solicitação de montagem da placa', null, 'alert-danger');
        }
    }

    private function validarDataHoraInicio(SolicitacaoMontarPlaca $objSolMontarPlaca, Excecao $objExcecao){
        if($objSolMontarPlaca->getDataHoraInicio() == null ){
            $objExcecao->adicionar_validacao('Informar a data hora início da solicitação de montagem da placa', null, 'alert-danger');
        }
    }

    private function validarIdUsuario(SolicitacaoMontarPlaca $objSolMontarPlaca, Excecao $objExcecao){
        if($objSolMontarPlaca->getIdUsuarioFk() == null ){
            $objExcecao->adicionar_validacao('Informar o usuário que fez a solicitação de montagem da placa', null, 'alert-danger');
        }
    }


    public function cadastrar(SolicitacaoMontarPlaca $objSolMontarPlaca){
        $objBanco = new Banco();
        try{

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            //print_r($objSolMontarPlaca);
            if($objSolMontarPlaca->getObjPlaca() != null){
                if($objSolMontarPlaca->getObjPlaca()->getIdPlaca() == null) {
                    $objPlacaRN = new PlacaRN();
                    $objplaca = $objPlacaRN->cadastrar($objSolMontarPlaca->getObjPlaca());
                }

                $objSolMontarPlaca->setObjPlaca($objplaca);
                $objSolMontarPlaca->setIdPlacaFk($objplaca->getIdPlaca());
            }

            if($objSolMontarPlaca->getObjRelPerfilPlaca()->getObjPerfis() != null){
                foreach ($objSolMontarPlaca->getObjRelPerfilPlaca()->getObjPerfis() as $perfilplaca){
                    $objPerfilPlacaRN = new RelPerfilPlacaRN();
                    $objPerfilPlaca = new RelPerfilPlaca();
                    $objPerfilPlaca->setIdPlacaFK($objplaca->getIdPlaca());
                    $objPerfilPlaca->setIdPerfilFk($perfilplaca->getIdPerfilPaciente());
                    $objPerfilPlacaRN->cadastrar($objPerfilPlaca);
                }
            }

            $this->validarIdPlaca($objSolMontarPlaca, $objExcecao);
            $this->validarDataHoraInicio($objSolMontarPlaca, $objExcecao);
            $this->validarDataHoraFim($objSolMontarPlaca, $objExcecao);
            $this->validarIdUsuario($objSolMontarPlaca, $objExcecao);


            $objExcecao->lancar_validacoes();
            $objSolMontarPlacaBD = new SolicitacaoMontarPlacaBD();
            $objSolMontarPlaca = $objSolMontarPlacaBD->cadastrar($objSolMontarPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objSolMontarPlaca;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro no cadastramento da solicitação de montagem da placa do RTqPCR.', $e);
        }
    }

    public function alterar(SolicitacaoMontarPlaca $objSolMontarPlaca) {
        $objBanco = new Banco();
        try{

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            if($objSolMontarPlaca->getObjPlaca() != null){
                if($objSolMontarPlaca->getObjPlaca()->getIdPlaca() != null) {
                    $objPlacaRN = new PlacaRN();
                    $objplaca = $objPlacaRN->alterar($objSolMontarPlaca->getObjPlaca());
                }

                $objSolMontarPlaca->setObjPlaca($objplaca);
            }

            $this->validarIdPlaca($objSolMontarPlaca, $objExcecao);
            $this->validarDataHoraInicio($objSolMontarPlaca, $objExcecao);
            $this->validarDataHoraFim($objSolMontarPlaca, $objExcecao);
            $this->validarIdUsuario($objSolMontarPlaca, $objExcecao);

            $objExcecao->lancar_validacoes();
            $objSolMontarPlacaBD = new SolicitacaoMontarPlacaBD();
            $objSolMontarPlaca  = $objSolMontarPlacaBD->alterar($objSolMontarPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objSolMontarPlaca;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na alteração da solicitação de montagem da placa do RTqPCR.', $e);
        }
    }

    public function consultar(SolicitacaoMontarPlaca $objSolMontarPlaca) {
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objSolMontarPlacaBD = new SolicitacaoMontarPlacaBD();
            $arr =  $objSolMontarPlacaBD->consultar($objSolMontarPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na consulta da solicitação de montagem da placa do RTqPCR.',$e);
        }
    }

    public function remover(SolicitacaoMontarPlaca $objSolMontarPlaca) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objSolMontarPlacaBD = new SolicitacaoMontarPlacaBD();


            $arr =  $objSolMontarPlacaBD->remover($objSolMontarPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;

        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na remoção da solicitação de montagem da placa do RTqPCR.', $e);
        }
    }

    public function listar(SolicitacaoMontarPlaca $objSolMontarPlaca) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objSolMontarPlacaBD = new SolicitacaoMontarPlacaBD();

            $arr =  $objSolMontarPlacaBD->listar($objSolMontarPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na listagem da solicitação de montagem da placa do RTqPCR.',$e);
        }
    }

    public function remover_completamente(SolicitacaoMontarPlaca $objSolMontarPlaca) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objSolMontarPlacaBD = new SolicitacaoMontarPlacaBD();

            $arr =  $objSolMontarPlacaBD->remover_completamente($objSolMontarPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na listagem da solicitação de montagem da placa do RTqPCR.',$e);
        }
    }
}