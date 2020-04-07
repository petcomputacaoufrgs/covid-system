<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Banco/Banco.php';
class TempoPermanenciaBD{

    public function cadastrar(TempoPermanencia $objTempoPermanencia, Banco $objBanco) {
        try{
          
            $INSERT = 'INSERT INTO tb_tempoPermanencia (tempoPermanencia) VALUES (?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objTempoPermanencia->getTempoPermanencia());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objTempoPermanencia->setIdTempoPermanencia($objBanco->obterUltimoID());
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando o tempo de permanência  no BD.",$ex);
        }
        
    }
    
    public function alterar(TempoPermanencia $objTempoPermanencia, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_tempoPermanencia SET '
                . ' tempoPermanencia = ?'
                . '  where idTempoPermanencia = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('s',$objTempoPermanencia->getTempoPermanencia());
            $arrayBind[] = array('i',$objTempoPermanencia->getIdTempoPermanencia());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando o tempo de permanência no BD.",$ex);
        }
       
    }
    
     public function listar(TempoPermanencia $objTempoPermanencia, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_tempoPermanencia";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_permanencia = array();
            foreach ($arr as $reg){
                $objTempoPermanencia = new TempoPermanencia();
                $objTempoPermanencia->setIdTempoPermanencia($reg['idTempoPermanencia']);
                $objTempoPermanencia->setTempoPermanencia($reg['tempoPermanencia']);

                $array_permanencia[] = $objTempoPermanencia;
            }
            return $array_permanencia;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando o tempo de permanência no BD.",$ex);
        }
       
    }
    
    public function consultar(TempoPermanencia $objTempoPermanencia, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idTempoPermanencia,tempoPermanencia FROM tb_tempoPermanencia WHERE idTempoPermanencia = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objTempoPermanencia->getIdTempoPermanencia());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $permanencia = new TempoPermanencia();
            $permanencia->setIdTempoPermanencia($arr[0]['idTempoPermanencia']);
            $permanencia->setTempoPermanencia($arr[0]['tempoPermanencia']);

            return $permanencia;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando o tempo de permanência no BD.",$ex);
        }

    }
    
    public function remover(TempoPermanencia $objTempoPermanencia, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_tempoPermanencia WHERE idTempoPermanencia = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objTempoPermanencia->getIdTempoPermanencia());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendo o tempo de permanência no BD.",$ex);
        }
    }
    
      
    

    
}
