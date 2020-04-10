<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class CodigoGAL
{
    private $idCodigoGAL;
    private $idPaciente_fk;
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
    
    function getIdPaciente_fk() {
        return $this->idPaciente_fk;
    }

    function setIdPaciente_fk($idPaciente_fk) {
        $this->idPaciente_fk = $idPaciente_fk;
    }



    
}