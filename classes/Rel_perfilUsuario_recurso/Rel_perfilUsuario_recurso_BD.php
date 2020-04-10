<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Banco/Banco.php';
class Rel_perfilUsuario_recurso_BD{
    
     

    public function cadastrar(Rel_perfilUsuario_recurso $objRel_perfilUsuario_recurso, Banco $objBanco) {
        try{
           
            $INSERT = 'INSERT INTO tb_rel_perfilUsuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_perfilUsuario_recurso->getIdPerfilUsuario_fk());
            $arrayBind[] = array('i',$objRel_perfilUsuario_recurso->getIdRecurso_fk());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objRel_perfilUsuario_recurso->setIdRel_perfilUsuario_recurso($objBanco->obterUltimoID());
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrandoo o relacionamento do perfil do usuário com o seu recurso no BD.",$ex);
        }
        
    }
    
    public function alterar(Rel_perfilUsuario_recurso $objRel_perfilUsuario_recurso, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_rel_perfilUsuario_recurso SET '
                    . ' idPerfilUsuario_fk = ?,'
                    . ' idRecurso_fk = ?'
                . '  where id_rel_perfilUsuario_recurso = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_perfilUsuario_recurso->getIdPerfilUsuario_fk());
            $arrayBind[] = array('i',$objRel_perfilUsuario_recurso->getIdRecurso_fk());
            $arrayBind[] = array('i',$objRel_perfilUsuario_recurso->getIdRel_perfilUsuario_recurso());
            

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterandoo o relacionamento do perfil do usuário com o seu recurso no BD.",$ex);
        }
       
    }
    
     public function listar(Rel_perfilUsuario_recurso $objRel_perfilUsuario_recurso, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_rel_perfilUsuario_recurso";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_usuario = array();
            foreach ($arr as $reg){
                $objRel_perfilUsuario_recurso = new Rel_perfilUsuario_recurso();
                $objRel_perfilUsuario_recurso->setIdRel_perfilUsuario_recurso($reg['id_rel_perfilUsuario_recurso']);
                $objRel_perfilUsuario_recurso->setIdPerfilUsuario_fk($reg['idPerfilUsuario_fk']);
                $objRel_perfilUsuario_recurso->setIdRecurso_fk($reg['idRecurso_fk']);

                $array_usuario[] = $objRel_perfilUsuario_recurso;
            }
            return $array_usuario;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando o relacionamento do perfil do usuário com o seu recurso no BD.",$ex);
        }
       
    }
    
    public function consultar(Rel_perfilUsuario_recurso $objRel_perfilUsuario_recurso, Banco $objBanco) {

        try{

            $SELECT = 'SELECT id_rel_perfilUsuario_recurso,idPerfilUsuario_fk,idRecurso_fk FROM tb_rel_perfilUsuario_recurso WHERE id_rel_perfilUsuario_recurso = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_perfilUsuario_recurso->getId_rel_usuario_perfilUsuario());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $perfilUsu_recurso= new Rel_perfilUsuario_recurso();
            $perfilUsu_recurso->setIdRel_perfilUsuario_recurso($arr[0]['id_rel_perfilUsuario_recurso']);
            $perfilUsu_recurso->setIdPerfilUsuario_fk($arr[0]['idPerfilUsuario_fk']);
            $perfilUsu_recurso->setIdRecurso_fk($arr[0]['idRecurso_fk']);

            return $perfilUsu_recurso;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultandoo o relacionamento do perfil do usuário com o seu recurso no BD.",$ex);
        }

    }
    
    public function remover(Rel_perfilUsuario_recurso $objRel_perfilUsuario_recurso, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_rel_perfilUsuario_recurso WHERE id_rel_perfilUsuario_recurso = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_perfilUsuario_recurso->getIdRel_perfilUsuario_recurso());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendoo o relacionamento do perfil do usuário com o seu recurso no BD.",$ex);
        }
    }
    
    
   
}
