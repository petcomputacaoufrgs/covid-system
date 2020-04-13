<?php 
session_start();
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Sessao/Sessao.php';

//Sessao::getInstance()->logar('00274715','12345678');
    if(isset($_POST['login-submit'])){
        Sessao::getInstance()->logar($_POST['cartaoufrgs'],$_POST['pwd']);
    }
    
    session_destroy();
?>

<?php

    Pagina::abrir_head("Login - Processo de tratamento de amostras para diagnóstico de COVID-19");
    Pagina::getInstance()->adicionar_css("style");
    //Pagina::getInstance()->adicionar_javascript();
    Pagina::getInstance()->fechar_head();
    Pagina::getInstance()->montar_menu_topo();
?>

    <main>
      <div class="form-box">
          <section class="section-default">
              <form method="POST">
              <h1 id="title-login">LOGIN NO SISTEMA</h1>
              <input type="text" name="cartaoufrgs" id="idMatricula" class="txtbox" placeholder="Cartão UFRGS"><br><br>
              <input type="password" name="pwd" class="txtbox" placeholder="Senha"><br><br>
              <button type="submit" name="login-submit" class="btn">ENVIAR</button><br><br>
              </form>
          </section>
        </div>
    </main>

<?php
    Pagina::getInstance()->mostrar_excecoes();
    Pagina::getInstance()->fechar_corpo();