<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do paciente do paciente
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/PacienteBD.php';

class PacienteRN {

    private function validarNome(Paciente $paciente, Excecao $objExcecao) {
        $strNome = trim($paciente->getNome());

        if ($strNome == '') {
            $objExcecao->adicionar_validacao('O nome do paciente não foi informado', 'idNome');
        } else {
            if (strlen($strNome) > 130) {
                $objExcecao->adicionar_validacao('O nome do paciente possui mais que 130 caracteres.', 'idNome');
            }
        }

        return $paciente->setNome($strNome);
    }

    private function validarNomeMae(Paciente $paciente, Excecao $objExcecao) {
        $strNomeMae = trim($paciente->getNomeMae());

        if (strlen($strNomeMae) > 130) {
            $objExcecao->adicionar_validacao('O nome da mãe do paciente possui mais que 130 caracteres.', 'idNomeMae');
        }

        /* if($strNomeMae == '' && $paciente->getObsNomeMae() == ''){
          $objExcecao->adicionar_validacao('Informe o nome da mãe ou justifique a ausência.','idNomeMae');
          } */

        return $paciente->setNomeMae($strNomeMae);
    }

    private function validarObsNomeMae(Paciente $paciente, Excecao $objExcecao) {
        $strNomeMaeObs = trim($paciente->getObsNomeMae());

        if (strlen($strNomeMaeObs) > 150) {
            $objExcecao->adicionar_validacao('Observações do nome da mãe do paciente possui mais que 150 caracteres.', 'idObsMae');
        }

        if ($strNomeMaeObs == '' && $paciente->getNomeMae() == '') {
            return $paciente->setObsNomeMae('Desconhecido');
        }


        return $paciente->setObsNomeMae($strNomeMaeObs);
    }

