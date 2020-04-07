<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class LugarOrigem{
    private $idLugarOrigem;
    private $nome;
    
    function __construct() {
        
    }
    
    function getIdLugarOrigem() {
        return $this->idLugarOrigem;
    }

    function getNome() {
        return $this->nome;
    }

    function setIdLugarOrigem($idLugarOrigem) {
        $this->idLugarOrigem = $idLugarOrigem;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }





}