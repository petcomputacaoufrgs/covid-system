<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\Usuario;

class Usuario
{
    private $idUsuario;
    private $matricula;
    
    public function __construct()
    {
    }
    
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function getMatricula()
    {
        return $this->matricula;
    }

    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;
    }
}
