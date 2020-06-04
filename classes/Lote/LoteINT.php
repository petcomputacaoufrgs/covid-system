<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
class LoteINT
{

    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new LoteINT();
        }
        return self::$instance;
    }

    static function montar_select_situacao_lote(&$select_situacao_lote, $positionSelected=null, $disabled = null, $onchange = null)
    {
        $selected = '';

        $select_situacao_lote = ' <select ' . $disabled . $onchange .
            'class="form-control" name="sel_situacao_lote" onblur="">
                            <option value="-1">Selecione uma das situações do lote</option>';
        $arr_situacoes = LoteRN::listarValoresSituacaoLote();
        //print_r($arr_situacoes);

        for ($i=0; $i<count($arr_situacoes); $i++) {
            $selected = '';
            if ($arr_situacoes[$i]->getStrTipo() == $positionSelected && $positionSelected != null) {
                $selected = ' selected ';
            }

            $select_situacao_lote .= '<option ' . $selected . ' value="' . $arr_situacoes[$i]->getStrTipo() . '">'
                . Pagina::formatar_html($arr_situacoes[$i]->getStrDescricao()) . '</option>';
        }
        $select_situacao_lote .= '</select>';
    }


    static function montar_select_lotes(&$select_lotes,$objLote, $objLoteRN, $disabled=null, $onchange=null)
    {

        if(is_null($disabled)){ $disabled = '';}
        else{ $disabled = ' disabled ';}
        if(is_null($onchange)) { $onchange = '';}
        else{ $onchange = ' onchange="this.form.submit()" ';}


        $select_lotes = '<select  class="form-control " '
            . ' data-live-search="true"  ' . $disabled.$onchange
            . 'name="sel_lote">'
            . '<option data-tokens="" value="-1">Selecione um grupo </option>';


        $arr_lotes = $objLoteRN->listar($objLote);


        foreach ($arr_lotes as $lote) {
            if($lote->getTipo() == LoteRN::$TL_PREPARO){
                $nome = LoteRN::$TNL_ALIQUOTAMENTO;
            }

            if($lote->getTipo() == LoteRN::$TL_EXTRACAO){
                $nome = LoteRN::$TL_EXTRACAO;
            }

            $selected = '';
            if ($lote->getIdLote() == $objLote->getIdLote()) {
                $selected = ' selected ';
            }

            $select_lotes .= '<option ' . $selected .
                'value="' . Pagina::formatar_html($lote->getObjPreparo()->getIdPreparoLote())
                . '" data-tokens="' . Pagina::formatar_html($lote->getIdLote()) . '">
                    Lote: ' .$nome. Pagina::formatar_html($lote->getIdLote()) . ' com ' . Pagina::formatar_html($lote->getQntAmostrasAdquiridas()) . ' amostras</option>';

        }


        $select_lotes .= '</select>';

    }
}
