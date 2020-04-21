<?php
$currentDirectory = getcwd();
$uploadDirectory = '../../../planilhas/';;

date_default_timezone_set("America/Sao_Paulo");

$errors = []; // Store errors here

$fileExtensionsAllowed = ['xls']; // These will be the only file extensions allowed

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
            echo "The file " . basename($fileName) . " has been uploaded";
        } else {
            echo "An error occurred. Please contact the administrator.";
        }
    } else {
        foreach ($errors as $error) {
            echo $error . "These are the errors" . "\n";
        }
    }

}
?>