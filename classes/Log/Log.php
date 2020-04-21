<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class Log{
    private $idLog;
    private $idUsuario;
    private $texto;
    private $dataHora;
    
    function getIdLog() {
        return $this->idLog;
    }

    function setIdLog($idLog) {
        $this->idLog = $idLog;
    }

        function getIdUsuario() {
        return $this->idUsuario;
    }

    function getTexto() {
        return $this->texto;
    }

    function getDataHora() {
        return $this->dataHora;
    }

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    function setTexto($texto) {
        $this->texto = $texto;
    }

    function setDataHora($dataHora) {
        $this->dataHora = $dataHora;
    }


    
    
}
