<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class SolicitacaoMontarPlaca
{
    private $idSolicitacaoMontarPlaca;
    private $idUsuario_fk;
    private $idPlaca_fk;
    private $situacaoSolicitacao;
    private $dataHoraInicio;
    private $dataHoraFim;

    private $objPlaca;
    private $objUsuario;

    private $numPagina;
    private $totalRegistros;
    private $registrosEncontrados;

    private $objsRelTuboPlaca;
    private $objsAmostras;
    private $objsPerfis;
    private $ObjRelPerfilPlaca;

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
    public function getObjRelPerfilPlaca()
    {
        return $this->ObjRelPerfilPlaca;
    }

    /**
     * @param mixed $ObjRelPerfilPlaca
     */
    public function setObjRelPerfilPlaca($ObjRelPerfilPlaca)
    {
        $this->ObjRelPerfilPlaca = $ObjRelPerfilPlaca;
    }



    /**
     * @return mixed
     */
    public function getObjsPerfis()
    {
        return $this->objsPerfis;
    }

    /**
     * @param mixed $objsPerfis
     */
    public function setObjsPerfis($objsPerfis)
    {
        $this->objsPerfis = $objsPerfis;
    }



    /**
     * @return mixed
     */
    public function getObjsAmostras()
    {
        return $this->objsAmostras;
    }

    /**
     * @param mixed $objsAmostras
     */
    public function setObjsAmostras($objsAmostras)
    {
        $this->objsAmostras = $objsAmostras;
    }



    /**
     * @return mixed
     */
    public function getObjsRelTuboPlaca()
    {
        return $this->objsRelTuboPlaca;
    }

    /**
     * @param mixed $objsRelTuboPlaca
     */
    public function setObjsRelTuboPlaca($objsRelTuboPlaca)
    {
        $this->objsRelTuboPlaca = $objsRelTuboPlaca;
    }


    /**
     * @return mixed
     */
    public function getObjPlaca()
    {
        return $this->objPlaca;
    }

    /**
     * @param mixed $objPlaca
     */
    public function setObjPlaca($objPlaca)
    {
        $this->objPlaca = $objPlaca;
    }



    /**
     * @return mixed
     */
    public function getIdSolicitacaoMontarPlaca()
    {
        return $this->idSolicitacaoMontarPlaca;
    }

    /**
     * @param mixed $idSolicitacaoMontarPlaca
     */
    public function setIdSolicitacaoMontarPlaca($idSolicitacaoMontarPlaca)
    {
        $this->idSolicitacaoMontarPlaca = $idSolicitacaoMontarPlaca;
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
    public function getIdPlacaFk()
    {
        return $this->idPlaca_fk;
    }

    /**
     * @param mixed $idPlaca_fk
     */
    public function setIdPlacaFk($idPlaca_fk)
    {
        $this->idPlaca_fk = $idPlaca_fk;
    }

    /**
     * @return mixed
     */
    public function getSituacaoSolicitacao()
    {
        return $this->situacaoSolicitacao;
    }

    /**
     * @param mixed $situacaoSolicitacao
     */
    public function setSituacaoSolicitacao($situacaoSolicitacao)
    {
        $this->situacaoSolicitacao = $situacaoSolicitacao;
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


}