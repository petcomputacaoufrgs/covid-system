<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class PreparoLoteBD{

    public function cadastrar(PreparoLote $objPreparoLote, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO tb_preparo_lote (
                            idUsuario_fk,
                            idCapela_fk,
                            idLote_fk,
                            dataHoraInicio,
                            dataHoraFim
                            ) VALUES (?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPreparoLote->getIdUsuarioFk());
            $arrayBind[] = array('i',$objPreparoLote->getIdCapelaFk());
            $arrayBind[] = array('i',$objPreparoLote->getIdLoteFk());
            $arrayBind[] = array('s',$objPreparoLote->getDataHoraInicio());
            $arrayBind[] = array('s',$objPreparoLote->getDataHoraFim());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objPreparoLote->setIdPreparoLote($objBanco->obterUltimoID());

        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando o preparo do lote no BD.",$ex);
        }

    }

    public function alterar(PreparoLote $objPreparoLote, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_preparo_lote SET '
                . ' idUsuario_fk = ?,'
                . ' idCapela_fk = ?,'
                . ' idLote_fk = ?,'
                . ' dataHoraInicio = ?,'
                . ' dataHoraFim = ?'
                . '  where idPreparoLote = ?';


            $arrayBind = array();
            $arrayBind[] = array('i',$objPreparoLote->getIdUsuarioFk());
            $arrayBind[] = array('i',$objPreparoLote->getIdCapelaFk());
            $arrayBind[] = array('i',$objPreparoLote->getIdLoteFk());
            $arrayBind[] = array('s',$objPreparoLote->getDataHoraInicio());
            $arrayBind[] = array('s',$objPreparoLote->getDataHoraFim());

            $arrayBind[] = array('i',$objPreparoLote->getIdPreparoLote());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando o preparo do lote no BD.",$ex);
        }

    }

    public function listar(PreparoLote $objPreparoLote, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_preparo_lote";
            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            //fitro pelo lote
            if ($objPreparoLote->getIdLoteFk() != null) {
                $WHERE .= $AND . " idLote_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPreparoLote->getIdLoteFk() );
            }

            //filtro pela capela
            if ($objPreparoLote->getIdCapelaFk() != null) {
                $WHERE .= $AND . " idCapela_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPreparoLote->getIdCapelaFk());
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }


            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            $array = array();
            foreach ($arr as $reg){
                $objPreparoLote = new PreparoLote();
                $objPreparoLote->setIdPreparoLote($reg['idPreparoLote']);
                $objPreparoLote->setIdUsuarioFk($reg['idUsuario_fk']);
                $objPreparoLote->setIdCapelaFk($reg['idCapela_fk']);
                $objPreparoLote->setIdLoteFk($reg['idLote_fk']);
                $objPreparoLote->setDataHoraFim($reg['dataHoraFim']);
                $objPreparoLote->setDataHoraInicio($reg['dataHoraInicio']);

                $array[] = $objPreparoLote;
            }
            return $array;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando o preparo do lote no BD.",$ex);
        }

    }

    public function consultar(PreparoLote $objPreparoLote, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_preparo_lote WHERE idPreparoLote = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPreparoLote->getIdPreparoLote());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $preparoLote = new PreparoLote();
            $preparoLote->setIdPreparoLote($arr[0]['idPreparoLote']);
            $preparoLote->setIdUsuarioFk($arr[0]['idUsuario_fk']);
            $preparoLote->setIdCapelaFk($arr[0]['idCapela_fk']);
            $preparoLote->setIdLoteFk($arr[0]['idLote_fk']);
            $preparoLote->setDataHoraFim($arr[0]['dataHoraFim']);
            $preparoLote->setDataHoraInicio($arr[0]['dataHoraInicio']);

            return $preparoLote;
        } catch (Exception $ex) {

            throw new Excecao("Erro consultando preparo do lote no BD.",$ex);
        }

    }

    public function remover(PreparoLote $objPreparoLote, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_preparo_lote WHERE idPreparoLote = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objPreparoLote->getIdPreparoLote());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro removendo preparo do lote no BD.",$ex);
        }
    }

}
