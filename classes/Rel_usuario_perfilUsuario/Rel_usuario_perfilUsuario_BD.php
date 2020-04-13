<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class Rel_usuario_perfilUsuario_BD{
    
     

    public function cadastrar(Rel_usuario_perfilUsuario $objRel_usuario_perfilUsuario, Banco $objBanco) {
        try{
           
            $INSERT = 'INSERT INTO tb_rel_usuario_perfilUsuario (idPerfilUsuario_fk,idUsuario_fk) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_usuario_perfilUsuario->getIdPerfilUsuario_fk());
            $arrayBind[] = array('i',$objRel_usuario_perfilUsuario->getIdUsuario_fk());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objRel_usuario_perfilUsuario->setId_rel_usuario_perfilUsuario($objBanco->obterUltimoID());
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrandoo o relacionamento do usuário com o seu perfil no BD.",$ex);
        }
        
    }
    
    public function alterar(Rel_usuario_perfilUsuario $objRel_usuario_perfilUsuario, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_rel_usuario_perfilUsuario SET '
                    . ' idPerfilUsuario_fk = ?,'
                    . ' idUsuario_fk = ?'
                . '  where id_rel_usuario_perfilUsuario = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_usuario_perfilUsuario->getIdPerfilUsuario_fk());
            $arrayBind[] = array('i',$objRel_usuario_perfilUsuario->getIdUsuario_fk());
            $arrayBind[] = array('i',$objRel_usuario_perfilUsuario->getIdRel_usuario_perfilUsuario());
            

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterandoo o relacionamento do usuário com o seu perfil no BD.",$ex);
        }
       
    }
    
     public function listar(Rel_usuario_perfilUsuario $objRel_usuario_perfilUsuario, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_rel_usuario_perfilUsuario";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();
            if($objRel_usuario_perfilUsuario->getIdUsuario_fk() != null){
                $WHERE .= $AND." idUsuario_fk = ?";
                $AND = ' and '; 
                $arrayBind[] = array('i',$objRel_usuario_perfilUsuario->getIdUsuario_fk());
            }
            

            if($WHERE != ''){
                $WHERE = ' where '.$WHERE;
            } 
        
            //echo $SELECT.$WHERE;

            $arr = $objBanco->consultarSQL($SELECT.$WHERE,$arrayBind);
            
            $array_usuario = array();
            foreach ($arr as $reg){
                $objRel_usuario_perfilUsuario = new Rel_usuario_perfilUsuario();
                $objRel_usuario_perfilUsuario->setId_rel_usuario_perfilUsuario($reg['id_rel_usuario_perfilUsuario']);
                $objRel_usuario_perfilUsuario->setIdPerfilUsuario_fk($reg['idPerfilUsuario_fk']);
                $objRel_usuario_perfilUsuario->setIdUsuario_fk($reg['idUsuario_fk']);

                $array_usuario[] = $objRel_usuario_perfilUsuario;
            }
            return $array_usuario;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando o relacionamento do usuário com o seu perfil no BD.",$ex);
        }
       
    }
    
    public function consultar(Rel_usuario_perfilUsuario $objRel_usuario_perfilUsuario, Banco $objBanco) {

        try{

            $SELECT = 'SELECT id_rel_usuario_perfilUsuario,idPerfilUsuario_fk,idUsuario_fk FROM tb_rel_usuario_perfilUsuario WHERE id_rel_usuario_perfilUsuario = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_usuario_perfilUsuario->getId_rel_usuario_perfilUsuario());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $usuario_perfil = new Rel_usuario_perfilUsuario();
            $usuario_perfil->setId_rel_usuario_perfilUsuario($arr[0]['id_rel_usuario_perfilUsuario']);
            $usuario_perfil->setIdPerfilUsuario_fk($arr[0]['idPerfilUsuario_fk']);
            $usuario_perfil->setIdUsuario_fk($arr[0]['idUsuario_fk']);

            return $usuario_perfil;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultandoo o relacionamento do usuário com o seu perfil no BD.",$ex);
        }

    }
    
    public function remover(Rel_usuario_perfilUsuario $objRel_usuario_perfilUsuario, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_rel_usuario_perfilUsuario WHERE idUsuario_fk = ? AND idPerfilUsuario_fk = ?';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_usuario_perfilUsuario->getIdUsuario_fk());
            $arrayBind[] = array('i',$objRel_usuario_perfilUsuario->getIdPerfilUsuario_fk());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendoo o relacionamento do usuário com o seu perfil no BD.",$ex);
        }
    }
    
    
   
     public function validar_cadastro(Rel_usuario_perfilUsuario $objRel_usuario_perfilUsuario, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_rel_usuario_perfilUsuario WHERE idPerfilUsuario_fk = ? AND idUsuario_fk = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_usuario_perfilUsuario->getIdPerfilUsuario_fk());
            $arrayBind[] = array('i',$objRel_usuario_perfilUsuario->getIdUsuario_fk());
            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);
            
            if(empty($arr)){
                return $arr;
            }
            
            $array_usuario = array();
            foreach ($arr as $reg){
                $objRel_usuario_perfilUsuario = new Rel_usuario_perfilUsuario();
                $objRel_usuario_perfilUsuario->setId_rel_usuario_perfilUsuario($reg['id_rel_usuario_perfilUsuario']);
                $objRel_usuario_perfilUsuario->setIdPerfilUsuario_fk($reg['idPerfilUsuario_fk']);
                $objRel_usuario_perfilUsuario->setIdUsuario_fk($reg['idUsuario_fk']);

                $array_usuario[] = $objRel_usuario_perfilUsuario;
            }
            return $array_usuario;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultandoo o relacionamento do usuário com o seu perfil no BD.",$ex);
        }

    }
}
