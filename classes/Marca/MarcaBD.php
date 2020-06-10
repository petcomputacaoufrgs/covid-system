<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class MarcaBD{

    public function cadastrar(Marca $objMarca, Banco $objBanco) {
        try{
            //echo $objMarca->getMarca();
            //die("die");
            $INSERT = 'INSERT INTO tb_marca (marca,index_marca) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objMarca->getMarca());
            $arrayBind[] = array('s',$objMarca->getIndex_marca());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objMarca->setIdMarca($objBanco->obterUltimoID());
            return $objMarca;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando marca  no BD.",$ex);
        }
        
    }
    
    public function alterar(Marca $objMarca, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_marca SET '
                    . ' marca = ?,'
                    . ' index_marca = ?'
                . '  where idMarca = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('s',$objMarca->getMarca());
            $arrayBind[] = array('s',$objMarca->getIndex_marca());
            $arrayBind[] = array('i',$objMarca->getIdMarca());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objMarca;

        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando marca no BD.",$ex);
        }
       
    }
    
     public function listar(Marca $objMarca,$numLimite=null, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_marca";

             $WHERE = '';
             $AND = '';
             $arrayBind = array();
             if($objMarca->getIndex_marca() != null){
                 $WHERE .= $AND." index_marca = ?";
                 $AND = ' and ';
                 $arrayBind[] = array('s',$objMarca->getIndex_marca());
             }

             if($objMarca->getIdMarca() != null){
                 $WHERE .= $AND." idMarca = ?";
                 $AND = ' and ';
                 $arrayBind[] = array('i',$objMarca->getIdMarca() );
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
            $array_marca = array();
            foreach ($arr as $reg){
                $marca = new Marca();
                $marca->setIdMarca($reg['idMarca']);
                $marca->setMarca($reg['marca']);
                $marca->setIndex_marca($reg['index_marca']);

                $array_marca[] = $marca;
            }
            return $array_marca;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando marca no BD.",$ex);
        }
       
    }
    
    public function consultar(Marca $objMarca, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idMarca,marca,index_marca FROM tb_marca WHERE idMarca = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objMarca->getIdMarca());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $marca = new Marca();
            $marca->setIdMarca($arr[0]['idMarca']);
            $marca->setMarca($arr[0]['marca']);
            $marca->setIndex_marca($arr[0]['index_marca']);

            return $marca;
        } catch (Throwable $ex) {
       
            throw new Excecao("Erro consultando marca no BD.",$ex);
        }

    }
    
    public function remover(Marca $objMarca, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_marca WHERE idMarca = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objMarca->getIdMarca());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo marca no BD.",$ex);
        }
    }
    
    
    public function pesquisar_index(Marca $objMarca, Banco $objBanco) {

        try{
            
            $SELECT = 'SELECT * from tb_marca WHERE index_marca = ?';
            
            $arrayBind = array();
            $arrayBind[] = array('s',$objMarca->getIndex_marca());
            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);
            
            if(empty($arr)){
                return $arr;
            }
            $arr_marcas = array();
             
            foreach ($arr as $reg){
                $objMarca = new Marca();
                $objMarca->setIdMarca($reg['idMarca']);
                $objMarca->setMarca($reg['marca']);
                $objMarca->setIndex_marca($reg['index_marca']);
                $arr_marcas[] = $objMarca;
            }
             return $arr_marcas;
            
        } catch (Throwable $ex) {
            throw new Excecao("Erro pesquisando marca no BD.",$ex);
        }
    }
    

    
}
