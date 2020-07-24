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
            $objExcecao->adicionar_validacao('O nome do paciente não foi informado',  null, 'alert-danger');
        } else {
            if (strlen($strNome) > 130) {
                $objExcecao->adicionar_validacao('O nome do paciente possui mais que 130 caracteres.',  null, 'alert-danger');
            }
        }

        $paciente->setNome($strNome);
    }

    private function validarNomeMae(Paciente $paciente, Excecao $objExcecao) {
        $strNomeMae = trim($paciente->getNomeMae());

        if (strlen($strNomeMae) > 130) {
            $objExcecao->adicionar_validacao('O nome da mãe do paciente possui mais que 130 caracteres.',  null, 'alert-danger');
        }

        /* if($strNomeMae == '' && $paciente->getObsNomeMae() == ''){
          $objExcecao->adicionar_validacao('Informe o nome da mãe ou justifique a ausência.','idNomeMae');
          } */

        $paciente->setNomeMae($strNomeMae);
    }

    private function validarComplemento(Paciente $paciente, Excecao $objExcecao) {
        $strComplemento = trim($paciente->getComplemento());

        if (strlen($strComplemento) > 50) {
            $objExcecao->adicionar_validacao('O complemento do endereço do paciente possui mais que 50 caracteres.',  null, 'alert-danger');
        }

        $paciente->setComplemento($strComplemento);
    }


    private function validarBairro(Paciente $paciente, Excecao $objExcecao) {
        $strBairro = trim($paciente->getBairro());

        if (strlen($strBairro) > 50) {
            $objExcecao->adicionar_validacao('O bairro do endereço do paciente possui mais que 50 caracteres.',  null, 'alert-danger');
        }

        $paciente->setBairro($strBairro);
    }
    private function validarObsNomeMae(Paciente $paciente, Excecao $objExcecao) {
        $strNomeMaeObs = trim($paciente->getObsNomeMae());

        if (strlen($strNomeMaeObs) > 150) {
            $objExcecao->adicionar_validacao('Observações do nome da mãe do paciente possui mais que 150 caracteres.',  null, 'alert-danger');
        }

        if ($strNomeMaeObs == '' && $paciente->getNomeMae() == '') {
            $paciente->setObsNomeMae('Desconhecido');
        }


        $paciente->setObsNomeMae($strNomeMaeObs);
    }

    private function validarObsMunicipio(Paciente $paciente, Excecao $objExcecao) {
        $strMunicipio = trim($paciente->getObsMunicipio());

        if (strlen($strMunicipio) > 150) {
            $objExcecao->adicionar_validacao('Observações do município do paciente possui mais que 150 caracteres.',  null, 'alert-danger');
        }

        if ($strMunicipio == '' && $paciente->getIdMunicipioFk() == '') {
            $paciente->setObsMunicipio('Desconhecido');
        }


        $paciente->setObsMunicipio($strMunicipio);
    }

    private function validarCPF(Paciente $paciente, Excecao $objExcecao) {
        $strCPF = trim($paciente->getCPF());

        if (strlen($strCPF) > 0) {
            if (strlen($strCPF) != 11) {
                $objExcecao->adicionar_validacao('O CPF do paciente não possui  11 caracteres.',  null, 'alert-danger');
            }
            
            $objPacienteAux = new Paciente();
            $objPacienteAuxRN = new PacienteRN();
            $objPacienteAux->setCPF($paciente->getCPF());
            $arr = $objPacienteAuxRN->listar($objPacienteAux);

            if(count($arr) > 0 && $paciente->getIdPaciente() == null){
                $objExcecao->adicionar_validacao('O CPF já pertence a outro paciente', null, 'alert-danger');
            }else if (count($arr) > 0 && $paciente->getIdPaciente() != null) {
                foreach ($arr as $item) {
                    if ($item->getIdPaciente() != $paciente->getIdPaciente()) {
                        if ($item->getCPF() == $paciente->getCPF()) {
                            $objExcecao->adicionar_validacao('O CPF já pertence a outro paciente', null, 'alert-danger');
                        }
                    }
                }
            }
            
            
            // Extrai somente os números

            $strCPF = preg_replace('/[^0-9]/is', '', $strCPF);

            // Verifica se foi informado todos os digitos corretamente
            // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
            if (preg_match('/(\d)\1{10}/', $strCPF)) {
                $objExcecao->adicionar_validacao('O CPF do paciente não é válido.',  null, 'alert-danger');
            }
            $cpf = intval($strCPF);
            // Faz o calculo para validar o CPF
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) {
                    $objExcecao->adicionar_validacao('O CPF do paciente não é válido.',  null, 'alert-danger');
                }
            }
        }
       

        $paciente->setCPF($strCPF);
    }

    private function validarRG(Paciente $paciente, Excecao $objExcecao) {
        $strRG = trim($paciente->getRG());

        if(strlen($strRG) > 20){
            $objExcecao->adicionar_validacao('O RG já possui mais de 20 caracteres', null, 'alert-danger');
        }

        /*if (strlen($strRG) > 0) {
            $objPacienteAux = new Paciente();
            $objPacienteAuxRN = new PacienteRN();
            $arr = $objPacienteAuxRN->listar($objPacienteAux);
            
            foreach ($arr as $item){
                if($item->getRG() == $paciente->getRG() ){
                    if($paciente->getIdPaciente() != null){
                        if($item->getIdPaciente() != $paciente->getIdPaciente()){
                            $objExcecao->adicionar_validacao('O RG já pertence a outro paciente', null, 'alert-danger');
                        }
                    }else{
                        $objExcecao->adicionar_validacao('O RG já pertence a outro paciente', null, 'alert-danger');
                    }
                    
                }
            }
        }*/

        $paciente->setRG($strRG);
    }

    private function validarObsRG(Paciente $paciente, Excecao $objExcecao) {
        $strObsRG = trim($paciente->getObsRG());

        if (strlen($strObsRG) > 150) {
            $objExcecao->adicionar_validacao('As observações do RG do paciente possui mais que 150 caracteres.', null, 'alert-danger');
        }

        if ($strObsRG == '' && $paciente->getRG() == '') {
            $paciente->setObsRG('Desconhecido');
        }
        $paciente->setObsRG($strObsRG);
    }

    private function validarObsCEP(Paciente $paciente, Excecao $objExcecao) {
        $strObsCEP = trim($paciente->getObsCEP());

        if (strlen($strObsCEP) > 300) {
            $objExcecao->adicionar_validacao('As observações do CEP do paciente possui mais que 300 caracteres.',  null, 'alert-danger');
        }

        if ($strObsCEP == '' && $paciente->getCEP() == '') {
            $paciente->setObsCEP('Desconhecido');
        }

        $paciente->setObsCEP($strObsCEP);
    }

    private function validarObsCartaoSUS(Paciente $paciente, Excecao $objExcecao) {
        if($paciente->getObsCartaoSUS() != null) {
            $strObsCartaoSUS = trim($paciente->getObsCartaoSUS());

            if (strlen($strObsCartaoSUS) > 300) {
                $objExcecao->adicionar_validacao('As observações do cartão do SUS do paciente possui mais que 300 caracteres.', null, 'alert-danger');
            }

            if ($strObsCartaoSUS == '' && $paciente->getCartaoSUS() == '') {
                $paciente->setObsCartaoSUS('Desconhecido');
            }

            $paciente->setObsCartaoSUS($strObsCartaoSUS);
        }
    }

    private function validarCartaoSUS(Paciente $paciente, Excecao $objExcecao) {
        if($paciente->getCartaoSUS() != null) {
            $strCartaoSUS = trim($paciente->getCartaoSUS());

            if (strlen($strCartaoSUS) > 15) {
                $objExcecao->adicionar_validacao('O cartão do SUS do paciente possui mais que 15 caracteres.', null, 'alert-danger');
            }

            /*if (strlen($strCartaoSUS) > 0) {
                $objPacienteAux = new Paciente();
                $objPacienteAuxRN = new PacienteRN();
                $arr = $objPacienteAuxRN->listar($objPacienteAux);

                foreach ($arr as $item) {
                    if ($item->getCartaoSUS() == $paciente->getCartaoSUS()) {
                        if ($paciente->getIdPaciente() != null) {
                            if ($item->getIdPaciente() != $paciente->getIdPaciente()) {
                                $objExcecao->adicionar_validacao('O cartão SUS já pertence a outro paciente', null, 'alert-danger');
                            }
                        } else {
                            $objExcecao->adicionar_validacao('O cartão SUS já pertence a outro paciente', null, 'alert-danger');
                        }

                    }
                }
            }*/

            $paciente->setCartaoSUS($strCartaoSUS);
        }
    }

    private function validarObsEndereco(Paciente $paciente, Excecao $objExcecao) {
        if($paciente->getObsEndereco() != null) {
            $strObsEndereco = trim($paciente->getObsEndereco());

            if (strlen($strObsEndereco) > 300) {
                $objExcecao->adicionar_validacao('As observações do endereco do paciente possui mais que 300 caracteres.', null, 'alert-danger');
            }

            if ($strObsEndereco == '' && $paciente->getEndereco() == '') {
                $paciente->setObsEndereco('Desconhecido');
            }

            $paciente->setObsEndereco($strObsEndereco);
        }
    }



    private function validarObsPassaporte(Paciente $paciente, Excecao $objExcecao) {
        if($paciente->getObsPassaporte() != null) {
            $strObsPassaporte = trim($paciente->getObsPassaporte());

            if (strlen($strObsPassaporte) > 300) {
                $objExcecao->adicionar_validacao('As observações do passaporte do paciente possui mais que 300 caracteres.', 'idObsPassaporte', 'alert-danger');
            }

            if ($strObsPassaporte == '' && $paciente->getPassaporte() == '') {
                $paciente->setObsPassaporte('Desconhecido');
            }


            $paciente->setObsPassaporte($strObsPassaporte);
        }
    }

    private function validarObsCPF(Paciente $paciente, Excecao $objExcecao) {
        if($paciente->getObsCPF() != null) {
            $strObsCPF = trim($paciente->getObsCPF());

            if (strlen($strObsCPF) > 300) {
                $objExcecao->adicionar_validacao('As observações do CPF do paciente possui mais que 300 caracteres.', 'idObsCPF', 'alert-danger');
            }

            if ($strObsCPF == '' && $paciente->getCPF() == '') {
                $paciente->setObsCPF('Desconhecido');
            }

            $paciente->setObsCPF($strObsCPF);
        }
    }

    private function validarPassaporte(Paciente $paciente, Excecao $objExcecao) {
        if($paciente->getPassaporte() != null) {
            if ($paciente->getPassaporte() != null) {
                $strPassaporte = trim($paciente->getPassaporte());

                if (strlen($strPassaporte) > 15) {
                    $objExcecao->adicionar_validacao('O passaporte do paciente possui mais que 15 caracteres.', 'idPassaporte', 'alert-danger');
                }

                /*if (strlen($strPassaporte) > 0) {
                    $objPacienteAux = new Paciente();
                    $objPacienteAuxRN = new PacienteRN();
                    $arr = $objPacienteAuxRN->listar($objPacienteAux);

                    foreach ($arr as $item) {
                        if ($item->getPassaporte() == $paciente->getPassaporte()) {
                            if ($paciente->getIdPaciente() != null) {
                                if ($item->getIdPaciente() != $paciente->getIdPaciente()) {
                                    $objExcecao->adicionar_validacao('O passaporte já pertence a outro paciente', null, 'alert-danger');
                                }
                            } else {
                                $objExcecao->adicionar_validacao('O passaporte já pertence a outro paciente', null, 'alert-danger');
                            }

                        }
                    }
                }*/


                $paciente->setPassaporte($strPassaporte);
            }
        }
    }

    private function validarDataNascimento(Paciente $paciente, Excecao $objExcecao) {
        if($paciente->getDataNascimento() != null) {
            $strDataNascimento = trim($paciente->getDataNascimento());
            Utils::validarData($strDataNascimento, $objExcecao);
            $paciente->setDataNascimento($strDataNascimento);
        }
    }

    private function validarCEP(Paciente $paciente, Excecao $objExcecao) {
        if($paciente->getCEP() != null) {
            $strCEP = trim($paciente->getCEP());

            if (strlen($strCEP) > 8) {
                $objExcecao->adicionar_validacao('O CEP do paciente possui mais que 8 caracteres.', 'idCEP', 'alert-danger');
            }
            if (strlen($strCEP) < 8) {
                $objExcecao->adicionar_validacao('O CEP do paciente possui menos que 8 caracteres', 'idCEP', 'alert-danger');
            }

            $paciente->setCEP($strCEP);
        }
    }

    private function validarEndereco(Paciente $paciente, Excecao $objExcecao) {
        if($paciente->getEndereco() != null) {
            $strEndereco = trim($paciente->getEndereco());

            if (strlen($strEndereco) > 150) {
                $objExcecao->adicionar_validacao('O endereço possui mais que 150 caracteres.', 'idEndereco', 'alert-danger');
            }

            $paciente->setEndereco($strEndereco);
        }
    }

    private function validarIdMunicipioIdEstado(Paciente $paciente, Excecao $objExcecao) {
        if($paciente->getIdEstadoFk() != null && $paciente->getIdMunicipioFk() != null) {
            $objLugarOrigem = new LugarOrigem();
            $objLugarOrigemRN = new LugarOrigemRN();
            $arr_lugar = $objLugarOrigemRN->listar($objLugarOrigem);

            foreach ($arr_lugar as $lugar){
                if($lugar->getIdLugarOrigem() == $paciente->getIdMunicipioFk()){
                    if($paciente->getIdEstadoFk() != $lugar->getObjEstado()->getCod_estado()){
                        return $objExcecao->adicionar_validacao('O município deve ser do estado correspondente', 'idEndereco', 'alert-danger');
                    }
                }
            }


            $strEndereco = trim($paciente->getEndereco());

            if (strlen($strEndereco) > 150) {
                $objExcecao->adicionar_validacao('O endereço possui mais que 150 caracteres.', 'idEndereco', 'alert-danger');
            }

            $paciente->setEndereco($strEndereco);
        }
    }


    private function validarObsDataNascimento(Paciente $paciente, Excecao $objExcecao) {
        $strObsDataNascimento = trim($paciente->getObsDataNascimento());

        if (strlen($strObsDataNascimento) > 150) {
            $objExcecao->adicionar_validacao('As observações da data de nascimento possui mais que 300 caracteres.',null,'alert-danger');
        }

        $paciente->setObsDataNascimento($strObsDataNascimento);
    }


    private function validarDDD(Paciente $paciente, Excecao $objExcecao) {
        if($paciente->getDDD() != null) {
            $strDDD = trim($paciente->getDDD());

            if (strlen($strDDD) > 3) {
                $objExcecao->adicionar_validacao('O DDD do telefone tem mais que 3 caracteres', null, 'alert-danger');
            }

            if ($strDDD != '' && $paciente->getTelefone() == '') {
                $objExcecao->adicionar_validacao('Informe o número do telefone', null, 'alert-danger');
            }

            $paciente->setDDD($strDDD);
        }
    }

    private function validarTelefone(Paciente $paciente, Excecao $objExcecao) {
        if($paciente->getTelefone() != null) {
            $strTelefone = trim($paciente->getTelefone());

            if (strlen($strTelefone) > 9) {
                $objExcecao->adicionar_validacao('O número do telefone deve possuir, no máximo, 9 caracteres', null, 'alert-danger');
            }

            if ($strTelefone != '' && $paciente->getDDD() == '') {
                $objExcecao->adicionar_validacao('Informe o DDD do número', null, 'alert-danger');
            }

            $paciente->setTelefone($strTelefone);
        }
    }
    
    
    public function cadastrar(Paciente $paciente) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objPacienteBD = new PacienteBD();

            //$this->validarCenarioPendente($paciente, $objExcecao);
            $this->validarCEP($paciente, $objExcecao);
            $this->validarEndereco($paciente, $objExcecao);
            $this->validarCPF($paciente, $objExcecao);
            $this->validarDataNascimento($paciente,$objExcecao);
            $this->validarNome($paciente, $objExcecao);
            $this->validarObsCartaoSUS($paciente, $objExcecao);
            $this->validarCartaoSUS($paciente, $objExcecao);
            $this->validarNomeMae($paciente, $objExcecao);
            $this->validarObsDataNascimento($paciente, $objExcecao);
            $this->validarObsNomeMae($paciente, $objExcecao);
            $this->validarObsRG($paciente, $objExcecao);
            $this->validarObsCPF($paciente, $objExcecao);
            $this->validarPassaporte($paciente,$objExcecao);
            $this->validarObsCEP($paciente, $objExcecao);
            $this->validarObsPassaporte($paciente, $objExcecao);
            $this->validarObsEndereco($paciente, $objExcecao);
            $this->validarRG($paciente, $objExcecao);
            $this->validarObsMunicipio($paciente, $objExcecao);
            $this->validarIdMunicipioIdEstado($paciente, $objExcecao);
            $this->validarDDD($paciente, $objExcecao);
            $this->validarTelefone($paciente, $objExcecao);
            $this->validarBairro($paciente, $objExcecao);
            $this->validarComplemento($paciente, $objExcecao);
            
            /* VALIDAR CENÁRIO 7 e 8 */
            //$this->validarCenario_7_8($paciente, $objExcecao);
            
            
            $objExcecao->lancar_validacoes();
            
            $objPacienteBD->cadastrar($paciente, $objBanco);
            
            if($paciente->getObjCodGAL() != null){
              
                $objCodGAL = $paciente->getObjCodGAL();
                $objCodGAL->setIdPaciente_fk($paciente->getIdPaciente()); 
            
                $objCodGALRN = new CodigoGAL_RN();
                $objCodGALRN->cadastrar($objCodGAL);
               $paciente->setObjCodGAL($objCodGAL);
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
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objCodGALRN = new CodigoGAL_RN();

            if($paciente->getObjCodGAL() != null){
                if($paciente->getObjCodGAL()->getIdCodigoGAL() == null){
                    $objCodGAL = $paciente->getObjCodGAL();
                    $objCodGAL->setIdPaciente_fk($paciente->getIdPaciente());
                    $objCodGALRN->cadastrar($objCodGAL);

                }else{
                    $objCodGALRN->alterar($paciente->getObjCodGAL());

                }
                $paciente->setObjCodGAL($objCodGAL);

            }

            //$this->validarCenarioPendente($paciente, $objExcecao);
            $this->validarDDD($paciente, $objExcecao);
            $this->validarTelefone($paciente, $objExcecao);
            $this->validarCEP($paciente, $objExcecao);
            $this->validarEndereco($paciente, $objExcecao);
            $this->validarCPF($paciente, $objExcecao);
            $this->validarDataNascimento($paciente,$objExcecao);
            $this->validarNome($paciente, $objExcecao);
            $this->validarObsCartaoSUS($paciente, $objExcecao);
            $this->validarCartaoSUS($paciente, $objExcecao);
            $this->validarNomeMae($paciente, $objExcecao);
            $this->validarObsDataNascimento($paciente, $objExcecao);
            $this->validarObsNomeMae($paciente, $objExcecao);
            $this->validarObsRG($paciente, $objExcecao);
            $this->validarObsCPF($paciente, $objExcecao);
            $this->validarPassaporte($paciente,$objExcecao);
            $this->validarObsCEP($paciente, $objExcecao);
            $this->validarObsPassaporte($paciente, $objExcecao);
            $this->validarObsEndereco($paciente, $objExcecao);
            $this->validarRG($paciente, $objExcecao);
            $this->validarObsMunicipio($paciente, $objExcecao);
            $this->validarIdMunicipioIdEstado($paciente, $objExcecao);
            $this->validarBairro($paciente, $objExcecao);
            $this->validarComplemento($paciente, $objExcecao);
            //$this->validarCenario_7_8($paciente,$objExcecao); 

            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();
            $objPacienteBD->alterar($paciente, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $paciente;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o paciente.', $e);
        }
    }

    public function consultar(Paciente $paciente) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();
            $arr = $objPacienteBD->consultar($paciente, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o paciente.', $e);
        }
    }

    public function listar_completo(Paciente $paciente,$numLimite = null) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();
            $arr = $objPacienteBD->listar_completo($paciente,$numLimite, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o paciente.', $e);
        }
    }

    public function remover(Paciente $paciente) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();
            $arr = $objPacienteBD->remover($paciente, $objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o paciente.', $e);
        }
    }

    public function listar(Paciente $paciente) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();

            $arr = $objPacienteBD->listar($paciente, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o paciente.', $e);
        }
    }

    public function validarCadastro(Paciente $paciente) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();
            $arr = $objPacienteBD->validarCadastro($paciente, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro pesquisando o paciente.', $e);
        }
    }

    public function procurar(Paciente $paciente) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();
            $arr = $objPacienteBD->procurar($paciente, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o paciente.', $e);
        }
    }

    public function procurarCPF(Paciente $paciente) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();
            $arr = $objPacienteBD->procurarCPF($paciente, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o paciente.', $e);
        }
    }

    public function procurarRG(Paciente $paciente) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();
            $arr = $objPacienteBD->procurarRG($paciente, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o paciente.', $e);
        }
    }

    
    public function procurarPassaporte(Paciente $paciente) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();
            $arr = $objPacienteBD->procurarPassaporte($paciente, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o paciente.', $e);
        }
    }

    public function procurar_paciente(Paciente $paciente) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();

            $arr = $objPacienteBD->procurar_paciente($paciente, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro procurando o paciente.', $e);
        }
    }
    
}
