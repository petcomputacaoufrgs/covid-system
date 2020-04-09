<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\Usuario\Paciente;

class Paciente
{
    private $idPaciente;
    private $idSexo_fk;
    private $idPerfilPaciente_fk;
    private $codGAL;
    private $CPF;
    private $RG;
    private $nome;
    private $nomeMae;
    private $dataNascimento;
    private $obsCPF;
    private $obsRG;
    private $obsSexo;
    private $obsNomeMae;
    
    public function __construct()
    {
    }
    
    public function getIdPaciente()
    {
        return $this->idPaciente;
    }

    public function getIdSexo_fk()
    {
        return $this->idSexo_fk;
    }

    public function getIdPerfilPaciente_fk()
    {
        return $this->idPerfilPaciente_fk;
    }

    public function getCodGAL()
    {
        return $this->codGAL;
    }

    public function getCPF()
    {
        return $this->CPF;
    }

    public function getRG()
    {
        return $this->RG;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getNomeMae()
    {
        return $this->nomeMae;
    }

    public function getDataNascimento()
    {
        return $this->dataNascimento;
    }

    public function getObsCPF()
    {
        return $this->obsCPF;
    }

    public function getObsRG()
    {
        return $this->obsRG;
    }

    public function getObsSexo()
    {
        return $this->obsSexo;
    }

    public function getObsNomeMae()
    {
        return $this->obsNomeMae;
    }

    public function setIdPaciente($idPaciente)
    {
        $this->idPaciente = $idPaciente;
    }

    public function setIdSexo_fk($idSexo_fk)
    {
        $this->idSexo_fk = $idSexo_fk;
    }

    public function setIdPerfilPaciente_fk($idPerfilPaciente_fk)
    {
        $this->idPerfilPaciente_fk = $idPerfilPaciente_fk;
    }

    public function setCodGAL($codGAL)
    {
        $this->codGAL = $codGAL;
    }

    public function setCPF($CPF)
    {
        $this->CPF = $CPF;
    }

    public function setRG($RG)
    {
        $this->RG = $RG;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setNomeMae($nomeMae)
    {
        $this->nomeMae = $nomeMae;
    }

    public function setDataNascimento($dataNascimento)
    {
        $this->dataNascimento = $dataNascimento;
    }

    public function setObsCPF($obsCPF)
    {
        $this->obsCPF = $obsCPF;
    }

    public function setObsRG($obsRG)
    {
        $this->obsRG = $obsRG;
    }

    public function setObsSexo($obsSexo)
    {
        $this->obsSexo = $obsSexo;
    }

    public function setObsNomeMae($obsNomeMae)
    {
        $this->obsNomeMae = $obsNomeMae;
    }
}
