<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class RelPerfilPlaca
{
    private $idRelPerfilPlaca;
    private $idPerfil_fk;
    private $idPlaca_fk;

    private $objPerfis;
    private $objPlaca;

    /**
     * @return mixed
     */
    public function getObjPerfis()
    {
        return $this->objPerfis;
    }

    /**
     * @param mixed $objPerfis
     */
    public function setObjPerfis($objPerfis)
    {
        $this->objPerfis = $objPerfis;
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



    /**
     * @return mixed
     */
    public function getIdRelPerfilPlaca()
    {
        return $this->idRelPerfilPlaca;
    }

    /**
     * @param mixed $idRelPerfilPlaca
     */
    public function setIdRelPerfilPlaca($idRelPerfilPlaca)
    {
        $this->idRelPerfilPlaca = $idRelPerfilPlaca;
    }

    /**
     * @return mixed
     */
    public function getIdPerfilFk()
    {
        return $this->idPerfil_fk;
    }

    /**
     * @param mixed $idPerfil_fk
     */
    public function setIdPerfilFk($idPerfil_fk)
    {
        $this->idPerfil_fk = $idPerfil_fk;
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


}