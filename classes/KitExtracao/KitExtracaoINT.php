<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class KitExtracaoINT
{
    static function montar_select_kitsExtracao(&$select_kits_extracao, $objKitExtracao, $objKitExtracaoRN,$disabled=null, $onchange=null){

        if(is_null($disabled)){ $disabled = ''; }
        else{$disabled = ' disabled '; }

        if(is_null($onchange)){ $onchange = ''; }
        else{ $onchange = ' onchange="this.form.submit()" ';}

        $select_kits_extracao = '<select  class="form-control" '
            . 'data-live-search="true"  '.$disabled.$onchange
            . 'name="sel_kit_extracao">'
            . '<option data-tokens="" value="-1">Selecione um kit de extração </option>';

        $arr_kits_extracao = $objKitExtracaoRN->listar(new KitExtracao());

        foreach ($arr_kits_extracao as $ke){

            $selected = ' ';
            if($objKitExtracao->getIdKitExtracao() == $ke->getIdKitExtracao() ){
                $selected = ' selected ';
            }

            $select_kits_extracao .=  '<option ' . $selected .
                '  value="' . Pagina::formatar_html($ke->getIdKitExtracao())
                . '" data-tokens="' .Pagina::formatar_html($ke->getNome()). '">'
                . Pagina::formatar_html($ke->getNome()) .'</option>';

        }

        $select_kits_extracao .= '</select>';

    }
}