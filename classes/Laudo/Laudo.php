<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class Laudo
{
    private $idLaudo;
    private $idAmostra_fk;
    private $idUsuario_fk;
    private $dataHoraLiberacao;
    private $dataHoraGeracao;
    private $observacoes;
    private $resultado;
    private $situacao;

    private $objAmostra;
    private $objInfosTubo;

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
    public function getIdLaudo()
    {
        return $this->idLaudo;
    }

    /**
     * @return mixed
     */
    public function getDataHoraGeracao()
    {
        return $this->dataHoraGeracao;
    }

    /**
     * @param mixed $dataHoraGeracao
     */
    public function setDataHoraGeracao($dataHoraGeracao)
    {
        $this->dataHoraGeracao = $dataHoraGeracao;
    }



    /**
     * @param mixed $idLaudo
     */
    public function setIdLaudo($idLaudo)
    {
        $this->idLaudo = $idLaudo;
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
    public function getDataHoraLiberacao()
    {
        return $this->dataHoraLiberacao;
    }

    /**
     * @param mixed $dataHoraLiberacao
     */
    public function setDataHoraLiberacao($dataHoraLiberacao)
    {
        $this->dataHoraLiberacao = $dataHoraLiberacao;
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
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * @param mixed $situacao
     */
    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
    }



}