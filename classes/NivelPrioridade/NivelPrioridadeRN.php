<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do nível de prioridade do paciente
 */

require_once '../classes/Excecao/Excecao.php';
require_once '../classes/NivelPrioridade/NivelPrioridadeBD.php';

class NivelPrioridadeRN{
    

    private function validarNivelPrioridade(NivelPrioridade $nivelPrioridade,Excecao $objExcecao){
        $strNivelPrioridade = trim($nivelPrioridade->getNivel());
        
        if ($strNivelPrioridade == '') {
            $objExcecao->adicionar_validacao('O nível de prioridade não foi informado','idNivelPrioridade');
        }        
        return $nivelPrioridade->setNivel($strNivelPrioridade);

    }
     

    public function cadastrar(NivelPrioridade $nivelPrioridade) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarNivelPrioridade($nivelPrioridade,$objExcecao); 
            $objExcecao->lancar_validacoes();
            $objNivelPrioridadeBD = new NivelPrioridadeBD();
            $objNivelPrioridadeBD->cadastrar($nivelPrioridade,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando o nível de prioridade.', $e);
        }
    }

    public function alterar(NivelPrioridade $nivelPrioridade) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarNivelPrioridade($nivelPrioridade,$objExcecao);   
                        
            $objExcecao->lancar_validacoes();
            $objNivelPrioridadeBD = new NivelPrioridadeBD();
            $objNivelPrioridadeBD->alterar($nivelPrioridade,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando o nível de prioridade.', $e);
        }
    }

    public function consultar(NivelPrioridade $nivelPrioridade) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objNivelPrioridadeBD = new NivelPrioridadeBD();
            $arr =  $objNivelPrioridadeBD->consultar($nivelPrioridade,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando o nível de prioridade.',$e);
        }
    }

    public function remover(NivelPrioridade $nivelPrioridade) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objNivelPrioridadeBD = new NivelPrioridadeBD();
            $arr =  $objNivelPrioridadeBD->remover($nivelPrioridade,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo o nível de prioridade.', $e);
        }
    }

    public function listar(NivelPrioridade $nivelPrioridade) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objNivelPrioridadeBD = new NivelPrioridadeBD();
            
            $arr = $objNivelPrioridadeBD->listar($nivelPrioridade,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o nível de prioridade.',$e);
        }
    }


    public function pesquisar($campoBD, $valor_usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objNivelPrioridadeBD = new NivelPrioridadeBD();
            $arr = $objNivelPrioridadeBD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando o nível de prioridade.', $e);
        }
    }
    
    public function validar_cadastro(NivelPrioridade $nivelPrioridade) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            
            $objNivelPrioridadeBD = new NivelPrioridadeBD();
            $arr = $objNivelPrioridadeBD->validar_cadastro($nivelPrioridade,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando o nível de prioridade.', $e);
        }
    }

}

?>
