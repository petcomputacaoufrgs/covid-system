<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class LaudoINT
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new LaudoINT();
        }
        return self::$instance;
    }


    static function montar_select_situacao(&$select_situacao,$objLaudo,$disabled = null ,$onchange = null){

        if(is_null($disabled)){ $disabled = '';}
        else{ $disabled = ' disabled ';}
        if(is_null($onchange)) { $onchange = '';}
        else{ $onchange = ' onchange="this.form.submit()" ';}

        $select_situacao = '<select  class="form-control " '
            . 'id="idSituacaoLaudo" data-live-search="true"  '.$disabled.$onchange
            . 'name="sel_situacao_laudo">'
            . '<option data-tokens="">Selecione a situação do laudo </option>';

        foreach (LaudoRN::listarValoresStaLaudo() as $situacao){

            $selected = ' ';
            if($objLaudo->getSituacao() == $situacao->getStrTipo() ){
                $selected = ' selected ';
            }

            $select_situacao .=  '<option ' . $selected .
                '  value="' . Pagina::formatar_html($situacao->getStrTipo())
                . '" data-tokens="' .Pagina::formatar_html($situacao->getStrDescricao()). '">'
                . Pagina::formatar_html($situacao->getStrDescricao()) .'</option>';

        }

        $select_situacao .= '</select>';

    }

    static function montar_select_resultado(&$select_resultado,$objLaudo,$disabled = null ,$onchange = null){

        if(is_null($disabled)){ $disabled = '';}
        else{ $disabled = ' disabled ';}
        if(is_null($onchange)) { $onchange = '';}
        else{ $onchange = ' onchange="this.form.submit()" ';}

        $select_resultado = '<select  class="form-control " '
            . 'id="idResultadoLaudo" data-live-search="true"  '.$disabled.$onchange
            . 'name="sel_resultado_laudo">'
            . '<option data-tokens="">Selecione o resultado do laudo </option>';

        foreach (LaudoRN::listarValoresResultado() as $situacao){

            $selected = ' ';
            if($objLaudo->getResultado() == $situacao->getStrTipo() ){
                $selected = ' selected ';
            }

            $select_resultado .=  '<option ' . $selected .
                '  value="' . Pagina::formatar_html($situacao->getStrTipo())
                . '" data-tokens="' .Pagina::formatar_html($situacao->getStrDescricao()). '">'
                . Pagina::formatar_html($situacao->getStrDescricao()) .'</option>';

        }

        $select_resultado .= '</select>';

    }

    static function montar_select_resultado_PNI(&$select_resultado,$objLaudo,$disabled = null ,$onchange = null){

        if(is_null($disabled)){ $disabled = '';}
        else{ $disabled = ' disabled ';}
        if(is_null($onchange)) { $onchange = '';}
        else{ $onchange = ' onchange="this.form.submit()" ';}

        $select_resultado = '<select  class="form-control " '
            . 'id="idResultadoLaudo" data-live-search="true"  '.$disabled.$onchange
            . 'name="sel_resultado_laudo_PNI">'
            . '<option data-tokens="">Selecione o resultado do laudo </option>';


        $selectedPositivo = ' ';$selectedNegativo= '';$selectedInconclusivo ='';
        if($objLaudo->getResultado() == LaudoRN::$RL_POSITIVO ){
            $selectedPositivo = ' selected ';
        }
        if($objLaudo->getResultado() == LaudoRN::$RL_NEGATIVO ){
            $selectedNegativo = ' selected ';
        }
        if($objLaudo->getResultado() == LaudoRN::$RL_INCONCLUSIVO ){
            $selectedInconclusivo = ' selected ';
        }
        $select_resultado .=  '<option ' . $selectedPositivo .
            '  value="P" data-tokens="DETECTADO">DETECTADO</option>';
        $select_resultado .=  '<option ' . $selectedNegativo .
            '  value="N" data-tokens="NAO_DETECTADO">NÃO-DETECTADO</option>';
        $select_resultado .=  '<option ' . $selectedInconclusivo .
            '  value="I" data-tokens="INCONCLUSIVO">INCONCLUSIVO</option>';

        $select_resultado .= '</select>';

    }

}