<?php

require_once '../vendor/autoload.php';
require_once '../classes/Sessao/Sessao.php';

require_once '../classes/Amostra/Amostra.php';
require_once '../classes/Amostra/AmostraRN.php';

require_once '../classes/Usuario/Usuario.php';
require_once '../classes/Usuario/UsuarioRN.php';

require_once '../classes/CadastroAmostra/CadastroAmostra.php';
require_once '../classes/CadastroAmostra/CadastroAmostraRN.php';

require_once '../classes/PerfilPaciente/PerfilPaciente.php';
require_once '../classes/PerfilPaciente/PerfilPacienteRN.php';

class PDF_Estatisticas {

    public static function pdf_estatisticas_gerais($dt) {
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [190, 236]]);
        
        $DATA = $dt;
      
        $objCadastroAmostra = new CadastroAmostra();
        $objCadastroAmostraRN = new CadastroAmostraRN();

        $objUsuario = NEW Usuario();
        $objUsuarioRN = NEW UsuarioRN();

        /* PERFIL PACIENTE */
        $objPerfilPaciente = new PerfilPaciente();
        $objPerfilPacienteRN = new PerfilPacienteRN();

        $arr_amostras = $objCadastroAmostraRN->consultarData($objCadastroAmostra, $DATA);
        if ($arr_amostras != null && !empty($arr_amostras)) {
            $objAmostra = new Amostra();
            $objAmostraRN = new AmostraRN();

            $html = "   
            <table>
                           
                    <tr>
                        <td><img src=\"../public_html/img/logoICBS.png\"  style=\"width:100px;  \" /> </td>
                        <td><h1> ESTATÍSTICAS DO DIA " . $DATA . " </h1></td>
                    </tr>
            </table>";
       
            $html .= " <table> 
              <tr><td></td></tr>
              <tr>
                   <td>Quantidade de amostras cadastradas: " . count($arr_amostras) . "</td>
              </tr>
               <tr><td><hr width=\"1\"  height=\"100\"></td></tr>";
            $qntAmostra = 1;
            foreach ($arr_amostras as $a) {

                $objAmostra->setIdAmostra($a->getIdAmostra_fk());
                $objAmostra = $objAmostraRN->consultar($objAmostra);

                $result = '';
                if ($objAmostra->get_a_r_g() == 'r') {
                    $result = 'Recusada';
                    $style = ' style="background-color:rgba(255, 0, 0, 0.2);" ';
                } else if ($objAmostra->get_a_r_g() == 'a') {
                    $result = 'Aceita';
                    $style = ' style="background-color:rgba(0, 255, 0, 0.2);" ';
                } else if ($objAmostra->get_a_r_g() == 'g') {
                    $result = 'Aguardando chegada';
                    $style = ' style="background-color:rgba(255, 255, 0, 0.2);" ';
                }

                $objUsuario->setIdUsuario($a->getIdUsuario_fk());
                $objUsuario = $objUsuarioRN->consultar($objUsuario);

                $objPerfilPaciente->setIdPerfilPaciente($objAmostra->getIdPerfilPaciente_fk());
                $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);


                $html .= "<tr> <td style=\"background-color: #ddd;\">Amostra  " . $qntAmostra . " do dia</td></tr>"
                        . "<tr> <td>Código amostra: " . $objAmostra->getCodigoAmostra() . "</td></tr>" .
                        "<tr><td" . $style . "> Situação da amostra: " . $result . "</td></tr>" .
                        "<tr><td> Perfil da amostra: " . $objPerfilPaciente->getPerfil() . "</td></tr>" .
                        "<tr><td> Amostra cadastrada pelo usuário: " . $objUsuario->getMatricula() . "</td></tr>" .
                        "<tr><td><hr width=\"1\"  height=\"100\"></td></tr>";

                $qntAmostra++;
            }
            $html .= " </table>";



            $css = "
	body,html{
		color:black;
		font-size:12px;
	}
	table{
            width:100%;
            /*border: 1px solid red;*/
	}
        
        tr,td{
            /*border: 1px solid blue;*/
        }
";

            $DATAAUX = explode("/", $DATA);

            $dia = $DATAAUX[0];
            $mes = $DATAAUX[1];
            $ano = $DATAAUX[2];

            $output = 'estatisticas_gerais_' . $dia . '_' . $mes . '_' . $ano;

            $mpdf->WriteHTML($css, 1);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
            //$mpdf->Output($output . '.pdf', I);
        
        } else {
            return null;
        }
    }

}
