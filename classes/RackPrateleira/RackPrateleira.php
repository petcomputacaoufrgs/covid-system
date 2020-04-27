<?php

class RackPrateleira{

    private $idRackPrateleira;
    private $idRack_fk;
    private $idPrateleira_fk;

    function __construct() {
        
    }

    

    /**
     * Get the value of idRackPrateleira
     */ 
    public function getIdRackPrateleira()
    {
        return $this->idRackPrateleira;
    }

    /**
     * Set the value of idRackPrateleira
     *
     * @return  self
     */ 
    public function setIdRackPrateleira($idRackPrateleira)
    {
        $this->idRackPrateleira = $idRackPrateleira;

        return $this;
    }

    /**
     * Get the value of idRack_fk
     */ 
    public function getIdRack_fk()
    {
        return $this->idRack_fk;
    }

    /**
     * Set the value of idRack_fk
     *
     * @return  self
     */ 
    public function setIdRack_fk($idRack_fk)
    {
        $this->idRack_fk = $idRack_fk;

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
}