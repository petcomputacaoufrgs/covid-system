<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Banco/Banco.php';
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
        } catch (Exception $ex) {
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

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando marca no BD.",$ex);
        }
       
    }
    
     public function listar(Marca $objMarca, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_marca";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_marca = array();
            foreach ($arr as $reg){
                $objMarca = new Marca();
                $objMarca->setIdMarca($reg['idMarca']);
                $objMarca->setMarca($reg['marca']);
                $objMarca->setIndex_marca($reg['index_marca']);

                $array_marca[] = $objMarca;
            }
            return $array_marca;
        } catch (Exception $ex) {
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
            $marca->setMarca($arr[0]['index_marca']);

            return $marca;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando marca no BD.",$ex);
        }

    }
    
    public function remover(Marca $objMarca, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_marca WHERE idMarca = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objMarca->getIdMarca());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
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
            
        } catch (Exception $ex) {
            throw new Excecao("Erro pesquisando marca no BD.",$ex);
        }
    }
    

    
}
