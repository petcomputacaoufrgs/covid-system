<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class Modelo{
    private $idModelo;
    private $modelo;
    private $index_modelo;
    
    function __construct() {
        
    }
    
    function getIdModelo() {
        return $this->idModelo;
    }

    function getModelo() {
        return $this->modelo;
    }

    function getIndex_modelo() {
        return $this->index_modelo;
    }

    function setIdModelo($idModelo) {
        $this->idModelo = $idModelo;
    }

    function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    function setIndex_modelo($index_modelo) {
        $this->index_modelo = $index_modelo;
    }


}