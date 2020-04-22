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

    public static function validarData($dataPassada,$objExcecao){

       // echo $dataPassada;
        $data = explode("-", $dataPassada);

            $ano = $data[0];
            $mes = $data[1];
            $dia = $data[2];

            //echo "\n".$dia."\n";
            //echo $mes."\n";
            //echo $ano."\n \n";

            $atual = date("d-m-Y");

            $atual_aux = explode("-", $atual);

            $dia_aux = $atual_aux[0];
            $mes_aux = $atual_aux[1];
            $ano_aux = $atual_aux[2];

            /*echo "\n".$dia_aux."\n";
            echo $mes_aux."\n";
            echo $ano_aux."\n";

            echo "dia:".$dia."\n";
            echo "dia_aux:".$dia_aux;*/
            /*
            if($ano == $ano_aux) {

                if ($mes > $mes_aux) { //ano é menor ou igual mas o mês é maior
                    //echo $mes.">".$mes_aux."\n";
                    $objExcecao->adicionar_validacao('O mês informado é maior que o mês atual no ano atual', 'idDataHora', 'alert-danger');
                } else if ($mes == $mes_aux) {
                    //echo $dia.">".$dia_aux."\n";
                    if ($dia > $dia_aux) { //ano e mês estão certos, mas o dia é maior que o dia atual
                        $objExcecao->adicionar_validacao('O dia informado é maior que o dia do mês atual e do ano atual', 'idDataHora', 'alert-danger');
                    }
                }
            }
            else if($ano > $ano_aux){ //ano maior que o ano atual
                $objExcecao->adicionar_validacao('O ano informado é maior que o ano atual','idDataHora','alert-danger');
            }*/


    }

}
