<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class AmostraBD{

    public function cadastrar(Amostra $objAmostra, Banco $objBanco) {
        try{
            //echo $objAmostra->getAmostra();
            $INSERT = 'INSERT INTO tb_amostra ('
                    . 'idPaciente_fk,'
                    . 'cod_estado_fk,'
                    . 'cod_municipio_fk,'
                    . 'idCodGAL_fk,'
                    . 'idNivelPrioridade_fk,'
                    . 'idPerfilPaciente_fk,'
                    . 'observacoes,'
                    . 'dataColeta,'
                    . 'a_r_g,'
                    . 'horaColeta,'
                    . 'motivo,'
                    . 'CEP,'
                    . 'codigoAmostra,'
                    . 'obsCEPAmostra,'
                    . 'obsHoraColeta,'
                    . 'obsLugarOrigem,'
                    . 'obsMotivo,'
                    . 'nickname'
                    . ')' 
                    . 'VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objAmostra->getIdPaciente_fk());
            $arrayBind[] = array('i',$objAmostra->getIdEstado_fk());
            $arrayBind[] = array('i',$objAmostra->getIdLugarOrigem_fk());
            $arrayBind[] = array('i',$objAmostra->getIdCodGAL_fk());
            $arrayBind[] = array('i',$objAmostra->getIdNivelPrioridade_fk());
            $arrayBind[] = array('i',$objAmostra->getIdPerfilPaciente_fk());
            $arrayBind[] = array('s',$objAmostra->getObservacoes());
            $arrayBind[] = array('s',$objAmostra->getDataColeta());
            $arrayBind[] = array('s',$objAmostra->get_a_r_g());
            $arrayBind[] = array('s',$objAmostra->getHoraColeta());
            $arrayBind[] = array('s',$objAmostra->getMotivoExame());
            $arrayBind[] = array('s',$objAmostra->getCEP());
            $arrayBind[] = array('s',$objAmostra->getCodigoAmostra());
            $arrayBind[] = array('s',$objAmostra->getObsCEP());
            $arrayBind[] = array('s',$objAmostra->getObsHoraColeta());
            $arrayBind[] = array('s',$objAmostra->getObsLugarOrigem());
            $arrayBind[] = array('s',$objAmostra->getObsMotivo());
            $arrayBind[] = array('s',$objAmostra->getNickname());
            
            
                        

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objAmostra->setIdAmostra($objBanco->obterUltimoID());
            return $objAmostra;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando a amostra no BD.",$ex);
        }

        
    }
    
    public function alterar(Amostra $objAmostra, Banco $objBanco) {
        try{
                      
            $UPDATE = 'UPDATE tb_amostra SET '
                    . 'idPaciente_fk =? ,'
                    . 'cod_estado_fk =?,'
                    . 'cod_municipio_fk =?,'
                    . 'idCodGAL_fk =?,'
                    . 'idNivelPrioridade_fk =?,'
                    . 'idPerfilPaciente_fk =?,'
                    . 'observacoes =?,'
                    . 'dataColeta =?,'
                    . 'a_r_g =?, '
                    . 'horaColeta =?,'
                    . 'motivo =?, '
                    . 'CEP  =?,'
                    . 'codigoAmostra =?,'
                    . 'obsCEPAmostra =?,'
                    . 'obsHoraColeta =?,'
                    . 'obsLugarOrigem =?,'
                    . 'obsMotivo =?,'
                    . 'nickname =?'
                . '  where idAmostra = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objAmostra->getIdPaciente_fk());
            $arrayBind[] = array('i',$objAmostra->getIdEstado_fk());
            $arrayBind[] = array('i',$objAmostra->getIdLugarOrigem_fk());
            $arrayBind[] = array('i',$objAmostra->getIdCodGAL_fk());
            $arrayBind[] = array('i',$objAmostra->getIdNivelPrioridade_fk());
            $arrayBind[] = array('i',$objAmostra->getIdPerfilPaciente_fk());
            $arrayBind[] = array('s',$objAmostra->getObservacoes());
            $arrayBind[] = array('s',$objAmostra->getDataColeta());
            $arrayBind[] = array('s',$objAmostra->get_a_r_g());
            $arrayBind[] = array('s',$objAmostra->getHoraColeta());
            $arrayBind[] = array('s',$objAmostra->getMotivoExame());
            $arrayBind[] = array('s',$objAmostra->getCEP());
            $arrayBind[] = array('s',$objAmostra->getCodigoAmostra());
            $arrayBind[] = array('s',$objAmostra->getObsCEP());
            $arrayBind[] = array('s',$objAmostra->getObsHoraColeta());
            $arrayBind[] = array('s',$objAmostra->getObsLugarOrigem());
            $arrayBind[] = array('s',$objAmostra->getObsMotivo());
            $arrayBind[] = array('s',$objAmostra->getNickname());
            
            $arrayBind[] = array('i',$objAmostra->getIdAmostra());
            

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objAmostra;
        } catch (Throwable $ex) {
            //die($ex);
            throw new Excecao("Erro alterando a amostra no BD.",$ex);
        }

       
    }
    
     public function listar(Amostra $objAmostra, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_amostra";
            
            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objAmostra->getCodigoAmostra() != null) {
                $WHERE .= $AND . " codigoAmostra = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objAmostra->getCodigoAmostra());
            }
            
            if ($objAmostra->get_a_r_g() != null) {
                $WHERE .= $AND . " a_r_g = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objAmostra->get_a_r_g());
            }

            if ($objAmostra->getDataColeta() != null) {
                $WHERE .= $AND . " dataColeta = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objAmostra->getDataColeta());
            }
            
            if ($objAmostra->getIdPerfilPaciente_fk() != null) {
                $WHERE .= $AND . " idPerfilPaciente_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objAmostra->getIdPerfilPaciente_fk());
            }
            
            if ($objAmostra->getIdPaciente_fk() != null) {
                $WHERE .= $AND . " idPaciente_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objAmostra->getIdPaciente_fk());
            }

             if ($objAmostra->getNickname() != null) {
                 $WHERE .= $AND . " nickname = ?";
                 $AND = ' and ';
                 $arrayBind[] = array('s', $objAmostra->getNickname());
             }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            //echo $SELECT.$WHERE;$WHERE

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);
            
          
 
            $array_paciente = array();
            foreach ($arr as $reg){
                $objAmostra = new Amostra();
                $objAmostra->setIdAmostra($reg['idAmostra']);
                $objAmostra->setIdPaciente_fk($reg['idPaciente_fk']);
                $objAmostra->setIdCodGAL_fk($reg['idCodGAL_fk']);
                $objAmostra->setIdNivelPrioridade_fk($reg['idNivelPrioridade_fk']);
                $objAmostra->setIdPerfilPaciente_fk($reg['idPerfilPaciente_fk']);
                $objAmostra->setIdEstado_fk($reg['cod_estado_fk']);
                $objAmostra->setIdLugarOrigem_fk($reg['cod_municipio_fk']);
                $objAmostra->setObservacoes($reg['observacoes']);
                $objAmostra->setDataColeta($reg['dataColeta']);
                $objAmostra->set_a_r_g($reg['a_r_g']);
                $objAmostra->setHoraColeta($reg['horaColeta']);
                $objAmostra->setMotivoExame($reg['motivo']);
                $objAmostra->setCEP($reg['CEP']);
                $objAmostra->setCodigoAmostra($reg['codigoAmostra']);
                $objAmostra->setObsCEP($reg['obsCEPAmostra']);
                $objAmostra->setObsHoraColeta($reg['obsHoraColeta']);
                $objAmostra->setObsLugarOrigem($reg['obsLugarOrigem']);
                $objAmostra->setObsMotivo($reg['obsMotivo']);
                $objAmostra->setNickname($reg['nickname']);
                
                

                $array_paciente[] = $objAmostra;
                
            }
            return $array_paciente;
        } catch (Throwable $ex) {
             die($ex);
            throw new Excecao("Erro listando a amostra no BD.",$ex);
        }
       
    }


    public function listar_aguardando_sol_montagem_placa_RTqCPR(Amostra $amostra, Banco $objBanco) {
        try{

            if($amostra->getObjPerfil() != null) {

                $interrogacoes = '';
                for ($i = 0; $i < count($amostra->getObjPerfil()); $i++) {
                    $interrogacoes .= '?,';
                }
                $interrogacoes = substr($interrogacoes, 0, -1);

                /* para cada um gerar o ultimo info tubo dos tubos gerados acima e que tenha como situação do tubo o 'aguardando RTqPCR' */
                $select2 = '   select distinct tb_infostubo.idTubo_fk 
                                    from tb_infostubo
                                    WHERE tb_infostubo.situacaoTubo = ?
                                    and tb_infostubo.etapa = ?';
                $arrayBind2 = array();
                $arrayBind2[] = array('s', InfosTuboRN::$TST_AGUARDANDO_SOLICITACAO_MONTAGEM_PLACA);
                $arrayBind2[] = array('s', InfosTuboRN::$TP_RTqPCR_SOLICITACAO__MONTAGEM_PLACA);

                $info = $objBanco->consultarSQL($select2, $arrayBind2);

                foreach ($info as $i) {
                    $objTubo = new Tubo();
                    $objTubo->setIdTubo($i['idTubo_fk']);

                    $SELECTINFOSTUBO = 'SELECT * from tb_infostubo where idInfosTubo = (select max(idInfosTubo) from tb_infostubo where idTubo_fk = ?)';
                    $arrayBind3 = array();
                    $arrayBind3[] = array('i', $i['idTubo_fk']);

                    $infos_completos = $objBanco->consultarSQL($SELECTINFOSTUBO, $arrayBind3);
                    //echo "<pre>";
                    //print_r($infos_completos);
                    //echo "</pre>";

                    if($infos_completos[0]['etapa'] == InfosTuboRN::$TP_RTqPCR_SOLICITACAO__MONTAGEM_PLACA && $infos_completos[0]['situacaoEtapa'] == InfosTuboRN::$TSP_AGUARDANDO) {

                        $SELECT_AMOSTRA = 'SELECT * from tb_amostra,tb_tubo where tb_amostra.idPerfilPaciente_fk in (' . $interrogacoes . ') 
                                        and tb_tubo.idAmostra_fk = tb_amostra.idAmostra
                                        and tb_tubo.idTubo = ?
                                        ';

                        $arrayBindA = array();

                        for ($i = 0; $i < count($amostra->getObjPerfil()); $i++) {
                            $arrayBindA[] = array('i', intval($amostra->getObjPerfil()[$i]));
                        }
                        $arrayBindA[] = array('i', $objTubo->getIdTubo());
                        //$arrayBindA[] = array('i', $amostra->getObjProtocolo()->getNumMaxAmostras());
                        $amostra_arr = $objBanco->consultarSQL($SELECT_AMOSTRA, $arrayBindA);

                        /*echo "<pre>";
                        print_r($amostra_arr);
                        echo "</pre>";*/
                        if(count($amostra_arr) > 0) {

                            $objAmostra = new Amostra();
                            $objAmostra->setIdAmostra($amostra_arr[0]['idAmostra']);
                            $objAmostra->setIdPaciente_fk($amostra_arr[0]['idPaciente_fk']);
                            $objAmostra->setIdCodGAL_fk($amostra_arr[0]['idCodGAL_fk']);
                            $objAmostra->setIdNivelPrioridade_fk($amostra_arr[0]['idNivelPrioridade_fk']);
                            $objAmostra->setIdPerfilPaciente_fk($amostra_arr[0]['idPerfilPaciente_fk']);
                            $objAmostra->setIdEstado_fk($amostra_arr[0]['cod_estado_fk']);
                            $objAmostra->setIdLugarOrigem_fk($amostra_arr[0]['cod_municipio_fk']);
                            $objAmostra->setObservacoes($amostra_arr[0]['observacoes']);
                            $objAmostra->setDataColeta($amostra_arr[0]['dataColeta']);
                            $objAmostra->set_a_r_g($amostra_arr[0]['a_r_g']);
                            $objAmostra->setHoraColeta($amostra_arr[0]['horaColeta']);
                            $objAmostra->setMotivoExame($amostra_arr[0]['motivo']);
                            $objAmostra->setCEP($amostra_arr[0]['CEP']);
                            $objAmostra->setCodigoAmostra($amostra_arr[0]['codigoAmostra']);
                            $objAmostra->setObsCEP($amostra_arr[0]['obsCEPAmostra']);
                            $objAmostra->setObsHoraColeta($amostra_arr[0]['obsHoraColeta']);
                            $objAmostra->setObsLugarOrigem($amostra_arr[0]['obsLugarOrigem']);
                            $objAmostra->setObsMotivo($amostra_arr[0]['obsMotivo']);
                            $objAmostra->setNickname($amostra_arr[0]['nickname']);


                            $objTubo = new Tubo();
                            $objTubo->setIdTubo($amostra_arr[0]['idTubo']);
                            $objTubo->setIdTubo_fk($amostra_arr[0]['idTubo_fk']);
                            $objTubo->setIdAmostra_fk($amostra_arr[0]['idAmostra_fk']);
                            $objTubo->setTuboOriginal($amostra_arr[0]['tuboOriginal']);
                            $objTubo->setTipo($amostra_arr[0]['tipo']);
                            $objAmostra->setObjTubo($objTubo);
                            $objAmostra->setObjProtocolo($amostra->getObjProtocolo());


                            $arr_amostras[] = $objAmostra;
                        }
                    }
                }
            }
            //die();



               /* $SELECT = "select disctinct * from tb_amostra, tb_tubo, tb_perfilpaciente
                            where tb_amostra.idAmostra not in (select idAmostra_fk from tb_laudo)
                            and tb_amostra.idAmostra = tb_tubo.idAmostra_fk
                            and tb_amostra.idPerfilPaciente_fk = tb_perfilpaciente.idPerfilPaciente
                            and tb_perfilpaciente.idPerfilPaciente in (".$interrogacoes.")
                            
                            order by tb_amostra.dataColeta
                            LIMIT ?";

                $arrayBind = array();
                for($i=0; $i<$amostra->getObjPerfil()[(count($amostra->getObjPerfil()) - 1)]; $i++){
                    $arrayBind[] = array('i', intval($amostra->getObjPerfil()[$i]));
                }
                //$arrayBind[] = array('s', TuboRN::$TT_RNA);
                $arrayBind[] = array('i', $amostra->getObjProtocolo()->getNumMaxAmostras());

                $arr = $objBanco->consultarSQL($SELECT, $arrayBind);


                $arr_amostras = array();
                foreach ($arr as $reg) {
                    /*$objAmostra = new Amostra();
                    $objAmostra->setIdAmostra($reg['idAmostra']);
                    $objAmostra->setIdPaciente_fk($reg['idPaciente_fk']);
                    $objAmostra->setIdCodGAL_fk($reg['idCodGAL_fk']);
                    $objAmostra->setIdNivelPrioridade_fk($reg['idNivelPrioridade_fk']);
                    $objAmostra->setIdPerfilPaciente_fk($reg['idPerfilPaciente_fk']);
                    $objAmostra->setIdEstado_fk($reg['cod_estado_fk']);
                    $objAmostra->setIdLugarOrigem_fk($reg['cod_municipio_fk']);
                    $objAmostra->setObservacoes($reg['observacoes']);
                    $objAmostra->setDataColeta($reg['dataColeta']);
                    $objAmostra->set_a_r_g($reg['a_r_g']);
                    $objAmostra->setHoraColeta($reg['horaColeta']);
                    $objAmostra->setMotivoExame($reg['motivo']);
                    $objAmostra->setCEP($reg['CEP']);
                    $objAmostra->setCodigoAmostra($reg['codigoAmostra']);
                    $objAmostra->setObsCEP($reg['obsCEPAmostra']);
                    $objAmostra->setObsHoraColeta($reg['obsHoraColeta']);
                    $objAmostra->setObsLugarOrigem($reg['obsLugarOrigem']);
                    $objAmostra->setObsMotivo($reg['obsMotivo']);
                    $objAmostra->setNickname($reg['nickname']);

                    $objPerfilPaciente = new PerfilPaciente();
                    $objPerfilPaciente->setIdPerfilPaciente($reg['idPerfilPaciente']);
                    $objPerfilPaciente->setPerfil($reg['perfil']);
                    $objPerfilPaciente->setIndex_perfil($reg['index_perfil']);
                    $objPerfilPaciente->setCaractere($reg['caractere']);
                    $objAmostra->setObjPerfil($objPerfilPaciente);

                    $objTubo = new Tubo();
                    $objTubo->setIdTubo($reg['idTubo']);
                    $objTubo->setIdTubo_fk($reg['idTubo_fk']);
                    $objTubo->setIdAmostra_fk($reg['idAmostra_fk']);
                    $objTubo->setTuboOriginal($reg['tuboOriginal']);
                    $objTubo->setTipo($reg['tipo']);



                    $objAmostra->setObjTubo($objTubo);
                    $objAmostra->setObjProtocolo($amostra->getObjProtocolo());



                    $arr_amostras[] = $objAmostra;

                }
            }*/
            return $arr_amostras;
        } catch (Throwable $ex) {
            die($ex);
            throw new Excecao("Erro listando a amostra no BD.",$ex);
        }

    }



    public function obter_infos(Amostra $objAmostra, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_tubo, tb_amostra 
                        where tb_amostra.nickname = ? and tb_amostra.idAmostra = tb_tubo.idAmostra_fk";

            $arrayBind = array();
            $arrayBind[] = array('s', $objAmostra->getNickname());

            $arr_tubos = $objBanco->consultarSQL($SELECT, $arrayBind);

            foreach ($arr_tubos as $reg){

                $objTubo = new Tubo();
                $objTubo->setIdTubo($reg['idTubo']);
                $objTubo->setIdTubo_fk($reg['idTubo_fk']);
                $objTubo->setTipo($reg['tipo']);
                $objTubo->setTuboOriginal($reg['tuboOriginal']);

                $SELECT1 = "SELECT  DISTINCT
                                tb_infostubo.idInfostubo,
                                tb_infostubo.idTubo_fk,
                                tb_infostubo.etapa,
                                tb_infostubo.etapaAnterior,
                                tb_infostubo.situacaoTubo,
                                tb_infostubo.situacaoEtapa,
                                tb_infostubo.dataHora,
                                tb_infostubo.volume,
                                tb_infostubo.reteste
                                
                                
                                FROM tb_infostubo
                                where
                                 tb_infostubo.idTubo_fk = ?
                                
                                order by tb_infostubo.idInfostubo";

                $arrayBind1 = array();
                $arrayBind1[] = array('i', $reg['idTubo']);

                $arr_infos = $objBanco->consultarSQL($SELECT1, $arrayBind1);
                $arr_infostubo = array();
                foreach ($arr_infos as $info) {
                    $objInfosTubo = new InfosTubo();
                    $objInfosTubo->setIdInfosTubo($info['idInfostubo']);
                    $objInfosTubo->setIdTubo_fk($reg['idTubo']);
                    $objInfosTubo->setEtapa($info['etapa']);
                    $objInfosTubo->setEtapaAnterior($info['etapaAnterior']);
                    $objInfosTubo->setSituacaoTubo($info['situacaoTubo']);
                    $objInfosTubo->setSituacaoEtapa($info['situacaoEtapa']);
                    $objInfosTubo->setDataHora($info['dataHora']);
                    $objInfosTubo->setReteste($info['reteste']);
                    $objInfosTubo->setVolume($info['volume']);
                    $arr_infostubo[] = $objInfosTubo;
                }
                $objTubo->setObjInfosTubo($arr_infostubo);

                $array_retorno[] = $objTubo;

            }
            return $array_retorno;
        } catch (Throwable $ex) {
            die($ex);
            throw new Excecao("Erro listando a amostra no BD.",$ex);
        }

    }

    public function obter_locais(Amostra $objAmostra, Banco $objBanco) {
        try{

            $SELECT = "select tb_tubo.idTubo,tb_tubo.tipo from tb_amostra,tb_tubo
                            where tb_amostra.idAmostra = tb_tubo.idAmostra_fk 
                            and tb_amostra.nickname = ?
                             ";

            $arrayBind = array();
            $arrayBind[] = array('s', $objAmostra->getNickname());
            $arr_tubos = $objBanco->consultarSQL($SELECT, $arrayBind);

            foreach ($arr_tubos as $reg){

                $objTubo = new Tubo();
                $objTubo->setIdTubo($reg['idTubo']);
                $objTubo->setTipo($reg['tipo']);

                $select2 = '    SELECT idLocal_fk from tb_infostubo where idInfosTubo = (select max(idInfosTubo) from tb_infostubo where idTubo_fk = ?)
                                     ';
                $arrayBind2 = array();
                $arrayBind2[] = array('i', $reg['idTubo']);

                $local = $objBanco->consultarSQL($select2, $arrayBind2);
                $localTxt = new LocalArmazenamentoTexto();
                if($local[0]['idLocal_fk'] != null){

                    $SELECT2 = 'SELECT *  FROM tb_local_armazenamento_texto WHERE idLocal = ?';

                    $arrayBind3 = array();
                    $arrayBind3[] = array('i',$local[0]['idLocal_fk']);

                    $arr = $objBanco->consultarSQL($SELECT2,$arrayBind3);


                    $localTxt->setIdLocal($arr[0]['idLocal']);
                    $localTxt->setNome($arr[0]['nome']);
                    $localTxt->setIdTipoLocal($arr[0]['idTipoLocal']);
                    $localTxt->setPorta($arr[0]['porta']);
                    $localTxt->setPrateleira($arr[0]['prateleira']);
                    $localTxt->setColuna($arr[0]['coluna']);
                    $localTxt->setCaixa($arr[0]['caixa']);
                    $localTxt->setPosicao($arr[0]['posicao']);


                    $SELECT_TIPO_LOCAL = 'SELECT * FROM tb_tipo_localarmazenamento WHERE idTipoLocalArmazenamento = ?';

                    $arrayBind4 = array();
                    $arrayBind4[] = array('i',$arr[0]['idTipoLocal']);

                    $tipoLocal = $objBanco->consultarSQL($SELECT_TIPO_LOCAL,$arrayBind4);

                    $tipoLocalArm = new TipoLocalArmazenamento();
                    $tipoLocalArm->setIdTipoLocalArmazenamento($tipoLocal[0]['idTipoLocalArmazenamento']);
                    $tipoLocalArm->setTipo($tipoLocal[0]['tipo']);
                    $tipoLocalArm->setIndexTipo($tipoLocal[0]['index_tipo']);
                    $tipoLocalArm->setCaractereTipo($tipoLocal[0]['caractereTipo']);
                    $localTxt->setObjTipoLocal($tipoLocalArm);
                }

                $objTubo->setObjLocal($localTxt);

                $array_retorno[] = $objTubo;

            }
            return $array_retorno;
        } catch (Throwable $ex) {
            //die($ex);
            throw new Excecao("Erro listando a amostra no BD.",$ex);
        }

    }

    public function listar_especial(Amostra $objAmostra, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_amostra ";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objAmostra->getCodigoAmostra() != null) {
                $WHERE .= $AND . " codigoAmostra = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objAmostra->getCodigoAmostra());
            }

            if ($objAmostra->getIdAmostra() != null) {
                $WHERE .= $AND . " idAmostra >= ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objAmostra->getIdAmostra());
            }

            if ($objAmostra->get_a_r_g() != null) {
                $WHERE .= $AND . " a_r_g = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objAmostra->get_a_r_g());
            }

            if ($objAmostra->getDataColeta() != null) {
                $WHERE .= $AND . " dataColeta = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objAmostra->getDataColeta());
            }

            if ($objAmostra->getIdPerfilPaciente_fk() != null) {
                $WHERE .= $AND . " idPerfilPaciente_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objAmostra->getIdPerfilPaciente_fk());
            }

            if ($objAmostra->getIdPaciente_fk() != null) {
                $WHERE .= $AND . " idPaciente_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objAmostra->getIdPaciente_fk());
            }




            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }



            $arr = $objBanco->consultarSQL($SELECT . $WHERE." LIMIT 20 ", $arrayBind);



            $array_paciente = array();
            foreach ($arr as $reg){
                $objAmostra = new Amostra();
                $objAmostra->setIdAmostra($reg['idAmostra']);
                $objAmostra->setIdPaciente_fk($reg['idPaciente_fk']);
                $objAmostra->setIdCodGAL_fk($reg['idCodGAL_fk']);
                $objAmostra->setIdNivelPrioridade_fk($reg['idNivelPrioridade_fk']);
                $objAmostra->setIdPerfilPaciente_fk($reg['idPerfilPaciente_fk']);
                $objAmostra->setIdEstado_fk($reg['cod_estado_fk']);
                $objAmostra->setIdLugarOrigem_fk($reg['cod_municipio_fk']);
                $objAmostra->setObservacoes($reg['observacoes']);
                $objAmostra->setDataColeta($reg['dataColeta']);
                $objAmostra->set_a_r_g($reg['a_r_g']);
                $objAmostra->setHoraColeta($reg['horaColeta']);
                $objAmostra->setMotivoExame($reg['motivo']);
                $objAmostra->setCEP($reg['CEP']);
                $objAmostra->setCodigoAmostra($reg['codigoAmostra']);
                $objAmostra->setObsCEP($reg['obsCEPAmostra']);
                $objAmostra->setObsHoraColeta($reg['obsHoraColeta']);
                $objAmostra->setObsLugarOrigem($reg['obsLugarOrigem']);
                $objAmostra->setObsMotivo($reg['obsMotivo']);
                $objAmostra->setNickname($reg['nickname']);



                $array_paciente[] = $objAmostra;

            }
            return $array_paciente;
        } catch (Throwable $ex) {
            die($ex);
            throw new Excecao("Erro listando a amostra no BD.",$ex);
        }

    }
    
    public function consultar(Amostra $objAmostra, Banco $objBanco) {

        try{

            $SELECT = 'SELECT *  FROM tb_amostra WHERE idAmostra = ?';


            $arrayBind = array();
            $arrayBind[] = array('i',$objAmostra->getIdAmostra());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            if(count($arr) > 0){
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
                return $objAmostra;
            }
            return null;
            
        } catch (Throwable $ex) {
            die($ex);
       
            throw new Excecao("Erro consultando a amostra no BD.",$ex);
        }

    }
    
    public function remover(Amostra $objAmostra, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_amostra WHERE idAmostra = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objAmostra->getIdAmostra());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Throwable $ex) {
            //die($ex);
            throw new Excecao("Erro removendo a amostra no BD.",$ex);
        }
    }

    public function alterar_nickname(Amostra $objAmostra, Banco $objBanco){
        $SELECT = 'SELECT nickname FROM tb_amostra where idPerfilPaciente_fk = ? order by nickname desc limit 1 for update';

        $arrayBind = array();
        $arrayBind[] = array('i',$objAmostra->getIdPerfilPaciente_fk());

        $registro = $objBanco->consultarSql($SELECT,$arrayBind);
        if(count($registro) > 0) {
            return substr($registro[0]['nickname'], 1);
        }else{
            return 0;
        }



    }

    public function validar_nickname(Amostra $objAmostra, Banco $objBanco){
        $SELECT = 'SELECT idAmostra from tb_amostra where nickname = ? ';

        $AND = '';

        $arrayBind = array();
        $arrayBind[] = array('s',$objAmostra->getNickname());
        if ($objAmostra->getIdAmostra() != null) {
            $AND .= "AND  idAmostra != ?";
            $arrayBind[] = array('i', $objAmostra->getIdAmostra());
        }

        $nick = $objAmostra->getNickname();

        //$arrayBind[] = array('i',$objAmostra->getIdAmostra());

        $registro = $objBanco->consultarSql($SELECT.$AND.' limit 1',$arrayBind);

        return $registro[0]['idAmostra'];


    }

    public function filtro_menor_data(Amostra $objAmostra,$select, Banco $objBanco) {
        try{


            $SELECT = "SELECT * FROM tb_amostra ";
            $WHERE = '';
            $AND = '';
            $OR = '';
            $arrayBind = array();


            foreach ($select as $s) {
                    $WHERE .= $OR . " idPerfilPaciente_fk = ?";
                    $OR = ' OR ';
                    $arrayBind[] = array('i', $s->getIdPerfilPaciente());

            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            $ORDERBY =' order by dataColeta';
            //echo $SELECT.$WHERE.$ORDERBY;
            //print_r($arrayBind);

            $arr = $objBanco->consultarSQL($SELECT . $WHERE.$ORDERBY, $arrayBind);
            //print_r($arr);
            // die();
            if(count($arr) > 0) {
                $array_paciente = array();
                foreach ($arr as $reg) {
                    $objAmostra = new Amostra();
                    $objAmostra->setIdAmostra($reg['idAmostra']);
                    $objAmostra->setIdPaciente_fk($reg['idPaciente_fk']);
                    $objAmostra->setIdCodGAL_fk($reg['idCodGAL_fk']);
                    $objAmostra->setIdNivelPrioridade_fk($reg['idNivelPrioridade_fk']);
                    $objAmostra->setIdPerfilPaciente_fk($reg['idPerfilPaciente_fk']);
                    $objAmostra->setIdEstado_fk($reg['cod_estado_fk']);
                    $objAmostra->setIdLugarOrigem_fk($reg['cod_municipio_fk']);
                    $objAmostra->setObservacoes($reg['observacoes']);
                    $objAmostra->setDataColeta($reg['dataColeta']);
                    $objAmostra->set_a_r_g($reg['a_r_g']);
                    $objAmostra->setHoraColeta($reg['horaColeta']);
                    $objAmostra->setMotivoExame($reg['motivo']);
                    $objAmostra->setCEP($reg['CEP']);
                    $objAmostra->setCodigoAmostra($reg['codigoAmostra']);
                    $objAmostra->setObsCEP($reg['obsCEPAmostra']);
                    $objAmostra->setObsHoraColeta($reg['obsHoraColeta']);
                    $objAmostra->setObsLugarOrigem($reg['obsLugarOrigem']);
                    $objAmostra->setObsMotivo($reg['obsMotivo']);
                    $objAmostra->setNickname($reg['nickname']);

                    $array_paciente[] = $objAmostra;

                }
                return $array_paciente;
            }
            return null;
        } catch (Throwable $ex) {
            //die($ex);
            throw new Excecao("Erro listando a amostra no BD.",$ex);
        }

    }


    public function filtrar_por_quantidade(Amostra $objAmostra, Banco $objBanco) {
        try{

            //print_r($objAmostra);
            $SELECT = 'SELECT * FROM tb_amostra where idAmostra = ? LIMIT 20 ';

            $arrayBind = array();
            $arrayBind[] = array('i', $objAmostra->getIdAmostra());


            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);
            //print_r($arr);
            // die();
            if(count($arr) > 0) {
                $array_paciente = array();
                foreach ($arr as $reg) {
                    $objAmostra = new Amostra();
                    $objAmostra->setIdAmostra($reg['idAmostra']);
                    $objAmostra->setIdPaciente_fk($reg['idPaciente_fk']);
                    $objAmostra->setIdCodGAL_fk($reg['idCodGAL_fk']);
                    $objAmostra->setIdNivelPrioridade_fk($reg['idNivelPrioridade_fk']);
                    $objAmostra->setIdPerfilPaciente_fk($reg['idPerfilPaciente_fk']);
                    $objAmostra->setIdEstado_fk($reg['cod_estado_fk']);
                    $objAmostra->setIdLugarOrigem_fk($reg['cod_municipio_fk']);
                    $objAmostra->setObservacoes($reg['observacoes']);
                    $objAmostra->setDataColeta($reg['dataColeta']);
                    $objAmostra->set_a_r_g($reg['a_r_g']);
                    $objAmostra->setHoraColeta($reg['horaColeta']);
                    $objAmostra->setMotivoExame($reg['motivo']);
                    $objAmostra->setCEP($reg['CEP']);
                    $objAmostra->setCodigoAmostra($reg['codigoAmostra']);
                    $objAmostra->setObsCEP($reg['obsCEPAmostra']);
                    $objAmostra->setObsHoraColeta($reg['obsHoraColeta']);
                    $objAmostra->setObsLugarOrigem($reg['obsLugarOrigem']);
                    $objAmostra->setObsMotivo($reg['obsMotivo']);
                    $objAmostra->setNickname($reg['nickname']);

                    $array_paciente[] = $objAmostra;

                }
                return $array_paciente;
            }
            return null;
        } catch (Throwable $ex) {
            die($ex);
            throw new Excecao("Erro listando a amostra no BD.",$ex);
        }

    }


    public function listar_ids(Amostra $objAmostra, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_amostra";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objAmostra->getCodigoAmostra() != null) {
                $WHERE .= $AND . " codigoAmostra = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objAmostra->getCodigoAmostra());
            }

            if ($objAmostra->get_a_r_g() != null) {
                $WHERE .= $AND . " a_r_g = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objAmostra->get_a_r_g());
            }

            if ($objAmostra->getDataColeta() != null) {
                $WHERE .= $AND . " dataColeta = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objAmostra->getDataColeta());
            }

            if ($objAmostra->getIdPerfilPaciente_fk() != null) {
                $WHERE .= $AND . " idPerfilPaciente_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objAmostra->getIdPerfilPaciente_fk());
            }

            if ($objAmostra->getIdPaciente_fk() != null) {
                $WHERE .= $AND . " idPaciente_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objAmostra->getIdPaciente_fk());
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            //echo $SELECT.$WHERE;$WHERE

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);



            $array_paciente = array();
            foreach ($arr as $reg){
                $objAmostra = new Amostra();
                $objAmostra->setIdAmostra($reg['idAmostra']);
                $objAmostra->setIdPaciente_fk($reg['idPaciente_fk']);
                $objAmostra->setIdCodGAL_fk($reg['idCodGAL_fk']);
                $objAmostra->setIdNivelPrioridade_fk($reg['idNivelPrioridade_fk']);
                $objAmostra->setIdPerfilPaciente_fk($reg['idPerfilPaciente_fk']);
                $objAmostra->setIdEstado_fk($reg['cod_estado_fk']);
                $objAmostra->setIdLugarOrigem_fk($reg['cod_municipio_fk']);
                $objAmostra->setObservacoes($reg['observacoes']);
                $objAmostra->setDataColeta($reg['dataColeta']);
                $objAmostra->set_a_r_g($reg['a_r_g']);
                $objAmostra->setHoraColeta($reg['horaColeta']);
                $objAmostra->setMotivoExame($reg['motivo']);
                $objAmostra->setCEP($reg['CEP']);
                $objAmostra->setCodigoAmostra($reg['codigoAmostra']);
                $objAmostra->setObsCEP($reg['obsCEPAmostra']);
                $objAmostra->setObsHoraColeta($reg['obsHoraColeta']);
                $objAmostra->setObsLugarOrigem($reg['obsLugarOrigem']);
                $objAmostra->setObsMotivo($reg['obsMotivo']);
                $objAmostra->setNickname($reg['nickname']);



                $array_paciente[] = $objAmostra;

            }
            return $array_paciente;
        } catch (Throwable $ex) {
            die($ex);
            throw new Excecao("Erro listando a amostra no BD.",$ex);
        }

    }


    public function arrumar_banco1(Amostra $objAmostra, Banco $objBanco)
    {
        try {


            //$SELECT = "select idAmostra, a_r_g,idPerfilPaciente_fk from tb_amostra ";
            $SELECT = "select tb_tubo.idTubo, tb_amostra.idAmostra,tb_amostra.a_r_g from tb_tubo,tb_amostra where tb_tubo.idTubo not in (select idTubo_fk from tb_infostubo) and tb_tubo.idAmostra_fk= tb_amostra.idAmostra and tb_amostra.a_r_g != 'g'";
            $arr = $objBanco->consultarSQL($SELECT);
            //print_r($arr);
            die();
            foreach ($arr as $reg) {
                /*echo "aqui";
                $objAmostra->setIdAmostra($reg['idAmostra']);
                $objAmostraRN = new AmostraRN();
                $objAmostra = $objAmostraRN->consultar($objAmostra);
                print_r($objAmostra);
                if($reg['idPerfilPaciente_fk'] == 1){
                    $objAmostra->setCodigoAmostra('S'.$reg['idAmostra']);
                }
                if($reg['idPerfilPaciente_fk'] == 2){
                    $objAmostra->setCodigoAmostra('V'.$reg['idAmostra']);
                }
                if($reg['idPerfilPaciente_fk'] == 3){
                    $objAmostra->setCodigoAmostra('L'.$reg['idAmostra']);
                }
                if($reg['idPerfilPaciente_fk'] == 4){
                    $objAmostra->setCodigoAmostra('E'.$reg['idAmostra']);
                }
                if($reg['idPerfilPaciente_fk'] == 5){
                    $objAmostra->setCodigoAmostra('O'.$reg['idAmostra']);
                }

                $objAmostraBD = new AmostraBD();
                $objAmostraBD->alterar($objAmostra, $objBanco);*/


                if ($reg['a_r_g'] == 'a' || $reg['a_r_g'] == 'r') {
                    /*$objTubo = new Tubo();
                    $objTubo->setIdAmostra_fk($reg['idAmostra']);
                    $objTubo->setTuboOriginal('s');
                    $objTubo->setTipo(TuboRN::$TT_COLETA);
                    $objTuboRN = new TuboRN();
                    $objTubo = $objTuboRN->cadastrar($objTubo);*/


                    $objInfosTubo = new InfosTubo();
                    $objInfosTuboRN = new InfosTuboRN();
                    $objInfosTubo->setIdTubo_fk($reg['idTubo']);
                    $objInfosTubo->setVolume(0);
                    $objInfosTubo->setReteste('n');
                    $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                    $objInfosTubo->setIdUsuario_fk(2);
                    if ($reg['a_r_g'] == 'a') {
                        $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_SEM_UTILIZACAO);
                        $objInfosTubo->setEtapa(InfosTuboRN::$TP_RECEPCAO);
                        $objInfosTubo->setEtapaAnterior(null);
                        $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                        $objInfosTubo = $objInfosTuboRN->cadastrar($objInfosTubo);
                        //print_r($objInfosTubo);

                        $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_SEM_UTILIZACAO);
                        $objInfosTubo->setEtapa(InfosTuboRN::$TP_MONTAGEM_GRUPOS_AMOSTRAS);
                        $objInfosTubo->setEtapaAnterior(InfosTuboRN::$TP_RECEPCAO);
                        $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                        $objInfosTubo = $objInfosTuboRN->cadastrar($objInfosTubo);
                        //$arr_infos[] = $objInfosTubo;

                        //print_r($objInfosTubo);


                    } else if ($reg['a_r_g'] == 'r') {
                        $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_DESCARTADO);
                        $objInfosTubo->setEtapa(InfosTuboRN::$TP_RECEPCAO);
                        $objInfosTubo->setEtapaAnterior(null);
                        $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                        $objInfosTubo = $objInfosTuboRN->cadastrar($objInfosTubo);
                        //$arr_infos[] = $objInfosTubo;

                        $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_DESCARTADO);
                        $objInfosTubo->setEtapa(InfosTuboRN::$TP_LAUDO);
                        $objInfosTubo->setEtapaAnterior(InfosTuboRN::$TP_RECEPCAO);
                        $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                        $objInfosTubo = $objInfosTuboRN->cadastrar($objInfosTubo);
                    }
                    //$objTubo->setObjInfosTubo($arr_infos);

                }


            }

            return null;
        } catch (Throwable $ex) {
            die($ex);
            throw new Excecao("Erro listando a amostra no BD.", $ex);
        }
    }


    public function arrumar_banco_nicks(Amostra $objAmostra, Banco $objBanco)
    {
        try {


            $SELECT = "select * from tb_amostra  where idPerfilPaciente_fk = 3";

            $arr = $objBanco->consultarSQL($SELECT);
            //print_r($arr);

            foreach ($arr as $reg) {
                $valores  = explode("L", $reg['nickname']);
                echo "\n";
                if($valores[1] >= 425){
                    print_r(($valores[1] + 2000));
                    $objAmostra = new Amostra();
                    $objAmostra->setIdAmostra($reg['idAmostra']);
                    $objAmostra->setIdPaciente_fk($reg['idPaciente_fk']);
                    $objAmostra->setIdCodGAL_fk($reg['idCodGAL_fk']);
                    $objAmostra->setIdNivelPrioridade_fk($reg['idNivelPrioridade_fk']);
                    $objAmostra->setIdPerfilPaciente_fk($reg['idPerfilPaciente_fk']);
                    $objAmostra->setIdEstado_fk($reg['cod_estado_fk']);
                    $objAmostra->setIdLugarOrigem_fk($reg['cod_municipio_fk']);
                    $objAmostra->setObservacoes($reg['observacoes']);
                    $objAmostra->setDataColeta($reg['dataColeta']);
                    $objAmostra->set_a_r_g($reg['a_r_g']);
                    $objAmostra->setHoraColeta($reg['horaColeta']);
                    $objAmostra->setMotivoExame($reg['motivo']);
                    $objAmostra->setCEP($reg['CEP']);
                    $objAmostra->setCodigoAmostra($reg['codigoAmostra']);
                    $objAmostra->setObsCEP($reg['obsCEPAmostra']);
                    $objAmostra->setObsHoraColeta($reg['obsHoraColeta']);
                    $objAmostra->setObsLugarOrigem($reg['obsLugarOrigem']);
                    $objAmostra->setObsMotivo($reg['obsMotivo']);
                    $objAmostra->setNickname("L" . ($valores[1] + 2000));
                    print_r($objAmostra);
                    $objAmostraRN = new AmostraRN();
                    $objAmostraRN->alterar($objAmostra);
                }

            }
            return null;
        } catch (Throwable $ex) {
            die($ex);
            throw new Excecao("Erro listando a amostra no BD.", $ex);
        }
    }

    public function arrumar_banco2(Amostra $objAmostra, Banco $objBanco)
    {
        try {

            $SELECT = "SELECT tb_amostra.idAmostra, tb_amostra.idPerfilPaciente_fk,tb_perfilpaciente.caractere FROM 
                    tb_amostra, tb_perfilpaciente 
                    where tb_amostra.idPerfilPaciente_fk = tb_perfilpaciente.idPerfilPaciente  ";

            $arr = $objBanco->consultarSQL($SELECT);

            foreach ($arr as $reg) {
                $objAmostra = new Amostra();
                $objAmostraRN = new AmostraRN();
                $objAmostra->setIdAmostra($reg['idAmostra']);
                $objAmostra = $objAmostraRN->consultar($objAmostra);
                $objAmostra->setCodigoAmostra($reg['caractere'].$reg['idAmostra']);
                $objAmostraRN->alterar($objAmostra);

            }

            return null;
        } catch (Throwable $ex) {
            die($ex);
            throw new Excecao("Erro listando a amostra no BD.", $ex);
        }
    }

    public function arrumar_banco(Amostra $objAmostra, Banco $objBanco)
    {
        try {

            $SELECT = "select DISTINCT tb_amostra.idAmostra,tb_amostra.a_r_g,tb_tubo.idTubo, tb_cadastroamostra.idUsuario_fk 
                        from tb_amostra,tb_tubo ,tb_cadastroamostra 
                        where idAmostra in (SELECT idAmostra_fk FROM tb_tubo WHERE idTubo NOT IN (SELECT idTubo_fk FROM tb_infostubo)) 
                        and tb_amostra.idAmostra = tb_tubo.idAmostra_fk 
                        and tb_cadastroamostra.idAmostra_fk = tb_amostra.idAmostra
                        and tb_amostra.a_r_g != 'g' ";

            $arr = $objBanco->consultarSQL($SELECT);
            //print_r($arr);
            //die();
            foreach ($arr as $reg) {
                $objAmostra = new Amostra();
                $objAmostra->setIdAmostra($reg['idAmostra']);
                $objAmostra->set_a_r_g($reg['a_r_g']);

                $objInfosTubo = new InfosTubo();
                $objInfosTuboRN = new InfosTuboRN();
                $objInfosTubo->setIdTubo_fk($reg['idTubo']);
                $objInfosTubo->setVolume(0);
                $objInfosTubo->setReteste('n');
                $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                $objInfosTubo->setIdUsuario_fk($reg['idUsuario_fk']);
                if ($reg['a_r_g'] == 'a') {
                    $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_SEM_UTILIZACAO);
                    $objInfosTubo->setEtapa(InfosTuboRN::$TP_RECEPCAO);
                    $objInfosTubo->setEtapaAnterior(null);
                    $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                    $objInfosTubo = $objInfosTuboRN->cadastrar($objInfosTubo);

                    $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_SEM_UTILIZACAO);
                    $objInfosTubo->setEtapa(InfosTuboRN::$TP_MONTAGEM_GRUPOS_AMOSTRAS);
                    $objInfosTubo->setEtapaAnterior(InfosTuboRN::$TP_RECEPCAO);
                    $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                    $objInfosTubo = $objInfosTuboRN->cadastrar($objInfosTubo);


                } else if ($reg['a_r_g'] == 'r') {
                    $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_DESCARTADO);
                    $objInfosTubo->setEtapa(InfosTuboRN::$TP_RECEPCAO);
                    $objInfosTubo->setEtapaAnterior(null);
                    $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_FINALIZADO);
                    $objInfosTubo = $objInfosTuboRN->cadastrar($objInfosTubo);

                    $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_DESCARTADO);
                    $objInfosTubo->setEtapa(InfosTuboRN::$TP_LAUDO);
                    $objInfosTubo->setEtapaAnterior(InfosTuboRN::$TP_RECEPCAO);
                    $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                    $objInfosTubo = $objInfosTuboRN->cadastrar($objInfosTubo);

                }
            }

            return null;
        } catch (Throwable $ex) {
            die($ex);
            throw new Excecao("Erro listando a amostra no BD.", $ex);
        }
    }


    public function arrumar_banco3(Amostra $objAmostra, Banco $objBanco)
    {
        try {

            $SELECT = "SELECT * FROM `tb_infostubo` WHERE situacaoTubo = 'D'"; //todos os tubos descartados


            $arr = $objBanco->consultarSQL($SELECT);

            foreach ($arr as $reg) {
                $objInfosTubo = new InfosTubo();
                $objInfosTubo->setIdInfosTubo($reg['idInfosTubo']);
                $objInfosTubo->setIdUsuario_fk($reg['idUsuario_fk']);
                $objInfosTubo->setIdPosicao_fk($reg['idPosicao_fk']);
                $objInfosTubo->setIdTubo_fk($reg['idTubo_fk']);
                $objInfosTubo->setIdLote_fk($reg['idLote_fk']);
                $objInfosTubo->setEtapa($reg['etapa']);
                $objInfosTubo->setEtapaAnterior($reg['etapaAnterior']);
                $objInfosTubo->setDataHora($reg['dataHora']);
                $objInfosTubo->setReteste($reg['reteste']);
                $objInfosTubo->setVolume($reg['volume']);
                $objInfosTubo->setObsProblema($reg['obsProblema']);
                $objInfosTubo->setObservacoes($reg['observacoes']);
                $objInfosTubo->setSituacaoEtapa($reg['situacaoEtapa']);
                $objInfosTubo->setSituacaoTubo($reg['situacaoTubo']);

                $INSERT = 'INSERT INTO tb_infostubo ('
                    . 'idUsuario_fk,'
                    . 'idPosicao_fk,'
                    . 'idTubo_fk,'
                    . 'idLote_fk,'
                    . 'etapa,'
                    . 'etapaAnterior,'
                    . 'dataHora,'
                    . 'reteste,'
                    . 'volume,'
                    . 'obsProblema,'
                    . 'observacoes,'
                    . 'situacaoEtapa,'
                    . 'situacaoTubo'
                    . ')'
                    . 'VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)';

                $arrayBind = array();
                $arrayBind[] = array('i',$objInfosTubo->getIdUsuario_fk());
                $arrayBind[] = array('i',$objInfosTubo->getIdPosicao_fk());
                $arrayBind[] = array('i',$objInfosTubo->getIdTubo_fk());
                $arrayBind[] = array('i',$objInfosTubo->getIdLote_fk());
                $arrayBind[] = array('s',InfosTuboRN::$TP_LAUDO);
                $arrayBind[] = array('s',$objInfosTubo->getEtapa());
                $arrayBind[] = array('s',$objInfosTubo->getDataHora());
                $arrayBind[] = array('s',$objInfosTubo->getReteste());
                $arrayBind[] = array('d',$objInfosTubo->getVolume());
                $arrayBind[] = array('s',$objInfosTubo->getObsProblema());
                $arrayBind[] = array('s',$objInfosTubo->getObservacoes());
                $arrayBind[] = array('s',InfosTuboRN::$TSP_AGUARDANDO);
                $arrayBind[] = array('s',$objInfosTubo->getSituacaoTubo());


                $objBanco->executarSQL($INSERT,$arrayBind);
                $objInfosTubo->setIdInfosTubo($objBanco->obterUltimoID());

            }

            return null;
        } catch (Throwable $ex) {
            die($ex);
            throw new Excecao("Erro listando a amostra no BD.", $ex);
        }
    }



}
