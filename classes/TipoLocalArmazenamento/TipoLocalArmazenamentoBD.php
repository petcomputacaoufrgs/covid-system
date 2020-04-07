<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Banco/Banco.php';
class TipoLocalArmazenamentoBD{

    public function cadastrar(TipoLocalArmazenamento $objTipoLocalArmazenamento, Banco $objBanco) {
        try{
            $INSERT = 'INSERT INTO tb_tipoLocal (nomeLocal,qntEspacosTotal, qntEspacosAmostra) VALUES (?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objTipoLocalArmazenamento->getNomeLocal());
            $arrayBind[] = array('i',$objTipoLocalArmazenamento->getQntEspacosTotal());
            $arrayBind[] = array('i',$objTipoLocalArmazenamento->getQntEspacosAmostra());

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objTipoLocalArmazenamento->setIdTipoLocalArmazenamento($objBanco->obterUltimoID());
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando o tipo de local de armazenamento no BD.",$ex);
        }
        
    }
    
    public function alterar(TipoLocalArmazenamento $objTipoLocalArmazenamento, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_tipoLocal SET '
                    . ' nomeLocal = ? ,'
                    . ' qntEspacosTotal = ? ,'
                    . ' qntEspacosAmostra = ? '
                . '  where idTipoLocal = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('s',$objTipoLocalArmazenamento->getNomeLocal());
            $arrayBind[] = array('i',$objTipoLocalArmazenamento->getQntEspacosTotal());
            $arrayBind[] = array('i',$objTipoLocalArmazenamento->getQntEspacosAmostra());
            $arrayBind[] = array('i',$objTipoLocalArmazenamento->getIdTipoLocalArmazenamento());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando o tipo de local de armazenamento no BD.",$ex);
        }
       
    }
    
     public function listar(TipoLocalArmazenamento $objTipoLocalArmazenamento, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_tipoLocal";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_tipoLocais = array();
            foreach ($arr as $reg){
                $objTipoLocalArmazenamento = new TipoLocalArmazenamento();
                $objTipoLocalArmazenamento->setIdTipoLocalArmazenamento($reg['idTipoLocal']);
                $objTipoLocalArmazenamento->setNomeLocal($reg['nomeLocal']);
                $objTipoLocalArmazenamento->setQntEspacosTotal($reg['qntEspacosTotal']);
                $objTipoLocalArmazenamento->setQntEspacosAmostra($reg['qntEspacosAmostra']);

                $array_tipoLocais[] = $objTipoLocalArmazenamento;
            }
            return $array_tipoLocais;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando o tipo de local de armazenamento no BD.",$ex);
        }
       
    }
    
    public function consultar(TipoLocalArmazenamento $objTipoLocalArmazenamento, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idTipoLocal,nomeLocal,qntEspacosTotal,qntEspacosAmostra FROM tb_tipoLocal WHERE idTipoLocal = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objTipoLocalArmazenamento->getIdTipoLocalArmazenamento());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $sexoAmostra = new TipoLocalArmazenamento();
            $sexoAmostra->setIdTipoLocalArmazenamento($arr[0]['idTipoLocal']);
            $sexoAmostra->setNomeLocal($arr[0]['nomeLocal']);
            $sexoAmostra->setQntEspacosTotal($arr[0]['qntEspacosTotal']);
            $sexoAmostra->setQntEspacosAmostra($arr[0]['qntEspacosAmostra']);

            return $sexoAmostra;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando o tipo de local de armazenamento no BD.",$ex);
        }

    }
    
    public function remover(TipoLocalArmazenamento $objTipoLocalArmazenamento, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_tipoLocal WHERE idTipoLocal = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objTipoLocalArmazenamento->getIdTipoLocalArmazenamento());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendo o tipo de local de armazenamento no BD.",$ex);
        }
    }
    
    

    
}
