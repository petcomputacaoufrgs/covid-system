<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class Amostra{
    private $idAmostra;
    private $idTipoAmostra_fk;
    private $idUsuario_fk;
    private $idPaciente_fk;
    private $quantidade;
    private $observacoes;
    private $dataHoraInicio;
    private $dataHoraFim;
    private $dataHoraColeta;
    private $aceita_recusa;
    
    function __construct() {
        
    }
    function getIdAmostra() {
        return $this->idAmostra;
    }

    function getIdTipoAmostra_fk() {
        return $this->idTipoAmostra_fk;
    }

    function getIdUsuario_fk() {
        return $this->idUsuario_fk;
    }

    function getIdPaciente_fk() {
        return $this->idPaciente_fk;
    }

    function getQuantidade() {
        return $this->quantidade;
    }

    function getObservacoes() {
        return $this->observacoes;
    }

    function getDataHoraInicio() {
        return $this->dataHoraInicio;
    }

    function getDataHoraFim() {
        return $this->dataHoraFim;
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

    function setIdTipoAmostra_fk($idTipoAmostra_fk) {
        $this->idTipoAmostra_fk = $idTipoAmostra_fk;
    }

    function setIdUsuario_fk($idUsuario_fk) {
        $this->idUsuario_fk = $idUsuario_fk;
    }

    function setIdPaciente_fk($idPaciente_fk) {
        $this->idPaciente_fk = $idPaciente_fk;
    }

    function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }

    function setObservacoes($observacoes) {
        $this->observacoes = $observacoes;
    }

    function setDataHoraInicio($dataHoraInicio) {
        $this->dataHoraInicio = $dataHoraInicio;
    }

    function setDataHoraFim($dataHoraFim) {
        $this->dataHoraFim = $dataHoraFim;
    }

    function setDataHoraColeta($dataHoraColeta) {
        $this->dataHoraColeta = $dataHoraColeta;
    }

    function setAceita_recusa($aceita_recusa) {
        $this->aceita_recusa = $aceita_recusa;
    }



}