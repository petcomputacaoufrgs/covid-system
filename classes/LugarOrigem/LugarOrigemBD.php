<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Banco/Banco.php';
class LugarOrigemBD{
    
     public function listar(LugarOrigem $objLugarOrigem, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tab_municipio where cod_estado = 43";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_marca = array();
            foreach ($arr as $reg){
                $objLugarOrigem = new LugarOrigem();
                $objLugarOrigem->setIdLugarOrigem($reg['cod_municipio']);
                $objLugarOrigem->setNome($reg['nome']);

                $array_marca[] = $objLugarOrigem;
            }
            return $array_marca;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando marca no BD.",$ex);
        }
       
    }
    
    public function consultar(LugarOrigem $objLugarOrigem, Banco $objBanco) {

        try{

            $SELECT = 'SELECT cod_municipio,nome FROM tab_municipio WHERE idLugarOrigem = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objLugarOrigem->getIdLugarOrigem());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $marca = new LugarOrigem();
            $marca->setIdLugarOrigem($arr[0]['cod_municipio']);
            $marca->setNome($arr[0]['nome']);

            return $marca;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando marca no BD.",$ex);
        }

    }
    

    

    
}
