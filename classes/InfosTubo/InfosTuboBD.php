<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';

require_once __DIR__ . '/../Laudo/Laudo.php';
require_once __DIR__ . '/../Laudo/LaudoRN.php';

require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTexto.php';
require_once __DIR__ . '/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTextoRN.php';

class InfosTuboBD{

    public function cadastrar(InfosTubo $objInfosTubo, Banco $objBanco) {
        try{
           
            $INSERT = 'INSERT INTO tb_infostubo ('
                    . 'idUsuario_fk,'
                    . 'idPosicao_fk,'
                    . 'idTubo_fk,'
                    . 'idLote_fk,'
                    . 'etapa,'
                    . 'etapaAnterior,'
                    . 'dataHora,'
                    . 'reteste,'
                    . 'volume,'
                    . 'obsProblema,'
                    . 'observacoes,'
                    . 'situacaoEtapa,'
                    . 'situacaoTubo,'
                    . 'idLocal_fk'
                    . ')' 
                    . 'VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objInfosTubo->getIdUsuario_fk());
            $arrayBind[] = array('i',$objInfosTubo->getIdPosicao_fk());
            $arrayBind[] = array('i',$objInfosTubo->getIdTubo_fk());
            $arrayBind[] = array('i',$objInfosTubo->getIdLote_fk());
            $arrayBind[] = array('s',$objInfosTubo->getEtapa());
            $arrayBind[] = array('s',$objInfosTubo->getEtapaAnterior());
            $arrayBind[] = array('s',$objInfosTubo->getDataHora());
            $arrayBind[] = array('s',$objInfosTubo->getReteste());
            $arrayBind[] = array('d',$objInfosTubo->getVolume());
            $arrayBind[] = array('s',$objInfosTubo->getObsProblema());
            $arrayBind[] = array('s',$objInfosTubo->getObservacoes());
            $arrayBind[] = array('s',$objInfosTubo->getSituacaoEtapa());
            $arrayBind[] = array('s',$objInfosTubo->getSituacaoTubo());
            $arrayBind[] = array('i',$objInfosTubo->getIdLocalFk());
                       

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objInfosTubo->setIdInfosTubo($objBanco->obterUltimoID());
            //echo $objInfosTubo->getIdInfosTubo();
           return $objInfosTubo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando a amostra no BD.",$ex);
        }
        
    }
    
    public function alterar(InfosTubo $objInfosTubo, Banco $objBanco) {
        try{

            $UPDATE = 'UPDATE tb_infostubo SET '
                    . 'idUsuario_fk = ?,'
                    . 'idPosicao_fk = ?,'
                    . 'idTubo_fk = ?,'
                    . 'idLote_fk = ?,'
                    . 'etapa = ?,'
                    . 'etapaAnterior = ?,'
                    . 'dataHora = ?,'
                    . 'reteste = ?,'
                    . 'volume = ?,'
                    . 'obsProblema = ?,'
                    . 'observacoes = ?,'
                    . 'situacaoEtapa = ?,'
                    . 'situacaoTubo = ?,'
                    . 'idLocal_fk = ?'
                . '  where idInfosTubo = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objInfosTubo->getIdUsuario_fk());
            $arrayBind[] = array('i',$objInfosTubo->getIdPosicao_fk());
            $arrayBind[] = array('i',$objInfosTubo->getIdTubo_fk());
            $arrayBind[] = array('i',$objInfosTubo->getIdLote_fk());
            $arrayBind[] = array('s',$objInfosTubo->getEtapa());
            $arrayBind[] = array('s',$objInfosTubo->getEtapaAnterior());
            $arrayBind[] = array('s',$objInfosTubo->getDataHora());
            $arrayBind[] = array('s',$objInfosTubo->getReteste());
            $arrayBind[] = array('d',$objInfosTubo->getVolume());
            $arrayBind[] = array('s',$objInfosTubo->getObsProblema());
            $arrayBind[] = array('s',$objInfosTubo->getObservacoes());
            $arrayBind[] = array('s',$objInfosTubo->getSituacaoEtapa());
            $arrayBind[] = array('s',$objInfosTubo->getSituacaoTubo());
            $arrayBind[] = array('i',$objInfosTubo->getIdLocalFk());
            
            $arrayBind[] = array('i',$objInfosTubo->getIdInfosTubo());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objInfosTubo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando a amostra no BD.",$ex);
        }
       
    }
    
