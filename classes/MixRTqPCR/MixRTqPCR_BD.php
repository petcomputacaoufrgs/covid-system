<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class MixRTqPCR_BD
{
    public function cadastrar(MixRTqPCR $objMix, Banco $objBanco) {
        try{

            //die("die");
            $INSERT = 'INSERT INTO tb_mix_placa (situacaoMix, idPlaca_fk,idSolicitacao_fk,idUsuario_fk,dataHoraInicio,dataHoraFim) VALUES (?,?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objMix->getSituacaoMix());
            $arrayBind[] = array('i',$objMix->getIdPlacaFk());
            $arrayBind[] = array('i',$objMix->getIdSolicitacaoFk());
            $arrayBind[] = array('i',$objMix->getIdUsuarioFk());
            $arrayBind[] = array('s',$objMix->getDataHoraInicio());
            $arrayBind[] = array('s',$objMix->getDataHoraFim());

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objMix->setIdMixPlaca($objBanco->obterUltimoID());
            return $objMix;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o placa no BD.",$ex);
        }

    }

    public function alterar(MixRTqPCR $objMix, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_mix_placa SET '
                . ' situacaoMix = ?,'
                . ' idPlaca_fk = ?,'
                . ' idSolicitacao_fk = ?,'
                . ' idUsuario_fk = ?,'
                . ' dataHoraInicio = ?,'
                . ' dataHoraFim = ?'
                . '  where idMixPlaca = ?';


            $arrayBind = array();
            $arrayBind[] = array('s',$objMix->getSituacaoMix());
            $arrayBind[] = array('i',$objMix->getIdPlacaFk());
            $arrayBind[] = array('i',$objMix->getIdSolicitacaoFk());
            $arrayBind[] = array('i',$objMix->getIdUsuarioFk());
            $arrayBind[] = array('s',$objMix->getDataHoraInicio());
            $arrayBind[] = array('s',$objMix->getDataHoraFim());

            $arrayBind[] = array('i',$objMix->getidMixPlaca());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objMix;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando a placa no BD.",$ex);
        }

    }

    public function listar(MixRTqPCR $objMix,$numLimite=null, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_mix_placa";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objMix->getIdMixPlaca() != null) {
                $WHERE .= $AND . " idMixPlaca = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objMix->getIdMixPlaca());
            }

            if ($objMix->getIdSolicitacaoFk() != null) {
                $WHERE .= $AND . " idSolicitacao_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objMix->getIdSolicitacaoFk());
            }

            if ($objMix->getIdPlacaFk() != null) {
                $WHERE .= $AND . " idPlaca_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objMix->getIdPlacaFk());
            }

            if ($objMix->getSituacaoMix() != null) {
                $WHERE .= $AND . " situacaoMix = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objMix->getSituacaoMix());
            }

            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            $LIMIT = '';
            if($numLimite != null){
                $LIMIT = ' LIMIT ? ';
                $arrayBind[] = array('i', $numLimite);
            }




            $arr = $objBanco->consultarSQL($SELECT . $WHERE.$LIMIT, $arrayBind);


            $arr_mix = array();
            foreach ($arr as $reg){
                $mix = new MixRTqPCR();
                $mix->setIdMixPlaca($reg['idMixPlaca']);
                $mix->setIdPlacaFk($reg['idPlaca_fk']);
                $mix->setDataHoraInicio($reg['dataHoraInicio']);
                $mix->setDataHoraFim($reg['dataHoraFim']);
                $mix->setIdSolicitacaoFk($reg['idSolicitacao_fk']);
                $mix->setIdUsuarioFk($reg['idUsuario_fk']);
                $mix->setSituacaoMix($reg['situacaoMix']);

                $select_protocolo = 'select * from tb_solicitacao_montagem_placa_rtqpcr where idSolicitacaoMontarPlaca = ?';
                $arrayBind2 = array();
                $arrayBind2[] = array('i', $reg['idSolicitacao_fk']);
                $solicitacao = $objBanco->consultarSQL($select_protocolo, $arrayBind2);


                $objSolicitacao = new SolicitacaoMontarPlaca();
                $objSolicitacaoRN = new SolicitacaoMontarPlacaRN();
                $mix->setObjSolicitacao($solicitacao);

                $arr_mix[] = $mix;
            }
            return $arr_mix;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os mix no BD.",$ex);
        }

    }


    public function listar_completo(MixRTqPCR $objMix,$numLimite=null, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_mix_placa";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objMix->getIdMixPlaca() != null) {
                $WHERE .= $AND . " idMixPlaca = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objMix->getIdMixPlaca());
            }

            if ($objMix->getIdSolicitacaoFk() != null) {
                $WHERE .= $AND . " idSolicitacao_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objMix->getIdSolicitacaoFk());
            }

            if ($objMix->getIdPlacaFk() != null) {
                $WHERE .= $AND . " idPlaca_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objMix->getIdPlacaFk());
            }

            if ($objMix->getSituacaoMix() != null) {
                $WHERE .= $AND . " situacaoMix = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objMix->getSituacaoMix());
            }

            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            $LIMIT = '';
            if($numLimite != null){
                $LIMIT = ' LIMIT ? ';
                $arrayBind[] = array('i', $numLimite);
            }




            $arr = $objBanco->consultarSQL($SELECT . $WHERE.$LIMIT, $arrayBind);


            $arr_mix = array();
            foreach ($arr as $reg){
                $mix = new MixRTqPCR();
                $mix->setIdMixPlaca($reg['idMixPlaca']);
                $mix->setIdPlacaFk($reg['idPlaca_fk']);
                $mix->setDataHoraInicio($reg['dataHoraInicio']);
                $mix->setDataHoraFim($reg['dataHoraFim']);
                $mix->setIdSolicitacaoFk($reg['idSolicitacao_fk']);
                $mix->setIdUsuarioFk($reg['idUsuario_fk']);
                $mix->setSituacaoMix($reg['situacaoMix']);

                $objSolicitacao = new SolicitacaoMontarPlaca();
                $objSolicitacaoRN = new SolicitacaoMontarPlacaRN();
                $objSolicitacao->setIdSolicitacaoMontarPlaca($reg['idSolicitacao_fk']);
                $arr_solicitacao = $objSolicitacaoRN->paginacao($objSolicitacao);

               // echo "<pre>";
               // print_r($arr_solicitacao);
              //  echo "</pre>";

                $mix->setObjSolicitacao($arr_solicitacao[0]);

                $objUsuario  = new Usuario();
                $objUsuarioRN  = new UsuarioRN();
                $objUsuario->setIdUsuario($reg['idUsuario_fk']);
                $objUsuario = $objUsuarioRN->consultar($objUsuario);
                $mix->setObjUsuario($objUsuario);


                $arr_mix[] = $mix;
            }
            return $arr_mix;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os mix no BD.",$ex);
        }

    }

    public function consultar(MixRTqPCR $objMix, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_mix_placa WHERE idMixPlaca = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objMix->getidMixPlaca());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);


            $mix = new MixRTqPCR();
            $mix->setIdMixPlaca($arr[0]['idMixPlaca']);
            $mix->setIdPlacaFk($arr[0]['idPlaca_fk']);
            $mix->setDataHoraInicio($arr[0]['dataHoraInicio']);
            $mix->setDataHoraFim($arr[0]['dataHoraFim']);
            $mix->setIdSolicitacaoFk($arr[0]['idSolicitacao_fk']);
            $mix->setIdUsuarioFk($arr[0]['idUsuario_fk']);
            $mix->setSituacaoMix($arr[0]['situacaoMix']);

            return $mix;
        } catch (Throwable $ex) {
            throw new Excecao("Erro consultando a placa no BD.",$ex);
        }

    }

    public function remover(MixRTqPCR $objMix, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_mix_placa WHERE idMixPlaca = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objMix->getIdMixPlaca());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o mix no BD.",$ex);
        }
    }


    public function paginacao(MixRTqPCR $objMix, Banco $objBanco) {
        try{

            $inicio = ($objMix->getNumPagina()-1)*20;

            if($objMix->getNumPagina() == null){
                $inicio = 0;
            }

            $SELECT = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_mix_placa";

            $WHERE = '';
            $AND = '';
            $FROM = '';
            $arrayBind = array();

            if ($objMix->getIdMixPlaca() != null) {
                $WHERE .= $AND . " idMixPlaca = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objMix->getIdMixPlaca());
            }

            if ($objMix->getIdSolicitacaoFk() != null) {
                $WHERE .= $AND . " idSolicitacao_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objMix->getIdSolicitacaoFk());
            }

            if ($objMix->getIdPlacaFk() != null) {
                $WHERE .= $AND . " idPlaca_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objMix->getIdPlacaFk());
            }

            if ($objMix->getSituacaoMix() != null) {
                $WHERE .= $AND . " situacaoMix = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objMix->getSituacaoMix());
            }

            if ($objMix->getObjSolicitacao() != null) {
                $FROM .=' ,tb_solicitacao_montagem_placa_rtqpcr ';
                $WHERE .= $AND . " tb_solicitacao_montagem_placa_rtqpcr.idSolicitacaoMontarPlaca = tb_mix_placa.idSolicitacao_fk ";
                $AND = ' and ';
                if ($objMix->getObjSolicitacao()->getObjPlaca() != null) {
                    if ($objMix->getObjSolicitacao()->getObjPlaca()->getIdPlaca() != null) {
                        $WHERE .= $AND . "  tb_solicitacao_montagem_placa_rtqpcr.idPlaca_fk = ?";
                        $AND = ' and ';
                        $arrayBind[] = array('i', $objMix->getObjSolicitacao()->getObjPlaca()->getIdPlaca());
                    }
                }

            }

            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }


            $order_by = ' order by  tb_mix_placa.idMixPlaca desc ';
            $limit = ' LIMIT ?,20';

            $arrayBind[] = array('i', $inicio);
            $arr = $objBanco->consultarSQL($SELECT .$FROM. $WHERE.$order_by.$limit, $arrayBind);

            $SELECT = "SELECT FOUND_ROWS() as total";
            $total = $objBanco->consultarSQL($SELECT);
            $objMix->setTotalRegistros($total[0]['total']);
            $objMix->setNumPagina($inicio);


            $arr_mix = array();
            foreach ($arr as $reg){
                $mix = new MixRTqPCR();
                $mix->setIdMixPlaca($reg['idMixPlaca']);
                $mix->setIdPlacaFk($reg['idPlaca_fk']);
                $mix->setDataHoraInicio($reg['dataHoraInicio']);
                $mix->setDataHoraFim($reg['dataHoraFim']);
                $mix->setIdSolicitacaoFk($reg['idSolicitacao_fk']);
                $mix->setIdUsuarioFk($reg['idUsuario_fk']);
                $mix->setSituacaoMix($reg['situacaoMix']);

                $objSolicitacao = new SolicitacaoMontarPlaca();
                $objSolicitacaoRN = new SolicitacaoMontarPlacaRN();
                $objSolicitacao->setIdSolicitacaoMontarPlaca($reg['idSolicitacao_fk']);
                $arr_solicitacao = $objSolicitacaoRN->paginacao($objSolicitacao);
                $mix->setObjSolicitacao($arr_solicitacao[0]);

                $objUsuario  = new Usuario();
                $objUsuarioRN  = new UsuarioRN();
                $objUsuario->setIdUsuario($reg['idUsuario_fk']);
                $objUsuario = $objUsuarioRN->consultar($objUsuario);
                $mix->setObjUsuario($objUsuario);


                $arr_mix[] = $mix;
            }
            return $arr_mix;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os mix no BD.",$ex);
        }

    }
}