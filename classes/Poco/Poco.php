<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */


class Poco
{
    private $idPoco;
    private $linha;
    private $coluna;
    private $situacao;
    private $idTubo_fk;
    private $conteudo;


    private $objPlaca;
    private $objTubo;

    /**
     * @return mixed
     */
    public function getObjTubo()
    {
        return $this->objTubo;
    }

    /**
     * @param mixed $objTubo
     */
    public function setObjTubo($objTubo)
    {
        $this->objTubo = $objTubo;
    }



    /**
     * @return mixed
     */
    public function getConteudo()
    {
        return $this->conteudo;
    }

    /**
     * @param mixed $conteudo
     */
    public function setConteudo($conteudo)
    {
        $this->conteudo = $conteudo;
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
    public function getIdPoco()
    {
        return $this->idPoco;
    }

    /**
     * @param mixed $idPoco
     */
    public function setIdPoco($idPoco)
    {
        $this->idPoco = $idPoco;
    }

    /**
     * @return mixed
     */
    public function getLinha()
    {
        return $this->linha;
    }

    /**
     * @param mixed $linha
     */
    public function setLinha($linha)
    {
        $this->linha = $linha;
    }

    /**
     * @return mixed
     */
    public function getColuna()
    {
        return $this->coluna;
    }

    /**
     * @param mixed $coluna
     */
    public function setColuna($coluna)
    {
        $this->coluna = $coluna;
    }

    /**
     * @return mixed
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * @param mixed $situacao
     */
    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
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


}