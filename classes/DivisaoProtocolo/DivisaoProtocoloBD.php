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

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($divisaoProtocolo->getIdProtocoloFk() != null) {
                $WHERE .= $AND . " idProtocolo_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $divisaoProtocolo->getIdProtocoloFk());
            }

            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

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

    public function listar_completo(DivisaoProtocolo $divisaoProtocolo, Banco $objBanco)
    {
        try {

            $SELECT = "SELECT * FROM tb_divisao_protocolo";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($divisaoProtocolo->getIdProtocoloFk() != null) {
                $WHERE .= $AND . " idProtocolo_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $divisaoProtocolo->getIdProtocoloFk());
            }

            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            $array_divisao_protocolo = array();
            foreach ($arr as $reg) {
                $divisaoProtocolo = new DivisaoProtocolo();
                $divisaoProtocolo->setIdDivisaoProtocolo($reg['idDivisaoProtocolo']);
                $divisaoProtocolo->setIdProtocoloFk($reg['idProtocolo_fk']);
                $divisaoProtocolo->setNomeDivisao($reg['nomeDivisao']);

                if($reg['idProtocolo_fk'] != null){
                    $SELECT_PROTOCOLO = 'SELECT * FROM tb_protocolo WHERE idProtocolo = ?';

                    $arrayBindProtocolo = array();
                    $arrayBindProtocolo[] = array('i',$reg['idProtocolo_fk']);

                    $arr = $objBanco->consultarSQL($SELECT_PROTOCOLO,$arrayBindProtocolo);

                    $protocolo = new Protocolo();
                    $protocolo->setIdProtocolo($arr[0]['idProtocolo']);
                    $protocolo->setProtocolo($arr[0]['protocolo']);
                    $protocolo->setIndexProtocolo($arr[0]['index_protocolo']);
                    $protocolo->setNumMaxAmostras($arr[0]['numMax_amostras']);
                    $protocolo->setCaractere($arr[0]['caractere']);
                    $protocolo->setNumDivisoes($arr[0]['numDivisoes']);
                    $divisaoProtocolo->setObjProtocolo($protocolo);
                }

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