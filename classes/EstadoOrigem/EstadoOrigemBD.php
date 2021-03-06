<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class EstadoOrigemBD{
    
     public function listar(EstadoOrigem $objEstadoOrigem, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tab_estado";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_marca = array();
            foreach ($arr as $reg){
                $objEstadoOrigem = new EstadoOrigem();
                $objEstadoOrigem->setCod_estado($reg['cod_estado']);
                $objEstadoOrigem->setSigla($reg['sigla']);
                $objEstadoOrigem->setNome($reg['nome']);

                $array_marca[] = $objEstadoOrigem;
            }
            return $array_marca;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando marca no BD.",$ex);
        }
       
    }
    
    public function consultar(EstadoOrigem $objEstadoOrigem, Banco $objBanco) {

        try{

            $SELECT = 'SELECT cod_estado,sigla,nome FROM tab_estado WHERE cod_estado = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objEstadoOrigem->getCod_estado());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);


            if(count($arr) >0 ) {
                $estadoOrigem = new EstadoOrigem();
                $estadoOrigem->setCod_estado($arr[0]['cod_estado']);
                $estadoOrigem->setSigla($arr[0]['sigla']);
                $estadoOrigem->setNome($arr[0]['nome']);
                return $estadoOrigem;
            }



            //throw new Throwable("Nenhum registro encontrado na consulta");

        } catch (Throwable $ex) {
       
            throw new Excecao("Erro consultando marca no BD.",$ex);
        }

    }
    

    

    
}
