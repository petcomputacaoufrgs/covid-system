<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class CapelaBD{

    public function cadastrar(Capela $objCapela, Banco $objBanco) {
        try{
            //echo $objCapela->getCapela();
            //die("die");
            $INSERT = 'INSERT INTO tb_capela (numero,situacaoCapela,nivelSeguranca) VALUES (?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objCapela->getNumero());
            $arrayBind[] = array('s',$objCapela->getSituacaoCapela());
            $arrayBind[] = array('s',$objCapela->getNivelSeguranca());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objCapela->setIdCapela($objBanco->obterUltimoID());
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando a capela paciente no BD.",$ex);
        }
        
    }
    
    public function alterar(Capela $objCapela, Banco $objBanco) {
        try{
            
            $UPDATE = 'UPDATE tb_capela SET '
                    . ' numero = ?,'
                    . ' situacaoCapela = ?,'
                    . ' nivelSeguranca = ?'
                . '  where idCapela = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objCapela->getNumero());
            $arrayBind[] = array('s',$objCapela->getSituacaoCapela());
            $arrayBind[] = array('s',$objCapela->getNivelSeguranca());

            $arrayBind[] = array('i',$objCapela->getIdCapela());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando a capela no BD.",$ex);
        }
       
    }
    
     public function listar(Capela $objCapela, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_capela";

             $WHERE = '';
             $AND = '';
             $arrayBind = array();

             if ($objCapela->getNumero() != null) {
                 $WHERE .= $AND . " numero = ?";
                 $AND = ' and ';
                 $arrayBind[] = array('s', $objCapela->getNumero());
             }

             if ($objCapela->getSituacaoCapela() != null) {
                 $WHERE .= $AND . " situacaoCapela = ?";
                 $AND = ' and ';
                 $arrayBind[] = array('s', $objCapela->getSituacaoCapela());
             }

             if ($objCapela->getNivelSeguranca() != null) {
                 $WHERE .= $AND . " nivelSeguranca = ?";
                 $AND = ' and ';
                 $arrayBind[] = array('s', $objCapela->getNivelSeguranca());
             }

             if ($WHERE != '') {
                 $WHERE = ' where ' . $WHERE;
             }


             $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            $array_capelas = array();
            foreach ($arr as $reg){
                $objCapela = new Capela();
                $objCapela->setIdCapela($reg['idCapela']);
                $objCapela->setNumero($reg['numero']);
                $objCapela->setSituacaoCapela($reg['situacaoCapela']);
                $objCapela->setNivelSeguranca($reg['nivelSeguranca']);

                $array_capelas[] = $objCapela;
            }
            return $array_capelas;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando a capela no BD.",$ex);
        }
       
    }
    
    public function consultar(Capela $objCapela, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_capela WHERE idCapela = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objCapela->getIdCapela());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $capela = new Capela();
            $capela->setIdCapela($arr[0]['idCapela']);
            $capela->setNumero($arr[0]['numero']);
            $capela->setSituacaoCapela($arr[0]['situacaoCapela']);
            $capela->setNivelSeguranca($arr[0]['nivelSeguranca']);

            return $capela;
        } catch (Throwable $ex) {
       
            throw new Excecao("Erro consultando a capela no BD.",$ex);
        }

    }
    
    public function remover(Capela $objCapela, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_capela WHERE idCapela = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objCapela->getIdCapela());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo a capela no BD.",$ex);
        }
    }
    
    public function bloquear_registro(Capela $objCapela, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_capela  WHERE situacaoCapela = ? AND nivelSeguranca = ? FOR UPDATE ';

                   
            $arrayBind = array();
            $arrayBind[] = array('s', CapelaRN::$TE_LIBERADA);
            $arrayBind[] = array('s', $objCapela->getNivelSeguranca());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            
            if(empty($arr)){
                return $arr;
            }
            $arr_capelas = array();
             
            foreach ($arr as $reg){
                $capela = new Capela();
                $capela->setIdCapela($reg['idCapela']);
                $capela->setNumero($reg['numero']);
                $capela->setSituacaoCapela($reg['situacaoCapela']);
                $capela->setNivelSeguranca($reg['nivelSeguranca']);
                $arr_capelas[] = $capela;
            }
            return $arr_capelas;

            
        } catch (Throwable $ex) {
       
            throw new Excecao("Erro bloqueando a capela no BD.",$ex);
        }

    }


    public function validar_cadastro(Capela $objCapela, Banco $objBanco) {

        try{
            
            $SELECT = 'SELECT * from tb_capela WHERE numero = ?';
            
            $arrayBind = array();
            $arrayBind[] = array('i',$objCapela->getNumero());
            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);
            
            if(empty($arr)){
                return $arr;
            }
            $arr_capelas = array();
             
            foreach ($arr as $reg){
                if($objCapela->getIdCapela() != $reg['idCapela']) {
                    $ObjCapelaAux = new Capela();
                    $ObjCapelaAux->setIdCapela($reg['idCapela']);
                    $ObjCapelaAux->setNumero($reg['numero']);
                    $ObjCapelaAux->setSituacaoCapela($reg['situacaoCapela']);
                    $arr_capelas[] = $ObjCapelaAux;
                }
            }
             return $arr_capelas;
            
        } catch (Throwable $ex) {
            throw new Excecao("Erro validando cadastro no BD.",$ex);
        }
    }
    

    
}
