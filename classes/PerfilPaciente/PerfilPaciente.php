<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */


class PerfilPaciente{
    private $idPerfilPaciente;
    private $perfil;
    private $index_perfil;
    private $caractere;
    
    function __construct() {
        
    }
    
    function getCaractere() {
        return $this->caractere;
    }

    function setCaractere($caractere) {
        $this->caractere = $caractere;
    }

        
    function getIdPerfilPaciente() {
        return $this->idPerfilPaciente;
    }

    function getPerfil() {
        return $this->perfil;
    }

    function getIndex_perfil() {
        return $this->index_perfil;
    }

    function setIdPerfilPaciente($idPerfilPaciente) {
        $this->idPerfilPaciente = $idPerfilPaciente;
    }

    function setPerfil($perfil) {
        $this->perfil = $perfil;
    }

    function setIndex_perfil($index_perfil) {
        $this->index_perfil = $index_perfil;
    }

    
}