<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class Detentor{
    private $idDetentor;
    private $detentor;
    private $index_detentor;
    
    function __construct() {
        
    }
    
    function getIdDetentor() {
        return $this->idDetentor;
    }

    function getDetentor() {
        return $this->detentor;
    }

    function getIndex_detentor() {
        return $this->index_detentor;
    }

    function setIdDetentor($idDetentor) {
        $this->idDetentor = $idDetentor;
    }

    function setDetentor($detentor) {
        $this->detentor = $detentor;
    }

    function setIndex_detentor($index_detentor) {
        $this->index_detentor = $index_detentor;
    }



}