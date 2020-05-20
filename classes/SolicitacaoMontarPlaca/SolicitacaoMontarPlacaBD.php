<?php


class SolicitacaoMontarPlacaBD
{
    public function cadastrar(SolicitacaoMontarPlaca $objSolMontarPlaca, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO tb_solicitacao_montagem_placa_rtqpcr (
                            idPlaca_fk,
                            idUsuario_fk,
                            situacaoSolicitacao,
                            dataHoraFim,
                            dataHoraInicio
                            ) VALUES (?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objSolMontarPlaca->getIdPlacaFk());
            $arrayBind[] = array('i',$objSolMontarPlaca->getIdUsuarioFk());
            $arrayBind[] = array('s',$objSolMontarPlaca->getSituacaoSolicitacao());
            $arrayBind[] = array('s',$objSolMontarPlaca->getDataHoraFim());
            $arrayBind[] = array('s',$objSolMontarPlaca->getDataHoraInicio());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objSolMontarPlaca->setIdSolicitacaoMontarPlaca($objBanco->obterUltimoID());
            return $objSolMontarPlaca;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o relacionamento dos perfis com uma placa no BD.",$ex);
        }

    }

    public function alterar(SolicitacaoMontarPlaca $objSolMontarPlaca, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_solicitacao_montagem_placa_rtqpcr SET '
                . ' idPlaca_fk = ?,'
                . ' idUsuario_fk = ?,'
                . ' situacaoSolicitacao = ?,'
                . ' dataHoraFim = ?,'
                . ' dataHoraInicio = ?'
                . '  where idSolicitacaoMontarPlaca = ?';


            $arrayBind = array();
            $arrayBind[] = array('i',$objSolMontarPlaca->getIdPlacaFk());
            $arrayBind[] = array('i',$objSolMontarPlaca->getIdUsuarioFk());
            $arrayBind[] = array('s',$objSolMontarPlaca->getSituacaoSolicitacao());
            $arrayBind[] = array('s',$objSolMontarPlaca->getDataHoraFim());
            $arrayBind[] = array('s',$objSolMontarPlaca->getDataHoraInicio());

            $arrayBind[] = array('i',$objSolMontarPlaca->getIdSolicitacaoMontarPlaca());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objSolMontarPlaca;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o relacionamento dos perfis com uma placa no BD.",$ex);
        }

    }

    public function listar(SolicitacaoMontarPlaca $objSolMontarPlaca, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_solicitacao_montagem_placa_rtqpcr";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objSolMontarPlaca->getIdUsuarioFk() != null) {
                $WHERE .= $AND . " idUsuario_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objSolMontarPlaca->getIdUsuarioFk());
            }

            if ($objSolMontarPlaca->getIdSolicitacaoMontarPlaca() != null) {
                $WHERE .= $AND . " idSolicitacaoMontarPlaca = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objSolMontarPlaca->getIdSolicitacaoMontarPlaca());
            }

            if ($objSolMontarPlaca->getIdPlacaFk() != null) {
                $WHERE .= $AND . " idPlaca_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objSolMontarPlaca->getIdPlacaFk());

            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            //echo $SELECT.$WHERE;$WHERE

            $arr2 = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            $array = array();
            foreach ($arr2 as $reg){
                $solMontarPlaca = new SolicitacaoMontarPlaca();
                $solMontarPlaca->setIdSolicitacaoMontarPlaca($reg['idSolicitacaoMontarPlaca']);
                $solMontarPlaca->setIdPlacaFk($reg['idPlaca_fk']);
                $solMontarPlaca->setIdUsuarioFk($reg['idUsuario_fk']);
                $solMontarPlaca->setDataHoraInicio($reg['dataHoraInicio']);
                $solMontarPlaca->setDataHoraFim($reg['dataHoraFim']);
                $solMontarPlaca->setSituacaoSolicitacao($reg['situacaoSolicitacao']);


                $SELECT_USUARIO = 'SELECT matricula FROM tb_usuario WHERE idUsuario = ?';

                $arrayBindUsuario = array();
                $arrayBindUsuario[] = array('i',$reg['idUsuario_fk']);

                $arr = $objBanco->consultarSQL($SELECT_USUARIO,$arrayBindUsuario);

                $solMontarPlaca->setIdUsuarioFk($arr[0]['matricula']);


                if($reg['idPlaca_fk'] != null) {
                    $SELECT_PLACA = 'SELECT * FROM tb_placa WHERE idPlaca = ?';

                    $arrayBindPlaca = array();
                    $arrayBindPlaca[] = array('i', $reg['idPlaca_fk']);

                    $placa_arr = $objBanco->consultarSQL($SELECT_PLACA, $arrayBindPlaca);
                    //print_r($placa_arr);

                    $placa = new Placa();
                    $placa->setIdPlaca($placa_arr[0]['idPlaca']);
                    $placa->setPlaca($placa_arr[0]['placa']);
                    $placa->setIndexPlaca($placa_arr[0]['index_placa']);
                    $placa->setSituacaoPlaca($placa_arr[0]['situacaoPlaca']);
                    $placa->setIdProtocoloFk($placa_arr[0]['idProtocolo_fk']);

                    if($placa_arr[0]['idProtocolo_fk'] != null) {
                        $SELECT_PROTOCOLO = 'SELECT * FROM tb_protocolo WHERE idProtocolo = ?';

                        $arrayBindProtocolo = array();
                        $arrayBindProtocolo[] = array('i', $placa_arr[0]['idProtocolo_fk']);

                        $protocolo_arr = $objBanco->consultarSQL($SELECT_PROTOCOLO, $arrayBindProtocolo);

                        $protocolo = new Protocolo();
                        $protocolo->setIdProtocolo($protocolo_arr[0]['idProtocolo']);
                        $protocolo->setProtocolo($protocolo_arr[0]['protocolo']);
                        $protocolo->setIndexProtocolo($protocolo_arr[0]['index_protocolo']);
                        $protocolo->setNumMaxAmostras($protocolo_arr[0]['numMax_amostras']);
                        $protocolo->setCaractere($protocolo_arr[0]['caractere']);
                        $placa->setObjProtocolo($protocolo);

                    }
                    $solMontarPlaca->setObjPlaca($placa);

                    $SELECT_REL_TUBO_PLACA = 'SELECT * FROM tb_rel_tubo_placa WHERE idPlaca_fk = ?';

                    $arr_tubos_placas = $objBanco->consultarSQL($SELECT_REL_TUBO_PLACA,$arrayBindPlaca);
                    $arr_relacionamento = array();

                    $arr_amostras_sele = array();
                    foreach ($arr_tubos_placas as $tubos_placa) {
                        $tuboPlaca = new RelTuboPlaca();
                        $tuboPlaca->setIdRelTuboPlaca($tubos_placa['idRelTuboPlaca']);
                        $tuboPlaca->setIdPlacaFk($tubos_placa['idPlaca_fk']);
                        $tuboPlaca->setIdTuboFk($tubos_placa['idTubo_fk']);
                        $arr_relacionamento[] = $tuboPlaca;

                        $objTubo = new Tubo();
                        $objTubo->setIdTubo($tubos_placa['idTubo_fk']);

                        $SELECT_AMOSTRA = 'SELECT *  FROM tb_amostra,tb_tubo WHERE tb_tubo.idTubo = ? and tb_tubo.idAmostra_fk = tb_amostra.idAmostra';
                        $arrayBindAmostra = array();
                        $arrayBindAmostra[] = array('i', $tubos_placa['idTubo_fk']);

                        $arr = $objBanco->consultarSQL($SELECT_AMOSTRA, $arrayBindAmostra);


                            $objTubo = new Tubo();
                            $objTubo->setIdTubo($arr[0]['idTubo']);
                            $objTubo->setIdTubo_fk($arr[0]['idTubo_fk']);
                            $objTubo->setIdAmostra_fk($arr[0]['idAmostra_fk']);
                            $objTubo->setTuboOriginal($arr[0]['tuboOriginal']);
                            $objTubo->setTipo($arr[0]['tipo']);

                            $objAmostra = new Amostra();
                            $objAmostra->setIdAmostra($arr[0]['idAmostra']);
                            $objAmostra->setIdPaciente_fk($arr[0]['idPaciente_fk']);
                            $objAmostra->setIdCodGAL_fk($arr[0]['idCodGAL_fk']);
                            $objAmostra->setIdNivelPrioridade_fk($arr[0]['idNivelPrioridade_fk']);
                            $objAmostra->setIdPerfilPaciente_fk($arr[0]['idPerfilPaciente_fk']);
                            $objAmostra->setIdEstado_fk($arr[0]['cod_estado_fk']);
                            $objAmostra->setIdLugarOrigem_fk($arr[0]['cod_municipio_fk']);
                            $objAmostra->setObservacoes($arr[0]['observacoes']);
                            $objAmostra->setDataColeta($arr[0]['dataColeta']);
                            $objAmostra->set_a_r_g($arr[0]['a_r_g']);
                            $objAmostra->setHoraColeta($arr[0]['horaColeta']);
                            $objAmostra->setMotivoExame($arr[0]['motivo']);
                            $objAmostra->setCEP($arr[0]['CEP']);
                            $objAmostra->setCodigoAmostra($arr[0]['codigoAmostra']);
                            $objAmostra->setObsCEP($arr[0]['obsCEPAmostra']);
                            $objAmostra->setObsHoraColeta($arr[0]['obsHoraColeta']);
                            $objAmostra->setObsLugarOrigem($arr[0]['obsLugarOrigem']);
                            $objAmostra->setObsMotivo($arr[0]['obsMotivo']);
                            $objAmostra->setNickname($arr[0]['nickname']);
                            $objAmostra->setObjTubo($objTubo);



                            if($arr[0]['idPerfilPaciente_fk'] != null){

                                $SELECT_PERFIL_PACIENTE = "SELECT * FROM tb_perfilpaciente where idPerfilPaciente = ?";
                                $arrayBindPerfilPaciente = array();
                                $arrayBindPerfilPaciente[] = array('i',$arr[0]['idPerfilPaciente_fk']);
                                $perfilp = $objBanco->consultarSQL($SELECT_PERFIL_PACIENTE,$arrayBindPerfilPaciente);

                                $objPerfilPaciente = new PerfilPaciente();
                                $objPerfilPaciente->setIdPerfilPaciente($perfilp[0]['idPerfilPaciente']);
                                $objPerfilPaciente->setPerfil($perfilp[0]['perfil']);
                                $objPerfilPaciente->setIndex_perfil($perfilp[0]['index_perfil']);
                                $objPerfilPaciente->setCaractere($perfilp[0]['caractere']);
                                $objAmostra->setObjPerfil($objPerfilPaciente);
                            }

                        $arr_amostras_sele[] = $objAmostra;

                    }
                    $solMontarPlaca->setObjsAmostras($arr_amostras_sele);
                    $solMontarPlaca->setObjsRelTuboPlaca($arr_relacionamento);



                    $SELECT_REL_PERFIS_PLACA = 'SELECT * FROM tb_rel_perfil_placa WHERE idPlaca_fk = ?';

                    $arr_perfis_placa = $objBanco->consultarSQL($SELECT_REL_PERFIS_PLACA,$arrayBindPlaca);
                    $arr_perfis = array();

                    foreach ($arr_perfis_placa as $perfis){
                        $perfiPlaca = new RelPerfilPlaca();
                        $perfiPlaca->setIdRelPerfilPlaca($perfis['idRelPerfilPlaca']);
                        $perfiPlaca->setIdPlacaFk($perfis['idPlaca_fk']);
                        $perfiPlaca->setIdPerfilFk($perfis['idPerfil_fk']);
                        $arr_perfis[] = $perfiPlaca;
                    }
                    $solMontarPlaca->setObjsPerfis($arr_perfis);
                }




                $array[] = $solMontarPlaca;
            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o relacionamento dos perfis com uma placa no BD.",$ex);
        }

    }

    public function consultar(SolicitacaoMontarPlaca $objSolMontarPlaca, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_solicitacao_montagem_placa_rtqpcr WHERE idSolicitacaoMontarPlaca = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objSolMontarPlaca->getIdSolicitacaoMontarPlaca());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $solMontarPlaca = new SolicitacaoMontarPlaca();
            $solMontarPlaca->setIdSolicitacaoMontarPlaca($arr[0]['idSolicitacaoMontarPlaca']);
            $solMontarPlaca->setIdPlacaFk($arr[0]['idPlaca_fk']);
            $solMontarPlaca->setIdUsuarioFk($arr[0]['idUsuario_fk']);
            $solMontarPlaca->setDataHoraInicio($arr[0]['dataHoraInicio']);
            $solMontarPlaca->setDataHoraFim($arr[0]['dataHoraFim']);
            $solMontarPlaca->setSituacaoSolicitacao($arr[0]['situacaoSolicitacao']);


            return $solMontarPlaca;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando o relacionamento dos perfis com uma placa no BD.",$ex);
        }

    }

    public function remover(SolicitacaoMontarPlaca $objSolMontarPlaca, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_solicitacao_montagem_placa_rtqpcr WHERE idSolicitacaoMontarPlaca = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objSolMontarPlaca->getIdSolicitacaoMontarPlaca());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o relacionamento dos perfis com uma placa no BD.",$ex);
        }
    }

    public function remover_completamente(SolicitacaoMontarPlaca $objSolMontarPlaca, Banco $objBanco) {

        try{
            // PERFIS ASSOCIADOS A SOLICITACAO
            $SELECT_IDS_PERFIL = 'select tb_rel_perfil_placa.idRelPerfilPlaca from tb_placa, tb_rel_perfil_placa where 
                                    tb_rel_perfil_placa.idPlaca_fk = ?
                                    and tb_rel_perfil_placa.idPlaca_fk = tb_placa.idPlaca';
            $arrayBind1 = array();
            $arrayBind1[] = array('i',$objSolMontarPlaca->getIdPlacaFk());
            $array_perfis = $objBanco->consultarSQL($SELECT_IDS_PERFIL,$arrayBind1);

            foreach ($array_perfis as $perfil){
                $DELETE_PERFIL_PLACA = 'DELETE FROM tb_rel_perfil_placa WHERE idRelPerfilPlaca = ? ';
                $arrayBindPERFIL = array();
                $arrayBindPERFIL[] = array('i',$perfil['idRelPerfilPlaca']);
                $objBanco->executarSQL($DELETE_PERFIL_PLACA,$arrayBindPERFIL);
            }

            //TUBOS ASSOCIADOS A ESSA PLACA
            $SELECT_IDS_TUBOS = 'select DISTINCT tb_rel_tubo_placa.idRelTuboPlaca ,tb_rel_tubo_placa.idTubo_fk from tb_rel_tubo_placa, tb_placa where tb_placa.idPlaca = ?
                                    and tb_rel_tubo_placa.idPlaca_fk = tb_placa.idPlaca';
            $arrayBindTUBO = array();
            $arrayBindTUBO[] = array('i',$objSolMontarPlaca->getIdPlacaFk());
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

                $DELETE_TUBO_PLACA = 'DELETE FROM tb_rel_tubo_placa WHERE idRelTuboPlaca = ? ';
                $arrayBindTUBO_LOTE = array();
                $arrayBindTUBO_LOTE[] = array('i',$tubo['idRelTuboPlaca']);
                $objBanco->executarSQL($DELETE_TUBO_PLACA,$arrayBindTUBO_LOTE);
            }

            //deletar relacao poço placa
            $SELECT_POCO_PLACA = 'SELECT * FROM tb_pocos_placa WHERE idPlaca_fk = ?';

            $arrayBind1 = array();
            $arrayBind1[] = array('i',$objSolMontarPlaca->getIdPlacaFk());
            $array_pocos_placa = $objBanco->consultarSQL($SELECT_POCO_PLACA,$arrayBind1);

            foreach ($array_pocos_placa as $pocoplaca){
                $DELETE_POCO = 'DELETE FROM tb_poco WHERE idPoco = ? ';
                $arrayBindPoco = array();
                $arrayBindPoco[] = array('i',$pocoplaca['idPoco_fk']);
                $objBanco->executarSQL($DELETE_POCO, $arrayBindPoco);

                $DELETE_POCO_PLACA = 'DELETE FROM tb_pocos_placa WHERE idPocosPlaca = ? ';
                $arrayBindPocoPlaca = array();
                $arrayBindPocoPlaca[] = array('i',$pocoplaca['idPocosPlaca']);
                $objBanco->executarSQL($DELETE_POCO_PLACA, $arrayBindPocoPlaca);
            }






            $DELETE_SOLICITACAO = 'DELETE FROM tb_solicitacao_montagem_placa_rtqpcr WHERE idSolicitacaoMontarPlaca = ? ';
            $arrayBindPREPARO_LOTE = array();
            $arrayBindPREPARO_LOTE[] = array('i',$objSolMontarPlaca->getIdSolicitacaoMontarPlaca());
            $objBanco->executarSQL($DELETE_SOLICITACAO,$arrayBindPREPARO_LOTE);

            // PLACA
            $DELETE_PLACA = 'DELETE FROM tb_placa WHERE idPlaca = ? ';
            $arrayBindLOTE = array();
            $arrayBindLOTE[] = array('i',$objSolMontarPlaca->getIdPlacaFk());
            $objBanco->executarSQL($DELETE_PLACA,$arrayBindLOTE);




        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo a solicitação de montagem da placa completamente no BD.",$ex);
        }
    }
}