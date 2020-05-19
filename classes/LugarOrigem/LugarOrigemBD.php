<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class LugarOrigemBD{
    
     public function listar(LugarOrigem $objLugarOrigem, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT tab_municipio.cod_municipio,tab_municipio.nome,tab_municipio.cod_estado,tab_estado.sigla
                        FROM tab_municipio, tab_estado where
                        tab_municipio.cod_estado = tab_estado.cod_estado";

             $WHERE = '';
             $AND = 'and';
             $arrayBind = array();

             if ($objLugarOrigem->getCod_estado() != null) {
                 $WHERE .= $AND . " cod_estado = ?";
                 $AND = ' and ';
                 $arrayBind[] = array('i', $objLugarOrigem->getCod_estado() );
             }

             if ($objLugarOrigem->getNome() != null) {
                 $WHERE .= $AND . " nome = ?";
                 $AND = ' and ';
                 $arrayBind[] = array('s', $objLugarOrigem->getNome());
             }


             if ($WHERE != '') {
                 $WHERE = ' where ' . $WHERE;
             }

             //echo $SELECT.$WHERE;$WHERE

             $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);


            $array = array();
            foreach ($arr as $reg){
                $objLugarOrigem = new LugarOrigem();
                $objLugarOrigem->setIdLugarOrigem($reg['cod_municipio']);
                $objLugarOrigem->setNome($reg['nome']);
                $objLugarOrigem->setCod_estado($reg['cod_estado']);

                $objEstadoOrigem = new EstadoOrigem();
                $objEstadoOrigem->setCod_estado($reg['cod_estado']);
                $objEstadoOrigem->setSigla($reg['sigla']);
                $objLugarOrigem->setObjEstado($objEstadoOrigem);

                $array[] = $objLugarOrigem;
            }
            return $array;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando marca no BD.",$ex);
        }
       
    }
    
    public function consultar(LugarOrigem $objLugarOrigem, Banco $objBanco) {

        try{

            $SELECT = 'SELECT cod_municipio,nome,cod_estado FROM tab_municipio WHERE cod_municipio = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objLugarOrigem->getIdLugarOrigem());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $marca = new LugarOrigem();
            $marca->setIdLugarOrigem($arr[0]['cod_municipio']);
            $marca->setNome($arr[0]['nome']);
            $marca->setCod_estado($arr[0]['cod_estado']);

            return $marca;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando marca no BD.",$ex);
        }

    }
    

    

    
}
