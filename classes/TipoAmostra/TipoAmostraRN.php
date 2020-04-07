<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do tipo da amostra
 */

require_once 'classes/Excecao/Excecao.php';
require_once 'classes/TipoAmostra/TipoAmostraBD.php';

class TipoAmostraRN{


    private function validarTipo(TipoAmostra $objTipoAmostra, Excecao $objExcecao) {
        $strTipo = trim($objTipoAmostra->getTipo());
       
        if ($strTipo == '') {
            $objExcecao->adicionar_validacao('Tipo da amostra não foi informada','idTipoAmostra');
        }else{
            if (strlen($strTipo) > 50) {
                $objExcecao->adicionar_validacao('O tipo de amostra possui mais que 50 caracteres.','idTipoAmostra');
            }
            
            $tipoAmostra_aux_RN = new TipoAmostraRN();
            $array_tiposAmostras = $tipoAmostra_aux_RN->listar($objTipoAmostra);
            //print_r($array_sexos);
            foreach ($array_tiposAmostras as $ta){
                if($ta->getTipo() == $objTipoAmostra->getTipo()){
                    $objExcecao->adicionar_validacao('O tipo de amostra digitado já existe.','idTipoAmostra');
                }
            }
        }
        
        $objTipoAmostra->setTipo($strTipo);

    }
     

    public function cadastrar(TipoAmostra $tipoAmostra) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarTipo($tipoAmostra,$objExcecao); 
            $objExcecao->lancar_validacoes();
            $objTipoAmostraBD = new TipoAmostraBD();
            $objTipoAmostraBD->cadastrar($tipoAmostra,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando o tipo da amostra.', $e);
        }
    }

    public function alterar(TipoAmostra $tipoAmostra) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarTipo($tipoAmostra,$objExcecao);   
            
            $objExcecao->lancar_validacoes();
            $objTipoAmostraBD = new TipoAmostraBD();
            $objTipoAmostraBD->alterar($tipoAmostra,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando o tipo da amostra.', $e);
        }
    }

    public function consultar(TipoAmostra $tipoAmostra) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objTipoAmostraBD = new TipoAmostraBD();
            $arr =  $objTipoAmostraBD->consultar($tipoAmostra,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            die($e);
            throw new Excecao('Erro consultando o tipo da amostra.',$e);
        }
    }

    public function remover(TipoAmostra $tipoAmostra) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objTipoAmostraBD = new TipoAmostraBD();
            $arr = $objTipoAmostraBD->remover($tipoAmostra,$objBanco);
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro removendo o tipo da amostra.', $e);
        }
    }

    public function listar(TipoAmostra $tipoAmostra) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objTipoAmostraBD = new TipoAmostraBD();
            
            $arr = $objTipoAmostraBD->listar($tipoAmostra,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o tipo da amostra.',  $e);
        }
    }


    public function pesquisar($campoBD, $valor_usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objTipoAmostraBD = new TipoAmostraBD();
            $arr =$objTipoAmostraBD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando o tipo da amostra.', $e);
        }
    }

}

?>
