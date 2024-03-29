<?php
/*
    JORDI E RICARDO
*/
require_once __DIR__ ."/../../classes/Planilha/Planilha.php";
require_once __DIR__ . '/../../vendor/fpdf/fpdf.php';

function uploadFile() {
    $currentDirectory = getcwd();
    $uploadDirectory = '../../../planilhas/';

    date_default_timezone_set("America/Sao_Paulo");

    $errors = []; // Store errors here

    $fileExtensionsAllowed = ['xls' , 'xlsx']; // These will be the only file extensions allowed

    $fileName = $_FILES['the_file']['name'];
    $fileSize = $_FILES['the_file']['size'];
    $fileTmpName  = $_FILES['the_file']['tmp_name'];
    $fileType = $_FILES['the_file']['type'];
    $array = explode('.', $fileName);
    $fileExtension = strtolower(end($array));
    $newFileName = date("Ymd_Hi", time());

    $uploadPath = $currentDirectory . $uploadDirectory . basename($newFileName) . '.' . $fileExtension;

    if (isset($_POST['submit'])) {

        if (! in_array($fileExtension,$fileExtensionsAllowed)) {
            $errors[] = "Arquivo não suportado, favor fazer upload de um arquivo *.xls";
        }

        if ($fileSize > 8000000) {
            $errors[] = "Arquivo muito grande, fazer upload de um arquivo de até 8MB.";
        }

        if (empty($errors)) {
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

            if ($didUpload) {
                //echo "<h3>O arquivo " . basename($fileName) . " foi enviado com sucesso </h3>";
                return $newFileName . '.' . $fileExtension;
            } else {
                echo "Houve um erro, por favor tente novamente ou contate o administrador.";
                return -1;
            }
        } else {
            foreach ($errors as $error) {
                echo $error . "Esses são os erros:" . "\n";
                return count($errors);
            }
        }

    }
}
$result = uploadFile();
if(!is_int($result)) {
    //Le o arquivo .xls usando a função leituraXLS();
    $leitor = new Planilha();
    $leitor->leituraXLS($result);
}
