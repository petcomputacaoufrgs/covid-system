<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio da marca do paciente
 */

require_once 'classes/excecao/Excecao.php';
require_once 'classes/Paciente/PacienteBD.php';

class PacienteRN{
    

    private function validarNome(Paciente $paciente,Excecao $objExcecao){
        $strNome = trim($paciente->getNome());
        
        if ($strNome == '') {
            $objExcecao->adicionar_validacao('O nome do paciente não foi informado','idNome');
        }else{
            if (strlen($strNome) > 130) {
                $objExcecao->adicionar_validacao('O nome do paciente possui mais que 130 caracteres.','idNome');
            }
        }
        
        return $paciente->setNome($strNome);
    }
    
    //NÃO CADASTRA PACIENTE COM MESMO NOME E MESMO NOME DE MÃE
    private function validarCadastro(Paciente $paciente,Excecao $objExcecao){
        
        $pacienteRN  = new PacienteRN();
        $arr_pacientes = $pacienteRN->listar($paciente);
        foreach ($arr_pacientes as $p){
            if($paciente->getNome() == $p->getNome() && $paciente->getNomeMae() == $p->getNomeMae()){
                return false;
            }
        }
        return true;
        
    }
    
    private function validarNomeMae(Paciente $paciente,Excecao $objExcecao){
        $strNomeMae = trim($paciente->getNomeMae());
        
        if (strlen($strNomeMae) > 130) {
                $objExcecao->adicionar_validacao('O nome da mãe do paciente possui mais que 130 caracteres.','idNomeMae');
        }
        
        if($strNomeMae == '' && $paciente->getObsNomeMae() == ''){
            $objExcecao->adicionar_validacao('Informe o nome da mãe ou justifique a ausência.','idNomeMae');
        }
        
        return $paciente->setNomeMae($strNomeMae);
    }
    
    private function validarObsNomeMae(Paciente $paciente,Excecao $objExcecao){
        $strNomeMaeObs = trim($paciente->getObsNomeMae());
        
        if (strlen($strNomeMaeObs) > 150) {
            $objExcecao->adicionar_validacao('Observaçoes do nome da mãe do paciente possui mais que 150 caracteres.','idObsMae');
        }
        
        if($strNomeMaeObs == '' && $paciente->getNomeMae() == ''){
            $objExcecao->adicionar_validacao('Informe o nome da mãe ou justifique a ausência.');
        }
        
        
        return $paciente->setObsNomeMae($strNomeMaeObs);
    }
    
