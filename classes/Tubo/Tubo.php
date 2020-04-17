<?php

class Tubo{
    private $idTubo;
    private $idTubo_fk;
    private $idAmostra_fk;
    private $tuboOriginal;

    
    function __construct() {
        
    }
    
    function getIdTubo() {
        return $this->idTubo;
    }

    function getIdTubo_fk() {
        return $this->idTubo_fk;
    }

    function getIdAmostra_fk() {
        return $this->idAmostra_fk;
    }

    function getTuboOriginal() {
        return $this->tuboOriginal;
    }

    function setIdTubo($idTubo) {
        $this->idTubo = $idTubo;
    }

    function setIdTubo_fk($idTubo_fk){
        $this->idTubo_fk = $idTubo_fk;
    }

    function setIdAmostra_fk($idAmostra_fk){
        $this->idAmostra_fk = $idAmostra_fk;
    }

    function setTuboOriginal($tuboOriginal){
        $this->tuboOriginal = $tuboOriginal;
    }


}