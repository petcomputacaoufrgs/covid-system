<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio da capela do paciente
 */

require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Capela/CapelaBD.php';

class CapelaRN{
    

    private function validarStatus(Capela $capela,Excecao $objExcecao){
        $strStatus = trim($capela->getStatusCapela());
        
        if ($strStatus == '') {
            $objExcecao->adicionar_validacao('O status da capela não foi informado','idStatusCapela');
        }else{
            if (strlen($strStatus) > 100) {
                $objExcecao->adicionar_validacao('A status da capela possui mais que 100 caracteres.','idStatusCapela');
            }
        }
        
        return $capela->setStatusCapela($strStatus);

    }
    
    private function validarNumero(Capela $capela,Excecao $objExcecao){
        $strNumero = trim($capela->getNumero());
        
        if ($strNumero == '') {
            $objExcecao->adicionar_validacao('O número da capela não foi informado','idNumeroCapela');
        }
        return $capela->setNumero($strNumero);

    }

    public function cadastrar(Capela $capela) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarNumero($capela,$objExcecao); 
            $this->validarStatus($capela,$objExcecao); 
            
            $objExcecao->lancar_validacoes();
            $objCapelaBD = new CapelaBD();
            $objCapelaBD->cadastrar($capela,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando a capela.', $e);
        }
    }

    public function alterar(Capela $capela) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarNumero($capela,$objExcecao);   
            $this->validarStatus($capela,$objExcecao);   
                        
            $objExcecao->lancar_validacoes();
            $objCapelaBD = new CapelaBD();
            $objCapelaBD->alterar($capela,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando a capela.', $e);
        }
    }

    public function consultar(Capela $capela) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objCapelaBD = new CapelaBD();
            $arr =  $objCapelaBD->consultar($capela,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando a capela.',$e);
        }
    }

    public function remover(Capela $capela) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objCapelaBD = new CapelaBD();
            $arr =  $objCapelaBD->remover($capela,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo a capela.', $e);
        }
    }

    public function listar(Capela $capela) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objCapelaBD = new CapelaBD();
            
            $arr = $objCapelaBD->listar($capela,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando a capela.',$e);
        }
    }

     public function bloquear_registro(Capela $capela) {
        try {
            $objCapelaBD = new CapelaBD();
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            
            $objBanco->abrirConexao(); 
            $objBanco->abrirTransacao();
            $objBanco->confirmarTransacao();
            //sleep(5);
            $arr = $objCapelaBD->bloquear_registro($capela,$objBanco);
            if(empty($arr)){
               return $arr; 
            }
            
            $objCapela = new Capela();
            $objCapela->setIdCapela($arr[0]->getIdCapela());
            $objCapela->setNumero($arr[0]->getNumero());
            $arr[0]->setStatusCapela('OCUPADA');
            $objCapela->setStatusCapela($arr[0]->getStatusCapela());
            
            $capelaRN = NEW CapelaRN();
            $capelaRN->alterar($objCapela);
            
            $objBanco->cancelarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro bloqueando a capela.',$e);
        }
    }
    
    
    public function validar_cadastro(Capela $capela) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objCapelaBD = new CapelaBD();
            $arr = $objCapelaBD->validar_cadastro($capela,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando a capela.',$e);
        }
    }


    

}

?>
