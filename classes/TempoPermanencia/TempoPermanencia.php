<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class TempoPermanencia{
    private $idTempoPermanencia;
    private $tempoPermanencia;
    
    function __construct() {
        
    }
    
    function getIdTempoPermanencia() {
        return $this->idTempoPermanencia;
    }

    function getTempoPermanencia() {
        return $this->tempoPermanencia;
    }

    function setIdTempoPermanencia($idTempoPermanencia) {
        $this->idTempoPermanencia = $idTempoPermanencia;
    }

    function setTempoPermanencia($tempoPermanencia) {
        $this->tempoPermanencia = $tempoPermanencia;
    }



}