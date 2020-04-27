<?php

class Caixa{
    private $idCaixa;
    private $posicao;

    function __construct() {
        
    }

    /**
     * Get the value of idCaixa
     */ 
    public function getIdCaixa()
    {
        return $this->idCaixa;
    }

    /**
     * Set the value of idCaixa
     *
     * @return  self
     */ 
    public function setIdCaixa($idCaixa)
    {
        $this->idCaixa = $idCaixa;

        return $this;
    }

    /**
     * Get the value of posicao
     */ 
    public function getPosicao()
    {
        return $this->posicao;
    }

    /**
     * Set the value of posicao
     *
     * @return  self
     */ 
    public function setPosicao($posicao)
    {
        $this->posicao = $posicao;

        return $this;
    }

    
}