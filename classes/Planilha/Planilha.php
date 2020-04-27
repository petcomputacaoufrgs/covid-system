<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../ResultadoPCR/ResultadoPCR.php';
require_once __DIR__ . '/../ResultadoPCR/ResultadoPCR_RN.php';

use \PhpOffice\PhpSpreadsheet\Reader\Xls;

class Planilha {
    
    public function leituraXLS($filename) {

        $reader = new Xls();
        $reader->setReadDataOnly(true);
        $reader->setLoadSheetsOnly(["Results"]);
        $spreadsheet = $reader->load("../../planilhas/" . $filename);
    
        $resultadoRN = new ResultadoPCR_RN();
    
        $linha = 9;
        while ($spreadsheet->getActiveSheet()->getCellByColumnAndRow(1,$linha)->getValue() != null) {
            
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
            $resultadoRN->printObjeto($objetoResultado);
            echo "\n";
    
            $linha++;
        }
    }
}

//debug propouse only
//leituraXLS("tabela.xls");