<?php

/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\Usuario\Doenca;

class Doenca{
    private $idDoenca;
    private $doenca;
    
    function __construct() {
        
    }
    
    function getIdDoenca() {
        return $this->idDoenca;
    }

    function getDoenca() {
        return $this->doenca;
    }

    function setIdDoenca($idDoenca) {
        $this->idDoenca = $idDoenca;
    }

    function setDoenca($doenca) {
        $this->doenca = $doenca;
    }



}