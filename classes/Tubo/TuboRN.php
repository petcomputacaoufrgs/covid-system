<?php 
/*********************************************
 *  Classe das regras de negócio dos tubos   *
 *********************************************/

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/TuboBD.php';


require_once __DIR__ . '/../../classes/Caixa/Caixa.php';
require_once __DIR__ . '/../../classes/Caixa/CaixaRN.php';

require_once __DIR__ . '/../../classes/Posicao/Posicao.php';
require_once __DIR__ . '/../../classes/Posicao/PosicaoRN.php';

require_once __DIR__ . '/../../classes/LocalArmazenamento/LocalArmazenamento.php';
require_once __DIR__ . '/../../classes/LocalArmazenamento/LocalArmazenamentoRN.php';

require_once __DIR__ . '/../../classes/TipoLocalArmazenamento/TipoLocalArmazenamento.php';
require_once __DIR__ . '/../../classes/TipoLocalArmazenamento/TipoLocalArmazenamentoRN.php';

require_once __DIR__ . '/../../classes/Porta/Porta.php';
require_once __DIR__ . '/../../classes/Porta/PortaRN.php';

require_once __DIR__ . '/../../classes/Prateleira/Prateleira.php';
require_once __DIR__ . '/../../classes/Prateleira/PrateleiraRN.php';

require_once __DIR__ . '/../../classes/Coluna/Coluna.php';
require_once __DIR__ . '/../../classes/Coluna/ColunaRN.php';

require_once __DIR__.'/../../classes/Tubo/Tubo.php';
require_once __DIR__.'/../../classes/Tubo/TuboRN.php';

require_once __DIR__.'/../../classes/InfosTubo/InfosTubo.php';
require_once __DIR__.'/../../classes/InfosTubo/InfosTuboRN.php';

require_once __DIR__.'/../../classes/Amostra/Amostra.php';
require_once __DIR__.'/../../classes/Amostra/AmostraRN.php';



class TuboRN{


    public static $TT_COLETA  = 'C';
    public static $TT_ALIQUOTA = 'A';
    public static $TT_RNA = 'N';
    public static $TT_INDO_EXTRACAO = 'R';


    public static $TUBO_CADASTRADOS_PREPARACAO_INATIVACAO = 'C';
    public static $TUBO_ALTERADOS_PREPARACAO_INATIVACAO = 'A';
    public static $TUBO_NOVOSTUBOS_PREPARACAO_INATIVACAO = 'N';

    public static function listarValoresTipoTubo(){
        try {

            $arrObjTStaTubo = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TT_COLETA);
            $objSituacao->setStrDescricao('COLETA');
            $arrObjTStaTubo[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TT_ALIQUOTA);
            $objSituacao->setStrDescricao('ALIQUOTA');
            $arrObjTStaTubo[] = $objSituacao;


            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TT_RNA);
            $objSituacao->setStrDescricao('RNA');
            $arrObjTStaTubo[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TT_INDO_EXTRACAO);
            $objSituacao->setStrDescricao('Tubo que está indo para extração');
            $arrObjTStaTubo[] = $objSituacao;

