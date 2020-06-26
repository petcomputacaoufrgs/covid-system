<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class ResultadoPCR_BD
{
    public function cadastrar(ResultadoPCR $objResultado, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO tb_resultado_rtqpcr (idResultado,well, sampleName, targetName,task,reporter,ct,nomePlanilha,idRTqPCR_fk)
                        VALUES (?,?,?,?,?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objResultado->getIdResultado());
            $arrayBind[] = array('s',$objResultado->getWell());
            $arrayBind[] = array('s',$objResultado->getSampleName());
            $arrayBind[] = array('s',$objResultado->getTargetName());
            $arrayBind[] = array('s',$objResultado->getTask());
            $arrayBind[] = array('s',$objResultado->getReporter());
            $arrayBind[] = array('d',$objResultado->getCt());
            $arrayBind[] = array('s',$objResultado->getNomePlanilha());
            $arrayBind[] = array('i',$objResultado->getIdRTqPCRFk());

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objResultado->setIdResultado($objBanco->obterUltimoID());
            return $objResultado;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o resultado do RTqPCR no BD.",$ex);
        }

    }

    public function alterar(ResultadoPCR $objResultado, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_resultado_rtqpcr SET '
                . ' well = ? ,'
                . ' sampleName = ? ,'
                . ' targetName = ?, '
                . ' task = ?, '
                . ' reporter = ?, '
                . ' ct = ?, '
                . ' nomePlanilha = ?, '
                . ' idRTqPCR_fk = ? '
                . '  where idResultado = ?';


            $arrayBind = array();
            $arrayBind[] = array('s',$objResultado->getWell());
            $arrayBind[] = array('s',$objResultado->getSampleName());
            $arrayBind[] = array('s',$objResultado->getTargetName());
            $arrayBind[] = array('s',$objResultado->getTask());
            $arrayBind[] = array('s',$objResultado->getReporter());
            $arrayBind[] = array('d',$objResultado->getCt());
            $arrayBind[] = array('s',$objResultado->getNomePlanilha());
            $arrayBind[] = array('i',$objResultado->getIdRTqPCRFk());

            $arrayBind[] = array('i',$objResultado->getIdResultado());

            $objBanco->executarSQL($UPDATE,$arrayBind);

            return $objResultado;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o resultado do RTqPCR no BD.",$ex);
        }

    }

    public function listar(ResultadoPCR $objResultado,$numLimite=null, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_resultado_rtqpcr";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();



            if ($objResultado->getIdResultado() != null) {
                $WHERE .= $AND . " idResultado = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objResultado->getIdResultado());
            }


            if($objResultado->getCt() != null){
                $WHERE .= $AND." ct = ?";
                $AND = ' and ';
                $arrayBind[] = array('d',$objResultado->getCt());
            }

            if($objResultado->getIdRTqPCRFk() != null){
                $WHERE .= $AND." idRTqPCR_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i',$objResultado->getIdRTqPCRFk());
            }


            if($objResultado->getSampleName() != null){
                $WHERE .= $AND." sampleName = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objResultado->getSampleName());
            }
            if($objResultado->getWell() != null){
                $WHERE .= $AND." well = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objResultado->getWell());
            }

            if($objResultado->getTargetName() != null){
                $WHERE .= $AND." targetName = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objResultado->getTargetName());
            }

            if($objResultado->getTask() != null){
                $WHERE .= $AND." task  = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objResultado->getTask());
            }

            if($objResultado->getReporter() != null){
                $WHERE .= $AND." reporter  = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objResultado->getReporter());
            }

            if($objResultado->getNomePlanilha() != null){
                $WHERE .= $AND." nomePlanilha  = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objResultado->getNomePlanilha());
            }


            if($WHERE != ''){
                $WHERE = ' where '.$WHERE;
            }

            $LIMIT = '';
            if(!is_null($numLimite)){
                $LIMIT = ' LIMIT ?';
                $arrayBind[] = array('i',$numLimite);
            }

            $arr = $objBanco->consultarSQL($SELECT.$WHERE.$LIMIT,$arrayBind);


            $array_resultado = array();
            foreach ($arr as $reg){
                $resultado = new ResultadoPCR();
                $resultado->setIdResultado($reg['idResultado']);
                $resultado->setWell($reg['well']);
                $resultado->setSampleName($reg['sampleName']);
                $resultado->setTargetName($reg['targetName']);
                $resultado->setTask($reg['task']);
                $resultado->setReporter($reg['reporter']);
                $resultado->setCt($reg['ct']);
                $resultado->setNomePlanilha($reg['nomePlanilha']);
                $resultado->setIdRTqPCRFk($reg['idRTqPCR_fk']);

                $array_resultado[] = $resultado;
            }
            return $array_resultado;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o resultado do RTqPCR no BD.",$ex);
        }

    }

    public function consultar(ResultadoPCR $objResultado, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_resultado_rtqpcr WHERE idResultado = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objResultado->getIdResultado());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $resultado = new ResultadoPCR();
            $resultado->setIdResultado($arr[0]['idResultado']);
            $resultado->setWell($arr[0]['well']);
            $resultado->setSampleName($arr[0]['sampleName']);
            $resultado->setTargetName($arr[0]['targetName']);
            $resultado->setTask($arr[0]['task']);
            $resultado->setReporter($arr[0]['reporter']);
            $resultado->setCt($arr[0]['ct']);
            $resultado->setNomePlanilha($arr[0]['nomePlanilha']);
            $resultado->setIdRTqPCRFk($arr[0]['idRTqPCR_fk']);

            return $resultado;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando o resultado do RTqPCR no BD.",$ex);
        }

    }

    public function remover(ResultadoPCR $objResultado, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_resultado_rtqpcr WHERE idResultado = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objResultado->getIdResultado());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o resultado do RTqPCR no BD.",$ex);
        }
    }

    /**** EXTRAS ****/

   /* public function paginacao(ResultadoPCR $objResultado, Banco $objBanco) {
        try{

            $inicio = ($objResultado->getNumPagina()-1)*20;

            if($objResultado->getNumPagina() == null){
                $inicio = 0;
            }

            $SELECT = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_resultado_rtqpcr";

            $FROM = '';
            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objResultado->getidRTqPCR() != null) {
                $WHERE .= $AND . " tb_resultado_rtqpcr.idRTqPCR = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objResultado->getidRTqPCR());
            }

            if ($objResultado->getSituacaoRTqPCR() != null) {
                $WHERE .= $AND . " tb_resultado_rtqpcr.situacaoRTqPCR = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objResultado->getSituacaoRTqPCR());
            }

            if($objResultado->getObjEquipamento() != null){
                $FROM .=' ,tb_equipamento ';
                $WHERE .= $AND . " tb_equipamento.idEquipamento = tb_resultado_rtqpcr.idEquipamento_fk ";
                $AND = ' and ';

                if ($objResultado->getObjEquipamento()->getNomeEquipamento() != null) {
                    $WHERE .= $AND . " tb_equipamento.nomeEquipamento LIKE ?";
                    $AND = ' and ';
                    $arrayBind[] = array('s', "%".$objResultado->getNomeEquipamento()."%");
                }

                if ($objResultado->getObjEquipamento()->getIdEquipamento() != null) {
                    $WHERE .= $AND . " tb_equipamento.idEquipamento =  ?";
                    $AND = ' and ';
                    $arrayBind[] = array('i', $objResultado->getIdEquipamentoFk());
                }
            }

            if($objResultado->getObjPlaca() != null){
                $FROM .=' ,tb_placa ';
                $WHERE .= $AND . " tb_placa.idPlaca = tb_resultado_rtqpcr.idPlaca_fk ";
                $AND = ' and ';

                if ($objResultado->getObjPlaca()->getIndexPlaca() != null) {
                    $WHERE .= $AND . " tb_placa.index_placa LIKE ?";
                    $AND = ' and ';
                    $arrayBind[] = array('s', "%".$objResultado->getObjPlaca()->getIndexPlaca()."%");
                }

                if ($objResultado->getObjPlaca()->getIdPlaca() != null) {
                    $WHERE .= $AND . " tb_placa.idPlaca =  ?";
                    $AND = ' and ';
                    $arrayBind[] = array('i', $objResultado->getObjPlaca()->getIdPlaca());
                }
            }

            if($WHERE != ''){
                $WHERE = ' where '.$WHERE;
            }


            $order_by = ' order by  tb_resultado_rtqpcr.idRTqPCR desc ';
            $limit = ' LIMIT ?,20';

            $arrayBind[] = array('i', $inicio);
            $arr = $objBanco->consultarSQL($SELECT .$FROM. $WHERE.$order_by.$limit, $arrayBind);

            $SELECT = "SELECT FOUND_ROWS() as total";
            $total = $objBanco->consultarSQL($SELECT);
            $objResultado->setTotalRegistros($total[0]['total']);
            $objResultado->setNumPagina($inicio);

            $array_RTqPCRs = array();
            foreach ($arr as $reg){
                $RTqPCR = new RTqPCR();
                $RTqPCR->setIdRTqPCR($reg['idRTqPCR']);
                $RTqPCR->setIdPlacaFk($reg['idPlaca_fk']);
                $RTqPCR->setIdUsuarioFk($reg['idUsuario_fk']);
                $RTqPCR->setIdEquipamentoFk($reg['idEquipamento_fk']);
                $RTqPCR->setDataHoraInicio($reg['dataHoraInicio']);
                $RTqPCR->setDataHoraFim($reg['dataHoraFim']);
                $RTqPCR->setSituacaoRTqPCR($reg['situacaoRTqPCR']);

                $placa = new Placa();
                $placaRN = new PlacaRN();
                $placa->setIdPlaca($RTqPCR->getIdPlacaFk());
                $placa = $placaRN->consultar($placa);

                $objRelTuboPlaca = new RelTuboPlaca();
                $objRelTuboPlacaRN = new RelTuboPlacaRN();
                $objRelTuboPlaca->setIdPlacaFk($placa->getIdPlaca());
                $arr_tubos = $objRelTuboPlacaRN->listar_completo($objRelTuboPlaca);
                $placa->setObjsTubos($arr_tubos);

                $objRelPerfilPlaca = new RelPerfilPlaca();
                $objRelPerfilPlacaRN = new RelPerfilPlacaRN();
                $objRelPerfilPlaca->setIdPlacaFk($placa->getIdPlaca());
                $arr_perfis = $objRelPerfilPlacaRN->listar($objRelPerfilPlaca);
                $placa->setObjRelPerfilPlaca($arr_perfis);

                $RTqPCR->setObjPlaca($placa);

                $equipamento = new Equipamento();
                $equipamentoRN = new EquipamentoRN();
                $equipamento->setIdEquipamento($RTqPCR->getIdEquipamentoFk());
                $equipamento = $equipamentoRN->consultar($equipamento);
                $RTqPCR->setObjEquipamento($equipamento);

                $usuario = new Usuario();
                $usuarioRN = new UsuarioRN();
                $usuario->setIdUsuario($RTqPCR->getIdUsuarioFk());
                $usuario = $usuarioRN->consultar($usuario);
                $RTqPCR->setObjUsuario($usuario);


                $array_RTqPCRs[] = $RTqPCR;
            }
            return $array_RTqPCRs;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o resultado do RTqPCR no BD.",$ex);
        }

    }*/
}