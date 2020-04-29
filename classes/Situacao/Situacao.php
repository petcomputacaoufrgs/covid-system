<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
class Situacao
{
    private $strTipo;
    private $strDescricao;

    /**
     * @return mixed
     */
    public function getStrTipo()
    {
        return $this->strTipo;
    }

    /**
     * @param mixed $strTipo
     */
    public function setStrTipo($strTipo)
    {
        $this->strTipo = $strTipo;
    }

    /**
     * @return mixed
     */
    public function getStrDescricao()
    {
        return $this->strDescricao;
    }

    /**
     * @param mixed $strDescricao
     */
    public function setStrDescricao($strDescricao)
    {
        $this->strDescricao = $strDescricao;
    }




}