     public function listar(InfosTubo $objInfosTubo, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_infostubo ";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objInfosTubo->getIdTubo_fk() != null) {
                $WHERE .= $AND . " idTubo_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objInfosTubo->getIdTubo_fk());
            }

             if ($objInfosTubo->getIdLote_fk() != null) {
                 $WHERE .= $AND . " idLote_fk = ?";
                 $AND = ' and ';
                 $arrayBind[] = array('i', $objInfosTubo->getIdLote_fk());
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

             if ($objInfosTubo->getIdPosicao_fk() != null) {
                 $WHERE .= $AND . " idPosicao_fk = ?";
                 $AND = ' and ';
                 $arrayBind[] = array('i', $objInfosTubo->getIdPosicao_fk());
             }

             if ($objInfosTubo->getIdLocalFk() != null) {
                 $WHERE .= $AND . " idLocal_fk = ?";
                 $AND = ' and ';
                 $arrayBind[] = array('i', $objInfosTubo->getIdLocalFk());
             }


             if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            //echo $SELECT.$WHERE;

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

 
            $array_paciente = array();
            foreach ($arr as $reg){
                $objInfosTubo = new InfosTubo();
                $objInfosTubo->setIdInfosTubo($reg['idInfosTubo']);
                $objInfosTubo->setIdUsuario_fk($reg['idUsuario_fk']);
                $objInfosTubo->setIdPosicao_fk($reg['idPosicao_fk']);
                $objInfosTubo->setIdTubo_fk($reg['idTubo_fk']);
                $objInfosTubo->setIdLote_fk($reg['idLote_fk']);
                $objInfosTubo->setEtapa($reg['etapa']);
                $objInfosTubo->setEtapaAnterior($reg['etapaAnterior']);
                $objInfosTubo->setDataHora($reg['dataHora']);
                $objInfosTubo->setReteste($reg['reteste']);
                $objInfosTubo->setVolume($reg['volume']);
                $objInfosTubo->setObsProblema($reg['obsProblema']);
                $objInfosTubo->setObservacoes($reg['observacoes']);
                $objInfosTubo->setSituacaoEtapa($reg['situacaoEtapa']);
                $objInfosTubo->setSituacaoTubo($reg['situacaoTubo']);
                $objInfosTubo->setIdLocalFk($reg['idLocal_fk']);


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
            $objInfosTubo->setIdPosicao_fk($arr[0]['idPosicao_fk']);
            $objInfosTubo->setIdTubo_fk($arr[0]['idTubo_fk']);
            $objInfosTubo->setIdLote_fk($arr[0]['idLote_fk']);
            $objInfosTubo->setEtapa($arr[0]['etapa']);
            $objInfosTubo->setEtapaAnterior($arr[0]['etapaAnterior']);
            $objInfosTubo->setDataHora($arr[0]['dataHora']);
            $objInfosTubo->setReteste($arr[0]['reteste']);
            $objInfosTubo->setVolume($arr[0]['volume']);
            $objInfosTubo->setObsProblema($arr[0]['obsProblema']);
            $objInfosTubo->setObservacoes($arr[0]['observacoes']);
            $objInfosTubo->setSituacaoEtapa($arr[0]['situacaoEtapa']);
            $objInfosTubo->setSituacaoTubo($arr[0]['situacaoTubo']);
            $objInfosTubo->setIdLocalFk($arr[0]['idLocal_fk']);

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


    /**** EXTRAS ****/

    public function listar_completo(InfosTubo $objInfosTubo, Banco $objBanco) {
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

            if ($objInfosTubo->getIdLote_fk() != null) {
                $WHERE .= $AND . " idLote_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objInfosTubo->getIdLote_fk());
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

            if ($objInfosTubo->getIdPosicao_fk() != null) {
                $WHERE .= $AND . " idPosicao_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objInfosTubo->getIdPosicao_fk());
            }

            if ($objInfosTubo->getIdLocalFk() != null) {
                $WHERE .= $AND . " idLocal_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objInfosTubo->getIdLocalFk());
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            //echo $SELECT.$WHERE;$WHERE

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            //print_r($arr);
            $array = array();
            foreach ($arr as $reg){
                $objInfosTubo = new InfosTubo();
                $objInfosTubo->setIdInfosTubo($reg['idInfosTubo']);
                $objInfosTubo->setIdUsuario_fk($reg['idUsuario_fk']);
                $objInfosTubo->setIdPosicao_fk($reg['idPosicao_fk']);
                $objInfosTubo->setIdTubo_fk($reg['idTubo_fk']);
                $objInfosTubo->setIdLote_fk($reg['idLote_fk']);
                $objInfosTubo->setEtapa($reg['etapa']);
                $objInfosTubo->setEtapaAnterior($reg['etapaAnterior']);
                $objInfosTubo->setDataHora($reg['dataHora']);
                $objInfosTubo->setReteste($reg['reteste']);
                $objInfosTubo->setVolume($reg['volume']);
                $objInfosTubo->setObsProblema($reg['obsProblema']);
                $objInfosTubo->setObservacoes($reg['observacoes']);
                $objInfosTubo->setSituacaoEtapa($reg['situacaoEtapa']);
                $objInfosTubo->setSituacaoTubo($reg['situacaoTubo']);
                $objInfosTubo->setIdLocalFk($reg['idLocal_fk']);

               // echo "<pre>";
               // print_r($objInfosTubo);
               // echo "</pre>";

                /*$objTubo = new Tubo();
                $objTuboRN = new TuboRN();
                $objTubo->setIdTubo($reg['idTubo_fk']);
                $arrTubo = $objTuboRN->listar_completo($objTubo,null,true);*/

                $objLocal = new LocalArmazenamentoTexto();
                $objLocalRN = new LocalArmazenamentoTextoRN();

                if($objInfosTubo->getIdLocalFk() != null) {
                    $objLocal->setIdLocal($reg['idLocal_fk']);
                    $local = $objLocalRN->listar($objLocal);
                    $objInfosTubo->setObjLocal($local[0]);
                }


                $array[] = $objInfosTubo;

            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando a amostra no BD.",$ex);
        }

    }


    public function pegar_ultimo(InfosTubo $objInfosTubo, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * from tb_infostubo where idTubo_fk = ? order by idInfosTubo DESC LIMIT 1;';

            $arrayBind = array();
            $arrayBind[] = array('i',$objInfosTubo->getIdTubo_fk());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);
            //echo "!!!";
            //print_r($arr);
            $objInfosTubo = new InfosTubo();
            $objInfosTubo->setIdInfosTubo($arr[0]['idInfosTubo']);
            $objInfosTubo->setIdUsuario_fk($arr[0]['idUsuario_fk']);
            $objInfosTubo->setIdPosicao_fk($arr[0]['idPosicao_fk']);
            $objInfosTubo->setIdTubo_fk($arr[0]['idTubo_fk']);
            $objInfosTubo->setIdLote_fk($arr[0]['idLote_fk']);
            $objInfosTubo->setEtapa($arr[0]['etapa']);
            $objInfosTubo->setEtapaAnterior($arr[0]['etapaAnterior']);
            $objInfosTubo->setDataHora($arr[0]['dataHora']);
            $objInfosTubo->setReteste($arr[0]['reteste']);
            $objInfosTubo->setVolume($arr[0]['volume']);
            $objInfosTubo->setObsProblema($arr[0]['obsProblema']);
            $objInfosTubo->setObservacoes($arr[0]['observacoes']);
            $objInfosTubo->setSituacaoEtapa($arr[0]['situacaoEtapa']);
            $objInfosTubo->setSituacaoTubo($arr[0]['situacaoTubo']);
            $objInfosTubo->setIdLocalFk($arr[0]['idLocal_fk']);

            return $objInfosTubo;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando a amostra no BD.",$ex);
        }

    }


    public function consultar_aguardando_diagnostico(InfosTubo $objInfosTubo,$arrIdPerfis, Banco $objBanco) {
        try{

            $arrIdPerfis = explode(";",$arrIdPerfis);
            array_pop($arrIdPerfis);

            $objInfosTuboRN = new InfosTuboRN();
            $arr_infos = $objInfosTuboRN->listar($objInfosTubo);

            foreach ($arr_infos as $info) {
                $select_max_id = "select max(idInfosTubo) from tb_infostubo where idTubo_fk = ?";
                $arrayBind = array();
                $arrayBind[] = array('i', $info->getIdTubo_fk());
                $arr = $objBanco->consultarSQL($select_max_id,$arrayBind);
                if(count($arr) > 0 ) {
                    //echo $arr[0]['max(idInfosTubo)'];
                    if($arr[0]['max(idInfosTubo)'] == $info->getIdInfosTubo()){
                        $infos_validos[] = $info;
                    }
                }
            }

            $objTubo = new Tubo();
            $objTuboRN = new TuboRN();

            foreach ($infos_validos as $info){
                $objTubo->setIdTubo($info->getIdTubo_fk());
                $arrTubos = $objTuboRN->listar_completo($objTubo,null,true);
                foreach ($arrTubos as $amostra) {
                    foreach ($arrIdPerfis as $idPerfil) {
                        if ($amostra->getObjPerfil()->getIdPerfilPaciente() == $idPerfil) {
                            $arrRetorno[] = $amostra;
                        }
                    }
                }
            }

            $arrNicknameAmostras = array();
            $arrAmostras = array();
            foreach ($arrRetorno as $retorno){
                if(!in_array($retorno->getNickname(), $arrNicknameAmostras)){
                    $arrNicknameAmostras[] =  $retorno->getNickname();
                    $arrAmostras[] = $retorno;
                }else {
                    $arrTubo = array();
                    foreach ($arrAmostras as $amostra) {
                        if($amostra->getNickname() == $retorno->getNickname()) {
                            if (!is_array($amostra->getObjTubo())) {
                                $arrTubo[] = $amostra->getObjTubo();
                            } else {
                                foreach ($amostra->getObjTubo() as $objTubo) {
                                    $arrTubo[] = $objTubo;
                                }
                            }
                            $arrTubo[] = $retorno->getObjTubo();
                            $amostra->setObjTubo($arrTubo);
                        }
                    }
                }
            }

            /*
                echo "<pre>";
                print_r($arrAmostras);
                echo "</pre>";
                DIE();
            */


            return $arrAmostras;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando a amostra no BD.",$ex);
        }

    }


    public function arrumarbanco(InfosTubo $objInfosTubo, $info, Banco $objBanco) {
        try {


            $INSERT1 = 'INSERT into tb_informacoes_tubo (
                
                idUsuario_fk,
                idPosicao_fk,
                idTubo_fk,
                idLote_fk,
                situacaoTubo,
                situacaoEtapa,
                etapa,
                etapaAnterior,
                dataHora,reteste,volume,obsProblema,observacoes) 
                VALUES (
                ' . '\'' . $info->getIdUsuario_fk() . '\',' .
                 ' null ' . ',' .
                $info->getIdTubo_fk()
                . ', null ' . ',\'' .
                $info->getSituacaoTubo() . '\',\'' .
                $info->getSituacaoEtapa() . '\',\'' .
                $info->getEtapa() . '\',' .
                'null,\''.
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
                   $INSERT = 'INSERT into tb_informacoes_tubo (idUsuario_fk,idPosicao_fk,idTubo_fk,idLote_fk,
                        situacaoTubo,situacaoEtapa,etapa,etapaAnterior,dataHora,reteste,volume,obsProblema,
                        observacoes)
                        VALUES (
                       
                        (select idUsuario_fk from tb_infostubo where idInfosTubo = ' . $info->getIdInfosTubo() . '),
                        null,
                        (select idTubo_fk from tb_infostubo where idInfosTubo = ' . $info->getIdInfosTubo() . '),
                        (select idLote_fk from tb_infostubo where idInfosTubo = ' . $info->getIdInfosTubo() . '),'
                       . '\'' . InfosTuboRN::$TST_SEM_UTILIZACAO . '\',\'' .
                       InfosTuboRN::$TSP_AGUARDANDO . '\',\'' .
                       InfosTuboRN::$TP_MONTAGEM_GRUPOS_AMOSTRAS .  '\',\'' .
                       InfosTuboRN::$TP_RECEPCAO . '\',
                        (select dataHora from tb_infostubo where idInfosTubo = ' . $info->getIdInfosTubo() . '),
                        (select reteste from tb_infostubo where idInfosTubo = ' . $info->getIdInfosTubo() . '),
                        (select volume from tb_infostubo where idInfosTubo = ' . $info->getIdInfosTubo() . '),
                        null, null);';
                   echo $INSERT . "\n";
               }

               //$SELECT = 'SELECT * from tb_informacoes_tubo';
               //echo $SELECT;

                //ALTER TABLE tb_informacoes_tubo ADD FOREIGN KEY fk_lote (idLote_fk) REFERENCES tb_lote (idLote);
                //ALTER TABLE tb_informacoes_tubo ADD FOREIGN KEY fk_usuario (idUsuario_fk) REFERENCES tb_usuario (idUsuario);
                //ALTER TABLE tb_informacoes_tubo ADD FOREIGN KEY fk_tubo (idTubo_fk) REFERENCES tb_tubo (idTubo);
                //ALTER TABLE tb_informacoes_tubo ADD FOREIGN KEY fk_posicao (idPosicao_fk) REFERENCES tb_posicao_caixa (idPosicaoCaixa);

               /*CREATE TABLE tb_informacoes_tubo (
                  idInfosTubo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
                  idLote_fk INTEGER UNSIGNED NULL,
                  idUsuario_fk INTEGER UNSIGNED NOT NULL,
                  idPosicao_fk INTEGER UNSIGNED NULL,
                  idTubo_fk INTEGER UNSIGNED NULL,
                  situacaoTubo CHAR(1) NULL,
                  etapa CHAR(1) NULL,
                  etapaAnterior CHAR(1) NULL,
                  situacaoEtapa CHAR(1) NULL,
                  dataHora DATETIME NOT NULL,
                  reteste char(1) NULL,
                  volume DOUBLE NULL,
                  PRIMARY KEY(idInfosTubo)
                  );*/





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
            //die($ex);
            throw new Excecao("Erro cadastrando a amostra no BD.",$ex);
        }

    }


