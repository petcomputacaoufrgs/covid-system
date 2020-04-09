<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\LocalArmazenamento;

class LocalArmazenamento
{
    private $idLocalArmazenamento;
    private $idTipoLocal_fk;
    private $idTempoPermanencia_fk;
    private $dataHoraInicio;
    private $dataHoraFim;
    
    public function __construct()
    {
    }
    
    public function getIdLocalArmazenamento()
    {
        return $this->idLocalArmazenamento;
    }

    public function getIdTipoLocal_fk()
    {
        return $this->idTipoLocal_fk;
    }

    public function getIdTempoPermanencia_fk()
    {
        return $this->idTempoPermanencia_fk;
    }

    public function getDataHoraInicio()
    {
        return $this->dataHoraInicio;
    }

    public function getDataHoraFim()
    {
        return $this->dataHoraFim;
    }

    public function setIdLocalArmazenamento($idLocalArmazenamento)
    {
        $this->idLocalArmazenamento = $idLocalArmazenamento;
    }

    public function setIdTipoLocal_fk($idTipoLocal_fk)
    {
        $this->idTipoLocal_fk = $idTipoLocal_fk;
    }

    public function setIdTempoPermanencia_fk($idTempoPermanencia_fk)
    {
        $this->idTempoPermanencia_fk = $idTempoPermanencia_fk;
    }

    public function setDataHoraInicio($dataHoraInicio)
    {
        $this->dataHoraInicio = $dataHoraInicio;
    }

    public function setDataHoraFim($dataHoraFim)
    {
        $this->dataHoraFim = $dataHoraFim;
    }
}
