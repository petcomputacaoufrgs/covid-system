<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Banco/Banco.php';
require_once 'classes/Excecao/Excecao.php';

class SexoBD{

    public function cadastrar(Sexo $objSexo, Banco $objBanco) {
        try{
            $INSERT = 'INSERT INTO tb_sexo (sexo,index_sexo) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objSexo->getSexo());
            $arrayBind[] = array('s',$objSexo->getIndex_sexo());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objSexo->setIdSexo($objBanco->obterUltimoID());
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando sexo do paciente no BD.",$ex);
        }
        
    }
    
    public function alterar(Sexo $objSexo, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_sexo SET '
                    . ' sexo = ?,'
                    . ' index_sexo = ?'
                . '  where idSexo = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('s',$objSexo->getSexo());
            $arrayBind[] = array('s',$objSexo->getIndex_sexo());
            $arrayBind[] = array('i',$objSexo->getIdSexo());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando sexo do paciente no BD.",$ex);
        }
       
    }
    
     public function listar(Sexo $objSexo, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_sexo";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_sexo = array();
            foreach ($arr as $reg){
                $objSexo = new Sexo();
                $objSexo->setIdSexo($reg['idSexo']);
                $objSexo->setSexo($reg['sexo']);
                $objSexo->setIndex_sexo($reg['index_sexo']);

                $array_sexo[] = $objSexo;
            }
            return $array_sexo;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando sexo do paciente no BD.",$ex);
        }
       
    }
    
    public function consultar(Sexo $objSexo, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idSexo,sexo,index_sexo FROM tb_sexo WHERE idSexo = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objSexo->getIdSexo());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $sexo = new Sexo();
            $sexo->setIdSexo($arr[0]['idSexo']);
            $sexo->setSexo($arr[0]['sexo']);
            $sexo->setIndex_sexo($arr[0]['index_sexo']);

            return $sexo;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando sexo do paciente no BD.",$ex);
        }

    }
    
    public function remover(Sexo $objSexo, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_sexo WHERE idSexo = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objSexo->getIdSexo());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendo sexo do paciente no BD.",$ex);
        }
    }
    
    
    public function pesquisar_index(Sexo $objSexo, Banco $objBanco) {

        try{
            
            $SELECT = 'SELECT * from tb_sexo WHERE index_sexo = ?';
            
            $arrayBind = array();
            $arrayBind[] = array('s',$objSexo->getIndex_sexo());
            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);
            
            if(empty($arr)){
                return $arr;
            }
            $arr_sexos = array();
             
            foreach ($arr as $reg){
                $objSexo = new Sexo();
                $objSexo->setIdSexo($reg['idSexo']);
                $objSexo->setSexo($reg['sexo']);
                $objSexo->setIndex_sexo($reg['index_sexo']);
                $arr_sexos[] = $objSexo;
            }
             return $arr_sexos;
            
        } catch (Exception $ex) {
            throw new Excecao("Erro pesquisando sexo no BD.",$ex);
        }
    }
    

    
}
