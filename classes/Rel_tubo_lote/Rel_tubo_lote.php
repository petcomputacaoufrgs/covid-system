<?php

class Rel_tubo_lote{

    private $idTubo_fk;
    private $idLote_fk;

    function __construct() {
        
    }
    
    function getIdTubo_fk() {
        return $this->idTubo_fk;
    }

    function getIdLote_fk() {
        return $this->idLote_fk;
    }

    function setIdTubo_fk($idTubo_fk) {
        $this->idTubo_fk = $idTubo_fk;
    }

    function setIdLote_fk($idLote_fk) {
        $this->idLote_fk = $idLote_fk;
    }

    
}