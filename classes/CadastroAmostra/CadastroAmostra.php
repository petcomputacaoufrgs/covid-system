<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
class CadastroAmostra{
    private $idCadastroAmostra;
    private $idUsuario_fk;
    private $idAmostra_fk;
    private $idLocalArmazenamento_fk;
    private $dataHoraInicio;
    private $dataHoraFim;

    private $numPagina;
    private $totalRegistros;
    private $registrosEncontrados;

    private $objAmostra;
    private $objUsuario;

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
    public function getObjUsuario()
    {
        return $this->objUsuario;
    }

    /**
     * @param mixed $objUsuario
     */
    public function setObjUsuario($objUsuario)
    {
        $this->objUsuario = $objUsuario;
    }


    
    function getObjAmostra() {
        return $this->objAmostra;
    }

    function setObjAmostra($objAmostra) {
        $this->objAmostra = $objAmostra;
    }

        
    function getIdCadastroAmostra() {
        return $this->idCadastroAmostra;
    }

    function setIdCadastroAmostra($idCadastroAmostra) {
        $this->idCadastroAmostra = $idCadastroAmostra;
    }

        
    function getIdUsuario_fk() {
        return $this->idUsuario_fk;
    }

    function getIdAmostra_fk() {
        return $this->idAmostra_fk;
    }

    function getIdLocalArmazenamento_fk() {
        return $this->idLocalArmazenamento_fk;
    }

    function getDataHoraInicio() {
        return $this->dataHoraInicio;
    }

    function getDataHoraFim() {
        return $this->dataHoraFim;
    }

    function setIdUsuario_fk($idUsuario_fk) {
        $this->idUsuario_fk = $idUsuario_fk;
    }

    function setIdAmostra_fk($idAmostra_fk) {
        $this->idAmostra_fk = $idAmostra_fk;
    }

    function setIdLocalArmazenamento_fk($idLocalArmazenamento_fk) {
        $this->idLocalArmazenamento_fk = $idLocalArmazenamento_fk;
    }

    function setDataHoraInicio($dataHoraInicio) {
        $this->dataHoraInicio = $dataHoraInicio;
    }

    function setDataHoraFim($dataHoraFim) {
        $this->dataHoraFim = $dataHoraFim;
    }


}