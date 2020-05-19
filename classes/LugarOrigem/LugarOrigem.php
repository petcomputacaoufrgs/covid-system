<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class LugarOrigem{
    private $idLugarOrigem;
    private $nome;
    private $cod_estado;

    private $objEstado;

    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getObjEstado()
    {
        return $this->objEstado;
    }

    /**
     * @param mixed $objEstado
     */
    public function setObjEstado($objEstado)
    {
        $this->objEstado = $objEstado;
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
    
    function getCod_estado() {
        return $this->cod_estado;
    }

    function setCod_estado($cod_estado) {
        $this->cod_estado = $cod_estado;
    }






}