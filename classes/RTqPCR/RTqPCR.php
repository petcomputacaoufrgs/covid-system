<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class RTqPCR
{
    private $idRTqPCR;
    private $idUsuario_fk;
    private $dataHoraInicio;
    private $dataHoraFim;
    private $idPlaca_fk;
    private $idEquipamento_fk;
    private $situacaoRTqPCR;
    private $horaFinal;

    private $numPagina;
    private $totalRegistros;
    private $registrosEncontrados;

    private $objUsuario;
    private $objEquipamento;
    private $objPlaca;

    /**
     * @return mixed
     */
    public function getHoraFinal()
    {
        return $this->horaFinal;
    }

    /**
     * @param mixed $horaFinal
     */
    public function setHoraFinal($horaFinal)
    {
        $this->horaFinal = $horaFinal;
    }

    /**
     * @return mixed
     */
    public function getSituacaoRTqPCR()
    {
        return $this->situacaoRTqPCR;
    }


    /**
     * @param mixed $situacaoRTqPCR
     */
    public function setSituacaoRTqPCR($situacaoRTqPCR)
    {
        $this->situacaoRTqPCR = $situacaoRTqPCR;
    }


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
    public function getObjEquipamento()
    {
        return $this->objEquipamento;
    }

    /**
     * @param mixed $objEquipamento
     */
    public function setObjEquipamento($objEquipamento)
    {
        $this->objEquipamento = $objEquipamento;
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
    public function getIdRTqPCR()
    {
        return $this->idRTqPCR;
    }

    /**
     * @param mixed $idRTqPCR
     */
    public function setIdRTqPCR($idRTqPCR)
    {
        $this->idRTqPCR = $idRTqPCR;
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
    public function getIdEquipamentoFk()
    {
        return $this->idEquipamento_fk;
    }

    /**
     * @param mixed $idEquipamento_fk
     */
    public function setIdEquipamentoFk($idEquipamento_fk)
    {
        $this->idEquipamento_fk = $idEquipamento_fk;
    }

}