<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class Marca{
    private $idMarca;
    private $marca;
    private $index_marca;
    
    function __construct() {
        
    }
    
    function getIdMarca() {
        return $this->idMarca;
    }

    function getMarca() {
        return $this->marca;
    }

    function getIndex_marca() {
        return $this->index_marca;
    }

    function setIdMarca($idMarca) {
        $this->idMarca = $idMarca;
    }

    function setMarca($marca) {
        $this->marca = $marca;
    }

    function setIndex_marca($index_marca) {
        $this->index_marca = $index_marca;
    }



}