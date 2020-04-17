<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class Amostra{
    private $idAmostra;
    private $codigoAmostra; //letra + idAmostra
    private $idPerfilPaciente_fk;
    private $idEstado_fk;
    private $idLugarOrigem_fk;
    private $idCodGAL_fk;
    private $idNivelPrioridade_fk;
    private $observacoes;
    private $dataColeta;
    private $a_r_g;
    private $statusAmostra;
    private $CEP;
    private $motivoExame;
    
    function __construct() {
        
    }
    
    function getIdAmostra() {
        return $this->idAmostra;
    }

    function getCodigoAmostra() {
        return $this->codigoAmostra;
    }

    function getIdPerfilPaciente_fk() {
        return $this->idPerfilPaciente_fk;
    }

    function getIdEstado_fk() {
        return $this->idEstado_fk;
    }

    function getIdLugarOrigem_fk() {
        return $this->idLugarOrigem_fk;
    }

    function getIdCodGAL_fk() {
        return $this->idCodGAL_fk;
    }

    function getIdNivelPrioridade_fk() {
        return $this->idNivelPrioridade_fk;
    }

    function getObservacoes() {
        return $this->observacoes;
    }

    function getDataColeta() {
        return $this->dataColeta;
    }

    function get_a_r_g() {
        return $this->a_r_g;
    }

    function getStatusAmostra() {
        return $this->statusAmostra;
    }

    function getCEP() {
        return $this->CEP;
    }

    function getMotivoExame() {
        return $this->motivoExame;
    }

    function setIdAmostra($idAmostra) {
        $this->idAmostra = $idAmostra;
    }

    function setCodigoAmostra($codigoAmostra) {
        $this->codigoAmostra = $codigoAmostra;
    }

    function setIdPerfilPaciente_fk($idPerfilPaciente_fk) {
        $this->idPerfilPaciente_fk = $idPerfilPaciente_fk;
    }

    function setIdEstado_fk($idEstado_fk) {
        $this->idEstado_fk = $idEstado_fk;
    }

    function setIdLugarOrigem_fk($idLugarOrigem_fk) {
        $this->idLugarOrigem_fk = $idLugarOrigem_fk;
    }

    function setIdCodGAL_fk($idCodGAL_fk) {
        $this->idCodGAL_fk = $idCodGAL_fk;
    }

    function setIdNivelPrioridade_fk($idNivelPrioridade_fk) {
        $this->idNivelPrioridade_fk = $idNivelPrioridade_fk;
    }

    function setObservacoes($observacoes) {
        $this->observacoes = $observacoes;
    }

    function setDataColeta($dataColeta) {
        $this->dataColeta = $dataColeta;
    }

    function set_a_r_g($a_r_g) {
        $this->a_r_g = $a_r_g;
    }

    function setStatusAmostra($statusAmostra) {
        $this->statusAmostra = $statusAmostra;
    }

    function setCEP($CEP) {
        $this->CEP = $CEP;
    }

    function setMotivoExame($motivoExame) {
        $this->motivoExame = $motivoExame;
    }


}