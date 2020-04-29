<?php

class Coluna{

    private $idColuna;
    private $nome;
    private $idPrateleira_fk;
    private $situacaoColuna;

    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getSituacaoColuna()
    {
        return $this->situacaoColuna;
    }

    /**
     * @param mixed $situacaoColuna
     */
    public function setSituacaoColuna($situacaoColuna)
    {
        $this->situacaoColuna = $situacaoColuna;
    }



    /**
     * @return mixed
     */
    public function getIdPrateleira_fk()
    {
        return $this->idPrateleira_fk;
    }

    /**
     * @param mixed $idPrateleira_fk
     */
    public function setIdPrateleira_fk($idPrateleira_fk)
    {
        $this->idPrateleira_fk = $idPrateleira_fk;
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