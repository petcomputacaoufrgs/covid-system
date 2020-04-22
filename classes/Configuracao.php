<?php

class Configuracao{
    private static $instance;
    
    public static  function getInstance(){
        if(self::$instance == null){
            self::$instance= new Configuracao();
        }
        return self::$instance;
    }
    
    private function getArray(){
        require __DIR__ . '/../config.php';
        return $config;
    }
    
    
    
    public function getValor($strChave){
        $arr = $this->getArray();
        if(!isset($arr[$strChave])){
            throw new Exception("Configuração ".$strChave." não encontrada.");
        }
        return $arr[$strChave];
    }
}
