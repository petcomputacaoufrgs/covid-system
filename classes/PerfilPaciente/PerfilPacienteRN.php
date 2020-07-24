<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do perfil do paciente
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/PerfilPacienteBD.php';

class PerfilPacienteRN{

    public static $TP_PROFISSIONAIS_SAUDE = 'S';
    public static $TP_PREFEITURA_PORTO_ALEGRE = 'P';
    public static $TP_VOLUNTARIOS = 'V';
    public static $TP_PACIENTES_SUS = 'L';
    public static $TP_FUNCIONARIOS_ENGIE = 'E';
    public static $TE_OUTROS = 'O';
    public static $TP_REDE_ESGOTO = 'A';


    public static function listarValoresTipoPaciente(){
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

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TP_PREFEITURA_PORTO_ALEGRE);
            $objSituacao->setStrDescricao('prefeitura de POA');
            $arrObjTECapela[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TP_REDE_ESGOTO);
            $objSituacao->setStrDescricao('rede de esgoto de POA');
            $arrObjTECapela[] = $objSituacao;


            return $arrObjTECapela;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Tipo estado da capela',$e);
        }
    }

    public static function retornarTipoPaciente($tipoPaciente){
        $arr = self::listarValoresTipoPaciente();
        foreach ($arr as $a){
            if($a->getStrTipo() == $tipoPaciente ){
                return $a->getStrDescricao();
            }
        }
    }

    public static function mostrarDescricaoTipo($strTipo){

        foreach (self::listarValoresTipoPaciente() as $tipo){
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
            $objExcecao->adicionar_validacao('O perfil do paciente não foi informado',null,'alert-danger');
        }else{
            if (strlen($strPerfilPaciente) > 50) {
                $objExcecao->adicionar_validacao('O perfil do paciente possui mais que 50 caracteres',null,'alert-danger');
            }
        }
        
        return $perfilPaciente->setPerfil($strPerfilPaciente);

    }
    
     private function validarCaractere(PerfilPaciente $perfilPaciente,Excecao $objExcecao){
        $strCaractere = trim($perfilPaciente->getCaractere());
        
        if ($strCaractere == '') {
            $objExcecao->adicionar_validacao('O caractere do perfil do paciente não foi informado',null,'alert-danger');
        }else{
            if (strlen($strCaractere) > 1) {
                $objExcecao->adicionar_validacao('O máximo é de 1 caractere',null,'alert-danger');
            }
        }
        
        return $perfilPaciente->setCaractere($strCaractere);

    }
    

    private function validar_ja_existe_perfilPaciente(PerfilPaciente $perfilPaciente,Excecao $objExcecao){
        $objPerfilPacienteRN= new PerfilPacienteRN();
        if($objPerfilPacienteRN->ja_existe_perfil($perfilPaciente)){
            $objExcecao->adicionar_validacao('O perfil do paciente já existe',null,'alert-danger');
        }
    }

    private function validar_existe_amostra_com_o_perfil(PerfilPaciente $perfilPaciente,Excecao $objExcecao){
        $objPerfilPacienteRN= new PerfilPacienteRN();
        if($objPerfilPacienteRN->existe_amostra_com_o_perfil($perfilPaciente)){
            $objExcecao->adicionar_validacao('Existe ao menos uma amostra associado a este perfil. Logo, ele não pode ser excluído',null,'alert-danger');
        }
    }



    public function cadastrar(PerfilPaciente $perfilPaciente) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            
            $this->validarPerfil($perfilPaciente,$objExcecao); 
            $this->validar_ja_existe_perfilPaciente($perfilPaciente,$objExcecao);
            $this->validarCaractere($perfilPaciente,$objExcecao);
            
            $objExcecao->lancar_validacoes();
            $objPerfilPacienteBD = new PerfilPacienteBD();
            $perfilPaciente = $objPerfilPacienteBD->cadastrar($perfilPaciente,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $perfilPaciente;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o perfil do paciente.', $e);
        }
    }

    public function alterar(PerfilPaciente $perfilPaciente) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objPerfilPacienteBD = new PerfilPacienteBD();
            
            $this->validarPerfil($perfilPaciente,$objExcecao); 
            $this->validarCaractere($perfilPaciente,$objExcecao);
             $this->validar_ja_existe_perfilPaciente($perfilPaciente,$objExcecao);
             $objExcecao->lancar_validacoes();

             $perfilPaciente = $objPerfilPacienteBD->alterar($perfilPaciente,$objBanco);

             $objBanco->confirmarTransacao();
             $objBanco->fecharConexao();
             return $perfilPaciente;
         } catch (Throwable $e) {
             $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o perfil do paciente.', $e);
        }
    }

    public function consultar(PerfilPaciente $perfilPaciente) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPerfilPacienteBD = new PerfilPacienteBD();
            $arr =  $objPerfilPacienteBD->consultar($perfilPaciente,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o perfil do paciente.',$e);
        }
    }

    public function remover(PerfilPaciente $perfilPaciente) {
         $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $this->validar_existe_amostra_com_o_perfil($perfilPaciente,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objPerfilPacienteBD = new PerfilPacienteBD();
            $arr =  $objPerfilPacienteBD->remover($perfilPaciente,$objBanco);
             $objBanco->confirmarTransacao();
             $objBanco->fecharConexao();
             return $arr;
         } catch (Throwable $e) {
             $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o perfil do paciente.', $e);
        }
    }

    public function listar(PerfilPaciente $perfilPaciente) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPerfilPacienteBD = new PerfilPacienteBD();
            
            $arr = $objPerfilPacienteBD->listar($perfilPaciente,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o perfil do paciente.',$e);
        }
    }

    public function listar_nao_sus(PerfilPaciente $perfilPaciente) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPerfilPacienteBD = new PerfilPacienteBD();

            $arr = $objPerfilPacienteBD->listar_nao_sus($perfilPaciente,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o perfil do paciente.',$e);
        }
    }



     public function pesquisar_index(PerfilPaciente $perfilPaciente) {
         $objBanco = new Banco();
         try {

             $objExcecao = new Excecao();
             $objBanco->abrirConexao();
             $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPerfilPacienteBD = new PerfilPacienteBD();
            $arr = $objPerfilPacienteBD->pesquisar_index($perfilPaciente,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro pesquisando o perfil do paciente.', $e);
        }
    }

    public function ja_existe_perfil(PerfilPaciente $perfilPaciente) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPerfilPacienteBD = new PerfilPacienteBD();

            $arr = $objPerfilPacienteBD->ja_existe_perfil($perfilPaciente,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o sexo do paciente.',$e);
        }
    }

    public function existe_amostra_com_o_perfil(PerfilPaciente $perfilPaciente) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPerfilPacienteBD = new PerfilPacienteBD();

            $arr = $objPerfilPacienteBD->existe_amostra_com_o_perfil($perfilPaciente,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o sexo do paciente.',$e);
        }
    }

}

