<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class PacienteINT
{
    static function montar_select_cadastro_pendente(&$select_cadastro_pendente,$objPaciente,$disabled =null,$onchange = null)
    {
        $select_cadastro_pendente = ' <select ' . $disabled .$onchange.
            'class="form-control" name="sel_cadastro_pendente" >
            <option value="-1">Selecione sobre o cadastro</option>';

        $selecteds = ''; $selectedn = '';
        if($objPaciente->getCadastroPendente() == 's'){
            $selecteds = ' selected ';
        }
        if($objPaciente->getCadastroPendente() == 'n'){
            $selectedn = ' selected ';
        }
        $select_cadastro_pendente .= '<option ' . $selecteds . ' value="s">Sim </option>';
        $select_cadastro_pendente .= '<option ' . $selectedn . ' value="n">Não </option>';
        $select_cadastro_pendente .='</select>';
    }
}