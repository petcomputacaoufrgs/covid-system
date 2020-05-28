<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class UsuarioBD{
    
     

    public function cadastrar(Usuario $objUsuario, Banco $objBanco) {
        try{
            //echo $objUsuario->getMatricula();
            //die("die");
            $INSERT = 'INSERT INTO tb_usuario (matricula,senha) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objUsuario->getMatricula());
            $arrayBind[] = array('s',$objUsuario->getSenha());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objUsuario->setIdUsuario($objBanco->obterUltimoID());
        } catch (Throwable $ex) {
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
            $arrayBind[] = array('s',$objUsuario->getMatricula());
            $arrayBind[] = array('s',$objUsuario->getSenha());
            $arrayBind[] = array('i',$objUsuario->getIdUsuario());
            

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando usuário no BD.",$ex);
        }
       
    }
    
     public function listar(Usuario $objUsuario, Banco $objBanco) {
         try{
      
             
            $SELECT = "SELECT * FROM tb_usuario";
            $WHERE = '';
            $AND = '';
            $arrayBind = array();
            if($objUsuario->getMatricula() != null){
                $WHERE .= $AND." matricula = ?";
                $AND = ' and ';
                 
                $arrayBind[] = array('s',$objUsuario->getMatricula());
            }
            

            if($WHERE != ''){
                $WHERE = ' where '.$WHERE;
            } 
        
            //echo $SELECT.$WHERE;

            $arr = $objBanco->consultarSQL($SELECT.$WHERE,$arrayBind);

            $array_usuario = array();
            foreach ($arr as $reg){
                $objUsuario = new Usuario();
                $objUsuario->setIdUsuario($reg['idUsuario']);
                $objUsuario->setMatricula($reg['matricula']);
                $objUsuario->setSenha($reg['senha']);

                $array_usuario[] = $objUsuario;
            }
            return $array_usuario;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando usuário no BD.",$ex);
        }
       
    }
    
    public function consultar(Usuario $objUsuario, Banco $objBanco) {

        try{
            //print_r($objUsuario);
            $SELECT = 'SELECT idUsuario,matricula,senha FROM tb_usuario WHERE idUsuario = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objUsuario->getIdUsuario());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);
            
            //print_r($arr);
            $usuario = new Usuario();
            $usuario->setIdUsuario($arr[0]['idUsuario']);
            $usuario->setMatricula($arr[0]['matricula']);
            $usuario->setSenha($arr[0]['senha']);

            return $usuario;
        } catch (Throwable $ex) {
       
            throw new Excecao("Erro consultando usuário no BD.",$ex);
        }

    }
    
    public function remover(Usuario $objUsuario, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_usuario WHERE idUsuario = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objUsuario->getIdUsuario());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo usuário no BD.",$ex);
        }
    }
    
    
    public function validar_cadastro(Usuario $objUsuario, Banco $objBanco) {

       try{

            $SELECT = 'SELECT idUsuario,matricula,senha FROM tb_usuario WHERE matricula = ? AND senha = ? ';

            $arrayBind = array();
            $arrayBind[] = array('s',$objUsuario->getMatricula());
            $arrayBind[] = array('s',$objUsuario->getSenha());

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

            
        } catch (Throwable $ex) {
       
            throw new Excecao("Erro validando cadastro do usuário no BD.",$ex);
        }

    }
    
    

    
}
