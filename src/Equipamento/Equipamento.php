<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\Equipamento;

class Equipamento
{
    private $idEquipamento;
    private $idDetentor_fk;
    private $idMarca_fk;
    private $idModelo_fk;
    private $dataUltimaCalibragem;
    private $dataChegada;
    
    
    public function __construct()
    {
    }
    
    public function getIdEquipamento()
    {
        return $this->idEquipamento;
    }

    public function getIdDetentor_fk()
    {
        return $this->idDetentor_fk;
    }

    public function getIdMarca_fk()
    {
        return $this->idMarca_fk;
    }

    public function getIdModelo_fk()
    {
        return $this->idModelo_fk;
    }

    public function getDataUltimaCalibragem()
    {
        return $this->dataUltimaCalibragem;
    }

    public function getDataChegada()
    {
        return $this->dataChegada;
    }

    public function setIdEquipamento($idEquipamento)
    {
        $this->idEquipamento = $idEquipamento;
    }

    public function setIdDetentor_fk($idDetentor_fk)
    {
        $this->idDetentor_fk = $idDetentor_fk;
    }

    public function setIdMarca_fk($idMarca_fk)
    {
        $this->idMarca_fk = $idMarca_fk;
    }

    public function setIdModelo_fk($idModelo_fk)
    {
        $this->idModelo_fk = $idModelo_fk;
    }

    public function setDataUltimaCalibragem($dataUltimaCalibragem)
    {
        $this->dataUltimaCalibragem = $dataUltimaCalibragem;
    }

    public function setDataChegada($dataChegada)
    {
        $this->dataChegada = $dataChegada;
    }
}
