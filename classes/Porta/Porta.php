<?php

class Porta{

    private $idPorta;
    private $nome;
    private $situacaoPorta;
    private $idLocalArmazenamento_fk;
    private $qntPrateleiras;

    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getQntPrateleiras()
    {
        return $this->qntPrateleiras;
    }

    /**
     * @param mixed $qntPrateleiras
     */
    public function setQntPrateleiras($qntPrateleiras)
    {
        $this->qntPrateleiras = $qntPrateleiras;
    }



    /**
     * @return mixed
     */
    public function getIdLocalArmazenamentoFk()
    {
        return $this->idLocalArmazenamento_fk;
    }

    /**
     * @param mixed $idLocalArmazenamento_fk
     */
    public function setIdLocalArmazenamentoFk($idLocalArmazenamento_fk)
    {
        $this->idLocalArmazenamento_fk = $idLocalArmazenamento_fk;
    }


    /**
     * @return mixed
     */
    public function getSituacaoPorta()
    {
        return $this->situacaoPorta;
    }

    /**
     * @param mixed $situacaoPorta
     */
    public function setSituacaoPorta($situacaoPorta)
    {
        $this->situacaoPorta = $situacaoPorta;
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