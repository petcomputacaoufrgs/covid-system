<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\Usuario\Modelo;

class Modelo
{
    private $idModelo;
    private $modelo;
    
    public function __construct()
    {
    }
    
    public function getIdModelo()
    {
        return $this->idModelo;
    }

    public function getModelo()
    {
        return $this->modelo;
    }

    public function setIdModelo($idModelo)
    {
        $this->idModelo = $idModelo;
    }

    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }
}
