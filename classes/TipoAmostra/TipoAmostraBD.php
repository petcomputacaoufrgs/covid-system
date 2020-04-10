<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once 'classes/Banco/Banco.php';

class TipoAmostraBD{
    
    public function cadastrar(TipoAmostra $objTipoAmostra, Banco $objBanco) {
        try{
            $INSERT = 'INSERT INTO tb_tipoAmostra (tipo) VALUES (?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objTipoAmostra->getTipo());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objTipoAmostra->setIdTipoAmostra($objBanco->obterUltimoID());
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando tipo de amostra.",$ex);
        }
        
    }
    
    public function alterar(TipoAmostra $objTipoAmostra, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_tipoAmostra SET '
                . ' tipo = ?'
                . '  where idTipoAmostra = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('s',$objTipoAmostra->getTipo());
            $arrayBind[] = array('i',$objTipoAmostra->getIdTipoAmostra());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando tipo de amostra.",$ex);
        }
       
    }
    
     public function listar(TipoAmostra $objTipoAmostra, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_tipoAmostra";


            $arr = $objBanco->consultarSQL($SELECT);

            $arrTiposAmostras = array();
            foreach ($arr as $reg){
                $objTipoAmostra = new TipoAmostra();
                $objTipoAmostra->setIdTipoAmostra($reg['idTipoAmostra']);
                $objTipoAmostra->setTipo($reg['tipo']);

                $arrTiposAmostras[] = $objTipoAmostra;
            }
            return $arrTiposAmostras;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando tipo de amostra.",$ex);
        }
       
    }
    
    public function consultar(TipoAmostra $objTipoAmostra, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idTipoAmostra,tipo FROM tb_tipoAmostra WHERE idTipoAmostra = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objTipoAmostra->getIdTipoAmostra());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $tipoAmostra = new TipoAmostra();
            $tipoAmostra->setIdTipoAmostra($arr[0]['idTipoAmostra']);
            $tipoAmostra->setTipo($arr[0]['tipo']);

            return $tipoAmostra;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando tipo de amostra.",$ex);
        }

    }
    
    public function remover(TipoAmostra $objTipoAmostra, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_tipoAmostra WHERE idTipoAmostra = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objTipoAmostra->getIdTipoAmostra());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendo tipo de amostra.",$ex);
        }
    }
    
    

    
}