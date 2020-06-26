<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class RelTuboPlacaBD
{
    public function cadastrar(RelTuboPlaca $objRelTuboPlaca, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO tb_rel_tubo_placa (
                            idPlaca_fk,
                            idTubo_fk
                            ) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRelTuboPlaca->getIdPlacaFk());
            $arrayBind[] = array('i',$objRelTuboPlaca->getIdTuboFk());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objRelTuboPlaca->setIdRelTuboPlaca($objBanco->obterUltimoID());
            return $objRelTuboPlaca;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o relacionamento dos tubos com uma placa no BD.",$ex);
        }

    }

    public function alterar(RelTuboPlaca $objRelTuboPlaca, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_rel_tubo_placa SET '
                . ' idPlaca_fk = ?,'
                . ' idTubo_fk = ?'
                . '  where idRelTuboPlaca = ?';


            $arrayBind = array();
            $arrayBind[] = array('i',$objRelTuboPlaca->getIdPlacaFk());
            $arrayBind[] = array('i',$objRelTuboPlaca->getIdTuboFk());
            $arrayBind[] = array('i',$objRelTuboPlaca->getIdRelTuboPlaca());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objRelTuboPlaca;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o relacionamento dos tubos com uma placa no BD.",$ex);
        }

    }

    public function listar(RelTuboPlaca $objRelTuboPlaca, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_rel_tubo_placa";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objRelTuboPlaca->getIdTuboFk() != null) {
                $WHERE .= $AND . " idTubo_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objRelTuboPlaca->getIdTuboFk());
            }

            if ($objRelTuboPlaca->getIdPlacaFk() != null) {
                $WHERE .= $AND . " idPlaca_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objRelTuboPlaca->getIdPlacaFk());
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            //echo $SELECT.$WHERE;$WHERE

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            $array = array();
            foreach ($arr as $reg){
                $tuboPlaca = new RelTuboPlaca();
                $tuboPlaca->setIdRelTuboPlaca($reg['idRelTuboPlaca']);
                $tuboPlaca->setIdPlacaFk($reg['idPlaca_fk']);
                $tuboPlaca->setIdTuboFk($reg['idTubo_fk']);

                $array[] = $tuboPlaca;
            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o relacionamento dos tubos com uma placa no BD.",$ex);
        }

    }

    public function listar_completo($relTuboPlaca, Banco $objBanco) {
        try{

            if(is_array($relTuboPlaca)){

            }else{

            }

            $SELECT = "SELECT * FROM tb_rel_tubo_placa";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($relTuboPlaca->getIdRelTuboPlaca() != null) {
                $WHERE .= $AND . " idRelTuboPlaca = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $relTuboPlaca->getIdRelTuboPlaca());
            }

            if ($relTuboPlaca->getIdTuboFk() != null) {
                $WHERE .= $AND . " idTubo_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $relTuboPlaca->getIdTuboFk());
            }

            if ($relTuboPlaca->getIdPlacaFk() != null) {
                $WHERE .= $AND . " idPlaca_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $relTuboPlaca->getIdPlacaFk());
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            $array = array();
            foreach ($arr as $reg){
                $tuboPlaca = new RelTuboPlaca();
                $tuboPlaca->setIdRelTuboPlaca($reg['idRelTuboPlaca']);
                $tuboPlaca->setIdPlacaFk($reg['idPlaca_fk']);
                $tuboPlaca->setIdTuboFk($reg['idTubo_fk']);

                $objTubo = new Tubo();
                $objTuboRN = new TuboRN();

                $objTubo->setIdTubo($reg['idTubo_fk']);
                $objTubo = $objTuboRN->listar_completo($objTubo,null,true);

                $tuboPlaca->setObjTubo($objTubo);

                $array[] = $tuboPlaca;
            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o relacionamento dos tubos com uma placa no BD.",$ex);
        }

    }


    public function consultar(RelTuboPlaca $objRelTuboPlaca, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_rel_tubo_placa WHERE idRelTuboPlaca = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRelTuboPlaca->getIdRelTuboLote());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $tuboPlaca = new RelTuboPlaca();
            $tuboPlaca->setIdRelTuboPlaca($arr[0]['idRelTuboPlaca']);
            $tuboPlaca->setIdPlacaFk($arr[0]['idPlaca_fk']);
            $tuboPlaca->setIdTuboFk($arr[0]['idTubo_fk']);

            return $tuboPlaca;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando o relacionamento dos tubos com uma placa no BD.",$ex);
        }

    }

    public function remover(RelTuboPlaca $objRelTuboPlaca, Banco $objBanco) {

        try{
                $DELETE = 'DELETE FROM tb_rel_tubo_placa WHERE idRelTuboPlaca = ? ';
                $arrayBind = array();
                $arrayBind[] = array('i', $objRelTuboPlaca->getIdRelTuboPlaca());

            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o relacionamento dos tubos com uma placa no BD.",$ex);
        }
    }

    public function remover_arr($array, Banco $objBanco) {

        try{

            foreach ($array as $a) {
                $select_max = "select max(tb_infostubo.idInfostubo) from tb_infostubo, tb_tubo where tb_infostubo.idTubo_fk = tb_tubo.idTubo 
                and tb_tubo.idTubo = ?";
                $arrayBind = array();
                $arrayBind[] = array('i', $a->getIdTuboFk());
                $max_info = $objBanco->consultarSql($select_max, $arrayBind);

                $select_info = "select * from tb_infostubo where idInfostubo = ?";
                $arrayBind = array();
                $arrayBind[] = array('i',$max_info[0]['max(tb_infostubo.idInfostubo)']);
                $arr = $objBanco->consultarSql($select_info, $arrayBind);


                $objInfosTubo = new InfosTubo();
                $objInfosTuboRN = new InfosTuboRN();
                $objInfosTubo->setIdUsuario_fk($arr[0]['idUsuario_fk']);
                $objInfosTubo->setIdPosicao_fk($arr[0]['idPosicao_fk']);
                $objInfosTubo->setIdTubo_fk($arr[0]['idTubo_fk']);
                $objInfosTubo->setIdLote_fk($arr[0]['idLote_fk']);
                $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                $objInfosTubo->setReteste($arr[0]['reteste']);
                $objInfosTubo->setVolume($arr[0]['volume']);
                $objInfosTubo->setObsProblema($arr[0]['obsProblema']);
                $objInfosTubo->setObservacoes($arr[0]['observacoes']);
                $objInfosTubo->setIdLocalFk($arr[0]['idLocal_fk']);

                $objInfosTubo->setEtapaAnterior(InfosTuboRN::$TP_RTqPCR_SOLICITACAO__MONTAGEM_PLACA);
                $objInfosTubo->setEtapa(InfosTuboRN::$TP_RTqPCR_MIX_PLACA);
                $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_SEM_UTILIZACAO);
                $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_EM_ANDAMENTO);
                $objInfosTubo = $objInfosTuboRN->cadastrar($objInfosTubo);

                $objInfosTubo->setEtapaAnterior(InfosTuboRN::$TP_EXTRACAO);
                $objInfosTubo->setEtapa(InfosTuboRN::$TP_RTqPCR_SOLICITACAO__MONTAGEM_PLACA);
                $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_AGUARDANDO_SOLICITACAO_MONTAGEM_PLACA);
                $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                $objInfosTuboRN->cadastrar($objInfosTubo);

            }


            //die();

            $interrogacoes = '';
            foreach ($array as $a){
                $interrogacoes .= '?,';
            }
            $interrogacoes = substr($interrogacoes,0,-1);

            $DELETE = 'DELETE FROM tb_rel_tubo_placa WHERE idRelTuboPlaca in ('.$interrogacoes.')';
            $arrayBind = array();
            foreach ($array as $a) {
                $arrayBind[] = array('i', $a->getIdRelTuboPlaca());
            }

            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o relacionamento dos tubos com uma placa no BD.",$ex);
        }
    }
}