<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Banco/Banco.php';
class EquipamentoBD{

    public function cadastrar(Equipamento $objEquipamento, Banco $objBanco) {
        try{
            
            $INSERT = 'INSERT INTO tb_equipamento (idDetentor_fk,idMarca_fk,idModelo_fk,dataUltimaCalibragem,dataChegada) VALUES (?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objEquipamento->getIdDetentor_fk());
            $arrayBind[] = array('i',$objEquipamento->getIdMarca_fk());
            $arrayBind[] = array('i',$objEquipamento->getIdModelo_fk());
            $arrayBind[] = array('s',$objEquipamento->getDataUltimaCalibragem());
            $arrayBind[] = array('s',$objEquipamento->getDataChegada());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objEquipamento->setIdEquipamento($objBanco->obterUltimoID());
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando equipamento no BD.",$ex);
        }
        
    }
    
    public function alterar(Equipamento $objEquipamento, Banco $objBanco) {
        try{
            //print_r($objEquipamento);
            //die();
            $UPDATE = 'UPDATE tb_equipamento SET '
                    . ' idDetentor_fk = ? ,'
                    . ' idMarca_fk = ? ,'
                    . ' idModelo_fk = ? ,'
                    . ' dataUltimaCalibragem = ? ,'
                    . ' dataChegada = ?'
                . '  where idEquipamento = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objEquipamento->getIdDetentor_fk());
            $arrayBind[] = array('i',$objEquipamento->getIdMarca_fk());
            $arrayBind[] = array('i',$objEquipamento->getIdModelo_fk());
            $arrayBind[] = array('s',$objEquipamento->getDataUltimaCalibragem());
            $arrayBind[] = array('s',$objEquipamento->getDataChegada());
            $arrayBind[] = array('i',$objEquipamento->getIdEquipamento());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando equipamento no BD.",$ex);
        }
       
    }
    
     public function listar(Equipamento $objEquipamento, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_equipamento";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_equipamento = array();
            foreach ($arr as $reg){
                $objEquipamento = new Equipamento();
                $objEquipamento->setIdEquipamento($reg['idEquipamento']);
                $objEquipamento->setIdDetentor_fk($reg['idDetentor_fk']);
                $objEquipamento->setIdMarca_fk($reg['idMarca_fk']);
                $objEquipamento->setIdModelo_fk($reg['idModelo_fk']);
                $objEquipamento->setDataUltimaCalibragem($reg['dataUltimaCalibragem']);
                $objEquipamento->setDataChegada($reg['dataChegada']);

                $array_equipamento[] = $objEquipamento;
            }
            return $array_equipamento;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando equipamento no BD.",$ex);
        }
       
    }
    
    public function consultar(Equipamento $objEquipamento, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idEquipamento,idDetentor_fk,idMarca_fk,idModelo_fk,dataUltimaCalibragem,dataChegada '
                    . 'FROM tb_equipamento WHERE idEquipamento = ?';
                       
            $arrayBind = array();
            $arrayBind[] = array('i',$objEquipamento->getIdEquipamento());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $equipamento = new Equipamento();
            $equipamento->setIdEquipamento($arr[0]['idEquipamento']);
            $equipamento->setIdDetentor_fk($arr[0]['idDetentor_fk']);
            $equipamento->setIdMarca_fk($arr[0]['idMarca_fk']);
            $equipamento->setIdModelo_fk($arr[0]['idModelo_fk']);
            $equipamento->setDataUltimaCalibragem($arr[0]['dataUltimaCalibragem']);
            $equipamento->setDataChegada($arr[0]['dataChegada']);

            return $equipamento;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando equipamento no BD.",$ex);
        }

    }
    
    public function remover(Equipamento $objEquipamento, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_equipamento WHERE idEquipamento = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objEquipamento->getIdEquipamento());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendo equipamento no BD.",$ex);
        }
    }
    
    

    
}
