<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class UsuarioBD{
    
     

    public function cadastrar(Usuario $objUsuario, Banco $objBanco) {
        try{
            $INSERT = 'INSERT INTO tb_usuario (matricula,senha) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objUsuario->getMatricula());
            $arrayBind[] = array('s',$objUsuario->getSenha());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objUsuario->setIdUsuario($objBanco->obterUltimoID());
            return $objUsuario;
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
            return $objUsuario;

        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando usuário no BD.",$ex);
        }
       
    }
    
     public function listar(Usuario $objUsuario,$numLimite=null, Banco $objBanco) {
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

             $LIMIT = '';
             if($numLimite != null){
                 $LIMIT = ' LIMIT ?';
                 $arrayBind[] = array('i',$numLimite);
             }

             $arr = $objBanco->consultarSQL($SELECT.$WHERE.$LIMIT,$arrayBind);

            $array_usuario = array();
            if(count($arr) > 0) {
                foreach ($arr as $reg) {
                    $objUsuario = new Usuario();
                    $objUsuario->setIdUsuario($reg['idUsuario']);
                    $objUsuario->setMatricula($reg['matricula']);
                    $objUsuario->setSenha($reg['senha']);

                    $array_usuario[] = $objUsuario;
                }
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


    public function paginacao(Usuario $objUsuario, Banco $objBanco) {
        try{

            $inicio = ($objUsuario->getNumPagina()-1)*20;

            if($objUsuario->getNumPagina() == null){
                $inicio = 0;
            }

            $SELECT = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_usuario ";
            $WHERE = '';
            $AND = '';
            $arrayBind = array();
            if($objUsuario->getMatricula() != null){
                $WHERE .= $AND . " matricula LIKE ? ";
                $AND = ' and ';
                $arrayBind[] = array('s',"%".$objUsuario->getMatricula()."%");
            }

            if($objUsuario->getIdUsuario() != null){
                $WHERE .= $AND." idUsuario = ?";
                $AND = ' and ';

                $arrayBind[] = array('i',$objUsuario->getIdUsuario());
            }

            if($WHERE != ''){
                $WHERE = ' where '.$WHERE;
            }


            $SELECT.= $WHERE;
            $SELECT.= ' LIMIT ?,20 ';

            $arrayBind[] = array('i',$inicio);
            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $SELECT = "SELECT FOUND_ROWS() as total";
            $total = $objBanco->consultarSQL($SELECT);
            $objUsuario->setTotalRegistros($total[0]['total']);
            $objUsuario->setNumPagina($inicio);

            $array_usuario = array();
            if(count($arr) > 0) {
                foreach ($arr as $reg) {
                    $usuario = new Usuario();
                    $usuario->setIdUsuario($reg['idUsuario']);
                    $usuario->setMatricula($reg['matricula']);

                    $array_usuario[] = $usuario;
                }
            }


            return $array_usuario;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando usuário no BD.",$ex);
        }

    }


    
}
