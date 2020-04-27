<?php

class Lote{

    private $idLote;
    private $qntAmostrasDesejadas;
    private $qntAmostrasAdquiridas;
    private $statusLote;
    private $objsTubo;


    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getStatusLote()
    {
        return $this->statusLote;
    }

    /**
     * @param mixed $statusLote
     */
    public function setStatusLote($statusLote)
    {
        $this->statusLote = $statusLote;
    }



    /**
     * @return mixed
     */
    public function getObjsTubo()
    {
        return $this->objsTubo;
    }

    /**
     * @param mixed $objsTubo
     */
    public function setObjsTubo($objsTubo)
    {
        $this->objsTubo = $objsTubo;
    }



    function getIdLote() {
        return $this->idLote;
    }

    function getQntAmostrasDesejadas() {
        return $this->qntAmostrasDesejadas;
    }

    function getQntAmostrasAdquiridas() {
        return $this->qntAmostrasAdquiridas;
    }

    function setIdLote($idLote) {
        $this->idLote = $idLote;
    }

    function setQntAmostrasDesejadas($qntAmostrasDesejadas) {
        $this->qntAmostrasDesejadas = $qntAmostrasDesejadas;
    }

    function setQntAmostrasAdquiridas($qntAmostrasAdquiridas) {
        $this->qntAmostrasAdquiridas = $qntAmostrasAdquiridas;
    }


}