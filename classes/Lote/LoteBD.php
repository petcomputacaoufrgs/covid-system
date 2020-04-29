<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class LoteBD{

    public function cadastrar(Lote $objLote, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO tb_lote (
                            qntAmostrasDesejadas,
                            qntAmostrasAdquiridas,
                            situacaoLote
                            ) VALUES (?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objLote->getQntAmostrasDesejadas());
            $arrayBind[] = array('i',$objLote->getQntAmostrasAdquiridas());
            $arrayBind[] = array('s',$objLote->getSituacaoLote());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objLote->setIdLote($objBanco->obterUltimoID());
            return $objLote;
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando o lote no BD.",$ex);
        }

    }

    public function alterar(Lote $objLote, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_lote SET '
                . ' qntAmostrasDesejadas = ?,'
                . ' qntAmostrasAdquiridas = ?,'
                . ' situacaoLote = ?'
                . '  where idLote = ?';


            $arrayBind = array();
            $arrayBind[] = array('i',$objLote->getQntAmostrasDesejadas());
            $arrayBind[] = array('i',$objLote->getQntAmostrasAdquiridas());
            $arrayBind[] = array('s',$objLote->getSituacaoLote());

            $arrayBind[] = array('i',$objLote->getIdLote());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando o lote no BD.",$ex);
        }

    }

    public function listar(Lote $objLote, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_lote";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objLote->getSituacaoLote() != null) {
                $WHERE .= $AND . " situacaoLote = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objLote->getSituacaoLote());
            }

            if ($objLote->getQntAmostrasDesejadas()!= null) {
                $WHERE .= $AND . " qntAmostrasDesejadas = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objLote->getQntAmostrasDesejadas());
            }

            if ($objLote->getQntAmostrasAdquiridas()!= null) {
                $WHERE .= $AND . " qntAmostrasAdquiridas = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objLote->getQntAmostrasAdquiridas());
            }



            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            //echo $SELECT.$WHERE;$WHERE

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            $array = array();
            foreach ($arr as $reg){
                $objLote = new Lote();
                $objLote->setIdLote($reg['idLote']);
                $objLote->setQntAmostrasDesejadas($reg['qntAmostrasDesejadas']);
                $objLote->setQntAmostrasAdquiridas($reg['qntAmostrasAdquiridas']);
                $objLote->setSituacaoLote($reg['situacaoLote']);

                $array[] = $objLote;
            }
            return $array;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando o lote no BD.",$ex);
        }

    }

    public function consultar(Lote $objLote, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_lote WHERE idLote = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objLote->getIdLote());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $perfilUsu = new Lote();
            $perfilUsu->setIdLote($arr[0]['idLote']);
            $perfilUsu->setQntAmostrasDesejadas($arr[0]['qntAmostrasDesejadas']);
            $perfilUsu->setQntAmostrasAdquiridas($arr[0]['qntAmostrasAdquiridas']);
            $perfilUsu->setSituacaoLote($arr[0]['situacaoLote']);

            return $perfilUsu;
        } catch (Exception $ex) {

            throw new Excecao("Erro consultando o lote no BD.",$ex);
        }

    }

    public function remover(Lote $objLote, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_lote WHERE idLote = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objLote->getIdLote());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro removendo o lote no BD.",$ex);
        }
    }

}
