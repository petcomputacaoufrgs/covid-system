<?php

class Prateleira{

    private $idPrateleira;
    private $nome;

    function __construct() {
        
    }


    /**
     * Get the value of idPrateleira
     */ 
    public function getIdPrateleira()
    {
        return $this->idPrateleira;
    }

    /**
     * Set the value of idPrateleira
     *
     * @return  self
     */ 
    public function setIdPrateleira($idPrateleira)
    {
        $this->idPrateleira = $idPrateleira;

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