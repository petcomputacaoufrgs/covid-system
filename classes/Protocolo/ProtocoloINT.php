<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class ProtocoloINT
{
    static function montar_select_protocolo(&$select_protocolo,$objProtocolo,$disabled =null,$onchange =null)
    {

        if(is_null($disabled)){ $disabled = ''; }
        else{ $disabled = ' disabled '; }

        if(is_null($onchange)){ $onchange = ''; }
        else{ $onchange = ' onchange="this.form.submit()" '; }

        $select_protocolo = ' <select ' . $disabled . $onchange .
            'class="form-control" name="sel_tipos_protocolos" onblur="">
                            <option value="-1">Selecione um dos tipos de protocolo </option>';

        $arr_protocolos = ProtocoloRN::listarTiposProtocolos();
        for ($i=0; $i<count($arr_protocolos); $i++) {
            $selected = '';
            if($arr_protocolos[$i]->getStrTipo()== $objProtocolo->getCaractere() ){
                $selected = ' selected ';
            }

            $select_protocolo .= '<option ' . $selected . ' value="'.$arr_protocolos[$i]->getStrTipo().'">'
                . Pagina::formatar_html($arr_protocolos[$i]->getStrDescricao()) . '</option>';
        }
        $select_protocolo .='</select>';
    }




    static function montar_checkboxes_protocolo(&$checkboxes_protocolo,$objProtocolo,$objProtocoloRN,$checks_selecionados,$disabled =null){

        if(is_null($disabled)){ $disabled = ''; }
        else{$disabled = ' disabled '; }
        $checkboxes_protocolo = '';

        $arr_protocolos = $objProtocoloRN->listar(new Protocolo());
        foreach ($arr_protocolos as $protocolo){
            $checked = ' ';
            $encontrou = false;
            $i=0;
            if(!is_null($checks_selecionados)){
                while (!$encontrou && $i<count($checks_selecionados)) {
                    if ($checks_selecionados[$i]->getIdProtocoloFk() == $protocolo->getIdProtocolo()) {
                        $checked = ' checked ';
                    }
                    $i++;
                }

            }


                $checkboxes_protocolo .= ' <div class="form-check form-check-inline">
              <input class="form-check-input" '.$checked.' type="checkbox" id="idProtocolo_' . Pagina::formatar_html($protocolo->getIdProtocolo()) . '" 
                name="protocolo_' . Pagina::formatar_html($protocolo->getIdProtocolo()) . '" value="' . Pagina::formatar_html($protocolo->getIdProtocolo()) . '">
              <label class="form-check-label"  for="idProtocolo_' . Pagina::formatar_html($protocolo->getIdProtocolo()) . '">' . Pagina::formatar_html(ProtocoloRN::mosrtrar_descricao_tipo_protocolo($protocolo->getCaractere())) . '</label>
            </div>';


        }

    }

    static function montar_select_id_protocolo(&$select_protocolo,$objProtocolo,$objProtocoloRN,$disabled =null,$onchange =null)
    {

        if(is_null($disabled)){ $disabled = ''; }
        else{ $disabled = ' disabled '; }

        if(is_null($onchange)){ $onchange = ''; }
        else{ $onchange = ' onchange="this.form.submit()" '; }

        $select_protocolo = ' <select ' . $disabled . $onchange .
            'class="form-control" name="sel_protocolos" onblur="">
                            <option value="-1">Selecione um dos tipos de protocolo </option>';

        $arr_protocolos = $objProtocoloRN->listar($objProtocolo);
        foreach ($arr_protocolos as $protocolo) {
            $selected = '';
            if($protocolo->getIdProtocolo()== $objProtocolo->getIdProtocolo() ){
                $selected = ' selected ';
            }

            $select_protocolo .= '<option ' . $selected . ' value="'.Pagina::formatar_html($protocolo->getIdProtocolo()).'">'
                . Pagina::formatar_html(ProtocoloRN::mosrtrar_descricao_tipo_protocolo($protocolo->getCaractere())) . '</option>';
        }
        $select_protocolo .='</select>';
    }

    // LACEN -----------------------------
    static function tabela1_protocolo_LACEN(&$tabela,$numAmostras,$arrOperadores){
        $numAmostras += 5;
        $tabela ='<table class="table table-hover  table-sm" style="text-align: center;border: 1px solid #d2d2d2;" >
                    <tr>
                        <td>LACEN/IBMP</td>
                        <td>20ul</td>
                        <td></td>
                    </tr> 
                    <tr>
                        <td>Gene ORF-1ab / N/ Controle</td>
                        <td>1x</td>
                        <td>'.$numAmostras.'</td>
                    </tr> 
                    <tr>
                        <td style="background-color: rgba(224, 224, 224,0.6);">'.$arrOperadores[0]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp0_'.$arrOperadores[0]->getIdOperador().'" value="' . $arrOperadores[0]->getValor() . '"></td>
                        <td>'.($arrOperadores[0]->getValor()*$numAmostras).'</td>
                    </tr> 
                    <tr>
                        <td >'.$arrOperadores[1]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp1_'.$arrOperadores[1]->getIdOperador().'" value="' . $arrOperadores[1]->getValor() . '"></td>
                        <td>'.($arrOperadores[1]->getValor()*$numAmostras).'</td>
                    </tr> 
                   <tr>
                        <td style="background-color: rgba(224, 224, 224,0.6);">'.$arrOperadores[2]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp2_'.$arrOperadores[2]->getIdOperador().'" value="' . $arrOperadores[2]->getValor() . '"></td>
                        <td>'.($arrOperadores[2]->getValor()*$numAmostras).'</td>
                    </tr>       
                     <tr>
                        <td > - </td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp3_'.$arrOperadores[3]->getIdOperador().'" value="' . $arrOperadores[3]->getValor() . '"></td>
                        <td>'.($arrOperadores[3]->getValor()*$numAmostras).'</td>
                    </tr>  
                    <tr>
                        <tr>
                        <td style="border-bottom: 1px solid black;">'.$arrOperadores[4]->getNome().'</td>
                        <td style="border-bottom: 1px solid black;"><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp4_'.$arrOperadores[4]->getIdOperador().'" value="' . $arrOperadores[4]->getValor() . '"></td>
                        <td style="border-bottom: 1px solid black;"> - </td>
                    </tr>  
                     <tr>
                        <tr>
                        <td >'.$arrOperadores[5]->getNome().'</td>
                         <td ><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp5_'.$arrOperadores[5]->getIdOperador().'" value="' . $arrOperadores[5]->getValor() . '"></td>
                         <td >-</td>
                    </tr> 
                     <tr>
                        <td>Orf1ab: FAM</td>
                        <td>-</td>
                        <td>-</td>
                    </tr> 
                    <tr>
                        <td>Orf1ab: FAM</td>
                        <td>-</td>
                        <td>-</td>
                    </tr> 
                    <tr>
                        <td>N: VIC/HEX</td>
                        <td>-</td>
                        <td>-</td>
                    </tr> 
                    <tr>
                        <td>Ref. Passiva = None</td>
                        <td>-</td>
                        <td>-</td>
                    </tr> 
                    <tr>
                        <td>Quencher = None</td>
                        <td>-</td>
                        <td>-</td>
                    </tr> 
   
                    </table>';
    }
    static function tabelaAzul_protocolo_LACEN(&$tabela,$objEquipamento){

        $tabela ='<table class="table table-hover  table-sm" style="text-align: center; " >
                        <tr>
                            <th  colspan="5" >LACEN/IBMP</th>
                        </tr>
                        <tr>
                            <td>Equipamento</td>
                            <td  colspan="4" style="background: rgba(255,255,0,0.2);">'.$objEquipamento->getNomeEquipamento().'</td>
                           
                        </tr> 
                        <tr>
                            <th colspan="2">Estágio</th>
                            <th>Ciclo</th>
                            <th>°C</th>
                            <th>Tempo</th>
                        </tr> 
                        <tr>
                            <th colspan="2">Transcrição reversa</th>
                            <td>1</td>
                            <td>50°C</td>
                            <td>15\'</td>
                        </tr> 
                        <tr>
                            <th colspan="2">Inativ RT/ <br>
                                                desnat inicial</th>
                            <td>1</td>
                            <td>95°C</td>
                            <td>3\'</td>
                        </tr> 
                        <tr>
                            <th colspan="2" rowspan="2" >Amplificação</th>
                            <td rowspan="2">45</td>';
        $tabela .=   "       <td>95°C</td>
                            <td>15''</td>";

        $tabela .=   '  </tr> 
                        <tr>
                            <td>55°C</td>';
         $tabela .=  "      <td>40''</td>";
         $tabela .=   '</tr>
                        <tr>
                         <th colspan="2">Final</th>
                            <td>1</td>
                            <td>25°C</td>';
         $tabela .=   "     <td>10''</td>
                        </tr>   
                    </table>";

    }

    // NEWGENE -----------------------------
    static function tabela_E_protocolo_newgene(&$tabela,$numAmostras,$arrOperadores){
        $numAmostras += 5;
        $tabela ='<table class="table table-hover  table-sm" style="text-align: center;border: 1px solid #d2d2d2;" >
                    <tr>
                        <th>newGene RTPCRAmp</th>
                        <td>20ul</td>
                        <td></td>
                    </tr> 
                    <tr>
                        <td>Gene E</td>
                        <td>1x</td>
                        <td>'.$numAmostras.'</td>
                    </tr> 
                    <tr>
                        <td style="background-color: rgba(224, 224, 224,0.6);">'.$arrOperadores[0]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp0_'.$arrOperadores[0]->getIdOperador().'" value="' . $arrOperadores[0]->getValor() . '"></td>
                        <td>'.($arrOperadores[0]->getValor()*$numAmostras).'</td>
                    </tr> 
                    <tr>
                        <td>'.$arrOperadores[1]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp1_'.$arrOperadores[1]->getIdOperador().'" value="' . $arrOperadores[1]->getValor() . '"></td>
                        <td>'.($arrOperadores[1]->getValor()*$numAmostras).'</td>
                    </tr> 
                   <tr>
                        <td style="background-color: rgba(224, 224, 224,0.6);">'.$arrOperadores[2]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp2_'.$arrOperadores[2]->getIdOperador().'" value="' . $arrOperadores[2]->getValor() . '"></td>
                        <td>'.($arrOperadores[2]->getValor()*$numAmostras).'</td>
                    </tr>
                     <tr>
                        <td>'.$arrOperadores[3]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp3_'.$arrOperadores[3]->getIdOperador().'" value="' . $arrOperadores[3]->getValor() . '"></td>
                        <td>'.($arrOperadores[3]->getValor()*$numAmostras).'</td>
                    </tr>  
                    <tr><!-- em branco -->
                        <td > - </td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp4_'.$arrOperadores[4]->getIdOperador().'" value="' . $arrOperadores[4]->getValor() . '"></td>
                        <td> '.($arrOperadores[4]->getValor()*$numAmostras).' </td>
                    </tr> 
                  
                    <tr > <!-- RNA -->
                        <td style="border-bottom: 1px solid black;"><b>'.$arrOperadores[5]->getNome().'</b></td>
                        <td style="border-bottom: 1px solid black;">
                            <input type="number" class="form-control" step="any" style="text-align: center;"
                                name="txtOp5_'.$arrOperadores[5]->getIdOperador().'" value="'.$arrOperadores[5]->getValor().'"></td>
                        <td style="border-bottom: 1px solid black;">-</td>
                    </tr> 
                   
                     <tr> <!-- volume total -->
                        <td>'.$arrOperadores[6]->getNome().'</td>
                        <td ><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp6_'.$arrOperadores[6]->getIdOperador().'" value="'.$arrOperadores[6]->getValor().'"></td>
                        <td>-</td>
                    </tr> 
                     <tr>
                        <td>sonda com FAM</td>
                        <td>-</td>
                        <td>-</td>
                    </tr> 
                    <tr>
                        <td>Ref. Passiva = ROX</td>
                        <td>-</td>
                        <td>-</td>
                    </tr> 
                     
                    </table>';
    }
    static function tabela_RdRp_protocolo_newgene(&$tabela,$numAmostras,$arrOperadores){
        $numAmostras += 5;
        $tabela ='<table class="table table-hover  table-sm" style="text-align: center;border: 1px solid #d2d2d2;" >
                    <tr>
                        <th>newGene RTPCRAmp</th>
                        <td>20ul</td>
                        <td></td>
                    </tr> 
                    <tr>
                        <td>Gene RdRp</td>
                        <td>1x</td>
                        <td>'.$numAmostras.'</td>
                    </tr> 
                    <tr>
                        <td style="background-color: rgba(224, 224, 224,0.6);">'.$arrOperadores[0]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp0_'.$arrOperadores[0]->getIdOperador().'" value="' . $arrOperadores[0]->getValor() . '"></td>
                        <td>'.($arrOperadores[0]->getValor()*$numAmostras).'</td>
                    </tr> 
                    <tr>
                        <td>'.$arrOperadores[1]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp1_'.$arrOperadores[1]->getIdOperador().'" value="' . $arrOperadores[1]->getValor() . '"></td>
                        <td>'.($arrOperadores[1]->getValor()*$numAmostras).'</td>
                    </tr> 
                   <tr>
                        <td style="background-color: rgba(224, 224, 224,0.6);">'.$arrOperadores[2]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp2_'.$arrOperadores[2]->getIdOperador().'" value="' . $arrOperadores[2]->getValor() . '"></td>
                        <td>'.($arrOperadores[2]->getValor()*$numAmostras).'</td>
                    </tr>
                    <tr>
                        <td>'.$arrOperadores[3]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp3_'.$arrOperadores[3]->getIdOperador().'" value="' . $arrOperadores[3]->getValor() . '"></td>
                        <td>'.($arrOperadores[3]->getValor()*$numAmostras).'</td>
                    </tr>  
                    <tr>
                        <!-- em branco -->
                        <td > - </td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp4_'.$arrOperadores[4]->getIdOperador().'" value="' . $arrOperadores[4]->getValor() . '"></td>
                        <td> '.($arrOperadores[4]->getValor()*$numAmostras).' </td>
                    </tr> 
                  
                     <tr > <!-- RNA -->
                        <td style="border-bottom: 1px solid black;"><b>'.$arrOperadores[5]->getNome().'</b></td>
                        <td style="border-bottom: 1px solid black;"><strong><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp5_'.$arrOperadores[5]->getIdOperador().'" value="' . $arrOperadores[5]->getValor() . '"></strong></td>
                        <td style="border-bottom: 1px solid black;">-</td>
                    </tr> 
                   
                     <tr> <!-- volume total -->
                        <td>'.$arrOperadores[6]->getNome().'</td>
                        <td><strong><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp6_'.$arrOperadores[6]->getIdOperador().'" value="' . $arrOperadores[6]->getValor() . '"></strong></td>
                        <td>-</td>
                    </tr> 
                     <tr>
                        <td>sonda com FAM</td>
                        <td>-</td>
                        <td>-</td>
                    </tr> 
                    <tr>
                        <td>Ref. Passiva = ROX</td>
                        <td>-</td>
                        <td>-</td>
                    </tr> 
                     
                    </table>';
    }
    static function tabela_Controle_protocolo_newgene(&$tabela,$numAmostras,$arrOperadores){
        $numAmostras +=5;
        $tabela ='<table class="table table-hover  table-sm" style="text-align: center;border: 1px solid #d2d2d2;" >
                    <tr>
                        <th>newGene <br> RTPCRAmp</th>
                        <td>20ul</td>
                        <td></td>
                    </tr> 
                    <tr>
                        <td>Gene Controle</td>
                        <td>1x</td>
                        <td>'.$numAmostras.'</td>
                    </tr> 
                    <tr>
                        <td style="background-color: rgba(224, 224, 224,0.6);">'.$arrOperadores[0]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp0_'.$arrOperadores[0]->getIdOperador().'" value="' . $arrOperadores[0]->getValor() . '"></td>
                        <td>'.($arrOperadores[0]->getValor()*$numAmostras).'</td>
                    </tr> 
                    <tr>
                        <td>'.$arrOperadores[1]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp1_'.$arrOperadores[1]->getIdOperador().'" value="' . $arrOperadores[1]->getValor() . '"></td>
                        <td>'.($arrOperadores[1]->getValor()*$numAmostras).'</td>
                    </tr> 
                   <tr>
                        <td style="background-color: rgba(224, 224, 224,0.6);">'.$arrOperadores[2]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp2_'.$arrOperadores[2]->getIdOperador().'" value="' . $arrOperadores[2]->getValor() . '"></td>
                        <td>'.($arrOperadores[2]->getValor()*$numAmostras).'</td>
                    </tr>
                     <tr>
                        <td>'.$arrOperadores[3]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp3_'.$arrOperadores[3]->getIdOperador().'" value="' . $arrOperadores[3]->getValor() . '"></td>
                        <td>'.($arrOperadores[3]->getValor()*$numAmostras).'</td>
                    </tr>  
                    <tr>
                        <tr><!-- em branco -->
                        <td > - </td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp4_'.$arrOperadores[4]->getIdOperador().'" value="' . $arrOperadores[4]->getValor() . '"></td>
                        <td> '.($arrOperadores[4]->getValor()*$numAmostras).' </td>
                    </tr> 
                  
                     <tr > <!-- RNA -->
                        <td style="border-bottom: 1px solid black;"><b>'.$arrOperadores[5]->getNome().'</b></td>
                        <td style="border-bottom: 1px solid black;"><strong><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp5_'.$arrOperadores[5]->getIdOperador().'" value="' . $arrOperadores[5]->getValor() . '"></strong></td>
                        <td style="border-bottom: 1px solid black;">-</td>
                    </tr> 
                   
                     <tr> <!-- volume total -->
                        <td>'.$arrOperadores[6]->getNome().'</td>
                        <td><strong><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp6_'.$arrOperadores[6]->getIdOperador().'" value="' . $arrOperadores[6]->getValor() . '"></strong></td>
                        <td>-</td>
                    </tr> 
                     <tr>
                        <td>sonda com <strong>HEX/VIC</strong></td>
                        <td>-</td>
                        <td>-</td>
                    </tr> 
                    <tr>
                        <td>Ref. Passiva = ROX</td>
                        <td>-</td>
                        <td>-</td>
                    </tr> 
                     
                    </table>';
    }
    static function tabelaAzul_protocolo_newgene(&$tabela,$objEquipamento){

        $tabela ='<table class="table table-hover  table-sm" style="text-align: center; " >
                        <tr>
                            <th  colspan="5" >newGene</th>
                        </tr>
                        <tr>
                            <td>Equipamento</td>
                            <td  colspan="4" style="background: rgba(255,255,0,0.2);">'.$objEquipamento->getNomeEquipamento().'</td>
                           
                        </tr> 
                        <tr>
                            <th colspan="2">Estágio</th>
                            <th>Ciclo</th>
                            <th>°C</th>
                            <th>Tempo</th>
                        </tr> 
                        <tr>
                            <th colspan="2">Transcrição reversa</th>
                            <td>1</td>
                            <td>37°C</td>
                            <td>30\'</td>
                        </tr> 
                        <tr>
                            <th colspan="2">Inativ RT/ <br>
                                                desnat inicial</th>
                            <td>1</td>
                            <td>95°C</td>
                            <td>3\'</td>
                        </tr> 
                        <tr>
                            <th colspan="2" rowspan="2" >Amplificação</th>
                            <td rowspan="2">45</td>
                            <td>95°C</td>';
          $tabela .=   "            <td>15''</td>";
                           
          $tabela .= '   </tr> 
                        <tr>
                            <td>58°C</td>';
          $tabela .= "       <td>45 '' </td>";
          $tabela .='     </tr>          
                    </table>';

    }

    // AG Path -----------------------------
    static function tabela_N1_protocolo_agpath_CDC(&$tabela,$numAmostras,$arrOperadores){

        $numAmostras = $numAmostras+5;
        $tabela ='<table class="table table-hover  table-sm" style="text-align: center;border: 1px solid #d2d2d2;" >
                    <tr>
                        <th>AG Path / CDC</th>
                        <td colspan="2">10ul mix</td>
                    </tr> 
                    <tr>
                        <td>Gene N1</td>
                        <td>1x</td>
                        <td>'.$numAmostras.'</td>
                    </tr> 
                    <tr>
                        <td style="background-color: rgba(224, 224, 224,0.6);">'.$arrOperadores[0]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp0_'.$arrOperadores[0]->getIdOperador().'" value="' . $arrOperadores[0]->getValor() . '"></td>
                        <td>'.($arrOperadores[0]->getValor()*$numAmostras).'</td>
                    </tr> 
                    <tr>
                        <td>'.$arrOperadores[1]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp1_'.$arrOperadores[1]->getIdOperador().'" value="' . $arrOperadores[1]->getValor() . '"></td>
                        <td>'.($arrOperadores[1]->getValor()*$numAmostras).'</td>
                    </tr> 
                    <tr>
                        <td style="background-color: rgba(224, 224, 224,0.6);">'.$arrOperadores[2]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp2_'.$arrOperadores[2]->getIdOperador().'" value="' . $arrOperadores[2]->getValor() . '"></td>
                        <td>'.($arrOperadores[2]->getValor()*$numAmostras).'</td>
                    </tr>    
                    <tr>
                        <td>'.$arrOperadores[3]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp3_'.$arrOperadores[3]->getIdOperador().'" value="' . $arrOperadores[3]->getValor() . '"></td>
                        <td>'.($arrOperadores[3]->getValor()*$numAmostras).'</td>
                    </tr> 
                    <tr>
                        <td>-</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp4_'.$arrOperadores[4]->getIdOperador().'" value="' . $arrOperadores[4]->getValor() . '"></td>
                        <td>'.($arrOperadores[4]->getValor()*$numAmostras).'</td>
                    </tr> 
                    <tr >
                        <td style="border-bottom: 1px solid black;"><b>'.$arrOperadores[5]->getNome().'</b></td>
                        <td style="border-bottom: 1px solid black;"><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp5_'.$arrOperadores[5]->getIdOperador().'" value="' . $arrOperadores[5]->getValor() . '"></td>
                        <td style="border-bottom: 1px solid black;">-</td>
                    </tr> 
                     <tr>
                        <td>'.$arrOperadores[6]->getNome().'</td>
                        <td ><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp6_'.$arrOperadores[6]->getIdOperador().'" value="' . $arrOperadores[6]->getValor() . '"></td>
                        <td>-</td>
                    </tr> 
                     <tr>
                        <td>sonda com FAM</td>
                        <td>-</td>
                        <td>-</td>
                    </tr> 
                    <tr>
                        <td>Ref. Passiva = ROX</td>
                        <td>-</td>
                        <td>-</td>
                    </tr> 
                     
                    </table>';
    }
    static function tabela_N2_protocolo_agpath_CDC(&$tabela,$numAmostras,$arrOperadores){

        $numAmostras = $numAmostras+5;
        $tabela ='<table class="table table-hover  table-sm" style="text-align: center;border: 1px solid #d2d2d2;" >
                    <tr>
                       <tr>
                        <th>AG Path / CDC</th>
                        <td colspan="2">10ul mix</td>
                    </tr> 
                    <tr>
                        <td>Gene N2 </td>
                        <td>1x</td>
                        <td>'.$numAmostras.'</td>
                    </tr> 
                    <tr>
                        <td style="background-color: rgba(224, 224, 224,0.6);">'.$arrOperadores[0]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp0_'.$arrOperadores[0]->getIdOperador().'" value="' . $arrOperadores[0]->getValor() . '"></td>
                        <td>'.($arrOperadores[0]->getValor()*$numAmostras).'</td>
                    </tr> 
                    <tr>
                        <td>'.$arrOperadores[1]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp1_'.$arrOperadores[1]->getIdOperador().'" value="' . $arrOperadores[1]->getValor() . '"></td>
                        <td>'.($arrOperadores[1]->getValor()*$numAmostras).'</td>
                    </tr> 
                    <tr>
                        <td style="background-color: rgba(224, 224, 224,0.6);">'.$arrOperadores[2]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp2_'.$arrOperadores[2]->getIdOperador().'" value="' . $arrOperadores[2]->getValor() . '"></td>
                        <td>'.($arrOperadores[2]->getValor()*$numAmostras).'</td>
                    </tr>    
                    <tr>
                        <td>'.$arrOperadores[3]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp3_'.$arrOperadores[3]->getIdOperador().'" value="' . $arrOperadores[3]->getValor() . '"></td>
                        <td>'.($arrOperadores[3]->getValor()*$numAmostras).'</td>
                    </tr> 
                    <tr>
                        <td>-</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp4_'.$arrOperadores[4]->getIdOperador().'" value="' . $arrOperadores[4]->getValor() . '"></td>
                        <td>'.($arrOperadores[4]->getValor()*$numAmostras).'</td>
                    </tr> 
                    <tr >
                        <td style="border-bottom: 1px solid black;"><b>'.$arrOperadores[5]->getNome().'</b></td>
                        <td style="border-bottom: 1px solid black;"><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp5_'.$arrOperadores[5]->getIdOperador().'" value="' . $arrOperadores[5]->getValor() . '"></td>
                        <td style="border-bottom: 1px solid black;">-</td>
                    </tr> 
                   
                     <tr>
                        <td>'.$arrOperadores[6]->getNome().'</td>
                        <td ><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp6_'.$arrOperadores[6]->getIdOperador().'" value="' . $arrOperadores[6]->getValor() . '"></td>
                        <td>-</td>
                    </tr> 
                     <tr>
                        <td>sonda com FAM</td>
                        <td>-</td>
                        <td>-</td>
                    </tr> 
                    <tr>
                        <td>Ref. Passiva = ROX</td>
                        <td>-</td>
                        <td>-</td>
                    </tr> 
                     
                    </table>';
    }
    static function tabela_Controle_protocolo_agpath_CDC(&$tabela,$numAmostras,$arrOperadores){

        $numAmostras = $numAmostras+5;
        $tabela ='<table class="table table-hover  table-sm" style="text-align: center;border: 1px solid #d2d2d2;" >
                    <tr>
                         <tr>
                        <th>AG Path / CDC</th>
                        <td colspan="2">10ul mix</td>
                    </tr> 
                    </tr> 
                    <tr>
                        <td>Gene Controle</td>
                        <td>1x</td>
                        <td>'.$numAmostras.'</td>
                    </tr> 
                    <tr>
                        <td style="background-color: rgba(224, 224, 224,0.6);">'.$arrOperadores[0]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp0_'.$arrOperadores[0]->getIdOperador().'" value="' . $arrOperadores[0]->getValor() . '"></td>
                        <td>'.($arrOperadores[0]->getValor()*$numAmostras).'</td>
                    </tr> 
                    <tr>
                        <td>'.$arrOperadores[1]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp1_'.$arrOperadores[1]->getIdOperador().'" value="' . $arrOperadores[1]->getValor() . '"></td>
                        <td>'.($arrOperadores[1]->getValor()*$numAmostras).'</td>
                    </tr> 
                    <tr>
                        <td style="background-color: rgba(224, 224, 224,0.6);">'.$arrOperadores[2]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp2_'.$arrOperadores[2]->getIdOperador().'" value="' . $arrOperadores[2]->getValor() . '"></td>
                        <td>'.($arrOperadores[2]->getValor()*$numAmostras).'</td>
                    </tr>    
                    <tr>
                        <td>'.$arrOperadores[3]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp3_'.$arrOperadores[3]->getIdOperador().'" value="' . $arrOperadores[3]->getValor() . '"></td>
                        <td>'.($arrOperadores[3]->getValor()*$numAmostras).'</td>
                    </tr> 
                    <tr>
                        <td>-</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp4_'.$arrOperadores[4]->getIdOperador().'" value="' . $arrOperadores[4]->getValor() . '"></td>
                        <td>'.($arrOperadores[4]->getValor()*$numAmostras).'</td>
                    </tr> 
                    <tr >
                        <td style="border-bottom: 1px solid black;"><b>'.$arrOperadores[5]->getNome().'</b></td>
                        <td style="border-bottom: 1px solid black;"><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp5_'.$arrOperadores[5]->getIdOperador().'" value="' . $arrOperadores[5]->getValor() . '"></td>
                        <td style="border-bottom: 1px solid black;">-</td>
                    </tr> 
                   
                     <tr>
                        <td>'.$arrOperadores[6]->getNome().'</td>
                        <td ><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp6_'.$arrOperadores[6]->getIdOperador().'" value="' . $arrOperadores[6]->getValor() . '"></td>
                        <td>-</td>
                    </tr> 
                     <tr>
                        <td>sonda com FAM</td>
                        <td>-</td>
                        <td>-</td>
                    </tr> 
                    <tr>
                        <td>Ref. Passiva = ROX</td>
                        <td>-</td>
                        <td>-</td>
                    </tr> 
                     
                    </table>';
    }
    static function tabelaAzul_protocolo_agpath_CDC(&$tabela,$objEquipamento){

        $tabela ='<table class="table table-hover  table-sm" style="text-align: center; " >
                        <tr>
                            <th  colspan="5" >AG Path / CDC</th>
                        </tr>
                        <tr>
                            <td>Equipamento</td>
                            <td  colspan="4" style="background: rgba(255,255,0,0.2);">'.$objEquipamento->getNomeEquipamento().'</td>
                           
                        </tr> 
                        <tr>
                            <th colspan="2">Estágio</th>
                            <th>Ciclo</th>
                            <th>°C</th>
                            <th>Tempo</th>
                        </tr> 
                        <tr>
                            <th colspan="2">Transcrição reversa</th>
                            <td>1</td>
                            <td>50°C</td>
                            <td>15\'</td>
                        </tr> 
                        <tr>
                            <th colspan="2">Inativ RT/ <br>
                                                desnat inicial</th>
                            <td>1</td>
                            <td>95°C</td>
                            <td>10\'</td>
                        </tr> 
                        <tr>
                            <th colspan="2" rowspan="2" >Amplificação</th>
                            <td rowspan="2">45</td>
                            <td>95°C</td>';
        $tabela .=   "            <td>15''</td>";

        $tabela .= '   </tr> 
                        <tr>
                            <td>55°C</td>';
        $tabela .= "       <td>30 '' </td>";
        $tabela .='     </tr>          
                    </table>';

    }

    // AG Path/Charité -----------------------------
    static function tabela_E_protocolo_agpath_charite(&$tabela,$numAmostras,$arrOperadores){

        $numAmostras += 5;
        $tabela ='<table class="table table-hover  table-sm" style="text-align: center;border: 1px solid #d2d2d2;" >
                    <tr>
                        <th>AG Path </th>
                        <td colspan="2">20ul</td>
                    </tr> 
                    <tr>
                        <td>Gene E</td>
                        <td>1x</td>
                        <td>'.$numAmostras.'</td>
                    </tr> 
                    <tr>
                        <td style="background-color: rgba(224, 224, 224,0.6);">'.$arrOperadores[0]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp0_'.$arrOperadores[0]->getIdOperador().'" value="' . $arrOperadores[0]->getValor() . '"></td>
                        <td>'.($arrOperadores[0]->getValor()*$numAmostras).'</td>
                    </tr> 
                    <tr>
                        <td >'.$arrOperadores[1]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp1_'.$arrOperadores[1]->getIdOperador().'" value="' . $arrOperadores[1]->getValor() . '"></td>
                        <td>'.($arrOperadores[1]->getValor()*$numAmostras).'</td>
                    </tr> 
                   <tr>
                        <td style="background-color: rgba(224, 224, 224,0.6);">'.$arrOperadores[2]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp2_'.$arrOperadores[2]->getIdOperador().'" value="' . $arrOperadores[2]->getValor() . '"></td>
                        <td>'.($arrOperadores[2]->getValor()*$numAmostras).'</td>
                    </tr>
                     <tr>
                        <td >'. $arrOperadores[3]->getNome() .'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp3_'.$arrOperadores[3]->getIdOperador().'" value="' . $arrOperadores[3]->getValor() . '"></td>
                        <td>'.($arrOperadores[3]->getValor()*$numAmostras).'</td>
                    </tr>  
                    <tr>
                        <td > - </td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp4_'.$arrOperadores[4]->getIdOperador().'" value="' . $arrOperadores[4]->getValor() . '"></td>
                        <td> '.($arrOperadores[4]->getValor()*$numAmostras).' </td>
                    </tr> 
                  
                    <tr >
                        <td style="border-bottom: 1px solid black;"><b>'.$arrOperadores[5]->getNome().'</b></td>
                        <td style="border-bottom: 1px solid black;"><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp5_'.$arrOperadores[5]->getIdOperador().'" value="' . $arrOperadores[5]->getValor() . '"></td>
                        <td style="border-bottom: 1px solid black;">-</td>
                    </tr> 
                   
                     <tr>
                        <td>'.$arrOperadores[6]->getNome().'</td>
                        <td ><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp6_'.$arrOperadores[6]->getIdOperador().'" value="' . $arrOperadores[6]->getValor() . '"></td>
                        <td>-</td>
                    </tr>
                     <tr>
                        <td>sonda com FAM</td>
                        <td>-</td>
                        <td>-</td>
                    </tr> 
                    <tr>
                        <td>Ref. Passiva = ROX</td>
                        <td>-</td>
                        <td>-</td>
                    </tr> 
                     
                    </table>';
    }
    static function tabela_RdRp_protocolo_agpath_charite(&$tabela,$numAmostras,$arrOperadores){
        $numAmostras += 5;
        $tabela ='<table class="table table-hover  table-sm" style="text-align: center;border: 1px solid #d2d2d2;" >
                    <tr>
                       <tr>
                        <th>AG Path </th>
                        <td colspan="2">20ul</td>
                    </tr> 
                    <tr>
                        <td>Gene RdRp </td>
                        <td>1x</td>
                        <td>'.$numAmostras.'</td>
                    </tr> 
                    <tr>
                        <td style="background-color: rgba(224, 224, 224,0.6);">'.$arrOperadores[0]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp0_'.$arrOperadores[0]->getIdOperador().'" value="' . $arrOperadores[0]->getValor() . '"></td>
                        <td>'.($arrOperadores[0]->getValor()*$numAmostras).'</td>
                    </tr> 
                    <tr>
                        <td >'.$arrOperadores[1]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp1_'.$arrOperadores[1]->getIdOperador().'" value="' . $arrOperadores[1]->getValor() . '"></td>
                        <td>'.($arrOperadores[1]->getValor()*$numAmostras).'</td>
                    </tr> 
                   <tr>
                        <td style="background-color: rgba(224, 224, 224,0.6);">'.$arrOperadores[2]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp2_'.$arrOperadores[2]->getIdOperador().'" value="' . $arrOperadores[2]->getValor() . '"></td>
                        <td>'.($arrOperadores[2]->getValor()*$numAmostras).'</td>
                    </tr>
                     <tr>
                        <td >'. $arrOperadores[3]->getNome() .'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp3_'.$arrOperadores[3]->getIdOperador().'" value="' . $arrOperadores[3]->getValor() . '"></td>
                        <td>'.($arrOperadores[3]->getValor()*$numAmostras).'</td>
                    </tr>  
                    <tr>
                        <td > - </td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp4_'.$arrOperadores[4]->getIdOperador().'" value="' . $arrOperadores[4]->getValor() . '"></td>
                        <td> '.($arrOperadores[4]->getValor()*$numAmostras).' </td>
                    </tr> 
                  
                    <tr >
                        <td style="border-bottom: 1px solid black;"><b>'.$arrOperadores[5]->getNome().'</b></td>
                        <td style="border-bottom: 1px solid black;"><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp5_'.$arrOperadores[5]->getIdOperador().'" value="' . $arrOperadores[5]->getValor() . '"></td>
                        <td style="border-bottom: 1px solid black;">-</td>
                    </tr> 
                   
                     <tr>
                        <td>'.$arrOperadores[6]->getNome().'</td>
                        <td ><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp6_'.$arrOperadores[6]->getIdOperador().'" value="' . $arrOperadores[6]->getValor() . '"></td>
                        <td>-</td>
                    </tr>
                     <tr>
                        <td>sonda com FAM</td>
                        <td>-</td>
                        <td>-</td>
                    </tr> 
                    <tr>
                        <td>Ref. Passiva = ROX</td>
                        <td>-</td>
                        <td>-</td>
                    </tr> 
                     
                    </table>';
    }
    static function tabela_Controle_protocolo_agpath_charite(&$tabela,$numAmostras,$arrOperadores){
        $numAmostras += 5;
        $tabela ='<table class="table table-hover  table-sm" style="text-align: center;border: 1px solid #d2d2d2;" >
                    <tr>
                         <tr>
                        <th>AG Path</th>
                        <td colspan="2">20ul</td>
                    </tr> 
                    </tr> 
                    <tr>
                        <td>Gene Controle</td>
                        <td>1x</td>
                        <td>'.$numAmostras.'</td>
                    </tr> 
                    <tr>
                        <td style="background-color: rgba(224, 224, 224,0.6);">'.$arrOperadores[0]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp0_'.$arrOperadores[0]->getIdOperador().'" value="' . $arrOperadores[0]->getValor() . '"></td>
                        <td>'.($arrOperadores[0]->getValor()*$numAmostras).'</td>
                    </tr> 
                    <tr>
                        <td >'.$arrOperadores[1]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp1_'.$arrOperadores[1]->getIdOperador().'" value="' . $arrOperadores[1]->getValor() . '"></td>
                        <td>'.($arrOperadores[1]->getValor()*$numAmostras).'</td>
                    </tr> 
                   <tr>
                        <td style="background-color: rgba(224, 224, 224,0.6);">'.$arrOperadores[2]->getNome().'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp2_'.$arrOperadores[2]->getIdOperador().'" value="' . $arrOperadores[2]->getValor() . '"></td>
                        <td>'.($arrOperadores[2]->getValor()*$numAmostras).'</td>
                    </tr>
                     <tr>
                        <td >'. $arrOperadores[3]->getNome() .'</td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp3_'.$arrOperadores[3]->getIdOperador().'" value="' . $arrOperadores[3]->getValor() . '"></td>
                        <td>'.($arrOperadores[3]->getValor()*$numAmostras).'</td>
                    </tr>  
                    <tr>
                        <td > - </td>
                        <td><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp4_'.$arrOperadores[4]->getIdOperador().'" value="' . $arrOperadores[4]->getValor() . '"></td>
                        <td> '.($arrOperadores[4]->getValor()*$numAmostras).' </td>
                    </tr> 
                  
                    <tr >
                        <td style="border-bottom: 1px solid black;"><b>'.$arrOperadores[5]->getNome().'</b></td>
                        <td style="border-bottom: 1px solid black;"><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp5_'.$arrOperadores[5]->getIdOperador().'" value="' . $arrOperadores[5]->getValor() . '"></td>
                        <td style="border-bottom: 1px solid black;">-</td>
                    </tr> 
                   
                     <tr>
                        <td>'.$arrOperadores[6]->getNome().'</td>
                        <td ><input type="number" class="form-control" step="any" style="text-align: center;"
                           name="txtOp6_'.$arrOperadores[6]->getIdOperador().'" value="' . $arrOperadores[6]->getValor() . '"></td>
                        <td>-</td>
                    </tr>
                     <tr>
                        <td>sonda com <strong>HEX/VIC</strong></td>
                        <td>-</td>
                        <td>-</td>
                    </tr> 
                    <tr>
                        <td>Ref. Passiva = ROX</td>
                        <td>-</td>
                        <td>-</td>
                    </tr> 
                     
                    </table>';
    }
    static function tabelaAzul_protocolo_agpath_charite(&$tabela,$objEquipamento){

        $tabela ='<table class="table table-hover  table-sm" style="text-align: center; " >
                        <tr>
                            <th  colspan="5" >AG Path / Charité</th>
                        </tr> 
                        <tr>
                            <td>Equipamento</td>
                            <td  colspan="4" style="background: rgba(255,255,0,0.2);">'.$objEquipamento->getNomeEquipamento().'</td>
                           
                        </tr> 
                        <tr>
                            <th colspan="2">Estágio</th>
                            <th>Ciclo</th>
                            <th>°C</th>
                            <th>Tempo</th>
                        </tr> 
                        <tr>
                            <th colspan="2">Transcrição reversa</th>
                            <td>1</td>
                            <td>50°C</td>
                            <td>15\'</td>
                        </tr> 
                        <tr>
                            <th colspan="2">Inativ RT/ <br>
                                                desnat inicial</th>
                            <td>1</td>
                            <td>95°C</td>
                            <td>10\'</td>
                        </tr> 
                        <tr>
                            <th colspan="2" rowspan="2" >Amplificação</th>
                            <td rowspan="2">45</td>
                            <td>95°C</td>';
        $tabela .=   "            <td>15''</td>";

        $tabela .= '   </tr> 
                        <tr>
                            <td>58°C</td>';
        $tabela .= "       <td>30 '' </td>";
        $tabela .='     </tr>          
                    </table>';

    }



}