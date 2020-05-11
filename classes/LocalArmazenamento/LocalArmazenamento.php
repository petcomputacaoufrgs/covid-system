<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class LocalArmazenamento{
    private $idLocalArmazenamento;
    private $nome;
    private $qntPortas;
    private $qntPrateleiras;
    private $qntColunas;
    private $qntCaixas;
    private $qntLinhasCaixa;
    private $qntColunasCaixa;
    private $idTipoLocalArmazenamento_fk;

    private $objTipoLocalArmazenamento;
    private $obj;
    
    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getObj()
    {
        return $this->obj;
    }

    /**
     * @param mixed $obj
     */
    public function setObj($obj)
    {
        $this->obj = $obj;
    }



    /**
     * @return mixed
     */
    public function getObjTipoLocalArmazenamento()
    {
        return $this->objTipoLocalArmazenamento;
    }

    /**
     * @param mixed $objTipoLocalArmazenamento
     */
    public function setObjTipoLocalArmazenamento($objTipoLocalArmazenamento)
    {
        $this->objTipoLocalArmazenamento = $objTipoLocalArmazenamento;
    }



    /**
     * @return mixed
     */
    public function getIdLocalArmazenamento()
    {
        return $this->idLocalArmazenamento;
    }

    /**
     * @param mixed $idLocalArmazenamento
     */
    public function setIdLocalArmazenamento($idLocalArmazenamento)
    {
        $this->idLocalArmazenamento = $idLocalArmazenamento;
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
    public function getQntPortas()
    {
        return $this->qntPortas;
    }

    /**
     * @param mixed $qntPortas
     */
    public function setQntPortas($qntPortas)
    {
        $this->qntPortas = $qntPortas;
    }

    /**
     * @return mixed
     */
    public function getQntPrateleiras()
    {
        return $this->qntPrateleiras;
    }

    /**
     * @param mixed $qntPrateleiras
     */
    public function setQntPrateleiras($qntPrateleiras)
    {
        $this->qntPrateleiras = $qntPrateleiras;
    }

    /**
     * @return mixed
     */
    public function getQntColunas()
    {
        return $this->qntColunas;
    }

    /**
     * @param mixed $qntColunas
     */
    public function setQntColunas($qntColunas)
    {
        $this->qntColunas = $qntColunas;
    }

    /**
     * @return mixed
     */
    public function getQntCaixas()
    {
        return $this->qntCaixas;
    }

    /**
     * @param mixed $qntCaixas
     */
    public function setQntCaixas($qntCaixas)
    {
        $this->qntCaixas = $qntCaixas;
    }

    /**
     * @return mixed
     */
    public function getQntLinhasCaixa()
    {
        return $this->qntLinhasCaixa;
    }

    /**
     * @param mixed $qntLinhasCaixa
     */
    public function setQntLinhasCaixa($qntLinhasCaixa)
    {
        $this->qntLinhasCaixa = $qntLinhasCaixa;
    }

    /**
     * @return mixed
     */
    public function getQntColunasCaixa()
    {
        return $this->qntColunasCaixa;
    }

    /**
     * @param mixed $qntColunasCaixa
     */
    public function setQntColunasCaixa($qntColunasCaixa)
    {
        $this->qntColunasCaixa = $qntColunasCaixa;
    }

    /**
     * @return mixed
     */
    public function getIdTipoLocalArmazenamento_fk()
    {
        return $this->idTipoLocalArmazenamento_fk;
    }

    /**
     * @param mixed $idTipoLocalArmazenamento_fk
     */
    public function setIdTipoLocalArmazenamento_fk($idTipoLocalArmazenamento_fk)
    {
        $this->idTipoLocalArmazenamento_fk = $idTipoLocalArmazenamento_fk;
    }


}