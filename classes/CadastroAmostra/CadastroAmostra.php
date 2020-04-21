<?php
class CadastroAmostra{
    private $idCadastroAmostra;
    private $idUsuario_fk;
    private $idAmostra_fk;
    private $idLocalArmazenamento_fk;
    private $dataHoraInicio;
    private $dataHoraFim;
    
    private $objAmostra;
    
    
    
    function getObjAmostra() {
        return $this->objAmostra;
    }

    function setObjAmostra($objAmostra) {
        $this->objAmostra = $objAmostra;
    }

        
    function getIdCadastroAmostra() {
        return $this->idCadastroAmostra;
    }

    function setIdCadastroAmostra($idCadastroAmostra) {
        $this->idCadastroAmostra = $idCadastroAmostra;
    }

        
    function getIdUsuario_fk() {
        return $this->idUsuario_fk;
    }

    function getIdAmostra_fk() {
        return $this->idAmostra_fk;
    }

    function getIdLocalArmazenamento_fk() {
        return $this->idLocalArmazenamento_fk;
    }

    function getDataHoraInicio() {
        return $this->dataHoraInicio;
    }

    function getDataHoraFim() {
        return $this->dataHoraFim;
    }

    function setIdUsuario_fk($idUsuario_fk) {
        $this->idUsuario_fk = $idUsuario_fk;
    }

    function setIdAmostra_fk($idAmostra_fk) {
        $this->idAmostra_fk = $idAmostra_fk;
    }

    function setIdLocalArmazenamento_fk($idLocalArmazenamento_fk) {
        $this->idLocalArmazenamento_fk = $idLocalArmazenamento_fk;
    }

    function setDataHoraInicio($dataHoraInicio) {
        $this->dataHoraInicio = $dataHoraInicio;
    }

    function setDataHoraFim($dataHoraFim) {
        $this->dataHoraFim = $dataHoraFim;
    }


}