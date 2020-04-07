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
            $INSERT = 'INSERT INTO tb_usuario (matricula) VALUES (?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objUsuario->getMatricula());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objUsuario->setIdUsuario($objBanco->obterUltimoID());
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando usuário no BD.",$ex);
        }
        
    }
    
    public function alterar(Usuario $objUsuario, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_usuario SET '
                . ' matricula = ?'
                . '  where idUsuario = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('s',$objUsuario->getMatricula());
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

                $array_usuario[] = $objUsuario;
            }
            return $array_usuario;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando usuário no BD.",$ex);
        }
       
    }
    
    public function consultar(Usuario $objUsuario, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idUsuario,matricula FROM tb_usuario WHERE idUsuario = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objUsuario->getIdUsuario());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $usuário = new Usuario();
            $usuário->setIdUsuario($arr[0]['idUsuario']);
            $usuário->setMatricula($arr[0]['matricula']);

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
    
    

    
}
