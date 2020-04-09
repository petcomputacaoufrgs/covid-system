<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\PerfilPaciente;

class PerfilPaciente
{
    private $idPerfilPaciente;
    private $perfil;
    
    public function __construct()
    {
    }
    
    public function getIdPerfilPaciente()
    {
        return $this->idPerfilPaciente;
    }

    public function getPerfil()
    {
        return $this->perfil;
    }

    public function setIdPerfilPaciente($idPerfilPaciente)
    {
        $this->idPerfilPaciente = $idPerfilPaciente;
    }

    public function setPerfil($perfil)
    {
        $this->perfil = $perfil;
    }
}
