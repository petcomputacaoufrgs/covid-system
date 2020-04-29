<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do perfil do paciente
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/PerfilPacienteBD.php';

class PerfilPacienteRN{

    public static $TP_PROFISSIONAIS_SAUDE = 'S';
    public static $TP_VOLUNTARIOS = 'V';
    public static $TP_PACIENTES_SUS = 'L';
    public static $TP_FUNCIONARIOS_ENGIE = 'E';
    public static $TE_OUTROS = 'O';


    public static function listarValoresTipoEstado(){
        try {

            $arrObjTECapela = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TP_PROFISSIONAIS_SAUDE);
            $objSituacao->setStrDescricao('Profissionais da Saúde');
            $arrObjTECapela[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TP_VOLUNTARIOS);
            $objSituacao->setStrDescricao('Equipes de Voluntários');
            $arrObjTECapela[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TP_PACIENTES_SUS);
            $objSituacao->setStrDescricao('Pacientes SUS');
            $arrObjTECapela[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TP_FUNCIONARIOS_ENGIE);
            $objSituacao->setStrDescricao('Funcionários ENGIE');
            $arrObjTECapela[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TE_OUTROS);
            $objSituacao->setStrDescricao('outros');
            $arrObjTECapela[] = $objSituacao;


            return $arrObjTECapela;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Tipo estado da capela',$e);
        }
    }

    public static function mostrarDescricaoTipo($strTipo){
        //$objExcecao = new Excecao();

        foreach (self::listarValoresTipoEstado() as $tipo){
            if($tipo->getStrTipo() == $strTipo){
                return $tipo->getStrDescricao();
            }
        }
        return null;
        //$objExcecao->adicionarValidacao('Não encontrou o tipo informadoo.','alert-danger');
    }


    private function validarPerfil(PerfilPaciente $perfilPaciente,Excecao $objExcecao){
        $strPerfilPaciente = trim($perfilPaciente->getPerfil());
        
        if ($strPerfilPaciente == '') {
            $objExcecao->adicionar_validacao('O perfil do paciente não foi informado','idPerfilPaciente');
        }else{
            if (strlen($strPerfilPaciente) > 50) {
                $objExcecao->adicionar_validacao('O perfil do paciente possui mais que 50 caracteres.','idPerfilPaciente');
            }
        }
        
        return $perfilPaciente->setPerfil($strPerfilPaciente);

    }
    
     private function validarCaractere(PerfilPaciente $perfilPaciente,Excecao $objExcecao){
        $strCaractere = trim($perfilPaciente->getCaractere());
        
        if ($strCaractere == '') {
            $objExcecao->adicionar_validacao('O caractere do perfil do paciente não foi informado','idCaractere');
        }else{
            if (strlen($strCaractere) > 1) {
                $objExcecao->adicionar_validacao('O máximo é de 1 caractere.','idCaractere');
            }
        }
        
        return $perfilPaciente->setCaractere($strCaractere);

    }
    
    private function validarIndexPerfil(PerfilPaciente $perfilPaciente,Excecao $objExcecao){
        $strPerfilPacienteUPPER = trim($perfilPaciente->getIndex_perfil());
        
      
        $perfilPaciente_aux_RN = new PerfilPacienteRN();
        $array_perfis = $perfilPaciente_aux_RN->listar($perfilPaciente);
        //print_r($array_sexos);
        foreach ($array_perfis as $p){
            if($p->getIndex_perfil() == $perfilPaciente->getIndex_perfil()){
                //$objExcecao->adicionar_validacao('O perfil do paciente já existe.','idPerfilPaciente');
                return false;
            }
        }
        return true;
        
        
        //return $perfilPaciente->setIndex_perfil($strPerfilPacienteUPPER);

    }
     

    public function cadastrar(PerfilPaciente $perfilPaciente) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarPerfil($perfilPaciente,$objExcecao); 
            $this->validarIndexPerfil($perfilPaciente,$objExcecao);
            $this->validarCaractere($perfilPaciente,$objExcecao);
            
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
            $objPerfilPacienteBD = new PerfilPacienteBD();
            
            $this->validarPerfil($perfilPaciente,$objExcecao); 
            $this->validarCaractere($perfilPaciente,$objExcecao);
            
            if($this->validarIndexPerfil($perfilPaciente,$objExcecao)){
                $objExcecao->lancar_validacoes();
                $objPerfilPacienteBD->alterar($perfilPaciente,$objBanco);
            }else{
                $objExcecao->lancar_validacoes();
                $objPerfilPacienteBD->consultar($perfilPaciente,$objBanco);
            }
                        
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


     public function pesquisar_index(PerfilPaciente $perfilPaciente) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objPerfilPacienteBD = new PerfilPacienteBD();
            $arr = $objPerfilPacienteBD->pesquisar_index($perfilPaciente,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando o perfil do paciente.', $e);
        }
    }

}

