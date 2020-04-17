<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class Etnia{
    private $idEtnia;
    private $etnia;
    private $index_etnia;
    
    function getIndex_etnia() {
        return $this->index_etnia;
    }

    function setIndex_etnia($index_etnia) {
        $this->index_etnia = $index_etnia;
    }

        
    function getIdEtnia() {
        return $this->idEtnia;
    }

    function getEtnia() {
        return $this->etnia;
    }

    function setIdEtnia($idEtnia) {
        $this->idEtnia = $idEtnia;
    }

    function setEtnia($etnia) {
        $this->etnia = $etnia;
    }
    
    
}
