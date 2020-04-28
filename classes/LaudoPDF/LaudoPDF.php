<?php
require_once __DIR__ . '/../../vendor/fpdf/fpdf.php';
date_default_timezone_set("America/Sao_Paulo");
$data = date("d/m/Y", time());

$nome = 'João Paulo Assis';
$sexo = 'M';
$nascimento = '23/04/1992';
$tipoDocumento = "RG";
$documento = '12.345.678-9';
$nomeMae = 'Maria de Assis';
$codigoGAL = NULL;
$dataAmostra = '23/04/2020';
$status = 'Inconclusivo';
$observacoes = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullafacilisis ligula sit amet risus elementum ullamcorper. Maecenas eget ipsum nec auguemattis interdum at et nisi. Nulla sed lorem vel.';
$teste = 'RTPCR';
$virus = 'COVID-19';

if ($codigoGAL == NULL)
    $codigoGAL = 'Não se aplica';


class PDF extends FPDF
{
// Page header
    function Header()
    {
        // Logo
        $this->Image('logoUFRGS.png', 10, 6, 30);
        // Arial bold 15
        $this->SetFont('FreeSerif', 'B', 23);
        // Move to the right
        //$this->Cell(30);
        // Title
        $this->Cell(0, 25, 'Laudo de Teste', 0, 0, 'C');
        $this->Image('logoICBS.png', 170, 13, 30);
        // Line break
        $this->Ln(30);
    }

// Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('FreeSerif', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Universidade Federal do Rio Grande do Sul, Porto Alegre - RS  ' . date("d/m/Y", time()), 0, 0, 'C');
    }
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AddFont('FreeSerif', '', 'FreeSerif.php');
$pdf->AddFont('FreeSerif', 'B', 'FreeSerifBold.php');
$pdf->AddFont('FreeSerif', 'I', 'FreeSerifItalic.php');

$pdf->AliasNbPages();
$pdf->AddPage();




$pdf->Cell(25);
$pdf->SetFont('FreeSerif', 'B', 12);
$pdf->Cell(26, 8, 'Tipo de teste: ', 0, 0);
$pdf->SetFont('FreeSerif', '', 12);
$pdf->Cell(10, 8, $teste, 0, 0);

$pdf->SetFont('FreeSerif', 'B', 12);
$pdf->Cell(90, 8, 'Vírus: ', 0, 0, 'R');
$pdf->SetFont('FreeSerif', '', 12);
$pdf->Cell(0, 8, $virus, 0, 1, 'L');

$pdf->SetFont('FreeSerif', '', 12);
$pdf->Cell(0, 8,'', 'T', 1);

$pdf->Cell(25);
$pdf->SetFont('FreeSerif', 'B', 12);
$pdf->Cell(13, 8, 'Nome: ', 0, 0);
$pdf->SetFont('FreeSerif', '', 12);
$pdf->Cell(0, 8, $nome, 0, 1);

$pdf->Cell(25);
$pdf->SetFont('FreeSerif', 'B', 12);
$pdf->Cell(12, 8, 'Sexo: ', 0, 0);
$pdf->SetFont('FreeSerif', '', 12);
$pdf->Cell(0, 8, $sexo, 0, 1);

$pdf->Cell(25);
$pdf->SetFont('FreeSerif', 'B', 12);
$pdf->Cell(37, 8, 'Data de nascimento: ', 0, 0);
$pdf->SetFont('FreeSerif', '', 12);
$pdf->Cell(0, 8, $nascimento, 0, 1);

$pdf->Cell(25);
$pdf->SetFont('FreeSerif', 'B', 12);
$pdf->Cell(23, 8, 'Documento: ', 0, 0);
$pdf->SetFont('FreeSerif', '', 12);
$pdf->Cell(0, 8, $tipoDocumento . ' - ' . $documento, 0, 1);

$pdf->Cell(25);
$pdf->SetFont('FreeSerif', 'B', 12);
$pdf->Cell(27, 8, 'Nome da Mãe: ', 0, 0);
$pdf->SetFont('FreeSerif', '', 12);
$pdf->Cell(0, 8, $nomeMae, 0, 1);


$pdf->Cell(0, 8, '', 0, 1);

$pdf->Cell(25);
$pdf->SetFont('FreeSerif', 'B', 12);
$pdf->Cell(26, 8, 'Código GAL: ', 0, 0);
$pdf->SetFont('FreeSerif', '', 12);
$pdf->Cell(0, 8, $codigoGAL, 0, 1);

$pdf->Cell(25);
$pdf->SetFont('FreeSerif', 'B', 12);
$pdf->Cell(32 ,8, 'Data da amostra: ' , 0, 0);
$pdf->SetFont('FreeSerif', '', 12);
$pdf->Cell(0, 8, $dataAmostra, 0, 1);

$pdf->Cell(25);
$pdf->SetFont('FreeSerif', 'B', 12);
$pdf->Cell(14, 8, 'Status: ' , 0, 0);
$pdf->SetFont('FreeSerif', '', 12);
$pdf->Cell(0, 8, $status, 0, 1);

$pdf->Cell(25);
$pdf->SetFont('FreeSerif', 'B', 12);
$pdf->Cell(26, 8, 'Observações: ' , 0, 0);
$pdf->SetFont('FreeSerif', '', 12);
$pdf->MultiCell(0, 8, $observacoes, 0, "L");


$pdf->Output('I', $nome . date("d_m_Y", time()) . '.pdf', true);
?>