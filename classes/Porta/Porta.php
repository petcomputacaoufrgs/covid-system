<?php

class Porta{

    private $idPorta;
    private $nome;

    function __construct() {
        
    }

    

    /**
     * Get the value of idPorta
     */ 
    public function getIdPorta()
    {
        return $this->idPorta;
    }

    /**
     * Set the value of idPorta
     *
     * @return  self
     */ 
    public function setIdPorta($idPorta)
    {
        $this->idPorta = $idPorta;

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