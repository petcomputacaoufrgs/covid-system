<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class TuboBD{

    public function cadastrar(Tubo $objTubo, Banco $objBanco) {
        try{
            //echo $objTubo->getTubo();
            $INSERT = 'INSERT INTO tb_tubo ('
                    . 'idTubo_fk,'
                    . 'idAmostra_fk,'
                    . 'tuboOriginal'
                    . ')' 
                    . 'VALUES (?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objTubo->getIdTubo_fk());
            $arrayBind[] = array('i',$objTubo->getIdAmostra_fk());
            $arrayBind[] = array('s',$objTubo->getTuboOriginal());
                       

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objTubo->setIdTubo($objBanco->obterUltimoID());
           
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando o tubo no BD.",$ex);
        }
        
    }
    
    public function alterar(Tubo $objTubo, Banco $objBanco) {
        try{
                      
            $UPDATE = 'UPDATE tb_tubo SET '
                    . 'idTubo_fk =? ,'
                    . 'idAmostra_fk =?,'
                    . 'tuboOriginal =?'
                . '  where idTubo = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objTubo->getIdTubo_fk());
            $arrayBind[] = array('i',$objTubo->getIdAmostra_fk());
            $arrayBind[] = array('s',$objTubo->getTuboOriginal());
            $arrayBind[] = array('i',$objTubo->getIdTubo());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando o tubo no BD.",$ex);
        }
       
    }
    
     public function listar(Tubo $objTubo, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_tubo";


            $arr = $objBanco->consultarSQL($SELECT);
 
            $array_tubos = array();
            foreach ($arr as $reg){
                $objTubo = new Tubo();
                $objTubo->setIdTubo($reg['idTubo']);
                $objTubo->setIdTubo_fk($reg['idTubo_fk']);
                $objTubo->setIdAmostra_fk($reg['idAmostra_fk']);
                $objTubo->setTuboOriginal($reg['tuboOriginal']);
               
                $array_tubos[] = $objTubo;
                
            }
            return $array_tubos;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando o tubo no BD.",$ex);
        }
       
    }
    
    public function consultar(Tubo $objTubo, Banco $objBanco) {

        try{

            $SELECT = 'SELECT *  FROM tb_tubo WHERE idTubo = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objTubo->getIdTubo());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $objTubo = new Tubo();
            $objTubo->setIdTubo($arr[0]['idTubo']);
            $objTubo->setIdTubo_fk($arr[0]['idTubo_fk']);
            $objTubo->setIdAmostra_fk($arr[0]['idAmostra_fk']);
            $objTubo->setTuboOriginal($arr[0]['tuboOriginal']);
            

            return $objTubo;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando o tubo no BD.",$ex);
        }

    }
    
    public function remover(Tubo $objTubo, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_tubo WHERE idTubo = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objTubo->getIdTubo());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendo o tubo no BD.",$ex);
        }
    }
    
    

    
}
