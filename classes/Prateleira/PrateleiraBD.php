<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';

class PrateleiraBD
{
    public function cadastrar(Prateleira $objPrateleira, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO  tb_Prateleira  (nome,idPorta_fk) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objPrateleira->getNome());
            $arrayBind[] = array('i',$objPrateleira->getIdPorta_fk());

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objPrateleira->setIdPrateleira($objBanco->obterUltimoID());
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando Prateleira  no BD.",$ex);
        }

    }

    public function alterar(Prateleira $objPrateleira, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_Prateleira SET '
                . ' nome = ? '
                . ' idPorta_fk = ?, '
                . '  where idPrateleira = ?';


            $arrayBind = array();
            $arrayBind[] = array('s',$objPrateleira->getNome());
            $arrayBind[] = array('i',$objPrateleira->getIdPorta_fk());
            $arrayBind[] = array('i',$objPrateleira->getIdPrateleira());



            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando Prateleira no BD.",$ex);
        }

    }

    public function listar(Prateleira $objPrateleira, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_Prateleira";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objPrateleira->getSituacaoPrateleira() != null) {
                $WHERE .= $AND . " situacaoPrateleira = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPrateleira->getSituacaoPrateleira());
            }

            if ($objPrateleira->getNome() != null) {
                $WHERE .= $AND . " nome LIKE ? ";
                $AND = ' and ';
                $arrayBind[] = array('s', "%".$objPrateleira->getNome()."%");
            }

            if ($objPrateleira->getIdPorta_fk() != null) {
                $WHERE .= $AND . " idPorta_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPrateleira->getIdPorta_fk());
            }

            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);



            $array = array();
            foreach ($arr as $reg){
                $Prateleira = new Prateleira();
                $Prateleira->setIdPrateleira($reg['idPrateleira']);
                $Prateleira->setNome($reg['nome']);
                $Prateleira->setIdPorta_fk($reg['idPorta_fk']);

                $array[] = $Prateleira;
            }
            return $array;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando Prateleira no BD.",$ex);
        }

    }

    public function consultar(Prateleira $objPrateleira, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_Prateleira WHERE idPrateleira = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPrateleira->getIdPrateleira());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $Prateleira  = new Prateleira();
            $Prateleira ->setIdPrateleira($arr[0]['idPrateleira']);
            $Prateleira ->setNome($arr[0]['nome']);
            $Prateleira->setIdPorta_fk($arr[0]['idPorta_fk']);


            return  $Prateleira ;
        } catch (Exception $ex) {

            throw new Excecao("Erro consultando Prateleira no BD.",$ex);
        }

    }

    public function remover(Prateleira $objPrateleira, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_Prateleira WHERE idPrateleira = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objPrateleira->getIdPrateleira());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro removendo Prateleira no BD.",$ex);
        }
    }
}