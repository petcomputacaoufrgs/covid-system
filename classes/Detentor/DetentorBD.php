<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Banco/Banco.php';
class DetentorBD{

    public function cadastrar(Detentor $objDetentor, Banco $objBanco) {
        try{
            //echo $objDetentor->getDetentor();
            //die("die");
            $INSERT = 'INSERT INTO tb_detentor (detentor) VALUES (?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objDetentor->getDetentor());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objDetentor->setIdDetentor($objBanco->obterUltimoID());
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando detentor  no BD.",$ex);
        }
        
    }
    
    public function alterar(Detentor $objDetentor, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_detentor SET '
                . ' detentor = ?'
                . '  where idDetentor = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('s',$objDetentor->getDetentor());
            $arrayBind[] = array('i',$objDetentor->getIdDetentor());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando detentor no BD.",$ex);
        }
       
    }
    
     public function listar(Detentor $objDetentor, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_detentor";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_detentor = array();
            foreach ($arr as $reg){
                $objDetentor = new Detentor();
                $objDetentor->setIdDetentor($reg['idDetentor']);
                $objDetentor->setDetentor($reg['detentor']);

                $array_detentor[] = $objDetentor;
            }
            return $array_detentor;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando detentor no BD.",$ex);
        }
       
    }
    
    public function consultar(Detentor $objDetentor, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idDetentor,detentor FROM tb_detentor WHERE idDetentor = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objDetentor->getIdDetentor());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $detentor = new Detentor();
            $detentor->setIdDetentor($arr[0]['idDetentor']);
            $detentor->setDetentor($arr[0]['detentor']);

            return $detentor;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando detentor no BD.",$ex);
        }

    }
    
    public function remover(Detentor $objDetentor, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_detentor WHERE idDetentor = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objDetentor->getIdDetentor());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendo detentor no BD.",$ex);
        }
    }
    
      
    

    
}
