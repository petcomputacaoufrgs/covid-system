<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class RecursoBD{

    public function cadastrar(Recurso $objRecurso, Banco $objBanco) {
        try{
            
            //die("die");
            $INSERT = 'INSERT INTO tb_recurso (nome,s_n_menu,etapa) VALUES (?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objRecurso->getNome());
            $arrayBind[] = array('s',$objRecurso->getS_n_menu());
            $arrayBind[] = array('s',$objRecurso->getEtapa());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objRecurso->setIdRecurso($objBanco->obterUltimoID());
            return $objRecurso;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando recurso paciente no BD.",$ex);
        }
        
    }
    
    public function alterar(Recurso $objRecurso, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_recurso SET '
                    . ' nome = ?,'
                    . ' s_n_menu = ?,'
                    . ' etapa = ?'
                . '  where idRecurso = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('s',$objRecurso->getNome());
            $arrayBind[] = array('s',$objRecurso->getS_n_menu());
            $arrayBind[] = array('s',$objRecurso->getEtapa());
            $arrayBind[] = array('i',$objRecurso->getIdRecurso());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objRecurso;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando recurso no BD.",$ex);
        }
       
    }
    
     public function listar(Recurso $objRecurso, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_recurso";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_recurso = array();
            foreach ($arr as $reg){
                $objRecurso = new Recurso();
                $objRecurso->setIdRecurso($reg['idRecurso']);
                $objRecurso->setNome($reg['nome']);
                $objRecurso->setS_n_menu($reg['s_n_menu']);
                $objRecurso->setEtapa($reg['etapa']);

                $array_recurso[] = $objRecurso;
            }
            return $array_recurso;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando recurso no BD.",$ex);
        }
       
    }
    
    public function consultar(Recurso $objRecurso, Banco $objBanco) {

        try{
            
            $SELECT = 'SELECT * FROM tb_recurso WHERE idRecurso = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRecurso->getIdRecurso());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);
            
            
            $recurso = new Recurso();
            $recurso->setIdRecurso($arr[0]['idRecurso']);
            $recurso->setNome($arr[0]['nome']);
            $recurso->setS_n_menu($arr[0]['s_n_menu']);
            $recurso->setEtapa($arr[0]['etapa']);
            
            return $recurso;
        } catch (Throwable $ex) {
       
            throw new Excecao("Erro consultando recurso no BD.",$ex);
        }

    }
    
    public function remover(Recurso $objRecurso, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_recurso WHERE idRecurso = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objRecurso->getIdRecurso());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo recurso no BD.",$ex);
        }
    }
    
    public function validar_cadastro(Recurso $objRecurso, Banco $objBanco) {

        try{
            
            $SELECT = 'SELECT * from tb_recurso WHERE nome = ? AND etapa=? AND s_n_menu=?';
            
            $arrayBind = array();
            $arrayBind[] = array('s',$objRecurso->getNome());
            $arrayBind[] = array('s',$objRecurso->getEtapa());
            $arrayBind[] = array('s',$objRecurso->getS_n_menu());
            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);
            
            if(empty($arr)){
                return $arr;
            }
            $arr_recursos = array();
             
            foreach ($arr as $reg){
                $objRecurso = new Recurso();
                $objRecurso->setIdRecurso($reg['idRecurso']);
                $objRecurso->setNome($reg['nome']);
                $objRecurso->setEtapa($reg['etapa']);
                $objRecurso->setS_n_menu($reg['s_n_menu']);
                $arr_recursos[] = $objRecurso;
            }
             return $arr_recursos;
            
        } catch (Throwable $ex) {
            throw new Excecao("Erro pesquisando o perfil do usuário no BD.",$ex);
        }
    }


    public function ja_existe_recurso(Recurso $objRecurso, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idRecurso from tb_recurso WHERE nome = ? LIMIT 1';

            $arrayBind = array();
            $arrayBind[] = array('s',$objRecurso->getIdRecurso());
            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);

            if(count($arr) > 0){
                return true;
            }

            return false;

        } catch (Throwable $ex) {
            throw new Excecao("Erro verificando se já existe um recurso no BD.",$ex);
        }
    }


    public function existe_usuario_com_o_recurso(Recurso $objRecurso, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_usuario, tb_perfilusuario,tb_rel_usuario_perfilusuario, tb_rel_perfilusuario_recurso,tb_recurso 
                        where tb_usuario.idUsuario = tb_rel_usuario_perfilusuario.idUsuario_fk 
                        and tb_perfilusuario.idPerfilUsuario = tb_rel_usuario_perfilusuario.idPerfilUsuario_fk 
                        and tb_perfilusuario.idPerfilUsuario = tb_rel_perfilusuario_recurso.idPerfilUsuario_fk 
                        and tb_recurso.idRecurso = tb_rel_perfilusuario_recurso.idRecurso_fk 
                        and tb_recurso.idRecurso = ?
                        LIMIT 1";

            $arrayBind = array();
            $arrayBind[] = array('i',$objRecurso->getIdRecurso());
            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);

            if(count($arr) > 0){
                return true;
            }
            return false;
        } catch (Throwable $ex) {
            throw new Excecao("Erro verificando se existe um usuário com o recurso no BD.",$ex);
        }

    }
    
    

    
}
