<?php

/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\Usuario\Marca;

class Marca{
    private $idMarca;
    private $marca;
    
    function __construct() {
        
    }
    
    function getIdMarca() {
        return $this->idMarca;
    }

    function getMarca() {
        return $this->marca;
    }

    function setIdMarca($idMarca) {
        $this->idMarca = $idMarca;
    }

    function setMarca($marca) {
        $this->marca = $marca;
    }





}