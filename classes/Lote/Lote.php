<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
class Lote{

    private $idLote;
    private $qntAmostrasDesejadas;
    private $qntAmostrasAdquiridas;
    private $situacaoLote;
    private $tipo;

    private $objRelTuboLote;

    private $objsTubo;
    private $objsAmostras;
    private $objPreparo;



    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getObjRelTuboLote()
    {
        return $this->objRelTuboLote;
    }

    /**
     * @param mixed $objRelTuboLote
     */
    public function setObjRelTuboLote($objRelTuboLote)
    {
        $this->objRelTuboLote = $objRelTuboLote;
    }



    /**
     * @return mixed
     */
    public function getObjPreparo()
    {
        return $this->objPreparo;
    }

    /**
     * @param mixed $objPreparo
     */
    public function setObjPreparo($objPreparo)
    {
        $this->objPreparo = $objPreparo;
    }



    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }



    /**
     * @return mixed
     */
    public function getObjsAmostras()
    {
        return $this->objsAmostras;
    }

    /**
     * @param mixed $objsAmostras
     */
    public function setObjsAmostras($objsAmostras)
    {
        $this->objsAmostras = $objsAmostras;
    }



    /**
     * @return mixed
     */
    public function getSituacaoLote()
    {
        return $this->situacaoLote;
    }

    /**
     * @param mixed $situacaoLote
     */
    public function setSituacaoLote($situacaoLote)
    {
        $this->situacaoLote = $situacaoLote;
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