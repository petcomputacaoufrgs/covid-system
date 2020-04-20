<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class Interf {

    private static $instance;

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Interf();
        }
        return self::$instance;
    }

    function montar_select_cidade(&$select_municipios, $objLugarOrigem, $objLugarOrigemRN, &$objEstadoOrigem, &$objAmostra, $disabled, $onchange) {
        /* MUNICÃPIOS */
        $selected = '';
        $arr_municipios = $objLugarOrigemRN->listar($objLugarOrigem);

        $select_municipios = '<select class="form-control selectpicker "  ' . $disabled . $onchange
                . 'id="select-country idSel_cidades" data-live-search="true" name="sel_cidades">'
                . '<option data-tokens="" ></option>';

        foreach ($arr_municipios as $lugarOrigem) {
            $selected = '';
            if ($lugarOrigem->getCod_estado() == 43) {
                if ($lugarOrigem->getIdLugarOrigem() == $objAmostra->getIdLugarOrigem_fk()) {
                    $selected = 'selected';
                }
                $select_municipios .= '<option ' . $selected .
                        '  value="' . Pagina::formatar_html($lugarOrigem->getIdLugarOrigem()) .
                        '" data-tokens="' . Pagina::formatar_html($lugarOrigem->getNome()) . '">'
                        . Pagina::formatar_html($lugarOrigem->getNome()) . '</option>';
            }
        }
        $select_municipios .= '</select>';
    }

     function montar_select_niveis_prioridade(&$select_nivelPrioridade, $objNivelPrioridade, $objNivelPrioridadeRN, &$objAmostra, $disabled, $onchange) {
        /* TIPOS AMOSTRA */


        $selected = '';
        $arr_niveisPrioridade = $objNivelPrioridadeRN->listar($objNivelPrioridade);

        $select_nivelPrioridade = '<select class="form-control selectpicker" ' . $disabled . $onchange
                . 'id="select-country idSel_niveisPrioridade" data-live-search="true" name="sel_niveisPrioridade">'
                . '<option data-tokens="" ></option>';

        foreach ($arr_niveisPrioridade as $nivel) {
            $selected = '';
            if ($nivel->getIdNivelPrioridade() == $objAmostra->getIdNivelPrioridade_fk()) {
                $selected = 'selected';
            }

            $select_nivelPrioridade .= '<option ' . $selected . '  '
                    . 'value="' . Pagina::formatar_html($nivel->getIdNivelPrioridade()) .
                    '" data-tokens="' . Pagina::formatar_html($nivel->getNivel()) . '">'
                    . Pagina::formatar_html($nivel->getNivel()) . '</option>';
        }
        $select_nivelPrioridade .= '</select>';
    }

    function montar_select_aceitaRecusadaAguarda(&$select_a_r_g, &$objAmostra, $disabled, $onchange) {
        $selectedr = '';
        $selecteda = '';
        $selectedg = '';
        if ($objAmostra != null) {
            if ($objAmostra->get_a_r_g() == 'r') {
                $selectedr = ' selected ';
            }
            if ($objAmostra->get_a_r_g() == 'a') {
                $selecteda = ' selected ';
            }
            if ($objAmostra->get_a_r_g() == 'g') {
                $selectedg = ' selected ';
            }
        }
        $select_a_r_g = ' <select id="idSelAceitaRecusada" ' . $disabled . $onchange .
                'class="form-control" name="sel_a_r_g" onblur="">
                        <option value="">Selecione</option>
                        <option' . Pagina::formatar_html($selecteda) . ' value="a">Aceita</option>
                        <option' . Pagina::formatar_html($selectedr) . ' value="r">Recusada</option>
                        <option' . Pagina::formatar_html($selectedg) . ' value="g">Aguardando chegada</option>
                    </select>';
    }

    function montar_select_tiposAmostra(&$select_tiposAmostra, $objTipoAmostra, $objTipoAmostraRN, &$objAmostra, $disabled, $onchange) {
        /* TIPOS AMOSTRA */
        $selected = '';
        $arr_tiposAmostra = $objTipoAmostraRN->listar($objTipoAmostra);

        $select_tiposAmostra = '<select class="form-control selectpicker" ' . $disabled . $onchange
                . 'id="select-country idSel_tiposAmostra" data-live-search="true" name="sel_tipoAmostra">'
                . '<option data-tokens="" ></option>';

        foreach ($arr_tiposAmostra as $tipoAmostra) {
            $selected = '';
            if ($tipoAmostra->getIdTipoAmostra() == $objAmostra->getIdTipoAmostra_fk()) {
                $selected = 'selected';
            }

            $select_tiposAmostra .= '<option ' . $selected .
                    '  value="' . Pagina::formatar_html($tipoAmostra->getIdTipoAmostra()) .
                    '" data-tokens="' . Pagina::formatar_html($tipoAmostra->getTipo()) . '">'
                    . Pagina::formatar_html($tipoAmostra->getTipo()) . '</option>';
        }
        $select_tiposAmostra .= '</select>';
    }

    function montar_select_estado(&$select_estados, $objEstadoOrigem, $objEstadoOrigemRN, &$objAmostra, $disabled, $onchange) {
        /* ESTADO */
        $selected = '';
        $arr_estados = $objEstadoOrigemRN->listar($objEstadoOrigem);

        $select_estados = '<select class="form-control selectpicker is-valid"  disabled ' . $onchange
                . 'id="select-country idSel_estados"'
                . ' data-live-search="true" name="sel_estados">'
                . '<option data-tokens="" ></option>';

        foreach ($arr_estados as $estado) {
            $selected = '';
            if ($estado->getCod_estado() == $objAmostra->getIdEstado_fk()) {
                $selected = 'selected';
            }
            if ($estado->getSigla() == 'RS' && $objAmostra->getIdEstado_fk() == null) {
                $selected = 'selected';
            }

            $select_estados .= '<option ' . $selected .
                    '  value="' . Pagina::formatar_html($estado->getCod_estado()) . '" '
                    . 'data-tokens="' . Pagina::formatar_html($estado->getSigla()) . '">'
                    . Pagina::formatar_html($estado->getSigla()) . '</option>';
        }
        $select_estados .= '</select>';
    }

    function montar_select_perfilPaciente(&$select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, &$objAmostra, $disabled, $onchange) {
        /* PERFIL DO PACIENTE */
        $selected = '';
        $objPerfilPacienteAux = new PerfilPaciente();
        $arr_perfis = $objPerfilPacienteRN->listar($objPerfilPacienteAux);

        $select_perfis = '<select class="form-control selectpicker"' . $onchange
                . 'id="select-country idSel_perfil"'
                . ' data-live-search="true" name="sel_perfil"' . $disabled . '>'
                . '<option data-tokens="" ></option>';

        foreach ($arr_perfis as $perfil) {
            $selected = '';
            if ($perfil->getIdPerfilPaciente() == $objAmostra->getIdPerfilPaciente_fk()) {
                $selected = 'selected';
            }

            $select_perfis .= '<option ' . $selected .
                    '  value="' . Pagina::formatar_html($perfil->getIdPerfilPaciente())
                    . '" data-tokens="' . Pagina::formatar_html($perfil->getPerfil()) . '">'
                    . Pagina::formatar_html($perfil->getPerfil()) . '</option>';
        }
        $select_perfis .= '</select>';
    }

    function montar_select_sexo(&$select_sexos, $objSexoPaciente, $objSexoPacienteRN, &$objPaciente, $disabled, $onchange) {
        /* SEXO DO PACIENTE */
        $selected = '';
        $arr_sexos = $objSexoPacienteRN->listar($objSexoPaciente);


        $select_sexos = '<select  onchange="" ' . $disabled . $onchange
                . 'class="form-control selectpicker" '
                . 'id="select-country idSexo" data-live-search="true" '
                . 'name="sel_sexo">'
                . '<option data-tokens=""></option>';

        foreach ($arr_sexos as $sexo) {
            $selected = '';
            if ($sexo->getIndex_sexo() == 'NAO INFORMADO' && $objPaciente->getIdSexo_fk() == '') {
                $selected = 'selected';
            }

            if ($sexo->getIdSexo() == $objPaciente->getIdSexo_fk()) {
                $selected = 'selected';
            }
            $select_sexos .= '<option ' . $selected .
                    '  value="' . Pagina::formatar_html($sexo->getIdSexo())
                    . '" data-tokens="' . Pagina::formatar_html($sexo->getSexo()) . '">'
                    . Pagina::formatar_html($sexo->getSexo()) . '</option>';
        }
        $select_sexos .= '</select>';
    }

    function montar_select_etnias(&$select_etnias, $objEtnia, $objEtniaRN, &$objPaciente, $disabled, $onchange) {
        /* ETNIAS */


        $selected = '';
        $arr_etnias = $objEtniaRN->listar($objEtnia);

        $select_etnias = '<select class="form-control selectpicker" ' . $disabled . $onchange
                . 'id="select-country idSel_etnias" data-live-search="true" name="sel_etnias">'
                . '<option data-tokens="" ></option>';

        foreach ($arr_etnias as $etnia) {
            $selected = '';
            if ($etnia->getIndex_etnia() == 'SEM DECLARACAO' && $objPaciente->getIdEtnia_fk() == '') {
                $selected = 'selected';
            }



            if ($etnia->getIdEtnia() == $objPaciente->getIdEtnia_fk()) {
                $selected = 'selected';
            }

            $select_etnias .= '<option ' . $selected . '  '
                    . 'value="' . Pagina::formatar_html($etnia->getIdEtnia()) .
                    '" data-tokens="' . Pagina::formatar_html($etnia->getEtnia()) . '">'
                    . Pagina::formatar_html($etnia->getEtnia()) . '</option>';
        }
        $select_etnias .= '</select>';
    }

    function montar_select_cadastroPaciente(&$select_cadastro, $objSexoPaciente, $objSexoPacienteRN, &$objPaciente) {
        $selected = '';
        $arr_sexos = $objSexoPacienteRN->listar($objSexoPaciente);

        $select_sexos = '<select  onchange="" '
                . 'class="form-control selectpicker" '
                . 'id="select-country idSexo" data-live-search="true" '
                . 'name="sel_sexo">'
                . '<option data-tokens=""></option>';

        foreach ($arr_sexos as $sexo) {
            $selected = '';
            if ($sexo->getIdSexo() == $objPaciente->getIdSexo_fk()) {
                $selected = 'selected';
            }
            $select_sexos .= '<option ' . $selected .
                    '  value="' . Pagina::formatar_html($sexo->getIdSexo())
                    . '" data-tokens="' . Pagina::formatar_html($sexo->getSexo()) . '">'
                    . Pagina::formatar_html($sexo->getSexo()) . '</option>';
        }
        $select_sexos .= '</select>';
    }

    /*
     * SELECTS DAS LISTAS
     */

    static function montar_select_pesquisa($array_colunas,$positionSelected) {
        $options = '';
        $selected = '';
        $position = 0;
        
        foreach ($array_colunas as $c) {
            $selected = '';
            /*if($positionSelected == $position){
                 $selected = ' selected ';
            }*/
            $options .= '<option ' . $selected . ' value="' . $position . '">' . $c . '</option>' . "\n";
            $position++;
        }
        return $options;
    }

    function montar_select_pp(&$select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, &$objAmostra, $disabled, $onchange) {
        /* PERFIL DO PACIENTE */
        $selected = '';
        $objPerfilPacienteAux = new PerfilPaciente();
        $arr_perfis = $objPerfilPacienteRN->listar($objPerfilPacienteAux);
        $select_perfis = ' <select id="idPP" ' . $disabled . $onchange .
                'class="form-control" name="sel_PP" onblur="">
                        <option value="">Selecione</option>';

        foreach ($arr_perfis as $perfil) {
            $selected = '';
            if ($perfil->getIdPerfilPaciente() == $objAmostra->getIdPerfilPaciente_fk()) {
                $selected = 'selected';
            }

            $select_perfis .= '<option ' . $selected . ' value="' . Pagina::formatar_html($perfil->getIdPerfilPaciente())
                    . '">' . Pagina::formatar_html($perfil->getPerfil()) . '</option>';
        }
    }
    
    
    
}
