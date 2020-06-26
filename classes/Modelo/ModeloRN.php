<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do modelo do paciente
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/ModeloBD.php';

class ModeloRN{
    

    private function validarModelo(Modelo $modelo,Excecao $objExcecao){
        $strModelo = trim($modelo->getModelo());
        
        if ($strModelo == '') {
            $objExcecao->adicionar_validacao('O modelo não foi informado','idModelo');
        }else{
            if (strlen($strModelo) > 100) {
                $objExcecao->adicionar_validacao('O modelo possui mais que 100 caracteres.','idModelo');
            }
            
        }
        
        return $modelo->setModelo($strModelo);

    }
    private function validarRemocao(Modelo $modelo,Excecao $objExcecao){
        $objEquipamento = new Equipamento();
        $objEquipamentoRN = new EquipamentoRN();


        $objEquipamento->setIdModelo_fk($modelo->getIdModelo());
        $arr = $objEquipamentoRN->existe($objEquipamento);

        //print_r($arr);
        if(count($arr) > 0){
            $objExcecao->adicionar_validacao('O modelo não pode ser excluído porque tem um equipamento associado a ele','idLocalArmazenamento', 'alert-danger');
        }
    }
    
    public function cadastrar(Modelo $modelo) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objModeloBD = new ModeloBD();
            
            $this->validarModelo($modelo,$objExcecao); 
            
            $objExcecao->lancar_validacoes();
            $objModelo = $objModeloBD->cadastrar($modelo,$objBanco);


            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objModelo;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o modelo.', $e);
        }
    }

    public function alterar(Modelo $modelo) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            
            $this->validarModelo($modelo,$objExcecao);   
                        
            $objExcecao->lancar_validacoes();
            $objModeloBD = new ModeloBD();
            $objModelo = $objModeloBD->alterar($modelo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objModelo;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o modelo.', $e);
        }
    }

    public function consultar(Modelo $modelo) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objModeloBD = new ModeloBD();
           
            $arr =  $objModeloBD->consultar($modelo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o modelo.',$e);
        }
    }

    public function remover(Modelo $modelo) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

             $this->validarRemocao($modelo,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objModeloBD = new ModeloBD();
            $arr =  $objModeloBD->remover($modelo,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o modelo.', $e);
        }
    }

    public function listar(Modelo $modelo,$numLimite = null) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objModeloBD = new ModeloBD();
            
            $arr = $objModeloBD->listar($modelo,$numLimite,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o modelo.',$e);
        }
    }


    public function pesquisar_index(Modelo $modelo) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objModeloBD = new ModeloBD();
            $arr = $objModeloBD->pesquisar_index($modelo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro pesquisando o modelo.', $e);
        }
    }

}