    public function validar_volume(PreparoLote $preparoLote, Banco $objBanco) {
        try{
            //print_r($preparoLote);
            /*foreach ($preparoLote->getObjsTubosAlterados() as $tubos_alterados) {


                print_r($tubos_alterados);

                $SELECT = "SELECT DISTINCT idTubo FROM tb_tubo, tb_amostra
                        where tb_amostra.idAmostra = tb_tubo.idAmostra_fk
                        and tb_amostra.idAmostra = ?  and tb_tubo.tipo = ?";

                $arrayBind = array();
                $arrayBind[] = array('i', $tubos_alterados->getIdAmostra_fk());
                $arrayBind[] = array('s', TuboRN::$TT_ALIQUOTA);
                // no arr tem os ids dos tubos que foram gerados
                $arr = $objBanco->consultarSQL($SELECT, $arrayBind);
            }*/
            $volume = array();
            foreach ($preparoLote->getObjsTubosCadastro() as $tubosCadastrados) {
                if($tubosCadastrados->getTipo() == TuboRN::$TT_INDO_EXTRACAO){ //se cadastrou o tubo já é um sinal de que foi descartado, senão estaria em $preparoLote->getObjLote()->getObjsTubo(),algo assim
                    $SELECT = "SELECT max(idInfosTubo), idTubo_fk, volume from tb_infostubo where idTubo_fk = ? LIMIT 1";
                    $arrayBind = array();
                    $arrayBind[] = array('i', $tubosCadastrados->getIdTubo());
                    $ultima_info = $objBanco->consultarSQL($SELECT, $arrayBind);
                    if($ultima_info[0]['volume'] == 0.0){
                        //procurar por algum tubo dessa amostra q tenha volume, se não encontrar entao ir para o laudo
                        $SELECT2 = "SELECT DISTINCT idTubo FROM tb_tubo, tb_amostra
                        where tb_amostra.idAmostra = tb_tubo.idAmostra_fk
                        and tb_amostra.idAmostra = ? ";
                        $arrayBind2 = array();
                        $arrayBind2[] = array('i', $tubosCadastrados->getIdAmostra_fk());
                        $arr_tubos = $objBanco->consultarSQL($SELECT2, $arrayBind2);

                        $tubo_com_volume = array();
                        $tb_com_vol = 0;
                        foreach ($arr_tubos as $tubo) {

                            $SELECT3 = "SELECT max(tb_infostubo.idInfosTubo), tb_infostubo.idTubo_fk, volume,tb_tubo.tipo 
                                            from tb_infostubo,tb_tubo 
                                            where tb_infostubo.idTubo_fk = ?
                                            AND tb_tubo.idTubo = tb_infostubo.idTubo_fk LIMIT 1";
                            $arrayBind3 = array();
                            $arrayBind3[] = array('i', $tubo['idTubo']);
                            $arr_infos = $objBanco->consultarSQL($SELECT3, $arrayBind3);
                            if($arr_infos[0]['volume'] >= 0.0) {
                                if($arr_infos[0]['volume'] > 0.0 && $arr_infos[0]['tipo'] == TuboRN::$TT_ALIQUOTA){
                                    $tubo_com_volume[0] = $arr_infos[0];
                                }

                                $volume[$tubosCadastrados->getIdAmostra_fk()] += $arr_infos[0]['volume'];
                            }
                        }

                        if($volume[$tubosCadastrados->getIdAmostra_fk()] == 0.0){ //não tem volumes sobrando para mais nada
                            //PEGAR O TUBO ORIGINAL DA AMOSTRA
                            $select_tubo_original = "SELECT idTubo from tb_tubo, tb_amostra
                                                where tb_tubo.tuboOriginal = 's'
                                                and tb_amostra.idAmostra = ?
                                                and tb_tubo.idAmostra_fk = tb_amostra.idAmostra";

                            $idTubo = $objBanco->consultarSQL($select_tubo_original, $arrayBind2);

                            $objInfosTubo = new InfosTubo();
                            $objInfosTuboRN = new InfosTuboRN();
                            $objInfosTubo->setIdTubo_fk($idTubo[0]['idTubo']);
                            $objInfosTubo = $objInfosTuboRN->pegar_ultimo($objInfosTubo);

                            $objInfosTubo->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                            $objInfosTubo->setDataHora(date("Y-m-d H:i:s"));
                            $objInfosTubo->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                            $objInfosTubo->setEtapa(InfosTuboRN::$TP_LAUDO);
                            $objInfosTubo->setSituacaoTubo(InfosTuboRN::$TST_DESCARTADO_SEM_VOLUME);
                            $objInfosTuboRN->cadastrar($objInfosTubo);

                            $objLaudo = new Laudo();
                            $objLaudoRN = new LaudoRN();

                            $objLaudo->setIdAmostraFk($tubosCadastrados->getIdAmostra_fk());
                            $objLaudo->setIdUsuarioFk(Sessao::getInstance()->getIdUsuario());
                            $objLaudo->setDataHoraGeracao(date("Y-m-d H:i:s"));
                            $objLaudo->setResultado(LaudoRN::$RL_PROBLEMAS_PREPARACAO);
                            $objLaudo->setSituacao(LaudoRN::$SL_PENDENTE);
                            $objLaudo = $objLaudoRN->cadastrar($objLaudo);


                        }else { //extração é ZERO, mas tem algum volume sobrando

                            if ($tubo_com_volume[0]['tipo'] == TuboRN::$TT_ALIQUOTA) {

                                $objInfosTubo2 = new InfosTubo();
                                $objInfosTuboRN = new InfosTuboRN();
                                $objInfosTubo2->setIdTubo_fk($tubo_com_volume[0]['idTubo_fk']);
                                $objInfosTubo2 = $objInfosTuboRN->pegar_ultimo($objInfosTubo2);
                                //print_r($objInfosTubo);
                                $objInfosTubo2->setIdUsuario_fk(Sessao::getInstance()->getIdUsuario());
                                $objInfosTubo2->setDataHora(date("Y-m-d H:i:s"));
                                $objInfosTubo2->setSituacaoEtapa(InfosTuboRN::$TSP_AGUARDANDO);
                                $objInfosTubo2->setEtapa(InfosTuboRN::$TP_MONTAGEM_GRUPOS_AMOSTRAS);
                                $objInfosTubo2->setSituacaoTubo(InfosTuboRN::$TST_SEM_UTILIZACAO);
                                $objInfosTubo2->setReteste('s');
                                $objInfosTuboRN->cadastrar($objInfosTubo2);
                                // break;

                            }
                        }

                    }
                }
            }



            return null;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando a amostra no BD.",$ex);
        }

    }



