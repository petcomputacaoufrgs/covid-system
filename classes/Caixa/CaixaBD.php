<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';


class CaixaBD
{
    public function cadastrar(Caixa $objCaixa, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO  tb_caixa  (nome,qntSlotsOcupados,qntSlotsVazios,qntColunas,qntLinhas,idColuna_fk) VALUES (?,?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objCaixa->getNome());
            $arrayBind[] = array('i',$objCaixa->getQntSlotsOcupados());
            $arrayBind[] = array('i',$objCaixa->getQntSlotsVazios());
            $arrayBind[] = array('i',$objCaixa->getQntColunas());
            $arrayBind[] = array('i',$objCaixa->getQntLinhas());
            $arrayBind[] = array('i',$objCaixa->getIdColuna_fk());

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objCaixa->setIdCaixa($objBanco->obterUltimoID());
            return $objCaixa;
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando Caixa  no BD.",$ex);
        }

    }

    public function alterar(Caixa $objCaixa, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_caixa SET '
                . ' nome = ?, '
                . ' qntSlotsOcupados = ?, '
                . ' qntSlotsVazios = ?, '
                . ' qntColunas = ?,'
                . ' qntLinhas = ?,'
                . ' idColuna_fk = ?,'
                . '  where idCaixa = ?';


            $arrayBind = array();
            $arrayBind[] = array('s',$objCaixa->getNome());
            $arrayBind[] = array('i',$objCaixa->getQntSlotsOcupados());
            $arrayBind[] = array('i',$objCaixa->getQntSlotsVazios());
            $arrayBind[] = array('i',$objCaixa->getQntColunas());
            $arrayBind[] = array('i',$objCaixa->getQntLinhas());
            $arrayBind[] = array('i',$objCaixa->getIdColuna_fk());


            $arrayBind[] = array('i',$objCaixa->getIdCaixa());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando Caixa no BD.",$ex);
        }

    }

    public function listar(Caixa $objCaixa, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_caixa";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objCaixa->getQntSlotsOcupados() != null) {
                $WHERE .= $AND . " qntSlotsOcupados = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objCaixa->getQntSlotsOcupados());
            }



            if ($objCaixa->getQntSlotsVazios() != null) {
                $WHERE .= $AND . "qntSlotsVazios =? ";
                $AND = ' and ';
                $arrayBind[] = array('i',$objCaixa->getQntSlotsVazios());
            }

            if ($objCaixa->getQntLinhas() != null) {
                $WHERE .= $AND . "qntLinhas =? ";
                $AND = ' and ';
                $arrayBind[] = array('i', $objCaixa->getQntLinhas());
            }

            if ($objCaixa->getQntColunas() != null) {
                $WHERE .= $AND . "qntColunas =? ";
                $AND = ' and ';
                $arrayBind[] = array('i',$objCaixa->getQntColunas());
            }

            if ($objCaixa->getIdColuna_fk() != null) {
                $WHERE .= $AND . " idColuna_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objCaixa->getIdColuna_fk());
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);


            $array = array();
            foreach ($arr as $reg){
                $Caixa = new Caixa();
                $Caixa->setIdCaixa($reg['idCaixa']);
                $Caixa->setNome($reg['nome']);
                $Caixa->setQntSlotsOcupados($reg['qntSlotsOcupados']);
                $Caixa->setQntSlotsVazios($reg['qntSlotsVazios']);
                $Caixa->setQntColunas($reg['qntColunas']);
                $Caixa->setQntLinhas($reg['qntLinhas']);
                $Caixa->setIdColuna_fk($reg['idColuna_fk']);

                $array[] = $Caixa;
            }
            return $array;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando Caixa no BD.",$ex);
        }

    }

    public function consultar(Caixa $objCaixa, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_caixa WHERE idCaixa = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objCaixa->getIdCaixa());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $Caixa  = new Caixa();
            $Caixa->setIdCaixa($arr[0]['idCaixa']);
            $Caixa->setNome($arr[0]['nome']);
            $Caixa->setQntSlotsOcupados($arr[0]['qntSlotsOcupados']);
            $Caixa->setQntSlotsVazios($arr[0]['qntSlotsVazios']);
            $Caixa->setQntColunas($arr[0]['qntColunas']);
            $Caixa->setQntLinhas($arr[0]['qntLinhas']);
            $Caixa->setIdColuna_fk($arr[0]['idColuna_fk']);

            return  $Caixa ;
        } catch (Exception $ex) {

            throw new Excecao("Erro consultando Caixa no BD.",$ex);
        }

    }

    public function remover(Caixa $objCaixa, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_caixa WHERE idCaixa = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objCaixa->getIdCaixa());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro removendo Caixa no BD.",$ex);
        }
    }



}