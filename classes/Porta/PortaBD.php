<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';

class PortaBD
{
    public function cadastrar(Porta $objPorta, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO  tb_porta  (nome,idLocalArmazenamento_fk,situacaoPorta) VALUES (?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objPorta->getNome());
            $arrayBind[] = array('i',$objPorta->getIdLocalArmazenamentoFk());
            $arrayBind[] = array('s',$objPorta->getSituacaoPorta());

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objPorta->setIdPorta($objBanco->obterUltimoID());
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando porta  no BD.",$ex);
        }

    }

    public function alterar(Porta $objPorta, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_porta SET '
                . ' nome = ?, '
                . ' idLocalArmazenamento_fk = ?, '
                . ' situacaoPorta = ? '
                . '  where idPorta = ?';


            $arrayBind = array();
            $arrayBind[] = array('s',$objPorta->getNome());
            $arrayBind[] = array('i',$objPorta->getIdLocalArmazenamentoFk());
            $arrayBind[] = array('s',$objPorta->getSituacaoPorta());

            $arrayBind[] = array('i',$objPorta->getIdPorta());


            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando porta no BD.",$ex);
        }

    }

    public function listar(Porta $objPorta, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_porta ";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objPorta->getSituacaoPorta() != null) {
                $WHERE .= $AND . " situacaoPorta = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPorta->getSituacaoPorta());
            }

            if ($objPorta->getNome() != null) {
                $WHERE .= $AND . " nome LIKE ? ";
                $AND = ' and ';
                $arrayBind[] = array('s', "%".$objPorta->getNome()."%");
            }

            if ($objPorta->getIdLocalArmazenamentoFk() != null) {
                $WHERE .= $AND . " idLocalArmazenamento_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPorta->getIdLocalArmazenamentoFk());
            }

            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);


            $array = array();
            foreach ($arr as $reg){
                $Porta = new Porta();
                $Porta->setIdPorta($reg['idPorta']);
                $Porta->setNome($reg['nome']);
                $Porta->setSituacaoPorta($reg['situacaoPorta']);
                $Porta->setIdLocalArmazenamentoFk($reg['idLocalArmazenamento_fk']);

                $array[] = $Porta;
            }
            return $array;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando porta no BD.",$ex);
        }

    }

    public function consultar(Porta $objPorta, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_porta WHERE idPorta = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPorta->getIdPorta());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $Porta  = new Porta();
            $Porta ->setIdPorta($arr[0]['idPorta']);
            $Porta ->setNome($arr[0]['nome']);
            $Porta->setSituacaoPorta($arr[0]['situacaoPorta']);
            $Porta->setIdLocalArmazenamentoFk($arr[0]['idLocalArmazenamento_fk']);


            return  $Porta ;
        } catch (Exception $ex) {

            throw new Excecao("Erro consultando porta no BD.",$ex);
        }

    }

    public function remover(Porta $objPorta, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_porta WHERE idPorta = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objPorta->getIdPorta());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro removendo porta no BD.",$ex);
        }
    }
}