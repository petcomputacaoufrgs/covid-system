<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Banco/Banco.php';
class ModeloBD{

    public function cadastrar(Modelo $objModelo, Banco $objBanco) {
        try{
            //echo $objModelo->getModelo();
            //die("die");
            $INSERT = 'INSERT INTO tb_modelo (modelo) VALUES (?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objModelo->getModelo());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objModelo->setIdModelo($objBanco->obterUltimoID());
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando modelo  no BD.",$ex);
        }
        
    }
    
    public function alterar(Modelo $objModelo, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_modelo SET '
                . ' modelo = ?'
                . '  where idModelo = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('s',$objModelo->getModelo());
            $arrayBind[] = array('i',$objModelo->getIdModelo());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando modelo no BD.",$ex);
        }
       
    }
    
     public function listar(Modelo $objModelo, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_modelo";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_modelo = array();
            foreach ($arr as $reg){
                $objModelo = new Modelo();
                $objModelo->setIdModelo($reg['idModelo']);
                $objModelo->setModelo($reg['modelo']);

                $array_modelo[] = $objModelo;
            }
            return $array_modelo;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando modelo no BD.",$ex);
        }
       
    }
    
    public function consultar(Modelo $objModelo, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idModelo,modelo FROM tb_modelo WHERE idModelo = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objModelo->getIdModelo());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $modelo = new Modelo();
            $modelo->setIdModelo($arr[0]['idModelo']);
            $modelo->setModelo($arr[0]['modelo']);

            return $modelo;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando modelo no BD.",$ex);
        }

    }
    
    public function remover(Modelo $objModelo, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_modelo WHERE idModelo = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objModelo->getIdModelo());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendo modelo no BD.",$ex);
        }
    }
    
    

    
}
