<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class Sexo{
    private $idSexo;
    private $sexo;
    private $index_sexo;
    
    function __construct() {
    }
    
    function getIdSexo() {
        return $this->idSexo;
    }

    function getSexo() {
        return $this->sexo;
    }

    function getIndex_sexo() {
        return $this->index_sexo;
    }

    function setIdSexo($idSexo) {
        $this->idSexo = $idSexo;
    }

    function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    function setIndex_sexo($index_sexo) {
        $this->index_sexo = $index_sexo;
    }





}

