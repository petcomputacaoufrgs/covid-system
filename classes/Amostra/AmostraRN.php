<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/AmostraBD.php';

class AmostraRN{
   
    
      
    private function validarObservacoes(Amostra $objAmostra, Excecao $objExcecao) {
        if($objAmostra->getObservacoes() != null) {
            $strObservacoes = trim($objAmostra->getObservacoes());


            if (strlen($strObservacoes) > 300) {
                $objExcecao->adicionar_validacao('A observação possui mais de 300 caracteres.', 'idObsAmostra', 'alert-danger');
            }

            $objAmostra->setObservacoes($strObservacoes);
        }

    }
    
    private function validarDataColeta(Amostra $objAmostra, Excecao $objExcecao) {

        if($objAmostra->getDataColeta() == null){
            $objExcecao->adicionar_validacao('Informar a data da coleta', 'idDtColeta', 'alert-danger');
        }else {
            $strDataColeta = trim($objAmostra->getDataColeta());
            if ($strDataColeta == '') {
                $objExcecao->adicionar_validacao('Informar a data da coleta', 'idDtColeta', 'alert-danger');
            } else if (strlen($objAmostra->getDataColeta()) <= 11) {
                //Utils::validarData($strDataColeta, $objExcecao);
                $atual = date("Y-m-d");


                if ($objAmostra->getDataColeta() > $atual) {
                    $objExcecao->adicionar_validacao('A data informada é maior que a data atual', 'idDataHora', 'alert-danger');
                }

            } else {
                $objExcecao->adicionar_validacao('Informar uma data válida da coleta', 'idDtColeta', 'alert-danger');
            }
        }

    }
    
    private function validar_a_r_g(Amostra $objAmostra, Excecao $objExcecao) {
        $strARG = trim($objAmostra->get_a_r_g());
       
        
        if ($strARG == '') {
            $objExcecao->adicionar_validacao('Informe se a amostra é aceita, recusada ou está a caminho','idARG','alert-danger');
        }
       
        $objAmostra->set_a_r_g($strARG);

    }

    private function validarObsMotivo(Amostra $objAmostra, Excecao $objExcecao) {
        if($objAmostra->getObsMotivo() != null) {
            $strObsMotivo = trim($objAmostra->getObsMotivo());

            if (strlen($strObsMotivo) > 300) {
                $objExcecao->adicionar_validacao('As observações de motivo possui mais que 300 caracteres', 'idObsMotivo', 'alert-danger');
            }

            $objAmostra->setObsMotivo($strObsMotivo);
        }

    }

    private function validarObsCEP(Amostra $objAmostra, Excecao $objExcecao) {
        if($objAmostra->getObsCEP() != null) {
            $strObsCep = trim($objAmostra->getObsCEP());


            if (strlen($strObsCep) > 300) {
                $objExcecao->adicionar_validacao('As observações de CEP possui mais que 300 caracteres', 'idObsCEPAmostra', 'alert-danger');
            }

           return $objAmostra->setObsCEP($strObsCep);
        }

    }
    
    private function validarObsHoraColeta(Amostra $objAmostra, Excecao $objExcecao) {
        if($objAmostra->getObsHoraColeta() != null) {
            $strObsHrColeta = trim($objAmostra->getObsHoraColeta());


            if (strlen($strObsHrColeta) > 300) {
                $objExcecao->adicionar_validacao('As observações da hora da coleta possui mais que 300 caracteres', 'idObsHoraColeta', 'alert-danger');
            }

            return $objAmostra->setObsHoraColeta($strObsHrColeta);
        }

    }
    
    private function validarObsLugarOrigem(Amostra $objAmostra, Excecao $objExcecao) {
        if($objAmostra->getObsLugarOrigem() != null) {
            $strObsLugarOrigem = trim($objAmostra->getObsLugarOrigem());


            if (strlen($strObsLugarOrigem) > 300) {
                $objExcecao->adicionar_validacao('As observações do lugar de origem da coleta possui mais que 300 caracteres', 'idObsLugarOrigem', 'alert-danger');
            }

            $objAmostra->setObsLugarOrigem($strObsLugarOrigem);
        }

    }
    
