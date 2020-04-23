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
                    . 'obsMotivo'
                    . ')' 
                    . 'VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';

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
            
            
                        

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objAmostra->setIdAmostra($objBanco->obterUltimoID());
           
        } catch (Exception $ex) {
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
                    . 'obsMotivo =?'
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
            
            $arrayBind[] = array('i',$objAmostra->getIdAmostra());
            

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
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
                
                

                $array_paciente[] = $objAmostra;
                
            }
            return $array_paciente;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando a amostra no BD.",$ex);
        }
       
    }
    
    public function consultar(Amostra $objAmostra, Banco $objBanco) {

        try{

            $SELECT = 'SELECT *  FROM tb_amostra WHERE idAmostra = ?';


            $arrayBind = array();
            $arrayBind[] = array('i',$objAmostra->getIdAmostra());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);
            
            if($arr != null){
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
            return $objAmostra;
            }
            return null;
            
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando a amostra no BD.",$ex);
        }

    }
    
    public function remover(Amostra $objAmostra, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_amostra WHERE idAmostra = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objAmostra->getIdAmostra());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendo a amostra no BD.",$ex);
        }
    }


    public function filtro_menor_data(Amostra $objAmostra,$select, Banco $objBanco) {
        try{


            $SELECT = "SELECT * FROM tb_amostra ";
            $WHERE = '';
            $AND = '';
            $OR = '';
            $arrayBind = array();


            foreach ($select as $s) {

                    $WHERE .= $OR . " idPerfilPaciente_fk = ".$s;
                    $OR = ' OR ';
                    //$arrayBind[] = array('i', $s);

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


                    $array_paciente[] = $objAmostra;

                }
                return $array_paciente;
            }
            return null;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando a amostra no BD.",$ex);
        }

    }




}
