<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class Paciente{
    private $idPaciente;
    private $idSexo_fk;
    private $idEtnia_fk;
    private $CPF;
    private $RG;
    private $CEP;
    private $endereco;
    private $passaporte;
    private $nome;
    private $nomeMae;
    private $dataNascimento;
    private $obsRG;
    private $obsCPF;
    private $obsCEP;
    private $obsEndereco;
    private $obsPassaporte;
    private $obsNomeMae;
    private $cadastroPendente;
    
    
    function __construct() {
        
    }
    function getIdPaciente() {
        return $this->idPaciente;
    }

    function getIdSexo_fk() {
        return $this->idSexo_fk;
    }

    function getIdEtnia_fk() {
        return $this->idEtnia_fk;
    }

    function getCPF() {
        return $this->CPF;
    }

    function getRG() {
        return $this->RG;
    }

    function getCEP() {
        return $this->CEP;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getPassaporte() {
        return $this->passaporte;
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

    function getObsCPF() {
        return $this->obsCPF;
    }

    function getObsCEP() {
        return $this->obsCEP;
    }

    function getObsEndereco() {
        return $this->obsEndereco;
    }

    function getObsPassaporte() {
        return $this->obsPassaporte;
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

    function setIdEtnia_fk($idEtnia_fk) {
        $this->idEtnia_fk = $idEtnia_fk;
    }

    function setCPF($CPF) {
        $this->CPF = $CPF;
    }

    function setRG($RG) {
        $this->RG = $RG;
    }

    function setCEP($CEP) {
        $this->CEP = $CEP;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function setPassaporte($passaporte) {
        $this->passaporte = $passaporte;
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

    function setObsCPF($obsCPF) {
        $this->obsCPF = $obsCPF;
    }

    function setObsCEP($obsCEP) {
        $this->obsCEP = $obsCEP;
    }

    function setObsEndereco($obsEndereco) {
        $this->obsEndereco = $obsEndereco;
    }

    function setObsPassaporte($obsPassaporte) {
        $this->obsPassaporte = $obsPassaporte;
    }

    function setObsNomeMae($obsNomeMae) {
        $this->obsNomeMae = $obsNomeMae;
    }
    
    function getCadastroPendente() {
        return $this->cadastroPendente;
    }

    function setCadastroPendente($cadastroPendente) {
        $this->cadastroPendente = $cadastroPendente;
    }




}