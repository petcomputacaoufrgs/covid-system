<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';

class DiagnosticoBD
{

    public function cadastrar(Diagnostico $objDiagnostico, Banco $objBanco)
    {
        try {

            //die("die");
            $INSERT = 'INSERT INTO tb_diagnostico (idUsuario_fk, idAmostra_fk,diagnostico,situacao,dataHoraInicio,dataHoraFim,observacoes) VALUES (?,?,?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i', $objDiagnostico->getIdUsuarioFk());
            $arrayBind[] = array('i', $objDiagnostico->getIdAmostraFk());
            $arrayBind[] = array('s', $objDiagnostico->getDiagnostico());
            $arrayBind[] = array('s', $objDiagnostico->getSituacao());
            $arrayBind[] = array('s', $objDiagnostico->getDataHoraInicio());
            $arrayBind[] = array('s', $objDiagnostico->getDataHoraFim());
            $arrayBind[] = array('s', $objDiagnostico->getObservacoes());

            $objBanco->executarSQL($INSERT, $arrayBind);
            $objDiagnostico->setIdDiagnostico($objBanco->obterUltimoID());
            return $objDiagnostico;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o diagnóstico no BD.", $ex);
        }

    }

    public function alterar(Diagnostico $objDiagnostico, Banco $objBanco)
    {
        try {
            $UPDATE = 'UPDATE tb_diagnostico SET '
                . ' idUsuario_fk = ?,'
                . ' idAmostra_fk = ?,'
                . ' diagnostico = ?,'
                . ' situacao = ?,'
                . ' dataHoraInicio = ?,'
                . ' dataHoraFim = ?,'
                . ' observacoes = ?'
                . '  where idDiagnostico = ?';


            $arrayBind = array();
            $arrayBind[] = array('i', $objDiagnostico->getIdUsuarioFk());
            $arrayBind[] = array('i', $objDiagnostico->getIdAmostraFk());
            $arrayBind[] = array('s', $objDiagnostico->getDiagnostico());
            $arrayBind[] = array('s', $objDiagnostico->getSituacao());
            $arrayBind[] = array('s', $objDiagnostico->getDataHoraInicio());
            $arrayBind[] = array('s', $objDiagnostico->getDataHoraFim());
            $arrayBind[] = array('s', $objDiagnostico->getObservacoes());

            $arrayBind[] = array('i', $objDiagnostico->getIdDiagnostico());

            $objBanco->executarSQL($UPDATE, $arrayBind);
            return $objDiagnostico;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o diagnóstico no BD.", $ex);
        }

    }

    public function listar(Diagnostico $objDiagnostico, $numLimite = null, Banco $objBanco)
    {
        try {

            $SELECT = "SELECT * FROM tb_diagnostico";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objDiagnostico->getIdDiagnostico() != null) {
                $WHERE .= $AND . " idDiagnostico = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objDiagnostico->getIdDiagnostico());
            }

            if ($objDiagnostico->getIdAmostraFk() != null) {
                $WHERE .= $AND . " idAmostra_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objDiagnostico->getIdAmostraFk());
            }

            if ($objDiagnostico->getIdUsuarioFk() != null) {
                $WHERE .= $AND . " idUsuario_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objDiagnostico->getIdUsuarioFk());
            }

            if ($objDiagnostico->getDiagnostico() != null) {
                $WHERE .= $AND . " diagnostico = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objDiagnostico->getDiagnostico());
            }

            if ($objDiagnostico->getSituacao() != null) {
                $WHERE .= $AND . " situacao = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objDiagnostico->getSituacao());
            }

            if ($objDiagnostico->getObservacoes() != null) {
                $WHERE .= $AND . " observacoes LIKE ?";
                $AND = ' and ';
                $arrayBind[] = array('s', "%".$objDiagnostico->getObservacoes()."%");
            }

            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            $LIMIT = '';
            if ($numLimite != null) {
                $LIMIT = ' LIMIT ? ';
                $arrayBind[] = array('i', $numLimite);
            }


            $arr = $objBanco->consultarSQL($SELECT . $WHERE . $LIMIT, $arrayBind);


            $arr_diagnosticos = array();
            foreach ($arr as $reg) {
                $diagnostico = new Diagnostico();
                $diagnostico->setIdDiagnostico($reg['idDiagnostico']);
                $diagnostico->setIdUsuarioFk($reg['idUsuario_fk']);
                $diagnostico->setDataHoraInicio($reg['dataHoraInicio']);
                $diagnostico->setDataHoraFim($reg['dataHoraFim']);
                $diagnostico->setIdAmostraFk($reg['idAmostra_fk']);
                $diagnostico->setObservacoes($reg['observacoes']);
                $diagnostico->setDiagnostico($reg['diagnostico']);
                $diagnostico->setSituacao($reg['situacao']);

                $arr_diagnosticos[] = $diagnostico;
            }
            return $arr_diagnosticos;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os diagnósticos no BD.", $ex);
        }

    }

    public function listar_completo(Diagnostico $objDiagnostico, $numLimite = null, Banco $objBanco)
    {
        try {

            $SELECT = "SELECT * FROM tb_diagnostico";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objDiagnostico->getIdDiagnostico() != null) {
                $WHERE .= $AND . " idDiagnostico = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objDiagnostico->getIdDiagnostico());
            }

            if ($objDiagnostico->getIdAmostraFk() != null) {
                $WHERE .= $AND . " idAmostra_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objDiagnostico->getIdAmostraFk());
            }

            if ($objDiagnostico->getIdUsuarioFk() != null) {
                $WHERE .= $AND . " idUsuario_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objDiagnostico->getIdUsuarioFk());
            }

            if ($objDiagnostico->getDiagnostico() != null) {
                $WHERE .= $AND . " diagnostico = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objDiagnostico->getDiagnostico());
            }

            if ($objDiagnostico->getSituacao() != null) {
                $WHERE .= $AND . " situacao = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objDiagnostico->getSituacao());
            }

            if ($objDiagnostico->getObservacoes() != null) {
                $WHERE .= $AND . " observacoes LIKE ?";
                $AND = ' and ';
                $arrayBind[] = array('s', "%".$objDiagnostico->getObservacoes()."%");
            }

            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            $LIMIT = '';
            if ($numLimite != null) {
                $LIMIT = ' LIMIT ? ';
                $arrayBind[] = array('i', $numLimite);
            }


            $arr = $objBanco->consultarSQL($SELECT . $WHERE . $LIMIT, $arrayBind);


            $arr_diagnosticos = array();
            foreach ($arr as $reg) {
                $diagnostico = new Diagnostico();
                $diagnostico->setIdDiagnostico($reg['idDiagnostico']);
                $diagnostico->setIdUsuarioFk($reg['idUsuario_fk']);
                $diagnostico->setDataHoraInicio($reg['dataHoraInicio']);
                $diagnostico->setDataHoraFim($reg['dataHoraFim']);
                $diagnostico->setIdAmostraFk($reg['idAmostra_fk']);
                $diagnostico->setObservacoes($reg['observacoes']);
                $diagnostico->setDiagnostico($reg['diagnostico']);
                $diagnostico->setSituacao($reg['situacao']);


                $objAmostra = new Amostra();
                $objAmostraRN = new AmostraRN();
                $objAmostra->setIdAmostra($objDiagnostico->getIdAmostraFk());
                $arr_amostras = $objAmostraRN->listar_completo($objAmostra);
                $diagnostico->setObjAmostra($arr_amostras);

                $objUsuario = new Usuario();
                $objUsuarioRN = new UsuarioRN();
                $objUsuario->setIdUsuario($objDiagnostico->getIdUsuarioFk());
                $objUsuario = $objUsuarioRN->consultar($objUsuario);
                $diagnostico->setObjUsuario($objUsuario);


                $arr_diagnosticos[] = $diagnostico;
            }
            return $arr_diagnosticos;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os diagnósticos no BD.", $ex);
        }

    }

    public function consultar(Diagnostico $objDiagnostico, Banco $objBanco)
    {

        try {

            $SELECT = 'SELECT * FROM tb_diagnostico WHERE idDiagnostico = ?';

            $arrayBind = array();
            $arrayBind[] = array('i', $objDiagnostico->getIdDiagnostico());

            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);

            $diagnostico = new Diagnostico();
            $diagnostico->setIdDiagnostico($arr[0]['idDiagnostico']);
            $diagnostico->setIdUsuarioFk($arr[0]['idUsuario_fk']);
            $diagnostico->setDataHoraInicio($arr[0]['dataHoraInicio']);
            $diagnostico->setDataHoraFim($arr[0]['dataHoraFim']);
            $diagnostico->setIdAmostraFk($arr[0]['idAmostra_fk']);
            $diagnostico->setObservacoes($arr[0]['observacoes']);
            $diagnostico->setDiagnostico($arr[0]['diagnostico']);
            $diagnostico->setSituacao($arr[0]['situacao']);

            return $diagnostico;
        } catch (Throwable $ex) {
            throw new Excecao("Erro consultando o diagnóstico no BD.", $ex);
        }

    }

    public function remover(Diagnostico $objDiagnostico, Banco $objBanco)
    {

        try {

            $DELETE = 'DELETE FROM tb_diagnostico WHERE idDiagnostico = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i', $objDiagnostico->getIdDiagnostico());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o diagnóstico no BD.", $ex);
        }
    }


    public function paginacao(Diagnostico $objDiagnostico, Banco $objBanco)
    {
        try {

            $inicio = ($objDiagnostico->getNumPagina() - 1) * 20;

            if ($objDiagnostico->getNumPagina() == null) {
                $inicio = 0;
            }

            $SELECT = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_diagnostico";

            $WHERE = '';
            $AND = '';
            $FROM = '';
            $arrayBind = array();

            if ($objDiagnostico->getIdDiagnostico() != null) {
                $WHERE .= $AND . " idDiagnostico = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objDiagnostico->getIdDiagnostico());
            }

            if ($objDiagnostico->getIdAmostraFk() != null) {
                $WHERE .= $AND . " idAmostra_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objDiagnostico->getIdAmostraFk());
            }

            if ($objDiagnostico->getIdUsuarioFk() != null) {
                $WHERE .= $AND . " idUsuario_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objDiagnostico->getIdUsuarioFk());
            }

            if ($objDiagnostico->getDiagnostico() != null) {
                $WHERE .= $AND . " diagnostico = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objDiagnostico->getDiagnostico());
            }

            if ($objDiagnostico->getSituacao() != null) {
                $WHERE .= $AND . " situacao = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objDiagnostico->getSituacao());
            }

            if ($objDiagnostico->getObservacoes() != null) {
                $WHERE .= $AND . " observacoes LIKE ?";
                $AND = ' and ';
                $arrayBind[] = array('s', "%".$objDiagnostico->getObservacoes()."%");
            }

            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }


            $order_by = ' order by  tb_diagnostico.idDiagnostico desc ';
            $limit = ' LIMIT ?,20';

            $arrayBind[] = array('i', $inicio);
            $arr = $objBanco->consultarSQL($SELECT . $FROM . $WHERE . $order_by . $limit, $arrayBind);

            $SELECT = "SELECT FOUND_ROWS() as total";
            $total = $objBanco->consultarSQL($SELECT);
            $objDiagnostico->setTotalRegistros($total[0]['total']);
            $objDiagnostico->setNumPagina($inicio);


            $arr_diagnostico = array();
            foreach ($arr as $reg) {
                $diagnostico = new Diagnostico();
                $diagnostico->setIdDiagnostico($reg['idDiagnostico']);
                $diagnostico->setIdUsuarioFk($reg['idUsuario_fk']);
                $diagnostico->setDataHoraInicio($reg['dataHoraInicio']);
                $diagnostico->setDataHoraFim($reg['dataHoraFim']);
                $diagnostico->setIdAmostraFk($reg['idAmostra_fk']);
                $diagnostico->setObservacoes($reg['observacoes']);
                $diagnostico->setDiagnostico($reg['diagnostico']);
                $diagnostico->setSituacao($reg['situacao']);


                $objAmostra = new Amostra();
                $objAmostraRN = new AmostraRN();
                $objAmostra->setIdAmostra($objDiagnostico->getIdAmostraFk());
                $arr_amostras = $objAmostraRN->listar_completo($objAmostra);
                $diagnostico->setObjAmostra($arr_amostras);

                $objUsuario = new Usuario();
                $objUsuarioRN = new UsuarioRN();
                $objUsuario->setIdUsuario($objDiagnostico->getIdUsuarioFk());
                $objUsuario = $objUsuarioRN->consultar($objUsuario);
                $diagnostico->setObjUsuario($objUsuario);


                $arr_diagnostico[] = $diagnostico;
            }
            return $arr_diagnostico;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os diagnósticos no BD.", $ex);
        }

    }

}