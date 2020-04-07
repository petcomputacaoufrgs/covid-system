<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\Usuario\Sexo;

class Sexo
{
    private $idSexo;
    private $sexo;
    
    public function __construct()
    {
    }
    
    public function getIdSexo()
    {
        return $this->idSexo;
    }

    public function getSexo()
    {
        return $this->sexo;
    }

    public function setIdSexo($idSexo)
    {
        $this->idSexo = $idSexo;
    }

    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }
}
