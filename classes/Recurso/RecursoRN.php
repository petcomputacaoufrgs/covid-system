<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do recurso 
 */

require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Recurso/RecursoBD.php';

class RecursoRN{
    

    private function validarNome(Recurso $recurso,Excecao $objExcecao){
        $strNome = trim($recurso->getNome());
        
        if ($strNome == '') {
            $objExcecao->adicionar_validacao('O nome não foi informado','idNomeRecurso');
        }else{
            if (strlen($strNome) > 100) {
                $objExcecao->adicionar_validacao('O nome possui mais que 100 caracteres.','idNomeRecurso');
            }
            
            
        }
        
        return $recurso->getNome($strNome);

    }
    
     private function validarEtapa(Recurso $recurso,Excecao $objExcecao){
        $strEtapa= trim($recurso->getEtapa());
        
        if ($strEtapa == '') {
            $objExcecao->adicionar_validacao('A etapa não foi informada','idEtapa');
        }else{
            if (strlen($strEtapa) > 100) {
                $objExcecao->adicionar_validacao('A etapa possui mais que 100 caracteres.','idEtapa');
            }
            
            
        }
        
        return $recurso->setEtapa($strEtapa);

    }
    
    private function validar_s_n_menu(Recurso $recurso,Excecao $objExcecao){
        $str_s_n = trim($recurso->getS_n_menu());
        
        if ($str_s_n == '') {
            $objExcecao->adicionar_validacao('O s_n do menu não foi informado','idSNRecurso');
        }else{
            if (strlen($str_s_n) > 1) {
                $objExcecao->adicionar_validacao('O s_n do menu possui mais que 1 caracteres.','idSNRecurso');
            }
            if (is_numeric($str_s_n)) {
                $objExcecao->adicionar_validacao('O s_n do menu é não pode ser um número.','idSNRecurso');
            }
           
        }
        
        return $recurso->setS_n_menu($str_s_n);

    }
     

    public function cadastrar(Recurso $recurso) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarNome($recurso,$objExcecao); 
            $this->validarEtapa($recurso,$objExcecao); 
            $this->validar_s_n_menu($recurso,$objExcecao); 

            $objExcecao->lancar_validacoes();
            $objRecursoBD = new RecursoBD();
            $objRecursoBD->cadastrar($recurso,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando o recurso.', $e);
        }
    }

    public function alterar(Recurso $recurso) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarNome($recurso,$objExcecao);   
            $this->validarEtapa($recurso,$objExcecao); 
            $this->validar_s_n_menu($recurso,$objExcecao); 
                        
            $objExcecao->lancar_validacoes();
            $objRecursoBD = new RecursoBD();
            $objRecursoBD->alterar($recurso,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando o recurso.', $e);
        }
    }

    public function consultar(Recurso $recurso) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRecursoBD = new RecursoBD();
            $arr =  $objRecursoBD->consultar($recurso,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando o recurso.',$e);
        }
    }

    public function remover(Recurso $recurso) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRecursoBD = new RecursoBD();
            $arr =  $objRecursoBD->remover($recurso,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo o recurso.', $e);
        }
    }

    public function listar(Recurso $recurso) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRecursoBD = new RecursoBD();
            
            $arr = $objRecursoBD->listar($recurso,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o recurso.',$e);
        }
    }
    
    public function validar_cadastro(Recurso $recurso) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRecursoBD = new RecursoBD();
            
            $arr = $objRecursoBD->validar_cadastro($recurso,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro validando cadastro do recurso.',$e);
        }
    }


    public function pesquisar($campoBD, $valor_usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRecursoBD = new RecursoBD();
            $arr = $objRecursoBD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando o recurso.', $e);
        }
    }
    
    
}

?>
