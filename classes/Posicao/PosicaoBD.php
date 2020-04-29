<?php


class PosicaoBD
{
    public function cadastrar(Posicao $posicaoCaixa, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO  tb_posicao_caixa  (idCaixa_fk,coluna, linha, situacaoPosicao,idTubo_fk) VALUES (?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$posicaoCaixa->getIdCaixa_fk());
            $arrayBind[] = array('s',$posicaoCaixa->getColuna());
            $arrayBind[] = array('s',$posicaoCaixa->getLinha());
            $arrayBind[] = array('s',$posicaoCaixa->getSituacaoPosicao());
            $arrayBind[] = array('i',$posicaoCaixa->getIdTuboFk());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $posicaoCaixa->setIdPosicaoCaixa($objBanco->obterUltimoID());
            return $posicaoCaixa;
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando porta  no BD.",$ex);
        }

    }

    public function alterar(Posicao $posicaoCaixa, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_posicao_caixa SET '
                . ' idCaixa_fk = ?, '
                . ' coluna = ?, '
                . ' linha = ?, '
                . ' situacaoPosicao = ?, '
                . ' idTubo_fk = ? '
                . '  where idPosicaoCaixa = ?';


            $arrayBind = array();
            $arrayBind[] = array('i',$posicaoCaixa->getIdCaixa_fk());
            $arrayBind[] = array('s',$posicaoCaixa->getColuna());
            $arrayBind[] = array('s',$posicaoCaixa->getLinha());
            $arrayBind[] = array('s',$posicaoCaixa->getSituacaoPosicao());
            $arrayBind[] = array('i',$posicaoCaixa->getIdTuboFk());

            $arrayBind[] = array('i',$posicaoCaixa->getIdPosicaoCaixa());


            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $posicaoCaixa;
        } catch (Exception $ex) {
            throw new Excecao("Erro alterando porta no BD.",$ex);
        }

    }

    public function listar(Posicao $posicaoCaixa, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_posicao_caixa";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($posicaoCaixa->getLinha() != null) {
                $WHERE .= $AND . " linha = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $posicaoCaixa->getLinha());
            }

            if ($posicaoCaixa->getColuna() != null) {
                $WHERE .= $AND . " coluna = ? ";
                $AND = ' and ';
                $arrayBind[] = array('s', $posicaoCaixa->getColuna());
            }

            if ($posicaoCaixa->getIdTuboFk() != null) {
                $WHERE .= $AND . " idTubo_fk = ? ";
                $AND = ' and ';
                $arrayBind[] = array('i', $posicaoCaixa->getIdTuboFk());
            }


            if ($posicaoCaixa->getIdCaixa_fk() != null) {
                $WHERE .= $AND . " idCaixa_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $posicaoCaixa->getIdCaixa_fk());
            }



            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            $array = array();
            foreach ($arr as $reg){
                $posicao  = new Posicao();
                $posicao->setIdPosicaoCaixa($reg['idPosicaoCaixa']);
                $posicao->setIdCaixa_fk($reg['idCaixa_fk']);
                $posicao->setColuna($reg['coluna']);
                $posicao->setSituacaoPosicao($reg['situacaoPosicao']);
                $posicao->setLinha($reg['linha']);
                $posicao->setIdTuboFk($reg['idTubo_fk']);

                $array[] = $posicao;
            }
            return $array;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando porta no BD.",$ex);
        }

    }

    public function consultar(Posicao $posicaoCaixa, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_posicao_caixa WHERE idPosicaoCaixa = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$posicaoCaixa->getidPosicaoCaixa());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $posicao  = new Posicao();
            $posicao->setIdPosicaoCaixa($arr[0]['idPosicaoCaixa']);
            $posicao->setIdCaixa_fk($arr[0]['idCaixa_fk']);
            $posicao->setColuna($arr[0]['coluna']);
            $posicao->setSituacaoPosicao($arr[0]['situacaoPosicao']);
            $posicao->setLinha($arr[0]['linha']);
            $posicao->setIdTuboFk($arr[0]['idTubo_fk']);


            return  $posicao ;
        } catch (Exception $ex) {

            throw new Excecao("Erro consultando porta no BD.",$ex);
        }

    }

    public function remover(Posicao $posicaoCaixa, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_posicao_caixa WHERE idPosicaoCaixa = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$posicaoCaixa->getidPosicaoCaixa());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro removendo porta no BD.",$ex);
        }
    }


    public function bloquear_registro(Posicao $posicaoCaixa,LocalArmazenamento $local, Banco $objBanco) {

        try{

            $SELECT = 'select tb_posicao_caixa.idPosicaoCaixa,tb_posicao_caixa.linha,tb_posicao_caixa.coluna,tb_caixa.idCaixa 
                        from tb_posicao_caixa, tb_caixa, tb_coluna, tb_prateleira, tb_porta, tb_local_armazenamento
                        where tb_posicao_caixa.idCaixa_fk=tb_caixa.idCaixa
                        and tb_caixa.idColuna_fk=tb_coluna.idColuna
                        and tb_coluna.idPrateleira_fk=tb_prateleira.idPrateleira
                        and tb_prateleira.idPorta_fk=tb_porta.idPorta
                        and tb_porta.idLocalArmazenamento_fk=tb_local_armazenamento.idLocalArmazenamento
                        and tb_local_armazenamento.idLocalArmazenamento = ?
                        and tb_posicao_caixa.situacaoPosicao= ?
                        limit 1
                        for update ';


            $arrayBind = array();
            $arrayBind[] = array('i', $local->getIdLocalArmazenamento());
            $arrayBind[] = array('s', PosicaoRN::$TSP_LIBERADA);

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);


            if(empty($arr)){
                return $arr;
            }
            $array = array();

            foreach ($arr as $reg){
                $posicao  = new Posicao();
                $posicao->setIdPosicaoCaixa($reg['idPosicaoCaixa']);
                $posicao->setIdCaixa_fk($reg['idCaixa']); //pegando de forma diferente
                $posicao->setColuna($reg['coluna']);
                $posicao->setSituacaoPosicao($reg['situacaoPosicao']);
                $posicao->setLinha($reg['linha']);
                $posicao->setIdTuboFk($reg['idTubo_fk']);
                $array[] = $posicao;
            }
            return $array;


        } catch (Throwable $ex) {
            throw new Excecao("Erro bloqueando a posição da caixa no BD.",$ex);
        }

    }
}