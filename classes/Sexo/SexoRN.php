<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do tipo da amostra
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/SexoBD.php';

class SexoRN{
    

    private function validarSexo(Sexo $sexo,Excecao $objExcecao){
        $strSexo = trim($sexo->getSexo());
       
        if ($strSexo == '') {
            $objExcecao->adicionar_validacao('O sexo não foi informado','idSexoPaciente', 'alert-danger');
        }else{
            if (strlen($strSexo) > 50) {
                $objExcecao->adicionar_validacao('O sexo possui mais que 50 caracteres.','idSexoPaciente','alert-danger');
            }
        }
        
        return $sexo->setSexo($strSexo);

    }

    private function validar_ja_existe_sexo(Sexo $sexo,Excecao $objExcecao){
        $objSexoRN= new SexoRN();
        if($objSexoRN->ja_existe_sexo($sexo)){
            $objExcecao->adicionar_validacao('O sexo já existe.','idSexoPaciente','alert-danger');
        }
    }

    private function validar_existe_paciente_com_o_sexo(Sexo $sexo,Excecao $objExcecao){
        $objSexoRN= new SexoRN();
        if($objSexoRN->existe_paciente_com_o_sexo($sexo)){
            $objExcecao->adicionar_validacao('Existe ao menos um paciente associado a este sexo. Logo, ele não pode ser excluído','idSexoPaciente','alert-danger');
        }
    }
    
       

    public function cadastrar(Sexo $sexo) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            
            $this->validarSexo($sexo,$objExcecao);
            $this->validar_ja_existe_sexo($sexo,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objSexoBD = new SexoBD();
            $sexo = $objSexoBD->cadastrar($sexo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $sexo;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o sexo do paciente.', $e);
        }
    }

    public function alterar(Sexo $sexo) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            
            $this->validarSexo($sexo,$objExcecao);
            $this->validar_ja_existe_sexo($sexo,$objExcecao);
            
            $objExcecao->lancar_validacoes();
            $objSexoBD = new SexoBD();
            $sexo = $objSexoBD->alterar($sexo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $sexo;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o sexo do paciente.', $e);
        }
    }

    public function consultar(Sexo $sexo) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objSexoBD = new SexoBD();
            $arr =  $objSexoBD->consultar($sexo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
 
            throw new Excecao('Erro consultando o sexo do paciente.',$e);
        }
    }

    public function remover(Sexo $sexo) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validar_existe_paciente_com_o_sexo($sexo,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objSexoBD = new SexoBD();
            $arr =  $objSexoBD->remover($sexo,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o sexo do paciente.', $e);
        }
    }

    public function listar(Sexo $sexo) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objSexoBD = new SexoBD();
            
            $arr = $objSexoBD->listar($sexo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o sexo do paciente.',$e);
        }
    }


    public function ja_existe_sexo(Sexo $sexo) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objSexoBD = new SexoBD();

            $arr = $objSexoBD->ja_existe_sexo($sexo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o sexo do paciente.',$e);
        }
    }

    public function existe_paciente_com_o_sexo(Sexo $sexo) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objSexoBD = new SexoBD();

            $arr = $objSexoBD->existe_paciente_com_o_sexo($sexo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o sexo do paciente.',$e);
        }
    }

   public function pesquisar_index(Sexo $sexo) {
       $objBanco = new Banco();
       try {
           $objExcecao = new Excecao();
           $objBanco->abrirConexao();
           $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objSexoBD = new SexoBD();
            $arr = $objSexoBD->pesquisar_index($sexo,$objBanco);

           $objBanco->confirmarTransacao();
           $objBanco->fecharConexao();
           return $arr;
       } catch (Throwable $e) {
           $objBanco->cancelarTransacao();
            throw new Excecao('Erro pesquisando o sexo.', $e);
        }
    }

}

