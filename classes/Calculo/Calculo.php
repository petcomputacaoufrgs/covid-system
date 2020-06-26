<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class Calculo
{
    private $idCalculo;
    private $idProtocolo_fk;
    private $nome;

    private $objProtocolo;
    private $objOperador;

    /**
     * @return mixed
     */
    public function getObjOperador()
    {
        return $this->objOperador;
    }

    /**
     * @param mixed $objOperador
     */
    public function setObjOperador($objOperador)
    {
        $this->objOperador = $objOperador;
    }



    /**
     * @return mixed
     */
    public function getObjProtocolo()
    {
        return $this->objProtocolo;
    }

    /**
     * @param mixed $objProtocolo
     */
    public function setObjProtocolo($objProtocolo)
    {
        $this->objProtocolo = $objProtocolo;
    }


    /**
     * @return mixed
     */
    public function getIdCalculo()
    {
        return $this->idCalculo;
    }

    /**
     * @param mixed $idCalculo
     */
    public function setIdCalculo($idCalculo)
    {
        $this->idCalculo = $idCalculo;
    }

    /**
     * @return mixed
     */
    public function getIdProtocoloFk()
    {
        return $this->idProtocolo_fk;
    }

    /**
     * @param mixed $idProtocolo_fk
     */
    public function setIdProtocoloFk($idProtocolo_fk)
    {
        $this->idProtocolo_fk = $idProtocolo_fk;
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


}