<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class MontagemPlaca
{
    private $idMontagem;
    private $idMix_fk;
    private $idUsuario_fk;
    private $dataHoraInicio;
    private $dataHoraFim;
    private $situacaoMontagem;

    private $numPagina;
    private $totalRegistros;
    private $registrosEncontrados;

    private $objMix;
    private $objUsuario;
    private $objPocos;

    //para cadastro
    private $objInfosTubo;

    /**
     * @return mixed
     */
    public function getObjPocos()
    {
        return $this->objPocos;
    }

    /**
     * @param mixed $objPocos
     */
    public function setObjPocos($objPocos)
    {
        $this->objPocos = $objPocos;
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
    public function getSituacaoMontagem()
    {
        return $this->situacaoMontagem;
    }

    /**
     * @param mixed $situacaoMontagem
     */
    public function setSituacaoMontagem($situacaoMontagem)
    {
        $this->situacaoMontagem = $situacaoMontagem;
    }


    /**
     * @return mixed
     */
    public function getIdMontagem()
    {
        return $this->idMontagem;
    }

    /**
     * @param mixed $idMontagem
     */
    public function setIdMontagem($idMontagem)
    {
        $this->idMontagem = $idMontagem;
    }

    /**
     * @return mixed
     */
    public function getIdMixFk()
    {
        return $this->idMix_fk;
    }

    /**
     * @param mixed $idMix_fk
     */
    public function setIdMixFk($idMix_fk)
    {
        $this->idMix_fk = $idMix_fk;
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
    public function getObjMix()
    {
        return $this->objMix;
    }

    /**
     * @param mixed $objMix
     */
    public function setObjMix($objMix)
    {
        $this->objMix = $objMix;
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