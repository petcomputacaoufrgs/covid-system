<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class Operador
{
    private $idOperador;
    private $idCalculo_fk;
    private $valor;
    private $nome;

    private $objCalculo;

    /**
     * @return mixed
     */
    public function getObjCalculo()
    {
        return $this->objCalculo;
    }

    /**
     * @param mixed $objCalculo
     */
    public function setObjCalculo($objCalculo)
    {
        $this->objCalculo = $objCalculo;
    }


    /**
     * @return mixed
     */
    public function getIdOperador()
    {
        return $this->idOperador;
    }

    /**
     * @param mixed $idOperador
     */
    public function setIdOperador($idOperador)
    {
        $this->idOperador = $idOperador;
    }

    /**
     * @return mixed
     */
    public function getIdCalculoFk()
    {
        return $this->idCalculo_fk;
    }

    /**
     * @param mixed $idCalculo_fk
     */
    public function setIdCalculoFk($idCalculo_fk)
    {
        $this->idCalculo_fk = $idCalculo_fk;
    }

    /**
     * @return mixed
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param mixed $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
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