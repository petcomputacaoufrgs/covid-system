<?php

class PrateleiraColuna{

    private $idPrateleiraColuna;
    private $idPrateleira_fk;
    private $idColuna_fk;

    function __construct() {
        
    }

    

    /**
     * Get the value of idPrateleiraColuna
     */ 
    public function getIdPrateleiraColuna()
    {
        return $this->idPrateleiraColuna;
    }

    /**
     * Set the value of idPrateleiraColuna
     *
     * @return  self
     */ 
    public function setIdPrateleiraColuna($idPrateleiraColuna)
    {
        $this->idPrateleiraColuna = $idPrateleiraColuna;

        return $this;
    }

    /**
     * Get the value of idPrateleira_fk
     */ 
    public function getIdPrateleira_fk()
    {
        return $this->idPrateleira_fk;
    }

    /**
     * Set the value of idPrateleira_fk
     *
     * @return  self
     */ 
    public function setIdPrateleira_fk($idPrateleira_fk)
    {
        $this->idPrateleira_fk = $idPrateleira_fk;

        return $this;
    }

    /**
     * Get the value of idColuna_fk
     */ 
    public function getIdColuna_fk()
    {
        return $this->idColuna_fk;
    }

    /**
     * Set the value of idColuna_fk
     *
     * @return  self
     */ 
    public function setIdColuna_fk($idColuna_fk)
    {
        $this->idColuna_fk = $idColuna_fk;

        return $this;
    }
}