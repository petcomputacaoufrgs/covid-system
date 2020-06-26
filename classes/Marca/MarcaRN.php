<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio da marca do paciente
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/MarcaBD.php';

class MarcaRN{
    

    private function validarMarca(Marca $marca,Excecao $objExcecao){
        $strMarca = trim($marca->getMarca());
        
        if ($strMarca == '') {
            $objExcecao->adicionar_validacao('A marca não foi informado','idMarca');
        }else{
            if (strlen($strMarca) > 100) {
                $objExcecao->adicionar_validacao('A marca possui mais que 100 caracteres.','idMarca');
            }
            
        }
        
        return $marca->setMarca($strMarca);
    }

    private function validarRemocao(Marca $marca,Excecao $objExcecao){
        $objEquipamento = new Equipamento();
        $objEquipamentoRN = new EquipamentoRN();


        $objEquipamento->setIdMarca_fk($marca->getIdMarca());
        $arr = $objEquipamentoRN->existe($objEquipamento);

        //print_r($arr);
        if(count($arr) > 0){
            $objExcecao->adicionar_validacao('A marca não pode ser excluída porque tem um equipamento associado a ela','idLocalArmazenamento', 'alert-danger');
        }
    }
    
        
  
    public function cadastrar(Marca $marca) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objMarcaBD = new MarcaBD();
            
            $this->validarMarca($marca,$objExcecao);
            
            $objExcecao->lancar_validacoes();
            $objMarca = $objMarcaBD->cadastrar($marca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objMarca;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando a marca.', $e);
        }
    }

    public function alterar(Marca $marca) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            
            $this->validarMarca($marca,$objExcecao);
            
                        
            $objExcecao->lancar_validacoes();
            $objMarcaBD = new MarcaBD();
            $objMarca = $objMarcaBD->alterar($marca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objMarca;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando a marca.', $e);
        }
    }

    public function consultar(Marca $marca) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objMarcaBD = new MarcaBD();
            $arr =  $objMarcaBD->consultar($marca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando a marca.',$e);
        }
    }

    public function remover(Marca $marca) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarRemocao($marca,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objMarcaBD = new MarcaBD();
            $arr =  $objMarcaBD->remover($marca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo a marca.', $e);
        }
    }

    public function listar(Marca $marca,$numLimite = null) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objMarcaBD = new MarcaBD();
            
            $arr = $objMarcaBD->listar($marca,$numLimite,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando a marca.',$e);
        }
    }


     public function pesquisar_index(Marca $marca) {
         $objBanco = new Banco();
         try {

             $objExcecao = new Excecao();
             $objBanco->abrirConexao();
             $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objMarcaBD = new MarcaBD();
            $arr = $objMarcaBD->pesquisar_index($marca,$objBanco);

             $objBanco->confirmarTransacao();
             $objBanco->fecharConexao();
             return $arr;
         } catch (Throwable $e) {
             $objBanco->cancelarTransacao();
            throw new Excecao('Erro pesquisando o modelo.', $e);
        }
    }

}

