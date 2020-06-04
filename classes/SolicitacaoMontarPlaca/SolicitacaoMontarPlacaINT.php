<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class SolicitacaoMontarPlacaINT
{

    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new SolicitacaoMontarPlacaINT();
        }
        return self::$instance;
    }

    static function montar_select_solicitacoes(&$select_solicitacao, $objSolicitacao, $objSolicitacaoRN,$disabled = null, $onchange = null)
    {
        if(is_null($disabled)) { $disabled = '';}
        if(is_null($onchange)) { $onchange = '';}

        if($disabled){
            $disabled = ' disabled ';
        }
        if($onchange){
            $onchange = ' onchange="this.form.submit()" ';
        }

        $select_solicitacao = '<select class="form-control" data-live-search="true"  '
            . 'name="sel_solicitacao" '.$onchange.$disabled.'>'
            . '<option data-tokens="" value="-1">Selecione uma placa</option>';

        if($objSolicitacao->getObjPlaca() != null) {
            /*$objPlaca = new Placa();
            $objPlacaRN = new PlacaRN();
            $objPlaca->setSituacaoPlaca(PlacaRN::$STA_AGUARDANDO_MIX);
            $arr = $objPlacaRN->listar($objPlaca);
            $contador = 0;
            foreach ($arr as $p){
                $objSolicitacao->setIdPlaca($p->getIdPlaca());
                $arrs = $objSolicitacaoRN->listar($objSolicitacao);
                $arr_solicitacoes[$contador++]  = $arrs;
            }*/
            $objSolicitacaoRN = new SolicitacaoMontarPlacaRN();
            $arr_solicitacoes = $objSolicitacaoRN->listar_solicitacoes_validas($objSolicitacao);
            //print_r($arr_solicitacoes);
        }else{
            $arr_solicitacoes = $objSolicitacaoRN->listar($objSolicitacao);
        }

        foreach ($arr_solicitacoes as $solicitacao) {

            if($objSolicitacao != null) {
                if ($solicitacao->getIdSolicitacaoMontarPlaca() == $objSolicitacao->getIdSolicitacaoMontarPlaca()) {
                    $selected = ' selected ';
                }
            }

            //print_r($objLote);
            $select_solicitacao .= '<option ' . $selected .
                '  value="' . Pagina::formatar_html($solicitacao->getIdSolicitacaoMontarPlaca())
                . '" data-tokens="' . Pagina::formatar_html($solicitacao->getIdPlacaFk()) . '"> Placa '
                . Pagina::formatar_html($solicitacao->getIdPlacaFk()) .' </option>';


        }
        $select_solicitacao .= '</select>';
    }

    static function montar_select_situacoes_solicitacao(&$select_situacao_solicitacao, $objSolicitacao,$disabled = null, $onchange = null)
    {
        if(is_null($disabled)) { $disabled = '';}
        if(is_null($onchange)) { $onchange = '';}

        if($disabled){
            $disabled = ' disabled ';
        }
        if($onchange){
            $onchange = ' onchange="this.form.submit()" ';
        }

        $select_situacao_solicitacao = '<select class="form-control " data-live-search="true"  '
            . 'name="sel_situacao_solicitacao" '.$onchange.$disabled.'>'
            . '<option data-tokens="" value="-1">Selecione uma situação de solicitação</option>';


        $arr_situacoes_solicitacao = SolicitacaoMontarPlacaRN::listarValoresTipoSituacaoSolicitacao();

        foreach ($arr_situacoes_solicitacao as $solicitacao) {
            $selected = '';
            if($objSolicitacao != null) {
                if ($solicitacao->getStrTipo() == $objSolicitacao->getSituacaoSolicitacao()) {
                    $selected = ' selected ';
                }
            }

            //print_r($objLote);
            $select_situacao_solicitacao .= '<option ' . $selected .
                '  value="' . Pagina::formatar_html($solicitacao->getStrTipo())
                . '" data-tokens="' . Pagina::formatar_html($solicitacao->getStrDescricao()) . '">'
                . Pagina::formatar_html($solicitacao->getStrDescricao()) .' </option>';


        }
        $select_situacao_solicitacao .= '</select>';
    }
}