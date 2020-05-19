<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class Rel_tubo_lote_BD{

    public function cadastrar(Rel_tubo_lote $objRelTuboLote, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO tb_rel_tubo_lote (
                            idTubo_fk,
                            idLote_fk
                            ) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRelTuboLote->getIdTubo_fk());
            $arrayBind[] = array('i',$objRelTuboLote->getIdLote_fk());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objRelTuboLote->setIdRelTuboLote($objBanco->obterUltimoID());

        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o relacionamento do tubo com um dos seus lotes no BD.",$ex);
        }

    }

    public function alterar(Rel_tubo_lote $objRelTuboLote, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_rel_tubo_lote SET '
                . ' idTubo_fk = ?,'
                . ' idLote_fk = ?'
                . '  where idRelTuboLote = ?';


            $arrayBind = array();
            $arrayBind[] = array('i',$objRelTuboLote->getIdTubo_fk());
            $arrayBind[] = array('i',$objRelTuboLote->getIdLote_fk());
            $arrayBind[] = array('i',$objRelTuboLote->getIdRelTuboLote());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o relacionamento do tubo com um dos seus lotes no BD.",$ex);
        }

    }

    public function listar(Rel_tubo_lote $objRelTuboLote, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_rel_tubo_lote";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objRelTuboLote->getIdTubo_fk() != null) {
                $WHERE .= $AND . " idTubo_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objRelTuboLote->getIdTubo_fk());
            }

            if ($objRelTuboLote->getIdLote_fk() != null) {
                $WHERE .= $AND . " idLote_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objRelTuboLote->getIdLote_fk());
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            //echo $SELECT.$WHERE;$WHERE

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            $array = array();
            foreach ($arr as $reg){
                $objRelTuboLote = new Rel_tubo_lote();
                $objRelTuboLote->setIdRelTuboLote($reg['idRelTuboLote']);
                $objRelTuboLote->setIdTubo_fk($reg['idTubo_fk']);
                $objRelTuboLote->setIdLote_fk($reg['idLote_fk']);

                $array[] = $objRelTuboLote;
            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o relacionamento do tubo com um dos seus lotes no BD.",$ex);
        }

    }

    public function consultar(Rel_tubo_lote $objRelTuboLote, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_rel_tubo_lote WHERE idRelTuboLote = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRelTuboLote->getIdRelTuboLote());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $tuboLote = new Rel_tubo_lote();
            $tuboLote->setIdRelTuboLote($arr[0]['idRelTuboLote']);
            $tuboLote->setIdLote_fk($arr[0]['idLote_fk']);
            $tuboLote->setIdTubo_fk($arr[0]['idTubo_fk']);

            return $tuboLote;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando o relacionamento do tubo com um dos seus lotes no BD.",$ex);
        }

    }

    public function remover(Rel_tubo_lote $objRelTuboLote, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_rel_tubo_lote WHERE idRelTuboLote = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objRelTuboLote->getIdRelTuboLote());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o relacionamento do tubo com um dos seus lotes no BD.",$ex);
        }
    }

    public function remover_peloIdLote(Rel_tubo_lote $objRelTuboLote, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_rel_tubo_lote WHERE idLote_fk = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objRelTuboLote->getIdLote_fk());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o relacionamento do tubo com um dos seus lotes no BD.",$ex);
        }
    }

}
