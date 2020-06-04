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


require_once __DIR__ . '/../../classes/RelTuboPlaca/RelTuboPlaca.php';
require_once __DIR__ . '/../../classes/RelTuboPlaca/RelTuboPlacaRN.php';

class PreparoLoteRN
{

    private function validarObsKitExtracao(PreparoLote $preparoLote,Excecao $objExcecao){

        if($preparoLote->getObsKitExtracao() != null) {
            $strObsKitExtracao = trim($preparoLote->getObsKitExtracao());

            if (strlen($strObsKitExtracao) > 300) {
                    $objExcecao->adicionar_validacao('As observações do kit de extração deve possuir no máximo 300 caracteres', null, 'alert-danger');
            }

            return $preparoLote->setObsKitExtracao($strObsKitExtracao);
        }

    }

    private function validarNomeResponsavel(PreparoLote $preparoLote,Excecao $objExcecao){

        if($preparoLote->getNomeResponsavel() != null) {
            $strNomeResponsavel = trim($preparoLote->getNomeResponsavel());

            if (strlen($strNomeResponsavel) > 100) {
                $objExcecao->adicionar_validacao('O nome do responsável deve possuir no máximo 100 caracteres', null, 'alert-danger');
            }

            return $preparoLote->setNomeResponsavel($strNomeResponsavel);
        }

    }
    private function validarFabricacaoKit(PreparoLote $preparoLote,Excecao $objExcecao){

        if($preparoLote->getLoteFabricacaokitExtracao() != null) {
            $strLoteFabricacaoKitExtracao = trim($preparoLote->getLoteFabricacaokitExtracao());

            if (strlen($strLoteFabricacaoKitExtracao) > 130) {
                $objExcecao->adicionar_validacao('O lote de fabricação do kit de extração deve possuir no máximo 130 caracteres', null, 'alert-danger');
            }

            return $preparoLote->setLoteFabricacaokitExtracao($strLoteFabricacaoKitExtracao);
        }

    }

    private function validarIdResponsavel(PreparoLote $preparoLote,Excecao $objExcecao){

        if($preparoLote->getIdResponsavel() != null) {
            $objUsuarioRN = new UsuarioRN();
            $objUsuario = new Usuario();
            $objUsuario->setMatricula($preparoLote->getIdResponsavel());
            $arr_usuarios = $objUsuarioRN->listar($objUsuario);

            if (count($arr_usuarios) == 0) {
                $objExcecao->adicionar_validacao('O usuário não existe', null, 'alert-danger');
            } else {
                return $preparoLote->setIdResponsavel($arr_usuarios[0]->getIdUsuario());
            }

        }

    }

    private function validarIdPreparoLote(PreparoLote $preparoLote,Excecao $objExcecao){

        if($preparoLote->getIdPreparoLote() == null) {
            $objExcecao->adicionar_validacao('O identificador do preparo do lote não foi informado', null, 'alert-danger');
        }

    }


