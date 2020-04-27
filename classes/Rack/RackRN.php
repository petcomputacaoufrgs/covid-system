<?php

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/RackBD.php';

class RackRN{

    private function validarNome(Rack $rack,Excecao $objExcecao){
        $strNome = trim($rack->getNome());
        
        if ($strNome == '') {
            $objExcecao->adicionar_validacao('O nome do rack não foi informado','idNomeRack', 'alert-danger');
        }else{
            if (strlen($strNome) > 50) {
                $objExcecao->adicionar_validacao('O nome do rack possui mais que 50 caracteres.','idNomeRack', 'alert-danger');
            }
        }
        
        return $rack->setNome($strNome);

    }

    public function cadastrar(Rack $rack) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            /*REALIZAR VALIDACOES*/ 

            $objExcecao->lancar_validacoes();
            $objRackBD = new RackBD();
            $objRackBD->cadastrar($rack,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando o rack.', $e);
        }
    }

    public function alterar(Rack $rack) {
        try {
            
           $objExcecao = new Excecao();
           $objBanco = new Banco();
           $objBanco->abrirConexao(); 
           
           /*REALZIAR VALIDACOES*/
                       
           $objExcecao->lancar_validacoes();
           $objRackBD = new RackBD();
           $objRackBD->alterar($rack,$objBanco);
           
           $objBanco->fecharConexao();
       } catch (Exception $e) {
           throw new Excecao('Erro alterando o rack.', $e);
       }
   }

   public function consultar(Rack $rack) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRackBD = new RackBD();
            $arr =  $objRackBD->consultar($rack,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {

            throw new Excecao('Erro consultando o rack.',$e);
        }
    }

    public function remover(Rack $rack) {
        try {
           $objExcecao = new Excecao();
           $objBanco = new Banco();
           $objBanco->abrirConexao(); 
           $objExcecao->lancar_validacoes();
           $objRackBD = new RackBD();
           $arr =  $objRackBD->remover($rack,$objBanco);
           $objBanco->fecharConexao();
           return $arr;

       } catch (Exception $e) {
           throw new Excecao('Erro removendo o rack.', $e);
       }
   }

   public function listar(Rack $rack) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objRackBD = new RackBD();
            
            $arr = $objRackBD->listar($Rack,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando o rack.',$e);
        }
    }
}