    private function validarCPF(Paciente $paciente,Excecao $objExcecao){
        $strCPF = trim($paciente->getCPF());     
       
        
        if (strlen($strCPF) != 11) {
                $objExcecao->adicionar_validacao('O CPF do paciente não possui  11 caracteres.','idCPF');
        }
            
        if($paciente->getIdPerfilPaciente_fk() != 3){
            if($strCPF == ''){
                $objExcecao->adicionar_validacao('Insira o CPF do paciente.','idCPF');
            }
        }                    
            // Extrai somente os números
            
            $strCPF = preg_replace( '/[^0-9]/is', '', $strCPF );
            
            // Verifica se foi informado todos os digitos corretamente
            

            // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
            if (preg_match('/(\d)\1{10}/', $strCPF)) {
                $objExcecao->adicionar_validacao('O CPF do paciente não é válido.','idCPF');
            }
            $cpf = intval($strCPF);
            // Faz o calculo para validar o CPF
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    $objExcecao->adicionar_validacao('O CPF do paciente não é válido.','idCPF');
                }
            }

             
        return $paciente->setCPF($strCPF);
    }
     
    private function validarRG(Paciente $paciente,Excecao $objExcecao){
        $strRG = trim($paciente->getRG());
        
       if(strlen($strRG) > 0){
            if (strlen($strRG) != 10) {
                $objExcecao->adicionar_validacao('O RG do paciente não possui 10 caracteres.','idRG');
            }
       }
                           
        return $paciente->setRG($strRG);
    }
    
    private function validarCodigoGAL(Paciente $paciente,Excecao $objExcecao){
        $strCodGal = trim($paciente->getCodGAL());
        
       
        if (strlen($strCodGal) > 15) {
            $objExcecao->adicionar_validacao('O código GAL do paciente possui mais que 15 caracteres.','idCodGal');
        }
                           
        return $paciente->setCodGAL($strCodGal);
    }
    
    private function validarObsCPF(Paciente $paciente,Excecao $objExcecao){
        $strObsCPF = trim($paciente->getObsCPF());
       
        
        if($paciente->getIdPerfilPaciente_fk() != 3){
            if($strObsCPF == '' && $paciente->getCPF() == '' ){
                $objExcecao->adicionar_validacao('Insira o CPF do paciente.','idObsCPF');
            }
        }
        if (strlen($strObsCPF) > 150) {
            $objExcecao->adicionar_validacao('As observações do CPF do paciente possui mais que 150 caracteres.','idObsCPF');
        }
                           
        return $paciente->setObsCPF($strObsCPF);
    }
    
    private function validarObsRG(Paciente $paciente,Excecao $objExcecao){
        $strObsRG = trim($paciente->getObsRG());
       
        if (strlen($strObsRG) > 150) {
            $objExcecao->adicionar_validacao('As observações do RG do paciente possui mais que 150 caracteres.','idObsRG');
        }
                           
        return $paciente->setObsRG($strObsRG);
    }
    
    private function validarObsSexo(Paciente $paciente,Excecao $objExcecao){
        $strObsSexo = trim($paciente->getObsSexo());
       
        if (strlen($strObsSexo) > 150) {
            $objExcecao->adicionar_validacao('As observações do sexo do paciente possui mais que 150 caracteres.','idObsSexo');
        }
                           
        return $paciente->setObsSexo($strObsSexo);
    }
    
    private function validarDataNascimento(Paciente $paciente,Excecao $objExcecao){
        $strDataNascimento = trim($paciente->getDataNascimento());
       
        if (strlen($strDataNascimento) == '') {
            $objExcecao->adicionar_validacao('A data de nascimento do paciente não foi informada.','idDataNascimento');
        }
        
        //validar para que não haja datas de nascimento posteriores a data atual
                           
        return $paciente->setDataNascimento($strDataNascimento);
    }
    
    
    
    public function cadastrar(Paciente $paciente) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarCPF($paciente,$objExcecao); 
            $this->validarCodigoGAL($paciente,$objExcecao); 
            $this->validarDataNascimento($paciente,$objExcecao); 
            $this->validarNome($paciente,$objExcecao); 
            $this->validarNomeMae($paciente,$objExcecao); 
            $this->validarObsCPF($paciente,$objExcecao); 
            $this->validarObsNomeMae($paciente,$objExcecao); 
            $this->validarObsRG($paciente,$objExcecao); 
            $this->validarObsSexo($paciente,$objExcecao); 
            $this->validarRG($paciente,$objExcecao); 
            if($this->validarCadastro($paciente,$objExcecao)){
                $objExcecao->lancar_validacoes();
                $objPacienteBD = new PacienteBD();
                //print_r($paciente);        
                $objPacienteBD->cadastrar($paciente,$objBanco);
            
            }
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando a marca.', $e);
        }
    }

    public function alterar(Paciente $paciente) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarCPF($paciente,$objExcecao); 
            $this->validarCodigoGAL($paciente,$objExcecao); 
            $this->validarDataNascimento($paciente,$objExcecao); 
            $this->validarNome($paciente,$objExcecao); 
            $this->validarNomeMae($paciente,$objExcecao); 
            $this->validarObsCPF($paciente,$objExcecao); 
            $this->validarObsNomeMae($paciente,$objExcecao); 
            $this->validarObsRG($paciente,$objExcecao); 
            $this->validarObsSexo($paciente,$objExcecao); 
            $this->validarRG($paciente,$objExcecao); 
                        
            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();
            $objPacienteBD->alterar($paciente,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando a marca.', $e);
        }
    }

    public function consultar(Paciente $paciente) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();
            $arr =  $objPacienteBD->consultar($paciente,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando a marca.',$e);
        }
    }

    public function remover(Paciente $paciente) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();
            $arr =  $objPacienteBD->remover($paciente,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo a marca.', $e);
        }
    }

    public function listar(Paciente $paciente) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();
            
            $arr = $objPacienteBD->listar($paciente,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando a marca.',$e);
        }
    }


    public function pesquisar($campoBD, $valor_usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objPacienteBD = new PacienteBD();
            $arr = $objPacienteBD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando a marca.', $e);
        }
    }

}

?>
