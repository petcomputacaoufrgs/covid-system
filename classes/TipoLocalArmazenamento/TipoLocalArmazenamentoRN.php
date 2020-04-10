<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do tipo da amostra
 */

require_once 'classes/Excecao/Excecao.php';
require_once 'classes/TipoLocalArmazenamento/TipoLocalArmazenamentoBD.php';

class TipoLocalArmazenamentoRN{
    

    private function validarNomeLocal(TipoLocalArmazenamento $tipoLocalArmazenamento,Excecao $objExcecao){
        $strNomeLocal = trim($tipoLocalArmazenamento->getNomeLocal());
       
        if ($strNomeLocal == '') {
            $objExcecao->adicionar_validacao('O nome do local não foi informado','idNomeTipoLA');
        }else{
            if (strlen($strNomeLocal) > 50) {
                $objExcecao->adicionar_validacao('O nome do local  possui mais que 50 caracteres.','idNomeTipoLA');
            }
            
            $tipoLocalArmazenamento_aux_RN = new TipoLocalArmazenamentoRN();
            $array_sexos = $tipoLocalArmazenamento_aux_RN->listar($tipoLocalArmazenamento);
            //print_r($array_sexos);
            foreach ($array_sexos as $s){
                if($s->getNomeLocal() == $tipoLocalArmazenamento->getNomeLocal()){
                    $objExcecao->adicionar_validacao('O nome do local digitado já existe.','idNomeTipoLA');
                }
            }
        }
        
        return $tipoLocalArmazenamento->setNomeLocal($strNomeLocal);

    }
    
    private function validarQntEspacosTotal(TipoLocalArmazenamento $tipoLocalArmazenamento,Excecao $objExcecao){
        $strQntEspacoTotal = trim($tipoLocalArmazenamento->getQntEspacosTotal());
       
        if ($strQntEspacoTotal == '') {
            $objExcecao->adicionar_validacao('A quantidade de espaços totais não foi informada','idQntTotalEspacoLA');
        }else{
           if(intval($strQntEspacoTotal) < 0){
               $objExcecao->adicionar_validacao('A quantidade de espaços totais não pode ser um número negativo','idQntTotalEspacoLA');
           }
        }
        
        return $tipoLocalArmazenamento->setQntEspacosTotal($strQntEspacoTotal);

    }
    
     private function validarQntEspacosAmostras(TipoLocalArmazenamento $tipoLocalArmazenamento,Excecao $objExcecao){
        $strQntEspacoAmostras = trim($tipoLocalArmazenamento->getQntEspacosAmostra());
       
        if ($strQntEspacoAmostras == '') {
            $objExcecao->adicionar_validacao('A quantidade de espaços com amostras não foi informada','idQntTotalAmostraLA');
        }else{
           if(intval($strQntEspacoAmostras) < 0){
               $objExcecao->adicionar_validacao('A quantidade de espaços com amostras não pode ser um número negativo','idQntTotalAmostraLA');
           }
           
           if(intval($strQntEspacoAmostras) > intval($tipoLocalArmazenamento->getQntEspacosTotal())){
               $objExcecao->adicionar_validacao('A quantidade de espaços com amostras não pode ser maior que o espaço total','idQntTotalAmostraLA');
           }
        }
        
        return $tipoLocalArmazenamento->setQntEspacosTotal($strQntEspacoAmostras);

    }
    
     

    public function cadastrar(TipoLocalArmazenamento $tipoLocalArmazenamento) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarNomeLocal($tipoLocalArmazenamento,$objExcecao); 
            $this->validarQntEspacosAmostras($tipoLocalArmazenamento,$objExcecao); 
            $this->validarQntEspacosTotal($tipoLocalArmazenamento,$objExcecao); 
            
            $objExcecao->lancar_validacoes();
            $objTipoLocalArmazenamentoBD = new TipoLocalArmazenamentoBD();
            $objTipoLocalArmazenamentoBD->cadastrar($tipoLocalArmazenamento,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando o tipo do local de armazenamento.', $e);
        }
    }

    public function alterar(TipoLocalArmazenamento $tipoLocalArmazenamento) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            $this->validarNomeLocal($tipoLocalArmazenamento,$objExcecao);   
            $this->validarQntEspacosAmostras($tipoLocalArmazenamento,$objExcecao); 
            $this->validarQntEspacosTotal($tipoLocalArmazenamento,$objExcecao); 
            
            $objExcecao->lancar_validacoes();
            $objTipoLocalArmazenamentoBD = new TipoLocalArmazenamentoBD();
            $objTipoLocalArmazenamentoBD->alterar($tipoLocalArmazenamento,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro alterando o tipo do local de armazenamento.', $e);
        }
    }

    public function consultar(TipoLocalArmazenamento $tipoLocalArmazenamento) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objTipoLocalArmazenamentoBD = new TipoLocalArmazenamentoBD();
            $arr =  $objTipoLocalArmazenamentoBD->consultar($tipoLocalArmazenamento,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando o tipo do local de armazenamento.',$e);
        }
    }

    public function remover(TipoLocalArmazenamento $tipoLocalArmazenamento) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objTipoLocalArmazenamentoBD = new TipoLocalArmazenamentoBD();
            $arr =  $objTipoLocalArmazenamentoBD->remover($tipoLocalArmazenamento,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo o tipo do local de armazenamento.', $e);
        }
    }

    public function listar(TipoLocalArmazenamento $tipoLocalArmazenamento) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objTipoLocalArmazenamentoBD = new TipoLocalArmazenamentoBD();
            
            $arr = $objTipoLocalArmazenamentoBD->listar($tipoLocalArmazenamento,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o tipo do local de armazenamento.',$e);
        }
    }


    public function pesquisar($campoBD, $valor_usuario) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objTipoLocalArmazenamentoBD = new TipoLocalArmazenamentoBD();
            $arr = $objTipoLocalArmazenamentoBD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro pesquisando o tipo do local de armazenamento.', $e);
        }
    }

}

?>
