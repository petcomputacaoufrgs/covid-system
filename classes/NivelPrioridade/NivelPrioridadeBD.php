<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class NivelPrioridadeBD{

    public function cadastrar(NivelPrioridade $objNivelPrioridade, Banco $objBanco) {
        try{
            $INSERT = 'INSERT INTO tb_nivelprioridade (nivel) VALUES (?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objNivelPrioridade->getNivel());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objNivelPrioridade->setIdNivelPrioridade($objBanco->obterUltimoID());
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando o nível de prioridade paciente no BD.",$ex);
        }
        
    }
    
    public function alterar(NivelPrioridade $objNivelPrioridade, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_nivelprioridade SET '
                    . ' nivel = ?'
                . '  where idNivelPrioridade = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objNivelPrioridade->getNivel());
            $arrayBind[] = array('i',$objNivelPrioridade->getIdNivelPrioridade());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando o nível de prioridade no BD.",$ex);
        }
       
    }
    
     public function listar(NivelPrioridade $objNivelPrioridade, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_nivelprioridade";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_doença = array();
            foreach ($arr as $reg){
                $objNivelPrioridade = new NivelPrioridade();
                $objNivelPrioridade->setIdNivelPrioridade($reg['idNivelPrioridade']);
                $objNivelPrioridade->setNivel($reg['nivel']);

                $array_doença[] = $objNivelPrioridade;
            }
            return $array_doença;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando o nível de prioridade no BD.",$ex);
        }
       
    }
    
    public function consultar(NivelPrioridade $objNivelPrioridade, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idNivelPrioridade,nivel FROM tb_nivelprioridade WHERE idNivelPrioridade = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objNivelPrioridade->getIdNivelPrioridade());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $nivelprioridade = new NivelPrioridade();
            $nivelprioridade->setIdNivelPrioridade($arr[0]['idNivelPrioridade']);
            $nivelprioridade->setNivel($arr[0]['nivel']);

            return $nivelprioridade;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando o nível de prioridade no BD.",$ex);
        }

    }
    
    public function remover(NivelPrioridade $objNivelPrioridade, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_nivelprioridade WHERE idNivelPrioridade = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objNivelPrioridade->getIdNivelPrioridade());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendo o nível de prioridade no BD.",$ex);
        }
    }
    
    public function validar_cadastro(NivelPrioridade $objNivelPrioridade, Banco $objBanco) {

        try{
            
            $SELECT = 'SELECT * from tb_nivelprioridade WHERE nivel = ?';
            
            $arrayBind = array();
            $arrayBind[] = array('s',$objNivelPrioridade->getNivel());
            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);
            
            if(empty($arr)){
                return $arr;
            }
            $arr_niveisPrioridade = array();
             
            foreach ($arr as $reg){
                $objMarca = new NivelPrioridade();
                $objMarca->setIdNivelPrioridade($reg['idNivelPrioridade']);
                $objMarca->setNivel($reg['nivel']);
                $arr_niveisPrioridade[] = $objMarca;
            }
             return $arr_niveisPrioridade;
            
        } catch (Exception $ex) {
            throw new Excecao("Erro pesquisando níveis de prioridade no BD.",$ex);
        }
    }

    
}
