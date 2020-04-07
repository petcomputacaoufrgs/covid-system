<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\TempoPermanencia;

class TempoPermanencia
{
    private $idTempoPermanencia;
    private $tempoPermanencia;
    
    public function __construct()
    {
    }
    
    public function getIdTempoPermanencia()
    {
        return $this->idTempoPermanencia;
    }

    public function getTempoPermanencia()
    {
        return $this->tempoPermanencia;
    }

    public function setIdTempoPermanencia($idTempoPermanencia)
    {
        $this->idTempoPermanencia = $idTempoPermanencia;
    }

    public function setTempoPermanencia($tempoPermanencia)
    {
        $this->tempoPermanencia = $tempoPermanencia;
    }
}
