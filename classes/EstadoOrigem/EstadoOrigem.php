<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class EstadoOrigem{
    private $cod_estado;
    private $sigla;
    private $nome;
    
    function __construct() {
        
    }
    
    function getCod_estado() {
        return $this->cod_estado;
    }

    function getSigla() {
        return $this->sigla;
    }

    function getNome() {
        return $this->nome;
    }

    function setCod_estado($cod_estado) {
        $this->cod_estado = $cod_estado;
    }

    function setSigla($sigla) {
        $this->sigla = $sigla;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }




}