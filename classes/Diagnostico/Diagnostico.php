<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
class Diagnostico
{
    private $idDiagnostico;
    private $diagnostico;
    private $dataHoraInicio;
    private $dataHoraFim;
    private $idUsuario_fk;
    private $idAmostra_fk;
    private $observacoes;
    private $situacao;
    private $volumeRestante;
    private $reteste;

    private $numPagina;
    private $totalRegistros;
    private $registrosEncontrados;

    private $objUsuario;
    private $objAmostra;
    private $objLaudo;
    private $objInfosTubo;

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
    public function getVolumeRestante()
    {
        return $this->volumeRestante;
    }

    /**
     * @param mixed $volumeRestante
     */
    public function setVolumeRestante($volumeRestante)
    {
        $this->volumeRestante = $volumeRestante;
    }

    /**
     * @return mixed
     */
    public function getReteste()
    {
        return $this->reteste;
    }

    /**
     * @param mixed $reteste
     */
    public function setReteste($reteste)
    {
        $this->reteste = $reteste;
    }

    /**
     * @return mixed
     */
    public function getObjInfosTubo()
    {
        return $this->objInfosTubo;
    }

    /**
     * @param mixed $objInfosTubo
     */
    public function setObjInfosTubo($objInfosTubo)
    {
        $this->objInfosTubo = $objInfosTubo;
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

    /**
     * @return mixed
     */
    public function getObjAmostra()
    {
        return $this->objAmostra;
    }

    /**
     * @param mixed $objAmostra
     */
    public function setObjAmostra($objAmostra)
    {
        $this->objAmostra = $objAmostra;
    }


    /**
     * @return mixed
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * @param mixed $situacao
     */
    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
    }


    /**
     * @return mixed
     */
    public function getObservacoes()
    {
        return $this->observacoes;
    }

    /**
     * @param mixed $observacoes
     */
    public function setObservacoes($observacoes)
    {
        $this->observacoes = $observacoes;
    }


    /**
     * @return mixed
     */
    public function getIdDiagnostico()
    {
        return $this->idDiagnostico;
    }

    /**
     * @param mixed $idDiagnostico
     */
    public function setIdDiagnostico($idDiagnostico)
    {
        $this->idDiagnostico = $idDiagnostico;
    }

    /**
     * @return mixed
     */
    public function getDiagnostico()
    {
        return $this->diagnostico;
    }

    /**
     * @param mixed $diagnostico
     */
    public function setDiagnostico($diagnostico)
    {
        $this->diagnostico = $diagnostico;
    }

    /**
     * @return mixed
     */
    public function getDataHoraInicio()
    {
        return $this->dataHoraInicio;
    }

    /**
     * @param mixed $dataHoraInicio
     */
    public function setDataHoraInicio($dataHoraInicio)
    {
        $this->dataHoraInicio = $dataHoraInicio;
    }

    /**
     * @return mixed
     */
    public function getDataHoraFim()
    {
        return $this->dataHoraFim;
    }

    /**
     * @param mixed $dataHoraFim
     */
    public function setDataHoraFim($dataHoraFim)
    {
        $this->dataHoraFim = $dataHoraFim;
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
    public function getIdAmostraFk()
    {
        return $this->idAmostra_fk;
    }

    /**
     * @param mixed $idAmostra_fk
     */
    public function setIdAmostraFk($idAmostra_fk)
    {
        $this->idAmostra_fk = $idAmostra_fk;
    }


}