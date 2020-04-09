<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\Amostra;

class Amostra
{
    private $idAmostra;
    private $idPaciente_fk;
    private $idEstado_fk;
    private $idLugarOrigem_fk;
    private $quantidadeTubos;
    private $observacoes;
    private $dataHoraColeta;
    private $aceita_recusa;
    
    public function __construct()
    {
    }
    
    public function getIdEstado_fk()
    {
        return $this->idEstado_fk;
    }

    public function getIdLugarOrigem_fk()
    {
        return $this->idLugarOrigem_fk;
    }

    public function setIdEstado_fk($idEstado_fk)
    {
        $this->idEstado_fk = $idEstado_fk;
    }

    public function setIdLugarOrigem_fk($idLugarOrigem_fk)
    {
        $this->idLugarOrigem_fk = $idLugarOrigem_fk;
    }

        
    public function getIdAmostra()
    {
        return $this->idAmostra;
    }

    
    public function getIdPaciente_fk()
    {
        return $this->idPaciente_fk;
    }

    public function getQuantidadeTubos()
    {
        return $this->quantidadeTubos;
    }

    public function getObservacoes()
    {
        return $this->observacoes;
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

   
    public function setIdPaciente_fk($idPaciente_fk)
    {
        $this->idPaciente_fk = $idPaciente_fk;
    }

    public function setQuantidadeTubos($quantidadeTubos)
    {
        $this->quantidadeTubos = $quantidadeTubos;
    }

    public function setObservacoes($observacoes)
    {
        $this->observacoes = $observacoes;
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
