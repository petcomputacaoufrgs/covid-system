<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

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