<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do detentor do paciente
 */

require_once 'classes/Excecao/Excecao.php';
require_once 'classes/LocalArmazenamento/LocalArmazenamentoBD.php';

class LocalArmazenamentoRN{
    

    private function validarDataHoraInicio(LocalArmazenamento $localArmazenamento,Excecao $objExcecao){
        $strDataHoraInicio = trim($localArmazenamento->getDataHoraInicio());
        /*
        if ($strDataHoraInicio == '') {
            $objExcecao->adicionar_validacao('A data/hora inicío não foi informada','idLocalArmazenamento');
        }else{
            
        }
        */
        return $localArmazenamento->setDataHoraInicio($strDataHoraInicio);

    }
    
    private function validarDataHoraFim(LocalArmazenamento $localArmazenamento,Excecao $objExcecao){
        $strDataHoraFim = trim($localArmazenamento->getDataHoraFim());
        /*
        if ($strDataHoraInicio == '') {
            $objExcecao->adicionar_validacao('A data/hora inicío não foi informada','idLocalArmazenamento');
        }else{
            
        }
        */
        return $localArmazenamento->setDataHoraInicio($strDataHoraFim);

    }
     

    public function cadastrar(LocalArmazenamento $localArmazenamento) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarDataHoraFim($localArmazenamento,$objExcecao); 
            $this->validarDataHoraInicio($localArmazenamento,$objExcecao); 
            
            $objExcecao->lancar_validacoes();
            $objLocalArmazenamentoBD = new LocalArmazenamentoBD();
            $objLocalArmazenamentoBD->cadastrar($localArmazenamento,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando o local de armazenamento.', $e);
        }
    }

    public function alterar(LocalArmazenamento $localArmazenamento) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarDataHoraFim($localArmazenamento,$objExcecao);   
            $this->validarDataHoraInicio($localArmazenamento,$objExcecao); 
            
            $objExcecao->lancar_validacoes();
            $objLocalArmazenamentoBD = new LocalArmazenamentoBD();
            $objLocalArmazenamentoBD->alterar($localArmazenamento,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando o local de armazenamento.', $e);
        }
    }

    public function consultar(LocalArmazenamento $localArmazenamento) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objLocalArmazenamentoBD = new LocalArmazenamentoBD();
            $arr =  $objLocalArmazenamentoBD->consultar($localArmazenamento,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando o local de armazenamento.',$e);
        }
    }

    public function remover(LocalArmazenamento $localArmazenamento) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objLocalArmazenamentoBD = new LocalArmazenamentoBD();
            $arr =  $objLocalArmazenamentoBD->remover($localArmazenamento,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo o local de armazenamento.', $e);
        }
    }

    public function listar(LocalArmazenamento $localArmazenamento) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objLocalArmazenamentoBD = new LocalArmazenamentoBD();
            
            $arr = $objLocalArmazenamentoBD->listar($localArmazenamento,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o local de armazenamento.',$e);
        }
    }


    public function pesquisar($campoBD, $valor_usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objLocalArmazenamentoBD = new LocalArmazenamentoBD();
            $arr = $objLocalArmazenamentoBD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando o local de armazenamento.', $e);
        }
    }

}

?>
