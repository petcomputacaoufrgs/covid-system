<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/CadastroAmostraBD.php';

class CadastroAmostraRN{

    private function validarIdCadastroAmostra(CadastroAmostra $cadastroAmostra,Excecao $objExcecao){

        if (is_null($cadastroAmostra->getIdCadastroAmostra())) {
            $objExcecao->adicionar_validacao('O identificador do cadastro amostra não foi informado',null, 'alert-danger');
        }else{
            $numIdCadastroAmostra = trim($cadastroAmostra->getIdCadastroAmostra());
            $cadastroAmostra->setIdCadastroAmostra(intval($numIdCadastroAmostra));
        }
    }

    private function validarIdAmostra(CadastroAmostra $cadastroAmostra,Excecao $objExcecao){

        if (is_null($cadastroAmostra->getIdAmostra_fk())) {
            $objExcecao->adicionar_validacao('O identificador da amostra não foi informado',null, 'alert-danger');
        }else{

        }
    }

    private function validarCadastroAmostra(CadastroAmostra $cadastroAmostra,Excecao $objExcecao){
        $numIdAmostra = $cadastroAmostra->getIdAmostra_fk();
        $objCadastroAmostraAux = new CadastroAmostra();
        $objCadastroAmostraAuxRN = new CadastroAmostraRN();
        $objCadastroAmostraAux->setIdAmostra_fk($numIdAmostra);
        $arr_cadastros = $objCadastroAmostraAuxRN->listar($objCadastroAmostraAux,1);
        if(count($arr_cadastros) > 0){
            $objExcecao->adicionar_validacao('Essa amostra já foi cadastrada',null, 'alert-danger');
        }
        $cadastroAmostra->setIdAmostra_fk(intval($numIdAmostra));
    }
    private function validarIdUsuario(CadastroAmostra $cadastroAmostra,Excecao $objExcecao){

        if (is_null($cadastroAmostra->getIdUsuario_fk())) {
            $objExcecao->adicionar_validacao('O identificador do usuário não foi informado',null, 'alert-danger');
        }else{
            $numIdUsuario = trim($cadastroAmostra->getIdUsuario_fk());
            $cadastroAmostra->setIdUsuario_fk(intval($numIdUsuario));
        }
    }
   
    public function cadastrar(CadastroAmostra $cadastroAmostra) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            //

            if($cadastroAmostra->getObjAmostra() != null){
                $objAmostraRN = new AmostraRN();
                if($cadastroAmostra->getObjAmostra()->getIdAmostra() == null) {
                    $objAmostra = $objAmostraRN->cadastrar($cadastroAmostra->getObjAmostra());
                }else{
                    //$this->validarCadastroAmostra($cadastroAmostra,$objExcecao);
                    //$objExcecao->lancar_validacoes();
                    $objAmostra =$objAmostraRN->alterar($cadastroAmostra->getObjAmostra());
                }
                $cadastroAmostra->setIdAmostra_fk($objAmostra->getIdAmostra());
                $cadastroAmostra->setObjAmostra($objAmostra);
            }

//die();
            $this->validarIdAmostra($cadastroAmostra,$objExcecao);
            $this->validarIdUsuario($cadastroAmostra,$objExcecao);


            $objCadastroAmostraBD = new CadastroAmostraBD();
            $cadastroAmostra = $objCadastroAmostraBD->cadastrar($cadastroAmostra,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $cadastroAmostra;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando amostra (CadastroAmostraRN).', $e);
        }
    }

    public function alterar(CadastroAmostra $cadastroAmostra) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdCadastroAmostra($cadastroAmostra,$objExcecao);
            $this->validarIdAmostra($cadastroAmostra,$objExcecao);
            $objExcecao->lancar_validacoes();
            
            $objCadastroAmostraBD = new CadastroAmostraBD();
            $cadastro  = $objCadastroAmostraBD->alterar($cadastroAmostra,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $cadastro;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando amostra (CadastroAmostraRN).',  $e);
        }
    }

    public function consultar(CadastroAmostra $cadastroAmostra) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdCadastroAmostra($cadastroAmostra,$objExcecao);
            $objExcecao->lancar_validacoes();

            $objCadastroAmostraBD = new CadastroAmostraBD();
            $arr = $objCadastroAmostraBD->consultar($cadastroAmostra,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando amostra (CadastroAmostraRN).',  $e);
        }
    }

    public function remover(CadastroAmostra $cadastroAmostra) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdCadastroAmostra($cadastroAmostra,$objExcecao);
            $objExcecao->lancar_validacoes();

            $objCadastroAmostraBD = new CadastroAmostraBD();
            $objCadastroAmostraBD->remover($cadastroAmostra,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();

        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo amostra (CadastroAmostraRN).',  $e);
        }
    }

    public function remover_banco(CadastroAmostra $cadastroAmostra) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objCadastroAmostraBD = new CadastroAmostraBD();
            $objCadastroAmostraBD->remover_banco($cadastroAmostra,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();

        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo amostra (CadastroAmostraRN).',  $e);
        }
    }

    public function listar(CadastroAmostra $cadastroAmostra,$numLimite = null) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objCadastroAmostraBD = new CadastroAmostraBD();
            $arr =  $objCadastroAmostraBD->listar($cadastroAmostra,$numLimite,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando amostra (CadastroAmostraRN).',  $e);
        }
    }

    public function paginacao(CadastroAmostra $cadastroAmostra) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objCadastroAmostraBD = new CadastroAmostraBD();
            $arr =  $objCadastroAmostraBD->paginacao($cadastroAmostra,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando amostra (CadastroAmostraRN).',  $e);
        }
    }

    public function consultarData(CadastroAmostra $cadastroAmostra,$data) {
         $objBanco = new Banco();
         try {

             $objExcecao = new Excecao();
             $objBanco->abrirConexao();
             $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            
                        
            $dataAux  = explode("/", $data);
            
            $diaOriginal = $dataAux[0];
            $mesOriginal = $dataAux[1];
            $anoOriginal = $dataAux[2];
            
           
            $objCadastroAmostraBD = new CadastroAmostraBD();
            $arr =  $objCadastroAmostraBD->listar($cadastroAmostra,$objBanco);
            $arr_resultado = array();
            foreach ($arr as $ca){
                
                $datahora = $ca->getDataHoraInicio();
                $strDataHora = explode(" ", $datahora);
            
                $data = explode("-", "$strDataHora[0]");
                
                $ano = $data[0];
                $mes = $data[1];
                $dia = $data[2];
                
                //echo $diaOriginal;
                
                if($dia == $diaOriginal && $mes == $mesOriginal && $ano == $anoOriginal ){
                    $arr_resultado[] = $ca;
                }
            }


             $objBanco->confirmarTransacao();
             $objBanco->fecharConexao();
             return $arr;
         } catch (Throwable $e) {
             $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando amostra (CadastroAmostraRN).',  $e);
        }
    }

    public function listar_completo(CadastroAmostra $cadastroAmostra,$datas=null,$numLimite=null) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();

            $objCadastroAmostraBD = new CadastroAmostraBD();
            $arr =  $objCadastroAmostraBD->listar_completo($cadastroAmostra,$datas,$numLimite,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando amostra (CadastroAmostraRN).',  $e);
        }
    }


}

