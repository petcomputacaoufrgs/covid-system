<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once '../classes/Banco/Banco.php';
class AmostraBD{

    public function cadastrar(Amostra $objAmostra, Banco $objBanco) {
        try{
            //echo $objAmostra->getAmostra();
            $INSERT = 'INSERT INTO tb_amostra (idPaciente_fk,cod_estado_fk,cod_municipio_fk,'
                    . 'idCodGAL_fk,idNivelPrioridade_fk,observacoes,dataHoraColeta,a_r,statusAmostra)' 
                    . 'VALUES (?,?,?,?,?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objAmostra->getIdPaciente_fk());
            $arrayBind[] = array('i',$objAmostra->getIdEstado_fk());
            $arrayBind[] = array('i',$objAmostra->getIdLugarOrigem_fk());
            $arrayBind[] = array('i',$objAmostra->getIdCodGAL_fk());
            $arrayBind[] = array('i',$objAmostra->getIdNivelPrioridade_fk());
            $arrayBind[] = array('s',$objAmostra->getObservacoes());
            $arrayBind[] = array('s',$objAmostra->getDataHoraColeta());
            $arrayBind[] = array('s',$objAmostra->getAceita_recusa());
            $arrayBind[] = array('s',$objAmostra->getStatusAmostra());
                        

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objAmostra->setIdAmostra($objBanco->obterUltimoID());
           
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando a amostra no BD.",$ex);
        }
        
    }
    
    public function alterar(Amostra $objAmostra, Banco $objBanco) {
        try{
                      
            $UPDATE = 'UPDATE tb_amostra SET '
                    . ' idPaciente_fk = ?,'
                    . ' cod_estado_fk = ?,'
                    . ' cod_municipio_fk = ?,'
                    . ' idCodGAL_fk = ?,'
                    . ' idNivelPrioridade_fk = ?,'
                    . ' observacoes = ?,'
                    . ' dataHoraColeta = ?,'
                    . ' a_r = ?,'
                    . ' statusAmostra = ?'
                . '  where idAmostra = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objAmostra->getIdPaciente_fk());
            $arrayBind[] = array('i',$objAmostra->getIdEstado_fk());
            $arrayBind[] = array('i',$objAmostra->getIdLugarOrigem_fk());
            $arrayBind[] = array('i',$objAmostra->getIdCodGAL_fk());
            $arrayBind[] = array('i',$objAmostra->getIdNivelPrioridade_fk());
            $arrayBind[] = array('s',$objAmostra->getObservacoes());
            $arrayBind[] = array('s',$objAmostra->getDataHoraColeta());
            $arrayBind[] = array('s',$objAmostra->getAceita_recusa());
            $arrayBind[] = array('s',$objAmostra->getStatusAmostra());
            $arrayBind[] = array('i',$objAmostra->getIdAmostra());
            

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando a amostra no BD.",$ex);
        }
       
    }
    
     public function listar(Amostra $objAmostra, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_amostra";


            $arr = $objBanco->consultarSQL($SELECT);
 
            $array_paciente = array();
            foreach ($arr as $reg){
                $objAmostra = new Amostra();
                $objAmostra->setIdAmostra($reg['idAmostra']);
                $objAmostra->setIdPaciente_fk($reg['idPaciente_fk']);
                $objAmostra->setIdCodGAL_fk($reg['idCodGAL_fk']);
                $objAmostra->setIdNivelPrioridade_fk($reg['idNivelPrioridade_fk']);
                $objAmostra->setIdEstado_fk($reg['cod_estado_fk']);
                $objAmostra->setIdLugarOrigem_fk($reg['cod_municipio_fk']);
                $objAmostra->setObservacoes($reg['observacoes']);
                $objAmostra->setDataHoraColeta($reg['dataHoraColeta']);
                $objAmostra->setAceita_recusa($reg['a_r']);
                $objAmostra->setStatusAmostra($reg['statusAmostra']);
                

                $array_paciente[] = $objAmostra;
                
            }
            return $array_paciente;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando a amostra no BD.",$ex);
        }
       
    }
    
    public function consultar(Amostra $objAmostra, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idAmostra,idPaciente_fk,cod_estado_fk,cod_municipio_fk,'
                    . 'idCodGAL_fk,idNivelPrioridade_fk,observacoes,dataHoraColeta,'
                    . 'a_r,statusAmostra '
                    . ' FROM tb_amostra WHERE idAmostra = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objAmostra->getIdAmostra());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $objAmostra = new Amostra();
            $objAmostra->setIdAmostra($arr[0]['idAmostra']);
            $objAmostra->setIdPaciente_fk($arr[0]['idPaciente_fk']);
            $objAmostra->setIdEstado_fk($arr[0]['cod_estado_fk']);
            $objAmostra->setIdLugarOrigem_fk($arr[0]['cod_municipio_fk']);
            $objAmostra->setIdCodGAL_fk($arr[0]['idCodGAL_fk']);
            $objAmostra->setIdNivelPrioridade_fk($arr[0]['idNivelPrioridade_fk']);
            $objAmostra->setObservacoes($arr[0]['observacoes']);
            $objAmostra->setDataHoraColeta($arr[0]['dataHoraColeta']);
            $objAmostra->setAceita_recusa($arr[0]['a_r']);
            $objAmostra->setStatusAmostra($arr[0]['statusAmostra']);

            return $objAmostra;
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
    
    

    
}
