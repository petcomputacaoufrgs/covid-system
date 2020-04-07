<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class Detentor{
    private $idDetentor;
    private $detentor;
    
    function __construct() {
        
    }
    
    function getIdDetentor() {
        return $this->idDetentor;
    }

    function getDetentor() {
        return $this->detentor;
    }

    function setIdDetentor($idDetentor) {
        $this->idDetentor = $idDetentor;
    }

    function setDetentor($detentor) {
        $this->detentor = $detentor;
    }




}