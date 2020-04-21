<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class CapelaBD{

    public function cadastrar(Capela $objCapela, Banco $objBanco) {
        try{
            //echo $objCapela->getCapela();
            //die("die");
            $INSERT = 'INSERT INTO tb_capela (numero,statusCapela) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objCapela->getNumero());
            $arrayBind[] = array('s',$objCapela->getStatusCapela());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objCapela->setIdCapela($objBanco->obterUltimoID());
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando a capela paciente no BD.",$ex);
        }
        
    }
    
    public function alterar(Capela $objCapela, Banco $objBanco) {
        try{
            
            $UPDATE = 'UPDATE tb_capela SET '
                    . ' numero = ?,'
                    . ' statusCapela = ?'
                . '  where idCapela = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objCapela->getNumero());
            $arrayBind[] = array('s',$objCapela->getStatusCapela());
            $arrayBind[] = array('i',$objCapela->getIdCapela());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando a capela no BD.",$ex);
        }
       
    }
    
     public function listar(Capela $objCapela, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_capela";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_capelas = array();
            foreach ($arr as $reg){
                $objCapela = new Capela();
                $objCapela->setIdCapela($reg['idCapela']);
                $objCapela->setNumero($reg['numero']);
                $objCapela->setStatusCapela($reg['statusCapela']);

                $array_capelas[] = $objCapela;
            }
            return $array_capelas;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando a capela no BD.",$ex);
        }
       
    }
    
    public function consultar(Capela $objCapela, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idCapela,numero,statusCapela FROM tb_capela WHERE idCapela = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objCapela->getIdCapela());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $capela = new Capela();
            $capela->setIdCapela($arr[0]['idCapela']);
            $capela->setNumero($arr[0]['numero']);
            $capela->setStatusCapela($arr[0]['statusCapela']);

            return $capela;
        } catch (Throwable $ex) {
       
            throw new Excecao("Erro consultando a capela no BD.",$ex);
        }

    }
    
    public function remover(Capela $objCapela, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_capela WHERE idCapela = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objCapela->getIdCapela());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo a capela no BD.",$ex);
        }
    }
    
    public function bloquear_registro(Capela $objCapela, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_capela  WHERE statusCapela = ? FOR UPDATE ';

                   
            $arrayBind = array();
            $arrayBind[] = array('s','LIBERADA');    
            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);
            
            if(empty($arr)){
                return $arr;
            }
            $arr_capelas = array();
             
            foreach ($arr as $reg){
                $capela = new Capela();
                $capela->setIdCapela($reg['idCapela']);
                $capela->setNumero($reg['numero']);
                $capela->setStatusCapela($reg['statusCapela']);
                $arr_capelas[] = $capela;
            }
            return $arr_capelas;

            
        } catch (Throwable $ex) {
       
            throw new Excecao("Erro bloqueando a capela no BD.",$ex);
        }

    }


    public function validar_cadastro(Capela $objCapela, Banco $objBanco) {

        try{
            
            $SELECT = 'SELECT * from tb_capela WHERE numero = ? AND statusCapela = ?';
            
            $arrayBind = array();
            $arrayBind[] = array('i',$objCapela->getNumero());
            $arrayBind[] = array('s',$objCapela->getStatusCapela());
            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);
            
            if(empty($arr)){
                return $arr;
            }
            $arr_capelas = array();
             
            foreach ($arr as $reg){
                $objSexo = new Capela();
                $objSexo->setIdCapela($reg['idCapela']);
                $objSexo->setNumero($reg['numero']);
                $objSexo->setStatusCapela($reg['statusCapela']);
                $arr_capelas[] = $objSexo;
            }
             return $arr_capelas;
            
        } catch (Throwable $ex) {
            throw new Excecao("Erro validando cadastro no BD.",$ex);
        }
    }
    

    
}
