<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class Protocolo
{
    private $idProtocolo;
    private $protocolo;
    private $index_protocolo;
    private $numMax_amostras;
    private $caractere;
    private $numDivisoes;

    /**
     * @return mixed
     */
    public function getNumDivisoes()
    {
        return $this->numDivisoes;
    }

    /**
     * @param mixed $numDivisoes
     */
    public function setNumDivisoes($numDivisoes)
    {
        $this->numDivisoes = $numDivisoes;
    }




    /**
     * @return mixed
     */
    public function getCaractere()
    {
        return $this->caractere;
    }

    /**
     * @param mixed $caractere
     */
    public function setCaractere($caractere)
    {
        $this->caractere = $caractere;
    }



    /**
     * @return mixed
     */
    public function getIdProtocolo()
    {
        return $this->idProtocolo;
    }

    /**
     * @param mixed $idProtocolo
     */
    public function setIdProtocolo($idProtocolo)
    {
        $this->idProtocolo = $idProtocolo;
    }

    /**
     * @return mixed
     */
    public function getProtocolo()
    {
        return $this->protocolo;
    }

    /**
     * @param mixed $protocolo
     */
    public function setProtocolo($protocolo)
    {
        $this->protocolo = $protocolo;
    }

    /**
     * @return mixed
     */
    public function getIndexProtocolo()
    {
        return $this->index_protocolo;
    }

    /**
     * @param mixed $index_protocolo
     */
    public function setIndexProtocolo($index_protocolo)
    {
        $this->index_protocolo = $index_protocolo;
    }

    /**
     * @return mixed
     */
    public function getNumMaxAmostras()
    {
        return $this->numMax_amostras;
    }

    /**
     * @param mixed $numMax_amostras
     */
    public function setNumMaxAmostras($numMax_amostras)
    {
        $this->numMax_amostras = $numMax_amostras;
    }



}