<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Banco/Banco.php';
class Rel_codGAL_paciente_BD{

    public function cadastrar(Rel_codGAL_paciente $objRel_codGAL_paciente, Banco $objBanco) {
        try{
            $INSERT = 'INSERT INTO tb_rel_codGAL_paciente (idPaciente_fk,idCodGAL_fk) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_codGAL_paciente->getIdPaciente_fk());
            $arrayBind[] = array('i',$objRel_codGAL_paciente->getIdCodigoGAL_fk());

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objRel_codGAL_paciente->setIdRel_codGAL_paciente($objBanco->obterUltimoID());
           
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando o relacionamento do código GAL com o paciente no BD.",$ex);
        }
        
    }
    
    public function alterar(Rel_codGAL_paciente $objRel_codGAL_paciente, Banco $objBanco) {
        try{
                      
            $UPDATE = 'UPDATE tb_rel_codGAL_paciente SET '
                    . ' idPaciente_fk = ? ,'
                    . ' idCodGAL_fk = ?'
                . '  where idPaciente_fk = ? AND idCodGAL_fk = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_codGAL_paciente->getIdPaciente_fk());
            $arrayBind[] = array('i',$objRel_codGAL_paciente->getIdCodigoGAL_fk());
            $arrayBind[] = array('i',$objRel_codGAL_paciente->getIdPaciente_fk());
            $arrayBind[] = array('i',$objRel_codGAL_paciente->getIdCodigoGAL_fk());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando o relacionamento do código GAL com o paciente  no BD.",$ex);
        }
       
    }
    
     public function listar(Rel_codGAL_paciente $objRel_codGAL_paciente, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_rel_codGAL_paciente";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_marca = array();
            foreach ($arr as $reg){
                $objRel_codGAL_paciente = new Rel_codGAL_paciente();
                $objRel_codGAL_paciente->setIdPaciente_fk($reg['idPaciente_fk']);
                $objRel_codGAL_paciente->setIdCodigoGAL_fk($reg['idCodGAL_fk']);
                

                $array_marca[] = $objRel_codGAL_paciente;
                
            }
            return $array_marca;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando o relacionamento do código GAL com o paciente  no BD.",$ex);
        }
       
    }
    
    public function consultar(Rel_codGAL_paciente $objRel_codGAL_paciente, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idPaciente_fk,idCodGAL_fk FROM tb_rel_codGAL_paciente WHERE '
                    . '  where idPaciente_fk = ? AND idCodGAL_fk = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_codGAL_paciente->getIdRel_codGAL_paciente());
            
            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $paciente = new Rel_codGAL_paciente();
            $paciente->setIdRel_codGAL_paciente($arr[0]['idRel_codGAL_paciente']);
            $paciente->setCodigo($arr[0]['codigo']);

            return $paciente;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando o relacionamento do código GAL com o paciente  no BD.",$ex);
        }

    }
    
    public function remover(Rel_codGAL_paciente $objRel_codGAL_paciente, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_rel_codGAL_paciente WHERE idRel_codGAL_paciente = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_codGAL_paciente->getIdRel_codGAL_paciente());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendo o relacionamento do código GAL com o paciente  no BD.",$ex);
        }
    }
    
    

    
}
