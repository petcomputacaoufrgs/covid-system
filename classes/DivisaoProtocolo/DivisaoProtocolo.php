<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */


class DivisaoProtocolo
{
    private $idDivisaoProtocolo;
    private $idProtocolo_fk;
    private $nomeDivisao;

    /**
     * @return mixed
     */
    public function getIdDivisaoProtocolo()
    {
        return $this->idDivisaoProtocolo;
    }

    /**
     * @param mixed $idDivisaoProtocolo
     */
    public function setIdDivisaoProtocolo($idDivisaoProtocolo)
    {
        $this->idDivisaoProtocolo = $idDivisaoProtocolo;
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
    public function getNomeDivisao()
    {
        return $this->nomeDivisao;
    }

    /**
     * @param mixed $nomeDivisao
     */
    public function setNomeDivisao($nomeDivisao)
    {
        $this->nomeDivisao = $nomeDivisao;
    }


}