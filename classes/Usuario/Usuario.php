<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
class Usuario{
    private $idUsuario;
    private $matricula;
    private $senha;
    private $CPF;

    private $numPagina;
    private $totalRegistros;
    private $registrosEncontrados;

    /**
     * @return mixed
     */
    public function getCPF()
    {
        return $this->CPF;
    }

    /**
     * @param mixed $CPF
     */
    public function setCPF($CPF)
    {
        $this->CPF = $CPF;
    }



    /**
     * @return mixed
     */
    public function getNumPagina()
    {
        return $this->numPagina;
    }

    /**
     * @param mixed $numPagina
     */
    public function setNumPagina($numPagina)
    {
        $this->numPagina = $numPagina;
    }

    /**
     * @return mixed
     */
    public function getTotalRegistros()
    {
        return $this->totalRegistros;
    }

    /**
     * @param mixed $totalRegistros
     */
    public function setTotalRegistros($totalRegistros)
    {
        $this->totalRegistros = $totalRegistros;
    }

    /**
     * @return mixed
     */
    public function getRegistrosEncontrados()
    {
        return $this->registrosEncontrados;
    }

    /**
     * @param mixed $registrosEncontrados
     */
    public function setRegistrosEncontrados($registrosEncontrados)
    {
        $this->registrosEncontrados = $registrosEncontrados;
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