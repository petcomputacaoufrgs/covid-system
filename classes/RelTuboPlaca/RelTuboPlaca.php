<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class RelTuboPlaca
{
    private $idRelTuboPlaca;
    private $idTubo_fk;
    private $idPlaca_fk;

    private $objPlaca;

    /**
     * @return mixed
     */
    public function getIdRelTuboPlaca()
    {
        return $this->idRelTuboPlaca;
    }

    /**
     * @param mixed $idRelTuboPlaca
     */
    public function setIdRelTuboPlaca($idRelTuboPlaca)
    {
        $this->idRelTuboPlaca = $idRelTuboPlaca;
    }

    /**
     * @return mixed
     */
    public function getIdTuboFk()
    {
        return $this->idTubo_fk;
    }

    /**
     * @param mixed $idTubo_fk
     */
    public function setIdTuboFk($idTubo_fk)
    {
        $this->idTubo_fk = $idTubo_fk;
    }

    /**
     * @return mixed
     */
    public function getIdPlacaFk()
    {
        return $this->idPlaca_fk;
    }

    /**
     * @param mixed $idPlaca_fk
     */
    public function setIdPlacaFk($idPlaca_fk)
    {
        $this->idPlaca_fk = $idPlaca_fk;
    }

    /**
     * @return mixed
     */
    public function getObjPlaca()
    {
        return $this->objPlaca;
    }

    /**
     * @param mixed $objPlaca
     */
    public function setObjPlaca($objPlaca)
    {
        $this->objPlaca = $objPlaca;
    }


}