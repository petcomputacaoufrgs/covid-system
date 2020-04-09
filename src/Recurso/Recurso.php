<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\Recurso;

class Recurso
{
    private $idRecurso;
    private $nome;
    private $s_n_menu;
    
    public function __construct()
    {
    }
    
    public function getIdRecurso()
    {
        return $this->idRecurso;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function get_s_n_menu()
    {
        return $this->s_n_menu;
    }

    public function setIdRecurso($idRecurso)
    {
        $this->idRecurso = $idRecurso;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function set_s_n_menu($s_n_menu)
    {
        $this->s_n_menu = $s_n_menu;
    }
}
