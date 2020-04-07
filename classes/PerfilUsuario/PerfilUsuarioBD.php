<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Banco/Banco.php';
class PerfilUsuarioBD{

    public function cadastrar(PerfilUsuario $objPerfilUsuario, Banco $objBanco) {
        try{
            //echo $objPerfilUsuario->getPerfil();
            //die("die");
            $INSERT = 'INSERT INTO tb_perfilusuario (perfil) VALUES (?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objPerfilUsuario->getPerfil());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objPerfilUsuario->setIdPerfilUsuario($objBanco->obterUltimoID());
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando perfil do usuário no BD.",$ex);
        }
        
    }
    
    public function alterar(PerfilUsuario $objPerfilUsuario, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_perfilusuario SET '
                . ' perfil = ?'
                . '  where idPerfilUsuario = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('s',$objPerfilUsuario->getPerfil());
            $arrayBind[] = array('i',$objPerfilUsuario->getIdPerfilUsuario());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando perfil do usuário no BD.",$ex);
        }
       
    }
    
     public function listar(PerfilUsuario $objPerfilUsuario, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_perfilusuario";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_perfilUsu = array();
            foreach ($arr as $reg){
                $objPerfilUsuario = new PerfilUsuario();
                $objPerfilUsuario->setIdPerfilUsuario($reg['idPerfilUsuario']);
                $objPerfilUsuario->setPerfil($reg['perfil']);

                $array_perfilUsu[] = $objPerfilUsuario;
            }
            return $array_perfilUsu;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando perfil do usuário no BD.",$ex);
        }
       
    }
    
    public function consultar(PerfilUsuario $objPerfilUsuario, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idPerfilUsuario,perfil FROM tb_perfilusuario WHERE idPerfilUsuario = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPerfilUsuario->getIdPerfilUsuario());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $perfilUsu = new PerfilUsuario();
            $perfilUsu->setIdPerfilUsuario($arr[0]['idPerfilUsuario']);
            $perfilUsu->setPerfil($arr[0]['perfil']);

            return $perfilUsu;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando perfil do usuário no BD.",$ex);
        }

    }
    
    public function remover(PerfilUsuario $objPerfilUsuario, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_perfilusuario WHERE idPerfilUsuario = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objPerfilUsuario->getIdPerfilUsuario());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendo perfil do usuário no BD.",$ex);
        }
    }
    
    

    
}