    private function validarCPF(Paciente $paciente, Excecao $objExcecao) {
        $strCPF = trim($paciente->getCPF());

        if (strlen($strCPF) > 0) {
            if (strlen($strCPF) != 11) {
                $objExcecao->adicionar_validacao('O CPF do paciente não possui  11 caracteres.', 'idCPF');
            }


            // Extrai somente os números

            $strCPF = preg_replace('/[^0-9]/is', '', $strCPF);

            // Verifica se foi informado todos os digitos corretamente
            // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
            if (preg_match('/(\d)\1{10}/', $strCPF)) {
                $objExcecao->adicionar_validacao('O CPF do paciente não é válido.', 'idCPF');
            }
            $cpf = intval($strCPF);
            // Faz o calculo para validar o CPF
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) {
                    $objExcecao->adicionar_validacao('O CPF do paciente não é válido.', 'idCPF');
                }
            }
        }
       

        return $paciente->setCPF($strCPF);
    }

    private function validarRG(Paciente $paciente, Excecao $objExcecao) {
        $strRG = trim($paciente->getRG());

        /*if (strlen($strRG) > 0) {
            if (strlen($strRG) != 10) {
                $objExcecao->adicionar_validacao('O RG do paciente não possui 10 caracteres.', 'idRG');
            }
        }*/

        return $paciente->setRG($strRG);
    }

    private function validarObsRG(Paciente $paciente, Excecao $objExcecao) {
        $strObsRG = trim($paciente->getObsRG());

        if (strlen($strObsRG) > 150) {
            $objExcecao->adicionar_validacao('As observações do RG do paciente possui mais que 150 caracteres.', 'idObsRG');
        }

        if ($strObsRG == '' && $paciente->getRG() == '') {
            return $paciente->setObsRG('Desconhecido');
        }
        return $paciente->setObsRG($strObsRG);
    }

    private function validarObsCEP(Paciente $paciente, Excecao $objExcecao) {
        $strObsCEP = trim($paciente->getObsCEP());

        if (strlen($strObsCEP) > 300) {
            $objExcecao->adicionar_validacao('As observações do CEP do paciente possui mais que 300 caracteres.', 'idObsCEP');
        }

        if ($strObsCEP == '' && $paciente->getCEP() == '') {
            return $paciente->setObsCEP('Desconhecido');
        }

        return $paciente->setObsCEP($strObsCEP);
    }

    private function validarObsEndereco(Paciente $paciente, Excecao $objExcecao) {
        $strObsEndereco = trim($paciente->getObsEndereco());

        if (strlen($strObsEndereco) > 300) {
            $objExcecao->adicionar_validacao('As observações do endereco do paciente possui mais que 300 caracteres.', 'idObsEndereco');
        }

        if ($strObsEndereco == '' && $paciente->getEndereco() == '') {
            return $paciente->setObsEndereco('Desconhecido');
        }

        return $paciente->setObsEndereco($strObsEndereco);
    }

    private function validaObsCodGAL(Paciente $paciente, Excecao $objExcecao) {
        $strObsCodGAL = trim($paciente->getObsCodGAL());

        /* CÓDIGO GAL */
        $objCodigoGAL = new CodigoGAL();
        $objCodigoGAL_RN = new CodigoGAL_RN();

        $idGAL = '';
        $arr_codsGAL = $objCodigoGAL_RN->listar($objCodigoGAL);
        foreach ($arr_codsGAL as $cg) {
            if ($cg->getIdPaciente_fk() == $paciente->getIdPaciente()) {
                $idGAL = $cg->getCodigo();
            }
        }

        if ($idGAL == null) { // esse paciente não tem código gal
            $strObsCodGAL = 'Desconhecido';
        }

        if (strlen($strObsCodGAL) > 300) {
            $objExcecao->adicionar_validacao('As observações do código GAL do paciente possui mais que 300 caracteres.', 'idObsCodGAL');
        }



        return $paciente->setObsEndereco($strObsEndereco);
    }

    private function validarObsPassaporte(Paciente $paciente, Excecao $objExcecao) {
        $strObsPassaporte = trim($paciente->getObsPassaporte());

        if (strlen($strObsPassaporte) > 300) {
            $objExcecao->adicionar_validacao('As observações do passaporte do paciente possui mais que 300 caracteres.', 'idObsPassaporte');
        }

        if ($strObsPassaporte == '' && $paciente->getPassaporte() == '') {
            return $paciente->setObsPassaporte('Desconhecido');
        }

        return $paciente->setObsPassaporte($strObsPassaporte);
    }

    private function validarObsCPF(Paciente $paciente, Excecao $objExcecao) {
        $strObsCPF = trim($paciente->getObsCPF());

        if (strlen($strObsCPF) > 300) {
            $objExcecao->adicionar_validacao('As observações do CPF do paciente possui mais que 300 caracteres.', 'idObsCPF');
        }

        if ($strObsCPF == '' && $paciente->getCPF() == '') {
            return $paciente->setObsCPF('Desconhecido');
        }

        return $paciente->setObsCPF($strObsCPF);
    }

    private function validarPassaporte(Paciente $paciente, Excecao $objExcecao) {
        $strPassaporte = trim($paciente->getPassaporte());

        if (strlen($strPassaporte) > 300) {
            $objExcecao->adicionar_validacao('O passaporte do paciente possui mais que 300 caracteres.', 'idPassaporte');
        }

        return $paciente->setPassaporte($strPassaporte);
    }

    private function validarDataNascimento(Paciente $paciente, Excecao $objExcecao) {
        $strDataNascimento = trim($paciente->getDataNascimento());


        //validar para que não haja datas de nascimento posteriores a data atual

        return $paciente->setDataNascimento($strDataNascimento);
    }

    private function validarCEP(Paciente $paciente, Excecao $objExcecao) {
        $strCEP = trim($paciente->getCEP());
        
        if (strlen($strCEP) > 8) {
            $objExcecao->adicionar_validacao('O CEP possui mais que 8 caracteres.', 'idCEP');
        }

        return $paciente->setCEP($strCEP);
    }

    private function validarEndereco(Paciente $paciente, Excecao $objExcecao) {
        $strEndereco = trim($paciente->getEndereco());

        if (strlen($strEndereco) > 150) {
            $objExcecao->adicionar_validacao('O endereço possui mais que 150 caracteres.', 'idEndereco');
        }

        return $paciente->setEndereco($strEndereco);
    }

    /*
     *  Cenário : Marcar cadastro como pendente
     * Quando estou na tela de dados do paciente
     * E escolho opção “cadastro pendente”
     * Então recebo msg de confirmação  informando que este cadastro está em situação “pendente”.
     *
     * Cenário 7: Não justificar ausência de algum dado opcional do paciente
     *  Quando estou na tela de dados do paciente
     *  E não informo <CPF>, <GAL>, <RG>, <Passaporte>, <SUS>, <Sexo>, <endereço>, <CEP>, <Nome da mãe>, <Data nascimento> OU <etnia> 
     *  E não informo justificativa
     *  Então o campo é mostrado com o valor <NI/desconhecido>
     *  E recebo mensagem de confirmação 
     * 
     * Cenário 8: Não justificar ausência de NENHUM dado opcional do paciente
     * Quando estou na tela de dados do paciente
     * E não informo nenhum dos campos <CPF>, <GAL>, <RG>, <Passaporte>, <SUS>, <Sexo>, <endereço>, <CEP>, <Nome da mãe>, <Data nascimento> e <etnia> 
     * E não informo justificativa
     * Então os campos são mostrados com o valor <NI/desconhecido>
     * E recebo mensagem de erro (algum dado além do nome precisa ser informado para assegurar a correta localização da amostra posteriormente)
     * E recebo msg de confirmação  informando que este cadastro está em situação “pendente”.
     * 
     */

    private function validarCenario_7_8(Paciente $paciente, Excecao $objExcecao) {

        /* ETNIA */
        $objEtnia = new Etnia();
        $objEtniaRN = new EtniaRN();

        /* CÓDIGO GAL */
        $objCodigoGAL = new CodigoGAL();
        $objCodigoGAL_RN = new CodigoGAL_RN();

        $idGAL = '';
        $arr_codsGAL = $objCodigoGAL_RN->listar($objCodigoGAL);
        foreach ($arr_codsGAL as $cg) {
            if ($cg->getIdPaciente_fk() == $paciente->getIdPaciente()) {
                $idGAL = $cg->getCodigo();
            }
        }


        /* SEXO PACIENTE */
        $objSexoPaciente = new Sexo();
        $objSexoPacienteRN = new SexoRN();

        $idEtnia = '';
        $arr_etnias = $objEtniaRN->listar($objEtnia);
        foreach ($arr_etnias as $ae) {
            if ($ae->getIndex_etnia() == 'SEM DECLARACAO') {
                $idEtnia = $ae->getIdEtnia();
            }
        }

        $idSexo = '';
        $arr_sexos = $objSexoPacienteRN->listar($objSexoPaciente);
        foreach ($arr_sexos as $as) {
            if ($as->getIndex_sexo() == 'NAO INFORMADO') {
                $idSexo = $as->getIdSexo();
            }
        }

        /* CENÁRIO 7 */
        if (($paciente->getCPF() == '' &&
                $paciente->getRG() == '' &&
                $paciente->getPassaporte() == '' &&
                $paciente->getIdSexo_fk() == $idSexo &&
                $paciente->getEndereco() == '' &&
                $paciente->getCEP() == '' &&
                $paciente->getNomeMae() == '' &&
                $paciente->getDataNascimento() == '' &&
                $idGAL == null) || $paciente->getIdEtnia_fk() == $idEtnia) {

            $paciente->setObsRG('Desconhecido');
            $paciente->setObsCEP('Desconhecido');
            $paciente->setObsCPF('Desconhecido');
            $paciente->setObsEndereco('Desconhecido');
            $paciente->setObsPassaporte('Desconhecido');
            $paciente->setObsNomeMae('Desconhecido');
            $paciente->setObsCodGAL('Desconhecido');
        }

        /* CENÁRIO 8 */
        if ($paciente->getCPF() == '' &&
                $paciente->getRG() == '' &&
                $paciente->getPassaporte() == '' &&
                $paciente->getIdSexo_fk() == $idSexo &&
                $paciente->getEndereco() == '' &&
                $paciente->getCEP() == '' &&
                $paciente->getNomeMae() == '' &&
                $paciente->getDataNascimento() == '' &&
                $idGAL == null && $paciente->getIdEtnia_fk() == $idEtnia) {

            $paciente->setObsRG('Desconhecido');
            $paciente->setObsCEP('Desconhecido');
            $paciente->setObsCPF('Desconhecido');
            $paciente->setObsEndereco('Desconhecido');
            $paciente->setObsPassaporte('Desconhecido');
            $paciente->setObsNomeMae('Desconhecido');
            $paciente->setObsCodGAL('Desconhecido');
            $paciente->setCadastroPendente('s');
        }

        /* CENÁRIO 8 */
        if ($paciente->getCPF() == '' &&
                $paciente->getRG() == '' &&
                $paciente->getPassaporte() == '' &&
                $paciente->getIdSexo_fk() == $idSexo &&
                $paciente->getEndereco() == '' &&
                $paciente->getCEP() == '' &&
                $paciente->getNomeMae() == '' &&
                $paciente->getDataNascimento() == '' &&
                $idGAL == null && $paciente->getIdEtnia_fk() == $idEtnia && $paciente->getNome() != null & $paciente->getNome() != '') {

            $paciente->setObsRG('Desconhecido');
            $paciente->setObsCEP('Desconhecido');
            $paciente->setObsCPF('Desconhecido');
            $paciente->setObsEndereco('Desconhecido');
            $paciente->setObsPassaporte('Desconhecido');
            $paciente->setObsNomeMae('Desconhecido');
            $paciente->setObsCodGAL('Desconhecido');
            $paciente->setCadastroPendente('s');
        }




        //print_r($paciente);

        return $paciente;
    }

    public function cadastrar(Paciente $paciente) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objPacienteBD = new PacienteBD();
            
            $this->validarCEP($paciente, $objExcecao);
            
            $this->validarEndereco($paciente, $objExcecao);
            $this->validarCPF($paciente, $objExcecao);
            
            //$this->validarDataNascimento($paciente,$objExcecao); 
            $this->validarNome($paciente, $objExcecao);
            $this->validarNomeMae($paciente, $objExcecao);
            $this->validarObsNomeMae($paciente, $objExcecao);
            
            $this->validarObsRG($paciente, $objExcecao);
            $this->validarObsCPF($paciente, $objExcecao);
            //$this->validarPassaporte($paciente,$objExcecao);
            
            $this->validarObsCEP($paciente, $objExcecao);
            $this->validarObsPassaporte($paciente, $objExcecao);
            $this->validarObsEndereco($paciente, $objExcecao);
            $this->validarRG($paciente, $objExcecao);
            
            /* VALIDAR CENÁRIO 7 e 8 */
            //$this->validarCenario_7_8($paciente, $objExcecao);
            
            
            $objExcecao->lancar_validacoes();
            
            $objPacienteBD->cadastrar($paciente, $objBanco);
            
            if($paciente->getObjCodGAL() != null){
              
                $objCodGAL = $paciente->getObjCodGAL();    
                $objCodGAL->setIdPaciente_fk($paciente->getIdPaciente()); 
            
                $objCodGALRN = new CodigoGAL_RN();
                $objCodGALRN->cadastrar($objCodGAL);
               
            }
            

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $paciente;
           
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o paciente.', $e);
        }
    }

    public function alterar(Paciente $paciente) {
        try {

            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();

            $this->validarCEP($paciente, $objExcecao);
            $this->validarEndereco($paciente, $objExcecao);
            $this->validarCPF($paciente, $objExcecao);
            //$this->validarDataNascimento($paciente,$objExcecao); 
            $this->validarNome($paciente, $objExcecao);
            $this->validarNomeMae($paciente, $objExcecao);
            $this->validarObsNomeMae($paciente, $objExcecao);
            $this->validarObsRG($paciente, $objExcecao);
            //$this->validarPassaporte($paciente,$objExcecao);
            $this->validarObsCEP($paciente, $objExcecao);
            $this->validarObsPassaporte($paciente, $objExcecao);
            $this->validarObsEndereco($paciente, $objExcecao);
            $this->validarRG($paciente, $objExcecao);
            //$this->validarCenario_7_8($paciente,$objExcecao); 

            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();
            $objPacienteBD->alterar($paciente, $objBanco);

            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando o paciente.', $e);
        }
    }

    public function consultar(Paciente $paciente) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();
            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();
            $arr = $objPacienteBD->consultar($paciente, $objBanco);

            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {

            throw new Excecao('Erro consultando o paciente.', $e);
        }
    }

    public function remover(Paciente $paciente) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();
            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();
            $arr = $objPacienteBD->remover($paciente, $objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro removendo o paciente.', $e);
        }
    }

    public function listar(Paciente $paciente) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();
            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();

            $arr = $objPacienteBD->listar($paciente, $objBanco);

            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o paciente.', $e);
        }
    }

    public function validarCadastro(Paciente $paciente) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();
            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();
            $arr = $objPacienteBD->validarCadastro($paciente, $objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando o paciente.', $e);
        }
    }

    public function procurar(Paciente $paciente) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();
            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();
            $arr = $objPacienteBD->procurar($paciente, $objBanco);

            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {

            throw new Excecao('Erro consultando o paciente.', $e);
        }
    }

    public function procurarCPF(Paciente $paciente) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();
            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();
            $arr = $objPacienteBD->procurarCPF($paciente, $objBanco);

            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {

            throw new Excecao('Erro consultando o paciente.', $e);
        }
    }

    public function procurarRG(Paciente $paciente) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();
            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();
            $arr = $objPacienteBD->procurarRG($paciente, $objBanco);

            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {

            throw new Excecao('Erro consultando o paciente.', $e);
        }
    }

    
    public function procurarPassaporte(Paciente $paciente) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();
            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();
            $arr = $objPacienteBD->procurarPassaporte($paciente, $objBanco);

            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {

            throw new Excecao('Erro consultando o paciente.', $e);
        }
    }
    
}
