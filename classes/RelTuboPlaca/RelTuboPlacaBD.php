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
            $arrayBind[] = array('i',$objRelTuboPlaca->getIdRelTuboPlaca());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o relacionamento dos tubos com uma placa no BD.",$ex);
        }
    }
}