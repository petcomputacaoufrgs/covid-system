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
        return array(
            'versao' => '1.0.0',
            'producao' => false,

            'banco' => array('servidor' => 'localhost',
                'nome' => 'amostras_covid19',
                'usuario' => 'root',
                'senha' => ''),

        );

    }
    
    
    
    public function getValor($strChave){
        $arr = $this->getArray();
        if(!isset($arr[$strChave])){
            throw new Exception("Configuração ".$strChave." não encontrada.");
        }
        return $arr[$strChave];
    }
}
