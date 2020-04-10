<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class Doenca{
    private $idDoenca;
    private $doenca;
    private $index_doenca;
    
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
    
    function getIndex_doenca() {
        return $this->index_doenca;
    }

    function setIndex_doenca($index_doenca) {
        $this->index_doenca = $index_doenca;
    }




}