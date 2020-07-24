<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class AnaliseQualidadeINT
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new AnaliseQualidadeINT();
        }
        return self::$instance;
    }

    //SELECT COM OU SEM QUALIDADE
    static function montar_select_resultados_analise(&$select_resultado,$objAnaliseQualidade,$disabled = null ,$onchange = null){

        if(is_null($disabled)){ $disabled = '';}
        else{ $disabled = ' disabled ';}
        if(is_null($onchange)) { $onchange = '';}
        else{ $onchange = ' onchange="this.form.submit()" ';}

        $select_resultado = '<select  class="form-control " '
            . 'data-live-search="true"  '.$disabled.$onchange
            . 'name="sel_resultado_analise">'
            . '<option data-tokens="">Selecione o resultado da análise </option>';

        foreach (AnaliseQualidadeRN::listarValoresTipoResultadoAnalise() as $resultadoAnalise){

            $selected = ' ';
            if(!is_null($objAnaliseQualidade->getResultado()) && $objAnaliseQualidade->getResultado() == $resultadoAnalise->getStrTipo() ){
                $selected = ' selected ';
            }

            $select_resultado .=  '<option ' . $selected .
                '  value="' . Pagina::formatar_html($resultadoAnalise->getStrTipo())
                . '" data-tokens="' .Pagina::formatar_html($resultadoAnalise->getStrDescricao()). '">'
                . Pagina::formatar_html($resultadoAnalise->getStrDescricao()) .'</option>';

        }

        $select_resultado .= '</select>';

    }
}