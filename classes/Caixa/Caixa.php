<?php

class Caixa{
    private $idCaixa;
    private $nome;
    private $posicao;
    private $qntSlotsOcupados;
    private $qntSlotsVazios;
    private $qntLinhas;
    private $qntColunas;
    private $idColuna_fk;

    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getIdColuna_fk()
    {
        return $this->idColuna_fk;
    }

    /**
     * @param mixed $idColuna_fk
     */
    public function setIdColuna_fk($idColuna_fk)
    {
        $this->idColuna_fk = $idColuna_fk;
    }



    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getQntLinhas()
    {
        return $this->qntLinhas;
    }

    /**
     * @param mixed $qntLinhas
     */
    public function setQntLinhas($qntLinhas)
    {
        $this->qntLinhas = $qntLinhas;
    }

    /**
     * @return mixed
     */
    public function getQntColunas()
    {
        return $this->qntColunas;
    }

    /**
     * @param mixed $qntColunas
     */
    public function setQntColunas($qntColunas)
    {
        $this->qntColunas = $qntColunas;
    }



    /**
     * @return mixed
     */
    public function getQntSlotsOcupados()
    {
        return $this->qntSlotsOcupados;
    }

    /**
     * @param mixed $qntSlotsOcupados
     */
    public function setQntSlotsOcupados($qntSlotsOcupados)
    {
        $this->qntSlotsOcupados = $qntSlotsOcupados;
    }

    /**
     * @return mixed
     */
    public function getQntSlotsVazios()
    {
        return $this->qntSlotsVazios;
    }

    /**
     * @param mixed $qntSlotsVazios
     */
    public function setQntSlotsVazios($qntSlotsVazios)
    {
        $this->qntSlotsVazios = $qntSlotsVazios;
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