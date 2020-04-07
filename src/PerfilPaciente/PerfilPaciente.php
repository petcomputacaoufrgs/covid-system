<?php

/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\PerfilPaciente;


class PerfilPaciente{
    private $idPerfilPaciente;
    private $perfil;
    
    function __construct() {
        
    }
    
    function getIdPerfilPaciente() {
        return $this->idPerfilPaciente;
    }

    function getPerfil() {
        return $this->perfil;
    }

    function setIdPerfilPaciente($idPerfilPaciente) {
        $this->idPerfilPaciente = $idPerfilPaciente;
    }

    function setPerfil($perfil) {
        $this->perfil = $perfil;
    }



    
}