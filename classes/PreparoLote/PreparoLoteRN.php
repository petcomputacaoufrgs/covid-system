<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do preparo do lote
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/PreparoLoteBD.php';


require_once __DIR__ . '/../../classes/Tubo/Tubo.php';
require_once __DIR__ . '/../../classes/Tubo/TuboRN.php';

require_once __DIR__ . '/../../classes/InfosTubo/InfosTubo.php';
require_once __DIR__ . '/../../classes/InfosTubo/InfosTuboRN.php';

require_once __DIR__ . '/../../classes/Lote/Lote.php';
require_once __DIR__ . '/../../classes/Lote/LoteRN.php';

require_once __DIR__ . '/../../classes/PreparoLote/PreparoLote.php';
require_once __DIR__ . '/../../classes/PreparoLote/PreparoLoteRN.php';

require_once __DIR__ . '/../../classes/Rel_perfil_preparoLote/Rel_perfil_preparoLote.php';
require_once __DIR__ . '/../../classes/Rel_perfil_preparoLote/Rel_perfil_preparoLote_RN.php';

require_once __DIR__ . '/../../classes/Rel_tubo_lote/Rel_tubo_lote.php';
require_once __DIR__ . '/../../classes/Rel_tubo_lote/Rel_tubo_lote_RN.php';

class PreparoLoteRN
{

    public function cadastrar(PreparoLote $preparoLote)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            if($preparoLote->getObjLote() != null){
                if($preparoLote->getObjLote()->getIdLote() == null){ //cadastrar lote
                    $objLote =$preparoLote->getObjLote();
                    $objLoteRN = new LoteRN();
                    $objLote =  $objLoteRN->cadastrar($objLote);

                }else{ //alterar lote

                }
                $preparoLote->setIdLoteFk($objLote->getIdLote());
            }

            if($preparoLote->getObjsTubosAlterados() != null){ //ALTERAR PADRÃO
                //cadastrar tubo especial que vai chamar um infos tubo especial
                //foreach ($preparoLote->getObjsTubosAlterados() as $t) {
                $objTuboRN = new TuboRN();
                $arr_tubos_alterados = array();
                for($i=0; $i<count($preparoLote->getObjsTubosAlterados()); $i++){

                    $objTubo = new Tubo();
                    $objTubo->setIdTubo($preparoLote->getObjsTubosAlterados()[$i]->getIdTubo());
                    $objTubo = $objTuboRN->consultar($objTubo);
                    $objTubo->setObjInfosTubo($preparoLote->getObjsTubosAlterados()[$i]->getObjInfosTubo());
                    $objTubo = $objTuboRN->alterar($objTubo);
                    $arr_tubos_alterados[] = $objTubo;
                }
                //}
                $preparoLote->setObjsTubosAlterados($arr_tubos_alterados);

            }

            if($preparoLote->getObjsTubosCadastro() != null){
                //cadastrar tubo especial que vai chamar um infos tubo especial

                    foreach ($preparoLote->getObjsTubosCadastro() as $t) {
                        $objTuboRN = new TuboRN();
                        $t = $objTuboRN->cadastrar($t);
                        $arr_tubos_cadastrados[] = $t;
                    }
                $preparoLote->setObjsTubosCadastro($arr_tubos_cadastrados);

            }



