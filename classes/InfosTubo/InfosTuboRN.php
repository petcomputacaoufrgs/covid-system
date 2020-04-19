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

        //if($strIdLocalArmazenamento_fk == '' || $strIdLocalArmazenamento_fk == null){
        //    $objExcecao->adicionar_validacao('O ID do local de armazenamento não foi informado.', 'idLocalArmazenamento_fk');
        //}

        return $infosTubo->setIdLocalArmazenamento_fk($strIdLocalArmazenamento_fk);
    }

    private function validarIdTubo_fk(InfosTubo $infosTubo, Excecao $objExcecao){
        $strIdTubo_fk = trim($infosTubo->getIdTubo_fk());

        //if($strIdTubo_fk == '' || $strIdTubo_fk == null){
        //    $objExcecao->adicionar_validacao('O ID do tubo não foi informado.', 'idTubo_fk');
        //}

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
            $objExcecao->adicionar_validacao('O nome da etapa nao foi informada.', 'idEtapa');
        }else{
            if(strlen($strEtapa) > 100){
                $objExcecao->adicionar_validacao('O nome da etapa possui mais que 100 caracteres.','idEtapa');
            }
        }

        return $infosTubo->setEtapa($strEtapa);
    }

    private function validarDataHora(InfosTubo $infosTubo, Excecao $objExcecao){
        $dthr = trim($infosTubo->getDataHora());
        echo $infosTubo->getDataHora();
        echo strlen($infosTubo->getDataHora());
        if (strlen($infosTubo->getDataHora()) == 0) {
            $objExcecao->adicionar_validacao('Informar a data e hora.','idDataHora');
        }else{
            //echo $dthr;
            
            $strDataHora = explode(" ", "$dthr");
            
            $data = explode("-", "$strDataHora[0]");
            $hora = explode(":", "$strDataHora[1]");

            $ano = $data[0];
            $mes = $data[1];
            $dia = $data[2];
            
           
            /* Verifica se eh valida*/
            $res_data = checkdate($mes, $dia, $ano);
            
            
            if(!$res_data){
                $objExcecao->adicionar_validacao('Informar a data valida.','idDataHora');
            }else{
                $hoje = explode(date("Y/m/d"));
                $h_ano = $hoje[0];
                $h_mes = $hoje[1];
                $h_dia = $hoje[2];

                if(($h_ano < $ano) || 
                (($h_ano == $ano) && ($h_mes < $mes)) || 
                (($h_ano == $ano) && ($h_mes == mes) && ($h_dia < $dia))){
                    $objExcecao->adicionar_validacao('Informar a data valida.','idDataHora');
                }
            }
        }
        
        $infosTubo->setDataHora($dthr);
    }

    private function validarVolume(InfosTubo $infosTubo, Excecao $objExcecao){
        $strVolume = trim($infosTubo->getVolume());
        
        /*if($strVolume == ''){
            $objExcecao->adicionar_validacao('Informe um volume.','idVolume');
        }*/
                           
        return $infosTubo->setVolume($strVolume);
    }

    public function cadastrar(InfosTubo $infosTubo){
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
            $objInfosTuboBD->cadastrar($infosTubo,$objBanco);

            $objBanco->fecharConexao();
            
        }catch (Throwable $e){
            die($e);
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
        }catch (Throwable $e){
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
        }catch (Throwable $e){
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
        }catch (Throwable $e){
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
        }catch (Throwable $e){
            throw new Excecao('Erro na listagem das informacoes do tubo.', $e);
        }
    }
}