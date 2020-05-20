<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';

require_once __DIR__ . '/../DivisaoProtocolo/DivisaoProtocolo.php';
require_once __DIR__ . '/../DivisaoProtocolo/DivisaoProtocoloRN.php';
class ProtocoloBD
{
    public function cadastrar(Protocolo $objProtocolo, Banco $objBanco) {
        try{

            //die("die");
            $INSERT = 'INSERT INTO tb_protocolo (protocolo, index_protocolo,numMax_amostras,caractere,numDivisoes) VALUES (?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objProtocolo->getProtocolo());
            $arrayBind[] = array('s',$objProtocolo->getIndexProtocolo());
            $arrayBind[] = array('i',$objProtocolo->getNumMaxAmostras());
            $arrayBind[] = array('s',$objProtocolo->getCaractere());
            $arrayBind[] = array('i',$objProtocolo->getNumDivisoes());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objProtocolo->setIdProtocolo($objBanco->obterUltimoID());
            return $objProtocolo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o protocolo no BD.",$ex);
        }

    }

    public function alterar(Protocolo $objProtocolo, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_protocolo SET '
                . ' protocolo = ?,'
                . ' index_protocolo = ?,'
                . ' numMax_amostras = ?,'
                . ' caractere = ?,'
                . ' numDivisoes = ?'
                . '  where idProtocolo = ?';


            $arrayBind = array();
            $arrayBind[] = array('s',$objProtocolo->getProtocolo());
            $arrayBind[] = array('s',$objProtocolo->getIndexProtocolo());
            $arrayBind[] = array('i',$objProtocolo->getNumMaxAmostras());
            $arrayBind[] = array('s',$objProtocolo->getCaractere());
            $arrayBind[] = array('i',$objProtocolo->getNumDivisoes());

            $arrayBind[] = array('i',$objProtocolo->getIdProtocolo());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objProtocolo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o protocolo no BD.",$ex);
        }

    }

    public function listar(Protocolo $objProtocolo, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_protocolo";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_protocolo = array();
            foreach ($arr as $reg){
                $protocolo = new Protocolo();
                $protocolo->setIdProtocolo($reg['idProtocolo']);
                $protocolo->setProtocolo($reg['protocolo']);
                $protocolo->setIndexProtocolo($reg['index_protocolo']);
                $protocolo->setNumMaxAmostras($reg['numMax_amostras']);
                $protocolo->setCaractere($reg['caractere']);
                $protocolo->setNumDivisoes($reg['numDivisoes']);

                $SELECT = 'SELECT * FROM tb_divisao_protocolo WHERE idProtocolo_fk = ?';

                $arrayBind = array();
                $arrayBind[] = array('i', $reg['idProtocolo']);

                $arr_divs = $objBanco->consultarSQL($SELECT, $arrayBind);
                if(count($arr_divs) > 0) {
                    $arr_divs_protocolo = array();
                    foreach ($arr_divs as $divisao) {
                        $divisaoProtocolo = new DivisaoProtocolo();
                        $divisaoProtocolo->setIdDivisaoProtocolo($divisao['idDivisaoProtocolo']);
                        $divisaoProtocolo->setIdProtocoloFk($divisao['idProtocolo_fk']);
                        $divisaoProtocolo->setNomeDivisao($divisao['nomeDivisao']);
                        $arr_divs_protocolo[] = $divisaoProtocolo;
                    }
                    $protocolo->setObjDivisao($arr_divs_protocolo);
                }


                $array_protocolo[] = $protocolo;
            }
            return $array_protocolo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os protocolos no BD.",$ex);
        }

    }

    public function consultar(Protocolo $objProtocolo, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_protocolo WHERE idProtocolo = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objProtocolo->getIdProtocolo());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);


            $protocolo = new Protocolo();
            $protocolo->setIdProtocolo($arr[0]['idProtocolo']);
            $protocolo->setProtocolo($arr[0]['protocolo']);
            $protocolo->setIndexProtocolo($arr[0]['index_protocolo']);
            $protocolo->setNumMaxAmostras($arr[0]['numMax_amostras']);
            $protocolo->setCaractere($arr[0]['caractere']);
            $protocolo->setNumDivisoes($arr[0]['numDivisoes']);

            return $protocolo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro consultando o protocolo no BD.",$ex);
        }

    }

    public function remover(Protocolo $objProtocolo, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_protocolo WHERE idProtocolo = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objProtocolo->getIdProtocolo());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o protocolo no BD.",$ex);
        }
    }


    public function ja_existe_protocolo(Protocolo $objProtocolo, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idProtocolo from tb_protocolo WHERE index_protocolo = ? and idProtocolo != ? LIMIT 1';

            $arrayBind = array();
            $arrayBind[] = array('s',$objProtocolo->getIndexProtocolo());
            $arrayBind[] = array('i',$objProtocolo->getIdProtocolo());
            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);

            if(count($arr) > 0){
                return true;
            }

            return false;

        } catch (Throwable $ex) {
            throw new Excecao("Erro verificando se já existe um protocolo no BD.",$ex);
        }
    }


    public function existe_placa_com_o_protocolo(Protocolo $objProtocolo, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_placa,tb_protocolo  
                        where tb_placa.idProtocolo_fk = tb_protocolo.idProtocolo 
                        and tb_protocolo.idProtocolo = ?
                        LIMIT 1";

            $arrayBind = array();
            $arrayBind[] = array('i',$objProtocolo->getIdProtocolo());
            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);

            if(count($arr) > 0){
                return true;
            }
            return false;
        } catch (Throwable $ex) {
            throw new Excecao("Erro verificando se existe uma placa com o protocolo no BD.",$ex);
        }

    }
}