
<?php 
require_once 'classes/Pagina/Pagina.php';

$objPagina = new Pagina();
Pagina::abrir_head("Menu - Processo de tratamento de amostras para diagnóstico de COVID-19"); ?>
<link rel="stylesheet" type="text/css" href="css/style.css">
<?php Pagina::fechar_head(); ?>

<h1 id="menu">MENU</h1>
    <div class="main">
      <div class="boxes">
        <div class="box-main">
          <h1 class="box-title">CADASTRAR AMOSTRA</h1>
          <li><a href="controlador.php?action=#">Cadastrar</a></li>
          <li><a href="controlador.php?action=#">Listar</a></li>
        </div>
        <div class="box-main">
          <h1 class="box-title">ARMAZENAR AMOSTRA</h1>
          <li><a href="controlador.php?action=cadastrar_amostra_localArmazenamento">Cadastrar</a></li>
          <li><a href="controlador.php?action=#">Listar</a></li>
        </div>
        <div  class="box-main">
          <h1 class="box-title">EXTRAÇÃO DA AMOSTRA</h1>
          <li><a href="controlador.php?action=#">Cadastrar</a></li>
          <li><a href="controlador.php?action=#">Listar</a></li>
        </div>
        <div  class="box-main">
          <h1 class="box-title">RTPCR DA AMOSTRA</h1>
          <li><a href="controlador.php?action=#">Cadastrar</a></li>
          <li><a href="controlador.php?action=#">Listar</a></li>
        </div>
        <div  class="box-main">
          <h1 class="box-title">LAUDO DA AMOSTRA</h1>
          <li><a href="controlador.php?action=#">Cadastrar</a></li>
          <li><a href="controlador.php?action=#">Listar</a></li>
        </div>
      </div>
    </div>
    <h1 id="cadastramento">CADASTRAMENTO E LISTAGEM DOS DADOS</h1>
      <div class="second-boxes">
        <div class="box-second">
          <h1 class="box-title2">Tipo de amostras</h1>
          <li><a href="controlador.php?action=cadastrar_tipoAmostra">Cadastrar </a></li>
          <li><a href="controlador.php?action=listar_tipoAmostra">Listar</a></li>
        </div>  
        <div class="box-second">
          <h1 class="box-title2">Sexo pacientes</h1>
          <li><a href="controlador.php?action=cadastrar_sexoPaciente">Cadastrar</a></li>
          <li><a href="controlador.php?action=listar_sexoPaciente">Listar</a></li>
        </div>
        <div class="box-second">
          <h1 class="box-title2">Perfil do paciente</h1>
          <li><a href="controlador.php?action=cadastrar_perfilPaciente">Cadastrar</a></li>
          <li><a href="controlador.php?action=listar_perfilPaciente">Listar</a></li>
        </div>
        <div class="box-second">
          <h1 class="box-title2">Tipo Local Armazenamento</h1>
          <li><a href="controlador.php?action=cadastrar_tipoLocalArmazenamento">Cadastrar</a></li>
          <li><a href="controlador.php?action=listar_tipoLocalArmazenamento">Listar</a></li>
        </div> 
        <div class="box-second">
          <h1 class="box-title2">Perfil do usuário</h1>
          <li><a href="controlador.php?action=cadastrar_perfilUsuario">Cadastrar</a></li>
          <li><a href="controlador.php?action=listar_perfilUsuario">Listar</a></li>
        </div>
        <div class="box-second">
          <h1 class="box-title2">Doença</h1>
          <li><a href="controlador.php?action=cadastrar_doenca">Cadastrar</a></li>
          <li><a href="controlador.php?action=listar_doenca">Listar</a></li>
        </div> 
        <div class="box-second"> 
          <h1 class="box-title2">Usuário</h1>
          <li><a href="controlador.php?action=cadastrar_usuario">Cadastrar</a></li>
          <li><a href="controlador.php?action=listar_usuario">Listar</a></li>
        </div> 
        <div class="box-second"> 
          <h1 class="box-title2">Recurso</h1>
          <li><a href="controlador.php?action=cadastrar_recurso">Cadastrar</a></li>
          <li><a href="controlador.php?action=listar_recurso">Listar</a></li>
        </div> 
        <div class="box-second"> 
          <h1 class="box-title2">Equipamento</h1>
          <li><a href="controlador.php?action=cadastrar_equipamento">Cadastrar</a></li>
          <li><a href="controlador.php?action=listar_equipamento">Listar</a></li>
        </div> 
        <div class="box-second"> 
          <h1 class="box-title2">Detentor</h1>
          <li><a href="controlador.php?action=cadastrar_detentor">Cadastrar</a></li>
          <li><a href="controlador.php?action=listar_detentor">Listar</a></li>
        </div> 
        <div class="box-second"> 
          <h1 class="box-title2">Marca</h1>
          <li><a href="controlador.php?action=cadastrar_marca">Cadastrar</a></li>
          <li><a href="controlador.php?action=listar_marca">Listar</a></li>
        </div> 
        <div class="box-second"> 
          <h1 class="box-title2">Modelo</h1>
          <li><a href="controlador.php?action=cadastrar_modelo">Cadastrar</a></li>
          <li><a href="controlador.php?action=listar_modelo">Listar</a></li>
        </div> 
        <div class="box-second"> 
          <h1 class="box-title2">Permanência</h1>
          <li><a href="controlador.php?action=cadastrar_tempoPermanencia">Cadastrar</a></li>
          <li><a href="controlador.php?action=listar_tempoPermanencia">Listar</a></li>
        </div>    
        <div class="box-second"> 
          <h1 class="box-title2">Local Armazenamento</h1>
          <li><a href="controlador.php?action=cadastrar_localArmazenamento">Cadastrar</a></li>
          <li><a href="controlador.php?action=listar_localArmazenamento">Listar</a></li>
        </div>
        <div class="box-second"> 
          <h1 class="box-title2">Paciente</h1>
          <li><a href="controlador.php?action=cadastrar_paciente">Cadastrar</a></li>
          <li><a href="controlador.php?action=listar_paciente">Listar</a></li>
        </div>
        <div class="box-second"> 
          <h1 class="box-title2">Amostra</h1>
          <li><a href="controlador.php?action=cadastrar_amostra">Cadastrar</a></li>
          <li><a href="controlador.php?action=listar_amostra">Listar</a></li>
        </div>
    </div>
  </main>
  
     <?php
    $objPagina->fechar_corpo();
    
    ?>