<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do perfil do paciente
 */

require_once 'classes/Excecao/Excecao.php';
require_once 'classes/PerfilPaciente/PerfilPacienteBD.php';

class PerfilPacienteRN{
    

    private function validarPerfil(PerfilPaciente $perfilPaciente,Excecao $objExcecao){
        $strPerfilPaciente = trim($perfilPaciente->getPerfil());
        
        if ($strPerfilPaciente == '') {
            $objExcecao->adicionar_validacao('O perfil do paciente não foi informado','idPerfilPaciente');
        }else{
            if (strlen($strPerfilPaciente) > 50) {
                $objExcecao->adicionar_validacao('O perfil do paciente possui mais que 50 caracteres.','idPerfilPaciente');
            }
            
            $perfilPaciente_aux_RN = new PerfilPacienteRN();
            $array_perfis = $perfilPaciente_aux_RN->listar($perfilPaciente);
            //print_r($array_sexos);
            foreach ($array_perfis as $p){
                if($p->getPerfil() == $perfilPaciente->getPerfil()){
                    $objExcecao->adicionar_validacao('O perfil do paciente já existe.','idPerfilPaciente');
                }
            }
        }
        
        return $perfilPaciente->setPerfil($strPerfilPaciente);

    }
     

    public function cadastrar(PerfilPaciente $perfilPaciente) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarPerfil($perfilPaciente,$objExcecao); 
            $objExcecao->lancar_validacoes();
            $objPerfilPacienteBD = new PerfilPacienteBD();
            $objPerfilPacienteBD->cadastrar($perfilPaciente,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando o perfil do paciente.', $e);
        }
    }

    public function alterar(PerfilPaciente $perfilPaciente) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarPerfil($perfilPaciente,$objExcecao);   
                        
            $objExcecao->lancar_validacoes();
            $objPerfilPacienteBD = new PerfilPacienteBD();
            $objPerfilPacienteBD->alterar($perfilPaciente,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando o perfil do paciente.', $e);
        }
    }

    public function consultar(PerfilPaciente $perfilPaciente) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objPerfilPacienteBD = new PerfilPacienteBD();
            $arr =  $objPerfilPacienteBD->consultar($perfilPaciente,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando o perfil do paciente.',$e);
        }
    }

    public function remover(PerfilPaciente $perfilPaciente) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objPerfilPacienteBD = new PerfilPacienteBD();
            $arr =  $objPerfilPacienteBD->remover($perfilPaciente,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo o perfil do paciente.', $e);
        }
    }

    public function listar(PerfilPaciente $perfilPaciente) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objPerfilPacienteBD = new PerfilPacienteBD();
            
            $arr = $objPerfilPacienteBD->listar($perfilPaciente,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o perfil do paciente.',$e);
        }
    }


    public function pesquisar($campoBD, $valor_usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objPerfilPacienteBD = new PerfilPacienteBD();
            $arr = $objPerfilPacienteBD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando o perfil do paciente.', $e);
        }
    }

}

?>
