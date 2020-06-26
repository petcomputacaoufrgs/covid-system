<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class CalculoINT
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new CalculoINT();
        }
        return self::$instance;
    }

    static function montar_select_calculo(&$select_calculo,$objCalculo, $objCalculoRN,$disabled =null,$onchange =null)
    {

        if(is_null($disabled)){ $disabled = ''; }
        else{ $disabled = ' disabled '; }

        if(is_null($onchange)){ $onchange = ''; }
        else{ $onchange = ' onchange="this.form.submit()" '; }

        $select_calculo = ' <select ' . $disabled . $onchange .
            'class="form-control" name="sel_calculo" onblur="">
            <option value="-1">Selecione um dos cálculos </option>';

        $arr_calculos = $objCalculoRN->listar($objCalculo);
        foreach ($arr_calculos as $calculo) {
            $selected = '';
            if($calculo->getIdCalculo()== $objCalculo->getIdCalculo() ){
                $selected = ' selected ';
            }

            $select_calculo .= '<option ' . $selected . ' value="'.Pagina::formatar_html($calculo->getIdCalculo()).'">'
                . Pagina::formatar_html($calculo->getNome()) . '</option>';
        }
        $select_calculo .='</select>';
    }

}