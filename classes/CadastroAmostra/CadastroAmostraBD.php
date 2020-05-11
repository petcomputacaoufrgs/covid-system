<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class CadastroAmostraBD{

    public function cadastrar(CadastroAmostra $objCadastroAmostra, Banco $objBanco) {
        try{
            
            $INSERT = 'INSERT INTO tb_cadastroamostra (idUsuario_fk,idLocalArmazenamento_fk,idAmostra_fk,dataCadastroInicio,'
                    . 'dataCadastroFim) VALUES (?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objCadastroAmostra->getIdUsuario_fk());
            $arrayBind[] = array('i',$objCadastroAmostra->getIdLocalArmazenamento_fk());
            $arrayBind[] = array('i',$objCadastroAmostra->getIdAmostra_fk());
            $arrayBind[] = array('s',$objCadastroAmostra->getDataHoraInicio());            
            $arrayBind[] = array('s',$objCadastroAmostra->getDataHoraFim());
            
            
            $objBanco->executarSQL($INSERT,$arrayBind);
            //$objCadastroAmostra->setIdAmostra_fk($objBanco->obterUltimoID());
            
           return $objCadastroAmostra;
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando o paciente  no BD.",$ex);
        }
        
    }
    
    public function alterar(CadastroAmostra $objCadastroAmostra, Banco $objBanco) {
        try{
                      
            $UPDATE = 'UPDATE tb_cadastroamostra SET '
                    . ' idUsuario_fk = ?,'
                    . ' idLocalArmazenamento_fk = ?,'
                    . ' idAmostra_fk = ?,'
                    . ' dataCadastroInicio = ?,'
                    . ' dataCadastroFim = ?'
                . '  where idCadastroAmostra = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objCadastroAmostra->getIdUsuario_fk());
            $arrayBind[] = array('i',$objCadastroAmostra->getIdLocalArmazenamento_fk());
            $arrayBind[] = array('i',$objCadastroAmostra->getIdAmostra_fk());
            $arrayBind[] = array('s',$objCadastroAmostra->getDataHoraInicio());
            $arrayBind[] = array('s',$objCadastroAmostra->getDataHoraFim());
            $arrayBind[] = array('i',$objCadastroAmostra->getIdCadastroAmostra());
            
            
            $arrayBind[] = array('i',$objCadastroAmostra->getIdCadastroAmostra());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando o paciente no BD.",$ex);
        }
       
    }
    
     public function listar(CadastroAmostra $objCadastroAmostra, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_cadastroamostra";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_paciente = array();
            foreach ($arr as $reg){
                $objCadastroAmostra = new CadastroAmostra();
                $objCadastroAmostra->setIdCadastroAmostra($reg['idCadastroAmostra']);
                $objCadastroAmostra->setIdUsuario_fk($reg['idUsuario_fk']);
                $objCadastroAmostra->setIdAmostra_fk($reg['idAmostra_fk']);
                $objCadastroAmostra->setIdLocalArmazenamento_fk($reg['idLocalArmazenamento_fk']);
                $objCadastroAmostra->setDataHoraFim($reg['dataCadastroFim']);
                $objCadastroAmostra->setDataHoraInicio($reg['dataCadastroInicio']);
                
                

                $array_paciente[] = $objCadastroAmostra;
                
            }
            return $array_paciente;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando o paciente no BD.",$ex);
        }
       
    }
    
    public function consultar(CadastroAmostra $objCadastroAmostra, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_cadastroamostra WHERE idUsuario_fk = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objCadastroAmostra->getIdUsuario_fk());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $paciente = new CadastroAmostra();
            $paciente->setIdCadastroAmostra($arr[0]['idCadastroAmostra']);
            $paciente->setIdUsuario_fk($arr[0]['idUsuario_fk']);
            $paciente->setIdLocalArmazenamento_fk($arr[0]['idLocalArmazenamento_fk']);
            $paciente->setIdAmostra_fk($arr[0]['idAmostra_fk']);
            $paciente->setDataHoraInicio($arr[0]['dataCadastroInicio']); 
            $paciente->setDataHoraFim($arr[0]['dataCadastroFim']);
            

            return $paciente;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando o paciente no BD.",$ex);
        }

    }
    
    public function remover(CadastroAmostra $objCadastroAmostra, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_cadastroamostra WHERE idCadastroAmostra = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objCadastroAmostra->getIdCadastroAmostra());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendo o paciente no BD.",$ex);
        }
    }
    
 
   
}
