<?php

/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\Usuario\PerfilUsuario;


class PerfilUsuario{
    private $idPerfilUsuario;
    private $perfil;
    
    function __construct() {
        
    }
    
    function getIdPerfilUsuario() {
        return $this->idPerfilUsuario;
    }

    function getPerfil() {
        return $this->perfil;
    }

    function setIdPerfilUsuario($idPerfilUsuario) {
        $this->idPerfilUsuario = $idPerfilUsuario;
    }

    function setPerfil($perfil) {
        $this->perfil = $perfil;
    }





}