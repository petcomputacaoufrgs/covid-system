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
        $preparoLote->setIdPreparoLote(intval($preparoLote->getIdPreparoLote()));
        if($preparoLote->getIdPreparoLote() == null || $preparoLote->getIdPreparoLote() <= 0) {
            $objExcecao->adicionar_validacao('O identificador do preparo do lote não foi informado', null, 'alert-danger');
        }


    }

    private function validarIdCapela(PreparoLote $preparoLote,Excecao $objExcecao){
        if($preparoLote->getIdCapelaFk() != null) {
            $preparoLote->setIdCapelaFk(intval($preparoLote->getIdCapelaFk()));
            if ( $preparoLote->getIdCapelaFk() <= 0) {
                $objExcecao->adicionar_validacao('O identificador do preparo do lote não foi informado', null, 'alert-danger');
            }
        }

    }

    private function validarIdExtracao(PreparoLote $preparoLote,Excecao $objExcecao){


        $objLote = new Lote();
        $objLoteRN = new LoteRN();
        $objLote->setIdLote($preparoLote->getIdLoteFk());
        $objLote = $objLoteRN->consultar($objLote);
        if($objLote->getTipo() == LoteRN::$TL_EXTRACAO && $preparoLote->getIdKitExtracaoFk() == null) {
            $preparoLote->setIdKitExtracaoFk(intval($preparoLote->getIdKitExtracaoFk()));
            if ($objLote->getTipo() == LoteRN::$TL_EXTRACAO) {
                if ($preparoLote->getIdKitExtracaoFk() == null || $preparoLote->getIdKitExtracaoFk() <= 0) {
                    $objExcecao->adicionar_validacao('O identificador do kit de extração não foi informado', null, 'alert-danger');
                }
            }
        }

    }


    public function cadastrar(PreparoLote $preparoLote)
    {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            //print_r($preparoLote);

            $this->validarIdCapela($preparoLote,$objExcecao);
            $this->validarFabricacaoKit($preparoLote,$objExcecao);
            $this->validarObsKitExtracao($preparoLote,$objExcecao);
            $this->validarNomeResponsavel($preparoLote,$objExcecao);
            $this->validarIdResponsavel($preparoLote,$objExcecao);

            $objExcecao->lancar_validacoes();
            if($preparoLote->getObjLote() != null){
                if($preparoLote->getObjLote()->getIdLote() == null){ //cadastrar lote
                    $objLote =$preparoLote->getObjLote();
                    $objLoteRN = new LoteRN();
                    $objLote =  $objLoteRN->cadastrar($objLote);
                    $preparoLote->setObjLote($objLote);

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

            $this->validarIdPreparoLote($objPreparoLote,$objExcecao);
            $this->validarIdCapela($objPreparoLote,$objExcecao);
            $this->validarFabricacaoKit($objPreparoLote,$objExcecao);
            $this->validarNomeResponsavel($objPreparoLote,$objExcecao);
            $this->validarObsKitExtracao($objPreparoLote,$objExcecao);
            $this->validarIdResponsavel($objPreparoLote,$objExcecao);
            $this->validarIdExtracao($objPreparoLote, $objExcecao);

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

            //$preparoLote = $objPreparoLoteRN->consultar_tubos($objPreparoLote);

            $arrPreparoLote = $objPreparoLoteRN->paginacao($objPreparoLote);
            $preparoLote = $arrPreparoLote[0];
            $objLote = $preparoLote->getObjLote();

            $objInfosTuboRN = new InfosTuboRN();
            $objRelTuboLoteRN = new Rel_tubo_lote_RN();
            date_default_timezone_set('America/Sao_Paulo');
            foreach ($objLote->getObjRelTuboLote() as $relTuboLote){
                foreach ($relTuboLote->getObjTubo() as $amostra) {
                    $tubo = $amostra->getObjTubo();
                    $objInfosTubo = new InfosTubo();

                    if ($tubo->getTuboOriginal() == 'n') {
                        foreach ($tubo->getObjInfosTubo() as $info) {
                            $objInfosTuboRN->remover($info);
                            //remover local
                        }
                        $objInfosTubo->setIdTubo_fk($tubo->getIdTubo_fk());
                    }else{
                        $objInfosTubo->setIdTubo_fk($tubo->getIdTubo());
                    }

                    if($objLote->getTipo() == LoteRN::$TE_EM_PREPARACAO){
                        $objInfosTuboAux = new InfosTubo();
                        $objInfosTuboAux->setIdTubo_fk($tubo->getIdTubo());
                        $arr_infos_aux = $objInfosTuboRN->listar($objInfosTuboAux);
                        foreach ($arr_infos_aux as $info){
                            $info->setIdLote_fk(null);
                            $objInfosTuboRN->alterar($info);
                        }
                    }

                    $objInfosTubo = $objInfosTuboRN->pegar_ultimo($objInfosTubo);
                    $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_SEM_UTILIZACAO);
                    $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                    $objInfosTubo->setEtapa(InfosTuboRN::$TP_MONTAGEM_GRUPOS_AMOSTRAS);
                    $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                    $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                    $objInfosTubo->setEtapaAnterior(InfosTuboRN::$TP_RECEPCAO);
                    $objInfosTubo->setObservacoes("O -".LoteRN::mostrarDescricaoTipoLote($objLote->getTipo())."- foi apagado.");
                    $objInfosTuboRN->cadastrar($objInfosTubo);

                    if ($tubo->getTuboOriginal()== 'n') {
                        $objTuboRN = new TuboRN();

                        $objTuboOriginado = new Tubo();
                        $objTuboOriginado->setIdTubo_fk($tubo->getIdTubo_fk());
                        $arr_tubos_originados = $objTuboRN->listar($objTuboOriginado);

                        foreach ($arr_tubos_originados as $t){
                            if($t->getIdTubo() != $tubo->getIdTubo()) {
                                $objInfosAux = new InfosTubo();
                                $objInfosAux->setIdTubo_fk($t->getIdTubo());
                                $arr_infos = $objInfosTuboRN->listar($objInfosAux);
                                foreach ($arr_infos as $info) {
                                    /*if($info->getIdLocalFk() != null){
                                        $objLocalArmazenamento = new LocalArmazenamentoTexto();
                                        $objLocalArmazenamentoRN = new LocalArmazenamentoTextoRN();
                                        $objLocalArmazenamento->setIdLocal($info->getIdLocalFk());
                                        $objLocalArmazenamentoRN->remover($objLocalArmazenamento);
                                    }*/
                                    $objInfosTuboRN->remover($info);
                                }
                            }
                            $objTuboRN->remover($t);
                        }

                    }



                }

                //elimirar reltubolote
                $objRelTuboLoteRN->remover($relTuboLote);
            }

            //antes de remover o lote é preciso colocar como NULL em todos os infostubo
            $objInfosLote = new InfosTubo();
            $objInfosLote->setIdLote_fk($objLote->getIdLote());
            $arr_infos_lote = $objInfosTuboRN->listar($objInfosLote);
            /*echo "<pre>";
            print_r($arr_infos_lote);
            echo "</pre>";*/
            foreach ($arr_infos_lote as $infoLote){
                $infoLote->setIdLote_fk(null);
                $objInfosTuboRN->alterar($infoLote);
            }

            $objLoteRN = new LoteRN();
            //print_r($objLote);
            $objLoteRN->remover($objLote);

            if( $preparoLote->getObjCapela() != null && ($objLote->getSituacaoLote() == LoteRN::$TE_EM_PREPARACAO ||  $objLote->getSituacaoLote() == LoteRN::$TE_EM_EXTRACAO)) {
                $objCapela = $preparoLote->getObjCapela();
                $objCapela->setSituacaoCapela(CapelaRN::$TE_LIBERADA);
                $objCapelaRN = new CapelaRN();
                $objCapelaRN->alterar($objCapela);
            }

            if( $preparoLote->getObjLoteOriginal() != null) {
                $objPreparoLoteOriginal = new PreparoLote();
                $objPreparoLoteOriginal->setIdLoteFk($preparoLote->getObjLoteOriginal()->getIdLote());
                $arr_preparo_original = $objPreparoLoteRN->paginacao($objPreparoLoteOriginal);
                $objPreparoLoteRN->remover($arr_preparo_original[0]);
           }

            $objRel_Perfil_preparoLote = new Rel_perfil_preparoLote();
            $objRel_Perfil_preparoLoteRN = new Rel_perfil_preparoLote_RN();
            $objRel_Perfil_preparoLote->setIdPreparoLoteFk($preparoLote->getIdPreparoLote());
            $objRel_Perfil_preparoLoteRN->remover_peloIdPreparo($objRel_Perfil_preparoLote);

            $objPreparoLoteBD->remover($preparoLote, $objBanco);

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
    public function preparoLote_remover(PreparoLote $objPreparoLote)
    {
        $objBanco = new Banco();
        try {

            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            if($objPreparoLote->getObjLote()->getTipo() == LoteRN::$TL_PREPARO) {
                /*
                echo "<pre>";
                print_r($objPreparoLote->getObjPerfil());
                echo "</pre>";
                */
                $objPerfilPreparoLoteRN = new Rel_perfil_preparoLote_RN();
                foreach ($objPreparoLote->getObjPerfil() as $perfil){
                    $objPerfilPreparoLoteRN->remover($perfil);
                    //print_r($perfil);
                }

                $objRelTuboLoteRN = new Rel_tubo_lote_RN();
                $objInfosTuboRN = new InfosTuboRN();
                foreach ($objPreparoLote->getObjLote()->getObjRelTuboLote() as $tuboLote) {
                    /*
                    echo "<pre>";
                    print_r($tuboLote);
                    echo "</pre>";
                    */
                    $objRelTuboLoteRN->remover($tuboLote);
                    foreach ($tuboLote->getObjTubo() as $amostra) {
                        $tamInfos = count($amostra->getObjTubo()->getObjInfosTubo());
                        $infosTubo = $amostra->getObjTubo()->getObjInfosTubo()[$tamInfos - 1];
                        $objInfosTuboRN->remover($infosTubo);
                        /*
                        echo "<pre>";
                        print_r($infosTubo);
                        echo "</pre>";
                        */
                    }
                }
            }


            $objLoteRN = new LoteRN();
            $objLoteRN->remover($objPreparoLote->getObjLote());

            $objPreparoLoteBD = new PreparoLoteBD();
            $arr = $objPreparoLoteBD->remover($objPreparoLote, $objBanco);

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