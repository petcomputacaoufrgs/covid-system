<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class InfosTuboBD{

    public function cadastrar(InfosTubo $objInfosTubo, Banco $objBanco) {
        try{
           
            $INSERT = 'INSERT INTO tb_infostubo ('
                    . 'idUsuario_fk,'
                    . 'idLocalArmazenamento_fk,'
                    . 'idTubo_fk,'
                    . 'statusTubo,'
                    . 'etapa,'
                    . 'dataHora,'
                    . 'reteste,'
                    . 'volume'
                    . ')' 
                    . 'VALUES (?,?,?,?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objInfosTubo->getIdUsuario_fk());
            $arrayBind[] = array('i',$objInfosTubo->getIdLocalArmazenamento_fk());
            $arrayBind[] = array('i',$objInfosTubo->getIdTubo_fk());
            $arrayBind[] = array('s',$objInfosTubo->getStatusTubo());
            $arrayBind[] = array('s',$objInfosTubo->getEtapa());
            $arrayBind[] = array('s',$objInfosTubo->getDataHora());
            $arrayBind[] = array('s',$objInfosTubo->getReteste());
            $arrayBind[] = array('d',$objInfosTubo->getVolume());
                       

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objInfosTubo->setIdInfosTubo($objBanco->obterUltimoID());
            //echo $objInfosTubo->getIdInfosTubo();
           
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando a amostra no BD.",$ex);
        }
        
    }
    
    public function alterar(InfosTubo $objInfosTubo, Banco $objBanco) {
        try{
                      
            $UPDATE = 'UPDATE tb_infostubo SET '
                    . 'idUsuario_fk = ?,'
                    . 'idLocalArmazenamento_fk = ?,'
                    . 'idTubo_fk = ?,'
                    . 'statusTubo = ?,'
                    . 'etapa = ?,'
                    . 'dataHora = ?,'
                    . 'reteste = ?,'
                    . 'volume = ?'
                . '  where idInfosTubo = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objInfosTubo->getIdUsuario_fk());
            $arrayBind[] = array('i',$objInfosTubo->getIdLocalArmazenamento_fk());
            $arrayBind[] = array('i',$objInfosTubo->getIdTubo_fk());
            $arrayBind[] = array('s',$objInfosTubo->getStatusTubo());
            $arrayBind[] = array('s',$objInfosTubo->getEtapa());
            $arrayBind[] = array('s',$objInfosTubo->getDataHora());
            $arrayBind[] = array('s',$objInfosTubo->getReteste());
            $arrayBind[] = array('d',$objInfosTubo->getVolume());
            
            $arrayBind[] = array('i',$objInfosTubo->getIdInfosTubo());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando a amostra no BD.",$ex);
        }
       
    }
    
     public function listar(InfosTubo $objInfosTubo, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_infostubo";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objInfosTubo->getIdTubo_fk() != null) {
                $WHERE .= $AND . " idTubo_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objInfosTubo->getIdTubo_fk());
            }
            
            if ($objInfosTubo->getStatusTubo() != null) {
                $WHERE .= $AND . " statusTubo = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objInfosTubo->getStatusTubo());
            }

             if ($objInfosTubo->getReteste() != null) {
                 $WHERE .= $AND . " reteste = ?";
                 $AND = ' and ';
                 $arrayBind[] = array('s', $objInfosTubo->getReteste());
             }

             if ($objInfosTubo->getEtapa() != null) {
                 $WHERE .= $AND . " etapa = ?";
                 $AND = ' and ';
                 $arrayBind[] = array('s', $objInfosTubo->getEtapa());
             }
            
            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            //echo $SELECT.$WHERE;$WHERE

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);
            
       
 
            $array_paciente = array();
            foreach ($arr as $reg){
                $objInfosTubo = new InfosTubo();
                $objInfosTubo->setIdInfosTubo($reg['idInfosTubo']);
                $objInfosTubo->setIdUsuario_fk($reg['idUsuario_fk']);
                $objInfosTubo->setIdLocalArmazenamento_fk($reg['idLocalArmazenamento_fk']);
                $objInfosTubo->setIdTubo_fk($reg['idTubo_fk']);
                $objInfosTubo->setStatusTubo($reg['statusTubo']);
                $objInfosTubo->setEtapa($reg['etapa']);
                $objInfosTubo->setDataHora($reg['dataHora']);
                $objInfosTubo->setReteste($reg['reteste']);
                $objInfosTubo->setVolume($reg['volume']);
                

                $array_paciente[] = $objInfosTubo;
                
            }
            return $array_paciente;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando a amostra no BD.",$ex);
        }
       
    }
    
    public function consultar(InfosTubo $objInfosTubo, Banco $objBanco) {

        try{

            $SELECT = 'SELECT *  FROM tb_infostubo WHERE idInfosTubo = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objInfosTubo->getIdInfosTubo());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $objInfosTubo = new InfosTubo();
            $objInfosTubo->setIdInfosTubo($arr[0]['idInfosTubo']);
            $objInfosTubo->setIdUsuario_fk($arr[0]['idUsuario_fk']);
            $objInfosTubo->setIdLocalArmazenamento_fk($arr[0]['idLocalArmazenamento_fk']);
            $objInfosTubo->setIdTubo_fk($arr[0]['idTubo_fk']);
            $objInfosTubo->setStatusTubo($arr[0]['statusTubo']);
            $objInfosTubo->setEtapa($arr[0]['etapa']);
            $objInfosTubo->setDataHora($arr[0]['dataHora']);
            $objInfosTubo->setReteste($arr[0]['reteste']);
            $objInfosTubo->setVolume($arr[0]['volume']);

            return $objInfosTubo;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando a amostra no BD.",$ex);
        }

    }
    
    public function remover(InfosTubo $objInfosTubo, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_infostubo WHERE idInfosTubo = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objInfosTubo->getIdInfosTubo());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendo a amostra no BD.",$ex);
        }
    }


    public function pegar_ultimo(InfosTubo $objInfosTubo, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * from tb_infostubo where idTubo_fk = ? order by idInfosTubo DESC LIMIT 1;';

            $arrayBind = array();
            $arrayBind[] = array('i',$objInfosTubo->getIdTubo_fk());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $objInfosTubo = new InfosTubo();
            $objInfosTubo->setIdInfosTubo($arr[0]['idInfosTubo']);
            $objInfosTubo->setIdUsuario_fk($arr[0]['idUsuario_fk']);
            $objInfosTubo->setIdLocalArmazenamento_fk($arr[0]['idLocalArmazenamento_fk']);
            $objInfosTubo->setIdTubo_fk($arr[0]['idTubo_fk']);
            $objInfosTubo->setStatusTubo($arr[0]['statusTubo']);
            $objInfosTubo->setEtapa($arr[0]['etapa']);
            $objInfosTubo->setDataHora($arr[0]['dataHora']);
            $objInfosTubo->setReteste($arr[0]['reteste']);
            $objInfosTubo->setVolume($arr[0]['volume']);

            return $objInfosTubo;
        } catch (Exception $ex) {

            throw new Excecao("Erro consultando a amostra no BD.",$ex);
        }

    }
    
    

    
}
