<?php 
session_start();

require_once __DIR__.'/../classes/Pagina/Pagina.php';
require_once __DIR__.'/../classes/Sessao/Sessao.php';

try {
//Sessao::getInstance()->logar('00274715','12345678');
    if (isset($_POST['login-submit'], $_POST['cartaoufrgs'], $_POST['pwd'])) {
        Sessao::getInstance()->logar($_POST['cartaoufrgs'], $_POST['pwd']);
    }
}catch (Throwable $e){
    die($e);
}

session_destroy();

    Pagina::abrir_head("Login - Processo de tratamento de amostras para diagnóstico de COVID-19");
    Pagina::getInstance()->adicionar_css("style");
    //Pagina::getInstance()->adicionar_javascript();

    ?>


    <img src="img/header.png" class="HeaderImg">
    </head>
    <BODY>


    <main>
      <div class="form-box" style="margin-top: 10px;">
          <section class="section-default">
              <form method="POST">
              <h1 id="title-login">LOGIN NO SISTEMA</h1>
              <input type="text" name="cartaoufrgs" id="idMatricula" class="txtbox" placeholder="Cartão UFRGS ou CPF"><br><br>
              <input type="password" name="pwd" class="txtbox" placeholder="Senha"><br><br>
              <button type="submit" name="login-submit" class="btn">ENVIAR</button><br><br>
              </form>
          </section>
        </div>
    </main>

<?php
    Pagina::getInstance()->mostrar_excecoes();
    Pagina::getInstance()->fechar_corpo();
