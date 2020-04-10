<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do doença do paciente
 */

require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Doenca/DoencaBD.php';

class DoencaRN{
    

    private function validarDoenca(Doenca $doenca,Excecao $objExcecao){
        $strDoenca = trim($doenca->getDoenca());
        
        if ($strDoenca == '') {
            $objExcecao->adicionar_validacao('A doença não foi informado','idDoenca');
        }else{
            if (strlen($strDoenca) > 100) {
                $objExcecao->adicionar_validacao('A doença possui mais que 100 caracteres.','idDoenca');
            }
            
            $doenca_aux_RN = new DoencaRN();
            $array_doencas = $doenca_aux_RN->listar($doenca);
            //print_r($array_sexos);
            foreach ($array_doencas as $d){
                if($d->getDoenca() == $doenca->getDoenca()){
                    $objExcecao->adicionar_validacao('A doença já existe.','idDoenca');
                }
            }
        }
        
        return $doenca->setDoenca($strDoenca);

    }
     

    public function cadastrar(Doenca $doenca) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarDoenca($doenca,$objExcecao); 
            $objExcecao->lancar_validacoes();
            $objDoencaBD = new DoencaBD();
            $objDoencaBD->cadastrar($doenca,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando o doença.', $e);
        }
    }

    public function alterar(Doenca $doenca) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarDoenca($doenca,$objExcecao);   
                        
            $objExcecao->lancar_validacoes();
            $objDoencaBD = new DoencaBD();
            $objDoencaBD->alterar($doenca,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando o doença.', $e);
        }
    }

    public function consultar(Doenca $doenca) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objDoencaBD = new DoencaBD();
            $arr =  $objDoencaBD->consultar($doenca,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando o doença.',$e);
        }
    }

    public function remover(Doenca $doenca) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objDoencaBD = new DoencaBD();
            $arr =  $objDoencaBD->remover($doenca,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo o doença.', $e);
        }
    }

    public function listar(Doenca $doenca) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objDoencaBD = new DoencaBD();
            
            $arr = $objDoencaBD->listar($doenca,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o doença.',$e);
        }
    }


    public function pesquisar($campoBD, $valor_usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objDoencaBD = new DoencaBD();
            $arr = $objDoencaBD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando o doença.', $e);
        }
    }

}

?>
