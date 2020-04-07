<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\Usuario\TipoAmostra;

class TipoAmostra
{
    private $idTipoAmostra;
    private $tipo; //amostra congelada, amostra normal...
    
    public function __construct()
    {
    }
    
    public function getIdTipoAmostra()
    {
        return $this->idTipoAmostra;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setIdTipoAmostra($idTipoAmostra)
    {
        $this->idTipoAmostra = $idTipoAmostra;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
}
