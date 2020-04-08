<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class CodigoGAL
{
    private $idCodigoGAL;
    private $codigo;
   
    
    function __construct() {
        
    }
    
    function getIdCodigoGAL() {
        return $this->idCodigoGAL;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function setIdCodigoGAL($idCodigoGAL) {
        $this->idCodigoGAL = $idCodigoGAL;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }


    
}