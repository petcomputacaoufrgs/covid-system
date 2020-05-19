<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Banco/Banco.php';

class DivisaoProtocoloBD
{
    public function cadastrar(DivisaoProtocolo $divisaoProtocolo, Banco $objBanco)
    {
        try {

            //die("die");
            $INSERT = 'INSERT INTO tb_divisao_protocolo (idProtocolo_fk, nomeDivisao) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i', $divisaoProtocolo->getIdProtocoloFk());
            $arrayBind[] = array('s', $divisaoProtocolo->getNomeDivisao());


            $objBanco->executarSQL($INSERT, $arrayBind);
            $divisaoProtocolo->setIdDivisaoProtocolo($objBanco->obterUltimoID());
            return $divisaoProtocolo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando a divisão do protocolo no BD.", $ex);
        }

    }

    public function alterar(DivisaoProtocolo $divisaoProtocolo, Banco $objBanco)
    {
        try {
            $UPDATE = 'UPDATE tb_divisao_protocolo SET '
                . ' idProtocolo_fk = ?,'
                . ' nomeDivisao = ?'
                . '  where idDivisaoProtocolo = ?';


            $arrayBind = array();
            $arrayBind[] = array('i', $divisaoProtocolo->getIdProtocoloFk());
            $arrayBind[] = array('s', $divisaoProtocolo->getNomeDivisao());

            $arrayBind[] = array('i', $divisaoProtocolo->getIdDivisaoProtocolo());

            $objBanco->executarSQL($UPDATE, $arrayBind);
            return $divisaoProtocolo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando a divisão do protocolo no BD.", $ex);
        }

    }

    public function listar(DivisaoProtocolo $divisaoProtocolo, Banco $objBanco)
    {
        try {

            $SELECT = "SELECT * FROM tb_divisao_protocolo";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_divisao_protocolo = array();
            foreach ($arr as $reg) {
                $divisaoProtocolo = new DivisaoProtocolo();
                $divisaoProtocolo->setIdDivisaoProtocolo($reg['idDivisaoProtocolo']);
                $divisaoProtocolo->setIdProtocoloFk($reg['idProtocolo_fk']);
                $divisaoProtocolo->setNomeDivisao($reg['nomeDivisao']);

                $array_divisao_protocolo[] = $divisaoProtocolo;
            }
            return $array_divisao_protocolo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os protocolos no BD.", $ex);
        }

    }

    public function consultar(DivisaoProtocolo $divisaoProtocolo, Banco $objBanco)
    {

        try {

            $SELECT = 'SELECT * FROM tb_divisao_protocolo WHERE idDivisaoProtocolo = ?';

            $arrayBind = array();
            $arrayBind[] = array('i', $divisaoProtocolo->getIdDivisaoProtocolo());

            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);


            $divisaoProtocolo = new DivisaoProtocolo();
            $divisaoProtocolo->setIdDivisaoProtocolo($arr[0]['idDivisaoProtocolo']);
            $divisaoProtocolo->setIdProtocoloFk($arr[0]['idProtocolo_fk']);
            $divisaoProtocolo->setNomeDivisao($arr[0]['nomeDivisao']);

            return $divisaoProtocolo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro consultando a divisão do protocolo no BD.", $ex);
        }

    }

    public function remover(DivisaoProtocolo $divisaoProtocolo, Banco $objBanco)
    {

        try {

            $DELETE = 'DELETE FROM tb_divisao_protocolo WHERE idDivisaoProtocolo = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i', $divisaoProtocolo->getIdDivisaoProtocolo());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo a divisão do protocolo no BD.", $ex);
        }
    }

}