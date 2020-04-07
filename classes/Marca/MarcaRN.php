<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio da marca do paciente
 */

require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Marca/MarcaBD.php';

class MarcaRN{
    

    private function validarMarca(Marca $detentor,Excecao $objExcecao){
        $strMarca = trim($detentor->getMarca());
        
        if ($strMarca == '') {
            $objExcecao->adicionar_validacao('A marca não foi informado','idMarca');
        }else{
            if (strlen($strMarca) > 100) {
                $objExcecao->adicionar_validacao('A marca possui mais que 100 caracteres.','idMarca');
            }
            
            $detentor_aux_RN = new MarcaRN();
            $array_marcas = $detentor_aux_RN->listar($detentor);
            //print_r($array_sexos);
            foreach ($array_marcas as $m){
                if($m->getMarca() == $detentor->getMarca()){
                    $objExcecao->adicionar_validacao('A marca já existe.','idMarca');
                }
            }
        }
        
        return $detentor->setMarca($strMarca);

    }
     

    public function cadastrar(Marca $detentor) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarMarca($detentor,$objExcecao); 
            $objExcecao->lancar_validacoes();
            $objMarcaBD = new MarcaBD();
            $objMarcaBD->cadastrar($detentor,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando a marca.', $e);
        }
    }

    public function alterar(Marca $detentor) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarMarca($detentor,$objExcecao);   
                        
            $objExcecao->lancar_validacoes();
            $objMarcaBD = new MarcaBD();
            $objMarcaBD->alterar($detentor,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando a marca.', $e);
        }
    }

    public function consultar(Marca $detentor) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objMarcaBD = new MarcaBD();
            $arr =  $objMarcaBD->consultar($detentor,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando a marca.',$e);
        }
    }

    public function remover(Marca $detentor) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objMarcaBD = new MarcaBD();
            $arr =  $objMarcaBD->remover($detentor,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo a marca.', $e);
        }
    }

    public function listar(Marca $detentor) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objMarcaBD = new MarcaBD();
            
            $arr = $objMarcaBD->listar($detentor,$objBanco);
            
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
            $objMarcaBD = new MarcaBD();
            $arr = $objMarcaBD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando a marca.', $e);
        }
    }

}

?>
