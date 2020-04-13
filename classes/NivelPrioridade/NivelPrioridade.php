<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class NivelPrioridade{
    private $idNivelPrioridade;
    private $nivel;
    
    function __construct() {
        
    }
    
    function getIdNivelPrioridade() {
        return $this->idNivelPrioridade;
    }

    function getNivel() {
        return $this->nivel;
    }

    function setIdNivelPrioridade($idNivelPrioridade) {
        $this->idNivelPrioridade = $idNivelPrioridade;
    }

    function setNivel($nivel) {
        $this->nivel = $nivel;
    }




}
