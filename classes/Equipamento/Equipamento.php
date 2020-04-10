<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class Equipamento{
    private $idEquipamento;
    private $idDetentor_fk;
    private $idMarca_fk;
    private $idModelo_fk;
    private $dataUltimaCalibragem;
    private $dataChegada;
    
    
    function __construct() {
        
    }
    
    function getIdEquipamento() {
        return $this->idEquipamento;
    }

    function getIdDetentor_fk() {
        return $this->idDetentor_fk;
    }

    function getIdMarca_fk() {
        return $this->idMarca_fk;
    }

    function getIdModelo_fk() {
        return $this->idModelo_fk;
    }

    function getDataUltimaCalibragem() {
        return $this->dataUltimaCalibragem;
    }

    function getDataChegada() {
        return $this->dataChegada;
    }

    function setIdEquipamento($idEquipamento) {
        $this->idEquipamento = $idEquipamento;
    }

    function setIdDetentor_fk($idDetentor_fk) {
        $this->idDetentor_fk = $idDetentor_fk;
    }

    function setIdMarca_fk($idMarca_fk) {
        $this->idMarca_fk = $idMarca_fk;
    }

    function setIdModelo_fk($idModelo_fk) {
        $this->idModelo_fk = $idModelo_fk;
    }

    function setDataUltimaCalibragem($dataUltimaCalibragem) {
        $this->dataUltimaCalibragem = $dataUltimaCalibragem;
    }

    function setDataChegada($dataChegada) {
        $this->dataChegada = $dataChegada;
    }



}