<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class LocalArmazenamento{
    private $idLocalArmazenamento;
    private $idTipoLocal_fk;
    private $idTempoPermanencia_fk;
    private $dataHoraInicio;
    private $dataHoraFim;
    
    function __construct() {
        
    }
    
    function getIdLocalArmazenamento() {
        return $this->idLocalArmazenamento;
    }

    function getIdTipoLocal_fk() {
        return $this->idTipoLocal_fk;
    }

    function getIdTempoPermanencia_fk() {
        return $this->idTempoPermanencia_fk;
    }

    function getDataHoraInicio() {
        return $this->dataHoraInicio;
    }

    function getDataHoraFim() {
        return $this->dataHoraFim;
    }

    function setIdLocalArmazenamento($idLocalArmazenamento) {
        $this->idLocalArmazenamento = $idLocalArmazenamento;
    }

    function setIdTipoLocal_fk($idTipoLocal_fk) {
        $this->idTipoLocal_fk = $idTipoLocal_fk;
    }

    function setIdTempoPermanencia_fk($idTempoPermanencia_fk) {
        $this->idTempoPermanencia_fk = $idTempoPermanencia_fk;
    }

    function setDataHoraInicio($dataHoraInicio) {
        $this->dataHoraInicio = $dataHoraInicio;
    }

    function setDataHoraFim($dataHoraFim) {
        $this->dataHoraFim = $dataHoraFim;
    }



}