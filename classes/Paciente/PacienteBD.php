<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';

require_once __DIR__.'/../../classes/CodigoGAL/CodigoGAL.php';
require_once __DIR__.'/../../classes/CodigoGAL/CodigoGAL_RN.php';

require_once __DIR__ . '/../../classes/EstadoOrigem/EstadoOrigem.php';
require_once __DIR__ . '/../../classes/EstadoOrigem/EstadoOrigemRN.php';

require_once __DIR__ . '/../../classes/LugarOrigem/LugarOrigem.php';
require_once __DIR__ . '/../../classes/LugarOrigem/LugarOrigemRN.php';

require_once __DIR__.'/../../classes/Sexo/Sexo.php';
require_once __DIR__.'/../../classes/Sexo/SexoRN.php';
require_once __DIR__.'/../../classes/Etnia/Etnia.php';
require_once __DIR__.'/../../classes/Etnia/EtniaRN.php';

class PacienteBD
{

    public function cadastrar(Paciente $objPaciente, Banco $objBanco)
    {
        try {

            $INSERT = 'INSERT INTO tb_paciente (idSexo_fk,idEtnia_fk,nome,nomeMae,dataNascimento,CPF,RG,'
                . 'obsRG,obsNomeMae,CEP,endereco,obsEndereco,obsCEP,obsCPF,passaporte,obsPassaporte,
                    cadastroPendente,cartaoSUS,obsCartaoSUS,obsDataNascimento,idMunicipio_fk,idEstado_fk,obsMunicipio,DDD,telefone,numero,complemento,bairro) '
                . ' VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i', $objPaciente->getIdSexo_fk());
            $arrayBind[] = array('i', $objPaciente->getIdEtnia_fk());
            $arrayBind[] = array('s', $objPaciente->getNome());
            $arrayBind[] = array('s', $objPaciente->getNomeMae());
            $arrayBind[] = array('s', $objPaciente->getDataNascimento());
            $arrayBind[] = array('s', $objPaciente->getCPF());
            $arrayBind[] = array('s', $objPaciente->getRG());
            $arrayBind[] = array('s', $objPaciente->getObsRG());
            $arrayBind[] = array('s', $objPaciente->getObsNomeMae());
            $arrayBind[] = array('s', $objPaciente->getCEP());
            $arrayBind[] = array('s', $objPaciente->getEndereco());
            $arrayBind[] = array('s', $objPaciente->getObsEndereco());
            $arrayBind[] = array('s', $objPaciente->getObsCEP());
            $arrayBind[] = array('s', $objPaciente->getObsCPF());
            $arrayBind[] = array('s', $objPaciente->getPassaporte());
            $arrayBind[] = array('s', $objPaciente->getObsPassaporte());
            $arrayBind[] = array('s', $objPaciente->getCadastroPendente());
            $arrayBind[] = array('s', $objPaciente->getCartaoSUS());
            $arrayBind[] = array('s', $objPaciente->getObsCartaoSUS());
            $arrayBind[] = array('s', $objPaciente->getObsDataNascimento());
            $arrayBind[] = array('i', $objPaciente->getIdMunicipioFk());
            $arrayBind[] = array('i', $objPaciente->getIdEstadoFk());
            $arrayBind[] = array('s', $objPaciente->getObsMunicipio());
            $arrayBind[] = array('s', $objPaciente->getDDD());
            $arrayBind[] = array('s', $objPaciente->getTelefone());
            $arrayBind[] = array('i', $objPaciente->getNumero());
            $arrayBind[] = array('s', $objPaciente->getComplemento());
            $arrayBind[] = array('s', $objPaciente->getBairro());


