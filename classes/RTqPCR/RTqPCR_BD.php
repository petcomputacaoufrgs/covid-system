<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class RTqPCR_BD
{
    public function cadastrar(RTqPCR $objRTqPCR, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO tb_rtqpcr (idUsuario_fk,idPlaca_fk, idEquipamento_fk, dataHoraInicio,dataHoraFim,situacaoRTqPCR,horaFinal)
                        VALUES (?,?,?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRTqPCR->getIdUsuarioFk());
            $arrayBind[] = array('i',$objRTqPCR->getIdPlacaFk());
            $arrayBind[] = array('i',$objRTqPCR->getIdEquipamentoFk());
            $arrayBind[] = array('s',$objRTqPCR->getDataHoraInicio());
            $arrayBind[] = array('s',$objRTqPCR->getDataHoraFim());
            $arrayBind[] = array('s',$objRTqPCR->getSituacaoRTqPCR());
            $arrayBind[] = array('s',$objRTqPCR->getHoraFinal());

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objRTqPCR->setidRTqPCR($objBanco->obterUltimoID());
            return $objRTqPCR;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando RTqPCR no BD.",$ex);
        }

    }

    public function alterar(RTqPCR $objRTqPCR, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_rtqpcr SET '
                . ' idUsuario_fk = ? ,'
                . ' idPlaca_fk = ? ,'
                . ' idEquipamento_fk = ? ,'
                . ' dataHoraInicio = ?, '
                . ' dataHoraFim = ?, '
                . ' situacaoRTqPCR = ?, '
                . ' horaFinal = ? '
                . '  where idRTqPCR = ?';


            $arrayBind = array();
            $arrayBind[] = array('i',$objRTqPCR->getIdUsuarioFk());
            $arrayBind[] = array('i',$objRTqPCR->getIdPlacaFk());
            $arrayBind[] = array('i',$objRTqPCR->getIdEquipamentoFk());
            $arrayBind[] = array('s',$objRTqPCR->getDataHoraInicio());
            $arrayBind[] = array('s',$objRTqPCR->getDataHoraFim());
            $arrayBind[] = array('s',$objRTqPCR->getSituacaoRTqPCR());
            $arrayBind[] = array('s',$objRTqPCR->getHoraFinal());

            $arrayBind[] = array('i',$objRTqPCR->getIdRTqPCR());

            $objBanco->executarSQL($UPDATE,$arrayBind);

            return $objRTqPCR;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando RTqPCR no BD.",$ex);
        }

    }

    public function listar(RTqPCR $objRTqPCR,$numLimite=null, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_rtqpcr";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();



            if ($objRTqPCR->getIdEquipamentoFk() != null) {
                $WHERE .= $AND . " idEquipamento_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objRTqPCR->getIdEquipamentoFk());
            }


            if($objRTqPCR->getIdPlacaFk() != null){
                $WHERE .= $AND." idPlaca_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i',$objRTqPCR->getIdPlacaFk());
            }

            if($objRTqPCR->getIdUsuarioFk() != null){
                $WHERE .= $AND." idUsuario_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i',$objRTqPCR->getIdUsuarioFk());
            }
            if($objRTqPCR->getDataHoraInicio() != null){
                $WHERE .= $AND." dataHoraInicio = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objRTqPCR->getDataHoraInicio());
            }

            if($objRTqPCR->getDataHoraFim() != null){
                $WHERE .= $AND." dataHoraFim = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objRTqPCR->getDataHoraFim());
            }

            if($objRTqPCR->getSituacaoRTqPCR() != null){
                $WHERE .= $AND." situacaoRTqPCR  = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objRTqPCR->getSituacaoRTqPCR());
            }

            if($objRTqPCR->getHoraFinal() != null){
                $WHERE .= $AND." horaFinal  = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objRTqPCR->getHoraFinal());
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


            $array_RTqPCR = array();
            foreach ($arr as $reg){
                $RTqPCR = new RTqPCR();
                $RTqPCR->setIdRTqPCR($reg['idRTqPCR']);
                $RTqPCR->setIdPlacaFk($reg['idPlaca_fk']);
                $RTqPCR->setIdUsuarioFk($reg['idUsuario_fk']);
                $RTqPCR->setIdEquipamentoFk($reg['idEquipamento_fk']);
                $RTqPCR->setDataHoraInicio($reg['dataHoraInicio']);
                $RTqPCR->setDataHoraFim($reg['dataHoraFim']);
                $RTqPCR->setSituacaoRTqPCR($reg['situacaoRTqPCR']);
                $RTqPCR->setHoraFinal($reg['horaFinal']);

                $array_RTqPCR[] = $RTqPCR;
            }
            return $array_RTqPCR;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando RTqPCR no BD.",$ex);
        }

    }

    public function consultar(RTqPCR $objRTqPCR, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_rtqpcr WHERE idRTqPCR = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRTqPCR->getidRTqPCR());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $RTqPCR = new RTqPCR();
            $RTqPCR->setIdRTqPCR($arr[0]['idRTqPCR']);
            $RTqPCR->setIdPlacaFk($arr[0]['idPlaca_fk']);
            $RTqPCR->setIdUsuarioFk($arr[0]['idUsuario_fk']);
            $RTqPCR->setIdEquipamentoFk($arr[0]['idEquipamento_fk']);
            $RTqPCR->setDataHoraInicio($arr[0]['dataHoraInicio']);
            $RTqPCR->setDataHoraFim($arr[0]['dataHoraFim']);
            $RTqPCR->setSituacaoRTqPCR($arr[0]['situacaoRTqPCR']);
            $RTqPCR->setHoraFinal($arr[0]['horaFinal']);

            return $RTqPCR;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando RTqPCR no BD.",$ex);
        }

    }

    public function remover(RTqPCR $objRTqPCR, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_rtqpcr WHERE idRTqPCR = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objRTqPCR->getidRTqPCR());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo RTqPCR no BD.",$ex);
        }
    }

    /**** EXTRAS ****/

    public function listar_completo(RTqPCR $objRTqPCR,$numLimite=null, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_rtqpcr";

            $FROM = '';
            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if($objRTqPCR->getObjDetentor() != null) {
                $FROM .=' ,tb_detentor ';
                $WHERE .= $AND . " tb_rtqpcr.idDetentor_fk = tb_detentor.idDetentor ";
                $AND = ' and ';

                if ($objRTqPCR->getObjDetentor()->getIdDetentor() != null) {
                    $WHERE .= $AND . " tb_detentor.idDetentor = ?";
                    $AND = ' and ';
                    $arrayBind[] = array('i', $objRTqPCR->getObjDetentor()->getIdDetentor());
                }
                if ($objRTqPCR->getObjDetentor()->getIndex_detentor() != null) {
                    $WHERE .= $AND . " tb_detentor.index_detentor = ?";
                    $AND = ' and ';
                    $arrayBind[] = array('s', $objRTqPCR->getObjDetentor()->getIndex_detentor());
                }
            }

            if($objRTqPCR->getObjMarca() != null) {
                $FROM .=' ,tb_marca ';
                $WHERE .= $AND . " tb_rtqpcr.idMarca_fk = tb_marca.idMarca ";
                $AND = ' and ';

                if ($objRTqPCR->getObjMarca()->getIdMarca() != null) {
                    $WHERE .= $AND . " tb_marca.idMarca = ?";
                    $AND = ' and ';
                    $arrayBind[] = array('i', $objRTqPCR->getObjMarca()->getIdMarca());
                }
                if ($objRTqPCR->getObjMarca()->getIndex_marca() != null) {
                    $WHERE .= $AND . " tb_marca.index_marca = ?";
                    $AND = ' and ';
                    $arrayBind[] = array('s', $objRTqPCR->getObjMarca()->getIndex_marca());
                }
            }

            if($objRTqPCR->getObjModelo() != null) {
                $FROM .=' ,tb_modelo ';
                $WHERE .= $AND . " tb_rtqpcr.idModelo_fk = tb_modelo.idModelo ";
                $AND = ' and ';

                if ($objRTqPCR->getObjModelo()->getIdModelo() != null) {
                    $WHERE .= $AND . " tb_modelo.idModelo = ?";
                    $AND = ' and ';
                    $arrayBind[] = array('i', $objRTqPCR->getObjModelo()->getIdModelo());
                }
                if ($objRTqPCR->getObjModelo()->getIndex_modelo() != null) {
                    $WHERE .= $AND . " tb_modelo.index_modelo = ?";
                    $AND = ' and ';
                    $arrayBind[] = array('s', $objRTqPCR->getObjModelo()->getIndex_modelo());
                }
            }

            if($objRTqPCR->getNomeEquipamento() != null){
                $WHERE .= $AND." nomeEquipamento LIKE  ?";
                $AND = ' and ';
                $arrayBind[] = array('s',".%".$objRTqPCR->getNomeEquipamento()."%");
            }

            if($objRTqPCR->getidRTqPCR() != null){
                $WHERE .= $AND." idRTqPCR = ?";
                $AND = ' and ';
                $arrayBind[] = array('i',$objRTqPCR->getidRTqPCR());
            }

            if($objRTqPCR->getSituacaoEquipamento() != null){
                $WHERE .= $AND." situacaoEquipamento = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objRTqPCR->getSituacaoEquipamento());
            }

            if($objRTqPCR->getHoras() != null){
                $WHERE .= $AND." horas = ?";
                $AND = ' and ';
                $arrayBind[] = array('i',$objRTqPCR->getHoras());
            }

            if($objRTqPCR->getHoraFinal() != null){
                $WHERE .= $AND." horaFinal = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objRTqPCR->getHoraFinal());
            }

            if($objRTqPCR->getMinutos() != null){
                $WHERE .= $AND." minutos = ?";
                $AND = ' and ';
                $arrayBind[] = array('i',$objRTqPCR->getMinutos());
            }


            if($WHERE != ''){
                $WHERE = ' where '.$WHERE;
            }

            $LIMIT = '';
            if(!is_null($numLimite)){
                $LIMIT = ' LIMIT ?';
                $arrayBind[] = array('i',$numLimite);
            }

            $arr = $objBanco->consultarSQL($SELECT.$FROM.$WHERE.$LIMIT,$arrayBind);


            $array_equipamento = array();
            foreach ($arr as $reg){
                $objRTqPCR = new RTqPCR();
                $objRTqPCR->setidRTqPCR($reg['idRTqPCR']);
                $objRTqPCR->setIdDetentor_fk($reg['idDetentor_fk']);
                $objRTqPCR->setIdMarca_fk($reg['idMarca_fk']);
                $objRTqPCR->setIdModelo_fk($reg['idModelo_fk']);
                $objRTqPCR->setDataUltimaCalibragem($reg['dataUltimaCalibragem']);
                $objRTqPCR->setDataChegada($reg['dataChegada']);
                $objRTqPCR->setDataCadastro($reg['dataCadastro']);
                $objRTqPCR->setIdUsuarioFk($reg['idUsuario_fk']);
                $objRTqPCR->setSituacaoEquipamento($reg['situacaoEquipamento']);
                $objRTqPCR->setNomeEquipamento($reg['nomeEquipamento']);
                $objRTqPCR->setHoras($reg['horas']);
                $objRTqPCR->setMinutos($reg['minutos']);
                $objRTqPCR->setHoraFinal($reg['horaFinal']);


                //** DETENTOR
                $objDetentor = new Detentor();
                $objDetentorRN = new DetentorRN();
                $objDetentor->setIdDetentor($objRTqPCR->getIdDetentor_fk());
                $objDetentor = $objDetentorRN->consultar($objDetentor);
                $objRTqPCR->setObjDetentor($objDetentor);

                //** MODELO
                $objModelo = new Modelo();
                $objModeloRN = new ModeloRN();
                $objModelo->setIdModelo($objRTqPCR->getIdModelo_fk());
                $objModelo = $objModeloRN->consultar($objModelo);
                $objRTqPCR->setObjModelo($objModelo);

                //** MARCA
                $objMarca = new Marca();
                $objMarcaRN = new MarcaRN();
                $objMarca->setIdMarca($objRTqPCR->getIdMarca_fk());
                $objMarca = $objMarcaRN->consultar($objMarca);
                $objRTqPCR->setObjMarca($objMarca);

                $array_equipamento[] = $objRTqPCR;
            }
            return $array_equipamento;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando RTqPCR no BD.",$ex);
        }

    }

    public function paginacao(RTqPCR $objRTqPCR, Banco $objBanco) {
        try{

            $inicio = ($objRTqPCR->getNumPagina()-1)*20;

            if($objRTqPCR->getNumPagina() == null){
                $inicio = 0;
            }

            $SELECT = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_rtqpcr";

            $FROM = '';
            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objRTqPCR->getidRTqPCR() != null) {
                $WHERE .= $AND . " tb_rtqpcr.idRTqPCR = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objRTqPCR->getidRTqPCR());
            }

            if ($objRTqPCR->getSituacaoRTqPCR() != null) {
                $WHERE .= $AND . " tb_rtqpcr.situacaoRTqPCR = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objRTqPCR->getSituacaoRTqPCR());
            }

            if($objRTqPCR->getObjEquipamento() != null){
                $FROM .=' ,tb_equipamento ';
                $WHERE .= $AND . " tb_equipamento.idEquipamento = tb_rtqpcr.idEquipamento_fk ";
                $AND = ' and ';

                if ($objRTqPCR->getObjEquipamento()->getNomeEquipamento() != null) {
                    $WHERE .= $AND . " tb_equipamento.nomeEquipamento LIKE ?";
                    $AND = ' and ';
                    $arrayBind[] = array('s', "%".$objRTqPCR->getNomeEquipamento()."%");
                }

                if ($objRTqPCR->getObjEquipamento()->getIdEquipamento() != null) {
                    $WHERE .= $AND . " tb_equipamento.idEquipamento =  ?";
                    $AND = ' and ';
                    $arrayBind[] = array('i', $objRTqPCR->getIdEquipamentoFk());
                }
            }

            if($objRTqPCR->getObjPlaca() != null){
                $FROM .=' ,tb_placa ';
                $WHERE .= $AND . " tb_placa.idPlaca = tb_rtqpcr.idPlaca_fk ";
                $AND = ' and ';

                if ($objRTqPCR->getObjPlaca()->getIndexPlaca() != null) {
                    $WHERE .= $AND . " tb_placa.index_placa LIKE ?";
                    $AND = ' and ';
                    $arrayBind[] = array('s', "%".$objRTqPCR->getObjPlaca()->getIndexPlaca()."%");
                }

                if ($objRTqPCR->getObjPlaca()->getIdPlaca() != null) {
                    $WHERE .= $AND . " tb_placa.idPlaca =  ?";
                    $AND = ' and ';
                    $arrayBind[] = array('i', $objRTqPCR->getObjPlaca()->getIdPlaca());
                }
            }

            if($WHERE != ''){
                $WHERE = ' where '.$WHERE;
            }


            $order_by = ' order by  tb_rtqpcr.idRTqPCR desc ';
            $limit = ' LIMIT ?,20';

            $arrayBind[] = array('i', $inicio);
            $arr = $objBanco->consultarSQL($SELECT .$FROM. $WHERE.$order_by.$limit, $arrayBind);

            $SELECT = "SELECT FOUND_ROWS() as total";
            $total = $objBanco->consultarSQL($SELECT);
            $objRTqPCR->setTotalRegistros($total[0]['total']);
            $objRTqPCR->setNumPagina($inicio);

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
                $RTqPCR->setHoraFinal($reg['horaFinal']);

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
            throw new Excecao("Erro listando RTqPCR no BD.",$ex);
        }

    }
}