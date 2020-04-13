<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class CodigoGAL_BD{

    public function cadastrar(CodigoGAL $objCodigoGAL, Banco $objBanco) {
        try{
            $INSERT = 'INSERT INTO tb_codGAL (codigo,idPaciente_fk) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objCodigoGAL->getCodigo());
            $arrayBind[] = array('i',$objCodigoGAL->getIdPaciente_fk());

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objCodigoGAL->setIdCodigoGAL($objBanco->obterUltimoID());
           
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando o código GAL no BD.",$ex);
        }
        
    }
    
    public function alterar(CodigoGAL $objCodigoGAL, Banco $objBanco) {
        try{
                      
            $UPDATE = 'UPDATE tb_codGAL SET '
                    . ' codigo = ? ,'
                    . ' idPaciente_fk = ?'
                . '  where idCodigoGAL = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objCodigoGAL->getCodigo());
            $arrayBind[] = array('i',$objCodigoGAL->getIdPaciente_fk());
            $arrayBind[] = array('i',$objCodigoGAL->getIdCodigoGAL());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando o código GAL  no BD.",$ex);
        }
       
    }
    
     public function listar(CodigoGAL $objCodigoGAL, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_codGAL";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_marca = array();
            foreach ($arr as $reg){
                $objCodigoGAL = new CodigoGAL();
                $objCodigoGAL->setIdCodigoGAL($reg['idCodigoGAL']);
                $objCodigoGAL->setCodigo($reg['codigo']);
                $objCodigoGAL->setIdPaciente_fk($reg['idPaciente_fk']);
                

                $array_marca[] = $objCodigoGAL;
                
            }
            return $array_marca;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando o código GAL  no BD.",$ex);
        }
       
    }
    
    public function consultar(CodigoGAL $objCodigoGAL, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idCodigoGAL,codigo,idPaciente_fk FROM tb_codGAL WHERE idCodigoGAL = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objCodigoGAL->getIdCodigoGAL());
            
            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $paciente = new CodigoGAL();
            $paciente->setIdCodigoGAL($arr[0]['idCodigoGAL']);
            $paciente->setCodigo($arr[0]['codigo']);
            $paciente->setIdPaciente_fk($arr[0]['idPaciente_fk']);

            return $paciente;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando o código GAL  no BD.",$ex);
        }

    }
    
    public function remover(CodigoGAL $objCodigoGAL, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_codGAL WHERE idCodigoGAL = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objCodigoGAL->getIdCodigoGAL());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendo o código GAL  no BD.",$ex);
        }
    }
    
    

    
}
