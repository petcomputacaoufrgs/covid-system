<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class PreparoLote
{
    private $idPreparoLote;
    private $idUsuario_fk;
    private $dataHoraInicio;
    private $dataHoraFim;
    private $idLote_fk;
    private $idCapela_fk;
    private $idPreparoLote_fk;
    private $idKitExtracao_fk;
    private $obsKitExtracao;
    private $loteFabricacaokitExtracao;
    private $nomeResponsavel;
    private $idResponsavel;

    private $numPagina;
    private $totalRegistros;
    private $registrosEncontrados;

    private $objLote;
    private $objCapela;
    private $objUsuario;
    private $objKitExtracao;


    private $objLoteOriginal;
    private $objPerfil;
    private $objsTubos;

    private $ObjsTubosCadastro;
    private $ObjsTubosAlterados;
    private $extracao_invalida;

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
    public function getObjKitExtracao()
    {
        return $this->objKitExtracao;
    }

    /**
     * @param mixed $objKitExtracao
     */
    public function setObjKitExtracao($objKitExtracao)
    {
        $this->objKitExtracao = $objKitExtracao;
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
    public function getIdResponsavel()
    {
        return $this->idResponsavel;
    }

    /**
     * @param mixed $idResponsavel
     */
    public function setIdResponsavel($idResponsavel)
    {
        $this->idResponsavel = $idResponsavel;
    }



    /**
     * @return mixed
     */
    public function getNomeResponsavel()
    {
        return $this->nomeResponsavel;
    }

    /**
     * @param mixed $nomeResponsavel
     */
    public function setNomeResponsavel($nomeResponsavel)
    {
        $this->nomeResponsavel = $nomeResponsavel;
    }



    /**
     * @return mixed
     */
    public function getExtracaoInvalida()
    {
        return $this->extracao_invalida;
    }

    /**
     * @param mixed $extracao_invalida
     */
    public function setExtracaoInvalida($extracao_invalida)
    {
        $this->extracao_invalida = $extracao_invalida;
    }



    /**
     * @return mixed
     */
    public function getObjCapela()
    {
        return $this->objCapela;
    }

    /**
     * @param mixed $objCapela
     */
    public function setObjCapela($objCapela)
    {
        $this->objCapela = $objCapela;
    }



    /**
     * @return mixed
     */
    public function getObsKitExtracao()
    {
        return $this->obsKitExtracao;
    }

    /**
     * @param mixed $obsKitExtracao
     */
    public function setObsKitExtracao($obsKitExtracao)
    {
        $this->obsKitExtracao = $obsKitExtracao;
    }

    /**
     * @return mixed
     */
    public function getLoteFabricacaokitExtracao()
    {
        return $this->loteFabricacaokitExtracao;
    }

    /**
     * @param mixed $loteFabricacaokitExtracao
     */
    public function setLoteFabricacaokitExtracao($loteFabricacaokitExtracao)
    {
        $this->loteFabricacaokitExtracao = $loteFabricacaokitExtracao;
    }




    /**
     * @return mixed
     */
    public function getObjLoteOriginal()
    {
        return $this->objLoteOriginal;
    }

    /**
     * @param mixed $objLoteOriginal
     */
    public function setObjLoteOriginal($objLoteOriginal)
    {
        $this->objLoteOriginal = $objLoteOriginal;
    }



    /**
     * @return mixed
     */
    public function getIdKitExtracaoFk()
    {
        return $this->idKitExtracao_fk;
    }

    /**
     * @param mixed $idKitExtracao_fk
     */
    public function setIdKitExtracaoFk($idKitExtracao_fk)
    {
        $this->idKitExtracao_fk = $idKitExtracao_fk;
    }



    /**
     * @return mixed
     */
    public function getIdCapelaFk()
    {
        return $this->idCapela_fk;
    }

    /**
     * @param mixed $idCapela_fk
     */
    public function setIdCapelaFk($idCapela_fk)
    {
        $this->idCapela_fk = $idCapela_fk;
    }

    /**
     * @return mixed
     */
    public function getIdPreparoLoteFk()
    {
        return $this->idPreparoLote_fk;
    }

    /**
     * @param mixed $idPreparoLote_fk
     */
    public function setIdPreparoLoteFk($idPreparoLote_fk)
    {
        $this->idPreparoLote_fk = $idPreparoLote_fk;
    }



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