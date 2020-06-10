<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class EquipamentoINT
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new EquipamentoINT();
        }
        return self::$instance;
    }


    static function montar_select_situacao_equipamento(&$select_situacao,$objEquipamento,$disabled = null ,$onchange = null){

        if(is_null($disabled)){ $disabled = '';}
        else{ $disabled = ' disabled ';}
        if(is_null($onchange)) { $onchange = '';}
        else{ $onchange = ' onchange="this.form.submit()" ';}

        $select_situacao = '<select  class="form-control " '
            . 'id="idSituacaoEquipamento" data-live-search="true"  '.$disabled.$onchange
            . 'name="sel_situacao_equipamento">'
            . '<option data-tokens="">Selecione a situação do equipamento </option>';

        foreach (EquipamentoRN::listarValoresSituacaoEquipamento() as $situacaoEquipamento){

            $selected = ' ';
            if($objEquipamento->getSituacaoEquipamento() ==$situacaoEquipamento->getStrTipo() ){
                $selected = ' selected ';
            }

            $select_situacao .=  '<option ' . $selected .
                '  value="' . Pagina::formatar_html($situacaoEquipamento->getStrTipo())
                . '" data-tokens="' .Pagina::formatar_html($situacaoEquipamento->getStrDescricao()). '">'
                . Pagina::formatar_html($situacaoEquipamento->getStrDescricao()) .'</option>';

        }

        $select_situacao .= '</select>';

    }

    static function montar_select_equipamentos(&$select_equipamentos,$objEquipamento,$objEquipamentoRN,$disabled = null ,$onchange = null){

        if(is_null($disabled)){ $disabled = '';}
        else{ $disabled = ' disabled ';}
        if(is_null($onchange)) { $onchange = '';}
        else{ $onchange = ' onchange="this.form.submit()" ';}

        $select_equipamentos = '<select  class="form-control " '
            . 'id="idSituacaoEquipamento" data-live-search="true"  '.$disabled.$onchange
            . 'name="sel_equipamento">'
            . '<option data-tokens="">Selecione o equipamento </option>';

        $arrEquipamentos = $objEquipamentoRN->listar($objEquipamento);

        foreach ($arrEquipamentos as $equipamento){

            $selected = ' ';
            if($objEquipamento->getIdEquipamento() ==$equipamento->getIdEquipamento() ){
                $selected = ' selected ';
            }

            $select_equipamentos .=  '<option ' . $selected .
                '  value="' . Pagina::formatar_html($equipamento->getIdEquipamento())
                . '" data-tokens="' .Pagina::formatar_html($equipamento->getIdEquipamento()). '"> Equipamento de número '
                . Pagina::formatar_html($equipamento->getIdEquipamento()) .' com duração RTqPCR de '.Pagina::formatar_html($equipamento->getHoras()) .'hr e '
                . Pagina::formatar_html($equipamento->getMinutos()). 'min </option>';

        }

        $select_equipamentos .= '</select>';

    }

}