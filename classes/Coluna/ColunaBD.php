<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';

class ColunaBD
{
    public function cadastrar(Coluna $objColuna, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO  tb_Coluna  (nome,idPrateleira_fk,situacaoColuna) VALUES (?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objColuna->getNome());
            $arrayBind[] = array('i',$objColuna->getIdPrateleira_fk());
            $arrayBind[] = array('s',$objColuna->getSituacaoColuna());

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objColuna->setIdColuna($objBanco->obterUltimoID());
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando Coluna  no BD.",$ex);
        }

    }

    public function alterar(Coluna $objColuna, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_Coluna SET '
                . ' nome = ?, '
                . ' idPrateleira_fk = ?, '
                . ' situacaoColuna = ? '
                . '  where idColuna = ?';


            $arrayBind = array();
            $arrayBind[] = array('s',$objColuna->getNome());
            $arrayBind[] = array('i',$objColuna->getIdPrateleira_fk());
            $arrayBind[] = array('s',$objColuna->getSituacaoColuna());
            $arrayBind[] = array('i',$objColuna->getIdColuna());


            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando Coluna no BD.",$ex);
        }

    }

    public function listar(Coluna $objColuna, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_Coluna";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objColuna->getSituacaoColuna() != null) {
                $WHERE .= $AND . " situacaoColuna = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objColuna->getSituacaoColuna());
            }

            if ($objColuna->getNome() != null) {
                $WHERE .= $AND . " nome LIKE ? ";
                $AND = ' and ';
                $arrayBind[] = array('s', "%".$objColuna->getNome()."%");
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            $array = array();
            foreach ($arr as $reg){
                $Coluna = new Coluna();
                $Coluna->setIdColuna($reg['idColuna']);
                $Coluna->setNome($reg['nome']);
                $Coluna->setSituacaoColuna($reg['situacaoColuna']);
                $Coluna->setIdPrateleira_fk($reg['idPrateleira_fk']);

                $array[] = $Coluna;
            }
            return $array;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando Coluna no BD.",$ex);
        }

    }

    public function consultar(Coluna $objColuna, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_Coluna WHERE idColuna = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objColuna->getIdColuna());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $Coluna  = new Coluna();
            $Coluna->setIdColuna($arr[0]['idColuna']);
            $Coluna->setNome($arr[0]['nome']);
            $Coluna->setSituacaoColuna($arr[0]['situacaoColuna']);
            $Coluna->setIdPrateleira_fk($arr[0]['idPrateleira_fk']);


            return  $Coluna ;
        } catch (Exception $ex) {

            throw new Excecao("Erro consultando Coluna no BD.",$ex);
        }

    }

    public function remover(Coluna $objColuna, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_Coluna WHERE idColuna = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objColuna->getIdColuna());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro removendo Coluna no BD.",$ex);
        }
    }
}