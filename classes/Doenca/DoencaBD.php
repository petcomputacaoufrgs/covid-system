<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Banco/Banco.php';
class DoencaBD{

    public function cadastrar(Doenca $objDoenca, Banco $objBanco) {
        try{
            //echo $objDoenca->getDoenca();
            //die("die");
            $INSERT = 'INSERT INTO tb_doenca (doenca) VALUES (?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objDoenca->getDoenca());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objDoenca->setIdDoenca($objBanco->obterUltimoID());
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando doença paciente no BD.",$ex);
        }
        
    }
    
    public function alterar(Doenca $objDoenca, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_doenca SET '
                . ' doenca = ?'
                . '  where idDoenca = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('s',$objDoenca->getDoenca());
            $arrayBind[] = array('i',$objDoenca->getIdDoenca());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando doença no BD.",$ex);
        }
       
    }
    
     public function listar(Doenca $objDoenca, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_doenca";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_doença = array();
            foreach ($arr as $reg){
                $objDoenca = new Doenca();
                $objDoenca->setIdDoenca($reg['idDoenca']);
                $objDoenca->setDoenca($reg['doenca']);

                $array_doença[] = $objDoenca;
            }
            return $array_doença;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando doença no BD.",$ex);
        }
       
    }
    
    public function consultar(Doenca $objDoenca, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idDoenca,doenca FROM tb_doenca WHERE idDoenca = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objDoenca->getIdDoenca());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $doença = new Doenca();
            $doença->setIdDoenca($arr[0]['idDoenca']);
            $doença->setDoenca($arr[0]['doenca']);

            return $doença;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando doença no BD.",$ex);
        }

    }
    
    public function remover(Doenca $objDoenca, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_doenca WHERE idDoenca = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objDoenca->getIdDoenca());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendo doença no BD.",$ex);
        }
    }
    
    

    
}
