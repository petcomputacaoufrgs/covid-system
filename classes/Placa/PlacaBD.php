<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';

require_once __DIR__ . '/../Protocolo/ProtocoloRN.php';
require_once __DIR__ . '/../Protocolo/Protocolo.php';

class PlacaBD
{
    public function cadastrar(Placa $objPlaca, Banco $objBanco) {
        try{

            //die("die");
            $INSERT = 'INSERT INTO tb_placa (placa, index_placa,situacaoPlaca,idProtocolo_fk) VALUES (?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objPlaca->getPlaca());
            $arrayBind[] = array('s',$objPlaca->getIndexPlaca());
            $arrayBind[] = array('s',$objPlaca->getSituacaoPlaca());
            $arrayBind[] = array('i',$objPlaca->getIdProtocoloFk());

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objPlaca->setIdPlaca($objBanco->obterUltimoID());
            return $objPlaca;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o placa no BD.",$ex);
        }

    }

    public function alterar(Placa $objPlaca, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_placa SET '
                . ' placa = ?,'
                . ' index_placa = ?,'
                . ' situacaoPlaca = ?,'
                . ' idProtocolo_fk = ?'
                . '  where idPlaca = ?';


            $arrayBind = array();
            $arrayBind[] = array('s',$objPlaca->getPlaca());
            $arrayBind[] = array('s',$objPlaca->getIndexPlaca());
            $arrayBind[] = array('s',$objPlaca->getSituacaoPlaca());
            $arrayBind[] = array('i',$objPlaca->getIdProtocoloFk());

            $arrayBind[] = array('i',$objPlaca->getIdPlaca());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objPlaca;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando a placa no BD.",$ex);
        }

    }

    public function listar(Placa $objPlaca, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_placa";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objPlaca->getIdProtocoloFk() != null) {
                $WHERE .= $AND . " idProtocolo_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPlaca->getIdProtocoloFk());
            }

            if ($objPlaca->getIndexPlaca() != null) {
                $WHERE .= $AND . " index_placa = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPlaca->getIndexPlaca());
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }


            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);


            $array_placa = array();
            foreach ($arr as $reg){
                $placa = new Placa();
                $placa->setIdPlaca($reg['idPlaca']);
                $placa->setPlaca($reg['placa']);
                $placa->setIdProtocoloFk($reg['idProtocolo_fk']);
                $placa->setIndexPlaca($reg['index_placa']);
                $placa->setSituacaoPlaca($reg['situacaoPlaca']);

                $select_protocolo = 'select * from tb_protocolo where idProtocolo = ?';
                $arrayBind2 = array();
                $arrayBind2[] = array('i', $reg['idProtocolo_fk']);
                $protocolo = $objBanco->consultarSQL($select_protocolo, $arrayBind2);

                $placa->setObjProtocolo($protocolo);

                $array_placa[] = $placa;
            }
            return $array_placa;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando as placas no BD.",$ex);
        }

    }

    public function consultar(Placa $objPlaca, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_placa WHERE idPlaca = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPlaca->getIdPlaca());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);


            $placa = new Placa();
            $placa->setIdPlaca($arr[0]['idPlaca']);
            $placa->setPlaca($arr[0]['placa']);
            $placa->setIndexPlaca($arr[0]['index_placa']);
            $placa->setSituacaoPlaca($arr[0]['situacaoPlaca']);
            $placa->setIdProtocoloFk($arr[0]['idProtocolo_fk']);

            return $placa;
        } catch (Throwable $ex) {
            throw new Excecao("Erro consultando a placa no BD.",$ex);
        }

    }

    public function remover(Placa $objPlaca, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_placa WHERE idPlaca = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objPlaca->getIdPlaca());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo a placa no BD.",$ex);
        }
    }


    public function ja_existe_placa(Placa $objPlaca, Banco $objBanco) {

        try{

            $SELECT = "SELECT idPlaca from tb_placa WHERE index_placa = ? and index_placa != '' LIMIT 1";

            $arrayBind = array();
            $arrayBind[] = array('s',$objPlaca->getIndexPlaca());
            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);

            if(count($arr) > 0){
                return true;
            }

            return false;

        } catch (Throwable $ex) {
            throw new Excecao("Erro verificando se já existe uma placa no BD.",$ex);
        }
    }


    public function existe_placa_com_o_placa(Placa $objPlaca, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_placa,tb_placa  
                        where tb_placa.idPlaca_fk = tb_placa.idPlaca 
                        and tb_placa.idPlaca = ?
                        LIMIT 1";

            $arrayBind = array();
            $arrayBind[] = array('i',$objPlaca->getIdPlaca());
            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);

            if(count($arr) > 0){
                return true;
            }
            return false;
        } catch (Throwable $ex) {
            throw new Excecao("Erro verificando se existe uma placa com o placa no BD.",$ex);
        }

    }

}