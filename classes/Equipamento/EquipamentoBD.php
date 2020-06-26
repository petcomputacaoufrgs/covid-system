<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class EquipamentoBD{

    public function cadastrar(Equipamento $objEquipamento, Banco $objBanco) {
        try{
            
            $INSERT = 'INSERT INTO tb_equipamento (idDetentor_fk,idMarca_fk,idModelo_fk,dataUltimaCalibragem,dataChegada,nomeEquipamento,situacaoEquipamento,
                            idUsuario_fk,dataCadastro,horas,minutos)
                        VALUES (?,?,?,?,?,?,?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objEquipamento->getIdDetentor_fk());
            $arrayBind[] = array('i',$objEquipamento->getIdMarca_fk());
            $arrayBind[] = array('i',$objEquipamento->getIdModelo_fk());
            $arrayBind[] = array('s',$objEquipamento->getDataUltimaCalibragem());
            $arrayBind[] = array('s',$objEquipamento->getDataChegada());
            $arrayBind[] = array('s',$objEquipamento->getNomeEquipamento());
            $arrayBind[] = array('s',$objEquipamento->getSituacaoEquipamento());
            $arrayBind[] = array('i',$objEquipamento->getIdUsuarioFk());
            $arrayBind[] = array('s',$objEquipamento->getDataCadastro());
            $arrayBind[] = array('i',$objEquipamento->getHoras());
            $arrayBind[] = array('i',$objEquipamento->getMinutos());

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objEquipamento->setIdEquipamento($objBanco->obterUltimoID());
            return $objEquipamento;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando equipamento no BD.",$ex);
        }
        
    }
    
    public function alterar(Equipamento $objEquipamento, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_equipamento SET '
                    . ' idDetentor_fk = ? ,'
                    . ' idMarca_fk = ? ,'
                    . ' idModelo_fk = ? ,'
                    . ' dataUltimaCalibragem = ? ,'
                    . ' dataChegada = ?,'
                    . ' nomeEquipamento = ? ,'
                    . 'situacaoEquipamento = ?,'
                    . ' idUsuario_fk = ? ,'
                    . 'dataCadastro = ?,'
                    . ' horas = ? ,'
                    . 'minutos = ?'
                . '  where idEquipamento = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objEquipamento->getIdDetentor_fk());
            $arrayBind[] = array('i',$objEquipamento->getIdMarca_fk());
            $arrayBind[] = array('i',$objEquipamento->getIdModelo_fk());
            $arrayBind[] = array('s',$objEquipamento->getDataUltimaCalibragem());
            $arrayBind[] = array('s',$objEquipamento->getDataChegada());
            $arrayBind[] = array('s',$objEquipamento->getNomeEquipamento());
            $arrayBind[] = array('s',$objEquipamento->getSituacaoEquipamento());
            $arrayBind[] = array('i',$objEquipamento->getIdUsuarioFk());
            $arrayBind[] = array('s',$objEquipamento->getDataCadastro());
            $arrayBind[] = array('i',$objEquipamento->getHoras());
            $arrayBind[] = array('i',$objEquipamento->getMinutos());

            $arrayBind[] = array('i',$objEquipamento->getIdEquipamento());

            $objBanco->executarSQL($UPDATE,$arrayBind);

            return $objEquipamento;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando equipamento no BD.",$ex);
        }
       
    }

    public function listar(Equipamento $objEquipamento,$numLimite=null, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_equipamento";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();



            if ($objEquipamento->getIdDetentor_fk() != null) {
                $WHERE .= $AND . " idDetentor_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objEquipamento->getIdDetentor_fk());
            }


            if($objEquipamento->getIdMarca_fk() != null){
                $WHERE .= $AND." idMarca_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i',$objEquipamento->getIdMarca_fk());
            }

            if($objEquipamento->getIdModelo_fk() != null){
                $WHERE .= $AND." idModelo_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i',$objEquipamento->getIdModelo_fk());
            }
            if($objEquipamento->getHoras() != null){
                $WHERE .= $AND." horas = ?";
                $AND = ' and ';
                $arrayBind[] = array('i',$objEquipamento->getHoras());
            }

            if($objEquipamento->getNomeEquipamento() != null){
                $WHERE .= $AND." nomeEquipamento LIKE  ?";
                $AND = ' and ';
                $arrayBind[] = array('s',".%".$objEquipamento->getNomeEquipamento()."%");
            }

            if($objEquipamento->getSituacaoEquipamento() != null){
                $WHERE .= $AND." situacaoEquipamento =  ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objEquipamento->getSituacaoEquipamento());
            }


            if($WHERE != ''){
                $WHERE = ' where '.$WHERE;
            }

            $LIMIT = '';
            if(!is_null($numLimite)){
                $LIMIT = ' LIMIT ?';
                $arrayBind[] = array('i',$numLimite);
            }

            $arr = $objBanco->consultarSQL($SELECT.$WHERE.$LIMIT,$arrayBind);


            $array_equipamento = array();
            foreach ($arr as $reg){
                $objEquipamento = new Equipamento();
                $objEquipamento->setIdEquipamento($reg['idEquipamento']);
                $objEquipamento->setIdDetentor_fk($reg['idDetentor_fk']);
                $objEquipamento->setIdMarca_fk($reg['idMarca_fk']);
                $objEquipamento->setIdModelo_fk($reg['idModelo_fk']);
                $objEquipamento->setDataUltimaCalibragem($reg['dataUltimaCalibragem']);
                $objEquipamento->setDataChegada($reg['dataChegada']);
                $objEquipamento->setNomeEquipamento($reg['nomeEquipamento']);
                $objEquipamento->setSituacaoEquipamento($reg['situacaoEquipamento']);
                $objEquipamento->setIdUsuarioFk($reg['idUsuario_fk']);
                $objEquipamento->setDataCadastro($reg['dataCadastro']);
                $objEquipamento->setHoras($reg['horas']);
                $objEquipamento->setMinutos($reg['minutos']);

                $array_equipamento[] = $objEquipamento;
            }
            return $array_equipamento;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando equipamento no BD.",$ex);
        }

    }

    public function consultar(Equipamento $objEquipamento, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_equipamento WHERE idEquipamento = ?';
                       
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
            $equipamento->setNomeEquipamento($arr[0]['nomeEquipamento']);
            $equipamento->setSituacaoEquipamento($arr[0]['situacaoEquipamento']);
            $equipamento->setIdUsuarioFk($arr[0]['idUsuario_fk']);
            $equipamento->setDataCadastro($arr[0]['dataCadastro']);
            $equipamento->setHoras($arr[0]['horas']);
            $equipamento->setMinutos($arr[0]['minutos']);

            return $equipamento;
        } catch (Throwable $ex) {
       
            throw new Excecao("Erro consultando equipamento no BD.",$ex);
        }

    }
    
    public function remover(Equipamento $objEquipamento, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_equipamento WHERE idEquipamento = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objEquipamento->getIdEquipamento());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo equipamento no BD.",$ex);
        }
    }

    /**** EXTRAS ****/

    public function listar_completo(Equipamento $objEquipamento,$numLimite=null, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_equipamento";

            $FROM = '';
            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if($objEquipamento->getObjDetentor() != null) {
                $FROM .=' ,tb_detentor ';
                $WHERE .= $AND . " tb_equipamento.idDetentor_fk = tb_detentor.idDetentor ";
                $AND = ' and ';

                if ($objEquipamento->getObjDetentor()->getIdDetentor() != null) {
                    $WHERE .= $AND . " tb_detentor.idDetentor = ?";
                    $AND = ' and ';
                    $arrayBind[] = array('i', $objEquipamento->getObjDetentor()->getIdDetentor());
                }
                if ($objEquipamento->getObjDetentor()->getIndex_detentor() != null) {
                    $WHERE .= $AND . " tb_detentor.index_detentor = ?";
                    $AND = ' and ';
                    $arrayBind[] = array('s', $objEquipamento->getObjDetentor()->getIndex_detentor());
                }
            }

            if($objEquipamento->getObjMarca() != null) {
                $FROM .=' ,tb_marca ';
                $WHERE .= $AND . " tb_equipamento.idMarca_fk = tb_marca.idMarca ";
                $AND = ' and ';

                if ($objEquipamento->getObjMarca()->getIdMarca() != null) {
                    $WHERE .= $AND . " tb_marca.idMarca = ?";
                    $AND = ' and ';
                    $arrayBind[] = array('i', $objEquipamento->getObjMarca()->getIdMarca());
                }
                if ($objEquipamento->getObjMarca()->getIndex_marca() != null) {
                    $WHERE .= $AND . " tb_marca.index_marca = ?";
                    $AND = ' and ';
                    $arrayBind[] = array('s', $objEquipamento->getObjMarca()->getIndex_marca());
                }
            }

            if($objEquipamento->getObjModelo() != null) {
                $FROM .=' ,tb_modelo ';
                $WHERE .= $AND . " tb_equipamento.idModelo_fk = tb_modelo.idModelo ";
                $AND = ' and ';

                if ($objEquipamento->getObjModelo()->getIdModelo() != null) {
                    $WHERE .= $AND . " tb_modelo.idModelo = ?";
                    $AND = ' and ';
                    $arrayBind[] = array('i', $objEquipamento->getObjModelo()->getIdModelo());
                }
                if ($objEquipamento->getObjModelo()->getIndex_modelo() != null) {
                    $WHERE .= $AND . " tb_modelo.index_modelo = ?";
                    $AND = ' and ';
                    $arrayBind[] = array('s', $objEquipamento->getObjModelo()->getIndex_modelo());
                }
            }

            if($objEquipamento->getNomeEquipamento() != null){
                $WHERE .= $AND." nomeEquipamento LIKE  ?";
                $AND = ' and ';
                $arrayBind[] = array('s',".%".$objEquipamento->getNomeEquipamento()."%");
            }

            if($objEquipamento->getIdEquipamento() != null){
                $WHERE .= $AND." idEquipamento = ?";
                $AND = ' and ';
                $arrayBind[] = array('i',$objEquipamento->getIdEquipamento());
            }

            if($objEquipamento->getSituacaoEquipamento() != null){
                $WHERE .= $AND." situacaoEquipamento = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objEquipamento->getSituacaoEquipamento());
            }

            if($objEquipamento->getHoras() != null){
                $WHERE .= $AND." horas = ?";
                $AND = ' and ';
                $arrayBind[] = array('i',$objEquipamento->getHoras());
            }

            if($objEquipamento->getMinutos() != null){
                $WHERE .= $AND." minutos = ?";
                $AND = ' and ';
                $arrayBind[] = array('i',$objEquipamento->getMinutos());
            }


            if($WHERE != ''){
                $WHERE = ' where '.$WHERE;
            }

            $LIMIT = '';
            if(!is_null($numLimite)){
                $LIMIT = ' LIMIT ?';
                $arrayBind[] = array('i',$numLimite);
            }

            $arr = $objBanco->consultarSQL($SELECT.$FROM.$WHERE.$LIMIT,$arrayBind);


            $array_equipamento = array();
            foreach ($arr as $reg){
                $objEquipamento = new Equipamento();
                $objEquipamento->setIdEquipamento($reg['idEquipamento']);
                $objEquipamento->setIdDetentor_fk($reg['idDetentor_fk']);
                $objEquipamento->setIdMarca_fk($reg['idMarca_fk']);
                $objEquipamento->setIdModelo_fk($reg['idModelo_fk']);
                $objEquipamento->setDataUltimaCalibragem($reg['dataUltimaCalibragem']);
                $objEquipamento->setDataChegada($reg['dataChegada']);
                $objEquipamento->setDataCadastro($reg['dataCadastro']);
                $objEquipamento->setIdUsuarioFk($reg['idUsuario_fk']);
                $objEquipamento->setSituacaoEquipamento($reg['situacaoEquipamento']);
                $objEquipamento->setNomeEquipamento($reg['nomeEquipamento']);
                $objEquipamento->setHoras($reg['horas']);
                $objEquipamento->setMinutos($reg['minutos']);


                //** DETENTOR
                $objDetentor = new Detentor();
                $objDetentorRN = new DetentorRN();
                $objDetentor->setIdDetentor($objEquipamento->getIdDetentor_fk());
                $objDetentor = $objDetentorRN->consultar($objDetentor);
                $objEquipamento->setObjDetentor($objDetentor);

                //** MODELO
                $objModelo = new Modelo();
                $objModeloRN = new ModeloRN();
                $objModelo->setIdModelo($objEquipamento->getIdModelo_fk());
                $objModelo = $objModeloRN->consultar($objModelo);
                $objEquipamento->setObjModelo($objModelo);

                //** MARCA
                $objMarca = new Marca();
                $objMarcaRN = new MarcaRN();
                $objMarca->setIdMarca($objEquipamento->getIdMarca_fk());
                $objMarca = $objMarcaRN->consultar($objMarca);
                $objEquipamento->setObjMarca($objMarca);

                $array_equipamento[] = $objEquipamento;
            }
            return $array_equipamento;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando equipamento no BD.",$ex);
        }

    }

    public function paginacao(Equipamento $objEquipamento, Banco $objBanco) {
        try{

            $inicio = ($objEquipamento->getNumPagina()-1)*20;

            if($objEquipamento->getNumPagina() == null){
                $inicio = 0;
            }

            $SELECT = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_equipamento";

            $FROM = '';
            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objEquipamento->getIdEquipamento() != null) {
                $WHERE .= $AND . " tb_equipamento.idEquipamento = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objEquipamento->getIdEquipamento());
            }

            if ($objEquipamento->getNomeEquipamento() != null) {
                $WHERE .= $AND . " tb_equipamento.nomeEquipamento LIKE ?";
                $AND = ' and ';
                $arrayBind[] = array('s', "%".$objEquipamento->getNomeEquipamento()."%");
            }


            if ($objEquipamento->getSituacaoEquipamento() != null) {
                $WHERE .= $AND . " tb_equipamento.situacaoEquipamento = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objEquipamento->getSituacaoEquipamento());
            }

            if ($objEquipamento->getDataChegada() != null) {
                $WHERE .= $AND . " tb_equipamento.dataChegada = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objEquipamento->getDataChegada());
            }

            if ($objEquipamento->getDataUltimaCalibragem() != null) {
                $WHERE .= $AND . " tb_equipamento.dataUltimaCalibragem = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objEquipamento->getDataUltimaCalibragem());
            }

            if($objEquipamento->getObjDetentor() != null) {
                $FROM .=' ,tb_detentor ';
                $WHERE .= $AND . " tb_equipamento.idDetentor_fk = tb_detentor.idDetentor ";
                $AND = ' and ';

                if ($objEquipamento->getObjDetentor()->getIdDetentor() != null) {
                    $WHERE .= $AND . " tb_detentor.idDetentor = ?";
                    $AND = ' and ';
                    $arrayBind[] = array('i', $objEquipamento->getObjDetentor()->getIdDetentor());
                }
                if ($objEquipamento->getObjDetentor()->getIndex_detentor() != null) {
                    $WHERE .= $AND . " tb_detentor.index_detentor LIKE ?";
                    $AND = ' and ';
                    $arrayBind[] = array('s', "%".$objEquipamento->getObjDetentor()->getIndex_detentor()."%");
                }
            }

            if($objEquipamento->getObjMarca() != null) {
                $FROM .=' ,tb_marca ';
                $WHERE .= $AND . " tb_equipamento.idMarca_fk = tb_marca.idMarca ";
                $AND = ' and ';

                if ($objEquipamento->getObjMarca()->getIdMarca() != null) {
                    $WHERE .= $AND . " tb_marca.idMarca = ?";
                    $AND = ' and ';
                    $arrayBind[] = array('i', $objEquipamento->getObjMarca()->getIdMarca());
                }
                if ($objEquipamento->getObjMarca()->getIndex_marca() != null) {
                    $WHERE .= $AND . " tb_marca.index_marca LIKE ?";
                    $AND = ' and ';
                    $arrayBind[] = array('s', "%".$objEquipamento->getObjMarca()->getIndex_marca()."%");
                }
            }

            if($objEquipamento->getObjModelo() != null) {
                $FROM .=' ,tb_modelo ';
                $WHERE .= $AND . " tb_equipamento.idModelo_fk = tb_modelo.idModelo ";
                $AND = ' and ';

                if ($objEquipamento->getObjModelo()->getIdModelo() != null) {
                    $WHERE .= $AND . " tb_modelo.idModelo = ?";
                    $AND = ' and ';
                    $arrayBind[] = array('i', $objEquipamento->getObjModelo()->getIdModelo());
                }
                if ($objEquipamento->getObjModelo()->getIndex_modelo() != null) {
                    $WHERE .= $AND . " tb_modelo.index_modelo LIKE ?";
                    $AND = ' and ';
                    $arrayBind[] = array('s', "%".$objEquipamento->getObjModelo()->getIndex_modelo()."%");
                }
            }


            if($WHERE != ''){
                $WHERE = ' where '.$WHERE;
            }


            $order_by = ' order by  tb_equipamento.idEquipamento desc ';
            $limit = ' LIMIT ?,20';

            $arrayBind[] = array('i', $inicio);
            $arr = $objBanco->consultarSQL($SELECT .$FROM. $WHERE.$order_by.$limit, $arrayBind);

            $SELECT = "SELECT FOUND_ROWS() as total";
            $total = $objBanco->consultarSQL($SELECT);
            $objEquipamento->setTotalRegistros($total[0]['total']);
            $objEquipamento->setNumPagina($inicio);

            $array_equipamento = array();
            foreach ($arr as $reg){
                $equipamento = new Equipamento();
                $equipamento->setIdEquipamento($reg['idEquipamento']);
                $equipamento->setIdDetentor_fk($reg['idDetentor_fk']);
                $equipamento->setIdMarca_fk($reg['idMarca_fk']);
                $equipamento->setIdModelo_fk($reg['idModelo_fk']);
                $equipamento->setDataUltimaCalibragem($reg['dataUltimaCalibragem']);
                $equipamento->setDataChegada($reg['dataChegada']);
                $equipamento->setNomeEquipamento($reg['nomeEquipamento']);
                $equipamento->setSituacaoEquipamento($reg['situacaoEquipamento']);
                $equipamento->setHoras($reg['horas']);
                $equipamento->setMinutos($reg['minutos']);

                //** DETENTOR
                $objDetentor = new Detentor();
                $objDetentorRN = new DetentorRN();
                $objDetentor->setIdDetentor($equipamento->getIdDetentor_fk());
                $objDetentor = $objDetentorRN->consultar($objDetentor);
                $equipamento->setObjDetentor($objDetentor);

                //** MODELO
                $objModelo = new Modelo();
                $objModeloRN = new ModeloRN();
                $objModelo->setIdModelo($equipamento->getIdModelo_fk());
                $objModelo = $objModeloRN->consultar($objModelo);
                $equipamento->setObjModelo($objModelo);

                //** MARCA
                $objMarca = new Marca();
                $objMarcaRN = new MarcaRN();
                $objMarca->setIdMarca($equipamento->getIdMarca_fk());
                $objMarca = $objMarcaRN->consultar($objMarca);
                $equipamento->setObjMarca($objMarca);

                $array_equipamento[] = $equipamento;
            }
            return $array_equipamento;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando equipamento no BD.",$ex);
        }

    }

    public function bloquear_registro(Equipamento $objEquipamento, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_equipamento WHERE  idEquipamento = ? FOR UPDATE ';


            $arrayBind = array();
            $arrayBind[] = array('i', $objEquipamento->getIdEquipamento());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $equipamento = new Equipamento();
            $equipamento->setIdEquipamento($arr[0]['idEquipamento']);
            $equipamento->setIdDetentor_fk($arr[0]['idDetentor_fk']);
            $equipamento->setIdMarca_fk($arr[0]['idMarca_fk']);
            $equipamento->setIdModelo_fk($arr[0]['idModelo_fk']);
            $equipamento->setDataUltimaCalibragem($arr[0]['dataUltimaCalibragem']);
            $equipamento->setDataChegada($arr[0]['dataChegada']);
            $equipamento->setNomeEquipamento($arr[0]['nomeEquipamento']);
            $equipamento->setSituacaoEquipamento($arr[0]['situacaoEquipamento']);
            $equipamento->setIdUsuarioFk($arr[0]['idUsuario_fk']);
            $equipamento->setDataCadastro($arr[0]['dataCadastro']);
            $equipamento->setHoras($arr[0]['horas']);
            $equipamento->setMinutos($arr[0]['minutos']);

            $objEquipamentoRN = new EquipamentoRN();
            $equipamento->setSituacaoEquipamento(EquipamentoRN::$TE_OCUPADO);
            $equipamento = $objEquipamentoRN->alterar($equipamento);

            return $equipamento;

        } catch (Throwable $ex) {

            throw new Excecao("Erro bloqueando o equipamento de RTqPCR no BD.",$ex);
        }

    }

    /*
    public function existe(Equipamento $objEquipamento, Banco $objBanco)
    {
        try {

            $SELECT = "SELECT * FROM tb_equipamento";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objEquipamento->getIdMarca_fk() != null) {
                $WHERE .= $AND . " idMarca_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objEquipamento->getIdMarca_fk());
            }

            if ($objEquipamento->getIdDetentor_fk() != null) {
                $WHERE .= $AND . " idDetentor_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objEquipamento->getIdDetentor_fk());
            }

            if ($objEquipamento->getIdModelo_fk() != null) {
                $WHERE .= $AND . " idModelo_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objEquipamento->getIdModelo_fk());
            }

            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            //echo $SELECT . $WHERE." LIMIT 1 ";
            //die();
            $arr = $objBanco->consultarSQL($SELECT . $WHERE . " LIMIT 1 ", $arrayBind);


            $array = array();
            foreach ($arr as $reg) {
                $objEquipamento = new Equipamento();
                $objEquipamento->setIdEquipamento($reg['idEquipamento']);
                $objEquipamento->setIdDetentor_fk($reg['idDetentor_fk']);
                $objEquipamento->setIdMarca_fk($reg['idMarca_fk']);
                $objEquipamento->setIdModelo_fk($reg['idModelo_fk']);
                $objEquipamento->setDataUltimaCalibragem($reg['dataUltimaCalibragem']);
                $objEquipamento->setDataChegada($reg['dataChegada']);


                $array[] = $objEquipamento;
            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro verificando se existe o equipamento no BD.", $ex);
        }
    }
    */
    

    
}
