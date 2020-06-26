<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class CapelaINT
{

    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new CapelaINT();
        }
        return self::$instance;
    }

    //ocupada ou liberada
    static function montar_select_situacao_capela(&$select_situacao,$objCapela,$disabled = null ,$onchange = null){

        if(is_null($disabled)){ $disabled = '';}
        else{ $disabled = ' disabled ';}
        if(is_null($onchange)) { $onchange = '';}
        else{ $onchange = ' onchange="this.form.submit()" ';}

        $select_situacao = '<select  class="form-control " '
            . 'id="idSituacaoCapela" data-live-search="true"  '.$disabled.$onchange
            . 'name="sel_situacaoCapela">'
            . '<option data-tokens="">Selecione a situação da capela </option>';

        foreach (CapelaRN::listarValoresTipoEstado() as $situacaoCapela){

            $selected = ' ';
            if($objCapela->getSituacaoCapela() ==$situacaoCapela->getStrTipo() ){
                $selected = ' selected ';
            }

            $select_situacao .=  '<option ' . $selected .
                '  value="' . Pagina::formatar_html($situacaoCapela->getStrTipo())
                . '" data-tokens="' .Pagina::formatar_html($situacaoCapela->getStrDescricao()). '">'
                . Pagina::formatar_html($situacaoCapela->getStrDescricao()) .'</option>';

        }

        $select_situacao .= '</select>';

    }

    static function montar_capelas_liberadas(&$select_capelas,$objCapela, $objCapelaRN, $disabled = null ,$onchange = null){

        if(is_null($disabled)){ $disabled = '';}
        else{ $disabled = ' disabled ';}
        if(is_null($onchange)) { $onchange = '';}
        else{ $onchange = ' onchange="this.form.submit()" ';}

        $select_capelas = '<select  class="form-control" '
            . 'id="idSeguCapela" data-live-search="true"  '.$disabled.$onchange
            . 'name="sel_nivelSegsCapela">'
            . '<option data-tokens="" value="-1">Selecione uma capela </option>';

        $arr_capelas = $objCapelaRN->listar($objCapela);

        foreach ($arr_capelas as $capela){
            $selected = '';

            if($objCapela->getIdCapela() == null) {
                if ($capela->getNivelSeguranca() == $objCapela->getNivelSeguranca() && $capela->getSituacaoCapela() == CapelaRN::$TE_LIBERADA) {
                    if ($capela->getIdCapela() == $objCapela->getIdCapela()) {
                        $selected = ' selected ';
                    }
                    $select_capelas .= '<option ' . $selected .
                        '  value="' . Pagina::formatar_html($capela->getIdCapela())
                        . '" data-tokens="' . Pagina::formatar_html($capela->getNumero()) . '"> Capela '
                        . Pagina::formatar_html($capela->getNumero()) . '</option>';
                }
            }else {
                if ($capela->getIdCapela() ==  $objCapela->getIdCapela()) {
                    $selected = ' selected ';
                }
                $select_capelas .= '<option ' . $selected .
                    '  value="' . Pagina::formatar_html($capela->getIdCapela())
                    . '" data-tokens="' . Pagina::formatar_html($capela->getNumero()) . '"> Capela '
                    . Pagina::formatar_html($capela->getNumero()) . '</option>';
            }


        }

        $select_capelas .= '</select>';

    }
}