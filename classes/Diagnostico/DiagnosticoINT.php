<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */


class DiagnosticoINT
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new DiagnosticoINT();
        }
        return self::$instance;
    }


    static function montar_select_situacao_diagnostico(&$select_situacao,$objDiagnostico,$indice = null,$disabled = null ,$onchange = null){

        if(is_null($disabled)){ $disabled = '';}
        else{ $disabled = ' disabled ';}
        if(is_null($onchange)) { $onchange = '';}
        else{ $onchange = ' onchange="this.form.submit()" ';}

        $select_situacao = '<select  class="form-control " '
            . 'id="idSituacaoEquipamento" data-live-search="true"  '.$disabled.$onchange
            . 'name="sel_situacao_diagnostico'.$indice.'">'
            . '<option data-tokens="">Selecione o diagnóstico </option>';

        foreach (DiagnosticoRN::listarValoresSituacaoDiagnostico() as $situacao){

            $selected = ' ';
            if($objDiagnostico->getDiagnostico() == $situacao->getStrTipo() ){
                $selected = ' selected ';
            }

            $select_situacao .=  '<option ' . $selected .
                '  value="' . Pagina::formatar_html($situacao->getStrTipo())
                . '" data-tokens="' .Pagina::formatar_html($situacao->getStrDescricao()). '">'
                . Pagina::formatar_html($situacao->getStrDescricao()) .'</option>';

        }

        $select_situacao .= '</select>';

    }
}