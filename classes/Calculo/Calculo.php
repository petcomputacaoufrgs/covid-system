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


    public function getObjOperador()
    {
        return $this->objOperador;
    }

    public function setObjOperador($objOperador)
    {
        $this->objOperador = $objOperador;
    }

    public function getObjProtocolo()
    {
        return $this->objProtocolo;
    }

    public function setObjProtocolo($objProtocolo)
    {
        $this->objProtocolo = $objProtocolo;
    }

    public function getIdCalculo()
    {
        return $this->idCalculo;
    }

    public function setIdCalculo($idCalculo)
    {
        $this->idCalculo = $idCalculo;
    }

    public function getIdProtocoloFk()
    {
        return $this->idProtocolo_fk;
    }

    public function setIdProtocoloFk($idProtocolo_fk)
    {
        $this->idProtocolo_fk = $idProtocolo_fk;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }
}
