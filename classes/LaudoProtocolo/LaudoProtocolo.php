<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class LaudoProtocolo
{
    private $idRelLaudoProtocolo;
    private $idLaudo_fk;
    private $idProtocolo_fk;

    private $objProtocolo;

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
    public function getIdRelLaudoProtocolo()
    {
        return $this->idRelLaudoProtocolo;
    }

    /**
     * @param mixed $idRelLaudoProtocolo
     */
    public function setIdRelLaudoProtocolo($idRelLaudoProtocolo)
    {
        $this->idRelLaudoProtocolo = $idRelLaudoProtocolo;
    }

    /**
     * @return mixed
     */
    public function getIdLaudoFk()
    {
        return $this->idLaudo_fk;
    }

    /**
     * @param mixed $idLaudo_fk
     */
    public function setIdLaudoFk($idLaudo_fk)
    {
        $this->idLaudo_fk = $idLaudo_fk;
    }



}