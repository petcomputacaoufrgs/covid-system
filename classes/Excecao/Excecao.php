<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */




class Excecao extends Exception{
    private $array_validacoes;
    private $e;
    
    function __construct($texto = null, $e = null) {
        
        $this->array_validacoes = array();
        
        if($e != null){
            if($e instanceof Excecao){
                $this->e = $e->get_excecao();
                $this->array_validacoes = $e->get_validacoes();
            }else{
                $this->e = $e;
            }
        }
        
    }
    
    public function adicionar_validacao($texto, $campo = null){
        $this->array_validacoes[] = array($texto, $campo);
    }
    
    public function lancar_validacoes(){
        if(count($this->array_validacoes)){
            //print_r($this->array_validacoes);
            throw $this;
        }
    }
    
    public function possui_validacoes(){
       return count($this->array_validacoes);
    }
    
    public function get_excecao(){
        return $this->e;
    }
    public function get_validacoes(){
        return $this->array_validacoes;
    }
    
    public function __toString() {
        
        if($this->e != null && $this->e instanceof Excecao){
            $e = $this->e;
        }else{
            $e = $this;
        }
        
        
        if($e->possui_validacoes()){
            $msg = '';
           
            foreach ($e->get_validacoes() as $validacao){
                if($msg != ''){
                    $msg .= "\n";
                }
                $msg .= $validacao[0];
            }
            return $msg;
            
        }else{
            return $this->e->__toString();
            
        }
    }
}