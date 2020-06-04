<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class PesquisaINT
{

    static function montar_select_pesquisa(&$select_pesquisa,$array_colunas, $positionSelected=null,$disabled =null,$onchange =null)
    {
        $selected = '';

        $select_pesquisa = ' <select id="item1"  ' . $disabled . $onchange .
            'class="form-control" name="sel_pesquisa_coluna" onblur="">
                            <option value="-1">Selecione um dos campos de pesquisa</option>';

        for ($i=0; $i<count($array_colunas); $i++) {
            $selected = '';
            if($i == $positionSelected && $positionSelected != null){
                $selected = ' selected ';
            }

            $select_pesquisa .= '<option ' . $selected . ' value="'.$i.'">'
                . Pagina::formatar_html($array_colunas[$i]) . '</option>';
        }
        $select_pesquisa .='</select>';
    }
}