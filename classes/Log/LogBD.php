<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class LogBD{

    public function cadastrar(Log $objLog, Banco $objBanco) {
        try{
            $INSERT = 'INSERT INTO tb_log (idUsuario,texto,dataHora) VALUES (?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objLog->getIdUsuario());
            $arrayBind[] = array('s',$objLog->getTexto());
            $arrayBind[] = array('s',$objLog->getDataHora());

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objLog->setIdLog($objBanco->obterUltimoID());
           
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando o log do erro no BD.",$ex);
        }
        
    }
    
    public function alterar(Log $objLog, Banco $objBanco) {
        try{
                      
            $UPDATE = 'UPDATE tb_log SET '
                    . ' idUsuario = ? ,'
                    . ' texto = ? ,'
                    . ' dataHora = ?'
                . '  where idLog = ?';
        
                
            $arrayBind = array();
             $arrayBind[] = array('i',$objLog->getIdUsuario());
            $arrayBind[] = array('s',$objLog->getTexto());
            $arrayBind[] = array('s',$objLog->getDataHora());
            $arrayBind[] = array('i',$objLog->getIdLog());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando o log do erro  no BD.",$ex);
        }
       
    }
    
     public function listar(Log $objLog, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_log";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_marca = array();
            foreach ($arr as $reg){
                $objLog = new Log();
                $objLog->setIdLog($reg['idLog']);
                $objLog->setDataHora($reg['dataHora']);
                $objLog->setIdUsuario($reg['idUsuario']);
                $objLog->setTexto($reg['texto']);
                

                $array_marca[] = $objLog;
                
            }
            return $array_marca;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando o log do erro  no BD.",$ex);
        }
       
    }
    
    public function consultar(Log $objLog, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idLog ,idUsuario,texto,dataHora FROM tb_log WHERE idLog = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objLog->getIdLog());
            
            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $paciente = new Log();
            $paciente->setIdLog($arr[0]['idLog']);
            $paciente->setDataHora($arr[0]['dataHora']);
            $paciente->setIdUsuario($arr[0]['idUsuario']);
            $paciente->setTexto($arr[0]['texto']);

            return $paciente;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando o log do erro  no BD.",$ex);
        }

    }
    
    public function remover(Log $objLog, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_log WHERE idLog = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objLog->getIdLog());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendo o log do erro  no BD.",$ex);
        }
    }
    
    

    
}