            return $arrObjTStaTubo;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Tipo estado da capela',$e);
        }
    }


    public static function mostrarDescricaoTipoTubo($caractere){
        foreach (self::listarValoresTipoTubo() as $sta){
            if($sta->getStrTipo() == $caractere){
                return $sta->getStrDescricao();
            }
        }
        return null;
    }



    private function validarTuboOriginal(Tubo $tubo, Excecao $objExcecao){
        $boolTuboOriginal = $tubo->getTuboOriginal();

        if($boolTuboOriginal == null){
            $objExcecao->adicionar_validacao('A originalidade do tubo precisa ser informada', null,'alert-danger');
        }
        return $tubo->setTuboOriginal($boolTuboOriginal);
    }

    public function cadastrar(Tubo $tubo){
        $objBanco = new Banco();
        try{

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarTuboOriginal($tubo, $objExcecao);

            $objExcecao->lancar_validacoes();
            $objTuboBD = new TuboBD();
            $tubo = $objTuboBD->cadastrar($tubo,$objBanco);


            if($tubo->getObjInfosTubo() != null){
                $objInfosTuboRN = new InfosTuboRN();
                if(count($tubo->getObjInfosTubo() > 0 || $tubo->getObjInfosTubo() != null)) {
                    foreach ($tubo->getObjInfosTubo() as $info) {
                        if ($info->getIdInfosTubo() == null) {
                            $objInfosTubo = $info;
                            $objInfosTubo->setObjTubo($tubo);
                            $objInfosTubo->setIdTubo_fk($tubo->getIdTubo());
                            $objInfosTubo = $objInfosTuboRN->cadastrar($objInfosTubo);


                        } else {
                            $objInfosTubo = $objInfosTuboRN->alterar($info);
                        }
                        $arr_infos[] = $objInfosTubo;
                    }
                    $tubo->setObjInfosTubo($arr_infos);
                }

                /*if($objInfosTuboAux->getEtapa() == InfosTuboRN::$TP_RECEPCAO && $objInfosTuboAux->getSituacaoTubo(InfosTuboRN::$TST_SEM_UTILIZACAO)) { //tubo veio da recepção
                    $objTipoLocalArmazenamento->setCaractereTipo(TipoLocalArmazenamentoRN::$TL_GELADEIRA);
                    $arr_tipos_locais = $objTipoLocalArmazenamentoRN->listar($objTipoLocalArmazenamento);

                    foreach ($arr_tipos_locais as $tipo) {
                        $objLocalArmazenamento->setIdTipoLocalArmazenamento_fk($tipo->getIdTipoLocalArmazenamento());
                        $arr_locais = $objLocalArmazenamentoRN->listar($objLocalArmazenamento);

                        foreach ($arr_locais as $local) {
                            $posicao = $objPosicaoRN->bloquear_registro($objPosicao, $tubo, $local);
                            //$tubo->setObjPosicao($posicao);
                            if($posicao != null) $tubo->setObjPosicao($posicao);
                        }
                    }
                }*/

            }


            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $tubo;
        }catch(Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro no cadastramento do tubo.', $e);
        }
    }

    public function alterar(Tubo $tubo){
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            
            $this->validarTuboOriginal($tubo, $objExcecao);

            $objExcecao->lancar_validacoes();
            $objTuboBD = new TuboBD();
            $tubo = $objTuboBD->alterar($tubo,$objBanco);

             if($tubo->getObjInfosTubo() != null) {
                $objInfosTuboRN = new InfosTuboRN();
                if (count($tubo->getObjInfosTubo() > 0)) {
                    foreach ($tubo->getObjInfosTubo() as $info) {
                        if ($info->getIdInfosTubo() == null) {
                            $objInfosTubo = $info;
                            $objInfosTubo->setObjTubo($tubo);
                            $objInfosTubo->setIdTubo_fk($tubo->getIdTubo());
                            $objInfosTubo = $objInfosTuboRN->cadastrar($objInfosTubo);
                        }else {
                            $objInfosTubo = $objInfosTuboRN->alterar($info);
                        }
                        $arr_infos[] = $objInfosTubo;
                    }
                    $tubo->setObjInfosTubo($arr_infos);
                }
            }

            
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $tubo;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na alteração do tubo.', $e);
        }
    }

    public function alterar_array_tubos($arr_tubo){
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            foreach ($arr_tubo as $tubo) {

                $this->validarTuboOriginal($tubo, $objExcecao);

                $objExcecao->lancar_validacoes();
                $objTuboBD = new TuboBD();
                $tubo = $objTuboBD->alterar($tubo, $objBanco);

                if($tubo->getObjInfosTubo() != null) {
                    $objInfosTuboRN = new InfosTuboRN();
                    if (count($tubo->getObjInfosTubo() > 0)) {
                        foreach ($tubo->getObjInfosTubo() as $info) {
                            if ($info->getIdInfosTubo() == null) {
                                $objInfosTubo = $info;
                                $objInfosTubo->setObjTubo($tubo);
                                $objInfosTubo->setIdTubo_fk($tubo->getIdTubo());
                                $objInfosTubo = $objInfosTuboRN->cadastrar($objInfosTubo);
                            }else {
                                $objInfosTubo = $objInfosTuboRN->alterar($info);
                            }
                            $arr_infos[] = $objInfosTubo;
                        }
                        $tubo->setObjInfosTubo($arr_infos);
                    }
                }
            }

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $tubo;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na alteração do tubo.', $e);
        }
    }

    public function consultar(Tubo $tubo){
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao(); 
            $objBanco->abrirTransacao();
            
            $objExcecao->lancar_validacoes();
            $objTuboBD = new TuboBD();
            $arr =  $objTuboBD->consultar($tubo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na consulta do tubo.', $e);
        }
    }

    public function remover(Tubo $tubo){
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao(); 
            $objBanco->abrirTransacao();
            $objInfosTubo = new InfosTubo();
            $objInfosTuboRN = new InfosTuboRN();

            $objInfosTubo->setIdTubo_fk($tubo->getIdTubo());
            $arr_infos = $objInfosTuboRN->listar($objInfosTubo);
            foreach ($arr_infos as $info){
                $objInfosTuboRN->remover($info);
            }

            $objExcecao->lancar_validacoes();
            $objTuboBD = new TuboBD();
            $arr =  $objTuboBD->remover($tubo,$objBanco);
            
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na remoção do tubo.', $e);
        }
    }

    public function listar(Tubo $tubo){
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao(); 
            $objBanco->abrirTransacao();
            
            $objExcecao->lancar_validacoes();
            $objTuboBD = new TuboBD();
            
            $arr = $objTuboBD->listar($tubo,$objBanco);
            
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na listagem do tubo.',$e);
        }
    }

    public function pesquisar($campoBD, $valor_usuario) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao(); 
            $objBanco->abrirTransacao();
            
            $objExcecao->lancar_validacoes();
            $objTuboBD = new TuboBD();
            $arr = $objTuboBD->pesquisar($campoBD,$valor_usuario,$objBanco);
            
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na pesquisa do tubo.', $e);
        }
    }


}