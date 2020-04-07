<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\EstadoOrigem;

class EstadoOrigem
{
    private $cod_estado;
    private $sigla;
    private $nome;
    
    public function __construct()
    {
    }
    
    public function getCod_estado()
    {
        return $this->cod_estado;
    }

    public function getSigla()
    {
        return $this->sigla;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setCod_estado($cod_estado)
    {
        $this->cod_estado = $cod_estado;
    }

    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }
}
