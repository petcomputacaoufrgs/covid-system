<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
class Usuario{
    private $idUsuario;
    private $matricula;
    private $senha;
    
    function __construct() {
        
    }
    
    function getIdUsuario() {
        return $this->idUsuario;
    }

    function getMatricula() {
        return $this->matricula;
    }

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    function setMatricula($matricula) {
        $this->matricula = $matricula;
    }
    
    function getSenha() {
        return $this->senha;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }




}