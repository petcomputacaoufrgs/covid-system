<?php

class InfosTubo{
    private $idInfosTubo;
    private $idPosicao_fk;
    private $idTubo_fk;
    private $idUsuario_fk;
    private $idLote_fk;
    private $etapa;
    private $etapaAnterior;
    private $dataHora;
    private $reteste; // fará o reteste ou nao (s/n)
    private $volume;
    private $observacoes;
    private $obsProblema;
    private $situacaoTubo;
    private $situacaoEtapa;

    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getIdInfosTubo()
    {
        return $this->idInfosTubo;
    }

    /**
     * @param mixed $idInfosTubo
     */
    public function setIdInfosTubo($idInfosTubo)
    {
        $this->idInfosTubo = $idInfosTubo;
    }

    /**
     * @return mixed
     */
    public function getIdPosicao_fk()
    {
        return $this->idPosicao_fk;
    }

    /**
     * @param mixed $idPosicao_fk
     */
    public function setIdPosicao_fk($idPosicao_fk)
    {
        $this->idPosicao_fk = $idPosicao_fk;
    }

    /**
     * @return mixed
     */
    public function getIdTubo_fk()
    {
        return $this->idTubo_fk;
    }

    /**
     * @param mixed $idTubo_fk
     */
    public function setIdTubo_fk($idTubo_fk)
    {
        $this->idTubo_fk = $idTubo_fk;
    }

    /**
     * @return mixed
     */
    public function getIdUsuario_fk()
    {
        return $this->idUsuario_fk;
    }

    /**
     * @param mixed $idUsuario_fk
     */
    public function setIdUsuario_fk($idUsuario_fk)
    {
        $this->idUsuario_fk = $idUsuario_fk;
    }

    /**
     * @return mixed
     */
    public function getIdLote_fk()
    {
        return $this->idLote_fk;
    }

    /**
     * @param mixed $idLote_fk
     */
    public function setIdLote_fk($idLote_fk)
    {
        $this->idLote_fk = $idLote_fk;
    }

    /**
     * @return mixed
     */
    public function getEtapa()
    {
        return $this->etapa;
    }

    /**
     * @param mixed $etapa
     */
    public function setEtapa($etapa)
    {
        $this->etapa = $etapa;
    }

    /**
     * @return mixed
     */
    public function getEtapaAnterior()
    {
        return $this->etapaAnterior;
    }

    /**
     * @param mixed $etapaAnterior
     */
    public function setEtapaAnterior($etapaAnterior)
    {
        $this->etapaAnterior = $etapaAnterior;
    }

    /**
     * @return mixed
     */
    public function getDataHora()
    {
        return $this->dataHora;
    }

    /**
     * @param mixed $dataHora
     */
    public function setDataHora($dataHora)
    {
        $this->dataHora = $dataHora;
    }

    /**
     * @return mixed
     */
    public function getReteste()
    {
        return $this->reteste;
    }

    /**
     * @param mixed $reteste
     */
    public function setReteste($reteste)
    {
        $this->reteste = $reteste;
    }

    /**
     * @return mixed
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @param mixed $volume
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;
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
    public function getObsProblema()
    {
        return $this->obsProblema;
    }

    /**
     * @param mixed $obsProblema
     */
    public function setObsProblema($obsProblema)
    {
        $this->obsProblema = $obsProblema;
    }

    /**
     * @return mixed
     */
    public function getSituacaoTubo()
    {
        return $this->situacaoTubo;
    }

    /**
     * @param mixed $situacaoTubo
     */
    public function setSituacaoTubo($situacaoTubo)
    {
        $this->situacaoTubo = $situacaoTubo;
    }

    /**
     * @return mixed
     */
    public function getSituacaoEtapa()
    {
        return $this->situacaoEtapa;
    }

    /**
     * @param mixed $situacaoEtapa
     */
    public function setSituacaoEtapa($situacaoEtapa)
    {
        $this->situacaoEtapa = $situacaoEtapa;
    }




}