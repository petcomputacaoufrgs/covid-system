<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class TuboBD{

    public function cadastrar(Tubo $objTubo, Banco $objBanco) {
        try{
            $INSERT = 'INSERT INTO tb_tubo ('
                    . 'idTubo_fk,'
                    . 'idAmostra_fk,'
                    . 'tuboOriginal,'
                    . 'tipo'
                    . ')' 
                    . 'VALUES (?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objTubo->getIdTubo_fk());
            $arrayBind[] = array('i',$objTubo->getIdAmostra_fk());
            $arrayBind[] = array('s',$objTubo->getTuboOriginal());
            $arrayBind[] = array('s',$objTubo->getTipo());
                       

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objTubo->setIdTubo($objBanco->obterUltimoID());
            return $objTubo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o tubo no BD.",$ex);
        }
        
    }
    
    public function alterar(Tubo $objTubo, Banco $objBanco) {
        try{
                      
            $UPDATE = 'UPDATE tb_tubo SET '
                    . 'idTubo_fk =? ,'
                    . 'idAmostra_fk =?,'
                    . 'tuboOriginal =?,'
                    . 'tipo =? '
                . '  where idTubo = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objTubo->getIdTubo_fk());
            $arrayBind[] = array('i',$objTubo->getIdAmostra_fk());
            $arrayBind[] = array('s',$objTubo->getTuboOriginal());
            $arrayBind[] = array('s',$objTubo->getTipo());

            $arrayBind[] = array('i',$objTubo->getIdTubo());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objTubo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o tubo no BD.",$ex);
        }
       
    }
    
     public function listar(Tubo $objTubo,$numLimite = null, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_tubo";
            
            
            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objTubo->getIdAmostra_fk() != null) {
                $WHERE .= $AND . " idAmostra_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objTubo->getIdAmostra_fk());
            }
            
            if ($objTubo->getTuboOriginal() != null) {
                $WHERE .= $AND . " tuboOriginal = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objTubo->getTuboOriginal());
            }

             if ($objTubo->getTipo() != null) {
                 $WHERE .= $AND . " tipo = ?";
                 $AND = ' and ';
                 $arrayBind[] = array('s', $objTubo->getTipo());
             }
            
            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

             $LIMIT = '';
             if($numLimite != null){
                 $LIMIT = ' LIMIT ?';
                 $arrayBind[] = array('i',$numLimite);
             }

             $arr = $objBanco->consultarSQL($SELECT.$WHERE.$LIMIT,$arrayBind);


             $array_tubos = array();
             if(count($arr) > 0) {
                 foreach ($arr as $reg) {
                     $objTubo = new Tubo();
                     $objTubo->setIdTubo($reg['idTubo']);
                     $objTubo->setIdTubo_fk($reg['idTubo_fk']);
                     $objTubo->setIdAmostra_fk($reg['idAmostra_fk']);
                     $objTubo->setTuboOriginal($reg['tuboOriginal']);
                     $objTubo->setTipo($reg['tipo']);

                     $array_tubos[] = $objTubo;

                 }
             }
            return $array_tubos;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o tubo no BD.",$ex);
        }
       
    }


    public function consultar(Tubo $objTubo, Banco $objBanco) {

        try{

            $SELECT = 'SELECT *  FROM tb_tubo WHERE idTubo = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objTubo->getIdTubo());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);
            
            $objTuboaux = new Tubo();
            
            if($arr != null){
                $objTuboaux->setIdTubo($arr[0]['idTubo']);
                $objTuboaux->setIdTubo_fk($arr[0]['idTubo_fk']);
                $objTuboaux->setIdAmostra_fk($arr[0]['idAmostra_fk']);
                $objTuboaux->setTuboOriginal($arr[0]['tuboOriginal']);
                $objTuboaux->setTipo($arr[0]['tipo']);
                return $objTuboaux;
            }
            return null;

            
        } catch (Throwable $ex) {
       
            throw new Excecao("Erro consultando o tubo no BD.",$ex);
        }

    }
    
    public function remover(Tubo $objTubo, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_tubo WHERE idTubo = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objTubo->getIdTubo());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o tubo no BD.",$ex);
        }
    }



    /************************** FUNÇÕES EXTRAS **************************/

    public function listar_completo(Tubo $objTubo,$numLimite = null,$comInfos=null, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_tubo";


            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objTubo->getIdTubo() != null) {
                $WHERE .= $AND . " idTubo = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objTubo->getIdTubo());
            }

            if ($objTubo->getIdTubo_fk() != null) {
                $WHERE .= $AND . " idTubo_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objTubo->getIdTubo_fk());
            }

            if ($objTubo->getIdAmostra_fk() != null) {
                $WHERE .= $AND . " idAmostra_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objTubo->getIdAmostra_fk());
            }

            if ($objTubo->getTuboOriginal() != null) {
                $WHERE .= $AND . " tuboOriginal = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objTubo->getTuboOriginal());
            }

            if ($objTubo->getTipo() != null) {
                $WHERE .= $AND . " tipo = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objTubo->getTipo());
            }

            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            $LIMIT = '';
            if($numLimite != null){
                $LIMIT = ' LIMIT ?';
                $arrayBind[] = array('i',$numLimite);
            }

            $arr = $objBanco->consultarSQL($SELECT.$WHERE.$LIMIT,$arrayBind);


            $array_tubos = array();
            if(count($arr) > 0) {
                foreach ($arr as $reg) {
                    $objTubo = new Tubo();
                    $objTubo->setIdTubo($reg['idTubo']);
                    $objTubo->setIdTubo_fk($reg['idTubo_fk']);
                    $objTubo->setIdAmostra_fk($reg['idAmostra_fk']);
                    $objTubo->setTuboOriginal($reg['tuboOriginal']);
                    $objTubo->setTipo($reg['tipo']);

                    $objAmostra = new Amostra();
                    $objAmostraRN = new AmostraRN();

                    $objAmostra->setIdAmostra($reg['idAmostra_fk']);
                    $arr_amostras = $objAmostraRN->listar_completo($objAmostra,null);

                    if($comInfos != null && $comInfos) {
                        $objInfosTubo = new InfosTubo();
                        $objInfosTuboRN = new InfosTuboRN();
                        $objInfosTubo->setIdTubo_fk($reg['idTubo']);
                        $arr_infos = $objInfosTuboRN->listar_completo($objInfosTubo);
                        $objTubo->setObjInfosTubo($arr_infos);
                    }

                    $arr_amostras[0]->setObjTubo($objTubo);

                    $array_tubos[] = $arr_amostras[0];

                }
            }
            return $array_tubos;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o tubo completo no BD.",$ex);
        }

    }



}