    private function validarMotivo(Amostra $objAmostra, Excecao $objExcecao) {
        if($objAmostra->getMotivoExame() != null) {
            $strMotivo = trim($objAmostra->getMotivoExame());


            if (strlen($strMotivo) > 100) {
                $objExcecao->adicionar_validacao('O motivo do exame possui mais que 100 caracteres', 'idMotivo', 'alert-danger');
            }

            $objAmostra->setMotivoExame($strMotivo);
        }

    }
    
    private function validarCEP(Amostra $objAmostra, Excecao $objExcecao) {
        if($objAmostra->getCEP() != null) {
            $strCEP = trim($objAmostra->getCEP());


            if (strlen($strCEP) > 8) {
                $objExcecao->adicionar_validacao('O CEP do exame possui mais que 8 caracteres', 'idCEPAmostra', 'alert-danger');
            }
            if (strlen($strCEP) < 8) {
                $objExcecao->adicionar_validacao('O CEP do exame menos que 8 caracteres', 'idCEPAmostra', 'alert-danger');
            }

            $objAmostra->setCEP($strCEP);
        }

    }
    
    private function validarPerfilAmostra(Amostra $objAmostra, Excecao $objExcecao) {
        
        if ($objAmostra->getIdPerfilPaciente_fk() == 0) {
            $objExcecao->adicionar_validacao('Informe o perfil da amostra','idPerfilAmostra','alert-danger');
        }

        // se o perfil é paciente sus, então o paciente tem que ter um código gal para esta amostra
        if($objAmostra->getIdPerfilPaciente_fk() > 0 ){

            $objPerfilPaciente = new PerfilPaciente();
            $objPerfilPacienteRN = new PerfilPacienteRN();

            $objPerfilPaciente->setIdPerfilPaciente($objAmostra->getIdPerfilPaciente_fk());
            $perfil = $objPerfilPacienteRN->listar($objPerfilPaciente);

            $objPaciente = new Paciente();
            $objPacienteRN = new PacienteRN();
            $objPaciente->setIdPaciente($objAmostra->getIdPaciente_fk());
            $objPaciente = $objPacienteRN->consultar($objPaciente);

            /*if($perfil[0]->getIndex_perfil() == 'PACIENTES SUS' && $objAmostra->getIdCodGAL_fk() == null){
                $objExcecao->adicionar_validacao('#O perfil da amostra exige que o paciente tenha um código GAL','idPerfilAmostra','alert-danger');
            }*/

            //if($perfil[0]->getIndex_perfil() == 'PACIENTES SUS' && $objPaciente->getCartaoSUS() == null){
            //    $objExcecao->adicionar_validacao('O perfil da amostra exige que o paciente tenha um cartão SUS','idPerfilAmostra','alert-danger');
            //}

            //$objExcecao->adicionar_validacao('O perfil da amostra exige que o paciente tenha um código GAL','idPerfilAmostra','alert-danger');


        }
       
    }

    private function validarPerfilCodGAL(Amostra $objAmostra, Excecao $objExcecao) {

            if ($objAmostra->getIdCodGAL_fk() != null) {
                $objPerfilPaciente = new PerfilPaciente();
                $objPerfilPacienteRN = new PerfilPacienteRN();

                $objPerfilPaciente->setIdPerfilPaciente($objAmostra->getIdPerfilPaciente_fk());
                $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
                if ($objPerfilPaciente->getIndex_perfil() != 'PACIENTES SUS') {
                    $objExcecao->adicionar_validacao('O perfil da amostra não permite que este paciente tenha um código GAL', null, 'alert-danger');
                }

            }
            if ($objAmostra->getIdCodGAL_fk() == null) {
                $objPerfilPaciente = new PerfilPaciente();
                $objPerfilPacienteRN = new PerfilPacienteRN();

                $objPerfilPaciente->setIdPerfilPaciente($objAmostra->getIdPerfilPaciente_fk());
                $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
                if ($objPerfilPaciente->getIndex_perfil() == 'PACIENTES SUS') {
                    $objExcecao->adicionar_validacao('O perfil da amostra exige que este paciente tenha um código GAL', null, 'alert-danger');
                }
            }

    }

