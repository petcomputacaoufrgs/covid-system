<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class MontagemPlacaINT
{
    static function montar_select_situacao_montagem(&$select_situacoes_montagem,$objMontagem,$disabled =null,$onchange =null)
    {

        if(is_null($disabled)){ $disabled = ''; }
        else{ $disabled = ' disabled '; }

        if(is_null($onchange)){ $onchange = ''; }
        else{ $onchange = ' onchange="this.form.submit()" '; }

        $select_situacoes_montagem = ' <select ' . $disabled . $onchange .
            'class="form-control" name="sel_situacao_montagem" >
            <option value="-1">Selecione uma das situações de montagem </option>';

        $arr_situacoes_mix = MontagemPlacaRN::listarValoresStaMontagemPlaca();
        for ($i=0; $i<count($arr_situacoes_mix); $i++) {
            $selected = '';
            if($arr_situacoes_mix[$i]->getStrTipo()== $objMontagem->getSituacaoMontagem() ){
                $selected = ' selected ';
            }

            $select_situacoes_montagem .= '<option ' . $selected . ' value="'.$arr_situacoes_mix[$i]->getStrTipo().'">'
                . Pagina::formatar_html($arr_situacoes_mix[$i]->getStrDescricao()) . '</option>';
        }
        $select_situacoes_montagem .='</select>';
    }

}