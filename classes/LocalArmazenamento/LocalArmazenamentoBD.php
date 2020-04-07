<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Banco/Banco.php';
class LocalArmazenamentoBD{

    public function cadastrar(LocalArmazenamento $objLocalArmazenamento, Banco $objBanco) {
        try{
            //echo $objLocalArmazenamento->getLocalArmazenamento();
            //die("die");
            $INSERT = 'INSERT INTO tb_localArmazenamento (idTipoLocal_fk,idTempoPermanencia_fk,dataHoraInicio, dataHoraFim) VALUES (?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objLocalArmazenamento->getIdTipoLocal_fk());
            $arrayBind[] = array('i',$objLocalArmazenamento->getIdTempoPermanencia_fk());
            $arrayBind[] = array('s',$objLocalArmazenamento->getDataHoraInicio());
            $arrayBind[] = array('s',$objLocalArmazenamento->getDataHoraFim());

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objLocalArmazenamento->setIdLocalArmazenamento($objBanco->obterUltimoID());
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando armazenamento  no BD.",$ex);
        }
        
    }
    
    public function alterar(LocalArmazenamento $objLocalArmazenamento, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_localArmazenamento SET '
                    . ' idTipoLocal_fk = ? ,'
                    . ' idTempoPermanencia_fk = ? ,'
                    . ' dataHoraInicio = ? ,'
                    . ' dataHoraFim = ? '
                . '  where idLocalArmazenamento = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objLocalArmazenamento->getIdTipoLocal_fk());
            $arrayBind[] = array('i',$objLocalArmazenamento->getIdTempoPermanencia_fk());
            $arrayBind[] = array('s',$objLocalArmazenamento->getDataHoraInicio());
            $arrayBind[] = array('s',$objLocalArmazenamento->getDataHoraFim());
            $arrayBind[] = array('i',$objLocalArmazenamento->getIdLocalArmazenamento());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando armazenamento no BD.",$ex);
        }
       
    }
    
     public function listar(LocalArmazenamento $objLocalArmazenamento, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_localArmazenamento";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_detentor = array();
            foreach ($arr as $reg){
                $objLocalArmazenamento = new LocalArmazenamento();
                $objLocalArmazenamento->setIdLocalArmazenamento($reg['idLocalArmazenamento']);
                $objLocalArmazenamento->setIdTipoLocal_fk($reg['idTipoLocal_fk']);
                $objLocalArmazenamento->setIdTempoPermanencia_fk($reg['idTempoPermanencia_fk']);
                $objLocalArmazenamento->setDataHoraInicio($reg['dataHoraInicio']);
                $objLocalArmazenamento->setDataHoraFim($reg['dataHoraFim']);

                $array_detentor[] = $objLocalArmazenamento;
            }
            return $array_detentor;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando armazenamento no BD.",$ex);
        }
       
    }
    
    public function consultar(LocalArmazenamento $objLocalArmazenamento, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idLocalArmazenamento,idTipoLocal_fk,idTempoPermanencia_fk,dataHoraInicio, dataHoraFim FROM tb_localArmazenamento WHERE idLocalArmazenamento = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objLocalArmazenamento->getIdLocalArmazenamento());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

             $localArmazenamento  = new LocalArmazenamento();
             $localArmazenamento ->setIdLocalArmazenamento($arr[0]['idLocalArmazenamento']);
             $localArmazenamento ->setIdTipoLocal_fk($arr[0]['idTipoLocal_fk']);
             $localArmazenamento ->setIdTempoPermanencia_fk($arr[0]['idTempoPermanencia_fk']);
             $localArmazenamento ->setDataHoraInicio($arr[0]['dataHoraInicio']);
             $localArmazenamento ->setDataHoraFim($arr[0]['dataHoraFim']);

            return  $localArmazenamento ;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando armazenamento no BD.",$ex);
        }

    }
    
    public function remover(LocalArmazenamento $objLocalArmazenamento, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_localArmazenamento WHERE idLocalArmazenamento = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objLocalArmazenamento->getIdLocalArmazenamento());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendo armazenamento no BD.",$ex);
        }
    }
    
      
    

    
}
