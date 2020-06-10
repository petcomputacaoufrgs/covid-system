<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class Equipamento{
    private $idEquipamento;
    private $nomeEquipamento;
    private $situacaoEquipamento;
    private $idDetentor_fk;
    private $idMarca_fk;
    private $idModelo_fk;
    private $dataUltimaCalibragem;
    private $dataChegada;
    private $idUsuario_fk;
    private $dataCadastro;
    private $horas;
    private $minutos;

    private $numPagina;
    private $totalRegistros;
    private $registrosEncontrados;

    private $objDetentor;
    private $objModelo;
    private $objMarca;
    
    
    function __construct() {
    }

    /**
     * @return mixed
     */
    public function getHoras()
    {
        return $this->horas;
    }

    /**
     * @param mixed $horas
     */
    public function setHoras($horas)
    {
        $this->horas = $horas;
    }

    /**
     * @return mixed
     */
    public function getMinutos()
    {
        return $this->minutos;
    }

    /**
     * @param mixed $minutos
     */
    public function setMinutos($minutos)
    {
        $this->minutos = $minutos;
    }


    /**
     * @return mixed
     */
    public function getIdUsuarioFk()
    {
        return $this->idUsuario_fk;
    }

    /**
     * @param mixed $idUsuario_fk
     */
    public function setIdUsuarioFk($idUsuario_fk)
    {
        $this->idUsuario_fk = $idUsuario_fk;
    }

    /**
     * @return mixed
     */
    public function getDataCadastro()
    {
        return $this->dataCadastro;
    }

    /**
     * @param mixed $dataCadastro
     */
    public function setDataCadastro($dataCadastro)
    {
        $this->dataCadastro = $dataCadastro;
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


    /**
     * @return mixed
     */
    public function getObjDetentor()
    {
        return $this->objDetentor;
    }

    /**
     * @param mixed $objDetentor
     */
    public function setObjDetentor($objDetentor)
    {
        $this->objDetentor = $objDetentor;
    }

    /**
     * @return mixed
     */
    public function getObjModelo()
    {
        return $this->objModelo;
    }

    /**
     * @param mixed $objModelo
     */
    public function setObjModelo($objModelo)
    {
        $this->objModelo = $objModelo;
    }

    /**
     * @return mixed
     */
    public function getObjMarca()
    {
        return $this->objMarca;
    }

    /**
     * @param mixed $objMarca
     */
    public function setObjMarca($objMarca)
    {
        $this->objMarca = $objMarca;
    }


    /**
     * @return mixed
     */
    public function getSituacaoEquipamento()
    {
        return $this->situacaoEquipamento;
    }

    /**
     * @param mixed $situacaoEquipamento
     */
    public function setSituacaoEquipamento($situacaoEquipamento)
    {
        $this->situacaoEquipamento = $situacaoEquipamento;
    }



    /**
     * @return mixed
     */
    public function getNomeEquipamento()
    {
        return $this->nomeEquipamento;
    }/**
     * @param mixed $nomeEquipamento
     */
    public function setNomeEquipamento($nomeEquipamento)
    {
        $this->nomeEquipamento = $nomeEquipamento;
    }
    
    function getIdEquipamento() {
        return $this->idEquipamento;
    }

    function getIdDetentor_fk() {
        return $this->idDetentor_fk;
    }

    function getIdMarca_fk() {
        return $this->idMarca_fk;
    }

    function getIdModelo_fk() {
        return $this->idModelo_fk;
    }

    function getDataUltimaCalibragem() {
        return $this->dataUltimaCalibragem;
    }

    function getDataChegada() {
        return $this->dataChegada;
    }

    function setIdEquipamento($idEquipamento) {
        $this->idEquipamento = $idEquipamento;
    }

    function setIdDetentor_fk($idDetentor_fk) {
        $this->idDetentor_fk = $idDetentor_fk;
    }

    function setIdMarca_fk($idMarca_fk) {
        $this->idMarca_fk = $idMarca_fk;
    }

    function setIdModelo_fk($idModelo_fk) {
        $this->idModelo_fk = $idModelo_fk;
    }

    function setDataUltimaCalibragem($dataUltimaCalibragem) {
        $this->dataUltimaCalibragem = $dataUltimaCalibragem;
    }

    function setDataChegada($dataChegada) {
        $this->dataChegada = $dataChegada;
    }



}