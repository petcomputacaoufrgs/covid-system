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
        return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(Ç)/","/(ç)/"),explode(" ","a A e E i I o O u U n N c C"),$string);
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

    public static function ordenarArrDatas($arrDatas)
    {
        foreach ($arrDatas as $data){

        }

        function cmp($a, $b) {
            return $a['nome'] > $b['nome'];
        }

    }

    public static function converterData($dataPassada)
    {

        $data = explode("-", $dataPassada);

        $dia = $data[2];
        $mes = $data[1];
        $ano = $data[0];

        if($dia == '00'){
            return " - ";
        }

        return $dia."/".$mes."/".$ano;
    }

    public static function converterDataHora($dataHoraPassada)
    {

        $dataHora = explode(" ", $dataHoraPassada);
        $data = explode("-", $dataHora[0]);

        $dia = $data[2];
        $mes = $data[1];
        $ano = $data[0];

        if($dia == '00'){
            return " - ";
        }

        return $dia."/".$mes."/".$ano. " - ".$dataHora[1];

    }

    public static function getStrData($dataHoraPassada)
    {

        $dataHora = explode(" ", $dataHoraPassada);
        $data = explode("-", $dataHora[0]);

        $dia = $data[2];
        $mes = $data[1];
        $ano = $data[0];

        if($dia == '00'){
            return " - ";
        }

        return $dia."/".$mes."/".$ano;

    }

    public static function getData($dataHoraPassada)
    {

        $dataHora = explode(" ", $dataHoraPassada);

        return $dataHora[0];

    }

    public static function compararDataHora($strDataHoraIni, $strDataHoraFim)
    {

        if ($strDataHoraIni===null || $strDataHoraFim===null || trim($strDataHoraIni)==='' || trim($strDataHoraFim)==='') {
            return null;
        }

        $arrDataIni = explode('-', $strDataHoraIni);
        $arrDataFim = explode('-', $strDataHoraFim);


        if (strlen($arrDataIni[2])===11) {
            $arrHoraIni = explode(':', substr($arrDataIni[2], 3));
            $arrDataIni[2] = substr($arrDataIni[2], 0, 2);
        } else {
            $arrHoraIni = array(0, 0, 0);
        }

        if (strlen($arrDataFim[2])===11) {
            $arrHoraFim = explode(':', substr($arrDataFim[2], 3));
            $arrDataFim[2] = substr($arrDataFim[2], 0, 2);
        } else {
            $arrHoraFim = array(0, 0, 0);
        }


        //print_r($arrDataIni);
        //die();
        /*
        echo "INICIO DATA -- \n";
        echo "arrHoraIni0: ".$arrHoraIni[0]."\n";
        echo "arrHoraIni1: ".$arrHoraIni[1]."\n";
        echo "arrHoraIni2: ".$arrHoraIni[2]."\n";
        echo "arrDataIni0: ".$arrDataIni[2]."\n";
        echo "arrDataIni1: ".$arrDataIni[1]."\n";
        echo "arrDataIni2: ".$arrDataIni[0]."\n";

        echo "FIM DATA -- \n";
        echo "arrHoraFim0: ".$arrHoraFim[0]."\n";
        echo "arrHoraFim1: ".$arrHoraFim[1]."\n";
        echo "arrHoraFim2: ".$arrHoraFim[2]."\n";
        echo "arrDataFim0: ".$arrDataFim[2]."\n";
        echo "arrDataFim1: ".$arrDataFim[1]."\n";
        echo "arrDataFim2: ".$arrDataFim[0]."\n";
        */

        $strHrIni = $arrDataIni[0].$arrDataIni[1].$arrDataIni[2].$arrHoraIni[0].$arrHoraIni[1].$arrHoraIni[2];
        //echo "int: ".intval($strHrIni)."--";

        $strHrFim = $arrDataFim[0].$arrDataFim[1].$arrDataFim[2].$arrHoraFim[0].$arrHoraFim[1].$arrHoraFim[2];
        //echo "intFinal: ".intval($strHrFim)."--";

        //echo "final - inicial: ".(intval($strHrFim)-intval($strHrIni));

        //usa gmmktime para evitar interferencia do horario de verao
        //$iniDate = gmmktime((int)$arrHoraIni[0], (int)$arrHoraIni[1], (int)$arrHoraIni[2], (int)$arrDataIni[1], (int)$arrDataIni[2], (int)$arrDataIni[0]);
        //echo "inidate ".$iniDate."\n";
        //$fimDate = gmmktime((int)$arrHoraFim[0], (int)$arrHoraFim[1], (int)$arrHoraFim[2], (int)$arrDataFim[1], (int)$arrDataFim[2], (int)$arrDataFim[0]);
        //echo "fimdate ".$fimDate."\n";

        return (intval($strHrFim)-intval($strHrIni));
    }

    static function random_color($opacidade) {


        $letters = '0123456789ABCDEF';
        $color = '#';

        if($opacidade == 80){
            $color .= 'CC';
        }

        for($i = 0; $i < 6; $i++) {
            $index = rand(0,15);
            $color .= $letters[$index];
        }
        return $color;
    }
}
