<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */


require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPaciente.php';
require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPacienteRN.php';

require_once __DIR__ . '/../../classes/PreparoLote/PreparoLote.php';
require_once __DIR__ . '/../../classes/PreparoLote/PreparoLoteRN.php';

class InterfacePagina
{

    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new InterfacePagina();
        }
        return self::$instance;
    }


    static function montar_select_protocolos(&$select_protocolos, $objProtocolo, $objProtocoloRN, $disabled, $onchange)
    {
        /* PROTOCOLOS */

        $arr_protocolos = $objProtocoloRN->listar(new Protocolo());

        $select_protocolos = '<select class="form-control selectpicker "  ' . $disabled . $onchange
            . 'id="select-country idSel_protocolos" data-live-search="true" name="sel_protocolos">'
            . '<option data-tokens="" value="-1" >Selecione um protocolo</option>';

        foreach ($arr_protocolos as $protocolo) {
            $selected = '';

            if ($objProtocolo->getIdProtocolo() == $protocolo->getIdProtocolo()) {
                $selected = 'selected';
            }
            $select_protocolos .= '<option ' . $selected .
                '  value="' . Pagina::formatar_html($protocolo->getIdProtocolo()) .
                '" data-tokens="' . Pagina::formatar_html($protocolo->getProtocolo()) . '">'
                . Pagina::formatar_html($protocolo->getProtocolo()) . '</option>';

        }
        $select_protocolos .= '</select>';
    }

    static function montar_select_placas(&$select_placas, $objPlaca, $objPlacaRN, $disabled, $onchange)
    {
        /* PLACAS */

        $arr_placas = $objPlacaRN->listar(new Placa());

        $select_placas = '<select class="form-control selectpicker "  ' . $disabled . $onchange
            . 'id="select-country idSel_placas" data-live-search="true" name="sel_placas">'
            . '<option data-tokens="" value="-1" >Selecione uma placa</option>';

        foreach ($arr_placas as $placa) {
            $selected = '';

            if ($objPlaca->getIdPlaca() == $placa->getIdPlaca()) {
                $selected = 'selected';
            }
            $select_placas .= '<option ' . $selected .
                '  value="' . Pagina::formatar_html($placa->getIdPlaca()) .
                '" data-tokens="' . Pagina::formatar_html($placa->getPlaca()) . '">'
                . Pagina::formatar_html($placa->getPlaca()) . '</option>';

        }
        $select_placas .= '</select>';
    }

    static function montar_select_cidade_paciente(&$select_municipio_paciente, $objLugarOrigemPaciente, $objLugarOrigemPacienteRN, &$objEstadoOrigemPaciente, &$objPaciente, $disabled, $onchange)
    {
        /* MUNICÍPIO PACIENTE */
        $selected = '';

        $arr_municipios = $objLugarOrigemPacienteRN->listar($objLugarOrigemPaciente);
       // print_r($arr_municipios);

        $select_municipio_paciente = '<select class="form-control selectpicker "  ' . $disabled . $onchange
            . 'id="select-country idSel_cidades" data-live-search="true" name="sel_municipio_paciente">'
            . '<option data-tokens="" value="-1">Selecione o município</option>';

        foreach ($arr_municipios as $lugarOrigem) {
            $selected = '';

                if ($lugarOrigem->getIdLugarOrigem() == $objPaciente->getIdMunicipioFk()) {
                    $selected = 'selected';
                }
                $select_municipio_paciente .= '<option ' . $selected .
                    '  value="' . Pagina::formatar_html($lugarOrigem->getIdLugarOrigem()) .
                    '" data-tokens="' . Pagina::formatar_html($lugarOrigem->getNome()) . '">'
                    . Pagina::formatar_html($lugarOrigem->getNome()).', '.$lugarOrigem->getObjEstado()->getSigla() . '</option>';

        }
        $select_municipio_paciente .= '</select>';
    }


    static function montar_select_cidade(&$select_municipios, $objLugarOrigem, $objLugarOrigemRN, &$objEstadoOrigem, &$objAmostra, $disabled, $onchange)
    {
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

    static function montar_select_tipoLocalArmazenamento(&$select_tipoLocal,$objTipoLocalArmazenamentoRN,$objTipoLocalArmazenamento,$objLocalArmazenamento, $disabled, $onchange)
    {
        /* tipo local de armazenamento */

        $arr_locais = $objTipoLocalArmazenamentoRN->listar($objTipoLocalArmazenamento);

        $select_tipoLocal = '<select class="form-control selectpicker "  ' . $disabled . $onchange
            . 'id="select-country idSel_tipoLocal" data-live-search="true" name="sel_tipoLocalArmazenamento">'
            . '<option data-tokens="" ></option>';

        foreach ($arr_locais as $local) {
            $selected = '';
            if ($objLocalArmazenamento->getIdTipoLocalArmazenamento_fk() == $local->getIdTipoLocalArmazenamento()) {
                    $selected = 'selected';
            }
                $select_tipoLocal .= '<option ' . $selected .
                    '  value="' . Pagina::formatar_html($local->getIdTipoLocalArmazenamento()) .
                    '" data-tokens="' . Pagina::formatar_html($local->getTipo()) . '">'
                    . Pagina::formatar_html($local->getTipo()) . '</option>';
            }

        $select_tipoLocal .= '</select>';
    }

static function montar_select_niveis_prioridade(&$select_nivelPrioridade, $objNivelPrioridade, $objNivelPrioridadeRN, &$objAmostra, $disabled, $onchange)
    {
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


    static function montar_select_aceitaRecusadaAguarda(&$select_a_r_g, &$objAmostra, $disabled, $onchange){
        $selectedr = '';
        $selecteda = '';
        $selectedg = '';
        if ($objAmostra != null) {
            if ($objAmostra->get_a_r_g() == AmostraRN::$STA_RECUSADA) {
                $selectedr = ' selected ';
            }
            if ($objAmostra->get_a_r_g() == AmostraRN::$STA_ACEITA) {
                $selecteda = ' selected ';
            }
            if ($objAmostra->get_a_r_g() == AmostraRN::$STA_AGUARDANDO) {
                $selectedg = ' selected ';
            }
        }
        $select_a_r_g = ' <select id="idSelAceitaRecusada" ' . $disabled . $onchange .
            'class="form-control" name="sel_a_r_g" onblur="">
                        <option value="">Selecione</option>
                        <option   ' . Pagina::formatar_html($selecteda) . ' value="'.AmostraRN::$STA_ACEITA.'">Aceita</option>
                        <option' . Pagina::formatar_html($selectedr) . ' value="'.AmostraRN::$STA_RECUSADA.'">Recusada</option>
                        <option' . Pagina::formatar_html($selectedg) . ' value="'.AmostraRN::$STA_AGUARDANDO.'">Aguardando chegada</option>
                    </select>';
    }


    static  function montar_select_estado(&$select_estados, $objEstadoOrigem, $objEstadoOrigemRN, &$objAmostra, $disabled, $onchange)
    {
        /* ESTADO */
        $selected = '';
        $arr_estados = $objEstadoOrigemRN->listar($objEstadoOrigem);

        $select_estados = '<select class="form-control selectpicker "  disabled ' . $onchange
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


    static  function montar_select_estado_paciente(&$select_estado_paciente, $objEstadoOrigemPaciente, $objEstadoOrigemPacienteRN, &$objPaciente, $disabled, $onchange)
    {
        /* ESTADO DO PACIENTE */

        $arr_estados = $objEstadoOrigemPacienteRN->listar($objEstadoOrigemPaciente);

        $select_estado_paciente = '<select class="form-control selectpicker "  ' . $onchange
            . ' id="select-country idSel_estados"'
            . ' data-live-search="true" name="sel_estado_paciente">'
            . '<option data-tokens="" value="-1" >Selecione um estado</option>';

        foreach ($arr_estados as $estado) {
            $selected = '';

            if ($estado->getCod_estado() == $objPaciente->getIdEstadoFk()) {
                $selected = 'selected';
            }

            $select_estado_paciente .= '<option ' . $selected .
                '  value="' . Pagina::formatar_html($estado->getCod_estado()) . '" '
                . 'data-tokens="' . Pagina::formatar_html($estado->getSigla()) . '">'
                . Pagina::formatar_html($estado->getSigla()) . '</option>';
        }
        $select_estado_paciente .= '</select>';
    }

static function montar_select_perfilPaciente(&$select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, &$objAmostra, $disabled, $onchange)
    {
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

static function montar_select_sexo(&$select_sexos, $objSexoPaciente, $objSexoPacienteRN, &$objPaciente, $disabled, $onchange)
    {
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

    static  function montar_select_etnias(&$select_etnias, $objEtnia, $objEtniaRN, &$objPaciente, $disabled, $onchange)
    {
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


    /*
     * SELECTS DAS LISTAS
     */

    static function montar_select_pesquisa($array_colunas, $positionSelected)
    {
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

    static function montar_select_pp(&$select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, &$objAmostra, $disabled, $onchange)
        {
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

    static function montar_select_cadastroPendente(&$select_cadastroPendente, $objPacienteRN, &$objPaciente, $disabled, $onchange)
    {
        /* CADASTRO PENDENTE DO PACIENTE */

        $select_cadastroPendente = ' <select id="idCadastroPendente" ' . $disabled . $onchange .
            'class="form-control" name="sel_CadastroPendente" onblur="">
                        <option value="">Selecione</option>';

        $selectedn = '';
        $selecteds = '';
        if ($objPaciente->getCadastroPendente() == 's') {
            $selecteds = ' selected ';
        }
        if ($objPaciente->getCadastroPendente() == 'n') {
            $selectedn = ' selected ';
        }

        $select_cadastroPendente .= '<option ' . $selecteds . ' value="s">Sim</option>';
        $select_cadastroPendente .= '<option ' . $selectedn . ' value="n">Não</option>';

        $select_cadastroPendente .= '</select>';
    }

    /*
     * SELECTS MÚLTIPLOS
     */

    static function montar_select_perfisMultiplos(&$select_perfis, &$perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, $disabled, $onchange,$especialsus = null)
    {
        /* SELECIONAR VÁRIOS PERFIS DE USUÁRIO */
        $objPerfilPacienteRN = new PerfilPacienteRN();
        $selected = '';

        if($especialsus == 's'){
            $arr_perfis = $objPerfilPacienteRN->listar_nao_sus($objPerfilPaciente);
        }else{
            $arr_perfis = $objPerfilPacienteRN->listar($objPerfilPaciente);
        }


        $select_perfis = '<select ' . $disabled . ' class="form-control selectpicker" onchange="' . $onchange . '" 
            multiple data-live-search="true"        name="sel_perfis[]"  id="selectpicker"  >'
            . '<option value="0" ></option>';

        foreach ($arr_perfis as $perfil) {
            $selected = ' ';
            if ($perfisSelecionados != '') {
                $rec = explode(";", $perfisSelecionados);
                foreach ($rec as $r) {
                    if ($perfil->getIdPerfilPaciente() == $r) {
                        $selected = ' selected ';
                    }
                }
                $select_perfis .= '<option ' . $selected . '  value="' . $perfil->getIdPerfilPaciente() . '">' . $perfil->getPerfil() . '</option>';
            } else {
                $select_perfis .= '<option  value="' . $perfil->getIdPerfilPaciente() . '">' . $perfil->getPerfil() . '</option>';
            }
        }
        $select_perfis .= '</select>';
    }

    static function montar_grupos_amostras($objPreparoLote, $objPreparoLoteRN, &$select_grupos, $readonly, $tipo)
    {
        $select_grupos = '<select  class="form-control selectpicker" '
            . 'id="select-country idGrupos" data-live-search="true"  '.$readonly
            . 'name="sel_grupos">'
            . '<option data-tokens="" value="-1">Selecione um grupo </option>';

        //listar apenas lotes que ainda n foram para preparacao
        if($objPreparoLote->getIdPreparoLote() == null) {
            if($tipo == LoteRN::$TL_PREPARO) {
                $arr_preparos = $objPreparoLoteRN->listar_preparos($objPreparoLote,LoteRN::$TE_TRANSPORTE_PREPARACAO, LoteRN::$TL_PREPARO);

            }else if($tipo == LoteRN::$TL_EXTRACAO){
                $arr_preparos = $objPreparoLoteRN->listar_preparos($objPreparoLote,LoteRN::$TE_AGUARDANDO_EXTRACAO, LoteRN::$TL_EXTRACAO);
            }

            //print_r($arr_preparos);
            foreach ($arr_preparos as $preparo) {
                $selected = '';
                if ($preparo->getIdPreparoLote() == $objPreparoLote->getIdPreparoLote()) {
                    $selected = ' selected ';
                }

                $select_grupos .= '<option ' . $selected .
                    '  value="' . Pagina::formatar_html($preparo->getIdPreparoLote())
                    . '" data-tokens="' . Pagina::formatar_html($preparo->getIdPreparoLote()) . '">Preparo lote: '
                    . 'Lote: ' . Pagina::formatar_html($preparo->getObjLote()->getIdLote()) . ' com ' . Pagina::formatar_html($preparo->getObjLote()->getQntAmostrasAdquiridas()) . ' amostras</option>';

            }
        }else{
            $select_grupos .=' <option selected '.
                    '  value="' . Pagina::formatar_html($objPreparoLote->getIdPreparoLote())
                    . '" data-tokens="' . Pagina::formatar_html($objPreparoLote->getIdPreparoLote()) . '">Preparo Lote: ' . Pagina::formatar_html($objPreparoLote->getIdPreparoLote()) .'</option>';

        }


        $select_grupos .= '</select>';

    }

    static function montar_select_lotes($objLote, $objLoteRN, &$select_lotes, $readonly, $tipo)
    {
        $select_lotes = '<select  class="form-control selectpicker" '
            . 'id="select-country idGrupos" data-live-search="true"  ' . $readonly
            . 'name="sel_grupos">'
            . '<option data-tokens="" value="-1">Selecione um grupo </option>';

        /*if ($objLote == null) {
            $objLote->setSituacaoLote(LoteRN::$TE_AGUARDANDO_PREPARACAO);
            $objLote->setTipo(LoteRN::$TL_PREPARO);
        }*/

        $arr_lotes = $objLoteRN->listar($objLote);



        //print_r($arr_lotes);
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

    static function montar_select_situacao_capela(&$select_situacao,$objCapela,$disabled){
        $select_situacao = '<select  class="form-control selectpicker" '
            . 'id="idSituacaoCapela" data-live-search="true"  '.$disabled
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

    static function montar_select_nivelSeguranca_capela(&$select_nivelSeguranca,$objCapela,$disabled){
        $select_nivelSeguranca = '<select  class="form-control selectpicker" '
            . 'id="idSeguCapela" data-live-search="true"  '.$disabled
            . 'name="sel_nivelSegurancaCapela">'
            . '<option data-tokens="" value="-1">Selecione o nível de segurança </option>';

        foreach (CapelaRN::listarValoresTipoNivelSeguranca() as $segurancaCapela){

            $selected = ' ';
            if($objCapela->getNivelSeguranca() ==$segurancaCapela->getStrTipo() ){
                $selected = ' selected ';
            }

            $select_nivelSeguranca .=  '<option ' . $selected .
                '  value="' . Pagina::formatar_html($segurancaCapela->getStrTipo())
                . '" data-tokens="' .Pagina::formatar_html($segurancaCapela->getStrDescricao()). '">'
                . Pagina::formatar_html($segurancaCapela->getStrDescricao()) .'</option>';

        }

        $select_nivelSeguranca .= '</select>';

    }

    static function montar_select_caractereProtocolo(&$select_protocolo,$objProtocoloRN,$objProtocolo,$disabled){
        $select_protocolo = '<select  class="form-control selectpicker" '
            . 'id="idSeguCapela" data-live-search="true"  '.$disabled
            . 'name="sel_caractereProtococolo">'
            . '<option data-tokens="" value="-1">Selecione o caractere do protocolo </option>';

        $arr_protocolos = $objProtocoloRN->listar($objProtocolo);

        foreach ($arr_protocolos as $protocolo){

            $selected = ' ';
            if($objProtocolo->getCaractere() ==$protocolo->getCaractere() ){
                $selected = ' selected ';
            }

            $select_protocolo .=  '<option ' . $selected .
                '  value="' . Pagina::formatar_html($protocolo->getCaractere())
                . '" data-tokens="' .Pagina::formatar_html($protocolo->getIndexProtocolo()). '">'
                . $protocolo->getCaractere() .' - '.Pagina::formatar_html($protocolo->getIndexProtocolo()) .'</option>';

        }

        $select_protocolo .= '</select>';

    }

    static function montar_lista_caracteres(&$lista_caractere,$objProtocoloRN,$objProtocolo,$disabled){
        $lista_caractere = '<ul class="list-group" >';

        $arr_protocolos = $objProtocoloRN->listar($objProtocolo);

        foreach ($arr_protocolos as $protocolo){
            $lista_caractere .=  '<li class="list-group-item"><strong>'.$protocolo->getCaractere() .'</strong> - '.Pagina::formatar_html($protocolo->getIndexProtocolo()).'</li>';
        }

        $lista_caractere .= '</ul>';

    }


    static function montar_select_tipoLocalArmazenamentoTXT(&$select_tipoLocal,$objTipoLocalArmazenamentoRN,$objTipoLocalArmazenamento, $disabled, $onchange)
    {
        /* tipo local de armazenamento */


        $arr_locais = $objTipoLocalArmazenamentoRN->listar($objTipoLocalArmazenamento);

        $select_tipoLocal = '<select class="form-control selectpicker "  ' . $disabled . $onchange
            . 'id="select-country idSel_tipoLocal" data-live-search="true" name="sel_tipoLocalArmazenamentoTXT">'
            . '<option data-tokens="" ></option>';

        foreach ($arr_locais as $local) {
            $selected = '';
            if ($objTipoLocalArmazenamento->getIdTipoLocalArmazenamento() == $local->getIdTipoLocalArmazenamento()) {
                $selected = 'selected';
            }
            $select_tipoLocal .= '<option ' . $selected .
                '  value="' . Pagina::formatar_html($local->getIdTipoLocalArmazenamento()) .
                '" data-tokens="' . Pagina::formatar_html($local->getTipo()) . '">'
                . Pagina::formatar_html($local->getTipo()) . '</option>';
        }

        $select_tipoLocal .= '</select>';
    }


    static function montar_capelas_liberadas(&$objCapela, $objCapelaRN, &$select_capelas, $nivel, $disabled){
        $select_capelas = '<select  class="form-control selectpicker" '
            . 'id="idSeguCapela" data-live-search="true"  '.$disabled
            . 'name="sel_nivelSegsCapela">'
            . '<option data-tokens="" value="-1">Selecione uma capela </option>';

        $arr_capelas = $objCapelaRN->listar($objCapela);

        foreach ($arr_capelas as $capela){
            $selected = '';

            if($objCapela->getIdCapela() == null) {
                if ($capela->getNivelSeguranca() == $nivel && $capela->getSituacaoCapela() == CapelaRN::$TE_LIBERADA) {
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


    static function montar_select_kitsExtracao($objKitExtracao, $objKitExtracaoRN, &$select_kitExtracao,$disabled){
        $select_kitExtracao = '<select  class="form-control selectpicker" '
            . 'id="idSeguCapela" data-live-search="true"  '.$disabled
            . 'name="sel_kitsExtracao">'
            . '<option data-tokens="" value="-1">Selecione o kit de extração </option>';

        $arr_kits_extracao = $objKitExtracaoRN->listar($objKitExtracao);

        foreach ($arr_kits_extracao as $ke){

            $selected = ' ';
            if($objKitExtracao->getIdKitExtracao() == $ke->getIdKitExtracao() ){
                $selected = ' selected ';
            }

            $select_kitExtracao .=  '<option ' . $selected .
                '  value="' . Pagina::formatar_html($ke->getIdKitExtracao())
                . '" data-tokens="' .Pagina::formatar_html($ke->getNome()). '">'
                . Pagina::formatar_html($ke->getNome()) .'</option>';

        }

        $select_kitExtracao .= '</select>';

    }



    static function montar_select_perfil(&$select_perfilUsu, $objPerfilUsuarioRN, &$objPerfilUsuario, &$perfis_selecionados) {

        /* PERFIS DO USUÁRIO */
        $selected = '';
        $arr_perfis = $objPerfilUsuarioRN->listar($objPerfilUsuario);

        $select_perfilUsu = '<select  class="form-control selectpicker" multiple data-live-search="true"   name="sel_perfil[]">'
            . '<option value="0" ></option>';

        foreach ($arr_perfis as $todos_perfis) {
            $selected = ' ';
            if ($perfis_selecionados != '') {
                $perfis = explode(";", $perfis_selecionados);
                foreach ($perfis as $p) {
                    if ($todos_perfis->getIdPerfilUsuario() == $p) {
                        $selected = ' selected ';
                    }
                }
                $select_perfilUsu .= '<option ' . $selected . '  '
                    . 'value="' .  Pagina::formatar_html($todos_perfis->getIdPerfilUsuario()) . '">'
                    .  Pagina::formatar_html($todos_perfis->getPerfil()) . '</option>';
            } else {
                $select_perfilUsu .= '<option  '
                    . 'value="' .  Pagina::formatar_html($todos_perfis->getIdPerfilUsuario()) . '">'
                    .  Pagina::formatar_html($todos_perfis->getPerfil())  . '</option>';
            }
        }
        $select_perfilUsu .= '</select>';
    }

    static function montar_select_usuario(&$select_usuario, $objUsuarioRN, &$objUsuario) {

        /* USUÁRIO */
        $disabled ='';
        $selected = '';
        if(isset($_GET['idUsuario'])){
            $disabled = ' disabled ';
        }
        $arr_usuarios = $objUsuarioRN->listar($usuario = new Usuario());

        $select_usuario = '<select ' . $disabled . ' class="form-control selectpicker"   onchange="this.form.submit()"  '
            . 'id="idSel_usuarios" data-live-search="true" name="sel_usuario">'
            . '<option data-tokens="" ></option>';

        foreach ($arr_usuarios as $u) {
            $selected = '';
            if ($u->getIdUsuario() == $objUsuario->getIdUsuario()) {
                $selected = 'selected';
            }

            $select_usuario .= '<option ' . $selected . '  value="' . Pagina::formatar_html($u->getIdUsuario()) .
                '" data-tokens="' .  Pagina::formatar_html($u->getMatricula()) . '">' . Pagina::formatar_html($u->getMatricula()) . '</option>';
        }
        $select_usuario .= '</select>';
    }

}
