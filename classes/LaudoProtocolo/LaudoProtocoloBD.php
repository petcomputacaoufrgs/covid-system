<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';

class LaudoProtocoloBD
{
    public function cadastrar(LaudoProtocolo $objLaudoProtocolo, Banco $objBanco)
    {
        try {

            $INSERT = 'INSERT INTO tb_laudo_protocolo (idLaudo_fk, idProtocolo_fk)
                        VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i', $objLaudoProtocolo->getIdLaudoFk());
            $arrayBind[] = array('i', $objLaudoProtocolo->getIdProtocoloFk());

            $objBanco->executarSQL($INSERT, $arrayBind);
            $objLaudoProtocolo->setIdRelLaudoProtocolo($objBanco->obterUltimoID());
            return $objLaudoProtocolo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o relacionamento laudo+protocolo  no BD.", $ex);
        }

    }

    public function alterar(LaudoProtocolo $objLaudoProtocolo, Banco $objBanco)
    {
        try {
            //print_r($objLaudo);
            $UPDATE = 'UPDATE tb_laudo_protocolo SET '
                . ' idLaudo_fk = ?,'
                . ' idProtocolo_fk = ?'
                . '  where idRelLaudoProtocolo = ?';


            $arrayBind = array();
            $arrayBind[] = array('i', $objLaudoProtocolo->getIdLaudoFk());
            $arrayBind[] = array('i', $objLaudoProtocolo->getIdProtocoloFk());

            $arrayBind[] = array('i', $objLaudoProtocolo->getIdRelLaudoProtocolo());

            $objBanco->executarSQL($UPDATE, $arrayBind);
            return $objLaudoProtocolo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o relacionamento laudo+protocolo no BD.", $ex);
        }

    }

    public function listar(LaudoProtocolo $objLaudoProtocolo, Banco $objBanco)
    {
        try {

            $SELECT = "SELECT * FROM tb_laudo_protocolo";


            $WHERE = '';
            $AND = '';
            $arrayBind = array();
            if ($objLaudoProtocolo->getIdRelLaudoProtocolo() != null) {
                $WHERE .= $AND . " idRelLaudoProtocolo = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objLaudoProtocolo->getIdRelLaudoProtocolo() );
            }

            if ($objLaudoProtocolo->getIdLaudoFk() != null) {
                $WHERE .= $AND . " idLaudo_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objLaudoProtocolo->getIdLaudoFk() );
            }
            if ($objLaudoProtocolo->getIdProtocoloFk()  != null) {
                $WHERE .= $AND . " idProtocolo_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objLaudoProtocolo->getIdProtocoloFk() );
            }



            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            //echo $SELECT.$WHERE;$WHERE

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);


            $array = array();
            foreach ($arr as $reg) {
                $laudoProtocolo = new LaudoProtocolo();
                $laudoProtocolo->setIdRelLaudoProtocolo($reg['idRelLaudoProtocolo']);
                $laudoProtocolo->setIdLaudoFk($reg['idLaudo_fk']);
                $laudoProtocolo->setIdProtocoloFk($reg['idProtocolo_fk']);

                $objProtocolo = NEW Protocolo();
                $objProtocoloRN = NEW ProtocoloRN();
                $objProtocolo->setIdProtocolo($laudoProtocolo->getIdProtocoloFk());
                $objProtocolo = $objProtocoloRN->consultar($objProtocolo);
                $laudoProtocolo->setObjProtocolo($objProtocolo);

                $array[] = $laudoProtocolo;
            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o relacionamento laudo+protocolo no BD.", $ex);
        }

    }

    public function consultar(LaudoProtocolo $objLaudoProtocolo, Banco $objBanco)
    {

        try {

            $SELECT = 'SELECT * FROM tb_laudo_protocolo WHERE idRelLaudoProtocolo = ?';

            $arrayBind = array();
            $arrayBind[] = array('i', $objLaudoProtocolo->getIdRelLaudoProtocolo());

            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);

            if(count($arr) > 0) {
                $laudoProtocolo = new LaudoProtocolo();
                $laudoProtocolo->setIdRelLaudoProtocolo($arr[0]['idRelLaudoProtocolo']);
                $laudoProtocolo->setIdLaudoFk($arr[0]['idLaudo_fk']);
                $laudoProtocolo->setIdProtocoloFk($arr[0]['idProtocolo_fk']);

                return $laudoProtocolo;
            }

            return null;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando o relacionamento laudo+protocolo no BD.", $ex);
        }

    }

    public function remover(LaudoProtocolo $objLaudoProtocolo, Banco $objBanco)
    {

        try {

            $DELETE = 'DELETE FROM tb_laudo_protocolo WHERE idRelLaudoProtocolo = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i', $objLaudoProtocolo->getIdRelLaudoProtocolo());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o relacionamento laudo+protocolo no BD.", $ex);
        }
    }
}