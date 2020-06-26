<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class PerfilPacienteINT
{

    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new PerfilPacienteINT();
        }
        return self::$instance;
    }

    //select 1 perfil
    static function montar_select_perfilPaciente(&$select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $disabled=null, $onchange=null)
    {

        $onchange = '';
        $disabled = '';
        if($disabled){
            $disabled = ' disabled ';
        }
        if($onchange){
            $onchange = ' onchange="this.form.submit()" ';
        }


        $arr_perfis = $objPerfilPacienteRN->listar(new PerfilPaciente());

        $select_perfis = '<select class="form-control "' . $onchange
            . 'id="select-country idSel_perfil"'
            . ' data-live-search="true" name="sel_perfil"' . $disabled . '>'
            . '<option data-tokens="" value="-1">Selecione um perfil</option>';

        foreach ($arr_perfis as $perfil) {
            $selected = '';
            if ($perfil->getIdPerfilPaciente() == $objPerfilPaciente->getIdPerfilPaciente()) {
                $selected = 'selected';
            }

            $select_perfis .= '<option ' . $selected .
                '  value="' . Pagina::formatar_html($perfil->getIdPerfilPaciente())
                . '" data-tokens="' . Pagina::formatar_html($perfil->getPerfil()) . '">'
                . Pagina::formatar_html($perfil->getPerfil()) . '</option>';
        }
        $select_perfis .= '</select>';
    }

    static function montar_select_perfilPaciente_caractere(&$select_perfis, $objPerfilPaciente, $objPerfilPacienteRN, $disabled=null, $onchange=null)
    {

        $onchange = '';
        $disabled = '';
        if($disabled){
            $disabled = ' disabled ';
        }
        if($onchange){
            $onchange = ' onchange="this.form.submit()" ';
        }


        $arr_perfis = $objPerfilPacienteRN->listar(new PerfilPaciente());

        $select_perfis = '<select class="form-control "' . $onchange
            . 'id="select-country idSel_perfil"'
            . ' data-live-search="true" name="sel_perfil_caractere"' . $disabled . '>'
            . '<option data-tokens="" value="-1">Selecione um perfil</option>';

        foreach ($arr_perfis as $perfil) {
            $selected = '';
            if ($perfil->getCaractere() == $objPerfilPaciente->getCaractere()) {
                $selected = 'selected';
            }

            $select_perfis .= '<option ' . $selected .
                '  value="' . Pagina::formatar_html($perfil->getCaractere())
                . '" data-tokens="' . Pagina::formatar_html($perfil->getPerfil()) . '">'
                . Pagina::formatar_html($perfil->getPerfil()) . '</option>';
        }
        $select_perfis .= '</select>';
    }

    //select múltiplos perfis
    static function montar_select_perfisMultiplos(&$select_perfis, &$perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, $disabled=null, $onchange=null,$especialsus = null)
    {

        if($especialsus == 's'){
            $arr_perfis = $objPerfilPacienteRN->listar_nao_sus(new PerfilPaciente());
        }else{
            $arr_perfis = $objPerfilPacienteRN->listar(new PerfilPaciente());
        }

        $onchange = '';
        $disabled = '';
        if($disabled){
            $disabled = ' disabled ';
        }
        if($onchange){
            $onchange = ' onchange="this.form.submit()" ';
        }

        $select_perfis = '<select ' . $disabled . ' class="form-control selectpicker" onchange="' . $onchange . '" 
            multiple data-live-search="true"        name="sel_perfis[]"  id="selectpicker"  >'
            . '<option value="-1"  ></option>';

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

}