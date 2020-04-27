<?php

class PortaRack{

    private $portaIdPorta;
    private $rackIdRack;

    function __construct() {
        
    }

    /**
     * Get the value of portaIdPorta
     */ 
    public function getPortaIdPorta()
    {
        return $this->portaIdPorta;
    }

    /**
     * Set the value of portaIdPorta
     *
     * @return  self
     */ 
    public function setPortaIdPorta($portaIdPorta)
    {
        $this->portaIdPorta = $portaIdPorta;

        return $this;
    }

    /**
     * Get the value of rackIdRack
     */ 
    public function getRackIdRack()
    {
        return $this->rackIdRack;
    }

    /**
     * Set the value of rackIdRack
     *
     * @return  self
     */ 
    public function setRackIdRack($rackIdRack)
    {
        $this->rackIdRack = $rackIdRack;

        return $this;
    }
}