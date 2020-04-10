<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class Recurso{
    private $idRecurso;
    private $nome;
    private $etapa;
    private $s_n_menu;
    
    function __construct() {
        
    }
    
    function getIdRecurso() {
        return $this->idRecurso;
    }

    function getNome() {
        return $this->nome;
    }

    function getEtapa() {
        return $this->etapa;
    }

    function getS_n_menu() {
        return $this->s_n_menu;
    }

    function setIdRecurso($idRecurso) {
        $this->idRecurso = $idRecurso;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEtapa($etapa) {
        $this->etapa = $etapa;
    }

    function setS_n_menu($s_n_menu) {
        $this->s_n_menu = $s_n_menu;
    }


}