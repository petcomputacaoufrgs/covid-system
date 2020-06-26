<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class RelMixOperadorBD
{
    public function cadastrar(RelMixOperador $objRelMixOperador, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO tb_rel_mix_operador (valor,idOperador_fk,idMix_fk) VALUES (?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objRelMixOperador->getValor());
            $arrayBind[] = array('i',$objRelMixOperador->getIdOperadorFk());
            $arrayBind[] = array('i',$objRelMixOperador->getIdMixFk());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objRelMixOperador->setIdRelMixOperador($objBanco->obterUltimoID());
            return$objRelMixOperador;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o o relacionamento do mix com seus operadores no BD.",$ex);
        }

    }

    public function alterar(RelMixOperador $objRelMixOperador, Banco $objBanco) {
        try{

            $UPDATE = 'UPDATE tb_rel_mix_operador SET '
                . ' valor = ?,'
                . ' idOperador_fk = ?,'
                . ' idMix_fk = ?'
                . '  where idRelMixOperador = ?';


            $arrayBind = array();
            $arrayBind[] = array('s',$objRelMixOperador->getValor());
            $arrayBind[] = array('i',$objRelMixOperador->getIdOperadorFk());
            $arrayBind[] = array('i',$objRelMixOperador->getIdMixFk());

            $arrayBind[] = array('i',$objRelMixOperador->getIdRelMixOperador());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objRelMixOperador;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o o relacionamento do mix com seus operadores no BD.",$ex);
        }

    }

    public function listar(RelMixOperador $objRelMixOperador, $numLimite = null, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_rel_mix_operador";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objRelMixOperador->getIdRelMixOperador() != null) {
                $WHERE .= $AND . " idRelMixOperador = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objRelMixOperador->getIdRelMixOperador());
            }

            if ($objRelMixOperador->getIdOperadorFk() != null) {
                $WHERE .= $AND . " idOperador_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objRelMixOperador->getIdOperadorFk());
            }

            if ($objRelMixOperador->getValor() != null) {
                $WHERE .= $AND . " valor = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objRelMixOperador->getValor());
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            $LIMIT = '';
            if(!is_null($numLimite)){
                $LIMIT = ' LIMIT ?';
                $arrayBind[] = array('i',$numLimite);
            }

            $arr = $objBanco->consultarSQL($SELECT.$WHERE.$LIMIT,$arrayBind);

            $array= array();
            foreach ($arr as $reg){
                $relMixOperador = new RelMixOperador();
                $relMixOperador->setIdRelMixOperador($reg['idRelMixOperador']);
                $relMixOperador->setIdOperadorFk($reg['idOperador_fk']);
                $relMixOperador->setIdMixFk($reg['idMix_fk']);
                $relMixOperador->setValor($reg['valor']);

                $array[] = $relMixOperador;
            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o o relacionamento do mix com seus operadores no BD.",$ex);
        }

    }

    public function listar_completo(RelMixOperador $objRelMixOperador, $numLimite = null, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_rel_mix_operador";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objRelMixOperador->getIdRelMixOperador() != null) {
                $WHERE .= $AND . " idRelMixOperador = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objRelMixOperador->getIdRelMixOperador());
            }

            if ($objRelMixOperador->getIdMixFk() != null) {
                $WHERE .= $AND . " idMix_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objRelMixOperador->getIdMixFk());
            }

            if ($objRelMixOperador->getIdOperadorFk() != null) {
                $WHERE .= $AND . " idOperador_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objRelMixOperador->getIdOperadorFk());
            }
            if ($objRelMixOperador->getValor() != null) {
                $WHERE .= $AND . " valor = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objRelMixOperador->getValor());
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            $LIMIT = '';
            if(!is_null($numLimite)){
                $LIMIT = ' LIMIT ?';
                $arrayBind[] = array('i',$numLimite);
            }

            $arr = $objBanco->consultarSQL($SELECT.$WHERE.$LIMIT,$arrayBind);

            $array= array();
            foreach ($arr as $reg){
                $relMixOperador = new RelMixOperador();
                $relMixOperador->setIdRelMixOperador($reg['idRelMixOperador']);
                $relMixOperador->setIdMixFk($reg['idMix_fk']);
                $relMixOperador->setIdOperadorFk($reg['idOperador_fk']);
                $relMixOperador->setValor($reg['valor']);

                $objMix = new MixRTqPCR();
                $objMixRN = new MixRTqPCR_RN();
                $objMix->setIdMixPlaca($relMixOperador->getIdMixFk());
                $objMix = $objMixRN->consultar($objMix);
                $relMixOperador->setObjMix($objMix);

                $objOperador = new Operador();
                $objOperadorRN = new OperadorRN();
                $objOperador->setIdOperador($relMixOperador->getIdOperadorFk());
                $objOperador = $objOperadorRN->listar_completo($objOperador);
                $relMixOperador->setObjOperador($objOperador[0]);

                $array[] = $relMixOperador;
            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o o relacionamento do mix com seus operadores no BD.",$ex);
        }

    }

    public function consultar(RelMixOperador $objRelMixOperador, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_rel_mix_operador WHERE idRelMixOperador = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRelMixOperador->getIdRelMixOperador());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $relMixOperador = new RelMixOperador();
            $relMixOperador->setIdRelMixOperador($arr[0]['idRelMixOperador']);
            $relMixOperador->setIdOperadorFk($arr[0]['idOperador_fk']);
            $relMixOperador->setIdMixFk($arr[0]['idMix_fk']);
            $relMixOperador->setValor($arr[0]['valor']);

            return $relMixOperador;
        } catch (Throwable $ex) {
            throw new Excecao("Erro consultando o o relacionamento do mix com seus operadores no BD.",$ex);
        }

    }

    public function remover(RelMixOperador $objRelMixOperador, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_rel_mix_operador WHERE idRelMixOperador = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objRelMixOperador->getIdRelMixOperador());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o o relacionamento do mix com seus operadores no BD.",$ex);
        }
    }
}