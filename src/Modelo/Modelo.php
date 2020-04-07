<?php

/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\Modelo;

class Modelo{
    private $idModelo;
    private $modelo;
    
    function __construct() {
        
    }
    
    function getIdModelo() {
        return $this->idModelo;
    }

    function getModelo() {
        return $this->modelo;
    }

    function setIdModelo($idModelo) {
        $this->idModelo = $idModelo;
    }

    function setModelo($modelo) {
        $this->modelo = $modelo;
    }



}