    public function lockRegistro_utilizacaoTubo_MG( $montagemGrupo, Banco $objBanco) {

        try{

            //print_r($montagemGrupo);
            foreach ($montagemGrupo as $grupo){
                echo $grupo->getAmostra()->getObjTubo()->getIdTubo()."\n";
                $objInfosTubo = new InfosTubo();
            }
            die();

            $SELECT = 'SELECT * from tb_infostubo where idTubo_fk = ? order by idInfosTubo DESC LIMIT 1;';

            $arrayBind = array();
            $arrayBind[] = array('i',$objInfosTubo->getIdTubo_fk());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);
            //echo "!!!";
            //print_r($arr);
            $objInfosTubo = new InfosTubo();
            $objInfosTubo->setIdInfosTubo($arr[0]['idInfosTubo']);
            $objInfosTubo->setIdUsuario_fk($arr[0]['idUsuario_fk']);
            $objInfosTubo->setIdPosicao_fk($arr[0]['idPosicao_fk']);
            $objInfosTubo->setIdTubo_fk($arr[0]['idTubo_fk']);
            $objInfosTubo->setIdLote_fk($arr[0]['idLote_fk']);
            $objInfosTubo->setEtapa($arr[0]['etapa']);
            $objInfosTubo->setEtapaAnterior($arr[0]['etapaAnterior']);
            $objInfosTubo->setDataHora($arr[0]['dataHora']);
            $objInfosTubo->setReteste($arr[0]['reteste']);
            $objInfosTubo->setVolume($arr[0]['volume']);
            $objInfosTubo->setObsProblema($arr[0]['obsProblema']);
            $objInfosTubo->setObservacoes($arr[0]['observacoes']);
            $objInfosTubo->setSituacaoEtapa($arr[0]['situacaoEtapa']);
            $objInfosTubo->setSituacaoTubo($arr[0]['situacaoTubo']);
            $objInfosTubo->setIdLocalFk($arr[0]['idLocal_fk']);

            return $objInfosTubo;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando a amostra no BD.",$ex);
        }

    }


    public function procurar_sobra_volume($objAmostra, Banco $objBanco) {

        try{

            $objTubo = new Tubo();
            $objTuboRN = new TuboRN();

            $objTubo->setIdAmostra_fk($objAmostra->getIdAmostra());
            $objTubo->setTipo(TuboRN::$TT_ALIQUOTA);
            $arr_tubos = $objTuboRN->listar_completo($objTubo,null,true);

            foreach ($arr_tubos as $amostra) {
                $tubo = $amostra->getObjTubo();
                $tam = count($tubo->getObjInfosTubo());
                $infoTubo = $tubo->getObjInfosTubo()[$tam - 1];
                if ($infoTubo->getVolume() > 0 && $infoTubo->getSituacaoTubo() != InfosTuboRN::$TST_DESCARTADO && $infoTubo->getSituacaoTubo() != InfosTuboRN::$TST_DESCARTADO_NO_MEIO_ETAPA) {
                    $tubo->setObjInfosTubo($infoTubo);
                    $arr_infos[] = $tubo;
                }
            }

            $objTubo->setIdAmostra_fk($objAmostra->getIdAmostra());
            $objTubo->setTipo(TuboRN::$TT_RNA);
            $arr_tubos = $objTuboRN->listar_completo($objTubo,null,true);

            foreach ($arr_tubos as $amostra) {
                $tubo = $amostra->getObjTubo();
                $encontrou = false;
                $i = 0;
                while(!$encontrou && $i<count($tubo->getObjInfosTubo()) ){
                    $objInfosTubo = $tubo->getObjInfosTubo()[$i];
                    if($objInfosTubo->getSituacaoTubo() == InfosTuboRN::$TST_AGUARDANDO_BANCO_RNA){
                        $infoBanco = $objInfosTubo;
                        $encontrou = true;
                    }
                    $i++;
                }

                if($encontrou){
                    if($infoBanco->getVolume() > 0 && $infoBanco->getSituacaoTubo() != InfosTuboRN::$TST_DESCARTADO &&
                        $infoBanco->getSituacaoTubo() != InfosTuboRN::$TST_DESCARTADO_NO_MEIO_ETAPA){
                        $tubo->setObjInfosTubo($infoBanco);
                        $arr_infos[] = $tubo;
                    }
                }
                /*
                echo "<pre>";
                print_r($infoTubo);
                echo "</pre>";
                */
            }



            /*
            echo "<pre>";
            print_r($arr_infos_bancoRNA);
            echo "</pre>";
            */
            //die();

            return $arr_infos;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando a amostra no BD.",$ex);
        }

    }
    
    

    
}
