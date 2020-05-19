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
                            dataHoraFim,
                            idCapela_fk,
                            idPreparoLote_fk,
                            idKitExtracao_fk                            
                            ) VALUES (?,?,?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPreparoLote->getIdUsuarioFk());
            $arrayBind[] = array('i',$objPreparoLote->getIdLoteFk());
            $arrayBind[] = array('s',$objPreparoLote->getDataHoraInicio());
            $arrayBind[] = array('s',$objPreparoLote->getDataHoraFim());
            $arrayBind[] = array('i',$objPreparoLote->getIdCapelaFk());
            $arrayBind[] = array('i',$objPreparoLote->getIdPreparoLoteFk());
            $arrayBind[] = array('i',$objPreparoLote->getIdKitExtracaoFk());


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
                . ' dataHoraFim = ?,'
                . ' idCapela_fk = ?,'
                . ' idPreparoLote_fk = ?,'
                . ' idKitExtracao_fk = ?'
                . '  where idPreparoLote = ?';


            $arrayBind = array();
            $arrayBind[] = array('i',$objPreparoLote->getIdUsuarioFk());
            $arrayBind[] = array('i',$objPreparoLote->getIdLoteFk());
            $arrayBind[] = array('s',$objPreparoLote->getDataHoraInicio());
            $arrayBind[] = array('s',$objPreparoLote->getDataHoraFim());
            $arrayBind[] = array('i',$objPreparoLote->getIdCapelaFk());
            $arrayBind[] = array('i',$objPreparoLote->getIdPreparoLoteFk());
            $arrayBind[] = array('i',$objPreparoLote->getIdKitExtracaoFk());

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
            if ($objPreparoLote->getIdPreparoLoteFk() != null) {
                $WHERE .= $AND . " idPreparoLote_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPreparoLote->getIdPreparoLoteFk() );
            }

            if ($objPreparoLote->getIdCapelaFk() != null) {
                $WHERE .= $AND . " idCapela_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPreparoLote->getIdCapelaFk() );
            }

            if ($objPreparoLote->getIdKitExtracaoFk() != null) {
                $WHERE .= $AND . " idKitExtracao_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPreparoLote->getIdKitExtracaoFk() );
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
                $objPreparoLote->setIdPreparoLoteFk($reg['idPreparoLote_fk']);
                $objPreparoLote->setIdCapelaFk($reg['idCapela_fk']);
                $objPreparoLote->setIdKitExtracaoFk($reg['idKitExtracao_fk']);

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
            $preparoLote->setIdPreparoLoteFk($arr[0]['idPreparoLote_fk']);
            $preparoLote->setIdCapelaFk($arr[0]['idCapela_fk']);
            $preparoLote->setIdKitExtracaoFk($arr[0]['idKitExtracao_fk']);

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

    public function consultar_lote(PreparoLote $objPreparoLote, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_preparo_lote,tb_lote WHERE tb_preparo_lote.idPreparoLote = ?
                        and tb_preparo_lote.idLote_fk = tb_lote.idLote';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPreparoLote->getIdPreparoLote());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $preparoLote = new PreparoLote();
            $preparoLote->setIdPreparoLote($arr[0]['idPreparoLote']);
            $preparoLote->setIdUsuarioFk($arr[0]['idUsuario_fk']);
            $preparoLote->setIdLoteFk($arr[0]['idLote_fk']);
            $preparoLote->setDataHoraFim($arr[0]['dataHoraFim']);
            $preparoLote->setDataHoraInicio($arr[0]['dataHoraInicio']);
            $preparoLote->setIdPreparoLoteFk($arr[0]['idPreparoLote_fk']);
            $preparoLote->setIdCapelaFk($arr[0]['idCapela_fk']);
            $preparoLote->setIdKitExtracaoFk($arr[0]['idKitExtracao_fk']);

            $objLote = new Lote();
            $objLote->setIdLote($arr[0]['idLote']);
            $objLote->setQntAmostrasDesejadas($arr[0]['qntAmostrasDesejadas']);
            $objLote->setQntAmostrasAdquiridas($arr[0]['qntAmostrasAdquiridas']);
            $objLote->setSituacaoLote($arr[0]['situacaoLote']);
            $objLote->setTipo($arr[0]['tipo']);
            $preparoLote->setObjLote($objLote);

            return $preparoLote;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando preparo do lote no BD.",$ex);
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
                                       tb_perfilpaciente.caractere,
                                       tb_lote.situacaoLote
                                       
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
                $objAmostra->setObjLote($reg['situacaoLote']);
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

            $UPDATE = 'update tb_lote set situacaoLote = ? 
            where idLote = (SELECT idLote_fk FROM tb_preparo_lote where tb_preparo_lote.idPreparoLote = ?)';

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
                        from tb_preparo_lote, tb_lote,tb_usuario  
                        where tb_preparo_lote.idLote_fk = tb_lote.idLote 
                        and tb_lote.tipo = ?
                        AND tb_usuario.idUsuario = tb_preparo_lote.idUsuario_fk
                        ';

            $arrayBind1 = array();
            $arrayBind1[] = array('s',$tipoLote);
            $array = $objBanco->consultarSQL($SELECT1,$arrayBind1);


            foreach ($array as $arr) {
                $preparoLote = new PreparoLote();
                $preparoLote->setIdUsuarioFk($arr['matricula']);
                $preparoLote->setIdPreparoLote($arr['idPreparoLote']);
                $preparoLote->setDataHoraInicio($arr['dataHoraInicio']);
                $preparoLote->setIdLoteFk($arr['idLote_fk']);
                $preparoLote->setDataHoraFim($arr['dataHoraFim']);
                $preparoLote->setIdPreparoLoteFk($arr['idPreparoLote_fk']);
                $preparoLote->setIdCapelaFk($arr['idCapela_fk']);
                $preparoLote->setIdKitExtracaoFk($arr['idKitExtracao_fk']);

                //print_r($preparoLote);
                //echo "\n";

                if($preparoLote->getIdPreparoLoteFk() != null){
                    $objLoteOriginal = new Lote();

                    $select_lote_original = 'select tb_lote.idLote as idLoteOriginal,
                                            tb_lote.tipo as tipoLoteOriginal
                                    from tb_lote, tb_preparo_lote where
                        tb_lote.idLote = tb_preparo_lote.idLote_fk
                        and tb_preparo_lote.idPreparoLote = ?';
                    $arrayBind2 = array();
                    $arrayBind2[] = array('i', $arr['idPreparoLote_fk']);
                    $loteOriginal = $objBanco->consultarSQL($select_lote_original, $arrayBind2);

                    $objLoteOriginal->setTipo($loteOriginal[0]['tipoLoteOriginal']);
                    $objLoteOriginal->setIdLote($loteOriginal[0]['idLoteOriginal']);
                    $preparoLote->setObjLoteOriginal($objLoteOriginal);
                }


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
                $arr_amostras = array();
                foreach ($arr1 as $reg) {

                    $objTubo = new Tubo();
                    $objTubo->setIdTubo($reg['idTubo_fk']);
                    $objTubo->setTipo($reg['tipo']);
                    $arr_tubos[] = $objTubo;
                //}


                //foreach ($arr_tubos as $tubo){
                    $selectAmostras = 'select * from tb_amostra, tb_tubo where tb_amostra.idAmostra = tb_tubo.idAmostra_fk
                    and tb_tubo.idTubo = ?';

                    $arrayBind2 = array();
                    $arrayBind2[] = array('i', $objTubo->getIdTubo());
                    $array = $objBanco->consultarSQL($selectAmostras,$arrayBind2);

                    $objAmostra = new Amostra();
                    $objAmostra->setIdAmostra($array[0]['idAmostra']);
                    $objAmostra->setCodigoAmostra($array[0]['codigoAmostra']);
                    $objAmostra->setDataColeta($array[0]['dataColeta']);
                    $objAmostra->setNickname($array[0]['nickname']);
                    $arr_amostras[] = $objAmostra;

                }
                $objLote->setObjsAmostras($arr_amostras);
                $objLote->setObjsTubo($arr_tubos);
                $preparoLote->setObjLote($objLote);
                $arr_preparos[]  = $preparoLote;

            }

            return $arr_preparos;
        } catch (Throwable $ex) {
            die($ex);
            throw new Excecao("Erro consultando o lote no BD.",$ex);
        }

    }


    public function obter_todas_infos(PreparoLote $objPreparoLote,Banco $objBanco) {

        try{

            $SELECT1 = 'SELECT * FROM tb_preparo_lote, tb_lote, tb_rel_tubo_lote where 
                        tb_preparo_lote.idPreparoLote = ?
                         and tb_preparo_lote.idLote_fk = tb_lote.idLote 
                         AND tb_rel_tubo_lote.idLote_fk = tb_lote.idLote 
                    
                        ';

            $arrayBind1 = array();
            $arrayBind1[] = array('i',$objPreparoLote->getIdPreparoLote());
            $array = $objBanco->consultarSQL($SELECT1,$arrayBind1);

            $preparoLote = new PreparoLote();
            $preparoLote->setIdUsuarioFk($array[0]['idUsuario']);
            $preparoLote->setIdPreparoLote($array[0]['idPreparoLote']);
            $preparoLote->setDataHoraInicio($array[0]['dataHoraInicio']);
            $preparoLote->setIdLoteFk($array[0]['idLote_fk']);
            $preparoLote->setDataHoraFim($array[0]['dataHoraFim']);
            $preparoLote->setIdPreparoLoteFk($array[0]['idPreparoLote_fk']);
            $preparoLote->setIdCapelaFk($array[0]['idCapela_fk']);
            $preparoLote->setIdKitExtracaoFk($array[0]['idKitExtracao_fk']);

            $objLote = new Lote();
            $objLote->setQntAmostrasAdquiridas($array[0]['qntAmostrasAdquiridas']);
            $objLote->setQntAmostrasDesejadas($array[0]['qntAmostrasDesejadas']);
            $objLote->setTipo($array[0]['tipo']);
            $objLote->setSituacaoLote($array[0]['situacaoLote']);
            $objLote->setIdLote($array[0]['idLote']);

            $SELECT_PERFIS = 'SELECT * FROM tb_preparo_lote,tb_rel_perfil_preparolote,tb_perfilpaciente 
                                where tb_preparo_lote.idPreparoLote = ? 
                                and tb_rel_perfil_preparolote.idPreparoLote_fk = tb_preparo_lote.idPreparoLote 
                                and tb_perfilpaciente.idPerfilPaciente = tb_rel_perfil_preparolote.idPerfilPaciente_fk                         
                        ';
            $array_perfis = $objBanco->consultarSQL($SELECT_PERFIS,$arrayBind1);

            foreach ($array_perfis as $perfil) {
                $objPerfilPaciente = new PerfilPaciente();
                $objPerfilPaciente->setIdPerfilPaciente($perfil['idPerfilPaciente']);
                $objPerfilPaciente->setPerfil($perfil['perfil']);
                $objPerfilPaciente->setIndex_perfil($perfil['index_perfil']);
                $objPerfilPaciente->setCaractere($perfil['caractere']);
                $arr_perfis[]  = $objPerfilPaciente;
            }
            $preparoLote->setObjPerfil($arr_perfis);

            foreach ($array as $arr) {

                $objTubo = new Tubo();
                $objTubo->setIdTubo($arr['idTubo_fk']);
                $arr_tubos[] = $objTubo;


                //foreach ($arr_tubos as $tubo){
                $selectAmostras = 'select * from tb_amostra, tb_tubo where tb_amostra.idAmostra = tb_tubo.idAmostra_fk
                and tb_tubo.idTubo = ?';

                $arrayBind2 = array();
                $arrayBind2[] = array('i', $objTubo->getIdTubo());
                $array = $objBanco->consultarSQL($selectAmostras,$arrayBind2);

                $objAmostra = new Amostra();
                $objAmostra->setIdAmostra($array[0]['idAmostra']);
                $objAmostra->setCodigoAmostra($array[0]['codigoAmostra']);
                $objAmostra->setDataColeta($array[0]['dataColeta']);
                $objAmostra->setNickname($array[0]['nickname']);
                $objAmostra->setObjTubo($objTubo);
                $arr_amostras[] = $objAmostra;


            }
            $objLote->setObjsAmostras($arr_amostras);
            $objLote->setObjsTubo($arr_tubos);
            $preparoLote->setObjLote($objLote);

            return $preparoLote;
        } catch (Throwable $ex) {
            die($ex);
            throw new Excecao("Erro consultando o lote no BD.",$ex);
        }

    }


    public function remover_completamente(PreparoLote $objPreparoLote, Banco $objBanco) {

        try{
            // PERFIS ASSOCIADOS AO PREPARO LOTE
            $SELECT_IDS_PERFIL = 'select tb_rel_perfil_preparolote.idRelPerfilPreparoLote from tb_preparo_lote, tb_rel_perfil_preparolote where 
                                    tb_preparo_lote.idPreparoLote = ?
                                    and tb_rel_perfil_preparolote.idPreparoLote_fk = tb_preparo_lote.idPreparoLote';
            $arrayBind1 = array();
            $arrayBind1[] = array('i',$objPreparoLote->getIdPreparoLote());
            $array_perfis = $objBanco->consultarSQL($SELECT_IDS_PERFIL,$arrayBind1);

            foreach ($array_perfis as $perfil){
                $DELETE_PERFIL_PREPAROLOTE = 'DELETE FROM tb_rel_perfil_preparolote WHERE idRelPerfilPreparoLote = ? ';
                $arrayBindPERFIL = array();
                $arrayBindPERFIL[] = array('i',$perfil['idRelPerfilPreparoLote']);
                $objBanco->executarSQL($DELETE_PERFIL_PREPAROLOTE,$arrayBindPERFIL);
            }

            //TUBOS ASSOCIADOS AO PREPARO LOTE
            $SELECT_IDS_TUBOS = 'select DISTINCT tb_rel_tubo_lote.idRelTuboLote ,tb_rel_tubo_lote.idTubo_fk from tb_rel_tubo_lote, tb_lote where tb_lote.idLote = ?
                                    and tb_rel_tubo_lote.idLote_fk = tb_lote.idLote';
            $arrayBindTUBO = array();
            $arrayBindTUBO[] = array('i',$objPreparoLote->getIdLoteFk());
            $array_tubos = $objBanco->consultarSQL($SELECT_IDS_TUBOS,$arrayBindTUBO);
            foreach ($array_tubos as $tubo){

                $objInfosTubo = new InfosTubo();
                $objInfosTuboRN = new InfosTuboRN();
                $objInfosTubo->setIdTubo_fk($tubo['idTubo_fk']);
                $objInfosTubo = $objInfosTuboRN->pegar_ultimo($objInfosTubo);
                if($objInfosTubo->getSituacaoTubo() == InfosTuboRN::$TST_EM_UTILIZACAO) {
                    $DELETE_INFOSTUBO = 'DELETE FROM tb_infostubo WHERE idInfosTubo = ? ';
                    $arrayBindINFOS = array();
                    $arrayBindINFOS[] = array('i', $objInfosTubo->getIdInfosTubo());
                    $objBanco->executarSQL($DELETE_INFOSTUBO, $arrayBindINFOS);
                }

                $DELETE_TUBO_LOTE = 'DELETE FROM tb_rel_tubo_lote WHERE idRelTuboLote = ? ';
                $arrayBindTUBO_LOTE = array();
                $arrayBindTUBO_LOTE[] = array('i',$tubo['idRelTuboLote']);
                $objBanco->executarSQL($DELETE_TUBO_LOTE,$arrayBindTUBO_LOTE);
            }


            // LOTE
            $DELETE_LOTE = 'DELETE FROM tb_lote WHERE idLote = ? ';
            $arrayBindLOTE = array();
            $arrayBindLOTE[] = array('i',$objPreparoLote->getIdLoteFk());
            $objBanco->executarSQL($DELETE_LOTE,$arrayBindLOTE);

            $DELETE_PREPAROLOTE = 'DELETE FROM tb_preparo_lote WHERE idPreparoLote = ? ';
            $arrayBindPREPARO_LOTE = array();
            $arrayBindPREPARO_LOTE[] = array('i',$objPreparoLote->getIdPreparoLote());
            $objBanco->executarSQL($DELETE_PREPAROLOTE,$arrayBindPREPARO_LOTE);


        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo preparo do lote completamente no BD.",$ex);
        }
    }



}
