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
            $INSERT = 'INSERT INTO tb_marca (marca) VALUES (?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objMarca->getMarca());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objMarca->setIdMarca($objBanco->obterUltimoID());
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando marca  no BD.",$ex);
        }
        
    }
    
    public function alterar(Marca $objMarca, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_marca SET '
                . ' marca = ?'
                . '  where idMarca = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('s',$objMarca->getMarca());
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

                $array_marca[] = $objMarca;
            }
            return $array_marca;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando marca no BD.",$ex);
        }
       
    }
    
    public function consultar(Marca $objMarca, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idMarca,marca FROM tb_marca WHERE idMarca = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objMarca->getIdMarca());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $marca = new Marca();
            $marca->setIdMarca($arr[0]['idMarca']);
            $marca->setMarca($arr[0]['marca']);

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
    
    

    
}
