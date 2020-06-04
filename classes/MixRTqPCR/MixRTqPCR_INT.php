<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class MixRTqPCR_INT
{
    static function montar_select_situacao_mix(&$select_situacoes_mix,$objMix,$disabled =null,$onchange =null)
    {

        if(is_null($disabled)){ $disabled = ''; }
        else{ $disabled = ' disabled '; }

        if(is_null($onchange)){ $onchange = ''; }
        else{ $onchange = ' onchange="this.form.submit()" '; }

        $select_situacoes_mix = ' <select ' . $disabled . $onchange .
            'class="form-control" name="sel_situacao_mix" >
            <option value="-1">Selecione uma das situações do mix </option>';

        $arr_situacoes_mix = MixRTqPCR_RN::listarValoresStaMix();
        for ($i=0; $i<count($arr_situacoes_mix); $i++) {
            $selected = '';
            if($arr_situacoes_mix[$i]->getStrTipo()== $objMix->getSituacaoMix() ){
                $selected = ' selected ';
            }

            $select_situacoes_mix .= '<option ' . $selected . ' value="'.$arr_situacoes_mix[$i]->getStrTipo().'">'
                . Pagina::formatar_html($arr_situacoes_mix[$i]->getStrDescricao()) . '</option>';
        }
        $select_situacoes_mix .='</select>';
    }

    static function montar_select_mix_dadaSituacao(&$select_mix,$objMix,$objMixRN,$disabled =null,$onchange =null)
    {

        if(is_null($disabled)){ $disabled = ''; }
        else{ $disabled = ' disabled '; }

        if(is_null($onchange)){ $onchange = ''; }
        else{ $onchange = ' onchange="this.form.submit()" '; }

        $select_mix = ' <select ' . $disabled . $onchange .
            'class="form-control" name="sel_mix" >
            <option value="-1">Selecione um dos mix </option>';


        $arr_mix = $objMixRN->listar($objMix,null,true);
        foreach ($arr_mix as $mix){
            $selected = '';
            if($mix->getIdMixPlaca() == $objMix->getIdMixPlaca() ){
                $selected = ' selected ';
            }

            $objPlaca = $mix->getObjSolicitacao()->getObjPlaca();


            $strTubos = '';
            $strAmostras = '';

            foreach($objPlaca->getObjRelTuboPlaca() as $tubo){
                foreach ($tubo->getObjTubo() as $amostra) {
                    $strAmostras .= $amostra->getNickname() . ",";
                }
            }
            $strAmostras = substr($strAmostras, 0, -1);

            $select_mix .= '<option ' . $selected . ' value="'.$mix->getIdMixPlaca().'"> 
            Mix de número '.Pagina::formatar_html($mix->getIdMixPlaca())
                .": ". Pagina::formatar_html($strAmostras) . '</option>';
        }
        $select_mix .='</select>';
    }
}