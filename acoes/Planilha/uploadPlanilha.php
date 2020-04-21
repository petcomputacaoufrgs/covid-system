<?php echo
'<html>
  <head>
    <title>Envio de arquivo</title>
  </head>
  <body>
    <form action="upload.php" method="post" enctype="multipart/form-data">
      Selecione o arquivo: <input type="file" name="arquivo" />
      <input type="submit" value="Enviar"/>
    </form>
  </body>
</html>';