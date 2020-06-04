<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
class MixRTqPCR
{
    private $idMixPlaca;
    private $situacaoMix;
    private $idSolicitacao_fk;
    private $idPlaca_fk;
    private $idUsuario_fk;
    private $dataHoraInicio;
    private $dataHoraFim;

    private $numPagina;
    private $totalRegistros;
    private $registrosEncontrados;

    private $objUsuario;
    private $objSolicitacao;


    private $objPlaca;
    private $arrObjInfosTubo;

    /**
     * @return mixed
     */
    public function getNumPagina()
    {
        return $this->numPagina;
    }

    /**
     * @param mixed $numPagina
     */
    public function setNumPagina($numPagina)
    {
        $this->numPagina = $numPagina;
    }

    /**
     * @return mixed
     */
    public function getTotalRegistros()
    {
        return $this->totalRegistros;
    }

    /**
     * @param mixed $totalRegistros
     */
    public function setTotalRegistros($totalRegistros)
    {
        $this->totalRegistros = $totalRegistros;
    }

    /**
     * @return mixed
     */
    public function getRegistrosEncontrados()
    {
        return $this->registrosEncontrados;
    }

    /**
     * @param mixed $registrosEncontrados
     */
    public function setRegistrosEncontrados($registrosEncontrados)
    {
        $this->registrosEncontrados = $registrosEncontrados;
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



    /**
     * @return mixed
     */
    public function getArrObjInfosTubo()
    {
        return $this->objInfosTubo;
    }

    /**
     * @param mixed $objInfosTubo
     */
    public function setArrObjInfosTubo($objInfosTubo)
    {
        $this->objInfosTubo = $objInfosTubo;
    }

    /**
     * @return mixed
     */
    public function getObjPlaca()
    {
        return $this->objPlaca;
    }

    /**
     * @param mixed $objPlaca
     */
    public function setObjPlaca($objPlaca)
    {
        $this->objPlaca = $objPlaca;
    }


    /**
     * @return mixed
     */
    public function getObjSolicitacao()
    {
        return $this->objSolicitacao;
    }

    /**
     * @param mixed $objSolicitacao
     */
    public function setObjSolicitacao($objSolicitacao)
    {
        $this->objSolicitacao = $objSolicitacao;
    }


    /**
     * @return mixed
     */
    public function getIdMixPlaca()
    {
        return $this->idMixPlaca;
    }

    /**
     * @param mixed $idMixPlaca
     */
    public function setIdMixPlaca($idMixPlaca)
    {
        $this->idMixPlaca = $idMixPlaca;
    }

    /**
     * @return mixed
     */
    public function getSituacaoMix()
    {
        return $this->situacaoMix;
    }

    /**
     * @param mixed $situacaoMix
     */
    public function setSituacaoMix($situacaoMix)
    {
        $this->situacaoMix = $situacaoMix;
    }

    /**
     * @return mixed
     */
    public function getIdSolicitacaoFk()
    {
        return $this->idSolicitacao_fk;
    }

    /**
     * @param mixed $idSolicitacao_fk
     */
    public function setIdSolicitacaoFk($idSolicitacao_fk)
    {
        $this->idSolicitacao_fk = $idSolicitacao_fk;
    }

    /**
     * @return mixed
     */
    public function getIdPlacaFk()
    {
        return $this->idPlaca_fk;
    }

    /**
     * @param mixed $idPlaca_fk
     */
    public function setIdPlacaFk($idPlaca_fk)
    {
        $this->idPlaca_fk = $idPlaca_fk;
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


}