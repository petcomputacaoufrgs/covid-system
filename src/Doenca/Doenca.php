<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\Doenca;

class Doenca
{
    private $idDoenca;
    private $doenca;
    
    public function __construct()
    {
    }
    
    public function getIdDoenca()
    {
        return $this->idDoenca;
    }

    public function getDoenca()
    {
        return $this->doenca;
    }

    public function setIdDoenca($idDoenca)
    {
        $this->idDoenca = $idDoenca;
    }

    public function setDoenca($doenca)
    {
        $this->doenca = $doenca;
    }
}
