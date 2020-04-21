<?php


//Pasta na qual os arquivos vão ser salvos
$dir = '../../planilhas';

//Seleciona o arquivo que foi feito upload
$file = $_FILES["arquivo"];


//Escreve o nome do arquivo
$file_name = date('dMyHi');

//Tenta salvar o arquivo na pasta, aqui escolhe o nome do arquivo
if (move_uploaded_file($file["tmp_name"], "$dir/".$file["name"])) { 
    echo "Arquivo enviado com sucesso!"; 
}

else { 
    echo "Erro, o arquivo n&atilde;o pode ser enviado."; 
} 

?>