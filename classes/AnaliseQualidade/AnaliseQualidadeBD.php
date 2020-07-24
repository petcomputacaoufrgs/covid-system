<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class AnaliseQualidadeBD
{
    public function cadastrar(AnaliseQualidade $objAnaliseQualidade, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO tb_analise_qualidade (idAmostra_fk,idUsuario_fk,observacoes,resultado,dataHoraInicio,dataHoraFim,idTubo_fk) VALUES (?,?,?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objAnaliseQualidade->getIdAmostraFk());
            $arrayBind[] = array('i',$objAnaliseQualidade->getIdUsuarioFk());
            $arrayBind[] = array('s',$objAnaliseQualidade->getObservacoes());
            $arrayBind[] = array('s',$objAnaliseQualidade->getResultado());
            $arrayBind[] = array('s',$objAnaliseQualidade->getDataHoraInicio());
            $arrayBind[] = array('s',$objAnaliseQualidade->getDataHoraFim());
            $arrayBind[] = array('i',$objAnaliseQualidade->getIdTuboFk());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objAnaliseQualidade->setIdAnaliseQualidade($objBanco->obterUltimoID());
            return $objAnaliseQualidade;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando a análise de qualidade no BD (AnaliseQualidadeBD).",$ex);
        }

    }

    public function alterar(AnaliseQualidade $objAnaliseQualidade, Banco $objBanco) {
        try{

            $UPDATE = 'UPDATE tb_analise_qualidade SET '
                . ' idAmostra_fk = ?,'
                . ' idUsuario_fk = ?,'
                . ' observacoes = ?,'
                . ' resultado = ?,'
                . ' dataHoraInicio = ?,'
                . ' dataHoraFim = ?,'
                . ' idTubo_fk = ?'
                . '  where idAnaliseQualidade = ?';


            $arrayBind = array();
            $arrayBind[] = array('i',$objAnaliseQualidade->getIdAmostraFk());
            $arrayBind[] = array('i',$objAnaliseQualidade->getIdUsuarioFk());
            $arrayBind[] = array('s',$objAnaliseQualidade->getObservacoes());
            $arrayBind[] = array('s',$objAnaliseQualidade->getResultado());
            $arrayBind[] = array('s',$objAnaliseQualidade->getDataHoraInicio());
            $arrayBind[] = array('s',$objAnaliseQualidade->getDataHoraFim());
            $arrayBind[] = array('i',$objAnaliseQualidade->getIdTuboFk());

            $arrayBind[] = array('i',$objAnaliseQualidade->getIdAnaliseQualidade());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objAnaliseQualidade;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando a análise de qualidade no BD (AnaliseQualidadeBD).",$ex);
        }

    }

    public function listar(AnaliseQualidade $objAnaliseQualidade, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_analise_qualidade";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objAnaliseQualidade->getIdAnaliseQualidade() != null) {
                $WHERE .= $AND . " idAnaliseQualidade = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objAnaliseQualidade->getIdAnaliseQualidade());
            }

            if ($objAnaliseQualidade->getIdAmostraFk() != null) {
                $WHERE .= $AND . " idAmostra_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objAnaliseQualidade->getIdAmostraFk());
            }

            if ($objAnaliseQualidade->getIdTuboFk() != null) {
                $WHERE .= $AND . " idTubo_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objAnaliseQualidade->getIdTuboFk());
            }
            if ($objAnaliseQualidade->getIdUsuarioFk() != null) {
                $WHERE .= $AND . " idUsuario_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objAnaliseQualidade->getIdUsuarioFk());
            }

            if ($objAnaliseQualidade->getResultado() != null) {
                $WHERE .= $AND . " resultado = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objAnaliseQualidade->getResultado());
            }

            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }


            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            $array_analiseQualidade = array();
            foreach ($arr as $reg){
                $analiseQualidade = new AnaliseQualidade();
                $analiseQualidade->setIdAnaliseQualidade($reg['idAnaliseQualidade']);
                $analiseQualidade->setIdUsuarioFk($reg['idUsuario_fk']);
                $analiseQualidade->setIdAmostraFk($reg['idAmostra_fk']);
                $analiseQualidade->setIdTuboFk($reg['idTubo_fk']);
                $analiseQualidade->setResultado($reg['resultado']);
                $analiseQualidade->setObservacoes($reg['observacoes']);
                $analiseQualidade->setDataHoraInicio($reg['dataHoraInicio']);
                $analiseQualidade->setDataHoraFim($reg['dataHoraFim']);

                $array_analiseQualidade[] = $analiseQualidade;
            }
            return $array_analiseQualidade;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando a análise de qualidade no BD (AnaliseQualidadeBD).",$ex);
        }

    }

    public function consultar(AnaliseQualidade $objAnaliseQualidade, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_analise_qualidade WHERE idAnaliseQualidade = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objAnaliseQualidade->getIdAnaliseQualidade());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $analiseQualidade = new AnaliseQualidade();
            if(count($arr) > 0) {
                $analiseQualidade->setIdAnaliseQualidade($arr[0]['idAnaliseQualidade']);
                $analiseQualidade->setIdUsuarioFk($arr[0]['idUsuario_fk']);
                $analiseQualidade->setIdAmostraFk($arr[0]['idAmostra_fk']);
                $analiseQualidade->setIdTuboFk($arr[0]['idTubo_fk']);
                $analiseQualidade->setResultado($arr[0]['resultado']);
                $analiseQualidade->setObservacoes($arr[0]['observacoes']);
                $analiseQualidade->setDataHoraInicio($arr[0]['dataHoraInicio']);
                $analiseQualidade->setDataHoraFim($arr[0]['dataHoraFim']);
            }
            return $analiseQualidade;
        } catch (Throwable $ex) {
            throw new Excecao("Erro consultando a análise de qualidade no BD.",$ex);
        }

    }

    public function remover(AnaliseQualidade $objAnaliseQualidade, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_analise_qualidade WHERE idAnaliseQualidade = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objAnaliseQualidade->getIdAnaliseQualidade());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo a análise de qualidade no BD (AnaliseQualidadeBD).",$ex);
        }
    }
}