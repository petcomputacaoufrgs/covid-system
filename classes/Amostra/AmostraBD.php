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
    
    public function listar(Amostra $objAmostra,$numLimite=null, Banco $objBanco) {
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

    /**** EXTRAS ****/
    public function paginacao(Amostra $objAmostra, Banco $objBanco) {
        try{

            $inicio = ($objAmostra->getNumPagina()-1)*500;

            if($objAmostra->getNumPagina() == null){
                $inicio = 0;
            }

            $SELECT = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_amostra,tb_paciente,tb_perfilpaciente ";
            $WHERE = ' tb_amostra.idPaciente_fk = tb_paciente.idPaciente and tb_amostra.idPerfilPaciente_fk = tb_perfilpaciente.idPerfilPaciente  ';
            $AND = ' and ';
            $arrayBind = array();

            if ($objAmostra->get_a_r_g() != null) {
                $WHERE .= $AND . " tb_amostra.a_r_g = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objAmostra->get_a_r_g());
            }

            if ($objAmostra->getDataColeta() != null) {
                $WHERE .= $AND . " tb_amostra.dataColeta = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objAmostra->getDataColeta());
            }

            if ($objAmostra->getObjPerfil() != null) {
                if ($objAmostra->getObjPerfil()->getCaractere() != null) {
                    $WHERE .= $AND . " tb_perfilpaciente.caractere = ?";
                    $AND = ' and ';
                    $arrayBind[] = array('s', $objAmostra->getObjPerfil()->getCaractere());
                }
            }

            if ($objAmostra->getObjPaciente() != null) {
                if ($objAmostra->getObjPaciente()->getNome() != null) {
                    $WHERE .= $AND . " tb_paciente.nome LIKE ?";
                    $AND = ' and ';
                    $arrayBind[] = array('s', "%".$objAmostra->getObjPaciente()->getNome()."%");
                }

                if ($objAmostra->getObjPaciente()->getCadastroPendente() != null) {
                    $WHERE .= $AND . " tb_paciente.cadastroPendente = ?";
                    $AND = ' and ';
                    $arrayBind[] = array('s', $objAmostra->getObjPaciente()->getCadastroPendente());
                }

            }

            if ($objAmostra->getNickname() != null) {
                $WHERE .= $AND . " tb_amostra.nickname LIKE ?";
                $AND = ' and ';
                $arrayBind[] = array('s', "%".$objAmostra->getNickname()."%");
            }

            if($WHERE != ''){
                $WHERE = ' where '.$WHERE;
            }


            $SELECT.= $WHERE. ' order by tb_amostra.idAmostra desc';
            $SELECT.= ' LIMIT ?,500 ';



            $arrayBind[] = array('i',$inicio);
            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $SELECT = "SELECT FOUND_ROWS() as total";
            $total = $objBanco->consultarSQL($SELECT);
            $objAmostra->setTotalRegistros($total[0]['total']);
            $objAmostra->setNumPagina($inicio);


            $array_amostra = array();
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


                $objPaciente = new Paciente();
                $objPacienteRN = new PacienteRN();
                $objPaciente->setIdPaciente($reg['idPaciente_fk']);
                $paciente = $objPacienteRN->listar($objPaciente);
                $objAmostra->setObjPaciente($paciente[0]);

                $objPerfilPaciente = new PerfilPaciente();
                $objPerfilPacienteRN = new PerfilPacienteRN();
                $objPerfilPaciente->setIdPerfilPaciente($reg['idPerfilPaciente_fk']);
                $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
                $objAmostra->setObjPerfil($objPerfilPaciente);


                $array_amostra[] = $objAmostra;

            }
            return $array_amostra;
        } catch (Throwable $ex) {
            throw new Excecao("Erro paginação amostra no BD.",$ex);
        }

    }

    public function listar_completo($objAmostra,$numLimite=null, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_amostra";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objAmostra->getIdAmostra() != null) {
                $WHERE .= $AND . " idAmostra = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objAmostra->getIdAmostra());
            }

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


            $arr = $objBanco->consultarSQL($SELECT . $WHERE. ' order by dataColeta ', $arrayBind);

            $array_amostra = array();
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
                //print_r($objAmostra);


                //-----------------------  perfil da amostra -----------------------
                $objPerfilPaciente = new PerfilPaciente();
                $objPerfilPacienteRN = new PerfilPacienteRN();

                $objPerfilPaciente->setIdPerfilPaciente($reg['idPerfilPaciente_fk']);
                $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
                $objAmostra->setObjPerfil($objPerfilPaciente);

                //-----------------------  paciente -----------------------
                $objPaciente = new Paciente();
                $objPacienteRN = new PacienteRN();

                $objPaciente->setIdPaciente($reg['idPaciente_fk']);
                //print_r($objPaciente);
                $objPaciente = $objPacienteRN->listar_completo($objPaciente,null);
                //print_r($objPaciente);


                //-----------------------  estado -----------------------

                if($objAmostra->getIdEstado_fk() != null) {
                    $objEstado = new EstadoOrigem();
                    $objEstadoRN = new EstadoOrigemRN();
                    $objEstado->setCod_estado($objAmostra->getIdEstado_fk());
                    $objEstado = $objEstadoRN->consultar($objEstado);
                    $objAmostra->setObjEstado($objEstado);
                }

                //-----------------------  município -----------------------
                if($objAmostra->getIdLugarOrigem_fk() != null) {
                    $objMunicipio = new LugarOrigem();
                    $objMunicipioRN = new LugarOrigemRN();
                    $objMunicipio->setIdLugarOrigem($objAmostra->getIdLugarOrigem_fk());
                    $objMunicipio = $objMunicipioRN->consultar($objMunicipio);
                    $objAmostra->setObjMunicipio($objMunicipio);
                }


                //-----------------------  CÓDIGO GAL -----------------------
                if($objAmostra->getIdCodGAL_fk() != null) {
                    $objCodGAL = new CodigoGAL();
                    $objCodGALRN = new CodigoGAL_RN();
                    $objCodGAL->setIdCodigoGAL($objAmostra->getIdCodGAL_fk());
                    $objCodGAL = $objCodGALRN->consultar($objCodGAL);
                    //print_r($objCodGAL);
                    if(!is_null($objCodGAL) ) {
                        //echo "aidkjasdjas";
                        $objPaciente[0]->setObjCodGAL($objCodGAL);
                    }
                }
                $objAmostra->setObjPaciente($objPaciente[0]);
                //print_r($objAmostra);
                $array_amostra[] = $objAmostra;

            }

            /*echo "<pre>";
            print_r($array_amostra);
            echo "</pre>";
            die();*/
            return $array_amostra;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando a amostra no BD.",$ex);
        }

    }


    public function listar_completo_unica_consulta($objAmostra,$numLimite=null, Banco $objBanco) {
        try{

            $SELECT = "SELECT DISTINCT  tb_amostra.idAmostra,tb_amostra.idPaciente_fk,
                                        tb_amostra.idCodGAL_fk,tb_amostra.idNivelPrioridade_fk,
                                        tb_amostra.idPerfilPaciente_fk,tb_amostra.cod_estado_fk as codEstadoAmostra,
                                        tb_amostra.dataColeta,
                                        tb_amostra.a_r_g,tb_amostra.horaColeta,
                                        tb_amostra.motivo,tb_amostra.CEP, tb_amostra.cod_municipio_fk as codMunicipioAmostra,
                                        tb_amostra.nickname,
                                        tb_paciente.nome as nomePaciente,tb_paciente.idPaciente,
                                        tb_paciente.idSexo_fk, tb_paciente.idEtnia_fk,
                                        tb_paciente.CPF, tb_paciente.RG,
                                        tb_paciente.dataNascimento, tb_paciente.endereco,
                                        tb_paciente.CEP, tb_paciente.passaporte,
                                        tb_paciente.cartaoSUS, tb_paciente.idMunicipio_fk as codMunicipioPaciente,
                                        tb_paciente.idEstado_fk as codEstadoPaciente,
                                        tb_sexo.idSexo, tb_sexo.sexo,tb_sexo.index_sexo,
                                        tb_etnia.idEtnia, tb_etnia.etnia,tb_etnia.index_etnia,
                                        tb_perfilpaciente.idPerfilPaciente, tb_perfilpaciente.caractere,
                                        tb_perfilpaciente.index_perfil, tb_perfilpaciente.perfil,
                                        tab_municipio.cod_municipio,tab_municipio.nome as nomeMunicipioAmostra,
                                        tab_municipio.cod_estado,
                                        tab_estado.cod_estado,tab_estado.sigla as siglaEstadoAmostra,tab_estado.nome as nomeEstadoAmostra,
                                        tb_laudo.idLaudo, tb_laudo.idAmostra_fk,tb_laudo.dataHoraGeracao, tb_laudo.dataHoraLiberacao, tb_laudo.situacao, tb_laudo.resultado,
                                        tb_cadastroamostra.idUsuario_fk as idUsuarioCadastroAmostra, tb_cadastroamostra.dataCadastroInicio as dataHoraInicioCadastro,
                                        tb_cadastroamostra.dataCadastroFim as dataHoraFimCadastro,tb_cadastroamostra.idCadastroAmostra
                                                                  
                                        FROM tb_amostra
                            left join tab_estado on tb_amostra.cod_estado_fk =tab_estado.cod_estado
                            left join tab_municipio on tb_amostra.cod_municipio_fk =tab_municipio.cod_municipio
                            left join tb_laudo on tb_amostra.idAmostra =tb_laudo.idAmostra_fk
                            inner join ((tb_paciente left join tb_sexo on tb_sexo.idSexo = tb_paciente.idSexo_fk)
                                                     left join tb_etnia on tb_etnia.idEtnia = tb_paciente.idEtnia_fk)  on tb_amostra.idPaciente_fk = tb_paciente.idPaciente
                            inner join tb_perfilpaciente on tb_amostra.idPerfilPaciente_fk = tb_perfilpaciente.idPerfilPaciente
                            inner join tb_cadastroamostra on tb_amostra.idAmostra = tb_cadastroamostra.idAmostra_fk
                            
                            order by tb_amostra.dataColeta ";
            $arr = $objBanco->consultarSQL($SELECT , null);
          
            $array_amostra = array();
            foreach ($arr as $reg){
                $objAmostra = new Amostra();
                $objAmostra->setIdAmostra($reg['idAmostra']);
                $objAmostra->setIdPaciente_fk($reg['idPaciente_fk']);
                $objAmostra->setIdCodGAL_fk($reg['idCodGAL_fk']);
                $objAmostra->setIdNivelPrioridade_fk($reg['idNivelPrioridade_fk']);
                $objAmostra->setIdPerfilPaciente_fk($reg['idPerfilPaciente_fk']);
                $objAmostra->setIdEstado_fk($reg['codEstadoAmostra']);
                $objAmostra->setIdLugarOrigem_fk($reg['codMunicipioAmostra']);
                $objAmostra->setDataColeta($reg['dataColeta']);
                $objAmostra->set_a_r_g($reg['a_r_g']);
                $objAmostra->setHoraColeta($reg['horaColeta']);
                $objAmostra->setMotivoExame($reg['motivo']);
                $objAmostra->setCEP($reg['CEP']);
                $objAmostra->setCodigoAmostra($reg['codigoAmostra']);
                $objAmostra->setNickname($reg['nickname']);
                //print_r($objAmostra);

                //-----------------------  perfil da amostra -----------------------
                $objCadastroAmostra = new CadastroAmostra();
                $objCadastroAmostra->setIdCadastroAmostra($reg['idCadastroAmostra']);
                $objCadastroAmostra->setIdUsuario_fk($reg['idUsuarioCadastroAmostra']);
                $objCadastroAmostra->setDataHoraFim($reg['dataHoraFimCadastro']);
                $objCadastroAmostra->setDataHoraInicio($reg['dataHoraInicioCadastro']);



                //-----------------------  perfil da amostra -----------------------
                $objPerfilPaciente = new PerfilPaciente();
                $objPerfilPaciente->setIdPerfilPaciente($reg['idPerfilPaciente']);
                $objPerfilPaciente->setCaractere($reg['caractere']);
                $objPerfilPaciente->setIndex_perfil($reg['index_perfil']);
                $objPerfilPaciente->setPerfil($reg['perfil']);
                $objAmostra->setObjPerfil($objPerfilPaciente);

                //-----------------------  paciente -----------------------
                $paciente = new Paciente();
                $paciente->setIdPaciente($reg['idPaciente']);
                $paciente->setNome($reg['nomePaciente']);
                $paciente->setIdSexo_fk($reg['idSexo_fk']);
                $paciente->setIdEtnia_fk($reg['idEtnia_fk']);
                $paciente->setNomeMae($reg['nomeMae']);
                $paciente->setCPF($reg['CPF']);
                $paciente->setRG($reg['RG']);
                $paciente->setDataNascimento($reg['dataNascimento']);
                $paciente->setCEP($reg['CEP']);
                $paciente->setPassaporte($reg['passaporte']);
                $paciente->setCadastroPendente($reg['cadastroPendente']);
                $paciente->setCartaoSUS($reg['cartaoSUS']);
                $paciente->setIdMunicipioFk($reg['codMunicipioPaciente']);
                $paciente->setIdEstadoFk($reg['codEstadoPaciente']);



                if(!is_null($reg['idSexo'])) {
                    $sexo = new Sexo();
                    $sexo->setIdSexo($reg['idSexo']);
                    $sexo->setSexo($reg['sexo']);
                    $sexo->setIndex_sexo($reg['index_sexo']);
                    $paciente->setObjSexo($sexo);
                }

                if(!is_null($reg['idEtnia'])) {
                    $etnia = new Etnia();
                    $etnia->setIdEtnia($reg['idEtnia']);
                    $etnia->setEtnia($reg['etnia']);
                    $etnia->setIndex_etnia($reg['index_etnia']);
                    $paciente->setObjEtnia($etnia);
                }


                //print_r($objPaciente);


                //-----------------------  estado -----------------------

                if(!is_null($reg['codEstadoAmostra'])) {
                    $objEstadoOrigem = new EstadoOrigem();
                    $objEstadoOrigem->setCod_estado($reg['codEstadoAmostra']);
                    $objEstadoOrigem->setSigla($reg['siglaEstadoAmostra']);
                    $objEstadoOrigem->setNome($reg['nomeEstadoAmostra']);
                    $objAmostra->setObjEstado($objEstadoOrigem);
                }

                /*if(!is_null($reg['cod_estado'])) {
                    $objEstadoOrigem = new EstadoOrigem();
                    $objEstadoOrigem->setCod_estado($reg['codEstadoPaciente']);
                    $objEstadoOrigem->setSigla($reg['siglaEstadoPaciente']);
                    $objEstadoOrigem->setNome($reg['nomeEstadoPaciente']);
                    $paciente->setObjEstado($objEstadoOrigem);
                }*/

                //-----------------------  município -----------------------
                if(!is_null($reg['codMunicipioAmostra'])) {
                    $objLugarOrigem = new LugarOrigem();
                    $objLugarOrigem->setIdLugarOrigem($reg['codMunicipioAmostra']);
                    $objLugarOrigem->setNome($reg['nomeMunicipioAmostra']);
                    $objLugarOrigem->setCod_estado($reg['codEstadoAmostra']);
                    $objAmostra->setObjMunicipio($objLugarOrigem);
                }

                /*if(!is_null($reg['codMunicipioPaciente'])) {
                    $objLugarOrigemPaciente = new LugarOrigem();
                    $objLugarOrigemPaciente->setIdLugarOrigem($reg['codMunicipioPaciente']);
                    $objLugarOrigemPaciente->setNome($reg['nomeMunicipioPaciente']);
                    $objLugarOrigemPaciente->setCod_estado($reg['codEstadoPaciente']);
                    $paciente->setObjMunicipio($objLugarOrigemPaciente);
                }*/
                $objAmostra->setObjPaciente($paciente);

                //-----------------------  CÓDIGO GAL -----------------------

                if(!is_null($reg['idLaudo'])) {
                    $objLaudo = new Laudo();
                    $objLaudo->setIdLaudo($reg['idLaudo']);
                    $objLaudo->setIdAmostraFk($reg['idAmostra_fk']);
                    $objLaudo->setSituacao($reg['situacao']);
                    $objLaudo->setResultado($reg['resultado']);
                    $objLaudo->setDataHoraGeracao($reg['dataHoraGeracao']);
                    $objLaudo->setDataHoraLiberacao($reg['dataHoraLiberacao']);
                    $objAmostra->setObjLaudo($objLaudo);
                }

                $objCadastroAmostra->setObjAmostra($objAmostra);
                //print_r($objAmostra);
                $array_amostra[] = $objCadastroAmostra;

            }

           // echo "<pre>";
           // print_r($array_amostra);
           // echo "</pre>";
           //die();
            return $array_amostra;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando a amostra no BD.",$ex);
        }

    }

    public function listar_rtqpcrs_amostra(Amostra $objAmostra,$situacaoRTQPCR = null, Banco $objBanco) {
        try{

            $SELECT = "SELECT *  FROM tb_rtqpcr, tb_placa, tb_tubo, tb_rel_tubo_placa, tb_amostra 
                        WHERE tb_rtqpcr.idPlaca_fk = tb_placa.idPlaca 
                        AND tb_placa.idPlaca = tb_rel_tubo_placa.idPlaca_fk 
                        AND tb_rel_tubo_placa.idTubo_fk = tb_tubo.idTubo 
                        and tb_tubo.idAmostra_fk = tb_amostra.idAmostra ";

            $WHERE = '';
            $AND = ' and ';
            $arrayBind = array();

            if ($objAmostra->getIdAmostra() != null) {
                $WHERE .= $AND . "  tb_amostra.idAmostra = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objAmostra->getIdAmostra());
            }

            if ($objAmostra->getNickname() != null) {
                $WHERE .= $AND . " tb_amostra.nickname = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objAmostra->getNickname());
            }

            if ($situacaoRTQPCR != null) {
                $WHERE .= $AND . " tb_rtqpcr.situacaoRTqPCR = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $situacaoRTQPCR);
            }

            //$a = $SELECT .$WHERE. " order by tb_rtqpcr.dataHoraFim ";

            $arr = $objBanco->consultarSQL($SELECT .$WHERE. " order by tb_rtqpcr.dataHoraFim ", $arrayBind);

           // echo "<pre>";
           // print_r($arr);
           // echo  "<pre>";


            $array = array();
            $arr_rtqpcrs = array();
            foreach ($arr as $reg){
                if(!in_array($reg['idRTqPCR'],$arr_rtqpcrs)) {
                    $arr_rtqpcrs[] = $reg['idRTqPCR'];

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


                    $RTqPCR = new RTqPCR();
                    $RTqPCR->setIdRTqPCR($reg['idRTqPCR']);
                    $RTqPCR->setIdPlacaFk($reg['idPlaca_fk']);
                    $RTqPCR->setIdUsuarioFk($reg['idUsuario_fk']);
                    $RTqPCR->setIdEquipamentoFk($reg['idEquipamento_fk']);
                    $RTqPCR->setDataHoraInicio($reg['dataHoraInicio']);
                    $RTqPCR->setDataHoraFim($reg['dataHoraFim']);
                    $RTqPCR->setSituacaoRTqPCR($reg['situacaoRTqPCR']);
                    $RTqPCR->setHoraFinal($reg['horaFinal']);
                    /*$placa = new Placa();
                    $placa->setIdPlaca($reg['idPlaca']);
                    $placa->setPlaca($reg['placa']);
                    $placa->setIdProtocoloFk($reg['idProtocolo_fk']);
                    $placa->setIndexPlaca($reg['index_placa']);
                    $placa->setSituacaoPlaca($reg['situacaoPlaca']);
                    $RTqPCR->setObjPlaca($placa);*/
                    $objAmostra->setObjRTqPCR($RTqPCR);
                    /*$paciente = new Paciente();
                    $paciente->setIdPaciente($reg['idPaciente']);
                    $paciente->setNome($reg['nome']);
                    $paciente->setIdSexo_fk($reg['idSexo_fk']);
                    $paciente->setIdEtnia_fk($reg['idEtnia_fk']);
                    $paciente->setNomeMae($reg['nomeMae']);
                    $paciente->setCPF($reg['CPF']);
                    $paciente->setObsCPF($reg['CPF']);
                    $paciente->setRG($reg['RG']);
                    $paciente->setObsRG($reg['obsRG']);
                    $paciente->setDataNascimento($reg['dataNascimento']);
                    $paciente->setObsNomeMae($reg['obsNomeMae']);
                    $paciente->setEndereco($reg['endereco']);
                    $paciente->setCEP($reg['CEP']);
                    $paciente->setPassaporte($reg['passaporte']);
                    $paciente->setObsPassaporte($reg['obsPassaporte']);
                    $paciente->setObsCEP($reg['obsCEP']);
                    $paciente->setObsEndereco($reg['obsEndereco']);
                    $paciente->setCadastroPendente($reg['cadastroPendente']);
                    $paciente->setCartaoSUS($reg['cartaoSUS']);
                    $paciente->setObsCartaoSUS($reg['obsCartaoSUS']);
                    $paciente->setObsDataNascimento($reg['obsDataNascimento']);
                    $paciente->setIdMunicipioFk($reg['idMunicipio_fk']);
                    $paciente->setIdEstadoFk($reg['idEstado_fk']);
                    $paciente->setObsMunicipio($reg['obsMunicipio']);
                    $objAmostra->setObjPaciente($paciente);*/
                    $array[] = $objAmostra;
                }

            }

           // echo "<pre>";
           // print_r($array);
           // echo  "<pre>";
            return $array;
        } catch (Throwable $ex) {
            die($ex);
            throw new Excecao("Erro listando o exame RTqPCR da amostra no BD.",$ex);
        }

    }

    public function consultar_volume(Amostra $objAmostra, Banco $objBanco) {

        try{

            $objTubo = new Tubo();
            $objTuboRN = new TuboRN();
            $objTubo->setIdAmostra_fk($objAmostra->getIdAmostra());
            $arr_amostras = $objTuboRN->listar_completo($objTubo,null,true);

            /*
                echo "<pre>";
                print_r($arr_amostras);
                echo "</pre>";
            */
            foreach ($arr_amostras as $amostra){
                $tubo = $amostra->getObjTubo();
                $tam = count($amostra->getObjTubo()->getObjInfosTubo());
                $objInfosTubo = $amostra->getObjTubo()->getObjInfosTubo()[$tam-1];

                if($objInfosTubo->getVolume() >  0 && $tubo->getTipo() == TuboRN::$TT_ALIQUOTA && $objInfosTubo->getSituacaoTubo() == InfosTuboRN::$TST_AGUARDANDO_BANCO_AMOSTRAS ){
                    $tubo->setObjInfosTubo($objInfosTubo);
                    return $tubo;
                }
            }
            return null;
        } catch (Throwable $ex) {
            throw new Excecao("Erro consultando o volume da amostra no BD.",$ex);
        }

    }

    public function listar_aguardando_sol_montagem_placa_RTqCPR(Amostra $amostra,$numLimite=null,$arr_amostras_int=null, Banco $objBanco) {
        try{

            if($amostra->getObjPerfil() != null) {

                $interrogacoes = '';
                for ($i = 0; $i < count($amostra->getObjPerfil()); $i++) {
                    $interrogacoes .= '?,';
                }
                $interrogacoes = substr($interrogacoes, 0, -1);

                /* para cada um gerar o ultimo info tubo dos tubos gerados acima e que tenha como situação
                do tubo o 'aguardando RTqPCR' */
                $select2 = '   select distinct tb_infostubo.idTubo_fk 
                                    from tb_infostubo
                                    WHERE tb_infostubo.situacaoTubo = ?
                                    and tb_infostubo.etapa = ?';
                $arrayBind2 = array();
                $arrayBind2[] = array('s', InfosTuboRN::$TST_AGUARDANDO_SOLICITACAO_MONTAGEM_PLACA);
                $arrayBind2[] = array('s', InfosTuboRN::$TP_RTqPCR_SOLICITACAO__MONTAGEM_PLACA);

                $info = $objBanco->consultarSQL($select2, $arrayBind2);
                //print_r($info);
                //die("10");
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

                    if($infos_completos[0]['etapa'] == InfosTuboRN::$TP_RTqPCR_SOLICITACAO__MONTAGEM_PLACA
                        && $infos_completos[0]['situacaoEtapa'] == InfosTuboRN::$TSP_AGUARDANDO) {

                        $SELECT_AMOSTRA = 'SELECT * from tb_amostra,tb_tubo where tb_amostra.idPerfilPaciente_fk in (' . $interrogacoes . ') 
                                        and tb_tubo.idAmostra_fk = tb_amostra.idAmostra
                                        and tb_tubo.idTubo = ?
                                        ';

                        $arrayBindA = array();

                        for ($i = 0; $i < count($amostra->getObjPerfil()); $i++) {
                            $arrayBindA[] = array('i', $amostra->getObjPerfil()[$i]->getIdPerfilPaciente());
                        }
                        $arrayBindA[] = array('i', $objTubo->getIdTubo());
                        //$arrayBindA[] = array('i', $amostra->getObjProtocolo()->getNumMaxAmostras());
                        $amostra_arr = $objBanco->consultarSQL($SELECT_AMOSTRA, $arrayBindA);
                        //echo "<pre>";
                        //print_r($infos_completos);
                        //echo "</pre>";



                        $encontrou = false;
                        if(count($arr_amostras_int) > 0) {
                            foreach ($arr_amostras_int as $amostraINT){
                                if($amostraINT->getIdAmostra() == $amostra_arr[0]['idAmostra']){
                                    $encontrou = true;
                                    $arr_amostras[] = $amostraINT;
                                }
                            }


                        }

                        if(!$encontrou) {
                            /*echo "<pre>";
                            print_r($amostra_arr);
                            echo "</pre>";*/
                            if (count($amostra_arr) > 0) {

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
                                if (count($arr_amostras) >= $numLimite) {
                                    //echo "<pre>";
                                    //print_r($arr_amostras);
                                    //echo "</pre>";
                                    //die("30");
                                    return $arr_amostras;
                                }
                            }
                        }
                    }
                }
            }
            //die("40");
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
                                tb_infostubo.reteste,
                                tb_infostubo.observacoes
                                
                                
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
                    $objInfosTubo->setObservacoes($info['observacoes']);
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

    public function alterar_nickname(Amostra $objAmostra, Banco $objBanco){
        $SELECT = 'SELECT nickname FROM tb_amostra where idPerfilPaciente_fk = ? order by nickname desc limit 1 for update';

        $arrayBind = array();
        $arrayBind[] = array('i',intval($objAmostra->getIdPerfilPaciente_fk()));

        $registro = $objBanco->consultarSql($SELECT,$arrayBind);
        if(count($registro) > 0) {
            return substr($registro[0]['nickname'], 1);
        }else{
            return 0;
        }



    }

    public function validar_amostras($array_amostras,$array_perfis, Banco $objBanco){
        try{

            $arr_amostras_retorno = array();
            foreach ($array_amostras as $nickname) {
                $SELECT = "SELECT * FROM tb_amostra,tb_tubo 
                            where tb_amostra.nickname = ? 
                            and tb_amostra.idAmostra = tb_tubo.idAmostra_fk ";

                $arrayBind = array();
                $arrayBind[] = array('s', $nickname);
                $arr = $objBanco->consultarSql($SELECT, $arrayBind);

                foreach ($arr as $tubo) {
                    $select_max_infostubo = "
                    select * from tb_infostubo,tb_tubo,tb_amostra 
                    WHERE idInfostubo = (select max(tb_infostubo.idInfosTubo) from tb_infostubo, tb_tubo 
                                                                              where tb_infostubo.idTubo_fk = tb_tubo.idTubo 
                                                                              and tb_tubo.idTubo = ? ) 
                    and tb_infostubo.idTubo_fk = tb_tubo.idTubo 
                    and tb_tubo.idAmostra_fk = tb_amostra.idAmostra ";

                    $arrayBind = array();
                    $arrayBind[] = array('i', $tubo['idTubo']);
                    $array_completo = $objBanco->consultarSql($select_max_infostubo, $arrayBind);


                    foreach ($array_completo as $completo) {
                        if ($completo['etapa'] == InfosTuboRN::$TP_MONTAGEM_GRUPOS_AMOSTRAS &&
                            $completo['situacaoEtapa'] == InfosTuboRN::$TSP_AGUARDANDO &&
                            $completo['situacaoTubo'] == InfosTuboRN::$TST_SEM_UTILIZACAO) {

                            $objAmostra = new Amostra();
                            $objAmostra->setIdAmostra($completo['idAmostra']);
                            $objAmostra->setIdPaciente_fk($completo['idPaciente_fk']);
                            $objAmostra->setIdCodGAL_fk($completo['idCodGAL_fk']);
                            $objAmostra->setIdNivelPrioridade_fk($completo['idNivelPrioridade_fk']);
                            $objAmostra->setIdPerfilPaciente_fk($completo['idPerfilPaciente_fk']);
                            $objAmostra->setIdEstado_fk($completo['cod_estado_fk']);
                            $objAmostra->setIdLugarOrigem_fk($completo['cod_municipio_fk']);
                            $objAmostra->setObservacoes($completo['observacoes']);
                            $objAmostra->setDataColeta($completo['dataColeta']);
                            $objAmostra->set_a_r_g($completo['a_r_g']);
                            $objAmostra->setHoraColeta($completo['horaColeta']);
                            $objAmostra->setMotivoExame($completo['motivo']);
                            $objAmostra->setCEP($completo['CEP']);
                            $objAmostra->setCodigoAmostra($completo['codigoAmostra']);
                            $objAmostra->setObsCEP($completo['obsCEPAmostra']);
                            $objAmostra->setObsHoraColeta($completo['obsHoraColeta']);
                            $objAmostra->setObsLugarOrigem($completo['obsLugarOrigem']);
                            $objAmostra->setObsMotivo($completo['obsMotivo']);
                            $objAmostra->setNickname($completo['nickname']);

                            $objTubo = new Tubo();
                            $objTubo->setIdTubo($completo['idTubo']);
                            $objTubo->setIdTubo_fk($completo['idTubo_fk']);
                            $objTubo->setIdAmostra_fk($completo['idAmostra_fk']);
                            $objTubo->setTuboOriginal($completo['tuboOriginal']);
                            $objTubo->setTipo($completo['tipo']);


                            $objInfosTubo = new InfosTubo();
                            $objInfosTubo->setIdInfosTubo($completo['idInfosTubo']);
                            $objInfosTubo->setIdUsuario_fk($completo['idUsuario_fk']);
                            $objInfosTubo->setIdPosicao_fk($completo['idPosicao_fk']);
                            $objInfosTubo->setIdTubo_fk($completo['idTubo_fk']);
                            $objInfosTubo->setIdLote_fk($completo['idLote_fk']);
                            $objInfosTubo->setEtapa($completo['etapa']);
                            $objInfosTubo->setEtapaAnterior($completo['etapaAnterior']);
                            $objInfosTubo->setDataHora($completo['dataHora']);
                            $objInfosTubo->setReteste($completo['reteste']);
                            $objInfosTubo->setVolume($completo['volume']);
                            $objInfosTubo->setObsProblema($completo['obsProblema']);
                            $objInfosTubo->setObservacoes($completo['observacoes']);
                            $objInfosTubo->setSituacaoEtapa($completo['situacaoEtapa']);
                            $objInfosTubo->setSituacaoTubo($completo['situacaoTubo']);
                            $objInfosTubo->setIdLocalFk($completo['idLocal_fk']);
                            $objTubo->setObjInfosTubo($objInfosTubo);
                            $objAmostra->setObjTubo($objTubo);
                            $arr_amostras_retorno[] = $objAmostra;
                        }
                    }

                }
            }

            return $arr_amostras_retorno;
        } catch (Throwable $ex) {
            throw new Excecao("Erro validando as amostras.",$ex);
        }



    }

    public function validar_amostras_extracao($array_amostras, Banco $objBanco){
        try{

            $arr_amostras_retorno = array();
            foreach ($array_amostras as $nickname) {
                $SELECT = "SELECT * FROM tb_amostra,tb_tubo 
                            where tb_amostra.nickname = ? 
                            and tb_amostra.idAmostra = tb_tubo.idAmostra_fk ";

                $arrayBind = array();
                $arrayBind[] = array('s', $nickname);
                $arr = $objBanco->consultarSql($SELECT, $arrayBind);

                foreach ($arr as $tubo) {
                    $select_max_infostubo = "
                    select * from tb_infostubo,tb_tubo,tb_amostra 
                    WHERE idInfostubo = (select max(tb_infostubo.idInfosTubo) from tb_infostubo, tb_tubo 
                                                                              where tb_infostubo.idTubo_fk = tb_tubo.idTubo 
                                                                              and tb_tubo.idTubo = ? ) 
                    and tb_infostubo.idTubo_fk = tb_tubo.idTubo 
                    and tb_tubo.idAmostra_fk = tb_amostra.idAmostra ";

                    $arrayBind = array();
                    $arrayBind[] = array('i', $tubo['idTubo']);
                    $array_completo = $objBanco->consultarSql($select_max_infostubo, $arrayBind);


                    foreach ($array_completo as $completo) {
                        if ($completo['etapa'] == InfosTuboRN::$TP_EXTRACAO &&
                            $completo['situacaoEtapa'] == InfosTuboRN::$TSP_AGUARDANDO &&
                            $completo['situacaoTubo'] == InfosTuboRN::$TST_TRANSPORTE_EXTRACAO) {

                            $tubo = new Tubo();
                            $objTuboRN = new TuboRN();
                            $tubo->setIdTubo($completo['idTubo']);
                            $arr_tubo = $objTuboRN->listar_completo($tubo,null,true);
                            $arr_amostras_retorno[] = $arr_tubo[0];
                        }
                    }

                }
            }

            return $arr_amostras_retorno;
        } catch (Throwable $ex) {
            throw new Excecao("Erro validando as amostras.",$ex);
        }



    }

    public function validar_amostras_solicitacao($array_amostras,$array_perfis, Banco $objBanco){
        try{

            $arr_amostras_retorno = array();
            foreach ($array_amostras as $nickname) {
                $SELECT = "SELECT * FROM tb_amostra,tb_tubo 
                            where tb_amostra.nickname = ? 
                            and tb_amostra.idAmostra = tb_tubo.idAmostra_fk ";

                $arrayBind = array();
                $arrayBind[] = array('s', $nickname);
                $arr = $objBanco->consultarSql($SELECT, $arrayBind);

                foreach ($arr as $tubo) {
                    $select_max_infostubo = "
                    select * from tb_infostubo,tb_tubo,tb_amostra 
                    WHERE idInfostubo = (select max(tb_infostubo.idInfosTubo) from tb_infostubo, tb_tubo 
                                                                              where tb_infostubo.idTubo_fk = tb_tubo.idTubo 
                                                                              and tb_tubo.idTubo = ? ) 
                    and tb_infostubo.idTubo_fk = tb_tubo.idTubo 
                    and tb_tubo.idAmostra_fk = tb_amostra.idAmostra ";

                    $arrayBind = array();
                    $arrayBind[] = array('i', $tubo['idTubo']);
                    $array_completo = $objBanco->consultarSql($select_max_infostubo, $arrayBind);


                    foreach ($array_completo as $completo) {
                        if ($completo['etapa'] == InfosTuboRN::$TP_RTqPCR_SOLICITACAO__MONTAGEM_PLACA &&
                            $completo['situacaoEtapa'] == InfosTuboRN::$TSP_AGUARDANDO &&
                            $completo['situacaoTubo'] == InfosTuboRN::$TST_AGUARDANDO_SOLICITACAO_MONTAGEM_PLACA) {

                            $objAmostra = new Amostra();
                            $objAmostra->setIdAmostra($completo['idAmostra']);
                            $objAmostra->setIdPaciente_fk($completo['idPaciente_fk']);
                            $objAmostra->setIdCodGAL_fk($completo['idCodGAL_fk']);
                            $objAmostra->setIdNivelPrioridade_fk($completo['idNivelPrioridade_fk']);
                            $objAmostra->setIdPerfilPaciente_fk($completo['idPerfilPaciente_fk']);
                            $objAmostra->setIdEstado_fk($completo['cod_estado_fk']);
                            $objAmostra->setIdLugarOrigem_fk($completo['cod_municipio_fk']);
                            $objAmostra->setObservacoes($completo['observacoes']);
                            $objAmostra->setDataColeta($completo['dataColeta']);
                            $objAmostra->set_a_r_g($completo['a_r_g']);
                            $objAmostra->setHoraColeta($completo['horaColeta']);
                            $objAmostra->setMotivoExame($completo['motivo']);
                            $objAmostra->setCEP($completo['CEP']);
                            $objAmostra->setCodigoAmostra($completo['codigoAmostra']);
                            $objAmostra->setObsCEP($completo['obsCEPAmostra']);
                            $objAmostra->setObsHoraColeta($completo['obsHoraColeta']);
                            $objAmostra->setObsLugarOrigem($completo['obsLugarOrigem']);
                            $objAmostra->setObsMotivo($completo['obsMotivo']);
                            $objAmostra->setNickname($completo['nickname']);

                            $objTubo = new Tubo();
                            $objTubo->setIdTubo($completo['idTubo']);
                            $objTubo->setIdTubo_fk($completo['idTubo_fk']);
                            $objTubo->setIdAmostra_fk($completo['idAmostra_fk']);
                            $objTubo->setTuboOriginal($completo['tuboOriginal']);
                            $objTubo->setTipo($completo['tipo']);


                            $objInfosTubo = new InfosTubo();
                            $objInfosTubo->setIdInfosTubo($completo['idInfosTubo']);
                            $objInfosTubo->setIdUsuario_fk($completo['idUsuario_fk']);
                            $objInfosTubo->setIdPosicao_fk($completo['idPosicao_fk']);
                            $objInfosTubo->setIdTubo_fk($completo['idTubo_fk']);
                            $objInfosTubo->setIdLote_fk($completo['idLote_fk']);
                            $objInfosTubo->setEtapa($completo['etapa']);
                            $objInfosTubo->setEtapaAnterior($completo['etapaAnterior']);
                            $objInfosTubo->setDataHora($completo['dataHora']);
                            $objInfosTubo->setReteste($completo['reteste']);
                            $objInfosTubo->setVolume($completo['volume']);
                            $objInfosTubo->setObsProblema($completo['obsProblema']);
                            $objInfosTubo->setObservacoes($completo['observacoes']);
                            $objInfosTubo->setSituacaoEtapa($completo['situacaoEtapa']);
                            $objInfosTubo->setSituacaoTubo($completo['situacaoTubo']);
                            $objInfosTubo->setIdLocalFk($completo['idLocal_fk']);
                            $objTubo->setObjInfosTubo($objInfosTubo);
                            $objAmostra->setObjTubo($objTubo);
                            $arr_amostras_retorno[] = $objAmostra;
                        }
                    }

                }
            }

            return $arr_amostras_retorno;
        } catch (Throwable $ex) {
            throw new Excecao("Erro validando as amostras.",$ex);
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

}
