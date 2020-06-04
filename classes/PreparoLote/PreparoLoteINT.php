<?php


class PreparoLoteINT
{
    static function montar_select_lotes(&$select_preparos_lote,$objPreparoLote, $objPreparoLoteRN, $disabled=null, $onchange=null)
    {

        if(is_null($disabled)){ $disabled = '';}
        else{ $disabled = ' disabled ';}
        if(is_null($onchange)) { $onchange = '';}
        else{ $onchange = ' onchange="this.form.submit()" ';}


        $select_preparos_lote = '<select  class="form-control " '
            . 'data-live-search="true"  ' . $disabled.$onchange
            . 'name="sel_preparo_lote">'
            . '<option data-tokens="" value="-1">Selecione um grupo </option>';


        $arr_preparo_lotes = $objPreparoLoteRN->listar_com_lote($objPreparoLote);

        /*
        echo "<pre>";
        print_r($arr_preparo_lotes);
        echo "</pre>";
        */

        foreach ($arr_preparo_lotes as $preparo_lote) {
            $lote =  $preparo_lote->getObjLote();
            if($lote->getTipo() == LoteRN::$TL_PREPARO){
                $nome = LoteRN::$TNL_ALIQUOTAMENTO;
            }

            if($lote->getTipo() == LoteRN::$TL_EXTRACAO){
                $nome = LoteRN::$TL_EXTRACAO;
            }

            $selected = '';
            if ($preparo_lote->getIdPreparoLote() == $objPreparoLote->getIdPreparoLote()) {
                $selected = ' selected ';
            }

            $select_preparos_lote .= '<option ' . $selected .
                'value="' . Pagina::formatar_html($preparo_lote->getIdPreparoLote())
                . '" data-tokens="' . Pagina::formatar_html($preparo_lote->getIdPreparoLote()) . '">
                    Lote: ' .$nome. Pagina::formatar_html($lote->getIdLote()) . ' com ' . Pagina::formatar_html($lote->getQntAmostrasAdquiridas()) . ' amostras</option>';

        }


        $select_preparos_lote .= '</select>';

    }
}