<?php

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/PortaRackBD.php';

class PortaRackRN{

    public function cadastrar(PortaRack $portaRack) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            
            /*REALIZAR VALIDACOES*/ 

            $objExcecao->lancar_validacoes();
            $objPortaRackBD = new PortaRackBD();
            $objPortaRackBD->cadastrar($portaRack,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando a porta do rack.', $e);
        }
    }

    public function alterar(PortaRack $portaRack) {
        try {
            
           $objExcecao = new Excecao();
           $objBanco = new Banco();
           $objBanco->abrirConexao(); 
           
           /*REALZIAR VALIDACOES*/
                       
           $objExcecao->lancar_validacoes();
           $objPortaRackBD = new PortaRackBD();
           $objPortaRackBD->alterar($portaRack,$objBanco);
           
           $objBanco->fecharConexao();
       } catch (Exception $e) {
           throw new Excecao('Erro alterando a porta do rack.', $e);
       }
   }

   public function consultar(PortaRack $portaRack) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objPortaRackBD = new PortaRackBD();
            $arr =  $objPortaRackBD->consultar($portaRack,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {

            throw new Excecao('Erro consultando a porta do rack.',$e);
        }
    }

    public function remover(PortaRack $portaRack) {
        try {
           $objExcecao = new Excecao();
           $objBanco = new Banco();
           $objBanco->abrirConexao(); 
           $objExcecao->lancar_validacoes();
           $objPortaRackBD = new PortaRackBD();
           $arr =  $objPortaRackBD->remover($portaRack,$objBanco);
           $objBanco->fecharConexao();
           return $arr;

       } catch (Exception $e) {
           throw new Excecao('Erro removendo a porta do rack.', $e);
       }
   }

   public function listar(PortaRack $portaRack) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objPortaRackBD = new PortaRackBD();
            
            $arr = $objPortaRackBD->listar($portaRack,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando a porta do rack.',$e);
        }
    }
}