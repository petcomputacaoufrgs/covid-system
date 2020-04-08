<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class Rel_codGAL_paciente
{
    private $idCodigoGAL_fk;
    private $idPaciente_fk;
   
    
    function __construct() {
        
    }
    function getIdCodigoGAL_fk() {
        return $this->idCodigoGAL_fk;
    }

    function getIdPaciente_fk() {
        return $this->idPaciente_fk;
    }

    function setIdCodigoGAL_fk($idCodigoGAL_fk) {
        $this->idCodigoGAL_fk = $idCodigoGAL_fk;
    }

    function setIdPaciente_fk($idPaciente_fk) {
        $this->idPaciente_fk = $idPaciente_fk;
    }


    
}