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
            $INSERT = 'INSERT INTO tb_perfilpaciente (perfil) VALUES (?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objPerfilPaciente->getPerfil());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objPerfilPaciente->setIdPerfilPaciente($objBanco->obterUltimoID());
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando perfil do paciente no BD.",$ex);
        }
        
    }
    
    public function alterar(PerfilPaciente $objPerfilPaciente, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_perfilpaciente SET '
                . ' perfil = ?'
                . '  where idPerfilPaciente = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('s',$objPerfilPaciente->getPerfil());
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

                $array_perfil[] = $objPerfilPaciente;
            }
            return $array_perfil;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando perfil do paciente no BD.",$ex);
        }
       
    }
    
    public function consultar(PerfilPaciente $objPerfilPaciente, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idPerfilPaciente,perfil FROM tb_perfilpaciente WHERE idPerfilPaciente = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPerfilPaciente->getIdPerfilPaciente());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $perfilAmostra = new PerfilPaciente();
            $perfilAmostra->setIdPerfilPaciente($arr[0]['idPerfilPaciente']);
            $perfilAmostra->setPerfil($arr[0]['perfil']);

            return $perfilAmostra;
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
