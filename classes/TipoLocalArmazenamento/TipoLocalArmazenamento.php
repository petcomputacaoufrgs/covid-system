<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */


class TipoLocalArmazenamento{
    private $idTipoLocalArmazenamento;
    private $nomeLocal;
    private $qntEspacosTotal;
    private $qntEspacosAmostra;
    
    function __construct() {
        
    }
    
    function getIdTipoLocalArmazenamento() {
        return $this->idTipoLocalArmazenamento;
    }

    function getNomeLocal() {
        return $this->nomeLocal;
    }

    function getQntEspacosTotal() {
        return $this->qntEspacosTotal;
    }

    function getQntEspacosAmostra() {
        return $this->qntEspacosAmostra;
    }

    function setIdTipoLocalArmazenamento($idTipoLocalArmazenamento) {
        $this->idTipoLocalArmazenamento = $idTipoLocalArmazenamento;
    }

    function setNomeLocal($nomeLocal) {
        $this->nomeLocal = $nomeLocal;
    }

    function setQntEspacosTotal($qntEspacosTotal) {
        $this->qntEspacosTotal = $qntEspacosTotal;
    }

    function setQntEspacosAmostra($qntEspacosAmostra) {
        $this->qntEspacosAmostra = $qntEspacosAmostra;
    }
    
}