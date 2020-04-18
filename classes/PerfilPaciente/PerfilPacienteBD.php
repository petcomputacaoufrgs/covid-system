<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class PerfilPacienteBD{

    public function cadastrar(PerfilPaciente $objPerfilPaciente, Banco $objBanco) {
        try{
            //echo $objPerfilPaciente->getPerfil();
            //die("die");
            $INSERT = 'INSERT INTO tb_perfilpaciente (perfil,index_perfil,caractere) VALUES (?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objPerfilPaciente->getPerfil());
            $arrayBind[] = array('s',$objPerfilPaciente->getIndex_perfil());
            $arrayBind[] = array('s',$objPerfilPaciente->getCaractere());


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
                     . ' index_perfil = ?,'
                    . ' caractere = ?'
                . '  where idPerfilPaciente = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('s',$objPerfilPaciente->getPerfil());
            $arrayBind[] = array('s',$objPerfilPaciente->getIndex_perfil());
            $arrayBind[] = array('s',$objPerfilPaciente->getCaractere());
            
            $arrayBind[] = array('i',$objPerfilPaciente->getIdPerfilPaciente());
            

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando perfil do paciente no BD.",$ex);
        }
       
    }
    
     public function listar(PerfilPaciente $objPerfilPaciente, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_perfilpaciente";
            
            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objPerfilPaciente->getIdPerfilPaciente() != null) {
                $WHERE .= $AND . " idPerfilPaciente = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPerfilPaciente->getIdPerfilPaciente());
            }

            if ($objPerfilPaciente->getPerfil() != null) {
                $WHERE .= $AND . " perfil = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPerfilPaciente->getPerfil());
            }

            if ($objPerfilPaciente->getIndex_perfil() != null) {
                $WHERE .= $AND . " index_perfil = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPerfilPaciente->getIndex_perfil());
            }
            
             if ($objPerfilPaciente->getCaractere() != null) {
                $WHERE .= $AND . " caractere = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPerfilPaciente->getCaractere());
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            //echo $SELECT.$WHERE;$WHERE

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            
            $array_perfil = array();
            foreach ($arr as $reg){
                $objPerfilPaciente = new PerfilPaciente();
                $objPerfilPaciente->setIdPerfilPaciente($reg['idPerfilPaciente']);
                $objPerfilPaciente->setPerfil($reg['perfil']);
                $objPerfilPaciente->setIndex_perfil($reg['index_perfil']);
                $objPerfilPaciente->setCaractere($reg['caractere']);
                

                $array_perfil[] = $objPerfilPaciente;
            }
            return $array_perfil;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando perfil do paciente no BD.",$ex);
        }
       
    }
    
    public function consultar(PerfilPaciente $objPerfilPaciente, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * '
                    . 'FROM tb_perfilpaciente '
                    . 'WHERE idPerfilPaciente = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPerfilPaciente->getIdPerfilPaciente());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);
            $perfilPaciente = new PerfilPaciente();
            if($arr != null){
                
                $perfilPaciente->setIdPerfilPaciente($arr[0]['idPerfilPaciente']);
                $perfilPaciente->setPerfil($arr[0]['perfil']);
                $perfilPaciente->setIndex_perfil($arr[0]['index_perfil']);
                $perfilPaciente->setCaractere($arr[0]['caractere']);
            }

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
    
    public function pesquisar_index(PerfilPaciente $objPerfilPaciente, Banco $objBanco) {

        try{
            
            $SELECT = 'SELECT * from tb_perfilPaciente WHERE index_perfil = ?';
            
            $arrayBind = array();
            $arrayBind[] = array('s',$objPerfilPaciente->getIndex_perfil());
            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);
            
            if(empty($arr)){
                return $arr;
            }
            $arr_perfis_paciente = array();
             
            foreach ($arr as $reg){
                $objPerfilPaciente = new PerfilPaciente();
                $objPerfilPaciente->setIdPerfilPaciente($reg['idPerfilPaciente']);
                $objPerfilPaciente->setPerfil($reg['perfil']);
                $objPerfilPaciente->setIndex_perfil($reg['index_perfil']);
                $objPerfilPaciente->setCaractere($reg['caractere']);
                $arr_perfis_paciente[] = $objPerfilPaciente;
            }
             return $arr_perfis_paciente;
            
        } catch (Exception $ex) {
            throw new Excecao("Erro pesquisando perfil do paciente no BD.",$ex);
        }
    }
    
    

    
}
