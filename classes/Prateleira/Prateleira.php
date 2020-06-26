<?php

class Prateleira{

    private $idPrateleira;
    private $nome;
    private $situacaoPrateleira;
    private $idPorta_fk;

    private $objPorta;

    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getObjPorta()
    {
        return $this->objPorta;
    }

    /**
     * @param mixed $objPorta
     */
    public function setObjPorta($objPorta)
    {
        $this->objPorta = $objPorta;
    }



    /**
     * @return mixed
     */
    public function getIdPorta_fk()
    {
        return $this->idPorta_fk;
    }

    /**
     * @param mixed $idPorta_fk
     */
    public function setIdPorta_fk($idPorta_fk)
    {
        $this->idPorta_fk = $idPorta_fk;
    }


    /**
     * @return mixed
     */
    public function getSituacaoPrateleira()
    {
        return $this->situacaoPrateleira;
    }

    /**
     * @param mixed $situacaoPrateleira
     */
    public function setSituacaoPrateleira($situacaoPrateleira)
    {
        $this->situacaoPrateleira = $situacaoPrateleira;
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