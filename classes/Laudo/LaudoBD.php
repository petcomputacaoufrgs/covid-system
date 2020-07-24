<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';

class LaudoBD
{
    public function cadastrar(Laudo $objLaudo, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO tb_laudo (idAmostra_fk, idUsuario_fk, observacoes, resultado, situacao,dataHoraGeracao, dataHoraLiberacao,descarteDevolver) 
                        VALUES (?,?,?,?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objLaudo->getIdAmostraFk());
            $arrayBind[] = array('i',$objLaudo->getIdUsuarioFk());
            $arrayBind[] = array('s',$objLaudo->getObservacoes());
            $arrayBind[] = array('s',$objLaudo->getResultado());
            $arrayBind[] = array('s',$objLaudo->getSituacao());
            $arrayBind[] = array('s',$objLaudo->getDataHoraGeracao());
            $arrayBind[] = array('s',$objLaudo->getDataHoraLiberacao());
            $arrayBind[] = array('s',$objLaudo->getDescarteDevolver());

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objLaudo->setIdLaudo($objBanco->obterUltimoID());
            return $objLaudo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando laudo  no BD.",$ex);
        }

    }

    public function alterar(Laudo $objLaudo, Banco $objBanco) {
        try{
            //print_r($objLaudo);
            $UPDATE = 'UPDATE tb_laudo SET '
                . ' idAmostra_fk = ?,'
                . ' idUsuario_fk = ?,'
                . ' observacoes = ?,'
                . ' resultado = ?,'
                . ' situacao = ?,'
                . ' dataHoraGeracao = ?,'
                . ' dataHoraLiberacao = ?,'
                . ' descarteDevolver = ?'
                . '  where idLaudo = ?';


            $arrayBind = array();
            $arrayBind[] = array('i',$objLaudo->getIdAmostraFk());
            $arrayBind[] = array('i',$objLaudo->getIdUsuarioFk());
            $arrayBind[] = array('s',$objLaudo->getObservacoes());
            $arrayBind[] = array('s',$objLaudo->getResultado());
            $arrayBind[] = array('s',$objLaudo->getSituacao());
            $arrayBind[] = array('s',$objLaudo->getDataHoraGeracao());
            $arrayBind[] = array('s',$objLaudo->getDataHoraLiberacao());
            $arrayBind[] = array('s',$objLaudo->getDescarteDevolver());

            $arrayBind[] = array('i',$objLaudo->getIdLaudo());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objLaudo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando laudo no BD.",$ex);
        }

    }

    public function listar(Laudo $objLaudo, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_laudo";


            $WHERE = '';
            $AND = '';
            $arrayBind = array();
            if($objLaudo->getSituacao() != null){
                $WHERE .= $AND." situacao = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objLaudo->getSituacao());
            }

            if($objLaudo->getResultado() != null){
                $WHERE .= $AND." resultado = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objLaudo->getResultado());
            }
            if($objLaudo->getIdAmostraFk() != null){
                $WHERE .= $AND." idAmostra_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i',$objLaudo->getIdAmostraFk());
            }

            if($objLaudo->getDescarteDevolver() != null){
                $WHERE .= $AND." descarteDevolver = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objLaudo->getDescarteDevolver());

            }

            if($objLaudo->getIdLaudo() != null){
                $WHERE .= $AND." idLaudo = ?";
                $AND = ' and ';
                $arrayBind[] = array('i',$objLaudo->getIdLaudo());

            }


            if($WHERE != ''){
                $WHERE = ' where '.$WHERE;
            }

            //echo $SELECT.$WHERE;$WHERE

            $arr = $objBanco->consultarSQL($SELECT.$WHERE,$arrayBind);


            $array_laudo = array();
            foreach ($arr as $reg){
                $objLaudo = new Laudo();
                $objLaudo->setIdLaudo($reg['idLaudo']);
                $objLaudo->setIdAmostraFk($reg['idAmostra_fk']);
                $objLaudo->setIdUsuarioFk($reg['idUsuario_fk']);
                $objLaudo->setSituacao($reg['situacao']);
                $objLaudo->setResultado($reg['resultado']);
                $objLaudo->setObservacoes($reg['observacoes']);
                $objLaudo->setDataHoraGeracao($reg['dataHoraGeracao']);
                $objLaudo->setDataHoraLiberacao($reg['dataHoraLiberacao']);
                $objLaudo->setDescarteDevolver($reg['descarteDevolver']);


                $objLaudoProtocolo = new LaudoProtocolo();
                $objLaudoProtocoloRN = new LaudoProtocoloRN();
                $objLaudoProtocolo->setIdLaudoFk($objLaudo->getIdLaudo());
                $arr_protocolos = $objLaudoProtocoloRN->listar($objLaudoProtocolo);
                $objLaudo->setArrProtocolos($arr_protocolos);


                $objLaudoKitExtracao = new LaudoKitExtracao();
                $objLaudoKitExtracaoRN = new LaudoKitExtracaoRN();
                $objLaudoKitExtracao->setIdLaudoFk($objLaudo->getIdLaudo());
                $arr_kits = $objLaudoKitExtracaoRN->listar($objLaudoKitExtracao);
                $objLaudo->setArrKitsExtracao($arr_kits);


                $objAmostra = new Amostra();
                $objAmostraRN = new AmostraRN();
                $objAmostra->setIdAmostra($objLaudo->getIdAmostraFk());
                $objAmostra = $objAmostraRN->listar_completo($objAmostra);
                $objLaudo->setObjAmostra($objAmostra[0]);

                $objUsuario = new Usuario();
                $objUsuarioRN = new UsuarioRN();
                $objUsuario->setIdUsuario($objLaudo->getIdUsuarioFk());
                $objUsuario = $objUsuarioRN->consultar($objUsuario);
                $objLaudo->setObjUsuario($objUsuario);

                $array_laudo[] = $objLaudo;
            }
            return $array_laudo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando laudo no BD.",$ex);
        }

    }

    public function consultar(Laudo $objLaudo, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_laudo WHERE idLaudo = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objLaudo->getIdLaudo());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $laudo = new Laudo();
            $laudo->setIdLaudo($arr[0]['idLaudo']);
            $laudo->setIdAmostraFk($arr[0]['idAmostra_fk']);
            $laudo->setIdUsuarioFk($arr[0]['idUsuario_fk']);
            $laudo->setSituacao($arr[0]['situacao']);
            $laudo->setResultado($arr[0]['resultado']);
            $laudo->setObservacoes($arr[0]['observacoes']);
            $laudo->setDataHoraGeracao($arr[0]['dataHoraGeracao']);
            $laudo->setDataHoraLiberacao($arr[0]['dataHoraLiberacao']);
            $laudo->setDescarteDevolver($arr[0]['descarteDevolver']);

            return $laudo;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando laudo no BD.",$ex);
        }

    }

    public function remover(Laudo $objLaudo, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_laudo WHERE idLaudo = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objLaudo->getIdLaudo());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo laudo no BD.",$ex);
        }
    }


    public function paginacao(Laudo $objLaudo, Banco $objBanco) {
        try{

            $inicio = ($objLaudo->getNumPagina()-1)*50;

            if($objLaudo->getNumPagina() == null){
                $inicio = 0;
            }

            $SELECT = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_laudo ";
            $FROM = '';

            $WHERE = '';
            $AND = '';
            $arrayBind = array();
            if($objLaudo->getSituacao() != null){
                $WHERE .= $AND." tb_laudo.situacao = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objLaudo->getSituacao());
            }

            if($objLaudo->getResultado() != null){
                $WHERE .= $AND." tb_laudo.resultado = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objLaudo->getResultado());
            }


            if($objLaudo->getDescarteDevolver() != null){
                $WHERE .= $AND." tb_laudo.descarteDevolver = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objLaudo->getDescarteDevolver());

            }

            if($objLaudo->getIdLaudo() != null){
                $WHERE .= $AND." tb_laudo.idLaudo = ?";
                $AND = ' and ';
                $arrayBind[] = array('i',$objLaudo->getIdLaudo());

            }

            if($objLaudo->getObjAmostra() != null){
                $FROM .= ' ,tb_amostra ';
                $WHERE .= $AND . " tb_amostra.idAmostra = tb_laudo.idAmostra_fk ";
                $AND = ' and ';
                if($objLaudo->getObjAmostra()->getIdAmostraFk() != null){
                    $WHERE .= $AND." tb_amostra.idAmostra_fk = ?";
                    $AND = ' and ';
                    $arrayBind[] = array('i',$objLaudo->getIdAmostraFk());
                }
                if($objLaudo->getObjAmostra()->getNickname() != null){
                    $WHERE .= $AND." tb_amostra.nickname = ?";
                    $AND = ' and ';
                    $arrayBind[] = array('s',$objLaudo->getObjAmostra()->getNickname());
                }
            }


            if($WHERE != ''){
                $WHERE = ' where '.$WHERE;
            }


            $SELECT.= $FROM.$WHERE. ' order by tb_laudo.idLaudo desc';
            $SELECT.= ' LIMIT ?,50 ';

            $arrayBind[] = array('i',$inicio);
            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $SELECT = "SELECT FOUND_ROWS() as total";
            $total = $objBanco->consultarSQL($SELECT);
            $objLaudo->setTotalRegistros($total[0]['total']);
            $objLaudo->setNumPagina($inicio);

            $array_laudo = array();
            foreach ($arr as $reg){
                $objLaudoNovo = new Laudo();
                $objLaudoNovo->setIdLaudo($reg['idLaudo']);
                $objLaudoNovo->setIdAmostraFk($reg['idAmostra_fk']);
                $objLaudoNovo->setIdUsuarioFk($reg['idUsuario_fk']);
                $objLaudoNovo->setSituacao($reg['situacao']);
                $objLaudoNovo->setResultado($reg['resultado']);
                $objLaudoNovo->setObservacoes($reg['observacoes']);
                $objLaudoNovo->setDataHoraGeracao($reg['dataHoraGeracao']);
                $objLaudoNovo->setDataHoraLiberacao($reg['dataHoraLiberacao']);
                $objLaudoNovo->setDescarteDevolver($reg['descarteDevolver']);


                $objAmostra = new Amostra();
                $objAmostraRN = new AmostraRN();
                $objAmostra->setIdAmostra($objLaudoNovo->getIdAmostraFk());
                $objAmostra = $objAmostraRN->listar_completo($objAmostra);
                $objLaudoNovo->setObjAmostra($objAmostra[0]);

                $objUsuario = new Usuario();
                $objUsuarioRN = new UsuarioRN();
                $objUsuario->setIdUsuario($objLaudoNovo->getIdUsuarioFk());
                $objUsuario = $objUsuarioRN->consultar($objUsuario);
                $objLaudoNovo->setObjUsuario($objUsuario);

                $array_laudo[] = $objLaudoNovo;

            }
            //echo "<pre>";
            //print_r($array_laudo);
            //echo "</pre>";
            //die();
            return $array_laudo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando laudo no BD.",$ex);
        }

    }



}