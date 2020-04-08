<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Banco/Banco.php';
class PerfilPacienteBD{

    public function cadastrar(PerfilPaciente $objPerfilPaciente, Banco $objBanco) {
        try{
            //echo $objPerfilPaciente->getPerfil();
            //die("die");
            $INSERT = 'INSERT INTO tb_perfilpaciente (perfil,index_perfil) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objPerfilPaciente->getPerfil());
            $arrayBind[] = array('s',$objPerfilPaciente->getIndex_perfil());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objPerfilPaciente->setIdPerfilPaciente($objBanco->obterUltimoID());
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando perfil do paciente no BD.",$ex);
        }
        
    }
    
    public function alterar(PerfilPaciente $objPerfilPaciente, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_perfilpaciente SET '
                     . ' perfil = ?,'
                     . ' index_perfil = ?'
                . '  where idPerfilPaciente = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('s',$objPerfilPaciente->getPerfil());
            $arrayBind[] = array('s',$objPerfilPaciente->getIndex_perfil());
            $arrayBind[] = array('i',$objPerfilPaciente->getIdPerfilPaciente());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando perfil do paciente no BD.",$ex);
        }
       
    }
    
     public function listar(PerfilPaciente $objPerfilPaciente, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_perfilpaciente";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_perfil = array();
            foreach ($arr as $reg){
                $objPerfilPaciente = new PerfilPaciente();
                $objPerfilPaciente->setIdPerfilPaciente($reg['idPerfilPaciente']);
                $objPerfilPaciente->setPerfil($reg['perfil']);
                $objPerfilPaciente->setIndex_perfil($reg['index_perfil']);
                

                $array_perfil[] = $objPerfilPaciente;
            }
            return $array_perfil;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando perfil do paciente no BD.",$ex);
        }
       
    }
    
    public function consultar(PerfilPaciente $objPerfilPaciente, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idPerfilPaciente,perfil,index_perfil '
                    . 'FROM tb_perfilpaciente '
                    . 'WHERE idPerfilPaciente = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPerfilPaciente->getIdPerfilPaciente());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $perfilPaciente = new PerfilPaciente();
            $perfilPaciente->setIdPerfilPaciente($arr[0]['idPerfilPaciente']);
            $perfilPaciente->setPerfil($arr[0]['perfil']);
            $perfilPaciente->setIndex_perfil($arr[0]['index_perfil']);

            return $perfilPaciente;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando perfil do paciente no BD.",$ex);
        }

    }
    
    public function remover(PerfilPaciente $objPerfilPaciente, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_perfilpaciente WHERE idPerfilPaciente = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objPerfilPaciente->getIdPerfilPaciente());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendo perfil do paciente no BD.",$ex);
        }
    }
    
    

    
}
