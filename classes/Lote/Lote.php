<?php

class Lote{

    private $idLote;
    private $qntAmostrasTotal;
    private $qntAmostrasLivres;

    function __construct() {
        
    }
    
    function getIdLote() {
        return $this->idLote;
    }

    function getQntAmostrasTotal() {
        return $this->qntAmostrasTotal;
    }

    function getQntAmostrasLivres() {
        return $this->qntAmostrasLivres;
    }

    function setIdLote($idLote) {
        $this->idLote = $idLote;
    }

    function setQntAmostrasTotal($qntAmostrasTotal) {
        $this->qntAmostrasTotal = $qntAmostrasTotal;
    }

    function setQntAmostrasLivres($qntAmostrasLivres) {
        $this->qntAmostrasLivres = $qntAmostrasLivres;
    }


}