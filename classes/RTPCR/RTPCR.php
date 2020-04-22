<?php

class RTPCR
{
    private $idRTPCR;
    private $idUsuario_fk;
    private $idAmostra_fk;
    private $idEquipamento_fk;
    private $cqGeneRdRP;
    private $cqGeneE;
    private $p_n_i;
    private $observacoes;
    private $dataHoraInicio;
    private $dataHoraFim;
    private $reteste;
    private $qnts_retestes

    /**
     * RTPCR constructor.
     */

    public function __construct()
    {

    }
    /**
     * @return mixed
     */
    public function getIdRTPCR()
    {
        return $this->idRTPCR;
    }
    /**
     * @param mixed $idRTPCR
     */
    public function setIdRTPCR($idRTPCR): void
    {
        $this->idRTPCR = $idRTPCR;
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
    public function setIdUsuarioFk($idUsuario_fk): void
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
    public function setIdAmostraFk($idAmostra_fk): void
    {
        $this->idAmostra_fk = $idAmostra_fk;
    }
    /**
     * @return mixed
     */
    public function getIdEquipamentoFk()
    {
        return $this->idEquipamento_fk;
    }
    /**
     * @param mixed $idEquipamento_fk
     */
    public function setIdEquipamentoFk($idEquipamento_fk): void
    {
        $this->idEquipamento_fk = $idEquipamento_fk;
    }
    /**
     * @return mixed
     */
    public function getCqGeneRdRP()
    {
        return $this->cqGeneRdRP;
    }
    /**
     * @param mixed $cqGeneRdRP
     */
    public function setCqGeneRdRP($cqGeneRdRP): void
    {
        $this->cqGeneRdRP = $cqGeneRdRP;
    }
    /**
     * @return mixed
     */
    public function getCqGeneE()
    {
        return $this->cqGeneE;
    }
    /**
     * @param mixed $cqGeneE
     */
    public function setCqGeneE($cqGeneE): void
    {
        $this->cqGeneE = $cqGeneE;
    }
    /**
     * @return mixed
     */
    public function getPNI()
    {
        return $this->p_n_i;
    }
    /**
     * @param mixed $p_n_i
     */
    public function setPNI($p_n_i): void
    {
        $this->p_n_i = $p_n_i;
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
    public function setObservacoes($observacoes): void
    {
        $this->observacoes = $observacoes;
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
    public function setDataHoraInicio($dataHoraInicio): void
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
    public function setDataHoraFim($dataHoraFim): void
    {
        $this->dataHoraFim = $dataHoraFim;
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
    public function setReteste($reteste): void
    {
        $this->reteste = $reteste;
    }
    /**
     * @return mixed
     */
    public function getQntsRetestes()
    {
        return $this->qnts_retestes;
    }
    /**
     * @param mixed $qnts_retestes
     */
    public function setQntsRetestes($qnts_retestes): void
    {
        $this->qnts_retestes = $qnts_retestes;
    }



}