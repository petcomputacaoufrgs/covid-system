<?php

class ColunaCaixa{


    private $idColunaCaixa;
    private $idCaixa_fk;
    private $idColuna_fk;

    function __construct() {
        
    }

    

    /**
     * Get the value of idColunaCaixa
     */ 
    public function getIdColunaCaixa()
    {
        return $this->idColunaCaixa;
    }

    /**
     * Set the value of idColunaCaixa
     *
     * @return  self
     */ 
    public function setIdColunaCaixa($idColunaCaixa)
    {
        $this->idColunaCaixa = $idColunaCaixa;

        return $this;
    }

    /**
     * Get the value of idCaixa_fk
     */ 
    public function getIdCaixa_fk()
    {
        return $this->idCaixa_fk;
    }

    /**
     * Set the value of idCaixa_fk
     *
     * @return  self
     */ 
    public function setIdCaixa_fk($idCaixa_fk)
    {
        $this->idCaixa_fk = $idCaixa_fk;

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