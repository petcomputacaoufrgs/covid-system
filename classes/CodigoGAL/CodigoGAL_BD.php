<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';

class CodigoGAL_BD {

    public function cadastrar(CodigoGAL $objCodigoGAL, Banco $objBanco) {
        try {

            $INSERT = 'INSERT INTO tb_codgal (codigo,idPaciente_fk,obsCodGAL) VALUES (?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i', $objCodigoGAL->getCodigo());
            $arrayBind[] = array('i', $objCodigoGAL->getIdPaciente_fk());
            $arrayBind[] = array('s', $objCodigoGAL->getObsCodGAL());

            //echo $INSERT;
            $objBanco->executarSQL($INSERT, $arrayBind);
            $objCodigoGAL->setIdCodigoGAL($objBanco->obterUltimoID());
            
            return $objCodigoGAL;
        } catch (Throwable $ex) {
            DIE($ex);
            throw new Excecao("Erro cadastrando o código GAL no BD.", $ex);
        }
    }

    public function alterar(CodigoGAL $objCodigoGAL, Banco $objBanco) {
        try {

            $UPDATE = 'UPDATE tb_codgal SET '
                    . ' codigo = ? ,'
                    . ' idPaciente_fk = ?,'
                    . ' obsCodGAL = ?'
                    . ' where idCodGAL = ?';


            $arrayBind = array();
            $arrayBind[] = array('i', $objCodigoGAL->getCodigo());
            $arrayBind[] = array('i', $objCodigoGAL->getIdPaciente_fk());
            $arrayBind[] = array('s', $objCodigoGAL->getObsCodGAL());

            $arrayBind[] = array('i', $objCodigoGAL->getIdCodigoGAL());

            $objBanco->executarSQL($UPDATE, $arrayBind);
            return $objCodigoGAL;

        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o código GAL  no BD.", $ex);
        }
    }

    public function listar(CodigoGAL $objCodigoGAL, Banco $objBanco) {
        try {

            //print_r($objCodigoGAL);
            // DIE("DIE LISTA");
            $SELECT = "SELECT * FROM tb_codgal";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objCodigoGAL->getCodigo() != null) {
                $WHERE .= $AND . " codigo = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objCodigoGAL->getCodigo());
            }

            if ($objCodigoGAL->getIdPaciente_fk() != null) {
                $WHERE .= $AND . " idPaciente_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objCodigoGAL->getIdPaciente_fk());
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            //echo $SELECT.$WHERE;$WHERE
            
            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            //print_r($arr);
            //die();
            $array_marca = array();
            foreach ($arr as $reg) {
                $objCodigoGAL = new CodigoGAL();
                $objCodigoGAL->setIdCodigoGAL($reg['idCodGAL']);
                $objCodigoGAL->setCodigo($reg['codigo']);
                $objCodigoGAL->setIdPaciente_fk($reg['idPaciente_fk']);
                $objCodigoGAL->setObsCodGAL($reg['obsCodGAL']);


                $array_marca[] = $objCodigoGAL;
            }
            return $array_marca;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o código GAL  no BD.", $ex);
        }
    }

    public function consultar(CodigoGAL $objCodigoGAL, Banco $objBanco) {

        try {

            $SELECT = 'SELECT * FROM tb_codgal WHERE idCodGAL = ?';

            $arrayBind = array();
            $arrayBind[] = array('i', $objCodigoGAL->getIdCodigoGAL());

            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);

            $paciente = new CodigoGAL();
            $paciente->setIdCodigoGAL($arr[0]['idCodigoGAL']);
            $paciente->setCodigo($arr[0]['codigo']);
            $paciente->setIdPaciente_fk($arr[0]['idPaciente_fk']);
            $paciente->setObsCodGAL($arr[0]['obsCodGAL']);

            return $paciente;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando o código GAL  no BD.", $ex);
        }
    }

    public function remover(CodigoGAL $objCodigoGAL, Banco $objBanco) {

        try {

            $DELETE = 'DELETE FROM tb_codgal WHERE idCodGAL = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i', $objCodigoGAL->getIdCodigoGAL());
            $objBanco->executarSQL($DELETE, $arrayBind);
        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o código GAL  no BD.", $ex);
        }
    }

    public function procurarGAL(CodigoGAL $objCodigoGAL, Banco $objBanco) {
        try {


            $SELECT = "SELECT * FROM tb_codgal";


            $arr = $objBanco->consultarSQL($SELECT);


            $array = array();
            foreach ($arr as $reg) {
                if($objCodigoGAL->getIdPaciente_fk() != $reg['idPaciente_fk']) {
                    if($reg['codigo'] == $objCodigoGAL->getCodigo()){
                        $objCodigoGAL = new CodigoGAL();
                        $objCodigoGAL->setIdCodigoGAL($reg['idCodGAL']);
                        $objCodigoGAL->setCodigo($reg['codigo']);
                        $objCodigoGAL->setIdPaciente_fk($reg['idPaciente_fk']);
                        $objCodigoGAL->setObsCodGAL($reg['obsCodGAL']);


                        $array[] = $objCodigoGAL;
                    }
                }
            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o código GAL  no BD.", $ex);
        }
    }

}
