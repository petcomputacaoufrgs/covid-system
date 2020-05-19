<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class Placa
{
    private $idPlaca;
    private $idProtocolo_fk;
    private $placa;
    private $index_placa;
    private $situacaoPlaca;

    private $objProtocolo;
    private $objsAmostras;
    private $objsTubos;

    /**
     * @return mixed
     */
    public function getObjsTubos()
    {
        return $this->objsTubos;
    }

    /**
     * @param mixed $objsTubos
     */
    public function setObjsTubos($objsTubos)
    {
        $this->objsTubos = $objsTubos;
    }



    /**
     * @return mixed
     */
    public function getObjsAmostras()
    {
        return $this->objsAmostras;
    }

    /**
     * @param mixed $objsAmostras
     */
    public function setObjsAmostras($objsAmostras)
    {
        $this->objsAmostras = $objsAmostras;
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
    public function getIdPlaca()
    {
        return $this->idPlaca;
    }

    /**
     * @param mixed $idPlaca
     */
    public function setIdPlaca($idPlaca)
    {
        $this->idPlaca = $idPlaca;
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
    public function getPlaca()
    {
        return $this->placa;
    }

    /**
     * @param mixed $placa
     */
    public function setPlaca($placa)
    {
        $this->placa = $placa;
    }

    /**
     * @return mixed
     */
    public function getIndexPlaca()
    {
        return $this->index_placa;
    }

    /**
     * @param mixed $index_placa
     */
    public function setIndexPlaca($index_placa)
    {
        $this->index_placa = $index_placa;
    }

    /**
     * @return mixed
     */
    public function getSituacaoPlaca()
    {
        return $this->situacaoPlaca;
    }

    /**
     * @param mixed $situacaoPlaca
     */
    public function setSituacaoPlaca($situacaoPlaca)
    {
        $this->situacaoPlaca = $situacaoPlaca;
    }

}