<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class ProtocoloINT
{
    static function montar_select_protocolo(&$select_protocolo,$objProtocolo,$disabled =null,$onchange =null)
    {

        if(is_null($disabled)){ $disabled = ''; }
        else{ $disabled = ' disabled '; }

        if(is_null($onchange)){ $onchange = ''; }
        else{ $onchange = ' onchange="this.form.submit()" '; }

        $select_protocolo = ' <select ' . $disabled . $onchange .
            'class="form-control" name="sel_tipos_protocolos" onblur="">
                            <option value="-1">Selecione um dos tipos de protocolo </option>';

        $arr_protocolos = ProtocoloRN::listarTiposProtocolos();
        for ($i=0; $i<count($arr_protocolos); $i++) {
            $selected = '';
            if($arr_protocolos[$i]->getStrTipo()== $objProtocolo->getCaractere() ){
                $selected = ' selected ';
            }

            $select_protocolo .= '<option ' . $selected . ' value="'.$arr_protocolos[$i]->getStrTipo().'">'
                . Pagina::formatar_html($arr_protocolos[$i]->getStrDescricao()) . '</option>';
        }
        $select_protocolo .='</select>';
    }
}