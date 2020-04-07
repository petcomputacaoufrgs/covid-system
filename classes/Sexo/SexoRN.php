<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do tipo da amostra
 */

require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Sexo/SexoBD.php';

class SexoRN{
    

    private function validarSexo(Sexo $sexo,Excecao $objExcecao){
        $strSexo = trim($sexo->getSexo());
       
        if ($strSexo == '') {
            $objExcecao->adicionar_validacao('O sexo não foi informado','idSexoPaciente');
        }else{
            if (strlen($strSexo) > 50) {
                $objExcecao->adicionar_validacao('O sexo possui mais que 50 caracteres.','idSexoPaciente');
            }
            
            $sexo_aux_RN = new SexoRN();
            $array_sexos = $sexo_aux_RN->listar($sexo);
            //print_r($array_sexos);
            foreach ($array_sexos as $s){
                if($s->getSexo() == $sexo->getSexo()){
                    $objExcecao->adicionar_validacao('O sexo digitado já existe.','idSexoPaciente');
                }
            }
        }
        
        return $sexo->setSexo($strSexo);

    }
     

    public function cadastrar(Sexo $sexo) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarSexo($sexo,$objExcecao); 
            $objExcecao->lancar_validacoes();
            $objSexoBD = new SexoBD();
            $objSexoBD->cadastrar($sexo,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando o sexo do paciente.', $e);
        }
    }

    public function alterar(Sexo $sexo) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarSexo($sexo,$objExcecao);   
            
            $objExcecao->lancar_validacoes();
            $objSexoBD = new SexoBD();
            $objSexoBD->alterar($sexo,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando o sexo do paciente.', $e);
        }
    }

    public function consultar(Sexo $sexo) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objSexoBD = new SexoBD();
            $arr =  $objSexoBD->consultar($sexo,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando o sexo do paciente.',$e);
        }
    }

    public function remover(Sexo $sexo) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objSexoBD = new SexoBD();
            $arr =  $objSexoBD->remover($sexo,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo o sexo do paciente.', $e);
        }
    }

    public function listar(Sexo $sexo) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objSexoBD = new SexoBD();
            
            $arr = $objSexoBD->listar($sexo,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o sexo do paciente.',$e);
        }
    }


    public function pesquisar($campoBD, $valor_usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objSexoBD = new SexoBD();
            $arr = $objSexoBD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando o sexo do paciente.', $e);
        }
    }

}

?>
