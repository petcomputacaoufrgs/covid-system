<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';


class PocoBD
{
    public function cadastrar(Poco $objPoco, Banco $objBanco) {
        try{

            //die("die");
            $INSERT = 'INSERT INTO tb_poco (linha, coluna, situacao, idTubo_fk,conteudo) VALUES (?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objPoco->getLinha());
            $arrayBind[] = array('s',$objPoco->getColuna());
            $arrayBind[] = array('s',$objPoco->getSituacao());
            $arrayBind[] = array('i',$objPoco->getIdTuboFk());
            $arrayBind[] = array('s',$objPoco->getConteudo());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objPoco->setIdPoco($objBanco->obterUltimoID());
            return $objPoco;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o poço no BD.",$ex);
        }

    }

    public function alterar(Poco $objPoco, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_poco SET '
                . ' linha = ?,'
                . ' coluna = ?,'
                . ' situacao = ?,'
                . ' idTubo_fk = ?,'
                . ' conteudo = ?'
                . '  where idPoco = ?';


            $arrayBind = array();
            $arrayBind[] = array('s',$objPoco->getLinha());
            $arrayBind[] = array('s',$objPoco->getColuna());
            $arrayBind[] = array('s',$objPoco->getSituacao());
            $arrayBind[] = array('i',$objPoco->getIdTuboFk());
            $arrayBind[] = array('s',$objPoco->getConteudo());

            $arrayBind[] = array('i',$objPoco->getIdPoco());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objPoco;
        } catch (Throwable $ex) {
            die($ex);
            throw new Excecao("Erro alterando o poço no BD.",$ex);
        }

    }


    public function listar(Poco $objPoco, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_poco";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objPoco->getSituacao() != null) {
                $WHERE .= $AND . " situacao = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPoco->getSituacao());
            }

            if ($objPoco->getColuna() != null) {
                $WHERE .= $AND . " coluna = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPoco->getColuna());
            }

            if ($objPoco->getLinha() != null) {
                $WHERE .= $AND . " linha = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPoco->getLinha());
            }

            if ($objPoco->getIdTuboFk() != null) {
                $WHERE .= $AND . " idTubo_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPoco->getIdTuboFk() );
            }

            if ($objPoco->getIdPoco() != null) {
                $WHERE .= $AND . " idPoco = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPoco->getIdPoco() );
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            $array_poco = array();
            foreach ($arr as $reg){
                $poco = new Poco();
                $poco->setIdPoco($reg['idPoco']);
                $poco->setIdTuboFk($reg['idTubo_fk']);
                $poco->setColuna($reg['coluna']);
                $poco->setLinha($reg['linha']);
                $poco->setSituacao($reg['situacao']);
                $poco->setConteudo($reg['conteudo']);

                $array_poco[] = $poco;
            }
            return $array_poco;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os poços no BD.",$ex);
        }

    }

    public function listar_completo(Poco $objPoco, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_poco";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objPoco->getSituacao() != null) {
                $WHERE .= $AND . " situacao = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPoco->getSituacao());
            }

            if ($objPoco->getColuna() != null) {
                $WHERE .= $AND . " coluna = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPoco->getColuna());
            }

            if ($objPoco->getLinha() != null) {
                $WHERE .= $AND . " linha = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPoco->getLinha());
            }

            if ($objPoco->getIdTuboFk() != null) {
                $WHERE .= $AND . " idTubo_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPoco->getIdTuboFk() );
            }

            if ($objPoco->getIdPoco() != null) {
                $WHERE .= $AND . " idPoco = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPoco->getIdPoco() );
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            $array_poco = array();
            $objTuboRN = new TuboRN();
            foreach ($arr as $reg){
                $poco = new Poco();
                $poco->setIdPoco($reg['idPoco']);
                $poco->setIdTuboFk($reg['idTubo_fk']);
                $poco->setColuna($reg['coluna']);
                $poco->setLinha($reg['linha']);
                $poco->setSituacao($reg['situacao']);
                $poco->setConteudo($reg['conteudo']);

                $objTubo = new Tubo();
                if(!is_null($reg['idTubo_fk'])) {
                    $objTubo->setIdTubo($reg['idTubo_fk']);
                    $objTubo = $objTuboRN->listar_completo($objTubo,null,true);
                    $poco->setObjTubo($objTubo[0]);
                }


                $array_poco[] = $poco;
            }
            return $array_poco;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os poços no BD.",$ex);
        }

    }

    public function consultar(Poco $objPoco, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_poco WHERE idPoco = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPoco->getIdPoco());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);


            $poco = new Poco();
            $poco->setIdPoco($arr[0]['idPoco']);
            $poco->setIdTuboFk($arr[0]['idTubo_fk']);
            $poco->setColuna($arr[0]['coluna']);
            $poco->setLinha($arr[0]['linha']);
            $poco->setSituacao($arr[0]['situacao']);
            $poco->setConteudo($arr[0]['conteudo']);

            return $poco;
        } catch (Throwable $ex) {
            throw new Excecao("Erro consultando o poço no BD.",$ex);
        }

    }

    public function remover(Poco $objPoco, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_poco WHERE idPoco = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objPoco->getIdPoco());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o poço no BD.",$ex);
        }
    }

    public function alterar_conteudo(Poco $objPoco, Banco $objBanco) {
        try{

            $SELECT_POCO = 'select idPoco from tb_pocos_placa,tb_poco where tb_pocos_placa.idPlaca_fk = ? 
                            and tb_poco.linha=? 
                            and tb_poco.coluna = ? 
                            and tb_pocos_placa.idPoco_fk = tb_poco.idPoco';
            $arrayBind = array();
            $arrayBind[] = array('i',$objPoco->getObjPlaca()->getIdPlaca());
            $arrayBind[] = array('s',$objPoco->getLinha());
            $arrayBind[] = array('s',$objPoco->getColuna());

            $arr = $objBanco->consultarSQL($SELECT_POCO,$arrayBind);

            print_r($arr);
            $objPoco->setIdPoco($arr[0]['idPoco']);

            $objPocoBD = new PocoBD();
            $objPoco  = $objPocoBD->alterar($objPoco,$objBanco);

            return $objPoco;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o poço no BD.",$ex);
        }

    }



}