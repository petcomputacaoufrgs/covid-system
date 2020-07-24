<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class CalculoBD
{
    public function cadastrar(Calculo $objCalculo, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO tb_calculo (nome,idProtocolo_fk) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objCalculo->getNome());
            $arrayBind[] = array('i',$objCalculo->getIdProtocoloFk());

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objCalculo->setIdCalculo($objBanco->obterUltimoID());
            return$objCalculo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o cálculo no BD (CalculoBD).",$ex);
        }

    }

    public function alterar(Calculo $objCalculo, Banco $objBanco) {
        try{

            $UPDATE = 'UPDATE tb_calculo SET '
                . ' nome = ?,'
                . ' idProtocolo_fk = ?'
                . '  where idCalculo = ?';


            $arrayBind = array();
            $arrayBind[] = array('s',$objCalculo->getNome());
            $arrayBind[] = array('i',$objCalculo->getIdProtocoloFk());

            $arrayBind[] = array('i',$objCalculo->getIdCalculo());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objCalculo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o cálculo no BD (CalculoBD).",$ex);
        }

    }

    public function listar(Calculo $objCalculo, $numLimite = null, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_calculo";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objCalculo->getIdCalculo() != null) {
                $WHERE .= $AND . " idCalculo = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objCalculo->getIdCalculo());
            }

            if ($objCalculo->getIdProtocoloFk() != null) {
                $WHERE .= $AND . " idProtocolo_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objCalculo->getIdProtocoloFk());
            }

            if ($objCalculo->getNome() != null) {
                $WHERE .= $AND . " nome = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objCalculo->getNome());
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
                $calculo = new Calculo();
                $calculo->setIdCalculo($reg['idCalculo']);
                $calculo->setIdProtocoloFk($reg['idProtocolo_fk']);
                $calculo->setNome($reg['nome']);

                $array[] = $calculo;
            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o cálculo no BD (CalculoBD).",$ex);
        }

    }

    public function listar_completo(Calculo $objCalculo, $numLimite = null, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_calculo";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objCalculo->getIdCalculo() != null) {
                $WHERE .= $AND . " idCalculo = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objCalculo->getIdCalculo());
            }

            if ($objCalculo->getIdProtocoloFk() != null) {
                $WHERE .= $AND . " idProtocolo_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objCalculo->getIdProtocoloFk());
            }

            if ($objCalculo->getNome() != null) {
                $WHERE .= $AND . " nome = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objCalculo->getNome());
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
                $calculo = new Calculo();
                $calculo->setIdCalculo($reg['idCalculo']);
                $calculo->setIdProtocoloFk($reg['idProtocolo_fk']);
                $calculo->setNome($reg['nome']);

                $objProtocolo = new Protocolo();
                $objProtocoloRN = new ProtocoloRN();

                $objProtocolo->setIdProtocolo($calculo->getIdProtocoloFk());
                $objProtocolo = $objProtocoloRN->consultar($objProtocolo);

                $calculo->setObjProtocolo($objProtocolo);

                $objOperador = new Operador();
                $objOperadorRN = new OperadorRN();
                $objOperador->setIdCalculoFk($calculo->getIdCalculo());
                $arr_operadores = $objOperadorRN->listar($objOperador);
                $calculo->setObjOperador($arr_operadores);

                $array[] = $calculo;
            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o cálculo no BD (CalculoBD).",$ex);
        }

    }

    public function consultar(Calculo $objCalculo, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_calculo WHERE idCalculo = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objCalculo->getIdCalculo());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $calculo = new Calculo();
            if(count($arr) > 0) {
                $calculo->setIdCalculo($arr[0]['idCalculo']);
                $calculo->setIdProtocoloFk($arr[0]['idProtocolo_fk']);
                $calculo->setNome($arr[0]['nome']);
            }

            return $calculo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro consultando o cálculo no BD (CalculoBD).",$ex);
        }

    }

    public function remover(Calculo $objCalculo, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_calculo WHERE idCalculo = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objCalculo->getIdCalculo());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o cálculo no BD (CalculoBD).",$ex);
        }
    }
}