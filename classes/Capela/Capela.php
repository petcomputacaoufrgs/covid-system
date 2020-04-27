<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class Capela{
    private $idCapela;
    private $numero;
    private $statusCapela; //liberada ou não
    private $nivelSeguranca;
    
    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getNivelSeguranca()
    {
        return $this->nivelSeguranca;
    }

    /**
     * @param mixed $nivelSeguranca
     */
    public function setNivelSeguranca($nivelSeguranca)
    {
        $this->nivelSeguranca = $nivelSeguranca;
    }


    
    function getIdCapela() {
        return $this->idCapela;
    }

    function getNumero() {
        return $this->numero;
    }

    function setIdCapela($idCapela) {
        $this->idCapela = $idCapela;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    
    function getStatusCapela() {
        return $this->statusCapela;
    }

    function setStatusCapela($statusCapela) {
        $this->statusCapela = $statusCapela;
    }





}