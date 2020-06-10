<?php
/*
    JORDI E RICARDO
*/

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../ResultadoPCR/ResultadoPCR.php';
require_once __DIR__ . '/../ResultadoPCR/ResultadoPCR_RN.php';

use \PhpOffice\PhpSpreadsheet\Reader;




class Planilha {

    public function leituraXLS($fileName) {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("../../planilhas/" . $fileName);
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify("../../planilhas/" . $fileName);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        $reader->setLoadSheetsOnly(["Results"]);

        $resultadoRN = new ResultadoPCR_RN();

        $linha = 9;
        $pdf = new FPDF();
        $pdf->AliasNbPages();

        while ($spreadsheet->getActiveSheet()->getCellByColumnAndRow(1,$linha)->getValue() != null) {
            $pdf->AddPage();
            $pdf->SetFont("Times", "", 12);
            //registra valores nas respectivas variaveis
            $well = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(1,$linha)->getValue();

            $sampleName = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(2,$linha)->getValue();

            $targetName = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(3,$linha)->getValue();

            $task = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(4,$linha)->getValue();

            $reporter = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(5,$linha)->getValue();
            $ct = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(7,$linha)->getValue();

            //cria tupla de valores
            $valores = [$well, $sampleName, $targetName, $task, $reporter, $ct];

            //Cria o objeto para armazenar o resultado de APENAS UMA amostra
            $objetoResultado = new ResultadoPCR();

            $resultadoRN->configuraObjeto($objetoResultado, $valores);

            //debug propouse Only
            //Ao inves de print objeto, salva no  Banco de Dados


            $resultadoRN->printObjeto($objetoResultado, $pdf);

            echo "\n";

            $linha++;
        }
        $pdf->Output();
    }
}

//debug propouse only
//leituraXLS("tabela.xls");