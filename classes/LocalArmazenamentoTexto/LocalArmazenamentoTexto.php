<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class LocalArmazenamentoTexto
{
    private $idLocal;
    private $nome;
    private $idTipoLocal;
    private $porta;
    private $prateleira;
    private $coluna;
    private $caixa;
    private $posicao;

    private $objInfos;
    private $objTipoLocal;

    /**
     * @return mixed
     */
    public function getObjTipoLocal()
    {
        return $this->objTipoLocal;
    }

    /**
     * @param mixed $objTipoLocal
     */
    public function setObjTipoLocal($objTipoLocal)
    {
        $this->objTipoLocal = $objTipoLocal;
    }


    /**
     * @return mixed
     */
    public function getObjInfos()
    {
        return $this->objInfos;
    }

    /**
     * @param mixed $objInfos
     */
    public function setObjInfos($objInfos)
    {
        $this->objInfos = $objInfos;
    }



    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }



    /**
     * @return mixed
     */
    public function getIdTipoLocal()
    {
        return $this->idTipoLocal;
    }

    /**
     * @param mixed $idTipoLocal
     */
    public function setIdTipoLocal($idTipoLocal)
    {
        $this->idTipoLocal = $idTipoLocal;
    }




    /**
     * @return mixed
     */
    public function getIdLocal()
    {
        return $this->idLocal;
    }

    /**
     * @param mixed $idLocal
     */
    public function setIdLocal($idLocal)
    {
        $this->idLocal = $idLocal;
    }

    /**
     * @return mixed
     */
    public function getPorta()
    {
        return $this->porta;
    }

    /**
     * @param mixed $porta
     */
    public function setPorta($porta)
    {
        $this->porta = $porta;
    }

    /**
     * @return mixed
     */
    public function getPrateleira()
    {
        return $this->prateleira;
    }

    /**
     * @param mixed $prateleira
     */
    public function setPrateleira($prateleira)
    {
        $this->prateleira = $prateleira;
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
    public function getCaixa()
    {
        return $this->caixa;
    }

    /**
     * @param mixed $caixa
     */
    public function setCaixa($caixa)
    {
        $this->caixa = $caixa;
    }

    /**
     * @return mixed
     */
    public function getPosicao()
    {
        return $this->posicao;
    }

    /**
     * @param mixed $posicao
     */
    public function setPosicao($posicao)
    {
        $this->posicao = $posicao;
    }



}