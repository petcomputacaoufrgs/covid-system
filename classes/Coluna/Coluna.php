<?php

class Coluna{

    private $idColuna;
    private $nome;

    function __construct() {
        
    }

    

    /**
     * Get the value of idColuna
     */ 
    public function getIdColuna()
    {
        return $this->idColuna;
    }

    /**
     * Set the value of idColuna
     *
     * @return  self
     */ 
    public function setIdColuna($idColuna)
    {
        $this->idColuna = $idColuna;

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