<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';

require_once __DIR__ . '/../../classes/Lote/Lote.php';
require_once __DIR__ . '/../../classes/Lote/LoteRN.php';

require_once __DIR__ . '/../../classes/PreparoLote/PreparoLote.php';
require_once __DIR__ . '/../../classes/PreparoLote/PreparoLoteRN.php';

require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPaciente.php';
require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPacienteRN.php';

class PreparoLoteBD{

    public function cadastrar(PreparoLote $objPreparoLote, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO tb_preparo_lote (
                            idUsuario_fk,
                            idLote_fk,
                            dataHoraInicio,
                            dataHoraFim
                            ) VALUES (?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPreparoLote->getIdUsuarioFk());
            $arrayBind[] = array('i',$objPreparoLote->getIdLoteFk());
            $arrayBind[] = array('s',$objPreparoLote->getDataHoraInicio());
            $arrayBind[] = array('s',$objPreparoLote->getDataHoraFim());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objPreparoLote->setIdPreparoLote($objBanco->obterUltimoID());
            return $objPreparoLote;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o preparo do lote no BD.",$ex);
        }

    }

    public function alterar(PreparoLote $objPreparoLote, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_preparo_lote SET '
                . ' idUsuario_fk = ?,'
                . ' idLote_fk = ?,'
                . ' dataHoraInicio = ?,'
                . ' dataHoraFim = ?'
                . '  where idPreparoLote = ?';


            $arrayBind = array();
            $arrayBind[] = array('i',$objPreparoLote->getIdUsuarioFk());
            $arrayBind[] = array('i',$objPreparoLote->getIdLoteFk());
            $arrayBind[] = array('s',$objPreparoLote->getDataHoraInicio());
            $arrayBind[] = array('s',$objPreparoLote->getDataHoraFim());

            $arrayBind[] = array('i',$objPreparoLote->getIdPreparoLote());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objPreparoLote;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o preparo do lote no BD.",$ex);
        }

    }

    public function listar(PreparoLote $objPreparoLote, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_preparo_lote";
            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            //fitro pelo lote
            if ($objPreparoLote->getIdLoteFk() != null) {
                $WHERE .= $AND . " idLote_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPreparoLote->getIdLoteFk() );
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }


            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            $array = array();
            foreach ($arr as $reg){
                $objPreparoLote = new PreparoLote();
                $objPreparoLote->setIdPreparoLote($reg['idPreparoLote']);
                $objPreparoLote->setIdUsuarioFk($reg['idUsuario_fk']);
                $objPreparoLote->setIdLoteFk($reg['idLote_fk']);
                $objPreparoLote->setDataHoraFim($reg['dataHoraFim']);
                $objPreparoLote->setDataHoraInicio($reg['dataHoraInicio']);

                $array[] = $objPreparoLote;
            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o preparo do lote no BD.",$ex);
        }

    }

    public function consultar(PreparoLote $objPreparoLote, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_preparo_lote WHERE idPreparoLote = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPreparoLote->getIdPreparoLote());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $preparoLote = new PreparoLote();
            $preparoLote->setIdPreparoLote($arr[0]['idPreparoLote']);
            $preparoLote->setIdUsuarioFk($arr[0]['idUsuario_fk']);
            $preparoLote->setIdLoteFk($arr[0]['idLote_fk']);
            $preparoLote->setDataHoraFim($arr[0]['dataHoraFim']);
            $preparoLote->setDataHoraInicio($arr[0]['dataHoraInicio']);

            return $preparoLote;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando preparo do lote no BD.",$ex);
        }

    }

    public function remover(PreparoLote $objPreparoLote, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_preparo_lote WHERE idPreparoLote = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objPreparoLote->getIdPreparoLote());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo preparo do lote no BD.",$ex);
        }
    }


    public function listar_completo(PreparoLote $objPreparoLote, Banco $objBanco) {
        try{

            $SELECT = "select DISTINCT tb_preparo_lote.idPreparoLote,
                                        tb_preparo_lote.idUsuario_fk, 
                                       tb_lote.idLote, 
                                       tb_lote.situacaoLote, 
                                       tb_lote.qntAmostrasAdquiridas, 
                                       tb_rel_tubo_lote.idTubo_fk, 
                                       tb_tubo.tuboOriginal, 
                                       tb_tubo.tipo, 
                                       tb_tubo.idAmostra_fk 
                        from tb_preparo_lote,tb_lote,tb_rel_tubo_lote,tb_tubo 
                        where tb_preparo_lote.idLote_fk = tb_lote.idLote 
                        and tb_rel_tubo_lote.idLote_fk = tb_lote.idLote 
                        and tb_rel_tubo_lote.idTubo_fk = tb_tubo.idTubo 
                        and tb_lote.situacaoLote = ? ";

            $arrayBind = array();

            $arrayBind[] = array('s', LoteRN::$TE_TRANSPORTE_PREPARACAO );
            $arr = $objBanco->consultarSQL($SELECT , $arrayBind);



            $array = array();
            foreach ($arr as $reg){
                $objPreparoLote = new PreparoLote();
                $objPreparoLote->setIdPreparoLote($reg['idPreparoLote']);
                $objPreparoLote->setIdUsuarioFk($reg['idUsuario_fk']);
                $objPreparoLote->setIdLoteFk($reg['idLote_fk']);
                $objPreparoLote->setDataHoraFim($reg['dataHoraFim']);
                $objPreparoLote->setDataHoraInicio($reg['dataHoraInicio']);

                $objLote = new Lote();
                $objLote->setIdLote($reg['idLote']);
                $objLote->setSituacaoLote($reg['situacaoLote']);
                $objLote->setQntAmostrasAdquiridas($reg['qntAmostrasAdquiridas']);

                $objTubo = new Tubo();
                $objTubo->setIdTubo($reg['idTubo_fk']);
                $objTubo->setTuboOriginal($reg['tuboOriginal']);
                $objTubo->setTipo($reg['tipo']);
                $objTubo->setIdAmostra_fk($reg['idAmostra_fk']);
                $arr_tubos[]  =$objTubo;


                $objLote->setObjsTubo($arr_tubos);
                $objPreparoLote->setObjLote($objLote);


                $array[] = $objPreparoLote;
            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o preparo do lote no BD.",$ex);
        }

    }

    public function consultar_tubos(PreparoLote $objPreparoLote, Banco $objBanco) {

        try{

            $SELECT = 'select distinct 
                                       tb_rel_tubo_lote.idTubo_fk,
                                       tb_rel_tubo_lote.idLote_fk,
                                       tb_tubo.tipo,
                                       tb_amostra.idAmostra,
                                       tb_amostra.codigoAmostra,
                                       tb_amostra.nickname,
                                       tb_amostra.dataColeta,
                                       tb_perfilpaciente.caractere
                                       
                        FROM tb_tubo, tb_infostubo, tb_rel_tubo_lote,tb_preparo_lote,tb_lote ,tb_amostra,tb_perfilpaciente
                        where tb_preparo_lote.idPreparoLote = ?
                        and tb_tubo.idAmostra_fk = tb_amostra.idAmostra
                        and tb_rel_tubo_lote.idTubo_fk = tb_tubo.idTubo
                        and tb_lote.idLote = tb_rel_tubo_lote.idLote_fk 
                        and tb_preparo_lote.idLote_fk = tb_lote.idLote
                        and tb_amostra.idPerfilPaciente_fk = tb_perfilpaciente.idPerfilPaciente';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPreparoLote->getIdPreparoLote());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);
            //print_r($arr);
            $preparoLote = new PreparoLote();
            $preparoLote->setIdPreparoLote($objPreparoLote->getIdPreparoLote());

            $i=0;
            foreach ($arr as $reg) {
                if($i ==0 ){
                    //print_r($reg['idLote_fk']);
                    $preparoLote->setIdLoteFk($reg['idLote_fk']);
                }

                $objPerfilPaciente = new PerfilPaciente();
                $objPerfilPaciente->setCaractere($reg['caractere']);

                $objTubo = new Tubo();
                $objTubo->setIdTubo($reg['idTubo_fk']);
                $objTubo->setTipo($reg['tipo']);
                //$arr_tubos[] = $objTubo;

                $objAmostra = new Amostra();
                $objAmostra->setIdAmostra($reg['idAmostra']);
                $objAmostra->setCodigoAmostra($reg['codigoAmostra']);
                $objAmostra->setDataColeta($reg['dataColeta']);
                $objAmostra->setNickname($reg['nickname']);
                $objAmostra->setObjTubo($objTubo);
                $objAmostra->setObjPaciente($objPerfilPaciente);
                $arr_amostras[] = $objAmostra;
                $i++;
            }

            $preparoLote->setObjsTubos($arr_amostras);
            //$preparoLote->setObjsTubos($arr_tubos);
            $arr_preparos[] = $preparoLote;
            //print_r($arr_preparos);

            return $arr_preparos;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando o lote no BD.",$ex);
        }

    }


    public function listar_preparos(PreparoLote $objPreparoLote,$situacaoLote,$tipoLote, Banco $objBanco) {

        try{

            $SELECT = 'SELECT tb_preparo_lote.idPreparoLote, tb_lote.idLote, tb_lote.qntAmostrasAdquiridas, tb_lote.tipo 
                        from tb_preparo_lote, tb_lote 
                        where tb_preparo_lote.idLote_fk = tb_lote.idLote 
                        and tb_lote.situacaoLote = ? 
                        and tb_lote.tipo = ? ';

            $arrayBind = array();
            $arrayBind[] = array('s',$situacaoLote);
            $arrayBind[] = array('s',$tipoLote);

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            foreach ($arr as $reg) {
                $preparoLote = new PreparoLote();
                $preparoLote->setIdPreparoLote($reg['idPreparoLote']);

                $objLote = new Lote();
                $objLote->setQntAmostrasAdquiridas($reg['qntAmostrasAdquiridas']);
                $objLote->setIdLote($reg['idLote']);
                $objLote->setTipo($reg['tipo']);

                $preparoLote->setObjLote($objLote);
                $arr_preparos[] = $preparoLote;
            }

            return $arr_preparos;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando o lote no BD.",$ex);
        }

    }


    public function mudar_status_lote(PreparoLote $objPreparoLote,$novo_status, Banco $objBanco) {

        try{

            $UPDATE = 'update tb_lote set situacaoLote = ? where idLote = (SELECT idLote_fk FROM tb_preparo_lote where tb_preparo_lote.idPreparoLote = ?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$novo_status);
            $arrayBind[] = array('i',$objPreparoLote->getIdPreparoLote());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando o lote no BD.",$ex);
        }

    }

    public function listar_preparos_lote(PreparoLote $objPreparoLote,$tipoLote,Banco $objBanco) {

        try{

            $SELECT1 = 'SELECT *                      
                        from tb_preparo_lote, tb_lote  
                        where tb_preparo_lote.idLote_fk = tb_lote.idLote 
                        and tb_lote.tipo = ?
                        ';

            $arrayBind1 = array();
            $arrayBind1[] = array('s',$tipoLote);
            $array = $objBanco->consultarSQL($SELECT1,$arrayBind1);


            foreach ($array as $arr) {
                $preparoLote = new PreparoLote();
                $preparoLote->setIdUsuarioFk($arr['idUsuario_fk']);
                $preparoLote->setIdPreparoLote($arr['idPreparoLote']);
                $preparoLote->setDataHoraInicio($arr['dataHoraInicio']);
                $preparoLote->setIdLoteFk($arr['idLote_fk']);
                $preparoLote->setDataHoraFim($arr['dataHoraFim']);

                $objLote = new Lote();
                $objLote->setQntAmostrasAdquiridas($arr['qntAmostrasAdquiridas']);
                $objLote->setQntAmostrasDesejadas($arr['qntAmostrasDesejadas']);
                $objLote->setTipo($arr['tipo']);
                $objLote->setSituacaoLote($arr['situacaoLote']);
                $objLote->setIdLote($arr['idLote']);



                $SELECT1 = 'SELECT tb_rel_tubo_lote.idTubo_fk, tb_tubo.tipo 
                        FROM tb_lote, tb_rel_tubo_lote, tb_tubo 
                        where tb_lote.idLote = tb_rel_tubo_lote.idLote_fk 
                            and tb_lote.idLote  =  ?
                            and tb_tubo.idTubo = tb_rel_tubo_lote.idTubo_fk';

                $arrayBind1 = array();
                $arrayBind1[] = array('i',$arr['idLote']);
                $arr1 = $objBanco->consultarSQL($SELECT1,$arrayBind1);
                $arr_tubos = array();
                foreach ($arr1 as $reg) {

                    $objTubo = new Tubo();
                    $objTubo->setIdTubo($reg['idTubo_fk']);
                    $objTubo->setTipo($reg['tipo']);
                    $arr_tubos[] = $objTubo;
                }
                $objLote->setObjsTubo($arr_tubos);
                $preparoLote->setObjLote($objLote);
                $arr_preparos[]  = $preparoLote;

            }

            return $arr_preparos;
        } catch (Throwable $ex) {
            throw new Excecao("Erro consultando o lote no BD.",$ex);
        }

    }



}
