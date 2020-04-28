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
                    . 'etapa,'
                    . 'etapaAnterior,'
                    . 'dataHora,'
                    . 'reteste,'
                    . 'volume,'
                    . 'obsProblema,'
                    . 'observacoes,'
                    . 'situacaoEtapa,'
                    . 'situacaoTubo'
                    . ')' 
                    . 'VALUES (?,?,?,?,?,?,?,?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objInfosTubo->getIdUsuario_fk());
            $arrayBind[] = array('i',$objInfosTubo->getIdLocalArmazenamento_fk());
            $arrayBind[] = array('i',$objInfosTubo->getIdTubo_fk());
            $arrayBind[] = array('s',$objInfosTubo->getEtapa());
            $arrayBind[] = array('s',$objInfosTubo->getEtapaAnterior());
            $arrayBind[] = array('s',$objInfosTubo->getDataHora());
            $arrayBind[] = array('s',$objInfosTubo->getReteste());
            $arrayBind[] = array('d',$objInfosTubo->getVolume());
            $arrayBind[] = array('s',$objInfosTubo->getObsProblema());
            $arrayBind[] = array('s',$objInfosTubo->getObservacoes());
            $arrayBind[] = array('s',$objInfosTubo->getSituacaoEtapa());
            $arrayBind[] = array('s',$objInfosTubo->getSituacaoTubo());
                       

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objInfosTubo->setIdInfosTubo($objBanco->obterUltimoID());
            //echo $objInfosTubo->getIdInfosTubo();
           
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando a amostra no BD.",$ex);
        }
        
    }
    
    public function alterar(InfosTubo $objInfosTubo, Banco $objBanco) {
        try{

            $UPDATE = 'UPDATE tb_infostubo SET '
                    . 'idUsuario_fk = ?,'
                    . 'idLocalArmazenamento_fk = ?,'
                    . 'idTubo_fk = ?,'
                    . 'etapa = ?,'
                    . 'etapaAnterior = ?,'
                    . 'dataHora = ?,'
                    . 'reteste = ?,'
                    . 'volume = ?,'
                    . 'obsProblema = ?,'
                    . 'observacoes = ?,'
                    . 'situacaoEtapa = ?,'
                    . 'situacaoTubo = ?'
                . '  where idInfosTubo = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objInfosTubo->getIdUsuario_fk());
            $arrayBind[] = array('i',$objInfosTubo->getIdLocalArmazenamento_fk());
            $arrayBind[] = array('i',$objInfosTubo->getIdTubo_fk());
            $arrayBind[] = array('s',$objInfosTubo->getEtapa());
            $arrayBind[] = array('s',$objInfosTubo->getEtapaAnterior());
            $arrayBind[] = array('s',$objInfosTubo->getDataHora());
            $arrayBind[] = array('s',$objInfosTubo->getReteste());
            $arrayBind[] = array('d',$objInfosTubo->getVolume());
            $arrayBind[] = array('s',$objInfosTubo->getObsProblema());
            $arrayBind[] = array('s',$objInfosTubo->getObservacoes());
            $arrayBind[] = array('s',$objInfosTubo->getSituacaoEtapa());
            $arrayBind[] = array('s',$objInfosTubo->getSituacaoTubo());
            
            $arrayBind[] = array('i',$objInfosTubo->getIdInfosTubo());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Throwable $ex) {
            DIE($ex);
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
            

             if ($objInfosTubo->getSituacaoTubo() != null) {
                 $WHERE .= $AND . " situacaoTubo = ?";
                 $AND = ' and ';
                 $arrayBind[] = array('s', $objInfosTubo->getSituacaoTubo());
             }


             if ($objInfosTubo->getSituacaoEtapa() != null) {
                 $WHERE .= $AND . " situacaoEtapa = ?";
                 $AND = ' and ';
                 $arrayBind[] = array('s', $objInfosTubo->getSituacaoEtapa());
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

             if ($objInfosTubo->getEtapaAnterior() != null) {
                 $WHERE .= $AND . " etapaAnterior = ?";
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
                $objInfosTubo->setEtapa($reg['etapa']);
                $objInfosTubo->setEtapaAnterior($reg['etapaAnterior']);
                $objInfosTubo->setDataHora($reg['dataHora']);
                $objInfosTubo->setReteste($reg['reteste']);
                $objInfosTubo->setVolume($reg['volume']);
                $objInfosTubo->setObsProblema($reg['obsProblema']);
                $objInfosTubo->setObservacoes($reg['observacoes']);
                $objInfosTubo->setSituacaoEtapa($reg['situacaoEtapa']);
                $objInfosTubo->setSituacaoTubo($reg['situacaoTubo']);


                $array_paciente[] = $objInfosTubo;
                
            }
            return $array_paciente;
        } catch (Throwable $ex) {
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
            $objInfosTubo->setEtapa($arr[0]['etapa']);
            $objInfosTubo->setEtapaAnterior($arr[0]['etapaAnterior']);
            $objInfosTubo->setDataHora($arr[0]['dataHora']);
            $objInfosTubo->setReteste($arr[0]['reteste']);
            $objInfosTubo->setVolume($arr[0]['volume']);
            $objInfosTubo->setObsProblema($arr[0]['obsProblema']);
            $objInfosTubo->setObservacoes($arr[0]['observacoes']);
            $objInfosTubo->setSituacaoEtapa($arr[0]['situacaoEtapa']);
            $objInfosTubo->setSituacaoTubo($arr[0]['situacaoTubo']);

            return $objInfosTubo;
        } catch (Throwable $ex) {
       
            throw new Excecao("Erro consultando a amostra no BD.",$ex);
        }

    }
    
    public function remover(InfosTubo $objInfosTubo, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_infostubo WHERE idInfosTubo = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objInfosTubo->getIdInfosTubo());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Throwable $ex) {
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
            $objInfosTubo->setEtapa($arr[0]['etapa']);
            $objInfosTubo->setEtapaAnterior($arr[0]['etapaAnterior']);
            $objInfosTubo->setDataHora($arr[0]['dataHora']);
            $objInfosTubo->setReteste($arr[0]['reteste']);
            $objInfosTubo->setVolume($arr[0]['volume']);
            $objInfosTubo->setObsProblema($arr[0]['obsProblema']);
            $objInfosTubo->setObservacoes($arr[0]['observacoes']);
            $objInfosTubo->setSituacaoEtapa($arr[0]['situacaoEtapa']);
            $objInfosTubo->setSituacaoTubo($arr[0]['situacaoTubo']);

            return $objInfosTubo;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando a amostra no BD.",$ex);
        }

    }


    public function arrumarbanco(InfosTubo $objInfosTubo, $info, Banco $objBanco) {
        try {


            $INSERT1 = 'INSERT into tb_informacoes_tubo (idUsuario_fk,idLocalArmazenamento_fk,idTubo_fk,idLote_fk,
                situacaoTubo,situacaoEtapa,etapa,dataHora,reteste,volume,obsProblema,observacoes) 
                VALUES (' . '\'' . $info->getIdUsuario_fk() . '\',' .
                $info->getIdLocalArmazenamento_fk() . ',' .
                $info->getIdTubo_fk()
                . ', null ' . ',\'' .
                $info->getSituacaoTubo() . '\',\'' .
                $info->getSituacaoEtapa() . '\',\'' .
                $info->getEtapa() . '\',\'' .
                $info->getDataHora() . '\',\'' .
                $info->getReteste() . '\',' .
                $info->getVolume()
                . ' ,null , null );';

            echo $INSERT1;


            /*$arrayBind1 = array();
            $arrayBind1[] = array('i', $info->getIdUsuario_fk());
            $arrayBind1[] = array('i', $info->getIdLocalArmazenamento_fk());
            $arrayBind1[] = array('i', $info->getIdTubo_fk());
            $arrayBind1[] = array('i', $info->getIdLote_fk());
            $arrayBind1[] = array('s', $info->getSituacaoTubo());
            $arrayBind1[] = array('s', $info->getSituacaoEtapa());
            $arrayBind1[] = array('s', $info->getEtapa());
            $arrayBind1[] = array('s', $info->getDataHora());
            $arrayBind1[] = array('s', $info->getReteste());
            $arrayBind1[] = array('d', $info->getVolume());
            $arrayBind1[] = array('s', $info->getObsProblema());
            $arrayBind1[] = array('s', $info->getObservacoes());

            $objBanco->executarSQL($INSERT1, $arrayBind1);*/


               if ($info->getSituacaoTubo() != InfosTuboRN::$TST_DESCARTADO) {
                   $INSERT = 'INSERT into tb_informacoes_tubo (idUsuario_fk,idLocalArmazenamento_fk,idTubo_fk,idLote_fk,
                        situacaoTubo,situacaoEtapa,etapa,dataHora,reteste,volume,obsProblema,observacoes)
                        VALUES (
                        (select idUsuario_fk from tb_infostubo where idInfosTubo = ' . $info->getIdInfosTubo() . '),
                        (select idLocalArmazenamento_fk from tb_infostubo where idInfosTubo=' . $info->getIdInfosTubo() . '),
                        (select idTubo_fk from tb_infostubo where idInfosTubo = ' . $info->getIdInfosTubo() . '),
                        (select idLote_fk from tb_infostubo where idInfosTubo = ' . $info->getIdInfosTubo() . '),'
                       . '\'' . InfosTuboRN::$TST_SEM_UTILIZACAO . '\',\'' .
                       InfosTuboRN::$TSP_AGUARDANDO . '\',\'' .
                       InfosTuboRN::$TP_MONTAGEM_GRUPOS_AMOSTRAS . '\',
                        (select dataHora from tb_infostubo where idInfosTubo = ' . $info->getIdInfosTubo() . '),
                        (select reteste from tb_infostubo where idInfosTubo = ' . $info->getIdInfosTubo() . '),
                        (select volume from tb_infostubo where idInfosTubo = ' . $info->getIdInfosTubo() . '),
                        null, null);';
                   echo $INSERT . "\n";
               }

               $SELECT = 'SELECT * from tb_informacoes_tubo';
               echo $SELECT;

               /*$arrayBind = array();
               $arrayBind[] = array('i', $objInfosTubo->getIdUsuario_fk());
               $arrayBind[] = array('i', $objInfosTubo->getIdLocalArmazenamento_fk());
               $arrayBind[] = array('i', $objInfosTubo->getIdTubo_fk());
               $arrayBind[] = array('i', $objInfosTubo->getIdLote_fk());
               $arrayBind[] = array('s', $objInfosTubo->getSituacaoTubo());
               $arrayBind[] = array('s', $objInfosTubo->getSituacaoEtapa());
               $arrayBind[] = array('s', $objInfosTubo->getEtapa());
               $arrayBind[] = array('s', $objInfosTubo->getDataHora());
               $arrayBind[] = array('s', $objInfosTubo->getReteste());
               $arrayBind[] = array('d', $objInfosTubo->getVolume());
               $arrayBind[] = array('s', $objInfosTubo->getObsProblema());
               $arrayBind[] = array('s', $objInfosTubo->getObservacoes());


               $objBanco->executarSQL($INSERT, $arrayBind);*/




            //$objInfosTubo->setIdInfosTubo($objBanco->obterUltimoID());
            //echo $objInfosTubo->getIdInfosTubo();

        } catch (Throwable $ex) {
            die($ex);
            throw new Excecao("Erro cadastrando a amostra no BD.",$ex);
        }

    }
    
    

    
}
