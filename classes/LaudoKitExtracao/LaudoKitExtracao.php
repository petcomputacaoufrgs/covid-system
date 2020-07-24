<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class LaudoKitExtracao
{
    private $idRelLaudoKitExtracao;
    private $idLaudo_fk;
    private $idKitExtracao;

    private $objKitExtracao;

    /**
     * @return mixed
     */
    public function getObjKitExtracao()
    {
        return $this->objKitExtracao;
    }

    /**
     * @param mixed $objKitExtracao
     */
    public function setObjKitExtracao($objKitExtracao)
    {
        $this->objKitExtracao = $objKitExtracao;
    }



    /**
     * @return mixed
     */
    public function getIdRelLaudoKitExtracao()
    {
        return $this->idRelLaudoKitExtracao;
    }

    /**
     * @param mixed $idRelLaudoKitExtracao
     */
    public function setIdRelLaudoKitExtracao($idRelLaudoKitExtracao)
    {
        $this->idRelLaudoKitExtracao = $idRelLaudoKitExtracao;
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

    /**
     * @return mixed
     */
    public function getIdKitExtracao()
    {
        return $this->idKitExtracao;
    }

    /**
     * @param mixed $idKitExtracao
     */
    public function setIdKitExtracao($idKitExtracao)
    {
        $this->idKitExtracao = $idKitExtracao;
    }


}