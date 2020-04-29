<?php

class Rel_tubo_lote{
    private $idRelTuboLote;
    private $idTubo_fk;
    private $idLote_fk;
    private $objLote;

    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getObjLote()
    {
        return $this->objLote;
    }

    /**
     * @param mixed $objLote
     */
    public function setObjLote($objLote)
    {
        $this->objLote = $objLote;
    }



    /**
     * @return mixed
     */
    public function getIdRelTuboLote()
    {
        return $this->idRelTuboLote;
    }

    /**
     * @param mixed $idRelTuboLote
     */
    public function setIdRelTuboLote($idRelTuboLote)
    {
        $this->idRelTuboLote = $idRelTuboLote;
    }



    function getIdTubo_fk() {
        return $this->idTubo_fk;
    }

    function getIdLote_fk() {
        return $this->idLote_fk;
    }

    function setIdTubo_fk($idTubo_fk) {
        $this->idTubo_fk = $idTubo_fk;
    }

    function setIdLote_fk($idLote_fk) {
        $this->idLote_fk = $idLote_fk;
    }

    
}