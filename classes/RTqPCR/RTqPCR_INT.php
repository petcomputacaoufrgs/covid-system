<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class RTqPCR_INT
{
    static function montar_select_situacao_RTqPCR(&$select_situacoes_RTqPCR,$objRTqPCR,$disabled =null,$onchange =null)
    {

        if(is_null($disabled)){ $disabled = ''; }
        else{ $disabled = ' disabled '; }

        if(is_null($onchange)){ $onchange = ''; }
        else{ $onchange = ' onchange="this.form.submit()" '; }

        $select_situacoes_RTqPCR = ' <select ' . $disabled . $onchange .
            'class="form-control" name="sel_situacao_rtqpcr" onblur="">
                            <option value="-1">Selecione uma das situações da do RTqPCR </option>';

        $arr_situacoes_RTqPCR = RTqPCR_RN::listarValoresStaRTqPCR();
        for ($i=0; $i<count($arr_situacoes_RTqPCR); $i++) {
            $selected = '';
            if($arr_situacoes_RTqPCR[$i]->getStrTipo()== $objRTqPCR->getSituacaoRTqPCR() ){
                $selected = ' selected ';
            }

            $select_situacoes_RTqPCR .= '<option ' . $selected . ' value="'.$arr_situacoes_RTqPCR[$i]->getStrTipo().'">'
                . Pagina::formatar_html($arr_situacoes_RTqPCR[$i]->getStrDescricao()) . '</option>';
        }
        $select_situacoes_RTqPCR .='</select>';
    }

    static function montar_select_RTqPCR(&$select_rtpcr,$objRTqPcr,$objRTqPcrRN, $disabled =null,$onchange =null){
    {

        if(is_null($disabled)){ $disabled = ''; }
        else{ $disabled = ' disabled '; }

        if(is_null($onchange)){ $onchange = ''; }
        else{ $onchange = ' onchange="this.form.submit()" '; }

        $select_rtpcr = ' <select ' . $disabled . $onchange .
            'class="form-control" name="sel_rtqpcr" onblur="">
                            <option value="-1">Selecione um RTqPCR </option>';

        $arr_RTqPCR = $objRTqPcrRN->listar($objRTqPcr);


        foreach ($arr_RTqPCR as $rtqpcr)
            $selected = '';
            if($rtqpcr->getIdRTqPCR()== $objRTqPcr->getIdRTqPCR() ){
                $selected = ' selected ';
            }

            $select_rtpcr .= '<option ' . $selected . ' value="'.$rtqpcr->getIdRTqPCR().'"> RTqPCR: '
                . Pagina::formatar_html($rtqpcr->getIdRTqPCR()) . '  | Placa: '.$rtqpcr->getIdPlacaFk().' | Equipamento: '.$rtqpcr->getIdEquipamentoFk().' </option>';
        }
        $select_rtpcr .='</select>';
    }
}