            $objExcecao->lancar_validacoes();
            $objPreparoLoteBD = new PreparoLoteBD();
            $preparoLote= $objPreparoLoteBD->cadastrar($preparoLote, $objBanco);
            $preparoLote->setObjLote($objLote);


            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $preparoLote;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o perfil do preparo do lote.', $e);
        }
    }

    public function alterar(PreparoLote $preparoLote)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();


            $objExcecao->lancar_validacoes();
            $objPreparoLoteBD = new PreparoLoteBD();
            $preparoLote = $objPreparoLoteBD->alterar($preparoLote, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $preparoLote;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o perfil do preparo do lote.', $e);
        }
    }

    public function consultar(PreparoLote $preparoLote)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objPreparoLoteBD = new PreparoLoteBD();
            $arr = $objPreparoLoteBD->consultar($preparoLote, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o perfil do preparo do lote.', $e);
        }
    }


    public function remover(PreparoLote $objPreparoLote)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objPreparoLoteBD = new PreparoLoteBD();


            $objPreparoLoteRN = new PreparoLoteRN();
            $preparoLote = $objPreparoLoteRN->consultar_tubos($objPreparoLote);

            $objLote = new Lote();
            $objLoteRN = new LoteRN();

            $arr = $preparoLote[0]->getObjsTubos();

            for ($i=0; $i<count($arr); $i++) {

                $objInfosTubo = new InfosTubo();
                $objInfosTuboRN = new InfosTuboRN();

                $objInfosTubo->setIdTubo_fk($arr[$i]->getObjTubo()->getIdTubo());
                $objInfosTuboAux = $objInfosTuboRN->pegar_ultimo($objInfosTubo);

                $objInfosTuboAux->setIdLote_fk(null);
                $objInfosTuboAux->setIdTubo_fk($arr[$i]->getObjTubo()->getIdTubo());
                $objInfosTuboAux->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                $objInfosTuboAux->setEtapa(InfosTuboRN::$TP_MONTAGEM_GRUPOS_AMOSTRAS);
                $objInfosTuboAux->setSituacaoTubo(InfosTuboRN::$TST_SEM_UTILIZACAO);
                $objInfosTuboAux->setObservacoes(InfosTuboRN::$O_PREPARO_LOTE_APAGADO);
                $objInfosTuboRN->cadastrar($objInfosTuboAux);

            }


            $objRelTuboLote = new Rel_tubo_lote();
            $objRelTuboLoteRN = new Rel_tubo_lote_RN();
            $objRelTuboLote->setIdLote_fk($preparoLote[0]->getIdLoteFk());
            $objRelTuboLoteRN->remover_peloIdLote($objRelTuboLote);

            $objRel_Perfil_preparoLote = new Rel_perfil_preparoLote();
            $objRel_Perfil_preparoLoteRN = new Rel_perfil_preparoLote_RN();
            $objRel_Perfil_preparoLote->setIdPreparoLoteFk($preparoLote[0]->getIdPreparoLote());
            $objRel_Perfil_preparoLoteRN->remover_peloIdPreparo($objRel_Perfil_preparoLote);


            $objPreparoLoteBD->remover($objPreparoLote, $objBanco);

            $objLote->setIdLote($preparoLote[0]->getIdLoteFk());
            $objLoteRN->remover($objLote);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();

        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o perfil do preparo do lote.', $e);
        }
    }

    public function consultar_tubos(PreparoLote $preparoLote) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();


            $objPreparoLoteBD = new PreparoLoteBD();
            $arr =  $objPreparoLoteBD->consultar_tubos($preparoLote,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na consulta do lote.',$e);
        }
    }

    public function mudar_status_lote(PreparoLote $preparoLote,$novo_status) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();


            $objPreparoLoteBD = new PreparoLoteBD();
            $objPreparoLoteBD->mudar_status_lote($preparoLote,$novo_status, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();

        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na consulta do lote.',$e);
        }
    }


    public function listar(PreparoLote $preparoLote)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objPreparoLoteBD = new PreparoLoteBD();

            $arr = $objPreparoLoteBD->listar($preparoLote, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o perfil do preparo do lote.', $e);
        }
    }

    public function listar_completo(PreparoLote $preparoLote)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objPreparoLoteBD = new PreparoLoteBD();

            $arr = $objPreparoLoteBD->listar_completo($preparoLote, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o perfil do preparo do lote.', $e);
        }
    }


    public function listar_preparos(PreparoLote $preparoLote,$situacaoLote,$tipoLote)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objPreparoLoteBD = new PreparoLoteBD();
            $arr = $objPreparoLoteBD->listar_preparos($preparoLote,$situacaoLote,$tipoLote, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o perfil do preparo do lote.', $e);
        }
    }

    public function listar_preparos_lote(PreparoLote $preparoLote,$tipoLote)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objPreparoLoteBD = new PreparoLoteBD();
            $arr = $objPreparoLoteBD->listar_preparos_lote($preparoLote,$tipoLote, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o perfil do preparo do lote.', $e);
        }
    }

}