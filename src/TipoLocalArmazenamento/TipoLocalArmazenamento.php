<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\TipoLocalArmazenamento;

class TipoLocalArmazenamento
{
    private $idTipoLocalArmazenamento;
    private $nomeLocal;
    private $qntEspacosTotal;
    private $qntEspacosAmostra;
    
    public function __construct()
    {
    }
    
    public function getIdTipoLocalArmazenamento()
    {
        return $this->idTipoLocalArmazenamento;
    }

    public function getNomeLocal()
    {
        return $this->nomeLocal;
    }

    public function getQntEspacosTotal()
    {
        return $this->qntEspacosTotal;
    }

    public function getQntEspacosAmostra()
    {
        return $this->qntEspacosAmostra;
    }

    public function setIdTipoLocalArmazenamento($idTipoLocalArmazenamento)
    {
        $this->idTipoLocalArmazenamento = $idTipoLocalArmazenamento;
    }

    public function setNomeLocal($nomeLocal)
    {
        $this->nomeLocal = $nomeLocal;
    }

    public function setQntEspacosTotal($qntEspacosTotal)
    {
        $this->qntEspacosTotal = $qntEspacosTotal;
    }

    public function setQntEspacosAmostra($qntEspacosAmostra)
    {
        $this->qntEspacosAmostra = $qntEspacosAmostra;
    }
}
