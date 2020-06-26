<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class ModeloBD{

    public function cadastrar(Modelo $objModelo, Banco $objBanco) {
        try{
            //echo $objModelo->getModelo();
            //die("die");
            $INSERT = 'INSERT INTO tb_modelo (modelo,index_modelo) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objModelo->getModelo());
            $arrayBind[] = array('s',$objModelo->getIndex_modelo());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objModelo->setIdModelo($objBanco->obterUltimoID());
            return $objModelo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando modelo  no BD.",$ex);
        }
        
    }
    
    public function alterar(Modelo $objModelo, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_modelo SET '
                    . ' modelo = ?,'
                    . ' index_modelo = ?'
                    
                . '  where idModelo = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('s',$objModelo->getModelo());
            $arrayBind[] = array('s',$objModelo->getIndex_modelo());
            $arrayBind[] = array('i',$objModelo->getIdModelo());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objModelo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando modelo no BD.",$ex);
        }
       
    }
    
     public function listar(Modelo $objModelo,$numLimite=null, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_modelo";

             $WHERE = '';
             $AND = '';
             $arrayBind = array();
             if($objModelo->getIndex_modelo() != null){
                 $WHERE .= $AND." index_modelo = ?";
                 $AND = ' and ';
                 $arrayBind[] = array('s',$objModelo->getIndex_modelo());
             }

             if($objModelo->getIdModelo() != null){
                 $WHERE .= $AND." idModelo = ?";
                 $AND = ' and ';
                 $arrayBind[] = array('i',$objModelo->getIdModelo());
             }


             if($WHERE != ''){
                 $WHERE = ' where '.$WHERE;
             }

             $LIMIT = '';
             if(!is_null($numLimite)){
                 $LIMIT = ' LIMIT ?';
                 $arrayBind[] = array('i',$numLimite);
             }

             $arr = $objBanco->consultarSQL($SELECT.$WHERE.$LIMIT,$arrayBind);


            $array_modelo = array();
            foreach ($arr as $reg){
                $modelo = new Modelo();
                $modelo->setIdModelo($reg['idModelo']);
                $modelo->setModelo($reg['modelo']);
                $modelo->setIndex_modelo($reg['index_modelo']);

                $array_modelo[] = $modelo;
            }
            return $array_modelo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando modelo no BD.",$ex);
        }
       
    }
    
    public function consultar(Modelo $objModelo, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idModelo,modelo,index_modelo FROM tb_modelo WHERE idModelo = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objModelo->getIdModelo());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $modelo = new Modelo();
            $modelo->setIdModelo($arr[0]['idModelo']);
            $modelo->setModelo($arr[0]['modelo']);
            $modelo->setIndex_modelo($arr[0]['index_modelo']);

            return $modelo;
        } catch (Throwable $ex) {
       
            throw new Excecao("Erro consultando modelo no BD.",$ex);
        }

    }
    
    public function remover(Modelo $objModelo, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_modelo WHERE idModelo = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objModelo->getIdModelo());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo modelo no BD.",$ex);
        }
    }
    
    
    public function pesquisar_index(Modelo $objModelo, Banco $objBanco) {

        try{
            
            $SELECT = 'SELECT * from tb_modelo WHERE index_modelo = ?';
            
            $arrayBind = array();
            $arrayBind[] = array('s',$objModelo->getIndex_modelo());
            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);
            
            if(empty($arr)){
                return $arr;
            }
            $arr_modelos = array();
             
            foreach ($arr as $reg){
                $objModelo = new Modelo();
                $objModelo->setIdModelo($reg['idModelo']);
                $objModelo->setModelo($reg['modelo']);
                $objModelo->setIndex_modelo($reg['index_modelo']);
                $arr_modelos[] = $objModelo;
            }
             return $arr_modelos;
            
        } catch (Throwable $ex) {
            throw new Excecao("Erro pesquisando modelo no BD.",$ex);
        }
    }
    
    

    
}
