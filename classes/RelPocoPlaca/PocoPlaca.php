<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class PocoPlaca
{
    private $idPocosPlaca;
    private $idPlaca_fk;
    private $idPoco_fk;

    /**
     * @return mixed
     */
    public function getIdPocosPlaca()
    {
        return $this->idPocosPlaca;
    }

    /**
     * @param mixed $idPocosPlaca
     */
    public function setIdPocosPlaca($idPocosPlaca)
    {
        $this->idPocosPlaca = $idPocosPlaca;
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
    public function getIdPocoFk()
    {
        return $this->idPoco_fk;
    }

    /**
     * @param mixed $idPoco_fk
     */
    public function setIdPocoFk($idPoco_fk)
    {
        $this->idPoco_fk = $idPoco_fk;
    }


}