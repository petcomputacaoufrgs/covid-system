<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\Usuario\PerfilUsuario;

class PerfilUsuario
{
    private $idPerfilUsuario;
    private $perfil;
    
    public function __construct()
    {
    }
    
    public function getIdPerfilUsuario()
    {
        return $this->idPerfilUsuario;
    }

    public function getPerfil()
    {
        return $this->perfil;
    }

    public function setIdPerfilUsuario($idPerfilUsuario)
    {
        $this->idPerfilUsuario = $idPerfilUsuario;
    }

    public function setPerfil($perfil)
    {
        $this->perfil = $perfil;
    }
}
