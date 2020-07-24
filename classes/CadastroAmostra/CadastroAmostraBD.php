<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class CadastroAmostraBD{

    public function cadastrar(CadastroAmostra $objCadastroAmostra, Banco $objBanco) {
        try{
            
            $INSERT = 'INSERT INTO tb_cadastroamostra (idUsuario_fk,idAmostra_fk,dataCadastroInicio,dataCadastroFim) VALUES (?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objCadastroAmostra->getIdUsuario_fk());
            $arrayBind[] = array('i',$objCadastroAmostra->getIdAmostra_fk());
            $arrayBind[] = array('s',$objCadastroAmostra->getDataHoraInicio());            
            $arrayBind[] = array('s',$objCadastroAmostra->getDataHoraFim());

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objCadastroAmostra->setIdCadastroAmostra($objBanco->obterUltimoID());
            
           return $objCadastroAmostra;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o paciente  no BD (CadastroAmostraBD).",$ex);
        }
    }
    
    public function alterar(CadastroAmostra $objCadastroAmostra, Banco $objBanco) {
        try{
                      
            $UPDATE = 'UPDATE tb_cadastroamostra SET '
                    . ' idUsuario_fk = ?,'
                    . ' idAmostra_fk = ?,'
                    . ' dataCadastroInicio = ?,'
                    . ' dataCadastroFim = ?'
                . '  where idCadastroAmostra = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objCadastroAmostra->getIdUsuario_fk());
            $arrayBind[] = array('i',$objCadastroAmostra->getIdAmostra_fk());
            $arrayBind[] = array('s',$objCadastroAmostra->getDataHoraInicio());
            $arrayBind[] = array('s',$objCadastroAmostra->getDataHoraFim());
            $arrayBind[] = array('i',$objCadastroAmostra->getIdCadastroAmostra());
            
            
            $arrayBind[] = array('i',$objCadastroAmostra->getIdCadastroAmostra());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objCadastroAmostra;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o cadastro da amostra no BD (CadastroAmostraBD).",$ex);
        }
       
    }
    
     public function listar(CadastroAmostra $objCadastroAmostra,$numLimite = null, Banco $objBanco) {
         try{
      
             $SELECT = "SELECT * FROM tb_cadastroamostra ";
             $LIMIT = '';
             $WHERE = '';
             $AND = ' ';
             $arrayBind = array();

             if ($objCadastroAmostra->getIdAmostra_fk() != null) {
                 $WHERE .= $AND . "  idAmostra_fk = ?";
                 $AND = ' and ';
                 $arrayBind[] = array('i', $objCadastroAmostra->getIdAmostra_fk());
             }

             if ($WHERE != '') {
                 $WHERE = ' where ' . $WHERE;
             }

             if(!is_null($numLimite)){
                $LIMIT = ' LIMIT ?';
                $arrayBind[] = array('i',$numLimite);
             }
             $arr = $objBanco->consultarSQL($SELECT.$WHERE.$LIMIT, $arrayBind);

             $array = array();
             foreach ($arr as $reg){
                $objCadastroAmostra = new CadastroAmostra();
                $objCadastroAmostra->setIdCadastroAmostra($reg['idCadastroAmostra']);
                $objCadastroAmostra->setIdUsuario_fk($reg['idUsuario_fk']);
                $objCadastroAmostra->setIdAmostra_fk($reg['idAmostra_fk']);
                $objCadastroAmostra->setDataHoraFim($reg['dataCadastroFim']);
                $objCadastroAmostra->setDataHoraInicio($reg['dataCadastroInicio']);

                $array[] = $objCadastroAmostra;
                
             }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o cadastro da amostra no BD (CadastroAmostraBD).",$ex);
        }
       
    }

    public function listar_completo(CadastroAmostra $objCadastroAmostra,$data = null,$numLimite=null, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_cadastroamostra";

            $WHERE = '';
            $AND = '';
            $FROM = '';
            $arrayBind = array();

            if ($objCadastroAmostra->getIdAmostra_fk() != null) {
                $WHERE .= $AND . " tb_cadastroamostra.idAmostra_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objCadastroAmostra->getIdAmostra_fk());
            }

            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            $LIMIT = '';
            if(!is_null($numLimite)){
                $LIMIT = ' LIMIT ?';
                $arrayBind[] = array('i',$numLimite);
            }

            $arr = $objBanco->consultarSQL($SELECT .$FROM. $WHERE.$LIMIT, $arrayBind);

            $array = array();
            foreach ($arr as $reg){
                $listar = true;
                $dataCadastro = explode(" ",$reg['dataCadastroInicio']);
                if(!is_array($data) && !is_null($data)) {
                    if($dataCadastro[0] != $data){
                        $listar = false;
                    }
                }else if(is_array($data)){
                    $encontrou = false;
                    $i=0;
                    while(!$encontrou && $i<count($data)){
                        if($dataCadastro[0] != $data[$i]){
                            $listar = false;
                        }else{
                            $encontrou = true;
                            $listar = true;
                        }
                        $i++;
                    }

                }

                if($listar) {
                    $objCadastroAmostraNovo = new CadastroAmostra();
                    $objCadastroAmostraNovo->setIdCadastroAmostra($reg['idCadastroAmostra']);
                    $objCadastroAmostraNovo->setIdUsuario_fk($reg['idUsuario_fk']);
                    $objCadastroAmostraNovo->setIdAmostra_fk($reg['idAmostra_fk']);
                    $objCadastroAmostraNovo->setDataHoraFim($reg['dataCadastroFim']);
                    $objCadastroAmostraNovo->setDataHoraInicio($reg['dataCadastroInicio']);

                    $objAmostra = new Amostra();
                    $objAmostraRN = new AmostraRN();
                    $objAmostra->setIdAmostra($objCadastroAmostraNovo->getIdAmostra_fk());
                    $arrAmostras = $objAmostraRN->listar_completo($objAmostra);
                    $objCadastroAmostraNovo->setObjAmostra($arrAmostras[0]);

                    $objUsuario = new Usuario();
                    $objUsuarioRN = new UsuarioRN();
                    $objUsuario->setIdUsuario($objCadastroAmostraNovo->getIdUsuario_fk());
                    $objUsuario = $objUsuarioRN->consultar($objUsuario);
                    $objCadastroAmostraNovo->setObjUsuario($objUsuario);

                    $array[] = $objCadastroAmostraNovo;
                }

            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o cadastro da amostra no BD (CadastroAmostraBD).",$ex);
        }

    }


    public function paginacao(CadastroAmostra $objCadastroAmostra, Banco $objBanco) {
        try{

            $inicio = ($objCadastroAmostra->getNumPagina()-1)*500;

            if($objCadastroAmostra->getNumPagina() == null){
                $inicio = 0;
            }

            $SELECT = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_cadastroamostra ";

            $WHERE = '';
            $AND = '';
            $FROM = '';
            $arrayBind = array();

            if(!is_null($objCadastroAmostra->getObjAmostra())) {
                $FROM .=' ,tb_amostra ';
                $WHERE .= $AND . " tb_amostra.idAmostra = tb_cadastroamostra.idAmostra_fk ";
                $AND = ' and ';
                if ($objCadastroAmostra->getObjAmostra()->getIdAmostra_fk() != null) {
                    $WHERE .= $AND . " tb_amostra.idAmostra = ?";
                    $AND = ' and ';
                    $arrayBind[] = array('i', $objCadastroAmostra->getObjAmostra()->getIdAmostra_fk());
                }
            }

            if(!is_null($objCadastroAmostra->getObjUsuario())) {
                $FROM .=' ,tb_usuario ';
                $WHERE .= $AND . " tb_usuario.idUsuario = tb_cadastroamostra.idUsuario_fk ";
                $AND = ' and ';
                if ($objCadastroAmostra->getObjUsuario()->getCPF() != null) {
                    $WHERE .= $AND . " tb_usuario.CPF = ?";
                    $AND = ' and ';
                    $arrayBind[] = array('s', $objCadastroAmostra->getObjUsuario()->getCPF());
                }

                if ($objCadastroAmostra->getObjUsuario()->getMatricula() != null) {
                    $WHERE .= $AND . " tb_usuario.matricula = ?";
                    $AND = ' and ';
                    $arrayBind[] = array('s', $objCadastroAmostra->getObjUsuario()->getMatricula());
                }
            }

            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            $SELECT.= $FROM.$WHERE. ' order by tb_cadastroAmostra.idCadastroAmostra desc';
            $SELECT.= ' LIMIT ?,500 ';


            $arrayBind[] = array('i',$inicio);
            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $SELECT = "SELECT FOUND_ROWS() as total";
            $total = $objBanco->consultarSQL($SELECT);
            $objCadastroAmostra->setTotalRegistros($total[0]['total']);
            $objCadastroAmostra->setNumPagina($inicio);

            $array = array();
            foreach ($arr as $reg){

                $objCadastroAmostraNovo = new CadastroAmostra();
                $objCadastroAmostraNovo->setIdCadastroAmostra($reg['idCadastroAmostra']);
                $objCadastroAmostraNovo->setIdUsuario_fk($reg['idUsuario_fk']);
                $objCadastroAmostraNovo->setIdAmostra_fk($reg['idAmostra_fk']);
                $objCadastroAmostraNovo->setDataHoraFim($reg['dataCadastroFim']);
                $objCadastroAmostraNovo->setDataHoraInicio($reg['dataCadastroInicio']);

                $objAmostra = new Amostra();
                $objAmostraRN = new AmostraRN();
                $objAmostra->setIdAmostra($objCadastroAmostraNovo->getIdAmostra_fk());
                $objAmostra = $objAmostraRN->consultar($objAmostra);
                $objCadastroAmostraNovo->setObjAmostra($objAmostra);

                $objUsuario = new Usuario();
                $objUsuarioRN = new UsuarioRN();
                $objUsuario->setIdUsuario($objCadastroAmostraNovo->getIdUsuario_fk());
                $objUsuario = $objUsuarioRN->consultar($objUsuario);
                $objCadastroAmostraNovo->setObjUsuario($objUsuario);

                $array[] = $objCadastroAmostraNovo;
            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro realizando paginação do cadastro da amostra no BD (CadastroAmostraBD).",$ex);
        }
    }
    
    public function consultar(CadastroAmostra $objCadastroAmostra, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_cadastroamostra WHERE idUsuario_fk = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objCadastroAmostra->getIdUsuario_fk());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $cadastroAmostra = new CadastroAmostra();
            if(count($arr) > 0) {
                $cadastroAmostra->setIdCadastroAmostra($arr[0]['idCadastroAmostra']);
                $cadastroAmostra->setIdUsuario_fk($arr[0]['idUsuario_fk']);
                $cadastroAmostra->setIdLocalArmazenamento_fk($arr[0]['idLocalArmazenamento_fk']);
                $cadastroAmostra->setIdAmostra_fk($arr[0]['idAmostra_fk']);
                $cadastroAmostra->setDataHoraInicio($arr[0]['dataCadastroInicio']);
                $cadastroAmostra->setDataHoraFim($arr[0]['dataCadastroFim']);
            }

            return $cadastroAmostra;
        } catch (Throwable $ex) {
            throw new Excecao("Erro consultando o cadastro da amostra no BD (CadastroAmostraBD).",$ex);
        }

    }
    
    public function remover(CadastroAmostra $objCadastroAmostra, Banco $objBanco) {
        try{
            $DELETE = 'DELETE FROM tb_cadastroamostra WHERE idCadastroAmostra = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objCadastroAmostra->getIdCadastroAmostra());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o cadastro da amostra no BD (CadastroAmostraBD).",$ex);
        }
    }

    public function remover_banco(CadastroAmostra $objCadastroAmostra, Banco $objBanco) {
        try{
            $DELETE = 'SELECT idAmostra_fk, COUNT(idAmostra_fk) AS Qtd FROM tb_cadastroamostra GROUP BY idAmostra_fk HAVING COUNT(idAmostra_fk) > 1 ORDER BY COUNT(idAmostra_fk) DESC';
            $arrayBind = array();
            $arrayBind[] = array('i',$objCadastroAmostra->getIdCadastroAmostra());
            $arr = $objBanco->consultarSql($DELETE);
            //print_r($arr);

            foreach ($arr as $item){
                echo $item['Qtd'];


                $objCadastroAmostra = new CadastroAmostra();
                $objCadastroAmostraRN = new CadastroAmostraRN();
                $objCadastroAmostra->setIdAmostra_fk($item['idAmostra_fk']);
                $arramostras = $objCadastroAmostraRN->listar($objCadastroAmostra);
                for($i=0; $i<count($arramostras)-1; $i++){
                    //echo $i;
                    $objCadastroAmostraRN->remover($arramostras[$i]);
                }



            }


        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o cadastro da amostra no BD (CadastroAmostraBD).",$ex);
        }
    }

}
