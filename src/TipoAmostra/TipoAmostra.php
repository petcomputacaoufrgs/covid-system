<?php

/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\TipoAmostra;

class TipoAmostra{
    private $idTipoAmostra;
    private $tipo; //amostra congelada, amostra normal...
    
    function __construct() {
        
    }
    
    function getIdTipoAmostra() {
        return $this->idTipoAmostra;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setIdTipoAmostra($idTipoAmostra) {
        $this->idTipoAmostra = $idTipoAmostra;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }


}