    private function validarPerfilCartaoSUS(Amostra $objAmostra, Excecao $objExcecao) {
        // print_r($objAmostra);

        /*if($objAmostra->getObjPaciente() != null || $objAmostra->getIdCodGAL_fk() != null){
            if($objAmostra->getObjPaciente()->getCartaoSUS() != null){
                $objPerfilPaciente = new PerfilPaciente();
                $objPerfilPacienteRN = new PerfilPacienteRN();

                $objPerfilPaciente->setIdPerfilPaciente($objAmostra->getIdPerfilPaciente_fk());
                $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
                if($objPerfilPaciente->getIndex_perfil() != 'PACIENTES SUS'){
                    $objExcecao->adicionar_validacao('O perfil da amostra não permite que este paciente tenha um cartão SUS',null,'alert-danger');
                }
            }
        }*/

    }

    private function validarCamposDesconhecidos(Amostra $objAmostra, Excecao $objExcecao) {

        if($objAmostra->getCEP() == null && $objAmostra->getObsCEP() == null){
            $objAmostra->setObsCEP('Desconhecido');
        }

        if($objAmostra->getMotivoExame() == null && $objAmostra->getObsMotivo() == null){
            $objAmostra->setObsMotivo('Desconhecido');
        }

        if($objAmostra->getHoraColeta() == null && $objAmostra->getHoraColeta() == null){
            $objAmostra->setObsHoraColeta('Desconhecido');
        }

        if($objAmostra->getObsLugarOrigem() == null && $objAmostra->getIdLugarOrigem_fk() == null){
            $objAmostra->setObsLugarOrigem('Desconhecido');
        }

    }






    public function cadastrar(Amostra $amostra) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            //print_r($amostra->getObjPaciente());
            //existe o obj paciente
            if($amostra->getObjPaciente() != null){
                if($amostra->getObjPaciente()->getIdPaciente() == null) {

                    $objPacienteRN = new PacienteRN();
                    $objPaciente = $objPacienteRN->cadastrar($amostra->getObjPaciente());
                    $amostra->setIdPaciente_fk($objPaciente->getIdPaciente());
                    if ($objPaciente->getObjCodGAL() != null) {
                        if ($objPaciente->getObjCodGAL()->getIdCodigoGAL() != null) {
                            $amostra->setIdCodGAL_fk($objPaciente->getObjCodGAL()->getIdCodigoGAL());
                        }
                    }
                }else{ // nesse objeto paciente já havia sido cadastrado

                    $objPacienteRN = new PacienteRN();
                    $objPaciente  = $objPacienteRN->alterar($amostra->getObjPaciente());
                    $amostra->setObjPaciente($objPaciente);
                    $amostra->setIdPaciente_fk($objPaciente->getIdPaciente());
                    if ($objPaciente->getObjCodGAL() != null) {
                        if ($objPaciente->getObjCodGAL()->getIdCodigoGAL() != null) {
                            $amostra->setIdCodGAL_fk($objPaciente->getObjCodGAL()->getIdCodigoGAL());
                        }
                    }
                }
                              
            }

            //$this->validarPerfilCodGAL($amostra,$objExcecao);
            $this->validarObservacoes($amostra,$objExcecao);
            $this->validar_a_r_g($amostra,$objExcecao);
            $this->validarDataColeta($amostra,$objExcecao);
            $this->validarObsCEP($amostra,$objExcecao);
            $this->validarObsHoraColeta($amostra,$objExcecao);
            $this->validarObsLugarOrigem($amostra, $objExcecao);
            $this->validarObsMotivo($amostra, $objExcecao);
            $this->validarMotivo($amostra, $objExcecao);
            $this->validarCEP($amostra, $objExcecao);
            $this->validarPerfilCartaoSUS($amostra, $objExcecao);
            $this->validarPerfilAmostra($amostra, $objExcecao);
            $this->validarCamposDesconhecidos($amostra, $objExcecao);
            $this->validarNickname($amostra,$objExcecao);

            $objPerfilPaciente = new PerfilPaciente();
            $objPerfilPacienteRN = new PerfilPacienteRN();
            $objPerfilPaciente->setIdPerfilPaciente($amostra->getIdPerfilPaciente_fk());
            $arr_perfil = $objPerfilPacienteRN->listar($objPerfilPaciente);
            $objAmostraBD = new AmostraBD();
            //$idNickname = $objAmostraBD->alterar_nickname($amostra,$objBanco);
            //$amostra->setNickname($arr_perfil[0]->getCaractere() . ($idNickname+1));

