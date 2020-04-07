<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class Sexo{
    private $idSexo;
    private $sexo;
    
    function __construct() {
    }
    
    function getIdSexo() {
        return $this->idSexo;
    }

    function getSexo() {
        return $this->sexo;
    }

    function setIdSexo($idSexo) {
        $this->idSexo = $idSexo;
    }

    function setSexo($sexo) {
        $this->sexo = $sexo;
    }



}

