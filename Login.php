<?php 
require_once 'classes/Pagina/Pagina.php';

$objPagina = new Pagina();
Pagina::abrir_head("Login - Processo de tratamento de amostras para diagnóstico de COVID-19"); 
Pagina::fechar_head(); 
?>
    <main>
      <div class="form-box">
          <section class="section-default">
              <h1 id="title-login">LOGIN NO SISTEMA</h1>
              <input type="text" name="cartaoufrgs" class="txtbox" placeholder="Cartão UFRGS"><br><br>
              <input type="password" name="pwd" class="txtbox" placeholder="Senha"><br><br>
              <button type="submit" name="login-submit" class="btn">ENVIAR</button><br><br>
          </section>
        </div>
    </main>
<?php
  $objPagina->fechar_corpo();
?>