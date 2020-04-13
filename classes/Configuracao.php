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
            /*
            
            'banco' => array('servidor' => 'db2.inf.ufrgs.br', 
                             'nome' => 'covid19_rtpcr',
                             'usuario' => 'covid19_rtpcr',
                             'senha' => 'tu4ei%PeaEe?p2Oew3Gei'),
             
             */
            
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
