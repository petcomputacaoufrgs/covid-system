<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class AnaliseQualidade
{
    private $idAnaliseQualidade;
    private $idUsuario_fk;
    private $idAmostra_fk;
    private $idTubo_fk;
    private $dataHoraInicio;
    private $dataHoraFim;
    private $observacoes;
    private $resultado;

    private $objAmostra;
    private $objUsuario;
    private $objInfosTubo;

    /**
     * @return mixed
     */
    public function getIdTuboFk()
    {
        return $this->idTubo_fk;
    }

    /**
     * @param mixed $idTubo_fk
     */
    public function setIdTuboFk($idTubo_fk)
    {
        $this->idTubo_fk = $idTubo_fk;
    }



    /**
     * @return mixed
     */
    public function getObjInfosTubo()
    {
        return $this->objInfosTubo;
    }

    /**
     * @param mixed $objInfosTubo
     */
    public function setObjInfosTubo($objInfosTubo)
    {
        $this->objInfosTubo = $objInfosTubo;
    }



    /**
     * @return mixed
     */
    public function getIdAnaliseQualidade()
    {
        return $this->idAnaliseQualidade;
    }

    /**
     * @param mixed $idAnaliseQualidade
     */
    public function setIdAnaliseQualidade($idAnaliseQualidade)
    {
        $this->idAnaliseQualidade = $idAnaliseQualidade;
    }

    /**
     * @return mixed
     */
    public function getIdUsuarioFk()
    {
        return $this->idUsuario_fk;
    }

    /**
     * @param mixed $idUsuario_fk
     */
    public function setIdUsuarioFk($idUsuario_fk)
    {
        $this->idUsuario_fk = $idUsuario_fk;
    }

    /**
     * @return mixed
     */
    public function getIdAmostraFk()
    {
        return $this->idAmostra_fk;
    }

    /**
     * @param mixed $idAmostra_fk
     */
    public function setIdAmostraFk($idAmostra_fk)
    {
        $this->idAmostra_fk = $idAmostra_fk;
    }

    /**
     * @return mixed
     */
    public function getDataHoraInicio()
    {
        return $this->dataHoraInicio;
    }

    /**
     * @param mixed $dataHoraInicio
     */
    public function setDataHoraInicio($dataHoraInicio)
    {
        $this->dataHoraInicio = $dataHoraInicio;
    }

    /**
     * @return mixed
     */
    public function getDataHoraFim()
    {
        return $this->dataHoraFim;
    }

    /**
     * @param mixed $dataHoraFim
     */
    public function setDataHoraFim($dataHoraFim)
    {
        $this->dataHoraFim = $dataHoraFim;
    }

    /**
     * @return mixed
     */
    public function getObservacoes()
    {
        return $this->observacoes;
    }

    /**
     * @param mixed $observacoes
     */
    public function setObservacoes($observacoes)
    {
        $this->observacoes = $observacoes;
    }

    /**
     * @return mixed
     */
    public function getResultado()
    {
        return $this->resultado;
    }

    /**
     * @param mixed $resultado
     */
    public function setResultado($resultado)
    {
        $this->resultado = $resultado;
    }

    /**
     * @return mixed
     */
    public function getObjAmostra()
    {
        return $this->objAmostra;
    }

    /**
     * @param mixed $objAmostra
     */
    public function setObjAmostra($objAmostra)
    {
        $this->objAmostra = $objAmostra;
    }

    /**
     * @return mixed
     */
    public function getObjUsuario()
    {
        return $this->objUsuario;
    }

    /**
     * @param mixed $objUsuario
     */
    public function setObjUsuario($objUsuario)
    {
        $this->objUsuario = $objUsuario;
    }


}