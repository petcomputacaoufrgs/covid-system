<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class Amostra{
    private $idAmostra;
    private $codigoAmostra; //letra + idAmostra
    private $idPerfilPaciente_fk;
    private $idEstado_fk;
    private $idPaciente_fk;
    private $idLugarOrigem_fk;
    private $idCodGAL_fk;
    private $idNivelPrioridade_fk;
    private $observacoes;
    private $dataColeta;
    private $horaColeta;
    private $a_r_g;
    private $obsHoraColeta;
    private $obsMotivo;
    private $obsLugarOrigem;
    private $obsCEP;
    private $CEP;
    private $motivoExame;
    private $nickname;

    private $numPagina;
    private $totalRegistros;
    private $registrosEncontrados;
    
    private $objPaciente;
    private $objPerfil;


    private $objRTqPCR;
    private $objTubo;
    private $idsAmostras;
    private $objLaudo;
    private $objProtocolo;
    private $objLote;
    private $objMunicipio;
    private $objEstado;

    /**
     * @return mixed
     */
    public function getObjRTqPCR()
    {
        return $this->objRTqPCR;
    }

    /**
     * @param mixed $objRTqPCR
     */
    public function setObjRTqPCR($objRTqPCR)
    {
        $this->objRTqPCR = $objRTqPCR;
    }



    /**
     * @return mixed
     */
    public function getObjMunicipio()
    {
        return $this->objMunicipio;
    }

    /**
     * @param mixed $objMunicipio
     */
    public function setObjMunicipio($objMunicipio)
    {
        $this->objMunicipio = $objMunicipio;
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



    function __construct() {
        
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
    public function getObjLote()
    {
        return $this->objLote;
    }/**
     * @param mixed $objLote
     */
    public function setObjLote($objLote)
    {
        $this->objLote = $objLote;
    }



    /**
     * @return mixed
     */
    public function getObjProtocolo()
    {
        return $this->objProtocolo;
    }

    /**
     * @param mixed $objProtocolo
     */
    public function setObjProtocolo($objProtocolo)
    {
        $this->objProtocolo = $objProtocolo;
    }



    /**
     * @return mixed
     */
    public function getObjPerfil()
    {
        return $this->objPerfil;
    }

    /**
     * @param mixed $objPerfil
     */
    public function setObjPerfil($objPerfil)
    {
        $this->objPerfil = $objPerfil;
    }



    /**
     * @return mixed
     */
    public function getObjLaudo()
    {
        return $this->objLaudo;
    }

    /**
     * @param mixed $objLaudo
     */
    public function setObjLaudo($objLaudo)
    {
        $this->objLaudo = $objLaudo;
    }



    /**
     * @return mixed
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param mixed $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }



    /**
     * @return mixed
     */
    public function getIdsAmostras()
    {
        return $this->idsAmostras;
    }

    /**
     * @param mixed $idsAmostras
     */
    public function setIdsAmostras($idsAmostras)
    {
        $this->idsAmostras = $idsAmostras;
    }


    
    function getObjTubo() {
        return $this->objTubo;
    }

    function setObjTubo($objTubo) {
        $this->objTubo = $objTubo;
    }

        
    function getObjPaciente() {
        return $this->objPaciente;
    }

    function setObjPaciente($objPaciente) {
        $this->objPaciente = $objPaciente;
    }

        
    function getIdPaciente_fk() {
        return $this->idPaciente_fk;
    }

    function setIdPaciente_fk($idPaciente_fk) {
        $this->idPaciente_fk = $idPaciente_fk;
    }

        
    function getHoraColeta() {
        return $this->horaColeta;
    }

    function setHoraColeta($horaColeta) {
        $this->horaColeta = $horaColeta;
    }

        function getIdAmostra() {
        return $this->idAmostra;
    }

    function getCodigoAmostra() {
        return $this->codigoAmostra;
    }

    function getIdPerfilPaciente_fk() {
        return $this->idPerfilPaciente_fk;
    }

    function getIdEstado_fk() {
        return $this->idEstado_fk;
    }

    function getIdLugarOrigem_fk() {
        return $this->idLugarOrigem_fk;
    }

    function getIdCodGAL_fk() {
        return $this->idCodGAL_fk;
    }

    function getIdNivelPrioridade_fk() {
        return $this->idNivelPrioridade_fk;
    }

    function getObservacoes() {
        return $this->observacoes;
    }

    function getDataColeta() {
        return $this->dataColeta;
    }

    function get_a_r_g() {
        return $this->a_r_g;
    }


    function getCEP() {
        return $this->CEP;
    }

    function getMotivoExame() {
        return $this->motivoExame;
    }

    function setIdAmostra($idAmostra) {
        $this->idAmostra = $idAmostra;
    }

    function setCodigoAmostra($codigoAmostra) {
        $this->codigoAmostra = $codigoAmostra;
    }

    function setIdPerfilPaciente_fk($idPerfilPaciente_fk) {
        $this->idPerfilPaciente_fk = $idPerfilPaciente_fk;
    }

    function setIdEstado_fk($idEstado_fk) {
        $this->idEstado_fk = $idEstado_fk;
    }

    function setIdLugarOrigem_fk($idLugarOrigem_fk) {
        $this->idLugarOrigem_fk = $idLugarOrigem_fk;
    }

    function setIdCodGAL_fk($idCodGAL_fk) {
        $this->idCodGAL_fk = $idCodGAL_fk;
    }

    function setIdNivelPrioridade_fk($idNivelPrioridade_fk) {
        $this->idNivelPrioridade_fk = $idNivelPrioridade_fk;
    }

    function setObservacoes($observacoes) {
        $this->observacoes = $observacoes;
    }

    function setDataColeta($dataColeta) {
        $this->dataColeta = $dataColeta;
    }

    function set_a_r_g($a_r_g) {
        $this->a_r_g = $a_r_g;
    }

   
    function setCEP($CEP) {
        $this->CEP = $CEP;
    }

    function setMotivoExame($motivoExame) {
        $this->motivoExame = $motivoExame;
    }
    
    function getObsHoraColeta() {
        return $this->obsHoraColeta;
    }

    function getObsMotivo() {
        return $this->obsMotivo;
    }

    function getObsLugarOrigem() {
        return $this->obsLugarOrigem;
    }

    function getObsCEP() {
        return $this->obsCEP;
    }

    function setObsHoraColeta($obsHoraColeta) {
        $this->obsHoraColeta = $obsHoraColeta;
    }

    function setObsMotivo($obsMotivo) {
        $this->obsMotivo = $obsMotivo;
    }

    function setObsLugarOrigem($obsLugarOrigem) {
        $this->obsLugarOrigem = $obsLugarOrigem;
    }

    function setObsCEP($obsCEP) {
        $this->obsCEP = $obsCEP;
    }



}