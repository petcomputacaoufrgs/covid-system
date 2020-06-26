<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do recurso 
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/RecursoBD.php';

class RecursoRN{
    

    private function validarNome(Recurso $recurso,Excecao $objExcecao){
        $strNome = trim($recurso->getNome());
        
        if ($strNome == '') {
            $objExcecao->adicionar_validacao('O nome não foi informado','idNomeRecurso','alert-danger');
        }else{
            if (strlen($strNome) > 100) {
                $objExcecao->adicionar_validacao('O nome possui mais que 100 caracteres.','idNomeRecurso','alert-danger');
            }
            
            
        }
        
        return $recurso->getNome($strNome);

    }
    
     private function validarEtapa(Recurso $recurso,Excecao $objExcecao){
        $strEtapa= trim($recurso->getEtapa());
        
        if ($strEtapa == '') {
            $objExcecao->adicionar_validacao('A etapa não foi informada','idEtapa','alert-danger');
        }else{
            if (strlen($strEtapa) > 100) {
                $objExcecao->adicionar_validacao('A etapa possui mais que 100 caracteres.','idEtapa','alert-danger');
            }
            
            
        }
        
        return $recurso->setEtapa($strEtapa);

    }
    
    private function validar_s_n_menu(Recurso $recurso,Excecao $objExcecao){
        $str_s_n = trim($recurso->getS_n_menu());
        
        if ($str_s_n == '') {
            $objExcecao->adicionar_validacao('O s_n do menu não foi informado','idSNRecurso','alert-danger');
        }else{
            if (strlen($str_s_n) > 1) {
                $objExcecao->adicionar_validacao('O s_n do menu possui mais que 1 caracteres.','idSNRecurso','alert-danger');
            }
            if (is_numeric($str_s_n)) {
                $objExcecao->adicionar_validacao('O s_n do menu é não pode ser um número.','idSNRecurso','alert-danger');
            }
           
        }
        
        return $recurso->setS_n_menu($str_s_n);

    }

    private function validar_ja_existe_recurso(Recurso $recurso,Excecao $objExcecao){
        $objRecursoRN= new RecursoRN();
        if($objRecursoRN->ja_existe_recurso($recurso)){
            $objExcecao->adicionar_validacao('O recurso já existe',null,'alert-danger');
        }
    }

    private function validar_existe_usuario_com_o_recurso(Recurso $recurso,Excecao $objExcecao){
        $objRecursoRN= new RecursoRN();
        if($objRecursoRN->existe_usuario_com_o_recurso($recurso)){
            $objExcecao->adicionar_validacao('Existe ao menos um usuário associado a este recurso. Logo, ele não pode ser excluído',null,'alert-danger');
        }
    }


    public function cadastrar(Recurso $recurso) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarNome($recurso,$objExcecao); 
            $this->validarEtapa($recurso,$objExcecao); 
            $this->validar_s_n_menu($recurso,$objExcecao);
            $this->validar_ja_existe_recurso($recurso,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objRecursoBD = new RecursoBD();
            $recurso = $objRecursoBD->cadastrar($recurso,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $recurso;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
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
            $this->validar_ja_existe_recurso($recurso,$objExcecao);
                        
            $objExcecao->lancar_validacoes();
            $objRecursoBD = new RecursoBD();
             $recurso = $objRecursoBD->alterar($recurso,$objBanco);

             $objBanco->confirmarTransacao();
             $objBanco->fecharConexao();
             return $recurso;
         } catch (Throwable $e) {
             $objBanco->cancelarTransacao();
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

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
 
            throw new Excecao('Erro consultando o recurso.',$e);
        }
    }

    public function remover(Recurso $recurso) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();

            $this->validar_existe_usuario_com_o_recurso($recurso,$objExcecao);
            $objExcecao->lancar_validacoes();
            $objRecursoBD = new RecursoBD();
            $arr =  $objRecursoBD->remover($recurso,$objBanco);
             $objBanco->confirmarTransacao();
             $objBanco->fecharConexao();
             return $arr;
         } catch (Throwable $e) {
             $objBanco->cancelarTransacao();
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

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
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

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
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
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro pesquisando o recurso.', $e);
        }
    }


    public function ja_existe_recurso(Recurso $recurso) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objRecursoBD = new RecursoBD();

            $arr = $objRecursoBD->ja_existe_recurso($recurso,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro verificando se já existe um recurso na RN .',$e);
        }
    }

    public function existe_usuario_com_o_recurso(Recurso $recurso) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objRecursoBD = new RecursoBD();

            $arr = $objRecursoBD->existe_usuario_com_o_recurso($recurso,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro verificando se existe um usuário com o recurso RN.',$e);
        }
    }


}

