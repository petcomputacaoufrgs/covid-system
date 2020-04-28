<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
class Utils{
    
    private static $instance;
    
    public static  function getInstance(){
        if(self::$instance == null){
            self::$instance= new Utils();
        }
        return self::$instance;
    }
    
        
    function tirarAcentos($string){
        return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
    }

    public static function validarData($dataPassada,$objExcecao)
    {

        $atual = date("Y-m-d");

        if ($dataPassada > $atual) {
            //echo $dataPassada . " > " . $atual . "\n";
            $objExcecao->adicionar_validacao('A data informada é maior que a data atual', 'idDataHora', 'alert-danger');
        } else {
            //echo $dataPassada . " <= " . $atual . "\n";
        }



    }

    static function random_color() {
        $letters = '0123456789ABCDEF';
        $color = '#';
        for($i = 0; $i < 6; $i++) {
            $index = rand(0,15);
            $color .= $letters[$index];
        }
        return $color;
    }
}