            $objExcecao->lancar_validacoes();

            $objAmostraBD->cadastrar($amostra,$objBanco); //cadastra sem o código pq precisa do ID
            $amostra->setCodigoAmostra($arr_perfil[0]->getCaractere() . $amostra->getIdAmostra());
            $objAmostraAuxRN = new AmostraRN();
            $objAmostraAuxRN->alterar($amostra);

            if($amostra->getObjTubo() != null){

                $objTuboRN = new TuboRN();
                if($amostra->getObjTubo()->getIdTubo() == null) { //tubo ainda não cadastrado
                    if ($amostra->get_a_r_g() != 'g') {
                        $objTubo = $amostra->getObjTubo();
                        $objTubo->setIdAmostra_fk($amostra->getIdAmostra());
                        $amostra->setObjTubo($objTuboRN->cadastrar($objTubo));

                    }
                }else {
                    $amostra->setObjTubo($objTuboRN->alterar($amostra->getObjTubo()));
                }
               
            }

            $objLaudo = new Laudo();
            if($amostra->getObjLaudo() != null){
                $objLaudoRN = new LaudoRN();
                if($amostra->getObjLaudo()->getIdLaudo() == null) { //laudo ainda não cadastrado

                    $objLaudo->setIdAmostraFk($amostra->getIdAmostra());
                    $objLaudo = $objLaudoRN->cadastrar($objLaudo);
                    $amostra->setObjLaudo($objLaudo);
                }else {
                   // $amostra->setObjTubo($objTuboRN->alterar($amostra->getObjTubo()));
                }
            }


