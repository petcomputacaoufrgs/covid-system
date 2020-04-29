<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class TipoLocalArmazenamentoBD{

    public function cadastrar(TipoLocalArmazenamento $objTipoLocalArmazenamento, Banco $objBanco) {
        try{
            $INSERT = 'INSERT INTO tb_tipo_localarmazenamento (tipo,index_tipo,caractereTipo) VALUES (?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objTipoLocalArmazenamento->getTipo());
            $arrayBind[] = array('s',$objTipoLocalArmazenamento->getIndexTipo());
            $arrayBind[] = array('s',$objTipoLocalArmazenamento->getCaractereTipo());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objTipoLocalArmazenamento->setIdTipoLocalArmazenamento($objBanco->obterUltimoID());
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o tipo de local de armazenamento no BD.",$ex);
        }
        
    }
    
    public function alterar(TipoLocalArmazenamento $objTipoLocalArmazenamento, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_tipo_localarmazenamento SET '
                    . ' tipo = ?, '
                    . ' index_tipo = ?, '
                    . ' caractereTipo = ?, '
                . '  where idTipoLocalArmazenamento = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('s',$objTipoLocalArmazenamento->getTipo());
            $arrayBind[] = array('s',$objTipoLocalArmazenamento->getIndexTipo());
            $arrayBind[] = array('s',$objTipoLocalArmazenamento->getCaractereTipo());
            $arrayBind[] = array('i',$objTipoLocalArmazenamento->getIdTipoLocalArmazenamento());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o tipo de local de armazenamento no BD.",$ex);
        }
       
    }
    
     public function listar(TipoLocalArmazenamento $objTipoLocalArmazenamento, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_tipo_localarmazenamento";

             $WHERE = '';
             $AND = '';
             $arrayBind = array();

             if ($objTipoLocalArmazenamento->getCaractereTipo() != null) {
                 $WHERE .= $AND . " caractereTipo = ?";
                 $AND = ' and ';
                 $arrayBind[] = array('s', $objTipoLocalArmazenamento->getCaractereTipo());
             }

             if ($objTipoLocalArmazenamento->getIndexTipo() != null) {
                 $WHERE .= $AND . " index_tipo = ? ";
                 $AND = ' and ';
                 $arrayBind[] = array('s', $objTipoLocalArmazenamento->getIndexTipo());
             }

             if ($WHERE != '') {
                 $WHERE = ' where ' . $WHERE;
             }

             $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            $array_tipoLocais = array();
            foreach ($arr as $reg){
                $tipoLocal = new TipoLocalArmazenamento();
                $tipoLocal->setIdTipoLocalArmazenamento($reg['idTipoLocalArmazenamento']);
                $tipoLocal->setTipo($reg['tipo']);
                $tipoLocal->setIndexTipo($reg['index_tipo']);
                $tipoLocal->setCaractereTipo($reg['caractereTipo']);

                $array_tipoLocais[] = $tipoLocal;
            }
            return $array_tipoLocais;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o tipo de local de armazenamento no BD.",$ex);
        }
       
    }
    
    public function consultar(TipoLocalArmazenamento $objTipoLocalArmazenamento, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_tipo_localarmazenamento WHERE idTipoLocalArmazenamento = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objTipoLocalArmazenamento->getIdTipoLocalArmazenamento());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $tipoLocal = new TipoLocalArmazenamento();
            $tipoLocal->setIdTipoLocalArmazenamento($arr[0]['idTipoLocalArmazenamento']);
            $tipoLocal->setTipo($arr[0]['tipo']);
            $tipoLocal->setIndexTipo($arr[0]['index_tipo']);
            $tipoLocal->setCaractereTipo($arr[0]['caractereTipo']);

            return $tipoLocal;
        } catch (Throwable $ex) {
            throw new Excecao("Erro consultando o tipo de local de armazenamento no BD.",$ex);
        }

    }
    
    public function remover(TipoLocalArmazenamento $objTipoLocalArmazenamento, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_tipo_localarmazenamento WHERE idTipoLocalArmazenamento = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objTipoLocalArmazenamento->getIdTipoLocalArmazenamento());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o tipo de local de armazenamento no BD.",$ex);
        }
    }
    
    

    
}
