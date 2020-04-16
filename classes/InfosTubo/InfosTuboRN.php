<?php

/*************************************
*   Classe das regras de negocio das * 
*   informacoes dos tubos            *
**************************************/ 

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/InfosTuboBD.php';

class InfosTuboRN{

    private function validarIdLocalArmazenamento_fk(InfosTubo $infosTubo, Excecao $objExcecao){
        $strIdLocalArmazenamento_fk = trim($infosTubo->getIdLocalArmazenamento_fk());

        if($strIdLocalArmazenamento_fk == '' || $strIdLocalArmazenamento_fk == null){
            $objExcecao->adicionar_validacao('O ID do local de armazenamento não foi informado.', 'idLocalArmazenamento_fk');
        }

        return $infosTubo->setIdLocalArmazenamento_fk($strIdLocalArmazenamento_fk);
    }

    private function validarIdTubo_fk(InfosTubo $infosTubo, Excecao $objExcecao){
        $strIdTubo_fk = trim($infosTubo->getIdTubo_fk());

        if($strIdTubo_fk == '' || $strIdTubo_fk == null){
            $objExcecao->adicionar_validacao('O ID do tubo não foi informado.', 'idTubo_fk');
        }

        return $infosTubo->setIdTubo_fk($strIdTubo_fk);
    }

    private function validarStatusTubo(InfosTubo $infosTubo, Excecao $objExcecao){
        $strStatusTubo = trim($infosTubo->getStatusTubo());

        if($strStatusTubo == ''){
            $objExcecao->adicionar_validacao('O status do tubo nao foi informado.', 'idStatusTubo');
        }else{
            if(strlen($strStatusTubo) > 100){
                $objExcecao->adicionar_validacao('O status do tubo possui mais que 100 caracteres.','idStatusTubo');
            }
        }

        return $infosTubo->setStatusTubo($strStatusTubo);
    }

    private function validarEtapa(InfosTubo $infosTubo, Excecao $objExcecao){
        $strEtapa = trim($infosTubo->getEtapa());

        if($strEtapa == ''){
            $objExcecao->adicionar_validacao('O a etapa nao foi informada.', 'idEtapa');
        }else{
            if(strlen($strEtapa) > 100){
                $objExcecao->adicionar_validacao('O nome da etapa possui mais que 100 caracteres.','idEtapa');
            }
        }

        return $infosTubo->setEtapa($strEtapa);
    }

    private function validarDataHora(InfosTubo $infosTubo, Excecao $objExcecao){
        $strDataHora = trim($infosTubo->getDataHora());
       
        if ($strDataHora == '') {
            $objExcecao->adicionar_validacao('Informar a data e hora.','idDataHora');
        }
        $infosTubo->setDataHora($strDataHora);
    }

    private function validarVolume(InfosTubo $infosTubo, Excecao $objExcecao){
        $strVolume = trim($infosTubo->getVolume());
        
        if($strRG == ''){
            $objExcecao->adicionar_validacao('Informe um volume.','idVolume');
        }
                           
        return $infosTubo->setVolume($strVolume);
    }

    public function cadastrar(InfosTubo $infosTubo){
        try{

            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objInfosTuboBD = new InfosTuboBD();

            $this->validarIdLocalArmazenamento_fk($infosTubo, $objExcecao);
            $this->validarIdTubo_fk($infosTubo, $objExcecao);
            $this->validarStatusTubo($infosTubo, $objExcecao);
            $this->validarEtapa($infosTubo, $objExcecao);
            $this->validarDataHora($infosTubo, $objExcecao);
            $this->validarVolume($infosTubo, $objExcecao);

            $objExcecao->lancar_validacoes();
            $objInfosTuboBD = new infosTuboBD();
            $objInfosTuboBD->cadastrar($infosTubo,$objBanco);

            $objBanco->fecharConexao();
        }catch (Exception $e){
            throw new Excecao('Erro no cadastramento das informacoes do tubo.', $e);
        }
    }

    public function alterar(InfosTubo $infosTubo){
        try{

            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 

            $this->validarIdLocalArmazenamento_fk($infosTubo, $objExcecao);
            $this->validarIdTubo_fk($infosTubo, $objExcecao);
            $this->validarStatusTubo($infosTubo, $objExcecao);
            $this->validarEtapa($infosTubo, $objExcecao);
            $this->validarDataHora($infosTubo, $objExcecao);
            $this->validarVolume($infosTubo, $objExcecao);

            $objExcecao->lancar_validacoes();
            $objInfosTuboBD = new infosTuboBD();
            $objInfosTuboBD->alterar($infosTubo,$objBanco);

            $objBanco->fecharConexao();
        }catch (Exception $e){
            throw new Excecao('Erro na alteração das informacoes do tubo.', $e);
        }
    }

    public function consultar(InfosTubo $infosTubo){
        try{

            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objInfosTuboBD = new infosTuboBD();
            $arr = $objInfosTuboBD->consultar($infosTubo,$objBanco);

            $objBanco->fecharConexao();
            return $arr;
        }catch (Exception $e){
            throw new Excecao('Erro na consulta das informacoes do tubo.', $e);
        }
    }

    public function remover(InfosTubo $infosTubo){
        try{
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objInfosTuboBD = new infosTuboBD();
            $arr = $objInfosTuboBD->remover($infosTubo,$objBanco);

            $objBanco->fecharConexao();
            return $arr;
        }catch (Exception $e){
            throw new Excecao('Erro na remoção das informacoes do tubo.', $e);
        }
    }

    public function listar(InfosTubo $infosTubo){
        try{
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objInfosTuboBD = new infosTuboBD();
            $arr = $objInfosTuboBD->listar($infosTubo,$objBanco);

            $objBanco->fecharConexao();
            return $arr;
        }catch (Exception $e){
            throw new Excecao('Erro na listagem das informacoes do tubo.', $e);
        }
    }





}