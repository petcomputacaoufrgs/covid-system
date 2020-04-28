<?php

class InfosTubo{
    private $idInfosTubo;
    private $idLocalArmazenamento_fk;
    private $idTubo_fk;
    private $idUsuario_fk;
    private $idLote_fk;
    private $statusTubo;
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
    public function getDescarteNaEtapa()
    {
        return $this->descarteNaEtapa;
    }

    /**
     * @param mixed $descarteNaEtapa
     */
    public function setDescarteNaEtapa($descarteNaEtapa)
    {
        $this->descarteNaEtapa = $descarteNaEtapa;
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


    
    function getIdUsuario_fk() {
        return $this->idUsuario_fk;
    }

    function setIdUsuario_fk($idUsuario_fk) {
        $this->idUsuario_fk = $idUsuario_fk;
    }

        
    function getIdInfosTubo() {
        return $this->idInfosTubo;
    }

    function getIdLocalArmazenamento_fk() {
        return $this->idLocalArmazenamento_fk;
    }

    function getIdTubo_fk() {
        return $this->idTubo_fk;
    }

    function getStatusTubo() {
        return $this->statusTubo;
    }

    function getEtapa() {
        return $this->etapa;
    }

    function getDataHora() {
        return $this->dataHora;
    }

    function getReteste() {
        return $this->reteste;
    }

    function getVolume() {
        return $this->volume;
    }

    function setIdInfosTubo($idInfosTubo) {
        $this->idInfosTubo = $idInfosTubo;
    }

    function setIdLocalArmazenamento_fk($idLocalArmazenamento_fk) {
        $this->idLocalArmazenamento_fk = $idLocalArmazenamento_fk;
    }

    function setIdTubo_fk($idTubo_fk) {
        $this->idTubo_fk = $idTubo_fk;
    }

    function setStatusTubo($statusTubo) {
        $this->statusTubo = $statusTubo;
    }

    function setEtapa($etapa) {
        $this->etapa = $etapa;
    }

    function setDataHora($dataHora) {
        $this->dataHora = $dataHora;
    }

    function setReteste($reteste) {
        $this->reteste = $reteste;
    }

    function setVolume($volume) {
        $this->volume = $volume;
    }



}