<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';


class PocoPlacaBD
{
    public function cadastrar(PocoPlaca $objPocoPlaca, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO tb_pocos_placa (idPlaca_fk, idPoco_fk) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPocoPlaca->getIdPlacaFk());
            $arrayBind[] = array('i',$objPocoPlaca->getIdPocoFk());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objPocoPlaca->setIdPocosPlaca($objBanco->obterUltimoID());
            return $objPocoPlaca;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o poço no BD.",$ex);
        }

    }

    public function alterar(PocoPlaca $objPocoPlaca, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_pocos_placa SET '
                . ' idPoco_fk = ?,'
                . ' idPlaca_fk = ?'
                . '  where idPocosPlaca = ?';


            $arrayBind = array();
            $arrayBind[] = array('i',$objPocoPlaca->getIdPocoFk());
            $arrayBind[] = array('i',$objPocoPlaca->getIdPlacaFk());

            $arrayBind[] = array('i',$objPocoPlaca->getIdPocosPlaca());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objPocoPlaca;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o poço no BD.",$ex);
        }

    }

    public function listar(PocoPlaca $objPocoPlaca, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_pocos_placa";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objPocoPlaca->getIdPlacaFk() != null) {
                $WHERE .= $AND . " idPlaca_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPocoPlaca->getIdPlacaFk() );
            }

            if ($objPocoPlaca->getIdPocoFk() != null) {
                $WHERE .= $AND . " idPoco_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPocoPlaca->getIdPocoFk() );
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            $array_poco_placa = array();
            foreach ($arr as $reg){
                $pocoPlaca = new PocoPlaca();
                $pocoPlaca->setIdPocosPlaca($reg['idPocosPlaca']);
                $pocoPlaca->setIdPlacaFk($reg['idPlaca_fk']);
                $pocoPlaca->setIdPocoFk($reg['idPoco_fk']);

                $array_poco_placa[] = $pocoPlaca;
            }
            return $array_poco_placa;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os poços das placas no BD.",$ex);
        }

    }

    public function consultar(PocoPlaca $objPocoPlaca, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_pocos_placa WHERE idPocosPlaca = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPocoPlaca->getIdPocosPlaca());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $pocoPlaca = new PocoPlaca();
            $pocoPlaca->setIdPocosPlaca($arr[0]['idPocosPlaca']);
            $pocoPlaca->setIdPlacaFk($arr[0]['idPlaca_fk']);
            $pocoPlaca->setIdPocoFk($arr[0]['idPoco_fk']);

            return $pocoPlaca;
        } catch (Throwable $ex) {
            throw new Excecao("Erro consultando o poço no BD.",$ex);
        }

    }

    public function remover(PocoPlaca $objPocoPlaca, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_pocos_placa WHERE idPocosPlaca = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objPocoPlaca->getIdPocosPlaca());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o poço no BD.",$ex);
        }
    }


}