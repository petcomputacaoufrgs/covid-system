<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\Usuario\Amostra;

class Amostra
{
    private $idAmostra;
    private $idTipoAmostra_fk;
    private $idUsuario_fk;
    private $idPaciente_fk;
    private $quantidade;
    private $observacoes;
    private $dataHoraInicio;
    private $dataHoraFim;
    private $dataHoraColeta;
    private $aceita_recusa;
    
    public function __construct()
    {
    }
    public function getIdAmostra()
    {
        return $this->idAmostra;
    }

    public function getIdTipoAmostra_fk()
    {
        return $this->idTipoAmostra_fk;
    }

    public function getIdUsuario_fk()
    {
        return $this->idUsuario_fk;
    }

    public function getIdPaciente_fk()
    {
        return $this->idPaciente_fk;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }

    public function getObservacoes()
    {
        return $this->observacoes;
    }

    public function getDataHoraInicio()
    {
        return $this->dataHoraInicio;
    }

    public function getDataHoraFim()
    {
        return $this->dataHoraFim;
    }

    public function getDataHoraColeta()
    {
        return $this->dataHoraColeta;
    }

    public function getAceita_recusa()
    {
        return $this->aceita_recusa;
    }

    public function setIdAmostra($idAmostra)
    {
        $this->idAmostra = $idAmostra;
    }

    public function setIdTipoAmostra_fk($idTipoAmostra_fk)
    {
        $this->idTipoAmostra_fk = $idTipoAmostra_fk;
    }

    public function setIdUsuario_fk($idUsuario_fk)
    {
        $this->idUsuario_fk = $idUsuario_fk;
    }

    public function setIdPaciente_fk($idPaciente_fk)
    {
        $this->idPaciente_fk = $idPaciente_fk;
    }

    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
    }

    public function setObservacoes($observacoes)
    {
        $this->observacoes = $observacoes;
    }

    public function setDataHoraInicio($dataHoraInicio)
    {
        $this->dataHoraInicio = $dataHoraInicio;
    }

    public function setDataHoraFim($dataHoraFim)
    {
        $this->dataHoraFim = $dataHoraFim;
    }

    public function setDataHoraColeta($dataHoraColeta)
    {
        $this->dataHoraColeta = $dataHoraColeta;
    }

    public function setAceita_recusa($aceita_recusa)
    {
        $this->aceita_recusa = $aceita_recusa;
    }
}
