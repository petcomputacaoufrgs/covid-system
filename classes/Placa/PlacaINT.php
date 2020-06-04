<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class PlacaINT
{
    static function montar_select_situacao_placa(&$select_situacoes_placa,$objPlaca,$disabled =null,$onchange =null)
    {

        if(is_null($disabled)){ $disabled = ''; }
        else{ $disabled = ' disabled '; }

        if(is_null($onchange)){ $onchange = ''; }
        else{ $onchange = ' onchange="this.form.submit()" '; }

        $select_situacoes_placa = ' <select ' . $disabled . $onchange .
            'class="form-control" name="sel_situacao_placa" onblur="">
                            <option value="-1">Selecione uma das situações da placa </option>';

        $arr_situacoes_placa = PlacaRN::listarValoresStaPlaca();
        for ($i=0; $i<count($arr_situacoes_placa); $i++) {
            $selected = '';
            if($arr_situacoes_placa[$i]->getStrTipo()== $objPlaca->getSituacaoPlaca() ){
                $selected = ' selected ';
            }

            $select_situacoes_placa .= '<option ' . $selected . ' value="'.$arr_situacoes_placa[$i]->getStrTipo().'">'
                . Pagina::formatar_html($arr_situacoes_placa[$i]->getStrDescricao()) . '</option>';
        }
        $select_situacoes_placa .='</select>';
    }
}