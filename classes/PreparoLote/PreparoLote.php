<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

//Corresponde a etapa 2.1
class PreparoLote
{
    private $idPreparoLote;
    private $idUsuario_fk;
    private $dataHoraInicio;
    private $dataHoraFim;
    private $idLote_fk;
    private $objLote;
    private $objPerfil;
    private $objsTubos;

    private $ObjsTubosCadastro;
    private $ObjsTubosAlterados;

    /**
     * @return mixed
     */
    public function getObjsTubosCadastro()
    {
        return $this->ObjsTubosCadastro;
    }

    /**
     * @param mixed $ObjsTubosCadastro
     */
    public function setObjsTubosCadastro($ObjsTubosCadastro)
    {
        $this->ObjsTubosCadastro = $ObjsTubosCadastro;
    }

    /**
     * @return mixed
     */
    public function getObjsTubosAlterados()
    {
        return $this->ObjsTubosAlterados;
    }

    /**
     * @param mixed $ObjsTubosAlterados
     */
    public function setObjsTubosAlterados($ObjsTubosAlterados)
    {
        $this->ObjsTubosAlterados = $ObjsTubosAlterados;
    }


    /**
     * PreparoLote constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getObjsTubos()
    {
        return $this->objsTubos;
    }

    /**
     * @param mixed $objsTubos
     */
    public function setObjsTubos($objsTubos)
    {
        $this->objsTubos = $objsTubos;
    }



    /**
     * @return mixed
     */
    public function getIdPreparoLote()
    {
        return $this->idPreparoLote;
    }

    /**
     * @param mixed $idPreparoLote
     */
    public function setIdPreparoLote($idPreparoLote)
    {
        $this->idPreparoLote = $idPreparoLote;
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
    public function getIdLoteFk()
    {
        return $this->idLote_fk;
    }

    /**
     * @param mixed $idLote_fk
     */
    public function setIdLoteFk($idLote_fk)
    {
        $this->idLote_fk = $idLote_fk;
    }


    /**
     * @return mixed
     */
    public function getObjLote()
    {
        return $this->objLote;
    }

    /**
     * @param mixed $objLote
     */
    public function setObjLote($objLote)
    {
        $this->objLote = $objLote;
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




}