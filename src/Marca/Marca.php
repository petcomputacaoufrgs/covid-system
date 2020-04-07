<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\Marca;

class Marca
{
    private $idMarca;
    private $marca;
    
    public function __construct()
    {
    }
    
    public function getIdMarca()
    {
        return $this->idMarca;
    }

    public function getMarca()
    {
        return $this->marca;
    }

    public function setIdMarca($idMarca)
    {
        $this->idMarca = $idMarca;
    }

    public function setMarca($marca)
    {
        $this->marca = $marca;
    }
}
