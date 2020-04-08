<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class Paciente{
    private $idPaciente;
    private $idSexo_fk;
    private $idPerfilPaciente_fk;
    private $CPF;
    private $RG;
    private $nome;
    private $nomeMae;
    private $dataNascimento;
    private $obsRG;
    private $obsSexo;
    private $obsNomeMae;
    
    function __construct() {
        
    }
    
    function getIdPaciente() {
        return $this->idPaciente;
    }

    function getIdSexo_fk() {
        return $this->idSexo_fk;
    }

    function getIdPerfilPaciente_fk() {
        return $this->idPerfilPaciente_fk;
    }

    function getCPF() {
        return $this->CPF;
    }

    function getRG() {
        return $this->RG;
    }

    function getNome() {
        return $this->nome;
    }

    function getNomeMae() {
        return $this->nomeMae;
    }

    function getDataNascimento() {
        return $this->dataNascimento;
    }

    function getObsRG() {
        return $this->obsRG;
    }

    function getObsSexo() {
        return $this->obsSexo;
    }

    function getObsNomeMae() {
        return $this->obsNomeMae;
    }

    function setIdPaciente($idPaciente) {
        $this->idPaciente = $idPaciente;
    }

    function setIdSexo_fk($idSexo_fk) {
        $this->idSexo_fk = $idSexo_fk;
    }

    function setIdPerfilPaciente_fk($idPerfilPaciente_fk) {
        $this->idPerfilPaciente_fk = $idPerfilPaciente_fk;
    }

    function setCPF($CPF) {
        $this->CPF = $CPF;
    }

    function setRG($RG) {
        $this->RG = $RG;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setNomeMae($nomeMae) {
        $this->nomeMae = $nomeMae;
    }

    function setDataNascimento($dataNascimento) {
        $this->dataNascimento = $dataNascimento;
    }

    function setObsRG($obsRG) {
        $this->obsRG = $obsRG;
    }

    function setObsSexo($obsSexo) {
        $this->obsSexo = $obsSexo;
    }

    function setObsNomeMae($obsNomeMae) {
        $this->obsNomeMae = $obsNomeMae;
    }
    
}