    public function cadastrar(PreparoLote $preparoLote)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarFabricacaoKit($preparoLote,$objExcecao);
            $this->validarObsKitExtracao($preparoLote,$objExcecao);
            $this->validarNomeResponsavel($preparoLote,$objExcecao);
            $this->validarIdResponsavel($preparoLote,$objExcecao);

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
            if($preparoLote->getObjLote() != null) {
                $preparoLote = $objPreparoLoteBD->cadastrar($preparoLote, $objBanco);
            }
            $preparoLote->setObjLote($objLote);


            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $preparoLote;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o perfil do preparo do lote.', $e);
        }
    }

    public function alterar(PreparoLote $objPreparoLote)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();


            $this->validarFabricacaoKit($objPreparoLote,$objExcecao);
            $this->validarNomeResponsavel($objPreparoLote,$objExcecao);
            $this->validarObsKitExtracao($objPreparoLote,$objExcecao);
            $this->validarIdResponsavel($objPreparoLote,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objPreparoLoteBD = new PreparoLoteBD();
            $preparoLote = $objPreparoLoteBD->alterar($objPreparoLote, $objBanco);

             if($objPreparoLote->getObjLote() != null){
                if($objPreparoLote->getObjLote()->getIdLote() != null){
                    $objLoteRN = new LoteRN();
                    $objLote = $objLoteRN->alterar($objPreparoLote->getObjLote());
                    $preparoLote->setObjLote($objLote);
                }
            }



            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $preparoLote;
        } catch (Throwable $e) {
            //die($e);
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o perfil do preparo do lote.', $e);
        }
    }


    public function alterar_extracao(PreparoLote $objPreparoLote)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarFabricacaoKit($objPreparoLote,$objExcecao);
            $this->validarObsKitExtracao($objPreparoLote,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objPreparoLoteBD = new PreparoLoteBD();
            $preparoLote = $objPreparoLoteBD->alterar($objPreparoLote, $objBanco);


            //alterar capela
            if($objPreparoLote->getObjCapela() != null){
                $objCapelaRN = new CapelaRN();
                $objCapelaRN->bloquear_registro($objPreparoLote->getObjCapela());
            }

            //alterar infos tubo
            if($objPreparoLote->getObjLote()->getObjsAmostras() != null){
                foreach($objPreparoLote->getObjLote()->getObjsAmostras() as $amostra){

                    $tubo  = $amostra->getObjTubo();
                    $infotubo  = $amostra->getObjTubo()->getObjInfosTubo();
                    if($infotubo->getSituacaoTubo() == InfosTuboRN::$TST_DESCARTADO_NO_MEIO_ETAPA) {
                        //verificar se não está em nenhuma placa
                        $objRelTuboPlaca = new RelTuboPlaca();
                        $objRelTuboPlacaRN = new RelTuboPlacaRN();
                        $objRelTuboPlaca->setIdTuboFk($infotubo->getIdTubo_fk());
                        $arr = $objRelTuboPlacaRN->listar($objRelTuboPlaca);
                        if (count($arr) > 0) {
                            $objExcecao->adicionar_validacao('A amostra não pode ser descartada pois está associada a uma placa de RTqPCR', null, 'alert-danger');
                        }

                        //verificar no lote
                        $objLote = new Lote();
                        $objLoteRN = new LoteRN();
                        $objLote->setIdLote($objPreparoLote->getIdLoteFk());
                        $objLote = $objLoteRN->consultar($objLote);
                        $objLote->setQntAmostrasAdquiridas(($objLote->getQntAmostrasAdquiridas() - 1));
                        //caso tenha deletado a última amostra do lote
                        if ($objLote->getQntAmostrasAdquiridas() == 0) {
                            //deletar todo o lote preparo lote rel perfil preparo lote...
                            $objPreparoLoteRN = new PreparoLoteRN();
                            $objPreparoLoteRN->remover_completamente($objPreparoLote);
                            $objExcecao->adicionar_validacao('Por não possuir mais amostras o lote foi eliminado', null, 'alert-danger');
                        } else {
                            $objLote = $objLoteRN->alterar($objLote);
                        }

                        $objRelTuboLote = new Rel_tubo_lote();
                        $objRelTuboLoteRN = new Rel_tubo_lote_RN();
                        $objRelTuboLote->setIdLote_fk($objPreparoLote->getIdLoteFk());
                        $objRelTuboLote->setIdTubo_fk($tubo->getIdTubo());
                        $arr_tubo_lote = $objRelTuboLoteRN->listar($objRelTuboLote);

                        $objRelTuboLote->setIdRelTuboLote($arr_tubo_lote[0]->getIdRelTuboLote());
                        $objRelTuboLoteRN->remover($objRelTuboLote);


                        $objExcecao->lancar_validacoes();
                    }else{
                        $objInfosTuboRN = new InfosTuboRN();
                        $objInfosTuboRN->alterar($infotubo);
                    }
                }
                
            }

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

            $this->validarIdPreparoLote($preparoLote,$objExcecao);
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

    public function consultar_lote(PreparoLote $preparoLote)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objPreparoLoteBD = new PreparoLoteBD();
            $arr = $objPreparoLoteBD->consultar_lote($preparoLote, $objBanco);

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

            //$this->validarRemocao($objPreparoLote,$objExcecao);


            $objPreparoLoteBD = new PreparoLoteBD();

            $objPreparoLoteRN = new PreparoLoteRN();

            $preparoLote = $objPreparoLoteRN->consultar_tubos($objPreparoLote);

            $objLote = new Lote();
            $objLoteRN = new LoteRN();
            $preparoLoteAux = $objPreparoLoteRN->consultar($objPreparoLote);
            $objLote->setIdLote($preparoLoteAux->getIdLoteFk());
            $objLote = $objLoteRN->consultar($objLote);
            if ($objLote->getSituacaoLote() == LoteRN::$TE_PREPARACAO_FINALIZADA || $objLote->getSituacaoLote() == LoteRN::$TE_EXTRACAO_FINALIZADA) {
                $objExcecao->adicionar_validacao("O lote já foi finalizado, logo não pode ser excluído",null,'alert-danger');
            }else{

                $arr = $preparoLote[0]->getObjsTubos();

                $objInfosTuboAuxiliar = new InfosTubo();
                $objInfosTuboAuxiliarRN = new InfosTuboRN();

                $objInfosTuboAuxiliar->setIdLote_fk($preparoLote[0]->getIdLoteFk());
                $arr_infos = $objInfosTuboAuxiliarRN->listar($objInfosTuboAuxiliar);

                foreach ($arr_infos as $info){
                    $info->setIdLote_fk(null);
                    $objInfosTuboAuxiliarRN->alterar($info);

                }

                for ($i = 0; $i < count($arr); $i++) {


                    $objInfosTubo = new InfosTubo();
                    $objInfosTuboRN = new InfosTuboRN();

                    $objInfosTubo->setIdTubo_fk($arr[$i]->getObjTubo()->getIdTubo());
                    $objInfosTuboAux = $objInfosTuboRN->pegar_ultimo($objInfosTubo);

                    $objInfosTuboAux->setIdLote_fk(null);
                    $objInfosTuboRN->alterar($objInfosTuboAux);

                    $objInfosTuboAux->setIdTubo_fk($arr[$i]->getObjTubo()->getIdTubo());
                    $objInfosTuboAux->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                    $objInfosTuboAux->setEtapa(InfosTuboRN::$TP_MONTAGEM_GRUPOS_AMOSTRAS);
                    $objInfosTuboAux->setSituacaoTubo(InfosTuboRN::$TST_SEM_UTILIZACAO);
                    $objInfosTuboAux->setObservacoes(InfosTuboRN::$O_PREPARO_LOTE_APAGADO);
                    $objInfosTuboRN->cadastrar($objInfosTuboAux);

                }

                $objLote->setIdLote($preparoLote[0]->getIdLoteFk());
                $objLoteRN->remover($objLote);

                $objRelTuboLote = new Rel_tubo_lote();
                $objRelTuboLoteRN = new Rel_tubo_lote_RN();
                $objRelTuboLote->setIdLote_fk($preparoLote[0]->getIdLoteFk());
                $objRelTuboLoteRN->remover_peloIdLote($objRelTuboLote);

                $objRel_Perfil_preparoLote = new Rel_perfil_preparoLote();
                $objRel_Perfil_preparoLoteRN = new Rel_perfil_preparoLote_RN();
                $objRel_Perfil_preparoLote->setIdPreparoLoteFk($preparoLote[0]->getIdPreparoLote());
                $objRel_Perfil_preparoLoteRN->remover_peloIdPreparo($objRel_Perfil_preparoLote);




                $objPreparoLoteBD->remover($objPreparoLote, $objBanco);


        }
            $objExcecao->lancar_validacoes();
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();

        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o perfil do preparo do lote.', $e);
        }
    }

    public function remover_completamente(PreparoLote $objPreparoLote)
    {
        $objBanco = new Banco();
        try {


            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();


            $objPreparoLoteBD = new PreparoLoteBD();
            $objPreparoLoteBD->remover_completamente($objPreparoLote,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();

        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o perfil do preparo do lote.', $e);
        }
    }

    public function remover_preparoLote(PreparoLote $objPreparoLote)
    {
        $objBanco = new Banco();
        try {


            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();


            $objPreparoLoteBD = new PreparoLoteBD();
            $objPreparoLoteBD->remover_preparoLote($objPreparoLote,$objBanco);

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

    public function obter_todas_infos(PreparoLote $preparoLote,$str=null)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();


            $objExcecao->lancar_validacoes();
            $objPreparoLoteBD = new PreparoLoteBD();

            $arr = $objPreparoLoteBD->obter_todas_infos($preparoLote, $str,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o perfil do preparo do lote.', $e);
        }
    }


    /**** EXTRAS  ****/

    public function paginacao(PreparoLote $preparoLote)
    {
        $objBanco = new Banco();
        try {

            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objPreparoLoteBD = new PreparoLoteBD();
            $arr = $objPreparoLoteBD->paginacao($preparoLote, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o perfil do preparo do lote.', $e);
        }
    }

    public function preparoLote_completo(PreparoLote $preparoLote)
    {
        $objBanco = new Banco();
        try {

            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objPreparoLoteBD = new PreparoLoteBD();
            $arr = $objPreparoLoteBD->preparoLote_completo($preparoLote, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o perfil do preparo do lote.', $e);
        }
    }


    public function listar_com_lote(PreparoLote $preparoLote)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objPreparoLoteBD = new PreparoLoteBD();

            $arr = $objPreparoLoteBD->listar_com_lote($preparoLote, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o perfil do preparo do lote.', $e);
        }
    }
}