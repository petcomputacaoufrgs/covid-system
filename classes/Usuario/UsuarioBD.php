<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Banco/Banco.php';
class UsuarioBD{
    
     

    public function cadastrar(Usuario $objUsuario, Banco $objBanco) {
        try{
            //echo $objUsuario->getMatricula();
            //die("die");
            $INSERT = 'INSERT INTO tb_usuario (matricula,senha) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objUsuario->getMatricula());
            $arrayBind[] = array('s',$objUsuario->getSenha());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objUsuario->setIdUsuario($objBanco->obterUltimoID());
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando usuário no BD.",$ex);
        }
        
    }
    
    public function alterar(Usuario $objUsuario, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_usuario SET '
                    . ' matricula = ?,'
                    . ' senha = ?'
                . '  where idUsuario = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objUsuario->getMatricula());
            $arrayBind[] = array('s',$objUsuario->getSenha());
            $arrayBind[] = array('i',$objUsuario->getIdUsuario());
            

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando usuário no BD.",$ex);
        }
       
    }
    
     public function listar(Usuario $objUsuario, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_usuario";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_usuario = array();
            foreach ($arr as $reg){
                $objUsuario = new Usuario();
                $objUsuario->setIdUsuario($reg['idUsuario']);
                $objUsuario->setMatricula($reg['matricula']);
                $objUsuario->setSenha($reg['senha']);

                $array_usuario[] = $objUsuario;
            }
            return $array_usuario;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando usuário no BD.",$ex);
        }
       
    }
    
    public function consultar(Usuario $objUsuario, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idUsuario,matricula,senha FROM tb_usuario WHERE idUsuario = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objUsuario->getIdUsuario());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $usuário = new Usuario();
            $usuário->setIdUsuario($arr[0]['idUsuario']);
            $usuário->setMatricula($arr[0]['matricula']);
            $usuário->setSenha($arr[0]['senha']);

            return $usuário;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando usuário no BD.",$ex);
        }

    }
    
    public function remover(Usuario $objUsuario, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_usuario WHERE idUsuario = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objUsuario->getIdUsuario());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendo usuário no BD.",$ex);
        }
    }
    
    
    public function validar_cadastro(Usuario $objUsuario, Banco $objBanco) {

       try{

            $SELECT = 'SELECT idUsuario,matricula,senha FROM tb_usuario WHERE matricula = ? ';

            $arrayBind = array();
            $arrayBind[] = array('i',$objUsuario->getMatricula());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $array_usuario = array();
            foreach ($arr as $reg){
                $objUsuario = new Usuario();
                $objUsuario->setIdUsuario($reg['idUsuario']);
                $objUsuario->setMatricula($reg['matricula']);
                $objUsuario->setSenha($reg['senha']);

                $array_usuario[] = $objUsuario;
            }
            return $array_usuario;

            
        } catch (Exception $ex) {
       
            throw new Excecao("Erro validando cadastro do usuário no BD.",$ex);
        }

    }
    
    

    
}