            //print_r($objTubo);
            //print_r($amostra);
            //die("rn 40");
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $amostra;
                   
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando amostra.', $e);
        }
    }

    public function alterar(Amostra $amostra) {

        $objBanco = new Banco();
        try {
             
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();


             if($amostra->getObjPaciente() != null){
                 if($amostra->getObjPaciente()->getIdPaciente() == null) {
                     $objExcecao->adicionar_validacao('Não existe paciente cadastrado para esta amostra ',null,'alert-danger');
                 }else{ // nesse objeto paciente já havia sido cadastrado
                     $objPacienteRN = new PacienteRN();
                     $objPaciente  = $objPacienteRN->alterar($amostra->getObjPaciente());
                     $amostra->setObjPaciente($objPaciente);
                     $amostra->setIdPaciente_fk($objPaciente->getIdPaciente());

                     if($objPaciente->getObjCodGAL() != null &&
                         $objPaciente->getObjCodGAL()->getIdCodigoGAL() != null) {
                         $amostra->setIdCodGAL_fk($objPaciente->getObjCodGAL()->getIdCodigoGAL());
                     }
                 }
                 $amostra->setObjPaciente($objPaciente);
             }



            $this->validarObservacoes($amostra,$objExcecao);
            $this->validar_a_r_g($amostra,$objExcecao);
            $this->validarDataColeta($amostra,$objExcecao);
            $this->validarPerfilCartaoSUS($amostra, $objExcecao);
            //$this->validarPerfilCodGAL($amostra,$objExcecao);
            $this->validarObsCEP($amostra,$objExcecao);
            $this->validarObsHoraColeta($amostra,$objExcecao);
            $this->validarObsLugarOrigem($amostra, $objExcecao);
            $this->validarObsMotivo($amostra, $objExcecao);
            $this->validarMotivo($amostra, $objExcecao);
            $this->validarCEP($amostra, $objExcecao);

            $this->validarNickname($amostra);


            $objExcecao->lancar_validacoes();

            $objAmostraBD = new AmostraBD();
            $objAmostraBD->alterar($amostra,$objBanco);

             if($amostra->getObjTubo() != null){
                 $objTuboRN = new TuboRN();

                 if($amostra->getObjTubo()->getIdTubo() == null) { //tubo ainda não cadastrado

                         $objTubo = $amostra->getObjTubo();
                         $objTubo->setIdAmostra_fk($amostra->getIdAmostra());
                         $amostra->setObjTubo($objTuboRN->cadastrar($objTubo));

                 }else {
                     $objTuboRN->alterar($amostra->getObjTubo());
                 }

             }

            if($amostra->getObjLaudo() != null){
                $objLaudoRN = new LaudoRN();
                if($amostra->getObjLaudo()->getIdLaudo() == null) { //laudo ainda não cadastrado
                    $amostra->getObjLaudo()->setIdAmostraFk($amostra->getIdAmostra());
                    $objLaudo = $objLaudoRN->cadastrar($amostra->getObjLaudo());
                    $amostra->setObjLaudo($objLaudo);
                }else {
                    // $amostra->setObjTubo($objTuboRN->alterar($amostra->getObjTubo()));
                }
            }


            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
             return $amostra;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando amostra.', $e);
        }
    }

    public function consultar(Amostra $amostra) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();

            $objAmostraBD = new AmostraBD();
            $arr = $objAmostraBD->consultar($amostra,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando amostra.', $e);
        }
    }

    public function remover(Amostra $amostra) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();


            $objTubo = new Tubo();
            $objTuboRN = new TuboRN();
            $objTubo->setIdAmostra_fk($amostra->getIdAmostra());
            $arr_tubos = $objTuboRN->listar($objTubo);

            $objInfosTubo = new InfosTubo();
            $objInfosTuboRN = new InfosTuboRN();

            foreach ($arr_tubos as $tubo){
                $objInfosTubo->setIdTubo_fk($tubo->getIdTubo());
                $arr_infosTubo = $objInfosTuboRN->listar($objInfosTubo);
                $objTuboRN->remover($tubo);
            }

            foreach ($arr_infosTubo as $infoTubo){
                $objInfosTuboRN->remover($infoTubo);
            }

            $objAmostraBD = new AmostraBD();
            $arr =  $objAmostraBD->remover($amostra,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo amostra.',  $e);
        }
    }

    public function listar(Amostra $amostra) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();

            $objAmostraBD = new AmostraBD();
            $arr =  $objAmostraBD->listar($amostra,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando amostra.', $e);
        }
    }

    public function listar_especial(Amostra $amostra) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();

            $objAmostraBD = new AmostraBD();
            $arr =  $objAmostraBD->listar_especial($amostra,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando amostra.', $e);
        }
    }


    public function listar_aguardando_sol_montagem_placa_RTqCPR(Amostra $amostra) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();

            $objAmostraBD = new AmostraBD();
            $arr =  $objAmostraBD->listar_aguardando_sol_montagem_placa_RTqCPR($amostra,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando amostra.', $e);
        }
    }
    
    public function validarCadastro(Amostra $amostra) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $arr_resultado = array();
            $cadastrar = true;
            $objAmostraRN = new AmostraRN();
            $arr_amostras = $objAmostraRN->listar($amostra);
                        
            foreach ($arr_amostras as $a){
                if($a->get_a_r_g() == $amostra->get_a_r_g() &&
                   $a->getObservacoes() == $amostra->getObservacoes() &&
                   strtotime ($a->getDataColeta()) == strtotime($amostra->getDataColeta()) &&
                   strtotime ($a->getHoraColeta()) == strtotime($amostra->getHoraColeta()) &&
                   $a->getIdEstado_fk() == $amostra->getIdEstado_fk() && 
                   $a->getIdLugarOrigem_fk() == $amostra->getIdLugarOrigem_fk() &&
                   $a->getIdPaciente_fk() == $amostra->getIdPaciente_fk() && 
                   $a->getIdNivelPrioridade_fk() == $amostra->getIdNivelPrioridade_fk() && 
                   $a->getObsCEP() == $amostra->getObsCEP() && 
                   $a->getObsHoraColeta() == $amostra->getObsHoraColeta() && 
                   $a->getObsLugarOrigem() == $amostra->getObsLugarOrigem() && 
                   $a->getObsMotivo() == $amostra->getObsMotivo() && 
                   $a->getMotivoExame() == $amostra->getMotivoExame()){
                     $amostra->setIdAmostra($a->getIdAmostra());
                     $cadastrar = false;
                     //return $arr_resultado;
                }
            }
            
            if($cadastrar){
                return $arr_resultado;
            }else{
                $objAmostraBD = new AmostraBD();
                $arr_resultado =  $objAmostraBD->consultar($amostra,$objBanco);
                $objBanco->fecharConexao();
            
            }
            return $arr_resultado;
        } catch (Throwable $e) {
            throw new Excecao('Erro listando amostra.', $e);
        }
    }

    private function validarNickname(Amostra $objAmostra) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            if($objAmostra->getNickname() != null) {
                $strNickname = trim($objAmostra->getNickname());



                if($objAmostra->getIdPerfilPaciente_fk() != null) {
                    $objPerfilPaciente = new PerfilPaciente();
                    $objPerfilPacienteRN = new PerfilPacienteRN();
                    $objPerfilPaciente->setIdPerfilPaciente($objAmostra->getIdPerfilPaciente_fk());
                    $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);


                    if ($objPerfilPaciente->getCaractere() != $strNickname[0]) {
                        $objExcecao->adicionar_validacao('O primeiro catactere do código da amostra não condiz com o perfil informado', 'idObsLugarOrigem', 'alert-danger');
                    }
                }

                if (strlen($strNickname) == 0) {
                    $objExcecao->adicionar_validacao('O código da amostra precisa ser informado', 'idObsLugarOrigem', 'alert-danger');
                } else {
                    if (strlen($strNickname) > 6) {
                        $objExcecao->adicionar_validacao('O código da amostra possui mais que 6 caracteres', 'idObsLugarOrigem', 'alert-danger');
                    }
                    $objAmostraBD = new AmostraBD();
                    if ($objAmostraBD->validar_nickname($objAmostra, $objBanco) != null) {
                        $objExcecao->adicionar_validacao('O código da amostra já está associado a outra amostra', 'idObsLugarOrigem', 'alert-danger');
                    }

                    if(strlen($strNickname) > 0  && strlen($strNickname) <= 6){
                        for($i =0; $i<strlen($strNickname); $i++){
                            if($i == 0 && is_numeric($strNickname[0])){
                                $objExcecao->adicionar_validacao('O código da amostra deve possuir como primeiro caractere uma letra', 'idObsLugarOrigem', 'alert-danger');
                                break;
                            }else if($i > 0 && !is_numeric($strNickname[$i])){
                                $objExcecao->adicionar_validacao('O código da amostra deve possuir números a partir do 2º caractere', 'idObsLugarOrigem', 'alert-danger');
                                break;
                            }
                        }
                    }
                }
            }else{
                $objExcecao->adicionar_validacao('O código da amostra precisa ser informado', 'idObsLugarOrigem', 'alert-danger');
            }
            $objExcecao->lancar_validacoes();

            $objAmostra->setNickname($strNickname);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objAmostra;
        }catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando amostra.', $e);
        }

    }


    public function filtro_menor_data(Amostra $amostra,$select) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();

            $objAmostraBD = new AmostraBD();
            $arr =  $objAmostraBD->filtro_menor_data($amostra,$select,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando amostra.', $e);
        }
    }

    public function filtrar_por_quantidade(Amostra $amostra) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();

            $objAmostraBD = new AmostraBD();
            $arr =  $objAmostraBD->filtrar_por_quantidade($amostra,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando amostra.', $e);
        }
    }


    public function listar_ids(Amostra $amostra) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();

            $objAmostraBD = new AmostraBD();
            $arr =  $objAmostraBD->listar_ids($amostra,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando amostra.', $e);
        }
    }


    public function arrumar_banco(Amostra $amostra) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();

            $objAmostraBD = new AmostraBD();

            $arr =  $objAmostraBD->arrumar_banco1($amostra,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando amostra.', $e);
        }
    }

    public function obter_infos(Amostra $amostra) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();

            $objAmostraBD = new AmostraBD();
            $arr =  $objAmostraBD->obter_infos($amostra,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando amostra.', $e);
        }
    }

    public function obter_locais(Amostra $amostra) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();

            $objAmostraBD = new AmostraBD();
            $arr =  $objAmostraBD->obter_locais($amostra,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando amostra.', $e);
        }
    }


  
  

}

