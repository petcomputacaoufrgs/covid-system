<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';

class MontagemPlacaBD
{
    public function cadastrar(MontagemPlaca $objMontagemPlaca, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO tb_montagem_placa (idUsuario_fk, idMix_fk,situacaoMontagemPlaca,
                        dataHoraInicio,dataHoraFim)
                        VALUES (?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objMontagemPlaca->getIdUsuarioFk());
            $arrayBind[] = array('i',$objMontagemPlaca->getIdMixFk());
            $arrayBind[] = array('s',$objMontagemPlaca->getSituacaoMontagem());
            $arrayBind[] = array('s',$objMontagemPlaca->getDataHoraInicio());
            $arrayBind[] = array('s',$objMontagemPlaca->getDataHoraFim());

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objMontagemPlaca->setIdMontagem($objBanco->obterUltimoID());
            return $objMontagemPlaca;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando a montagem da placa no BD.",$ex);
        }

    }

    public function alterar(MontagemPlaca $objMontagemPlaca, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_montagem_placa SET '
                . ' idUsuario_fk = ?,'
                . ' idMix_fk = ?,'
                . ' situacaoMontagemPlaca = ?,'
                . ' dataHoraInicio = ?,'
                . ' dataHoraFim = ?'
                . '  where idMontagemPlaca = ?';


            $arrayBind = array();
            $arrayBind[] = array('i',$objMontagemPlaca->getIdUsuarioFk());
            $arrayBind[] = array('i',$objMontagemPlaca->getIdMixFk());
            $arrayBind[] = array('s',$objMontagemPlaca->getSituacaoMontagem());
            $arrayBind[] = array('s',$objMontagemPlaca->getDataHoraInicio());
            $arrayBind[] = array('s',$objMontagemPlaca->getDataHoraFim());

            $arrayBind[] = array('i',$objMontagemPlaca->getIdMontagem());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objMontagemPlaca;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando a montagem da placa no BD.",$ex);
        }

    }

    public function listar(MontagemPlaca $objMontagemPlaca,$numLimite = null, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_montagem_placa";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objMontagemPlaca->getIdMontagem() != null) {
                $WHERE .= $AND . " idMontagemPlaca = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objMontagemPlaca->getIdMontagem());
            }


            if ($objMontagemPlaca->getIdMixFk() != null) {
                $WHERE .= $AND . " idMix_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objMontagemPlaca->getIdMixFk());
            }

            if ($objMontagemPlaca->getIdUsuarioFk() != null) {
                $WHERE .= $AND . " idUsuario_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objMontagemPlaca->getIdUsuarioFk());
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }


            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);


            $array_montagem_placa = array();
            foreach ($arr as $reg){
                $montagemPlaca = new MontagemPlaca();
                $montagemPlaca->setIdMontagem($reg['idMontagemPlaca']);
                $montagemPlaca->setIdMixFk($reg['idMix_fk']);
                $montagemPlaca->setIdUsuarioFk($reg['idUsuario_fk']);
                $montagemPlaca->setDataHoraInicio($reg['dataHoraInicio']);
                $montagemPlaca->setDataHoraFim($reg['dataHoraFim']);
                $montagemPlaca->setSituacaoMontagem($reg['situacaoMontagemPlaca']);

                $array_montagem_placa[] = $montagemPlaca;
            }
            return $array_montagem_placa;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando as montagens das placas no BD.",$ex);
        }

    }

    public function consultar(MontagemPlaca $objMontagemPlaca, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_montagem_placa WHERE idMontagemPlaca = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objMontagemPlaca->getIdMontagem());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);


            $montagemPlaca = new MontagemPlaca();
            $montagemPlaca->setIdMontagem($arr[0]['idMontagemPlaca']);
            $montagemPlaca->setIdMixFk($arr[0]['idMix_fk']);
            $montagemPlaca->setIdUsuarioFk($arr[0]['idUsuario_fk']);
            $montagemPlaca->setDataHoraInicio($arr[0]['dataHoraInicio']);
            $montagemPlaca->setDataHoraFim($arr[0]['dataHoraFim']);
            $montagemPlaca->setSituacaoMontagem($arr[0]['situacaoMontagemPlaca']);

            return $montagemPlaca;
        } catch (Throwable $ex) {
            throw new Excecao("Erro consultando a montagem da placa no BD.",$ex);
        }

    }

    public function remover(MontagemPlaca $objMontagemPlaca, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_montagem_placa WHERE idMontagemPlaca = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objMontagemPlaca->getIdMontagem());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo a montagem da placa no BD.",$ex);
        }
    }


    public function paginacao(MontagemPlaca $objMontagemPlaca, Banco $objBanco) {
        try{

            $inicio = ($objMontagemPlaca->getNumPagina()-1)*20;

            if($objMontagemPlaca->getNumPagina() == null){
                $inicio = 0;
            }

            $SELECT = "SELECT * FROM tb_montagem_placa";

            $FROM = '';
            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objMontagemPlaca->getIdMontagem() != null) {
                $WHERE .= $AND . " idMontagemPlaca = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objMontagemPlaca->getIdMontagem());
            }


            if ($objMontagemPlaca->getIdMixFk() != null) {
                $WHERE .= $AND . " idMix_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objMontagemPlaca->getIdMixFk());
            }

            if ($objMontagemPlaca->getSituacaoMontagem() != null) {
                $WHERE .= $AND . " situacaoMontagemPlaca = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objMontagemPlaca->getSituacaoMontagem());
            }

            if($objMontagemPlaca->getObjMix() != null){
                if($objMontagemPlaca->getObjMix()->getObjSolicitacao() != null){
                    if($objMontagemPlaca->getObjMix()->getObjSolicitacao()->getObjPlaca() != null){
                        $FROM .=' ,tb_placa,tb_mix_placa ';
                        $WHERE .= $AND . " tb_montagem_placa.idMix_fk = tb_mix_placa.idMixPlaca and
                                            tb_placa.idPlaca = tb_mix_placa.idPlaca_fk";
                        $AND = ' and ';

                        if ($objMontagemPlaca->getObjMix()->getObjSolicitacao()->getObjPlaca()->getIdPlaca() != null) {
                            $WHERE .= $AND . "  tb_placa.idPlaca = ?";
                            $AND = ' and ';
                            $arrayBind[] = array('i', $objMontagemPlaca->getObjMix()->getObjSolicitacao()->getObjPlaca()->getIdPlaca());
                        }

                    }
                }
            }

            if ($objMontagemPlaca->getIdUsuarioFk() != null) {
                $WHERE .= $AND . " idUsuario_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objMontagemPlaca->getIdUsuarioFk());
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }


            $order_by = ' order by  tb_montagem_placa.idMontagemPlaca desc ';
            $limit = ' LIMIT ?,20';

            $arrayBind[] = array('i', $inicio);
            $arr = $objBanco->consultarSQL($SELECT .$FROM. $WHERE.$order_by.$limit, $arrayBind);

            $SELECT = "SELECT FOUND_ROWS() as total";
            $total = $objBanco->consultarSQL($SELECT);
            $objMontagemPlaca->setTotalRegistros($total[0]['total']);
            $objMontagemPlaca->setNumPagina($inicio);


            $array_montagem_placa = array();
            foreach ($arr as $reg){
                $montagemPlaca = new MontagemPlaca();
                $montagemPlaca->setIdMontagem($reg['idMontagemPlaca']);
                $montagemPlaca->setIdMixFk($reg['idMix_fk']);
                $montagemPlaca->setIdUsuarioFk($reg['idUsuario_fk']);
                $montagemPlaca->setDataHoraInicio($reg['dataHoraInicio']);
                $montagemPlaca->setDataHoraFim($reg['dataHoraFim']);
                $montagemPlaca->setSituacaoMontagem($reg['situacaoMontagemPlaca']);

                $objUsuario  = new Usuario();
                $objUsuarioRN  = new UsuarioRN();
                $objUsuario->setIdUsuario($reg['idUsuario_fk']);
                $objUsuario = $objUsuarioRN->consultar($objUsuario);
                $montagemPlaca->setObjUsuario($objUsuario);

                $objMix = new MixRTqPCR();
                $objMixRN = new MixRTqPCR_RN();
                $objMix->setIdMixPlaca($reg['idMix_fk']);
                $mix = $objMixRN->listar($objMix,null, true);

                $montagemPlaca->setObjMix($mix[0]);

                $array_montagem_placa[] = $montagemPlaca;
            }
            return $array_montagem_placa;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os mix no BD.",$ex);
        }

    }


}