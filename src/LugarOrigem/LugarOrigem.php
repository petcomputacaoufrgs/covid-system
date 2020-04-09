<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\LugarOrigem;

class LugarOrigem
{
    private $idLugarOrigem;
    private $nome;
    
    public function __construct()
    {
    }
    
    public function getIdLugarOrigem()
    {
        return $this->idLugarOrigem;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setIdLugarOrigem($idLugarOrigem)
    {
        $this->idLugarOrigem = $idLugarOrigem;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }
}
