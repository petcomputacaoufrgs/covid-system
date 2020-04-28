<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/CadastroAmostraBD.php';

class CadastroAmostraRN{
   
    public function cadastrar(CadastroAmostra $cadastroAmostra) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            //print_r($cadastroAmostra);

            if($cadastroAmostra->getObjAmostra() != null){
                $objAmostraRN = new AmostraRN();
                if($cadastroAmostra->getObjAmostra()->getIdAmostra() == null) {
                    $objAmostra = $objAmostraRN->cadastrar($cadastroAmostra->getObjAmostra());
                }else{
                    $objAmostra =$objAmostraRN->alterar($cadastroAmostra->getObjAmostra());
                }
                $cadastroAmostra->setIdAmostra_fk($objAmostra->getIdAmostra());
                $cadastroAmostra->setObjAmostra($objAmostra);
            }

            $objExcecao->lancar_validacoes();
            $objCadastroAmostraBD = new CadastroAmostraBD();
            $objCadastroAmostraBD->cadastrar($cadastroAmostra,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            
            return $cadastroAmostra;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando amostra.', $e);
        }
    }

    public function alterar(CadastroAmostra $cadastroAmostra) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 

            
            $objExcecao->lancar_validacoes();
            
            $objCadastroAmostraBD = new CadastroAmostraBD();
            $objCadastroAmostraBD->alterar($cadastroAmostra,$objBanco);
            $objBanco->fecharConexao();

        } catch (Throwable $e) {
            throw new Excecao('Erro alterando amostra.', NULL, $e);
        }
    }

    public function consultar(CadastroAmostra $cadastroAmostra) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objCadastroAmostraBD = new CadastroAmostraBD();
            $arr = $objCadastroAmostraBD->consultar($cadastroAmostra,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Throwable $e) {
            throw new Excecao('Erro consultando amostra.', NULL, $e);
        }
    }

    public function remover(CadastroAmostra $cadastroAmostra) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objCadastroAmostraBD = new CadastroAmostraBD();
            $arr =  $objCadastroAmostraBD->remover($cadastroAmostra,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro removendo amostra.', NULL, $e);
        }
    }

    public function listar(CadastroAmostra $cadastroAmostra) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objCadastroAmostraBD = new CadastroAmostraBD();
            $arr =  $objCadastroAmostraBD->listar($cadastroAmostra,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            throw new Excecao('Erro listando amostra.', NULL, $e);
        }
    }
    
    
    
     public function consultarData(CadastroAmostra $cadastroAmostra,$data) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
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
            
            
            $objBanco->fecharConexao();
            return $arr_resultado;
        } catch (Throwable $e) {
            throw new Excecao('Erro listando amostra.', NULL, $e);
        }
    }
    
    
  
  

}