            $objBanco->executarSQL($INSERT, $arrayBind);
            $objPaciente->setIdPaciente($objBanco->obterUltimoID());
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o paciente  no BD.", $ex);
        }
    }

    public function alterar(Paciente $objPaciente, Banco $objBanco)
    {
        try {
            //print_r($objPaciente);
            $UPDATE = 'UPDATE tb_paciente SET idSexo_fk = ?,idEtnia_fk = ?, nome = ?, nomeMae = ?,dataNascimento = ?, CPF = ?,'
                . ' RG = ?, obsRG = ?, obsNomeMae = ?, CEP = ?, endereco = ?, obsEndereco = ?, obsCEP = ?, obsCPF = ?,'
                . ' passaporte = ?,obsPassaporte = ?,cadastroPendente = ? , cartaoSUS= ?, 
                        obsCartaoSUS =? ,obsDataNascimento =?, idMunicipio_fk =?, idEstado_fk =?, obsMunicipio= ?, DDD =?, telefone =?,numero=?,
                         complemento =?, bairro=? '
                . ' where idPaciente = ?';

            $arrayBind = array();
            $arrayBind[] = array('i', $objPaciente->getIdSexo_fk());
            $arrayBind[] = array('i', $objPaciente->getIdEtnia_fk());
            $arrayBind[] = array('s', $objPaciente->getNome());
            $arrayBind[] = array('s', $objPaciente->getNomeMae());
            $arrayBind[] = array('s', $objPaciente->getDataNascimento());
            $arrayBind[] = array('s', $objPaciente->getCPF());
            $arrayBind[] = array('s', $objPaciente->getRG());
            $arrayBind[] = array('s', $objPaciente->getObsRG());
            $arrayBind[] = array('s', $objPaciente->getObsNomeMae());
            $arrayBind[] = array('s', $objPaciente->getCEP());
            $arrayBind[] = array('s', $objPaciente->getEndereco());
            $arrayBind[] = array('s', $objPaciente->getObsEndereco());
            $arrayBind[] = array('s', $objPaciente->getObsCEP());
            $arrayBind[] = array('s', $objPaciente->getObsCPF());
            $arrayBind[] = array('s', $objPaciente->getPassaporte());
            $arrayBind[] = array('s', $objPaciente->getObsPassaporte());
            $arrayBind[] = array('s', $objPaciente->getCadastroPendente());
            $arrayBind[] = array('s', $objPaciente->getCartaoSUS());
            $arrayBind[] = array('s', $objPaciente->getObsCartaoSUS());
            $arrayBind[] = array('s', $objPaciente->getObsDataNascimento());
            $arrayBind[] = array('i', $objPaciente->getIdMunicipioFk());
            $arrayBind[] = array('i', $objPaciente->getIdEstadoFk());
            $arrayBind[] = array('s', $objPaciente->getObsMunicipio());
            $arrayBind[] = array('s', $objPaciente->getDDD());
            $arrayBind[] = array('s', $objPaciente->getTelefone());
            $arrayBind[] = array('i', $objPaciente->getNumero());
            $arrayBind[] = array('s', $objPaciente->getComplemento());
            $arrayBind[] = array('s', $objPaciente->getBairro());

            $arrayBind[] = array('i', $objPaciente->getIdPaciente());

            $objBanco->executarSQL($UPDATE, $arrayBind);
            return $objPaciente;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o paciente no BD.", $ex);
        }
    }

    public function listar(Paciente $objPaciente, Banco $objBanco)
    {
        try {

            //print_r($objPaciente);

            $SELECT = "SELECT * FROM tb_paciente";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objPaciente->getIdPaciente() != null) {
                $WHERE .= $AND . " idPaciente = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPaciente->getIdPaciente());
            }

            if ($objPaciente->getNome() != null) {
                $WHERE .= $AND . " nome LIKE ? ";
                $AND = ' and ';
                $arrayBind[] = array('s', "%" . $objPaciente->getNome() . "%");
            }

            if ($objPaciente->getCPF() != null) {
                $WHERE .= $AND . " CPF = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPaciente->getCPF());
            }

            if ($objPaciente->getRG() != null) {
                $WHERE .= $AND . " RG = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPaciente->getRG());
            }

            if ($objPaciente->getCartaoSUS() != null) {
                $WHERE .= $AND . " cartaoSUS = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPaciente->getCartaoSUS());
            }

            if ($objPaciente->getCadastroPendente() != null) {
                $WHERE .= $AND . " cadastroPendente = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPaciente->getCadastroPendente());
            }

            if ($objPaciente->getIdMunicipioFk() != null) {
                $WHERE .= $AND . " idMunicipio_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPaciente->getIdMunicipioFk());
            }

            if ($objPaciente->getIdEstadoFk() != null) {
                $WHERE .= $AND . " idEstado_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPaciente->getIdEstadoFk());
            }

            if ($objPaciente->getObsMunicipio() != null) {
                $WHERE .= $AND . " obsMunicipio = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPaciente->getObsMunicipio());
            }

            if ($objPaciente->getDDD() != null) {
                $WHERE .= $AND . " DDD = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPaciente->getDDD());
            }

            if ($objPaciente->getTelefone() != null) {
                $WHERE .= $AND . " telefone = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPaciente->getTelefone());
            }

            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            //echo $SELECT.$WHERE;
            //die('aqui');
            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            $array_paciente = array();
            foreach ($arr as $reg) {
                $paciente = new Paciente();
                $paciente->setIdPaciente($reg['idPaciente']);
                $paciente->setNome($reg['nome']);
                $paciente->setIdSexo_fk($reg['idSexo_fk']);
                $paciente->setIdEtnia_fk($reg['idEtnia_fk']);
                $paciente->setNomeMae($reg['nomeMae']);
                $paciente->setCPF($reg['CPF']);
                $paciente->setObsCPF($reg['CPF']);
                $paciente->setRG($reg['RG']);
                $paciente->setObsRG($reg['obsRG']);
                $paciente->setDataNascimento($reg['dataNascimento']);
                $paciente->setObsNomeMae($reg['obsNomeMae']);
                $paciente->setEndereco($reg['endereco']);
                $paciente->setCEP($reg['CEP']);
                $paciente->setPassaporte($reg['passaporte']);
                $paciente->setObsPassaporte($reg['obsPassaporte']);
                $paciente->setObsCEP($reg['obsCEP']);
                $paciente->setObsEndereco($reg['obsEndereco']);
                $paciente->setCadastroPendente($reg['cadastroPendente']);
                $paciente->setCartaoSUS($reg['cartaoSUS']);
                $paciente->setObsCartaoSUS($reg['obsCartaoSUS']);
                $paciente->setObsDataNascimento($reg['obsDataNascimento']);
                $paciente->setIdMunicipioFk($reg['idMunicipio_fk']);
                $paciente->setIdEstadoFk($reg['idEstado_fk']);
                $paciente->setObsMunicipio($reg['obsMunicipio']);
                $paciente->setDDD($reg['DDD']);
                $paciente->setTelefone($reg['telefone']);
                $paciente->setNumero($reg['numero']);
                $paciente->setComplemento($reg['complemento']);
                $paciente->setBairro($reg['bairro']);

                $array_paciente[] = $paciente;
            }
            return $array_paciente;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o paciente no BD.", $ex);
        }
    }

    public function listar_completo(Paciente $objPaciente,$numLimite=null, Banco $objBanco)
    {
        try {

            //print_r($objPaciente);

            $SELECT = "SELECT * FROM tb_paciente";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objPaciente->getIdPaciente() != null) {
                $WHERE .= $AND . " idPaciente = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPaciente->getIdPaciente());
            }

            if ($objPaciente->getNome() != null) {
                $WHERE .= $AND . " nome LIKE ? ";
                $AND = ' and ';
                $arrayBind[] = array('s', "%" . $objPaciente->getNome() . "%");
            }

            if ($objPaciente->getCPF() != null) {
                $WHERE .= $AND . " CPF = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPaciente->getCPF());
            }

            if ($objPaciente->getRG() != null) {
                $WHERE .= $AND . " RG = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPaciente->getRG());
            }

            if ($objPaciente->getCartaoSUS() != null) {
                $WHERE .= $AND . " cartaoSUS = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPaciente->getCartaoSUS());
            }

            if ($objPaciente->getCadastroPendente() != null) {
                $WHERE .= $AND . " cadastroPendente = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPaciente->getCadastroPendente());
            }

            if ($objPaciente->getIdMunicipioFk() != null) {
                $WHERE .= $AND . " idMunicipio_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPaciente->getIdMunicipioFk());
            }

            if ($objPaciente->getIdEstadoFk() != null) {
                $WHERE .= $AND . " idEstado_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPaciente->getIdEstadoFk());
            }

            if ($objPaciente->getObsMunicipio() != null) {
                $WHERE .= $AND . " obsMunicipio = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPaciente->getObsMunicipio());
            }

            if ($objPaciente->getDDD() != null) {
                $WHERE .= $AND . " DDD = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPaciente->getDDD());
            }

            if ($objPaciente->getTelefone() != null) {
                $WHERE .= $AND . " telefone = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPaciente->getTelefone());
            }

            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            //echo $SELECT.$WHERE;
            //die('aqui');
            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            $array_paciente = array();
            foreach ($arr as $reg) {
                $paciente = new Paciente();
                $paciente->setIdPaciente($reg['idPaciente']);
                $paciente->setNome($reg['nome']);
                $paciente->setIdSexo_fk($reg['idSexo_fk']);
                $paciente->setIdEtnia_fk($reg['idEtnia_fk']);
                $paciente->setNomeMae($reg['nomeMae']);
                $paciente->setCPF($reg['CPF']);
                $paciente->setObsCPF($reg['CPF']);
                $paciente->setRG($reg['RG']);
                $paciente->setObsRG($reg['obsRG']);
                $paciente->setDataNascimento($reg['dataNascimento']);
                $paciente->setObsNomeMae($reg['obsNomeMae']);
                $paciente->setEndereco($reg['endereco']);
                $paciente->setCEP($reg['CEP']);
                $paciente->setPassaporte($reg['passaporte']);
                $paciente->setObsPassaporte($reg['obsPassaporte']);
                $paciente->setObsCEP($reg['obsCEP']);
                $paciente->setObsEndereco($reg['obsEndereco']);
                $paciente->setCadastroPendente($reg['cadastroPendente']);
                $paciente->setCartaoSUS($reg['cartaoSUS']);
                $paciente->setObsCartaoSUS($reg['obsCartaoSUS']);
                $paciente->setObsDataNascimento($reg['obsDataNascimento']);
                $paciente->setIdMunicipioFk($reg['idMunicipio_fk']);
                $paciente->setIdEstadoFk($reg['idEstado_fk']);
                $paciente->setObsMunicipio($reg['obsMunicipio']);
                $paciente->setDDD($reg['DDD']);
                $paciente->setTelefone($reg['telefone']);
                $paciente->setNumero($reg['numero']);
                $paciente->setComplemento($reg['complemento']);
                $paciente->setBairro($reg['bairro']);


                if (!is_null($paciente->getIdSexo_fk())) {
                    $objSexo = new Sexo();
                    $objSexoRN = new SexoRN();
                    $objSexo->setIdSexo($paciente->getIdSexo_fk());
                    $objSexo = $objSexoRN->consultar($objSexo);
                    $paciente->setObjSexo($objSexo);

                }
                if (!is_null($paciente->getIdEtnia_fk())) {
                    $objEtnia = new Etnia();
                    $objEtniaRN = new EtniaRN();
                    $objEtnia->setIdEtnia($paciente->getIdEtnia_fk());
                    $objEtnia = $objEtniaRN->consultar($objEtnia);
                    $paciente->setObjEtnia($objEtnia);

                }

                if (!is_null($paciente->getIdEstadoFk())) {

                    $objEstado = new EstadoOrigem();
                    $objEstadoRN = new EstadoOrigemRN();
                    $objEstado->setCod_estado($paciente->getIdEstadoFk());
                    $objEstado = $objEstadoRN->consultar($objEstado);
                    $paciente->setObjEstado($objEstado);
                }

                if (!is_null($paciente->getIdMunicipioFk())) {
                    $objMunicipio = new LugarOrigem();
                    $objMunicipioRN = new LugarOrigemRN();
                    $objMunicipio->setIdLugarOrigem($paciente->getIdMunicipioFk());
                    $objMunicipio = $objMunicipioRN->consultar($objMunicipio);
                    $paciente->setObjMunicipio($objMunicipio);
                }

                $array_paciente[] = $paciente;
            }
            return $array_paciente;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o paciente no BD.", $ex);
        }
    }

    public function consultar(Paciente $objPaciente, Banco $objBanco)
    {

        try {

            $SELECT = 'SELECT * FROM tb_paciente WHERE idPaciente = ?';

            $arrayBind = array();
            $arrayBind[] = array('i', $objPaciente->getIdPaciente());

            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);

            $paciente = new Paciente();
            $paciente->setIdPaciente($arr[0]['idPaciente']);
            $paciente->setNome($arr[0]['nome']);
            $paciente->setNomeMae($arr[0]['nomeMae']);
            $paciente->setIdSexo_fk($arr[0]['idSexo_fk']);
            $paciente->setIdEtnia_fk($arr[0]['idEtnia_fk']);
            $paciente->setCPF($arr[0]['CPF']);
            $paciente->setObsCPF($arr[0]['obsCPF']);
            $paciente->setRG($arr[0]['RG']);
            $paciente->setObsRG($arr[0]['obsRG']);
            $paciente->setDataNascimento($arr[0]['dataNascimento']);
            $paciente->setObsNomeMae($arr[0]['obsNomeMae']);
            $paciente->setEndereco($arr[0]['endereco']);
            $paciente->setCEP($arr[0]['CEP']);
            $paciente->setPassaporte($arr[0]['passaporte']);
            $paciente->setObsPassaporte($arr[0]['obsPassaporte']);
            $paciente->setObsCEP($arr[0]['obsCEP']);
            $paciente->setObsEndereco($arr[0]['obsEndereco']);
            $paciente->setCadastroPendente($arr[0]['cadastroPendente']);
            $paciente->setCartaoSUS($arr[0]['cartaoSUS']);
            $paciente->setObsCartaoSUS($arr[0]['obsCartaoSUS']);
            $paciente->setObsDataNascimento($arr[0]['obsDataNascimento']);
            $paciente->setIdMunicipioFk($arr[0]['idMunicipio_fk']);
            $paciente->setIdEstadoFk($arr[0]['idEstado_fk']);
            $paciente->setObsMunicipio($arr[0]['obsMunicipio']);
            $paciente->setDDD($arr[0]['DDD']);
            $paciente->setTelefone($arr[0]['telefone']);
            $paciente->setNumero($arr[0]['numero']);
            $paciente->setComplemento($arr[0]['complemento']);
            $paciente->setBairro($arr[0]['bairro']);

            return $paciente;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando o paciente no BD.", $ex);
        }
    }

    public function remover(Paciente $objPaciente, Banco $objBanco)
    {

        try {

            $DELETE = 'DELETE FROM tb_paciente WHERE idPaciente = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i', $objPaciente->getIdPaciente());
            $objBanco->executarSQL($DELETE, $arrayBind);
        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o paciente no BD.", $ex);
        }
    }

    public function procurar(Paciente $objPaciente, Banco $objBanco)
    {

        try {

            // print_r($objPaciente);
            $SELECT = 'SELECT * from tb_paciente ';
            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objPaciente->getIdPaciente() != null) {
                $WHERE .= $AND . " idPaciente = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPaciente->getIdPaciente());
            }

            if ($objPaciente->getNome() != null) {
                $WHERE .= $AND . " nome = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPaciente->getNome());
            }

            if ($objPaciente->getCPF() != null) {
                //echo $objPaciente->getCPF();
                $WHERE .= $AND . " CPF = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPaciente->getCPF());
            }

            if ($objPaciente->getRG() != null) {
                $WHERE .= $AND . " RG = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPaciente->getRG());
            }

            if ($objPaciente->getPassaporte() != null) {
                $WHERE .= $AND . " passaporte = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPaciente->getPassaporte());
            }

            if ($objPaciente->getIdMunicipioFk() != null) {
                $WHERE .= $AND . " idMunicipio_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPaciente->getIdMunicipioFk());
            }

            if ($objPaciente->getIdEstadoFk() != null) {
                $WHERE .= $AND . " idEstado_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPaciente->getIdEstadoFk());
            }

            if ($objPaciente->getObsMunicipio() != null) {
                $WHERE .= $AND . " obsMunicipio = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPaciente->getObsMunicipio());
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            //echo $SELECT.$WHERE;$WHERE

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            if (empty($arr)) {
                return $arr;
            }
            $arr_pacientes = array();

            foreach ($arr as $reg) {
                $paciente = new Paciente();
                $paciente->setIdPaciente($reg['idPaciente']);
                $paciente->setNome($reg['nome']);
                $paciente->setIdSexo_fk($reg['idSexo_fk']);
                $paciente->setIdEtnia_fk($reg['idEtnia_fk']);
                $paciente->setNomeMae($reg['nomeMae']);
                $paciente->setCPF($reg['CPF']);
                $paciente->setObsCPF($reg['CPF']);
                $paciente->setRG($reg['RG']);
                $paciente->setObsRG($reg['obsRG']);
                $paciente->setDataNascimento($reg['dataNascimento']);
                $paciente->setObsNomeMae($reg['obsNomeMae']);
                $paciente->setEndereco($reg['endereco']);
                $paciente->setCEP($reg['CEP']);
                $paciente->setPassaporte($reg['passaporte']);
                $paciente->setObsPassaporte($reg['obsPassaporte']);
                $paciente->setObsCEP($reg['obsCEP']);
                $paciente->setObsEndereco($reg['obsEndereco']);
                $paciente->setCadastroPendente($reg['cadastroPendente']);
                $paciente->setCartaoSUS($reg['cartaoSUS']);
                $paciente->setObsCartaoSUS($reg['obsCartaoSUS']);
                $paciente->setObsDataNascimento($reg['obsDataNascimento']);
                $paciente->setIdMunicipioFk($reg['idMunicipio_fk']);
                $paciente->setIdEstadoFk($reg['idEstado_fk']);
                $paciente->setObsMunicipio($reg['obsMunicipio']);
                $paciente->setNumero($reg['numero']);
                $paciente->setComplemento($reg['complemento']);
                $paciente->setBairro($reg['bairro']);


                $arr_pacientes[] = $paciente;
            }
            return $arr_pacientes;
        } catch (Throwable $ex) {
            throw new Excecao("Erro pesquisando o detentor no BD.", $ex);
        }
    }

    public function procurarCPF(Paciente $objPaciente, Banco $objBanco)
    {

        try {


            $SELECT = 'SELECT * from tb_paciente where CPF = ?';

            $arrayBind = array();
            $arrayBind[] = array('s', $objPaciente->getCPF());

            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);


            if (empty($arr)) {
                return $arr;
            }
            $arr_pacientes = array();

            foreach ($arr as $reg) {
                if ($reg['idPaciente'] != $objPaciente->getIdPaciente()) {
                    if ($reg['CEP'] != null) {
                        $paciente = new Paciente();
                        $paciente->setIdPaciente($reg['idPaciente']);
                        $paciente->setNome($reg['nome']);
                        $paciente->setIdSexo_fk($reg['idSexo_fk']);
                        $paciente->setIdEtnia_fk($reg['idEtnia_fk']);
                        $paciente->setNomeMae($reg['nomeMae']);
                        $paciente->setCPF($reg['CPF']);
                        $paciente->setObsCPF($reg['CPF']);
                        $paciente->setRG($reg['RG']);
                        $paciente->setObsRG($reg['obsRG']);
                        $paciente->setDataNascimento($reg['dataNascimento']);
                        $paciente->setObsNomeMae($reg['obsNomeMae']);
                        $paciente->setEndereco($reg['endereco']);
                        $paciente->setCEP($reg['CEP']);
                        $paciente->setPassaporte($reg['passaporte']);
                        $paciente->setObsPassaporte($reg['obsPassaporte']);
                        $paciente->setObsCEP($reg['obsCEP']);
                        $paciente->setObsEndereco($reg['obsEndereco']);
                        $paciente->setCadastroPendente($reg['cadastroPendente']);
                        $paciente->setCartaoSUS($reg['cartaoSUS']);
                        $paciente->setObsCartaoSUS($reg['obsCartaoSUS']);
                        $paciente->setObsDataNascimento($reg['obsDataNascimento']);
                        $paciente->setIdMunicipioFk($reg['idMunicipio_fk']);
                        $paciente->setIdEstadoFk($reg['idEstado_fk']);
                        $paciente->setObsMunicipio($reg['obsMunicipio']);
                        $paciente->setNumero($reg['numero']);
                        $paciente->setComplemento($reg['complemento']);
                        $paciente->setBairro($reg['bairro']);


                        $arr_pacientes[] = $paciente;
                    }
                }
            }
            return $arr_pacientes;
        } catch (Throwable $ex) {
            throw new Excecao("Erro pesquisando o CPF do paciente no BD.", $ex);
        }
    }

    public function procurarRG(Paciente $objPaciente, Banco $objBanco)
    {

        try {


            $SELECT = 'SELECT * from tb_paciente where RG = ?';

            $arrayBind = array();
            $arrayBind[] = array('s', $objPaciente->getRG());

            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);

            if (empty($arr)) {
                return $arr;
            }
            $arr_pacientes = array();

            foreach ($arr as $reg) {
                if ($reg['idPaciente'] != $objPaciente->getIdPaciente()) {
                    if ($reg['RG'] != null) {
                        $paciente = new Paciente();
                        $paciente->setIdPaciente($reg['idPaciente']);
                        $paciente->setNome($reg['nome']);
                        $paciente->setIdSexo_fk($reg['idSexo_fk']);
                        $paciente->setIdEtnia_fk($reg['idEtnia_fk']);
                        $paciente->setNomeMae($reg['nomeMae']);
                        $paciente->setCPF($reg['CPF']);
                        $paciente->setObsCPF($reg['CPF']);
                        $paciente->setRG($reg['RG']);
                        $paciente->setObsRG($reg['obsRG']);
                        $paciente->setDataNascimento($reg['dataNascimento']);
                        $paciente->setObsNomeMae($reg['obsNomeMae']);
                        $paciente->setEndereco($reg['endereco']);
                        $paciente->setCEP($reg['CEP']);
                        $paciente->setPassaporte($reg['passaporte']);
                        $paciente->setObsPassaporte($reg['obsPassaporte']);
                        $paciente->setObsCEP($reg['obsCEP']);
                        $paciente->setObsEndereco($reg['obsEndereco']);
                        $paciente->setCadastroPendente($reg['cadastroPendente']);
                        $paciente->setCartaoSUS($reg['cartaoSUS']);
                        $paciente->setObsCartaoSUS($reg['obsCartaoSUS']);
                        $paciente->setObsDataNascimento($reg['obsDataNascimento']);
                        $paciente->setIdMunicipioFk($reg['idMunicipio_fk']);
                        $paciente->setIdEstadoFk($reg['idEstado_fk']);
                        $paciente->setObsMunicipio($reg['obsMunicipio']);
                        $paciente->setNumero($reg['numero']);
                        $paciente->setComplemento($reg['complemento']);
                        $paciente->setBairro($reg['bairro']);


                        $arr_pacientes[] = $paciente;
                    }
                }
            }
            return $arr_pacientes;
        } catch (Throwable $ex) {
            throw new Excecao("Erro pesquisando o RG do paciente no BD.", $ex);
        }
    }


    public function procurar_paciente(Paciente $objPaciente, Banco $objBanco)
    {
        try {
            $SELECT = 'SELECT * from tb_paciente ';
            $WHERE = '';
            $AND = '';
            $FROM = '';
            $arrayBind = array();

            if ($objPaciente->getIdPaciente() != null) {
                $WHERE .= $AND . " tb_paciente.idPaciente = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPaciente->getIdPaciente());
            }

            if ($objPaciente->getNome() != null) {
                $WHERE .= $AND . " tb_paciente.nome LIKE ?";
                $AND = ' and ';
                $arrayBind[] = array('s', "%".$objPaciente->getNome()."%");
            }

            if ($objPaciente->getCPF() != null) {
                //echo $objPaciente->getCPF();
                $WHERE .= $AND . " tb_paciente.CPF = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPaciente->getCPF());
            }

            if ($objPaciente->getRG() != null) {
                $WHERE .= $AND . " tb_paciente.RG = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPaciente->getRG());
            }

            if ($objPaciente->getPassaporte() != null) {
                $WHERE .= $AND . " tb_paciente.passaporte = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPaciente->getPassaporte());
            }

            if ($objPaciente->getIdMunicipioFk() != null) {
                $WHERE .= $AND . " tb_paciente.idMunicipio_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPaciente->getIdMunicipioFk());
            }

            if ($objPaciente->getIdEstadoFk() != null) {
                $WHERE .= $AND . " tb_paciente.idEstado_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPaciente->getIdEstadoFk());
            }

            if ($objPaciente->getObsMunicipio() != null) {
                $WHERE .= $AND . " tb_paciente.obsMunicipio = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPaciente->getObsMunicipio());
            }

            if ($objPaciente->getObjCodGAL() != null) {
                $FROM .= ' ,tb_codgal ';
                $WHERE .= $AND . " tb_codgal.idPaciente_fk = tb_paciente.idPaciente ";
                $AND = ' and ';
                if ($objPaciente->getObjCodGAL()->getCodigo() != null) {
                    $WHERE .= $AND . " tb_codgal.codigo = ?";
                    $AND = ' and ';
                    $arrayBind[] = array('s', $objPaciente->getObjCodGAL()->getCodigo());

                }
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            //echo $SELECT.$WHERE;$WHERE

            $arr = $objBanco->consultarSQL($SELECT .$FROM. $WHERE, $arrayBind);

            $arr_pacientes = array();
            $numeroAmostras = 0;
            $numeroPacientes = 0;
            foreach ($arr as $reg) {

                /*$paciente = new Paciente();
                $paciente->setIdPaciente($reg['idPaciente']);

                $paciente->setNome($reg['nome']);
                $paciente->setIdSexo_fk($reg['idSexo_fk']);
                $paciente->setIdEtnia_fk($reg['idEtnia_fk']);
                $paciente->setNomeMae($reg['nomeMae']);
                $paciente->setCPF($reg['CPF']);
                $paciente->setObsCPF($reg['obsCPF']);
                $paciente->setRG($reg['RG']);
                $paciente->setObsRG($reg['obsRG']);
                $paciente->setDataNascimento($reg['dataNascimento']);
                $paciente->setObsNomeMae($reg['obsNomeMae']);
                $paciente->setEndereco($reg['endereco']);
                $paciente->setCEP($reg['CEP']);
                $paciente->setPassaporte($reg['passaporte']);
                $paciente->setObsPassaporte($reg['obsPassaporte']);
                $paciente->setObsCEP($reg['obsCEP']);
                $paciente->setObsEndereco($reg['obsEndereco']);
                $paciente->setCadastroPendente($reg['cadastroPendente']);
                $paciente->setCartaoSUS($reg['cartaoSUS']);
                $paciente->setObsCartaoSUS($reg['obsCartaoSUS']);
                $paciente->setObsDataNascimento($reg['obsDataNascimento']);
                $paciente->setIdMunicipioFk($reg['idMunicipio_fk']);
                $paciente->setIdEstadoFk($reg['idEstado_fk']);
                $paciente->setObsMunicipio($reg['obsMunicipio']);
                */


                $objAmostra = new Amostra();
                $objAmostraRN = new AmostraRN();

                if(!is_null($reg['idCodGAL'])){
                    $objAmostra->setIdCodGAL_fk($reg['idCodGAL']);
                }

                $objAmostra->setIdPaciente_fk($reg['idPaciente']);
                $arr_amostras = $objAmostraRN->listar_completo($objAmostra);
                $numeroAmostras += count($arr_amostras);

                if(count($arr_amostras) == 0){
                    $paciente = new Paciente();
                    $paciente->setIdPaciente($reg['idPaciente']);

                    $paciente->setNome($reg['nome']);
                    $paciente->setIdSexo_fk($reg['idSexo_fk']);
                    $paciente->setIdEtnia_fk($reg['idEtnia_fk']);
                    $paciente->setNomeMae($reg['nomeMae']);
                    $paciente->setCPF($reg['CPF']);
                    $paciente->setObsCPF($reg['obsCPF']);
                    $paciente->setRG($reg['RG']);
                    $paciente->setObsRG($reg['obsRG']);
                    $paciente->setDataNascimento($reg['dataNascimento']);
                    $paciente->setObsNomeMae($reg['obsNomeMae']);
                    $paciente->setEndereco($reg['endereco']);
                    $paciente->setCEP($reg['CEP']);
                    $paciente->setPassaporte($reg['passaporte']);
                    $paciente->setObsPassaporte($reg['obsPassaporte']);
                    $paciente->setObsCEP($reg['obsCEP']);
                    $paciente->setObsEndereco($reg['obsEndereco']);
                    $paciente->setCadastroPendente($reg['cadastroPendente']);
                    $paciente->setCartaoSUS($reg['cartaoSUS']);
                    $paciente->setObsCartaoSUS($reg['obsCartaoSUS']);
                    $paciente->setObsDataNascimento($reg['obsDataNascimento']);
                    $paciente->setIdMunicipioFk($reg['idMunicipio_fk']);
                    $paciente->setIdEstadoFk($reg['idEstado_fk']);
                    $paciente->setObsMunicipio($reg['obsMunicipio']);
                    $objAmostra->setObjPaciente($paciente);
                    $paciente->setNumero($reg['numero']);
                    $paciente->setComplemento($reg['complemento']);
                    $paciente->setBairro($reg['bairro']);
                    $arr_pacientes[] = $objAmostra;
                }else {
                    $arr_pacientes[] = $arr_amostras;
                }

            }

            $numeroPacientes = count($arr);
            $arr_pacientes[] = $numeroAmostras;
            $arr_pacientes[] = $numeroPacientes;
            return $arr_pacientes;
        }catch (Throwable $ex){
            throw new Excecao("Erro procurando pelo paciente no BD.", $ex);
        }
    }



    /*
    public function procurar_paciente(Paciente $objPaciente, Banco $objBanco)
    {
        try {
            if ($objPaciente->getObjCodGAL() != null) {
                $tabela_gal = ',tb_codgal';
                $itens_tabela = 'tb_codgal.idCodGAL,
                              tb_codgal.obsCodGAL,
                              tb_codgal.codigo,';
            } else {
                $tabela_gal = '';
                $itens_tabela = '';
            }

            $SELECT = "select  distinct tb_paciente.idPaciente,
                              tb_paciente.nome,
                              tb_paciente.idSexo_fk,
                              tb_paciente.idEtnia_fk,
                              tb_paciente.nomeMae,
                              tb_paciente.CPF,
                              tb_paciente.obsCPF,
                              tb_paciente.RG,
                              tb_paciente.obsRG,
                              tb_paciente.dataNascimento,
                              tb_paciente.obsNomeMae,
                              tb_paciente.endereco,
                              tb_paciente.CEP,
                              tb_paciente.passaporte,
                              tb_paciente.obsPassaporte,
                              tb_paciente.obsCEP,
                              tb_paciente.obsEndereco,
                              tb_paciente.cadastroPendente,
                              tb_paciente.cartaoSUS,
                              tb_paciente.obsCartaoSUS,
                              tb_paciente.obsDataNascimento,
                              tb_paciente.obsMunicipio,
                              tb_paciente.idMunicipio_fk,
                              tb_paciente.idEstado_fk," .
                $itens_tabela . "
                              tb_amostra.idAmostra,
                              tb_amostra.idCodGAL_fk,
                              tb_amostra.cod_municipio_fk,
                              tb_amostra.idPaciente_fk,
                              tb_amostra.observacoes,
                              tb_amostra.dataColeta,
                              tb_amostra.idPerfilPaciente_fk,
                              tb_amostra.horaColeta,
                              tb_amostra.motivo,
                              tb_amostra.CEP,
                              tb_amostra.codigoAmostra,
                              tb_amostra.a_r_g,
                              tb_amostra.obsMotivo,
                              tb_amostra.obsCEPAmostra,
                              tb_amostra.obsLugarOrigem,
                              tb_amostra.obsHoraColeta,
                              tb_amostra.nickname
                        from tb_paciente, tb_amostra " . $tabela_gal . "
                        where tb_amostra.idPaciente_fk = tb_paciente.idPaciente
                         ";
            if ($objPaciente->getObjCodGAL() != null) {
                $SELECT .= " 
                                      and tb_paciente.idPaciente = tb_codgal.idPaciente_fk
                                       and (tb_paciente.nome LIKE ? ";
                $SELECT .= " and tb_codgal.codigo = ?
                                    and tb_codgal.idCodGAL = tb_amostra.idCodGAL_fk) ";
            } else {
                $SELECT .= "  and tb_paciente.nome LIKE ?";
            }


            $arrayBind = array();
            if($objPaciente->getNome() != null) {
                $arrayBind[] = array('s', "%" . $objPaciente->getNome() . "%");
            }
            if ($objPaciente->getObjCodGAL() != null) {
                $arrayBind[] = array('d', $objPaciente->getObjCodGAL());
            }

            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);

            $array_paciente = array();
            foreach ($arr as $reg) {
                $paciente = new Paciente();
                $paciente->setIdPaciente($reg['idPaciente']);
                $paciente->setNome($reg['nome']);
                $paciente->setIdSexo_fk($reg['idSexo_fk']);
                $paciente->setIdEtnia_fk($reg['idEtnia_fk']);
                $paciente->setNomeMae($reg['nomeMae']);
                $paciente->setCPF($reg['CPF']);
                $paciente->setObsCPF($reg['obsCPF']);
                $paciente->setRG($reg['RG']);
                $paciente->setObsRG($reg['obsRG']);
                $paciente->setDataNascimento($reg['dataNascimento']);
                $paciente->setObsNomeMae($reg['obsNomeMae']);
                $paciente->setEndereco($reg['endereco']);
                $paciente->setCEP($reg['CEP']);
                $paciente->setPassaporte($reg['passaporte']);
                $paciente->setObsPassaporte($reg['obsPassaporte']);
                $paciente->setObsCEP($reg['obsCEP']);
                $paciente->setObsEndereco($reg['obsEndereco']);
                $paciente->setCadastroPendente($reg['cadastroPendente']);
                $paciente->setCartaoSUS($reg['cartaoSUS']);
                $paciente->setObsCartaoSUS($reg['obsCartaoSUS']);
                $paciente->setObsDataNascimento($reg['obsDataNascimento']);
                $paciente->setIdMunicipioFk($reg['idMunicipio_fk']);
                $paciente->setIdEstadoFk($reg['idEstado_fk']);
                $paciente->setObsMunicipio($reg['obsMunicipio']);


                $objAmostra = new Amostra();
                $objAmostra->setIdAmostra($reg['idAmostra']);
                $objAmostra->setIdPaciente_fk($reg['idPaciente_fk']);
                $objAmostra->setIdCodGAL_fk($reg['idCodGAL_fk']);
                $objAmostra->setIdNivelPrioridade_fk($reg['idNivelPrioridade_fk']);
                $objAmostra->setIdPerfilPaciente_fk($reg['idPerfilPaciente_fk']);
                $objAmostra->setIdEstado_fk($reg['cod_estado_fk']);
                $objAmostra->setIdLugarOrigem_fk($reg['cod_municipio_fk']);
                $objAmostra->setObservacoes($reg['observacoes']);
                $objAmostra->setDataColeta($reg['dataColeta']);
                $objAmostra->set_a_r_g($reg['a_r_g']);
                $objAmostra->setHoraColeta($reg['horaColeta']);
                $objAmostra->setMotivoExame($reg['motivo']);
                $objAmostra->setCEP($reg['CEP']);
                $objAmostra->setCodigoAmostra($reg['codigoAmostra']);
                $objAmostra->setObsCEP($reg['obsCEPAmostra']);
                $objAmostra->setObsHoraColeta($reg['obsHoraColeta']);
                $objAmostra->setObsLugarOrigem($reg['obsLugarOrigem']);
                $objAmostra->setObsMotivo($reg['obsMotivo']);
                $objAmostra->setNickname($reg['nickname']);

                $paciente->setObjsAmostras($objAmostra);


                $objCodigoGAL = new CodigoGAL();

                if ($reg['idCodGAL_fk'] != null) {
                    $objCodigoGALRN = new CodigoGAL_RN();
                    $objCodigoGAL->setIdCodigoGAL($reg['idCodGAL_fk']);
                    $objCodigoGAL = $objCodigoGALRN->consultar($objCodigoGAL);
                } else if ($reg['idCodGAL_fk'] == $reg['codigo']) {
                    $objCodigoGAL->setCodigo($reg['codigo']);
                    $objCodigoGAL->setIdCodigoGAL($reg['idCodGAL']);
                    $objCodigoGAL->setObsCodGAL($reg['obsCodGAL']);
                }

                $paciente->setObjCodGAL($objCodigoGAL);

                $array_paciente[] = $paciente;
            }



            $select_paciente_sem_amostra = 'select * from tb_paciente where idPaciente not in (select idPaciente_fk from tb_amostra) and nome like ?';
            $arrayBind1 = array();
            $arrayBind1[] = array('s', "%" . $objPaciente->getNome() . "%");

            $arr = $objBanco->consultarSQL($select_paciente_sem_amostra, $arrayBind1);

            foreach ($arr as $reg){
                $paciente = new Paciente();
                $paciente->setIdPaciente($reg['idPaciente']);
                $paciente->setNome($reg['nome']);
                $paciente->setIdSexo_fk($reg['idSexo_fk']);
                $paciente->setIdEtnia_fk($reg['idEtnia_fk']);
                $paciente->setNomeMae($reg['nomeMae']);
                $paciente->setCPF($reg['CPF']);
                $paciente->setObsCPF($reg['obsCPF']);
                $paciente->setRG($reg['RG']);
                $paciente->setObsRG($reg['obsRG']);
                $paciente->setDataNascimento($reg['dataNascimento']);
                $paciente->setObsNomeMae($reg['obsNomeMae']);
                $paciente->setEndereco($reg['endereco']);
                $paciente->setCEP($reg['CEP']);
                $paciente->setPassaporte($reg['passaporte']);
                $paciente->setObsPassaporte($reg['obsPassaporte']);
                $paciente->setObsCEP($reg['obsCEP']);
                $paciente->setObsEndereco($reg['obsEndereco']);
                $paciente->setCadastroPendente($reg['cadastroPendente']);
                $paciente->setCartaoSUS($reg['cartaoSUS']);
                $paciente->setObsCartaoSUS($reg['obsCartaoSUS']);
                $paciente->setObsDataNascimento($reg['obsDataNascimento']);
                $paciente->setIdMunicipioFk($reg['idMunicipio_fk']);
                $paciente->setIdEstadoFk($reg['idEstado_fk']);
                $paciente->setObsMunicipio($reg['obsMunicipio']);
                $array_paciente[] = $paciente;
            }


            $SELECT = 'select distinct count(*), nome from tb_paciente group by nome having count(*) >=1';
            $arr = $objBanco->consultarSQL($SELECT);

            $array_paciente[] = $arr;

            return $array_paciente;
        } catch (Throwable $ex) {

            throw new Excecao("Erro listando o paciente no BD.", $ex);
        }
    }
    */

}
