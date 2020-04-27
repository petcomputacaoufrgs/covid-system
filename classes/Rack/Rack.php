<?php

class Rack{

    private $idRack;
    private $nome;

    function __construct() {
        
    }

    /**
     * Get the value of idRack
     */ 
    public function getIdRack()
    {
        return $this->idRack;
    }

    /**
     * Set the value of idRack
     *
     * @return  self
     */ 
    public function setIdRack($idRack)
    {
        $this->idRack = $idRack;

        return $this;
    }

    /**
     * Get the value of nome
     */ 
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     *
     * @return  self
     */ 
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }
}