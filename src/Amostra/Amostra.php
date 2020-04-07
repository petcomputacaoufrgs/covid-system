<?php

/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\Amostra;

class Amostra{
    private $idAmostra;
    private $idPaciente_fk;
    private $idEstado_fk;
    private $idLugarOrigem_fk;
    private $quantidadeTubos;
    private $observacoes;
    private $dataHoraColeta;
    private $aceita_recusa;
    
    function __construct() {
        
    }
    
    function getIdEstado_fk() {
        return $this->idEstado_fk;
    }

    function getIdLugarOrigem_fk() {
        return $this->idLugarOrigem_fk;
    }

    function setIdEstado_fk($idEstado_fk) {
        $this->idEstado_fk = $idEstado_fk;
    }

    function setIdLugarOrigem_fk($idLugarOrigem_fk) {
        $this->idLugarOrigem_fk = $idLugarOrigem_fk;
    }

        
    function getIdAmostra() {
        return $this->idAmostra;
    }

    
    function getIdPaciente_fk() {
        return $this->idPaciente_fk;
    }

    function getQuantidadeTubos() {
        return $this->quantidadeTubos;
    }

    function getObservacoes() {
        return $this->observacoes;
    }

    function getDataHoraColeta() {
        return $this->dataHoraColeta;
    }

    function getAceita_recusa() {
        return $this->aceita_recusa;
    }

    function setIdAmostra($idAmostra) {
        $this->idAmostra = $idAmostra;
    }

   
    function setIdPaciente_fk($idPaciente_fk) {
        $this->idPaciente_fk = $idPaciente_fk;
    }

    function setQuantidadeTubos($quantidadeTubos) {
        $this->quantidadeTubos = $quantidadeTubos;
    }

    function setObservacoes($observacoes) {
        $this->observacoes = $observacoes;
    }

    function setDataHoraColeta($dataHoraColeta) {
        $this->dataHoraColeta = $dataHoraColeta;
    }

    function setAceita_recusa($aceita_recusa) {
        $this->aceita_recusa = $aceita_recusa;
    }



}