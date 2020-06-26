<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';

class LocalArmazenamentoTextoBD
{
    public function cadastrar(LocalArmazenamentoTexto $localTxt, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO tb_local_armazenamento_texto ('
                . 'idTipoLocal, '
                . 'nome, '
                . 'porta, '
                . 'prateleira,'
                . 'coluna,'
                . 'caixa,'
                . 'posicao'
                . ')'
                . 'VALUES (?,?,?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$localTxt->getIdTipoLocal());
            $arrayBind[] = array('s',$localTxt->getNome());
            $arrayBind[] = array('s',$localTxt->getPorta());
            $arrayBind[] = array('s',$localTxt->getPrateleira());
            $arrayBind[] = array('s',$localTxt->getColuna());
            $arrayBind[] = array('s',$localTxt->getCaixa());
            $arrayBind[] = array('s',$localTxt->getPosicao());

            $objBanco->executarSQL($INSERT,$arrayBind);
            $localTxt->setIdLocal($objBanco->obterUltimoID());
            //echo $localTxt->getIdLocal();
            return $localTxt;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o local de armazenamento (txt) no BD.",$ex);
        }

    }

    public function alterar(LocalArmazenamentoTexto $localTxt, Banco $objBanco) {
        try{

            $UPDATE = 'UPDATE tb_local_armazenamento_texto SET '
                . 'idTipoLocal = ?,'
                . 'nome = ?,'
                . 'porta = ?,'
                . 'prateleira = ?,'
                . 'coluna = ?,'
                . 'caixa = ?,'
                . 'posicao = ?'
                . '  where idLocal = ?';


            $arrayBind = array();
            $arrayBind[] = array('i',$localTxt->getIdTipoLocal());
            $arrayBind[] = array('s',$localTxt->getNome());
            $arrayBind[] = array('s',$localTxt->getPorta());
            $arrayBind[] = array('s',$localTxt->getPrateleira());
            $arrayBind[] = array('s',$localTxt->getColuna());
            $arrayBind[] = array('s',$localTxt->getCaixa());
            $arrayBind[] = array('s',$localTxt->getPosicao());

            $arrayBind[] = array('i',$localTxt->getIdLocal());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $localTxt;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o local de armazenamento (txt) no BD.",$ex);
        }

    }

    public function listar(LocalArmazenamentoTexto $localTxt, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_local_armazenamento_texto";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($localTxt->getIdLocal() != null) {
                $WHERE .= $AND . " idLocal = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $localTxt->getIdLocal());
            }

            if ($localTxt->getColuna() != null) {
                $WHERE .= $AND . " coluna = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $localTxt->getColuna());
            }

            if ($localTxt->getNome() != null) {
                $WHERE .= $AND . " nome LIKE ?";
                $AND = ' and ';
                $arrayBind[] = array('s',"%".$localTxt->getNome()."%");
            }

            if ($localTxt->getIdTipoLocal() != null) {
                $WHERE .= $AND . " idTipoLocal = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $localTxt->getIdTipoLocal());
            }

            if ($localTxt->getPorta() != null) {
                $WHERE .= $AND . " porta = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $localTxt->getPorta());
            }


            if ($localTxt->getPrateleira() != null) {
                $WHERE .= $AND . " prateleira = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $localTxt->getPrateleira());
            }

            if ($localTxt->getCaixa() != null) {
                $WHERE .= $AND . " caixa = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $localTxt->getCaixa());
            }

            if ($localTxt->getPosicao() != null) {
                $WHERE .= $AND . " posicao = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $localTxt->getPosicao());
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            //echo $SELECT.$WHERE;

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);


            $array_localTXT = array();
            foreach ($arr as $reg){
                $localTxt = new LocalArmazenamentoTexto();
                $localTxt->setIdLocal($reg['idLocal']);
                $localTxt->setNome($reg['nome']);
                $localTxt->setIdTipoLocal($reg['idTipoLocal']);
                $localTxt->setPorta($reg['porta']);
                $localTxt->setPrateleira($reg['prateleira']);
                $localTxt->setColuna($reg['coluna']);
                $localTxt->setCaixa($reg['caixa']);
                $localTxt->setPosicao($reg['posicao']);


                $array_localTXT[] = $localTxt;

            }
            return $array_localTXT;
        } catch (Throwable $ex) {
            //die($ex);
            throw new Excecao("Erro listando o local de armazenamento (txt) no BD.",$ex);
        }

    }

    public function consultar(LocalArmazenamentoTexto $localTxt, Banco $objBanco) {

        try{

            $SELECT = 'SELECT *  FROM tb_local_armazenamento_texto WHERE idLocal = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$localTxt->getIdLocal());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $localTxt = new LocalArmazenamentoTexto();
            $localTxt->setIdLocal($arr[0]['idLocal']);
            $localTxt->setNome($arr[0]['nome']);
            $localTxt->setIdTipoLocal($arr[0]['idTipoLocal']);
            $localTxt->setPorta($arr[0]['porta']);
            $localTxt->setPrateleira($arr[0]['prateleira']);
            $localTxt->setColuna($arr[0]['coluna']);
            $localTxt->setCaixa($arr[0]['caixa']);
            $localTxt->setPosicao($arr[0]['posicao']);

            return $localTxt;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando o local de armazenamento (txt) no BD.",$ex);
        }

    }

    public function remover(LocalArmazenamentoTexto $localTxt, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_local_armazenamento_texto WHERE idLocal = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$localTxt->getIdLocal());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o local de armazenamento (txt) no BD.",$ex);
        }
    }



}