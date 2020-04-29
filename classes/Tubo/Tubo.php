<?php

class Tubo{
    private $idTubo;
    private $idTubo_fk;
    private $idAmostra_fk;
    private $tuboOriginal;
    private $tipo;
    
    private $objInfosTubo;
    private $objPosicao;

    
    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getObjPosicao()
    {
        return $this->objPosicao;
    }

    /**
     * @param mixed $objPosicao
     */
    public function setObjPosicao($objPosicao)
    {
        $this->objPosicao = $objPosicao;
    }


    
    function getObjInfosTubo() {
        return $this->objInfosTubo;
    }

    function setObjInfosTubo($objInfosTubo) {
        $this->objInfosTubo = $objInfosTubo;
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


        
    function getIdTubo() {
        return $this->idTubo;
    }

    function getIdTubo_fk() {
        return $this->idTubo_fk;
    }

    function getIdAmostra_fk() {
        return $this->idAmostra_fk;
    }

    function getTuboOriginal() {
        return $this->tuboOriginal;
    }

    function setIdTubo($idTubo) {
        $this->idTubo = $idTubo;
    }

    function setIdTubo_fk($idTubo_fk){
        $this->idTubo_fk = $idTubo_fk;
    }

    function setIdAmostra_fk($idAmostra_fk){
        $this->idAmostra_fk = $idAmostra_fk;
    }

    function setTuboOriginal($tuboOriginal){
        $this->tuboOriginal = $tuboOriginal;
    }


}