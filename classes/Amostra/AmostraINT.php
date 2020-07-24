<?php


class AmostraINT
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new AmostraINT();
        }
        return self::$instance;
    }


    static function montar_select_aceitaRecusadaAguarda(&$select_a_r_g, $objAmostra, $disabled=null, $onchange=null)
    {
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
                        <option   ' . Pagina::formatar_html($selecteda) . ' value="a">Aceita</option>
                        <option' . Pagina::formatar_html($selectedr) . ' value="r">Recusada</option>
                        <option' . Pagina::formatar_html($selectedg) . ' value="g">Aguardando chegada</option>
                    </select>';
    }
}