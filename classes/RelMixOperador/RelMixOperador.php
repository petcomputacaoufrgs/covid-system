<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class RelMixOperador
{
    private $idRelMixOperador;
    private $idOperador_fk;
    private $idMix_fk;
    private $valor;

    private $objMix;
    private $objOperador;

    /**
     * @return mixed
     */
    public function getObjMix()
    {
        return $this->objMix;
    }

    /**
     * @param mixed $objMix
     */
    public function setObjMix($objMix)
    {
        $this->objMix = $objMix;
    }

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
    public function getIdRelMixOperador()
    {
        return $this->idRelMixOperador;
    }

    /**
     * @param mixed $idRelMixOperador
     */
    public function setIdRelMixOperador($idRelMixOperador)
    {
        $this->idRelMixOperador = $idRelMixOperador;
    }

    /**
     * @return mixed
     */
    public function getIdOperadorFk()
    {
        return $this->idOperador_fk;
    }

    /**
     * @param mixed $idOperador_fk
     */
    public function setIdOperadorFk($idOperador_fk)
    {
        $this->idOperador_fk = $idOperador_fk;
    }

    /**
     * @return mixed
     */
    public function getIdMixFk()
    {
        return $this->idMix_fk;
    }

    /**
     * @param mixed $idMix_fk
     */
    public function setIdMixFk($idMix_fk)
    {
        $this->idMix_fk = $idMix_fk;
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

}