<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Banco/Banco.php';
class RecursoBD{

    public function cadastrar(Recurso $objRecurso, Banco $objBanco) {
        try{
            //echo $objRecurso->getRecurso();
            //die("die");
            $INSERT = 'INSERT INTO tb_recurso (nome,s_n_menu) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objRecurso->getNome());
            $arrayBind[] = array('s',$objRecurso->get_s_n_menu());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objRecurso->setIdRecurso($objBanco->obterUltimoID());
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando recurso paciente no BD.",$ex);
        }
        
    }
    
    public function alterar(Recurso $objRecurso, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_recurso SET '
                . ' nome = ?'
                . ' s_n_menu = ?'
                . '  where idRecurso = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('s',$objRecurso->getRecurso());
            $arrayBind[] = array('s',$objRecurso->get_s_n_menu());
            $arrayBind[] = array('i',$objRecurso->getIdRecurso());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
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
                $objRecurso->set_s_n_menu($reg['s_n_menu']);

                $array_recurso[] = $objRecurso;
            }
            return $array_recurso;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando recurso no BD.",$ex);
        }
       
    }
    
    public function consultar(Recurso $objRecurso, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idRecurso,nome,s_n_menu FROM tb_recurso WHERE idRecurso = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRecurso->getIdRecurso());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $recurso = new Recurso();
            $recurso->setIdRecurso($arr[0]['idRecurso']);
            $recurso->getNome($arr[0]['nome']);
            $recurso->get_s_n_menu($arr[0]['s_n_menu']);

            return $recurso;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando recurso no BD.",$ex);
        }

    }
    
    public function remover(Recurso $objRecurso, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_recurso WHERE idRecurso = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objRecurso->getIdRecurso());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendo recurso no BD.",$ex);
        }
    }
    
    

    
}
