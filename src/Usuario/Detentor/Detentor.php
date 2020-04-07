<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\Usuario\Detentor;

class Detentor
{
    private $idDetentor;
    private $detentor;
    
    public function __construct()
    {
    }
    
    public function getIdDetentor()
    {
        return $this->idDetentor;
    }

    public function getDetentor()
    {
        return $this->detentor;
    }

    public function setIdDetentor($idDetentor)
    {
        $this->idDetentor = $idDetentor;
    }

    public function setDetentor($detentor)
    {
        $this->detentor = $detentor;
    }
}
