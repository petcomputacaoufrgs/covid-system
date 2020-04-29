<?php


require_once __DIR__ . '/../classes/Pagina/Pagina.php';
require_once __DIR__ . '/../classes/Excecao/Excecao.php';


try {


} catch (Throwable $ex) {
    die($ex);
}


Pagina::abrir_head("Caixinha");
Pagina::getInstance()->adicionar_css("precadastros");
if($liberar_popUp == 's') {
    Pagina::getInstance()->adicionar_javascript("popUp");
}
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
echo $alert;


$table = "<h3> Caixa 03 - Freezer 2 </h3>";
$table .= '<div class="conteudo_tabela" style="margin-top: -20px;">
            <table class="table table-hover">
             <table>
             <tr>   ';
for($i=0; $i<=10;$i++){
    if($i ==0){
        $table .= '<td><input type="text" class="form-control" id="idDataHoraLogin" disabled style="text-align: center;"
                       name="input_'.$i.'" value=""></td>';
    }else {
        $table .= '<td><input type="text" class="form-control" id="idDataHoraLogin" disabled style="text-align: center;"
                       name="input_' . $i . '" value="LINHA '.$i.'"></td>';
    }
}
$table.='<tr>';
for($i=1; $i<=10;$i++){
    $table .= '<td><input type="text" class="form-control" id="idDataHoraLogin" disabled style="text-align: center;"
                       name="input_'.$i.'_'.$j.'" value="COL '.$i.'"></td>';
    for($j=1; $j<=10;$j++){
        $posicao[2][3] = 'V49';
        $posicao[7][9] = 'L54';
        $posicao[1][2] = 'E32';
        if($i == 2 && $j == 3){
            $table .= '<td>
                <input type="text" class="form-control" id="idDataHoraLogin" style="background-color: rgba(255,0,0,0.2);text-align: center;"disabled placeholder="[' . $i . '][' . $j . ']" style="text-align: center;"
                       name="input_' . $i . '_' . $j . '" value="V49">
                 </td>';
        } else if($i == 7 && $j == 9){
            $table .= '<td>
                <input type="text" class="form-control" id="idDataHoraLogin" style="background-color: rgba(255,0,0,0.2);text-align: center;"  disabled placeholder="[' . $i . '][' . $j . ']" style="text-align: center;"
                       name="input_' . $i . '_' . $j . '" value="L54">
                 </td>';
        }
        else if($i == 5 && $j == 3){
            $table .= '<td>
                <input type="text" class="form-control" id="idDataHoraLogin" style="background-color: rgba(255,0,0,0.2);text-align: center;" disabled placeholder="[' . $i . '][' . $j . ']" style="text-align: center;"
                       name="input_' . $i . '_' . $j . '" value="L32">
                 </td>';
        }
        else if($i == 4 && $j == 6){
            $table .= '<td>
                <input type="text" class="form-control" id="idDataHoraLogin" style="background-color: rgba(255,0,0,0.2);text-align: center;" disabled placeholder="[' . $i . '][' . $j . ']" style="text-align: center;"
                       name="input_' . $i . '_' . $j . '" value="E11">
                 </td>';
        }
        else if($i == 1 && $j == 8){
            $table .= '<td>
                <input type="text" class="form-control" id="idDataHoraLogin" disabled placeholder="[' . $i . '][' . $j . ']" style="background-color: rgba(255,0,0,0.2);text-align: center;"
                       name="input_' . $i . '_' . $j . '" value="O14">
                 </td>';
        }else {
            $table .= '<td>
                <input type="text" class="form-control" id="idDataHoraLogin" placeholder="[' . $i . '][' . $j . ']" style="text-align: center;"
                       name="input_' . $i . '_' . $j . '" value="">
                 </td>';
        }

    }
    $table.='</tr>';
}
$table .= '</table>';

echo $table;





Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();