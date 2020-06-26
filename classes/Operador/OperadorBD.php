<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class OperadorBD{

    public function cadastrar(Operador $objOperador, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO tb_operador (valor,nome,idCalculo_fk) VALUES (?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objOperador->getValor());
            $arrayBind[] = array('s',$objOperador->getNome());
            $arrayBind[] = array('i',$objOperador->getIdCalculoFk());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objOperador->setIdOperador($objBanco->obterUltimoID());
            return$objOperador;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o operador no BD.",$ex);
        }

    }

    public function alterar(Operador $objOperador, Banco $objBanco) {
        try{

            $UPDATE = 'UPDATE tb_operador SET '
                . ' valor = ?,'
                . ' nome = ?,'
                . ' idCalculo_fk = ?'
                . '  where idOperador = ?';


            $arrayBind = array();
            $arrayBind[] = array('s',$objOperador->getValor());
            $arrayBind[] = array('s',$objOperador->getNome());
            $arrayBind[] = array('i',$objOperador->getIdCalculoFk());

            $arrayBind[] = array('i',$objOperador->getIdOperador());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objOperador;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o operador no BD.",$ex);
        }

    }

    public function listar(Operador $objOperador, $numLimite = null, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_operador";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objOperador->getIdOperador() != null) {
                $WHERE .= $AND . " idOperador = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objOperador->getIdOperador());
            }

            if ($objOperador->getIdCalculoFk() != null) {
                $WHERE .= $AND . " idCalculo_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objOperador->getIdCalculoFk());
            }

            if ($objOperador->getNome() != null) {
                $WHERE .= $AND . " nome = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objOperador->getNome());
            }

            if ($objOperador->getValor() != null) {
                $WHERE .= $AND . " valor = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objOperador->getValor());
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
                $operador = new Operador();
                $operador->setIdOperador($reg['idOperador']);
                $operador->setIdCalculoFk($reg['idCalculo_fk']);
                $operador->setNome($reg['nome']);
                $operador->setValor($reg['valor']);

                $array[] = $operador;
            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o operador no BD.",$ex);
        }

    }

    public function listar_completo(Operador $objOperador, $numLimite = null, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_operador";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objOperador->getIdOperador() != null) {
                $WHERE .= $AND . " idOperador = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objOperador->getIdOperador());
            }

            if ($objOperador->getIdCalculoFk() != null) {
                $WHERE .= $AND . " idCalculo_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objOperador->getIdCalculoFk());
            }

            if ($objOperador->getNome() != null) {
                $WHERE .= $AND . " nome = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objOperador->getNome());
            }

            if ($objOperador->getValor() != null) {
                $WHERE .= $AND . " valor = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objOperador->getValor());
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
                $operador = new Operador();
                $operador->setIdOperador($reg['idOperador']);
                $operador->setIdCalculoFk($reg['idCalculo_fk']);
                $operador->setNome($reg['nome']);
                $operador->setValor($reg['valor']);

                $objCalculo = new Calculo();
                $objCalculoRN = new CalculoRN();
                $objCalculo->setIdCalculo($operador->getIdCalculoFk());
                $objCalculo = $objCalculoRN->consultar($objCalculo);
                $operador->setObjCalculo($objCalculo);

                $array[] = $operador;
            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o operador no BD.",$ex);
        }

    }

    public function consultar(Operador $objOperador, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_operador WHERE idOperador = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objOperador->getIdOperador());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $operador = new Operador();
            $operador->setIdOperador($arr[0]['idOperador']);
            $operador->setIdCalculoFk($arr[0]['idCalculo_fk']);
            $operador->setNome($arr[0]['nome']);
            $operador->setValor($arr[0]['valor']);

            return $operador;
        } catch (Throwable $ex) {
            throw new Excecao("Erro consultando o operador no BD.",$ex);
        }

    }

    public function remover(Operador $objOperador, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_operador WHERE idOperador = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objOperador->getIdOperador());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o operador no BD.",$ex);
        }
    }


}
