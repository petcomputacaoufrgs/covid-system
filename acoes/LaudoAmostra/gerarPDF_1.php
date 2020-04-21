<?php
//session_start();
require_once '../../vendor/autoload.php';
//require_once '../classes/Sessao/Sessao.php';

//$mpdf = new \Mpdf\Mpdf();

// Define a default page using all default values except "L" for Landscape orientation
//$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);

// Define a default page size/format by array - page will be 190mm wide x 236mm height
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [190, 236]]);

$html  .= 
        "
            <table>
                    <tr>
                        <td><img src=\"../../img/logoICBS.png\"  style=\"width:100px;  \" /> </td>
                        <td><h1> Laudo </h1></td>
                    </tr>
            </table>
            <table>
                <tr>
                    <td>Nº amostra: </td>
                    <td>Nº </td>
                </tr>
                <tr><td colspan=\"3\"><hr width=\"1\"  height=\"100\"></td><tr>
                        <tr><td colspan=\"2\">Nome do paciente:</td></tr>
                <tr><td colspan=\"3\"><hr width=\"1\"  height=\"100\"></td><tr>
                        <tr><td>Número interno</td></tr>
                        <tr><td>data emissão</td></tr>
            </table>";
		
$css = "
	body,html{
		color:black;
		font-size:12px;
	}
	table{
            width:100%;
		border: 1px solid red;
	}
        
        tr,td{
            border: 1px solid blue;
        }
";

$mpdf->WriteHTML($css,1);
$mpdf->WriteHTML($html);
$mpdf->Output();
?>