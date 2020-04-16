<?php

class InfosTubo{
    private $idInfosTubo;
    private $idLocalArmazenamento_fk;
    private $idTubo_fk;
    private $statusTubo;
    private $etapa;
    private $dataHora;
    private $reteste; // fará o reteste ou nao (bool)
    private $volume;

    function __construct() {
        
    }

    function getIdInfosTubo(){
        return $this->idInfosTubo;
    }

    function getIdLocalArmazenamento_fk(){
        return $this->idLocalArmazenamento_fk;
    }

    function getIdTubo_fk(){
        return $this->idTubo_fk;
    }

    function getStatusTubo(){
        return $this->statusTubo;
    }

    function getEtapa(){
        return $this->etapa;
    }

    function getDataHora(){
        return $this->dataHora;
    }

    function getReteste(){
        return $this->reteste;
    }

    function getVolume(){
        return $this->volume;
    }

    function setIdInfosTubo($idInfosTubo){
        $this->idInfosTubo = $idInfosTubo;
    }

    function setIdLocalArmazenamento_fk($idLocalArmazenamento_fk){
        $this->idLocalArmazenamento_fk = $idLocalArmazenamento_fk;
    }

    function setIdTubo_fk($idTubo_fk){
        $this->idTubo_fk = $idTubo_fk;
    }

    function setStatusTubo($statusTubo){
        $this->statusTubo = $statusTubo;
    }

    function setEtapa($etapa){
        $this->etapa = $etapa;
    }

    function setDataHora($dataHora){
        $this->dataHora= $dataHora;
    }

    function setReteste($reteste){
        $this->reteste = $reteste;
    }

    function setVolume($volume){
        $this->volume = $volume;
    }
}