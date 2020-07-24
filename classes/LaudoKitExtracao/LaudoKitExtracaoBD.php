<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';

class LaudoKitExtracaoBD
{
    public function cadastrar(LaudoKitExtracao $objLaudoKitExtracao, Banco $objBanco)
    {
        try {

            $INSERT = 'INSERT INTO tb_laudo_kitextracao (idLaudo_fk, idKitExtracao_fk)
                        VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i', $objLaudoKitExtracao->getIdLaudoFk());
            $arrayBind[] = array('i', $objLaudoKitExtracao->getIdKitExtracao());


            $objBanco->executarSQL($INSERT, $arrayBind);
            $objLaudoKitExtracao->setIdRelLaudoKitExtracao($objBanco->obterUltimoID());
            return $objLaudoKitExtracao;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o relacionamento laudo+kitExtração  no BD.", $ex);
        }

    }

    public function alterar(LaudoKitExtracao $objLaudoKitExtracao, Banco $objBanco)
    {
        try {
            //print_r($objLaudo);
            $UPDATE = 'UPDATE tb_laudo_kitextracao SET '
                . ' idLaudo_fk = ?,'
                . ' idKitExtracao_fk = ?'
                . '  where idRelLaudoKitExtracap = ?';


            $arrayBind = array();
            $arrayBind[] = array('i', $objLaudoKitExtracao->getIdLaudoFk());
            $arrayBind[] = array('i', $objLaudoKitExtracao->getIdKitExtracao());

            $arrayBind[] = array('i', $objLaudoKitExtracao->getIdRelLaudoKitExtracao());

            $objBanco->executarSQL($UPDATE, $arrayBind);
            return $objLaudoKitExtracao;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o relacionamento laudo+kitExtração no BD.", $ex);
        }

    }

    public function listar(LaudoKitExtracao $objLaudoKitExtracao, Banco $objBanco)
    {
        try {

            $SELECT = "SELECT * FROM tb_laudo_kitextracao";


            $WHERE = '';
            $AND = '';
            $arrayBind = array();
            if ($objLaudoKitExtracao->getIdRelLaudoKitExtracao() != null) {
                $WHERE .= $AND . " idRelLaudoKitExtracao = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objLaudoKitExtracao->getIdRelLaudoKitExtracao() );
            }

            if ($objLaudoKitExtracao->getIdLaudoFk() != null) {
                $WHERE .= $AND . " idLaudo_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objLaudoKitExtracao->getIdLaudoFk() );
            }
            if ($objLaudoKitExtracao->getIdKitExtracao()  != null) {
                $WHERE .= $AND . " idKitExtracao_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objLaudoKitExtracao->getIdKitExtracao() );
            }



            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            //echo $SELECT.$WHERE;$WHERE

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);


            $array = array();
            foreach ($arr as $reg) {
                $laudoKitExtracao = new LaudoKitExtracao();
                $laudoKitExtracao->setIdRelLaudoKitExtracao($reg['idRelLaudoKitExtracao']);
                $laudoKitExtracao->setIdLaudoFk($reg['idLaudo_fk']);
                $laudoKitExtracao->setIdKitExtracao($reg['idKitExtracao_fk']);

                $objKitExtracao = NEW KitExtracao();
                $objKitExtracaoRN = NEW KitExtracaoRN();
                $objKitExtracao->setIdKitExtracao($laudoKitExtracao->getIdKitExtracao());
                $objKitExtracao = $objKitExtracaoRN->consultar($objKitExtracao);
                $laudoKitExtracao->setObjKitExtracao($objKitExtracao);

                $array[] = $laudoKitExtracao;
            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o relacionamento laudo+kitExtração no BD.", $ex);
        }

    }

    public function consultar(LaudoKitExtracao $objLaudoKitExtracao, Banco $objBanco)
    {

        try {

            $SELECT = 'SELECT * FROM tb_laudo_kitextracao WHERE idRelLaudoKitExtracao = ?';

            $arrayBind = array();
            $arrayBind[] = array('i', $objLaudoKitExtracao->getIdRelLaudoKitExtracao());

            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);

            if(count($arr) > 0) {
                $laudoKitExtracao = new LaudoKitExtracao();
                $laudoKitExtracao->setIdRelLaudoKitExtracao($arr[0]['idRelLaudoKitExtracao']);
                $laudoKitExtracao->setIdLaudoFk($arr[0]['idLaudo_fk']);
                $laudoKitExtracao->setIdKitExtracao($arr[0]['idKitExtracao_fk']);

                return $laudoKitExtracao;
            }

            return null;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando o relacionamento laudo+kitExtração no BD.", $ex);
        }

    }

    public function remover(LaudoKitExtracao $objLaudoKitExtracao, Banco $objBanco)
    {

        try {

            $DELETE = 'DELETE FROM tb_laudo_kitextracao WHERE idRelLaudoKitExtracao = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i', $objLaudoKitExtracao->getIdRelLaudoKitExtracao());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o relacionamento laudo+kitExtração no BD.", $ex);
        }
    }
}