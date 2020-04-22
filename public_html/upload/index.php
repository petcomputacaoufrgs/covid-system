<?php
require "header.php";
?>
<main>
    <div class="form-box">
        <form action="../../acoes/Planilha/fileUpload.php" method="post" enctype="multipart/form-data">
            Selecione o arquivo para enviar:
            <input type="file" name="the_file" id="fileToUpload">
            <input class="btn" type="submit" name="submit" value="Enviar arquivo">
        </form>
    </div>
</main>
<?php
require "footer.php";
?>
