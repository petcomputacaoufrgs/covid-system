<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class EtniaBD{

    public function cadastrar(Etnia $objEtnia, Banco $objBanco) {
        try{
            $INSERT = 'INSERT INTO tb_etnia (etnia,index_etnia) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objEtnia->getEtnia());
            $arrayBind[] = array('s',$objEtnia->getIndex_etnia());

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objEtnia->setIdEtnia($objBanco->obterUltimoID());
           
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando a etnia do paciente no BD.",$ex);
        }
        
    }
    
    public function alterar(Etnia $objEtnia, Banco $objBanco) {
        try{
                      
            $UPDATE = 'UPDATE tb_etnia SET '
                    . ' etnia = ? ,'
                    . ' index_etnia = ? '
                . '  where idEtnia = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('s',$objEtnia->getEtnia());
            $arrayBind[] = array('s',$objEtnia->getIndex_etnia());
            $arrayBind[] = array('i',$objEtnia->getIdEtnia());


            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando a etnia do paciente  no BD.",$ex);
        }
       
    }
    
     public function listar(Etnia $objEtnia, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_etnia";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_etnias = array();
            foreach ($arr as $reg){
                $objEtnia = new Etnia();
                $objEtnia->setIdEtnia($reg['idEtnia']);
                $objEtnia->setEtnia($reg['etnia']);
                $objEtnia->setIndex_etnia($reg['index_etnia']);               

                $array_etnias[] = $objEtnia;
                
            }
            return $array_etnias;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando a etnia do paciente  no BD.",$ex);
        }
       
    }
    
    public function consultar(Etnia $objEtnia, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_etnia WHERE idEtnia = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objEtnia->getIdEtnia());
            
            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $etnia = new Etnia();
            $etnia->setIdEtnia($arr[0]['idEtnia']);
            $etnia->setEtnia($arr[0]['etnia']);
            $etnia->setIndex_etnia($arr[0]['index_etnia']);

            return $etnia;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando a etnia do paciente  no BD.",$ex);
        }

    }
    
    public function remover(Etnia $objEtnia, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_etnia WHERE idEtnia = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objEtnia->getIdEtnia());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendo a etnia do paciente  no BD.",$ex);
        }
    }
    
    public function pesquisar_index(Etnia $objEtnia, Banco $objBanco) {

        try{
            
            $SELECT = 'SELECT * from tb_etnia WHERE index_etnia = ?';
            
            $arrayBind = array();
            $arrayBind[] = array('s',$objEtnia->getIndex_etnia());
            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);
            
            if(empty($arr)){
                return $arr;
            }
            $arr_etnias = array();
             
            foreach ($arr as $reg){
                $etnia = new Etnia();
                $etnia->setIdEtnia($reg['idEtnia']);
                $etnia->setEtnia($reg['etnia']);
                $etnia->setIndex_etnia($reg['index_etnia']);
                $arr_etnias[] = $etnia;
            }
             return $arr_etnias;
            
        } catch (Exception $ex) {
            throw new Excecao("Erro pesquisando a etnia do paciente  no BD.",$ex);
        }
    }
    

    
}
