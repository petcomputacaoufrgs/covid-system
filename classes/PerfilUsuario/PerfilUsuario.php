<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */


class PerfilUsuario{
    private $idPerfilUsuario;
    private $perfil;
    private $index_perfil;
    
    function __construct() {
        
    }
    
    function getIdPerfilUsuario() {
        return $this->idPerfilUsuario;
    }

    function getPerfil() {
        return $this->perfil;
    }

    function getIndex_perfil() {
        return $this->index_perfil;
    }

    function setIdPerfilUsuario($idPerfilUsuario) {
        $this->idPerfilUsuario = $idPerfilUsuario;
    }

    function setPerfil($perfil) {
        $this->perfil = $perfil;
    }

    function setIndex_perfil($index_perfil) {
        $this->index_perfil = $index_perfil;
    }






}